<?php $access = get_user_access ( get_logged_in_user_id () ); ?>
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
        <form method="post">
            <input type="hidden" name="action" value="do_sale_lab_test">
            <input type="hidden" id="panel_id" name="panel_id" value="">
            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
            <input type="hidden" id="added" value="1">
            
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Sale Tests
                    </div>
                </div>
                <div class="portlet-body" style="overflow: hidden">
                    <div class="row">
                        <div style="display: flex; width: 100%; float: left;;">
                            <div class="form-group col-lg-3" style="position: relative">
                                <label for="exampleInputEmail1">MR No.</label>
                                <input type="text" name="patient_id" class="form-control patient-id"
                                       placeholder="Enter MR after <?php echo emr_prefix ?> e.g 5240"
                                       autofocus="autofocus"
                                       style="padding-left: 85px;"
                                       value="<?php echo @$_GET[ 'patient' ] ?>"
                                       required="required" id="prn"
                                       onchange="get_patient_and_load_tests ( this.value )">
                                <label style="position: absolute;top: 25px;background: #e3e3e3;padding: 7px 25px;">MR-</label>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                                <input type="text" class="form-control" readonly="readonly" id="patient-name">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_CNIC' ) ?></label>
                                <input type="text" class="form-control" readonly="readonly" id="patient-cnic">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Reference</label>
                                <select name="reference-id" class="form-control select2me">
                                    <option value="">Select</option>
                                    <?php
                                        if ( count ( $references ) > 0 ) {
                                            foreach ( $references as $reference ) {
                                                ?>
                                                <option value="<?php echo $reference -> id ?>">
                                                    <?php echo $reference -> title ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
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
                        
                        <div class="col-md-4">
                            <label for="doctor-id">Doctor</label>
                            <select data-placeholder="Select" class="form-control select2me"
                                    name="doctor-id" id="doctor-id" required="required">
                                <option></option>
                                <?php
                                    if ( count ( $doctors ) > 0 ) {
                                        foreach ( $doctors as $doctor ) {
                                            ?>
                                            <option value="<?php echo $doctor -> id ?>">
                                                <?php echo $doctor -> name ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <hr style="margin-top: 0" />
                    
                    <div class="row">
                        <div class="col-md-4">
                            <select class="form-control" required="required" id="lab-tests-sale"
                                    data-placeholder="Select"
                                    onchange="load_sale_test(this.value)">
                                <option></option>
                            </select>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="add-more"></div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12" style="padding: 0; margin-bottom: 25px">
                            <div class="col-lg-4 col-lg-offset-8" style="margin-bottom: 10px;">
                                <label>Doc. Share (%)</label>
                                <input type="number" step="0.01" required="required" class="form-control"
                                       name="doctor-share" min="0" max="100">
                            </div>
                            <div class="col-lg-4 col-lg-offset-8" style="margin-bottom: 10px;">
                                <label>Discount(%)</label>
                                <input type="number" max="100" step="0.01" name="discount" required="required"
                                       value="0" <?php if ( !in_array ( 'add_lab_discount', explode ( ',', $access -> access ) ) ) : ?> readonly="readonly" <?php endif ?>
                                       class="form-control"
                                       onchange="calculate_lab_sale_discount()" id="discount">
                            </div>
                            <div class="col-lg-4 col-lg-offset-8" style="margin-bottom: 10px;">
                                <label>Discount(Flat)</label>
                                <input type="text" name="flat-discount" required="required" value="0"
                                       class="form-control" <?php if ( !in_array ( 'add_lab_discount', explode ( ',', $access -> access ) ) ) : ?> readonly="readonly" <?php endif ?>
                                       onchange="calculate_flat_lab_sale_discount()" id="flat-discount">
                            </div>
                            <div class="col-lg-4 col-lg-offset-8">
                                <label>Net Price</label>
                                <input type="text" name="net_price" required="required" readonly="readonly"
                                       value="0"
                                       class="form-control net-price" id="lab-sale-total">
                                <input type="hidden" value="0" class="form-control total"
                                       id="constant-lab-sale-total">
                            </div>
                            <div class="col-lg-4 col-lg-offset-8" style="padding-top: 10px">
                                <label style="color: #ff0000; font-weight: 700">Paid Amount</label>
                                <input type="number" step="any" min="0" name="paid_amount" required="required"
                                       class="form-control paid-amount" id="paid-amount"
                                       onchange="check_lab_sale_paid_amount(this.value)">
                            </div>
                            <div class="col-lg-4 col-lg-offset-8" style="padding-top: 10px">
                                <label>Balance</label>
                                <input type="text" readonly="readonly" value="0" class="form-control balance-amount"
                                       id="balance-amount">
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <label><strong>Show Lab Online Report</strong></label>
                            <select name="show_online_report" class="form-control select2me" required="required">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        
                        <div class="col-lg-4">
                            <label><strong>Internal Remarks</strong></label>
                            <textarea name="internal-remarks" class="form-control" rows="5"></textarea>
                        </div>
                        
                        <div class="col-lg-4">
                            <label><strong>Patient Remarks</strong></label>
                            <textarea name="patient-remarks" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-actions">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
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
<script type="text/javascript">
    <?php if (isset( $_GET[ 'patient' ] ) and !empty( trim ( $_GET[ 'patient' ] ) )) : ?>
    jQuery ( window ).on ( 'load', function () {
        let prn = <?php echo $_GET[ 'patient' ] ?>;
        get_patient_and_load_tests ( prn );
    } );
    <?php endif; ?>
</script>
