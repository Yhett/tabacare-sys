<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Generate Report | TABACARE</title>
    <style>
        :root{--ink:#18303b;--muted:#6c7f86;--paper:#f6f8f5;--panel:#fff;--line:#dce6e1;--teal:#087f78;--shadow:0 14px 40px rgba(24,48,59,.08)}
        *{box-sizing:border-box}body{margin:0;background:var(--paper);color:var(--ink);font-family:Georgia,'Times New Roman',serif}button,input,select{font:inherit}
        .main{min-height:100vh;padding:30px clamp(20px,4vw,58px) 48px}.topbar{display:flex;justify-content:space-between;gap:20px;margin-bottom:28px}.eyebrow{color:var(--teal);font:700 11px Arial,sans-serif;letter-spacing:.16em;text-transform:uppercase}h1{margin:7px 0 6px;font-size:clamp(28px,4vw,40px);font-weight:400}.intro{margin:0;color:var(--muted);font-size:16px}.profile{display:flex;align-items:center;gap:10px;color:var(--muted);font:13px Arial,sans-serif}.avatar{width:39px;height:39px;display:grid;place-items:center;border-radius:50%;background:#f3d28d;color:#604416;font-weight:700}
        .panel,.preview{padding:24px;background:var(--panel);border:1px solid var(--line);box-shadow:var(--shadow)}h2{margin:0 0 8px;font-size:21px;font-weight:400}.hint,.meta{color:var(--muted);font:13px Arial,sans-serif}.form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:0 16px}.field{display:grid;gap:7px;margin:18px 0}label{color:var(--muted);font:700 10px Arial,sans-serif;letter-spacing:.1em;text-transform:uppercase}input,select{width:100%;min-height:42px;padding:9px 11px;border:1px solid var(--line);border-radius:4px;background:#fff;color:var(--ink)}.actions{display:flex;gap:10px;margin-top:7px}.button{min-height:42px;padding:0 16px;border:0;border-radius:4px;background:#0a3b69;color:#fff;cursor:pointer;font:700 12px Arial,sans-serif}.button:hover{background:#173866}.button:disabled{opacity:.65;cursor:wait}
        .alert{margin-bottom:16px;padding:12px 15px;border:1px solid;border-radius:4px;font:13px Arial,sans-serif}.success{border-color:#bde5cd;background:#effaf3;color:#19683d}.error{border-color:#f3c7c0;background:#fff4f2;color:#9d3d2f}.ready{margin-top:18px;padding:18px;border:1px solid #bbf7d0;border-radius:8px;background:#f0fdf4;font:13px Arial,sans-serif;color:#166534}.preview{margin-top:18px;padding:0;overflow:hidden}.preview-head{padding:18px 20px;border-bottom:1px solid var(--line)}.table-wrap{max-width:100%;overflow:auto}.preview table{width:3943px;table-layout:fixed;border-collapse:separate;border-spacing:0;font:13px Arial,sans-serif}.preview th{padding:12px;text-align:left;color:#fff;background:#0a3b69;font-size:10px;letter-spacing:.1em;text-transform:uppercase;white-space:nowrap}.preview td{padding:13px 12px;border-top:1px solid #edf2ef;white-space:nowrap}.fixed-disease,.fixed-icd{position:sticky;z-index:2;background:#fff}.fixed-disease{left:0}.fixed-icd{left:627px}.preview th.fixed-disease,.preview th.fixed-icd{z-index:4;background:#0a3b69}.preview-actions{display:flex;gap:10px;padding:17px 20px;border-top:1px solid var(--line)}.upload{display:flex;align-items:end;gap:12px;padding:17px 20px;border-top:1px solid #99f6e4;background:#f0fdfa}.upload label{flex:1}.upload input{margin-top:7px;background:#fff}.empty{padding:35px;color:var(--muted);text-align:center;font:13px Arial,sans-serif}
        @media(max-width:650px){.topbar,.upload{display:block}.profile{margin-top:16px}.form-grid{grid-template-columns:1fr}.upload .button,.preview-actions .button{width:100%;margin-top:10px}.actions{display:block}.actions .button{width:100%;margin-top:8px}}
    </style>
</head>
<body>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('generateReportForm');
            const button = document.getElementById('generateReportButton');
            const periodType = document.getElementById('period_type');
            const monthField = document.getElementById('month-field');
            const month = document.getElementById('month');
            const updatePeriodFields = () => {
                const monthly = periodType.value === 'monthly';
                monthField.hidden = !monthly;
                month.required = monthly;
                month.disabled = !monthly;
            };
            periodType.addEventListener('change', updatePeriodFields);
            updatePeriodFields();
            form?.addEventListener('submit', function () {
                button.disabled = true;
                button.textContent = 'Generating...';
            });
            const submitForm = document.getElementById('submitReportForm');
            const submitButton = document.getElementById('submitReportButton');
            submitForm?.addEventListener('submit', function () {
                if (document.getElementById('reportFile')?.files.length) {
                    submitButton.disabled = true;
                    submitButton.textContent = 'Submitting...';
                }
            });
        });
    </script>
    @include('partials.sidebar')
    <main class="main">
        <header class="topbar">
            <div><div class="eyebrow">Health worker workspace</div><h1>Generate barangay report</h1><p class="intro">Create a report from records in {{ $barangay }}.</p></div>
            <div class="profile"><div class="avatar">{{ strtoupper(substr($workerName,0,1)) }}</div>{{ $workerName }}</div>
        </header>
        @if(session('success'))<div class="alert success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert error"><strong>Report was not generated or submitted.</strong><br>{{ $errors->first() }}</div>@endif
        <section class="panel">
            <h2>Generate disease report</h2>
            <p class="hint">The report includes all five diseases for {{ $barangay }}. Choose a monthly or annual period.</p>
            <form method="POST" action="{{ route('reports.generate') }}" id="generateReportForm">
                @csrf
                <div class="form-grid">
                    <div class="field"><label for="period_type">Report period</label><select id="period_type" name="period_type" required><option value="monthly" @selected(old('period_type',$periodType)==='monthly')>Monthly</option><option value="annual" @selected(old('period_type',$periodType)==='annual')>Annual</option></select></div>
                    <div class="field" id="month-field"><label for="month">Report month ({{ now()->year }})</label><select id="month" name="month">@foreach($months as $number=>$name)<option value="{{ $number }}" @selected((int)old('month',$month)===(int)$number)>{{ $name }}</option>@endforeach</select></div>
                    <div class="field"><label for="prepared_by">Prepared by</label><input id="prepared_by" name="prepared_by" value="{{ old('prepared_by',$preparedBy) }}" required></div>
                </div>
                <div class="actions"><button class="button" id="generateReportButton" type="submit">Generate preview</button></div>
            </form>
        </section>
        @if($generated)
            @php($reportTitle = $periodType === 'annual' ? 'Annual '.$reportStart->format('Y') : $reportStart->format('F Y'))
            <div class="ready"><strong>{{ $reportTitle }} report generated successfully.</strong> {{ $reportData->count() }} case(s) found.</div>
            <section class="preview">
                <div class="preview-head"><h2>Disease report preview</h2><div class="meta">{{ $barangay }} · Prepared by {{ $preparedBy }} · {{ now()->format('F d, Y') }}</div></div>
                @if($reportRows->isNotEmpty())
                    <div class="table-wrap"><table><colgroup><col style="width:627px"><col style="width:180px">@foreach($reportRows->first()['counts'] as $band=>$counts)<col style="width:64px"><col style="width:64px"><col style="width:64px">@endforeach<col style="width:80px"></colgroup><thead><tr><th class="fixed-disease" rowspan="2">Disease type/name</th><th class="fixed-icd" rowspan="2">ICD code/s</th>@foreach($reportRows->first()['counts'] as $band=>$counts)<th colspan="3">{{ $band }}</th>@endforeach<th rowspan="2">Grand total</th></tr><tr>@foreach($reportRows->first()['counts'] as $counts)<th>Male</th><th>Female</th><th>Total</th>@endforeach</tr></thead><tbody>@foreach($reportRows as $row)<tr><td class="fixed-disease">{{ $row['disease'] }}</td><td class="fixed-icd">{{ $row['icd_code'] }}</td>@foreach($row['counts'] as $counts)<td>{{ $counts['Male'] }}</td><td>{{ $counts['Female'] }}</td><td>{{ $counts['Total'] }}</td>@endforeach<td>{{ $row['grand_total'] }}</td></tr>@endforeach</tbody></table></div>
                @else<div class="empty">No patients found for the selected diseases.</div>@endif
                <div class="preview-actions"><form method="POST" action="{{ route('reports.download') }}">@csrf<input type="hidden" name="prepared_by" value="{{ $preparedBy }}"><input type="hidden" name="period_type" value="{{ $periodType }}"><input type="hidden" name="month" value="{{ $month }}"><button class="button" type="submit">Download Excel</button></form></div>
                <form class="upload" method="POST" action="{{ route('reports.submit') }}" enctype="multipart/form-data" id="submitReportForm">@csrf<input type="hidden" name="prepared_by" value="{{ $preparedBy }}"><input type="hidden" name="period_type" value="{{ $periodType }}"><input type="hidden" name="month" value="{{ $month }}"><label>Attach exported Excel report<input id="reportFile" type="file" name="report_file" accept=".xls,.xlsx" required></label><button class="button" id="submitReportButton" type="submit">Submit to admin</button></form>
            </section>
        @endif
    </main>
@include('partials.submit-guard')
</body>
</html>
