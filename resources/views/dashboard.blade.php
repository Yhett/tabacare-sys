<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TABACARE Dashboard</title>
    <style>
        :root {
            --ink: #18303b;
            --muted: #6c7f86;
            --paper: #f6f8f5;
            --panel: #ffffff;
            --line: #dce6e1;
            --teal: #087f78;
            --teal-dark: #075c5a;
            --coral: #e9795d;
            --gold: #d9a441;
            --shadow: 0 14px 40px rgba(24, 48, 59, .08);
        }

        * { box-sizing: border-box; }
        body { margin: 0; background: var(--paper); color: var(--ink); font-family: Georgia, 'Times New Roman', serif; }
        button, select { font: inherit; }
        .shell { min-height: 100vh; display: grid; grid-template-columns: 246px 1fr; }
        .sidebar { background: var(--teal-dark); color: #e9f6f0; padding: 28px 18px; display: flex; flex-direction: column; }
        .brand { display: flex; align-items: center; gap: 10px; padding: 0 12px 34px; }
        .brand-mark { width: 38px; height: 38px; display: grid; place-items: center; border: 1px solid rgba(255,255,255,.38); border-radius: 50%; color: #f4c96f; font-size: 22px; }
        .brand strong { display: block; font-size: 16px; letter-spacing: .08em; }
        .brand small { color: #a9d2c9; font: 11px Arial, sans-serif; letter-spacing: .08em; text-transform: uppercase; }
        .nav-label { padding: 0 12px 10px; color: #8dbbb2; font: 11px Arial, sans-serif; letter-spacing: .13em; text-transform: uppercase; }
        .nav a { display: flex; align-items: center; gap: 11px; padding: 12px; border-radius: 7px; color: #c9e5dc; text-decoration: none; font-size: 15px; }
        .nav a:hover, .nav a.active { background: rgba(255,255,255,.12); color: #fff; }
        .nav-icon { width: 19px; text-align: center; font-family: Arial, sans-serif; }
        .sidebar-footer { margin-top: auto; padding: 16px 12px 4px; border-top: 1px solid rgba(255,255,255,.14); color: #a9d2c9; font: 12px Arial, sans-serif; line-height: 1.5; }
        .main { min-width: 0; padding: 30px clamp(20px, 4vw, 58px) 48px; }
        .topbar { display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; margin-bottom: 34px; }
        .eyebrow { color: var(--teal); font: 11px Arial, sans-serif; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
        h1 { margin: 7px 0 6px; font-size: clamp(28px, 4vw, 42px); font-weight: 400; letter-spacing: -.02em; }
        .intro { margin: 0; color: var(--muted); font-size: 16px; }
        .profile { display: flex; align-items: center; gap: 11px; color: var(--muted); font: 13px Arial, sans-serif; white-space: nowrap; }
        .avatar { width: 39px; height: 39px; display: grid; place-items: center; border-radius: 50%; background: #f3d28d; color: #604416; font-weight: 700; }
        .filters { display: flex; align-items: end; gap: 14px; padding: 15px 18px; margin-bottom: 22px; background: var(--panel); border: 1px solid var(--line); box-shadow: var(--shadow); }
        .filter { display: grid; gap: 6px; min-width: 190px; }
        .filter label { color: var(--muted); font: 10px Arial, sans-serif; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        select { width: 100%; padding: 10px 12px; border: 1px solid var(--line); border-radius: 4px; color: var(--ink); background: #fbfdfb; }
        .reset { margin-left: auto; padding: 10px 13px; border: 0; background: transparent; color: var(--teal); cursor: pointer; font: 12px Arial, sans-serif; font-weight: 700; }
        .stat-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; margin-bottom: 26px; }
        .stat { padding: 20px; background: var(--panel); border: 1px solid var(--line); box-shadow: 0 7px 20px rgba(24,48,59,.04); }
        .stat.primary { background: var(--teal); border-color: var(--teal); color: #fff; }
        .stat-label { color: var(--muted); font: 11px Arial, sans-serif; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; }
        .primary .stat-label { color: #b9e0d5; }
        .stat-value { margin: 14px 0 7px; font-size: 35px; font-weight: 400; }
        .stat-note { color: var(--muted); font: 12px Arial, sans-serif; }
        .primary .stat-note { color: #d9f0e9; }
        .content-grid { display: grid; grid-template-columns: minmax(0, 1.45fr) minmax(280px, .85fr); gap: 18px; }
        .panel { padding: 23px; background: var(--panel); border: 1px solid var(--line); box-shadow: var(--shadow); }
        .panel-heading { display: flex; align-items: baseline; justify-content: space-between; gap: 15px; margin-bottom: 25px; }
        h2 { margin: 0; font-size: 20px; font-weight: 400; }
        .panel-heading span { color: var(--muted); font: 12px Arial, sans-serif; }
        .chart { display: grid; grid-template-columns: repeat(5, 1fr); align-items: end; gap: 14px; height: 235px; padding: 12px 0 0; border-bottom: 1px solid var(--line); }
        .bar-wrap { height: 100%; display: flex; flex-direction: column; justify-content: end; align-items: center; gap: 8px; }
        .bar-value { color: var(--muted); font: 11px Arial, sans-serif; }
        .bar { width: min(48px, 70%); min-height: 8px; height: calc(var(--value) * 1%); background: var(--teal); border-radius: 3px 3px 0 0; }
        .bar.coral { background: var(--coral); } .bar.gold { background: var(--gold); } .bar.blue { background: #5c91a5; } .bar.plum { background: #846d8e; }
        .bar-name { min-height: 30px; color: var(--muted); text-align: center; font: 11px Arial, sans-serif; line-height: 1.25; }
        .disease-list { display: grid; gap: 12px; }
        .disease-row { display: grid; grid-template-columns: 10px 1fr auto; align-items: center; gap: 10px; padding-bottom: 12px; border-bottom: 1px solid #edf2ef; }
        .dot { width: 9px; height: 9px; border-radius: 50%; background: var(--teal); }
        .dot.coral { background: var(--coral); } .dot.gold { background: var(--gold); } .dot.blue { background: #5c91a5; } .dot.plum { background: #846d8e; }
        .disease-name { font-size: 14px; } .disease-count { color: var(--muted); font: 12px Arial, sans-serif; }
        .table-panel { margin-top: 18px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { padding: 0 10px 12px; color: var(--muted); text-align: left; font: 10px Arial, sans-serif; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; }
        td { padding: 14px 10px; border-top: 1px solid #edf2ef; } td:last-child, th:last-child { text-align: right; }
        .status { display: inline-block; padding: 5px 8px; border-radius: 3px; background: #e4f3eb; color: #197050; font: 10px Arial, sans-serif; font-weight: 700; text-transform: uppercase; }
        .mobile-pc-notice {
    display: none;
    background: #e6f6f3;
    border: 1px solid #a7ddd5;
    color: #155e59;
    padding: 14px 18px;
    border-radius: 8px;
    font: 14px/1.5 Arial, sans-serif;
    margin-bottom: 20px;
}

.mobile-pc-notice strong {
    display: block;
    margin-bottom: 4px;
    font-size: 15px;
}

.mobile-pc-notice span {
    display: block;
}
/* MOBILE VIEW */
@media (max-width: 850px) {

    /* Hide sidebar */
    .sidebar {
        display: none;
    }

    .shell {
        grid-template-columns: 1fr;
    }

    /* Show mobile notice */
    .mobile-pc-notice {
        display: block;
    }

    .main {
        padding: 20px 16px 36px;
    }

    /* Dashboard header */
    .topbar {
        display: flex;
        flex-direction: column-reverse;
        gap: 16px;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .profile {
        border-bottom: 1px solid var(--line);
        padding-bottom: 14px;
        width: 100%;
    }

    /* Keep dashboard overview */
    .stat-grid {
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 20px;
    }

    .stat {
        padding: 14px;
    }

    .stat-value {
        font-size: 26px;
        margin: 8px 0 4px;
    }

    /* Hide filters and detailed system sections */
    .filters,
    #statistics,
    #reports,
    #patients {
        display: none !important;
    }

    h1 {
        font-size: 30px;
    }

    .intro {
        font-size: 14px;
    }
}
    </style>
</head>
<body>
    @php($initial = strtoupper(substr($worker, 0, 1)))

    <div class="shell">
        @include('partials.sidebar')

        <main class="main">
            <header class="topbar">
                <div>
                    <div class="eyebrow">Health worker workspace</div>
                    <h1> {{ $worker }}</h1>
                    <p class="intro">A clear view of health activity in {{ $barangay }}.</p>
                </div>
                <div class="profile"><div class="avatar">{{ $initial }}</div><span>{{ $worker }}<br><small>{{ $barangay }}</small></span></div>
            </header>

            <section class="filters" aria-label="Dashboard filters">
                <div class="filter"><label for="diseaseFilter">Disease type</label><select id="diseaseFilter"><option value="all">All diseases</option>@foreach($diseases as $disease)<option value="{{ $disease['name'] }}">{{ $disease['name'] }}</option>@endforeach</select></div>
                <div class="filter"><label for="periodFilter">Time period</label><select id="periodFilter"><option>All time</option><option>This month</option><option>Last 30 days</option></select></div>
                <button class="reset" type="button" id="resetFilters">Reset filters</button>
            </section>

            <section class="stat-grid" aria-label="Health summary">
                <article class="stat primary"><div class="stat-label">Total patients</div><div class="stat-value" id="totalPatients">{{ $totalPatients }}</div><div class="stat-note">Recorded in your barangay</div></article>
                <article class="stat"><div class="stat-label">This month</div><div class="stat-value">{{ $thisMonth }}</div><div class="stat-note">By date of onset</div></article>
                <article class="stat"><div class="stat-label">Added this week</div><div class="stat-value">{{ $lastSevenDays }}</div><div class="stat-note">New records</div></article>
                <article class="stat"><div class="stat-label">Disease types</div><div class="stat-value">{{ $diseaseTypes }}</div><div class="stat-note">With recorded cases</div></article>
            </section>

            <section class="content-grid" id="statistics">
                <article class="panel">
                    <div class="panel-heading"><h2>Cases by disease</h2><span>Current records</span></div>
                    <div class="chart" id="chart">@foreach($diseases as $disease)<div class="bar-wrap" data-disease="{{ $disease['name'] }}"><div class="bar-value">{{ $disease['count'] }}</div><div class="bar {{ $disease['color'] }}" style="--value: {{ round(($disease['count'] / $maxDiseaseCount) * 100) }}"></div><div class="bar-name">{{ $disease['name'] }}</div></div>@endforeach</div>
                </article>
                <article class="panel">
                    <div class="panel-heading"><h2>Disease mix</h2><span>{{ $totalPatients }} cases</span></div>
                    <div class="disease-list">@foreach($diseases as $disease)<div class="disease-row" data-disease="{{ $disease['name'] }}"><span class="dot {{ $disease['color'] }}"></span><span class="disease-name">{{ $disease['name'] }}</span><span class="disease-count">{{ $disease['count'] }} cases</span></div>@endforeach</div>
                </article>
            </section>

            <div id="reports"></div>
            <section class="panel table-panel" id="patients">
                <div class="panel-heading"><h2>Recent patient activity</h2><span>Last updated today</span></div>
                <table><thead><tr><th>Patient reference</th><th>Condition</th><th>Date of onset</th><th>Record added</th></tr></thead><tbody>@forelse($recentPatients as $patient)<tr><td>{{ $patient->patient_code }}</td><td>{{ $patient->disease }}</td><td>{{ $patient->date_onset?->format('d M Y') ?? '—' }}</td><td>{{ $patient->created_at?->format('d M Y') ?? '—' }}</td></tr>@empty<tr><td colspan="4">No patient records in {{ $barangay }} yet.</td></tr>@endforelse</tbody></table>
            </section>
        </main>
        <div class="mobile-pc-notice">
            <strong>&#9432; NOTICE</strong>
            <span>
            You are viewing the TABACARE Dashboard Overview.
            For full access to the system and management features,
            please use a PC or laptop.
            </span>
        </div>
    </div>

    <script>
        const diseaseFilter = document.getElementById('diseaseFilter');
        const rows = document.querySelectorAll('[data-disease]');
        const totalPatients = document.getElementById('totalPatients');
        const resetFilters = document.getElementById('resetFilters');
        const total = {{ $totalPatients }};
        diseaseFilter.addEventListener('change', function () {
            const selected = this.value;
            rows.forEach((row) => { row.hidden = selected !== 'all' && row.dataset.disease !== selected; });
            totalPatients.textContent = selected === 'all' ? total : document.querySelector('.disease-row[data-disease="' + selected + '"] .disease-count').textContent.split(' ')[0];
        });
        resetFilters.addEventListener('click', function () { diseaseFilter.value = 'all'; diseaseFilter.dispatchEvent(new Event('change')); document.getElementById('periodFilter').selectedIndex = 0; });
    </script>
@include('partials.submit-guard')
</body>
</html>
