<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if (validation_errors() != false) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('response')) : ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('response') ?>
            </div>
        <?php endif; ?>
        
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Reference
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                           value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="action" value="do_edit_reference">
                    <input type="hidden" name="reference-id" value="<?php echo $reference->id ?>">
                    
                    <div class="form-body" style="overflow: auto">
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Add reference"
                                       autofocus="autofocus" value="<?php echo $reference->title ?>">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label>Discount in %</label>
                                <input type="text" name="discount_percent" class="form-control" placeholder="Add discount in %"
                                       value="<?php echo isset($reference->discount_percent) ? $reference->discount_percent : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn blue">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
