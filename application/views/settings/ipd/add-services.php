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
					<i class="fa fa-reorder"></i> Add Services
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" method="post" autocomplete="off">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
					<input type="hidden" name="action" value="do_add_ipd_services">
					<input type="hidden" id="added" value="1">
					<div class="form-body" style="overflow: auto">
						<div class="form-group col-lg-2">
							<label for="exampleInputEmail1">Code</label>
							<input type="text" name="code" class="form-control" placeholder="Add code" autofocus="autofocus" value="<?php echo set_value('code') ?>">
						</div>
						<div class="form-group col-lg-4">
							<label for="exampleInputEmail1">Title</label>
							<input type="text" name="title" class="form-control" placeholder="Add title" autofocus="autofocus" value="<?php echo set_value('title') ?>" required="required">
						</div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Parent Service</label>
                            <select name="parent_id" class="form-control select2me">
                                <option value="">Select</option>
								<?php echo $services ?>
                            </select>
                        </div>
                        <div class="col-lg-2" style="margin-top: 30px">
                            <input type="checkbox" name="add_in_opd" value="1" checked="checked">
                            <label> Add in OPD Services? </label>
                        </div>
                        <div class="col-lg-4">
                            <label> Service Type </label>
                            <select class="form-control select2me" name="service_type">
                                <option value=""></option>
                                <option value="xray">X-Ray</option>
                                <option value="ultrasound">Ultrasound</option>
                                <option value="ecg">ECG</option>
                                <option value="echo">Echo</option>
                                <option value="dialysis">Dialysis</option>
                                <option value="dentistry">Dentistry</option>
                            </select>
                        </div>
						<div class="form-group col-lg-2">
							<label for="exampleInputEmail1">Price</label>
							<input type="text" name="price" class="form-control" placeholder="Add price" value="<?php echo set_value('price') ?>">
						</div>
                        <div class="col-lg-2">
                            <label> Charges Per </label>
                            <select class="form-control select2me" name="charge">
                                <option value="">None</option>
                                <option value="day">Day</option>
                                <option value="hour">Hour</option>
                                <option value="minute">Minute</option>
                                <option value="visit">Visit</option>
                                <option value="no">No.</option>
                            </select>
                        </div>
                        <div class="col-lg-4" style="margin-top: 30px">
                            <input type="checkbox" name="requires_doctor" value="1">
                            <label> Check this box, when service requires a doctor. </label>
                        </div>
						<div class="form-group col-lg-12">
							<label for="exampleInputEmail1">Description</label>
                            <textarea rows="5" type="text" name="description" class="form-control" placeholder="Add description"><?php echo set_value('description') ?></textarea>
						</div>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn blue" id="sales-btn">Submit</button>
					</div>
				</form>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->
	</div>
</div>
