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
                    <i class="fa fa-reorder"></i> Add Birth Certificate
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="add_birth_certificate">
                    
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-2" style="position: relative">
                                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>.</label>
                                <input type="text" name="patient_id" class="form-control patient-id" placeholder="EMR"
                                       autofocus="autofocus" onchange="get_patient(this.value)" required="required">
                            </div>
                            <div class="form-group col-lg-5">
                                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                                <input type="text" class="form-control" readonly="readonly" id="patient-name">
                            </div>
                            <div class="form-group col-lg-5">
                                <label for="exampleInputEmail1"><?php echo $this -> lang -> line('PATIENT_CNIC') ?></label>
                                <input type="text" class="form-control" readonly="readonly" id="patient-cnic">
                            </div>
                            
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Baby Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Add member name"
                                       autofocus="autofocus" value="<?php echo set_value ( 'name' ) ?>" maxlength="100"
                                       required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Gender</label>
                                <select name="gender" class="form-control select2me" required="required">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Father Name</label>
                                <input type="text" name="father-name" class="form-control" placeholder="Add father name"
                                       value="<?php echo set_value ( 'father-name' ) ?>" required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Father CNIC</label>
                                <input type="text" name="father-cnic" class="form-control" placeholder="Add father cnic"
                                       value="<?php echo set_value ( 'father-cnic' ) ?>" required="required" maxlength="13">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Father Phone</label>
                                <input type="text" name="father-phone" class="form-control"
                                       placeholder="Add father contact no"
                                       value="<?php echo set_value ( 'father-phone' ) ?>" required="required" maxlength="11">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Mother Name</label>
                                <input type="text" name="mother-name" class="form-control" placeholder="Add mother name"
                                       value="<?php echo set_value ( 'mother-name' ) ?>" required="required">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Mother CNIC</label>
                                <input type="text" name="mother-cnic" class="form-control" placeholder="Add mother cnic"
                                       value="<?php echo set_value ( 'mother-cnic' ) ?>" required="required" maxlength="13">
                            </div>
                            
                            <div class="form-group col-lg-12">
                                <label for="exampleInputEmail1">Address</label>
                                <textarea name="address" class="form-control" rows="5" required="required"
                                          placeholder="Address"><?php echo set_value ( 'address' ) ?></textarea>
                            </div>
                            
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Date Of Birth</label>
                                <input type="text" name="birth-date" class="form-control date-picker"
                                       placeholder="Birth Date"
                                       value="<?php echo set_value ( 'birth-date' ) ?>" required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Time Of Birth</label>
                                <input type="time" name="birth-time" class="form-control" placeholder="Birth Time"
                                       value="<?php echo set_value ( 'birth-time' ) ?>" required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Weight (kg)</label>
                                <input type="text" name="weight" class="form-control" placeholder="Weight"
                                       value="<?php echo set_value ( 'weight' ) ?>" required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Consultant</label>
                                <select name="doctor_id" class="form-control select2me" required="required">
                                    <option value="">Select</option>
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
                            
                            <div class="form-group col-lg-12">
                                <label for="exampleInputEmail1">Any Disability</label>
                                <textarea name="disability" class="form-control" rows="5"
                                          placeholder="Any Disability"><?php echo set_value ( 'disability' ) ?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="patient-reg-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>