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

        <div class="search">
            <form method="get">
                <div class="col-lg-3 col-lg-offset-3">
                    <select name="month" class="form-control select2me">
                        <option value="">Select</option>
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <option value="<?php echo $i ?>" <?php if($i == date('m')) echo 'selected="selected"' ?>>
                                <?php echo date("F", mktime(0, 0, 0, $i, 1)) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <select name="year" class="form-control select2me">
                        <option value="">Select</option>
                        <?php for ($y = 2018; $y <= date('Y'); $y++) : ?>
                            <option value="<?php echo $y ?>" <?php if($y == date('Y')) echo 'selected="selected"' ?>>
                                <?php echo $y ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-lg-1">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>

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
                        <th> Salary ID </th>
                        <th> Total Employees </th>
                        <th> Month </th>
                        <th> Month Days </th>
                        <th> Paid Salary </th>
                        <th> Date Added </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($sheets) > 0) {
                        $counter = 1;
                        foreach ($sheets as $sheet) {
                            ?>
                            <tr>
                                <td> <?php echo $counter++ ?> </td>
                                <td> <?php echo $sheet -> salary_id ?> </td>
                                <td> <?php echo $sheet -> employees ?> </td>
                                <td> <?php echo date('M, Y', strtotime($sheet -> date_added)) ?> </td>
                                <td> <?php echo $sheet -> days ?> </td>
                                <td> <?php echo number_format($sheet -> net_salary, 2) ?> </td>
                                <td> <?php echo date_setter($sheet -> date_added) ?> </td>
                                <td class="btn-group-xs">
                                    <?php if(get_user_access(get_logged_in_user_id()) and in_array('edit_sheet', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn blue" href="<?php echo base_url('/hr/edit_sheet/'.$sheet -> salary_id) ?>">Edit</a>
                                    <?php endif; ?>
                                    <?php if(get_user_access(get_logged_in_user_id()) and in_array('delete_sheet', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn red" href="<?php echo base_url('/hr/delete_sheet/'.$sheet -> salary_id) ?>" onclick="return confirm('Are you sure?')">Delete</a>
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