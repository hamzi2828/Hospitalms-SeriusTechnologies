<tr>
    <input type="hidden" name="opd_service_id[]"
           value="<?php echo $service_id ?>">
    <td>
        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column">
            <div class="counter"><?php echo $row ?></div>
        </div>
    </td>
    <td>
        <?php echo get_service_by_id ( $service_id ) -> title ?>
    </td>
    <td>
        <label style="width: 100%">
            <input type="text" name="opd_service_price[]" value="0" placeholder="Panel Charges" class="form-control">
        </label>
    </td>
    <!--    <td>-->
    <!--        <label style="width: 100%">-->
    <!--            <input type="text" name="opd_discount[]" class="form-control" value="0">-->
    <!--        </label>-->
    <!--    </td>-->
    <!--    <td>-->
    <!--        <label style="width: 100%">-->
    <!--            <select name="opd_type[]" class="form-control js-example-basic-single---><?php //echo $row ?><!--">-->
    <!--                <option value="flat">Flat</option>-->
    <!--                <option value="percent">Percent</option>-->
    <!--            </select>-->
    <!--        </label>-->
    <!--    </td>-->
</tr>