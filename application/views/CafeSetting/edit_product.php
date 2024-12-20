<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Product
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
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    <input type="hidden" name="action" value="do_edit_product">
                    <input type="hidden" name="edit_id" value="<?php echo $product -> id ?>">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Product Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Edit Product Name" autofocus="autofocus" value="<?php echo set_value('name', $product -> name) ?>">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Product Price</label>
                            <input type="number" name="price" class="form-control" placeholder="Edit Product Price" autofocus="autofocus" value="<?php echo set_value('price', $product -> price) ?>">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Category</label>
                            <select class="form-control" name="category_id">
                                <option value="">Select Category</option>
                                <?php if(!empty($categories)) { foreach ($categories as $category) { ?>
                                    <option value="<?php echo $category -> id ?>" <?php if($category -> id == $product -> category_id) { echo "selected"; } ?>><?php echo $category -> name ?></option>
                                <?php } } ?>
                            </select>
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