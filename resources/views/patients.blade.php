<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patients | TABACARE</title>
    <style>
        :root { --ink: #18303b; --muted: #6c7f86; --paper: #f6f8f5; --panel: #fff; --line: #dce6e1; --teal: #087f78; --coral: #e9795d; --shadow: 0 14px 40px rgba(24,48,59,.08); }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--paper); color: var(--ink); font-family: Georgia, 'Times New Roman', serif; }
        button, input, select { font: inherit; }
        .main { min-height: 100vh; padding: 30px clamp(20px, 4vw, 58px) 48px; }
        .page-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 18px; margin-bottom: 28px; }
        .eyebrow { color: var(--teal); font: 700 11px Arial, sans-serif; letter-spacing: .16em; text-transform: uppercase; }
        h1 { margin: 7px 0 6px; font-size: clamp(28px, 4vw, 40px); font-weight: 400; }
        .intro { margin: 0; color: var(--muted); font-size: 16px; }
        .user-chip { display: flex; align-items: center; gap: 9px; color: var(--muted); font: 13px Arial, sans-serif; white-space: nowrap; }
        .avatar { width: 38px; height: 38px; display: grid; place-items: center; border-radius: 50%; background: #f3d28d; color: #604416; font-weight: 700; }
        .toolbar { display: flex; align-items: end; gap: 14px; padding: 17px; background: var(--panel); border: 1px solid var(--line); box-shadow: var(--shadow); }
        .field { display: grid; gap: 6px; min-width: 180px; flex: 1; }
        label { color: var(--muted); font: 700 10px Arial, sans-serif; letter-spacing: .1em; text-transform: uppercase; }
        input, select { width: 100%; min-height: 42px; padding: 9px 11px; border: 1px solid var(--line); border-radius: 4px; background: #fbfdfb; color: var(--ink); }
        .button { min-height: 42px; padding: 0 16px; border: 0; border-radius: 4px; background: var(--teal); color: #fff; cursor: pointer; font: 700 12px Arial, sans-serif; }
        .button:hover { background: #075c5a; }
        .button.secondary { background: #edf5f1; color: var(--teal); text-decoration: none; display: inline-flex; align-items: center; }
        .button.coral { background: var(--coral); }
        .alert { margin: 16px 0; padding: 12px 15px; border: 1px solid; border-radius: 4px; font: 13px Arial, sans-serif; }
        .alert.success { border-color: #bde5cd; background: #effaf3; color: #19683d; }
        .alert.error { border-color: #f3c7c0; background: #fff4f2; color: #9d3d2f; }
        .summary-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; margin-bottom: 18px; }
        .summary-card { padding: 16px 18px; background: var(--panel); border: 1px solid var(--line); box-shadow: 0 7px 20px rgba(24,48,59,.04); }
        .summary-card.primary { background: var(--teal); border-color: var(--teal); color: #fff; }
        .summary-label { display: block; color: var(--muted); font: 700 10px Arial, sans-serif; letter-spacing: .1em; text-transform: uppercase; }
        .primary .summary-label { color: #bce5dc; }
        .summary-value { display: block; margin-top: 9px; font-size: 28px; }
        .summary-note { display: block; margin-top: 4px; color: var(--muted); font: 11px Arial, sans-serif; }
        .primary .summary-note { color: #d9f3ec; }
        .disease-strip { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 2px; margin-bottom: 18px; }
        .disease-chip { flex: 0 0 auto; padding: 8px 11px; border: 1px solid var(--line); border-radius: 999px; background: #fff; color: var(--muted); font: 11px Arial, sans-serif; }
        .disease-chip strong { color: var(--teal); font-size: 13px; }
        .table-panel { margin-top: 18px; overflow: hidden; background: var(--panel); border: 1px solid var(--line); box-shadow: var(--shadow); }
        .table-head { display: flex; justify-content: space-between; align-items: center; gap: 15px; padding: 19px 20px; border-bottom: 1px solid var(--line); }
        h2 { margin: 0; font-size: 20px; font-weight: 400; }
        .count { color: var(--muted); font: 12px Arial, sans-serif; }
        .table-scroll { max-width: 100%; overflow: auto; scrollbar-gutter: stable; }
        table { width: 100%; min-width: 900px; table-layout: fixed; border-collapse: collapse; font: 13px Arial, sans-serif; }
        th { position: sticky; top: 0; z-index: 1; padding: 13px 15px; border-bottom: 1px solid var(--line); background: #f7faf8; color: var(--muted); text-align: left; font: 700 10px Arial, sans-serif; letter-spacing: .1em; text-transform: uppercase; white-space: nowrap; }
        td { padding: 14px 15px; border-top: 1px solid #edf2ef; color: #334b52; white-space: nowrap; }
        tbody tr:nth-child(even) { background: #fbfdfc; }
        tbody tr:hover { background: #f0f8f5; }
        td:first-child { color: var(--teal); font-weight: 700; }
        td:nth-child(4) { white-space: normal; line-height: 1.4; }
        td:last-child { text-align: right; }
        .actions { display: flex; justify-content: flex-end; gap: 7px; }
        .action { padding: 7px 10px; border: 1px solid var(--line); border-radius: 3px; background: #fff; color: var(--teal); cursor: pointer; font: 700 11px Arial, sans-serif; }
        .action.delete { color: #b24b40; }
        .empty { padding: 55px 20px; color: var(--muted); text-align: center; }
        .table-footer { display: flex; justify-content: space-between; align-items: center; gap: 15px; padding: 14px 20px; border-top: 1px solid var(--line); color: var(--muted); font: 12px Arial, sans-serif; }
        .pagination { display: flex; gap: 6px; }
        .pagination a, .pagination span { padding: 7px 10px; border: 1px solid var(--line); border-radius: 3px; color: var(--teal); text-decoration: none; }
        .pagination span { background: var(--teal); color: #fff; }
        dialog { width: min(500px, calc(100% - 30px)); padding: 0; border: 0; border-radius: 7px; box-shadow: 0 25px 80px rgba(24,48,59,.25); }
        dialog::backdrop { background: rgba(24,48,59,.34); }
        .modal-head { display: flex; justify-content: space-between; padding: 22px 24px 15px; border-bottom: 1px solid var(--line); }
        .modal-close { border: 0; background: transparent; color: var(--muted); cursor: pointer; font-size: 24px; }
        .modal-body { display: grid; gap: 13px; padding: 22px 24px 24px; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 5px; }
        .assigned { padding: 10px 12px; border-radius: 4px; background: #effaf3; color: #19683d; font: 12px Arial, sans-serif; }
        @media (max-width: 700px) { .page-head, .toolbar, .table-footer { display: block; } .user-chip { margin-top: 16px; } .field, .toolbar .button { width: 100%; margin-top: 10px; } .table-head { align-items: flex-start; } }
        @media (max-width: 700px) { .summary-grid { grid-template-columns: 1fr; } }
        .export-notice {
    position: fixed;
    top: 22px;
    right: 22px;
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 13px 18px;
    border: 1px solid #bde5cd;
    border-radius: 6px;
    background: #effaf3;
    color: #19683d;
    box-shadow: 0 8px 25px rgba(24,48,59,.12);
    font: 13px Arial, sans-serif;
    font-weight: 600;
    animation: slideIn .3s ease;
}

.export-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: #19683d;
    color: white;
    font-weight: bold;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
    </style>
</head>
<body>
    @include('partials.sidebar')
    <main class="main">
        @php($worker = session('user', 'Health Worker'))
        <header class="page-head">
            <div><div class="eyebrow">Patient management</div><h1>Patients information</h1><p class="intro">Records assigned to {{ $barangay }} only.</p></div>
            <div class="user-chip"><div class="avatar">{{ strtoupper(substr($worker, 0, 1)) }}</div>{{ $worker }}</div>
        </header>

        <section class="summary-grid" aria-label="Patient summary">
            <article class="summary-card primary"><span class="summary-label">Total patients</span><span class="summary-value">{{ $patients->total() }}</span><span class="summary-note">In {{ $barangay }}</span></article>
            <article class="summary-card"><span class="summary-label">This month</span><span class="summary-value">{{ $monthTotal }}</span><span class="summary-note">By date of onset</span></article>
            <article class="summary-card"><span class="summary-label">Showing</span><span class="summary-value">{{ $patients->count() }}</span><span class="summary-note">Current page records</span></article>
        </section>
        <div class="disease-strip" aria-label="Cases by disease">@foreach($diseases as $disease)<span class="disease-chip">{{ $disease }} <strong>{{ $diseaseTotals[$disease] ?? 0 }}</strong></span>@endforeach</div>

        @if (session('success'))<div class="alert success">{{ session('success') }}</div>@endif
        @if ($errors->any())<div class="alert error">{{ $errors->first() }}</div>@endif

        <form class="toolbar" method="GET" action="{{ route('patients.index') }}">
            @csrf
            <div class="field"><label for="search">Search patient code</label><input id="search" name="search" value="{{ $search }}" placeholder="e.g. PAT-001"></div>
            <div class="field"><label for="filter_disease">Filter disease</label><select id="filter_disease" name="filter_disease"><option value="">All diseases</option>@foreach($diseases as $disease)<option value="{{ $disease }}" @selected($filterDisease === $disease)>{{ $disease }}</option>@endforeach</select></div>
            <button class="button" type="submit">Search</button>
            @if($search || $filterDisease)<a class="button secondary" href="{{ route('patients.index') }}">Clear</a>@endif
            <button
                class="button secondary"
                type="submit"
                formmethod="POST"
                formaction="{{ route('patients.export') }}"
                onclick="exportExcel(event, this)">
                Export Excel
            </button>
            <button class="button coral" type="button" onclick="openPatientModal()">+ Add patient</button>
        </form>

        <section class="table-panel">
            <div class="table-head"><h2>Patient records</h2><span class="count">{{ $patients->total() }} record(s) in {{ $barangay }}</span></div>
            <div class="table-scroll" role="region" aria-label="Patient records table" tabindex="0"><table><colgroup><col style="width:145px"><col style="width:90px"><col style="width:100px"><col style="width:260px"><col style="width:155px"><col style="width:150px"></colgroup><thead><tr><th>Patient code</th><th>Age</th><th>Gender</th><th>Disease</th><th>Date of onset</th><th>Actions</th></tr></thead><tbody>
                @forelse($patients as $patient)
                    <tr><td>{{ $patient->patient_code }}</td><td>{{ $patient->age !== null ? $patient->age . ' ' . ($patient->age_unit ?? 'years') : '—' }}</td><td>{{ $patient->gender ?? '—' }}</td><td>{{ $patient->disease }}</td><td>{{ $patient->date_onset?->format('d M Y') ?? '—' }}</td><td><div class="actions"><button class="action" type="button" onclick='editPatient(@json($patient))'>Edit</button><form method="POST" action="{{ route('patients.destroy', $patient) }}" onsubmit="return confirm('Delete this patient record?')">@csrf @method('DELETE')<button class="action delete" type="submit">Delete</button></form></div></td></tr>
                @empty
                    <tr><td class="empty" colspan="6">No patients found for the current filters.</td></tr>
                @endforelse
            </tbody></table></div>
            <div class="table-footer"><span>Showing {{ $patients->firstItem() ?? 0 }} to {{ $patients->lastItem() ?? 0 }}</span><div class="pagination">@if($patients->previousPageUrl())<a href="{{ $patients->previousPageUrl() }}">Previous</a>@endif @if($patients->nextPageUrl())<a href="{{ $patients->nextPageUrl() }}">Next</a>@endif</div></div>
        </section>
    </main>

    <dialog id="patientModal">
        <div class="modal-head"><div><div class="eyebrow">Patient record</div><h2 id="modalTitle">Add patient</h2></div><button class="modal-close" type="button" onclick="closePatientModal()" aria-label="Close">&times;</button></div>
        <form class="modal-body" id="patientForm" method="POST" action="{{ route('patients.store') }}">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="">
            <div class="field"><label for="patient_code">Patient code</label><input id="patient_code" name="patient_code" required></div>
            <div class="field"><label for="age">Age</label><div style="display:grid;grid-template-columns:1fr 130px;gap:8px"><input id="age" name="age" type="number" min="0" max="150" required><select name="age_unit" aria-label="Age unit" required><option value="years">Years</option><option value="months">Months</option><option value="days">Days</option></select></div></div>
            <div class="field"><label for="gender">Gender</label><select id="gender" name="gender" required><option value="">Select gender</option><option>Male</option><option>Female</option></select></div>
            <div class="field"><label for="disease">Disease</label><select id="disease" name="disease" required><option value="">Select disease</option>@foreach($diseases as $disease)<option>{{ $disease }}</option>@endforeach</select></div>
            <div class="field"><label for="date_onset">Date of onset</label><input id="date_onset" name="date_onset" type="date" required></div>
            <div class="assigned">Barangay is fixed to <strong>{{ $barangay }}</strong> for this account.</div>
            <div class="modal-actions"><button class="button secondary" type="button" onclick="closePatientModal()">Cancel</button><button class="button" id="submitButton" type="submit">Add patient</button></div>
        </form>
    </dialog>

    <script>
        const modal = document.getElementById('patientModal');
        const form = document.getElementById('patientForm');
        const methodField = document.getElementById('methodField');
        const patientsStoreUrl = @json(route('patients.store'));
        function openPatientModal() { form.reset(); form.action = patientsStoreUrl; methodField.value = ''; document.getElementById('modalTitle').textContent = 'Add patient'; document.getElementById('submitButton').textContent = 'Add patient'; modal.showModal(); }
        function editPatient(patient) { form.action = '/patients/' + patient.id; methodField.value = 'PUT'; document.getElementById('patient_code').value = patient.patient_code || ''; document.getElementById('age').value = patient.age ?? ''; form.querySelector('[name="age_unit"]').value = patient.age_unit || 'years'; document.getElementById('gender').value = patient.gender || ''; document.getElementById('disease').value = patient.disease || ''; document.getElementById('date_onset').value = patient.date_onset ? patient.date_onset.substring(0, 10) : ''; document.getElementById('modalTitle').textContent = 'Edit patient'; document.getElementById('submitButton').textContent = 'Save changes'; modal.showModal(); }
        function closePatientModal() { modal.close(); }

        function exportExcel(event, button) {
    event.preventDefault();

    const form = button.closest('form');

    button.disabled = true;
    button.innerHTML = 'Exporting...';

    const formData = new FormData(form);

    fetch(button.formAction, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Export failed');
        }

        return response.blob();
    })
    .then(blob => {

        // Download the Excel file
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');

        a.href = url;
        a.download = 'TABACARE_Patient_Records.xlsx';

        document.body.appendChild(a);
        a.click();
        a.remove();

        window.URL.revokeObjectURL(url);

        // Success message
        showExportNotice();
    })
    .catch(error => {
        alert('Unable to export the file.');
        console.error(error);
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = 'Export Excel';
    });
}

        function showExportNotice() {
            const notice = document.createElement('div');

                notice.className = 'export-notice';

                notice.innerHTML = `
                <span class="export-icon">✓</span>
                <span>File exported successfully.</span>
            `;

            document.body.appendChild(notice);

            setTimeout(function () {
                notice.remove();
            }, 3000);
        }
    </script>
@include('partials.submit-guard')
</body>
</html>
