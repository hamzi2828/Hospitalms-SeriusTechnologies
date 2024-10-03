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
            <input type="hidden" name="action" value="do_sale_lab_package">
            <input type="hidden" id="panel_id" name="panel_id" value="">
            
            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Sale Packages
                    </div>
                </div>
                <div class="portlet-body" style="overflow: auto">
                    
                    <div class="row">
                        <div class="form-group col-lg-4" style="position: relative">
                            <label for="exampleInputEmail1">MR No.</label>
                            <input type="text" name="patient_id" class="form-control patient-id"
                                   placeholder="Enter MR after <?php echo emr_prefix ?> e.g 5240" autofocus="autofocus"
                                   style="padding-left: 85px;"
                                   value="<?php echo @$_GET[ 'patient' ] ?>"
                                   required="required" id="prn"
                                   onchange="get_patient ( this.value, false, false, false )">
                            <label style="position: absolute;top: 25px;background: #e3e3e3;padding: 7px 25px;">MR-</label>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Patient Name</label>
                            <input type="text" class="form-control" readonly="readonly" id="patient-name">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Patient CNIC</label>
                            <input type="text" class="form-control" readonly="readonly" id="patient-cnic">
                        </div>
                        <input type="hidden" id="added" value="1">
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
                    
                    <div class="form-group col-lg-6" style="padding-left: 0">
                        <label>Package</label>
                        <select name="package_id[]" class="form-control select2me" required="required"
                                onchange="get_lab_package_info(this.value, 1)">
                            <option value="">Select</option>
                            <?php
                                if ( count ( $packages ) > 0 ) {
                                    foreach ( $packages as $package ) {
                                        ?>
                                        <option value="<?php echo $package -> id ?>">
                                            <?php echo $package -> title ?>
                                        </option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Price</label>
                        <input type="text" class="form-control price price-1" readonly="readonly" name="price[]">
                    </div>
                    <div class="col-lg-3">
                        <label><strong>Report Collection Date & Time</strong></label>
                        <input type="datetime-local" class="form-control">
                    </div>
                    
                    <div class="add-more"></div>
                    
                    <div class="col-lg-12" style="padding: 0">
                        <div class="col-lg-2 col-lg-offset-10" style="margin-bottom: 10px;">
                            <label>Discount(%)</label>
                            <input type="text" name="discount" required="required" value="0" class="form-control"
                                   onchange="calculate_lab_sale_discount()" id="discount">
                        </div>
                        <div class="col-lg-2 col-lg-offset-10" style="margin-bottom: 10px;">
                            <label>Discount(Flat)</label>
                            <input type="text" name="flat-discount" required="required" value="0" class="form-control"
                                   onchange="calculate_flat_lab_sale_discount()" id="flat-discount">
                        </div>
                        <div class="col-lg-2 col-lg-offset-10">
                            <label>Net Price</label>
                            <input type="text" name="net_price" required="required" readonly="readonly" value="0"
                                   class="form-control net-price" id="lab-sale-total">
                            <input type="hidden" value="0" class="form-control total" id="constant-lab-sale-total">
                        </div>
                        <div class="col-lg-2 col-lg-offset-10" style="padding-top: 10px">
                            <label>Paid Amount</label>
                            <input type="text" name="paid_amount" required="required"
                                   class="form-control paid-amount" id="paid-amount">
                        </div>
                        <div class="col-lg-2 col-lg-offset-10" style="padding-top: 10px">
                            <label>Balance</label>
                            <input type="text" readonly="readonly" value="0" class="form-control balance-amount"
                                   id="balance-amount">
                        </div>
                    </div>
                    
                    <div class="col-lg-8">
                        <label><strong>Comments</strong></label>
                        <textarea name="comments" class="form-control" rows="8"></textarea>
                    </div>
                    
                    <div class="col-lg-4">
                        <label><strong>Show Lab Online Report</strong></label>
                        <select name="show_online_report" class="form-control select2me" required="required">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                        <button type="button" class="btn purple" onclick="add_more_lab_packages()">Add More</button>
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