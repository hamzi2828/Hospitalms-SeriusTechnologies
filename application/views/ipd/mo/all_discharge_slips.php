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
                    <i class="fa fa-globe"></i> Discharge Slips
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Adm. No </th>
                        <th> Room/Bed No </th>
                        <th> Consultant </th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?> </th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?> </th>
                        <th> Admission Date </th>
                        <th> Discharge Date </th>
                        <th> Date Added </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					if(count($slips) > 0) {
						$counter = 1;
						foreach ($slips as $slip) {
							$patient    = get_patient($slip -> patient_id);
							$doctor     = get_doctor($slip -> doctor_id);
							?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $slip -> admission_no ?></td>
                                <td><?php echo $slip -> room_bed_no ?></td>
                                <td><?php echo $doctor -> name ?></td>
                                <td><?php echo $patient -> id ?></td>
                                <td><?php echo get_patient_name (0, $patient) ?></td>
                                <td><?php echo date('m-d-Y', strtotime($slip -> admission_date)) ?></td>
                                <td><?php echo date('m-d-Y', strtotime($slip -> discharge_date)) ?></td>
                                <td><?php echo date_setter($slip -> date_added) ?></td>
                                <td class="btn-group-xs">
									<?php if(get_user_access(get_logged_in_user_id()) and in_array('edit_blood_transfusion', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn-block btn green" href="<?php echo base_url('/IPD/mo/edit-discharge-slip/'.$slip -> id) ?>">Edit</a>
									<?php endif; ?>
									<?php if(get_user_access(get_logged_in_user_id()) and in_array('delete_blood_transfusion', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn-block btn red" href="<?php echo base_url('/IPD/mo/delete-discharge-slip/'.$slip -> id) ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
									<?php endif; ?>
									<?php if(get_user_access(get_logged_in_user_id()) and in_array('print_discharge_slip', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a class="btn-block btn purple" target="_blank" href="<?php echo base_url('/invoices/print-discharge-slip/?id='.$slip -> id) ?>">Print</a>
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