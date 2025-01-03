<div class="row row-<?php echo $row ?>"
     style="display: block; float: left; width: 100%; background: #f5f5f5; padding: 10px 0 15px 0; margin-bottom: 15px; position: relative">
    <input type="hidden" name="product_id[]" value="<?php echo $product -> id ?>">
    
    <div class="form-group col-lg-3">
        <span style="position: absolute;left: -10px;font-size: 16px;font-weight: 800;top: 30px;"><?php echo $row ?></span>
        <a href="javascript:void(0)" onclick="_remove_store_stock_row(<?php echo $row ?>)"
           style="position: absolute;left: 3px;top: 33px; z-index: 999">
            <i class="fa fa-trash-o"></i>
        </a>
        
        <label for="exampleInputEmail1">Item</label>
        <input type="text" readonly="readonly" class="form-control"
               value="<?php echo $product -> name ?>">
    </div>

    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Available Qty</label>
        <input type="text" name="available_qty[]" class="form-control available-<?php echo $row ?>"
               value="<?php echo (int) get_product_total_quantity_by_id($product -> id) ?>" readonly="readonly">
    </div>

    
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Sale Qty.</label>
        <input type="number" name="sale_qty[]" class="form-control sale-qty-<?php echo $row ?>"
               onchange="calculate_store_cafe_sale_net_price(<?php echo $row ?>)" value="0" min="0">
    </div>

    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Sale Price</label>
        <input type="text" name="price[]" class="form-control sale_price-<?php echo $row ?>"
               onchange="calculate_store_cafe_sale_net_price(<?php echo $row ?>)"  value="<?php echo $product -> sale_unit ?>">
    </div>
    
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Net</label>
        <input type="text" name="net_price[]" class="form-control net-<?php echo $row ?> net-price"
        value="" readonly="readonly">
    </div>
</div>

