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

        .parent {
            padding-left: 25px;
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
                    echo '<br>';
                    foreach ( $consultants as $consultant )
                        if ( $consultant -> service_id > 0 ) {
                            echo get_ipd_service_by_id ( $consultant -> service_id ) -> title . ' / ' . get_doctor ( $consultant -> doctor_id ) -> name . '<br>';
                        }
                }
            ?>
        <td width="50%" style="text-align: right;">
            <strong style="font-size: 28px"><?php echo $sale_id ?></strong> <br /><br />
            <strong>Admission No:</strong> <?php echo $_REQUEST[ 'sale_id' ] ?> <br />
            <?php
                $patient_info = get_patient ( $patient_id );
                if ( $patient_info -> panel_id > 0 ) {
                    $panel = get_panel_by_id ( $patient_info -> panel_id );
                    ?>
                    <div style="text-align: right; width: 100%; display: block; text-align: right">
                        <strong>Panel Name:</strong> <?php echo $panel -> name ?>
                        <br>
                        <strong>Panel Code:</strong> <?php echo $panel -> code ?>
                    </div>
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
<table width="100%" style="font-size: 9pt; border-collapse: collapse; border: none; page-break-inside:avoid"
       cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> IPD Consolidated Bill </strong></h3>
        </td>
    </tr>
</table>

<?php if ( count ( $ipd_associated_services ) > 0 ) : ?>
    <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0; page-break-inside:avoid"
           cellpadding="0" border="0">
        <tr style="margin-left: 0">
            <td style="margin-left: 0">
                <strong style="font-size: 14px; float: left; width: 100%">IPD Charges</strong>
            </td>
        </tr>
    </table>
<?php endif; ?>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <tbody>
    <!-- IPD SERVICES -->
    <?php
        $services_net = 0;
        if ( count ( $ipd_associated_services ) > 0 ) {
            $counter = 1;
            ?>
            <?php
            foreach ( $ipd_associated_services as $ipd_associated_service ) {
                $ipd_service  = get_ipd_service_by_id ( $ipd_associated_service -> service_id );
                $services_net = $services_net + $ipd_associated_service -> net_price;
                ?>
                <tr>
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td> <?php echo $ipd_service -> title ?> </td>
                    <td align="center">
                        <?php
                            if ( $ipd_associated_service -> doctor_id > 0 ) {
                                echo get_doctor ( $ipd_associated_service -> doctor_id ) -> name;
                            }
                            else
                                echo '-';
                        ?>
                    </td>
                    <td align="center">
                        <?php
                            if ( !empty( trim ( $ipd_associated_service -> charge_per ) ) )
                                echo $ipd_associated_service -> charge_per_value . ' ' . $ipd_associated_service -> charge_per;
                            else
                                echo '-';
                        ?>
                    </td>
                    <td align="right"> <?php echo number_format ( $ipd_associated_service -> net_price, 2 ) ?> </td>
                    <td align="right"> <?php echo $ipd_associated_service -> date_added ?> </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <?php
        if ( count ( $ipd_associated_services ) > 0 ) { ?>
            <tfoot>
            <tr>
                <td colspan="4"></td>
                <td align="right"><strong><?php echo number_format ( $services_net, 2 ) ?></strong></td>
                <td></td>
            </tr>
            </tfoot>
        <?php } ?>
</table>

<?php if ( count ( $ipd_lab_tests ) > 0 ) : ?>
    <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0; page-break-inside:avoid"
           cellpadding="0" border="0">
        <tr style="margin-left: 0">
            <td style="margin-left: 0">
                <strong style="font-size: 14px; float: left; width: 100%">Diagnostic/Treatment Test
                                                                          Charges</strong>
            </td>
        </tr>
    </table>
<?php endif; ?>
<?php if ( count ( $ipd_lab_tests ) > 0 ) { ?>
    <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
           border="1" cellpadding="5px" autosize="1">
        <tbody>
        <!-- LAB SERVICES -->
        <?php
            $counter = 1;
            $lab_net = 0;
        ?>
        <?php
            foreach ( $ipd_lab_tests as $ipd_lab_test ) {
                $test    = get_test_by_id ( $ipd_lab_test -> test_id );
                $lab_net = $lab_net + $ipd_lab_test -> net_price;
                if ( !check_if_test_is_child ( $test -> id ) ) { ?>
                    <tr>
                        <td align="center"> <?php echo $counter++ ?> </td>
                        <td> <?php echo $test -> name ?> </td>
                        <td align="right"> <?php echo number_format ( $ipd_lab_test -> net_price, 2 ) ?> </td>
                        <td align="right"> <?php echo $ipd_lab_test -> date_added ?> </td>
                    </tr>
                    <?php
                }
            }
        ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2"></td>
            <td align="right"><strong><?php echo number_format ( $lab_net, 2 ) ?></strong></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
<?php } ?>

<?php if ( count ( $medication ) > 0 ) : ?>
    <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0;"
           cellpadding="0" border="0">
        <tr style="margin-left: 0">
            <td style="margin-left: 0">
                <strong style="font-size: 14px; float: left; width: 100%">Pharmacy Charges</strong>
            </td>
        </tr>
    </table>
<?php endif; ?>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%;" border="1"
       cellpadding="5px">
    <tbody>
    <!-- MEDICATION -->
    <?php
        $medicine_net = 0;
        if ( count ( $medication ) > 0 ) {
            $counter = 1;
            ?>
            <tr>
                <th align="left"></th>
                <th align="left"> Description</th>
                <th align="right"> Total</th>
                <th align="right"> Date Added</th>
            </tr>
            <?php
            foreach ( $medication as $med ) {
                $medicine     = get_medicine ( $med -> medicine_id );
                $medicine_net = $medicine_net + $med -> net_price;
                $generic      = get_generic ( $medicine -> generic_id );
                $form         = get_form ( $medicine -> form_id );
                $strength     = get_strength ( $medicine -> strength_id );
                ?>
                <tr>
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td> <?php echo $medicine -> name ?> (
                        <?php
                            if ( $medicine -> generic_id > 1 )
                                echo $generic -> title;
                            if ( $medicine -> form_id > 1 )
                                echo $form -> title;
                            if ( $medicine -> strength_id > 1 )
                                echo $strength -> title;
                        ?>)
                    </td>
                    <td align="right"> <?php echo number_format ( $med -> net_price, 2 ) ?> </td>
                    <td align="right"> <?php echo $med -> date_added ?> </td>
                </tr>
                <?php
            }
            ?>
            <?php
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2"></td>
        <td align="right"><strong><?php echo number_format ( $medicine_net, 2 ) ?></strong></td>
        <td></td>
    </tr>
    </tfoot>
</table>

<?php if ( count ( $xray ) > 0 ) : ?>
    <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0"
           cellpadding="0" border="0">
        <tr style="margin-left: 0">
            <td style="margin-left: 0">
                <strong style="font-size: 14px; float: left; width: 100%">X-Ray Charges</strong>
            </td>
        </tr>
    </table>
<?php endif; ?>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <tbody>
    <!-- XRAY -->
    <?php
        if ( count ( $xray ) > 0 ) {
            $counter = 1;
            ?>
            <?php
            foreach ( $xray as $item ) {
                $ipd_service = get_ipd_service_by_id ( $item -> service_id );
                ?>
                <tr>
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td> <?php echo $ipd_service -> title ?> </td>
                    <td align="center">
                        <?php
                            if ( !empty( trim ( $item -> charge_per ) ) )
                                echo $item -> charge_per_value . ' ' . $item -> charge_per;
                            else
                                echo '-';
                        ?>
                    </td>
                    <td align="right"> <?php echo number_format ( $item -> net_price, 2 ) ?> </td>
                    <td align="right"> <?php echo $item -> date_added ?> </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>

<?php if ( count ( $ultrasound ) > 0 ) : ?>
    <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0; page-break-inside:avoid"
           cellpadding="0" border="0">
        <tr style="margin-left: 0">
            <td style="margin-left: 0">
                <strong style="font-size: 14px; float: left; width: 100%">Ultrasound Charges</strong>
            </td>
        </tr>
    </table>
<?php endif; ?>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <tbody>
    <!-- ULTRASOUND -->
    <?php
        if ( count ( $ultrasound ) > 0 ) {
            $counter = 1;
            foreach ( $ultrasound as $item ) {
                $ipd_service = get_ipd_service_by_id ( $item -> service_id );
                ?>
                <tr>
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td> <?php echo $ipd_service -> title ?> </td>
                    <td align="center">
                        <?php
                            if ( !empty( trim ( $item -> charge_per ) ) )
                                echo $item -> charge_per_value . ' ' . $item -> charge_per;
                            else
                                echo '-';
                        ?>
                    </td>
                    <td align="right"> <?php echo number_format ( $item -> net_price, 2 ) ?> </td>
                    <td align="right"> <?php echo $item -> date_added ?> </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <tbody>
    <!-- ECG -->
    <?php
        if ( count ( $ecg ) > 0 ) {
            $counter = 1;
            foreach ( $ecg as $item ) {
                $ipd_service = get_ipd_service_by_id ( $item -> service_id );
                ?>
                <tr>
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td> <?php echo $ipd_service -> title ?> </td>
                    <td align="center">
                        <?php
                            if ( !empty( trim ( $item -> charge_per ) ) )
                                echo $item -> charge_per_value . ' ' . $item -> charge_per;
                            else
                                echo '-';
                        ?>
                    </td>
                    <td align="right"> <?php echo number_format ( $item -> net_price, 2 ) ?> </td>
                    <td align="right"> <?php echo $item -> date_added ?> </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <tbody>
    <!-- ECHO -->
    <?php
        if ( count ( $echo ) > 0 ) {
            $counter = 1;
            foreach ( $echo as $item ) {
                $ipd_service = get_ipd_service_by_id ( $item -> service_id );
                ?>
                <tr>
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td> <?php echo $ipd_service -> title ?> </td>
                    <td align="center">
                        <?php
                            if ( !empty( trim ( $item -> charge_per ) ) )
                                echo $item -> charge_per_value . ' ' . $item -> charge_per;
                            else
                                echo '-';
                        ?>
                    </td>
                    <td align="right"> <?php echo number_format ( $item -> net_price, 2 ) ?> </td>
                    <td align="right"> <?php echo $item -> date_added ?> </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>

<table class="items" width="100%" style="font-size: 9pt; margin-top: 10px; border: none" cellpadding="0" border="0">
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

<div class="signature" style="width: 100%; display: block; float: left; margin-top: 50px">
    <div class="prepared-by"
         style="width: 25%; float: left; display: inline-block; border-top: 2px solid #000000; margin-right: 25px; text-align: center">
        <strong>Authorized Officer</strong>
    </div>
    <div class="verified-by"
         style="width: 25%; float: left; display: inline-block; border-top: 2px solid #000000; margin-left: 25px; text-align: center">
        <strong>Verified By</strong>
    </div>
</div>

</body>
</html>
