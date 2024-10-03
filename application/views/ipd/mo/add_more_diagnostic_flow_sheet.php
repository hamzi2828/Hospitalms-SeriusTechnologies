<div class="form-group col-lg-8">
    <label for="exampleInputEmail1">Lab Test</label>
    <select name="test_id[]" class="form-control select-<?php echo $row ?>">
        <option value="">Select</option>
        <?php
        if (count($tests) > 0) {
            foreach ($tests as $test) {
                $has_parent = check_if_test_has_sub_tests($test->id);
                ?>
                <option value="<?php echo $test->id ?>" class="<?php if ($has_parent) echo 'has-child' ?>">
                    <?php echo $test -> name ?>
                </option>
                <?php
                echo get_child_tests($test->id);
            }
        }
        ?>
    </select>
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Date</label>
    <input type="text" class="form-control date date-picker" name="test_date[]">
</div>