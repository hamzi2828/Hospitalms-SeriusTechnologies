<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN SAMPLE FORM PORTLET-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-reorder"></i> Add OPD Services
				</div>
			</div>
			<div class="portlet-body form">
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
				<form role="form" method="post" autocomplete="off">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
					<input type="hidden" name="action" value="do_add_opd_services">
					<div class="form-body" style="overflow: auto;">
						<div class="form-group col-lg-3">
							<label for="exampleInputEmail1">Parent Service</label>
							<select class="form-control select2me" name="parent_id">
								<option value="">Select</option>
								<?php
								if(count($services) > 0) {
									foreach ($services as $service) {
										?>
										<option value="<?php echo $service -> id ?>">
											<?php echo $service -> title ?>
										</option>
								<?php
									}
								}
								?>
							</select>
						</div>
						<div class="form-group col-lg-3">
							<label for="exampleInputEmail1">Code</label>
							<input type="text" name="code" class="form-control" placeholder="Add service code" value="<?php echo set_value('code') ?>" autofocus>
						</div>
						<div class="form-group col-lg-3">
							<label for="exampleInputEmail1">Title</label>
							<input type="text" name="title" class="form-control" placeholder="Add service title" value="<?php echo set_value('title') ?>">
						</div>
						<div class="form-group col-lg-3">
							<label for="exampleInputEmail1">Price</label>
							<input type="text" name="price" class="form-control" placeholder="Add service price" value="<?php echo set_value('price') ?>">
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