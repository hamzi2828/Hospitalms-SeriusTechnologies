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
                <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?><br />
            </span>
            <span style="font-size: 8pt;">
                <strong>Search Criteria:</strong>
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?>
                <?php echo !empty( @$_REQUEST[ 'start_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'start_time' ] ) ) : '' ?> @
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
                <?php echo !empty( @$_REQUEST[ 'end_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'end_time' ] ) ) : '' ?>
            </span>
        </td>
    </tr>
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Pharmacy General Report (IPD Med) </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
        <th> Sold By</th>
        <th> Medicine</th>
        <th> Batch</th>
        <th> Sold Qty</th>
        <th> Price</th>
        <th> Net Price</th>
        <th> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        if ( count ( $reports ) > 0 ) {
            $count         = 1;
            $total         = 0;
            $net           = 0;
            $flat_discount = 0;
            foreach ( $reports as $report ) {
                $medicine   = explode ( ',', $report -> medicine_id );
                $stock      = explode ( ',', $report -> stock_id );
                $quantities = explode ( ',', $report -> quantity );
                $prices     = explode ( ',', $report -> price );
                $total      = $total + $report -> net_price;
                $user       = get_user ( $report -> user_id );
                ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $report -> sale_id; ?></td>
                    <td><?php echo $report -> patient_id; ?></td>
                    <td><?php echo $user -> name; ?></td>
                    <td>
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
                    <td>
                        <?php
                            foreach ( $stock as $id ) {
                                $sto = get_stock ( $id );
                                echo @$sto -> batch . '<br>';
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            foreach ( $quantities as $quantity ) {
                                echo $quantity . '<br>';
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            foreach ( $prices as $price ) {
                                echo $price . '<br>';
                            }
                        ?>
                    </td>
                    <td><?php echo number_format ( $report -> net_price, 2 ); ?></td>
                    <td><?php echo date_setter ( $report -> date_added ); ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="7" class="text-right"></td>
                <td class="text-right">
                    <strong>Total:</strong>
                </td>
                <td class="text-left">
                    <?php echo number_format ( $total, 2 ) ?>
                </td>
                <td class="text-right"></td>
            </tr>
            <?php
        }
        else {
            ?>
            <tr>
                <td colspan="10">
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