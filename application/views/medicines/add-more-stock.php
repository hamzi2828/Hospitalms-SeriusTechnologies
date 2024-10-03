<div class="stock-rows col-lg-12 stock-rows-<?php echo $added ?>" style="margin-top: 15px">

    <div class="form-group col-lg-4">
        <a href="javascript:void(0)" onclick="remove_row(<?php echo $added ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
        <span style="position: absolute;left: -10px;font-size: 16px;font-weight: 800;top: 30px;"><?php echo $added ?></span>
        <label for="exampleInputEmail1">Medicine</label>
        <select name="medicine_id[]" class="form-control js-example-basic-single-<?php echo $added ?>"  required="required" id="medicine-id-<?php echo $added ?>" onchange="get_medicine(this.value, <?php echo $added ?>)">
            <option value="">Select Medicine</option>
            <?php
            if(count($medicines) > 0) {
                foreach ($medicines as $medicine) {
                    ?>
                    <option value="<?php echo $medicine -> id ?>">
                        <?php
                        echo $medicine -> name . ' ' . get_strength($medicine -> strength_id) -> title . ' (' . get_form($medicine -> form_id) -> title.')';
                        ?>
                    </option>
                    <?php
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Batch#</label>
        <input type="text" name="batch[]" class="form-control batch_number"  required="required">
    </div>

    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Expiry date</label>
        <input type="text" name="expiry_date[]" class="date date-picker-<?php echo $added ?> form-control" placeholder="Expiry date"  required="required">
    </div>

    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Box QTY.</label>
        <input type="number" name="box_qty[]" class="form-control" id="box-qty-<?php echo $added ?>" required="required" min="1" onchange="calculate_quantity(<?php echo $added ?>)">
    </div>

    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Pack size</label>
        <input type="number" name="units[]" class="form-control" id="unit-<?php echo $added ?>" min="1"  onchange="calculate_quantity(<?php echo $added ?>)">
    </div>

    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Total Units</label>
        <input type="text" name="quantity[]" class="form-control" id="quantity-<?php echo $added ?>">
    </div>

    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">TP/Box</label>
        <input type="text" name="box_price[]" class="form-control" required="required" id="box-price-<?php echo $added ?>" onchange="calculate_per_unit_price(<?php echo $added ?>)">
    </div>

    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Total Amount</label>
        <input type="text" name="price[]" class="form-control total-price-<?php echo $added ?>" required="required">
    </div>

    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">Disc.(%)</label>
        <input type="text" name="discount[]" class="form-control discount-<?php echo $added ?> discounts" required="required" onchange="calculate_net_bill(<?php echo $added ?>)" >
    </div>

    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">S.Tax (%)</label>
        <input type="text" name="sales_tax[]" class="form-control s-tax-<?php echo $added ?>" required="required" onchange="calculate_net_bill(<?php echo $added ?>)" >
    </div>

    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">Net</label>
        <input type="text" name="net[]" class="form-control net-<?php echo $added ?> net-price" required="required">
    </div>

    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">Cost/Box</label>
        <input type="text" name="box_price_after_dis_tax[]" class="form-control cost-box-<?php echo $added ?>" required="required">
    </div>

    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">Cost/Unit</label>
        <input type="text" name="tp_unit[]" class="form-control" required="required" id="purchase-price-<?php echo $added ?>" onchange="calculate_total_price(<?php echo $added ?>)">
    </div>

    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">Sale/Box</label>
        <!--                                class=cost-unit-1-->
        <input type="text" name="sale_box[]" class="form-control sale-box-<?php echo $added ?>" required="required" onchange="calculate_sale_price(this.value, <?php echo $added ?>)">
    </div>
    <div class="form-group col-lg-1">
        <label for="exampleInputEmail1">Sale/Unit</label>
        <input type="text" name="sale_unit[]" class="form-control sale-unit-<?php echo $added ?>" required="required">
    </div>
</div>