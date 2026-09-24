<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Get Help | TABACARE</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; padding: 32px 18px; background: #f4f8fa; color: #1d2935; font-family: Arial, sans-serif; }
        main { width: min(900px, 100%); margin: 0 auto; }
        .back { color: #0f766e; font-size: 14px; font-weight: 700; text-decoration: none; }
        .back:hover { text-decoration: underline; }
        header { margin: 28px 0 22px; padding: 28px; border-radius: 12px; color: #fff; background: linear-gradient(125deg,#075c5a,#0f766e 65%,#168d85); }
        header .eyebrow { color: #bdebe2; }
        .eyebrow { color: #0f766e; font-size: 11px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; }
        h1 { margin: 8px 0; font-size: clamp(30px, 5vw, 42px); }
        header p { margin: 0; color: #e0f2ef; line-height: 1.6; }
        .manual-layout { display: grid; grid-template-columns: 210px minmax(0,1fr); gap: 18px; align-items: start; }
        nav { position: sticky; top: 18px; display: grid; gap: 4px; padding: 14px; border: 1px solid #e1e8eb; border-radius: 10px; background: #fff; }
        nav a { padding: 9px 10px; border-radius: 6px; color: #48606a; font-size: 13px; text-decoration: none; }
        nav a:hover { background: #e8f6f3; color: #0f766e; }
        .steps { display: grid; gap: 10px; margin-top: 12px; }
        .step { display: grid; grid-template-columns: 30px 1fr; gap: 11px; align-items: start; color: #586875; line-height: 1.6; }
        .step-number { display: grid; place-items: center; width: 28px; height: 28px; border-radius: 50%; color: #0f766e; background: #e5f5f1; font-size: 12px; font-weight: 700; }
        .help-card { margin: 12px 0; padding: 20px 22px; border: 1px solid #e1e8eb; border-radius: 10px; background: #fff; box-shadow: 0 10px 28px rgba(27,45,61,.06); }
        h2 { margin: 0 0 8px; font-size: 18px; }
        .help-card p { margin: 0; color: #586875; line-height: 1.65; }
        .help-card a { color: #0f766e; font-weight: 700; }
        .note { margin-top: 12px !important; padding: 12px 14px; border-left: 3px solid #d9a441; border-radius: 4px; background: #fffbeb; }
        @media (max-width: 650px) { body { padding: 22px 14px; } header { padding: 22px; } .manual-layout { grid-template-columns: 1fr; } nav { position: static; grid-template-columns: repeat(2,minmax(0,1fr)); } .help-card { padding: 17px; } }
    </style>
</head>
<body>
    <main>
        <a class="back" href="{{ route('home') }}">&larr; Back to TABACARE</a>
        <header>
            <div class="eyebrow">Barangay health worker guide</div>
            <h1>TABACARE User Manual</h1>
            <p>Instructions for managing your barangay’s patient records and submitting monthly disease reports.</p>
        </header>
        <div class="manual-layout">
            <nav aria-label="Manual sections">
                <a href="#sign-in">Sign in</a>
                <a href="#dashboard">Dashboard</a>
                <a href="#patients">Patient records</a>
                <a href="#reports">Monthly reports</a>
                <a href="#account-help">Account help</a>
            </nav>
            <div>
                <section class="help-card" id="sign-in">
                    <h2>1. Sign in to your barangay account</h2>
                    <div class="steps">
                        <div class="step"><span class="step-number">1</span><span>On the home page, choose <strong>Health Worker</strong>.</span></div>
                        <div class="step"><span class="step-number">2</span><span>Enter the username and password provided by your TABACARE administrator.</span></div>
                        <div class="step"><span class="step-number">3</span><span>Select your assigned barangay and choose <strong>Sign In as Health Worker</strong>. Your account only displays records for that barangay.</span></div>
                    </div>
                </section>
                <section class="help-card" id="dashboard">
                    <h2>2. Use the dashboard</h2>
                    <p>The dashboard summarizes patient records and disease activity in your barangay. Use the navigation to open patient records or generate a report. Dashboard filters help review disease totals; they do not change or delete patient records.</p>
                </section>
                <section class="help-card" id="patients">
                    <h2>3. Add and manage patient records</h2>
                    <div class="steps">
                        <div class="step"><span class="step-number">1</span><span>Open <strong>Patient Records</strong> and select <strong>Add patient</strong>.</span></div>
                        <div class="step"><span class="step-number">2</span><span>Enter a unique patient code, age and age unit (days, months, or years), gender, disease, and date of onset.</span></div>
                        <div class="step"><span class="step-number">3</span><span>Save the record. The barangay is assigned from your account automatically.</span></div>
                        <div class="step"><span class="step-number">4</span><span>Use patient-code search or the disease filter to find a record. Choose <strong>Edit</strong> to correct it or <strong>Delete</strong> to remove it. Confirm details before deleting.</span></div>
                        <div class="step"><span class="step-number">5</span><span>Use <strong>Export Excel</strong> to download the records shown for your barangay and current search/filter.</span></div>
                    </div>
                    <p class="note">Check the patient code, age unit, disease, and onset date carefully. Monthly report totals are grouped using the date of onset.</p>
                </section>
                <section class="help-card" id="reports">
                    <h2>4. Generate and submit the monthly report</h2>
                    <div class="steps">
                        <div class="step"><span class="step-number">1</span><span>Open <strong>Generate Report</strong>, choose the month, and enter the preparer’s name.</span></div>
                        <div class="step"><span class="step-number">2</span><span>Select <strong>Generate preview</strong>. The report includes all five tracked diseases and records for your barangay whose onset date falls in the selected month.</span></div>
                        <div class="step"><span class="step-number">3</span><span>Review the preview, then select <strong>Download Excel</strong> to save the report file.</span></div>
                        <div class="step"><span class="step-number">4</span><span>To send it to the administrator, attach the downloaded Excel file under <strong>Submit to admin</strong>, then submit the report.</span></div>
                    </div>
                </section>
                <section class="help-card" id="account-help">
                    <h2>5. Account or sign-in problems</h2>
                    <p>Contact your TABACARE administrator at the Tabaco City Health Unit if your account is missing, your barangay assignment is incorrect, or you need a password reset. The system does not provide self-service password recovery.</p>
                </section>
            </div>
        </div>
    </main>
</body>
</html>
