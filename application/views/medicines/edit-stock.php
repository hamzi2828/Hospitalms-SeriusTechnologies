<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Medicine Stock
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
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_update_medicine_stock">
                    <input type="hidden" name="stock_id" value="<?php echo $stock -> id ?>">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Medicine Name</label>
                            <select name="medicine_id" class="form-control select2me" onchange="get_medicine_detail(this.value)" required="required" id="medicine_id">
                                <option value="">Select Medicine</option>
                                <?php
                                if(count($medicines) > 0) {
                                    foreach ($medicines as $medicine) {
                                        ?>
                                        <option value="<?php echo $medicine -> id ?>" <?php if($stock -> medicine_id == $medicine -> id) echo 'selected' ?>>
                                            <?php echo $medicine -> name ?>
                                        </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Supplier</label>
                            <select name="supplier_id" class="form-control select2me" required="required">
                                <option value="">Select Supplier</option>
                                <?php
                                if(count($suppliers) > 0) {
                                    foreach ($suppliers as $supplier) {
                                        ?>
                                        <option value="<?php echo $supplier -> id ?>" <?php if($stock -> supplier_id == $supplier -> id) echo 'selected' ?>>
                                            <?php echo $supplier -> title ?>
                                        </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Batch Number</label>
                            <input type="text" name="batch" class="form-control" placeholder="Batch number"  required="required" onchange="validate_batch_number(this.value)" id="batch_number" value="<?php echo $stock -> batch ?>">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Expiry date</label>
                            <input type="text" name="expiry_date" class="date date-picker form-control" placeholder="Expiry date"  required="required" value="<?php echo date('m/d/Y', strtotime($stock -> expiry_date)) ?>">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Supplier Invoice</label>
                            <input type="text" name="supplier_invoice" class="form-control" placeholder="Supplier Invoice"  required="required" onchange="validate_invoice_number(this.value)" id="invoice_number" value="<?php echo $stock -> supplier_invoice ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Packs/Boxes</label>
                            <input type="number" name="packs" class="form-control" placeholder="Quantity of packs/boxes"  required="required" min="1" onchange="calculate_quantity(this.value)" value="<?php echo $stock -> packs ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Stripes</label>
                            <input type="text" name="stripes" class="form-control" placeholder="Will be calculated depending upon quantity" readonly="readonly" id="stripes" value="<?php echo $stock -> stripes ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Medicine Per Stripe</label>
                            <input type="text" name="medicines" class="form-control" readonly="readonly" id="medicine-per-strip" value="<?php echo $stock -> medicines ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Quantity</label>
                            <input type="text" name="quantity" class="form-control" placeholder="Will be calculated depending upon packs" readonly="readonly" id="quantity" value="<?php echo $stock -> quantity ?>">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Purchase Price/Pack</label>
                            <input type="text" name="purchase_price" class="form-control" placeholder="Purchase price per pack" required="required" value="<?php echo $stock -> purchase_price ?>" onchange="calculate_net_bill(this.value)" id="purchase_price">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Sale Price/Pack</label>
                            <input type="text" name="sale_price" class="form-control" placeholder="Sale price per pack" required="required" value="<?php echo $stock -> sale_price ?>">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Invoice Bill</label>
                            <input type="text" name="invoice_bill" class="form-control" placeholder="Bill to be paid to supplier" required="required" readonly="readonly" id="invoice-bill" value="<?php echo $stock -> invoice_bill ?>">
                        </div>
                    </div>
                    <div class="form-actions col-lg-12">
                        <button type="submit" class="btn blue" id="submit-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .form {
        width: 100%;
        display: block;
        overflow: auto;
    }
</style>