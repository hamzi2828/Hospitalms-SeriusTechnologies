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
<div style="text-align: right">
    <strong><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>:</strong> <?php echo $order -> patient_id ?> <br>
    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Admission Order Invoice </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <tbody>
    <tr>
        <td>
            <strong> Drug Allergies </strong>
        </td>
        <td><?php echo $order -> drug_allergies ?></td>
    </tr>
    <tr>
        <td>
            <strong> Admission No </strong>
        </td>
        <td><?php echo $record -> admission_no ?></td>
    </tr>
    <tr>
        <td>
            <strong> Medicine </strong>
        </td>
        <td><?php echo $record -> medicine ?></td>
    </tr>
    <tr>
        <td>
            <strong> Doctor </strong>
        </td>
        <td><?php echo get_doctor ( $record -> doctor_id ) -> name ?></td>
    </tr>
    <tr>
        <td>
            <strong> Admission Date & Time </strong>
        </td>
        <td><?php echo $record -> order_date_time ?></td>
    </tr>
    <tr>
        <td>
            <strong> Diagnosis </strong>
        </td>
        <td><?php echo $record -> diagnosis ?></td>
    </tr>
    <tr>
        <td>
            <strong> Condition </strong>
        </td>
        <td><?php echo $record -> condition ?></td>
    </tr>
    <tr>
        <td>
            <strong> Activity </strong>
        </td>
        <td><?php echo $record -> activity ?></td>
    </tr>
    <tr>
        <td>
            <strong> Vital Signs </strong>
        </td>
        <td><?php echo $record -> vital_signs ?></td>
    </tr>
    <tr>
        <td>
            <strong> Diet </strong>
        </td>
        <td><?php echo $record -> diet ?></td>
    </tr>
    <tr>
        <td>
            <strong> Investigation </strong>
        </td>
        <td><?php echo $record -> investigation ?></td>
    </tr>
    </tbody>
</table>

</body>
</html>