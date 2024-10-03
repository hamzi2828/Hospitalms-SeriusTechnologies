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
                <div class="form-group col-lg-3 col-md-offset-3">
                    <label for="voucher">Voucher No#</label>
                    <input type="text" name="voucher" class="form-control" id="voucher"
                           value="<?php echo $this -> input -> get ( 'voucher' ) ?>">
                </div>
                <div class="col-lg-2" style="padding-top: 25px">
                    <button type="submit" class="btn btn-block btn-primary">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <?php
            $first_transaction  = 0;
            $other_transactions = 0;
            if ( count ( $transactions ) > 0 ) : ?>
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-globe"></i> Edit Transactions
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form role="form" method="post" autocomplete="off">
                            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                            <input type="hidden" name="action" value="do_update_transaction">
                            <div class="form-body">
                                <?php if ( count ( $transactions ) > 0 ) : ?>
                                    <div class="row" style="border-bottom: 1px solid #e3e3e3; margin-bottom: 25px;">
                                        <div class="form-group col-md-offset-3 col-lg-3">
                                            <label for="trans-date">Date</label>
                                            <input type="text" name="trans-date" class="date date-picker form-control"
                                                   id="trans-date" required="required"
                                                   value="<?php echo date ( 'm/d/Y', strtotime ( $transactions[ 0 ] -> trans_date ) ) ?>">
                                        </div>
                                        <div class="form-group col-lg-3">
                                            <label for="payment-mode">Payment Mode</label>
                                            <select name="payment-mode" class="form-control" id="payment-mode">
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
                                    foreach ( $transactions as $key => $transaction ) :
                                        if ( $key == 0 )
                                            $first_transaction = ( $transaction -> credit + $transaction -> debit );
                                        else
                                            $other_transactions += ( $transaction -> credit + $transaction -> debit );
                                        ?>
                                        
                                        <?php if ( count ( $transactions ) > 2 && $key == 0 ) : ?>
                                        <div class="row">
                                            <div class="col-md-7 col-md-offset-3">
                                                <h3 style="border-bottom: 1px solid #e3e3e3; margin-bottom: 25px;">
                                                    <strong>First Transaction</strong>
                                                </h3>
                                            </div>
                                        </div>
                                    <?php elseif ( count ( $transactions ) > 2 && $key == '1' ) : ?>
                                        <div class="row">
                                            <div class="col-md-7 col-md-offset-3">
                                                <h3 style="border-bottom: 1px solid #e3e3e3; margin-bottom: 25px;">
                                                    <strong>Other Transactions</strong>
                                                </h3>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                        
                                        <input type="hidden" name="general-ledger-id[]"
                                               value="<?php echo $transaction -> id ?>">
                                        <div class="row">
                                            <div class="form-group col-md-offset-3 col-lg-3">
                                                <label for="acc-head-id">
                                                    <?php if ( $key > 1 && !empty( $access ) && in_array ( 'delete-transactions', explode ( ',', $access -> access ) ) ) : ?>
                                                        <a href="<?php echo base_url ( '/accounts/delete-transaction/' . $transaction -> id ) ?>"
                                                           onclick="return confirm('Are you sure?')"
                                                           style="text-decoration: none; color: #FF0000;">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    Choose Account Head
                                                </label>
                                                <select class="form-control select2me" required="required"
                                                        id="acc-head-id"
                                                        name="acc-head-id[]">
                                                    <?php echo buildList ( $tree, $options, 0, false, null, $transaction -> acc_head_id ); ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label class="">Transaction Type</label>
                                                <div class="radio-list">
                                                    <label class="radio-inline">
                                                        <input type="radio" disabled="disabled"
                                                               value="credit" <?php if ( $transaction -> transaction_type == 'credit' ) echo 'checked="checked"' ?>>
                                                        Debit
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" disabled="disabled"
                                                               value="debit" <?php if ( $transaction -> transaction_type == 'debit' ) echo 'checked="checked"' ?>>
                                                        Credit
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="amount">Amount</label>
                                                <input type="number" step="any" name="amount[]"
                                                       class="form-control amount <?php echo $key == 0 ? 'first-transaction initial-amount' : 'other-amounts' ?>"
                                                       id="amount" <?php if ( count ( $transactions ) == '2' ) : ?> onchange="setTransactionPrice(this.value)" <?php endif; ?>
                                                       value="<?php echo ( $transaction -> debit + $transaction -> credit ) ?>"
                                                       required="required">
                                            </div>
                                        </div>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                                <?php if ( count ( $transactions ) > 0 ) : ?>
                                    <div class="row">
                                        <div class="form-group col-lg-7 col-md-offset-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" rows="5" id="description"
                                                      class="form-control"><?php echo $transactions[ 0 ] -> description ?></textarea>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button <?php if ( $first_transaction != $other_transactions ) echo 'disabled="disabled"' ?>
                                                type="submit" class="btn blue" id="multiple-transactions-btn">
                                            Update
                                        </button>
                                        <a href="<?php echo base_url ( '/invoices/voucher_transaction/' . $transactions[ 0 ] -> voucher_number ) ?>"
                                           target="_blank" style="display: inline;"
                                           class="btn green">Print Voucher</a>
                                        
                                        <?php if ( !empty( $access ) && in_array ( 'revert-transactions', explode ( ',', $access -> access ) ) ) : ?>
                                            <a href="<?php echo base_url ( '/accounts/revert_transaction/' . $transactions[ 0 ] -> voucher_number ) ?>"
                                               class="btn red"
                                               onclick="return confirm('Are you sure? Once deleted can not be recover.')"
                                               style="display: inline;">
                                                Revert Transactions
                                                <small>(Delete)</small>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<?php if ( $first_transaction != $other_transactions ) : ?>
    <script type="text/javascript">
        alert ( 'Transactions are not balanced. Please fix before closing.' )
    </script>
<?php endif; ?>
