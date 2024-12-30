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
            <h3><strong> Cafe Store Stock Invoice </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8" border="1">
    <thead>
    <tr>
        <th>Sr. No</th>
        <th>Invoice</th>
        <th>Supplier</th>
        <th>Items</th>
        <th>Quantities</th>
        <th>TP Unit</th>
        <th>Net Prices</th>
        <th>Date Added</th>
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
                <td> <?php echo $stock->invoice; ?> </td>
                <td> <?php echo @get_account_head($stock->supplier_id)->title; ?> </td>
                <td>
                    <?php
                    $product = get_product_by_id($stock->product_id); 
                    echo @$product->name ?? 'Unknown Item';
                    ?>
                </td>
                <td>
                    <?php echo number_format($stock->quantity, 2); ?>
                </td>
                <td>
                    <?php echo number_format($stock->tp_unit, 2); ?>
                </td>
                <td>
                    <?php echo number_format($stock->net_price, 2); ?>
                </td>
                <td>
                    <?php echo date_setter($stock->date_added); ?>
                </td>
             
            </tr>
            <?php
        }
  ?>
            <tr>
                <td colspan="7" class="text-right" align="right">
                    <strong>Total:</strong>
                </td>
                <td>
                <strong><?php echo isset($stock_info->total) ? number_format($stock_info->total, 2) : '0.00'; ?></strong>
            </td>
            </tr>
            <tr>
                <td colspan="7" class="text-right" align="right">
                    <strong>Bill Discount (%):</strong>
                </td>
                <td>
                    <strong><?php echo number_format ( $stock_info -> discount, 2 ) ?></strong>
                </td>
            </tr>
            <tr>
                <td colspan="7" class=" text-right" align="right">
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