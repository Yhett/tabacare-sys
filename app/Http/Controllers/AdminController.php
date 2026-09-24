<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    private const BARANGAYS = [
        'Agnas', 'Bacolod', 'Bangkilingan', 'Bantayan', 'Baranghawon', 'Basagan', 'Basud', 'Bognabong', 'Bombon', 'Bonot',
        'Buang', 'Buhian', 'Cabagnan', 'Cobo', 'Comon', 'Cormidal', 'Divino Rostro', 'Fatima', 'Guinobat', 'Hacienda',
        'Magapo', 'Mariroc', 'Matagbac', 'Oras', 'Oson', 'Panal', 'Pawa', 'Pinagbobong', 'Quinale Cabasan', 'Quinastillojan',
        'Rawis', 'Sagurong', 'Salvacion', 'San Antonio', 'San Carlos', 'San Isidro', 'San Juan', 'San Lorenzo', 'San Ramon', 'San Roque',
        'San Vicente', 'Santo Cristo', 'Sua-Igot', 'Tabiguian', 'Tagas', 'Tayhi', 'Visita',
    ];

    private const DISEASES = ['Influenza', 'Measles', 'Common Cold', 'Chickenpox', 'Hand, Foot, and Mouth Disease'];
    private const OUTBREAK_THRESHOLD = 50;

    public function dashboard(Request $request): View
    {
        abort_unless($request->session()->get('role') === 'admin', 403);

        $admin = User::find($request->session()->get('id'));
        $admin?->forceFill(['last_active' => now()])->save();

        return view('admin.dashboard', [
            'adminName' => $request->session()->get('user', 'Administrator'),
            'totalPatients' => Patient::count(),
            'totalWorkers' => User::where('role', 'health_worker')->count(),
            'recentCount' => Patient::where('created_at', '>=', now()->subDays(7))->count(),
            'barangayCount' => User::where('role', 'health_worker')->whereNotNull('barangay')->distinct('barangay')->count('barangay'),
            'recentWorkers' => User::where('role', 'health_worker')->latest('last_active')->limit(5)->get(['username', 'barangay', 'last_active']),
        ]);
    }

    public function patients(Request $request): View
    {
        $this->ensureAdmin($request);
        $filterDisease = trim((string) $request->query('filter_disease', ''));

        $patients = Patient::query()
            ->with('addedBy:id,username')
            ->whereHas('addedBy', fn ($query) => $query->where('role', 'admin'))
            ->when(in_array($filterDisease, self::DISEASES, true), fn ($query) => $query->where('disease', $filterDisease))
            ->latest('id')
            ->paginate(50)
            ->withQueryString();

        return view('admin.patients', [
            'adminName' => $request->session()->get('user', 'Administrator'),
            'patients' => $patients,
            'filterDisease' => $filterDisease,
            'diseases' => self::DISEASES,
            'barangays' => self::BARANGAYS,
        ]);
    }

    public function accounts(Request $request): View
    {
        $this->ensureAdmin($request);
        $workers = User::where('role', 'health_worker')->orderBy('barangay')->orderBy('username')->get();
        $barangayWorkers = collect(self::BARANGAYS)->mapWithKeys(fn ($barangay) => [
            $barangay => $workers->where('barangay', $barangay),
        ]);

        return view('admin.accounts', [
            'adminName' => $request->session()->get('user', 'Administrator'),
            'barangays' => self::BARANGAYS,
            'workers' => $workers,
            'barangayWorkers' => $barangayWorkers,
        ]);
    }

    public function adminAccounts(Request $request): View
    {
        $this->ensureAdmin($request);

        return view('admin.admin_accounts', [
            'adminName' => $request->session()->get('user', 'Administrator'),
            'admins' => User::where('role', 'admin')->orderBy('username')->get(),
        ]);
    }

    public function storeAdminAccount(Request $request): RedirectResponse
    {
        $this->ensureAdmin($request);
        $data = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'username' => $data['username'],
            'name' => $data['username'],
            'email' => $data['username'] . '@tabacare.local',
            'password' => Hash::make($data['password']),
            'role' => 'admin',
            'barangay' => null,
            'created_by' => $request->session()->get('id'),
        ]);

        return to_route('admin.admin-accounts.index')->with('success', 'Administrator account created successfully.');
    }

    public function updateAdminAccount(Request $request, User $user): RedirectResponse
    {
        $this->ensureAdmin($request);
        abort_unless($user->role === 'admin', 404);

        $data = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user->username = $data['username'];
        $user->name = $data['username'];
        $user->email = $data['username'] . '@tabacare.local';
        if (filled($data['password'] ?? null)) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        if ((int) $request->session()->get('id') === (int) $user->id) {
            $request->session()->put('user', $user->username);
        }

        return to_route('admin.admin-accounts.index')->with('success', 'Administrator account updated successfully.');
    }

    public function statistics(Request $request): View
    {
        $this->ensureAdmin($request);
        $filter = (string) $request->query('barangay_disease', '');
        if (! in_array($filter, self::DISEASES, true)) {
            $filter = '';
        }

        $diseaseCounts = collect(self::DISEASES)->mapWithKeys(fn ($disease) => [
            $disease => Patient::where('disease', $disease)->count(),
        ]);
        $monthlyCases = Patient::query()
            ->whereBetween('date_onset', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])
            ->selectRaw('disease, COUNT(*) as total')
            ->groupBy('disease')
            ->pluck('total', 'disease');
        $outbreakAlerts = $monthlyCases->filter(fn ($total) => $total >= self::OUTBREAK_THRESHOLD);
        $barangayCounts = Patient::query()
            ->when($filter !== '', fn ($query) => $query->where('disease', $filter))
            ->selectRaw('address, COUNT(*) as total')
            ->groupBy('address')
            ->pluck('total', 'address');

        $trendLabels = [];
        $trendValues = [];
        for ($monthsAgo = 5; $monthsAgo >= 0; $monthsAgo--) {
            $month = now()->subMonths($monthsAgo);
            $trendLabels[] = $month->format('M Y');
            $trendValues[] = Patient::query()
                ->whereBetween('date_onset', [$month->copy()->startOfMonth()->toDateString(), $month->copy()->endOfMonth()->toDateString()])
                ->count();
        }

        $currentMonth = now()->startOfMonth();
        $previousMonth = now()->subMonth()->startOfMonth();
        $currentMonthTotal = Patient::whereBetween('date_onset', [$currentMonth->toDateString(), $currentMonth->copy()->endOfMonth()->toDateString()])->count();
        $previousMonthTotal = Patient::whereBetween('date_onset', [$previousMonth->toDateString(), $previousMonth->copy()->endOfMonth()->toDateString()])->count();
        $monthChange = $previousMonthTotal === 0
            ? ($currentMonthTotal > 0 ? 100 : 0)
            : round((($currentMonthTotal - $previousMonthTotal) / $previousMonthTotal) * 100);
        $topBarangays = $barangayCounts->sortDesc()->take(5);
        $barangayChartData = collect(self::BARANGAYS)
            ->mapWithKeys(fn ($barangay) => [$barangay => (int) ($barangayCounts[$barangay] ?? 0)])
            ->sortDesc();

        return view('admin.statistics', [
            'adminName' => $request->session()->get('user', 'Administrator'),
            'barangays' => self::BARANGAYS,
            'diseases' => self::DISEASES,
            'filter' => $filter,
            'diseaseCounts' => $diseaseCounts,
            'monthlyCases' => $monthlyCases,
            'monthlyTotal' => $monthlyCases->sum(),
            'outbreakAlerts' => $outbreakAlerts,
            'outbreakThreshold' => self::OUTBREAK_THRESHOLD,
            'totalPatients' => Patient::count(),
            'barangayCounts' => $barangayCounts,
            'trendLabels' => $trendLabels,
            'trendValues' => $trendValues,
            'monthChange' => $monthChange,
            'previousMonthTotal' => $previousMonthTotal,
            'topBarangays' => $topBarangays,
            'barangayChartData' => $barangayChartData,
            'monthLabel' => now()->format('F Y'),
        ]);
    }

    public function reports(Request $request): View
    {
        $this->ensureAdmin($request);
        $reports = Report::query()->latest('id')->paginate(20);

        return view('admin.reports', [
            'adminName' => $request->session()->get('user', 'Administrator'),
            'reports' => $reports,
            'totalCases' => Report::sum('patient_count'),
            'barangayCount' => Report::query()->distinct('barangay')->count('barangay'),
        ]);
    }

    public function downloadAttachment(Request $request, Report $report): BinaryFileResponse
    {
        $this->ensureAdmin($request);
        abort_if(blank($report->attachment_path) || ! Storage::disk('local')->exists($report->attachment_path), 404);

        return response()->download(
            Storage::disk('local')->path($report->attachment_path),
            basename($report->attachment_name ?: $report->attachment_path),
            ['X-Content-Type-Options' => 'nosniff']
        );
    }

    public function downloadReport(Request $request, Report $report): Response
    {
        $this->ensureAdmin($request);
        $diseases = is_array($report->diseases) ? $report->diseases : [];
        $reportStart = $report->report_period?->copy()->startOfMonth() ?? now()->startOfMonth();
        $isAnnual = $report->report_frequency === 'annual';
        $reportEnd = $isAnnual ? $reportStart->copy()->endOfYear() : $reportStart->copy()->endOfMonth();
        $rows = Patient::query()
            ->where('address', $report->barangay)
            ->whereIn('disease', $diseases)
            ->whereBetween('date_onset', [$reportStart->toDateString(), $reportEnd->toDateString()])
            ->orderBy('disease')
            ->latest('date_onset')
            ->get();
        $reportRows = app(ReportController::class)->summarizeRows($rows);
        $periodType = $isAnnual ? 'annual' : 'monthly';
        $periodLabel = $isAnnual ? 'Annual ' . $reportStart->format('Y') : $reportStart->format('F Y');
        $title = 'Disease Report - ' . $periodLabel . ' - ' . $report->barangay;
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $title) . '.xls';

        return response("\xEF\xBB\xBF" . view('reports.excel', [
            'reportRows' => $reportRows,
            'barangay' => $report->barangay,
            'selected' => $diseases,
            'title' => $title,
            'data' => ['prepared_by' => $report->prepared_by ?: $report->worker?->username],
            'periodType' => $periodType,
            'reportStart' => $reportStart,
            'reportEnd' => $reportEnd,
        ])->render(), 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache',
        ]);
    }

    public function storeAccount(Request $request): RedirectResponse
    {
        $this->ensureAdmin($request);
        $data = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8'],
            'barangay' => ['required', Rule::in(self::BARANGAYS), Rule::unique('users', 'barangay')->where(fn ($query) => $query->where('role', 'health_worker'))],
        ]);
        User::create([
            'username' => $data['username'],
            'name' => $data['username'],
            'email' => $data['username'] . '@tabacare.local',
            'password' => Hash::make($data['password']),
            'role' => 'health_worker',
            'barangay' => $data['barangay'],
            'created_by' => $request->session()->get('id'),
        ]);

        return to_route('admin.accounts')->with('success', "Health-worker account created for {$data['barangay']}.");
    }

    public function destroyAccount(Request $request, User $user): RedirectResponse
    {
        $this->ensureAdmin($request);
        abort_unless($user->role === 'health_worker', 404);
        $username = $user->username;
        $user->delete();

        return to_route('admin.accounts')->with('success', "Health-worker account \"{$username}\" was deleted.");
    }

    public function updateAccount(Request $request, User $user): RedirectResponse
    {
        $this->ensureAdmin($request);
        abort_unless($user->role === 'health_worker', 404);

        $data = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'barangay' => ['required', Rule::in(self::BARANGAYS), Rule::unique('users', 'barangay')->where(fn ($query) => $query->where('role', 'health_worker'))->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user->username = $data['username'];
        $user->name = $data['username'];
        $user->email = $data['username'] . '@tabacare.local';
        $user->barangay = $data['barangay'];
        if (filled($data['password'] ?? null)) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return to_route('admin.accounts')->with('success', "Barangay account for {$data['barangay']} was updated.");
    }

    public function storePatient(Request $request): RedirectResponse
    {
        $this->ensureAdmin($request);
        $data = $request->validate([
            'patient_code' => ['required', 'string', 'max:255', 'unique:patients,patient_code'],
            'disease' => ['required', Rule::in(self::DISEASES)],
            'date_onset' => ['required', 'date'],
            'address' => ['required', Rule::in(self::BARANGAYS)],
            'age' => ['required', 'integer', 'between:0,150'],
            'age_unit' => ['required', Rule::in(['days', 'months', 'years'])],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
        ]);
        $data['added_by'] = $request->session()->get('id');
        Patient::create($data);

        return to_route('admin.patients')->with('success', 'Patient added to the health-center list.');
    }

    private function ensureAdmin(Request $request): void
    {
        abort_unless($request->session()->get('role') === 'admin', 403);
    }
}
