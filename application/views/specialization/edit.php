<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Specializations
                </div>
            </div>
            <div class="portlet-body form">
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
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_specialization">
                    <input type="hidden" name="specialization_id" value="<?php echo $specialization -> id ?>">
                    <div class="form-body">
                        <div class="row" style="margin-bottom: 15px">
                            <div class="col-lg-12">
                                <input type="text" name="specialization" class="form-control" placeholder="Add Specialization" value="<?php echo $specialization -> title ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="sales-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>