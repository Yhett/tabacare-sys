<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private const DISEASES = [
        ['name' => 'Influenza', 'color' => ''],
        ['name' => 'Common Cold', 'color' => 'coral'],
        ['name' => 'Measles', 'color' => 'gold'],
        ['name' => 'Chickenpox', 'color' => 'blue'],
        ['name' => 'Hand, Foot, and Mouth Disease', 'color' => 'plum'],
    ];

    public function index(Request $request): View
    {
        abort_unless($request->session()->get('role') === 'health_worker', 403);

        $barangay = trim((string) $request->session()->get('barangay', ''));
        abort_if($barangay === '', 403);

        $baseQuery = Patient::query()->where('address', $barangay);
        $diseaseTotals = $baseQuery->clone()
            ->selectRaw('disease, COUNT(*) as total')
            ->groupBy('disease')
            ->pluck('total', 'disease');
        $totalPatients = $baseQuery->count();
        $thisMonth = $baseQuery->clone()
            ->whereBetween('date_onset', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])
            ->count();
        $lastSevenDays = $baseQuery->clone()
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        $recentPatients = $baseQuery->clone()
            ->latest('date_onset')
            ->latest('id')
            ->limit(5)
            ->get(['id', 'patient_code', 'disease', 'date_onset', 'created_at']);

        $diseases = collect(self::DISEASES)->map(function (array $disease) use ($diseaseTotals): array {
            return $disease + ['count' => (int) ($diseaseTotals[$disease['name']] ?? 0)];
        });
        $maxDiseaseCount = max(1, (int) $diseases->max('count'));

        return view('dashboard', [
            'worker' => $request->session()->get('user', 'Health Worker'),
            'barangay' => $barangay,
            'diseases' => $diseases,
            'totalPatients' => $totalPatients,
            'thisMonth' => $thisMonth,
            'lastSevenDays' => $lastSevenDays,
            'diseaseTypes' => $diseaseTotals->filter(fn ($total) => $total > 0)->count(),
            'maxDiseaseCount' => $maxDiseaseCount,
            'recentPatients' => $recentPatients,
        ]);
    }
}
