<div class="row row-<?php echo $row ?>"
     style="display: block; float: left; width: 100%; background: #f5f5f5; padding: 10px 0 15px 0; margin-bottom: 15px; position: relative">
    <input type="hidden" name="product_id[]" value="<?php echo $product -> id ?>">
    
    <div class="form-group col-lg-6">
        <span style="position: absolute;left: -10px;font-size: 16px;font-weight: 800;top: 30px;"><?php echo $row ?></span>
        <a href="javascript:void(0)" onclick="_remove_store_stock_row(<?php echo $row ?>)"
           style="position: absolute;left: 3px;top: 33px; z-index: 999">
            <i class="fa fa-trash-o"></i>
        </a>
        
        <label for="exampleInputEmail1">Item</label>
        <input type="text" readonly="readonly" class="form-control"
               value="<?php echo $product -> name ?>">
    </div>
 
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Stock.No</label>
        <input type="text" name="stock_no[]" class="form-control" readonly="readonly"
               value="<?php echo unique_id ( 4 ) ?>">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Expiry Date</label>
        <input type="text" name="expiry[]" class="date date-picker form-control">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Quantity (Units)</label>
        <input type="text" name="quantity[]" class="form-control quantity-<?php echo $row ?>"
         onchange="calculate_store_cafe_stock_net_price(<?php echo $row ?>)"
        value="">
    </div>

    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">TP/Box</label>
        <input type="text" name="tp_box[]" class="form-control tp-box-<?php echo $row ?>"
               onchange="calculate_tp_unit_price(<?php echo $row ?>)"
               value="<?php echo $product -> tp_box ?>" readonly="readonly">
    </div>

    
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Pack Size</label>
        <input type="text" name="pack_size[]" class="form-control pack-size-<?php echo $row ?>"
               onchange="calculate_tp_unit_price(<?php echo $row ?>)"
               value="<?php echo $product -> quantity ?>" readonly="readonly">
    </div>

    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">TP/Unit</label>
        <input type="text" name="tp_unit[]" class="form-control tp-unit-<?php echo $row ?>"
               onchange="calculate_store_cafe_stock_net_price(<?php echo $row ?>)" 
               value="<?php echo $product -> tp_unit ?>" readonly="readonly">
    </div>

    
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Sale/Box</label>
        <input type="text" name="sale_box[]" class="form-control sale-box-<?php echo $row ?>"
                onchange="calculate_sale_unit_price( <?php echo $row ?>)"
               value="<?php echo $product -> sale_box ?>" readonly="readonly">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Sale/Unit</label>
        <input type="text" name="sale_unit[]" class="form-control sale-unit-<?php echo $row ?>"
               value="<?php echo $product -> sale_unit ?>" readonly="readonly">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Discount (Flat)</label>
        <input type="text" name="discount[]" class="form-control discount-<?php echo $row ?>"
               onchange="calculate_store_cafe_stock_net_price(<?php echo $row ?>)"  value="0.00">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Net</label>
        <input type="text" name="net_price[]" class="form-control net-<?php echo $row ?> net-price"
        value="" readonly="readonly">
    </div>
</div>

