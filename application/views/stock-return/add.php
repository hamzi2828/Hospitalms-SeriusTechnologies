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
        
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-body">
                    <div class="form-group col-lg-5">
                        <label for="exampleInputEmail1">Supplier</label>
                        <select name="supplier_id" class="form-control select2me" required="required"
                                id="supplier_id">
                            <option value="">Select Supplier</option>
                            <?php
                                if ( count ( $suppliers ) > 0 ) {
                                    foreach ( $suppliers as $supplier ) {
                                        ?>
                                        <option value="<?php echo $supplier -> id ?>" <?php if ( isset( $_GET[ 'supplier_id' ] ) && $_GET[ 'supplier_id' ] == $supplier -> id ) echo 'selected="selected"' ?>>
                                            <?php echo $supplier -> title ?>
                                        </option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-5">
                        <label for="exampleInputEmail1">Invoice#</label>
                        <input type="text" class="form-control" name="invoice"
                               value="<?php echo @$_GET[ 'invoice' ] ?>">
                    </div>
                    <div class="form-group col-lg-2">
                        <button type="submit" class="btn btn-primary btn-block" style="margin-top: 25px">Search</button>
                    </div>
                </div>
            </form>
        </div>
        
        <?php if ( count ( $stocks ) > 0 ) : ?>
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Add Return Stock
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="alert alert-danger expiry-response" style="display: none"></div>
                    <div class="alert alert-danger type-response" style="display: none"></div>
                    <form role="form" method="post" autocomplete="off">
                        
                        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                               value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                        <input type="hidden" name="action" value="do_add_return_stock">
                        <input type="hidden" name="supplier_id"
                               value="<?php echo $this -> input -> get ( 'supplier_id' ) ?>">
                        <input type="hidden" name="invoice"
                               value="<?php echo $this -> input -> get ( 'invoice' ) ?>">
                        
                        <div class="form-body" style="overflow: auto; background: transparent">
                            <?php
                                
                                foreach ( $stocks as $key => $stock ) {
                                    $medicine_id = $stock -> medicine_id;
                                    $stock_id = $stock -> id;
                                    
                                    $medicine = get_medicine ( $medicine_id );
                                    $name = $medicine -> name;
                                    if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 )
                                        $name .= get_form ( $medicine -> form_id ) -> title . '-' . get_strength ( $medicine -> strength_id ) -> title;
                                    
                                    $available = count_stock_available_quantity ( $medicine_id, $stock );
                                    
                                    ?>
                                    
                                    <input type="hidden" name="stock_id[]" value="<?php echo $stock_id ?>">
                                    
                                    <div class="sale-<?php echo $key ?> sale-fields">
                                        <div class="form-group col-lg-4">
                                            <label for="exampleInputEmail1">Medicine</label>
                                            <select class="form-control select2me" name="medicine_id[]">
                                                <option value="<?php echo $medicine_id ?>">
                                                    <?php echo $name ?>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <label for="exampleInputEmail1">Batch</label>
                                            <div class="batch">
                                                <input type="text" class="form-control"
                                                       value="<?php echo $stock -> batch ?>" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-1">
                                            <label for="exampleInputEmail1">Available</label>
                                            <input type="text" class="form-control" readonly="readonly"
                                                   id="available-qty" value="<?php echo $available ?>">
                                        </div>
                                        <div class="form-group col-lg-1">
                                            <label for="exampleInputEmail1">Return Qty</label>
                                            <input type="text" class="form-control" name="return_qty[]"
                                                   required="required"
                                                   onchange="calculate_net_price_return_stock(this.value, <?php echo $key ?>)">
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <label for="exampleInputEmail1">Cost/Unit</label>
                                            <input type="text" class="form-control" name="cost_unit[]"
                                                   readonly="readonly"
                                                   value="<?php echo $stock -> tp_unit ?>" id="price">
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <label for="exampleInputEmail1">Net Price</label>
                                            <input type="text" class="form-control net-price" readonly="readonly"
                                                   name="net_price[]">
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>
                            
                            <div class="col-lg-1 col-lg-offset-9">
                                <strong class="total-net-price">Total</strong>
                            </div>
                            <div class="col-lg-2">
                                <input type="text" name="total" id="total-net-price" readonly="readonly"
                                       class="form-control grand_total">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn blue" id="return-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
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