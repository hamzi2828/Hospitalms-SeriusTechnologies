<div class="test-<?php echo $row ?>" style="display: block; float: left; width: 100%; background: #f5f5f5; padding: 10px 0 15px 0; margin-bottom: 15px; position: relative">
    <a href="javascript:void(0)" onclick="_remove_ipd_lab_test_row(<?php echo $row ?>)"
       style="position: absolute;left: 0;top: 42px; z-index: 999">
        <i class="fa fa-trash-o"></i>
    </a>
    <input type="hidden" name="test_id[]" value="<?php echo $test -> id ?>">
    <div class="form-group col-lg-6">
        <label>Lab Test</label>
        <input type="text" class="form-control" readonly="readonly" value="<?php echo $test -> name ?>">
    </div>
    <div class="form-group col-lg-2">
        <label>Price</label>
        <input type="text" name="test_price[]" class="form-control test-price" readonly="readonly"
               required="required" value="<?php echo $price ?>">
    </div>
    <div class="form-group col-lg-2">
        <label>Discount(%)</label>
        <input type="text" name="test_discount[]" class="form-control test-discount" value="0"
               required="required" onchange="calculate_ipd_sale_test_discount(this.value, <?php echo $row ?>)">
    </div>
    <div class="form-group col-lg-2">
        <label>Net Price</label>
        <input type="text" name="net_price[]" class="form-control net-price" value="<?php echo $price ?>" required="required">
    </div>
</div>