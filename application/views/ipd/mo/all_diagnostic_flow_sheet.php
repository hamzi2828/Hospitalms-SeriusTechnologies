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
                    <i class="fa fa-globe"></i> All Diagnostics
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?> </th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?> </th>
                        <th> Diagnosis/Tests </th>
                        <th> Test Date </th>
                        <th> Date Added </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					if(count($diagnostics) > 0) {
						$counter = 1;
						foreach ($diagnostics as $diagnostic) {
							$patient    = get_patient($diagnostic -> patient_id);
							$tests      = explode(',', $diagnostic -> tests);
							$test_dates = explode(',', $diagnostic -> test_date);
							?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $patient -> id ?></td>
                                <td><?php echo get_patient_name (0, $patient) ?></td>
                                <td>
                                    <?php
                                    if(count($tests) > 0) {
                                        foreach ($tests as $test_id) {
                                            echo get_test_by_id($test_id) -> name . '<br>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(count($test_dates) > 0) {
                                        foreach ($test_dates as $test_date) {
                                            echo date('m/d/Y', strtotime($test_date)) . '<br>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?php echo date_setter($diagnostic -> date_added) ?></td>
                                <td class="btn-group-xs">
									<?php if(get_user_access(get_logged_in_user_id()) and in_array('edit_diagnostic_flow_sheet', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn-block btn green" href="<?php echo base_url('/IPD/mo/edit-diagnostic-flow-sheet/'.$diagnostic -> patient_id) ?>">Edit</a>
									<?php endif; ?>
									<?php if(get_user_access(get_logged_in_user_id()) and in_array('delete_diagnostic_flow_sheet', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn-block btn red" href="<?php echo base_url('/IPD/mo/delete-diagnostic-flow-sheet/'.$diagnostic -> patient_id) ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
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