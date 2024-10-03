<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            size   : auto;
            header : myheader;
            footer : myfooter;
        }
        
        body {
            font-family : sans-serif;
            font-size   : 10pt;
        }
        
        p {
            margin : 0pt;
        }
        
        table.items {
            border : 0.1mm solid #000000;
        }
        
        table#print-info {
            border : 0;
        }
        
        td {
            vertical-align : top;
        }
        
        .items td {
            border-left  : 0.1mm solid #000000;
            border-right : 0.1mm solid #000000;
        }
        
        #print-info td {
            border-left  : 0;
            border-right : 0;
        }
        
        table thead td {
            background-color : #EEEEEE;
            text-align       : center;
            border           : 0.1mm solid #000000;
            font-variant     : small-caps;
        }
        
        .items td.blanktotal {
            background-color : #EEEEEE;
            border           : 0.1mm solid #000000;
            background-color : #FFFFFF;
            border           : 0mm none #000000;
            border-top       : 0.1mm solid #000000;
            border-right     : 0.1mm solid #000000;
        }
        
        .items td.totals {
            text-align  : right;
            border      : 0.1mm solid #000000;
            font-weight : 800 !important;
        }
        
        .items td.cost {
            text-align : center;
        }
        
        .totals {
            font-weight : 800 !important;
        }
        
        .parent {
            padding-left : 25px;
        }
        
        #print-info tr td {
            border-bottom : 1px dotted #000000;
            padding-left  : 0;
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
            <h3><strong> Death Certificate </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <tbody>
    <tr>
        <td style="width: 30%"><strong>Hospital Registration No</strong></td>
        <td style="width: 70%"><?php echo BIRTH_CERT_REG . $certificate -> id . '-' . date ( 'Y', strtotime ( $certificate -> death_date ) ) ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>This certifies that</strong></td>
        <td style="width: 70%"><?php echo get_patient_name ( 0, $patient ) ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>CNIC No</strong></td>
        <td style="width: 70%"><?php echo $patient -> cnic ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>S/O, D/O, W/O. M/O</strong></td>
        <td style="width: 70%"><?php echo $patient -> father_name ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Declare Death At</strong></td>
        <td style="width: 70%"><?php echo date_setter_without_time ( $certificate -> death_date ) ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Death Time</strong></td>
        <td style="width: 70%"><?php echo date ( 'g:i A', strtotime ( $certificate -> death_time ) ) ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Gender</strong></td>
        <td style="width: 70%"><?php echo get_patient_gender ( 0, $patient ) ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Age</strong></td>
        <td style="width: 70%"><?php echo get_patient_age ( 0, $patient ) ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Ward</strong></td>
        <td style="width: 70%"><?php echo @get_room_by_id ( $certificate -> room_id ) -> title ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Cause of Death</strong></td>
        <td style="width: 70%"><?php echo $certificate -> death_cause ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Permanent Address</strong></td>
        <td style="width: 70%"><?php echo $patient -> address ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Admitted On</strong></td>
        <td style="width: 70%"><?php echo date_setter ( $patient -> date_registered ) ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Consultant</strong></td>
        <td style="width: 70%"><?php echo get_doctor ( $certificate -> doctor_id ) -> name ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Diagnosis</strong></td>
        <td style="width: 70%"><?php echo $certificate -> diagnosis ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Body Handed To</strong></td>
        <td style="width: 70%"><?php echo $certificate -> body_handed_to ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>Relation</strong></td>
        <td style="width: 70%"><?php echo $certificate -> relation ?></td>
    </tr>
    <tr>
        <td style="width: 30%"><strong>CNIC No</strong></td>
        <td style="width: 70%"><?php echo $certificate -> guardian_cnic ?></td>
    </tr>
    </tbody>
</table>

<table width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px; border: 0" cellpadding="8"
       border="0">
    <tbody>
    <tr>
        <td align="center" style="width: 40%; padding-top: 80px;">
            -<br />
            _____________________________
        </td>
        <td align="center" style="width: 20%; padding-top: 80px;">
            <?php echo $patient -> id ?> <br />
            _____________________________
        </td>
        <td align="center" style="width: 40%; padding-top: 80px;">
            -<br />
            _____________________________
        </td>
    </tr>
    <tr>
        <td align="center" style="width: 40%;"><strong>Admin Signature</strong></td>
        <td align="center" style="width: 20%;"><strong>EMR</strong></td>
        <td align="center" style="width: 40%;"><strong>Doctor Signature</strong></td>
    </tr>
    </tbody>
</table>

</body>
</html>