<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Cafe Category
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
                <form role="form" method="post" action="<?php echo isset($route) ? $route : ''; ?>" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="action" value="do_edit_category">
                    <input type="hidden" name="edit_id" value="<?php echo isset($category->id) ? $category->id : ''; ?>">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Category</label>
                            <input type="text" name="name" class="form-control" placeholder="Add Category" autofocus="autofocus" value="<?php echo isset($category->name) ? $category->name : set_value('name'); ?>">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>