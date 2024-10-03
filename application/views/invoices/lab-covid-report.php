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
<table width="100%">
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 8pt;">
                <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?><br />
            </span>
            <span style="font-size: 8pt;">
                <strong>Search Criteria:</strong>
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?> @
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
            </span>
        </td>
    </tr>
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Lab General Report (COVID-19) </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> Airline</th>
        <th align="left"> Tests</th>
        <th> Rates</th>
        <th> Passenger</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        $p_total = 0;
        if ( count ( $reports ) > 0 ) {
            foreach ( $reports as $report ) {
                $p_total     = $p_total + $report -> price;
                $tests       = explode ( ',', $report -> tests );
                $airlineInfo = get_airlines_by_id ( $report -> airline_id );
                ?>
                <tr>
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td align="left"> <?php echo $airlineInfo -> title ?> </td>
                    <td align="left">
                        <?php
                            if ( count ( $tests ) > 0 ) {
                                foreach ( $tests as $test ) {
                                    if ( $test > 0 ) {
                                        if ( !check_if_test_is_child ( $test ) )
                                            echo get_test_by_id ( $test ) -> name . '<br>';
                                    }
                                }
                            } ?>
                    </td>
                    <td align="center"> <?php echo number_format ( $report -> price, 2 ) ?> </td>
                    <td align="center"> <?php echo $report -> patients ?> </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="3" align="right"><b>Total</b></td>
                <td align="center"><?php echo number_format ( $p_total, 2 ) ?></td>
                <td></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</body>
</html>