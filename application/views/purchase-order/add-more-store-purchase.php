<div class="row-<?php echo $row ?>"
     style="display: block; float: left; width: 100%; background: #f5f5f5; padding: 10px 0 0 0; margin-bottom: 15px; position: relative">
    <div class="form-group col-lg-5">
        <span style="position: absolute;left: -10px;font-size: 16px;font-weight: 800;top: 30px;"><?php echo $row ?></span>
        <a href="javascript:void(0)" onclick="_remove_purchase_order_row(<?php echo $row ?>)">
            <i class="fa fa-trash"></i>
        </a>
        <label for="exampleInputEmail1">Store Item</label>
        <input type="hidden" name="store_id[]" value="<?php echo $item -> id ?>">
        <input type="text" class="form-control" readonly="readonly" value="<?php echo $item -> item ?>">
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Quantity</label>
        <input type="number" name="box_qty[]" class="form-control quantity-<?php echo $row ?>" required="required"
               onchange="calculate_store_purchase_order_total_by_quantity(this.value, <?php echo $row ?>)">
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Price</label>
        <input type="text" name="tp[]" class="form-control tp-<?php echo $row ?>" required="required"
               onchange="calculate_store_purchase_order_total(this.value, <?php echo $row ?>)">
    </div>
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">App Amount</label>
        <input type="text" name="total[]" class="form-control total-<?php echo $row ?> net-total" readonly="readonly">
    </div>
</div>