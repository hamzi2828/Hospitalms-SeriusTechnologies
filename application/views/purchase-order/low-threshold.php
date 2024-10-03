<?php
    $row = 0;
    $rows = 1;
    if ( count ( $medicines ) > 0 ) {
        foreach ( $medicines as $key => $medicine ) {
            $random = random_int ( 8000, 18000 );
            $med = get_medicine ( $medicine -> medicine_id );
            $sold = get_sold_quantity ( $medicine -> medicine_id );
            $tp_unit = get_latest_medicine_stock ( $medicine -> medicine_id );
            $quantity = get_stock_quantity ( $medicine -> medicine_id );
            $generic = get_generic ( $med -> generic_id );
            $form = get_form ( $med -> form_id );
            $strength = get_strength ( $med -> strength_id );
            $returned = get_medicine_returned_quantity ( $medicine -> medicine_id );
            $issued = get_issued_quantity ( $medicine -> medicine_id );
            $return_supplier = get_returned_medicines_quantity_by_supplier ( $medicine -> medicine_id );
            $issued = get_issued_quantity ( $medicine -> medicine_id );
            $ipd_issuance = get_ipd_issued_medicine_quantity ( $medicine -> medicine_id );
            $adjustment_qty = get_total_adjustments_by_medicine_id ( $medicine -> medicine_id );
            $expired = get_expired_quantity_medicine_id ( $medicine -> medicine_id );
//            $available = $quantity - $sold - $issued - $ipd_issuance - $return_supplier - $adjustment_qty - $expired;
            $available = get_medicines_available_quantity_by_medicine_id ( $medicine -> medicine_id );
            
            $threshold = $med -> threshold;
            if ( $available < 0 or $threshold > $available ) {
                ?>
                <div class="stock-rows-<?php echo $row ?>"
                     style="display: block; float: left; width: 100%; background: #f5f5f5; padding: 10px 0 0 0; margin-bottom: 15px; position: relative">
                    <span style="position: absolute;left: -10px;font-size: 16px;font-weight: 800;top: 30px;"><?php echo $rows++ ?></span>
                    <div class="form-group col-lg-4">
                        <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)">
                            <i class="fa fa-trash"></i>
                        </a>
                        <label for="exampleInputEmail1">Medicine</label>
                        <select name="medicine_id[]" class="form-control select2me">
                            <option value="<?php echo $medicine -> medicine_id ?>">
                                <?php
                                    echo $med -> name . ' ' . $strength -> title . ' (' . $form -> title . ')';
                                ?>
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="exampleInputEmail1">Pack Size</label>
                        <input type="text" class="form-control" value="<?php echo $med -> quantity ?>"
                               readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">Available</label>
                        <input type="text" class="form-control" readonly="readonly" placeholder="Available Qty"
                               value="<?php echo $available ?>">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">Threshold</label>
                        <input type="text" class="form-control" readonly="readonly" placeholder="Threshold value"
                               value="<?php echo $threshold ?>">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">Order Qty (Box)</label>
                        <input type="number" name="box_qty[]" class="form-control quantity-<?php echo $random ?>"
                               placeholder="Box quantity" required="required"
                               onchange="calculate_purchase_order_total_by_quantity(this.value, <?php echo $random ?>)">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">TP/Box</label>
                        <input type="number" name="tp[]" class="form-control tp-<?php echo $random ?>" placeholder="TP"
                               value="<?php echo $med -> tp_box ?>" required="required" readonly="readonly"
                               onchange="calculate_purchase_order_total(this.value, <?php echo $random ?>)">
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="exampleInputEmail1">App Amount</label>
                        <input type="number" name="total[]" class="form-control total-<?php echo $random ?> net-total"
                               placeholder="Total">
                    </div>
                </div>
                <?php
                $row++;
            }
        }
    }
?>
<script type="text/javascript">
    jQuery ( '#added' ).val ( '<?php echo $rows++ ?>' )
</script>
