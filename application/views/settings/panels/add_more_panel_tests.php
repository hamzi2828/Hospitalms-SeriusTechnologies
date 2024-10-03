<tr>
    <input type="hidden" name="test_id[]"
           value="<?php echo $test_id ?>">
    <td>
        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column">
            <div class="counter"><?php echo $row ?></div>
        </div>
    </td>
    <td>
        <?php
            $testInfo = get_test_by_id ( $test_id );
            echo '(' . $testInfo -> code . ') ' . $testInfo -> name;
        ?>
    </td>
    <td>
        <label style="width: 100%">
            <input type="text" name="price[]" value="0" placeholder="Panel Charges" class="form-control">
        </label>
    </td>
    <!--    <td>-->
    <!--        <label style="width: 100%">-->
    <!--            <input type="text" name="discount[]" class="form-control" value="0">-->
    <!--        </label>-->
    <!--    </td>-->
    <!--    <td>-->
    <!--        <label style="width: 100%">-->
    <!--            <select name="type[]" class="form-control js-example-basic-single---><?php //echo $row ?><!--">-->
    <!--                <option value="flat">Flat</option>-->
    <!--                <option value="percent">Percent</option>-->
    <!--            </select>-->
    <!--        </label>-->
    <!--    </td>-->
</tr>