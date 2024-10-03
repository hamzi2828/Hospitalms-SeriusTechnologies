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

        .parent {
            padding-left: 25px;
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
            <h3><strong> Adjustments Invoice </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 30px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Adjustment ID#</th>
        <th> Medicine</th>
        <th> Batch#</th>
        <th> Quantity</th>
        <th> Cost/Unit</th>
        <th> G.Total</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $g_total         = 0;
        $total_cost_unit = 0;
        $total_quantity  = 0;
        if ( count ( $sales ) > 0 ) {
            $counter = 1;
            foreach ( $sales as $sale ) {
                $medicine_id = explode ( ',', $sale -> medicine_id );
                $stock_id    = explode ( ',', $sale -> stock_id );
                $quantities  = explode ( ',', $sale -> quantity );
                $prices      = explode ( ',', $sale -> price );
                $sale_info   = get_adjustment_by_id ( $sale -> adjustment_id );
                $total       = $sale_info -> total;
                $g_total     = $g_total + $total;
                ?>
                <tr class="odd gradeX">
                    <td> <?php echo $counter++ ?> </td>
                    <td> <?php echo $sale -> adjustment_id ?> </td>
                    <td>
                        <?php
                            if ( count ( $medicine_id ) > 0 ) {
                                foreach ( $medicine_id as $id ) {
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
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( count ( $stock_id ) > 0 ) {
                                foreach ( $stock_id as $id ) {
                                    echo get_stock ( $id ) -> batch . '<br>';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( count ( $quantities ) > 0 ) {
                                foreach ( $quantities as $quantity ) {
                                    $total_quantity = $total_quantity + $quantity;
                                    echo $quantity . '<br>';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( count ( $prices ) > 0 ) {
                                foreach ( $prices as $price ) {
                                    $total_cost_unit = $total_cost_unit + $price;
                                    echo $price . '<br>';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php echo round ( $total, 2 ) ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4"></td>
        <td>
            <strong><?php echo number_format ( $total_quantity, 2 ) ?></strong>
        </td>
        <td>
            <strong><?php echo number_format ( $total_cost_unit, 2 ) ?></strong>
        </td>
        <td>
            <strong><?php echo number_format ( $g_total, 2 ) ?></strong>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>