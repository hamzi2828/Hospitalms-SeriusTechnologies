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
    <span style="font-weight: bold; font-size: 25pt;"><?php echo $tests[ 0 ] -> sale_id ?></span><br>
    <strong><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>: </strong> <?php echo $tests[ 0 ] -> patient_id ?>
    <br>
    <strong><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?>:
    </strong> <?php echo @get_patient ( $tests[ 0 ] -> patient_id ) -> name ?> <br>
    <strong>Admission No: </strong> <?php echo $tests[ 0 ] -> sale_id ?> <br>
    <strong>Date & Time: </strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> IPD Lab Test </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> Code</th>
        <th align="left"> Test</th>
        <th align="left"> Test Type</th>
        <th align="left"> Price</th>
        <th align="left"> Discount</th>
        <th align="left"> Net Price</th>
        <th align="left"> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter   = 1;
        $price     = 0;
        $net_price = 0;
        if ( count ( $tests ) > 0 ) {
            foreach ( $tests as $test ) {
                $price       = $price + $test -> price;
                $net_price   = $net_price + $test -> net_price;
                $testInfo    = get_test_by_id ( $test -> test_id );
                $isTestChild = check_if_test_is_child ( $test -> test_id );
                if ( !$isTestChild ) {
                    ?>
                    <tr>
                        <td> <?php echo $counter++; ?> </td>
                        <td align="left"> <?php echo $testInfo -> code; ?> </td>
                        <td align="left"> <?php echo $testInfo -> name; ?> </td>
                        <td align="left"> <?php echo ucfirst ( $testInfo -> type ); ?> </td>
                        <td align="left"> <?php echo number_format ( $test -> price, 2 ) ?> </td>
                        <td align="left"> <?php echo number_format ( $test -> discount, 2 ) ?> </td>
                        <td align="left"> <?php echo number_format ( $test -> net_price, 2 ) ?> </td>
                        <td align="left"> <?php echo date_setter ( $test -> date_added ) ?> </td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td colspan="5" align="right">
                    <strong> <?php echo number_format ( $price, 2 ) ?> </strong>
                </td>
                <td align="right"></td>
                <td>
                    <strong> <?php echo number_format ( $net_price, 2 ) ?> </strong>
                </td>
                <td align="right"></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</body>
</html>