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
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> <?php echo $title ?>
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_paid_loan">
                    <input type="hidden" name="paid_id" value="<?php echo $paid -> id ?>">
                    <div class="form-body" style="overflow: auto">
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Employee</label>
                            <select name="employee_id" required="required" class="form-control select2me">
                                <option value="<?php echo $paid -> employee_id ?>"><?php echo get_employee_by_id($paid -> employee_id) -> name ?></option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Paid Loan</label>
                            <input type="text" name="loan" class="form-control" required="required" value="<?php echo $paid -> paid ?>">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea name="description" class="form-control" rows="5"><?php echo $paid -> description ?></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="patient-reg-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>