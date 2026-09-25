<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Dashboard | TABACARE</title>

    <style>

        :root {
            --ink: #1d2935;
            --muted: #70808b;
            --paper: #f4f7f8;
            --panel: #fff;
            --line: #e1e8eb;
            --teal: #0f766e;
            --teal-light: #e6f6f3;
            --nav: #172331;
            --shadow: 0 14px 36px rgba(27, 45, 61, .08);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--paper);
            color: var(--ink);
            font-family: Georgia, "Times New Roman", serif;
        }

        button {
            font: inherit;
        }

        .admin-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
        }

        .admin-sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 22px 13px;
            background: var(--nav);
            color: #d9e3ea;
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 5px 12px 28px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .admin-mark {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .4);
            border-radius: 10px;
            color: #70ddd0;
            font: 24px Arial, sans-serif;
        }

        .admin-mark img {
            width: 34px;
            height: 34px;
            object-fit: contain;
        }

        .admin-brand strong {
            display: block;
            color: #fff;
            font: 800 16px Arial, sans-serif;
            letter-spacing: .08em;
        }

        .admin-brand small {
            color: #91a7b5;
            font: 10px Arial, sans-serif;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .admin-label {
            padding: 25px 12px 9px;
            color: #8094a2;
            font: 700 10px Arial, sans-serif;
            letter-spacing: .13em;
            text-transform: uppercase;
        }

        .admin-nav {
            display: grid;
            gap: 5px;
        }

        .admin-nav a {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 12px;
            border-radius: 8px;
            color: #aabac5;
            text-decoration: none;
            font: 600 14px Arial, sans-serif;
        }

        .admin-nav a:hover,
        .admin-nav a.active {
            background: rgba(20, 184, 166, .14);
            color: #6ee7d8;
        }

        .admin-icon {
            width: 20px;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .admin-footer {
            margin-top: auto;
            padding: 16px 12px 4px;
            border-top: 1px solid rgba(255, 255, 255, .08);
            color: #8da1ad;
            font: 12px/1.5 Arial, sans-serif;
        }

        .admin-main {
            min-width: 0;
            width: 100%;
            padding: 30px clamp(20px, 4vw, 58px) 48px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 31px;
        }

        .eyebrow {
            color: var(--teal);
            font: 700 11px Arial, sans-serif;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        h1 {
            margin: 7px 0 6px;
            font-size: clamp(28px, 4vw, 42px);
            font-weight: 400;
        }

        .intro {
            margin: 0;
            color: var(--muted);
            font-size: 16px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--muted);
            font: 13px Arial, sans-serif;
            white-space: nowrap;
        }

        .avatar {
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #f2d18b;
            color: #65491a;
            font-weight: 700;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 22px;
        }

        .stat {
            padding: 21px;
            background: var(--panel);
            border: 1px solid var(--line);
            box-shadow: 0 7px 20px rgba(27, 45, 61, .04);
        }

        .stat.primary {
            background: var(--teal);
            border-color: var(--teal);
            color: #fff;
        }

        .stat-label {
            color: var(--muted);
            font: 700 10px Arial, sans-serif;
            letter-spacing: .11em;
            text-transform: uppercase;
        }

        .primary .stat-label {
            color: #bce5dc;
        }

        .stat-value {
            margin: 14px 0 7px;
            font-size: 35px;
            font-weight: 400;
        }

        .stat-note {
            color: var(--muted);
            font: 12px Arial, sans-serif;
        }

        .primary .stat-note {
            color: #d9f3ec;
        }

        .content-grid {
            display: grid;
            grid-template-columns:
                minmax(0, 1.35fr)
                minmax(280px, .85fr);
            gap: 18px;
        }

        .panel {
            min-width: 0;
            padding: 23px;
            background: var(--panel);
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
        }

        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 12px;
            margin-bottom: 20px;
        }

        h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 400;
        }

        .panel-heading span {
            color: var(--muted);
            font: 12px Arial, sans-serif;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 650px;
            border-collapse: collapse;
            font-size: 14px;
        }

        th {
            padding: 0 10px 12px;
            color: var(--muted);
            text-align: left;
            font: 700 10px Arial, sans-serif;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        td {
            padding: 13px 10px;
            border-top: 1px solid #edf2f3;
            white-space: nowrap;
        }

        td:last-child,
        th:last-child {
            text-align: right;
        }

        .worker-name {
            color: var(--teal);
            font-weight: 700;
        }

        .status {
            display: inline-block;
            padding: 5px 8px;
            border-radius: 3px;
            background: #e3f4ec;
            color: #197050;
            font: 700 10px Arial, sans-serif;
            text-transform: uppercase;
        }
/* MOBILE EXCLUSIVE DISPLAY NOTICE & SWITCHER */
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

    .admin-shell {
        grid-template-columns: 1fr;
    }

    /* Hide sidebar */
    .admin-sidebar {
        display: none;
    }

    /* Show PC/Laptop message */
    .mobile-pc-notice {
        display: block;
    }

    /* Hide full system sections */
    .content-grid,
    #reports {
        display: none !important;
    }

    /* Keep only dashboard overview/statistics */
    .stat-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-bottom: 20px;
    }

    .stat {
        padding: 16px;
    }

    .stat-value {
        font-size: 25px;
    }

    .topbar {
        flex-direction: column;
        gap: 12px;
        margin-bottom: 20px;
    }

    .profile {
        align-self: flex-start;
    }

    .admin-main {
        padding: 20px 16px 35px;
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
    <div class="admin-shell">

        <!-- SIDEBAR -->
        <aside class="admin-sidebar">

            <div class="admin-brand">
                <div class="admin-mark">
                    <img src="{{ asset('images/tabacare-logo.png') }}" alt="TABACARE logo">
                </div>

                <div>
                    <strong>TABACARE</strong>
                    <small>Administration</small>
                </div>

            </div>

            <div class="admin-label">Management</div>

            <nav class="admin-nav">
                <a class="active" href="{{ route('admin.dashboard') }}"><span class="admin-icon">&#9632;</span>Dashboard</a>
                <a href="{{ route('admin.accounts') }}"><span class="admin-icon">&#9673;</span>Barangay accounts</a>
                <a href="{{ route('admin.reports') }}"><span class="admin-icon">&#9776;</span>Barangay reports</a>
                <a href="{{ route('admin.statistics') }}"><span class="admin-icon">&#9646;</span>Disease statistics</a>
                <a href="{{ route('admin.patients') }}"><span class="admin-icon">&#9998;</span>Patient records</a>
            </nav>


            <div class="admin-footer">Administrator access<br>
                <strong>{{ $adminName }}</strong>
                <a href="{{ route('admin.admin-accounts.index') }}" style="display:block;margin-top:12px;padding:9px 10px;border-radius:6px;background:rgba(255,255,255,.08);color:#d9e3ea;text-decoration:none;font:600 12px Arial">Admin accounts</a>
                <form method="POST" action="{{ route('logout') }}" style="margin-top:12px">

                    @csrf

                    <button type="submit"
                        style="
                            width:100%;
                            padding:9px;
                            border:1px solid rgba(255,255,255,.18);
                            border-radius:6px;
                            background:transparent;
                            color:#aabac5;
                            cursor:pointer;
                            font:600 12px Arial;
                        "
                    >
                    Log out
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="admin-main">

            <!-- TOP BAR -->
            <header class="topbar">
                <div>
                    <div class="eyebrow">Administration workspace</div>
                    <h1>Admin dashboard</h1>
                    <p class="intro">A city-wide view of TABACARE activity.</p>
                </div>

                <div class="profile">
                    <div class="avatar">{{ strtoupper(substr($adminName, 0, 1)) }}</div>
                    {{ $adminName }}
                </div>
            </header>

            <!-- STATISTICS -->
            <section class="stat-grid" aria-label="Administrative summary">
                <article class="stat primary">
                    <div class="stat-label">Total patients</div>
                    <div class="stat-value">{{ $totalPatients }}</div>
                    <div class="stat-note">Across all barangays</div>
                </article>

                <article class="stat">
                    <div class="stat-label">Barangay Accounts</div>
                    <div class="stat-value">{{ $totalWorkers }}</div>
                    <div class="stat-note">Registered accounts</div>
                </article>

                <article class="stat">
                    <div class="stat-label">New this week</div>
                    <div class="stat-value">{{ $recentCount }}</div>
                    <div class="stat-note">Patient records added</div>
                </article>

                <article class="stat">
                    <div class="stat-label">Barangays covered</div>
                    <div class="stat-value">{{ $barangayCount }}</div>
                    <div class="stat-note">Active accounts</div>
                </article>
            </section>

            <!-- CONTENT -->
            <section class="content-grid">

                <!-- RECENT WORKERS -->
                <article class="panel" id="workers">
                    <div class="panel-heading">
                        <h2>Recent worker activity</h2>
                        <span>Latest sign-ins</span>
                    </div>

                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Barangay</th>
                                    <th>Last active</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($recentWorkers as $worker)
                                    <tr>
                                        <td class="worker-name">{{ $worker->username }}</td>
                                        <td>{{ $worker->barangay ?: 'Not assigned' }}</td>
                                        <td>{{ $worker->last_active?->format('d M Y, H:i') ?: 'Never' }}</td>
                                        <td><span class="status">Active</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No accounts found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </article>

            </section>

            <!-- REPORTING CENTER -->
            <section class="panel" id="reports" style="margin-top:18px">
                <div class="panel-heading">
                    <h2>Reporting center</h2>
                    <span>System overview</span>
                </div>
                <p class="intro"> {{ $totalPatients }} patient records are currently available across {{ $barangayCount }} barangay areas.</p>
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


@include('partials.submit-guard')
</body>
</html>

