<!DOCTYPE html>
<html lang="en"
      xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:ex="urn:schemas-microsoft-com:office:excel">

<head>

    <meta charset="UTF-8">

    <!-- =====================================================
         EXCEL FREEZE PANES
         ===================================================== -->

    <!--[if gte mso 9]>
    <xml>

        <ex:ExcelWorkbook>

            <ex:ExcelWorksheets>

                <ex:ExcelWorksheet>

                    <ex:Name>{{ $periodType === 'annual' ? 'ANNUAL' : 'MONTHLY' }} (Morbidity)</ex:Name>

                    <ex:WorksheetOptions>

                        <ex:Selected/>

                        <ex:FreezePanes/>

                        <ex:FrozenNoSplit/>

                        <!-- FREEZE ROWS 1-9 -->
                        <ex:SplitHorizontal>9</ex:SplitHorizontal>

                        <ex:TopRowBottomPane>9</ex:TopRowBottomPane>

                        <!-- FREEZE COLUMNS A-B -->
                        <ex:SplitVertical>2</ex:SplitVertical>

                        <ex:LeftColumnRightPane>2</ex:LeftColumnRightPane>

                        <!-- ACTIVE AREA = AGE COLUMNS -->
                        <ex:ActivePane>0</ex:ActivePane>

                        <ex:Panes>

                            <!-- Bottom-right pane
                                 AGE COLUMNS -->
                            <ex:Pane>
                                <ex:Number>3</ex:Number>
                                <ex:ActiveRow>9</ex:ActiveRow>
                                <ex:ActiveCol>2</ex:ActiveCol>
                            </ex:Pane>

                            <!-- Top-right pane -->
                            <ex:Pane>
                                <ex:Number>1</ex:Number>
                            </ex:Pane>

                            <!-- Bottom-left pane
                                 DISEASE + ICD -->
                            <ex:Pane>
                                <ex:Number>2</ex:Number>
                            </ex:Pane>

                            <!-- Top-left pane -->
                            <ex:Pane>
                                <ex:Number>0</ex:Number>
                            </ex:Pane>

                        </ex:Panes>

                    </ex:WorksheetOptions>

                </ex:ExcelWorksheet>

            </ex:ExcelWorksheets>

        </ex:ExcelWorkbook>

    </xml>
    <![endif]-->


    <style>

        /* PAGE */
        @page {
            size: landscape;
            margin: 0.25in;
        }

        body {
            margin: 10px;
            color: #111;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9pt;
        }

        table {
            width: 3943px;
            border-collapse: collapse;
            table-layout: fixed;
        }

        td,
        th {
            border: 1px solid #111;
            padding: 3px;
            vertical-align: middle;
            overflow: hidden;
        }

        .seal-cell {
            text-align: center;
            vertical-align: middle;
            border: 0;
        }

        .seal {
            display: block;
            width: 120px;
            height: 120px;
            margin-left: auto;
            margin-right: auto;
        }

        .report-meta {
            height: 19px;
            border: 0;
            padding: 0 4px;
            color: #111;
            font-size: 11pt;
            line-height: 1.1;
            font-weight: bold;
        }

        .period-value, .place-value {
            color: #fff;
            background: #0a3b69;
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
            border: 1px solid #111;
        }

        .month {
            text-align: center;
        }

        .submission {
            border: 0 !important;
            text-align: center;
            font-size: 9pt;
            font-weight: normal !important;
        }

        .head {
            background: #0a3b69;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .column-head {
            height: 62px;
            background: #0a3b69;
            color: #fff;
            text-align: center;
            font-weight: bold;
            vertical-align: middle;
            white-space: normal;
        }

        .column-head.main-head {
            color: #fff;
            background: #0a3b69;
            font-weight: bold;
        }

        .column-head.total {
            color: #fff;
            background: #0a3b69;
            font-weight: bold;
        }

        .group-head {
            background: #d8d8d8;
            text-align: left;
            font-weight: bold;
            height: 22px;
        }

        .age-head {
            background: #c4dcf3;
            color: #111;
            font-weight: bold;
            text-align: center;
        }

        .disease {
            text-align: left;
            white-space: normal;
        }

        .icd {
            text-align: left;
            white-space: normal;
        }

        .data-row td {
            height: 20px;
            text-align: center;
        }

        .data-row .disease {
            text-align: left;
        }

        .data-row .icd {
            text-align: left;
        }

        .total {
            background: #d9d9d9;
            font-weight: normal;
        }

        .grand-total {
            background: #d9d9d9;
            font-weight: bold;
            text-align: center;
        }

        .meta-row td {
            border: 0;
        }

    </style>
</head>

<body>
@php
    $sealPath = public_path(
        'images/department-of-health-seal.jpg'
    );

    $sealData = '';

    if (is_file($sealPath)) {

        $sealData =
            'data:image/jpeg;base64,' .
            base64_encode(
                file_get_contents($sealPath)
            );
    }


    /*GET AGE GROUP COUNT*/

    $firstRow = $reportRows->first();

    $ageGroupCount = $firstRow
        ? count($firstRow['counts'])
        : 0;

    $totalColumns =
        2 +
        ($ageGroupCount * 3) +
        1;

@endphp

<table>
    <colgroup>
        <col style="width:627px">
        <col style="width:180px">
        @for(
            $i = 0;
            $i < ($ageGroupCount * 3);
            $i++
        )
            <col style="width:64px">
        @endfor
        <col style="width:64px">
    </colgroup>

    <tr>
        <td class="seal-cell" colspan="2" rowspan="7">
            @if($sealData)
                <img class="seal" src="{{ $sealData }}" width="120" height="120" alt="Department of Health seal">
            @endif
        </td>

        <td class="report-meta" colspan="5"> FHSIS REPORT for the</td>
        <td class="report-meta month" colspan="2">MONTH:</td>
        <td class="report-meta period-value" colspan="2">
            {{
                $periodType === 'annual'
                ? 'ANNUAL'
                : strtoupper($reportStart->format('F'))
            }}
        </td>

        <td class="report-meta period-value" colspan="2">{{ $reportStart->format('Y') }}</td>
        <td class="report-meta" colspan="38"></td>
    </tr>

    <tr>
        <td class="report-meta" colspan="6">Name of Health Facility:</td>
        <td class="report-meta place-value" colspan="5">{{ $healthFacility ?? '' }}</td>
        <td class="report-meta" colspan="38"></td>
    </tr>

    <tr>
        <td class="report-meta" colspan="6"> Name of Barangay:</td>
        <td class="report-meta place-value" colspan="5">{{ $barangay }}</td>
        <td class="report-meta" colspan="38"></td>
    </tr>

    <tr>
        <td class="report-meta" colspan="6">Name of Municipality/City:</td>
        <td class="report-meta place-value" colspan="5">Tabaco City</td>
        <td class="report-meta" colspan="38"></td>
    </tr>

    <tr>
        <td class="report-meta" colspan="6"> Name of Province:</td>
        <td class="report-meta place-value" colspan="5"> ALBAY</td>
        <td class="report-meta" colspan="38"></td>
    </tr>

    <tr>
        <td class="report-meta" colspan="6"> Projected Population of the Year:</td>
        <td class="report-meta place-value" colspan="5"> #N/A</td>
        <td class="report-meta" colspan="38"></td>
    </tr>

    <tr>
        <td class="report-meta submission" colspan="11">For submission to the next administrative level</td>
        <td class="report-meta" colspan="38"></td>
    </tr>

    <tr>
        <th class="head" rowspan="2">Disease/s</th>
        <th class="head" rowspan="2">ICD-Code/s</th>
        <!-- AGE GROUPS -->
        @if($firstRow)
            @foreach(
                $firstRow['counts']
                as $band => $counts
            )
                <th class="column-head" colspan="3">{{ $band }}</th>
            @endforeach
        @endif
        <!-- GRAND TOTAL -->
        <th class="column-head main-head" rowspan="2">Grand total</th>
    </tr>
    <!--TABLE HEADER - SECOND ROW-->
    <tr>
        @if($firstRow)
            @foreach($reportRows->first()['counts'] ?? [] as $counts)
                <th class="age-head">Male</th>
                <th class="age-head">Female</th>
                <th class="head total">Total</th>
            @endforeach
        @endif
    </tr>
    <!--GROUP HEADER -->
    <tr>
        <td class="group-head" colspan="{{ $totalColumns }}">Common Diseases</td>
    </tr>

    <!-- DATA ROWS -->

    @foreach($reportRows as $row)

        <tr class="data-row">
            <!-- DISEASE -->
            <td class="disease">{{ $row['disease'] }}</td>
            <!-- ICD -->
            <td class="icd">{{ $row['icd_code'] }}</td>

            <!-- AGE GROUP DATA -->

            @foreach($row['counts'] as $counts)

                <!-- MALE -->

                <td>{{ $counts['Male'] ?? 0 }}</td>

                <!-- FEMALE -->

                <td>{{ $counts['Female'] ?? 0 }}</td>

                <!-- TOTAL -->

                <td class="total">{{ $counts['Total'] ?? 0 }}</td>

            @endforeach

            <!-- GRAND TOTAL -->

            <td class="grand-total">{{ $row['grand_total'] ?? 0 }}</td>
        </tr>

    @endforeach

</table>
</body>
</html>