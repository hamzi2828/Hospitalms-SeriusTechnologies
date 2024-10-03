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
        
        td {
            vertical-align : top;
        }
        
        .items td {
            border-left  : 0.1mm solid #000000;
            border-right : 0.1mm solid #000000;
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
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
    <?php require 'pdf-header.php'; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
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
    <?php require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<table width="100%">
    <tr>
        <td width="50%" style="color:#000; ">
            <b><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>: </b><?php echo $patient_id ?><br />
            <b><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?>
                : </b><?php echo get_patient_name ( 0, $patient ) ?><br />
            <b><?php echo $this -> lang -> line ( 'PATIENT_PHONE' ); ?>: </b><?php echo $patient -> mobile ?><br />
            <b><?php echo $this -> lang -> line ( 'PATIENT_AGE' ); ?>: </b><?php echo $patient -> age ?><br /><br />
            <?php
                if ( count ( $consultants ) > 0 ) {
                    foreach ( $consultants as $consultant )
                        if ( $consultant -> service_id > 0 ) {
                            echo get_ipd_service_by_id ( $consultant -> service_id ) -> title . ' / ' . get_doctor ( $consultant -> doctor_id ) -> name . '<br>';
                        }
                }
            ?>
        </td>
        <td width="50%" style="text-align: right;">
            <strong style="font-size: 28px"><?php echo $sale_id ?></strong> <br /> <br />
            <strong>Admission No:</strong> <?php echo $_REQUEST[ 'sale_id' ] ?> <br>
            <strong>Admission Date:</strong>
            <?php echo date ( 'd-m-Y', strtotime ( @get_ipd_admission_date ( $_REQUEST[ 'sale_id' ] ) -> admission_date ) ) ?>
            <br>
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
<table width="100%" style="font-size: 9pt; border-collapse: collapse; border: none; page-break-inside:avoid"
       cellpadding="2" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> IPD Consolidated Bill </strong></h3>
        </td>
    </tr>
</table>
<br>

<!------------------------>
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
<table width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%;" border="1" cellpadding="5px">
    <tbody>
    <!-- IPD SERVICES -->
    <?php
        $net_ipd      = 0;
        $services_net = 0;
        $tax_value    = 0;
        if ( count ( $ipd_associated_services ) > 0 ) {
            $counter = 1;
            foreach ( $ipd_associated_services as $ipd_associated_service ) {
                $ipd_service  = get_ipd_service_by_id ( $ipd_associated_service -> service_id );
                $services_net = $services_net + $ipd_associated_service -> net_price;
                $net_ipd      += ( $ipd_associated_service -> net_price );
//                $net_ipd      = $net_ipd + $services_net;
                ?>
                <tr>
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td> <?php echo $ipd_service -> title ?> </td>
                    <td align="center">
                        <?php
                            $doctors = explode ( ',', $ipd_associated_service -> doctors );
                            if ( count ( $doctors ) > 0 ) {
                                foreach ( $doctors as $doctor_id ) {
                                    if ( $doctor_id > 0 ) {
                                        echo get_doctor ( $doctor_id ) -> name . ' <br>';
                                    }
                                    else
                                        echo '-';
                                }
                            }
                            else
                                echo '-';
                        ?>
                    </td>
                    <td align="center"> <?php echo $ipd_associated_service -> services_count ?> </td>
                    <td align="center">
                        <?php
                            if ( !empty( trim ( $ipd_associated_service -> charge_per ) ) )
                                echo $ipd_associated_service -> charge_per_value . ' ' . $ipd_associated_service -> charge_per;
                            else
                                echo '-';
                        ?>
                    </td>
                    <td align="right"> <?php echo number_format ( $ipd_associated_service -> net_price, 2 ) ?> </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="5"></td>
        <td align="right"><strong><?php echo number_format ( $services_net, 2 ) ?></strong></td>
    </tr>
    
    <?php
        if ( !empty( $panel ) && !empty( trim ( $sale_billing -> tax ) ) && $sale_billing -> tax > 0 ) {
            $tax_value = ( $net_ipd * ( $sale_billing -> tax / 100 ) );
            $net_ipd   = $net_ipd - $tax_value;
            ?>
            <tr>
                <td colspan="5" align="right">Tax (<?php echo $sale_billing -> tax . '%' ?>)</td>
                <td align="right"><?php echo number_format ( $tax_value, 2 ) ?></td>
            </tr>
            <tr>
                <td colspan="5" align="right"><strong>Net Value</strong></td>
                <td align="right"><strong><?php echo number_format ( $net_ipd, 2 ) ?></strong></td>
            </tr>
            <?php
        }
    ?>
    </tfoot>
</table>
<!------------------------>

<!------------------------>
<?php if ( count ( $ipd_associated_services_excluded ) > 0 ) : ?>
    <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0; page-break-inside:avoid"
           cellpadding="0" border="0">
        <tr style="margin-left: 0">
            <td style="margin-left: 0">
                <strong style="font-size: 14px; float: left; width: 100%">IPD Charges (Excluded)</strong>
            </td>
        </tr>
    </table>
<?php endif; ?>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%;" border="1" cellpadding="5px">
    <tbody>
    <!-- IPD SERVICES -->
    <?php
        $net_ipd_excluded      = 0;
        $services_net_excluded = 0;
        if ( count ( $ipd_associated_services_excluded ) > 0 ) {
            $counter = 1;
            foreach ( $ipd_associated_services_excluded as $ipd_associated_service ) {
                $ipd_service           = get_ipd_service_by_id ( $ipd_associated_service -> service_id );
                $services_net_excluded = $services_net_excluded + $ipd_associated_service -> net_price;
                $net_ipd_excluded      = $net_ipd_excluded + $services_net_excluded;
                ?>
                <tr>
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td> <?php echo $ipd_service -> title ?> </td>
                    <td align="center">
                        <?php
                            $doctors = explode ( ',', $ipd_associated_service -> doctors );
                            if ( count ( $doctors ) > 0 ) {
                                foreach ( $doctors as $doctor_id ) {
                                    if ( $doctor_id > 0 ) {
                                        echo get_doctor ( $doctor_id ) -> name . ' <br>';
                                    }
                                    else
                                        echo '-';
                                }
                            }
                            else
                                echo '-';
                        ?>
                    </td>
                    <td align="center"> <?php echo $ipd_associated_service -> services_count ?> </td>
                    <td align="center">
                        <?php
                            if ( !empty( trim ( $ipd_associated_service -> charge_per ) ) )
                                echo $ipd_associated_service -> charge_per_value . ' ' . $ipd_associated_service -> charge_per;
                            else
                                echo '-';
                        ?>
                    </td>
                    <td align="right"> <?php echo number_format ( $ipd_associated_service -> net_price, 2 ) ?> </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="5"></td>
        <td align="right"><strong><?php echo number_format ( $services_net_excluded, 2 ) ?></strong></td>
    </tr>
    </tfoot>
</table>
<!------------------------>

<!------------------------>
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
<table width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%;" border="1" cellpadding="5px">
    <!-- LAB SERVICES -->
    <?php
        $lab_net = 0;
        if ( count ( $ipd_lab_tests ) > 0 ) {
            $counter = 1;
            foreach ( $ipd_lab_tests as $ipd_lab_test ) {
                $test    = get_test_by_id ( $ipd_lab_test -> test_id );
                $lab_net = $lab_net + $ipd_lab_test -> net_price;
            }
            ?>
            <tr>
                <td align="center">1</td>
                <td> Sum of all tests</td>
                <td align="right"> <?php echo number_format ( $lab_net, 2 ) ?> </td>
            </tr>
            <?php
        }
    ?>
</table>
<!------------------------>


<!------------------------>
<?php if ( count ( $medication ) > 0 ) : ?>
    <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0; page-break-inside:avoid"
           cellpadding="0" border="0">
        <tr style="margin-left: 0">
            <td style="margin-left: 0">
                <strong style="font-size: 14px; float: left; width: 100%">Pharmacy Charges</strong>
            </td>
        </tr>
    </table>
<?php endif; ?>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%;" border="1" cellpadding="5px">
    <tbody>
    <!-- MEDICATION -->
    <?php
        $medicine_net = 0;
        if ( count ( $medication ) > 0 ) {
            $counter = 1;
            foreach ( $medication as $med ) {
                $medicine     = get_medicine ( $med -> medicine_id );
                $medicine_net = $medicine_net + $med -> net_price;
            }
            ?>
            
            <tr>
                <td align="center">1</td>
                <td> Sum of all medication</td>
                <td align="right"> <?php echo number_format ( $medicine_net, 2 ) ?> </td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
<!------------------------>


<!------------------------>
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
<table width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%;" border="1" cellpadding="5px">
    <tbody>
    <!-- XRAY -->
    <?php
        $xray_charges_net = 0;
        if ( count ( $xray ) > 0 ) {
            $counter = 1;
            foreach ( $xray as $item ) {
                $ipd_service      = get_ipd_service_by_id ( $item -> service_id );
                $xray_charges_net += $item -> net_price;
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
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
<!------------------------>


<!------------------------>
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
<table width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%;" border="1" cellpadding="5px">
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
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
<!------------------------>


<!------------------------>
<?php if ( count ( $ecg ) > 0 ) : ?>
    <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0; page-break-inside:avoid"
           cellpadding="0" border="0">
        <tr style="margin-left: 0">
            <td style="margin-left: 0">
                <strong style="font-size: 14px; float: left; width: 100%">ECG Charges</strong>
            </td>
        </tr>
    </table>
<?php endif; ?>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%;" border="1" cellpadding="5px">
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
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
<!------------------------>


<!------------------------>
<?php if ( count ( $echo ) > 0 ) : ?>
    <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0; page-break-inside:avoid"
           cellpadding="0" border="0">
        <tr style="margin-left: 0">
            <td style="margin-left: 0">
                <strong style="font-size: 14px; float: left; width: 100%">ECHO Charges</strong>
            </td>
        </tr>
    </table>
<?php endif; ?>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%;" border="1" cellpadding="5px">
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
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
<!------------------------>

<table width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; margin-top: 30px" border="1"
       cellpadding="2px">
    <tbody>
    <?php $to_be_paid = $sale_billing -> net_total - $sale_billing -> initial_deposit - $count_payment - $services_net_excluded - $tax_value; ?>
    <tr>
        <td colspan="2" align="right" style="border: none">
            <strong>Total Amount: </strong>
        </td>
        <td align="right" style="border: none">
            <?php echo number_format ( $net_ipd, 2 ) ?>
        </td>
    </tr>
    
    <?php if ( $sale_billing -> discount > 0 ) : ?>
        <tr style="width: 100%; display: block; float: left; border: none;">
            <td colspan="2" align="right" style="border: none">
                <strong>Discount(%): </strong>
            </td>
            <td align="right" style="border: none">
                <?php echo number_format ( $sale_billing -> discount, 2 ) ?>
            </td>
        </tr>
    <?php endif; ?>
    
    <?php if ( $services_net_excluded > 0 ) : ?>
        <tr style="width: 100%; display: block; float: left; border: none;">
            <td colspan="2" align="right" style="border: none">
                <strong>IPD Excluded: </strong>
            </td>
            <td align="right" style="border: none">
                <?php echo number_format ( $services_net_excluded, 2 ) ?>
            </td>
        </tr>
    <?php endif; ?>
    
    <?php if ( !empty( $panel ) && $panel -> exclude_pharmacy == '1' ) : ?>
        <tr style="width: 100%; display: block; float: left; border: none;">
            <td colspan="2" align="right" style="border: none">
                <strong>Pharmacy Excluded: </strong>
            </td>
            <td align="right" style="border: none">
                <?php echo number_format ( $medicine_net, 2 ) ?>
            </td>
        </tr>
    <?php endif; ?>
    
    <?php if ( !empty( $panel ) && $panel -> exclude_lab == '1' ) : ?>
        <tr style="width: 100%; display: block; float: left; border: none;">
            <td colspan="2" align="right" style="border: none">
                <strong>Lab Excluded: </strong>
            </td>
            <td align="right" style="border: none">
                <?php echo number_format ( $lab_net, 2 ) ?>
            </td>
        </tr>
    <?php endif; ?>
    
    <?php if ( !empty( $panel ) && $panel -> exclude_xray == '1' ) : ?>
        <tr style="width: 100%; display: block; float: left; border: none;">
            <td colspan="2" align="right" style="border: none">
                <strong>X-Ray Excluded: </strong>
            </td>
            <td align="right" style="border: none">
                <?php echo number_format ( $xray_charges_net, 2 ) ?>
            </td>
        </tr>
    <?php endif; ?>
    
    <tr style="width: 100%; display: block; float: left; border: none;">
        <td colspan="2" align="right" style="border: none">
            <strong>Deduction: </strong>
        </td>
        <td align="right" style="border: none">
            <?php echo number_format ( $sale_billing -> deduction, 2 ) ?>
        </td>
    </tr>
    
    <?php
        $cash_paid_by_patient = 0;
        if ( $patient -> panel_id > 0 ) {
            $cash_paid_by_patient = ( $cash_paid + $sale_billing -> initial_deposit );
            if ( $cash_paid_by_patient > 0 ) {
                ?>
                <tr style="width: 100%; display: block; float: left; border: none;">
                    <td colspan="2" align="right" style="border: none">
                        <strong>Cash Paid By Patient: </strong>
                    </td>
                    <td align="right" style="border: none">
                        <?php echo number_format ( $cash_paid_by_patient, 2 ) ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    
    <tr style="width: 100%; display: block; float: left; border: none">
        <td colspan="2" align="right" style="border: none">
            <strong>Net Amount: </strong>
        </td>
        <td align="right" style="border: none">
            <?php
                $netBill = $net_ipd - $services_net_excluded - $sale_billing -> deduction;
                
                if ( !empty( $panel ) && $panel -> exclude_pharmacy == '1' ) {
                    $to_be_paid -= $medicine_net;
                    $netBill    -= $medicine_net;
                }
                else if ( !empty( $panel ) && $panel -> exclude_pharmacy != '1' ) {
                    $to_be_paid += $medicine_net;
                    $netBill    += $medicine_net;
                }
                
                if ( !empty( $panel ) && $panel -> exclude_lab == '1' ) {
                    $to_be_paid -= $lab_net;
                    $netBill    -= $lab_net;
                }
                else if ( !empty( $panel ) && $panel -> exclude_lab != '1' ) {
                    $to_be_paid += $lab_net;
                    $netBill    += $lab_net;
                }
                
                if ( !empty( $panel ) && $panel -> exclude_xray == '1' ) {
                    $to_be_paid -= $xray_charges_net;
                    $netBill    -= $xray_charges_net;
                }
                else if ( !empty( $panel ) && $panel -> exclude_xray != '1' ) {
                    $to_be_paid += $xray_charges_net;
                    $netBill    += $xray_charges_net;
                }
                
                $netBill += $cash_paid_by_patient;
                
                echo number_format ( $netBill, 2 );
            ?>
        </td>
    </tr>
    
    <?php
        if ( $patient -> panel_id > 0 ) :
            ?>
            <tr style="width: 100%; display: block; float: left; border: none">
                <td colspan="2" align="right" style="border: none; color: #0000FF">
                    <strong>Hospital Share:</strong>
                </td>
                <td align="right" style="border: none; color: #0000FF">
                    <?php echo number_format ( ( $netBill / 2 ), 2 ) ?>
                </td>
            </tr>
            <tr style="width: 100%; display: block; float: left; border: none">
                <td colspan="2" align="right" style="border: none; color: #FF0000">
                    <strong>Consultant Share:</strong>
                </td>
                <td align="right" style="border: none; color: #FF0000">
                    <?php echo number_format ( ( $netBill / 2 ), 2 ) ?>
                </td>
            </tr>
        <?php
        endif;
    ?>
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
    </tbody>
</table>

<!------------------------>
<?php if ( count ( $consultants ) > 0 ) : ?>
    <pagebreak />
    <br />
    <table width="100%"
           style="font-size: 9pt; border: none; margin-left: 0; page-break-inside:avoid; margin-bottom: 10px"
           cellpadding="0" border="0">
        <tr style="margin-left: 0">
            <td style="margin-left: 0">
                <strong style="font-size: 14px; float: left; width: 100%">Consultants Commissioning</strong>
            </td>
        </tr>
    </table>
<?php endif; ?>
<table width="100%" style="font-size: 9pt; border-collapse: collapse;" border="1"
       cellpadding="5px">
    <thead>
    <tr>
        <th align="center">Sr.No</th>
        <th align="left">Consultant</th>
        <th align="left">Fixed Commission</th>
        <th align="left">Commission (%) On IPD Charges</th>
        <th align="left">Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $consultants ) > 0 ) {
            foreach ( $consultants as $consultant ) {
                $doctor = get_doctor ( $consultant -> doctor_id );
                ?>
                <tr>
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td align="left"> <?php echo $doctor -> name ?> </td>
                    <td align="left">
                        <?php echo number_format ( $consultant -> commission, 2 ) ?>
                    </td>
                    <td align="left">
                        <?php echo number_format ( $consultant -> bill_commission, 2 ) ?> %
                    </td>
                    <td align="right">
                        <?php
                            if ( $consultant -> commission > 0 )
                                echo number_format ( $consultant -> commission, 2 );
                            else
                                echo number_format ( $netBill * ( $consultant -> bill_commission / 100 ), 2 );
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>

<!------------------------>
<?php if ( count ( $anesthesia_charges ) > 0 ) : ?>
    <table width="100%"
           style="font-size: 9pt; border: none; margin-top: 25px; margin-left: 0; page-break-inside:avoid; margin-bottom: 10px"
           cellpadding="0" border="0">
        <tr style="margin-left: 0">
            <td style="margin-left: 0">
                <strong style="font-size: 14px; float: left; width: 100%">Anesthesia Commissioning </strong>
            </td>
        </tr>
    </table>
<?php endif; ?>
<table width="100%" style="font-size: 9pt; border-collapse: collapse;" border="1"
       cellpadding="5px">
    <thead>
    <tr>
        <th align="center">Sr.No</th>
        <th align="left">Consultant</th>
        <th align="left">Commission</th>
        <th align="left">Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $anesthesia_charges ) > 0 ) {
            foreach ( $anesthesia_charges as $anesthesia_charge ) {
                $doctor = get_doctor ( $anesthesia_charge -> doctor_id );
                ?>
                <tr>
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td align="left"> <?php echo $doctor -> name ?> </td>
                    <td align="left">
                        <?php echo number_format ( $anesthesia_charge -> commission, 2 ) ?>
                    </td>
                    <td align="left">
                        <?php echo number_format ( $anesthesia_charge -> commission, 2 ); ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>

</body>
</html>
