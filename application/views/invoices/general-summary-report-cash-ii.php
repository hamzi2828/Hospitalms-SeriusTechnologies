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
<?php require 'search-criteria.php'; ?>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> General Summary Report (Cash II) </strong></h3>
        </td>
    </tr>
</table>
<br>
<table width="100%" style="font-size: 8pt; border-collapse: collapse; width: 100%;"
       cellpadding="4" border="1">
    <tbody>
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center"><strong>1</strong></td>
        <td style="color: #ff0000; font-size: 18px" colspan="5">
            <strong>Consultancies</strong>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><strong>Cash</strong></td>
        <td><strong>Card</strong></td>
        <td><strong>Bank</strong></td>
        <td><strong>Refund</strong></td>
        <td><strong>Net Cash</strong></td>
    </tr>
    <tr>
        <?php $netConsultancies = ( $cash_consultancies + $card_consultancies + $bank_consultancies ) - $consultancies_refunded; ?>
        <td></td>
        <td><?php echo number_format ( $cash_consultancies, 2 ) ?></td>
        <td><?php echo number_format ( $card_consultancies, 2 ) ?></td>
        <td><?php echo number_format ( $bank_consultancies, 2 ) ?></td>
        <td><?php echo number_format ( $consultancies_refunded, 2 ) ?></td>
        <td><?php echo number_format ( $netConsultancies, 2 ); ?></td>
    </tr>
    
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center"><strong>2</strong></td>
        <td style="color: #ff0000; font-size: 18px" colspan="5">
            <strong>OPD</strong>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><strong>Cash</strong></td>
        <td><strong>Card</strong></td>
        <td><strong>Bank</strong></td>
        <td><strong>Refund</strong></td>
        <td><strong>Net Cash</strong></td>
    </tr>
    <tr>
        <?php $netOPD = ( $cash_opd + $card_opd + $bank_opd ) - $opd_refunded; ?>
        <td></td>
        <td><?php echo number_format ( $cash_opd, 2 ) ?></td>
        <td><?php echo number_format ( $card_opd, 2 ) ?></td>
        <td><?php echo number_format ( $bank_opd, 2 ) ?></td>
        <td><?php echo number_format ( $opd_refunded, 2 ) ?></td>
        <td><?php echo number_format ( $netOPD, 2 ); ?></td>
    </tr>
    
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center"><strong>3</strong></td>
        <td style="color: #ff0000; font-size: 18px" colspan="5">
            <strong>Lab</strong>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><strong>Cash</strong></td>
        <td><strong>Card</strong></td>
        <td><strong>Bank</strong></td>
        <td><strong>Refund</strong></td>
        <td><strong>Net Cash</strong></td>
    </tr>
    <tr>
        <?php $netLab = ( $cash_lab + $card_lab + $bank_lab ) - $lab_refunded; ?>
        <td></td>
        <td><?php echo number_format ( $cash_lab, 2 ) ?></td>
        <td><?php echo number_format ( $card_lab, 2 ) ?></td>
        <td><?php echo number_format ( $bank_lab, 2 ) ?></td>
        <td><?php echo number_format ( $lab_refunded, 2 ) ?></td>
        <td><?php echo number_format ( $netLab, 2 ); ?></td>
    </tr>
    
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center"><strong>4</strong></td>
        <td style="color: #ff0000; font-size: 16px" colspan="5">
            <strong>IPD Cash (Paid by Cash Patient)</strong>
        </td>
    </tr>
    
    <tr>
        <td></td>
        <td colspan="4"><strong>Cash</strong></td>
        <td><strong>Net Cash</strong></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="4"><?php echo number_format ( $ipd_total, 2 ); ?></td>
        <td><?php echo number_format ( $ipd_total, 2 ); ?></td>
    </tr>
    
    <?php
        $grand_total = ( $cash_consultancies + $cash_opd + $cash_lab + $ipd_total );
        $panelCount  = 5;
        if ( count ( $panels ) > 0 ) {
            foreach ( $panels as $key => $panel ) {
                $panel_cash  = get_ipd_cash_by_panel ( $panel -> id );
                $grand_total += $panel_cash;
                if ( $panel_cash > 0 ) {
                    ?>
                    <tr>
                        <td style="color: #ff0000; font-size: 18px" width="3%" align="center">
                            <strong><?php echo $panelCount++ ?></strong>
                        </td>
                        <td style="color: #ff0000; font-size: 16px" colspan="5">
                            <strong>IPD Cash (Paid By <?php echo $panel -> name ?>)</strong>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4"><strong>Cash</strong></td>
                        <td><strong>Net Cash</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4"><?php echo number_format ( $panel_cash, 2 ) ?></td>
                        <td><?php echo number_format ( $panel_cash, 2 ) ?></td>
                    </tr>
                    <?php
                }
            }
        }
    ?>
    
    <tr>
        <td style="color: #ff0000; font-size: 18px" colspan="6" align="center">
            <strong>Grand Total</strong>
        </td>
    </tr>
    
    <tr>
        <td></td>
        <td><strong>Net Cash</strong></td>
        <td><strong>Net Card</strong></td>
        <td><strong>Net Bank</strong></td>
        <td><strong>Net Refund</strong></td>
        <td><strong>Net Cash</strong></td>
    </tr>
    <tr>
        <?php
            $netCard    = ( $card_consultancies + $card_lab + $card_opd );
            $netBank    = ( $bank_consultancies + $bank_lab + $bank_opd );
            $netRefund  = ( $consultancies_refunded + $lab_refunded + $opd_refunded );
            $cashInHand = ( $grand_total + $netCard + $netBank ) - $netRefund;
        ?>
        <td></td>
        <td><?php echo number_format ( $grand_total, 2 ); ?></td>
        <td><?php echo number_format ( $netCard, 2 ); ?></td>
        <td><?php echo number_format ( $netBank, 2 ); ?></td>
        <td><?php echo number_format ( $netRefund, 2 ); ?></td>
        <td>
            <?php echo number_format ( $cashInHand, 2 ); ?>
        </td>
    </tr>
    </tbody>
</table>
<br>

<table width="100%" style="font-size: 8pt; border-collapse: collapse; width: 100%;"
       cellpadding="4" border="1">
    <thead>
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center">
            <strong><?php echo $panelCount++ ?></strong>
        </td>
        <th colspan="6" style="color: #ff0000; font-size: 18px" align="left">
            <strong>Doctor Summary Report</strong>
        </th>
    </tr>
    <tr>
        <th></th>
        <th> Sr. No</th>
        <th align="left"> Doctor</th>
        <th align="left"> No. of Consultancies</th>
        <th align="left"> Net Bill</th>
        <th align="left"> Hospital Commission</th>
        <th align="left"> Doctor Commission</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $doc_counter             = 1;
        $netConsultancies        = 0;
        $totalBill               = 0;
        $totalHospitalCommission = 0;
        $totalDoctorCommission   = 0;
        
        if ( count ( $filter_doctors ) > 0 ) {
            foreach ( $filter_doctors as $doctor ) {
                
                $counter               = 1;
                $netHospitalCharges    = 0;
                $netBill               = 0;
                $netHospitalCommission = 0;
                $netDoctorCommission   = 0;
                $hosp_commission       = 0;
                $doc_commission        = 0;
                $net                   = 0;
                
                $consultancies = get_doctor_consultancies ( $doctor -> id );
                if ( count ( $consultancies ) > 0 ) {
                    foreach ( $consultancies as $consultancy ) {
                        $specialization        = get_specialization_by_id ( $consultancy -> specialization_id );
                        $doctor                = get_doctor ( $consultancy -> doctor_id );
                        $patient               = get_patient ( $consultancy -> patient_id );
                        $net                   = $net + $consultancy -> net_bill;
                        $hospital_commission   = $consultancy -> hospital_share - $consultancy -> hospital_discount;
                        $commission            = $consultancy -> doctor_charges - $consultancy -> doctor_discount;
                        $hosp_commission       = $hosp_commission + $hospital_commission;
                        $doc_commission        = $doc_commission + $commission;
                        $netHospitalCharges    += $consultancy -> charges;
                        $netBill               += $consultancy -> net_bill;
                        $netHospitalCommission += $hospital_commission;
                        $netDoctorCommission   += $commission;
                    }
                    
                    ?>
                    <tr>
                        <td></td>
                        <td> <?php echo $doc_counter++ ?> </td>
                        <td>
                            <?php
                                echo $doctor -> name . '<br/>';
                                echo $doctor -> qualification;
                            ?>
                        </td>
                        <td><?php echo count ( $consultancies ) ?></td>
                        <td><?php echo number_format ( $netBill, 2 ) ?></td>
                        <td><?php echo number_format ( $netHospitalCommission, 2 ) ?></td>
                        <td><?php echo number_format ( $netDoctorCommission, 2 ) ?></td>
                    </tr>
                    <?php
                }
                
                $netConsultancies        += count ( $consultancies );
                $totalBill               += $netBill;
                $totalHospitalCommission += $netHospitalCommission;
                $totalDoctorCommission   += $netDoctorCommission;
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td>
            <strong><?php echo $netConsultancies ?></strong>
        </td>
        <td>
            <strong><?php echo number_format ( $totalBill, 2 ) ?></strong>
        </td>
        <td>
            <strong><?php echo number_format ( $totalHospitalCommission, 2 ) ?></strong>
        </td>
        <td>
            <strong><?php echo number_format ( $totalDoctorCommission, 2 ) ?></strong>
        </td>
    </tr>
    </tfoot>
</table>
<br>

<table width="100%" style="font-size: 8pt; border-collapse: collapse; width: 100%;"
       cellpadding="4" border="1">
    <thead>
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center">
            <strong><?php echo $panelCount++ ?></strong>
        </td>
        <th colspan="14" style="color: #ff0000; font-size: 18px" align="left">
            <strong>OPD Doctor's Share</strong>
        </th>
    </tr>
    <tr>
        <th></th>
        <th> Sr. No</th>
        <th align="left"> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
        <th align="left"> Doctor(s)</th>
        <th align="left"> Service(s)</th>
        <th align="left"> Price</th>
        <th align="left"> Total</th>
        <th align="left"> Discount (%)</th>
        <th align="left"> Discount (Flat)</th>
        <th align="left"> Net Price</th>
        <th align="left"> Doctor's Share (%)</th>
        <th align="left"> Doctor's Share (Value)</th>
        <th align="left"> Refunded</th>
        <th align="left"> Refund Reason</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter        = 1;
        $total          = 0;
        $net            = 0;
        $doctorNetShare = 0;
        if ( count ( $sales ) > 0 ) {
            foreach ( $sales as $sale ) {
                $patient   = get_patient ( $sale -> patient_id );
                $sale_info = get_opd_sale ( $sale -> sale_id );
                
                if ( $sale_info -> refund !== '1' ) {
                    $total          = $total + $sale_info -> net;
                    $net            += $sale -> net_price;
                    $doctorNetShare += ( $sale_info -> total * ( $sale_info -> doctor_share / 100 ) );
                }
                
                $refunded = $sale_info -> refund == '1' ? 'Yes' : 'No';
                ?>
                <tr class="odd gradeX">
                    <td></td>
                    <td> <?php echo $counter++ ?> </td>
                    <td><?php echo $sale -> sale_id ?></td>
                    <td>
                        <?php echo get_patient_name ( 0, $patient ) ?>
                        <?php
                            if ( $sale_info -> refund == '1' ) {
                                echo '<span class="badge badge-danger">Refunded</span>';
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( $sale_info -> doctor_id > 0 )
                                echo get_doctor ( $sale_info -> doctor_id ) -> name . '<br>';
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php
                            $services = explode ( ',', $sale -> services );
                            if ( count ( $services ) > 0 ) {
                                foreach ( $services as $service ) {
                                    echo get_service_by_id ( $service ) -> title . '<br>';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            $prices = explode ( ',', $sale -> prices );
                            if ( count ( $prices ) > 0 ) {
                                foreach ( $prices as $price ) {
                                    echo $price . '<br>';
                                }
                            }
                        ?>
                    </td>
                    <td><?php echo $sale -> net_price ?></td>
                    <td><?php echo $sale_info -> discount ?></td>
                    <td><?php echo $sale_info -> flat_discount ?></td>
                    <td><?php echo $sale_info -> net ?></td>
                    <td>
                        <?php
                            $doctor_share = $sale_info -> doctor_share;
                            if ( $doctor_share > 0 )
                                echo $sale_info -> doctor_share . '%';
                        ?>
                    </td>
                    <td>
                        <?php
                            $doctor_share = $sale_info -> doctor_share;
                            if ( $doctor_share > 0 )
                                echo ( $sale_info -> total * ( $sale_info -> doctor_share / 100 ) );
                        ?>
                    </td>
                    <td><?php echo $refunded ?></td>
                    <td><?php echo $sale_info -> refund_reason ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="7"></td>
                <td>
                    <strong><?php echo number_format ( $net, 2 ) ?></strong>
                </td>
                <td colspan="2"></td>
                <td>
                    <strong><?php echo number_format ( $total, 2 ) ?></strong>
                </td>
                <td></td>
                <td>
                    <strong><?php echo number_format ( $doctorNetShare, 2 ) ?></strong>
                </td>
                <td colspan="3"></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
<br>

<table width="100%" style="font-size: 8pt; border-collapse: collapse; width: 100%;"
       cellpadding="4" border="1">
    <thead>
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center">
            <strong><?php echo $panelCount++ ?></strong>
        </td>
        <th colspan="14" style="color: #ff0000; font-size: 18px" align="left">
            <strong>Lab Doctor's Share</strong>
        </th>
    </tr>
    <tr>
        <th></th>
        <th> Sr. No</th>
        <th align="left"> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th align="left"> Test</th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
        <th align="left"> Patient Type</th>
        <th align="left"> Doctor(s)</th>
        <th align="left"> Price</th>
        <th align="left"> Discount(%)</th>
        <th align="left"> Discount(Flat)</th>
        <th align="left"> Paid Amount</th>
        <th align="left"> Net Amount</th>
        <th align="left"> Doctor's Share (%)</th>
        <th align="left"> Doctor's Share Value</th>
        <th align="left"> Remarks</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter             = 1;
        $total               = 0;
        $p_total             = 0;
        $total_flat_discount = 0;
        $totalPaidAmount     = 0;
        $doctorShareNet      = 0;
        if ( count ( $reports ) > 0 ) {
            foreach ( $reports as $report ) {
                $patient   = get_patient ( $report -> patient_id );
                $sale      = get_lab_sale ( $report -> sale_id );
                $tests     = explode ( ',', $report -> tests );
                $receiving = get_lab_sale_receiving ( $report -> sale_id );
                $saleInfo  = get_lab_sale ( $report -> sale_id );
                
                if ( $report -> refunded !== '1' )
                    $p_total = $p_total + $report -> price;
                
                $netReceiving = 0;
                if ( count ( $receiving ) > 0 ) {
                    foreach ( $receiving as $received ) {
                        $netReceiving += $received -> amount;
                    }
                }
                
                if ( $report -> refunded != '1' )
                    $total_flat_discount = $total_flat_discount + $sale -> flat_discount;
                
                $netPrice = $report -> price;
                
                if ( $sale -> discount > 0 )
                    $netPrice = $netPrice - ( $netPrice * ( $sale -> discount / 100 ) );
                if ( $sale -> flat_discount > 0 )
                    $netPrice = $netPrice - $sale -> flat_discount;
                $netPrice     = $netPrice - $sale -> paid_amount;
                $saleTotal    = get_lab_sales_total ( $report -> sale_id );
                $doctor_share = $saleInfo -> doctor_share;
                
                if ( $report -> refunded !== '1' ) {
                    $totalPaidAmount = $totalPaidAmount + $sale -> paid_amount;
                    $total           = $total + $saleInfo -> total;
                    $doctorShareNet  += ( $saleInfo -> net * ( $saleInfo -> doctor_share / 100 ) );
                }
                
                $totalPaidAmount = $totalPaidAmount - $netReceiving;
                ?>
                <tr>
                    <td></td>
                    <td> <?php echo $counter++ ?> </td>
                    <td> <?php echo $report -> sale_id ?> </td>
                    <td>
                        <?php
                            if ( count ( $tests ) > 0 ) {
                                foreach ( $tests as $test ) {
                                    if ( !check_if_test_is_child ( $test ) )
                                        echo get_test_by_id ( $test ) -> name . '<br>';
                                }
                            } ?>
                    </td>
                    <td>
                        <?php
                            echo get_patient_name ( 0, $patient );
                            if ( $report -> refunded == '1' ) {
                                echo '<span class="badge badge-danger">Refunded</span>';
                            }
                        ?>
                    </td>
                    <td> <?php echo $patient -> panel_id > 0 ? get_panel_by_id ( $patient -> panel_id ) -> name : 'Cash' ?> </td>
                    <td>
                        <?php
                            if ( $saleInfo -> doctor_id > 0 )
                                echo get_doctor ( $saleInfo -> doctor_id ) -> name . '<br>';
                            else
                                echo '-';
                        ?>
                    </td>
                    <td><?php echo number_format ( $saleInfo -> net, 2 ) ?></td>
                    <td> <?php echo $sale -> discount ?> </td>
                    <td>
                        <?php
                            if ( $report -> refunded == '1' and !empty( trim ( $report -> remarks ) ) )
                                echo '-' . $sale -> flat_discount;
                            else
                                echo $sale -> flat_discount;
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( $report -> refunded == '1' and !empty( trim ( $report -> remarks ) ) )
                                echo '-' . ( $sale -> paid_amount - $netReceiving );
                            else
                                echo ( $sale -> paid_amount - $netReceiving );
                            
                            if ( count ( $receiving ) > 0 ) {
                                echo '<br/>';
                                foreach ( $receiving as $received ) {
                                    $receivedBy = get_user ( $received -> user_id );
                                    echo '<small>' . number_format ( $received -> amount, 2 ) . ' received by ' . $receivedBy -> name . '</small> <br/>';
                                }
                            }
                        
                        ?>
                    </td>
                    <td><?php echo number_format ( $saleInfo -> total, 2 ) ?></td>
                    <td>
                        <?php
                            if ( $doctor_share > 0 ) {
                                echo $saleInfo -> doctor_share . '%';
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( $doctor_share > 0 ) {
                                echo ( $saleInfo -> net * ( $saleInfo -> doctor_share / 100 ) );
                            }
                        ?>
                    </td>
                    <td> <?php echo $report -> remarks ?> </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="7" class="text-right"></td>
                <td>
                    <b><?php echo number_format ( $p_total, 2 ) ?></b>
                </td>
                <td class="text-right"></td>
                <td>
                    <b><?php echo number_format ( $total_flat_discount, 2 ) ?></b>
                </td>
                <td>
                    <b><?php echo number_format ( $totalPaidAmount, 2 ) ?></b>
                </td>
                <td>
                    <b><?php echo number_format ( $total, 2 ) ?></b>
                </td>
                <td></td>
                <td>
                    <b><?php echo number_format ( $doctorShareNet, 2 ) ?></b>
                </td>
                <td></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
<br>

<table width="100%" style="font-size: 8pt; border-collapse: collapse; width: 100%;"
       cellpadding="4" border="1">
    <thead>
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center">
            <strong><?php echo $panelCount++ ?></strong>
        </td>
        <th colspan="14" style="color: #ff0000; font-size: 18px" align="left">
            <strong>IPD Doctor's Share</strong>
        </th>
    </tr>
    
    <tr>
        <th></th>
        <th> Sr. No</th>
        <th align="left"> Patient EMR</th>
        <th align="left"> Patient Name</th>
        <th align="left"> Cash/Panel</th>
        <th align="left"> Invoice ID</th>
        <th align="left"> Consultant Name</th>
        <th align="left"> Service(s)</th>
        <th align="left"> Direct Commission</th>
        <th align="left"> Bill Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter              = 1;
        $net                  = 0;
        $medicationNet        = 0;
        $labNet               = 0;
        $direct_commission    = 0;
        $amount_after_tax     = 0;
        $net_consultant_share = 0;
        $net_hospital_share   = 0;
        
        if ( count ( $ipd_sales ) > 0 ) {
            foreach ( $ipd_sales as $ipd_sale ) {
                $patient    = get_patient ( $ipd_sale -> patient_id );
                $medication = get_ipd_medication_net_price ( $ipd_sale -> sale_id );
                $lab        = get_ipd_lab_net_price ( $ipd_sale -> sale_id );
                $panel      = get_panel_by_id ( $patient -> panel_id );
                $ipd_net    = get_sum_patient_ipd_associated_services_consolidated_not_in_type ( $ipd_sale -> sale_id );
                
                $xray         = $this -> IPDModel -> get_sum_patient_associated_services_by_type ( $ipd_sale -> sale_id, 'xray' );
                $ultrasound   = $this -> IPDModel -> get_sum_patient_associated_services_by_type ( $ipd_sale -> sale_id, 'ultrasound' );
                $ecg          = $this -> IPDModel -> get_sum_patient_associated_services_by_type ( $ipd_sale -> sale_id, 'ecg' );
                $echo         = $this -> IPDModel -> get_sum_patient_associated_services_by_type ( $ipd_sale -> sale_id, 'echo' );
                $ipd_excluded = $this -> IPDModel -> get_patient_sum_ipd_associated_services_consolidated_not_in_type ( $ipd_sale -> sale_id, '0' );
                
                $medicationNet = $medicationNet + $medication;
                $labNet        = $labNet + $lab;
                
                $net_price = get_ipd_net_price_excluding ( $ipd_sale );
                
                if ( !empty( $panel ) )
                    $tax = $ipd_net - ( $ipd_net * ( $panel -> tax / 100 ) );
                else
                    $tax = 0;
                
                $final = $tax - $xray - $ultrasound - $ecg - $echo - $medication - $lab - $ipd_excluded;
                
                $consultant_share = ( $final / 2 );
                $hospital_share   = ( $final / 2 );
                
                $direct_commission    += $ipd_sale -> commission;
                $net                  += $ipd_net;
                $amount_after_tax     += $tax;
                $net_consultant_share += $consultant_share;
                $net_hospital_share   += $hospital_share;
                
                ?>
                <tr class="odd gradeX">
                    <td></td>
                    <td> <?php echo $counter++ ?> </td>
                    <td><?php echo $patient -> id ?></td>
                    <td><?php echo $patient -> name ?></td>
                    <td>
                        <?php echo $panel ? $panel -> name : 'Cash' ?>
                    </td>
                    <td><?php echo $ipd_sale -> sale_id ?></td>
                    <td><?php echo @get_doctor ( $ipd_sale -> doctor_id ) -> name . '<br>'; ?></td>
                    <td><?php echo @get_ipd_service_by_id ( $ipd_sale -> service_id ) -> title ?></td>
                    <td><?php echo number_format ( $ipd_sale -> commission, 2 ) ?></td>
                    <td><?php echo number_format ( $ipd_net, 2 ) ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="8"></td>
        <td align="left"><strong><?php echo number_format ( $direct_commission, 2 ) ?></strong></td>
        <td align="left"><strong><?php echo number_format ( $net, 2 ) ?></strong></td>
    </tr>
    </tfoot>
</table>
<br>

<table width="100%" style="font-size: 8pt; border-collapse: collapse; width: 100%;"
       cellpadding="4" border="1">
    <thead>
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center">
            <strong><?php echo $panelCount++ ?></strong>
        </td>
        <th colspan="6" style="color: #ff0000; font-size: 18px" align="left">
            <strong>Consultants Share</strong>
        </th>
    </tr>
    <tr>
        <td></td>
        <th>Sr.No</th>
        <th>Consultant</th>
        <th>Opening Balance</th>
        <th>Debit</th>
        <th>Credit</th>
        <th>Running Balance</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter    = 1;
        $net_credit = 0;
        $net_debit  = 0;
        $net_rb     = 0;
        $start_date = $this -> input -> get ( 'start_date' );
        $start_date = !empty( $start_date ) ? $start_date : date ( 'Y-m-d' );
        
        if ( count ( $consultants ) > 0 ) {
            foreach ( $consultants as $consultant ) {
                $opening_balance = !empty( $start_date ) ? get_opening_balance_previous_than_searched_start_date ( $start_date, $consultant -> id ) : 0;
                $transaction     = calculate_acc_head_transaction ( $consultant -> id );
                $runningBalance  = 0;
                
                if ( !empty( $transaction ) && ( $transaction -> credit > 0 || $transaction -> debit > 0 ) ) {
                    $net_credit = $net_credit + $transaction -> credit;
                    $net_debit  = $net_debit + $transaction -> debit;
                    
                    if ( in_array ( $consultant -> role_id, array ( assets, expenditure ) ) )
                        $runningBalance = $runningBalance + $transaction -> credit - $transaction -> debit;
                    
                    else if ( in_array ( $consultant -> role_id, array ( liabilities, capitals, income ) ) )
                        $runningBalance = $runningBalance - $transaction -> credit + $transaction -> debit;
                    
                    $net_rb = +$runningBalance;
                    ?>
                    <tr>
                        <td></td>
                        <td><?php echo $counter++ ?></td>
                        <td><?php echo $consultant -> title ?></td>
                        <td><?php echo number_format ( $opening_balance, 2 ) ?></td>
                        <td><?php echo number_format ( $transaction -> credit, 2 ) ?></td>
                        <td><?php echo number_format ( $transaction -> debit, 2 ) ?></td>
                        <td><?php echo number_format ( ( $runningBalance + $opening_balance ), 2 ) ?></td>
                    </tr>
                    <?php
                }
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="4"></th>
        <th aria-level="left">
            <strong><?php echo number_format ( $net_credit, 2 ) ?></strong>
        </th>
        <td></td>
        <th></th>
    </tr>
    </tfoot>
</table>
<br>

<table width="100%" style="font-size: 8pt; border-collapse: collapse; width: 100%;"
       cellpadding="4" border="1">
    <thead>
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center">
            <strong><?php echo $panelCount++ ?></strong>
        </td>
        <th colspan="7" style="color: #ff0000; font-size: 18px" align="left">
            <strong>Expanses</strong>
        </th>
    </tr>
    <tr>
        <td></td>
        <th> Sr. No</th>
        <th> Account Head</th>
        <th> Trans. No</th>
        <th> Voucher No.</th>
        <th> Description</th>
        <th> Debit</th>
        <th> Credit</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $netDebit  = 0;
        $netCredit = 0;
        if ( count ( $accounts ) > 0 ) {
            foreach ( $accounts as $account ) {
                $ledgers          = get_ledger_by_account_head ( $account[ 'id' ] );
                $accountNetCredit = 0;
                $accountNetDebit  = 0;
                if ( count ( $ledgers ) > 0 ) {
                    ?>
                    <tr>
                        <td colspan="2"></td>
                        <td style="background: rgba(53, 170, 71, 0.7)"><?php echo $account[ 'title' ]; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php
                }
                
                if ( count ( $ledgers ) > 0 ) {
                    $counter = 1;
                    foreach ( $ledgers as $ledger ) {
                        $netDebit         = $netDebit + $ledger -> debit;
                        $netCredit        = $netCredit + $ledger -> credit;
                        $accountNetDebit  = $accountNetDebit + $ledger -> debit;
                        $accountNetCredit = $accountNetCredit + $ledger -> credit;
                        ?>
                        <tr>
                            <td></td>
                            <td><?php echo $counter++ ?></td>
                            <td></td>
                            <td><?php echo $ledger -> id ?></td>
                            <td><?php echo $ledger -> voucher_number ?></td>
                            <td><?php echo $ledger -> description ?></td>
                            <td><?php echo number_format ( $ledger -> debit, 2 ) ?></td>
                            <td><?php echo number_format ( $ledger -> credit, 2 ) ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <strong><?php echo number_format ( $accountNetDebit, 2 ) ?></strong>
                        </td>
                        <td>
                            <strong><?php echo number_format ( $accountNetCredit, 2 ) ?></strong>
                        </td>
                    </tr>
                    <?php
                }
                
                if ( isset( $account[ 'children' ] ) and count ( $account[ 'children' ] ) > 0 ) {
                    foreach ( $account[ 'children' ] as $childAccount ) {
                        $childLedgers     = get_ledger_by_account_head ( $childAccount[ 'id' ] );
                        $accountNetCredit = 0;
                        $accountNetDebit  = 0;
                        if ( count ( $childLedgers ) > 0 ) {
                            ?>
                            <tr>
                                <td colspan="2"></td>
                                <td style="background: rgba(53, 170, 71, 0.7)"><?php echo $childAccount[ 'title' ]; ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php
                        }
                        if ( count ( $childLedgers ) > 0 ) {
                            $counter = 1;
                            foreach ( $childLedgers as $childLedger ) {
                                $netDebit         = $netDebit + $childLedger -> debit;
                                $netCredit        = $netCredit + $childLedger -> credit;
                                $accountNetDebit  = $accountNetDebit + $childLedger -> debit;
                                $accountNetCredit = $accountNetCredit + $childLedger -> credit;
                                ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $counter++ ?></td>
                                    <td></td>
                                    <td><?php echo $childLedger -> id ?></td>
                                    <td><?php echo $childLedger -> voucher_number ?></td>
                                    <td><?php echo $childLedger -> description ?></td>
                                    <td><?php echo number_format ( $childLedger -> debit, 2 ) ?></td>
                                    <td><?php echo number_format ( $childLedger -> credit, 2 ) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <strong><?php echo number_format ( $accountNetDebit, 2 ) ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $accountNetCredit, 2 ) ?></strong>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="6" align="right"></td>
        <td>
            <strong><?php echo number_format ( $netDebit, 2 ) ?></strong>
        </td>
        <td>
            <strong><?php echo number_format ( $netCredit, 2 ) ?></strong>
        </td>
    </tr>
    </tfoot>
</table>
<br />
<hr />

<table width="100%" style="font-size: 8pt; border-collapse: collapse; width: 100%;"
       cellpadding="4" border="0">
    <thead>
    <tr>
        <th align="left" width="75%" style="color: #ff0000; font-size: 14px">
            <strong>
                Cash in Hand = Net Cash - GL - Consultants Share (Debit) - Expanses
            </strong>
        </th>
        <th align="right" width="25%" style="color: #ff0000; font-size: 18px">
            <strong>
                <?php echo number_format ( ( $cashInHand - $net_credit - ( $netDebit + $netCredit ) ), 2 ) ?>
            </strong>
        </th>
    </tr>
    </thead>
</table>
</body>
</html>