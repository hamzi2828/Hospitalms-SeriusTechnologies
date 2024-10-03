<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-lg-12">
        <?php if ( validation_errors () != false ) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors (); ?>
            </div>
        <?php } ?>
        <?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata ( 'error' ) ?>
            </div>
        <?php endif; ?>
        <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-md-12">
        <div class="search-form">
            <form method="get" autocomplete="off">
                <div class="form-group col-lg-3 col-lg-offset-4">
                    <label for="voucher-no">Voucher No#</label>
                    <input type="text" id="voucher-no" name="voucher" class="form-control" placeholder="Voucher No#"
                           value="<?php echo $this -> input -> get ( 'voucher' ) ?>">
                </div>
                <div class="col-lg-1" style="padding-top: 25px">
                    <button type="submit" class="btn btn-block btn-primary">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <?php if ( count ( $transactions ) > 0 ) : ?>
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Edit Transactions
                    </div>
                </div>
                <div class="portlet-body form">
                    <form role="form" method="post" autocomplete="off"
                          action="<?php echo base_url ( '/accounts/update-transactions-bulk' ) ?>">
                        
                        <input type="hidden" name="action" value="update_bulk_transactions">
                        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                               value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                        
                        <div class="form-body">
                            <div class="row" style="border-bottom: 1px solid #e5e5e5; margin-bottom: 25px;">
                                <div class="form-group col-lg-offset-4 col-lg-2">
                                    <label for="exampleInputEmail1">Date</label>
                                    <input type="text" name="trans_date"
                                           class="date date-picker form-control" data-date-format="dd-mm-yyyy"
                                           placeholder="Transaction date" required="required"
                                           value="<?php echo date ( 'd-m-Y', strtotime ( $transactions[ 0 ] -> trans_date ) ) ?>">
                                </div>
                                
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Payment Mode</label>
                                    <select name="payment_mode" class="form-control select2me" id="payment-mode">
                                        <option
                                                value="cash" <?php if ( $transactions[ 0 ] -> payment_mode == 'cash' ) echo 'selected="selected"' ?>>
                                            Cash
                                        </option>
                                        <option
                                                value="cheque" <?php if ( $transactions[ 0 ] -> payment_mode == 'cheque' ) echo 'selected="selected"' ?>>
                                            Cheque
                                        </option>
                                        <option
                                                value="online" <?php if ( $transactions[ 0 ] -> payment_mode == 'online' ) echo 'selected="selected"' ?>>
                                            Online
                                        </option>
                                    </select>
                                    
                                    <input type="text" name="transaction-no" id="transaction-no"
                                           value="<?php echo $transactions[ 0 ] -> transaction_no ?>"
                                           class="form-control margin-top-10 <?php echo ( empty( trim ( $transactions[ 0 ] -> transaction_no ) ) ) ? 'hidden' : '' ?>"
                                           placeholder="Cheque/Transaction No">
                                </div>
                            </div>
                            <?php
                                $net_transactions  = 0;
                                $first_transaction = ( $transactions[ 0 ] -> credit + $transactions[ 0 ] -> debit );
                                foreach ( $transactions as $key => $transaction ) {
                                    
                                    if ( $key > 0 )
                                        $net_transactions += ( $transaction -> credit + $transaction -> debit );
                                    
                                    ?>
                                    <div class="row">
                                        <input type="hidden" name="general-ledger-id[]"
                                               value="<?php echo $transaction -> id ?>">
                                        
                                        <div class="form-group col-lg-4">
                                            <label for="exampleInputEmail1">Account Head</label>
                                            <select name="acc_head_id[]" class="form-control select2me"
                                                    required="required"
                                                    id="acc_head_id">
                                                <option value="0">Select Account Head</option>
                                                <?php
                                                    if ( count ( $account_heads ) > 0 ) {
                                                        foreach ( $account_heads as $account_head ) {
                                                            $child = if_has_child ( $account_head -> id );
                                                            ?>
                                                            <option value="<?php echo $account_head -> id ?>"
                                                                    class="<?php if ( $child > 0 ) echo 'has-child' ?>" <?php if ( $transaction -> acc_head_id == $account_head -> id ) echo 'selected' ?>>
                                                                <?php echo $account_head -> title ?>
                                                            </option>
                                                            <?php
                                                            echo get_child_account_heads ( $account_head -> id, $transaction -> acc_head_id );
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-lg-4">
                                            <label class="">Transaction Type</label>
                                            <div class="radio-list">
                                                <label class="radio-inline">
                                                    <input type="radio"
                                                           name="transaction_type_<?php echo $transaction -> id ?>"
                                                           value="credit" <?php if ( $transaction -> transaction_type === 'credit' ) echo 'checked="checked"' ?>>
                                                    Debit
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio"
                                                           name="transaction_type_<?php echo $transaction -> id ?>"
                                                           value="debit" <?php if ( $transaction -> transaction_type === 'debit' ) echo 'checked="checked"' ?>>
                                                    Credit
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-lg-4">
                                            <label for="exampleInputEmail1">Amount</label>
                                            <input type="text" name="amount[]"
                                                   class="form-control <?php echo $key < 1 ? 'price-' . ( $key + 1 ) : 'price'; ?>"
                                                   placeholder="Add amount"
                                                   value="<?php echo ( $transaction -> debit + $transaction -> credit ) ?>"
                                                   required="required"
                                                   onchange="<?php echo $key < 1 ? 'sum_first_transaction_amount()' : 'sum_transaction_amount()'; ?>">
                                        </div>
                                    </div>
                                    <hr style="margin: 20px 0 30px 0;" />
                                    <?php
                                }
                            ?>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="">Description</label>
                                    <textarea name="description" rows="5"
                                              class="form-control"><?php echo $transactions[ 0 ] -> description ?></textarea>
                                </div>
                            </div>
                            
                            <?php if ( $transactions[ 0 ] -> is_multiple === '1' ) : ?>
                                <div class="row">
                                    <div class="form-group col-lg-offset-9 col-lg-3">
                                        <label for="exampleInputEmail1">First Transaction Amount</label>
                                        <div class="doctor">
                                            <input type="text" class="form-control first-transaction"
                                                   readonly="readonly"
                                                   value="<?php echo $first_transaction ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-lg-offset-9 col-lg-3">
                                        <label for="exampleInputEmail1">Other Transactions Total</label>
                                        <div class="doctor">
                                            <input type="text" class="form-control other-transactions"
                                                   readonly="readonly"
                                                   value="<?php echo ( $net_transactions - $first_transaction ) ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                        
                        </div>
                        <div class="form-actions">
                            <button type="submit"
                                    class="btn blue" <?php if ( $transactions[ 0 ] -> is_multiple === '1' ) echo 'id="add-transaction"'; ?>>
                                Update
                            </button>
                            
                            <a href="<?php echo base_url ( '/invoices/voucher_transaction/' . $transactions[ 0 ] -> voucher_number ) ?>"
                               style="display: inline;"
                               target="_blank" class="btn purple">Print</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>