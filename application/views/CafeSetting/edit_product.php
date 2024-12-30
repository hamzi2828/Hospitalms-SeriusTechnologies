<!-- BEGIN PAGE CONTENT -->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET -->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Product
                </div>
            </div>
            <div class="portlet-body form">
                <!-- Display Validation Errors -->
                <?php if (validation_errors()) { ?>
                    <div class="alert alert-danger validation-errors">
                        <?php echo validation_errors(); ?>
                    </div>
                <?php } ?>
                
                <!-- Display Flash Messages -->
                <?php if ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('response')) : ?>
                    <div class="alert alert-success">
                        <?php echo $this->session->flashdata('response'); ?>
                    </div>
                <?php endif; ?>

                <!-- Begin Form -->
                <form role="form" method="post" action="<?php echo isset($route) ? $route : ''; ?>" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" 
                           value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="edit_id" value="<?php echo isset($product->id) ? $product->id : ''; ?>">

                    <div class="form-body" style="overflow:auto;">
                        <!-- Medicine Name -->
                        <div class="form-group col-lg-3">
                            <label for="medicineName">Medicine Name</label>
                            <input type="text" name="name" id="medicineName" class="form-control" 
                                   placeholder="Add medicine name e.g Adderall" autofocus="autofocus" 
                                   value="<?php echo isset($product->name) ? $product->name : set_value('name'); ?>">
                        </div>

                        <!-- Category -->
                        <div class="form-group col-lg-3">
                            <label for="category">Category</label>
                            <select class="form-control" name="category_id" id="category">
                                <option value="">Select Category</option>
                                <?php if (!empty($categories)) {
                                    foreach ($categories as $category) { ?>
                                        <option value="<?php echo $category->id; ?>" 
                                                <?php echo isset($product->category_id) && $product->category_id == $category->id ? 'selected' : ''; ?>>
                                            <?php echo $category->name; ?>
                                        </option>
                                <?php }
                                } ?>
                            </select>
                        </div>

                        <!-- TP/Box -->
                        <div class="form-group col-lg-3">
                            <label for="tpBox">TP/Box</label>
                            <small>(Trade price of 1 box)</small>
                            <input type="text" name="tp_box" id="tpBox" class="form-control tp-box" required="required"
                                   value="<?php echo isset($product->tp_box) ? $product->tp_box : set_value('tp_box'); ?>" 
                                   onchange="calculate_tp_unit_price()">
                        </div>

                        <!-- Pack Size -->
                        <div class="form-group col-lg-3">
                            <label for="quantity">Pack Size</label>
                            <small>(Amount of drugs per box)</small>
                            <input type="text" name="quantity" id="quantity" class="form-control quantity" required="required"
                                   value="<?php echo isset($product->quantity) ? $product->quantity : set_value('quantity'); ?>" 
                                   onchange="calculate_tp_unit_price()">
                        </div>

                        <!-- TP/Unit -->
                        <div class="form-group col-lg-3">
                            <label for="tpUnit">TP/Unit</label>
                            <input type="text" name="tp_unit" id="tpUnit" class="form-control tp-unit" required="required"
                                   value="<?php echo isset($product->tp_unit) ? $product->tp_unit : set_value('tp_unit'); ?>" readonly="readonly">
                        </div>

                        <!-- Sale/Box -->
                        <div class="form-group col-lg-3">
                            <label for="saleBox">Sale/Box</label>
                            <input type="text" name="sale_box" id="saleBox" class="form-control sale-box" required="required"
                                   value="<?php echo isset($product->sale_box) ? $product->sale_box : set_value('sale_box'); ?>" 
                                   onchange="calculate_sale_unit_price()">
                        </div>

                        <!-- Sale/Unit -->
                        <div class="form-group col-lg-3">
                            <label for="saleUnit">Sale/Unit</label>
                            <input type="text" name="sale_unit" id="saleUnit" class="form-control sale-unit" required="required"
                                   value="<?php echo isset($product->sale_unit) ? $product->sale_unit : set_value('sale_unit'); ?>" readonly="readonly">
                        </div>
                    </div>



                    <form role="form" method="post" autocomplete="off">
                            <input id="csrf_token" type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                                value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                        
                          
                        <!-- Ingredients Section -->
                        <div class="form-body" style="overflow: auto">
                            <div class="col-lg-12" style="padding: 0">
                                <h3 class="sample-information">Ingredients</h3>
                                <div class="info" style="max-height: 500px; overflow: auto">
                                    <?php if (isset($product_ingredients) && count($product_ingredients) > 0) {
                                        foreach ($product_ingredients as $index => $product_ingredient) { ?>
                                            <div class="form-group col-lg-12 ingredient-row">
                                                <div class="col-md-6">
                                                    <label for="ingredient_<?php echo $index; ?>">Ingredient</label>
                                                    <select name="ingredient_id[]" id="ingredient_<?php echo $index; ?>" class="form-control select2me">
                                                        <option value="">Select</option>
                                                        <?php if (isset($ingredients) && count($ingredients) > 0) {
                                                            foreach ($ingredients as $ingredient) { ?>
                                                                <option value="<?php echo $ingredient->id; ?>" 
                                                                        <?php echo $product_ingredient->ingredient_id == $ingredient->id ? 'selected' : ''; ?>>
                                                                    <?php echo $ingredient->name; ?>
                                                                </option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="usableQuantity_<?php echo $index; ?>">Usable Quantity (ML/Kit)</label>
                                                    <input type="text" id="usableQuantity_<?php echo $index; ?>" class="form-control" 
                                                        name="usable_quantity[]" value="<?php echo $product_ingredient->price; ?>">
                                                </div>
                                            </div>
                                    <?php }
                                    } else { ?>
                                        <div class="form-group col-lg-12 ingredient-row">
                                            <div class="col-md-6">
                                                <label for="ingredient_new">Ingredient</label>
                                                <select name="ingredient_id[]" id="ingredient_new" class="form-control select2me">
                                                    <option value="">Select</option>
                                                    <?php if (isset($ingredients) && count($ingredients) > 0) {
                                                        foreach ($ingredients as $ingredient) { ?>
                                                            <option value="<?php echo $ingredient->id; ?>"><?php echo $ingredient->name; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="usableQuantity_new">Usable Quantity (ML/Kit)</label>
                                                <input type="text" id="usableQuantity_new" class="form-control" name="usable_quantity[]" value="">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div id="add-more"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Add More Ingredients Button -->
                        <div class="form-actions">
                            <button type="button" class="btn purple" onclick="add_more_ingredients()">Add More</button>
                        </div>
                        </form>

                    <!-- Submit -->
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="sales-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET -->
    </div>
</div>
