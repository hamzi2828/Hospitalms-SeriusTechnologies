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
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Medical Officer (MO) Orders
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Order ID </th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?> </th>
                        <th> Medicine(s) </th>
                        <th> Doctor </th>
                        <th> Date Added </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					if(count($orders) > 0) {
						$counter = 1;
						foreach ($orders as $order) {
							$patient    = get_patient($order -> patient_id);
							$record     = get_mo_order_record($order -> id);
							?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $order -> id ?></td>
                                <td><?php echo get_patient_name (0, $patient) ?></td>
                                <td>
                                    <?php
									if(count($record) > 0) {
										foreach ($record as $medicine) {
											echo $medicine -> medicine;
										}
									}
									?>
                                </td>
                                <td>
									<?php
									if(count($record) > 0) {
										foreach ($record as $doctor_id) {
										    if($doctor_id -> doctor_id > 0) {
												$doctor = get_doctor($doctor_id -> doctor_id);
												echo @$doctor -> name . '<br>';
											}
										}
									}
									?>
                                </td>
                                <td><?php echo date_setter($order -> date_added) ?></td>
                                <td class="btn-group-xs">
							<?php if(get_user_access(get_logged_in_user_id()) and in_array('print_mo_adm_order', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn-block btn purple" href="<?php echo base_url('/invoices/admission-order-invoice/'.$order -> id) ?>">Print</a>
							<?php endif; ?>
									<?php if(get_user_access(get_logged_in_user_id()) and in_array('edit_mo_adm_order', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn-block btn green" href="<?php echo base_url('/IPD/mo/edit-admission-order/'.$order -> id) ?>">Edit</a>
									<?php endif; ?>
									<?php if(get_user_access(get_logged_in_user_id()) and in_array('delete_mo_adm_order', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn-block btn red" href="<?php echo base_url('/IPD/mo/delete-mo-order/'.$order -> id) ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
									<?php endif; ?>
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