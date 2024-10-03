<div class="stock-rows stock-rows-<?php echo $row ?> col-lg-12">
    
    <div class="form-group col-lg-6">
        <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
        <span style="position: absolute;left: -10px;font-size: 16px;font-weight: 800;top: 30px;"><?php echo $row ?></span>
        <label for="exampleInputEmail1">Medicine</label>
        <input type="text" readonly="readonly" class="form-control" value="<?php echo $name ?>">
        <input type="hidden" class="form-control" name="medicine_id[]" value="<?php echo $medicine -> id ?>">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Batch#</label>
        <input type="text" name="batch[]" class="form-control batch_number"
               required="required">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Expiry date</label>
        <input type="text" name="expiry_date[]"
               class="date date-picker form-control" placeholder="Expiry date"
               required="required">
    </div>
    
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Box QTY.</label>
        <input type="number" name="box_qty[]" class="form-control"
               id="box-qty-<?php echo $row ?>" required="required" min="1"
               onchange="calculate_quantity(<?php echo $row ?>)">
    </div>
    
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Pack Size</label>
        <input type="number" name="units[]" class="form-control"
               id="unit-<?php echo $row ?>" min="1" value="<?php echo $medicine -> quantity ?>"
               onchange="calculate_quantity(<?php echo $row ?>)">
    </div>
    
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Total Units</label>
        <input type="text" name="quantity[]" class="form-control"
               id="quantity-<?php echo $row ?>">
    </div>
    
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">TP/Box</label>
        <input type="text" name="box_price[]" class="form-control"
               required="required" id="box-price-<?php echo $row ?>" value="<?php echo $medicine -> tp_box ?>"
               onchange="calculate_per_unit_price(<?php echo $row ?>)">
    </div>
    
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Total Amount</label>
        <input type="text" name="price[]"
               class="form-control total-price-<?php echo $row ?>"
               required="required">
    </div>
    
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Disc.(%)</label>
        <input type="text" name="discount[]"
               class="form-control discount-<?php echo $row ?> discounts"
               required="required"
               onchange="calculate_net_bill(<?php echo $row ?>)">
    </div>
    
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">S.Tax (%)</label>
        <input type="text" name="sales_tax[]"
               class="form-control s-tax-<?php echo $row ?>" required="required"
               onchange="calculate_net_bill(<?php echo $row ?>)">
    </div>
    
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Net</label>
        <input type="text" name="net[]"
               class="form-control net-<?php echo $row ?> net-price"
               required="required">
    </div>
    
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Cost/Box</label>
        <input type="text" name="box_price_after_dis_tax[]"
               class="form-control cost-box-<?php echo $row ?>"
               required="required">
    </div>
    
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Cost/Unit</label>
        <input type="text" name="tp_unit[]" class="form-control"
               required="required" id="purchase-price-<?php echo $row ?>" value="<?php echo $medicine -> tp_unit ?>"
               onchange="calculate_total_price(<?php echo $row ?>)">
    </div>
    
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Sale/Box</label>
        <input type="text" name="sale_box[]"
               class="form-control sale-box-<?php echo $row ?>"
               required="required" value="<?php echo $medicine -> sale_box ?>"
               onchange="calculate_sale_price(this.value, <?php echo $row ?>)">
    </div>
    
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Sale/Unit</label>
        <input type="text" name="sale_unit[]" value="<?php echo $medicine -> sale_unit ?>"
               class="form-control sale-unit-<?php echo $row ?>"
               required="required">
    </div>
</div>