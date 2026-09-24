<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barangay Accounts | TABACARE</title>

    <style>
        :root {
            --ink: #1d2935;
            --muted: #70808b;
            --paper: #f4f7f8;
            --panel: #fff;
            --line: #e1e8eb;
            --teal: #0f766e;
            --nav: #172331;
            --shadow: 0 14px 36px rgba(27,45,61,.08);
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

        button, input, select {
            font: inherit;
        }

        /* MAIN LAYOUT */

        .shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
        }

        /* SIDEBAR */

        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 22px 13px;
            background: var(--nav);
            color: #d9e3ea;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 5px 12px 28px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .mark {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(255,255,255,.4);
            border-radius: 10px;
            color: #70ddd0;
            font: 24px Arial, sans-serif;
        }

        .brand strong {
            display: block;
            color: #fff;
            font: 800 16px Arial, sans-serif;
            letter-spacing: .08em;
        }

        .brand small {
            color: #91a7b5;
            font: 10px Arial, sans-serif;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .label {
            padding: 25px 12px 9px;
            color: #8094a2;
            font: 700 10px Arial, sans-serif;
            letter-spacing: .13em;
            text-transform: uppercase;
        }

        .nav {
            display: grid;
            gap: 5px;
        }

        .nav a {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 12px;
            border-radius: 8px;
            color: #aabac5;
            text-decoration: none;
            font: 600 14px Arial, sans-serif;
        }

        .nav a:hover,
        .nav a.active {
            background: rgba(20,184,166,.14);
            color: #6ee7d8;
        }

        .nav-icon {
            width: 20px;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .side-footer {
            margin-top: auto;
            padding: 16px 12px 4px;
            border-top: 1px solid rgba(255,255,255,.08);
            color: #8da1ad;
            font: 12px/1.5 Arial, sans-serif;
        }

        /*  MAIN */

        .main {
            min-width: 0;
            width: 100%;
            padding: 30px clamp(20px, 4vw, 58px) 48px;
        }

        .topbar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 28px;
        }

        .eyebrow {
            color: var(--teal);
            font: 700 11px Arial, sans-serif;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        h1 {
            margin: 7px 0 6px;
            font-size: clamp(28px, 4vw, 40px);
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

        /* PANELS */

        .panel {
            width: 100%;
            margin-bottom: 18px;
            padding: 22px;
            background: var(--panel);
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
        }

        h2 {
            margin: 0 0 17px;
            font-size: 20px;
            font-weight: 400;
        }

        /* CREATE ACCOUNT */

        .create-grid {
            width: 100%;
            display: grid;
            grid-template-columns:
                minmax(0, 1fr)
                minmax(0, 1fr)
                minmax(0, 1fr)
                auto;
            gap: 12px;
            align-items: end;
        }

        label {
            display: grid;
            gap: 6px;
            color: var(--muted);
            font: 700 10px Arial, sans-serif;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        input,
        select {
            min-height: 42px;
            width: 100%;
            padding: 9px 11px;
            border: 1px solid var(--line);
            border-radius: 4px;
            background: #fbfdfc;
            color: var(--ink);
            outline: none;
        }

        input:focus,
        select:focus {
            border-color: var(--teal);
        }

        .button {
            min-height: 42px;
            padding: 0 18px;
            border: 0;
            border-radius: 4px;
            background: var(--teal);
            color: #fff;
            cursor: pointer;
            font: 700 12px Arial, sans-serif;
            white-space: nowrap;
        }

        .button:hover {
            opacity: .9;
        }

        .button.danger {
            background: #c94e46;
        }

        /* ALERTS */

        .alert {
            margin-bottom: 16px;
            padding: 12px 15px;
            border: 1px solid;
            border-radius: 4px;
            font: 13px Arial, sans-serif;
        }

        .success {
            border-color: #bde5cd;
            background: #effaf3;
            color: #19683d;
        }

        .error {
            border-color: #f3c7c0;
            background: #fff4f2;
            color: #9d3d2f;
        }

        /* BARANGAY CARDS */

        .barangay-grid {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(220px, 1fr)
            );
            gap: 13px;
        }

        .barangay {
            min-width: 0;
            padding: 15px;
            border: 1px solid var(--line);
            border-radius: 5px;
            background: #fbfdfc;
        }

        .barangay h3 {
            margin: 0 0 10px;
            color: var(--teal);
            font: 700 14px Arial, sans-serif;
        }

        .worker {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            padding: 9px 0;
            border-top: 1px solid #edf2f3;
            font: 13px Arial, sans-serif;
        }

        .worker strong {
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .worker small {
            color: var(--muted);
            white-space: nowrap;
        }

        .worker-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .empty {
            color: var(--muted);
            font: 12px Arial, sans-serif;
        }

        .edit {
            border: 0;
            padding: 0;
            color: var(--teal);
            background: transparent;
            cursor: pointer;
            font: 700 12px Arial, sans-serif;
        }

        .delete {
            border: 0;
            padding: 0;
            color: #b24b40;
            background: transparent;
            cursor: pointer;
            font: 700 12px Arial, sans-serif;
        }

        .delete:hover,
        .edit:hover {
            text-decoration: underline;
        }

        .password-field {
            position: relative;
        }

        .password-field input {
            padding-right: 72px;
        }

        .toggle-password {
            position: absolute;
            right: 9px;
            bottom: 11px;
            border: 0;
            padding: 2px;
            background: transparent;
            color: var(--teal);
            cursor: pointer;
            font: 700 11px Arial, sans-serif;
        }

        .modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 10;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(15, 28, 38, .55);
        }

        .modal-backdrop.open {
            display: flex;
        }

        .modal {
            width: min(520px, 100%);
            padding: 22px;
            background: #fff;
            box-shadow: var(--shadow);
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 18px;
        }

        .button.secondary {
            border: 1px solid var(--line);
            background: #fff;
            color: var(--ink);
        }

        .edit-grid {
            display: grid;
            gap: 14px;
        }


        @media (max-width: 950px) {

            .shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: relative;
                height: auto;
                min-height: auto;
                padding: 14px 18px;
            }

            .brand {
                padding: 0 0 14px;
                border: 0;
            }

            .label,
            .side-footer {
                display: none;
            }

            .nav {
                display: flex;
                overflow-x: auto;
                gap: 5px;
            }

            .nav a {
                white-space: nowrap;
            }

            .create-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 620px) {

            .main {
                padding: 22px 15px 35px;
            }

            .topbar {
                display: block;
            }

            .profile {
                margin-top: 17px;
            }

            .create-grid {
                display: block;
            }

            .create-grid label,
            .create-grid .button {
                margin-top: 11px;
            }

            .panel {
                padding: 16px;
            }

            .barangay-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="shell">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="brand">
            <div class="mark">+</div>

            <div>
                <strong>TABACARE</strong>
                <small>Administration</small>
            </div>
        </div>

        <div class="label">Management</div>

        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}"><span class="nav-icon">&#9632;</span>Dashboard</a>
            <a class="active" href="{{ route('admin.accounts') }}"><span class="nav-icon">&#9673;</span>Barangay accounts</a>
            <a href="{{ route('admin.reports') }}"><span class="nav-icon">&#9776;</span>Barangay reports</a>
            <a href="{{ route('admin.statistics') }}"><span class="nav-icon">&#9646;</span>Disease statistics</a>
            <a href="{{ route('admin.patients') }}"><span class="nav-icon">&#9998;</span>List of patients</a>

        </nav>

        <div class="side-footer">

            Administrator access<br>

            <strong>{{ $adminName }}</strong>

            <a href="{{ route('admin.admin-accounts.index') }}" style="display:block;margin-top:12px;padding:9px 10px;border-radius:6px;background:rgba(255,255,255,.08);color:#d9e3ea;text-decoration:none;font:600 12px Arial">Admin accounts</a>

            <form method="POST" action="{{ route('logout') }}" style="margin-top:12px;">
                @csrf

                <button type="submit"
                    style="
                        width:100%;
                        padding:9px;
                        border:1px solid #dcebea;
                        border-radius:6px;
                        background:transparent;
                        color:#aabac5;
                        cursor:pointer;
                        font:600 12px Arial;
                    "
                >Log out</button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main">
        <!-- TOPBAR -->
        <header class="topbar">
            <div>
                <div class="eyebrow">Account management</div>
                <h1>Barangay accounts</h1>
                <p class="intro">Create and manage one health-worker account per barangay.</p>
            </div>

            <div class="profile">
                <div class="avatar">{{ strtoupper(substr($adminName, 0, 1)) }}</div>
                {{ $adminName }}
            </div>
        </header>

        <!-- SUCCESS MESSAGE -->
        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        <!-- ERROR MESSAGE -->
        @if($errors->any())
            <div class="alert error">{{ $errors->first() }}</div>
        @endif

        <!-- CREATE ACCOUNT -->
        <section class="panel">

            <h2>Create barangay health-worker account</h2>

            <form method="POST" action="{{ route('admin.accounts.store') }}" class="create-grid">

                @csrf

                <label>Username <input name="username" value="{{ old('username') }}" required></label>

                <label class="password-field">Password
                    <input name="password" type="password" required autocomplete="new-password">
                    <button class="toggle-password" type="button" aria-label="Show password" aria-pressed="false">Show</button>
                </label>

                <label>
                    Barangay
                    <select name="barangay" required>
                        <option value="">Select barangay</option>

                        @foreach($barangays as $barangay)
                            <option value="{{ $barangay }}" @selected(old('barangay') === $barangay)>{{ $barangay }}</option>
                        @endforeach
                    </select>
                </label>

                <button class="button" type="submit">Create account</button>

            </form>
        </section>

        <!-- ACCOUNTS BY BARANGAY -->
        <section class="panel">
            <h2>Accounts by barangay</h2>
            <div class="barangay-grid">
                @foreach($barangayWorkers as $barangay => $workers)
                    <div class="barangay">
                        <h3>{{ $barangay }}</h3>

                        @forelse($workers as $worker)
                            <div class="worker">
                                <strong>{{ $worker->username }}</strong>
                                <div class="worker-actions">
                                    <small>{{ $worker->last_active?->format('Y-m-d H:i') ?? 'Never' }}</small>
                                    <button class="edit" type="button"
                                        data-edit-account
                                        data-action="{{ route('admin.accounts.update', $worker) }}"
                                        data-username="{{ $worker->username }}"
                                        data-barangay="{{ $worker->barangay }}"
                                    >Edit</button>
                                    <form method="POST" action="{{ route('admin.accounts.destroy', $worker) }}"
                                        onsubmit="return confirm('Delete this barangay account?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="delete" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                        <span class="empty">No assigned account</span>
                        @endforelse
                    </div>
                @endforeach
            </div>
        </section>

    </main>
</div>

<div class="modal-backdrop" id="edit-account-modal" role="dialog" aria-modal="true" aria-labelledby="edit-account-title">
    <section class="modal">
        <h2 id="edit-account-title">Edit barangay account</h2>
        <form method="POST" id="edit-account-form" class="edit-grid">
            @csrf
            @method('PATCH')
            <label>Username <input name="username" id="edit-username" required></label>
            <label>
                Barangay
                <select name="barangay" id="edit-barangay" required>
                    @foreach($barangays as $barangay)
                        <option value="{{ $barangay }}">{{ $barangay }}</option>
                    @endforeach
                </select>
            </label>
            <label class="password-field">New password <span>(leave blank to keep current)</span>
                <input name="password" id="edit-password" type="password" autocomplete="new-password">
                <button class="toggle-password" type="button" aria-label="Show password" aria-pressed="false">Show</button>
            </label>
            <div class="modal-actions">
                <button class="button secondary" type="button" id="cancel-edit">Cancel</button>
                <button class="button" type="submit">Save changes</button>
            </div>
        </form>
    </section>
</div>

<script>
    document.querySelectorAll('[data-edit-account]').forEach((button) => {
        button.addEventListener('click', () => {
            document.getElementById('edit-account-form').action = button.dataset.action;
            document.getElementById('edit-username').value = button.dataset.username;
            document.getElementById('edit-barangay').value = button.dataset.barangay;
            document.getElementById('edit-password').value = '';
            document.getElementById('edit-account-modal').classList.add('open');
            document.getElementById('edit-username').focus();
        });
    });

    const closeEditModal = () => document.getElementById('edit-account-modal').classList.remove('open');
    document.getElementById('cancel-edit').addEventListener('click', closeEditModal);
    document.getElementById('edit-account-modal').addEventListener('click', (event) => {
        if (event.target.id === 'edit-account-modal') closeEditModal();
    });
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape') closeEditModal(); });

    document.querySelectorAll('.toggle-password').forEach((button) => {
        button.addEventListener('click', () => {
            const input = button.parentElement.querySelector('input');
            const showing = input.type === 'password';
            input.type = showing ? 'text' : 'password';
            button.textContent = showing ? 'Hide' : 'Show';
            button.setAttribute('aria-label', showing ? 'Hide password' : 'Show password');
            button.setAttribute('aria-pressed', String(showing));
        });
    });
</script>

@include('partials.submit-guard')
</body>
</html>

