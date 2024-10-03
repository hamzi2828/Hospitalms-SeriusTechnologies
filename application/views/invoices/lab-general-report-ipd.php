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

<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" page="all" value="on" />
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
            <h3><strong> Lab General Report IPD </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th> Test</th>
        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
        <th> Patient Type</th>
        <th> Price</th>
        <th> Discount(%)</th>
        <th> Net Price</th>
        <th> Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
        if ( count ( $reports ) > 0 ) {
            $counter = 1;
            $total   = 0;
            $p_total = 0;
            foreach ( $reports as $report ) {
                $patient   = get_patient ( $report -> patient_id );
                $total     = $total + $report -> price;
                $p_total   = $p_total + $report -> net_price;
                $tests     = explode ( ',', $report -> tests );
                $discounts = explode ( ',', $report -> discounts );
                ?>
                <tr>
                    <td> <?php echo $counter++ ?> </td>
                    <td> <?php echo $report -> sale_id ?> </td>
                    <td>
                        <?php
                            if ( count ( $tests ) > 0 ) {
                                foreach ( $tests as $test ) {
                                    echo get_test_by_id ( $test ) -> name . '<br>';
                                }
                            }
                        ?>
                    </td>
                    <td> <?php echo get_patient_name (0, $patient) ?> </td>
                    <td> <?php echo ucfirst ( $patient -> type ) ?> </td>
                    <td> <?php echo $report -> price ?> </td>
                    <td>
                        <?php
                            if ( count ( $discounts ) > 0 ) {
                                foreach ( $discounts as $discount ) {
                                    echo $discount . '<br>';
                                }
                            }
                        ?>
                    </td>
                    <td> <?php echo $report -> net_price ?> </td>
                    <td> <?php echo date_setter ( $report -> date_added ) ?> </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="5" class="text-right" align="right"><b>Total</b></td>
                <td><?php echo $p_total ?></td>
                <td class="text-right"><b>Net Total</b></td>
                <td><?php echo $total ?></td>
                <td></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</body>
</html>