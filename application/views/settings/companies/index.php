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
                    <i class="fa fa-globe"></i> Companies
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Name </th>
                        <th> Email </th>
                        <th> Address </th>
                        <th> Date Added </th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($companies) > 0) {
                        $counter = 1;
                        foreach ($companies as $company) {
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $company -> name ?></td>
                                <td><?php echo $company -> email ?></td>
                                <td><?php echo $company -> address ?></td>
                                <td><?php echo date_setter($company -> date_added) ?></td>
                                <td class="btn-group-xs">
							<?php if(get_user_access(get_logged_in_user_id()) and in_array('company_members', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                    <a type="button" class="btn purple" href="<?php echo base_url('/settings/company-members/'.$company -> id.'?settings=general') ?>">Members</a>
							<?php endif; ?>
                            <?php if(get_user_access(get_logged_in_user_id()) and in_array('edit_companies', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                    <a type="button" class="btn blue" href="<?php echo base_url('/settings/edit-company/'.$company -> id.'?settings=general') ?>">Edit</a>
							<?php endif; ?>
                            <?php if(get_user_access(get_logged_in_user_id()) and in_array('delete_companies', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                    <a type="button" class="btn red" href="<?php echo base_url('/settings/delete-company/'.$company -> id.'?settings=general') ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
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