<div class="row row-<?php echo $row ?>">
    <input type="hidden" class="form-control" name="medicine_id[]" value="<?php echo $medicine -> id ?>">
    
    <div class="form-group col-lg-6">
        <a href="javascript:void(0)" onclick="_remove_row(<?php echo $row ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
        <span style="position: absolute;left: -10px;font-size: 16px;font-weight: 800;top: 30px;"><?php echo $row ?></span>
        <label for="exampleInputEmail1">Medicine</label>
        <input type="text" readonly="readonly" class="form-control" value="<?php echo $name ?>">
    </div>
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Batch</label>
        <input type="text" name="batch[]" readonly="readonly" class="form-control"
               value="<?php echo unique_id ( 4 ); ?>">
    </div>
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Expiry Date</label>
        <input type="text" name="expiry_date[]" class="form-control date-picker" required="required">
    </div>
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Box QTY.</label>
        <input type="number" name="box_qty[]" class="form-control" id="box-qty-<?php echo $row ?>"
               min="1" required="required">
    </div>
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Total Units</label>
        <input type="text" name="quantity[]" class="form-control t-units-<?php echo $row ?>" required="required"
               value="">
    </div>
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">TP/Unit</label>
        <input type="text" name="tp_unit[]"
               class="form-control purchase-per-unit-<?php echo $row ?>"
               onchange="calculate_net_local_purchase(<?php echo $row ?>)" required="required">
    </div>
    <!--                            onchange="calculate_total_purchase_price()"-->
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Total</label>
        <input type="text" readonly="readonly"
               class="form-control purchase-total purchase-total-<?php echo $row ?>" required="required">
    </div>
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Sale/Unit</label>
        <input type="text" name="sale_unit[]" class="form-control" required="required"
               value="">
    </div>
    <div class="form-group col-lg-9">
        <label for="exampleInputEmail1">Description</label>
        <textarea rows="3" name="description[]" class="form-control"></textarea>
    </div>
</div>