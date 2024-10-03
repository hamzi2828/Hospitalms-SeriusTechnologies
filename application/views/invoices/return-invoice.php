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
<div style="text-align: right">
    <strong>Supplier:</strong> <?php echo $supplier -> title ?><br>
    <strong>Return Date:</strong> <?php echo date_setter ( $return_info -> date_added ) ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Return Invoice </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr style="background: #f5f5f5;">
        <td style="width: 10%">Sr. No.</td>
        <td>Supplier</td>
        <td>Medicine</td>
        <td>Batch</td>
        <td>Invoice</td>
        <td>Return Qty</td>
        <td>Cost/Unit</td>
        <td>Net Price</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <?php
        $counter  = 1;
        $total    = 0;
        $discount = 0;
        if ( count ( $returns ) > 0 ) {
            foreach ( $returns as $return ) {
                $medicine = get_medicine ( $return -> medicine_id );
                $stock    = get_stock ( $return -> stock_id );
                $supplier = get_account_head ( $return -> supplier_id );
                $generic  = get_generic ( $medicine -> generic_id );
                $form     = get_form ( $medicine -> form_id );
                $strength = get_strength ( $medicine -> strength_id );
                
                $name = $medicine -> name;
                if ( $medicine -> form_id > 1 )
                    $name .= ' ' . $form -> title;
                
                if ( $medicine -> strength_id > 1 )
                    $name .= ' ' . $strength -> title;
                ?>
                <tr>
                    <td align="center"><?php echo $counter++ ?></td>
                    <td align="center"><?php echo $supplier -> title ?></td>
                    <td align="center"><?php echo $name ?></td>
                    <td align="center"><?php echo $stock -> batch ?></td>
                    <td align="center"><?php echo $return -> invoice ?></td>
                    <td align="center"><?php echo $return -> return_qty ?></td>
                    <td align="center"><?php echo $return -> cost_unit ?></td>
                    <td align="center"><?php echo $return -> net_price ?></td>
                </tr>
                <?php
            }
            ?>
            
            <!-- END ITEMS HERE -->
            <tr>
                <td class="blanktotal" colspan="7"></td>
                <td class="totals cost"><strong>Pkr-<?php echo $return_info -> total ?>/-</strong></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</body>
</html>