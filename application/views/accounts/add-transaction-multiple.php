<?php
    $trigger_change            = $this -> input -> get ( 'trigger-change' );
    $disposed_value            = $this -> input -> get ( 'disposed-value' );
    $total_asset_value         = $this -> input -> get ( 'total-asset-value' );
    $accumulative_depreciation = $this -> input -> get ( 'accumulative-depreciation' );
    $accounts                  = $this -> input -> get ( 'accounts' );
?>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
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
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Transaction (Multiple)
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="add_transactions_multiple">
                    <input type="hidden" id="added" value="0">
                    
                    <div class="form-body">
                        
                        <div class="row">
                            <div class="form-group col-lg-2 col-lg-offset-3">
                                <label for="voucher">Voucher</label>
                                <select name="voucher_number" id="voucher" class="form-control select2me"
                                        required="required"
                                        data-placeholder="Select"
                                    <?php if ( !isset( $trigger_change ) ) : ?> onchange="setFirstTransactionTypeMultipleTransactions(this.value)" <?php endif ?>>
                                    <option></option>
                                    <option value="CPV">CPV</option>
                                    <option value="CRV">CRV</option>
                                    <option value="BPV">BPV</option>
                                    <option value="BRV">BRV</option>
                                    <option value="JV">JV</option>
                                </select>
                            </div>
                            
                            <?php $access = get_user_access ( get_logged_in_user_id () ) ?>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Date</label>
                                <input type="text" name="trans_date"
                                       class="<?php echo ( !in_array ( 'allow-back-date-entries', explode ( ',', $access -> access ) ) ) ? 'financial-year' : 'date date-picker' ?> form-control"
                                       placeholder="Transaction date"
                                       required="required" <?php echo ( !in_array ( 'allow-back-date-entries', explode ( ',', $access -> access ) ) ) ? 'readonly="readonly"' : '' ?>
                                       value="<?php echo $this -> input -> get ( 'date' ) ? $this -> input -> get ( 'date' ) : date ( 'm/d/Y' ) ?>">
                            </div>
                            
                            <div class="form-group col-lg-2">
                                <label for="payment-mode">Payment Mode</label>
                                <select name="payment_mode" id="payment-mode" class="form-control select2me"
                                        required="required">
                                    <option value="cash">Cash</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="online">Online</option>
                                    <option value="credit-card">Credit Card</option>
                                </select>
                                <input type="text" name="transaction-no" id="transaction-no"
                                       class="form-control margin-top-10 hidden"
                                       placeholder="Cheque/Transaction No">
                            </div>
                        </div>
                        <hr />
                        
                        <?php
                            $first_transaction  = 0;
                            $second_transaction = 0;
                            
                            if ( isset( $accounts ) ) {
                                $accounts = explode ( ',', $accounts );
                                if ( count ( $accounts ) > 0 ) {
                                    
                                    $disposalRemainingValue = abs ( ( $total_asset_value - $disposed_value - $accumulative_depreciation ) );
                                    
                                    foreach ( $accounts as $key => $account_id ) {
                                        $values = array (
                                            array (
                                                'nature' => 'debit',
                                                'value'  => abs ( $total_asset_value )
                                            ),
                                            array (
                                                'nature' => 'credit',
                                                'value'  => abs ( $accumulative_depreciation )
                                            ),
                                            array (
                                                'nature' => 'credit',
                                                'value'  => abs ( $disposed_value )
                                            ),
                                            array (
                                                'nature' => $account_id == LOSS_ON_DISPOSAL ? 'credit' : 'debit',
                                                'value'  => $disposalRemainingValue
                                            ),
                                        );
                                        $nature = $values[ $key ];
                                        
                                        if ( $nature[ 'nature' ] === 'credit' )
                                            $first_transaction += $nature[ 'value' ];
                                        else
                                            $second_transaction += $nature[ 'value' ];
                                        
                                        ?>
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label for="account-head-<?php echo $account_id ?>">
                                                    Choose Account Head
                                                </label>
                                                <select name="acc_head_id[]" class="form-control select2me"
                                                        required="required" id="account-head-<?php echo $account_id ?>"
                                                        id="acc_head_id" data-placeholder="Select"
                                                        data-allow-clear="true">
                                                    <option></option>
                                                    <?php
                                                        if ( $account_id < 1 )
                                                            echo $list;
                                                        else {
                                                            $account = get_account_head ( $account_id );
                                                            echo '<option value="' . $account_id . '" selected="selected">' . $account -> title . '</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label class="">Transaction Type</label>
                                                <div class="radio-list">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="transaction_type_<?php echo $key ?>"
                                                               id="credit-<?php echo $key ?>"
                                                               value="credit" <?php echo $nature[ 'nature' ] === 'credit' ? 'checked="checked"' : '' ?>
                                                               required="required"> Debit
                                                    </label>
                                                    
                                                    <label class="radio-inline">
                                                        <input type="radio" name="transaction_type_<?php echo $key ?>"
                                                               id="debit-<?php echo $key ?>"
                                                               value="debit" <?php echo $nature[ 'nature' ] === 'debit' ? 'checked="checked"' : '' ?>
                                                               required="required"> Credit
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label for="amount-<?php echo $account_id ?>">Amount</label>
                                                <input type="text" id="amount-<?php echo $account_id ?>" name="amount[]"
                                                       class="form-control price-1"
                                                       placeholder="Add amount"
                                                       value="<?php echo set_value ( 'amount', $nature[ 'value' ] ) ?>"
                                                       required="required"
                                                       onchange="sum_first_transaction_amount()">
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="add-more"></div>
                                        <div class="form-group col-lg-12">
                                            <label for="description">Description</label>
                                            <textarea id="description" name="description" rows="5" class="form-control"
                                                      required="required"><?php echo set_value ( 'description', $this -> input -> get ( 'asset-detail' ) ) ?></textarea>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            else {
                                $first_transaction = $this -> input -> get ( 'amount' );
                                ?>
                                <div class="row">
                                    <div class="form-group col-lg-5">
                                        <label for="exampleInputEmail1">Choose Account Head</label>
                                        <select name="acc_head_id[]" class="form-control select2me" required="required"
                                                id="acc_head_id" data-placeholder="Select" data-allow-clear="true">
                                            <?php
                                                $selected        = '';
                                                $account_head_id = $this -> input -> get ( 'acc-head-id' );
                                                if ( $account_head_id > 0 ) {
                                                    $account = get_account_head ( $account_head_id );
                                                    echo '<option value="' . $account_head_id . '" selected="selected">' . $account -> title . '</option>';
                                                    $selected = 'checked="checked"';
                                                }
                                            ?>
                                            <option></option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-lg-3">
                                        <label class="">Transaction Type</label>
                                        <div class="radio-list">
                                            <label class="radio-inline">
                                                <input type="radio" name="transaction_type_0" id="credit-0"
                                                       disabled="disabled"
                                                       value="credit"
                                                       required="required"> Debit
                                            </label>
                                            
                                            <label class="radio-inline">
                                                <input type="radio" name="transaction_type_0" id="debit-0" value="debit"
                                                       disabled="disabled"
                                                       required="required"> Credit
                                            </label>
                                        </div>
                                        <input type="hidden" id="transaction-type" name="transaction_type_0">
                                    </div>
                                    
                                    <div class="form-group col-lg-4">
                                        <label for="exampleInputEmail1">Amount</label>
                                        <input type="text" name="amount[]" class="form-control price-1"
                                               placeholder="Add amount"
                                               value="<?php echo set_value ( 'amount', $this -> input -> get ( 'amount' ) ) ?>"
                                               required="required"
                                               onchange="sum_first_transaction_amount()">
                                    </div>
                                    <div class="add-more"></div>
                                    <div class="form-group col-lg-12">
                                        <label class="">Description</label>
                                        <textarea name="description" rows="5" class="form-control"
                                                  required="required"><?php echo set_value ( 'description', $this -> input -> get ( 'asset-detail' ) ) ?></textarea>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                        
                        <div class="form-group" style="margin-top: 25px">
                            <div class="row">
                                <div class="form-group col-lg-offset-9 col-lg-3">
                                    <label for="exampleInputEmail1">Total Debits</label>
                                    <div class="doctor">
                                        <input type="text" class="form-control first-transaction" readonly="readonly"
                                               value="<?php echo ( $first_transaction ) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-offset-9 col-lg-3">
                                    <label for="exampleInputEmail1">Total Credits</label>
                                    <div class="doctor">
                                        <input type="text" class="form-control other-transactions" readonly="readonly"
                                               value="<?php echo abs ( $second_transaction ) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="add-transaction">Submit</button>
                        <button type="button" class="btn purple" onclick="add_more_transactions()">Add More</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .has-child {
        font-weight : 600;
    }
    
    .child {
        padding-left : 15px;
    }
    
    .sub-child {
        padding-left : 30px;
    }
    
    .has-sub-child {
        font-weight  : 600;
        padding-left : 15px;
    }
</style>
<script type="text/javascript">
    $ ( '#credit-0' ).on ( 'click', function () {
        if ( $ ( this ).is ( ':checked' ) ) {
            $ ( '#transaction-type' ).val ( 'credit' );
            
            let voucher = $ ( '#voucher' ).val ();
            if ( voucher === 'JV' ) {
                $.uniform.update ( $ ( '.other-multiple-transaction-credit' ).attr ( 'checked', true ) );
                $.uniform.update ( $ ( '.other-multiple-transaction-debit' ).attr ( 'checked', false ) );
                $ ( '.other-multiple-transactions-values' ).val ( 'debit' );
            }
        }
    } );
    
    $ ( '#debit-0' ).on ( 'click', function () {
        if ( $ ( this ).is ( ':checked' ) ) {
            $ ( '#transaction-type' ).val ( 'debit' );
            
            let voucher = $ ( '#voucher' ).val ();
            if ( voucher === 'JV' ) {
                $.uniform.update ( $ ( '.other-multiple-transaction-credit' ).attr ( 'checked', false ) );
                $.uniform.update ( $ ( '.other-multiple-transaction-debit' ).attr ( 'checked', true ) );
                $ ( '.other-multiple-transactions-values' ).val ( 'credit' );
            }
        }
    } );
</script>
