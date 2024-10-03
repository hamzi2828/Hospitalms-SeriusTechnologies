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

        .has-medicines td {
            background: #bce8f1 !important;
            font-size: 16px;
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
            <h3><strong> Form Wise Report </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <?php
        
        if ( count ( $forms ) > 0 ) {
        $counter = 1;
        foreach ( $forms
        
        as $form ) {
        $medicines = get_medicines_by_form ( $form -> id );
    ?>
    <tr class="odd gradeX <?php if ( count ( $medicines ) > 0 ) echo 'has-medicines' ?>">
        <td> <?php echo $counter++ ?> </td>
        <td><strong><?php echo $form -> title ?></strong></td>
        <td colspan="14"></td>
    </tr>
    <thead>
    <tr>
        <th></th>
        <th> Sr. No</th>
        <th> Medicine</th>
        <th> Generic</th>
        <th> Strength</th>
        <th> Type</th>
        <th> Total Qty.</th>
        <th> Sold Qty.</th>
        <th> Returned Customer.</th>
        <th> Returned Supplier.</th>
        <th> Expired Qty.</th>
        <th> Internally Issued Qty.</th>
        <th> IPD Issued Qty.</th>
        <th> Adjustment Qty.</th>
        <th> Available Qty.</th>
        <th> Net Value</th>
    </tr>
    </thead>
    <tbody>
    <?php
        if ( count ( $medicines ) > 0 ) {
            $m_counter = 1;
            $total     = 0;
            foreach ( $medicines as $medicine ) {
                $sold            = get_sold_quantity ( $medicine -> id );
                $quantity        = get_stock_quantity ( $medicine -> id );
                $expired         = get_stock_expired_quantity ( $medicine -> id );
                $generic         = get_generic ( $medicine -> generic_id );
                $form            = get_form ( $medicine -> form_id );
                $strength        = get_strength ( $medicine -> strength_id );
                $returned        = get_medicine_returned_quantity ( $medicine -> id );
                $issued          = get_issued_quantity ( $medicine -> id );
                $ipd_issuance    = get_ipd_issued_medicine_quantity ( $medicine -> id );
                $return_supplier = get_returned_medicines_quantity_by_supplier ( $medicine -> id );
                $adjustment_qty  = get_total_adjustments_by_medicine_id ( $medicine -> id );
                $available       = $quantity - $sold - $expired - $issued - $ipd_issuance - $return_supplier - $adjustment_qty;
                $net_value       = get_all_stock_price_by_medicine_id ( $medicine -> id );
                $total           = $total + $net_value;
                ?>
                <tr class="odd gradeX">
                    <td></td>
                    <td align="center"> <?php echo $m_counter++ ?> </td>
                    <td><?php echo $medicine -> name ?></td>
                    <td><?php echo $generic -> title ?></td>
                    <td><?php echo $strength -> title ?></td>
                    <td><?php echo ucfirst ( $medicine -> type ) ?></td>
                    <td><?php echo $quantity > 0 ? $quantity : 0 ?></td>
                    <td><?php echo $sold > 0 ? $sold : 0 ?></td>
                    <td><?php echo $returned > 0 ? $returned : 0 ?></td>
                    <td><?php echo $return_supplier > 0 ? $return_supplier : 0 ?></td>
                    <td><?php echo $expired > 0 ? $expired : 0 ?></td>
                    <td><?php echo $issued > 0 ? $issued : 0 ?></td>
                    <td><?php echo $ipd_issuance > 0 ? $ipd_issuance : 0 ?></td>
                    <td><?php echo $adjustment_qty > 0 ? $adjustment_qty : 0 ?></td>
                    <td><?php echo $available ?></td>
                    <td><?php echo number_format ( $net_value, 2 ) ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="15" align="right">
                    <strong>Total:</strong>
                </td>
                <td>
                    <strong><?php echo number_format ( $total, 2 ) ?></strong>
                </td>
            </tr>
            <?php
        }
        }
        }
    ?>
    </tbody>
</table>
</body>
</html>