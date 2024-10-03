<div class="row row-<?php echo $row ?>"
     style="display: block; float: left; width: 100%; background: #f5f5f5; padding: 10px 0 15px 0; margin-bottom: 15px; position: relative">
    <input type="hidden" name="store_id[]" value="<?php echo $store -> id ?>">
    
    <div class="form-group col-lg-6">
        <span style="position: absolute;left: -10px;font-size: 16px;font-weight: 800;top: 30px;"><?php echo $row ?></span>
        
        <a href="javascript:void(0)" onclick="_remove_store_stock_row(<?php echo $row ?>)"
           style="position: absolute;left: 3px;top: 33px; z-index: 999">
            <i class="fa fa-trash-o"></i>
        </a>
        
        <label for="exampleInputEmail1">Item</label>
        <input type="text" readonly="readonly" class="form-control"
               value="<?php echo $store -> item ?>">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Stock.No</label>
        <input type="text" name="batch[]" class="form-control" readonly="readonly"
               value="<?php echo unique_id ( 4 ) ?>">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Expiry Date</label>
        <input type="text" name="expiry[]" class="date date-picker form-control">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Quantity</label>
        <input type="text" name="quantity[]" class="form-control quantity-<?php echo $row ?>"
               onchange="calculate_store_stock_net_price(<?php echo $row ?>)">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Price</label>
        <input type="text" name="price[]" class="form-control price-<?php echo $row ?>"
               onchange="calculate_store_stock_net_price(<?php echo $row ?>)">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Discount</label>
        <input type="text" name="discount[]" class="form-control discount-<?php echo $row ?>"
               onchange="calculate_store_stock_net_price(<?php echo $row ?>)">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Net</label>
        <input type="text" name="net_price[]" class="form-control net-<?php echo $row ?> net-price"
               readonly="readonly">
    </div>
</div>