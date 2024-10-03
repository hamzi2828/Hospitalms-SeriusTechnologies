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
        <div class="col-sm-12 alert alert-danger">
            <i class="fa fa-exclamation-circle"></i>
            <strong> This information shall be forwarded to CEO and shall be kept confidential. </strong>
        </div>
        <div class="col-sm-12 alert alert-info">
            <i class="fa fa-exclamation-circle"></i> I solemnly providing correct information of which I shall be responsible. Strict actions shall be take against bogus complaints as per hospital disciplinary policy.
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Complaints
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_complains">
                    <div class="form-body" style="overflow: auto">
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="Add complaint subject" autofocus="autofocus" value="<?php echo set_value('subject') ?>" maxlength="100" required="required">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Priority</label>
                            <select name="priority" class="form-control select2me">
                                <option value="0">Normal</option>
                                <option value="1">Urgent</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Complaint</label>
                            <textarea name="complain" class="form-control" rows="5" placeholder="Type your complaint here..."><?php echo set_value('complain') ?></textarea>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Attachment# 1</label>
                            <input name="attachment[]" class="form-control"  type="file">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Attachment# 2</label>
                            <input name="attachment[]" class="form-control"  type="file">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Attachment# 3</label>
                            <input name="attachment[]" class="form-control"  type="file">
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