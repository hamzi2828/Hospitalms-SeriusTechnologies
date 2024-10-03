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
                    <i class="fa fa-globe"></i> <?php echo $title ?>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Employee </th>
                        <th> Paid Loan </th>
                        <th> Date Added </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($loans) > 0) {
                        $counter = 1;
                        foreach ($loans as $loan) {
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo get_employee_by_id($loan -> employee_id) -> name ?></td>
                                <td><?php echo $loan -> paid ?></td>
                                <td>
                                    <?php echo date_setter($loan -> date_added); ?>
                                </td>
                                <td class="btn-group-xs">
                                    <?php if(get_user_access(get_logged_in_user_id()) and in_array('edit_paid_loan', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn blue" href="<?php echo base_url('/loan/edit_paid/'.$loan -> id) ?>">Edit</a>
                                    <?php endif; ?>
                                    <?php if(get_user_access(get_logged_in_user_id()) and in_array('delete_paid_loan', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn red" href="<?php echo base_url('/loan/delete_paid/'.$loan -> id) ?>" onclick="return confirm('Are you sure?')">Delete</a>
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