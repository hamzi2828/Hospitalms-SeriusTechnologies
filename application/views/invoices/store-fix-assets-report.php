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

<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Store Fix Assets Report </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Account Head</th>
        <th> Code</th>
        <th> Fix Asset Item</th>
        <th> Location</th>
        <th> Purchase Date</th>
        <th> Price</th>
        <th> Depreciation (%)</th>
        <th> Depreciation Charge</th>
        <?php
            if ( count ( $filters ) > 0 ) {
                for ( $year = $filters[ 'start_year' ]; $year <= $filters[ 'end_year' ]; $year++ ) {
                    if ( $year > 0 ) {
                        ?>
                        <th>
                            As of
                            <?php echo date ( 'M', strtotime ( $this -> input -> get ( 'end-date' ) ) ) . ' ' . $year ?>
                        </th>
                        <?php
                    }
                }
            }
            
            if ( !empty( $this -> input -> get ( 'end-date' ) ) ) {
                ?>
                <th>Total Accumulative Depreciation</th>
                <th>
                    WDV
                    <?php echo date ( 'M', strtotime ( $this -> input -> get ( 'end-date' ) ) ) . ' ' . $filters[ 'end_year' ] ?>
                </th>
                <?php
            }
        
        ?>
        <th> Disposed Date</th>
        <th> Disposed Value</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter         = 1;
        $netValue        = 0;
        $netWDVValue     = 0;
        $netAccumulative = 0;
        $yearsTotal      = array ();
        
        if ( count ( $reports ) > 0 ) {
            foreach ( $reports as $report ) {
                $last_depreciation      = 0;
                $depSum                 = 0;
                $disposed               = get_store_disposed_asset ( $report -> store_id );
                $total_accumulative_dep = 0;
//                                $total_accumulative_dep = calculate_total_accumulative_depreciation ( $report -> purchase_date, $report -> value, $report -> depreciation, $report -> depreciation_charge );
                $netValue += $report -> value;
                $acc_head = get_account_head ( $report -> account_head_id );
                $wdv      = 0;
                ?>
                <tr class="odd gradeX">
                    <td> <?php echo $counter++ ?> </td>
                    <td><?php echo $acc_head -> title ?></td>
                    <td><?php echo $report -> code ?></td>
                    <td><?php echo $report -> item ?></td>
                    <td><?php echo $report -> location ?></td>
                    <td><?php echo date_setter_without_time ( $report -> purchase_date ) ?></td>
                    <td><?php echo number_format ( $report -> value, 2 ) ?></td>
                    <td><?php echo number_format ( $report -> depreciation, 2 ) ?></td>
                    <td><?php echo string_to_title ( $report -> depreciation_charge ) ?></td>
                    <?php
                        $value = $report -> value;
                        if ( count ( $filters ) > 0 ) {
                            for ( $year = $filters[ 'start_year' ]; $year <= $filters[ 'end_year' ]; $year++ ) {
                                if ( $year > 0 ) {
                                    $depreciation           = calculate_depreciation_value ( $report -> purchase_date, $value, $report -> depreciation, $report -> depreciation_charge, $year, $depSum );
                                    $depSum                 += $depreciation;
                                    $value                  -= $depreciation;
                                    $total_accumulative_dep += $depreciation;
                                    ?>
                                    <td>
                                        <?php
                                            $last_depreciation += $depreciation;
                                            
                                            if ( isset( $yearsTotal[ $year ] ) )
                                                $yearsTotal[ $year ] += $depreciation;
                                            else
                                                $yearsTotal[ $year ] = $depreciation;
                                            
                                            echo $depreciation > 0 ? number_format ( $depreciation, 2 ) : '-';
                                        ?>
                                    </td>
                                    <?php
                                }
                            }
                            $wdv = $report -> value - $total_accumulative_dep;
                            $wdv = max ( $wdv, 0 );
                            ?>
                            <td><?php echo number_format ( $total_accumulative_dep, 2 ) ?></td>
                            <td><?php echo number_format ( ( $wdv ), 2 ) ?></td>
                            <?php
                        }
                        $netAccumulative += $total_accumulative_dep;
                    ?>
                    <td>
                        <?php echo !empty( $disposed ) ? date_setter_without_time ( $disposed -> dispose_date ) : '-' ?>
                    </td>
                    <td>
                        <?php echo !empty( $disposed ) ? number_format ( $disposed -> value, 2 ) : '-' ?>
                    </td>
                </tr>
                <?php
                $netWDVValue += $wdv;
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="6"></td>
        <td>
            <strong><?php echo number_format ( $netValue, 2 ) ?></strong>
        </td>
        <td colspan="2"></td>
        <?php
            if ( count ( $filters ) > 0 ) {
                for ( $year = $filters[ 'start_year' ]; $year <= $filters[ 'end_year' ]; $year++ ) {
                    if ( $year > 0 ) {
                        ?>
                        <td>
                            <strong>
                                <?php echo number_format ( $yearsTotal[ $year ], 2 ) ?></strong>
                        </td>
                        <?php
                    }
                }
                ?>
                <td>
                    <strong><?php echo number_format ( $netAccumulative, 2 ) ?></strong>
                </td>
                <td>
                    <strong><?php echo number_format ( $netWDVValue, 2 ) ?></strong>
                </td>
                <?php
            }
        ?>
    </tr>
    </tfoot>
</table>

</body>
</html>