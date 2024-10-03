<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-xs-8">
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-circle"></i> Make sure you add only required number of rows. After adding stock to the rows, adding more rows is not allowed. By doing so, you will lose the entered stock.
        </div>
    </div>
    <div class="col-xs-4">
        <form method="get">
            <label for="stock">No. of Rows</label>
            <input type="number" name="rows" class="form-control" value="<?php echo @$_REQUEST['rows'] ? $_REQUEST['rows'] : 0 ?>">
            <button type="submit" class="btn btn-primary" style="position: absolute;top: 25px;right: 15px;"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="col-md-12">
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
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Medicine Stock
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_medicine_stock">
                    <div class="form-body">

                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Supplier</label>
                            <select name="supplier_id" class="form-control select2me" required="required" onchange="check_if_invoice_already_exists()" id="supplier_id">
                                <option value="">Select Supplier</option>
                                <?php
                                if(count($suppliers) > 0) {
                                    foreach ($suppliers as $supplier) {
                                        ?>
                                        <option value="<?php echo $supplier -> id ?>">
                                            <?php echo $supplier -> title ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">
                                Supplier Invoice
                                <small style="color: #ff0000">
                                    (Slashes (/,\ and space) are not allowed)
                                </small>
                            </label>
                            <input type="text" name="supplier_invoice" class="form-control"  required="required" id="invoice_number" onchange="check_if_invoice_already_exists()">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Date</label>
                            <input type="text" name="date_added" class="date date-picker form-control"   required="required" value="<?php echo date('m/d/Y') ?>">
                        </div>

                        <input type="hidden" id="added" value="<?php echo @$_REQUEST['rows'] ? $_REQUEST['rows'] : 1 ?>">

                        <?php
                        if(isset($_REQUEST['rows']) and !empty(trim($_REQUEST['rows'])) and $_REQUEST['rows'] > 0)
                            $rows = $_REQUEST['rows'];
                        else
                            $rows = 1;

                        for ($i = 1; $i <= $rows; $i++) :
                            ?>
                            <div class="stock-rows col-lg-12 stock-rows-<?php echo $i ?>">

                                <div class="form-group col-lg-4">
                                    <?php if($i > 1) : ?>
                                        <a href="javascript:void(0)" onclick="remove_row(<?php echo $i ?>)">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    <?php endif; ?>
                                    <span style="position: absolute;left: -10px;font-size: 16px;font-weight: 800;top: 30px;"><?php echo $i ?></span>
                                    <label for="exampleInputEmail1">Medicine</label>
                                    <select name="medicine_id[]" class="form-control select2me" required="required" id="medicine-id-<?php echo $i ?>" onchange="get_medicine(this.value, <?php echo $i ?>)">
                                        <option value="">Select Medicine</option>
                                        <?php
                                        if(count($medicines) > 0) {
                                            foreach ($medicines as $medicine) {
                                                ?>
                                                <option value="<?php echo $medicine -> id ?>">
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

                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Batch#</label>
                                    <input type="text" name="batch[]" class="form-control batch_number"  required="required">
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Expiry date</label>
                                    <input type="text" name="expiry_date[]" class="date date-picker form-control" placeholder="Expiry date" required="required">
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Box QTY.</label>
                                    <input type="number" name="box_qty[]" class="form-control" id="box-qty-<?php echo $i ?>" required="required" min="1" onchange="calculate_quantity(<?php echo $i ?>)">
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Pack Size</label>
                                    <input type="number" name="units[]" class="form-control" id="unit-<?php echo $i ?>" min="1"  onchange="calculate_quantity(<?php echo $i ?>)">
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Total Units</label>
                                    <input type="text" name="quantity[]" class="form-control" id="quantity-<?php echo $i ?>">
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="exampleInputEmail1">TP/Box</label>
                                    <input type="text" name="box_price[]" class="form-control" required="required" id="box-price-<?php echo $i ?>" onchange="calculate_per_unit_price(<?php echo $i ?>)">
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Total Amount</label>
                                    <input type="text" name="price[]" class="form-control total-price-<?php echo $i ?>" required="required">
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="exampleInputEmail1">Disc.(%)</label>
                                    <input type="text" name="discount[]" class="form-control discount-<?php echo $i ?> discounts" required="required" onchange="calculate_net_bill(<?php echo $i ?>)" >
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="exampleInputEmail1">S.Tax (%)</label>
                                    <input type="text" name="sales_tax[]" class="form-control s-tax-<?php echo $i ?>" required="required" onchange="calculate_net_bill(<?php echo $i ?>)" >
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="exampleInputEmail1">Net</label>
                                    <input type="text" name="net[]" class="form-control net-<?php echo $i ?> net-price" required="required">
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="exampleInputEmail1">Cost/Box</label>
                                    <input type="text" name="box_price_after_dis_tax[]" class="form-control cost-box-<?php echo $i ?>" required="required">
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="exampleInputEmail1">Cost/Unit</label>
                                    <input type="text" name="tp_unit[]" class="form-control" required="required" id="purchase-price-<?php echo $i ?>" onchange="calculate_total_price(<?php echo $i ?>)">
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="exampleInputEmail1">Sale/Box</label>
                                    <input type="text" name="sale_box[]" class="form-control sale-box-<?php echo $i ?>" required="required" onchange="calculate_sale_price(this.value, <?php echo $i ?>)">
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="exampleInputEmail1">Sale/Unit</label>
                                    <input type="text" name="sale_unit[]" class="form-control sale-unit-<?php echo $i ?>" required="required">
                                </div>
                            </div>
                        <?php endfor; ?>
                        <div class="add-stock-rows"></div>

                        <div class="row">
                            <div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
                                <strong>Disc. (%)</strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                                <input type="text" name="grand_total_discount" class="form-control grand_total_discount" onchange="calculate_grand_total_discount(this.value)" value="0">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
                                <strong>G.Total</strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                                <input type="text" name="grand_total" class="form-control grand_total" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions col-lg-12">
                        <button type="submit" class="btn blue" id="submit-btn">Submit</button>
                        <button class="btn purple" type="button" onclick="add_more_stock()">
                            Add More Stock
                        </button>
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
        overflow-x: hidden;
        /* float: left; */
        clear: both;
        overflow-y: hidden;
    }
    .stock-rows {
        display: block;
        width: 100%;
        float: left;
        background: #e3e3e3;
        padding: 10px 0;
    }
</style>