<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Color
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
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    <input type="hidden" name="action" value="do_edit_test_tube_colors">
                    <input type="hidden" name="color_id" value="<?php echo $color -> id ?>">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Color</label>
                            <input type="text" name="name" class="form-control" placeholder="Add Color" autofocus="autofocus" value="<?php echo $color -> name ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1" style="width: 100%;display: block;float: left;">Choose Color</label>
                            <input type='color' class="form-control" name='color' value='<?php echo $color -> color ?>' />
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