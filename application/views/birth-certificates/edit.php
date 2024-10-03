<style>
    td {
        text-transform: capitalize;
    }
</style>
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
                    <i class="fa fa-reorder"></i> Edit Birth Certificate
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="edit_birth_certificate">
                    <input type="hidden" name="certificate-id" value="<?php echo $certificate -> id ?>">
                    
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-2" style="position: relative">
                                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>.</label>
                                <input type="text" name="patient_id" class="form-control patient-id" placeholder="EMR"
                                       value="<?php echo $certificate -> patient_id ?>" disabled="disabled">
                            </div>
                            <div class="form-group col-lg-5">
                                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                                <input type="text" class="form-control" readonly="readonly" id="patient-name"
                                       disabled="disabled"
                                       value="<?php echo get_patient ( $certificate -> patient_id ) -> name ?>">
                            </div>
                            <div class="form-group col-lg-5">
                                <label for="exampleInputEmail1"><?php echo $this -> lang -> line('PATIENT_CNIC') ?></label>
                                <input type="text" class="form-control" readonly="readonly" id="patient-cnic"
                                       disabled="disabled"
                                       value="<?php echo get_patient ( $certificate -> patient_id ) -> cnic ?>">
                            </div>
                            
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Baby Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Add member name"
                                       autofocus="autofocus" value="<?php echo $certificate -> name ?>" maxlength="100"
                                       required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Gender</label>
                                <select name="gender" class="form-control select2me" required="required">
                                    <option value="">Select Gender</option>
                                    <option value="male" <?php echo $certificate -> gender == 'male' ? 'selected="selected"' : '' ?>>Male</option>
                                    <option value="female" <?php echo $certificate -> gender == 'female' ? 'selected="selected"' : '' ?>>Female</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Father Name</label>
                                <input type="text" name="father-name" class="form-control" placeholder="Add father name"
                                       value="<?php echo $certificate -> father_name ?>" required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Father CNIC</label>
                                <input type="text" name="father-cnic" class="form-control" placeholder="Add father cnic"
                                       value="<?php echo $certificate -> father_cnic ?>" required="required" maxlength="13">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Father Phone</label>
                                <input type="text" name="father-phone" class="form-control"
                                       placeholder="Add father contact no"
                                       value="<?php echo $certificate -> father_mobile ?>" required="required"
                                       maxlength="11">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Mother Name</label>
                                <input type="text" name="mother-name" class="form-control" placeholder="Add mother name"
                                       value="<?php echo $certificate -> mother_name ?>" required="required">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Mother CNIC</label>
                                <input type="text" name="mother-cnic" class="form-control" placeholder="Add mother cnic"
                                       value="<?php echo $certificate -> mother_cnic ?>" required="required" maxlength="13">
                            </div>
                            
                            <div class="form-group col-lg-12">
                                <label for="exampleInputEmail1">Address</label>
                                <textarea name="address" class="form-control" rows="5" required="required"
                                          placeholder="Address"><?php echo $certificate -> address ?></textarea>
                            </div>
                            
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Date Of Birth</label>
                                <input type="text" name="birth-date" class="form-control date-picker"
                                       placeholder="Birth Date"
                                       value="<?php echo date ( 'm/d/Y', strtotime ( $certificate -> birth_date ) ) ?>"
                                       required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Time Of Birth</label>
                                <input type="time" name="birth-time" class="form-control" placeholder="Birth Time"
                                       value="<?php echo $certificate -> birth_time ?>" required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Weight (kg)</label>
                                <input type="text" name="weight" class="form-control" placeholder="Weight"
                                       value="<?php echo $certificate -> weight ?>" required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Consultant</label>
                                <select name="doctor_id" class="form-control select2me" required="required">
                                    <option value="">Select</option>
                                    <?php
                                        if ( count ( $doctors ) > 0 ) {
                                            foreach ( $doctors as $doctor ) {
                                                ?>
                                                <option value="<?php echo $doctor -> id ?>" <?php echo $certificate -> doctor_id == $doctor -> id ? 'selected="selected"' : '' ?>>
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
                                          placeholder="Any Disability"><?php echo $certificate -> disability ?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="patient-reg-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>