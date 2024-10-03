<div class="sale-<?php echo $row ?>">
    <div class="form-group col-lg-6" style="padding-left: 0">
        <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)">
            <i class="fa fa-trash"></i>
        </a>
        <label>Test</label>
        <select name="test_id[]" class="form-control test-<?php echo $row ?>">
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
                    echo @get_sub_lab_tests($test -> id);
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-6" style="padding-left: 0">
        <label>No. of Time Calibrated</label>
        <input type="text" class="form-control" name="calibrated[]">
    </div>
</div>