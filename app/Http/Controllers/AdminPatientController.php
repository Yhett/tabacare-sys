<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class AdminPatientController extends Controller
{
    public function index(Request $request)
    {
        $diseases = [
            'Influenza',
            'Measles',
            'Common Cold',
            'Hypertension',
            'Hand, Foot, and Mouth Disease'
        ];

        $barangays = [
            // Put your 47 barangays here
        ];

        $filterDisease = $request->input('filter_disease');

        $patients = Patient::with('addedBy')
            ->when($filterDisease, function ($query) use ($filterDisease) {
                $query->where('disease', $filterDisease);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $adminName = session('user', 'Administrator');

        return view('admin.patients', compact(
            'patients',
            'diseases',
            'barangays',
            'filterDisease',
            'adminName'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_code' => 'required|string|max:50|unique:patients,patient_code',
            'age'          => 'required|integer|min:0|max:150',
            'age_unit'     => 'required|in:years,months,days',
            'gender'       => 'required|in:Male,Female',
            'disease'      => 'required|string|max:255',
            'date_onset'   => 'required|date',
            'address'      => 'required|string|max:255'
        ]);

        $validated['added_by'] = auth()->id();

        Patient::create($validated);

        return redirect()
            ->route('admin.patients')
            ->with('success', 'Patient record added successfully.');
    }

    public function edit(Patient $patient)
    {
        return view('admin.patients-edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'patient_code' => 'required|string|max:50|unique:patients,patient_code,' . $patient->id,
            'age'          => 'required|integer|min:0|max:150',
            'age_unit'     => 'required|in:years,months,days',
            'gender'       => 'required|in:Male,Female',
            'disease'      => 'required|string|max:255',
            'date_onset'   => 'required|date',
            'address'      => 'required|string|max:255'
        ]);

        $patient->update($validated);

        return redirect()
            ->route('admin.patients')
            ->with('success', 'Patient record updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()
            ->route('admin.patients')
            ->with('success', 'Patient record deleted successfully.');
    }
}