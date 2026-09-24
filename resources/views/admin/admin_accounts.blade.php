<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Accounts | TABACARE</title>
    <style>
        :root{--ink:#1d2935;--muted:#70808b;--paper:#f4f7f8;--panel:#fff;--line:#e1e8eb;--teal:#0f766e;--nav:#172331;--shadow:0 14px 36px rgba(27,45,61,.08)}
        *{box-sizing:border-box}body{margin:0;background:var(--paper);color:var(--ink);font-family:Georgia,'Times New Roman',serif}.shell{min-height:100vh;display:grid;grid-template-columns:260px minmax(0,1fr)}
        .sidebar{position:sticky;top:0;height:100vh;display:flex;flex-direction:column;padding:22px 13px;background:var(--nav);color:#d9e3ea}.brand{display:flex;align-items:center;gap:11px;padding:5px 12px 28px;border-bottom:1px solid rgba(255,255,255,.08)}.mark{width:38px;height:38px;display:grid;place-items:center;overflow:hidden;border-radius:10px;background:#fff}.mark img{width:38px;height:38px;object-fit:contain}.brand strong{display:block;color:#fff;font:800 16px Arial;letter-spacing:.08em}.brand small{color:#91a7b5;font:10px Arial;letter-spacing:.08em;text-transform:uppercase}.label{padding:25px 12px 9px;color:#8094a2;font:700 10px Arial;letter-spacing:.13em;text-transform:uppercase}.nav{display:grid;gap:5px}.nav a{display:flex;align-items:center;gap:11px;padding:12px;border-radius:8px;color:#aabac5;text-decoration:none;font:600 14px Arial}.nav a:hover,.nav a.active{background:rgba(20,184,166,.14);color:#6ee7d8}.nav-icon{width:20px;text-align:center}.side-footer{margin-top:auto;padding:16px 12px 4px;border-top:1px solid rgba(255,255,255,.08);color:#8da1ad;font:12px/1.5 Arial}
        .main{min-width:0;padding:30px clamp(20px,4vw,58px) 48px}.topbar{display:flex;justify-content:space-between;gap:20px;margin-bottom:28px}.eyebrow{color:var(--teal);font:700 11px Arial;letter-spacing:.16em;text-transform:uppercase}h1{margin:7px 0 6px;font-size:clamp(28px,4vw,40px);font-weight:400}.intro{margin:0;color:var(--muted);font-size:16px}.profile{display:flex;align-items:center;gap:10px;color:var(--muted);font:13px Arial}.avatar{width:39px;height:39px;display:grid;place-items:center;border-radius:50%;background:#f2d18b;color:#65491a;font-weight:700}
        .panel{margin-bottom:18px;padding:22px;background:var(--panel);border:1px solid var(--line);box-shadow:var(--shadow)}h2{margin:0 0 9px;font-size:20px;font-weight:400}.hint{margin:0 0 18px;color:var(--muted);font:13px/1.5 Arial}.form-grid{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr) auto;align-items:end;gap:12px}label{display:grid;gap:6px;color:var(--muted);font:700 10px Arial;letter-spacing:.1em;text-transform:uppercase}input{width:100%;min-height:42px;padding:9px 11px;border:1px solid var(--line);border-radius:4px;background:#fbfdfc;color:var(--ink);font:14px Arial}.button{min-height:42px;padding:0 18px;border:0;border-radius:4px;background:var(--teal);color:#fff;cursor:pointer;font:700 12px Arial;white-space:nowrap}.button.secondary{border:1px solid var(--line);background:#fff;color:var(--ink)}
        .alert{margin-bottom:16px;padding:12px 15px;border:1px solid;border-radius:4px;font:13px Arial}.success{border-color:#bde5cd;background:#effaf3;color:#19683d}.error{border-color:#f3c7c0;background:#fff4f2;color:#9d3d2f}.admin-list{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:12px;margin-top:20px}.admin-card{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:15px;border:1px solid var(--line);border-radius:5px;background:#fbfdfc;font:13px Arial}.admin-card strong{overflow:hidden;text-overflow:ellipsis}.admin-card small{color:var(--muted);font-size:11px}.edit{padding:6px 0;border:0;background:transparent;color:var(--teal);cursor:pointer;font:700 12px Arial}.modal-backdrop{position:fixed;inset:0;z-index:20;display:none;align-items:center;justify-content:center;padding:20px;background:rgba(15,28,38,.55)}.modal-backdrop.open{display:flex}.modal{width:min(500px,100%);padding:24px;background:#fff;box-shadow:var(--shadow)}.modal h2{margin-bottom:18px}.modal-form{display:grid;gap:14px}.modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:5px}.password-field{position:relative}.password-field input{padding-right:66px}.toggle-password{position:absolute;right:9px;bottom:11px;padding:2px;border:0;background:transparent;color:var(--teal);cursor:pointer;font:700 11px Arial}
        @media(max-width:900px){.shell{grid-template-columns:1fr}.sidebar{position:static;height:auto;padding:14px 18px}.brand{padding:0 0 14px;border:0}.label,.side-footer{display:none}.nav{display:flex;overflow-x:auto}.nav a{white-space:nowrap}}@media(max-width:620px){.topbar{display:block}.profile{margin-top:16px}.form-grid{grid-template-columns:1fr}.form-grid .button{width:100%}}
    </style>
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <div class="brand"><div class="mark"><img src="{{ asset('images/tabacare-logo.png') }}" alt="TABACARE logo"></div><div><strong>TABACARE</strong><small>Administration</small></div></div>
        <div class="label">Management</div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}"><span class="nav-icon">&#9632;</span>Dashboard</a>
            <a href="{{ route('admin.accounts') }}"><span class="nav-icon">&#9673;</span>Barangay accounts</a>
            <a href="{{ route('admin.reports') }}"><span class="nav-icon">&#9776;</span>Barangay reports</a>
            <a href="{{ route('admin.statistics') }}"><span class="nav-icon">&#9646;</span>Disease statistics</a>
            <a href="{{ route('admin.patients') }}"><span class="nav-icon">&#9998;</span>List of patients</a>
        </nav>
        <div class="side-footer">Administrator access<br><strong>{{ $adminName }}</strong><a class="active" href="{{ route('admin.admin-accounts.index') }}" style="display:block;margin-top:12px;padding:9px 10px;border-radius:6px;background:rgba(20,184,166,.14);color:#6ee7d8;text-decoration:none;font:600 12px Arial">Admin accounts</a><form method="POST" action="{{ route('logout') }}" style="margin-top:12px">@csrf<button type="submit" class="button secondary" style="width:100%;min-height:36px;background:transparent;color:#d9e3ea">Log out</button></form></div>
    </aside>
    <main class="main">
        <header class="topbar"><div><div class="eyebrow">Access management</div><h1>Admin accounts</h1><p class="intro">Manage administrator sign-in accounts separately from barangay health-worker accounts.</p></div><div class="profile"><div class="avatar">{{ strtoupper(substr($adminName,0,1)) }}</div>{{ $adminName }}</div></header>
        @if(session('success'))<div class="alert success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert error">{{ $errors->first() }}</div>@endif
        <section class="panel">
            <h2>Add an administrator</h2><p class="hint">New administrators can sign in using their username and password.</p>
            <form class="form-grid" method="POST" action="{{ route('admin.admin-accounts.store') }}">
                @csrf
                <label>Username<input name="username" value="{{ old('username') }}" required autocomplete="username"></label>
                <label class="password-field">Password<input name="password" type="password" required minlength="8" autocomplete="new-password"><button class="toggle-password" type="button">Show</button></label>
                <button class="button" type="submit">Add admin account</button>
            </form>
        </section>
        <section class="panel">
            <h2>Administrator accounts</h2><p class="hint">Edit usernames and reset passwords. Your current account is marked “You.”</p>
            <div class="admin-list">
                @foreach($admins as $admin)
                    <article class="admin-card"><strong>{{ $admin->username }} @if((int)session('id') === (int)$admin->id)<small>(You)</small>@endif</strong><button class="edit" type="button" data-edit-admin data-action="{{ route('admin.admin-accounts.update',$admin) }}" data-username="{{ $admin->username }}">Edit</button></article>
                @endforeach
            </div>
        </section>
    </main>
</div>
<div class="modal-backdrop" id="adminEditModal" role="dialog" aria-modal="true" aria-labelledby="adminEditTitle">
    <section class="modal"><h2 id="adminEditTitle">Edit administrator</h2>
        <form class="modal-form" id="adminEditForm" method="POST">
            @csrf @method('PATCH')
            <label>Username<input id="adminEditUsername" name="username" required autocomplete="username"></label>
            <label class="password-field">New password <span>(leave blank to keep current)</span><input id="adminEditPassword" name="password" type="password" minlength="8" autocomplete="new-password"><button class="toggle-password" type="button">Show</button></label>
            <div class="modal-actions"><button class="button secondary" type="button" id="cancelAdminEdit">Cancel</button><button class="button" type="submit">Save changes</button></div>
        </form>
    </section>
</div>
<script>
    const adminEditModal=document.getElementById('adminEditModal');
    document.querySelectorAll('[data-edit-admin]').forEach((button)=>button.addEventListener('click',()=>{document.getElementById('adminEditForm').action=button.dataset.action;document.getElementById('adminEditUsername').value=button.dataset.username;document.getElementById('adminEditPassword').value='';adminEditModal.classList.add('open');document.getElementById('adminEditUsername').focus()}));
    const closeAdminEdit=()=>adminEditModal.classList.remove('open');
    document.getElementById('cancelAdminEdit').addEventListener('click',closeAdminEdit);
    adminEditModal.addEventListener('click',(event)=>{if(event.target===adminEditModal)closeAdminEdit()});
    document.addEventListener('keydown',(event)=>{if(event.key==='Escape')closeAdminEdit()});
    document.querySelectorAll('.toggle-password').forEach((button)=>button.addEventListener('click',()=>{const input=button.parentElement.querySelector('input');const showing=input.type==='password';input.type=showing?'text':'password';button.textContent=showing?'Hide':'Show'}));
</script>
@include('partials.submit-guard')
</body>
</html>
