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
                    <i class="fa fa-globe"></i> Complaints
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Complaint By </th>
                        <th> Subject </th>
                        <th> Priority </th>
                        <th> Seen </th>
                        <th> Date Added </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($complains) > 0) {
                        $counter = 1;
                        foreach ($complains as $complain) {
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo get_user($complain -> user_id) -> name ?></td>
                                <td><?php echo $complain -> subject ?></td>
                                <td><?php echo $complain -> priority == '1' ? 'High Priority' : 'Normal' ?></td>
                                <td><?php echo ($complain -> seen == '1') ? 'Seen' : 'Pending <span class="badge badge-success">New</span>' ?></td>
                                <td>
                                    <?php echo date_setter($complain -> date_added); ?>
                                </td>
                                <td class="btn-group-xs">
                                    <?php if(get_user_access(get_logged_in_user_id()) and in_array('edit_complains', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                            <a type="button" class="btn blue" href="<?php echo base_url('/complaints/edit/'. $complain -> id) ?>">View/Edit</a>
                                    <?php endif; ?>
                                    <?php if(get_user_access(get_logged_in_user_id()) and in_array('delete_complains', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                            <a type="button" class="btn red" onclick="return confirm('Are you sure?')" href="<?php echo base_url('/complaints/delete/'. $complain -> id) ?>">Delete</a>
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