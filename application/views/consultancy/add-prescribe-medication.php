<tr class="row-<?php echo $counter ?>">
    <td>
        <a href="javascript:void(0)"
           onclick="remove_prescription_medication(<?php echo $counter ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
        <?php echo $counter ?>
    </td>
    <td>
        <label>
            <input type="text" name="medicines[]" class="form-control">
        </label>
    </td>
    <td>
        <label>
            <input type="text" name="dosage[]" class="form-control">
        </label>
    </td>
    <td>
        <label>
            <input type="text" name="timings[]" class="form-control">
        </label>
    </td>
    <td>
        <label>
            <input type="text" name="days[]" class="form-control">
        </label>
    </td>
    <td>
        <select data-placeholder="Select" name="instructions[]" class="form-control select2-<?php echo $counter ?>">
            <option></option>
            <?php
                if ( count ( $instructions ) > 0 ) {
                    foreach ( $instructions as $instruction ) {
                        ?>
                        <option value="<?php echo $instruction -> id ?>">
                            <?php echo $instruction -> instruction ?>
                        </option>
                        <?php
                    }
                }
            ?>
        </select>
    </td>
</tr>