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

        .has-medicines td {
            background: #bce8f1 !important;
            font-size: 16px;
            font-weight: 800 !important;
        }

        .items td {
            border-bottom: 0.1mm solid #000000;
        }

        .items td:last-child {
            border-bottom: 0;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="firstpage">
    <?php require 'pdf-header.php'; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
    <?php require 'pdf-footer.php'; ?>
</htmlpagefooter>

<htmlpageheader name="otherpages" style="display:none"></htmlpageheader>

<sethtmlpageheader name="firstpage" value="on" show-this-page="1" />
<sethtmlpageheader name="otherpages" value="on" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<table width="100%">
    <tr>
        <td width="50%" style="color:#000; ">
            <b><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>: </b><?php echo $patient_id ?><br />
            <b><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?>
                : </b><?php echo get_patient_name ( 0, $patient ) ?><br />
            <b><?php echo $this -> lang -> line ( 'PATIENT_PHONE' ); ?>: </b><?php echo $patient -> mobile ?><br />
            <b><?php echo $this -> lang -> line ( 'PATIENT_AGE' ); ?>: </b><?php echo $patient -> age ?><br />
            <?php
                if ( count ( $consultants ) > 0 ) {
                    echo '<br/>';
                    foreach ( $consultants as $consultant )
                        if ( $consultant -> service_id > 0 ) {
                            echo get_ipd_service_by_id ( $consultant -> service_id ) -> title . ' / ' . get_doctor ( $consultant -> doctor_id ) -> name . '<br>';
                        }
                }
            ?>
        <td width="50%" style="text-align: right;">
            <strong style="font-size: 28px"><?php echo $sale_id ?></strong> <br /> <br />
            <strong>Admission No:</strong> <?php echo $_REQUEST[ 'sale_id' ] ?> <br />
            <?php
                $patient_info = get_patient ( $patient_id );
                if ( $patient_info -> panel_id > 0 ) {
                    $panel = get_panel_by_id ( $patient_info -> panel_id );
                    ?>
                    <div style="text-align: right; width: 100%; display: block; text-align: right">
                        <br>
                        <strong>Panel Name:</strong> <?php echo $panel -> name ?>
                        <br>
                        <strong>Panel Code:</strong> <?php echo $panel -> code ?>
                    </div>
                    <br>
                    <?php
                }
            ?>
            <strong>Discharged Date:</strong>
            <?php echo !empty( trim ( $sale -> date_discharged ) ) ? date_setter ( @$sale -> date_discharged ) : 'Not yet discharged.' ?>
            <br>
            <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
        </td>
    </tr>
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> IPD Customer Invoice </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tbody>
    <tr>
        <td>1</td>
        <td>IPD Services</td>
        <td align="right"><?php echo $total_ipd_services > 0 ? number_format ( $total_ipd_services, 2 ) : 0 ?></td>
    </tr>
    <tr>
        <td>2</td>
        <td>Medication</td>
        <td align="right"><?php echo $total_medication > 0 ? number_format ( $total_medication, 2 ) : 0 ?></td>
    </tr>
    <tr>
        <td>3</td>
        <td>Lab Tests</td>
        <td align="right"><?php echo $total_lab_services > 0 ? number_format ( $total_lab_services, 2 ) : 0 ?></td>
    </tr>
    <tr>
        <td colspan="3" align="right" style="border-bottom: 0">
            <strong>
                <?php echo number_format ( $total_ipd_services + $total_medication + $total_lab_services, 2 ) ?>
            </strong>
        </td>
    </tr>
    </tbody>
</table>
<table class="items" width="100%" style="font-size: 9pt; margin-top: 30px; border: none" cellpadding="0" border="0">
    <tbody>
    <?php $to_be_paid = ( $sale_billing -> total > 0 ? $sale_billing -> net_total : $sale_billing -> total ) - $sale_billing -> initial_deposit - $count_payment; ?>
    <tr style="width: 100%; display: block; float: left; border: none;">
        <td colspan="2" align="right" style="border: none">
            <strong>Total Amount: </strong>
        </td>
        <td align="right" style="border: none">
            <?php echo number_format ( $sale_billing -> total, 2 ) ?>
        </td>
    </tr>
    <?php if ( $sale_billing -> discount > 0 ) : ?>
        <tr style="width: 100%; display: block; float: left; border: none;">
            <td colspan="2" align="right" style="border: none">
                <strong>Discount: </strong>
            </td>
            <td align="right" style="border: none">
                <?php echo number_format ( $sale_billing -> discount, 2 ) ?>
            </td>
        </tr>
    <?php endif; ?>
    <tr style="width: 100%; display: block; float: left; border: none;">
        <td colspan="2" align="right" style="border: none">
            <strong>Net Amount: </strong>
        </td>
        <td align="right" style="border: none">
            <?php echo number_format ( $sale_billing -> total > 0 ? $sale_billing -> net_total : $sale_billing -> total, 2 ) ?>
        </td>
    </tr>
    <tr style="width: 100%; display: block; float: left; border: none">
        <td colspan="2" align="right" style="border: none">
            <strong>Deposit: </strong>
        </td>
        <td align="right" style="border: none">
            <?php echo number_format ( $sale_billing -> initial_deposit ) ?>
        </td>
    </tr>
    <tr style="width: 100%; display: block; float: left; border: none">
        <td colspan="2" align="right" style="border: none">
            <strong>Payments: </strong>
        </td>
        <td align="right" style="border: none">
            <?php echo number_format ( $count_payment ) ?>
        </td>
    </tr>
    <tr style="width: 100%; display: block; float: left; border: none">
        <td colspan="2" align="right" style="border: none">
            <strong> Final Payment:</strong>
        </td>
        <td align="right" style="border: none">
            <?php echo number_format ( $to_be_paid, 2 ) ?>
        </td>
    </tr>
    </tbody>
</table>
<div class="signature" style="width: 100%; display: block; float: left; margin-top: 250px">
    <div class="prepared-by"
         style="width: 25%; float: left; display: inline-block; border-top: 2px solid #000000; margin-right: 25px; text-align: center">
        <strong>Authorized Officer</strong>
    </div>
    <div class="verified-by"
         style="width: 25%; float: right; display: inline-block; border-top: 2px solid #000000; margin-left: 25px; text-align: center">
        <strong>Verified By</strong>
    </div>
</div>
</body>
</html>