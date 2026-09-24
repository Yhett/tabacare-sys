<?php
$barangays = [
    "Agnas","Bacolod","Bangkilingan","Bantayan","Baranghawon",
    "Basagan","Basud","Bognabong","Bombon","Bonot",
    "Buang","Buhian","Cabagnan","Cobo","Comon",
    "Cormidal","Divino Rostro","Fatima","Guinobat","Hacienda",
    "Magapo","Mariroc","Matagbac","Oras","Oson",
    "Panal","Pawa","Pinagbobong","Quinale Cabasan","Quinastillojan",
    "Rawis","Sagurong","Salvacion","San Antonio","San Carlos",
    "San Isidro","San Juan","San Lorenzo","San Ramon","San Roque",
    "San Vicente","Santo Cristo","Sua-Igot","Tabiguian","Tagas",
    "Tayhi","Visita"
];

$activeTab = $_GET['tab'] ?? 'worker';
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>TABACARE System</title>

<link rel="stylesheet" href="style.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet"
>

<style>

/* ==============================
   RESET
============================== */

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Inter', sans-serif;
}


/* ==============================
   LANDING PAGE
============================== */

.landing-page {
    min-height: 100vh;

    display: flex;

    background: #f8fafc;
}


/* ==============================
   LEFT SIDE
============================== */

.landing-left {
    flex: 1;

    background:
        linear-gradient(
            135deg,
            #f0fdfa 0%,
            #f1f5f9 50%,
            #e0f2fe 100%
        );

    display: flex;

    justify-content: center;
    align-items: center;

    padding: 60px 40px;

    position: relative;

    overflow: hidden;
}


.landing-left::before {
    content: '';

    position: absolute;

    top: -30%;
    right: -20%;

    width: 500px;
    height: 500px;

    background:
        radial-gradient(
            circle,
            rgba(13,148,136,0.08) 0%,
            transparent 70%
        );

    border-radius: 50%;
}


.landing-left::after {
    content: '';

    position: absolute;

    bottom: -30%;
    left: -10%;

    width: 400px;
    height: 400px;

    background:
        radial-gradient(
            circle,
            rgba(14,165,233,0.06) 0%,
            transparent 70%
        );

    border-radius: 50%;
}


/* ==============================
   HERO
============================== */

.hero-inner {

    width: 100%;
    max-width: 520px;

    text-align: center;

    position: relative;

    z-index: 1;

    animation: fadeInUp .6s ease;
}


@keyframes fadeInUp {

    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }

}


/* ==============================
   LOGOS
============================== */

.hero-logos {

    display: flex;

    justify-content: center;
    align-items: center;

    gap: 20px;

    margin-bottom: 32px;

    flex-wrap: wrap;
}


.hero-logos img {

    width: 80px;
    height: 80px;

    object-fit: contain;

    filter:
        drop-shadow(
            0 4px 6px rgba(0,0,0,0.05)
        );

    transition: transform .3s;
}


.hero-logos img:hover {

    transform: scale(1.05);

}


/* ==============================
   HERO TITLE
============================== */

.hero-inner h1 {

    font-size: 2.4rem;

    font-weight: 800;

    margin-bottom: 16px;

    background:
        linear-gradient(
            135deg,
            #0f172a,
            #0d9488
        );

    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;

    background-clip: text;
}


.hero-inner p {

    font-size: 1.05rem;

    color: #64748b;

    line-height: 1.7;
}


/* ==============================
   HERO FEATURES
============================== */

.hero-features {

    display: flex;

    justify-content: center;

    gap: 32px;

    margin-top: 40px;

    flex-wrap: wrap;
}


.hero-feature {

    text-align: center;

    color: #475569;
}


.hero-feature svg {

    margin-bottom: 8px;

    color: #0f766e;
}


.hero-feature span {

    display: block;

    font-size: 13px;

    font-weight: 600;
}

.get-help-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 28px;
    padding: 11px 18px;
    border: 1px solid #0f766e;
    border-radius: 9px;
    color: #0f766e;
    background: rgba(255,255,255,.75);
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    transition: background .2s, color .2s, transform .2s;
}

.get-help-link:hover {
    color: #fff;
    background: #0f766e;
    transform: translateY(-1px);
}


/* ==============================
   RIGHT SIDE
============================== */

.landing-right {

    width: 440px;

    min-width: 400px;

    background: #fff;

    display: flex;

    justify-content: center;
    align-items: center;

    padding: 40px;

    box-shadow:
        -10px 0 40px rgba(0,0,0,0.03);

    position: relative;

    z-index: 2;
}


/* ==============================
   LOGIN CARD
============================== */

.login-card {

    width: 100%;

    max-width: 360px;
}


.login-card h2 {

    font-size: 1.5rem;

    margin-bottom: 4px;

    text-align: center;

    color: #0f172a;
}


.login-card .subtitle {

    text-align: center;

    color: #64748b;

    font-size: 14px;

    margin-bottom: 24px;
}


/* ==============================
   ALERT
============================== */

.alert {

    padding: 10px 14px;

    border-radius: 8px;

    font-size: 13px;

    margin-bottom: 12px;
}


.alert-error {

    background: #fef2f2;

    color: #991b1b;

    border: 1px solid #fecaca;
}


.alert-success {

    background: #f0fdf4;

    color: #166534;

    border: 1px solid #bbf7d0;
}


/* ==============================
   AUTH TABS
============================== */

.auth-tabs {

    display: flex;

    gap: 4px;

    padding: 4px;

    background: #f1f5f9;

    border-radius: 10px;

    margin-bottom: 20px;
}


.auth-tab {

    flex: 1;

    padding: 10px 8px;

    background: transparent;

    color: #64748b;

    border: none;

    border-radius: 8px;

    cursor: pointer;

    font-weight: 600;

    font-size: 12px;

    transition: all .2s;

    text-align: center;
}


.auth-tab:hover {

    background: rgba(255,255,255,.5);

    color: #0f172a;
}


.auth-tab.active {

    background: #fff;

    color: #0f766e;

    box-shadow:
        0 1px 3px rgba(0,0,0,.08);
}


/* ==============================
   AUTH PANES
============================== */

.auth-pane {

    display: none;

    animation: fadeIn .3s ease;
}


.auth-pane.active {

    display: block;
}


@keyframes fadeIn {

    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }

}


/* ==============================
   ROLE BADGES
============================== */

.role-badge-inline {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 6px 12px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 600;

    margin-bottom: 16px;

    width: 100%;

    justify-content: center;
}


.role-badge-inline.admin {

    background: #fef3c7;

    color: #92400e;
}


.role-badge-inline.worker {

    background: #dbeafe;

    color: #1e40af;
}


/* ==============================
   FORM INPUTS
============================== */

.auth-pane form {

    display: flex;

    flex-direction: column;

    gap: 12px;
}


.auth-pane input[type="text"],
.auth-pane select {

    width: 100%;

    height: 46px;

    padding: 0 13px;

    border: 1px solid #e2e8f0;

    border-radius: 9px;

    background: #f8fafc;

    color: #334155;

    font-family: inherit;

    font-size: 13px;

    outline: none;

    transition: .2s;
}


.auth-pane input[type="text"]:focus,
.auth-pane select:focus {

    border-color: #2dd4bf;

    background: #fff;

    box-shadow:
        0 0 0 3px rgba(45,212,191,.12);
}


/* ==============================
   PASSWORD
============================== */

.password-wrapper {

    position: relative;

    width: 100%;
}


.password-wrapper input {

    width: 100%;

    height: 46px;

    padding: 0 60px 0 13px;

    border: 1px solid #e2e8f0;

    border-radius: 9px;

    background: #f8fafc;

    color: #334155;

    font-family: inherit;

    font-size: 13px;

    outline: none;

    transition: .2s;
}


.password-wrapper input:focus {

    border-color: #2dd4bf;

    background: #fff;

    box-shadow:
        0 0 0 3px rgba(45,212,191,.12);
}


.password-toggle {

    position: absolute;

    top: 50%;

    right: 10px;

    transform: translateY(-50%);

    padding: 5px 6px;

    border: none;

    background: transparent;

    color: #0f766e;

    font-family: inherit;

    font-size: 11px;

    font-weight: 700;

    cursor: pointer;
}


.password-toggle:hover {

    color: #115e59;

}


/* ==============================
   SIGN IN BUTTON
============================== */

.auth-pane form > button {

    height: 46px;

    width: 100%;

    border: none;

    border-radius: 9px;

    background:
        linear-gradient(
            135deg,
            #0f766e,
            #0d9488
        );

    color: #fff;

    font-family: inherit;

    font-size: 13px;

    font-weight: 700;

    cursor: pointer;

    box-shadow:
        0 5px 14px rgba(15,118,110,.18);

    transition: .2s;
}


.auth-pane form > button:hover {

    background:
        linear-gradient(
            135deg,
            #115e59,
            #0f766e
        );

    transform: translateY(-1px);

    box-shadow:
        0 8px 18px rgba(15,118,110,.23);
}


/* ==============================
   MOBILE
============================== */

@media (max-width: 900px) {

    .landing-page {

        flex-direction: column;
    }


    .landing-left {

        padding: 40px 24px;

        min-height: auto;
    }


    .landing-right {

        width: 100%;

        min-width: auto;

        padding: 32px 24px;
    }


    .hero-inner h1 {

        font-size: 1.8rem;
    }

}


@media (max-width: 480px) {

    .hero-logos {

        gap: 12px;

        margin-bottom: 24px;
    }


    .hero-logos img {

        width: 65px;

        height: 65px;
    }


    .hero-inner p {

        font-size: .95rem;
    }


    .hero-features {

        gap: 18px;

        margin-top: 28px;
    }


    .landing-right {

        padding: 28px 18px;
    }


    .login-card {

        max-width: 100%;
    }

}

</style>

</head>

<body>

<div class="landing-page">

    <!-- =========================================
         LEFT / WELCOME SECTION
    ========================================== -->

    <div class="landing-left">
        <div class="hero-inner">
            <div class="hero-logos">
                <img src="{{ asset('images/tabacare-logo.png') }}" alt="TABACARE System Logo">
            </div>
            <h1>Welcome to TABACARE</h1>
            <p>
                Health Care System for Tabaco City Health Unit —
                managing patient records, disease tracking,
                and health worker coordination in one place.
            </p>

            <div class="hero-features">
                <div class="hero-feature">
                    <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>

                    <span>Patient Records</span>
                </div>

                <div class="hero-feature">
                    <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>

                    <span>Disease Tracking</span>
                </div>

                <div class="hero-feature">
                    <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <path d="M3 9h18"/>
                    </svg>

                    <span>Reports</span>
                </div>
            </div>
            <a class="get-help-link" href="{{ route('help') }}" aria-label="Get help using TABACARE">
                <span aria-hidden="true">?</span> Get Help
            </a>
        </div>
    </div>

    <!-- =========================================
         RIGHT / LOGIN SECTION
    ========================================== -->

    <div class="landing-right">
        <div class="login-card">
            <h2 id="panelTitle">Sign In</h2>
            <p class="subtitle" id="panelSubtitle">Sign in to access your dashboard</p>

            <!-- LOGIN ERROR -->

            @if ($errors->any())

                <div class="alert alert-error">{{ $errors->first() }}</div>

            @endif

            <!-- AUTH TABS -->

            <div class="auth-tabs">
                <button type="button" class="auth-tab <?php echo ($activeTab=='admin')?'active':''; ?>"
                    onclick="switchAuthTab('admin')"
                >Admin</button>

                <button
                    type="button"
                    class="auth-tab <?php echo ($activeTab=='worker')?'active':''; ?>"
                    onclick="switchAuthTab('worker')"
                >
                    Health Worker
                </button>
            </div>

            <!-- =================================
                 ADMIN LOGIN
            ================================== -->

            <div id="auth-admin" class="auth-pane <?php echo ($activeTab=='admin')?'active':''; ?>">
                <div class="role-badge-inline admin">
                    <svg
                        width="14"
                        height="14"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Administrator Access
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="role" value="admin">
                    <input type="text" name="username" placeholder="Admin Username" required autocomplete="username">

                    <div class="password-wrapper">
                        <input type="password" name="password" id="adminPassword" placeholder="Password" required autocomplete="current-password">
                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('adminPassword', this)"
                        >
                            Show
                        </button>

                    </div>


                    <button
                        type="submit"
                        name="login"
                    >
                        Sign In as Admin
                    </button>

                </form>

            </div>


            <!-- =================================
                 HEALTH WORKER LOGIN
            ================================== -->

            <div
                id="auth-worker"
                class="auth-pane <?php echo ($activeTab=='worker')?'active':''; ?>"
            >

                <div class="role-badge-inline worker">

                    <svg
                        width="14"
                        height="14"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>

                    Barangay Health Worker Access

                </div>


                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <input
                        type="hidden"
                        name="role"
                        value="health_worker"
                    >


                    <input
                        type="text"
                        name="username"
                        placeholder="Username"
                        required
                        autocomplete="username"
                    >


                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password"
                            id="workerPassword"
                            placeholder="Password"
                            required
                            autocomplete="current-password"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('workerPassword', this)"
                        >
                            Show
                        </button>

                    </div>


                    <select
                        name="barangay"
                        required
                    >

                        <option value="">
                            Select Barangay
                        </option>

                        <?php foreach($barangays as $barangay): ?>

                            <option
                                value="<?php echo htmlspecialchars($barangay); ?>"
                            >
                                <?php echo htmlspecialchars($barangay); ?>
                            </option>

                        <?php endforeach; ?>

                    </select>


                    <button
                        type="submit"
                        name="login"
                    >
                        Sign In as Health Worker
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<script>

/* =========================================
   SWITCH ADMIN / HEALTH WORKER
========================================= */

function switchAuthTab(tab) {

    document
        .querySelectorAll('.auth-tab')
        .forEach(function(button) {

            button.classList.remove('active');

        });


    const tabButton =
        document.querySelector(
            ".auth-tab[onclick*='" + tab + "']"
        );


    if(tabButton) {

        tabButton.classList.add('active');

    }


    document
        .querySelectorAll('.auth-pane')
        .forEach(function(pane) {

            pane.classList.remove('active');

        });


    const selectedPane =
        document.getElementById('auth-' + tab);


    if(selectedPane) {

        selectedPane.classList.add('active');

    }


    const title =
        document.getElementById('panelTitle');

    const subtitle =
        document.getElementById('panelSubtitle');


    if(tab === 'admin') {

        title.textContent = 'Admin Login';

        subtitle.textContent =
            'Sign in to manage the system';

    } else {

        title.textContent =
            'Health Worker Login';

        subtitle.textContent =
            'Sign in to manage patients';

    }

}


/* =========================================
   SHOW / HIDE PASSWORD
========================================= */

function togglePassword(inputId, button) {

    const passwordInput =
        document.getElementById(inputId);


    if(!passwordInput) {
        return;
    }


    if(passwordInput.type === 'password') {

        passwordInput.type = 'text';

        button.textContent = 'Hide';

    } else {

        passwordInput.type = 'password';

        button.textContent = 'Show';

    }

}

</script>

@include('partials.submit-guard')
</body>
</html>
