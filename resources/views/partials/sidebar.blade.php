@php
    $sidebarBarangay = session('barangay', 'Not assigned');
    $workerName = session('user', 'Health Worker');
    $isDashboardPage = request()->routeIs('dashboard');
    $isPatientsPage = request()->routeIs('patients.*');
@endphp

<style>
    :root { --worker-sidebar-width: 270px; --worker-sidebar-border: #e5eeee; --worker-text: #183b3b; --worker-muted: #718686; --worker-teal: #0f766e; --worker-light: #e8f7f5; }
    .shell { display: block; }
    .main { margin-left: var(--worker-sidebar-width); }
    .worker-sidebar { position: fixed; inset: 0 auto 0 0; z-index: 1000; width: var(--worker-sidebar-width); display: flex; flex-direction: column; overflow: hidden; background: #fff; border-right: 1px solid var(--worker-sidebar-border); color: var(--worker-text); box-shadow: 3px 0 18px rgba(15,118,110,.05); transition: width .25s ease, transform .25s ease; }
    .worker-sidebar-brand { height: 82px; display: flex; align-items: center; justify-content: space-between; padding: 0 18px; border-bottom: 1px solid var(--worker-sidebar-border); }
    .worker-brand-link { display: flex; align-items: center; gap: 12px; color: inherit; text-decoration: none; }
    .worker-brand-logo { width: 46px; height: 46px; display: grid; place-items: center; overflow: hidden; border: 1px solid #cdebe7; border-radius: 12px; background: var(--worker-light); color: var(--worker-teal); font: 26px Arial, sans-serif; }
    .worker-brand-logo img { width: 42px; height: 42px; object-fit: contain; }
    .worker-brand-name { color: var(--worker-teal); font-size: 18px; font-weight: 800; letter-spacing: .8px; }
    .worker-brand-subtitle { margin-top: 2px; color: var(--worker-muted); font: 600 10px Arial, sans-serif; letter-spacing: .6px; text-transform: uppercase; }
    .worker-sidebar-toggle { width: 32px; height: 32px; display: grid; place-items: center; border: 1px solid #dcebea; border-radius: 8px; background: #fff; color: var(--worker-muted); cursor: pointer; }
    .worker-sidebar-toggle:hover { color: var(--worker-teal); background: var(--worker-light); }
    .worker-sidebar-toggle svg { width: 17px; height: 17px; transition: transform .25s ease; }
    .worker-sidebar-section { padding: 24px 12px 0; }
    .worker-sidebar-label { padding: 0 12px 10px; color: #8ba09f; font: 700 10px Arial, sans-serif; letter-spacing: 1.3px; }
    .worker-sidebar-nav { display: flex; flex-direction: column; gap: 5px; }
    .worker-nav-link { position: relative; min-height: 48px; display: flex; align-items: center; gap: 12px; padding: 0 12px; border-radius: 11px; color: var(--worker-muted); text-decoration: none; font: 600 14px Arial, sans-serif; transition: background .2s ease, color .2s ease, transform .2s ease; }
    .worker-nav-link:hover, .worker-nav-link.active { color: var(--worker-teal); background: var(--worker-light); }
    .worker-nav-link:hover { transform: translateX(2px); }
    .worker-nav-link.active { box-shadow: inset 3px 0 0 #149b8f; }
    .worker-nav-link.active::after { content: ''; position: absolute; right: 11px; width: 6px; height: 6px; border-radius: 50%; background: #149b8f; }
    .worker-nav-icon { width: 38px; height: 38px; display: grid; place-items: center; flex-shrink: 0; border-radius: 9px; }
    .worker-nav-link:hover .worker-nav-icon, .worker-nav-link.active .worker-nav-icon { background: rgba(20,155,143,.1); }
    .worker-nav-icon svg { width: 20px; height: 20px; }
    .worker-sidebar-spacer { flex: 1; }
    .worker-assignment { margin: 0 12px 12px; padding: 14px; border: 1px solid #d7ece9; border-radius: 13px; background: linear-gradient(145deg,#effaf8,#f7fbfa); }
    .worker-assignment-header { display: flex; align-items: center; gap: 10px; }
    .worker-assignment-icon { width: 36px; height: 36px; display: grid; place-items: center; flex-shrink: 0; border-radius: 9px; background: #dff4f1; color: var(--worker-teal); }
    .worker-assignment-icon svg { width: 19px; height: 19px; }
    .worker-assignment-kicker { margin-bottom: 3px; color: #7b9290; font: 700 9px Arial, sans-serif; letter-spacing: 1px; }
    .worker-assignment-name { max-width: 170px; overflow: hidden; color: #214746; font: 700 14px Arial, sans-serif; text-overflow: ellipsis; white-space: nowrap; }
    .worker-assignment-caption { display: flex; gap: 7px; margin-top: 11px; padding-top: 10px; border-top: 1px solid #dfefed; color: #819694; font: 10px/1.5 Arial, sans-serif; }
    .worker-assignment-caption svg { width: 13px; height: 13px; flex-shrink: 0; color: var(--worker-teal); }
    .worker-account { margin: 0 12px 10px; padding: 10px 12px; border: 1px solid #edf3f2; border-radius: 10px; background: #f8fbfb; }
    .worker-account-status { display: flex; align-items: center; gap: 9px; }
    .worker-status-dot { width: 8px; height: 8px; border-radius: 50%; background: #22a06b; box-shadow: 0 0 0 3px rgba(34,160,107,.1); }
    .worker-account-text { display: flex; flex-direction: column; gap: 1px; font-family: Arial, sans-serif; }
    .worker-account-title { color: #31504f; font-size: 11px; font-weight: 700; }
    .worker-account-subtitle { color: #8a9c9b; font-size: 9px; }
    .worker-sidebar-footer { padding: 10px 12px 15px; border-top: 1px solid var(--worker-sidebar-border); }
    .worker-logout { display: flex; align-items: center; gap: 12px; width: 100%; height: 44px; padding: 0 12px; border: 0; border-radius: 10px; background: transparent; color: #819392; cursor: pointer; text-align: left; font: 600 13px Arial, sans-serif; }
    .worker-logout:hover { color: #dc5555; background: #fff2f2; }
    .worker-logout-icon { width: 38px; height: 38px; display: grid; place-items: center; }
    .worker-logout-icon svg { width: 19px; height: 19px; }
    .worker-sidebar-version { padding-top: 7px; color: #9aacab; text-align: center; font: 8px Arial, sans-serif; letter-spacing: .8px; }
    .theme-toggle { display: flex; align-items: center; gap: 9px; width: 100%; margin: 0 0 10px; padding: 9px 12px; border: 1px solid #dcebea; border-radius: 8px; background: transparent; color: #718686; cursor: pointer; font: 600 12px Arial, sans-serif; }
    .theme-toggle:hover { background: #e8f7f5; color: #0f766e; }
    body.dark-mode { background: #101a21 !important; color: #dce7e7 !important; }
    body.dark-mode .main { background: #101a21 !important; color: #dce7e7 !important; }
    body.dark-mode .panel, body.dark-mode .table-panel, body.dark-mode .toolbar, body.dark-mode .preview, body.dark-mode .insight-card, body.dark-mode .summary-card { background: #18262e !important; border-color: #2b4148 !important; color: #dce7e7 !important; }
    body.dark-mode h1, body.dark-mode h2, body.dark-mode h3, body.dark-mode td, body.dark-mode .intro { color: #dce7e7 !important; }
    body.dark-mode th, body.dark-mode .count, body.dark-mode .summary-label, body.dark-mode .summary-note, body.dark-mode .chart-note { color: #9eb4b5 !important; }
    body.dark-mode input, body.dark-mode select { background: #101a21 !important; border-color: #385159 !important; color: #e5f1f0 !important; }
    body.dark-mode .table-panel td, body.dark-mode .table-panel th { border-color: #2b4148 !important; }
    body.dark-mode .theme-toggle { border-color: #385159; color: #b4c8c8; }
    body.dark-mode .worker-sidebar { background: #17252c; border-color: #2b4148; color: #dce7e7; }
    body.dark-mode .worker-sidebar-brand { border-color: #2b4148; }
    body.dark-mode .worker-brand-name, body.dark-mode .worker-nav-link.active, body.dark-mode .worker-nav-link:hover { color: #72ded1; }
    body.dark-mode .worker-brand-subtitle, body.dark-mode .worker-sidebar-label, body.dark-mode .worker-nav-link { color: #9eb4b5; }
    body.dark-mode .worker-nav-link.active, body.dark-mode .worker-nav-link:hover { background: #20383e; }
    body.dark-mode .worker-assignment, body.dark-mode .worker-account { background: #20383e; border-color: #385159; }
    body.dark-mode .worker-assignment-name, body.dark-mode .worker-account-title { color: #dce7e7; }
    .worker-sidebar.collapsed { width: 82px; }
    .worker-sidebar.collapsed .worker-brand-info, .worker-sidebar.collapsed .worker-sidebar-label, .worker-sidebar.collapsed .worker-nav-text, .worker-sidebar.collapsed .worker-assignment, .worker-sidebar.collapsed .worker-account-text, .worker-sidebar.collapsed .worker-sidebar-version { display: none; }
    .worker-sidebar.collapsed .worker-sidebar-brand { justify-content: center; padding: 0; }
    .worker-sidebar.collapsed .worker-sidebar-toggle { position: absolute; top: 25px; right: 7px; width: 24px; height: 24px; }
    .worker-sidebar.collapsed .worker-sidebar-toggle svg { transform: rotate(180deg); }
    .worker-sidebar.collapsed .worker-sidebar-section { padding: 24px 10px 0; }
    .worker-sidebar.collapsed .worker-nav-link { justify-content: center; padding: 0; }
    .worker-sidebar.collapsed .worker-nav-link.active::after { right: 5px; }
    .worker-sidebar.collapsed .worker-account { display: flex; justify-content: center; margin: 0 10px 10px; padding: 12px; }
    .worker-sidebar.collapsed .worker-logout { justify-content: center; padding: 0; }
    @media (max-width: 900px) { .worker-sidebar { transform: translateX(-100%); } .worker-sidebar.mobile-open { transform: translateX(0); box-shadow: 12px 0 35px rgba(0,0,0,.15); } .main { margin-left: 0 !important; } }
    @media (max-width: 480px) { .worker-sidebar { width: min(280px, 88vw); } .worker-sidebar-brand { height: 74px; } }
</style>

<aside class="worker-sidebar" id="workerSidebar" aria-label="Health worker navigation">
    <div class="worker-sidebar-brand">
        <a class="worker-brand-link" href="{{ route('dashboard') }}"><div class="worker-brand-logo"><img src="{{ asset('images/tabacare-logo.png') }}" alt="TABACARE logo"></div><div class="worker-brand-info"><div class="worker-brand-name">TABACARE</div><div class="worker-brand-subtitle">Health Unit Reporting</div></div></a>
        <button class="worker-sidebar-toggle" id="workerSidebarToggle" type="button" aria-label="Toggle sidebar" aria-expanded="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg></button>
    </div>
    <div class="worker-sidebar-section"><div class="worker-sidebar-label">WORKSPACE</div><nav class="worker-sidebar-nav">
        <a class="worker-nav-link {{ $isDashboardPage ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="worker-nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg></span><span class="worker-nav-text">Dashboard</span></a>
        <a class="worker-nav-link {{ $isPatientsPage ? 'active' : '' }}" href="{{ route('patients.index') }}"><span class="worker-nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span><span class="worker-nav-text">Patients</span></a>
        <a class="worker-nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.create') }}"><span class="worker-nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="13" y2="17"/></svg></span><span class="worker-nav-text">Generate Report</span></a>
    </nav></div>
    <div class="worker-sidebar-spacer"></div>
    <div class="worker-assignment"><div class="worker-assignment-header"><div class="worker-assignment-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg></div><div><div class="worker-assignment-kicker">ASSIGNED BARANGAY</div><div class="worker-assignment-name">{{ $sidebarBarangay }}</div></div></div><div class="worker-assignment-caption"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v4M12 16h.01"/></svg><span>Reports are limited to this area.</span></div></div>
    <div class="worker-account"><div class="worker-account-status"><span class="worker-status-dot"></span><div class="worker-account-text"><span class="worker-account-title">{{ $workerName }}</span><span class="worker-account-subtitle">Account active</span></div></div></div>
    <div class="worker-sidebar-footer"><button class="theme-toggle" id="workerThemeToggle" type="button">&#9790; <span>Dark mode</span></button><form method="POST" action="{{ route('logout') }}">@csrf<button class="worker-logout" type="submit"><span class="worker-logout-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></span><span class="worker-nav-text">Logout</span></button></form><div class="worker-sidebar-version">TABACARE • HEALTH ANALYTICS</div></div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('workerSidebar');
        const toggle = document.getElementById('workerSidebarToggle');
        if (!sidebar || !toggle) return;
        toggle.addEventListener('click', function () {
            const mobile = window.innerWidth <= 900;
            sidebar.classList.toggle(mobile ? 'mobile-open' : 'collapsed');
            toggle.setAttribute('aria-expanded', String(mobile ? sidebar.classList.contains('mobile-open') : !sidebar.classList.contains('collapsed')));
        });
        const themeButton = document.getElementById('workerThemeToggle');
        const applyTheme = function (dark) {
            document.body.classList.toggle('dark-mode', dark);
            if (themeButton) themeButton.innerHTML = dark ? '&#9728; <span>Light mode</span>' : '&#9790; <span>Dark mode</span>';
        };
        applyTheme(localStorage.getItem('tabacare-theme') === 'dark');
        themeButton?.addEventListener('click', function () {
            const dark = !document.body.classList.contains('dark-mode');
            localStorage.setItem('tabacare-theme', dark ? 'dark' : 'light');
            applyTheme(dark);
        });
    });
</script>
