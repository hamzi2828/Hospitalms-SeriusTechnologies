
<select name="stock_id[]" class="form-control stock-<?php echo $row ?>" onchange="get_stock_available_quantity_adjustments(<?php echo $medicine_id ?>, this.value, <?php echo $row ?>)" required="required" id="stock_id">
    <?php
    if(count($stock) > 0) {
        foreach ($stock as $item) {
            $stock_quantity = $item -> quantity;
            $returned_quantity = get_stock_returned_quantity($item -> id);
            $sold_quantity = check_quantity_sold($item -> medicine_id, $item -> id);
            $issued_quantity = check_issued_quantity($item -> medicine_id, $item -> id);
			$adjustment     = count_medicine_adjustment_by_medicine_id($item -> medicine_id, $item->id);
            $available = $stock_quantity - $sold_quantity - $returned_quantity - $issued_quantity - $adjustment;
            if($available > 0) {
                ?>
                <option value="<?php echo $item->id ?>" <?php if($selected == $item -> id) echo 'selected="selected"' ?>>
                    <?php echo ucwords($item->batch) ?>
                </option>
                <?php
            }
        }
    }
    ?>
</select>