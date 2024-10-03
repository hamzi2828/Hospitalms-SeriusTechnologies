<tr class="row-<?php echo $row ?>">
    <td>
        <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
        <?php echo $row ?>
    </td>
    <td>
        <?php echo $store -> item ?>
    </td>
    <td>
        <input type="hidden" value="<?php echo $store -> id ?>" name="store_id[]">
        <label>
            <input type="number" min="1" class="form-control quantity-<?php echo $row ?>" value="1" name="quantity[]"
                   required="required">
        </label>
    </td>
    <td>
        <label>
            <input type="number" step="0.01" min="0" class="form-control price-<?php echo $row ?>" name="price[]"
                   required="required" value="<?php echo $price ?>">
        </label>
    </td>
    <td>
        <label>
            <textarea class="form-control" name="description[]" rows="3"></textarea>
        </label>
    </td>
</tr>