<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    private const DISEASES = [
        'Influenza',
        'Measles',
        'Common Cold',
        'Chickenpox',
        'Hand, Foot, and Mouth Disease',
    ];

    public function index(Request $request): View
    {
        abort_unless($request->session()->get('role') === 'health_worker', 403);
        $barangay = $this->workerBarangay($request);
        $search = trim((string) $request->query('search', ''));
        $filterDisease = (string) $request->query('filter_disease', '');

        $patients = Patient::query()
            ->where('address', $barangay)
            ->when($search !== '', fn ($query) => $query->where('patient_code', 'like', "%{$search}%"))
            ->when(in_array($filterDisease, self::DISEASES, true), fn ($query) => $query->where('disease', $filterDisease))
            ->latest('date_onset')
            ->paginate(10)
            ->withQueryString();

        $diseaseTotals = Patient::query()
            ->where('address', $barangay)
            ->selectRaw('disease, COUNT(*) as total')
            ->groupBy('disease')
            ->pluck('total', 'disease');
        $monthTotal = Patient::query()
            ->where('address', $barangay)
            ->whereBetween('date_onset', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])
            ->count();

        return view('patients', [
            'patients' => $patients,
            'barangay' => $barangay,
            'search' => $search,
            'filterDisease' => $filterDisease,
            'diseases' => self::DISEASES,
            'diseaseTotals' => $diseaseTotals,
            'monthTotal' => $monthTotal,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $barangay = $this->workerBarangay($request);
        $data = $this->validated($request);
        $data['address'] = $barangay;
        $data['added_by'] = $request->session()->get('id');

        Patient::create($data);

        return to_route('patients.index')->with('success', 'Patient added successfully.');
    }

    public function update(Request $request, Patient $patient): RedirectResponse
    {
        $barangay = $this->workerBarangay($request);
        $this->ownedPatient($patient, $barangay);

        $data = $this->validated($request, $patient);
        $data['address'] = $barangay;
        $patient->update($data);

        return to_route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Request $request, Patient $patient): RedirectResponse
    {
        $this->ownedPatient($patient, $this->workerBarangay($request));
        $patient->delete();

        return to_route('patients.index')->with('success', 'Patient deleted successfully.');
    }

    public function export(Request $request): Response
    {
        $barangay = $this->workerBarangay($request);
        $search = trim((string) $request->input('search', ''));
        $filterDisease = trim((string) $request->input('filter_disease', ''));

        $patients = Patient::query()
            ->where('address', $barangay)
            ->when($search !== '', fn ($query) => $query->where('patient_code', 'like', "%{$search}%"))
            ->when(in_array($filterDisease, self::DISEASES, true), fn ($query) => $query->where('disease', $filterDisease))
            ->orderBy('address')
            ->orderBy('disease')
            ->latest('date_onset')
            ->orderBy('patient_code')
            ->get();

        $reportTitle = $filterDisease !== ''
            ? "Cases of {$filterDisease} in {$barangay}"
            : "Cases of Common Diseases in {$barangay}";
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $reportTitle);
        $filename .= $search !== ''
            ? '_Search_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $search)
            : '';
        $filename .= '_' . now()->format('Y-m-d') . '.xls';

        $html = view('exports.patients', [
            'patients' => $patients,
            'barangay' => $barangay,
            'reportTitle' => $reportTitle,
            'reportDate' => now()->format('F d, Y'),
        ])->render();

        return response("\xEF\xBB\xBF" . $html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    private function validated(Request $request, ?Patient $patient = null): array
    {
        return $request->validate([
            'patient_code' => ['required', 'string', 'max:255', Rule::unique('patients', 'patient_code')->ignore($patient?->id)],
            'disease' => ['required', Rule::in(self::DISEASES)],
            'date_onset' => ['required', 'date'],
            'age' => ['required', 'integer', 'between:0,150'],
            'age_unit' => ['required', Rule::in(['days', 'months', 'years'])],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
        ]);
    }

    private function workerBarangay(Request $request): string
    {
        abort_unless($request->session()->get('role') === 'health_worker', 403);

        $barangay = trim((string) $request->session()->get('barangay', ''));
        abort_if($barangay === '', 403);

        return $barangay;
    }

    private function ownedPatient(Patient $patient, string $barangay): void
    {
        abort_unless($patient->address === $barangay, 403);
    }
}
