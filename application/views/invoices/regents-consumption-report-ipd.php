<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            sheet-size: A4;
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
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Regents Consumption Report (IPD) </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Test</th>
        <th> No. of Times Performed</th>
        <th> No. of Times Calibrated</th>
        <th> Regents/Items <br /> (Standard Values)</th>
        <th> Usability Against Sale</th>
        <th> Usability Against Calibrations</th>
        <th> Total Usage</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        $used    = 0;
        if ( count ( $regent_consumption ) > 0 ) {
            foreach ( $regent_consumption as $consumption ) {
                $sale_id      = $consumption -> sale_id;
                $calibrations = get_regent_calibrations ( $consumption -> test_id );
                ?>
                <tr>
                    <td><?php echo $counter++; ?></td>
                    <td>
                        <?php
                            $testInfo = get_test_by_id ( $consumption -> test_id );
                            echo $testInfo -> name;
                        ?>
                    </td>
                    <td>
                        <?php
                            $results      = get_ipd_regent_test_results ( $consumption -> test_id );
                            $totalRegents = 0;
                            if ( count ( $results ) > 0 ) {
                                foreach ( $results as $result ) {
                                    $totalRegents += $result -> regents;
                                }
                            }
                            echo $totalRegents;
                        ?>
                    </td>
                    <td>
                        <?php echo $calibrations ?>
                    </td>
                    <td>
                        <?php
                            $regents = get_test_regents ( $consumption -> test_id );
                            if ( count ( $regents ) > 0 ) {
                                foreach ( $regents as $regent ) {
                                    $store = get_store_by_id ( $regent -> regent_id );
                                    echo '<b>' . $store -> item . '</b> = ' . $regent -> usable_quantity . '<br/>';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            $regents = get_test_regents ( $consumption -> test_id );
                            if ( count ( $regents ) > 0 ) {
                                foreach ( $regents as $regent ) {
                                    $store = get_store_by_id ( $regent -> regent_id );
                                    echo '<b>' . $store -> item . '</b> = ' . $regent -> usable_quantity * $totalRegents . '<br/>';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            $regents = get_test_regents ( $consumption -> test_id );
                            if ( count ( $regents ) > 0 ) {
                                foreach ( $regents as $regent ) {
                                    $store = get_store_by_id ( $regent -> regent_id );
                                    echo '<b>' . $store -> item . '</b> = ' . $regent -> usable_quantity * $calibrations . '<br/>';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            $regents = get_test_regents ( $consumption -> test_id );
                            if ( count ( $regents ) > 0 ) {
                                foreach ( $regents as $regent ) {
                                    $store = get_store_by_id ( $regent -> regent_id );
                                    $val1  = $regent -> usable_quantity * $calibrations;
                                    $val2  = $regent -> usable_quantity * $totalRegents;
                                    $total = $val1 + $val2;
                                    echo '<b>' . $store -> item . '</b> = ' . $total . '<br/>';
                                }
                            }
                        ?>
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