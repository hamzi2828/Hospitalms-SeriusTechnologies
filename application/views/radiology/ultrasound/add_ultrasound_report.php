<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<form method="get">
			<div class="col-lg-6 col-lg-offset-3" style="margin-bottom: 15px">
				<select name="report_type" class="form-control select2me" required="required">
					<option value="">Select report</option>
					<option value="abdomen_pelvis_male" <?php if(@$_REQUEST['report_type'] == 'abdomen_pelvis_male') echo 'selected="selected"' ?>>
						Abdomen & Pelvis (Male)
					</option>
					<option value="abdomen_pelvis_female" <?php if(@$_REQUEST['report_type'] == 'abdomen_pelvis_female') echo 'selected="selected"' ?>>
						Abdomen & Pelvis (Female)
					</option>
				</select>
			</div>
			<div class="col-lg-1" style="margin-bottom: 15px">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
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
					<i class="fa fa-reorder"></i> Add Ultrasound Report
				</div>
			</div>
			<div class="portlet-body form">
				<?php
					$report_type = @$_REQUEST['report_type'];
					if(isset($report_type) and !empty(trim($report_type)))
						require_once($report_type.'.php');
				?>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->
	</div>
</div>