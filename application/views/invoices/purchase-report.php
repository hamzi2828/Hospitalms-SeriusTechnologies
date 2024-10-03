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
<div style="text-align: right; font-size: 8pt">
    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Purchase Report </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Invoice</th>
        <th> Item</th>
        <th> Quantity</th>
        <th> Price</th>
        <th> Net Price</th>
        <th> Total Amount</th>
        <th> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $net_total = 0;
        if ( count ( $stocks ) > 0 ) {
            $counter = 1;
            foreach ( $stocks as $stock ) {
                $store_items = explode ( ',', $stock -> store_items );
                $quantities  = explode ( ',', $stock -> quantities );
                $prices      = explode ( ',', $stock -> prices );
                $discounts   = explode ( ',', $stock -> discounts );
                $net_prices  = explode ( ',', $stock -> net_prices );
                ?>
                <tr class="odd gradeX">
                    <td> <?php echo $counter++ ?> </td>
                    <td>
                        <?php echo $stock -> invoice ?>
                    </td>
                    <td>
                        <?php
                            if ( count ( $store_items ) > 0 ) {
                                foreach ( $store_items as $store_id ) {
                                    $store = get_store_by_id ( $store_id );
                                    echo @$store -> item . '<br/>';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( count ( $quantities ) > 0 ) {
                                foreach ( $quantities as $quantity ) {
                                    echo $quantity . '<br/>';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( count ( $prices ) > 0 ) {
                                foreach ( $prices as $price ) {
                                    echo number_format ( $price, 2 ) . '<br/>';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( count ( $net_prices ) > 0 ) {
                                foreach ( $net_prices as $net_price ) {
                                    echo number_format ( $net_price, 2 ) . '<br/>';
                                    $net_total = $net_total + $net_price;
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            $net = 0;
                            if ( count ( $net_prices ) > 0 ) {
                                foreach ( $net_prices as $net_price ) {
                                    $net = $net + $net_price;
                                }
                                echo number_format ( $net, 2 );
                            }
                        ?>
                    </td>
                    <td>
                        <?php echo date_setter ( $stock -> date_added ); ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="6"></td>
        <td><strong><?php echo number_format ( $net_total, 2 ) ?></strong></td>
        <td></td>
    </tr>
    </tfoot>
</table>
</body>
</html>
