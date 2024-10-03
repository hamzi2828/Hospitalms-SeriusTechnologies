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
<div style="text-align: right">
    Invoice# <strong><?php echo $stocks[ 0 ] -> supplier_invoice ?></strong> <br />
    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y', strtotime ( $stocks[ 0 ] -> date_added ) ) ?> <br />
    <strong>Print Date:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Local Purchase </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Supplier</th>
        <th> Medicine</th>
        <th> Expiry</th>
        <th> Invoice#</th>
        <th> Quantity</th>
        <!--        <th> Sold </th>-->
        <!--        <th> Returned </th>-->
        <!--        <th> Available </th>-->
        <th> TP</th>
        <th> Value</th>
        <th> Sale Price</th>
        <th> Net Price</th>
        <th> Description</th>
        <th> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        if ( count ( $stocks ) > 0 ) {
            $counter = 1;
            $net     = 0;
            foreach ( $stocks as $stock ) {
                $medicine = get_medicine ( $stock -> medicine_id );
                $supplier = get_supplier ( $stock -> supplier_id );
                $date     = date ( 'Y-m-d', strtotime ( $stock -> date_added ) );
                $sold     = get_sold_quantity_by_stock ( $stock -> medicine_id, $stock -> id );
                $returned = get_stock_returned_quantity ( $stock -> medicine_id );
                $net      = $net + ( $stock -> quantity * $stock -> tp_unit );
                ?>
                <tr class="odd gradeX">
                    <td> <?php echo $counter++ ?> </td>
                    <td><?php echo $supplier -> title ?></td>
                    <td>
                        <?php
                            $strength = get_strength ( $medicine -> strength_id );
                            $form     = get_form ( $medicine -> form_id );
                            echo $medicine -> name . ' ' . $strength -> title . '(' . $form -> title . ')';
                        ?>
                    </td>
                    <td><?php echo date_setter ( $stock -> expiry_date ) ?></td>
                    <td><?php echo $stock -> supplier_invoice ?></td>
                    <td><?php echo $stock -> quantity ?></td>
                    <!--                <td> --><?php //echo $sold; ?><!-- </td>-->
                    <!--                <td> --><?php //echo $returned; ?><!-- </td>-->
                    <!--                <td>-->
                    <!--					--><?php
                        //					$sold       = get_sold_quantity_by_stock($stock -> medicine_id, $stock -> id);
                        //					$returned   = get_stock_returned_quantity($stock -> medicine_id);
                        //					$available  = $stock -> quantity - $sold;
                        //					echo $available;
                        //					?>
                    <!--                </td>-->
                    <td> <?php echo $stock -> tp_unit; ?> </td>
                    <td>
                        <?php
                            $sold     = get_sold_quantity_by_stock ( $stock -> medicine_id, $stock -> id );
                            $returned = get_stock_returned_quantity ( $stock -> medicine_id );
                            $quantity = $stock -> quantity;
                            $tp       = $stock -> tp_unit;
                            echo number_format ( ( $quantity - $sold ) * $tp, 2 );
                        ?>
                    </td>
                    <td> <?php echo $stock -> sale_unit; ?> </td>
                    <td> <?php echo $stock -> quantity * $stock -> tp_unit; ?> </td>
                    <td> <?php echo $stock -> description; ?> </td>
                    <td><?php echo date_setter ( $stock -> date_added ) ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="9"></td>
                <td><strong><?php echo $net ?></strong></td>
                <td></td>
                <td></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</body>
</html>
