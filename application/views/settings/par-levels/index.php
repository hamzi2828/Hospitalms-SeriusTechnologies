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
                    <i class="fa fa-globe"></i> Par Levels
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Department </th>
                        <th> Item(s) </th>
                        <th> Par Level </th>
                        <th> Date Added </th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($levels) > 0) {
                        $counter = 1;
                        foreach ($levels as $level) {
                            $department = get_department($level -> department_id);
                            $items      = explode(',', $level -> items);
                            $par_levels = explode(',', $level -> par_levels);
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $department -> name ?></td>
                                <td>
                                    <?php
                                    if(count($items) > 0) {
                                        foreach ($items as $item) {
                                            $item_info = get_store($item);
                                            echo $item_info -> item . '<br>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(count($par_levels) > 0) {
                                        foreach ($par_levels as $par_level) {
                                            echo $par_level. '<br>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?php echo date_setter($level -> date_added) ?></td>
                                <td class="btn-group-xs">
							<?php if(get_user_access(get_logged_in_user_id()) and in_array('edit_par_levels', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                    <a type="button" class="btn blue" href="<?php echo base_url('/settings/edit-par-levels/'.$level -> department_id.'?settings=store-settings') ?>">Edit</a>
							<?php endif; ?>
                            <?php if(get_user_access(get_logged_in_user_id()) and in_array('delete_par_levels', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                    <a type="button" class="btn red" href="<?php echo base_url('/settings/delete-par-levels/'.$level -> department_id.'?settings=store-settings') ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
							<?php endif; ?>
                            <?php if(get_user_access(get_logged_in_user_id()) and in_array('print_par_levels', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                    <a type="button" class="btn purple" href="<?php echo base_url('/invoices/print-par-level/'.$level -> department_id) ?>">Print</a>
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