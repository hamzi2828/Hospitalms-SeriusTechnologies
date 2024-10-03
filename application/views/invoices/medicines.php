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
    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Medicines </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Name</th>
        <th> Generic</th>
        <th> Form</th>
        <th> Strength</th>
        <th> Type</th>
        <th> TP/Unit</th>
        <th> SP/Unit</th>
        <th> Total Qty.</th>
        <th> Sold Qty.</th>
        <th> Returned Customer.</th>
        <th> Returned Supplier.</th>
        <th> Internally Issued Qty.</th>
        <th> IPD Issued Qty.</th>
        <th> Adjustment Qty.</th>
        <th> Available Qty.</th>
        <th> Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
        if ( count ( $medicines ) > 0 ) {
            $counter = 1;
            foreach ( $medicines as $medicine ) {
                $sold            = get_sold_quantity ( $medicine -> id );
                $quantity        = get_stock_quantity ( $medicine -> id );
                $generic         = get_generic ( $medicine -> generic_id );
                $form            = get_form ( $medicine -> form_id );
                $strength        = get_strength ( $medicine -> strength_id );
                $returned        = get_medicine_returned_quantity ( $medicine -> id );
                $issued          = get_issued_quantity ( $medicine -> id );
                $stock           = get_latest_medicine_stock ( $medicine -> id );
                $ipd_issuance    = get_ipd_issued_medicine_quantity ( $medicine -> id );
                $return_supplier = get_returned_medicines_quantity_by_supplier ( $medicine -> id );
                $adjustment_qty  = get_total_adjustments_by_medicine_id ( $medicine -> id );
                ?>
                <tr class="odd gradeX">
                    <td> <?php echo $counter++ ?> </td>
                    <td><?php echo $medicine -> name ?></td>
                    <td><?php if ( $medicine -> generic_id > 1 ) echo $generic -> title ?></td>
                    <td><?php if ( $medicine -> form_id > 1 ) echo $form -> title ?></td>
                    <td><?php if ( $medicine -> strength_id > 1 ) echo $strength -> title ?></td>
                    <td><?php echo ucfirst ( $medicine -> type ) ?></td>
                    <td><?php echo @$medicine -> tp_unit ?></td>
                    <td><?php echo @$medicine -> sale_unit ?></td>
                    <td><?php echo $quantity > 0 ? $quantity : 0 ?></td>
                    <td><?php echo $sold > 0 ? $sold : 0 ?></td>
                    <td><?php echo $returned > 0 ? $returned : 0 ?></td>
                    <td><?php echo $return_supplier > 0 ? $return_supplier : 0 ?></td>
                    <td><?php echo $issued > 0 ? $issued : 0 ?></td>
                    <td><?php echo $ipd_issuance > 0 ? $ipd_issuance : 0 ?></td>
                    <td><?php echo $adjustment_qty > 0 ? $adjustment_qty : 0 ?></td>
                    <td>
                        <?php
                            echo $quantity - $sold - $issued - $ipd_issuance - $return_supplier - $adjustment_qty;
                        ?>
                    </td>
                    <td>
                        <?php echo ( $medicine -> status == '1' ) ? 'Active' : 'Inactive' ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
</body>
</html>