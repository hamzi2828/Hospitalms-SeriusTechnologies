<div class="sale-<?php echo $row ?>" style="display: block; float: left; width: 100%; background: #f5f5f5; padding: 10px 0 0 15px; margin-bottom: 15px; position: relative">
    
    <!-- Lab Test Section -->
    <div class="form-group col-lg-4" style="padding-left: 0">
        <a href="javascript:void(0)" onclick="remove_lab_row(<?php echo $row ?>)">
            <i class="fa fa-trash"></i>
        </a>
        <label>Lab Test</label>
        <?php if (!empty($outsourcing)) { ?>
    <span style="margin-left: 10px" class="label label-success"><?php echo ucfirst($outsourcing); ?></span>
<?php } ?>

        <input type="hidden" name="test_id[]" value="<?php echo $test->id ?>">
        <input type="text" class="form-control" readonly="readonly" value="<?php echo '('.$test->code.') '.$test->name ?>">
    </div>
    
    <!-- Price Section -->
    <div class="form-group col-lg-2" style="padding-left: 0; max-width: 100px">
        <label>Price</label>
        <input type="text" class="form-control price" readonly="readonly" name="price[]" value="<?php echo $price ?>">
    </div>
    
    <!-- Report Date & Time Section -->
    <div class="form-group col-lg-3" style="padding-left: 0; max-width: 160px">
        <label><strong>Report Date & Time</strong></label>
        <input type="datetime-local" 
               name="report-collection-date-time[]" 
               class="form-control"
               value="<?php echo isset($default_datetime) ? $default_datetime : '' ?>"
               placeholder="dd/mm/yyyy --:--">
    </div>

    <!-- Due Dropdown -->
    <div class="form-group col-lg-2" style="padding-left: 5px; max-width: 100px">
        <label><strong>Due</strong></label>
        <select name="due[]" class="form-control">
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>
    </div>

    <!-- Urgent Dropdown -->
    <div class="form-group col-lg-2" style="padding-left: 5px; max-width: 100px">
        <label><strong>Urgent</strong></label>
        <select name="urgent[]" class="form-control">
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>
    </div>

</div>