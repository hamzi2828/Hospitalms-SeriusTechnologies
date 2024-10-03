<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
		<?php if (validation_errors() != false) { ?>
            <div class="alert alert-danger validation-errors">
				<?php echo validation_errors(); ?>
            </div>
		<?php } ?>
		<?php if ($this -> session -> flashdata('error')) : ?>
            <div class="alert alert-danger">
				<?php echo $this -> session -> flashdata('error') ?>
            </div>
		<?php endif; ?>
		<?php if ($this -> session -> flashdata('response')) : ?>
            <div class="alert alert-success">
				<?php echo $this -> session -> flashdata('response') ?>
            </div>
		<?php endif; ?>
        <div class="col-sm-12 alert alert-success">
            <i class="fa fa-exclamation-circle"></i>
            <strong> This information shall be forwarded to CEO and shall be kept confidential. </strong>
        </div>
        <div class="col-sm-12 alert alert-danger">
            <i class="fa fa-exclamation-circle"></i>
            <strong> I solemnly providing correct information of which I shall be responsible. Strict actions shall be take against bogus complaints as per hospital disciplinary policy. </strong>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Complaints
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name(); ?>" value="<?php echo $this -> security -> get_csrf_hash(); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_update_complain">
                    <input type="hidden" name="complain_id" value="<?php echo $complain -> id ?>">
                    <div class="form-body" style="overflow: auto">
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Subject</label>
                            <input type="text" class="form-control" readonly="readonly" value="<?php echo $complain -> subject ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Priority</label>
                            <select disabled="disabled" class="form-control select2me">
                                <option value="0" <?php echo $complain -> priority == '0' ? 'selected="selected"' : '' ?>>Normal</option>
                                <option value="1" <?php echo $complain -> priority == '1' ? 'selected="selected"' : '' ?>>Urgent</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Complaint</label>
                            <textarea  readonly="readonly" class="form-control" rows="5"><?php echo $complain -> complain ?></textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1" style="color: #FF0000;"> <strong>Remarks</strong> </label>
                            <textarea name="remarks" class="form-control" rows="5" placeholder="Type your remarks here..." required="required"><?php echo $complain -> remarks ?></textarea>
                        </div>
                        <?php
                            $counter = 1;
                            if(count($attachments) > 0) {
                                foreach ($attachments as $attachment) {
                                    ?>
                                    <div class="form-group col-lg-4">
                                        <label for="exampleInputEmail1">Attachment# <?php echo $counter++ ?></label>
                                        <input name="attachment[]" class="form-control" type="file">
                                        <a href="<?php echo $attachment -> attachment ?>"> 1 document attached </a>
                                    </div>
                        <?php
                                }
                            }
                        ?>
                        <?php
                            $documents  = 3 - count($attachments);
                            for ($document = 1; $document <= $documents; $document++) {
                                ?>
                                <div class="form-group col-lg-4">
                                    <label for="exampleInputEmail1">Attachment# <?php echo $document ?></label>
                                    <input name="attachment[]" class="form-control" type="file">
                                </div>
                        <?php
                            }
                        ?>
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