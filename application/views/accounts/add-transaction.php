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
                    <i class="fa fa-reorder"></i> Add Transaction
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_transaction">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-3 col-lg-offset-3">
                                <label for="voucher">Voucher Number</label>
                                <select name="voucher_number" class="form-control select2me" required="required"
                                        data-placeholder="Select" id="voucher"
                                        onchange="setFirstTransactionType(this.value)">
                                    <option></option>
                                    <option value="CPV">CPV</option>
                                    <option value="CRV">CRV</option>
                                    <option value="BPV">BPV</option>
                                    <option value="BRV">BRV</option>
                                    <option value="JV">JV</option>
                                </select>
                            </div>
                            
                            <?php $access = get_user_access ( get_logged_in_user_id () ) ?>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Date</label>
                                <input type="text" name="trans_date"
                                       class="<?php echo ( !in_array ( 'allow-back-date-entries', explode ( ',', $access -> access ) ) ) ? 'financial-year' : 'date date-picker' ?> form-control"
                                       placeholder="Transaction date"
                                       required="required" <?php echo ( !in_array ( 'allow-back-date-entries', explode ( ',', $access -> access ) ) ) ? 'readonly="readonly"' : '' ?>
                                       value="<?php echo date ( 'm/d/Y' ) ?>">
                            </div>
                        </div>
                        <hr />
                        
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="acc_head_id">Choose Account Head</label>
                                <select name="acc_head_id" class="form-control select2me" required="required"
                                        data-placeholder="Select" data-allow-clear="true"
                                        id="acc_head_id">
                                    <option></option>
                                </select>
                            </div>
                            
                            <div class="form-group col-lg-4">
                                <label class="">Transaction Type</label>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="transaction_type" id="credit-0" value="credit"
                                               required="required"
                                               disabled="disabled"> Debit
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="transaction_type" id="debit-0" value="debit"
                                               required="required"
                                               disabled="disabled"> Credit
                                    </label>
                                </div>
                                <input type="hidden" name="transaction_type" id="transaction-type" value="">
                            </div>
                            
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Amount</label>
                                <input type="number" step="0.01" name="amount" class="form-control"
                                       placeholder="Add amount" min="0"
                                       value="<?php echo set_value ( 'amount' ) ?>" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Choose Account Head</label>
                                <!--                                onchange="check_account_type(this.value, 1)"-->
                                <select name="acc_head_id_2" class="form-control select2me" required="required"
                                        id="acc_head_id" data-placeholder="Select">
                                    <option></option>
                                    <?php echo $account_heads ?>
                                </select>
                            </div>
                            
                            <div class="form-group col-lg-4">
                                <label class="">Transaction Type</label>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="transaction_type_2" id="credit-1" value="credit"
                                               required="required"
                                               disabled="disabled">
                                        Debit
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="transaction_type_2" id="debit-1" value="debit"
                                               required="required"
                                               disabled="disabled"> Credit
                                    </label>
                                </div>
                                <input type="hidden" name="transaction_type_2" id="transaction-type-2" value="">
                            </div>
                            
                            <div class="form-group col-lg-4">
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
                        
                        <?php if ( count ( $admissions ) > 0 ) : ?>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label for="ssp-visit-no">Visit No(s).</label>
                                    <select id="ssp-visit-no" name="sale-id[]" class="form-control select2me"
                                            data-placeholder="Select" data-allow-clear="true" multiple="multiple"
                                            required="required">
                                        <option></option>
                                        <?php
                                            foreach ( $admissions as $key => $admission ) {
                                                $selected = set_select ( 'sale-id[]', $admission -> sale_id );
                                                echo '<option value="' . $admission -> sale_id . '"' . $selected . '>' . $admission -> visit_no . '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="">Description</label>
                                <textarea name="description" rows="5" class="form-control"
                                          required="required"><?php echo set_value ( 'description' ) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="add-transaction">Submit</button>
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
            $.uniform.update ( $ ( '#credit-1' ).attr ( 'checked', false ) );
            $.uniform.update ( $ ( '#debit-1' ).attr ( 'checked', true ) );
        }
        
        disable_second_transactions ();
        $ ( '#transaction-type-2' ).val ( 'debit' );
    } );
    
    $ ( '#debit-0' ).on ( 'click', function () {
        if ( $ ( this ).is ( ':checked' ) ) {
            $.uniform.update ( $ ( '#debit-1' ).attr ( 'checked', false ) );
            $.uniform.update ( $ ( '#credit-1' ).attr ( 'checked', true ) );
        }
        
        disable_second_transactions ();
        $ ( '#transaction-type-2' ).val ( 'credit' );
    } );
    
    function disable_second_transactions () {
        $.uniform.update ( $ ( '#debit-1' ).attr ( 'disabled', true ) );
        $.uniform.update ( $ ( '#credit-1' ).attr ( 'disabled', true ) );
    }
    
    function enable_other_transactions () {
        $.uniform.update ( $ ( '#debit-1' ).attr ( 'disabled', false ) );
        $.uniform.update ( $ ( '#credit-1' ).attr ( 'disabled', false ) );
    }
</script>
