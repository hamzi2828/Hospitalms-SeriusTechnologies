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
            border: none;
        }
        

        td {
            vertical-align: top;
            border: none;
        }

        .items td {
            border-left: none;
            border-right: none;
            border: none;
            border-bottom : 0.1mm dotted #000000;
        }

        table thead td {
            background-color: #EEEEEE;
            text-align: center;
            border: none;
            font-variant: small-caps;
        }

        .items td.blanktotal {
            background-color: #FFFFFF;
            border: none;
        }

        .items td.totals {
            text-align: right;
            border: none;
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
    <?php require 'pdf-blood-bank-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->


<!-- Main Report Info -->
<?php
$patient = get_patient(@$x_match_report['patient_id']);
$reference = get_reference_details_by_id($patient->reference_id);
?>
<table width="100%">
    <tr>
        <td width="50%" align="left" style="color:#000; vertical-align:top;">
            <!-- First section -->
            <span style="font-size: 8pt;"><strong>Report ID:</strong> <?php echo @$x_match_report['id']; ?></span><br>
            <span style="font-size: 8pt;"><strong> MR No: </strong> <?php echo @$patient->id; ?></span><br>
            <span style="font-size: 8pt;"><strong> Name: </strong> <?php echo @get_patient_name(0, $patient); ?></span><br>
            <span style="font-size: 8pt;"><strong> Gender: </strong> <?php echo (@$patient->gender == 1) ? 'Male' : 'Female'; ?></span><br>
            <span style="font-size: 8pt;">
                <strong> Age: </strong>
                <?php echo @$patient->age . ' ' . ucwords($patient->age_year_month); ?>
            </span><br>

        </td>
        <td width="50%" align="right" style="font-size: 8pt; vertical-align:top;">
        <?php if (!empty(trim($patient->cnic))) : ?>
                <span style="font-size: 8pt;"><strong> CNIC: </strong> <?php echo @$patient->cnic; ?></span><br>
            <?php endif; ?>
            <span style="font-size: 8pt;"><strong>Collection Date & Time:</strong> <?php echo date('d-m-Y H:i', strtotime(@$x_match_report['report_collection_date_time'])); ?></span><br>
            

            <span style="font-size: 8pt;"><strong>Reporting Time:</strong> <?php echo date('d-m-Y H:i'); ?></span><br>

            <span style="font-size: 8pt;">
                <strong>Referred By:</strong> <?php echo $reference-> title ?></span><br>
        </td>
    </tr>
</table>
<br>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong>Department of Blood Bank</strong></h3>
        </td>
    </tr>
</table>
<br>
<span style="font-size: 8pt;"><strong>Donor Name:</strong> <?php echo @$x_match_report['donor_name']; ?></span><br>
<!-- Tests Table -->
<table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; margin-top: 15px; border: 0"
    cellpadding="8">
    <thead>
        <tr style="background: #f5f5f5;">
            <th style="text-align: left; ">Test Name</th>
            <th style="text-align: left;">Cut Off Value</th>
            <th style="text-align: left;">Patient Value</th>
            <th style="text-align: left;">Result</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($x_match_report['tests'])): ?>
            <?php foreach ($x_match_report['tests'] as $i => $test): ?>
                <?php if ($test['test_name'] === '<h4>DONOR</h4>'): ?>
                    <?php continue; // Skip this, handle before Donor Blood Group ?>
                <?php elseif ($test['test_name'] === 'Donor Blood Group'): ?>
                    <tr>
                        <td colspan="5"><h4>DONOR</h4></td>
                    </tr>
                    <tr>
                        <td><?php echo htmlspecialchars($test['test_name']); ?></td>
                        <td><?php echo htmlspecialchars($test['cut_off_value']); ?></td>
                        <td><?php echo htmlspecialchars($test['patient_value']); ?></td>
                        <td><?php echo htmlspecialchars($test['result']); ?></td>
                    </tr>
                <?php elseif ($test['test_name'] === '<h4>PATIENT</h4>'): ?>
                    <?php continue; // Skip this, handle after Recipient Name: ?>
                <?php elseif ($test['test_name'] === 'Recipient Name:'): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($test['test_name']); ?></td>
                        <td><?php echo htmlspecialchars($test['cut_off_value']); ?></td>
                        <td><?php echo htmlspecialchars($test['patient_value']); ?></td>
                        <td><?php echo htmlspecialchars($test['result']); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5"><h4>PATIENT</h4></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?php echo htmlspecialchars($test['test_name']); ?></td>
                        <td><?php echo htmlspecialchars($test['cut_off_value']); ?></td>
                        <td><?php echo htmlspecialchars($test['patient_value']); ?></td>
                        <td><?php echo htmlspecialchars($test['result']); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if (!empty($x_match_report['remarks'])): ?>
                <tr>
                    <td colspan="5" style="text-align:left; border-bottom: none;"><strong>Remarks:</strong> <?php echo htmlspecialchars($x_match_report['remarks']); ?></td>
                </tr>
            <?php endif; ?>

        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align:center;">No test data found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</body>
</html>
