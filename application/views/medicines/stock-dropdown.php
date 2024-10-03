<tr class="sale-<?php echo $row ?>">
    <input type="hidden" name="medicine_id[]" value="<?php echo $medicine -> id ?>">
    <td align="center" width="5%" style="display: flex; flex-direction: column; width: 100%;">
        <?php echo $row ?>
        <a href="javascript:void(0)"
           onclick="remove_ipd_medication_row(<?php echo $row ?>, <?php echo $medicine -> id ?>)">
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
                            $available = count_stock_available_quantity ( $item -> medicine_id, $item );
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
        <input type="text" class="form-control" readonly="readonly" id="available-qty"
               name="available-qty">
    </td>
    <td width="15%">
        <input type="text" class="form-control" name="quantity[]"
               onchange="calculate_net_price(this.value, <?php echo $row ?>)" id="quantity"
               required="required">
    </td>
    <td width="15%">
        <input type="text" class="form-control" readonly="readonly" name="price[]" id="price">
    </td>
    <td width="10%">
        <input type="text" class="form-control net-price" readonly="readonly" name="net_price[]"
               value="">
    </td>
</tr>