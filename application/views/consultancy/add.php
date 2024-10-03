<!-- BEGIN PAGE CONTENT-->
<?php $access = get_user_access ( get_logged_in_user_id () ); ?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger panel-info hidden"></div>
        <!--        <div class="alert alert-danger panel-discount-info hidden"></div>-->
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
                    <i class="fa fa-reorder"></i> Add Consultancy
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_consultancy">
                    <div class="form-body">
                        
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
                        
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                                <input type="text" name="patient_id" class="form-control"
                                       placeholder="Add <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>"
                                       autofocus="autofocus" value="<?php echo set_value ( 'patient_id' ) ?>"
                                       required="required" id="patient_id"
                                       onchange="get_consultancy_patient(this.value)">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control name" id="patient-name" readonly="readonly">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">CNIC</label>
                                <input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="medical-department">Medical Department</label>
                                <select class="form-control select2me" name="specialization_id" id="medical-department"
                                        required="required"
                                        onchange="get_doctors_by_specializations(this.value)">
                                    <option value="">Select Department</option>
                                    <?php
                                        if ( count ( $specializations ) > 0 ) {
                                            foreach ( $specializations as $specialization ) {
                                                ?>
                                                <option value="<?php echo $specialization -> id ?>">
                                                    <?php echo $specialization -> title ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Doctor</label>
                                <div class="doctor">
                                    <select class="form-control select2me doctors" name="doctor_id"
                                            required="required"></select>
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Available From</label>
                                <input type="text" class="form-control available_from" name="available_from"
                                       readonly="readonly">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Available Till</label>
                                <input type="text" class="form-control available_till" name="available_till"
                                       readonly="readonly">
                            </div>
                            
                            <div class="form-group col-lg-3">
                                <label for="online-reference-id">Online Referral Portal</label>
                                <select class="form-control select2me" name="online-reference-id"
                                        id="online-reference-id" onchange="get_doctor_info(0)"
                                        data-placeholder="Select">
                                    <option></option>
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
                            
                            <div class="form-group col-lg-9">
                                <label for="exampleInputEmail1">Remarks<sup
                                            style="color: #FF0000; font-weight: 700">*</sup></label>
                                <textarea class="form-control" name="remarks" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-md-offset-8">
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="charges">Charges</label>
                                            <input type="text" id="charges" class="form-control charges" name="charges"
                                                   readonly="readonly">
                                        </div>
                                    </div>
                                    
                                    <div class="row online-reference" style="display: none">
                                        <div class="form-group col-lg-12">
                                            <label for="online-reference">Online Reference Commission</label>
                                            <input type="number" id="online-reference" class="form-control"
                                                   name="online-reference"
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
                                                           required="required" readonly="readonly">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="hospital-discount">Hosp. Disc (Flat)</label>
                                                    <input type="number" step="0.01" name="hospital-discount" min="0"
                                                           onchange="calculateConsultancyDiscount()"
                                                           class="form-control hospital-discount" id="hospital-discount"
                                                           required="required" value="0">
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
                                                           required="required" readonly="readonly">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="doctor-discount">Dr. Disc (Flat)</label>
                                                    <input type="number" step="0.01" name="doctor-discount" min="0"
                                                           onchange="calculateConsultancyDiscount()"
                                                           class="form-control doctor-discount" id="doctor-discount"
                                                           required="required" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="net-bill">Net Bill</label>
                                            <input type="text" id="net-bill" class="form-control net_bill"
                                                   name="net_bill"
                                                   readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" id="submitButton" class="btn blue">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>