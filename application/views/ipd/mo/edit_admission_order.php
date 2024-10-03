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
					<i class="fa fa-reorder"></i> Edit Admission Order
				</div>
			</div>
			<div class="portlet-body form">
				<div class="alert alert-danger" id="patient-info" style="display: none"></div>
				<form role="form" method="post" autocomplete="off">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
					<input type="hidden" name="action" value="do_mo_edit_admission_orders">
					<input type="hidden" name="order_id" value="<?php echo $order -> id ?>">
					<input type="hidden" id="added" value="<?php echo count($orders) ?>">
					<div class="form-body" style="overflow:auto;">
						<div class="form-group col-lg-8">
							<label for="exampleInputEmail1">Drug Allergies</label>
							<input type="text" class="form-control" name="drug_allergies" value="<?php echo $order -> drug_allergies ?>">
						</div>
						<div class="form-group col-lg-4">
							<div class="form-group col-lg-6">
								<label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
								<input type="text" name="patient_id" class="form-control" placeholder="Add <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>" autofocus="autofocus" required="required" onchange="get_patient(this.value)" value="<?php echo $order -> patient_id; ?>" onchange="get_patient(this.value)">
							</div>
                            <div class="form-group col-lg-6">
                                <label for="exampleInputEmail1">Admission No</label>
                                <input type="text" name="admission_no" class="form-control" readonly="readonly" id="admission_no" value="<?php echo $order -> id ?>">
                            </div>
							<div class="form-group col-lg-12">
								<label for="exampleInputEmail1">Name</label>
								<input type="text" class="form-control name" id="patient-name" readonly="readonly" value="<?php echo get_patient($order -> patient_id) -> name ?>">
							</div>
						</div>
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Actions</th>
									<th>Date & Time</th>
									<th>Admission Orders</th>
								</tr>
							</thead>
							<tbody id="add-admission-order">
                            <?php
                            if(count($orders) > 0) {
								foreach ($orders as $order) {
									?>
                                    <tr>
                                        <td style="padding-top: 15px;">
                                            <a href="<?php echo base_url('/IPD/mo/delete-admission-order-order/?record_id='.$order -> id) ?>" style="color: #000000" onclick="return confirm('Are you sure to delete?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                        <td style="width: 15%">
                                            <input type="datetime-local" class="form-control" required="required" name="date_time[]" value="<?php echo date('Y-m-d\TH:i', strtotime($order -> order_date_time)) ?>">
                                        </td>
                                        <td style="width: 70%">
                                            <div class="row">
                                                <p class="col-md-3" style="padding-top: 10px;">
                                                    ADMIT TO SERVICE OF:
                                                </p>
                                                <p class="col-md-9">
                                                    <select name="doctor_id[]" class="form-control select2me">
                                                        <option value="<?php echo $order -> doctor_id ?>">
															<?php
															$doctor = get_doctor($order -> doctor_id);
															echo $doctor -> name
															?>
                                                        </option>
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
                                                    <input type="text" class="form-control" name="diagnosis[]" value="<?php echo $order -> diagnosis ?>">
                                                </p>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-3" style="padding-top: 10px;">
                                                    CONDITION:
                                                </p>
                                                <p class="col-md-9">
                                                    <select class="form-control" name="condition[]">
                                                        <option value="stable" <?php if($order -> condition == 'stable') echo 'selected="selected"' ?>>Stable</option>
                                                        <option value="serious" <?php if($order -> condition == 'serious') echo 'selected="selected"' ?>>Serious</option>
                                                        <option value="critical" <?php if($order -> condition == 'critical') echo 'selected="selected"' ?>>Critical</option>
                                                    </select>
                                                </p>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-3" style="padding-top: 10px;">
                                                    ACTIVITY:
                                                </p>
                                                <p class="col-md-9">
                                                    <input type="text" class="form-control" name="activity[]" value="<?php echo $order -> activity ?>">
                                                </p>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-3" style="padding-top: 10px;">
                                                    VITAL SIGNS:
                                                </p>
                                                <p class="col-md-9">
                                                    <input type="text" class="form-control" name="vital_signs[]" value="<?php echo $order -> vital_signs ?>">
                                                </p>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-3" style="padding-top: 10px;">
                                                    DIET:
                                                </p>
                                                <p class="col-md-9">
                                                    <input type="text" class="form-control" name="diet[]" value="<?php echo $order -> diet ?>">
                                                </p>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-3" style="padding-top: 10px;">
                                                    INVESTIGATIONS:
                                                </p>
                                                <p class="col-md-9">
                                                    <textarea class="form-control" name="investigations[]" rows="5"><?php echo $order -> investigation ?></textarea>
                                                </p>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-3" style="padding-top: 10px;">
                                                    MEDICATIONS:
                                                </p>
                                                <p class="col-md-9">
                                                    <input type="text" class="form-control" name="medicine[]" value="<?php echo $order -> medicine ?>">
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
									<?php
								}
							}
                            ?>
							</tbody>
						</table>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn blue">Update</button>
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