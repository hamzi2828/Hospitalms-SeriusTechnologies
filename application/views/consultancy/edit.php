<!-- BEGIN PAGE CONTENT-->
<?php $access = get_user_access ( get_logged_in_user_id () ); ?>
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
                    <i class="fa fa-reorder"></i> Edit Consultancy
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_consultancy">
                    <input type="hidden" name="consultancy_id" value="<?php echo $consultancy -> id ?>">
                    <input type="hidden" name="doctor_id" value="<?php echo $consultancy -> doctor_id ?>">
                    <div class="form-body">
                        
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="payment-method">Payment Method</label>
                                <select class="form-control select2me" name="payment-method" id="payment-method"
                                        required="required" data-placeholder="Select" disabled="disabled"
                                        onchange="getPaymentMethodFields(this.value)">
                                    <option></option>
                                    <option value="cash" <?php echo $consultancy -> payment_method == 'cash' ? 'selected="selected"' : '' ?>>
                                        Cash
                                    </option>
                                    <option value="card" <?php echo $consultancy -> payment_method == 'card' ? 'selected="selected"' : '' ?>>
                                        Card
                                    </option>
                                    <option value="bank" <?php echo $consultancy -> payment_method == 'bank' ? 'selected="selected"' : '' ?>>
                                        Bank
                                    </option>
                                </select>
                            </div>
                            
                            <div id="payment-methods">
                                <?php if ( $consultancy -> payment_method == 'bank' ) : ?>
                                    <div class="form-group col-lg-4">
                                        <label for="bank-id">Bank</label>
                                        <select class="form-control select2me" name="bank-id" id="bank-id"
                                                disabled="disabled"
                                                required="required" data-placeholder="Select">
                                            <option></option>
                                            <?php
                                                if ( count ( $banks ) > 0 ) {
                                                    foreach ( $banks as $bank ) {
                                                        ?>
                                                        <option value="<?php echo $bank -> id ?>" <?php echo $consultancy -> account_head_id == $bank -> id ? 'selected="selected"' : '' ?>>
                                                            <?php echo $bank -> title ?>
                                                        </option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="form-group col-lg-4">
                                    <label for="transaction-no">Cheque/Transaction No</label>
                                    <input type="text" class="form-control" name="transaction-no"
                                           required="required" id="transaction-no"
                                           value="<?php echo $consultancy -> transaction_no ?>">
                                </div>
                            </div>
                        </div>
                        <hr style="margin-top: 0" />
                        
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                                <input type="text" class="form-control" value="<?php echo $consultancy -> patient_id ?>"
                                       readonly="readonly">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control" readonly="readonly"
                                       value="<?php echo $patient -> name ?>">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">CNIC</label>
                                <input type="text" class="form-control" readonly="readonly"
                                       value="<?php echo $patient -> cnic ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Medical Department</label>
                                <input type="text" class="form-control" readonly="readonly"
                                       value="<?php echo get_specialization_by_id ( $consultancy -> specialization_id ) -> title ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Doctor</label>
                                <input type="text" class="form-control" readonly="readonly"
                                       value="<?php echo get_doctor ( $consultancy -> doctor_id ) -> name ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Available From</label>
                                <input type="text" class="form-control available_from" readonly="readonly"
                                       value="<?php echo $consultancy -> available_from ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Available Till</label>
                                <input type="text" class="form-control available_till" readonly="readonly"
                                       value="<?php echo $consultancy -> available_till ?>">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="exampleInputEmail1">Remarks<sup
                                            style="color: #FF0000; font-weight: 700">*</sup></label>
                                <textarea class="form-control" name="remarks"
                                          rows="5"><?php echo $consultancy -> remarks ?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-md-offset-8">
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="charges">Charges</label>
                                            <input type="text" id="charges" class="form-control charges" name="charges"
                                                   readonly="readonly" value="<?php echo $consultancy -> charges ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="row online-reference"
                                         style="<?php echo $consultancy -> online_reference_commission > 0 ? '' : 'display: none' ?>">
                                        <div class="form-group col-lg-12">
                                            <label for="online-reference">Online Reference Commission</label>
                                            <input type="number" id="online-reference" class="form-control"
                                                   name="online-reference"
                                                   value="<?php echo $consultancy -> online_reference_commission > 0 ? $consultancy -> online_reference_commission : 0 ?>"
                                                   readonly="readonly">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="hospital-commission">Hosp. Commission</label>
                                                    <input type="number" step="0.01" name="hospital-commission"
                                                           class="form-control" id="hospital-commission"
                                                           required="required" readonly="readonly"
                                                           value="<?php echo $consultancy -> hospital_share ?>">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="hospital-discount">Hosp. Disc (Flat)</label>
                                                    <input type="number" step="0.01" name="hospital-discount" min="0"
                                                           onchange="calculateConsultancyDiscount()"
                                                           class="form-control hospital-discount" id="hospital-discount"
                                                           required="required" <?php echo $patient -> panel_id > 0 ? 'readonly="readonly"' : '' ?>
                                                           value="<?php echo $consultancy -> hospital_discount ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="doctor-commission">Dr. Commission</label>
                                                    <input type="number" step="0.01" name="doctor-commission"
                                                           class="form-control" id="doctor-commission"
                                                           required="required" readonly="readonly"
                                                           value="<?php echo $consultancy -> doctor_charges ?>">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="doctor-discount">Dr. Disc (Flat)</label>
                                                    <input type="number" step="0.01" name="doctor-discount" min="0"
                                                           onchange="calculateConsultancyDiscount()"
                                                           class="form-control doctor-discount" id="doctor-discount"
                                                           required="required" <?php echo $patient -> panel_id > 0 ? 'readonly="readonly"' : '' ?>
                                                           value="<?php echo $consultancy -> doctor_discount ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="net-bill">Net Bill</label>
                                            <input type="text" id="net-bill" class="form-control net_bill"
                                                   name="net_bill" value="<?php echo $consultancy -> net_bill ?>"
                                                   readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="sales-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>