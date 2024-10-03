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

        table#print-info {
            border: 0;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        #print-info td {
            border-left: 0;
            border-right: 0;
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

        .parent {
            padding-left: 25px;
        }

        #print-info tr td {
            border-bottom: 1px dotted #000000;
            padding-left: 0;
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
<br>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Birth Certificate </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <tbody>
    <tr>
        <td style="width: 30%"><strong>Hospital Registration No</strong></td>
        <td style="width: 70%"><?php echo BIRTH_CERT_REG . $certificate -> id . '-' . date ( 'Y', strtotime ( $certificate -> birth_date ) ) ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Baby Name</strong></td>
        <td style="width: 70%"><?php echo $certificate -> name ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Gender</strong></td>
        <td style="width: 70%"><?php echo ucfirst ( $certificate -> gender ) ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Father Name</strong></td>
        <td style="width: 70%"><?php echo $certificate -> father_name ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Father CNIC</strong></td>
        <td style="width: 70%"><?php echo $certificate -> father_cnic ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Fathers Mobile No.</strong></td>
        <td style="width: 70%"><?php echo $certificate -> father_mobile ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Mother Name</strong></td>
        <td style="width: 70%"><?php echo $certificate -> mother_name ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Mother CNIC</strong></td>
        <td style="width: 70%"><?php echo $certificate -> mother_cnic ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Permanent Address</strong></td>
        <td style="width: 70%"><?php echo $certificate -> address ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Date Of Birth</strong></td>
        <td style="width: 70%"><?php echo $certificate -> birth_date ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Time Of Birth</strong></td>
        <td style="width: 70%"><?php echo date ( 'g:i A', strtotime ( $certificate -> birth_time ) ) ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Weight (kgs)</strong></td>
        <td style="width: 70%"><?php echo $certificate -> weight ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Any Disability</strong></td>
        <td style="width: 70%"><?php echo $certificate -> disability ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Consultant</strong></td>
        <td style="width: 70%"><?php echo get_doctor ( $certificate -> doctor_id ) -> name ?></td>
    </tr>
    <tr>
        <td style="width: 30%; padding-top: 80px"></td>
        <td style="width: 70%; padding-top: 80px"></td>
    </tr>
    <tr>
        <td style="width: 30%;"><strong>Doctor Signature</strong></td>
        <td style="width: 70%;"><strong>Admin Signature</strong></td>
    </tr>
    </tbody>
</table>

</body>
</html>