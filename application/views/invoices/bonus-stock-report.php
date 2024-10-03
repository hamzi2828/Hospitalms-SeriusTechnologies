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
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Bonus Stock Report </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Medicine</th>
        <th> Total Qty.</th>
        <th> Sold Qty.</th>
        <th> Internal Issued Qty.</th>
        <th> IPD Issued Qty.</th>
        <th> Return Supplier</th>
        <th> Adjustment Qty.</th>
        <th> Available Qty.</th>
        <th> Value w.r.t Total Qty.</th>
        <th> Value w.r.t Sold Qty.</th>
        <th> Value w.r.t Issued Qty.</th>
        <th> Value w.r.t Available Qty.</th>
    </tr>
    </thead>
    <tbody>
    <?php
        if ( count ( $stocks ) > 0 ) {
            $counter       = 1;
            $net_total     = 0;
            $net_sold      = 0;
            $net_issued    = 0;
            $net_available = 0;
            foreach ( $stocks as $stock ) {
                $medicine        = get_medicine ( $stock -> id );
                $sold            = get_sold_quantity ( $medicine -> id );
                $quantity        = get_stock_quantity ( $medicine -> id );
                $expired         = get_stock_expired_quantity ( $medicine -> id );
                $issued          = get_issued_quantity ( $medicine -> id );
                $ipd_issuance    = get_ipd_issued_medicine_quantity ( $medicine -> id );
                $return_supplier = get_returned_medicines_quantity_by_supplier ( $medicine -> id );
                $adjustment_qty  = get_total_adjustments_by_medicine_id ( $medicine -> id );
                $available       = $quantity - $sold - $expired - $issued - $ipd_issuance - $return_supplier - $adjustment_qty;
                $tot_value       = get_stock_price_by_medicine_id_total_quantity ( $medicine -> id, $quantity );
                $sold_value      = get_stock_price_by_medicine_id_sold_quantity ( $medicine -> id, $sold );
                $a_value         = get_stock_price_by_medicine_id_available_quantity ( $medicine -> id, $available );
                $i_value         = get_stock_price_by_medicine_id_issued_quantity ( $medicine -> id, $issued );
                $net_total       = $net_total + $tot_value;
                $net_sold        = $net_sold + $sold_value;
                $net_issued      = $net_issued + $i_value;
                $net_available   = $net_available + $a_value;
                ?>
                <tr class="odd gradeX">
                    <td> <?php echo $counter++ ?> </td>
                    <td>
                        <?php
                            echo $medicine -> name;
                            if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 ) :
                                ?>
                                (<?php echo get_form ( $medicine -> form_id ) -> title ?> - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
                            <?php endif ?>
                    </td>
                    <td><?php echo $quantity > 0 ? $quantity : 0 ?></td>
                    <td><?php echo $sold > 0 ? $sold : 0 ?></td>
                    <td><?php echo $issued > 0 ? $issued : 0 ?></td>
                    <td><?php echo $ipd_issuance > 0 ? $ipd_issuance : 0 ?></td>
                    <td><?php echo $return_supplier > 0 ? $return_supplier : 0 ?></td>
                    <td><?php echo $adjustment_qty > 0 ? $adjustment_qty : 0 ?></td>
                    <td><?php echo $available > 0 ? $available : 0 ?></td>
                    <td><?php echo $tot_value > 0 ? $tot_value : 0 ?></td>
                    <td><?php echo $sold_value > 0 ? $sold_value : 0 ?></td>
                    <td><?php echo $i_value > 0 ? $i_value : 0 ?></td>
                    <td><?php echo $a_value > 0 ? $a_value : 0 ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="9"></td>
                <td>
                    <strong><?php echo $net_total ?></strong>
                </td>
                <td>
                    <strong><?php echo $net_sold ?></strong>
                </td>
                <td>
                    <strong><?php echo $net_issued ?></strong>
                </td>
                <td>
                    <strong><?php echo $net_available ?></strong>
                </td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</body>
</html>