<form role="form" method="post" autocomplete="off">
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
	<input type="hidden" name="action" value="do_add_abdomen_pelvis_female">
	<div class="form-body" style="overflow:auto;">
		<div class="form-group col-lg-2">
			<label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
			<input type="text" name="patient_id" class="form-control" placeholder="EMR#" autofocus="autofocus" value="<?php echo set_value('patient_id') ?>" required="required" onchange="get_patient(this.value)">
		</div>
		<div class="form-group col-lg-2">
			<label for="exampleInputEmail1">Name</label>
			<input type="text" class="form-control name" id="patient-name" readonly="readonly">
		</div>
		<div class="form-group col-lg-2">
			<label for="exampleInputEmail1">CNIC</label>
			<input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly">
		</div>
		<div class="form-group col-lg-3">
			<label for="exampleInputEmail1">Referred By</label>
			<select name="referred_by" class="form-control select2me" required="required">
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
		</div>
		<div class="form-group col-lg-3">
			<label for="exampleInputEmail1">Referred To</label>
			<select name="doctor_id" class="form-control select2me" required="required">
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
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">LIVER</label>
			<textarea rows="5" class="form-control" name="liver" required="required">Liver is normal in size & contours are smooth. Parenchymal echotexture is homogenous. Echogenicity is normal. No focal lesion seen. No Intra/extrahepatic cholestasis seen. </textarea>
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">PORTA HEPATIS</label>
			<textarea rows="5" class="form-control" name="porta_hepatis" required="required">Portal vein is normal in diameter measuring mm (Normal < 13 mm). There is no evidence of lymphadenopathy / mass at porta hepatis. CBD is normal in caliber.</textarea>
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">GALL BLADDER</label>
			<textarea rows="5" class="form-control" name="gall_bladder" required="required">Gall bladder is well distended. There is no evidence of biliary mass or peri cholecystic fluid. No calculus seen.</textarea>
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">PANCREAS</label>
			<textarea rows="5" class="form-control" name="pancreas" required="required">Normal in size, shape and texture.  </textarea>
		</div>
		<div class="form-group col-lg-12">
			<label for="exampleInputEmail1">SPLEEN</label>
			<textarea rows="5" class="form-control" name="spleen" required="required">Normal in size measuring  cm (Normal ≤ 13 cm). No focal lesion seen.</textarea>
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
						<td><input type="text" name="right_bipolar_length" class="form-control" value="10.8 cm" required="required"></td>
						<td><input type="text" name="right_parenchmal_thickness" class="form-control" value="1.3	 cm" required="required"></td>
					</tr>
					<tr>
						<td>Left Kidney</td>
						<td><input type="text" name="left_bipolar_length" class="form-control" value="8.1 cm" required="required"></td>
						<td><input type="text" name="left_parenchmal_thickness" class="form-control" value="1.5 cm" required="required"></td>
					</tr>
					<tr>
						<td>Description</td>
						<td colspan="2">
							<textarea name="description" class="form-control" required="required">Both kidneys are normal in size, shape and position.No renal parenchymal pathology seen.Normal cortical thickness and corticomedullary differentiation.No stone or hydronephrosis seen.No renal or adrenal mass is seen.</textarea>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">URINARY BLADDER</label>
			<textarea rows="5" class="form-control" name="urinary_bladder" required="required">Urinary bladder is empty. Normal walls. No evidence of calculus or mass seen.</textarea>
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">UTERUS</label>
			<textarea rows="5" class="form-control" name="uterus" required="required">Uterus is normal in size and anteverted in position. It measures  cm.Endometrial lining is intact and measures mm.No intra uterine mass is seen.No fluid, gestational sac or RPOCs are seen in uterine cavity.</textarea>
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">OVARIES</label>
			<textarea rows="5" class="form-control" name="ovaris" required="required">Both ovaries are normal in size & stromal echotexture.No ovarian cyst or mass noted.</textarea>
		</div>
		<div class="form-group col-lg-6">
			<label for="exampleInputEmail1">GENERAL SURVEY</label>
			<textarea rows="5" class="form-control" name="general_survey" required="required">There is no evidence of para aortic lymphadenopathy or free intra abdominal fluid. No pleural effusion seen. </textarea>
		</div>
		<div class="form-group col-lg-12">
			<label for="exampleInputEmail1">CONCLUSION</label>
			<textarea rows="5" class="form-control" name="conclusion" required="required">Normal USG Abdomen and Pelvis.</textarea>
		</div>
	</div>
	<div class="form-actions">
		<button type="submit" class="btn blue">Submit</button>
	</div>
</form>