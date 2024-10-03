<form role="form" method="post" autocomplete="off">
    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
    <input type="hidden" name="selected" value="" id="selected_batch">
    <input type="hidden" name="action" value="do_add_ipd_medication">
    <input type="hidden" id="added" value="<?php echo count ( $medication ); ?>">
    <input type="hidden" name="sale_id" value="<?php echo $sale -> sale_id ?>">
    <input type="hidden" name="patient_id" value="<?php echo $sale -> patient_id ?>">
    <input type="hidden" name="deleted_medication" id="deleted_medication">
    <div class="form-body" style="overflow:auto; overflow-x: hidden">
        <div class="row">
            <div style="display: flex; width: 100%; border-bottom: 1px solid #d5d5d5; float: left; margin-bottom: 15px;">
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                    <input type="text" name="patient_id" class="form-control"
                           placeholder="Add <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>"
                           autofocus="autofocus" value="<?php echo $sale -> patient_id ?>" required="required"
                           onchange="get_patient(this.value)" readonly="readonly">
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control name" id="patient-name" readonly="readonly"
                           value="<?php echo get_patient ( $sale -> patient_id ) -> name ?>">
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">CNIC</label>
                    <input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly"
                           value="<?php echo get_patient ( $sale -> patient_id ) -> cnic ?>">
                </div>
            </div>
        </div>
        
        <?php
            $med_total = 0;
            $c         = 0;
            if ( count ( $medication ) > 0 ) {
                $med_counter = 0;
                foreach ( $medication as $med ) {
                    $c++;
                    $medicine    = get_medicine ( $med -> medicine_id );
                    $stock       = get_stock ( $med -> stock_id );
                    $available   = count_stock_available_quantity ( $med -> medicine_id, $stock );
                    $med_total   = $med_total + $med -> net_price;
                    $assigned_by = get_user ( $med -> user_id );
                    ?>
                    <input type="hidden" name="medication_id[]" value="<?php echo $med -> id ?>">
                    <div class="sale-<?php echo $med_counter ?> sale-fields"
                         style="display: block;float: left;width: 100%; border: 1px solid #a4a4a4; margin-bottom: 15px; padding-top: 13px; border-radius: 8px !important;">
                        <div class="form-group col-lg-3">
                            <div class="counter"><?php echo $c ?></div>
                            <?php if ( !check_if_ipd_medication_bill_cleared ( $_REQUEST[ 'sale_id' ] ) ) :
                                if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_added_ipd_medication', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                    <a href="<?php echo base_url ( '/IPD/delete_ipd_medication?med_id=' . $med -> id . '&sale_id=' . $sale -> sale_id ) ?>"
                                       onclick="return confirm('Are you sure?')"
                                       style="position: absolute;left: 3px;top: 0;">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                <?php
                                endif;
                            endif;
                            ?>
                            <label for="exampleInputEmail1">Medicine</label>
                            <select name="medicine_id[]" class="form-control select2me" required="required"
                                    style="pointer-events: none">
                                <option value="<?php echo $med -> medicine_id ?>">
                                    <?php echo $medicine -> name ?>
                                    <?php if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 ) : ?>
                                        (<?php echo get_form ( $medicine -> form_id ) -> title ?> - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
                                    <?php endif ?>
                                </option>
                            </select>
                            <label class="pull-right"
                                   style="font-size: 12px; font-style: italic; margin-bottom: 0; padding-top: 7px; display: flex; justify-content: space-between; width: 100%;">
                                <span><?php echo $assigned_by -> name ?></span>
                                <span><?php echo date_setter ( $med -> date_added ) ?></span>
                            </label>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Batch</label>
                            <select name="stock_id[]" class="form-control select2me" required="required"
                                    style="pointer-events: none">
                                <option value="<?php echo $med -> stock_id ?>">
                                    <?php echo $stock -> batch ?>
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Sale Qty.</label>
                            <input type="text" class="form-control data-quantity-<?php echo $med_counter ?>"
                                   name="quantity[]"
                                   readonly="readonly"
                                   id="quantity"
                                   required="required" value="<?php echo $med -> quantity ?>"
                                   data-quantity="<?php echo $med -> quantity ?>">
                        </div>
                        <div class="form-group col-lg-1">
                            <label for="exampleInputEmail1">Price</label>
                            <input type="text" class="form-control" readonly="readonly" name="price[]" id="price"
                                   value="<?php echo $med -> price ?>">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Net Price</label>
                            <input type="text" class="form-control net-price" readonly="readonly" name="net_price[]"
                                   value="<?php echo $med -> net_price ?>">
                        </div>
                    </div>
                    <?php
                    $med_counter++;
                }
            }
        ?>
        <div id="sale-more-ipd-medicine"></div>
    </div>
    <br>
    <div class="row">
        <div class="form-group col-lg-offset-9 col-lg-3">
            <label for="exampleInputEmail1">Medication Section Total</label>
            <div class="doctor">
                <input type="text" class="form-control" value="<?php echo $med_total ?>" readonly="readonly">
            </div>
        </div>
    </div>
    <div class="">
        <div class="row">
            <div class="form-group col-lg-offset-9 col-lg-3">
                <label for="exampleInputEmail1">Total</label>
                <div class="doctor">
                    <input type="text" class="total form-control" name="total"
                           value="<?php echo $sale_billing -> total ?>" readonly="readonly">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-offset-9 col-lg-3">
                <label for="exampleInputEmail1">Discount <small>(Flat)</small></label>
                <div class="doctor">
                    <input type="text" class="discount form-control" onchange="calculate_ipd_net_bill()" name="discount"
                           value="<?php echo $sale_billing -> discount ?>" readonly="readonly">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-offset-9 col-lg-3">
                <label for="exampleInputEmail1">Net Total</label>
                <div class="doctor">
                    <input type="text" class="net-total form-control" name="net_total"
                           value="<?php echo $sale_billing -> net_total ?>" readonly="readonly">
                </div>
            </div>
        </div>
        <div class="row" style="display: none">
            <div class="form-group col-lg-offset-9 col-lg-3">
                <label for="exampleInputEmail1">Initial Deposit</label>
                <div class="doctor">
                    <input type="text" class="form-control" name="initial_deposit"
                           value="<?php echo $sale_billing -> initial_deposit ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php if ( !check_if_ipd_medication_bill_cleared ( $_REQUEST[ 'sale_id' ] ) ) : ?>
            <button type="submit" class="btn blue" id="sales-btn">Update</button>
        <?php endif; ?>
        <a class="btn purple"
           href="<?php echo base_url ( '/invoices/ipd-medication-invoices?sale_id=' . $_REQUEST[ 'sale_id' ] ) ?>"
           target="_blank"
           style="display: inline">Print</a>
        <a <?php if ( check_if_ipd_medication_bill_cleared ( $_REQUEST[ 'sale_id' ] ) ) { ?> onclick="return false;" disabled="disabled" <?php } ?>
                class="btn red" href="<?php echo base_url ( '/IPD/clear_bill?sale_id=' . $_REQUEST[ 'sale_id' ] ) ?>"
                style="display: inline">
            <?php if ( check_if_ipd_medication_bill_cleared ( $_REQUEST[ 'sale_id' ] ) )
                echo 'Bill Cleared';
            else echo 'Clear Bill' ?>
        </a>
    </div>
</form>