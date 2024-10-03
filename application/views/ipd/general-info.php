<div class="tab-pane <?php if(isset($current_tab) and $current_tab == 'ipd-general') echo 'active' ?>">
	<form role="form" method="post" autocomplete="off">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
		<input type="hidden" name="action" value="do_edit_patient">
		<input type="hidden" id="sale_id" name="sale_id" value="<?php echo $sale -> sale_id ?>">
		<div class="form-body" style="overflow:auto; overflow-x: hidden">
			<div class="row">
				<div class="form-group col-lg-2">
					<label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
					<input type="text" name="patient_id" class="form-control" placeholder="Add <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>" autofocus="autofocus" value="<?php echo $sale -> patient_id ?>" required="required" onchange="get_patient(this.value)" readonly="readonly">
				</div>
				<div class="form-group col-lg-4">
					<label for="exampleInputEmail1">Name</label>
					<input type="text" class="form-control name" id="patient-name" readonly="readonly" value="<?php echo get_patient($sale -> patient_id) -> name ?>">
				</div>
				<div class="form-group col-lg-4">
					<label for="exampleInputEmail1">CNIC</label>
					<input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly" value="<?php echo get_patient($sale -> patient_id) -> cnic ?>">
				</div>
				<div class="form-group col-lg-2">
					<label for="exampleInputEmail1">Admission No</label>
					<input type="text" class="form-control" readonly="readonly" value="<?php echo $_REQUEST['sale_id'] ?>">
				</div>
				<div class="form-group col-lg-12">
					<label for="exampleInputEmail1">Purpose</label>
					<textarea rows="5" class="form-control" name="purpose"><?php echo $sale -> purpose ?></textarea>
				</div>
			</div>
		</div>
		<div class="form-actions" style="margin-top: 0">
			<button type="submit" class="btn blue">Update</button>
		</div>
	</form>
</div>