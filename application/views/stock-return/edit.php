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
                    <i class="fa fa-reorder"></i> Edit Return Stock
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger expiry-response" style="display: none"></div>
                <div class="alert alert-danger type-response" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_return_stock">
                    <input type="hidden" name="return_id" value="<?php echo $returns[ 0 ] -> return_id ?>">
                    <div class="form-body" style="overflow: auto; background: transparent">
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Supplier</label>
                            <select name="supplier_id" class="form-control select2me" required="required"
                                    id="supplier_id" disabled="disabled">
                                <option value="">Select Supplier</option>
                                <?php
                                    if ( count ( $suppliers ) > 0 ) {
                                        foreach ( $suppliers as $supplier ) {
                                            ?>
                                            <option value="<?php echo $supplier -> id ?>" <?php if ( $supplier -> id == $returns[ 0 ] -> supplier_id ) echo 'selected="selected"' ?>>
                                                <?php echo $supplier -> title ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Invoice#</label>
                            <input type="text" class="form-control" name="invoice"
                                   onchange="check_invoice_exists(this.value)"
                                   value="<?php echo $returns[ 0 ] -> invoice; ?>" readonly="readonly">
                        </div>
                        <?php
                            $count = 1;
                            foreach ( $returns as $return ) :
                                $count++;
                                $stock = get_stock ( $return -> stock_id );
                                $sold = get_sold_quantity_by_stock ( $return -> medicine_id, $return -> stock_id );
                                $returned = get_stock_returned_quantity ( $return -> stock_id );
                                $available = $stock -> quantity - $sold - $returned;
                                $medicine = get_medicine ( $return -> medicine_id );
                                ?>
                                <div class="sale-<?php echo $count ?> sale-fields">
                                    <input type="hidden" name="return[]" value="<?php echo $return -> id ?>">
                                    <div class="form-group col-lg-3">
                                        <a href="<?php echo base_url ( 'stock-return/delete-return/' . $return -> id ) ?>"
                                           onclick="return confirm('Are you sure to delete?')">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        <label for="exampleInputEmail1">Medicine</label>
                                        <input type="text" class="form-control"
                                               value="<?php echo $medicine -> name . '(' . get_strength ( $medicine -> strength_id ) -> title . ')'; ?>"
                                               readonly="readonly">
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="exampleInputEmail1">Batch</label>
                                        <div class="batch">
                                            <input type="text" class="form-control"
                                                   value="<?php echo get_stock ( $return -> stock_id ) -> batch ?>"
                                                   readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="exampleInputEmail1">Available Qty</label>
                                        <input type="text" class="form-control" value="<?php echo $available ?>"
                                               id="available-qty" readonly="readonly">
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <label for="exampleInputEmail1">Return Qty</label>
                                        <input type="text" class="form-control" name="return_qty[]"
                                               value="<?php echo $return -> return_qty ?>"
                                               onkeyup="calculate_net_price_return_stock(this.value, <?php echo $count ?>)"
                                               readonly="readonly">
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="exampleInputEmail1">Cost/Unit</label>
                                        <input type="text" class="form-control" name="cost_unit[]" id="price"
                                               readonly="readonly" value="<?php echo $return -> cost_unit ?>">
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="exampleInputEmail1">Net Price</label>
                                        <input type="text" class="form-control net-price" readonly="readonly"
                                               name="net_price[]" value="<?php echo $return -> net_price ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <div class="col-lg-1 col-lg-offset-9">
                            <strong class="total-net-price">Total</strong>
                        </div>
                        <div class="col-lg-2">
                            <input type="text" name="total" id="total-net-price" readonly="readonly"
                                   class="form-control grand_total" value="<?php echo $return_info -> total ?>">
                        </div>
                    </div>
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
    
    .sale-fields {
        width: 100%;
        display: block;
        float: left;
    }
</style>