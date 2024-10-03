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
        <form role="form" class="search-form" method="get" autocomplete="off">
            <div class="form-body" style="overflow: auto">
                <div class="form-group col-lg-11">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></label>
                    <input type="text" name="sale_id" class="form-control" required="required"
                           value="<?php echo @$_REQUEST[ 'sale_id' ]; ?>" autofocus="autofocus">
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            
            </div>
        </form>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Sale
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    
                    <?php
                        if ( count ( $sales ) > 0 ) {
                            $sale_info = get_sale ( $sales[ 0 ] -> sale_id );
                            ?>
                            <input type="hidden" name="action" value="do_edit_sale">
                            <input type="hidden" value="<?php echo $sales[ 0 ] -> sale_id ?>" name="sale_id">
                            <div class="form-body" style="overflow: auto">
                                <div class="form-group col-lg-2" style="position: relative;padding-top: 30px;">
                                    <input type="checkbox" name="cash_from_pharmacy" class="cash-customer"
                                           value="<?php echo cash_from_pharmacy ?>" <?php if ( $sales[ 0 ] -> patient_id == cash_from_pharmacy ) echo 'checked="checked"; readonly="readonly"'; ?>>
                                    Cash Customer
                                </div>
                                <div class="form-group col-lg-4" style="position: relative">
                                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>.</label>
                                    <input type="text" name="patient_id" class="form-control patient-id"
                                           placeholder="Enter EMR after <?php echo emr_prefix ?> e.g 5240"
                                           autofocus="autofocus" onchange="get_patient(this.value)"
                                           style="padding-left: 85px;" <?php if ( $sales[ 0 ] -> patient_id == cash_from_pharmacy )
                                        echo 'disabled="disabled"';
                                    else echo 'required="required"' ?>>
                                    <label style="position: absolute;top: 25px;background: #e3e3e3;padding: 7px 25px;">PAT-</label>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                                    <input type="text" class="form-control" readonly="readonly" id="patient-name">
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line('PATIENT_CNIC') ?></label>
                                    <input type="text" class="form-control" readonly="readonly" id="patient-cnic">
                                </div>
                                <?php
                                    $counter = 1;
                                    $total = 0;
                                    foreach ( $sales as $sale ) {
                                        $medicine = get_medicine ( $sale -> medicine_id ) -> name;
                                        $stock = get_stock ( $sale -> stock_id ) -> batch;
                                        $returned = get_stock_returned_quantity ( $sale -> stock_id );
                                        $issued = check_stock_issued_quantity ( $sale -> stock_id );
                                        $adjustment_qty = count_medicine_adjustment_by_medicine_id ( get_medicine ( $sale -> medicine_id ) -> id, $sale -> stock_id );
                                        $avail_quantity = get_stock ( $sale -> stock_id ) -> quantity - check_quantity_sold ( $sale -> medicine_id, $sale -> stock_id ) - $returned - $issued - $adjustment_qty;
                                        
                                        if ( $avail_quantity <= $sale -> quantity )
                                            $avail_quantity += $sale -> quantity;
                                        
                                        $total += $sale -> net_price;
                                        
                                        ?>
                                        <div class="sale-<?php echo $counter ?>"
                                             style="display: block;float: left;width: 100%;position: relative">
                                            <a href="<?php echo base_url ( '/medicines/delete-sale/' . $sale -> id ) ?>"
                                               onclick="return confirm('Are you sure? Action will be permanent.')"
                                               style="position: absolute;top: 30px;left: 0; cursor: pointer; z-index: 999">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            <input type="hidden" name="id[]" value="<?php echo $sale -> id ?>">
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Medicine</label>
                                                <input type="text" name="medicine_id[]" value="<?php echo $medicine ?>"
                                                       required="required" class="form-control" readonly="readonly">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Batch</label>
                                                <input type="hidden" name="stock_id[]"
                                                       value="<?php echo $sale -> stock_id ?>"
                                                       required="required"
                                                       class="form-control" readonly="readonly">
                                                <input type="text"
                                                       value="<?php echo $stock ?>"
                                                       required="required"
                                                       class="form-control" readonly="readonly">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Available Qty.</label>
                                                <input type="text" class="form-control" readonly="readonly"
                                                       id="available-qty"
                                                       value="<?php echo $avail_quantity; ?>">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Sale Qty.</label>
                                                <input type="text" class="form-control" name="quantity[]"
                                                       onchange="calculate_net_price_edit(this.value, <?php echo $counter ?>)"
                                                       id="quantity"
                                                       required="required" value="<?php echo $sale -> quantity ?>">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Price</label>
                                                <input type="text" class="form-control" readonly="readonly"
                                                       name="price[]"
                                                       id="price" value="<?php echo $sale -> price ?>">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Net Price</label>
                                                <input type="text" class="form-control net-price" readonly="readonly"
                                                       name="net_price[]" value="<?php echo $sale -> net_price ?>">
                                            </div>
                                        </div>
                                        <?php
                                        $counter++;
                                    }
                                    
                                    $net_total = $total;
                                    if ( $sale_info -> discount > 0 )
                                        $net_total = $net_total - ( $net_total * $sale_info -> discount / 100 );
                                    
                                    if ( $sale_info -> flat_discount > 0 )
                                        $net_total = $net_total - $sale_info -> flat_discount;
                                
                                ?>
                                <div id="sale-more-medicine"></div>
                                <div class="col-lg-1 col-lg-offset-9">
                                    <strong class="total-net-price">Total</strong>
                                </div>
                                <div class="col-lg-2" style="margin-bottom: 5px;">
                                    <input type="text" class="form-control total" readonly="readonly"
                                           value="<?php echo $total ?>"
                                           name="pharmacy_sale_total">
                                </div>
                                <div class="col-lg-1 col-lg-offset-9">
                                    <strong class="total-net-price">Discount(%)</strong>
                                </div>
                                <div class="col-lg-2" style="margin-bottom: 10px">
                                    <input type="text"
                                           name="sale_discount" <?php if ( $sale_info -> discount or $sale_info -> flat_discount > 0 ) echo 'readonly="readonly"' ?>
                                           class="form-control sale_discount grand_total_discount"
                                           value="<?php echo $sale_info -> discount ?>"
                                           onchange="calculate_sale_discount(this.value)">
                                </div>
                                <div class="col-lg-1 col-lg-offset-9">
                                    <strong class="total-net-price">Flat Dis.</strong>
                                </div>
                                <div class="col-lg-2" style="margin-bottom: 10px">
                                    <input type="text"
                                           name="flat_discount" <?php if ( $sale_info -> discount or $sale_info -> flat_discount > 0 ) echo 'readonly="readonly"' ?>
                                           class="form-control flat_discount"
                                           value="<?php echo $sale_info -> flat_discount ?>"
                                           onchange="calculate_flat_sale_discount(this.value)">
                                </div>
                                <div class="col-lg-2 col-lg-offset-8">
                                    <strong class="total-net-price">Added Amount</strong>
                                </div>
                                <div class="col-lg-2" style="margin-bottom: 10px">
                                    <input type="text"
                                           name="added_amount" <?php if ( $sale_info -> added_amount > 0 ) echo 'readonly="readonly"' ?>
                                           class="form-control added_amount"
                                           value="<?php echo $sale_info -> added_amount ?>"
                                           onchange="calculate_added_amount_total(this.value)">
                                </div>
                                <div class="col-lg-1 col-lg-offset-9">
                                    <strong class="total-net-price">Total</strong>
                                </div>
                                <div class="col-lg-2">
                                    <input type="text" name="total" id="total-net-price" readonly="readonly"
                                           class="form-control grand_total"
                                           value="<?php echo $net_total ?>">
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue" id="sales-btn">Update</button>
                                <a type="button"
                                   href="<?php echo base_url ( 'invoices/sale-invoice/' . $sales[ 0 ] -> sale_id ) ?>"
                                   target="_blank" class="btn purple" style="display: inline;">Print</a>
                            </div>
                            <?php
                        }
                    ?>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .total-net-price {
        float: right;
        padding-top: 8px;
        font-size: 16px;
    }
</style>