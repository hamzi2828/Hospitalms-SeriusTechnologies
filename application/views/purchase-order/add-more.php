<div class="add-more-order">
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Medicine</label>
        <select name="medicine_id[]" class="form-control js-example-basic-single-<?php echo $row ?>"
                onchange="get_medicine_threshold_value(this.value, <?php echo $row ?>)">
            <option value="">Select Medicine</option>
            <?php
                if ( count ( $medicines ) > 0 ) {
                    foreach ( $medicines as $medicine ) {
                        ?>
                        <option value="<?php echo $medicine -> id ?>">
                            <?php
                                echo $medicine -> name . ' ' . get_strength ( $medicine -> strength_id ) -> title . ' (' . get_form ( $medicine -> form_id ) -> title . ')';
                            ?>
                        </option>
                        <?php
                    }
                }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">Pack Size</label>
        <input type="text" class="form-control pack-size-<?php echo $row ?>" readonly="readonly">
    </div>
    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">Available (Unit)</label>
        <input type="text" class="form-control available-<?php echo $row ?>" readonly="readonly">
    </div>
    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">Threshold (Unit)</label>
        <input type="text" class="form-control threshold-<?php echo $row ?>" readonly="readonly">
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Order Qty (Box)</label>
        <input type="number" name="box_qty[]" class="form-control quantity-<?php echo $row ?>"
               onchange="calculate_purchase_order_total_by_quantity(this.value, <?php echo $row ?>)">
    </div>
    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">TP/Box</label>
        <input type="text" name="tp[]" class="form-control tp-<?php echo $row ?>"
               onchange="calculate_purchase_order_total(this.value, <?php echo $row ?>)" readonly="readonly">
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">App Amount</label>
        <input type="text" name="total[]" class="form-control total-<?php echo $row ?> net-total">
    </div>
</div>