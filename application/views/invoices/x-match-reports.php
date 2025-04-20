<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            size: auto;
            header: myheader;
            footer: myfooter;
        }

        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        p {
            margin: 0pt;
        }

        table.items {
            border: 0.1mm solid #000000;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        table thead td {
            background-color: #EEEEEE;
            text-align: center;
            border: 0.1mm solid #000000;
            font-variant: small-caps;
        }

        .items td.blanktotal {
            background-color: #EEEEEE;
            border: 0.1mm solid #000000;
            background-color: #FFFFFF;
            border: 0mm none #000000;
            border-top: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        .items td.totals {
            text-align: right;
            border: 0.1mm solid #000000;
            font-weight: 800 !important;
        }

        .items td.cost {
            text-align: center;
        }

        .totals {
            font-weight: 800 !important;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
    <?php require 'pdf-header.php'; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
    <?php require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<br />

<br>
<!-- Main Report Info -->
<?php
$patient = get_patient(@$x_match_report['patient_id']);
?>
<table width="100%">
    <tr>
        <td width="60%" align="left" style="color:#000; ">
            <span style="font-size: 8pt;"><strong>Report ID:</strong> <?php echo @$x_match_report['id']; ?></span><br>
            <span style="font-size: 8pt;"><strong> MR No: </strong> <?php echo @$patient->id; ?></span><br>
            <span style="font-size: 8pt;"><strong> Name: </strong> <?php echo @get_patient_name(0, $patient); ?></span><br>
            <span style="font-size: 8pt;"><strong> Gender: </strong> <?php echo (@$patient->gender == 1) ? 'Male' : 'Female'; ?></span><br>
            <span style="font-size: 8pt;">
                <strong> Age: </strong>
                <?php
                    echo @$patient->age . ' ' . ucwords($patient->age_year_month);
                ?>
            </span><br>
            <?php if (!empty(trim($patient->cnic))) : ?>
                <span style="font-size: 8pt;"><strong> CNIC: </strong> <?php echo @$patient->cnic; ?></span><br>
            <?php endif; ?>
            <span style="font-size: 8pt;"><strong>Blood Type:</strong> <?php echo @$x_match_report['blood_type']; ?></span><br>
            <span style="font-size: 8pt;"><strong>Created At:</strong> <?php echo date('d-m-Y H:i', strtotime(@$x_match_report['created_at'])); ?></span>
        </td>
        <td width="40%" align="right" style="font-size: 8pt">
            <!-- Optionally add barcode or other info here -->
        </td>
    </tr>
</table>
<br>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong>Cross Match Report</strong></h3>
        </td>
    </tr>
</table>
<br>
<!-- Tests Table -->
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8" border="1">
    <thead>
        <tr>
            <th>Sr. No</th>
            <th>Test Name</th>
            <th>Cut Off Value</th>
            <th>Patient Value</th>
            <th>Result</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($x_match_report['tests'])): ?>
            <?php foreach ($x_match_report['tests'] as $i => $test): ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo htmlspecialchars($test['test_name']); ?></td>
                    <td><?php echo htmlspecialchars($test['cut_off_value']); ?></td>
                    <td><?php echo htmlspecialchars($test['patient_value']); ?></td>
                    <td><?php echo htmlspecialchars($test['result']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align:center;">No test data found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</body>
</html>
