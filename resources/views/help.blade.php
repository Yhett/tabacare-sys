<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name    = "viewport" content="width=device-width, initial-scale=1">
    <title>Get Help | TABACARE</title>
    <style>
        * { 
            box-sizing: border-box;
         }
        body {
             margin: 0;
              min-height: 100vh; 
              padding: 32px 18px; 
              background: #f4f8fa; 
              color: #1d2935; 
              font-family: Arial, sans-serif; 
        }

        main {
             width: min(900px, 100%);
             margin: 0 auto; 

        }
        .back {
             color: #0f766e;
             font-size: 14px;
             font-weight: 700;
             text-decoration: none;
         }

        .back:hover {
             text-decoration: underline;
        }

        .topbar {
             display: flex;
             align-items: center;
             justify-content: space-between;
             gap: 12px;
             flex-wrap: wrap;
        }

        .lang-switch {
             display: inline-flex;
             padding: 3px;
             border: 1px solid #cbd9de;
             border-radius: 999px;
             background: #fff;
             box-shadow: 0 4px 14px rgba(27,45,61,.06);
        }

        .lang-switch button {
             border: 0;
             border-radius: 999px;
             background: transparent;
             color: #48606a;
             cursor: pointer;
             font-size: 13px;
             font-weight: 700;
             padding: 7px 14px;
        }

        .lang-switch button.active {
             background: #0f766e;
             color: #fff;
        }

        header { 
            margin: 28px 0 22px;
            padding: 28px;
            border-radius: 12px;
            color: #fff;
            background: linear-gradient(125deg,#075c5a,#0f766e 65%,#168d85); 
        }

        header .eyebrow {
             color: #bdebe2; 
            }
        .eyebrow {
             color: #0f766e;
             font-size: 11px;
             font-weight: 700; 
             letter-spacing: .14em; 
             text-transform: uppercase; 
            }

        h1 { 
            margin: 8px 0;
            font-size: clamp(30px, 5vw, 42px); 
        }

        header p {
            margin: 0;
            color: #e0f2ef;
            line-height: 1.6; 
        }

        .manual-layout {
            display: grid;
            grid-template-columns: 210px minmax(0,1fr);
            gap: 18px;
            align-items: start;
        }

        nav {
            position: sticky;
            top: 18px;
            display: grid;
            gap: 4px;
            padding: 14px;
            border: 1px solid #e1e8eb;
            border-radius: 10px; background: #fff;
        }

        nav a {
             padding: 9px 10px;
             border-radius: 6px;
             color: #48606a;
             font-size: 13px;
             text-decoration: none;
        }

        nav a:hover {
             background: #e8f6f3;
             color: #0f766e;
        }

        .steps {
            display: grid; 
            gap: 10px; 
            margin-top: 12px;
        }
        .step {
            display: grid;
            grid-template-columns: 30px 1fr;
            gap: 11px;
            align-items: start; 
            color: #586875;
            line-height: 1.6;
        }

        .step-number {
            display: grid;
            place-items: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            color: #0f766e;
            background: #e5f5f1;
            font-size: 12px;
            font-weight: 700;
        }

        .help-card {
            margin: 12px 0;
            padding: 20px 22px;
            border: 1px solid #e1e8eb;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 10px 28px rgba(27,45,61,.06);
        }

        h2 {
            margin: 0 0 8px;
            font-size: 18px;
        }

        .help-card p {
            margin: 0;
            color: #586875;
            line-height: 1.65;
        }

        .help-card a {
            color: #0f766e;
            font-weight: 700;
        }
        .note {
            margin-top: 12px !important;
            padding: 12px 14px;
            border-left: 3px solid #d9a441; border-radius: 4px; background: #fffbeb;
        }

        .topbar {
             display: flex;
             align-items: center;
             justify-content: space-between;
             gap: 12px;
             flex-wrap: wrap;
        }

        .lang-switch {
             display: inline-flex;
             padding: 3px;
             border: 1px solid #cbd9de;
             border-radius: 999px;
             background: #fff;
        }

        .lang-switch button {
             border: 0;
             border-radius: 999px;
             background: transparent;
             color: #48606a;
             cursor: pointer;
             font-size: 13px;
             font-weight: 700;
             padding: 7px 14px;
        }

        .lang-switch button.active {
             background: #0f766e;
             color: #fff;
        }
        @media (max-width: 650px) { 
            body { 
                padding: 22px 14px; 
            } 
            header { 
                padding: 22px; 
            } 
            .manual-layout { 
                grid-template-columns: 1fr; 
            } 
            nav { 
                position: static; 
                grid-template-columns: repeat(2,minmax(0,1fr)); 
            } 
            .help-card { 
                padding: 17px; 
            } 
        }
    </style>
    @include('partials.fonts')
</head>
<body>
    <main>
        <div class = "topbar">
        <a class = "back" href="{{ route('home') }}" data-i18n="back">&larr; Back to TABACARE</a>
        <div class = "lang-switch" role="group" aria-label="Language / Wika" data-i18n-aria="langLabel">
        <button type="button" id="langEn" class="active" onclick="setHelpLang('en')">English</button>
        <button type="button" id="langTl" onclick="setHelpLang('tl')">Filipino</button>
        </div>
        </div>
        <header>
            <div class = "eyebrow" data-i18n="eyebrow">Barangay health worker guide</div>
            <h1 data-i18n="title">TABACARE User Manual</h1>
            <p data-i18n="subtitle">Instructions for managing your barangay’s patient records and submitting monthly disease reports.</p>
        </header>
        <div class          = "manual-layout">
            <nav aria-label = "Manual sections" data-i18n-aria="navLabel">
                <a href     = "#sign-in" data-i18n="navSignIn">Sign in</a>
                <a href     = "#dashboard" data-i18n="navDashboard">Dashboard</a>
                <a href     = "#patients" data-i18n="navPatients">Patient records</a>
                <a href     = "#reports" data-i18n="navReports">Monthly reports</a>
                <a href     = "#account-help" data-i18n="navAccount">Account help</a>
            </nav>
            <div>
                <section class = "help-card" id="sign-in">
                    <h2 data-i18n="signInTitle">1. Sign in to your barangay account</h2>
                    <div class     = "steps">
                        <div class = "step"><span class="step-number">1</span><span data-i18n="signIn1">On the home page, choose <strong>Health Worker</strong>.</span></div>
                        <div class = "step"><span class="step-number">2</span><span data-i18n="signIn2">Enter the username and password provided by your TABACARE administrator.</span></div>
                        <div class = "step"><span class="step-number">3</span><span data-i18n="signIn3">Select your assigned barangay and choose <strong>Sign In as Health Worker</strong>. Your account only displays records for that barangay.</span></div>
                    </div>
                </section>
                <section class = "help-card" id="dashboard">
                    <h2 data-i18n="dashboardTitle">2. Use the dashboard</h2>
                    <p data-i18n="dashboardText">The dashboard summarizes patient records and disease activity in your barangay. Use the navigation to open patient records or generate a report. Dashboard filters help review disease totals; they do not change or delete patient records.</p>
                </section>
                <section class = "help-card" id="patients">
                    <h2 data-i18n="patientsTitle">3. Add and manage patient records</h2>
                    <div class     = "steps">
                        <div class = "step"><span class="step-number">1</span><span data-i18n="patients1">Open <strong>Patient Records</strong> and select <strong>Add patient</strong>.</span></div>
                        <div class = "step"><span class="step-number">2</span><span data-i18n="patients2">Enter a unique patient code, age and age unit (days, months, or years), gender, disease, and date of onset.</span></div>
                        <div class = "step"><span class="step-number">3</span><span data-i18n="patients3">Save the record. The barangay is assigned from your account automatically.</span></div>
                        <div class = "step"><span class="step-number">4</span><span data-i18n="patients4">Use patient-code search or the disease filter to find a record. Choose <strong>Edit</strong> to correct it or <strong>Delete</strong> to remove it. Confirm details before deleting.</span></div>
                        <div class = "step"><span class="step-number">5</span><span data-i18n="patients5">Use <strong>Export Excel</strong> to download the records shown for your barangay and current search/filter.</span></div>
                    </div>
                    <p class = "note" data-i18n="patientsNote">Check the patient code, age unit, disease, and onset date carefully. Monthly report totals are grouped using the date of onset.</p>
                </section>
                <section class = "help-card" id="reports">
                    <h2 data-i18n="reportsTitle">4. Generate and submit the monthly report</h2>
                    <div class     = "steps">
                        <div class = "step"><span class="step-number">1</span><span data-i18n="reports1">Open <strong>Generate Report</strong>, choose the month, and enter the preparer’s name.</span></div>
                        <div class = "step"><span class="step-number">2</span><span data-i18n="reports2">Select <strong>Generate preview</strong>. The report includes all five tracked diseases and records for your barangay whose onset date falls in the selected month.</span></div>
                        <div class = "step"><span class="step-number">3</span><span data-i18n="reports3">Review the preview, then select <strong>Download Excel</strong> to save the report file.</span></div>
                        <div class = "step"><span class="step-number">4</span><span data-i18n="reports4">To send it to the administrator, attach the downloaded Excel file under <strong>Submit to admin</strong>, then submit the report.</span></div>
                    </div>
                </section>
                <section class = "help-card" id="account-help">
                    <h2 data-i18n="accountTitle">5. Account or sign-in problems</h2>
                    <p data-i18n="accountText">Contact your TABACARE administrator at the Tabaco City Health Unit if your account is missing, your barangay assignment is incorrect, or you need a password reset. The system does not provide self-service password recovery.</p>
                </section>
            </div>
        </div>
    </main>
<script>
var helpEn = {
back: '&larr; Back to TABACARE',
eyebrow: 'Barangay health worker guide',
title: 'TABACARE User Manual',
navSignIn: 'Sign in',
navDashboard: 'Dashboard',
navPatients: 'Patient records',
navReports: 'Monthly reports',
navAccount: 'Account help',
signInTitle: '1. Sign in to your barangay account',
dashboardTitle: '2. Use the dashboard',
patientsTitle: '3. Add and manage patient records',
reportsTitle: '4. Generate and submit the monthly report',
accountTitle: '5. Account or sign-in problems',
navLabel: 'Manual sections',
langLabel: 'Language / Wika'
};
var helpEnLong = {
subtitle: 'Instructions for managing your barangay\u2019s patient records and submitting monthly disease reports.',
signIn1: 'On the home page, choose <strong>Health Worker</strong>.',
signIn2: 'Enter the username and password provided by your TABACARE administrator.',
dashboardText: 'The dashboard summarizes patient records and disease activity in your barangay. Use the navigation to open patient records or generate a report. Dashboard filters help review disease totals; they do not change or delete patient records.',
patients1: 'Open <strong>Patient Records</strong> and select <strong>Add patient</strong>.',
signIn3: 'Select your assigned barangay and choose <strong>Sign In as Health Worker</strong>. Your account only displays records for that barangay.',
patients2: 'Enter a unique patient code, age and age unit (days, months, or years), gender, disease, and date of onset.',
patients3: 'Save the record. The barangay is assigned from your account automatically.',
patients4: 'Use patient-code search or the disease filter to find a record. Choose <strong>Edit</strong> to correct it or <strong>Delete</strong> to remove it. Confirm details before deleting.',
patients5: 'Use <strong>Export Excel</strong> to download the records shown for your barangay and current search/filter.',
patientsNote: 'Check the patient code, age unit, disease, and onset date carefully. Monthly report totals are grouped using the date of onset.',
reports1: 'Open <strong>Generate Report</strong>, choose the month, and enter the preparer name.',
reports2: 'Select <strong>Generate preview</strong>. The report includes all five tracked diseases and records for your barangay whose onset date falls in the selected month.',
reports3: 'Review the preview, then select <strong>Download Excel</strong> to save the report file.',
reports4: 'To send it to the administrator, attach the downloaded Excel file under <strong>Submit to admin</strong>, then submit the report.',
accountText: 'Contact your TABACARE administrator at the Tabaco City Health Unit if your account is missing, your barangay assignment is incorrect, or you need a password reset. The system does not provide self-service password recovery.'
};
var helpTl = {
back: '&larr; Bumalik sa TABACARE',
eyebrow: 'Gabay para sa barangay health worker',
title: 'Manwal ng TABACARE',
navSignIn: 'Pag-sign in',
navDashboard: 'Dashboard',
navPatients: 'Tala ng pasyente',
navReports: 'Buwanang ulat',
navAccount: 'Tulong sa account',
signInTitle: '1. Mag-sign in sa iyong barangay account',
dashboardTitle: '2. Gamitin ang dashboard',
patientsTitle: '3. Magdagdag at mamahala ng tala ng pasyente',
reportsTitle: '4. Gumawa at magsumite ng buwanang ulat',
accountTitle: '5. Problema sa account o pag-sign in',
navLabel: 'Mga seksyon ng manwal',
langLabel: 'Language / Wika'
};
var helpTlLong = {
subtitle: 'Mga tagubilin sa pamamahala ng tala ng pasyente ng iyong barangay at pagsusumite ng buwanang ulat ng sakit.',
signIn1: 'Sa home page, piliin ang <strong>Health Worker</strong>.',
signIn2: 'Ilagay ang username at password na ibinigay ng iyong TABACARE administrator.',
signIn3: 'Piliin ang iyong nakatalagang barangay at pindutin ang <strong>Sign In as Health Worker</strong>. Ang iyong account ay nagpapakita lamang ng mga tala para sa barangay na iyon.',
dashboardText: 'Ipinapakita ng dashboard ang buod ng mga tala ng pasyente at galaw ng sakit sa iyong barangay. Gamitin ang navigation upang buksan ang tala ng pasyente o gumawa ng ulat. Ang mga filter ng dashboard ay tumutulong sa pagsusuri ng kabuuang sakit; hindi nito binabago o binubura ang mga tala ng pasyente.',
patients1: 'Buksan ang <strong>Patient Records</strong> at piliin ang <strong>Add patient</strong>.',
patients2: 'Ilagay ang natatanging patient code, edad at yunit ng edad (araw, buwan, o taon), kasarian, sakit, at petsa ng pagsisimula.',
patients3: 'I-save ang tala. Ang barangay ay awtomatikong nakatalaga mula sa iyong account.',
patients4: 'Gamitin ang paghahanap gamit ang patient code o ang filter ng sakit upang hanapin ang tala. Piliin ang <strong>Edit</strong> upang itama ito o <strong>Delete</strong> upang burahin ito. Siguraduhin ang mga detalye bago magbura.',
patients5: 'Gamitin ang <strong>Export Excel</strong> upang i-download ang mga talang ipinapakita para sa iyong barangay at kasalukuyang paghahanap/filter.',
patientsNote: 'Suriing mabuti ang patient code, yunit ng edad, sakit, at petsa ng pagsisimula. Ang kabuuang buwanang ulat ay pinapangkat ayon sa petsa ng pagsisimula.',
reports1: 'Buksan ang <strong>Generate Report</strong>, piliin ang buwan, at ilagay ang pangalan ng naghanda.',
reports2: 'Piliin ang <strong>Generate preview</strong>. Kasama sa ulat ang lahat ng limang sinusubaybayang sakit at mga tala para sa iyong barangay na ang petsa ng pagsisimula ay pasok sa napiling buwan.',
reports3: 'Suriin ang preview, pagkatapos ay piliin ang <strong>Download Excel</strong> upang i-save ang file ng ulat.',
reports4: 'Upang ipadala ito sa administrator, ilakip ang na-download na Excel file sa ilalim ng <strong>Submit to admin</strong>, pagkatapos ay isumite ang ulat.',
accountText: 'Makipag-ugnayan sa iyong TABACARE administrator sa Tabaco City Health Unit kung nawawala ang iyong account, mali ang iyong nakatalagang barangay, o kailangan mo ng pag-reset ng password. Walang self-service password recovery ang sistema.'
};
function setHelpLang(lang) {
applyHelpLang(lang);
var enBtn = document.getElementById('langEn');
var tlBtn = document.getElementById('langTl');
if (enBtn) enBtn.classList.toggle('active', lang !== 'tl');
if (tlBtn) tlBtn.classList.toggle('active', lang === 'tl');
try { localStorage.setItem('tabacare-help-lang', lang); } catch (e) {}
}
function applyHelpLang(lang) {
var dict = (lang === 'tl') ? helpTl : helpEn;
var longDict = (lang === 'tl') ? helpTlLong : helpEnLong;
var key, nodes, i;
for (key in dict) {
if (!dict.hasOwnProperty(key)) continue;
nodes = document.querySelectorAll('[data-i18n="' + key + '"]');
for (i = 0; i < nodes.length; i++) nodes[i].innerHTML = dict[key];
}
for (key in longDict) {
if (!longDict.hasOwnProperty(key)) continue;
nodes = document.querySelectorAll('[data-i18n="' + key + '"]');
for (i = 0; i < nodes.length; i++) nodes[i].innerHTML = longDict[key];
}
document.documentElement.lang = (lang === 'tl') ? 'tl' : 'en';
var ariaNodes = document.querySelectorAll('[data-i18n-aria]');
for (i = 0; i < ariaNodes.length; i++) {
var ariaKey = ariaNodes[i].getAttribute('data-i18n-aria');
if (dict[ariaKey] !== undefined) ariaNodes[i].setAttribute('aria-label', dict[ariaKey]);
}
var enBtn = document.getElementById('langEn');
var tlBtn = document.getElementById('langTl');
if (enBtn) enBtn.classList.toggle('active', lang !== 'tl');
if (tlBtn) tlBtn.classList.toggle('active', lang === 'tl');
}
(function () {
var saved = null;
try { saved = localStorage.getItem('tabacare-help-lang'); } catch (e) {}
applyHelpLang(saved === 'tl' ? 'tl' : 'en');
})();
</script>
</body>
</html>
