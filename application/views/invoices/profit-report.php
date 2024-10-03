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
                <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
            </span>
        </td>
    </tr>
    <tr>
        <td width="100%" style="text-align: right;">
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
            <h3><strong> Pharmacy Profit Report (Sales) </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr style="background: #f5f5f5; border-bottom: 1px solid #000000">
        <th> Sr. No</th>
        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th> Medicine</th>
        <th> Batch</th>
        <th> Account Head</th>
        <th> Sold Qty</th>
        <th> S. Price</th>
        <th> P. Price</th>
        <th> Price</th>
        <th> Net Price</th>
        <th> Discount(%)</th>
        <th> Flat Disc.</th>
        <th> Total</th>
        <th> Gross Profit</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $count         = 1;
        $total         = 0;
        $net           = 0;
        $total_profit  = 0;
        $flat_discount = 0;
        if ( count ( $reports ) > 0 ) {
            foreach ( $reports as $report ) {
                $medicine      = explode ( ',', $report -> medicine_id );
                $stock         = explode ( ',', $report -> stock_id );
                $quantities    = explode ( ',', $report -> quantity );
                $prices        = explode ( ',', $report -> price );
                $acc_head      = get_account_head ( $report -> patient_id );
                $total         = $total + $report -> net_price;
                $sale          = get_sale ( $report -> sale_id );
                $net           = $net + $sale -> total;
                $profit        = 0;
                $flat_discount = $flat_discount + $sale -> flat_discount;
                ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $report -> sale_id; ?></td>
                    <td>
                        <?php
                            foreach ( $medicine as $id ) {
                                $med = get_medicine ( $id );
                                echo $med -> name . '<br>';
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            foreach ( $stock as $id ) {
                                $sto = get_stock ( $id );
                                echo $sto -> batch . '<br>';
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( !empty( $acc_head ) )
                                echo $acc_head -> title;
                            else
                                echo get_patient ( $report -> patient_id ) -> name;
                        ?>
                    </td>
                    <td>
                        <?php
                            foreach ( $quantities as $quantity ) {
                                echo $quantity . '<br>';
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            foreach ( $stock as $key => $id ) {
                                $sto = get_stock ( $id );
                                echo $sto -> sale_unit . '<br>';
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            foreach ( $stock as $id ) {
                                $sto = get_stock ( $id );
                                echo $sto -> tp_unit . '<br>';
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            foreach ( $prices as $price ) {
                                echo $price . '<br>';
                            }
                        ?>
                    </td>
                    <td><?php echo number_format ( $report -> net_price, 2 ); ?></td>
                    <td><?php echo $sale -> discount; ?></td>
                    <td><?php echo $sale -> flat_discount; ?></td>
                    <td><?php echo number_format ( $sale -> total, 2 ); ?></td>
                    <td>
                        <?php
                            foreach ( $stock as $key => $id ) {
                                $sto    = get_stock ( $id );
                                $profit += ( $prices[ $key ] * $quantities[ $key ] ) - ( $sto -> tp_unit * $quantities[ $key ] );
//						$purchase_price = $sto -> tp_unit * $quantities[$key];
//						$profit = $sale -> total - $purchase_price;
                            }
                            $total_profit += $profit;
                            echo number_format ( $profit, 2 );
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr style="background: #f5f5f5; border-top: 1px solid #000000">
                <td colspan="8" class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-left">
                    <strong><?php echo number_format ( $total, 2 ) ?></strong>
                </td>
                <td class="text-right"></td>
                <td>
                    <?php echo number_format ( $flat_discount, 2 ) ?>
                </td>
                <td class="text-left">
                    <strong><?php echo number_format ( $net, 2 ) ?></strong>
                </td>
                <td><strong><?php echo number_format ( $total_profit, 2 ) ?><strong></td>
            </tr>
            <?php
        }
        else {
            ?>
            <tr>
                <td colspan="9">
                    No record found.
                </td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
<br>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Pharmacy Profit Report (Return Sales) </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Medicine</th>
        <th> Batch</th>
        <th> Return Qty</th>
        <th> S. Price</th>
        <th> P. Price</th>
        <th> Paid To Customer</th>
        <th> Gross Profit</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $sr_no        = 1;
        $return_gross = 0;
        if ( count ( $returns ) > 0 ) {
            foreach ( $returns as $return ) {
                $medicine      = get_medicine ( $return -> medicine_id );
                $return_profit = $return -> paid_to_customer - ( $return -> quantity * $return -> tp_unit );
                $return_gross  = $return_gross + $return_profit;
                ?>
                <tr>
                    <td> <?php echo $sr_no++ ?> </td>
                    <td> <?php echo $medicine -> name ?> </td>
                    <td> <?php echo $return -> batch ?> </td>
                    <td> <?php echo $return -> quantity ?> </td>
                    <td> <?php echo $return -> sale_unit ?> </td>
                    <td> <?php echo $return -> tp_unit ?> </td>
                    <td> <?php echo $return -> paid_to_customer ?> </td>
                    <td> <?php echo number_format ( $return_profit, 2 ) ?> </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="7"></td>
                <td> <?php echo number_format ( $return_gross, 2 ) ?> </td>
            </tr>
            <?php
        }
        else {
            ?>
            <tr>
                <td colspan="8">
                    No record found.
                </td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
<h2 style="text-align: right"> Total Profit: <?php echo number_format ( $total_profit - $return_gross ); ?> </h2>
</body>
</html>