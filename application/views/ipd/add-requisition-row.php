<div class="sale-<?php echo $row ?>" style="display: block; float: left; width: 100%; background: #f5f5f5; padding: 10px 0 15px 0; margin-bottom: 15px; position: relative">
    <?php
        $name = $medicine -> name;
        $form = get_form ( $medicine -> form_id );
        $strength = get_strength ( $medicine -> strength_id );
        
        if ( !empty( $form ) )
            $name .= ' ' . $form -> title;
        
        if ( !empty( $strength ) )
            $name .= ' ' . $strength -> title;
    ?>
    <input type="hidden" name="medicine_id[]" value="<?php echo $medicine -> id ?>">
    <div class="form-group col-lg-4">
        <a href="javascript:void(0)"
           onclick="remove_ipd_requisition_row(<?php echo $row ?>)"
           style="position: absolute;left: 0;top: 30px;">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="exampleInputEmail1">Medicine</label>
        <input type="text" class="form-control" readonly="readonly" value="<?php echo $name ?>">
    </div>
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Frequency</label>
        <select name="frequency[]" class="form-control select2me-<?php echo $medicine -> id ?>" required="required">
            <option value="OD">
                OD
            </option>
            <option value="BID">
                BID
            </option>
            <option value="TID">
                TID
            </option>
            <option value="QID">
                QID
            </option>
            <option value="HS">
                HS
            </option>
            <option value="STAT">
                STAT
            </option>
            <option value="SOS">
                SOS
            </option>
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Quantity</label>
        <input type="text" class="form-control" name="quantity[]" id="quantity"
               required="required">
    </div>
</div>