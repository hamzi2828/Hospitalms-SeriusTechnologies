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

<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" page="all" value="on"/>
mpdf-->
<br />
<table width="100%">
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 8pt;">
                <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?><br />
            </span>
        </td>
    </tr>
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Balance Sheet </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Account Head</th>
        <th> Closing Balance</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <h3 style="font-size: 18px; font-weight: 800 !important;">
                <strong>Total Assets</strong>
            </h3>
        </td>
        <td style="padding-left: 25px">
            <h3 style="font-size: 18px; font-weight: 800 !important;">
                <strong>
                    <?php
                        $C = ( ( $cash_balances[ 'net_closing' ] ) + $banks[ 'net_closing' ] + $receivable_accounts[ 'net_closing' ] + $inventory[ 'net_closing' ] ) + ( ( $furniture_fixture[ 'net_closing' ] + $intangible_assets[ 'net_closing' ] + $bio_medical_surgical_items[ 'net_closing' ] + $machinery_equipment[ 'net_closing' ] + $electrical_equipment[ 'net_closing' ] + $it_equipment[ 'net_closing' ] + $office_equipment[ 'net_closing' ] + $land_building[ 'net_closing' ] ) - $accumulated_depreciation[ 'net_closing' ] );
                        echo number_format ( abs ( $C ), 2 );
                    ?>
                </strong>
            </h3>
        </td>
    </tr>
    <tr>
        <td>
            <strong>Current Assets:</strong>
        </td>
        <td></td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $cash_balances[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $cash_balances[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $banks[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $banks[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $receivable_accounts[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $receivable_accounts[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $inventory[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $inventory[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <strong>Total:</strong>
        </td>
        <td style="padding-left: 25px">
            <strong><?php echo $A = number_format ( $cash_balances[ 'net_closing' ] + $banks[ 'net_closing' ] + $receivable_accounts[ 'net_closing' ] + $inventory[ 'net_closing' ], 2 ) ?></strong>
        </td>
    </tr>
    <tr>
        <td>
            <strong>
                Non-Current assets:
            </strong>
        </td>
        <td></td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $furniture_fixture[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $furniture_fixture[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $intangible_assets[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $intangible_assets[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $bio_medical_surgical_items[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $bio_medical_surgical_items[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $machinery_equipment[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $machinery_equipment[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $electrical_equipment[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $electrical_equipment[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $it_equipment[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $it_equipment[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $office_equipment[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $office_equipment[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $land_building[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $land_building[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <strong>
                Total:
            </strong>
        </td>
        <td style="padding-left: 25px">
            <strong>
                <?php
                    $B = $furniture_fixture[ 'net_closing' ] + $intangible_assets[ 'net_closing' ] + $bio_medical_surgical_items[ 'net_closing' ] + $machinery_equipment[ 'net_closing' ] + $electrical_equipment[ 'net_closing' ] + $it_equipment[ 'net_closing' ] + $office_equipment[ 'net_closing' ] + $land_building[ 'net_closing' ];
                    echo number_format ( abs ( $B ), 2 );
                ?>
            </strong>
        </td>
    </tr>
    <tr>
        <td>Total Accumulated Depreciation</td>
        <td style="padding-left: 25px">
            <strong>
                <?php
                    $TAD = $total_accumulative_depreciation;
                    echo number_format ( $TAD, 2 );
                ?>
            </strong>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo get_account_head ( $accumulated_depreciation[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php
                echo number_format ( abs ( $accumulated_depreciation[ 'net_closing' ] ), 2 );
                $U = $accumulated_depreciation[ 'net_closing' ];
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <strong style="color: #000000; font-weight: 800 !important; float: left">
                Net Non-Current Assets
            </strong>
            <strong style="color: #000000; font-weight: 800 !important; float: right"> Total: </strong>
        </td>
        <td style="padding-left: 25px">
            <strong style="margin-top: 5px; display: block;">
                <?php
                    $P = ( $B ) - ( $U ) - ( $TAD );
                    echo number_format ( @abs ( $P ), 2 );
                ?>
            </strong>
        </td>
    </tr>
    <tr>
        <td>
            <strong> Liabilities </strong>
        </td>
        <td style="padding-left: 25px">
            <strong>
                <?php
                    $F = ( $payable_accounts[ 'net_closing' ] + $accrued_expenses[ 'net_closing' ] + $unearned_revenue[ 'net_closing' ] + $WHT_payable[ 'net_closing' ] ) + ( $long_term_debt[ 'net_closing' ] + $other_long_term_liabilities[ 'net_closing' ] );
                    //                                    echo number_format ( abs ( $F ), 2 );
                ?>
            </strong>
        </td>
    </tr>
    <tr>
        <td>
            <strong> Current liabilities:</strong>
        </td>
        <td></td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $payable_accounts[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $payable_accounts[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $accrued_expenses[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $accrued_expenses[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $unearned_revenue[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $unearned_revenue[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ( $WHT_payable[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $WHT_payable[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <strong> Total: </strong>
        </td>
        <td style="padding-left: 25px">
            <strong>
                <?php echo $D = number_format ( abs ( $payable_accounts[ 'net_closing' ] + $accrued_expenses[ 'net_closing' ] + $unearned_revenue[ 'net_closing' ] + $WHT_payable[ 'net_closing' ] ), 2 ) ?>
            </strong>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo get_account_head ( $long_term_debt[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $long_term_debt[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo get_account_head ( $other_long_term_liabilities[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format ( abs ( $other_long_term_liabilities[ 'net_closing' ] ), 2 ) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <strong> Total: </strong>
        </td>
        <td style="padding-left: 25px">
            <strong>
                <?php echo $E = number_format ( abs ( $long_term_debt[ 'net_closing' ] + $other_long_term_liabilities[ 'net_closing' ] ), 2 ) ?>
            </strong>
        </td>
    </tr>
    <tr>
        <td>
            <strong> Shareholder's Equity</strong>
        </td>
        <td>
            <h3 style="font-size: 18px; font-weight: 800 !important;"></h3>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo get_account_head ( $capital[ 'account_head_id' ] ) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php
                $G = $capital[ 'net_closing' ];
                echo number_format ( abs ( $G ), 2 )
            ?>
        </td>
    </tr>
    <tr>
        <td>Net Profit</td>
        <td style="padding-left: 25px">
            <?php
                $H = $calculate_net_profit;
                echo number_format ( abs ( $H ), 2 )
            ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <strong> Total: </strong>
        </td>
        <td style="padding-left: 25px">
            <strong>
                <?php echo $I = number_format ( ( $G + $H ), 2 ) ?>
            </strong>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
