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
            border: 1px dotted #000000;
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

<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> IPD Discharge Slip </strong></h3>
        </td>
    </tr>
</table>
<table class="items" id="print-info" width="100%"
       style="font-size: 9pt; border-collapse: collapse; margin-top: 10px; border: 0" cellpadding="8" border="1">
    <tbody>
    <tr>
        <td style="width: 30%"><strong><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>:</strong></td>
        <td> <?php echo $patient -> id ?> </td>
    </tr>
    <tr>
        <td style="width: 30%"><strong><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?>:</strong></td>
        <td> <?php echo get_patient_name (0, $patient) ?> </td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Admission No:</strong></td>
        <td> <?php echo $slip -> admission_no ?> </td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Doctor:</strong></td>
        <td> <?php echo get_doctor ( $slip -> doctor_id ) -> name ?> </td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Panel/Pvt:</strong></td>
        <td> <?php echo $slip -> panel_pvt ?> </td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Room/Bed No:</strong></td>
        <td> <?php echo $slip -> room_bed_no ?> </td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Admission Date:</strong></td>
        <td> <?php echo date_setter ( $slip -> admission_date ) ?> </td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Discharge Date:</strong></td>
        <td> <?php echo date_setter ( $slip -> discharge_date ) ?> </td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Diagnosis:</strong></td>
        <td> <?php echo $slip -> diagnosis ?> </td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Operation Procedure:</strong></td>
        <td> <?php echo $slip -> operation_procedure ?> </td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Rest Advise:</strong></td>
        <td> <?php echo $slip -> rest_advise ?> </td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Days Week:</strong></td>
        <td> <?php echo $slip -> days_week ?> </td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Follow Up Treatment:</strong></td>
        <td> <?php echo $slip -> follow_up_treatment ?> </td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Revisit On:</strong></td>
        <td> <?php echo $slip -> revisit_on ?> </td>
    </tr>
    </tbody>
</table>

</body>
</html>