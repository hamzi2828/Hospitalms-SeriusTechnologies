<div class="sale-<?php echo $row ?>">
    <div class="form-group col-lg-7" style="padding-left: 0">
        <a href="javascript:void(0)" onclick="remove_lab_row(<?php echo $row ?>)">
            <i class="fa fa-trash"></i>
        </a>
        <label>Lab Test</label>
        <select name="test_id[]" class="form-control test-<?php echo $row ?>" onchange="get_test_info(this.value, <?php echo $row ?>)">
            <option value="">Select</option>
            <?php
            if(count ($tests) > 0) {
                foreach ($tests as $test) {
                    $hasChild = check_if_test_has_sub_tests ($test -> id);
                    ?>
                    <option value="<?php echo $test -> id ?>" class="<?php if($hasChild) echo 'has-child'; ?>">
                        <?php echo '('.$test -> code.') '.$test -> name ?>
                    </option>
            <?php
//                    echo @get_sub_lab_tests($test -> id);
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-2" style="padding-left: 0; display: none">
        <label>TAT</label>
        <input type="text" class="form-control tat-<?php echo $row ?>" readonly="readonly">
    </div>
    <div class="form-group col-lg-2" style="padding-left: 0">
        <label>Price</label>
        <input type="text" class="form-control price price-<?php echo $row ?>" readonly="readonly" name="price[]">
    </div>
    <div class="col-lg-3">
        <label><strong>Report Collection Date & Time</strong></label>
        <input type="datetime-local" name="report-collection-date-time[]" class="form-control">
    </div>
</div>