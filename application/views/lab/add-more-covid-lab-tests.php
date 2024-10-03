<div class="sale-<?php echo $row ?>">
    <div class="form-group col-lg-4" style="padding-left: 0">
        <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)">
            <i class="fa fa-trash"></i>
        </a>
        <label>Lab Test</label>
        <select name="test_id[]" class="form-control test-<?php echo $row ?>" id="test-<?php echo $row ?>"
                onchange="get_airlines_associated_to_test(this.value, <?php echo $row ?>)">
            <option value="">Select</option>
            <?php
                if ( count ( $tests ) > 0 ) {
                    foreach ( $tests as $test ) {
                        $hasChild = check_if_test_has_sub_tests ( $test -> id );
                        ?>
                        <option value="<?php echo $test -> id ?>" class="<?php if ( $hasChild )
                            echo 'has-child'; ?>">
                            <?php echo '(' . $test -> code . ') ' . $test -> name ?>
                        </option>
                        <?php
                        echo @get_sub_lab_tests ( $test -> id );
                    }
                }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-3" style="padding-left: 0">
        <label>Airline</label>
        <select name="airline_id[]" class="form-control airline-<?php echo $row ?>"
                onchange="get_test_info_by_airline(this.value, <?php echo $row ?>)" id="airlines-<?php echo $row ?>">
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