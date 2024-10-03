<form role="form" method="post" autocomplete="off">
    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
    <input type="hidden" name="selected" value="" id="selected_batch">
    <input type="hidden" name="action" value="do_add_ipd_medication">
    <input type="hidden" id="added" value="1">
    <input type="hidden" name="sale_id" value="<?php echo $sale -> sale_id ?>">
    <input type="hidden" name="patient_id" value="<?php echo $sale -> patient_id ?>">
    <input type="hidden" name="deleted_medication" id="deleted_medication">
    <div class="form-body" style="overflow:auto; overflow-x: hidden">
        <div class="row">
            <div style="display: flex; width: 100%; border-bottom: 1px solid #d5d5d5; float: left; margin-bottom: 15px;">
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                    <input type="text" name="patient_id" class="form-control" placeholder="Add <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>"
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
        
        <div style="min-height: 300px;">
            <div class="row">
                <div class="col-md-4">
                    <select class="form-control select2me"
                            id="sale-medicines-dropdown" data-placeholder="Select Medicines"
                            required="required" onchange="get_stock_for_sale(this.value)" readonly="readonly">
                        <option></option>
                        <?php
                            if ( count ( $medicines ) > 0 ) {
                                foreach ( $medicines as $medicine ) {
                                    ?>
                                    <option value="<?php echo $medicine -> id ?>">
                                        <?php echo $medicine -> name ?>
                                        <?php if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 ) : ?>
                                            (<?php echo get_form ( $medicine -> form_id ) -> title ?> - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
                                        <?php endif ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered" border="1">
                        <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Medicine</th>
                            <th>Batch</th>
                            <th>Available Qty.</th>
                            <th>Sale Qty.</th>
                            <th>Price</th>
                            <th>Net Price</th>
                        </tr>
                        </thead>
                        <tbody id="sale-more-medicine"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="form-group col-lg-offset-9 col-lg-3">
            <label for="exampleInputEmail1">Medication Section Total</label>
            <div class="doctor">
                <input type="text" class="form-control" value="<?php echo number_format ( $total_medication, 2 ) ?>"
                       readonly="readonly">
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
            <a href="<?php echo base_url ( 'IPD/edit-sale/?sale_id=' . $_REQUEST[ 'sale_id' ] . '&tab=medication&action=clear-sale' ) ?>"
               class="btn dark" onclick="return confirm('Are you sure?')">Clear Sale</a>
        <?php endif; ?>
    </div>
</form>