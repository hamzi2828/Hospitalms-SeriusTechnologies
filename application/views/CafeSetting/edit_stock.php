<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if ( validation_errors () != false ) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors (); ?>
            </div>
        <?php } ?>
        <?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata ( 'error' ) ?>
            </div>
        <?php endif; ?>
        <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
        <?php endif; ?>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Cafe Stock
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_update_store_stock_for_cafe">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body">
                        
                        <div class="row">
                            <div style="display: flex; width: 100%; border-bottom: 1px solid #d5d5d5; float: left; margin-bottom: 15px;">
                            <div class="form-group col-lg-4">
                            <label for="supplier_id">Supplier</label>
                            <select name="supplier_id" class="form-control select2me" id="supplier_id" 
                                    data-placeholder="Select" required="required" disabled> 
                                <option></option>
                                <optgroup label="Cafe Suppliers">
                                    <?php 
                                    foreach ($Cafe_Suppliers as $supplier) { 
                                        $selected = ($supplier->id == $stock[0]->supplier_id) ? 'selected' : ''; 
                                        echo '<option value="' . $supplier->id . '" ' . $selected . '>' . $supplier->title . '</option>';
                                    } 
                                    ?>
                                </optgroup>
                            </select>
                        </div>
                                <div class="form-group col-lg-4">
                                <label for="Invoice">Supplier Invoice</label>
                                <input type="text" name="invoice" class="form-control invoice" id="Invoice" 
                                    value="<?php echo $stock[0]->invoice; ?>" 
                                    onchange="validate_store_stock_invoice_number(this.value)" 
                                    required="required" readonly> 
                            </div>
                            <div class="form-group col-lg-4">
                <label for="Date">Date</label>
                <input type="text" name="date_added" class="date date-picker form-control" id="Date"
                    value="<?php echo date('m/d/Y', strtotime($stock[0]->date_added)); ?>"> 
            </div>
                        </div>
                        </div>
                        
                    
                        <div class="row" style="min-height: 300px">

                       
                        <div class="col-md-2">
                            <!-- <select name="store_id[]" id="store-items-add-stock-dropdown" data-placeholder="Select"
                                    class="form-control select2me"
                                    onchange="load_store_item_for_cafe(this.value)">
                                <option></option>
                                <?php
                                    if (count($products) > 0) {
                                        foreach ($products as $store) {
                                            ?>
                                            <option value="<?php echo $store->id ?>"
                                                    class="option-<?php echo $store->id ?>">
                                                <?php echo $store->name ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select> -->
                        </div>
                        <div class="col-md-10">
                            <div class="add-more-store-stock">
                                <?php
                                    if (count($stock) > 0) {
                                        $row = 1;
                                        foreach ($stock as $product) {
                                            ?>
                                            <div class="row row-<?php echo $row ?>" style="display: block; float: left; width: 100%; background: #f5f5f5; padding: 10px 0 15px 0; margin-bottom: 15px; position: relative">
                                                <input type="hidden" name="stock_id[]" value="<?php echo $product->id ?>">

                                                <div class="form-group col-lg-6">
                                                    <span style="position: absolute;left: -10px;font-size: 16px;font-weight: 800;top: 30px;"><?php echo $row ?></span>
                                                    <a href="javascript:void(0)" onclick="_remove_store_stock_row(<?php echo $row ?>)"
                                                    style="position: absolute;left: 3px;top: 33px; z-index: 999">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>

                                                    <?php  $item = get_product_by_id($product->product_id);  ?>
                                                    <label for="exampleInputEmail1">Item</label>
                                                    <input type="text" readonly="readonly" class="form-control" value="<?php  echo @$item->name ?? 'Unknown Item' ?>">
                                                </div>

                                                <div class="form-group col-lg-3">
                                                    <label for="exampleInputEmail1">Stock.No</label>
                                                    <input type="text" name="stock_no[]" class="form-control" readonly="readonly"
                                                        value="<?php echo $product->stock_no ?>">
                                                </div>

                                                <div class="form-group col-lg-3">
                                                    <label for="exampleInputEmail1">Expiry Date</label>
                                                    <input type="text" name="expiry[]" class="date date-picker form-control"
                                                        value="<?php echo $product->expiry ?>">
                                                </div>

                                                <div class="form-group col-lg-3">
                                                    <label for="exampleInputEmail1">Quantity (Units)</label>
                                                    <input type="text" name="quantity[]" class="form-control quantity-<?php echo $row ?>"
                                                        onchange="calculate_store_cafe_stock_net_price(<?php echo $row ?>)"
                                                        value="<?php echo $product->quantity ?>">
                                                </div>

                                                <div class="form-group col-lg-3">
                                                    <label for="exampleInputEmail1">TP/Box</label>
                                                    <input type="text" name="tp_box[]" class="form-control tp-box-<?php echo $row ?>"
                                                        onchange="calculate_tp_unit_price(<?php echo $row ?>)"
                                                        value="<?php echo $product->tp_box ?>">
                                                </div>

                                                <div class="form-group col-lg-3">
                                                    <label for="exampleInputEmail1">Pack Size</label>
                                                    <input type="text" name="pack_size[]" class="form-control pack-size-<?php echo $row ?>"
                                                        onchange="calculate_tp_unit_price(<?php echo $row ?>)"
                                                        value="<?php echo $product->pack_size ?>">
                                                </div>

                                                <div class="form-group col-lg-3">
                                                    <label for="exampleInputEmail1">TP/Unit</label>
                                                    <input type="text" name="tp_unit[]" class="form-control tp-unit-<?php echo $row ?>"
                                                        onchange="calculate_store_cafe_stock_net_price(<?php echo $row ?>)"
                                                        value="<?php echo $product->tp_unit ?>" readonly="readonly">
                                                </div>

                                                <div class="form-group col-lg-3">
                                                    <label for="exampleInputEmail1">Sale/Box</label>
                                                    <input type="text" name="sale_box[]" class="form-control sale-box-<?php echo $row ?>"
                                                        onchange="calculate_sale_unit_price(<?php echo $row ?>)"
                                                        value="<?php echo $product->sale_box ?>">
                                                </div>

                                                <div class="form-group col-lg-3">
                                                    <label for="exampleInputEmail1">Sale/Unit</label>
                                                    <input type="text" name="sale_unit[]" class="form-control sale-unit-<?php echo $row ?>"
                                                        value="<?php echo $product->sale_unit ?>" readonly="readonly">
                                                </div>

                                                <div class="form-group col-lg-3">
                                                    <label for="exampleInputEmail1">Discount (Flat)</label>
                                                    <input type="text" name="discount[]" class="form-control discount-<?php echo $row ?>"
                                                        onchange="calculate_store_cafe_stock_net_price(<?php echo $row ?>)"
                                                        value="<?php echo $product->discount ?? '0.00' ?>">
                                                </div>

                                                <div class="form-group col-lg-3">
                                                    <label for="exampleInputEmail1">Net</label>
                                                    <input type="text" name="net_price[]" class="form-control net-<?php echo $row ?> net-price"
                                                        value="<?php echo $product->net_price ?>" readonly="readonly">
                                                </div>
                                            </div>
                                            <?php
                                            $row++;
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                        
                  
                        <div class="row">
                            <div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
                                <strong>Dis.(Flat) </strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                                <input type="text" name="grand_total_discount" class="form-control grand_total_discount"
                                       onchange="calculate_grand_total_discount_for_cafe(this.value)"  
                                          value="<?php echo $stock_info[0]->discount; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
                                <strong>G.Total</strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                                <input type="text" name="grand_total" class="form-control grand_total"
                                value="<?php echo $stock_info[0]->total; ?>"
                                       readonly="readonly">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions" style="padding-left: 10px">
                        <button type="submit" class="btn blue">Submit</button>
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