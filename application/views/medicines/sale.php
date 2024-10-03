<?php $access = get_user_access ( get_logged_in_user_id () ); ?>
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
            <script type='text/javascript'
                    language='Javascript'>window.open ( '<?php echo base_url ( '/invoices/sale-invoice/' . $this -> session -> flashdata ( 'response' ) ) ?>' );</script>
        <?php endif; ?>
        <div class="alert alert-danger expiry-response" style="display: none"></div>
        <div class="alert alert-danger type-response" style="display: none"></div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Sale Medicine
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off" id="sale-medicine-form">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_sale_medicine">
                    <input type="hidden" name="selected" value="" id="selected_batch">
                    <input type="hidden" value="1" id="added">
                    <div class="form-body" style="overflow:auto; overflow-x: hidden">
                        
                        <div class="row">
                            <div style="display: flex; width: 100%; float: left;">
                                <div class="form-group col-lg-2" style="position: relative;padding-top: 30px;">
                                    <input type="checkbox" name="cash_from_pharmacy" class="cash-customer"
                                           id="cash-customer"
                                           value="<?php echo cash_from_pharmacy ?>" checked="checked">
                                    Cash Customer
                                </div>
                                <div class="form-group col-lg-2" style="position: relative;">
                                    <label for="exampleInputEmail1">Customer Name</label>
                                    <input type="text" name="customer_name" class="form-control">
                                </div>
                                <div class="form-group col-lg-2" style="position: relative">
                                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>
                                        .</label>
                                    <input type="text" name="patient_id" class="form-control patient-id"
                                           placeholder="EMR"
                                           autofocus="autofocus" onchange="get_patient(this.value)">
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                                    <input type="text" class="form-control" readonly="readonly" id="patient-name">
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_CNIC' ) ?></label>
                                    <input type="text" class="form-control" readonly="readonly" id="patient-cnic">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
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
                        <hr style="margin-top: 0" />
                        
                        <div style="min-height: 300px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-control select2me"
                                            id="sale-medicines-dropdown" data-placeholder="Select Medicines"
                                            required="required" onchange="get_stock_for_sale(this.value)"
                                            readonly="readonly">
                                        <option></option>
                                        <?php
                                            if ( count ( $medicines ) > 0 ) {
                                                foreach ( $medicines as $medicine ) {
                                                    ?>
                                                    <option value="<?php echo $medicine -> id ?>">
                                                        <?php echo $medicine -> name ?>
                                                        <?php if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 ) : ?>
                                                            (<?php echo get_form ( $medicine -> form_id ) -> title ?> - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
                                                        <?php endif ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <table class="table table-bordered" border="1">
                                        <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Medicine</th>
                                            <th>Batch</th>
                                            <th>Available Qty.</th>
                                            <th>Sale Qty.</th>
                                            <th>Price</th>
                                            <th>Net Price</th>
                                        </tr>
                                        </thead>
                                        <tbody id="sale-more-medicine"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div id="sale-payment-info"> <!-- sale-payment-info -->
                            <div class="col-lg-2 col-lg-offset-8">
                                <strong class="total-net-price">Total</strong>
                            </div>
                            <div class="col-lg-2" style="margin-bottom: 5px;">
                                <input type="text" class="form-control total" name="pharmacy_sale_total"
                                       readonly="readonly"
                                       value="0">
                            </div>
                            <div class="col-lg-2 col-lg-offset-8">
                                <strong class="total-net-price">Discount(%)</strong>
                            </div>
                            <div class="col-lg-2" style="margin-bottom: 5px;">
                                <input type="text"
                                       class="form-control sale_discount grand_total_discount" <?php if ( !in_array ( 'add_pharmacy_discount', explode ( ',', $access -> access ) ) ) : ?> readonly="readonly" <?php endif ?>
                                       name="sale_discount" onchange="calculate_sale_discount(this.value)" value="0">
                            </div>
                            <div class="col-lg-2 col-lg-offset-8">
                                <strong class="total-net-price">Discount (Flat)</strong>
                            </div>
                            <div class="col-lg-2" style="margin-bottom: 5px;">
                                <input type="text" class="form-control flat_discount"
                                       name="flat_discount" <?php if ( !in_array ( 'add_pharmacy_discount', explode ( ',', $access -> access ) ) ) : ?> readonly="readonly" <?php endif ?>
                                       onchange="calculate_flat_sale_discount(this.value)" value="0">
                            </div>
                            <div class="col-lg-2 col-lg-offset-8">
                                <strong class="total-net-price">Add Amount</strong>
                            </div>
                            <div class="col-lg-2" style="margin-bottom: 5px;">
                                <input type="text" class="form-control added_amount" name="added_amount"
                                       onchange="calculate_added_amount_total(this.value)" value="0">
                            </div>
                            <div class="col-lg-2 col-lg-offset-8" style="margin-bottom: 5px;">
                                <strong class="total-net-price">Net Total</strong>
                            </div>
                            <div class="col-lg-2">
                                <input type="text" name="total" id="total-net-price" readonly="readonly"
                                       class="form-control grand_total">
                            </div>
                            <div class="col-lg-2 col-lg-offset-8" style="margin-bottom: 5px;">
                                <strong class="total-net-price">Paid</strong>
                            </div>
                            <div class="col-lg-2">
                                <input type="text" name="paid_amount" class="form-control"
                                       onchange="calculate_balance_after_payment(this.value)">
                            </div>
                            <div class="col-lg-2 col-lg-offset-8" style="margin-bottom: 5px;">
                                <strong class="total-net-price">Balance</strong>
                            </div>
                            <div class="col-lg-2">
                                <input type="text" readonly="readonly" class="form-control balance">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-actions"
                                 style="float: left; width: 100%; display: block; margin-top: 0; padding: 15px 10px 5px 15px !important;">
                                <button type="submit" class="btn blue">Submit</button>
                                <a href="<?php echo base_url ( '/medicines/sale/?action=clear-sale' ) ?>"
                                   class="btn dark"
                                   onclick="return confirm('Are you sure?')">Clear Sale</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .total-net-price {
        float       : right;
        padding-top : 8px;
        font-size   : 16px;
    }
    
    .sale-fields {
        width   : 100%;
        display : block;
        float   : left;
    }
</style>
<script type="text/javascript">
    $ ( window ).on ( 'load', function () {
        get_locked_medicines ();
        $ ( document ).on ( 'click', '#close-popup', function () {
            $ ( '#locked-medicines' ).remove ();
        } )
    } )
</script>