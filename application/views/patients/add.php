<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <?php patient_search_form ( $patients ) ?>
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
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Patient
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="redirect" value="<?php echo @$_GET[ 'redirect' ] ?>">
                    <?php
                        if ( isset( $_GET[ 'category' ] ) and !empty( trim ( $_GET[ 'category' ] ) ) )
                            $category = 'covid';
                        else
                            $category = 'general';
                    ?>
                    <input type="hidden" name="category" value="<?php echo $category ?>">
                    <input type="hidden" name="action" value="do_add_patient">
                    <div class="form-body" style="overflow: hidden">
                        <div class="row">
                            <input type="hidden" name="type" value="cash">
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Prefix</label>
                                <select name="prefix" class="form-control select2me">
                                    <option value="Mr.">Mr.</option>
                                    <option value="Mrs.">Mrs.</option>
                                    <option value="Ms.">Ms.</option>
                                    <option value="Master.">Master.</option>
                                    <option value="Mst.">Mst.</option>
                                    <option value="M/O">M/O</option>
                                    <option value="F/O">F/O</option>
                                    <option value="Baby of">Baby of</option>
                                    <option value="Baby">Baby</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?> <sup
                                            style="color: #FF0000; font-weight: 700">*</sup></label>
                                <input type="text" name="name" class="form-control" placeholder="<?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?>"
                                       autofocus="autofocus" value="<?php echo set_value ( 'name' ) ?>" maxlength="100"
                                       required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Relationship</label>
                                <select name="relationship" class="form-control select2me">
                                    <option value="S/O" <?php echo ( set_value ( 'relationship' ) == 'S/O' ) ? 'selected="selected"' : '' ?>>
                                        S/O
                                    </option>
                                    <option value="D/O" <?php echo ( set_value ( 'relationship' ) == 'D/O' ) ? 'selected="selected"' : '' ?>>
                                        D/O
                                    </option>
                                    <option value="F/O" <?php echo ( set_value ( 'relationship' ) == 'F/O' ) ? 'selected="selected"' : '' ?>>
                                        F/O
                                    </option>
                                    <option value="W/O" <?php echo ( set_value ( 'relationship' ) == 'W/O' ) ? 'selected="selected"' : '' ?>>
                                        W/O
                                    </option>
                                    <option value="M/O" <?php echo ( set_value ( 'relationship' ) == 'M/O' ) ? 'selected="selected"' : '' ?>>
                                        M/O
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Guardian Name</label>
                                <input type="text" name="father_name" class="form-control" placeholder="Guardian Name"
                                       value="<?php echo set_value ( 'father_name' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Martial Status</label>
                                <select name="martial_status" class="form-control select2me">
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="divorced">Divorced</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Blood Group</label>
                                <select name="blood_group" class="form-control select2me">
                                    <option>Select</option>
                                    <option value="A-">A-</option>
                                    <option value="A+">A+</option>
                                    <option value="B-">B-</option>
                                    <option value="B+">B+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="O-">O-</option>
                                    <option value="O+">O+</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-4 hidden">
                                <label for="exampleInputEmail1">Religion</label>
                                <input type="text" name="religion" class="form-control" placeholder="Religion"
                                       maxlength="13" value="<?php echo set_value ( 'religion' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="">Gender <sup style="color: #FF0000; font-weight: 700">*</sup></label>
                                <select name="gender" class="form-control select2me">
                                    <option value="1">Male</option>
                                    <option value="0">Female</option>
                                    <option value="2">MC</option>
                                    <option value="3">FC</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-1">
                                <label for="exampleInputEmail1">Age</label>
                                <input type="number" name="age" class="form-control" placeholder="Age" id="age"
                                       maxlength="3" value="<?php echo set_value ( 'age' ) ?>">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Year/Month</label>
                                <select name="age_year_month" class="form-control select2me">
                                    <option value="year">Year</option>
                                    <option value="month">Month</option>
                                    <option value="days">Days</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Date of Birth</label>
                                <input type="text" name="dob" class="form-control date-picker"
                                       placeholder="Date of Birth" onchange="calculateAge(this.value)"
                                       maxlength="13" value="<?php echo set_value ( 'dob' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">CNIC</label>
                                <input type="text" name="cnic" class="form-control" placeholder="CNIC" maxlength="13"
                                       value="<?php echo set_value ( 'cnic' ) ?>">
                                <!--                            onchange="check_customer_exists_by_cnic(this.value)"-->
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Passport No.</label>
                                <input type="text" name="passport" class="form-control" placeholder="Passport No."
                                       maxlength="11" value="<?php echo set_value ( 'passport' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Country</label>
                                <input type="text" name="country" class="form-control" placeholder="Country"
                                       maxlength="11"
                                       value="<?php echo 'Pakistan' ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Contact No <sup
                                            style="color: #FF0000; font-weight: 700">*</sup></label>
                                <input type="text" name="phone" class="form-control" placeholder="Contact No"
                                       maxlength="11"
                                       value="<?php echo set_value ( 'phone' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                       value="<?php echo set_value ( 'email' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">City</label>
                                <select name="city" class="form-control select2me">
                                    <option value="0">Select</option>
                                    <?php
                                        if ( count ( $cities ) > 0 ) {
                                            foreach ( $cities as $city ) {
                                                ?>
                                                <option
                                                        value="<?php echo $city -> id ?>"><?php echo $city -> title ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Reference</label>
                                <select name="reference-id" class="form-control select2me">
                                    <option value="">Select</option>
                                    <?php
                                        if ( count ( $references ) > 0 ) {
                                            foreach ( $references as $reference ) {
                                                ?>
                                                <option
                                                        value="<?php echo $reference -> id ?>"><?php echo $reference -> title ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Consultant</label>
                                <select name="doctor_id" class="form-control select2me">
                                    <option value="">Select</option>
                                    <?php
                                        if ( count ( $doctors ) > 0 ) {
                                            foreach ( $doctors as $doctor ) {
                                                ?>
                                                <option
                                                        value="<?php echo $doctor -> id ?>"><?php echo $doctor -> name ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3" style="display: none">
                                <label for="exampleInputEmail1">OPD Service</label>
                                <select name="service_id" class="form-control select2me">
                                    <option value="">Select</option>
                                    <?php
                                        if ( count ( $services ) > 0 ) {
                                            foreach ( $services as $service ) {
                                                ?>
                                                <option
                                                        value="<?php echo $service -> id ?>"><?php echo $service -> title ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <h3 style="font-weight: 800 !important; color: #FF0000"> Permanent Address </h3>
                                <hr style="margin-top: 0" />
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Nationality</label>
                                <input type="text" name="nationality" class="form-control" placeholder="Nationality"
                                       maxlength="11" value="">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Picture</label>
                                <input type="file" class="form-control" name="picture">
                                <p style="margin-top: 5px; color: #FF0000;">Upload Image (Max. 2MB)</p>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="exampleInputEmail1">Address</label>
                                <textarea class="form-control" rows="5" name="address"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <h3 style="font-weight: 800 !important; color: #FF0000"> Emergency Address </h3>
                                <hr style="margin-top: 0" />
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" name="emergency_person_name" class="form-control" placeholder="Name"
                                       maxlength="11" value="<?php echo set_value ( 'emergency_person_name' ) ?>">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Number</label>
                                <input type="text" name="emergency_person_number" class="form-control"
                                       placeholder="Mobile Number" maxlength="11"
                                       value="<?php echo set_value ( 'emergency_person_number' ) ?>">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Relation</label>
                                <input type="text" name="emergency_person_relation" class="form-control"
                                       placeholder="Relation" maxlength="11"
                                       value="<?php echo set_value ( 'emergency_person_relation' ) ?>">
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