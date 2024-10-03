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
                    <i class="fa fa-reorder"></i> Add Doctors
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_doctors">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">
                                    Name <sup style="color: #FF0000">*</sup>
                                </label>
                                <input type="text" name="name" class="form-control" placeholder="Add name"
                                       autofocus="autofocus" value="<?php echo set_value ( 'name' ) ?>"
                                       required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Phone Number <sup style="color: #FF0000">*</sup></label>
                                <input type="text" name="phone" class="form-control" placeholder="Add phone"
                                       value="<?php echo set_value ( 'phone' ) ?>" required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">CNIC</label>
                                <input type="text" name="cnic" class="form-control" placeholder="Add cnic"
                                       value="<?php echo set_value ( 'cnic' ) ?>">
                            </div>
                            <div class="form-group col-lg-3" style="margin-top: 30px">
                                <input type="checkbox" name="anesthesiologist" value="1"> Anesthesiologist Doctor
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Specialization <sup
                                            style="color: #FF0000">*</sup></label>
                                <select class="form-control select2me" name="specialization_id" required="required">
                                    <option value="">Select specialization</option>
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
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Available From</label>
                                <input type="time" class="form-control timepicker-default" name="available_from">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Available Till</label>
                                <input type="time" class="form-control timepicker-default" name="available_till">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Doctor Qualification</label>
                                <input type="text" name="qualification" class="form-control"
                                       placeholder="Add qualification by coma separated"
                                       value="<?php echo set_value ( 'qualification' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Hospital Charges <sup
                                            style="color: #FF0000">*</sup></label>
                                <input type="text" name="hospital_charges" class="form-control"
                                       placeholder="Add hospital charges"
                                       value="<?php echo set_value ( 'hospital_charges' ) ?>" required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Doctor Share <sup style="color: #FF0000">*</sup></label>
                                <input type="text" name="doctor_share" class="form-control"
                                       placeholder="Add doctor share"
                                       value="<?php echo set_value ( 'doctor_share' ) ?>" required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Charges Type</label>
                                <select class="form-control select2me" name="charges_type">
                                    <option value="percentage">Percentage</option>
                                    <option value="fix">Fix rate</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea rows="5" name="description" class="form-control"
                                          placeholder="Add description"><?php echo set_value ( 'description' ) ?></textarea>
                            </div>
                            
                            <div class="form-group col-lg-12">
                                <label>Doctor Stamp</label>
                                <textarea rows="5" name="stamp" class="form-control ckeditor"
                                          placeholder="Add stamp"><?php echo set_value ( 'stamp' ) ?></textarea>
                            </div>
                            <div class="form-group col-lg-8">
                                <label for="exampleInputEmail1">Service</label>
                                <select name="service_id[]" class="form-control select2me">
                                    <option value="">Select</option>
                                    <?php
                                        if ( count ( $services ) > 0 ) {
                                            foreach ( $services as $service ) {
                                                $has_parent = check_if_service_has_child ( $service -> id );
                                                ?>
                                                <option value="<?php echo $service -> id ?>"
                                                        class="<?php if ( $has_parent )
                                                            echo 'has-child' ?>">
                                                    <?php echo $service -> title ?>
                                                </option>
                                                <?php
                                                echo get_sub_child ( $service -> id );
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Charges</label>
                                <input type="text" class="form-control" placeholder="Add charges in percentage"
                                       name="charges[]">
                            </div>
                            <div class="add-more" style="display: block; float: left; width: 100%;"></div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="sales-btn">Submit</button>
                        <button type="button" class="btn purple" onclick="add_more_doctor_services()">Add More</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>