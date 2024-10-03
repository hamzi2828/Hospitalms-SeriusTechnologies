<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Purchase Order
                </div>
            </div>
            <div class="portlet-body" style="overflow: auto;">
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
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_purchase_order">
                    <input type="hidden" name="order_id" value="<?php echo $order -> id ?>">

                    <div class="form-group col-lg-offset-3 col-lg-4">
                        <label for="exampleInputEmail1">Supplier</label>
                        <select name="supplier_id" class="form-control select2me" required="required">
                            <option value="">Select Supplier</option>
                            <?php
                            if(count($suppliers) > 0) {
                                foreach ($suppliers as $supplier) {
                                    ?>
                                    <option value="<?php echo $supplier -> id ?>" <?php if($order -> supplier_id == $supplier -> id) echo 'selected="selected"' ?>>
                                        <?php echo $supplier -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">Medicine</label>
                        <select name="medicine_id" class="form-control select2me" required="required">
                            <option value="">Select Medicine</option>
                            <?php
                            if(count($medicines) > 0) {
                                foreach ($medicines as $medicine) {
                                    ?>
                                    <option value="<?php echo $medicine -> id ?>" <?php if($order -> medicine_id == $medicine -> id) echo 'selected="selected"' ?>>
                                        <?php
                                        echo $medicine -> name . ' ' . get_strength($medicine -> strength_id) -> title . ' (' . get_form($medicine -> form_id) -> title.')';
                                        ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="exampleInputEmail1">Quantity/Boxes</label>
                        <input type="number" name="box_qty" class="form-control quantity-<?php echo $order ?>" placeholder="Box quantity" required="required" value="<?php echo $order -> box_qty ?>">
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">TP/Box</label>
                        <input type="number" name="tp[]" class="form-control" placeholder="TP" onkeyup="calculate_purchase_order_total(this.value, <?php echo $order ?>)" value="<?php echo $order -> tp ?>">
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">App Amount</label>
                        <input type="number" name="total[]" class="form-control total-<?php echo $order ?>" placeholder="Total" value="<?php echo $order -> total ?>">
                    </div>

                    <div class="form-actions col-lg-12">
                        <button type="submit" class="btn blue" id="submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>