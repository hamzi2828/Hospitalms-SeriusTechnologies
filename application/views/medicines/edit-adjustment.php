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
        <form role="form" method="get" autocomplete="off" class="search-form">
            <div class="form-body" style="overflow: auto">
                <div class="form-group col-lg-11">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></label>
                    <input type="text" name="adjustment_id" class="form-control" required="required"
                           value="<?php echo @$_REQUEST[ 'adjustment_id' ]; ?>">
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
                    <i class="fa fa-reorder"></i> Edit Adjustment
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    
                    <?php
                        if ( count ( $sales ) > 0 ) {
                            $sale_info = get_adjustment_by_id ( $_REQUEST[ 'adjustment_id' ] );
                            ?>
                            <input type="hidden" name="action" value="do_edit_adjustment">
                            <input type="hidden" value="<?php echo $_REQUEST[ 'adjustment_id' ] ?>"
                                   name="adjustment_id">
                            <div class="form-body" style="overflow: auto">
                                
                                <?php
                                    $counter = 1;
                                    foreach ( $sales as $sale ) {
                                        $medicine = get_medicine ( $sale -> medicine_id );
                                        $stockInfo = get_stock ( $sale -> stock_id );
                                        $stock = $stockInfo -> batch;
                                        $returned = get_stock_returned_quantity ( $sale -> stock_id );
                                        $issued = check_stock_issued_quantity ( $sale -> stock_id );
                                        $adjustment = count_medicine_adjustment_by_medicine_id ( $sale -> medicine_id, $sale -> stock_id );
                                        $avail_quantity = count_stock_available_quantity ( $sale -> medicine_id, $stockInfo );
                                        
                                        if ( $medicine -> strength_id > 1 )
                                            $strength = get_strength ( $medicine -> strength_id ) -> title;
                                        else
                                            $strength = '';
                                        if ( $medicine -> form_id > 1 )
                                            $form = get_form ( $medicine -> form_id ) -> title;
                                        else
                                            $form = '';
                                        
                                        ?>
                                        <div class="sale-<?php echo $counter ?>"
                                             style="display: block;float: left;width: 100%;position: relative">
                                            <a href="<?php echo base_url ( '/medicines/delete_adjustment/' . $sale -> id ) ?>"
                                               onclick="return confirm('Are you sure? Action will be permanent.')"
                                               style="position: absolute;top: 30px;left: 0; z-index: 999;">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            <input type="hidden" name="id[]" value="<?php echo $sale -> id ?>">
                                            <div class="form-group col-lg-4">
                                                <label for="exampleInputEmail1">Medicine</label>
                                                <input type="text" name="medicine_id[]"
                                                       value="<?php echo $medicine -> name . ' ' . $strength . ' ' . $form ?>"
                                                       required="required" class="form-control" readonly="readonly">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Batch</label>
                                                <input type="text" name="stock_id[]"
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
                                            <div class="form-group col-lg-1">
                                                <label for="exampleInputEmail1">Sale Qty.</label>
                                                <input type="text" class="form-control" name="quantity[]"
                                                       onchange="calculate_net_price_edit(this.value, <?php echo $counter ?>)"
                                                       id="quantity"
                                                       required="required" value="<?php echo $sale -> quantity ?>">
                                            </div>
                                            <div class="form-group col-lg-1">
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
                                ?>
                                <div id="sale-more-medicine"></div>
                                <div class="col-lg-1 col-lg-offset-9">
                                    <strong class="total-net-price">Total</strong>
                                </div>
                                <div class="col-lg-2">
                                    <input type="text" name="total" id="total-net-price" readonly="readonly"
                                           class="form-control grand_total" value="<?php echo $sale_info -> total ?>">
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue" id="sales-btn">Update</button>
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