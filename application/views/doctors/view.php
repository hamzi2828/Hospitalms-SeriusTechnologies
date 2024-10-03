<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
		<?php if(validation_errors() != false) { ?>
            <div class="alert alert-danger validation-errors">
				<?php echo validation_errors(); ?>
            </div>
		<?php } ?>
		<?php if($this -> session -> flashdata('error')) : ?>
            <div class="alert alert-danger">
				<?php echo $this -> session -> flashdata('error') ?>
            </div>
		<?php endif; ?>
		<?php if($this -> session -> flashdata('response')) : ?>
            <div class="alert alert-success">
				<?php echo $this -> session -> flashdata('response') ?>
            </div>
		<?php endif; ?>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> View Doctors
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-body" style="overflow:auto;">
                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Add name" autofocus="autofocus" value="<?php echo $doctor -> name ?>" required="required" readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="Add phone"  value="<?php echo $doctor -> phone ?>" required="required" readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">CNIC</label>
                        <input type="text" name="cnic" class="form-control" placeholder="Add cnic"  value="<?php echo $doctor -> cnic ?>" required="required" readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3" style="margin-top: 30px">
                        <input type="checkbox" name="anesthesiologist" value="1" <?php if($doctor -> anesthesiologist == '1') echo 'checked="checked"' ?> readonly="readonly"> Anesthesiologist Doctor
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputEmail1">Specialization</label>
                        <select class="form-control select2me" name="specialization_id" required="required" disabled="disabled">
                            <option value="">Select specialization</option>
                            <?php
                            if(count($specializations) > 0) {
                                foreach ($specializations as $specialization) {
                                    ?>
                                    <option value="<?php echo $specialization -> id ?>" <?php if($doctor -> specialization_id == $specialization -> id) echo 'selected="selected"' ?>>
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
                        <small class="pull-right">(<?php echo date('g:i a', strtotime($doctor -> available_from)) ?>)</small>
                        <div class="input-group bootstrap-timepicker">
                            <input type="text" class="form-control timepicker-default" name="available_from" readonly="readonly">
                            <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-clock-o"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputEmail1">Available Till</label>
                        <small class="pull-right">(<?php echo date('g:i a', strtotime($doctor -> available_till)) ?>)</small>
                        <div class="input-group bootstrap-timepicker">
                            <input type="text" class="form-control timepicker-default" name="available_till" readonly="readonly">
                            <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-clock-o"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">Doctor Qualification</label>
                        <input type="text" name="qualification" class="form-control" placeholder="Add qualification by coma separated"  value="<?php echo $doctor -> qualification ?>" readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">Hospital Charges</label>
                        <input type="text" name="hospital_charges" class="form-control" placeholder="Add hospital charges"  value="<?php echo $doctor -> hospital_charges ?>" required="required" readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">Doctor Share</label>
                        <input type="text" name="doctor_share" class="form-control" placeholder="Add doctor share"  value="<?php echo $doctor -> doctor_share ?>" required="required" readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">Charges Type</label>
                        <select class="form-control select2me" name="charges_type" disabled="disabled">
                            <option value="fix" <?php if($doctor -> charges_type == 'fix') echo 'selected="selected"' ?>>Fix rate</option>
                            <option value="percentage" <?php if($doctor -> charges_type == 'percentage') echo 'selected="selected"' ?>>Percentage</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="exampleInputEmail1">Description</label>
                        <textarea rows="5" name="description" class="form-control" placeholder="Add description" readonly="readonly"><?php echo $doctor -> description ?></textarea>
                    </div>
                    <?php
                    if(count($doctor_services) > 0) {
                        foreach ($doctor_services as $doctor_service) {
                            ?>
                            <div class="form-group col-lg-8">
                                <label for="exampleInputEmail1">Service</label>
                                <select name="service_id[]" class="form-control select2me" disabled="disabled">
                                    <option value="<?php echo $doctor_service -> service_id ?>">
                                        <?php echo get_ipd_service_by_id($doctor_service -> service_id) -> title ?>
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Charges</label>
                                <input type="text" class="form-control" placeholder="Add charges in percentage" name="charges[]" value="<?php echo $doctor_service -> charges ?>" readonly="readonly">
                            </div>
                    <?php
                        }
                    }
                    ?>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputEmail1">Charges</label>
                        <input type="text" class="form-control" placeholder="Add charges in percentage" name="charges[]" readonly="readonly">
                    </div>
                </div>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>