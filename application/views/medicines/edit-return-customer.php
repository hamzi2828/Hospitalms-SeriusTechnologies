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
        <form method="get" autocomplete="off">
            <div class="form-group col-lg-4 display-none" style="padding-left: 0">
                <label for="exampleInputEmail1">Supplier</label>
                <select name="supplier_id" class="form-control select2me" disabled="disabled">
                    <option value="">Select Supplier</option>
                    <?php
                        if ( count ( $suppliers ) > 0 ) {
                            foreach ( $suppliers as $supplier ) {
                                ?>
                                <option value="<?php echo $supplier -> id ?>" <?php if ( $supplier -> id == return_customer ) echo 'selected="selected"' ?>>
                                    <?php echo $supplier -> title ?>
                                </option>
                                <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-lg-3 col-lg-offset-4">
                <label for="exampleInputEmail1">Invoice No.</label>
                <input type="text" name="invoice" class="form-control" required="required" autofocus="autofocus"
                       value="<?php echo @$_REQUEST[ 'invoice' ] ?>">
            </div>
            <div class="form-group col-lg-3 display-none">
                <label for="exampleInputEmail1">Date</label>
                <input type="text" name="date_added" class="form-control date-picker"
                       value="<?php if ( isset( $_REQUEST[ 'date_added' ] ) && !empty( trim ( $_REQUEST[ 'date_added' ] ) ) ) echo date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'date_added' ] ) ) ?>">
            </div>
            <div class="form-group col-lg-1">
                <button type="submit" style="margin-top: 25px" class="btn btn-primary btn-block">Search</button>
            </div>
        </form>
        <form method="post">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Edit Customer Return Stock
                    </div>
                </div>
                <div class="portlet-body form">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_return_customer">
                    <div class="form-body">
                        <?php
                            if ( count ( $stock ) > 0 ) {
                                foreach ( $stock as $item ) {
                                    ?>
                                    <input type="hidden" name="stock_id[]" value="<?php echo $item -> id ?>">
                                    <input type="hidden" name="supplier_invoice[]"
                                           value="<?php echo $item -> supplier_invoice ?>">
                                    <?php
                                    $sold = get_sold_quantity_by_stock ( $item -> medicine_id, $item -> id );
                                    $available = count_stock_available_quantity ( $item -> medicine_id, $item );
                                    if ( $sold > 0 || $available != $item -> quantity ) {
                                        ?>
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <label for="exampleInputEmail1">Medicine</label>
                                                <select name="medicine_id[]" class="form-control select2me">
                                                    <?php
                                                        $medicine = get_medicine ( $item -> medicine_id );
                                                        if ( $medicine -> strength_id > 1 ) {
                                                            $strength = get_strength ( $medicine -> strength_id ) -> title;
                                                        }
                                                        else {
                                                            $strength = '';
                                                        }
                                                        if ( $medicine -> form_id > 1 ) {
                                                            $form = get_form ( $medicine -> form_id ) -> title;
                                                        }
                                                        else {
                                                            $form = '';
                                                        }
                                                    ?>
                                                    <option value="<?php echo $medicine -> id ?>">
                                                        <?php
                                                            echo $medicine -> name . ' ' . $strength . ' ' . $form;
                                                        ?>
                                                    </option>
                                                    <?php
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-1">
                                                <label for="exampleInputEmail1">Batch</label>
                                                <input type="text" readonly="readonly"
                                                       class="form-control" name="batch[]"
                                                       value="<?php echo $item -> batch; ?>">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Expiry Date</label>
                                                <input type="text" class="form-control date-picker"
                                                       name="expiry_date[]"
                                                       value="<?php echo date ( 'm/d/Y', strtotime ( $item -> expiry_date ) ) ?>"
                                                       readonly="readonly">
                                            </div>
                                            <div class="form-group col-lg-1">
                                                <label for="exampleInputEmail1">Quantity</label>
                                                <input type="text" class="form-control"
                                                       name="quantity[]"
                                                       value="<?php echo $item -> quantity; ?>" readonly="readonly">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Purchase/Unit</label>
                                                <input type="text" class="form-control"
                                                       name="tp_unit[]"
                                                       value="<?php echo $item -> tp_unit; ?>" readonly="readonly">
                                            </div>
                                            <div class="form-group col-lg-1">
                                                <label for="exampleInputEmail1">Sale/Unit</label>
                                                <input type="text" class="form-control"
                                                       name="sale_unit[]"
                                                       value="<?php echo $item -> sale_unit; ?>" readonly="readonly">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Paid To Customer</label>
                                                <input type="text" class="form-control"
                                                       name="paid_to_customer[]"
                                                       value="<?php echo $item -> paid_to_customer; ?>"
                                                       readonly="readonly">
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    else {
                                        ?>
                                        <div class="row">
                                            <div class="form-group col-lg-3">
                                                <a href="<?php echo base_url ( '/medicines/delete_return_customer_stock/' . $item -> id ) ?>"
                                                   onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                                <label for="exampleInputEmail1">Medicine</label>
                                                <select name="medicine_id[]" class="form-control select2me">
                                                    <?php
                                                        $medicine = get_medicine ( $item -> medicine_id );
                                                        if ( $medicine -> strength_id > 1 ) {
                                                            $strength = get_strength ( $medicine -> strength_id ) -> title;
                                                        }
                                                        else {
                                                            $strength = '';
                                                        }
                                                        if ( $medicine -> form_id > 1 ) {
                                                            $form = get_form ( $medicine -> form_id ) -> title;
                                                        }
                                                        else {
                                                            $form = '';
                                                        }
                                                    ?>
                                                    <option value="<?php echo $medicine -> id ?>">
                                                        <?php
                                                            echo $medicine -> name . ' ' . $strength . ' ' . $form;
                                                        ?>
                                                    </option>
                                                    <?php
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-1">
                                                <label for="exampleInputEmail1">Batch</label>
                                                <input type="text" name="batch[]" readonly="readonly"
                                                       class="form-control"
                                                       value="<?php echo $item -> batch; ?>">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Expiry Date</label>
                                                <input type="text" name="expiry_date[]" class="form-control date-picker"
                                                       value="<?php echo date ( 'm/d/Y', strtotime ( $item -> expiry_date ) ) ?>">
                                            </div>
                                            <div class="form-group col-lg-1">
                                                <label for="exampleInputEmail1">Quantity</label>
                                                <input type="text" name="quantity[]"
                                                       onchange="calculate_customer_return_total(<?php echo $item -> id ?>)"
                                                       class="form-control quantity-<?php echo $item -> id ?>"
                                                       value="<?php echo $item -> quantity; ?>">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Purchase/Unit</label>
                                                <input type="text" name="tp_unit[]"
                                                       class="form-control tp-unit-<?php echo $item -> id ?>"
                                                       value="<?php echo $item -> tp_unit; ?>">
                                            </div>
                                            <div class="form-group col-lg-1">
                                                <label for="exampleInputEmail1">Sale/Unit</label>
                                                <input type="text" name="sale_unit[]"
                                                       onchange="calculate_customer_return_total(<?php echo $item -> id ?>)"
                                                       class="form-control sale-unit-<?php echo $item -> id ?>"
                                                       value="<?php echo $item -> sale_unit; ?>">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Paid To Customer</label>
                                                <input type="text" name="paid_to_customer[]"
                                                       class="form-control paid-customer-<?php echo $item -> id ?>"
                                                       onchange="calculate_paid_to_customer()"
                                                       value="<?php echo $item -> paid_to_customer; ?>">
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                    <?php if ( count ( $stock ) > 0 ) : ?>
                        <div class="form-actions">
                            <button type="submit" class="btn blue" id="sales-btn">Update</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END SAMPLE FORM PORTLET-->