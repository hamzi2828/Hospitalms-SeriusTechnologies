<form role="form" method="post" autocomplete="off">
    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
    <input type="hidden" name="action" value="do_add_ipd_lab_tests">
    <input type="hidden" id="added" value="<?php echo count ( $ipd_lab_tests ); ?>">
    <input type="hidden" name="sale_id" value="<?php echo $sale -> sale_id ?>">
    <input type="hidden" name="patient_id" value="<?php echo $sale -> patient_id ?>">
    <input type="hidden" name="deleted_ipd_lab_tests" id="deleted_ipd_lab_tests">
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
            $test_total = 0;
            $c          = 0 + ( @$_GET[ 'per_page' ] );
            if ( count ( $ipd_lab_tests ) > 0 ) {
                $test_counter = 0;
                foreach ( $ipd_lab_tests as $ipd_lab_test ) {
                    $c++;
                    $test_total  = $test_total + $ipd_lab_test -> net_price;
                    $assigned_by = get_user ( $ipd_lab_test -> user_id );
                    ?>
                    <div class="test-<?php echo $test_counter ?>"
                         style="display: block;float: left;width: 100%; border: 1px solid #a4a4a4; margin-bottom: 15px; padding-top: 13px; border-radius: 8px !important;">
                        <input type="hidden" name="ipd_lab_test_id[]" value="<?php echo $ipd_lab_test -> id ?>">
                        <div class="form-group col-lg-6">
                            <div class="counter"><?php echo $c ?></div>
                            <input type="checkbox" name="print-lab-selected[]"
                                   value="<?php echo $ipd_lab_test -> id ?>">
                            <?php
                                if ( !check_if_ipd_lab_bill_cleared ( $_REQUEST[ 'sale_id' ] ) ) :
                                    if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_added_ipd_lab_tests', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                        <a href="javascript:void(0)"
                                           onclick="remove_test_row(<?php echo $test_counter ?>, <?php echo $ipd_lab_test -> id ?>)"
                                           style="margin-right: 5px">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    <?php
                                    endif;
                                endif;
                            ?>
                            <a href="<?php echo base_url ( '/invoices/ipd-lab-test/' . $ipd_lab_test -> id ) ?>"
                               target="_blank"
                               style="margin-right: 5px">
                                <i class="fa fa-print"></i>
                            </a>
                            <label for="exampleInputEmail1">Lab Test</label>
                            <input type="hidden" name="test_id[]" value="<?php echo $ipd_lab_test -> test_id ?>">
                            <select class="form-control select2me" disabled="disabled">
                                <option>
                                    <?php echo get_test_by_id ( $ipd_lab_test -> test_id ) -> name ?>
                                </option>
                            </select>
                            <label class="pull-left"
                                   style="font-size: 12px; font-style: italic; margin-bottom: 0; padding-top: 7px; display: flex; justify-content: space-between; width: 100%;">
                                <span><?php echo $assigned_by -> name ?></span>
                                <span><?php echo date_setter ( $ipd_lab_test -> date_added ) ?></span>
                            </label>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Price</label>
                            <input type="text" name="test_price[]" class="form-control test-price" readonly="readonly"
                                   required="required" value="<?php echo $ipd_lab_test -> price; ?>">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Discount(%)</label>
                            <input type="text" name="test_discount[]" class="form-control test-discount"
                                   value="<?php echo $ipd_lab_test -> discount; ?>" required="required"
                                   onchange="calculate_ipd_sale_test_discount(this.value, <?php echo $test_counter ?>)"
                                   readonly="readonly">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Net Price</label>
                            <input type="text" name="net_price[]" class="form-control net-price"
                                   value="<?php echo $ipd_lab_test -> net_price; ?>" required="required">
                        </div>
                    </div>
                    <?php
                    $test_counter++;
                }
            }
        ?>
        <div class="assign-more-tests" style="display: block;float: left;width: 100%;"></div>
        <div id="pagination" style="float: left">
            <ul class="tsc_pagination">
                <!-- Show pagination links -->
                <?php foreach ( $links as $link ) {
                    echo "<li>" . $link . "</li>";
                } ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="form-group col-lg-offset-9 col-lg-3">
            <label for="exampleInputEmail1">Lab Section Total</label>
            <div class="doctor">
                <input type="text" class="form-control" value="<?php echo $test_total ?>" readonly="readonly">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-offset-9 col-lg-3">
            <label for="exampleInputEmail1">Total</label>
            <div class="doctor">
                <input type="text" class="total form-control" name="total" value="<?php echo $sale_billing -> total ?>"
                       readonly="readonly">
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
    <div class="form-actions">
        <?php if ( !check_if_ipd_lab_bill_cleared ( $_REQUEST[ 'sale_id' ] ) ) : ?>
            <button type="submit" class="btn blue">Update</button>
        <?php endif; ?>
        <a class="btn purple"
           href="<?php echo base_url ( '/invoices/ipd-lab-tests?sale_id=' . $_REQUEST[ 'sale_id' ] ) ?>" target="_blank"
           style="display: inline">Print All</a>
        <button type="submit" class="btn purple" style="display: inline">Print Selected</button>
        <a <?php if ( check_if_ipd_lab_bill_cleared ( $_REQUEST[ 'sale_id' ] ) ) { ?> onclick="return false;" disabled="disabled" <?php } ?>
                class="btn red"
                href="<?php echo base_url ( '/IPD/clear_lab_bill?sale_id=' . $_REQUEST[ 'sale_id' ] ) ?>"
                style="display: inline">
            <?php if ( check_if_ipd_lab_bill_cleared ( $_REQUEST[ 'sale_id' ] ) )
                echo 'Bill Cleared';
            else echo 'Clear Bill' ?>
        </a>
    </div>
</form>