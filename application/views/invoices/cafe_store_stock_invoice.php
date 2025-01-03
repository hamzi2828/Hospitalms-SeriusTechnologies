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
    <p style="font-size: 18px">
        <strong><?php echo @$_REQUEST[ 'invoice' ] ?></strong>
    </p>
    <strong>Supplier: </strong>
    <?php
        $supplier = get_supplier ( $stocks[ 0 ] -> supplier_id );
        if ( !empty( $supplier ) )
            echo $supplier -> title;
    ?>
    <br /><br />
    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Cafe Stock Invoice </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8" border="1">
    <thead>
    <tr>
        <th>Sr. No</th>
        <th>Items</th>

        <th>Quantity (Units)</th>
        <th>TP/Box</th>
        <th>Pack Size</th>
        <th>TP Unit</th>
        <th>Sale/Box</th>
        <th>Sale/Unit</th>
        <th>Discount</th>
        <th>Net Prices</th>
    </tr>
    </thead>

    <tbody>
    <?php
    if (count($stocks) > 0) {
        $counter = 1;
        foreach ($stocks as $stock) {
            ?>
            <tr class="odd gradeX">
                <td> <?php echo $counter++; ?> </td>
                <td style="width: 130px;">
                    <?php
                    $product = get_product_by_id($stock->product_id); 
                    echo @$product->name ?? 'Unknown Item';
                    ?>
                </td>
                <td>
                    <?php echo number_format($stock->quantity, 0); ?>
                </td>
                <td>
                    <?php echo number_format($stock->tp_box, 2); ?>
                </td>
                <td style="font-weight: normal;">
                    <?php echo number_format($stock->pack_size, 2); ?>
                </td>
                <td>
                    <?php echo number_format($stock->tp_unit, 2); ?>
                </td>
                <td style="font-weight: normal;">
                    <?php echo number_format($stock->sale_box, 2); ?>
                </th>
                <td style="font-weight: normal;">
                    <?php echo number_format($stock->sale_unit, 2); ?>
                </th>
                <td style="font-weight: normal;">
                    <?php echo number_format($stock->discount, 2); ?>
                </th>
                <td>
                    <?php echo number_format($stock->net_price, 2); ?>
                </td>
               
             
            </tr>
            <?php
        }
      ?>
            <tr>
                <td colspan="9" class="text-right" align="right">
                    <strong>Total:</strong>
                </td>
                <td>
                <strong><?php echo isset($stock_info->total) ? number_format($stock_info->total, 2) : '0.00'; ?></strong>
            </td>
            </tr>
            <tr>
                <td colspan="9" class="text-right" align="right">
                    <strong>Bill Discount (Flat):</strong>
                </td>
                <td>
                    <strong><?php echo number_format ( $stock_info -> discount, 2 ) ?></strong>
                </td>
            </tr>
            <tr>
                <td colspan="9" class=" text-right" align="right">
                    <strong>Net Bill:</strong>
                </td>
                <td>
                    <strong><?php echo number_format ( $stock_info -> total, 2 ) ?></strong>
                </td>
            </tr>
            <?php
        
    }
    ?>
    </tbody>
</table>

</body>
</html>