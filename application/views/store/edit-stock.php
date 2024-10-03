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
        <form role="form" method="get" autocomplete="off" style="background: #f5f5f5;padding: 8px !important;">
            <div class="row">
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">Supplier Invoice</label>
                    <input type="text" name="invoice" class="form-control invoice"
                           value="<?php echo @$_REQUEST[ 'invoice' ] ?>" required="required">
                </div>
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">Date</label>
                    <input type="text" name="date_added" class="date date-picker form-control"
                           value="<?php echo @$_REQUEST[ 'date_added' ] ?>">
                </div>
                <div class="form-group col-lg-2" style="margin-top: 25px">
                    <button type="submit" class="btn-block btn blue">Search</button>
                </div>
            </div>
        </form>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Store Stock
                </div>
            </div>
            <div class="portlet-body form">
                <form method="post">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <div class="form-body">
                        <?php
                            $counter               = 1;
                            if ( count ( $stock ) > 0 ) :
                                ?>
                                <input type="hidden" name="action" value="do_update_store_stock">
                                <input type="hidden" name="supplier_id"
                                       value="<?php echo $stock[ 0 ] -> supplier_id; ?>">
                                <input type="hidden" name="action" value="do_update_store_stock">
                                <input type="hidden" id="added" value="<?php echo count ( $stock ) ?>">
                                <input type="hidden" name="invoice_number" value="<?php echo $_REQUEST[ 'invoice' ] ?>">
                                <?php
                                foreach ( $stock as $item ) :
                                    $store_info = get_store ( $item -> store_id );
                                    $sold_quantity = get_stock_sold_quantity ( $item -> id );
                                    if ( $sold_quantity > 0 ) {
                                        ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div style="display: block;float: left;width: 100%; border: 1px solid #a4a4a4; margin-bottom: 15px; padding-top: 13px; border-radius: 8px !important;">
                                                    <div class="form-group col-lg-3">
                                                        <span style="font-weight: 900;"
                                                              class="counter"><?php echo $counter ?></span>
                                                        <label for="exampleInputEmail1">Store Item</label>
                                                        <select name="store_id[]" class="form-control select2me">
                                                            <option value="<?php echo $store_info -> id ?>">
                                                                <?php echo $store_info -> item ?>
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <label for="exampleInputEmail1">Stock.No</label>
                                                        <input type="text" class="form-control"
                                                               readonly="readonly"
                                                               value="<?php echo $item -> batch ?>">
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <label for="exampleInputEmail1">Expiry Date</label>
                                                        <input type="text"
                                                               class="form-control"
                                                               readonly="readonly"
                                                               value="<?php echo date ( 'm/d/Y', strtotime ( $item -> expiry ) ) ?>">
                                                    </div>
                                                    <div class="form-group col-lg-1">
                                                        <label for="exampleInputEmail1">Quantity</label>
                                                        <input type="text" readonly="readonly"
                                                               class="form-control"
                                                               value="<?php echo $item -> quantity ?>">
                                                    </div>
                                                    <div class="form-group col-lg-1">
                                                        <label for="exampleInputEmail1">Price</label>
                                                        <input type="text" readonly="readonly"
                                                               class="form-control"
                                                               value="<?php echo $item -> price ?>">
                                                    </div>
                                                    <div class="form-group col-lg-1">
                                                        <label for="exampleInputEmail1">Discount</label>
                                                        <input type="text" readonly="readonly"
                                                               class="form-control"
                                                               value="<?php echo $item -> discount ?>">
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <label for="exampleInputEmail1">Net</label>
                                                        <input type="text"
                                                               class="form-control net-price"
                                                               readonly="readonly"
                                                               value="<?php echo $item -> net_price ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    else {
                                        ?>
                                        <input type="hidden" name="stock_id[]" value="<?php echo $item -> id ?>">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div style="display: block;float: left;width: 100%; border: 1px solid #a4a4a4; margin-bottom: 15px; padding-top: 13px; border-radius: 8px !important;">
                                                    <div class="form-group col-lg-3">
                                                        <span style="font-weight: 900;"
                                                              class="counter"><?php echo $counter ?></span>
                                                        <a href="<?php echo base_url ( 'store/delete_individual_stock/' . $item -> id ) ?>"
                                                           onclick="return confirm('Are you sure?')">
                                                            <i class="fa fa-trash-o"></i>
                                                        </a>
                                                        <label for="exampleInputEmail1">Store Item</label>
                                                        <select name="store_id[]" class="form-control select2me">
                                                            <option value="<?php echo $store_info -> id ?>">
                                                                <?php echo $store_info -> item ?>
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <label for="exampleInputEmail1">Stock.No</label>
                                                        <input type="text" name="batch[]" class="form-control"
                                                               readonly="readonly"
                                                               value="<?php echo $item -> batch ?>">
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <label for="exampleInputEmail1">Expiry Date</label>
                                                        <input type="text" name="expiry[]"
                                                               class="date date-picker form-control"
                                                               readonly="readonly"
                                                               value="<?php echo date ( 'm/d/Y', strtotime ( $item -> expiry ) ) ?>">
                                                    </div>
                                                    <div class="form-group col-lg-1">
                                                        <label for="exampleInputEmail1">Quantity</label>
                                                        <input type="text" name="quantity[]"
                                                               class="form-control quantity-<?php echo $counter ?>"
                                                               onchange="calculate_store_stock_net_price(<?php echo $counter ?>)"
                                                               value="<?php echo $item -> quantity ?>">
                                                    </div>
                                                    <div class="form-group col-lg-1">
                                                        <label for="exampleInputEmail1">Price</label>
                                                        <input type="text" name="price[]"
                                                               class="form-control price-<?php echo $counter ?>"
                                                               onchange="calculate_store_stock_net_price(<?php echo $counter ?>)"
                                                               value="<?php echo $item -> price ?>">
                                                    </div>
                                                    <div class="form-group col-lg-1">
                                                        <label for="exampleInputEmail1">Discount</label>
                                                        <input type="text" name="discount[]"
                                                               class="form-control discount-<?php echo $counter ?>"
                                                               onchange="calculate_store_stock_net_price(<?php echo $counter ?>)"
                                                               value="<?php echo $item -> discount ?>">
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <label for="exampleInputEmail1">Net</label>
                                                        <input type="text" name="net_price[]"
                                                               class="form-control net-<?php echo $counter ?> net-price"
                                                               readonly="readonly"
                                                               value="<?php echo $item -> net_price ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    $counter++;
                                endforeach;
                            endif;
                        ?>
                        <div class="add-more-store-stock"></div>
                        <div class="row">
                            <div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
                                <strong>Disc. (%)</strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                                <input type="text" name="grand_total_discount" class="form-control grand_total_discount"
                                       onchange="calculate_grand_total_discount(this.value)"
                                       value="<?php echo @$stock_info -> discount ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
                                <strong>G.Total</strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                                <input type="text" name="grand_total" class="form-control grand_total"
                                       readonly="readonly" value="<?php echo @$stock_info -> total ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions col-lg-12">
                        <button type="submit" class="btn blue">Update</button>
                        <?php if ( count ( $stock ) > 0 ) : ?>
                            <a class="btn green" style="display: inline"
                               href="<?php echo base_url ( '/invoices/store-stock-invoice?invoice=' . $_REQUEST[ 'invoice' ] ); ?>"
                               target="_blank">Print</a>
                        <?php endif; ?>
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

    .counter {
        font-weight: 900;
        position: absolute;
        left: 4px;
        top: 30px;
    }
</style>