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
					<i class="fa fa-reorder"></i> Edit OPD Services
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" method="post" autocomplete="off">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
					<input type="hidden" name="action" value="do_edit_opd_services">
					<input type="hidden" name="service_id" value="<?php echo @$service_info -> id ?>">
					<div class="form-body" style="overflow: auto;">
						<div class="form-group col-lg-4">
							<label for="exampleInputEmail1">Parent Service</label>
							<select class="form-control select2me" name="parent_id">
								<option value="">Select</option>
								<?php
								if(count($services) > 0) {
									foreach ($services as $service) {
										?>
										<option value="<?php echo $service -> id ?>" <?php if(@$service_info -> parent_id == $service -> id) echo 'selected="selected"' ?>>
											<?php echo $service -> title ?>
										</option>
								<?php
									}
								}
								?>
							</select>
						</div>
						<div class="form-group col-lg-4">
							<label for="exampleInputEmail1">Code</label>
							<input type="text" name="code" class="form-control" placeholder="Add service code" value="<?php echo @$service_info -> code ?>" autofocus="autofocus">
						</div>
						<div class="form-group col-lg-4">
							<label for="exampleInputEmail1">Title</label>
							<input type="text" name="title" class="form-control" placeholder="Add service title" value="<?php echo @$service_info -> title ?>">
						</div>
						<div class="form-group col-lg-6">
							<label for="exampleInputEmail1">Price</label>
							<input type="text" name="price" class="form-control" placeholder="Add service price" value="<?php echo @$service_info -> price ?>">
						</div>
                        <div class="form-group col-lg-6">
                            <label> Service Type </label>
                            <select class="form-control select2me" name="service_type">
                                <option value=""></option>
                                <option value="xray" <?php if(@$service_info -> service_type == 'xray') echo 'selected="selected"' ?>>X-Ray</option>
                                <option value="ultrasound" <?php if(@$service_info -> service_type == 'ultrasound') echo 'selected="selected"' ?>>Ultrasound</option>
                                <option value="ecg" <?php if(@$service_info -> service_type == 'ecg') echo 'selected="selected"' ?>>ECG</option>
                                <option value="echo" <?php if(@$service_info -> service_type == 'echo') echo 'selected="selected"' ?>>Echo</option>
                                <option value="dialysis" <?php if(@$service_info -> service_type == 'dialysis') echo 'selected="selected"' ?>>Dialysis</option>
                            </select>
                        </div>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn blue">Update</button>
					</div>
				</form>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->
	</div>
</div>