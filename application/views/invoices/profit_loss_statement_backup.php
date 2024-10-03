<?php
    header ( 'Content-Type: application/pdf' ); ?>
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
    <table width="100%">
        <tr>
            <td width="50%" style="color:#0000BB; ">
                <img src="<?php
    echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" height="120px"><br><br/><br/>
            </td>
            <td width="50%" style="text-align: right;">
                <span style="font-size: 8pt;"><?php
    echo hospital_address ?></span><br/>
                <span style="font-family:dejavusanscondensed; font-size: 8pt; display: none;">&#9742;</span>
                <span style="font-size: 8pt;"><?php
    echo hospital_phone ?></span> <br/><br/>
                <span style="font-size: 8pt;">
                    <strong>Date & Time:</strong> <?php
    echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?><br/>
                </span>
                <span style="font-size: 8pt;">
                    <strong>Search Criteria:</strong>
                    <?php
    echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?> @
                    <?php
    echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
                </span>
            </td>
        </tr>
    </table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
    <div style="width:100%; display:block; text-align:right"><small><b><?php
    echo @$user -> name ?><br></small></div>
    <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
        Page {PAGENO} of {nb}
    </div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" page="all" value="on"/>
mpdf-->
<br/>
<div style="text-align: right">
    <strong>Search Criteria:</strong>
    <?php
        echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?>
    <?php
        echo !empty( @$_REQUEST[ 'start_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'start_time' ] ) ) : '' ?>
    @
    <?php
        echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
    <?php
        echo !empty( @$_REQUEST[ 'end_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'end_time' ] ) ) : '' ?>
</div>
<br/>
<br/>
<br/>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Profit Loss Statement </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th align="left"> Account Head</th>
        <th></th>
    </tr>
    </thead>
    <thead>
    <tr>
        <th> Account Head</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter     = 1;
        $sales_debit = 0;
        if ( count ( $sales_account_head ) > 0 ) {
            foreach ( $sales_account_head as $sale_account_head ) {
                $childAccHeads = get_child_account_heads_data ( $sale_account_head -> id );
                $acc_head_id   = $sale_account_head -> id;
                $transaction   = calculate_acc_head_transaction ( $acc_head_id );
                $sales_debit   = $sales_debit + $transaction -> debit;
                ?>
                <tr>
                    <td>
                        <?php
                            echo $sale_account_head -> title;
                            if ( $sale_account_head -> role_id > 0 ) {
                                $role = get_account_head_role ( $sale_account_head -> role_id );
                                if ( !empty( $role ) )
                                    echo '(' . get_account_head_role ( $sale_account_head -> role_id ) -> name . ')';
                            }
                        ?>
                    </td>
                    <td><?php
                            echo number_format ( abs ( - $transaction -> credit + $transaction -> debit ), 2 ) ?></td>
                </tr>
                <?php
                if ( count ( $childAccHeads ) > 0 ) {
                    foreach ( $childAccHeads as $childAccHead ) {
                        $acc_head_id        = $childAccHead -> id;
                        $transaction        = calculate_acc_head_transaction ( $acc_head_id );
                        $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                        $sub_transaction    = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                        $sales_debit        = $sales_debit + $transaction -> debit;
                        if ( $sub_transaction )
                            $sales_debit = $sales_debit + $sub_transaction -> debit;
                        ?>
                        <tr>
                            <td style="padding-left: 40px">
                                <?php
                                    echo $childAccHead -> title;
                                    if ( $childAccHead -> role_id > 0 ) {
                                        $role = get_account_head_role ( $childAccHead -> role_id );
                                        if ( !empty( $role ) )
                                            echo ' (' . get_account_head_role ( $childAccHead -> role_id ) -> name . ')';
                                    }
                                ?>
                            </td>
                            <td><?php
                                    echo number_format ( abs ( ( - $transaction -> credit + $transaction -> debit ) + ( - @$sub_transaction -> credit + @$sub_transaction -> debit ) ), 2 ) ?></td>
                        </tr>
                        <?php
                    }
                }
            }
        }
    ?>
    <tr>
        <td align="right"><strong>Total:</strong></td>
        <td align="left"><strong><?php
                    echo number_format ( abs ( $sales_debit ), 2 ) ?></strong></td>
    </tr>
    <tr>
        <td>
            <?php
                $allowances_credit = 0;
                echo $returns_allowances_account_head -> title;
                $acc_head_id       = $returns_allowances_account_head -> id;
                $transaction       = calculate_acc_head_transaction ( $acc_head_id );
                $allowances_credit = $allowances_credit + $transaction -> debit;
                if ( $returns_allowances_account_head -> role_id > 0 ) {
                    $role = get_account_head_role ( $returns_allowances_account_head -> role_id );
                    if ( !empty( $role ) )
                        echo ' (' . get_account_head_role ( $returns_allowances_account_head -> role_id ) -> name . ')';
                }
            ?>
        </td>
        <td><?php
                echo number_format ( abs ( - $transaction -> credit + $transaction -> debit ), 2 ) ?></td>
    </tr>
    <?php
        $fee_discounts_credit = 0;
        if ( count ( $fee_discounts_account_head ) > 0 ) {
            foreach ( $fee_discounts_account_head as $fee_discount_account_head ) {
                $childAccHeads        = get_child_account_heads_data ( $fee_discount_account_head -> id );
                $acc_head_id          = $fee_discount_account_head -> id;
                $transaction          = calculate_acc_head_transaction ( $acc_head_id );
                $fee_discounts_credit = $fee_discounts_credit + $transaction -> credit;
                ?>
                <tr>
                    <td>
                        <?php
                            echo $fee_discount_account_head -> title;
                            if ( $fee_discount_account_head -> role_id > 0 ) {
                                $role = get_account_head_role ( $fee_discount_account_head -> role_id );
                                if ( !empty( $role ) )
                                    echo '(' . get_account_head_role ( $fee_discount_account_head -> role_id ) -> name . ')';
                            }
                        ?>
                    </td>
                    <td><?php
                            echo number_format ( abs ( - $transaction -> credit + $transaction -> debit ), 2 ) ?></td>
                </tr>
                <?php
                if ( count ( $childAccHeads ) > 0 ) {
                    foreach ( $childAccHeads as $childAccHead ) {
                        $acc_head_id          = $childAccHead -> id;
                        $transaction          = calculate_acc_head_transaction ( $acc_head_id );
                        $fee_discounts_credit = $fee_discounts_credit + $transaction -> credit;
                        $subChildAccHeadIds   = get_sub_child_account_head_ids ( $acc_head_id );
                        $sub_transaction      = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                        if ( $sub_transaction )
                            $fee_discounts_credit = $fee_discounts_credit + $sub_transaction -> credit;
                        
                        ?>
                        <tr>
                            <td style="padding-left: 40px">
                                <?php
                                    echo $childAccHead -> title;
                                    if ( $childAccHead -> role_id > 0 ) {
                                        $role = get_account_head_role ( $childAccHead -> role_id );
                                        if ( !empty( $role ) )
                                            echo ' (' . get_account_head_role ( $childAccHead -> role_id ) -> name . ')';
                                    }
                                ?>
                            </td>
                            <td><?php
                                    echo number_format ( abs ( ( - $transaction -> credit + $transaction -> debit ) + ( - @$sub_transaction -> credit + @$sub_transaction -> debit ) ), 2 ) ?></td>
                        </tr>
                        <?php
                    }
                }
            }
        }
    ?>
    <tr>
        <td align="right"><strong>Total:</strong></td>
        <td align="left"><strong><?php
                    echo number_format ( abs ( $fee_discounts_credit ), 2 ) ?></strong>
        </td>
    </tr>
    <tr>
        <td>
            <strong>Sales - Net</strong>
        </td>
        <td>
            <strong>
                <?php
                    $sales_net = $sales_debit - $allowances_credit - $fee_discounts_credit;
                    echo @number_format ( abs ( $sales_net ), 2 ) ?>
            </strong>
        </td>
    </tr>
    <?php
        $direct_cost_credit = 0;
        if ( count ( $Direct_Costs_account_head ) > 0 ) {
            foreach ( $Direct_Costs_account_head as $Direct_Cost_account_head ) {
                $childAccHeads      = get_child_account_heads_data ( $Direct_Cost_account_head -> id );
                $acc_head_id        = $Direct_Cost_account_head -> id;
                $transaction        = calculate_acc_head_transaction ( $acc_head_id );
                $direct_cost_credit = $direct_cost_credit + $transaction -> credit;
                ?>
                <tr>
                    <td>
                        <?php
                            echo $Direct_Cost_account_head -> title;
                            if ( $Direct_Cost_account_head -> role_id > 0 ) {
                                $role = get_account_head_role ( $Direct_Cost_account_head -> role_id );
                                if ( !empty( $role ) )
                                    echo '(' . get_account_head_role ( $Direct_Cost_account_head -> role_id ) -> name . ')';
                            }
                        ?>
                    </td>
                    <td><?php
                            echo number_format ( abs ( - $transaction -> credit + $transaction -> debit ), 2 ) ?></td>
                </tr>
                <?php
                if ( count ( $childAccHeads ) > 0 ) {
                    foreach ( $childAccHeads as $childAccHead ) {
                        $subChildAccHeads   = get_child_account_heads_data ( $childAccHead -> id );
                        $acc_head_id        = $childAccHead -> id;
                        $transaction        = calculate_acc_head_transaction ( $acc_head_id );
                        $direct_cost_credit = $direct_cost_credit + $transaction -> credit;
//									$subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
//									$sub_transaction = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
//									if ( $sub_transaction )
//										$direct_cost_credit = $direct_cost_credit + $sub_transaction -> credit;
                        
                        ?>
                        <tr>
                            <td style="padding-left: 40px">
                                <?php
                                    echo $childAccHead -> title;
                                    if ( $childAccHead -> role_id > 0 ) {
                                        $role = get_account_head_role ( $childAccHead -> role_id );
                                        if ( !empty( $role ) )
                                            echo ' (' . get_account_head_role ( $childAccHead -> role_id ) -> name . ')';
                                    }
                                ?>
                            </td>
                            <td><?php
                                    echo number_format ( abs ( ( - $transaction -> credit + $transaction -> debit ) ), 2 ) ?></td>
                        </tr>
                        <?php
                        if ( count ( $subChildAccHeads ) > 0 ) {
                            foreach ( $subChildAccHeads as $subChildAccHead ) {
                                $acc_head_id        = $subChildAccHead -> id;
                                $transaction        = calculate_acc_head_transaction ( $acc_head_id );
                                $direct_cost_credit = $direct_cost_credit + $transaction -> credit;
                                
                                $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                                $sub_transaction    = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                                if ( $sub_transaction )
                                    $direct_cost_credit = $direct_cost_credit + $sub_transaction -> credit;
                                
                                ?>
                                <tr>
                                    <td style="padding-left: 80px">
                                        <?php
                                            echo $subChildAccHead -> title;
                                            if ( $subChildAccHead -> role_id > 0 ) {
                                                $role = get_account_head_role ( $subChildAccHead -> role_id );
                                                if ( !empty( $role ) )
                                                    echo ' (' . get_account_head_role ( $subChildAccHead -> role_id ) -> name . ')';
                                            }
                                        ?>
                                    </td>
                                    <td><?php
                                            echo number_format ( abs ( ( - $transaction -> credit + $transaction -> debit ) + ( - @$sub_transaction -> credit + @$sub_transaction -> debit ) ), 2 ) ?></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                }
            }
        }
    ?>
    <tr>
        <td align="right"><strong>Total:</strong></td>
        <td align="left"><strong><?php
                    echo number_format ( abs ( $direct_cost_credit ), 2 ) ?></strong>
        </td>
    </tr>
    <tr>
        <td>
            <strong>Gross Profit / (Loss)</strong>
        </td>
        <td>
            <strong>
                <?php
                    $direct_cost_net = $sales_net - $direct_cost_credit;
                    echo @number_format ( abs ( ( $direct_cost_net ) ), 2 );
                ?>
            </strong>
        </td>
    </tr>
    <?php
        $expense_account_credit = 0;
        if ( count ( $expenses_account_head ) > 0 ) {
            foreach ( $expenses_account_head as $expense_account_head ) {
                $childAccHeads          = get_child_account_heads_data ( $expense_account_head -> id );
                $acc_head_id            = $expense_account_head -> id;
                $transaction            = calculate_acc_head_transaction ( $acc_head_id );
                $expense_account_credit = $expense_account_credit + $transaction -> debit;
                ?>
                <tr>
                    <td>
                        <?php
                            echo $expense_account_head -> title;
                            if ( $expense_account_head -> role_id > 0 ) {
                                $role = get_account_head_role ( $expense_account_head -> role_id );
                                if ( !empty( $role ) )
                                    echo '(' . get_account_head_role ( $expense_account_head -> role_id ) -> name . ')';
                            }
                        ?>
                    </td>
                    <td><?php
                            echo number_format ( abs ( - $transaction -> credit + $transaction -> debit ), 2 ) ?></td>
                </tr>
                <?php
                if ( count ( $childAccHeads ) > 0 ) {
                    foreach ( $childAccHeads as $childAccHead ) {
                        $subChildAccHeads       = get_child_account_heads_data ( $childAccHead -> id );
                        $childAccHeads          = get_child_account_heads_data ( $expense_account_head -> id );
                        $acc_head_id            = $childAccHead -> id;
                        $transaction            = calculate_acc_head_transaction ( $acc_head_id );
                        $expense_account_credit = $expense_account_credit + $transaction -> credit;
                        $subChildAccHeadIds     = get_sub_child_account_head_ids ( $acc_head_id );
                        $sub_transaction        = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                        
                        if ( !empty( $sub_transaction ) ) {
                            $expense_account_credit = $expense_account_credit + $sub_transaction -> credit;
                        }
                        
                        ?>
                        <tr>
                            <td style="padding-left: 40px">
                                <?php
                                    echo $childAccHead -> title;
                                    if ( $childAccHead -> role_id > 0 ) {
                                        $role = get_account_head_role ( $childAccHead -> role_id );
                                        if ( !empty( $role ) )
                                            echo ' (' . get_account_head_role ( $childAccHead -> role_id ) -> name . ')';
                                    }
                                ?>
                            </td>
                            <td><?php
                                    echo number_format ( abs ( ( - $transaction -> credit + $transaction -> debit ) + ( - @$sub_transaction -> credit + @$sub_transaction -> debit ) ), 2 ) ?></td>
                        </tr>
                        <?php
                    }
                }
            }
        }
    ?>
    <tr>
        <td align="right"><strong>Total:</strong></td>
        <td align="left"><strong><?php
                    echo number_format ( abs ( $expense_account_credit ), 2 ) ?></strong>
        </td>
    </tr>
    <tr>
        <td>
            <?php
                $finance_cost_debit = 0;
                $acc_head_id        = $Finance_Cost_account_head -> id;
                $transaction        = calculate_acc_head_transaction ( $acc_head_id );
                $finance_cost_debit = $finance_cost_debit + $transaction -> credit;
                echo $Finance_Cost_account_head -> title;
                if ( $Finance_Cost_account_head -> role_id > 0 ) {
                    $role = get_account_head_role ( $Finance_Cost_account_head -> role_id );
                    if ( !empty( $role ) )
                        echo ' (' . get_account_head_role ( $Finance_Cost_account_head -> role_id ) -> name . ')';
                }
            ?>
        </td>
        <td><?php
                echo number_format ( abs ( - $transaction -> credit + $transaction -> debit ), 2 ) ?></td>
    </tr>
    <tr>
        <td>
            <strong>Net Profit / (Loss) before tax</strong>
        </td>
        <td>
            <strong>
                <?php
                    $net_revenue_before_tax = $direct_cost_net - $expense_account_credit - $finance_cost_debit;
                    echo @number_format ( abs ( $net_revenue_before_tax ), 2 );
                ?>
            </strong>
        </td>
    </tr>
    <tr>
        <td>
            <?php
                $tax_debit   = 0;
                $acc_head_id = $Tax_account_head -> id;
                $transaction = calculate_acc_head_transaction ( $acc_head_id );
                $tax_debit   = $tax_debit + $transaction -> debit;
                echo $Tax_account_head -> title;
                if ( $Tax_account_head -> role_id > 0 ) {
                    $role = get_account_head_role ( $Tax_account_head -> role_id );
                    if ( !empty( $role ) )
                        echo ' (' . get_account_head_role ( $Tax_account_head -> role_id ) -> name . ')';
                }
            ?>
        </td>
        <td><?php
                echo number_format ( abs ( $transaction -> debit ), 2 ) ?></td>
    </tr>
    <tr>
        <td>
            <strong>Net Profit / (Loss) after tax</strong>
        </td>
        <td>
            <strong>
                <?php
                    $net_revenue_before_tax = $net_revenue_before_tax - $tax_debit;
                    echo @number_format ( abs ( $net_revenue_before_tax ), 2 );
                ?>
            </strong>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
