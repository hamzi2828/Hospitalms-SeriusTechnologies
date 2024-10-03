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
        <form method="get">
            <div class="form-group col-lg-5" style="padding-left: 0">
                <label for="exampleInputEmail1">Date</label>
                <input type="text" name="date_added" class="form-control date-picker"
                       value="<?php echo date ( 'm/d/Y' ) ?>">
            </div>
            <div class="form-group col-lg-5" style="padding-left: 0">
                <label for="exampleInputEmail1">Supplier Invoice</label>
                <input type="text" name="supplier_invoice" class="form-control"
                       value="<?php echo @$_REQUEST[ 'supplier_invoice' ] ?>">
            </div>
            <div class="form-group col-lg-2">
                <button type="submit" class="btn-block btn btn-primary" style="margin-top: 25px">Search</button>
            </div>
        </form>
        <form method="post">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Edit Local Purchase
                    </div>
                </div>
                <div class="portlet-body form">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_local_purchase">
                    <div class="form-body">
                        <?php
                            $total_purchase = 0;
                            if ( count ( $purchases ) > 0 ) {
                                foreach ( $purchases as $key => $purchase ) {
                                    $total_purchase = $total_purchase + ( $purchase -> quantity * $purchase -> tp_unit );
                                    $sold = get_sold_quantity_by_stock ( $purchase -> medicine_id, $purchase -> id );
                                    $available = count_stock_available_quantity ( $purchase -> medicine_id, $purchase );
                                    ?>
                                    <input type="hidden" name="purchase_id[]"
                                           value="<?php echo $purchase -> id ?>">
                                    <?php
                                    if ( $sold > 0 || $available != $purchase -> quantity ) {
                                        ?>
                                        <div class="row">
                                            <div class="form-group col-lg-4">
                                                <label for="exampleInputEmail1">Medicine</label>
                                                <select name="medicine_id[]" class="form-control select2me">
                                                    <?php
                                                        $medicine = get_medicine ( $purchase -> medicine_id );
                                                        if ( $medicine -> strength_id > 1 )
                                                            $strength = get_strength ( $medicine -> strength_id ) -> title;
                                                        else
                                                            $strength = '';
                                                        if ( $medicine -> form_id > 1 )
                                                            $form = get_form ( $medicine -> form_id ) -> title;
                                                        else
                                                            $form = '';
                                                    ?>
                                                    <option value="<?php echo $medicine -> id ?>">
                                                        <?php echo $medicine -> name . ' ' . $strength . ' ' . $form; ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label for="exampleInputEmail1">Batch</label>
                                                <input type="text" readonly="readonly"
                                                       class="form-control" name="batch[]"
                                                       value="<?php echo $purchase -> batch ?>">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label for="exampleInputEmail1">Expiry Date</label>
                                                <input type="text" readonly="readonly" class="form-control date-picker"
                                                       name="expiry_date[]"
                                                       value="<?php echo date ( 'm/d/Y', strtotime ( $purchase -> expiry_date ) ) ?>">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Box QTY.</label>
                                                <input type="number" readonly="readonly" class="form-control"
                                                       id="box-qty-<?php echo $key ?>" name="box_qty[]"
                                                       min="1" value="<?php echo $purchase -> box_qty ?>">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Total Units</label>
                                                <input type="text" readonly="readonly" name="quantity[]"
                                                       class="form-control total-units-<?php echo $key ?>"
                                                       value="<?php echo $purchase -> quantity ?>">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">TP/Unit</label>
                                                <input type="text" readonly="readonly" name="tp_unit[]"
                                                       class="form-control purchase-per-unit"
                                                       value="<?php echo $purchase -> tp_unit ?>"
                                                       onchange="calculate_total_local_purchase_price()">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Sale/Unit</label>
                                                <input type="text" readonly="readonly" class="form-control"
                                                       name="sale_unit[]"
                                                       value="<?php echo $purchase -> sale_unit ?>">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="exampleInputEmail1">Description</label>
                                                <textarea rows="3" readonly="readonly" name="description[]"
                                                          class="form-control"><?php echo $purchase -> description ?></textarea>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    else {
                                        ?>
                                        <div class="row">
                                            <div class="form-group col-lg-4">
                                                <a href="<?php echo base_url ( '/medicines/delete_local_purchase/' . $purchase -> id ) ?>"
                                                   onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                                <label for="exampleInputEmail1">Medicine</label>
                                                <select name="medicine_id[]" class="form-control select2me">
                                                    <?php
                                                        $medicine = get_medicine ( $purchase -> medicine_id );
                                                        if ( $medicine -> strength_id > 1 )
                                                            $strength = get_strength ( $medicine -> strength_id ) -> title;
                                                        else
                                                            $strength = '';
                                                        if ( $medicine -> form_id > 1 )
                                                            $form = get_form ( $medicine -> form_id ) -> title;
                                                        else
                                                            $form = '';
                                                    ?>
                                                    <option value="<?php echo $medicine -> id ?>">
                                                        <?php echo $medicine -> name . ' ' . $strength . ' ' . $form; ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label for="exampleInputEmail1">Batch</label>
                                                <input type="text" name="batch[]" readonly="readonly"
                                                       class="form-control"
                                                       value="<?php echo $purchase -> batch ?>">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label for="exampleInputEmail1">Expiry Date</label>
                                                <input type="text" name="expiry_date[]" class="form-control date-picker"
                                                       value="<?php echo date ( 'm/d/Y', strtotime ( $purchase -> expiry_date ) ) ?>">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Box QTY.</label>
                                                <input type="number" name="box_qty[]" class="form-control"
                                                       id="box-qty-1"
                                                       min="1" value="<?php echo $purchase -> box_qty ?>">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Total Units</label>
                                                <input type="text" name="quantity[]"
                                                       class="form-control total-units-<?php echo $key ?>"
                                                       value="<?php echo $purchase -> quantity ?>">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">TP/Unit</label>
                                                <input type="text" name="tp_unit[]"
                                                       class="form-control purchase-per-unit"
                                                       value="<?php echo $purchase -> tp_unit ?>"
                                                       onchange="calculate_total_local_purchase_price()">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Sale/Unit</label>
                                                <input type="text" name="sale_unit[]" class="form-control"
                                                       value="<?php echo $purchase -> sale_unit ?>">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="exampleInputEmail1">Description</label>
                                                <textarea rows="3" name="description[]"
                                                          class="form-control"><?php echo $purchase -> description ?></textarea>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    
                                    <?php
                                }
                            }
                        ?>
                        <div class="row">
                            <div class="col-lg-offset-6 col-lg-3 text-right" style="padding-top: 8px;">
                                <strong>Net Purchase:</strong>
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control net_amount" readonly="readonly"
                                       value="<?php echo $total_purchase ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="sales-btn">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>