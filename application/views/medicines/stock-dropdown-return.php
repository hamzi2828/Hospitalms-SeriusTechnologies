<select name="stock_id[]" class="form-control stock-<?php echo $row ?>" onchange="get_stock_available_quantity_return(this.value, <?php echo $row ?>)" required="required" id="stock_id">
    <?php
    if(count($stock) > 0) {
        foreach ($stock as $item) {
            $stock_quantity = $item -> quantity;
            $sold_quantity = check_quantity_sold($item -> medicine_id, $item -> id);
            if($stock_quantity > $sold_quantity) {
                ?>
                <option value="<?php echo $item->id ?>">
                    <?php echo ucwords($item->batch) ?>
                </option>
                <?php
            }
        }
    }
    ?>
</select>