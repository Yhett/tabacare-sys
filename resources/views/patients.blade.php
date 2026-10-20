<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patients | TABACARE</title>
    <link rel="icon" type="image/png" href="{{ asset('images/tabacare-logo.png') }}">

    <style>
        :root {
            --ink: #18303b;
            --muted: #6c7f86;
            --paper: #f6f8f5;
            --panel: #fff;
            --line: #dce6e1;
            --teal: #087f78;
            --coral: #e9795d;
            --shadow: 0 14px 40px rgba(24,48,59,.08);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--paper);
            color: var(--ink);
            font-family: Georgia, 'Times New Roman', serif;
        }

        button,
        input,
        select {
            font: inherit;
        }

        .main {
            min-height: 100vh;
            padding: 30px clamp(20px, 4vw, 58px) 48px;
        }

        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 18px;
            margin-bottom: 28px;
        }

        .eyebrow {
            color: var(--teal);
            font: 700 14px Arial, sans-serif;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        h1 {
            margin: 7px 0 6px;
            font-size: clamp(30px, 4vw, 42px);
            font-weight: 400;
            line-height: 1.2;
        }

        .intro {
            margin: 0;
            color: #3f565e;
            font-size: 19px;
            line-height: 1.6;
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #3f565e;
            font: 16px Arial, sans-serif;
            line-height: 1.5;
            white-space: nowrap;
        }

        .avatar {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #f3d28d;
            color: #604416;
            font-weight: 700;
        }

        .toolbar {
            display: flex;
            align-items: end;
            gap: 14px;
            padding: 17px;
            background: var(--panel);
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
        }

        .field {
            display: grid;
            gap: 6px;
            min-width: 180px;
            flex: 1;
        }

        label {
            color: #3f565e;
            font: 700 13px Arial, sans-serif;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        input,
        select {
            width: 100%;
            min-height: 50px;
            padding: 12px 14px;
            border: 1px solid var(--line);
            border-radius: 6px;
            background: #fbfdfb;
            color: var(--ink);
            font-size: 17px !important;
            line-height: 1.5;
        }

        .button {
            min-height: 50px;
            padding: 0 20px;
            border: 0;
            border-radius: 6px;
            background: var(--teal);
            color: #fff;
            cursor: pointer;
            font: 700 16px Arial, sans-serif;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            white-space: nowrap;
        }

        .button:hover {
            background: #075c5a;
        }

        .button.secondary {
            background: #edf5f1;
            color: var(--teal);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .button.coral {
            background: var(--coral);
        }

        .button:disabled {
            opacity: .7;
            cursor: wait;
        }

        /* Export runs in its own row so its loading state never touches Search. */
        .toolbar-export {
            margin-top: 10px;
            align-items: center;
        }

        .export-hint {
            color: #3f565e;
            font: 15px Arial, sans-serif;
            line-height: 1.5;
        }

        .alert {
            margin: 16px 0;
            padding: 14px 16px;
            border: 1px solid;
            border-radius: 6px;
            font: 16px Arial, sans-serif;
            line-height: 1.55;
        }

        .alert.success {
            border-color: #bde5cd;
            background: #effaf3;
            color: #19683d;
        }

        .alert.error {
            border-color: #f3c7c0;
            background: #fff4f2;
            color: #9d3d2f;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 18px;
        }

        .summary-card {
            padding: 20px 22px;
            background: var(--panel);
            border: 1px solid var(--line);
            box-shadow: 0 7px 20px rgba(24,48,59,.04);
        }

        .summary-card.primary {
            background: var(--teal);
            border-color: var(--teal);
            color: #fff;
        }

        .summary-label {
            display: block;
            color: #3f565e;
            font: 700 13px Arial, sans-serif;
            letter-spacing: .07em;
            text-transform: uppercase;
        }

        .primary .summary-label {
            color: #d4efe7;
        }

        .summary-value {
            display: block;
            margin-top: 10px;
            font-size: 36px;
            line-height: 1.1;
        }

        .summary-note {
            display: block;
            margin-top: 6px;
            color: #3f565e;
            font: 15px Arial, sans-serif;
        }

        .primary .summary-note {
            color: #e6f5f0;
        }

        .disease-strip {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 2px;
            margin-bottom: 18px;
        }

        .disease-chip {
            flex: 0 0 auto;
            padding: 10px 15px;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: #fff;
            color: #3f565e;
            font: 14px Arial, sans-serif;
        }

        .disease-chip strong {
            color: var(--teal);
            font-size: 15px;
        }

        .table-panel {
            margin-top: 18px;
            overflow: hidden;
            background: var(--panel);
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
        }

        .table-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 19px 20px;
            border-bottom: 1px solid var(--line);
        }

        h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 400;
            line-height: 1.3;
        }

        .count {
            color: #3f565e;
            font: 15px Arial, sans-serif;
        }

        .table-scroll {
            max-width: 100%;
            overflow: auto;
            scrollbar-gutter: stable;
        }

        table {
            width: 100%;
            min-width: 900px;
            table-layout: fixed;
            border-collapse: collapse;
            font: 17px Arial, sans-serif;
            line-height: 1.55;
        }

        th {
            position: sticky;
            top: 0;
            z-index: 1;
            padding: 15px;
            border-bottom: 1px solid var(--line);
            background: #f7faf8;
            color: #334e57;
            text-align: left;
            font: 700 13px Arial, sans-serif;
            letter-spacing: .07em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        td {
            padding: 16px 15px;
            border-top: 1px solid #edf2ef;
            color: #243f46;
            white-space: nowrap;
        }

        tbody tr:nth-child(even) {
            background: #fbfdfc;
        }

        tbody tr:hover {
            background: #f0f8f5;
        }

        td:first-child {
            color: var(--teal);
            font-weight: 700;
        }

        td:nth-child(4) {
            white-space: normal;
            line-height: 1.4;
        }

        td:last-child {
            text-align: right;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .action {
            padding: 10px 15px;
            min-height: 44px;
            border: 1px solid var(--line);
            border-radius: 5px;
            background: #fff;
            color: var(--teal);
            cursor: pointer;
            font: 700 15px Arial, sans-serif;
        }

        .action.delete {
            color: #b24b40;
        }

        .empty {
            padding: 60px 24px;
            color: #3f565e;
            text-align: center;
            font-size: 18px;
            line-height: 1.6;
        }

        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 16px 20px;
            border-top: 1px solid var(--line);
            color: #3f565e;
            font: 15px Arial, sans-serif;
        }

        .pagination {
            display: flex;
            gap: 8px;
        }

        .pagination a,
        .pagination span {
            padding: 10px 14px;
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            border: 1px solid var(--line);
            border-radius: 5px;
            color: var(--teal);
            text-decoration: none;
            font-size: 15px;
        }

        .pagination span {
            background: var(--teal);
            color: #fff;
        }

        dialog {
            width: min(560px, calc(100% - 30px));
            padding: 0;
            border: 0;
            border-radius: 8px;
            box-shadow: 0 25px 80px rgba(24,48,59,.25);
            font-size: 17px;
        }

        dialog::backdrop {
            background: rgba(24,48,59,.34);
        }

        .modal-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 24px 26px 16px;
            border-bottom: 1px solid var(--line);
            font-size: 22px;
        }

        .modal-close {
            border: 0;
            background: transparent;
            color: #3f565e;
            cursor: pointer;
            font-size: 30px;
            min-width: 48px;
            min-height: 48px;
        }

        .modal-body {
            display: grid;
            gap: 16px;
            padding: 24px 26px 26px;
            font-size: 17px;
            line-height: 1.6;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 8px;
        }

        .assigned {
            padding: 14px 16px;
            border-radius: 6px;
            background: #effaf3;
            color: #145f38;
            font: 16px Arial, sans-serif;
            line-height: 1.55;
        }

        /* Export success notification */
        .export-notice {
            position: fixed;
            top: 22px;
            right: 22px;
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            border: 1px solid #bde5cd;
            border-radius: 8px;
            background: #effaf3;
            color: #145f38;
            box-shadow: 0 8px 25px rgba(24,48,59,.12);
            font: 600 16px Arial, sans-serif;
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

        @media (max-width: 700px) {
            .page-head,
            .toolbar,
            .table-footer {
                display: block;
            }

            .user-chip {
                margin-top: 16px;
            }

            .field,
            .toolbar .button {
                width: 100%;
                margin-top: 10px;
            }

            .table-head {
                align-items: flex-start;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .export-notice {
                left: 15px;
                right: 15px;
                top: 15px;
            }
        }
    </style>
    @include('partials.fonts')
</head>

<body>

    @include('partials.sidebar')

    <main class="main">

        @php($worker = session('user', 'Health Worker'))

        <header class="page-head">
            <div>
                <div class="eyebrow">Patient management</div>
                <h1>Patients information</h1>
                <p class="intro">Records assigned to {{ $barangay }} only.</p>
            </div>

            <div class="user-chip">
                <div class="avatar">
                    {{ strtoupper(substr($worker, 0, 1)) }}
                </div>
                {{ $worker }}
            </div>
        </header>

        <section class="summary-grid" aria-label="Patient summary">

            <article class="summary-card primary">
                <span class="summary-label">Total patients</span>
                <span class="summary-value">{{ $patients->total() }}</span>
                <span class="summary-note">In {{ $barangay }}</span>
            </article>

            <article class="summary-card">
                <span class="summary-label">This month</span>
                <span class="summary-value">{{ $monthTotal }}</span>
                <span class="summary-note">By date of onset</span>
            </article>

            <article class="summary-card">
                <span class="summary-label">Showing</span>
                <span class="summary-value">{{ $patients->count() }}</span>
                <span class="summary-note">Current page records</span>
            </article>

        </section>

        <div class="disease-strip" aria-label="Cases by disease">
            @foreach($diseases as $disease)
                <span class="disease-chip">
                    {{ $disease }}
                    <strong>{{ $diseaseTotals[$disease] ?? 0 }}</strong>
                </span>
            @endforeach
        </div>

        @if (session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert error">
                {{ $errors->first() }}
            </div>
        @endif

        <form class="toolbar" id="patientSearchForm" method="GET" action="{{ route('patients.index') }}">

            <div class="field">
                <label for="search">Search patient code</label>
                <input
                    id="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="e.g. PAT-001">
            </div>

            <div class="field">
                <label for="filter_disease">Filter disease</label>

                <select id="filter_disease" name="filter_disease">
                    <option value="">All diseases</option>

                    @foreach($diseases as $disease)
                        <option
                            value="{{ $disease }}"
                            @selected($filterDisease === $disease)>
                            {{ $disease }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="button" id="patientSearchButton" type="submit">
                Search
            </button>

            @if($search || $filterDisease)
                <a
                    class="button secondary"
                    href="{{ route('patients.index') }}">
                    Clear
                </a>
            @endif

            <button
                class="button coral"
                type="button"
                onclick="openPatientModal()">
                + Add patient
            </button>

        </form>

        <form
            class="toolbar toolbar-export"
            id="patientExportForm"
            method="POST"
            action="{{ route('patients.export') }}"
            target="exportFrame">
            @csrf
            <input type="hidden" name="search" value="{{ $search }}">
            <input type="hidden" name="filter_disease" value="{{ $filterDisease }}">
            <button
                class="button secondary"
                id="patientExportButton"
                type="submit"
                onclick="showExportNotice()">
                Export Excel
            </button>
            <span class="export-hint">Exports the records matching the current search / filter above.</span>
        </form>

        <section class="table-panel">

            <div class="table-head">
                <h2>Patient records</h2>
                <span class="count">
                    {{ $patients->total() }} record(s) in {{ $barangay }}
                </span>
            </div>

            <div
                class="table-scroll"
                role="region"
                aria-label="Patient records table"
                tabindex="0">

                <table>

                    <colgroup>
                        <col style="width:145px">
                        <col style="width:90px">
                        <col style="width:100px">
                        <col style="width:260px">
                        <col style="width:155px">
                        <col style="width:150px">
                    </colgroup>

                    <thead>
                        <tr>
                            <th>Patient code</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Disease</th>
                            <th>Date of onset</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($patients as $patient)

                            <tr>

                                <td>
                                    {{ $patient->patient_code }}
                                </td>

                                <td>
                                    {{ $patient->age !== null
                                        ? $patient->age . ' ' . ($patient->age_unit ?? 'years')
                                        : '—' }}
                                </td>

                                <td>
                                    {{ $patient->gender ?? '—' }}
                                </td>

                                <td>
                                    {{ $patient->disease }}
                                </td>

                                <td>
                                    {{ $patient->date_onset?->format('d M Y') ?? '—' }}
                                </td>

                                <td>

                                    <div class="actions">

                                        <button
                                            class="action"
                                            type="button"
                                            onclick='editPatient(@json($patient))'>
                                            Edit
                                        </button>

                                        <form
                                            method="POST"
                                            action="{{ route('patients.destroy', $patient) }}"
                                            onsubmit="return confirm('Delete this patient record?')">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="action delete"
                                                type="submit">
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td class="empty" colspan="6">
                                    No patients found for the current filters.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="table-footer">

                <span>
                    Showing
                    {{ $patients->firstItem() ?? 0 }}
                    to
                    {{ $patients->lastItem() ?? 0 }}
                </span>

                <div class="pagination">

                    @if($patients->previousPageUrl())
                        <a href="{{ $patients->previousPageUrl() }}">
                            Previous
                        </a>
                    @endif

                    @if($patients->nextPageUrl())
                        <a href="{{ $patients->nextPageUrl() }}">
                            Next
                        </a>
                    @endif

                </div>

            </div>

        </section>

    </main>

    <!-- Hidden iframe for Excel download -->
    <iframe
        name="exportFrame"
        id="exportFrame"
        style="display:none;">
    </iframe>

    <dialog id="patientModal">

        <div class="modal-head">

            <div>
                <div class="eyebrow">Patient record</div>
                <h2 id="modalTitle">Add patient</h2>
            </div>

            <button
                class="modal-close"
                type="button"
                onclick="closePatientModal()"
                aria-label="Close">
                &times;
            </button>

        </div>

        <form
            class="modal-body"
            id="patientForm"
            method="POST"
            action="{{ route('patients.store') }}">

            @csrf

            <input
                type="hidden"
                name="_method"
                id="methodField"
                value="">

            <div class="field">

                <label for="patient_code">
                    Patient code
                </label>

                <input
                    id="patient_code"
                    name="patient_code"
                    required>

            </div>

            <div class="field">

                <label for="age">
                    Age
                </label>

                <div
                    style="display:grid;grid-template-columns:1fr 130px;gap:8px">

                    <input
                        id="age"
                        name="age"
                        type="number"
                        min="0"
                        max="150"
                        required>

                    <select name="age_unit" aria-label="Age unit" required>
                        <option value="years"> Years </option>
                        <option value="months"> Months </option>
                        <option value="days"> Days </option>
                    </select>

                </div>
            </div>

            <div class="field">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="">Select gender</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>

            <div class="field">
                <label for="disease"> Disease</label>
                <select id="disease" name="disease" required>
                    <option value="">Select disease</option>
                    @foreach($diseases as $disease)
                        <option>{{ $disease }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="date_onset"> Date of onset</label>
                <input id="date_onset" name="date_onset" type="date" required>
            </div>

            <div class="assigned"> Barangay is fixed to<strong>{{ $barangay }}</strong> for this account.</div>

            <div class="modal-actions">
                <button class="button secondary" type="button" onclick="closePatientModal()">Cancel</button>
                <button class="button" id="submitButton" type="submit">Add patient</button>
            </div>
        </form>
    </dialog>

    <script>
        const modal = document.getElementById('patientModal');
        const form = document.getElementById('patientForm');
        const methodField = document.getElementById('methodField');
        const patientsStoreUrl = @json(route('patients.store'));

        // Keep the separate Export form in sync with the live Search inputs,
        // so Export always downloads what is currently typed/selected.
        const searchInput = document.getElementById('search');
        const diseaseInput = document.getElementById('filter_disease');
        const exportForm = document.getElementById('patientExportForm');
        function syncExportFilters() {
            if (!exportForm) return;
            const searchField = exportForm.querySelector('input[name="search"]');
            const diseaseField = exportForm.querySelector('input[name="filter_disease"]');
            if (searchField && searchInput) searchField.value = searchInput.value;
            if (diseaseField && diseaseInput) diseaseField.value = diseaseInput.value;
        }
        if (searchInput) searchInput.addEventListener('input', syncExportFilters);
        if (diseaseInput) diseaseInput.addEventListener('change', syncExportFilters);
        if (exportForm) exportForm.addEventListener('submit', syncExportFilters);

        function openPatientModal() {
            form.reset();
            form.action = patientsStoreUrl;
            methodField.value = '';
            document.getElementById('modalTitle').textContent = 'Add patient';
            document.getElementById('submitButton').textContent = 'Add patient';
            modal.showModal();
        }

        function editPatient(patient) {
            form.action = '/patients/' + patient.id;

            methodField.value = 'PUT';
            document.getElementById('patient_code').value = patient.patient_code || '';
            document.getElementById('age').value = patient.age ?? '';
            form.querySelector('[name="age_unit"]').value = patient.age_unit || 'years';

            document.getElementById('gender').value = patient.gender || '';
            document.getElementById('disease').value = patient.disease || '';
            document.getElementById('date_onset').value = patient.date_onset
                    ? patient.date_onset.substring(0, 10) : '';
            document.getElementById('modalTitle').textContent = 'Edit patient';
            document.getElementById('submitButton').textContent = 'Save changes';
            modal.showModal();
        }

        function closePatientModal() {
            modal.close();
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