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
                <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?><br/>
            </span>
        </td>
    </tr>
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Store Stock Valuation Report </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> Name</th>
        <th align="left"> Type</th>
        <th> Total Qty.</th>
        <th> Issued Qty.</th>
        <th> Available Qty.</th>
        <th> Net Value</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $total   = 0;
        $counter = 1;
        if ( count ( $stores ) > 0 ) {
            foreach ( $stores as $store ) {
                $sold      = get_store_stock_sold_quantity ( $store -> id );
                $quantity  = get_store_stock_total_quantity ( $store -> id );
                $available = $quantity - $sold;
                $net_value = get_available_stock_price ( $store -> id );
                $total     = $total + $net_value;
                
                if ( $available > 0 ) {
                    ?>
                    <tr class="odd gradeX">
                        <td align="center"> <?php echo $counter++ ?> </td>
                        <td><?php echo $store -> item ?></td>
                        <td><?php echo ucwords ( $store -> type ) ?></td>
                        <td align="center"><?php echo $quantity > 0 ? $quantity : 0 ?></td>
                        <td align="center"><?php echo $sold > 0 ? $sold : 0 ?></td>
                        <td align="center"><?php echo $available ?></td>
                        <td align="center"><?php echo number_format ( $net_value, 2 ) ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td colspan="6" class="text-right" align="right">
                    <strong>Total:</strong>
                </td>
                <td align="center">
                    <strong><?php echo number_format ( $total, 2 ) ?></strong>
                </td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</body>
</html>
