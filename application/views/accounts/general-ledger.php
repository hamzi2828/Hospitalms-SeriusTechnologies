<!-- BEGIN PAGE CONTENT-->
<style>
    .search {
        width: 100%;
        display: block;
        float: left;
        background: #f5f5f5;
        padding: 15px 0 0 0;
        margin-bottom: 15px;
    }

    .has-child {
        font-weight: 600;
    }

    .child {
        padding-left: 15px;
    }

    .sub-child {
        padding-left: 30px;
    }

    .has-sub-child {
        font-weight: 600;
        padding-left: 15px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form method="get" autocomplete="off">
                <div class="form-group col-lg-3 col-lg-offset-2">
                    <label for="exampleInputEmail1">Choose Account Head</label>
                    <select name="acc_head_id" class="form-control select2me" required="required">
                        <option value="">Select Account Head</option>
                        <?php
                            if ( isset( $_REQUEST[ 'acc_head_id' ] ) ) {
                                $id = explode ( '-', $_REQUEST[ 'acc_head_id' ] );
                                $id = $id[ 1 ];
                            }
                            else {
                                $id = '';
                            }
                            if ( count ( $account_heads ) > 0 ) {
                                foreach ( $account_heads as $account_head ) {
                                    $child = if_has_child ( $account_head -> id );
                                    ?>
                                    <option value="<?php echo ( $child > 0 ) ? 'm-' . $account_head -> id : 'sc-' . $account_head -> id ?>"
                                            class="<?php if ( $child > 0 ) echo 'has-child' ?>" <?php if ( $id == $account_head -> id ) echo 'selected' ?>>
                                        <?php echo $account_head -> title ?>
                                    </option>
                                    <?php
                                    echo get_child_account_heads ( $account_head -> id, $id );
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="financial-year form-control" placeholder="Start date"
                           required="required"
                           value="<?php echo ( @$_REQUEST[ 'start_date' ] ) ? @$_REQUEST[ 'start_date' ] : date ( 'm/d/Y' ) ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="financial-year form-control" placeholder="End date"
                           required="required"
                           value="<?php echo ( @$_REQUEST[ 'end_date' ] ) ? @$_REQUEST[ 'end_date' ] : date ( 'm/d/Y' ) ?>">
                </div>
                <div class="col-lg-1" style="padding-top: 25px">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <?php
            if ( $ledgers and count ( $ledgers ) > 0 ) {
                $net_closing_balance = 0;
                foreach ( $ledgers as $ledger ) {
                    $acc_head_id = $ledger -> id;
                    ?>
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>
                                <?php echo $ledger -> title . ' Ledger'; ?>
                                <?php if ( isset( $_REQUEST[ 'start_date' ] ) ) : ?>
                                    <small>
                                        (
                                        <?php echo date ( 'm-d-Y', strtotime ( $_REQUEST[ 'start_date' ] ) ) ?> -
                                        <?php echo date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) ) ?>
                                        )
                                    </small>
                                <?php endif ?>
                            </div>
                            <?php if ( count ( $ledgers ) > 0 ) : ?>
                                <a href="<?php echo base_url ( '/invoices/general-ledger?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                                   target="_blank"
                                   class="pull-right print-btn">Print</a>
                            <?php endif ?>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="">
                                <thead>
                                <tr>
                                    <th> Sr. No</th>
                                    <th> Trans. ID</th>
                                    <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                                    <th> Voucher No.</th>
                                    <th> Date</th>
                                    <th> Account Head</th>
                                    <th> Description</th>
                                    <th> Debit</th>
                                    <th> Credit</th>
                                    <th> Running Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $transactions = get_transactions ( $acc_head_id );
                                    if ( $transactions and count ( $transactions ) > 0 ) {
                                        end ( $transactions );
                                        $last_key = key ( $transactions );
                                        
                                        $counter                 = 1;
                                        $total_credit            = 0;
                                        $total_debit             = 0;
                                        $running_balance         = 0;
                                        $current_opening_balance = get_opening_balance_previous_than_searched_start_date ( $_REQUEST[ 'start_date' ], $acc_head_id );
                                        if ( $current_opening_balance >= 0 or $current_opening_balance < 0 ) :
                                            $running_balance = $current_opening_balance;
                                            ?>
                                            <tr>
                                                <td colspan="6"></td>
                                                <td> Opening balance
                                                     of <?php echo date_setter ( $_REQUEST[ 'start_date' ] ) ?> </td>
                                                <td colspan="2"></td>
                                                <td> <?php echo $current_opening_balance ?> </td>
                                            </tr>
                                        <?php else : $running_balance = 0; endif; ?>
                                        <?php
                                        foreach ( $transactions as $key => $transaction ) {
                                            $parent = get_account_head_parent ( $transaction -> acc_head_id );
                                            if ( $transaction -> transaction_type == 'opening_balance' and $counter == 1 )
                                                $running_balance = $transaction -> debit + $transaction -> credit;
                                            else if ( !empty( $parent ) and ( $parent == bank_id or $parent == cash_from_pharmacy or $parent == cash_from_lab or $parent == cash_from_opd ) )
                                                $running_balance = ( $running_balance + $transaction -> credit ) - $transaction -> debit;
                                            else if ( $transaction -> acc_head_id == cash_from_pharmacy or $transaction -> acc_head_id == cash_from_lab or $transaction -> acc_head_id == cash_from_opd )
                                                $running_balance = ( $running_balance + $transaction -> credit ) - $transaction -> debit;
                                            else
                                                $running_balance = ( $running_balance - $transaction -> debit ) + $transaction -> credit;
//                                    if($key == $last_key)
//                                        $net_closing_balance += $running_balance;
                                            $second = check_id_double_entry ( $transaction -> voucher_number, $transaction -> id );
                                            ?>
                                            <tr class="odd gradeX <?php if ( $transaction -> transaction_type == 'opening_balance' )
                                                echo 'opening' ?>">
                                                <td><?php echo $counter++ ?></td>
                                                <td>
                                                    <?php
                                                        echo $transaction -> id;
                                                        if ( count ( $second ) > 0 ) {
                                                            foreach ( $second as $item ) {
                                                                echo ' - ' . $item -> id . '<br>';
                                                            }
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if ( !empty( trim ( $transaction -> invoice_id ) ) )
                                                            echo $transaction -> invoice_id;
                                                        
                                                        else if ( !empty( trim ( $transaction -> internal_issuance_id ) ) )
                                                            echo $transaction -> internal_issuance_id;
                                                        
                                                        else if ( !empty( trim ( $transaction -> bank_trans_id ) ) )
                                                            echo $transaction -> bank_trans_id;
                                                        
                                                        else if ( !empty( trim ( $transaction -> stock_id ) ) )
                                                            echo $transaction -> stock_id;
                                                        
                                                        else if ( !empty( trim ( $transaction -> lab_sale_id ) ) )
                                                            echo $transaction -> lab_sale_id;
                                                        
                                                        else if ( !empty( trim ( $transaction -> opd_consultancy_id ) ) )
                                                            echo $transaction -> opd_consultancy_id;
                                                        
                                                        else if ( !empty( trim ( $transaction -> opd_service_id ) ) )
                                                            echo $transaction -> opd_service_id;
                                                        
                                                        else if ( !empty( trim ( $transaction -> ipd_sale_id ) ) )
                                                            echo $transaction -> ipd_sale_id;
                                                        
                                                        else if ( !empty( trim ( $transaction -> local_purchase_id ) ) )
                                                            echo $transaction -> local_purchase_id;
                                                        
                                                        else if ( !empty( trim ( $transaction -> adjustment_id ) ) )
                                                            echo $transaction -> adjustment_id;
                                                        
                                                        else if ( !empty( trim ( $transaction -> store_fix_asset_id ) ) )
                                                            echo $transaction -> store_fix_asset_id;
                                                        
                                                        else if ( !empty( trim ( $transaction -> department_id ) ) )
                                                            echo $transaction -> department_id;
                                                        
                                                        else
                                                            echo $transaction -> stock_id;
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo base_url ( '/invoices/voucher_transaction/' . $transaction -> voucher_number ) ?>"
                                                       target="_blank">
                                                        <?php echo $transaction -> voucher_number ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $transaction -> trans_date ?></td>
                                                <td><?php echo get_account_head ( $transaction -> acc_head_id ) -> title ?></td>
                                                <td><?php echo $transaction -> description ?></td>
                                                <td><?php echo $transaction -> credit ?></td>
                                                <td><?php echo $transaction -> debit ?></td>
                                                <td><?php echo $running_balance ?></td>
                                            </tr>
                                            <?php
//                                            if ( $transaction -> transaction_type != 'opening_balance' ) {
                                            $total_credit += $transaction -> credit;
                                            $total_debit  += $transaction -> debit;
//                                            }
                                        }
                                        $net_closing_balance += ( $total_credit - $total_debit );
                                    }
                                ?>
                                </tbody>
                                <?php
                                    if ( $transactions and count ( $transactions ) > 0 ) {
                                        ?>
                                        <tfoot>
                                        <tr>
                                            <th colspan="8" style="text-align: right"> <?php echo $total_credit ?></th>
                                            <th> <?php echo $total_debit ?></th>
                                            <th><?php echo $total_credit - $total_debit; ?></th>
                                        </tr>
                                        </tfoot>
                                        <?php
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <h4 class="text-right">
                    <strong>Net closing balance: </strong> <?php echo number_format ( $net_closing_balance ) ?>
                </h4>
                <?php
            }
        ?>
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