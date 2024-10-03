<select name="stock_id[]" class="form-control stock-<?php echo $row ?>"
        onchange="get_stock_available_quantity(<?php echo $medicine_id ?>, this.value, <?php echo $row ?>)"
        required="required" id="stock_id">
    <?php
        if ( count ( $stock ) > 0 ) {
            foreach ( $stock as $item ) {
                if ( !in_array ( $item -> id, $selected_batch ) ) {
                    $stock_quantity = $item -> quantity;
                    $returned_quantity = get_stock_returned_quantity ( $item -> id );
                    $sold_quantity = check_quantity_sold ( $item -> medicine_id, $item -> id );
                    $issued_quantity = check_issued_quantity ( $item -> medicine_id, $item -> id );
                    $adjustment = count_medicine_adjustment_by_medicine_id ( $item -> medicine_id, $item -> id );
                    
                    $ipd_med = get_ipd_medication_assigned_count_by_stock_and_medicine ( $item -> medicine_id, $item -> id );
                    $adjustment_qty = count_medicine_adjustment_by_medicine_id ( $item -> medicine_id, $item -> id ); // returned by supplier
                    $available = $stock_quantity - $sold_quantity - $returned_quantity - $issued_quantity - $adjustment - $ipd_med;
                    if ( $available > 0 ) {
                        ?>
                        <option value="<?php echo $item -> id ?>" <?php if ( $selected == $item -> id )
                            echo 'selected="selected"' ?>>
                            <?php echo ucwords ( $item -> batch ) ?>
                        </option>
                        <?php
                    }
                }
            }
        }
        else {
            ?>
            <option value="0">No Stock Available</option>
            <?php
        }
    ?>
</select>