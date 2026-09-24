<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ReportController extends Controller
{
    private const DISEASES = ['Influenza', 'Measles', 'Common Cold', 'Chickenpox', 'Hand, Foot, and Mouth Disease'];

    private const ICD_CODES = [
        'Influenza' => 'J11.1',
        'Measles' => 'B05.9',
        'Common Cold' => 'J00',
        'Chickenpox' => 'B01.9',
        'Hand, Foot, and Mouth Disease' => 'B08.4',
    ];

    private const AGE_BANDS = [
        '0-6 days',
        '7-28 days',
        '29 days to 11 months',
        '1-4 years old',
        '5-9 years old',
        '10-14 years old',
        '15-19 years old',
        '20-24 years old',
        '25-29 years old',
        '30-34 years old',
        '35-39 years old',
        '40-44 years old',
        '45-49 years old',
        '50-54 years old',
        '55-59 years old',
        '60 and above',
    ];

    public function index(Request $request): View
    {
        $barangay = $this->workerBarangay($request);
        $selected = self::DISEASES;
        $month = filter_var($request->input('month', now()->month), FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 12]]) ?: now()->month;
        $periodType = $request->input('period_type', 'monthly') === 'annual' ? 'annual' : 'monthly';
        [$reportStart, $reportEnd] = $this->periodBounds($periodType, $month);
        $preparedBy = trim((string) $request->input('prepared_by', ''));
        $reportData = $request->boolean('generated') ? $this->patientsFor($barangay, $selected, $reportStart, $reportEnd) : collect();

        return view('reports.create', [
            'barangay' => $barangay,
            'workerName' => $request->session()->get('user', 'Health Worker'),
            'diseases' => self::DISEASES,
            'selectedDiseases' => $selected,
            'month' => $month,
            'periodType' => $periodType,
            'months' => $this->monthOptions(),
            'reportStart' => $reportStart,
            'reportEnd' => $reportEnd,
            'preparedBy' => $preparedBy,
            'reportData' => $reportData,
            'reportRows' => $this->summarizeRows($reportData),
            'generated' => $request->boolean('generated'),
        ]);
    }

    public function generate(Request $request): View
    {
        $data = $request->validate([
            'prepared_by' => ['required', 'string', 'max:150'],
            'period_type' => ['required', 'in:monthly,annual'],
            'month' => ['required_if:period_type,monthly', 'nullable', 'integer', 'between:1,12'],
        ]);

        $barangay = $this->workerBarangay($request);
        $selected = self::DISEASES;
        $month = (int) ($data['month'] ?? 1);
        $periodType = $data['period_type'];
        [$reportStart, $reportEnd] = $this->periodBounds($periodType, $month);
        $reportData = $this->patientsFor($barangay, $selected, $reportStart, $reportEnd);

        return view('reports.create', [
            'barangay' => $barangay,
            'workerName' => $request->session()->get('user', 'Health Worker'),
            'diseases' => self::DISEASES,
            'selectedDiseases' => $selected,
            'month' => $month,
            'periodType' => $periodType,
            'months' => $this->monthOptions(),
            'reportStart' => $reportStart,
            'reportEnd' => $reportEnd,
            'preparedBy' => $data['prepared_by'],
            'reportData' => $reportData,
            'reportRows' => $this->summarizeRows($reportData),
            'generated' => true,
        ]);
    }

    public function download(Request $request): Response
    {
        $data = $request->validate([
            'prepared_by' => ['required', 'string', 'max:150'],
            'period_type' => ['required', 'in:monthly,annual'],
            'month' => ['required_if:period_type,monthly', 'nullable', 'integer', 'between:1,12'],
        ]);
        $barangay = $this->workerBarangay($request);
        $selected = self::DISEASES;
        $month = (int) ($data['month'] ?? 1);
        $periodType = $data['period_type'];
        [$reportStart, $reportEnd] = $this->periodBounds($periodType, $month);
        $rows = $this->patientsFor($barangay, $selected, $reportStart, $reportEnd);
        $reportRows = $this->summarizeRows($rows);
        $periodLabel = $periodType === 'annual' ? 'Annual ' . $reportStart->format('Y') : $reportStart->format('F Y');
        $title = 'Disease Report - ' . $periodLabel . ' - ' . $barangay;
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $title) . '.xls';

        return response("\xEF\xBB\xBF" . view('reports.excel', compact('reportRows', 'barangay', 'selected', 'title', 'data', 'periodType', 'reportStart', 'reportEnd'))->render(), 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache',
        ]);
    }

    public function submit(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'prepared_by' => ['required', 'string', 'max:150'],
            'period_type' => ['required', 'in:monthly,annual'],
            'month' => ['required_if:period_type,monthly', 'nullable', 'integer', 'between:1,12'],
            'report_file' => ['required', 'file', 'max:5120', 'extensions:xls,xlsx'],
        ]);
        $barangay = $this->workerBarangay($request);
        $selected = self::DISEASES;
        $month = (int) ($data['month'] ?? 1);
        $periodType = $data['period_type'];
        [$reportStart, $reportEnd] = $this->periodBounds($periodType, $month);
        $file = $request->file('report_file');
        $storedPath = $file->storeAs('reports', 'report_' . $request->session()->get('id') . '_' . bin2hex(random_bytes(12)) . '.' . $file->extension());

        Report::create([
            'worker_id' => $request->session()->get('id'),
            'barangay' => $barangay,
            'report_period' => $reportStart->toDateString(),
            'report_frequency' => $periodType,
            'diseases' => $selected,
            'patient_count' => $this->patientsFor($barangay, $selected, $reportStart, $reportEnd)->count(),
            'prepared_by' => $data['prepared_by'],
            'attachment_path' => $storedPath,
            'attachment_name' => $file->getClientOriginalName(),
        ]);

        return to_route('reports.create')->with('success', 'Report submitted to admin successfully.');
    }

    private function patientsFor(string $barangay, array $diseases, Carbon $periodStart, Carbon $periodEnd)
    {
        return Patient::query()
            ->where('address', $barangay)
            ->whereIn('disease', $diseases)
            ->whereBetween('date_onset', [$periodStart->toDateString(), $periodEnd->toDateString()])
            ->orderBy('disease')
            ->latest('date_onset')
            ->get();
    }

    private function periodBounds(string $periodType, int $month): array
    {
        $year = now()->year;
        if ($periodType === 'annual') {
            $start = Carbon::create($year, 1, 1)->startOfDay();
            return [$start, $start->copy()->endOfYear()->startOfDay()];
        }

        $start = Carbon::create($year, $month, 1)->startOfMonth();
        return [$start, $start->copy()->endOfMonth()];
    }

    private function monthOptions(): array
    {
        return collect(range(1, 12))
            ->mapWithKeys(fn (int $month): array => [$month => Carbon::create(now()->year, $month, 1)->format('F')])
            ->all();
    }

    public function summarizeRows($patients)
    {
        return collect(self::DISEASES)
            ->map(function (string $disease) use ($patients): array {
                $counts = collect(self::AGE_BANDS)->mapWithKeys(fn (string $band): array => [
                    $band => [
                        'Male' => 0,
                        'Female' => 0,
                        'Total' => 0,
                    ],
                ])->all();

                foreach ($patients->where('disease', $disease) as $patient) {
                    $band = $this->ageBand($patient->age, $patient->age_unit ?? 'years');
                    if ($band === null) {
                        continue;
                    }

                    $gender = ucfirst(strtolower((string) $patient->gender));
                    if (! isset($counts[$band][$gender])) {
                        continue;
                    }

                    $counts[$band][$gender]++;
                    $counts[$band]['Total']++;
                }

                return [
                    'disease' => $disease,
                    'icd_code' => self::ICD_CODES[$disease],
                    'counts' => $counts,
                    'grand_total' => collect($counts)->sum('Total'),
                ];
            })->values();
    }

    private function ageBand(?int $age, string $unit): ?string
    {
        if ($age === null || $age < 0) {
            return null;
        }

        if ($unit === 'days') {
            return match (true) {
                $age <= 6 => '0-6 days',
                $age <= 28 => '7-28 days',
                $age <= 334 => '29 days to 11 months',
                default => null,
            };
        }

        if ($unit === 'months') {
            return $age <= 0 ? '0-6 days' : ($age <= 11 ? '29 days to 11 months' : $this->yearBand(intdiv($age, 12)));
        }

        return $this->yearBand($age);
    }

    private function yearBand(int $years): ?string
    {
        if ($years < 1) {
            return '0-6 days';
        }

        if ($years <= 4) {
            return '1-4 years old';
        }

        if ($years >= 60) {
            return '60 and above';
        }

        $bandStart = intdiv($years, 5) * 5;

        return $bandStart . '-' . ($bandStart + 4) . ' years old';
    }

    private function workerBarangay(Request $request): string
    {
        abort_unless($request->session()->get('role') === 'health_worker', 403);
        $barangay = trim((string) $request->session()->get('barangay', ''));
        abort_if($barangay === '', 403);
        return $barangay;
    }
}
