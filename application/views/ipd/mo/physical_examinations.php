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
                    <i class="fa fa-globe"></i> History - Physical Examinations
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Examination Date </th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?> </th>
                        <th> Attending Physician </th>
                        <th> Admission No </th>
                        <th> Room/Bed No. </th>
                        <th> Date Added </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					if(count($examinations) > 0) {
						$counter = 1;
						foreach ($examinations as $examination) {
							$patient    = get_patient($examination -> patient_id);
							$doctor     = get_doctor($examination -> doctor_id);
							?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo date('m-d-Y', strtotime($examination -> examination_date)) ?></td>
                                <td><?php echo get_patient_name (0, $patient) ?></td>
                                <td><?php echo $doctor -> name ?></td>
                                <td><?php echo $examination -> admission_no ?></td>
                                <td><?php echo $examination -> room_bed_no ?></td>
                                <td><?php echo date_setter($examination -> date_added) ?></td>
                                <td class="btn-group-xs">
									<?php if(get_user_access(get_logged_in_user_id()) and in_array('edit_physical_examination', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn-block btn green" href="<?php echo base_url('/IPD/mo/edit-physical-examination/'.$examination -> id) ?>">Edit</a>
									<?php endif; ?>
									<?php if(get_user_access(get_logged_in_user_id()) and in_array('delete_physical_examination', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn-block btn red" href="<?php echo base_url('/IPD/mo/delete-physical-examination/'.$examination -> id) ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
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