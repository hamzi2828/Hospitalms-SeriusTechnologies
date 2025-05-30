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
            <h3><strong> Analysis Report </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Supplier</th>
        <th> Invoice</th>
        <th> Medicines</th>
        <th> Quantity</th>
        <th> Total</th>
        <th> Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
        if ( count ( $analysis ) > 0 ) {
            $counter        = 1;
            $total          = 0;
            $total_quantity = 0;
            foreach ( $analysis as $stock ) {
                $medicines  = explode ( ',', $stock -> medicines );
                $quantities = explode ( ',', $stock -> quantities );
                $total      = $total + $stock -> net_price;
                ?>
                <tr>
                    <td> <?php echo $counter; ?> </td>
                    <td> <?php echo get_supplier ( $stock -> supplier_id ) -> title ?> </td>
                    <td> <?php echo $stock -> supplier_invoice ?> </td>
                    <td>
                        <?php
                            if ( count ( $medicines ) > 0 ) {
                                foreach ( $medicines as $medicine ) {
                                    $med = get_medicine ( $medicine );
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
                            if ( count ( $quantities ) > 0 ) {
                                foreach ( $quantities as $quantity ) {
                                    $total_quantity += $quantity;
                                    echo $quantity . '<br>';
                                }
                            }
                        ?>
                    </td>
                    <td> <?php echo number_format ( $stock -> net_price, 2 ) ?> </td>
                    <td> <?php echo date_setter ( $stock -> date_added ) ?> </td>
                </tr>
                <?php
                $counter++;
            }
            ?>
            <tr>
                <td colspan="5" align="right">
                    <strong><?php echo number_format ( $total_quantity, 2 ); ?></strong>
                </td>
                <td><strong><?php echo number_format ( $total, 2 ); ?></strong></td>
                <td></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</body>
</html>