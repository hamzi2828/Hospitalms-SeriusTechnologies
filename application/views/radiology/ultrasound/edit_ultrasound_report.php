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
					<i class="fa fa-reorder"></i> Edit Ultrasound Report
				</div>
			</div>
			<div class="portlet-body form">
				<?php
					$report_type = @$_REQUEST['report_type'];
					if(isset($report_type) and !empty(trim($report_type)))
						require_once('edit_'.$report_type.'.php');
				?>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->
	</div>
</div>