<div class="row">
    <div class="col-md-12">
        <div class="search">
            <form method="get" autocomplete="off">
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="date date-picker form-control" placeholder="Start date"
                           required="required" value="<?php
                        echo ( @$_REQUEST[ 'start_date' ] ) ? @$_REQUEST[ 'start_date' ] : date ( 'm/d/Y' ) ?>">
                </div>
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="date date-picker form-control" placeholder="End date"
                           required="required" value="<?php
                        echo ( @$_REQUEST[ 'end_date' ] ) ? @$_REQUEST[ 'end_date' ] : date ( 'm/d/Y' ) ?>">
                </div>
                <div class="col-lg-2" style="padding-top: 25px">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Profit Loss Statement
                    <?php
                        $start_date = @$_REQUEST[ 'start_date' ];
                        $end_date = @$_REQUEST[ 'end_date' ];
                        if ( isset( $start_date ) and !empty( $start_date ) and isset( $end_date ) and !empty( $end_date ) ) {
                            ?>
                            (<small><?php
                                    echo date ( 'jS F Y', strtotime ( $start_date ) ) . ' to ' . date ( 'jS F Y', strtotime ( $end_date ) ) ?></small>)
                            <?php
                        }
                    ?>
                </div>
                <a href="<?php
                    echo base_url ( '/invoices/profit-loss-statement?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                   class="pull-right print-btn">Print</a>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="">
                    <thead>
                    <tr>
                        <th> Account Head</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        $sales_debit = 0;
                        if ( count ( $sales_account_head ) > 0 ) {
                            foreach ( $sales_account_head as $sale_account_head ) {
                                $childAccHeads = get_child_account_heads_data ( $sale_account_head -> id );
                                $acc_head_id = $sale_account_head -> id;
                                $transaction = calculate_acc_head_transaction ( $acc_head_id );
                                $sales_debit = $sales_debit + $transaction -> debit;
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
                                        $acc_head_id = $childAccHead -> id;
                                        $transaction = calculate_acc_head_transaction ( $acc_head_id );
                                        $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                                        $sub_transaction = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                                        $sales_debit = $sales_debit + $transaction -> debit;
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
                                $acc_head_id = $returns_allowances_account_head -> id;
                                $transaction = calculate_acc_head_transaction ( $acc_head_id );
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
                                $childAccHeads = get_child_account_heads_data ( $fee_discount_account_head -> id );
                                $acc_head_id = $fee_discount_account_head -> id;
                                $transaction = calculate_acc_head_transaction ( $acc_head_id );
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
                                        $acc_head_id = $childAccHead -> id;
                                        $transaction = calculate_acc_head_transaction ( $acc_head_id );
                                        $fee_discounts_credit = $fee_discounts_credit + $transaction -> credit;
                                        $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                                        $sub_transaction = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
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
                                $childAccHeads = get_child_account_heads_data ( $Direct_Cost_account_head -> id );
                                $acc_head_id = $Direct_Cost_account_head -> id;
                                $transaction = calculate_acc_head_transaction ( $acc_head_id );
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
                                        $subChildAccHeads = get_child_account_heads_data ( $childAccHead -> id );
                                        $acc_head_id = $childAccHead -> id;
                                        $transaction = calculate_acc_head_transaction ( $acc_head_id );
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
                                                $acc_head_id = $subChildAccHead -> id;
                                                $transaction = calculate_acc_head_transaction ( $acc_head_id );
                                                $direct_cost_credit = $direct_cost_credit + $transaction -> credit;
                                                
                                                $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                                                $sub_transaction = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
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
                                $childAccHeads = get_child_account_heads_data ( $expense_account_head -> id );
                                $acc_head_id = $expense_account_head -> id;
                                $transaction = calculate_acc_head_transaction ( $acc_head_id );
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
                                        $subChildAccHeads = get_child_account_heads_data ( $childAccHead -> id );
                                        $childAccHeads = get_child_account_heads_data ( $expense_account_head -> id );
                                        $acc_head_id = $childAccHead -> id;
                                        $transaction = calculate_acc_head_transaction ( $acc_head_id );
                                        $expense_account_credit = $expense_account_credit + $transaction -> credit;
                                        $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                                        $sub_transaction = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                                        
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
                                $acc_head_id = $Finance_Cost_account_head -> id;
                                $transaction = calculate_acc_head_transaction ( $acc_head_id );
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
                                    //                                    echo @number_format (abs ($net_revenue_before_tax), 2);
                                    echo @number_format ( $net_revenue_before_tax, 2 );
                                ?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                                $tax_debit = 0;
                                $acc_head_id = $Tax_account_head -> id;
                                $transaction = calculate_acc_head_transaction ( $acc_head_id );
                                $tax_debit = $tax_debit + $transaction -> debit;
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
                                    //                                    echo @number_format (abs ($net_revenue_before_tax), 2);
                                    echo @number_format ( $net_revenue_before_tax, 2 );
                                ?>
                            </strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .input-xsmall {
        width: 100px !important;
    }

    .opening td {
        background-color: rgba(0, 255, 0, 0.3) !important;
    }
</style>
