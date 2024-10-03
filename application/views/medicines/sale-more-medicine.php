<div class="sale-<?php echo $added ?> sale-fields">
    <div class="form-group col-lg-3">
        <a href="javascript:void(0)" onclick="remove_row(<?php echo $added ?>)" style="position: absolute;left: 0;top: 30px;">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="exampleInputEmail1">Medicine</label>
        <select name="medicine_id[]" class="form-control medicines-list-<?php echo $added ?> js-example-basic-single-<?php echo $added ?>" onchange="get_stock(this.value, <?php echo $added ?>)">
            <option value="">Select Medicine</option>
            <?php
            if(count($medicines) > 0) {
                foreach ($medicines as $medicine) {
                    ?>
                    <option value="<?php echo $medicine -> id ?>">
                        <?php echo $medicine -> name ?>
                        <?php if($medicine -> form_id > 1 or $medicine -> strength_id > 1) : ?>
                        (<?php echo get_form($medicine -> form_id) -> title ?> - <?php echo get_strength($medicine -> strength_id) -> title ?>)
                        <?php endif ?>
                    </option>
                    <?php
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Batch</label>
        <div class="batch">
            <input type="text" class="form-control" readonly="readonly">
        </div>
    </div>
    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">Available</label>
        <input type="text" class="form-control" readonly="readonly" id="available-qty" name="available-qty">
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Sale Qty.</label>
        <input type="text" class="form-control" name="quantity[]" onchange="calculate_net_price(this.value, <?php echo $added ?>)" id="quantity" required="required">
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Price</label>
        <input type="text" class="form-control" readonly="readonly" name="price[]" id="price">
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Net Price</label>
        <input type="text" class="form-control net-price" readonly="readonly" name="net_price[]">
    </div>
</div>