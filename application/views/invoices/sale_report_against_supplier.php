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
    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<div style="text-align: right">
    <strong>Search Criteria:</strong>
    <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?>
    <?php echo !empty( @$_REQUEST[ 'start_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'start_time' ] ) ) : '' ?>
    @
    <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
    <?php echo !empty( @$_REQUEST[ 'end_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'end_time' ] ) ) : '' ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Sale Report Against Suppliers </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <thead>
    <tr style="background: #f5f5f5; border-bottom: 1px solid #000000">
        <th> Sr. No</th>
        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th> Medicine</th>
        <th> Sold Qty</th>
        <th> Net Price</th>
        <th> Discount(%)</th>
        <th> Flat Disc.</th>
        <th> Total</th>
        <th> Date Sold</th>
    </tr>
    </thead>
    <tbody>
    <?php
        if ( count ( $reports ) > 0 ) {
            $count         = 1;
            $total         = 0;
            $net           = 0;
            $flat_discount = 0;
            $net_quantity  = 0;
            foreach ( $reports as $report ) {
                $medicine      = explode ( ',', $report -> medicine_id );
                $stock         = explode ( ',', $report -> stock_id );
                $quantities    = explode ( ',', $report -> quantity );
                $prices        = explode ( ',', $report -> price );
                $acc_head      = get_account_head ( $report -> patient_id );
                $total         = $total + $report -> net_price;
                $sale          = get_sale ( $report -> sale_id );
                $net           = $net + $sale -> total;
                $flat_discount = $flat_discount + $sale -> flat_discount;
                $user          = get_user ( $report -> user_id );
                ?>
                <tr>
                    <td align="center"><?php echo $count++; ?></td>
                    <td align="center"><?php echo $report -> sale_id; ?></td>
                    <td align="center">
                        <?php
                            foreach ( $medicine as $id ) {
                                $med = get_medicine ( $id );
                                if ( $med -> strength_id > 1 )
                                    $strength = get_strength ( $med -> strength_id ) -> title;
                                else
                                    $strength = '';
                                if ( $med -> form_id > 1 )
                                    $form = get_form ( $med -> form_id ) -> title;
                                else
                                    $form = '';
                                echo $med -> name . ' ' . $strength . ' ' . $form . '<br>';
                            }
                        ?>
                    </td>
                    <td align="center">
                        <?php
                            foreach ( $quantities as $quantity ) {
                                echo $quantity . '<br>';
                                $net_quantity = $net_quantity + $quantity;
                            }
                        ?>
                    </td>
                    <td align="center"><?php echo number_format ( $report -> net_price, 2 ); ?></td>
                    <td align="center"><?php echo $sale -> discount; ?></td>
                    <td align="center"><?php echo $sale -> flat_discount; ?></td>
                    <td align="center">
                        <?php echo number_format ( $sale -> total, 2 ); ?>
                    </td>
                    <td align="center"><?php echo date_setter ( $report -> date_sold ); ?></td>
                </tr>
                <?php
            }
            ?>
            <tr style="background: #f5f5f5; border-top: 1px solid #000000">
                <td colspan="3" class="text-right" align="center"></td>
                <td class="text-left" align="center">
                    <strong><?php echo number_format ( $net_quantity, 2 ) ?></strong>
                </td>
                <td class="text-left" align="center">
                    <strong><?php echo number_format ( $total, 2 ) ?></strong>
                </td>
                <td class="text-right" align="center"></td>
                <td>
                    <strong><?php echo number_format ( $flat_discount, 2 ) ?></strong>
                </td>
                <td class="text-left" align="center">
                    <strong><?php echo number_format ( $net, 2 ) ?></strong>
                </td>
                <td></td>
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
</body>
</html>