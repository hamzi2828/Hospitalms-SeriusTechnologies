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
                    <input type="hidden" name="action" value="do_add_loan">
                    <div class="form-body" style="overflow: auto">
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Employee</label>
                            <select name="employee_id" required="required" class="form-control select2me">
                                <option value="">Select</option>
                                <?php
                                if(count($employees) > 0) {
                                    foreach ($employees as $employee) {
                                        ?>
                                        <option value="<?php echo $employee -> id ?>"><?php echo $employee -> name ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Loan</label>
                            <input type="text" name="loan" class="form-control" required="required">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea name="description" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="patient-reg-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>