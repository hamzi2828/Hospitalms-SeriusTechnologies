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

        table#print-info {
            border: 0;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        #print-info td {
            border-left: 0;
            border-right: 0;
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

        #print-info tr td {
            border-bottom: 1px dotted #000000;
            padding-left: 0;
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
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Discarded Expired Medicine </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th align="center"> Sr. No</th>
        <th align="left"> Medicine</th>
        <th align="left"> Supplier</th>
        <th align="left"> Invoice#</th>
        <th align="left"> Batch No</th>
        <th align="left"> Expiry Date</th>
        <th> Quantity</th>
        <th> Net Cost</th>
        <th align="left"> Date Discarded</th>
        <th align="left"> Discarded By</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        $net     = 0;
        if ( count ( $medicines ) > 0 ) {
            foreach ( $medicines as $medicine ) {
                $med      = get_medicine ( $medicine -> medicine_id );
                $sold     = get_sold_quantity ( $medicine -> medicine_id );
                $quantity = get_stock_quantity ( $medicine -> medicine_id );
                $generic  = get_generic ( $med -> generic_id );
                $form     = get_form ( $med -> form_id );
                $strength = get_strength ( $med -> strength_id );
                $stock    = get_stock_by_id ( $medicine -> stock_id );
                $supplier = get_account_head ( $stock -> supplier_id );
                $user     = get_user ( $medicine -> user_id );
                $net      = $net + ( $medicine -> net_cost );
                $name     = get_medicine_name ( $med );
                ?>
                <tr>
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td align="left">
                        <?php echo $name ?>
                    </td>
                    <td align="left"><?php echo $supplier -> title ?></td>
                    <td align="left"><?php echo $stock -> supplier_invoice ?></td>
                    <td align="left"><?php echo $medicine -> batch_no ?></td>
                    <td><?php echo date ( 'm/d/Y', strtotime ( $stock -> expiry_date ) ) ?></td>
                    <td><?php echo $medicine -> quantity ?></td>
                    <td><?php echo number_format ( $medicine -> net_cost, 2 ) ?></td>
                    <td align="left"><?php echo date_setter ( $medicine -> date_added, 5 ) ?></td>
                    <td align="left"><?php echo $user -> name ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="6" align="right"><strong>Total</strong></td>
        <td align="center">
            <strong><?php echo number_format ( $net, 2 ) ?></strong>
        </td>
        <td></td>
        <td></td>
    </tr>
    </tfoot>
</table>

</body>
</html>