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
            <h3><strong> Pharmacy General Report (Returns) </strong></h3>
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
        <th> Invoice</th>
        <th> Batch</th>
        <th> Expiry</th>
        <th> Quantity</th>
        <th> Paid To Customer</th>
        <th> Date Returned</th>
    </tr>
    </thead>
    <tbody>
    <?php
        if ( count ( $reports ) > 0 ) {
            $count = 1;
            $net   = 0;
            foreach ( $reports as $report ) {
                $medicine = get_medicine ( $report -> medicine_id );
                $supplier = get_account_head ( $report -> supplier_id );
                $net      = $net + $report -> paid_to_customer;
                $generic  = get_generic ( $medicine -> generic_id );
                $form     = get_form ( $medicine -> form_id );
                $strength = get_strength ( $medicine -> strength_id );
                ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $supplier -> title; ?></td>
                    <td>
                        <?php
                            echo $medicine -> name;
                            if ( $medicine -> generic_id > 1 ) echo $generic -> title . ' ';
                            if ( $medicine -> form_id > 1 ) echo $form -> title . ' ';
                            if ( $medicine -> strength_id > 1 ) echo $strength -> title . ' ';
                        ?>
                    </td>
                    <td><?php echo $report -> supplier_invoice ?></td>
                    <td><?php echo $report -> batch ?></td>
                    <td><?php echo $report -> expiry_date ?></td>
                    <td><?php echo $report -> quantity ?></td>
                    <td><?php echo $report -> paid_to_customer ?></td>
                    <td><?php echo date_setter ( $report -> date_added ); ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="6" class="text-right"></td>
                <td class="text-right">
                    <strong>Total:</strong>
                </td>
                <td class="text-left">
                    <?php echo number_format ( $net, 2 ) ?>
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