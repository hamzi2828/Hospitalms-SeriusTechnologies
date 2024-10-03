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
            <h3><strong> Summary Report </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Total Pharmacy Sale</th>
        <th> Total Discount <small>(Includes flat & percentage discount)</small></th>
        <th> Total Sale Return</th>
        <th> Net Sale</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $total_pharmacy = 0;
        $total_return   = 0;
        $net_sale       = 0;
    ?>
    <tr>
        <?php if ( $pharmacy_sales and !empty( $pharmacy_sales ) ) : ?>
            <td>
                <?php
                    $total_pharmacy = $pharmacy_sales + $pharmacy_discount;
                    echo number_format ( @$total_pharmacy, 2 )
                ?>
            </td>
        <?php endif; ?>
        <?php if ( $pharmacy_discount and !empty( $pharmacy_discount ) ) : ?>
            <td>
                <?php echo number_format ( $pharmacy_discount, 2 ) ?>
            </td>
        <?php endif; ?>
        <?php if ( $return_sales and !empty( $return_sales ) ) : ?>
            <td>
                <?php
                    $total_return = @$return_sales;
                    echo number_format ( @$return_sales, 2 )
                ?>
            </td>
        <?php else : $total_return = 0; ?>
            <td>
                <?php
                    echo number_format ( $total_return, 2 )
                ?>
            </td>
        <?php endif; ?>
        <?php if ( $pharmacy_sales and !empty( $pharmacy_sales ) ) : ?>
            <td>
                <?php
                    $net_sale = $pharmacy_sales - $total_return;
                    echo number_format ( $net_sale, 2 )
                ?>
            </td>
        <?php endif; ?>
    </tr>
    </tbody>
</table>

<table class="items" width="100%" style="font-size: 11pt; border-collapse: collapse; border: 0; margin-top: 15px"
       cellpadding="8" border="0">
    <tbody>
    <tr>
        <td width="85%" align="right" style="border: 0;">
            <strong>Local Purchase Amount:</strong>
        </td>
        <td width="15%" align="right" style="border: 0">
            <strong><?php echo number_format ( $total_local_purchase, 2 ) ?></strong>
        </td>
    </tr>
    <tr>
        <td width="85%" align="right" style="border: 0;">
            <strong>Net Amount:</strong>
        </td>
        <td width="15%" align="right" style="border: 0">
            <strong><?php echo number_format ( $net_sale - $total_local_purchase, 2 ) ?></strong>
        </td>
    </tr>
    </tbody>
</table>

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; border: 0; margin-top: 100px"
       cellpadding="8" border="0">
    <tbody>
    <tr>
        <td width="33%" align="center" style="border: 0;">
            <p style="border-top: 1px solid #000000;">Paid By</p>
        </td>
        <td width="33%" align="center" style="border: 0;">
            <p style="border-top: 1px solid #000000;">Received By</p>
        </td>
        <td width="33%" align="center" style="border: 0;">
            <p style="border-top: 1px solid #000000;">Verified By</p>
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>
