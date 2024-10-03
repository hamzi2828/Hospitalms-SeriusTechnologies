<tr class="sale-<?php echo $row ?>">
    <td style="display: flex; justify-content: center; align-items: center; flex-direction: column; width: 100%;">
        <?php echo $row ?>
        <a href="javascript:void(0)" onclick="_remove_op_sale_row(<?php echo $row ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
    </td>
    
    <td>
        <input type="hidden" name="service_id[]" value="<?php echo $service -> id ?>">
        <?php
            echo $service -> title;
            if ( !empty( trim ( $service -> code ) ) )
                echo ' (' . $service -> code . ')';
        ?>
    </td>
    
    <td>
        <input type="text" class="form-control service-price price-<?php echo $row ?>" name="price[]"
               readonly="readonly"
               value="<?php echo $charges ?>">
    </td>
</tr>