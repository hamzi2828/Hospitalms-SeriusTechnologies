<div class="row-<?php echo $row ?>"
     style="display: block; float: left; width: 100%; background: #f5f5f5; padding: 10px 0 0 0; margin-bottom: 15px; position: relative">
    
    <input type="hidden" name="medicine_id[]" value="<?php echo $medicine -> id ?>">
    <div class="form-group col-lg-4">
        <span style="position: absolute;left: -10px;font-size: 16px;font-weight: 800;top: 30px;"><?php echo $row ?></span>
        <a href="javascript:void(0)" onclick="_remove_purchase_order_row(<?php echo $row ?>)">
            <i class="fa fa-trash"></i>
        </a>
        
        <label for="exampleInputEmail1">Medicine</label>
        <?php
            $name = $medicine -> name;
            if ( $medicine -> strength_id > 0 )
                $name .= ' ' . get_strength ( $medicine -> strength_id ) -> title;
            
            if ( $medicine -> form_id > 0 )
                $name .= ' (' . get_form ( $medicine -> form_id ) -> title . ')';
        ?>
        <input type="text" readonly="readonly" class="form-control" value="<?php echo $name ?>">
    </div>
    
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Pack Size</label>
        <input type="text" class="form-control pack-size-<?php echo $row ?>"
               value="<?php echo $medicine -> quantity ?>" readonly="readonly">
    </div>
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Available (Unit)</label>
        <input type="text" class="form-control available-<?php echo $row ?>" readonly="readonly"
               value="<?php echo $available ?>">
    </div>
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Threshold (Unit)</label>
        <input type="text" class="form-control threshold-<?php echo $row ?>" readonly="readonly"
               value="<?php echo $medicine -> threshold ?>">
    </div>
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Order Qty (Box)</label>
        <input type="number" name="box_qty[]" class="form-control quantity-<?php echo $row ?>" required="required"
               onchange="calculate_purchase_order_total_by_quantity(this.value, <?php echo $row ?>)">
    </div>
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">TP/Box</label>
        <input type="text" name="tp[]" class="form-control tp-<?php echo $row ?>" required="required"
               onchange="calculate_purchase_order_total(this.value, <?php echo $row ?>)" readonly="readonly"
               value="<?php echo $medicine -> tp_box ?>">
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">App Amount</label>
        <input type="text" name="total[]" class="form-control total-<?php echo $row ?> net-total">
    </div>
</div>