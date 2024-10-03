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
            border: 0;
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
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Initial Deposit Slip </strong></h3>
        </td>
    </tr>
</table>
<br />
<div style="width: 100%; display: block; float: left">
    <p style="text-align: right; float: right; display: inline-block; width: 50%;">
        <strong>Date & Time:</strong> <?php echo date ( 'Y-m-d H:i:s A' ) ?>
    </p>
</div>
<br>

<?php $patient = get_patient ( $slip -> patient_id ); ?>
<table width="100%" style="border-collapse: collapse; font-size: 9pt" cellpadding="8" border="1">
    <tbody>
    <tr>
        <td width="30%">
            <strong>EMR:</strong>
        </td>
        <td>
            <?php echo $patient -> id ?>
        </td>
    </tr>
    
    <tr>
        <td width="30%">
            <strong>Name:</strong>
        </td>
        <td>
            <?php echo get_patient_name (0, $patient) ?>
        </td>
    </tr>
    
    <?php if ( !empty( trim ( $slip -> panel_pvt ) ) ) : ?>
        <tr>
            <td width="30%">
                <strong>Panel/PVT:</strong>
            </td>
            <td>
                <?php echo $slip -> panel_pvt; ?>
            </td>
        </tr>
    <?php endif; ?>
    
    <?php
        if ( !empty( trim ( $slip -> room_id ) ) && !empty( trim ( $slip -> bed_id ) ) ) :
            $bed = get_bed_by_id ( $slip -> bed_id );
            $room = get_room_by_id ( $slip -> room_id );
            ?>
            <tr>
                <td width="30%">
                    <strong>Room/Bed No:</strong>
                </td>
                <td>
                    <?php echo $room -> title . '/' . $bed -> title; ?>
                </td>
            </tr>
        <?php endif; ?>
    
    <?php if ( !empty( trim ( $slip -> admission_no ) ) ) : ?>
        <tr>
            <td width="30%">
                <strong>Admission No:</strong>
            </td>
            <td>
                <?php echo $slip -> admission_no; ?>
            </td>
        </tr>
    <?php endif; ?>
    
    <?php if ( !empty( trim ( $slip -> contact_no ) ) ) : ?>
        <tr>
            <td width="30%">
                <strong>Contact No:</strong>
            </td>
            <td>
                <?php echo $slip -> contact_no; ?>
            </td>
        </tr>
    <?php endif; ?>
    
    <?php if ( !empty( trim ( $sale_billing -> initial_deposit ) ) ) : ?>
        <tr>
            <td width="30%">
                <strong>Payment:</strong>
            </td>
            <td>
                <?php echo number_format ( $sale_billing -> initial_deposit, 2 ); ?>
            </td>
        </tr>
    <?php endif; ?>
    
    <?php if ( !empty( trim ( $slip -> date_added ) ) ) : ?>
        <tr>
            <td width="30%">
                <strong>Date of Payment:</strong>
            </td>
            <td>
                <?php echo date ( 'm/d/Y g:i a', strtotime ( $slip -> date_added ) ); ?>
            </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div class="slip" style="width: 100%; float: left; margin-top: 100px !important;">
    <div style="width: 50%; float: right; display: inline-block">
        <div style="width: 250px; border-top: 1px solid #000000; text-align: center; float: right">
            Admission & Discharge
        </div>
    </div>
</div>
</body>
</html>