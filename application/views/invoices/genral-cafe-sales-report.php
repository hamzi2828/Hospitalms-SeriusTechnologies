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
<table width="100%">
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 8pt;">
                <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?><br />
            </span>
            <span style="font-size: 8pt;">
                <strong>Search Criteria:</strong>
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?>
                <?php echo !empty( @$_REQUEST[ 'start_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'start_time' ] ) ) : '' ?> @
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
                <?php echo !empty( @$_REQUEST[ 'end_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'end_time' ] ) ) : '' ?>
            </span>
        </td>
    </tr>
    
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> General Sales Report (Cafe) </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
       <thead>
        <tr>
            <th>Sr. No</th>
            <th>Invoice ID</th>
            <th>Items</th>
            <th>Sale Qty</th>
            <th>Price</th>
            <th>Total</th>
            <th>Disc (Flat)</th>
            <th>Net Total</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $i = 1; 
    $total_net_total = 0; // Initialize total variable
    $total_grand_total_discount = 0;
    foreach ($grouped_sales as $invoice_id => $group) { 
        $total_net_total += $group['grand_total'];
        $total_grand_total_discount += $group['grand_total_discount'];
    ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td>
                <?php echo $group['invoice_id']; ?>
                <?php if ($group['refunded'] == 1): ?>
                    <span class="badge badge-danger">Refunded</span>
                <?php endif; ?>
            </td>
            <td><?php echo implode('<br>', $group['items']); ?></td>
            <td><?php echo implode('<br>', $group['sale_qtys']); ?></td>
            <td><?php echo implode('<br>', $group['prices']); ?></td>
            <td><?php echo implode('<br>', $group['net_prices']); ?></td>
            <td><?php echo $group['grand_total_discount']; ?></td>
            <td><?php echo $group['grand_total']; ?></td>
            <td><?php echo $group['created_at']; ?></td>
        </tr>
    <?php $i++; } ?>
</tbody>

<tfoot>
    <tr>
        <td colspan="6" style="text-align: right; font-weight: bold;">Total:</td>
        <td style="font-weight: bold;"><?php echo $total_grand_total_discount; ?></td>
        <td style="font-weight: bold;"><?php echo $total_net_total; ?></td>
        <td></td>
    </tr>
</tfoot>

</table>
</body>
</html>