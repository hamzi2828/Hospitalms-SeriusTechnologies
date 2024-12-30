<!-- BEGIN PAGE CONTENT -->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET -->
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
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                        value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Product Name</label>
                            <input type="text" name="name" class="form-control"
                                placeholder="Add product name e.g Adderall" autofocus="autofocus"
                                value="<?php echo set_value ( 'name' ) ?>">
                        </div>
                        <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">Category</label>
                            <select class="form-control" name="category_id">
                                <option value="">Select Category</option>
                                <?php if(!empty($categories)) { foreach ($categories as $category) { ?>
                                    <option value="<?php echo $category -> id ?>"><?php echo $category -> name ?></option>
                                <?php } } ?>
                            </select>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">TP/Box</label>
                            <small>(Trade price of 1 box)</small>
                            <input type="text" name="tp_box" class="form-control tp-box" required="required"
                                value="<?php echo set_value ( 'tp_box' ) ?>" onchange="calculate_tp_unit_price()">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Pack Size</label>
                            <small>(Amount of Items per box)</small>
                            <input type="text" name="quantity" class="form-control quantity" required="required"
                                value="<?php echo set_value ( 'quantity' ) ?>" onchange="calculate_tp_unit_price()">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">TP/Unit</label>
                            <input type="text" name="tp_unit" class="form-control tp-unit" required="required"
                                value="<?php echo set_value ( 'tp_unit' ) ?>" readonly="readonly">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Sale/Box</label>
                            <input type="text" name="sale_box" class="form-control sale-box" required="required"
                                value="<?php echo set_value ( 'sale_box' ) ?>"
                                onchange="calculate_sale_unit_price()">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Sale/Unit</label>
                            <input type="text" name="sale_unit" class="form-control sale-unit" required="required"
                                value="<?php echo set_value ( 'sale_unit' ) ?>" readonly="readonly">
                        </div>
                    </div>


                        <form role="form" method="post" autocomplete="off">
                            <input id="csrf_token" type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                                value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                        
                            <div class="form-body" style="overflow: auto">
                                <div class="col-lg-12" style="padding: 0">
                                    <h3 class="sample-information"></h3>
                                    <div class="info" style="max-height: 500px; overflow: auto">
                                        
                                        <div class="form-group col-lg-12">
                                            <div class="col-md-6">
                                                <label>Ingredient</label>
                                                <select name="ingredient_id[]" class="form-control select2me">
                                                    <option value="">Select</option>
                                                    <?php
                                                    if (count($ingredients) > 0) :
                                                        foreach ($ingredients as $ingredient) :
                                                            ?>
                                                            <option value="<?php echo $ingredient->id; ?>">
                                                                <?php echo $ingredient->name; ?>
                                                            </option>
                                                            <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Usable Quantity (ML/Kit)</label>
                                                <input type="text" class="form-control" name="usable_quantity[]" value="">
                                            </div>
                                        </div>
                                        <div id="add-more"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <a href="javascript:void(0)" type="button" class="btn purple" style="display: inline"
                                onclick="add_more_ingredients()">Add More</a>

                            </div>
                        </form>
                
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="sales-btn">Submit</button>
                    </div>
                </form>

            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET -->
    </div>
</div>

