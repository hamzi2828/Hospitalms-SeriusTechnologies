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
					<i class="fa fa-reorder"></i> Add Admission Orders
				</div>
			</div>
			<div class="portlet-body form">
				<div class="alert alert-danger" id="patient-info" style="display: none"></div>
				<form role="form" method="post" autocomplete="off">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
					<input type="hidden" name="action" value="do_mo_add_admission_orders">
					<input type="hidden" id="added" value="1">
					<div class="form-body" style="overflow:auto;">
						<div class="form-group col-lg-8">
							<label for="exampleInputEmail1">Drug Allergies</label>
							<input type="text" class="form-control" name="drug_allergies">
						</div>
						<div class="form-group col-lg-4">
							<div class="form-group col-lg-6">
								<label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
								<input type="text" name="patient_id" class="form-control" placeholder="Add <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>" autofocus="autofocus" value="<?php echo set_value('patient_id') ?>" required="required" onchange="get_patient(this.value, true)">
							</div>
							<div class="form-group col-lg-6">
								<label for="exampleInputEmail1">Admission No</label>
								<input type="text" name="admission_no" class="form-control" id="admission_no">
							</div>
							<div class="form-group col-lg-12">
								<label for="exampleInputEmail1">Name</label>
								<input type="text" class="form-control name" id="patient-name" readonly="readonly">
							</div>
						</div>
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Date & Time</th>
									<th>Admission Orders</th>
<!--									<th>Nurse's Initials</th>-->
								</tr>
							</thead>
							<tbody id="add-admission-order">
								<tr>
									<td style="width: 15%">
										<input type="datetime-local" class="form-control" required="required" name="date_time[]">
									</td>
									<td style="width: 70%">
                                        <div class="row">
                                            <p class="col-md-3" style="padding-top: 10px;">
                                                ADMIT TO SERVICE OF:
                                            </p>
                                            <p class="col-md-9">
                                                <select name="doctor_id[]" class="form-control select2me">
                                                    <option value="">Select</option>
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
                                            </p>
                                        </div>
                                        <div class="row">

                                        </div>
                                        <div class="row">
                                            <p class="col-md-3" style="padding-top: 10px;">
                                                ADMITTING DIAGNOSIS:
                                            </p>
                                            <p class="col-md-9">
                                                <input type="text" class="form-control" name="diagnosis[]">
                                            </p>
                                        </div>
                                        <div class="row">
                                            <p class="col-md-3" style="padding-top: 10px;">
                                                CONDITION:
                                            </p>
                                            <p class="col-md-9">
                                                <select class="form-control" name="condition[]">
                                                    <option value="stable">Stable</option>
                                                    <option value="serious">Serious</option>
                                                    <option value="critical">Critical</option>
                                                </select>
                                            </p>
                                        </div>
                                        <div class="row">
                                            <p class="col-md-3" style="padding-top: 10px;">
                                                ACTIVITY:
                                            </p>
                                            <p class="col-md-9">
                                                <input type="text" class="form-control" name="activity[]">
                                            </p>
                                        </div>
                                        <div class="row">
                                            <p class="col-md-3" style="padding-top: 10px;">
                                                VITAL SIGNS:
                                            </p>
                                            <p class="col-md-9">
                                                <input type="text" class="form-control" name="vital_signs[]" id="vital-signs" readonly="readonly">
                                            </p>
                                        </div>
                                        <div class="row">
                                            <p class="col-md-3" style="padding-top: 10px;">
                                                DIET:
                                            </p>
                                            <p class="col-md-9">
                                                <input type="text" class="form-control" name="diet[]">
                                            </p>
                                        </div>
                                        <div class="row">
                                            <p class="col-md-3" style="padding-top: 10px;">
                                                INVESTIGATIONS:
                                            </p>
                                            <p class="col-md-9">
                                                <textarea class="form-control" name="investigations[]" rows="5"></textarea>
                                            </p>
                                        </div>
                                        <div class="row">
                                            <p class="col-md-3" style="padding-top: 10px;">
                                                MEDICATIONS:
                                            </p>
                                            <p class="col-md-9">
                                                <input type="text" class="form-control" name="medicine[]">
                                            </p>
                                        </div>
									</td>
									<td style="width: 15%; display: none">
										<input type="text" class="form-control" name="nurse_initials[]">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn blue">Submit</button>
<!--						<button type="button" class="btn purple" onclick="add_more_admission_orders()">Add More</button>-->
					</div>
				</form>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->
	</div>
</div>
<style>
	.table-bordered {
		border: 1px solid #000;
	}
	th, td {
		border: 1px solid #000000 !important;
		border-color: #000000 !important;
	}
</style>