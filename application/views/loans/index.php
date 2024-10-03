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
                        <th> Loan History </th>
                        <th> Total Loan </th>
                        <th> Paid Loan </th>
                        <th> Balanced Loan </th>
                        <th> Date Added </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($loans) > 0) {
                        $counter = 1;
                        foreach ($loans as $loan) {
                            $paid_loan      = get_employee_paid_loan($loan -> employee_id);
                            $loans          = explode(',', $loan -> loans);
                            $ids            = explode(',', $loan -> ids);
                            $date_added     = explode(',', $loan -> date_added);
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo get_employee_by_id($loan -> employee_id) -> name ?></td>
                                <td>
                                    <?php
                                        foreach ($loans as $key => $value) {
                                            echo '<strong>' . $value . '</strong> on ' . date_setter($date_added[$key]);
                                            if(get_user_access(get_logged_in_user_id()) and in_array('edit_loan', explode(',', get_user_access(get_logged_in_user_id()) -> access))) :
                                            echo '<a style="display: inline-block;" class="btn btn-xs green" href="'.base_url('/loan/edit/'.$ids[$key]).'">Edit</a>';
                                            endif;
                                            if(get_user_access(get_logged_in_user_id()) and in_array('delete_loan', explode(',', get_user_access(get_logged_in_user_id()) -> access))) :
                                            echo '<a style="display: inline-block;" class="btn btn-xs red" href="'.base_url('/loan/delete/'.$ids[$key]).'" onclick="return confirm(\'Are you sure?\')">Delete</a>';
                                            endif;
                                            echo '<a style="display: inline-block;" class="btn btn-xs purple" href="'.base_url('/invoices/loan/'.$ids[$key]).'">Print</a>';
                                            echo '<br>';
                                        }
                                    ?>
                                </td>
                                <td><?php echo number_format($loan -> loan, 2) ?></td>
                                <td><?php echo number_format($paid_loan, 2) ?></td>
                                <td><?php echo number_format($loan -> loan-$paid_loan, 2) ?></td>
                                <td>
                                    <?php echo date_setter(end($date_added)); ?>
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