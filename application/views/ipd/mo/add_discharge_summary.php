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
                    <i class="fa fa-reorder"></i> Add Discharge Summary
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_mo_add_discharge_summary">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                            <input type="text" name="patient_id" class="form-control" autofocus="autofocus" value="<?php echo set_value('patient_id') ?>" required="required" onchange="get_patient(this.value, false, true)">
                        </div>
                        <div class="form-group col-lg-5">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control name" id="patient-name" readonly="readonly">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Sex</label>
                            <input type="text" class="form-control sex" id="sex" readonly="readonly">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Admission No</label>
                            <input type="text" name="admission_no" class="form-control" readonly="readonly" id="admission_no">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Date of Discharge</label>
                            <input type="text" class="form-control date date-picker" required="required" name="discharge_date" id="discharge_date">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Date of Admission</label>
                            <input type="text" class="form-control date date-picker" required="required" name="admission_date" id="admission_date">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Consultant Incharge</label>
                            <select name="consultant_id" class="form-control select2me" id="consultant">
                                <?php
//                                if(count($doctors) > 0) {
//                                    foreach ($doctors as $doctor) {
//                                        ?>
<!--                                        <option value="--><?php //echo $doctor -> id ?><!--">-->
<!--                                            --><?php //echo $doctor -> name ?>
<!--                                        </option>-->
<!--                                --><?php
//                                    }
//                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Medical Officer</label>
                            <select name="medical_officer" class="form-control select2me">
                                <?php
                                if(count($doctors) > 0) {
                                    foreach ($doctors as $doctor) {
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
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Allergy</label>
                            <input type="text" class="form-control" name="allergy">
                        </div>
                        <div class="form-group col-lg-9">
                            <label for="exampleInputEmail1">Primary Diagnosis</label>
                            <input type="text" class="form-control" name="primary_diagnosis">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Secondary Diagnosis</label>
                            <input type="text" class="form-control" name="secondary_diagnosis">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Presentations & Clinical Course</label>
                            <textarea class="form-control" name="course" rows="5"></textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Significant Physical & Other Findings</label>
                            <textarea class="form-control" name="findings" rows="5"></textarea>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Significant Medications During Hospitalization</label>
                            <select name="medicine_id[]" class="form-control select2me">
                                <option value="">Select Medicine</option>
								<?php
								if(count($medicines) > 0) {
									foreach ($medicines as $medicine) {
										?>
                                        <option value="<?php echo $medicine -> id ?>">
											<?php echo $medicine -> name ?>
											<?php if($medicine -> form_id > 1 or $medicine -> strength_id > 1) : ?>
                                                (<?php echo get_form($medicine -> form_id) -> title ?> - <?php echo get_strength($medicine -> strength_id) -> title ?>)
											<?php endif ?>
                                        </option>
										<?php
									}
								}
								?>
                            </select>
                            <div class="add-more-medications" style="width: 100%; display: block; float: left"></div>
                            <div class="add-more-btn">
                                <a href="javascript:void(0)" class="pull-right btn btn-xs purple" onclick="add_more_medicines()" style="margin-top: 5px;">Add more</a>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Beside Procedures / Operations</label>
                            <select name="service_id[]" class="form-control select2me">
                                <option value="">Select</option>
								<?php
								if (count($services) > 0) {
									foreach ($services as $service) {
										$has_parent = check_if_service_has_child($service->id);
										?>
                                        <option value="<?php echo $service->id ?>" class="<?php if ($has_parent)
											echo 'has-child' ?>">
											<?php echo $service->title ?>
                                        </option>
										<?php
										echo get_sub_child($service->id);
									}
								}
								?>
                            </select>
                            <div class="add-more-procedures" style="width: 100%; display: block; float: left"></div>
                            <div class="add-more-btn">
                                <a href="javascript:void(0)" class="pull-right btn btn-xs purple" onclick="add_more_services()" style="margin-top: 5px;">Add more</a>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Patient Diagnostic</label>
                            <textarea class="form-control" name="pertinent_diagnostic" rows="5"></textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Patient condition/status at the time of discharge</label>
                            <input type="text" class="form-control" name="patient_condition">
                        </div>
                        <hr style="float: left;width: 100%;">
                        <h3 style="width: 100%;float: left;margin: 0 0 20px 0;font-weight: 700 !important;font-size: 20px;">Discharge Instructions</h3>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Diet</label>
                            <input type="text" class="form-control" name="diet">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Activity</label>
                            <input type="text" class="form-control" name="activity">
                        </div>
                        <div class="form-group col-lg-12" style="padding: 0">
							<?php if(count($medicines) > 0) : ?>
                                <div class="form-group col-lg-3">
                                    <label style="display: block; float: left; width: 100%;">Medicines</label>
                                    <select name="medicines[]" class="form-control select2me">
                                        <option value="">Select Medicine</option>
										<?php
										if(count($medicines) > 0) {
											foreach ($medicines as $medicine) {
												?>
                                                <option value="<?php echo $medicine -> id ?>">
													<?php echo $medicine -> name ?>
													<?php if($medicine -> form_id > 1 or $medicine -> strength_id > 1) : ?>
                                                        (<?php echo get_form($medicine -> form_id) -> title ?> - <?php echo get_strength($medicine -> strength_id) -> title ?>)
													<?php endif ?>
                                                </option>
												<?php
											}
										}
										?>
                                    </select>
                                </div>
							<?php endif; ?>
                            <div class="form-group col-lg-2">
                                <label>Dosage</label>
                                <input type="text" name="dosage[]" class="form-control">
                            </div>
                            <div class="form-group col-lg-2">
                                <label>Timings</label>
                                <input type="text" name="timings[]" class="form-control">
                            </div>
                            <div class="form-group col-lg-2">
                                <label>Days</label>
                                <input type="text" name="days[]" class="form-control">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Instructions</label>
                                <select name="instructions[]" class="form-control select2me">
                                    <option value="">Select</option>
									<?php
									if(count($instructions) > 0) {
										foreach ($instructions as $instruction) {
											?>
                                            <option value="<?php echo $instruction->id ?>">
												<?php echo $instruction->instruction ?>
                                            </option>
											<?php
										}
									}
									?>
                                </select>
                            </div>
                        </div>
                        <div class="add-more"></div>
                        <div class="add-more-btn">
                            <a href="javascript:void(0)" class="pull-right btn btn-xs purple" onclick="add_more_prescribed_medicines()" style="margin-right: 15px;">Add more</a>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Instructions</label>
                            <input type="text" class="form-control" name="instruction">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">In case of emergency</label>
                            <input type="text" class="form-control" name="icoe">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>