<?php
/*
| Forgot Password (admin recovery via security question).
| Styled to match the login card on the landing page.
*/
?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Forgot Password | TABACARE System</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet"
>

<style>

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Inter', sans-serif;
    background:
        linear-gradient(
            135deg,
            #f0fdfa 0%,
            #f1f5f9 50%,
            #e0f2fe 100%
        );

    min-height: 100vh;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 40px 20px;
}


/* ==============================
   RESET CARD
============================== */

.reset-card {

    width: 100%;
    max-width: 380px;

    padding: 32px 28px;

    background: #fff;

    border-radius: 16px;

    box-shadow: 0 18px 45px rgba(15,23,42,.08);

    text-align: center;
}


.reset-logo {

    width: 84px;
    height: 84px;

    object-fit: contain;

    margin-bottom: 16px;

    filter: drop-shadow(0 4px 6px rgba(0,0,0,0.05));
}


.reset-card h2 {

    font-size: 1.5rem;

    color: #0f172a;

    margin-bottom: 4px;
}


.reset-card .subtitle {

    color: #64748b;

    font-size: 14px;

    line-height: 1.6;

    margin-bottom: 24px;
}


/* ==============================
   ALERTS
============================== */

.alert {

    padding: 10px 14px;

    border-radius: 8px;

    font-size: 13px;

    text-align: left;

    margin-bottom: 14px;
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
   FORM
============================== */

.reset-form {

    display: flex;

    flex-direction: column;

    gap: 12px;
}


.field-label {

    display: block;

    text-align: left;

    color: #475569;

    font-size: 12px;

    font-weight: 600;

    margin-bottom: -6px;
}


.reset-form input[type="text"],
.reset-form input[type="password"] {

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


.password-wrapper {
    position: relative;
    width: 100%;
}


.password-wrapper input {
    padding-right: 60px;
}


.reset-form input:focus {

    border-color: #2dd4bf;
    background: #fff;

    box-shadow: 0 0 0 3px rgba(45,212,191,.12);
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


.reset-form button[type="submit"] {

    height: 46px;
    width: 100%;

    border: none;
    border-radius: 9px;

    background: linear-gradient(135deg, #0f766e, #0d9488);

    color: #fff;

    font-family: inherit;
    font-size: 13px;
    font-weight: 700;

    cursor: pointer;

    box-shadow: 0 5px 14px rgba(15,118,110,.18);

    transition: .2s;
}


.reset-form button[type="submit"]:hover {

    background: linear-gradient(135deg, #115e59, #0f766e);

    transform: translateY(-1px);
}


.cancel-button {

    height: 42px;
    width: 100%;

    border: 1px solid #e2e8f0;
    border-radius: 9px;

    background: #fff;
    color: #475569;

    font-family: inherit;
    font-size: 13px;
    font-weight: 600;

    cursor: pointer;

    transition: .2s;
}


.cancel-button:hover {
    background: #f8fafc;
    color: #0f172a;
}


/* ==============================
   SECURITY QUESTION BOX
============================== */

.question-box {

    text-align: left;

    padding: 13px 15px;

    background: #fef3c7;
    border: 1px solid #fde68a;
    border-radius: 9px;

    margin-bottom: 4px;
}


.question-box small {

    display: block;

    color: #92400e;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;

    margin-bottom: 5px;
}


.question-box strong {

    color: #78350f;
    font-size: 13px;
    font-weight: 600;
    line-height: 1.5;
}


/* ==============================
   BACK LINK
============================== */

.back-link {

    display: inline-block;

    margin-top: 18px;

    color: #0f766e;
    font-size: 13px;
    font-weight: 600;

    text-decoration: none;
}


.back-link:hover {
    text-decoration: underline;
}

</style>

</head>

<body>

<div class="reset-card">

    <img
        src="{{ asset('images/tabacare-logo.png') }}"
        alt="TABACARE System Logo"
        class="reset-logo"
    >

    <h2>Forgot Password?</h2>

    <p class="subtitle">
        @if ($admin)
            Answer your security question to set a new admin password.
        @else
            Enter your admin username to start the password recovery.
        @endif
    </p>

    @if ($errors->any())

        <div class="alert alert-error">{{ $errors->first() }}</div>

    @endif

    @if (session('status'))

        <div class="alert alert-success">{{ session('status') }}</div>

    @endif

    @if ($admin)

        <!-- =================================
             STEP 2 — SECURITY QUESTION
        ================================== -->

        <div class="question-box">
            <small>Security Question</small>
            <strong>{{ $admin->security_question }}</strong>
        </div>

        <form class="reset-form" method="POST" action="{{ route('password.update') }}">
            @csrf

            <label class="field-label" for="security_answer">Your Answer</label>
            <input
                type="text"
                id="security_answer"
                name="security_answer"
                value="{{ old('security_answer') }}"
                placeholder="Type your answer"
                required
                autocomplete="off"
            >

            <label class="field-label" for="resetPassword">New Password</label>
            <div class="password-wrapper">
                <input
                    type="password"
                    id="resetPassword"
                    name="password"
                    placeholder="At least 8 characters"
                    required
                    minlength="8"
                    autocomplete="new-password"
                >
                <button
                    type="button"
                    class="password-toggle"
                    onclick="togglePassword('resetPassword', this)"
                >
                    Show
                </button>
            </div>

            <label class="field-label" for="resetPasswordConfirmation">Confirm New Password</label>
            <div class="password-wrapper">
                <input
                    type="password"
                    id="resetPasswordConfirmation"
                    name="password_confirmation"
                    placeholder="Repeat the new password"
                    required
                    minlength="8"
                    autocomplete="new-password"
                >
                <button
                    type="button"
                    class="password-toggle"
                    onclick="togglePassword('resetPasswordConfirmation', this)"
                >
                    Show
                </button>
            </div>

            <button type="submit">Reset Password</button>

            <button
                type="submit"
                class="cancel-button"
                formaction="{{ route('password.cancel') }}"
                formnovalidate
            >
                Back to Login
            </button>
        </form>

    @else

        <!-- =================================
             STEP 1 — IDENTIFY ACCOUNT
        ================================== -->

        <form class="reset-form" method="POST" action="{{ route('password.identify') }}">
            @csrf

            <label class="field-label" for="username">Admin Username</label>
            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username') }}"
                placeholder="Enter your admin username"
                required
                autocomplete="username"
                autofocus
            >

            <button type="submit">Continue</button>
        </form>

        <a class="back-link" href="{{ route('home') }}?tab=admin">&larr; Back to Admin Login</a>

    @endif

</div>

<script>

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



