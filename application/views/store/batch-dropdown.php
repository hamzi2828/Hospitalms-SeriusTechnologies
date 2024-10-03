<tr class="store-item-<?php echo $row ?>">
    <td style="display: flex; width: 100%; justify-content: center; align-items: center; flex-direction: column"
        width="5%">
        <span><?php echo $row ?></span>
        <a href="javascript:void(0)" onclick="_remove_store_row(<?php echo $row ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
    </td>
    <td width="25%">
        <input type="hidden" name="store_id[]" value="<?php echo $store -> id ?>">
        <?php echo $store -> item ?>
    </td>
    <td width="25%">
        <select name="stock_id[]" id="batch-<?php echo $row ?>" class="form-control batches-<?php echo $row ?>"
                onchange="get_store_stock_available_quantity_return(this.value, <?php echo $row ?>)"
                style="pointer-events: none"
                required="required">
            <?php
                if ( count ( $batches ) > 0 ) {
                    foreach ( $batches as $batch ) {
                        $available = $batch -> quantity - get_stock_sold_quantity ( $batch -> id );
                        if ( !in_array ( $batch -> id, $stock ) and $available > 0 ) {
                            ?>
                            <option value="<?php echo $batch -> id ?>">
                                <?php echo ucwords ( $batch -> batch ) ?>
                            </option>
                            <?php
                        }
                    }
                }
                else {
                    echo '<input type="hidden" value="0" name="stock_id[]">';
                }
            ?>
        </select>
    </td>
    <td width="15%">
        <input type="text" readonly="readonly" class="form-control available-<?php echo $row ?>">
    </td>
    <td width="15%">
        <input type="text" readonly="readonly" class="form-control par-level-<?php echo $row ?>">
    </td>
    <td width="15%">
        <input type="number" min="1" name="quantity[]" class="form-control quantity-<?php echo $row ?>" required="required"
               onkeyup="validate_sale_quantity(this.value, <?php echo $row ?>)">
    </td>
</tr>