<tr>
    <input type="hidden" name="doctor_id[]"
           value="<?php echo $doctor_id ?>">
    <td>
        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column">
            <div class="counter"><?php echo $row ?></div>
        </div>
    </td>
    <td>
        <?php echo get_doctor ( $doctor_id ) -> name ?>
    </td>
    <td>
        <label style="width: 100%">
            <input type="text" name="consultancy_price[]" value="0" placeholder="Panel Charges" class="form-control">
        </label>
    </td>
    <!--    <td>-->
    <!--        <label style="width: 100%">-->
    <!--            <input type="text" name="doc_discount[]" class="form-control" value="0">-->
    <!--        </label>-->
    <!--    </td>-->
    <!--    <td>-->
    <!--        <label style="width: 100%">-->
    <!--            <select name="doc_disc_type[]" class="form-control js-example-basic-single---><?php //echo $row ?><!--">-->
    <!--                <option value="flat">Flat</option>-->
    <!--                <option value="percent">Percent</option>-->
    <!--            </select>-->
    <!--        </label>-->
    <!--    </td>-->
</tr>