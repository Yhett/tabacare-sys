<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patient Review | TABACARE</title>
    <style>
        .sidebar { position: sticky; top: 0; height: 100vh; }
        :root { --ink:#1d2935; --muted:#70808b; --paper:#f4f7f8; --panel:#fff; --line:#e1e8eb; --teal:#0f766e; --teal-light:#e6f6f3; --nav:#172331; --shadow:0 14px 36px rgba(27,45,61,.08); }
        * { box-sizing:border-box; } body { margin:0; background:var(--paper); color:var(--ink); font-family:Georgia,'Times New Roman',serif; } button,input,select { font:inherit; }
        .shell { min-height:100vh; display:grid; grid-template-columns:260px 1fr; } .sidebar { display:flex; flex-direction:column; min-height:100vh; padding:22px 13px; background:var(--nav); color:#d9e3ea; }
        .brand { display:flex; align-items:center; gap:11px; padding:5px 12px 28px; border-bottom:1px solid rgba(255,255,255,.08); } .mark { width:38px; height:38px; display:grid; place-items:center; border:1px solid rgba(255,255,255,.4); border-radius:10px; color:#70ddd0; font:24px Arial,sans-serif; } .brand strong { display:block; color:#fff; font:800 16px Arial,sans-serif; letter-spacing:.08em; } .brand small { color:#91a7b5; font:10px Arial,sans-serif; letter-spacing:.08em; text-transform:uppercase; }
        .label { padding:25px 12px 9px; color:#8094a2; font:700 10px Arial,sans-serif; letter-spacing:.13em; text-transform:uppercase; } .nav { display:grid; gap:5px; } .nav a { display:flex; align-items:center; gap:11px; padding:12px; border-radius:8px; color:#aabac5; text-decoration:none; font:600 14px Arial,sans-serif; } .nav a:hover,.nav a.active { background:rgba(20,184,166,.14); color:#6ee7d8; } .nav-icon { width:20px; text-align:center; font-family:Arial,sans-serif; } .side-footer { margin-top:auto; padding:16px 12px 4px; border-top:1px solid rgba(255,255,255,.08); color:#8da1ad; font:12px/1.5 Arial,sans-serif; }
        .main { min-width:0; padding:30px clamp(20px,4vw,58px) 48px; } .topbar { display:flex; justify-content:space-between; align-items:flex-start; gap:20px; margin-bottom:28px; } .eyebrow { color:var(--teal); font:700 11px Arial,sans-serif; letter-spacing:.16em; text-transform:uppercase; } h1 { margin:7px 0 6px; font-size:clamp(28px,4vw,40px); font-weight:400; } .intro { margin:0; color:var(--muted); font-size:16px; } .profile { display:flex; align-items:center; gap:10px; color:var(--muted); font:13px Arial,sans-serif; white-space:nowrap; } .avatar { width:39px; height:39px; display:grid; place-items:center; border-radius:50%; background:#f2d18b; color:#65491a; font-weight:700; }
        .alert { margin-bottom:16px; padding:12px 15px; border:1px solid; border-radius:4px; font:13px Arial,sans-serif; } .success { border-color:#bde5cd; background:#effaf3; color:#19683d; } .error { border-color:#f3c7c0; background:#fff4f2; color:#9d3d2f; }
        .panel { overflow:hidden; background:var(--panel); border:1px solid var(--line); box-shadow:var(--shadow); } .panel-head { display:flex; justify-content:space-between; align-items:center; gap:15px; padding:20px; border-bottom:1px solid var(--line); } h2 { margin:0; font-size:20px; font-weight:400; } .count { color:var(--muted); font:12px Arial,sans-serif; }
        .filters { display:flex; align-items:end; gap:13px; padding:17px 20px; background:#fbfdfc; border-bottom:1px solid var(--line); } .field { display:grid; gap:6px; min-width:220px; } label { color:var(--muted); font:700 10px Arial,sans-serif; letter-spacing:.1em; text-transform:uppercase; } select { min-height:40px; padding:8px 10px; border:1px solid var(--line); border-radius:4px; background:#fff; } .button { min-height:40px; padding:0 15px; border:0; border-radius:4px; background:var(--teal); color:#fff; cursor:pointer; font:700 12px Arial,sans-serif; } .button.secondary { background:#eaf2f0; color:var(--teal); text-decoration:none; display:inline-flex; align-items:center; }
        .table-wrap { overflow:auto; max-height:calc(100vh - 360px); min-height:240px; }
        table { width:100%; min-width:980px; border-collapse:separate; border-spacing:0; font:13px/1.45 Arial,sans-serif; }
        thead { position:sticky; top:0; z-index:1; }
        th { padding:14px 16px; background:#173b58; color:#e9f4f7; text-align:left; font:700 10px Arial,sans-serif; letter-spacing:.1em; text-transform:uppercase; white-space:nowrap; }
        th:first-child { border-radius:5px 0 0 0; }
        th:last-child { border-radius:0 5px 0 0; }
        td { padding:13px 16px; border-bottom:1px solid #edf1f3; color:#354451; white-space:nowrap; transition:background .15s ease; }
        tbody tr:nth-child(even) { background:#f8fbfc; }
        tbody tr:hover { background:#eaf6f4; }
        td:first-child { color:#116e68; font-weight:700; }
        td:last-child,th:last-child { text-align:right; }
        .record-code,.disease-tag,.gender-tag { display:inline-flex; align-items:center; border-radius:999px; padding:5px 9px; font:700 11px Arial,sans-serif; }
        .record-code { background:#e7f3f5; color:#235a70; }
        .disease-tag { background:#e5f5ef; color:#17684e; }
        .gender-tag { min-width:54px; justify-content:center; background:#f0edff; color:#55439a; }
        .empty { padding:55px 20px; color:var(--muted); text-align:center; }
        .note { display:flex; justify-content:space-between; align-items:center; gap:16px; padding:14px 20px; border-top:1px solid var(--line); color:var(--muted); font:12px Arial,sans-serif; }
        dialog { width:min(500px,calc(100% - 30px)); padding:0; border:0; border-radius:7px; box-shadow:0 25px 80px rgba(24,48,59,.25); } dialog::backdrop { background:rgba(24,48,59,.34); } .modal-head { display:flex; justify-content:space-between; padding:22px 24px 15px; border-bottom:1px solid var(--line); } .close { border:0; background:transparent; color:var(--muted); cursor:pointer; font-size:24px; } .modal-body { display:grid; gap:13px; padding:22px 24px 24px; } .modal-actions { display:flex; justify-content:flex-end; gap:10px; margin-top:5px; } input { min-height:40px; padding:8px 10px; border:1px solid var(--line); border-radius:4px; }
        @media(max-width:900px){ .shell{grid-template-columns:1fr;} .sidebar{min-height:auto;padding:14px 18px;} .brand{padding:0 0 14px;border:0;} .label,.side-footer{display:none;} .nav{display:flex;overflow-x:auto;} .nav a{white-space:nowrap;} } @media(max-width:620px){ .topbar,.filters{display:block;} .profile{margin-top:17px;} .field,.filters .button{width:100%;margin-top:10px;} }
        .mark img{width:38px;height:38px;object-fit:contain;border-radius:10px;background:#fff}
    </style>
</head>
<body>
    <div class="shell">
        <aside class="sidebar"><div class="brand"><div class="mark"><img src="{{ asset('images/tabacare-logo.png') }}" alt="TABACARE logo"></div><div><strong>TABACARE</strong><small>Administration</small></div></div><div class="label">Management</div><nav class="nav"><a href="{{ route('admin.dashboard') }}"><span class="nav-icon">&#9632;</span> Dashboard</a><a href="{{ route('admin.accounts') }}"><span class="nav-icon">&#9673;</span> Barangay accounts</a><a href="{{ route('admin.reports') }}"><span class="nav-icon">&#9776;</span> Barangay reports</a><a href="{{ route('admin.statistics') }}"><span class="nav-icon">&#9646;</span> Disease statistics</a><a class="active" href="{{ route('admin.patients') }}"><span class="nav-icon">&#9998;</span> List of patients</a></nav><div class="side-footer">Administrator access<br><strong>{{ $adminName }}</strong><a href="{{ route('admin.admin-accounts.index') }}" style="display:block;margin-top:12px;padding:9px 10px;border-radius:6px;background:rgba(255,255,255,.08);color:#d9e3ea;text-decoration:none;font:600 12px Arial">Admin accounts</a><form method="POST" action="{{ route('logout') }}" style="margin-top:12px">@csrf<button type="submit" style="width:100%;padding:9px;border:1px solid #dcebea;border-radius:6px;background:transparent;color:#aabac5;cursor:pointer;font:600 12px Arial">Log out</button></form></div></aside>
        <main class="main">
            <header class="topbar">
                <div>
                    <div class="eyebrow">Patient review</div>
                        <h1>Added patients monitoring</h1>
                        <p class="intro">Health-center records added by administrators.</p>
                    </div>
                    <div class="profile">
                        <div class="avatar">{{ strtoupper(substr($adminName, 0, 1)) }}
                        </div>{{ $adminName }}
                    </div>
            </header>
            @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
            <div class="alert error">{{ $errors->first() }}</div>
            @endif
            <section class="panel">
                <div class="panel-head">
                    <h2>Added patients</h2>
                    <div>
                        <span class="count">{{ $patients->total() }} entries</span> 
                        <button class="button" type="button" onclick="openPatientModal()">+ Add patient</button>
                    </div>
                </div>
                <form class="filters" method="GET" action="{{ route('admin.patients') }}">
                    <div class="field">
                        <label for="filter_disease">Filter by disease</label>
                        <select id="filter_disease" name="filter_disease">
                            <option value="">All diseases</option>
                            @foreach($diseases as $disease)
                                <option value="{{ $disease }}" @selected($filterDisease === $disease)>{{ $disease }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="button" type="submit">Apply filters</button>
                    @if($filterDisease)
                        <a class="button secondary" href="{{ route('admin.patients') }}">Clear</a>
                    @endif
                </form>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Patient code</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Disease</th>
                                <th>Date of onset</th>
                                <th>Barangay</th>
                                <th>Added by</th>
                                <th>Date added</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patients as $patient)
                                <tr>
                                    <td><span class="record-code">{{ $patient->patient_code }}</span></td>
                                    <td>{{ $patient->age !== null ? $patient->age . ' ' . ($patient->age_unit ?? 'years') : '—' }}</td>
                                    <td><span class="gender-tag">{{ $patient->gender }}</span></td>
                                    <td><span class="disease-tag">{{ $patient->disease }}</span></td>
                                    <td>{{ $patient->date_onset?->format('d M Y') }}</td>
                                    <td>{{ $patient->address }}</td>
                                    <td>{{ $patient->addedBy?->username ?? 'Unknown' }}</td>
                                    <td>{{ $patient->created_at?->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="empty" colspan="8">No patients found for the selected filter.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="note">
                    Showing {{ $patients->firstItem() ?? 0 }} to {{ $patients->lastItem() ?? 0 }} patient record(s).
                    {{ $patients->links() }}
                </div>
            </section>
        </main>
    </div>
    <dialog id="patientModal">
        <div class="modal-head">
            <div>
                <div class="eyebrow">Health-center record</div>
                <h2>Add patient</h2>
            </div>
            <button class="close" type="button" onclick="patientModal.close()">&times;</button>
        </div>
        <form class="modal-body" method="POST" action="{{ route('admin.patients.store') }}">
            @csrf
            <input name="patient_code" placeholder="Patient code" required>
            <div style="display:grid;grid-template-columns:1fr 130px;gap:8px"><input name="age" type="number" min="0" max="150" placeholder="Age" required><select name="age_unit" aria-label="Age unit" required><option value="years">Years</option><option value="months">Months</option><option value="days">Days</option></select></div>
            <select name="gender" required>
                <option value="">Select gender</option>
                <option>Male</option>
                <option>Female</option>
            </select>
            <select name="disease" required>
                <option value="">Select disease</option>
                @foreach($diseases as $disease)
                    <option>{{ $disease }}</option>
                @endforeach
            </select>
            <input name="date_onset" type="date" required>
            <select name="address" required>
                <option value="">Select barangay</option>
                @foreach($barangays as $barangay)
                    <option>{{ $barangay }}</option>
                @endforeach
            </select>
            <div class="modal-actions">
                <button class="button secondary" type="button" onclick="patientModal.close()">Cancel</button>
                <button class="button" type="submit">Add patient</button>
            </div>
        </form>
    </dialog>
    <script>
        const patientModal = document.getElementById('patientModal');
        function openPatientModal() {
            patientModal.showModal();
        }
    </script>
@include('partials.submit-guard')
</body>
</html>
