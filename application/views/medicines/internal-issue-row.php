<tr class="sale-<?php echo $row ?>">
    <input type="hidden" name="medicine_id[]" value="<?php echo $medicine -> id ?>">
    <td align="center" width="5%" style="display: flex; flex-direction: column; width: 100%;">
        <?php echo $row ?>
        <a href="javascript:void(0)" onclick="_remove_row(<?php echo $row ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
    </td>
    <td width="20%">
        <?php echo $medicine -> name ?>
        <?php if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 ) : ?>
            (<?php echo get_form ( $medicine -> form_id ) -> title ?> - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
        <?php endif ?>
    </td>
    <td width="20%">
        <select name="stock_id[]" class="form-control stock-<?php echo $row ?>"
                onchange="get_stock_available_quantity(<?php echo $medicine_id ?>, this.value, <?php echo $row ?>)"
                required="required" id="stock_id">
            <?php
                if ( count ( $stock ) > 0 ) {
                    foreach ( $stock as $item ) {
                        if ( !in_array ( $item -> id, $selected_batch ) ) {
                            $stock_quantity    = $item -> quantity;
                            $returned_quantity = get_stock_returned_quantity ( $item -> id );
                            $sold_quantity     = check_quantity_sold ( $item -> medicine_id, $item -> id );
                            $issued_quantity   = check_issued_quantity ( $item -> medicine_id, $item -> id );
                            $adjustment        = count_medicine_adjustment_by_medicine_id ( $item -> medicine_id, $item -> id );
                            
                            $ipd_med        = get_ipd_medication_assigned_count_by_stock_and_medicine ( $item -> medicine_id, $item -> id );
                            $adjustment_qty = count_medicine_adjustment_by_medicine_id ( $item -> medicine_id, $item -> id ); // returned by supplier
                            $available      = $stock_quantity - $sold_quantity - $returned_quantity - $issued_quantity - $adjustment - $ipd_med;
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
    </td>
    <td width="15%">
        <input type="text" class="form-control available-qty-<?php echo $row ?>" readonly="readonly" id="available-qty"
               name="available-qty">
    </td>
    <td width="15%">
        <input type="text" readonly="readonly" class="form-control par-level-<?php echo $row ?>">
    </td>
    <td width="15%">
        <input type="text" class="form-control cost-per-unit-<?php echo $row ?>" readonly="readonly" id="price">
    </td>
    <td width="15%">
        <input type="text" class="form-control quantity-<?php echo $row ?>" name="quantity[]"
               onchange="check_if_quantity_is_valid(this.value, <?php echo $row ?>)" id="quantity"
               required="required">
    </td>
    <td width="15%">
        <input type="text" class="form-control price total-cost-per-unit-<?php echo $row ?>" readonly="readonly">
    </td>
</tr>
