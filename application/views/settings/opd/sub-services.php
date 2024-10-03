<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet box green">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-globe"></i> OPD Services
				</div>
			</div>
			<div class="portlet-body">
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
				<table class="table table-striped table-bordered table-hover" id="sample_1">
					<thead>
					<tr>
						<th> Sr. No </th>
						<th> CODE </th>
						<th> Title </th>
						<th> Price </th>
						<th> Date Added </th>
						<th> Actions</th>
					</tr>
					</thead>
					<tbody>
					<?php
					if(count($services) > 0) {
						$counter = 1;
						foreach ($services as $service) {
							?>
							<tr class="odd gradeX">
								<td> <?php echo $counter++ ?> </td>
								<td><?php echo $service -> code ?></td>
								<td><?php echo $service -> title ?></td>
								<td><?php echo $service -> price ?></td>
								<td><?php echo date_setter($service -> date_added) ?></td>
								<td class="btn-group-xs">
									<?php if(opd_services_has_children($service -> id)) : ?>
									<a type="button" class="btn blue" href="<?php echo base_url('/settings/sub-services/'.$service -> id.'?settings=opd') ?>">Sub Services</a>
									<?php endif; ?>
									<a type="button" class="btn blue" href="<?php echo base_url('/settings/edit-service/'.$service -> id.'?settings=opd') ?>">Edit</a>
									<a type="button" class="btn red" href="<?php echo base_url('/settings/delete-service/'.$service -> id.'?settings=opd') ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
								</td>
							</tr>
							<?php
						}
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<style>
	.input-xsmall {
		width: 100px !important;
	}
</style>