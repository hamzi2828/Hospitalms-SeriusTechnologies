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

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0;
            border-right: 0;
        }

        table thead td {
            background-color: #EEEEEE;
            text-align: center;
            border: 0;
            font-variant: small-caps;
        }

        .items td.blanktotal {
            background-color: #EEEEEE;
            border: 0;
            background-color: #FFFFFF;
            border: 0;
            border-top: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        .items td.totals {
            text-align: right;
            border: 0;
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
<table width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Admission Slip </strong></h3>
        </td>
    </tr>
</table>
<br>

<?php $patient = get_patient ( $slip -> patient_id ); ?>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; border: 1px solid #000000 "
       cellpadding="8" border="1">
    <tbody>
    <tr>
        <td><strong>Admission No</strong></td>
        <td><?php echo $slip -> admission_no ?></td>
    </tr>
    
    <tr>
        <td><strong>Admission Date</strong></td>
        <td><?php echo date ( 'm/d/Y', strtotime ( $slip -> admission_date ) ) ?></td>
    </tr>
    
    <tr>
        <td><strong><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></strong></td>
        <td><?php echo $slip -> patient_id ?></td>
    </tr>
    
    <tr>
        <td><strong><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></strong></td>
        <td><?php echo get_patient_name (0, $patient) ?></td>
    </tr>
    
    <tr>
        <td><strong><?php echo $this -> lang -> line ( 'PATIENT_AGE' ); ?></strong></td>
        <td><?php echo $patient -> age ?></td>
    </tr>
    
    <tr>
        <td><strong>Gender</strong></td>
        <td><?php echo $patient -> gender == '1' ? 'Male' : 'Female' ?></td>
    </tr>
    
    <tr>
        <td><strong>Contact No</strong></td>
        <td><?php echo $patient -> mobile ?></td>
    </tr>
    
    <tr>
        <td><strong>Panel/PVT</strong></td>
        <td><?php echo $slip -> panel_pvt ?></td>
    </tr>
    
    <tr>
        <td><strong>Room No</strong></td>
        <td><?php echo @get_room_by_id ( $slip -> room_id ) -> title ?></td>
    </tr>
    
    <tr>
        <td><strong>Bed No</strong></td>
        <td><?php echo @get_bed_by_id ( $slip -> bed_id ) -> title ?></td>
    </tr>
    
    <tr>
        <td><strong>Consultant</strong></td>
        <td><?php echo get_doctor ( $slip -> doctor_id ) -> name ?></td>
    </tr>
    
    <tr>
        <td><strong>Date of Payment</strong></td>
        <td><?php echo date_setter ( $slip -> date_added ) ?></td>
    </tr>
    
    <?php if ( $slip -> package_id > 0 ) : ?>
        <tr>
            <td><strong>Package</strong></td>
            <td><?php echo get_package_by_id ( $slip -> package_id ) -> title ?></td>
        </tr>
        
        <tr>
            <td><strong>Package Price</strong></td>
            <td><?php echo number_format ( $slip -> package, 2 ) ?></td>
        </tr>
    <?php endif ?>
    
    <?php if ( !empty( trim ( $slip -> remarks ) ) ) : ?>
        <tr>
            <td><strong>Remarks</strong></td>
            <td><?php echo $slip -> remarks ?></td>
        </tr>
    <?php endif ?>
    </tbody>
</table>

<br><br><br><br>
<div class="slip" style="width: 100%; float: left; margin-top: 100px !important;">
    <div style="width: 50%; float: left; display: inline-block">
        <div style="width: 250px; border-top: 1px solid #000000; text-align: center">
            Medical Officer Signature
        </div>
        <br /><br /><br /><br /><br />
        <div style="width: 250px; border-top: 1px solid #000000; text-align: center">
            Consultant Signature
        </div>
    </div>
    <div style="width: 50%; float: right; display: inline-block">
        <div style="width: 250px; border-top: 1px solid #000000; text-align: center; float: right">
            Admission & Discharge
        </div>
    </div>
</div>
</body>
</html>