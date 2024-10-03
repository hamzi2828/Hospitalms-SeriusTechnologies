<div class="row store-stock-row-<?php echo $added ?>" style="border-bottom: 10px solid #fff;padding-top: 10px;border-top: 10px solid #ffff;">
    <div class="form-group col-lg-3">
        <a href="javascript:void(0)" onclick="remove_store_stock_row(<?php echo $added ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="exampleInputEmail1">Store Item</label>
        <select name="store_id[]" class="form-control js-example-basic-single-<?php echo $added ?>">
            <option value="">Select Item</option>
            <?php
            if(count($stores) > 0) {
                foreach ($stores as $store) {
                    ?>
                    <option value="<?php echo $store -> id ?>">
                        <?php echo $store -> item ?>
                    </option>
                    <?php
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Stock No.</label>
        <input type="text" name="batch[]" class="form-control" value="<?php echo unique_id(4) ?>">
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Expiry Date</label>
        <input type="text" name="expiry[]" class="date date-picker-<?php echo $added ?> form-control">
    </div>
    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">Quantity</label>
        <input type="text" name="quantity[]" class="form-control quantity-<?php echo $added ?>" onchange="calculate_store_stock_net_price(<?php echo $added ?>)">
    </div>
    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">Price</label>
        <input type="text" name="price[]" class="form-control price-<?php echo $added ?>" onchange="calculate_store_stock_net_price(<?php echo $added ?>)">
    </div>
    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">Discount</label>
        <input type="text" name="discount[]" class="form-control discount-<?php echo $added ?>" onchange="calculate_store_stock_net_price(<?php echo $added ?>)">
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Net</label>
        <input type="text" name="net_price[]" class="form-control net-<?php echo $added ?> net-price" readonly="readonly">
    </div>
</div>