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
<?php
    $sale_info      = get_lab_sale ( $sale_id );
    $test_sale_info = get_test_sale ( $sale_id );
    if ( $test_sale_info -> refunded == '1' ) {
        $text = 'Refund Invoice ID#';
    }
    else {
        $text = 'Sale Invoice ID#';
    } ?>
<!--mpdf
<htmlpageheader name="myheader">
    <?php require 'pdf-header.php'; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
    <div style="width:100%; display:block; text-align:left; float:left; font-size: 14px">
        <?php if ( !empty( $online_report_info ) ) : ?>
            <b>Online report: <u><?php echo online_report_url ?></u> </b><br>
            <b>Invoice No: <?php echo $online_report_info -> sale_id ?> </b><br>
            <b>Password: <?php echo $online_report_info -> password ?> </b><br>
        <?php endif; ?>
    </div>
    <br/>
    <small style="color: #ff0000; text">
        <b>Note! Please bring this receipt to collect Lab Report. No Lab Report shall be given without receipt. Thanks</b>
    </small>
    <br/>
    <small style="color: #ff0000; text"><b>لیب رپورٹ لینے کے لیے براہ کرم یہ رسید لائیں۔ بغیر رسید کے کوئی لیب رپورٹ نہیں دی جائے گی۔</b></small>
    <?php require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<br />
<table width="100%">
    <tr>
        <td width="60%">
            <b>EMR: </b><?php echo $patient_id ?><br />
            <b>Name: </b><?php echo get_patient_name ( 0, $patient ) ?><br />
            <b>Gender: </b><?php echo get_patient_gender ( 0, $patient ) ?><br />
            <b>Age: </b><?php echo get_patient_dob ( $patient ) ?><br />
            <b>Mobile: </b><?php echo $patient -> mobile ?><br />
            <b>Patient Type: </b><?php echo ucfirst ( $patient -> type );
                if ( $patient -> panel_id > 0 )
                    echo ' / ' . get_panel_by_id ( $patient -> panel_id ) -> name ?><br />
            <b>Payment Method:</b><?php echo str_replace ( '-', ' ', ucwords ( $sale_info -> payment_method ) ) ?>
        </td>
        <td width="40%" style="text-align: right">
            <span style="font-weight: bold; font-size: 25pt;"><?php echo $sale_id ?></span>
            <br />
            <strong>Sampling
                    Date:</strong> <?php echo date ( 'd-m-Y g:i a', strtotime ( $sales[ 0 ] -> date_added ) ) ?>
            <br />
            <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . ' ' . date ( 'g:i a' ) ?> <br />
        </td>
    </tr>
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3>
                <?php
                    $sale_info = get_lab_sale ( $sale_id );
                    if ( $test_sale_info -> refunded == '1' ) {
                        ?>
                        <strong> Refund Invoice </strong>
                    <?php } else { ?>
                        <strong> Sale Invoice </strong>
                    <?php } ?>
            </h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr style="background: #f5f5f5;">
        <th style="width: 10%">Sr. No.</th>
        <th align="left">Code</th>
        <th align="left">Test Name</th>
        <th align="left">Type</th>
        <th align="left">Reporting Date</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <?php
        $description  = '';
        $array        = array ();
        $net          = 0;
        $netSalePrice = 0;
        if ( count ( $sales ) > 0 ) {
            $counter   = 1;
            $sale_info = get_lab_sale ( $sale_id );
            foreach ( $sales as $sale ) {
                $test        = get_test_by_id ( $sale -> test_id );
                $details     = get_test_procedure_info ( $sale -> test_id );
                $description = $sale -> remarks;
                
                if ( !empty( $details ) && !empty( trim ( $details -> protocol ) ) )
                    $style = 'color: #FF0000; font-weight: bold';
                else
                    $style = '';
                
                $netSalePrice = $netSalePrice + $sale -> price;
                
                if ( $sale -> parent_id != '' and $sale -> parent_id > 0 )
                    array_push ( $array, $sale -> parent_id );
                
                if ( !in_array ( $sale -> parent_id, $array ) ) {
                    $net = $net + $sale -> price;
                    ?>
                    <tr <?php if ( $sale -> parent_id != '' and $sale -> parent_id > 0 )
                        echo 'parent' ?>>
                        <td align="center" style="<?php echo $style ?>"><?php echo $counter++ ?></td>
                        <td align="left" style="<?php echo $style ?>"><?php echo $test -> code ?></td>
                        <td align="left" style="<?php echo $style ?>"><?php echo $test -> name ?></td>
                        <td align="left"><?php echo ucfirst ( $test -> type ) ?></td>
                        <td align="left" style="<?php echo $style ?>">
                            <?php
                                if ( $sale -> report_collection_date_time != '1970-01-01 05:00:00' )
                                    echo date ( 'd-m-Y h:i:s A', strtotime ( $sale -> report_collection_date_time ) );
                                else
                                    echo '-';
                            ?>
                        </td>
                        <td align="center"
                            style="<?php echo $style ?>"><?php echo number_format ( $sale -> price, 2 ) ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <?php if ( $test_sale_info -> refunded != '1' ) { ?>
                <tr>
                    <td></td>
                    <td colspan="4" style="text-align: right">
                        <strong>Gross Total</strong>
                    </td>
                    <td style="text-align: center">
                        <h4><?php echo number_format ( $netSalePrice, 2 ); ?></h4>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4" style="text-align: right">
                        <strong>Discount(%)</strong>
                    </td>
                    <td style="text-align: center">
                        <h4><?php echo $sale_info -> discount; ?></h4>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4" style="text-align: right">
                        <strong>Discount(Flat)</strong>
                    </td>
                    <td style="text-align: center">
                        <h4><?php echo $sale_info -> flat_discount; ?></h4>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4" style="text-align: right">
                        <strong>Net Total</strong>
                    </td>
                    <td style="text-align: center">
                        <h4><?php echo number_format ( $sale_info -> total, 2 ); ?></h4>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4" style="text-align: right">
                        <strong>Paid Amount</strong>
                    </td>
                    <td style="text-align: center">
                        <h4><?php echo number_format ( $sale_info -> paid_amount, 2 ); ?></h4>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4" style="text-align: right; color: #ff0000">
                        <strong>Balance</strong>
                    </td>
                    <td style="text-align: center; color: #ff0000">
                        <h4><?php echo number_format ( $sale_info -> total - $sale_info -> paid_amount, 2 ); ?></h4>
                    </td>
                </tr>
                <?php
            }
            else { ?>
                <tr>
                    <td></td>
                    <td colspan="4" style="text-align: right">
                        <strong>Total</strong>
                    </td>
                    <td style="text-align: center">
                        <h4><?php echo abs ( $net ); ?></h4>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4" style="text-align: right">
                        <strong>Discount(%)</strong>
                    </td>
                    <td style="text-align: center">
                        <h4><?php echo $sale_info -> discount; ?></h4>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4" style="text-align: right">
                        <strong>Refund Amount</strong>
                    </td>
                    <td style="text-align: center">
                        <h4><?php echo abs ( $sale_info -> total ); ?></h4>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4" style="text-align: right">
                        <strong>Balance</strong>
                    </td>
                    <td style="text-align: center">
                        <h4><?php echo number_format ( $sale_info -> total - $sale_info -> paid_amount, 2 ); ?></h4>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
<p style="width: 100%; float: left; margin-top: 15px">
    <?php if ( !empty( trim ( $description ) ) )
        echo '<strong>Remarks: </strong>' . $description; ?>
</p>
<strong style="margin-bottom: 10px">Specimen</strong>
<ul style="list-style-type: decimal; padding-left: 20px">
    <?php
        if ( count ( $specimens ) > 0 ) {
            foreach ( $specimens as $specimen ) {
                $sample = get_sample_by_id ( $specimen -> sample_id );
                ?>
                <li style="margin-bottom: 5px"><?php echo $sample -> name ?></li>
                <?php
            }
        }
    ?>
</ul>

<div style="margin-bottom: 50px">
    <?php if ( !empty( trim ( $sale_info -> patient_remarks ) ) ) : ?>
        <strong>Patient Remarks:</strong> <br />
        <?php echo $sale_info -> patient_remarks ?>
    <?php endif; ?>
</div>

</body>
</html>