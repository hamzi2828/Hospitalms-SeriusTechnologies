<?php
if(!empty($report))
    $patient = get_patient($report -> patient_id);
else
    $patient = '';
?>
<form role="form" method="post" autocomplete="off">
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
	<input type="hidden" name="action" value="do_edit_abdomen_pelvis_female">
	<input type="hidden" name="report_id" value="<?php echo @$report -> id ?>">
	<div class="form-body" style="overflow:auto;">
		<div class="form-group col-lg-2">
			<label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
			<input type="text" name="patient_id" class="form-control" placeholder="EMR#" autofocus="autofocus" value="<?php echo @$report -> patient_id ?>" readonly="readonly">
		</div>
		<div class="form-group col-lg-2">
			<label for="exampleInputEmail1">Name</label>
			<input type="text" class="form-control name" id="patient-name" readonly="readonly" value="<?php echo !empty($patient) ? get_patient_name (0, $patient) : '' ?>">
		</div>
		<div class="form-group col-lg-2">
			<label for="exampleInputEmail1">CNIC</label>
			<input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly" value="<?php echo !empty($patient) ? $patient -> cnic : '' ?>">
		</div>
		<div class="form-group col-lg-3">
			<label for="exampleInputEmail1">Referred By</label>
			<select name="referred_by" class="form-control select2me" required="required">
				<option value="">Select</option>
				<?php
				if(count($doctors) > 0) {
					foreach ($doctors as $doctor) {
						?>
						<option value="<?php echo $doctor -> id ?>" <?php if($doctor -> id == @$report -> referred_by) echo 'selected="selected"' ?>>
							<?php echo $doctor -> name ?>
						</option>
						<?php
					}
				}
				?>
			</select>
		</div>
		<div class="form-group col-lg-3">
			<label for="exampleInputEmail1">Referred To</label>
			<select name="doctor_id" class="form-control select2me" required="required">
				<option value="">Select</option>
				<?php
				if(count($doctors) > 0) {
					foreach ($doctors as $doctor) {
						?>
						<option value="<?php echo $doctor -> id ?>" <?php if($doctor -> id == @$report -> doctor_id) echo 'selected="selected"' ?>>
							<?php echo $doctor -> name ?>
						</option>
						<?php
					}
				}
				?>
			</select>
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">LIVER</label>
			<textarea rows="5" class="form-control" name="liver" required="required"><?php echo @$report -> liver ?></textarea>
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">PORTA HEPATIS</label>
			<textarea rows="5" class="form-control" name="porta_hepatis" required="required"><?php echo @$report -> porta_hepatis ?></textarea>
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">GALL BLADDER</label>
			<textarea rows="5" class="form-control" name="gall_bladder" required="required"><?php echo @$report -> gall_bladder ?></textarea>
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">PANCREAS</label>
			<textarea rows="5" class="form-control" name="pancreas" required="required"><?php echo @$report -> pancreas ?></textarea>
		</div>
		<div class="form-group col-lg-12">
			<label for="exampleInputEmail1">SPLEEN</label>
			<textarea rows="5" class="form-control" name="spleen" required="required"><?php echo @$report -> spleen ?></textarea>
		</div>
		<div class="col-lg-12">
			<table width="100" class="table table-bordered">
				<thead>
					<tr>
						<th></th>
						<th>Bipolar length</th>
						<th>Parenchymal thickness</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Right Kidney</td>
						<td>
                            <input type="text" name="right_bipolar_length" class="form-control" value="<?php echo @$kidney_reports -> right_bipolar_length ?>" required="required">
                        </td>
						<td>
                            <input type="text" name="right_parenchmal_thickness" class="form-control" value="<?php echo @$kidney_reports -> right_parenchmal_thickness ?>" required="required">
                        </td>
					</tr>
					<tr>
						<td>Left Kidney</td>
						<td><input type="text" name="left_bipolar_length" class="form-control" value="<?php echo @$kidney_reports -> left_bipolar_length ?>" required="required"></td>
						<td><input type="text" name="left_parenchmal_thickness" class="form-control" value="<?php echo @$kidney_reports -> left_parenchmal_thickness ?>" required="required"></td>
					</tr>
					<tr>
						<td>Description</td>
						<td colspan="2">
							<textarea name="description" class="form-control" required="required"><?php echo @$kidney_reports -> description ?></textarea>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">URINARY BLADDER</label>
			<textarea rows="5" class="form-control" name="urinary_bladder" required="required"><?php echo @$report -> urinary_bladder ?></textarea>
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">UTERUS</label>
			<textarea rows="5" class="form-control" name="uterus" required="required"><?php echo @$report -> uterus ?></textarea>
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">OVARIES</label>
			<textarea rows="5" class="form-control" name="ovaris" required="required"><?php echo @$report -> ovaris ?></textarea>
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">GENERAL SURVEY</label>
			<textarea rows="5" class="form-control" name="general_survey" required="required"><?php echo @$report -> general_survey ?></textarea>
		</div>
		<div class="form-group col-lg-12">
			<label for="exampleInputEmail1">CONCLUSION</label>
			<textarea rows="5" class="form-control" name="conclusion" required="required"><?php echo @$report -> conclusion ?></textarea>
		</div>
	</div>
	<div class="form-actions">
		<button type="submit" class="btn blue">Update</button>
		<a href="<?php echo base_url('/invoices/abdomen_pelvis_female_report?report_id='.@$report -> id) ?>" class="btn purple" target="_blank">Print</a>
	</div>
</form>