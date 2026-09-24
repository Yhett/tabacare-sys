<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $reportTitle }}</title>
    <style>
        body { color: #1f2937; font-family: Calibri, Arial, sans-serif; margin: 0; }
        table.sheet { width: 100%; border-collapse: collapse; border: 1px solid #cbd5e1; }
        .sheet td, .sheet th { border: 1px solid #cbd5e1; padding: 9px 12px; vertical-align: middle; }
        .header-wrap td { border: none; }
        .title-cell { padding: 18px 16px; border: 1px solid #86efac; background: #dcfce7; text-align: center; }
        .unit-name { color: #166534; font-size: 11pt; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; }
        .report-title { padding: 4px 0 2px; color: #14532d; font-size: 20pt; font-weight: bold; }
        .report-subtitle { color: #475569; font-size: 10.5pt; font-style: italic; }
        .meta { padding-top: 10px; padding-bottom: 10px; background: #f8fafc; font-size: 10pt; }
        .meta-label { background: #e2e8f0; color: #334155; font-weight: bold; }
        .meta-value { background: #fff; font-weight: bold; text-align: center; }
        .section-gap td { height: 12px; padding: 0; border: none; background: #fff; }
        .table-head th { padding-top: 11px; padding-bottom: 11px; background: #15803d; color: #fff; font-size: 11pt; text-align: center; }
        .text-center { text-align: center; } .text-left { text-align: left; }
        .row-even td { background: #f0fdf4; } .row-odd td { background: #fff; }
        .empty-cell { background: #f8fafc; color: #64748b; font-style: italic; text-align: center; }
    </style>
</head>
<body>
    <table class="sheet">
        <colgroup><col style="width:18%"><col style="width:8%"><col style="width:12%"><col style="width:24%"><col style="width:18%"><col style="width:20%"></colgroup>
        <tr class="header-wrap"><td colspan="6" class="title-cell"><div class="unit-name">TABACO CITY HEALTH UNIT</div><div class="report-title">{{ $reportTitle }}</div><div class="report-subtitle">{{ $barangay }}, Tabaco City, Albay</div></td></tr>
        <tr class="section-gap"><td colspan="6"></td></tr>
        <tr><td class="meta meta-label">Report Date</td><td class="meta meta-value">{{ $reportDate }}</td><td class="meta meta-label">Total Cases</td><td class="meta meta-value">{{ $patients->count() }}</td><td class="meta meta-label">Barangay</td><td class="meta meta-value">{{ $barangay }}</td></tr>
        <tr class="section-gap"><td colspan="6"></td></tr>
        <tr class="table-head"><th>Patient Code</th><th>Age</th><th>Gender</th><th>Disease</th><th>Date of Onset</th><th>Barangay</th></tr>
        @forelse($patients as $index => $patient)
            <tr class="{{ $index % 2 === 0 ? 'row-even' : 'row-odd' }}"><td class="text-center">{{ $patient->patient_code }}</td><td class="text-center">{{ $patient->age }}</td><td class="text-center">{{ $patient->gender }}</td><td class="text-left">{{ $patient->disease }}</td><td class="text-center">{{ $patient->date_onset?->format('F d, Y') }}</td><td class="text-left">{{ $patient->address }}</td></tr>
        @empty
            <tr><td colspan="6" class="empty-cell">No patient records found for the selected filters.</td></tr>
        @endforelse
    </table>
</body>
</html>
