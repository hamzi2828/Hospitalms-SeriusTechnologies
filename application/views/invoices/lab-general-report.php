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

<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" page="all" value="on" />
mpdf-->

<br />
<table width="100%">
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 8pt;">
                <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?><br />
            </span>
            <span style="font-size: 8pt;">
                <strong>Search Criteria:</strong>
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?> @
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
            </span>
        </td>
    </tr>
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Lab General Report </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th> Test</th>
        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
        <th> Patient Type</th>
        <th> Doctor(s)</th>
        <th> Price</th>
        <th> Discount(%)</th>
        <th> Discount(Flat)</th>
        <th> Paid Amount</th>
        <th> Net Amount</th>
        <th> Doctor's Share (%)</th>
        <th> Doctor's Share Value</th>
        <th> Remarks</th>
        <th> Date</th>
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
                <tr style="<?php echo $report -> refunded == '1' ? 'background: rgba(255, 255, 0, 0.5)' : '' ?>">
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
                    <td> <?php echo get_patient_name ( 0, $patient ) ?> </td>
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
                    <td> <?php echo date_setter ( $report -> date_added ) ?> </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="6" class="text-right"></td>
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
                <td colspan="2"></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
<?php if ( count ( $receivings ) > 0 ) echo '<pagebreak/>'; ?>

<?php $totalReceivedAmount = 0;
    if ( count ( $receivings ) > 0 ) : ?>
        <table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
            <tr>
                <td style="width: 100%; background: #f5f6f7; text-align: center">
                    <h3><strong> Previous Invoices Balance Receiving Report</strong></h3>
                </td>
            </tr>
        </table>
        <br>
        <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8"
               border="1">
            <thead>
            <tr>
                <th> Sr. No</th>
                <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                <th> Received By</th>
                <th> Received Amount</th>
                <th> Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $counter = 1;
                if ( count ( $receivings ) > 0 ) {
                    foreach ( $receivings as $receive ) {
                        $totalReceivedAmount = $totalReceivedAmount + $receive -> amount;
                        $received_by         = get_user ( $receive -> user_id );
                        ?>
                        <tr>
                            <td> <?php echo $counter++ ?> </td>
                            <td> <?php echo $receive -> sale_id ?> </td>
                            <td> <?php echo $received_by -> name ?> </td>
                            <td>
                                <?php echo number_format ( $receive -> amount, 2 ) ?>
                            </td>
                            <td> <?php echo date_setter ( $receive -> created_at ) ?> </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td colspan="3" class="text-right"></td>
                        <td colspan="2">
                            <b><?php echo number_format ( $totalReceivedAmount, 2 ) ?></b>
                        </td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>
    <?php endif; ?>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <tbody>
    <tr>
        <td colspan="5" align="right">
            <h3>
                <strong>G. Total: </strong>
                <?php echo number_format ( ( $totalPaidAmount + $totalReceivedAmount ), 2 ) ?>
            </h3>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>