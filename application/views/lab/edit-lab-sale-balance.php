<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger panel-info hidden"></div>
        <div class="alert alert-danger panel-discount-info hidden"></div>
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
        <?php if ( $patient -> panel_id > 0 ) : ?>
            <div class="alert alert-danger">
                <strong>Note!</strong> Patient is a panel customer.
            </div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="action" value="do_edit_lab_sale_balance">
            <input type="hidden" name="id" value="<?php echo $sale -> id ?>">
            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Edit Lab Sale Balance
                    </div>
                </div>
                <div class="portlet-body" style="overflow: hidden">
                    <div class="form-group col-lg-3" style="padding-left: 0">
                        <label><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                        <input type="text" class="form-control" value="<?php echo $patient -> id ?>"
                               readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                        <input type="text" class="form-control" value="<?php echo get_patient_name ( 0, $patient ) ?>"
                               readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Patient Contact No</label>
                        <input type="text" class="form-control" value="<?php echo $patient -> mobile ?>"
                               readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></label>
                        <input type="text" class="form-control" value="<?php echo $sale -> id ?>"
                               readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3" style="padding-left: 0">
                        <label>Total Amount</label>
                        <input type="text" class="form-control"
                               value="<?php echo number_format ( $sale -> total, 2 ) ?>"
                               readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Discount</label>
                        <input type="text" class="form-control"
                               value="<?php echo $sale -> discount ?>"
                               readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Paid Amount</label>
                        <input type="hidden" value="<?php echo $sale -> paid_amount ?>" id="original-paid-amount">
                        <input type="text" class="form-control"
                               value="<?php echo $sale -> paid_amount ?>" name="paid_amount" id="paid-amount"
                               autofocus="autofocus"
                               readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Balance</label>
                        <input type="text" class="form-control"
                               value="<?php echo number_format ( $sale -> total - $sale -> paid_amount, 2 ) ?>"
                               readonly="readonly">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Receiving's</h3>
                            <hr />
                        </div>
                    </div>
                    
                    <?php
                        if ( count ( $receiving ) > 0 ) {
                            foreach ( $receiving as $item ) {
                                ?>
                                <div class="row" style="border-bottom: 1px solid #e3e3e3; margin-bottom: 15px;">
                                    <div class="form-group col-lg-3">
                                        <label>Amount</label>
                                        <input type="text" class="form-control" readonly="readonly"
                                               value="<?php echo number_format ( $item -> amount, 2 ) ?>">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="payment-method">Payment Method</label>
                                        <select class="form-control select2me" id="payment-method"
                                                disabled="disabled" data-placeholder="Select">
                                            <option></option>
                                            <option value="cash" <?php echo $item -> payment_method == 'cash' ? 'selected="selected"' : '' ?>>
                                                Cash
                                            </option>
                                            <option value="card" <?php echo $item -> payment_method == 'card' ? 'selected="selected"' : '' ?>>
                                                Card
                                            </option>
                                            <option value="bank" <?php echo $item -> payment_method == 'bank' ? 'selected="selected"' : '' ?>>
                                                Bank
                                            </option>
                                        </select>
                                    </div>
                                    
                                    <?php if ( $item -> payment_method == 'bank' ) : ?>
                                        <div class="form-group col-lg-3">
                                            <label for="bank-id">Bank</label>
                                            <select class="form-control" id="bank-id"
                                                    disabled="disabled" data-placeholder="Select">
                                                <option></option>
                                                <?php
                                                    if ( count ( $banks ) > 0 ) {
                                                        foreach ( $banks as $bank ) {
                                                            ?>
                                                            <option value="<?php echo $bank -> id ?>" <?php echo $item -> account_head_id == $bank -> id ? 'selected="selected"' : '' ?>>
                                                                <?php echo $bank -> title ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ( in_array ( $item -> payment_method, array ( 'bank', 'card' ) ) ) : ?>
                                        <div class="form-group col-lg-3">
                                            <label for="transaction-no">Cheque/Transaction No</label>
                                            <input type="text" class="form-control"
                                                   value="<?php echo $item -> transaction_no ?>"
                                                   disabled="disabled" id="transaction-no">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="form-group col-lg-3">
                                        <label>Date Received</label>
                                        <input type="text" class="form-control" readonly="readonly"
                                               value="<?php echo date_setter ( $item -> created_at ) ?>">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Received By</label>
                                        <input type="text" class="form-control" readonly="readonly"
                                               value="<?php echo get_user ( $item -> user_id ) -> name ?>">
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    ?>
                    <?php if ( ( $sale -> total - $sale -> paid_amount ) > 0 ) : ?>
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label>Amount</label>
                                <input type="number" max="<?php echo ( $sale -> total - $sale -> paid_amount ) ?>"
                                       class="form-control" name="receiving" required="required" min="0"
                                       onchange="update_lab_sale_paid_amount(this.value)">
                            </div>
                            
                            <div class="form-group col-lg-4">
                                <label for="payment-method">Payment Method</label>
                                <select class="form-control select2me" name="payment-method" id="payment-method"
                                        required="required" data-placeholder="Select"
                                        onchange="getPaymentMethodFields(this.value)">
                                    <option></option>
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="bank">Bank</option>
                                </select>
                            </div>
                            
                            <div id="payment-methods"></div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( ( $sale -> total - $sale -> paid_amount ) > 0 and ( $patient -> panel_id < 1 or empty( trim ( $patient -> panel_id ) ) ) ) : ?>
                        <div class="form-actions">
                            <button type="submit" class="btn blue">Update</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .form-actions {
        float : left;
        width : 100%;
    }
</style>