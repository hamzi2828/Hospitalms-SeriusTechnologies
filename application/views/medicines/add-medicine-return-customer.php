<div class="row return-customer-<?php echo $row ?>">
    <input type="hidden" class="form-control" name="medicine_id[]" value="<?php echo $medicine -> id ?>">
    <div class="col-lg-12">
        <div class="form-group col-lg-5">
            <a href="javascript:void(0)" onclick="remove_customer_return_row(<?php echo $row ?>)">
                <i class="fa fa-trash-o"></i>
            </a>
            <span style="position: absolute;left: -10px;font-size: 16px;font-weight: 800;top: 30px;"><?php echo $row ?></span>
            <label for="exampleInputEmail1">Medicine</label>
            <input type="text" readonly="readonly" class="form-control" value="<?php echo $name ?>">
        </div>
        
        <div class="form-group col-lg-3">
            <label for="exampleInputEmail1">Batch</label>
            <input type="text" name="batch[]" readonly="readonly" class="form-control"
                   value="<?php echo str_pad ( rand ( 0, pow ( 10, 4 ) - 1 ), 4, '0', STR_PAD_LEFT ); ?>">
        </div>
        <div class="form-group col-lg-4">
            <label for="exampleInputEmail1">Expiry Date</label>
            <input type="text" name="expiry_date[]" class="form-control date-picker" required="required">
        </div>
        <div class="form-group col-lg-3">
            <label for="exampleInputEmail1">Quantity In Units</label>
            <input type="text" name="quantity[]" class="form-control quantity-<?php echo $row ?>" required="required"
                   onchange="calculate_customer_return_total(<?php echo $row ?>)">
        </div>
        <div class="form-group col-lg-3">
            <label for="exampleInputEmail1">Purchase/Unit</label>
            <input type="text" name="tp_unit[]" value="<?php echo $tp_unit ?>"
                   class="form-control tp-unit-<?php echo $row ?>" required="required">
        </div>
        <div class="form-group col-lg-3">
            <label for="exampleInputEmail1">Sale/Unit</label>
            <input type="text" name="sale_unit[]" value="<?php echo $sale_unit ?>"
                   class="form-control sale-unit-<?php echo $row ?>" required="required"
                   onchange="calculate_customer_return_total(<?php echo $row ?>)">
        </div>
        <div class="form-group col-lg-3">
            <label for="exampleInputEmail1">Paid To Customer</label>
            <input type="text" name="paid_to_customer[]" value="<?php echo $paid_to_customer ?>"
                   class="form-control paid-to-customer paid-customer-<?php echo $row ?>"
                   onchange="calculate_paid_to_customer()" required="required">
        </div>
    </div>
</div>