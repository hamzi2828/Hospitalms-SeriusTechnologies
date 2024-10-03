<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            size   : auto;
            header : myheader;
            footer : myfooter;
        }
        
        body {
            font-family : sans-serif;
            font-size   : 10pt;
        }
        
        p {
            margin : 0pt;
        }
        
        table.items {
            border : 0.1mm solid #000000;
        }
        
        td {
            vertical-align : top;
        }
        
        .items td {
            border-left  : 0.1mm solid #000000;
            border-right : 0.1mm solid #000000;
        }
        
        table thead td {
            background-color : #EEEEEE;
            text-align       : center;
            border           : 0.1mm solid #000000;
            font-variant     : small-caps;
        }
        
        .items td.blanktotal {
            background-color : #EEEEEE;
            border           : 0.1mm solid #000000;
            background-color : #FFFFFF;
            border           : 0mm none #000000;
            border-top       : 0.1mm solid #000000;
            border-right     : 0.1mm solid #000000;
        }
        
        .items td.totals {
            text-align  : right;
            border      : 0.1mm solid #000000;
            font-weight : 800 !important;
        }
        
        .items td.cost {
            text-align : center;
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
            <h3 style="color: #000000; font-weight: 800 !important;"><strong>Current Assets:</strong></h3>
        </td>
        <td></td>
    </tr>
    <?php
        $netCurrentAssets = 0;
        if ( count ( $currentAssets ) > 0 ) {
            foreach ( $currentAssets as $currentAsset ) {
                $balance_sheet    = filter_balance_sheet ( $currentAsset -> id );
                $netCurrentAssets += $balance_sheet[ 'net_closing' ];
                ?>
                <tr>
                    <td style="padding-left: 25px">
                        <?php echo $currentAsset -> title ?>
                    </td>
                    <td style="padding-left: 25px">
                        <?php echo number_format ( $balance_sheet[ 'net_closing' ], 2 ) ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    
    <tr>
        <td align="right">
            <h3 style="color: #000000; font-weight: 800 !important;"><strong>Total:</strong></h3>
        </td>
        <td style="padding-left: 25px">
            <h3 style="color: #000000; font-weight: 800 !important;">
                <strong>
                    <?php
                        $A = $netCurrentAssets;
                        echo number_format ( $A, 2 );
                    ?>
                </strong>
            </h3>
        </td>
    </tr>
    <tr>
        <td>
            <h2 style="color: #000000; font-weight: 800 !important;"><strong>Non-Current assets:</strong></h2>
        </td>
        <td></td>
    </tr>
    <?php
        $netNonCurrentAssets = 0;
        if ( count ( $nonCurrentAssets ) > 0 ) {
            foreach ( $nonCurrentAssets as $nonCurrentAsset ) {
                $balance_sheet       = filter_balance_sheet ( $nonCurrentAsset -> id );
                $netNonCurrentAssets += $balance_sheet[ 'net_closing' ];
                ?>
                <tr>
                    <td style="padding-left: 25px">
                        <?php echo $nonCurrentAsset -> title ?>
                    </td>
                    <td style="padding-left: 25px">
                        <?php echo number_format ( $balance_sheet[ 'net_closing' ], 2 ) ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    <tr>
        <td align="right">
            <h3 style="color: #000000; font-weight: 800 !important;"><strong>Total:</strong></h3>
        </td>
        <td style="padding-left: 25px">
            <h3 style="color: #000000; font-weight: 800 !important;">
                <strong>
                    <?php
                        $B = $netNonCurrentAssets;
                        echo number_format ( abs ( $B ), 2 );
                    ?>
                </strong>
            </h3>
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
            <h2 style="color: #000000; font-weight: 800 !important; float: left"><strong>Net Non-Current Assets
                                                                                         Total:</strong></h2>
        </td>
        <td style="padding-left: 25px">
            <h3>
                <strong style="margin-top: 5px; display: block;">
                    <?php
                        $P = ( $B ) - ( $U ) - ( $TAD );
                        echo number_format ( @abs ( $P ), 2 );
                    ?>
                </strong>
            </h3>
        </td>
    </tr>
    <tr>
        <td>
            <h2 style="color: #000000; font-weight: 800 !important;">
                <strong>Current liabilities:</strong>
            </h2>
        </td>
        <td></td>
    </tr>
    <?php
        $netCurrentLiabilities = 0;
        if ( count ( $currentLiabilities ) > 0 ) {
            foreach ( $currentLiabilities as $currentLiability ) {
                $balance_sheet         = filter_balance_sheet ( $currentLiability -> id );
                $netCurrentLiabilities += $balance_sheet[ 'net_closing' ];
                ?>
                <tr>
                    <td style="padding-left: 25px">
                        <?php echo $currentLiability -> title ?>
                    </td>
                    <td style="padding-left: 25px">
                        <?php echo number_format ( $balance_sheet[ 'net_closing' ], 2 ) ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    <tr>
        <td align="right">
            <h3 style="color: #000000; font-weight: 800 !important;"><strong>Total:</strong></h3>
        </td>
        <td style="padding-left: 25px">
            <h2 style="color: #000000; font-weight: 800 !important;">
                <strong><?php echo $D = number_format ( abs ( $netCurrentLiabilities ), 2 ) ?></strong>
            </h2>
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
            <h3 style="color: #000000; font-weight: 800 !important;"><strong>Total:</strong></h3>
        </td>
        <td style="padding-left: 25px">
            <h3 style="color: #000000; font-weight: 800 !important;">
                <strong>
                    <?php echo $E = number_format ( abs ( $long_term_debt[ 'net_closing' ] + $other_long_term_liabilities[ 'net_closing' ] ), 2 ) ?>
                </strong>
            </h3>
        </td>
    </tr>
    <tr>
        <td>
            <h2 style="font-size: 18px; font-weight: 800 !important;">
                <strong>Shareholder's Equity</strong>
            </h2>
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
                $net_other_incomes = 0;
                if ( count ( $other_incomes ) > 0 ) {
                    foreach ( $other_incomes as $other_income ) {
                        $childAccHeads     = get_child_account_heads_data ( $other_income -> id );
                        $acc_head_id       = $other_income -> id;
                        $transaction       = calculate_acc_head_transaction ( $acc_head_id, true );
                        $net_other_incomes = abs ( $net_other_incomes + $transaction -> debit );
                        
                        if ( count ( $childAccHeads ) > 0 ) {
                            foreach ( $childAccHeads as $childAccHead ) {
                                $subChildAccHeads   = get_child_account_heads_data ( $childAccHead -> id );
                                $childAccHeads      = get_child_account_heads_data ( $other_income -> id );
                                $acc_head_id        = $childAccHead -> id;
                                $transaction        = calculate_acc_head_transaction ( $acc_head_id, true );
                                $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                                $sub_transaction    = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                                $subChildAccHeads   = get_child_account_heads_data ( $childAccHead -> id );
                                $sub_transaction    = abs ( ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) ) );
                                $net_other_incomes  += abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) );
                                
                                if ( count ( $subChildAccHeads ) > 0 ) {
                                    foreach ( $subChildAccHeads as $subChildAccHead ) {
                                        $acc_head_id        = $subChildAccHead -> id;
                                        $transaction        = calculate_acc_head_transaction ( $acc_head_id, true );
                                        $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                                        $sub_transaction    = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                                        
                                        $net_other_incomes += abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) );
                                    }
                                }
                            }
                        }
                    }
                }
                $H = ( $calculate_net_profit - $TAD ) + ( abs ( $net_other_incomes ) );
                echo number_format ( abs ( $H ), 2 )
            ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <h3 style="color: #000000; font-weight: 800 !important;"><strong> Total:</strong></h3>
        </td>
        <td style="padding-left: 25px">
            <h3 style="color: #000000; font-weight: 800 !important;">
                <strong><?php echo $I = number_format ( ( $G + $H ), 2 ) ?></strong>
            </h3>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
