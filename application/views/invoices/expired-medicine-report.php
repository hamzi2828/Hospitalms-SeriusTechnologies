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
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Expired Medicine Report </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <tbody>
    <?php
        $net = 0;
        if ( count ( $medicines ) > 0 ) {
            foreach ( $medicines as $medicine ) {
                $stocks = get_expired_medicine_stocks ( $medicine -> id );
                if ( count ( $stocks ) > 0 ) {
                    ?>
                    <tr class="odd gradeX">
                        <td class="text-center" style="text-align: center; margin: 10px 0">
                            <h3 class="text-center" style="text-align: center; margin: 10px 0">
                                <strong><?php echo $medicine -> name . '(' . get_strength ( $medicine -> strength_id ) -> title . ')' ?></strong>
                            </h3>
                        </td>
                    </tr>
                    <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; "
                           cellpadding="8" border="1">
                        <thead>
                        <tr>
                            <th> Sr. No</th>
                            <th> Medicine</th>
                            <th> Supplier</th>
                            <th> Batch No.</th>
                            <th> Expiry Date</th>
                            <th> Invoice#</th>
                            <th> Quantity</th>
                            <th> Cost</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $counter = 1;
                            if ( count ( $stocks ) > 0 ) {
                                foreach ( $stocks as $stock ) {
                                    $medicine = get_medicine ( $stock -> medicine_id );
                                    $strength = get_strength ( $medicine -> strength_id );
                                    $form     = get_form ( $medicine -> form_id );
                                    $supplier = get_supplier ( $stock -> supplier_id );
                                    $sold     = get_sold_quantity_by_stock ( $stock -> medicine_id, $stock -> id );
                                    $returned = get_medicine_returned_quantity ( $medicine -> id );
                                    
                                    $sold              = get_sold_quantity_by_stock ( $stock -> medicine_id, $stock -> id );
                                    $supplier_returned = get_stock_returned_quantity ( $stock -> id );
                                    $returned_customer = get_stock_returned_quantity_by_customer ( $stock -> medicine_id, $stock -> id );
                                    $issued            = check_stock_issued_quantity ( $stock -> id );
                                    $ipd_med           = get_ipd_medication_assigned_count_by_stock_and_medicine ( $medicine -> id, $stock -> id );
                                    $adjustment_qty    = count_medicine_adjustment_by_medicine_id ( $stock -> medicine_id, $stock -> id );
                                    $available         = $stock -> quantity - $sold - $ipd_med - $issued - $supplier_returned - $adjustment_qty;
                                    $cost              = $stock -> tp_unit * $available;
                                    $net               = $net + $cost;
                                    $isDiscarded       = check_if_medicine_discarded ( $stock -> medicine_id, $stock -> id, $stock -> batch );
                                    $expired           = get_expired_quantity_medicine_id ( $stock -> medicine_id );
                                    
                                    if ( $available > 0 and !$isDiscarded ) {
                                        ?>
                                        <tr class="odd gradeX" <?php if ( $stock -> expiry_date < date ( 'Y-m-d' ) )
                                            echo 'style="background: rgba(255,0,0, 0.5)"' ?>>
                                            <td> <?php echo $counter++ ?> </td>
                                            <td><?php echo $medicine -> name . ' ' . $strength -> title . '(' . $form -> title . ')' ?></td>
                                            <td><?php echo $supplier -> title ?></td>
                                            <td><?php echo $stock -> batch ?></td>
                                            <td><?php echo date ( 'm/d/Y', strtotime ( $stock -> expiry_date ) ) ?></td>
                                            <td><?php echo $stock -> supplier_invoice ?></td>
                                            <td><?php echo $expired ?></td>
                                            <td><?php echo number_format ( $cost, 2 ) ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                    <?php
                }
            }
        }
    ?>
    </tbody>
</table>
<h1 style="float: right;text-align: right">
    <strong><?php echo number_format ( $net, 2 ) ?></strong>
</h1>
</body>
</html>
