<!-- BEGIN PAGE CONTENT-->
<?php $access = get_user_access ( get_logged_in_user_id () ); ?>
<div class="row">
    <div class="col-md-12">
        <?php if ( count ( $stocks ) > 0 ) : ?>
            <h3 style="text-align: center;margin-top: 0;margin-bottom: 20px;">
                <strong>Invoice Date# </strong>
                <?php echo date_setter ( $stocks[ 0 ] -> date_added ) ?>
            </h3>
        <?php endif; ?>
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
        <?php if ( isset( $_REQUEST[ 'request' ] ) and $_REQUEST[ 'request' ] == 'verify' ) : ?>
            <div class="alert alert-info">
                <i class="fa fa-exclamation-circle"></i>
                Please double check the stock. There might be some problem due to network failure or system inconsistency.
                <a href="<?php echo base_url ( '/medicines/add-medicines-stock' ); ?>">
                    <strong> Add More Stock </strong>
                </a>
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
                    <i class="fa fa-reorder"></i> Search Supplier Invoice
                </div>
            </div>
            <div class="portlet-body form">
                
                <form role="form" method="get" autocomplete="off">
                    <div class="form-body" style="overflow: auto">
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Supplier</label>
                            <select name="supplier_id" class="form-control select2me" required="required">
                                <option value="">Select Supplier</option>
                                <?php
                                    if ( count ( $suppliers ) > 0 ) {
                                        foreach ( $suppliers as $supplier ) {
                                            ?>
                                            <option value="<?php echo $supplier -> id ?>" <?php if ( $supplier -> id == @$_REQUEST[ 'supplier_id' ] )
                                                echo 'selected="selected"' ?>>
                                                <?php echo $supplier -> title ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Supplier Invoice</label>
                            <input type="text" name="supplier_invoice" class="form-control" required="required"
                                   id="invoice_number" value="<?php echo @$_REQUEST[ 'supplier_invoice' ]; ?>">
                        </div>
                        
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Date</label>
                            <input type="text" name="date_added" class="date date-picker form-control"
                                   value="<?php echo ( isset( $_REQUEST[ 'date_added' ] ) ) ? $_REQUEST[ 'date_added' ] : '' ?>">
                        </div>
                        
                        <div class="form-group col-lg-1">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-top: 25px;">Search</button>
                        </div>
                    
                    </div>
                </form>
                
                <?php
                    if ( count ( $stocks ) > 0 ) {
                        $counter = 1;
                        $sum_disc = 0;
                        $grand_total = get_stock_grand_total ( $_REQUEST[ 'supplier_invoice' ] );
                        $grand_discount = get_grand_discount ( $_REQUEST[ 'supplier_invoice' ] );
                        $discount = 0;
                        $total = 0;
                        $i = 1;
                        if ( !empty( $grand_discount ) )
                            $discount = $grand_discount -> discount;
                        if ( !empty( $grand_total ) )
                            $total = $grand_total -> grand_total;
                        foreach ( $stocks as $stock ) {
                            $sum_disc += $stock -> discount;
                            $medicine = get_medicine ( $stock -> medicine_id );
                            ?>
                            <input type="hidden" name="stock_id[]" value="<?php echo $stock -> id ?>">
                            <div class="stock-rows col-lg-12 stock-rows-<?php echo $counter ?>"
                                 style="margin-bottom: 15px">
                                
                                <div class="form-group col-lg-4">
                                    <label for="exampleInputEmail1">Medicine</label>
                                    <select name="medicine_id[]" class="form-control select2me" required="required"
                                            id="medicine-id-<?php echo $counter ?>" disabled="disabled">
                                        <option value="<?php echo $medicine -> id ?>">
                                            <?php echo $medicine -> name . ' ' . get_strength ( $medicine -> strength_id ) -> title . ' (' . get_form ( $medicine -> form_id ) -> title . ')' ?>
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Batch#</label>
                                    <input type="text" name="batch[]" class="form-control batch_number"
                                           required="required"
                                           onchange="validate_batch_number(this.value, <?php echo $counter ?>)"
                                           value="<?php echo $stock -> batch ?>" disabled="disabled">
                                </div>
                                
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Expiry date</label>
                                    <input type="text" name="expiry_date[]" class="date date-picker form-control"
                                           placeholder="Expiry date" required="required"
                                           value="<?php echo date ( 'm/d/Y', strtotime ( $stock -> expiry_date ) ) ?>"
                                           disabled="disabled">
                                </div>
                                
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Box QTY.</label>
                                    <input type="number" name="box_qty[]" class="form-control"
                                           id="box-qty-<?php echo $counter ?>"
                                           required="required" min="1"
                                           onchange="calculate_quantity(<?php echo $counter ?>)"
                                           value="<?php echo $stock -> box_qty ?>" disabled="disabled">
                                </div>
                                
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Pack size</label>
                                    <input type="number" name="units[]" class="form-control"
                                           id="unit-<?php echo $counter ?>" min="1"
                                           onchange="calculate_quantity(<?php echo $counter ?>)"
                                           value="<?php echo $stock -> units ?>" disabled="disabled">
                                </div>
                                
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Total Units</label>
                                    <input type="text" name="quantity[]" class="form-control"
                                           id="quantity-<?php echo $counter ?>"
                                           value="<?php echo $stock -> quantity ?>" disabled="disabled">
                                </div>
                                
                                <div class="form-group col-lg-1">
                                    <label for="exampleInputEmail1">TP/Box</label>
                                    <input type="text" name="box_price[]" class="form-control" required="required"
                                           id="box-price-<?php echo $counter ?>"
                                           onchange="calculate_per_unit_price(<?php echo $counter ?>)"
                                           value="<?php echo $stock -> box_price ?>" disabled="disabled">
                                </div>
                                
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Total Amount</label>
                                    <input type="text" name="price[]"
                                           class="form-control total-price-<?php echo $counter ?>"
                                           required="required" value="<?php echo $stock -> price ?>"
                                           disabled="disabled">
                                </div>
                                
                                <div class="form-group col-lg-1">
                                    <label for="exampleInputEmail1">Disc.(%)</label>
                                    <input type="text" name="discount[]"
                                           class="form-control discount-<?php echo $counter ?> discounts" <?php if ( $discount > 0 )
                                        echo '';
                                    else echo 'required="required"'; ?>
                                           onchange="calculate_net_bill(<?php echo $counter ?>)"
                                           value="<?php echo $stock -> discount ?>" disabled="disabled">
                                </div>
                                
                                <div class="form-group col-lg-1">
                                    <label for="exampleInputEmail1">S.Tax</label>
                                    <input type="text" name="sales_tax[]"
                                           class="form-control s-tax-<?php echo $counter ?>" required="required"
                                           value="<?php echo $stock -> sales_tax ?>"
                                           onchange="calculate_net_bill(<?php echo $counter ?>)" disabled="disabled">
                                </div>
                                
                                <div class="form-group col-lg-1">
                                    <label for="exampleInputEmail1">Net</label>
                                    <input type="text" name="net[]"
                                           class="form-control net-<?php echo $counter ?> net-price"
                                           required="required" value="<?php echo $stock -> net_price ?>"
                                           disabled="disabled">
                                </div>
                                
                                <div class="form-group col-lg-1">
                                    <label for="exampleInputEmail1">Cost/Box</label>
                                    <input type="text" name="box_price_after_dis_tax[]"
                                           class="form-control cost-box-<?php echo $counter ?>" required="required"
                                           value="<?php echo $stock -> box_price_after_dis_tax ?>"
                                           disabled="disabled">
                                </div>
                                
                                <div class="form-group col-lg-1">
                                    <label for="exampleInputEmail1">Cost/Unit</label>
                                    <input type="text" name="tp_unit[]" class="form-control" required="required"
                                           id="purchase-price-<?php echo $counter ?>"
                                           onchange="calculate_sale_price(this.value, 1)"
                                           value="<?php echo $stock -> tp_unit ?>" disabled="disabled">
                                </div>
                                
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Sale/Box</label>
                                    <input type="text" name="sale_box[]" class="form-control"
                                           required="required" value="<?php echo $stock -> sale_box ?>"
                                           onchange="calculate_sale_price(this.value, <?php echo $counter ?>)"
                                           disabled="disabled">
                                </div>
                                
                                <div class="form-group col-lg-1">
                                    <label for="exampleInputEmail1">Sale/Unit</label>
                                    <input type="text" name="sale_unit[]"
                                           class="form-control sale-unit-<?php echo $counter ?>" required="required"
                                           value="<?php echo $stock -> sale_unit ?>" disabled="disabled">
                                </div>
                            </div>
                            <?php
                            $counter++;
                        }
                        ?>
                        
                        <div class="row">
                            <div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
                                <strong>Disc. (%)</strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                                <input type="text" name="grand_total_discount"
                                       class="form-control grand_total_discount"
                                       onchange="calculate_grand_total_discount(this.value)"
                                       value="<?php echo $discount; ?>" <?php if ( $discount > 0 )
                                    echo '';
                                else echo 'required="required"'; ?> disabled="disabled">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
                                <strong>G.Total</strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                                <input type="text" name="grand_total" class="form-control grand_total"
                                       value="<?php echo $total ?>" disabled="disabled">
                            </div>
                        </div>
                        
                        <div class="form-actions col-lg-12">
                            <a class="btn purple"
                               href="<?php echo base_url ( '/invoices/stock-invoice/' . $_REQUEST[ 'supplier_invoice' ] . '?supplier_id=' . $_REQUEST[ 'supplier_id' ] ) ?>"
                               target="_blank" style="display: inline">Print</a>
                        </div>
                        
                        <?php
                    }
                ?>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>
</div>
<style>
    .form {
        width: 100%;
        display: block;
        /* float: left; */
        clear: both;
    }

    .stock-rows {
        display: block;
        width: 100%;
        float: left;
        background: #e3e3e3;
        padding: 10px 0;
    }
</style>