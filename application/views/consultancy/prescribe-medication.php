<div class="col-lg-12">
    <label for="medicines" style="display: block; width: 100%; font-size: 18px; font-weight: 900">
        Prescribed Medications
    </label>
    <table cellpadding="8" width="100%" border="1">
        <thead>
        <tr>
            <th>Sr.No</th>
            <th>Medicine</th>
            <th>Dosage</th>
            <th>Timings</th>
            <th>Days</th>
            <th>Instructions</th>
        </tr>
        </thead>
        <tbody id="medication">
        <?php
            $counter = 1;
            if ( count ( $prescribed_medicines ) > 0 ) {
                foreach ( $prescribed_medicines as $prescribed_medicine ) {
                    $medicine = get_medicine ( $prescribed_medicine -> medicine_id );
                    ?>
                    <tr>
                        <td>
                            <a href="<?php echo base_url ( '/consultancy/prescription/delete-medication/' . $prescribed_medicine -> id ) ?>"
                               onclick="return confirm('Are you sure?')">
                                <i class="fa fa-trash-o"></i>
                            </a>
                            <?php echo $counter++ ?>
                        </td>
                        <td>
                            <label>
                                <input type="text" name="medicines[]" class="form-control" required="required"
                                       value="<?php echo $prescribed_medicine -> name ?>">
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="text" name="dosage[]" class="form-control"
                                       value="<?php echo $prescribed_medicine -> dosage ?>">
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="text" name="timings[]" class="form-control"
                                       value="<?php echo $prescribed_medicine -> timings ?>">
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="text" name="days[]" class="form-control"
                                       value="<?php echo $prescribed_medicine -> days ?>">
                            </label>
                        </td>
                        <td>
                            <input type="hidden" name="instructions[]"
                                   value="<?php echo $prescribed_medicine -> instructions ?>">
                            <?php
                                $instruction = get_instruction_by_id ( $prescribed_medicine -> instructions );
                                echo $instruction -> instruction;
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }
        ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="6" align="right">
                <button class="btn btn-primary btn-xs" type="button" id="add-more-prescription-medications">
                    Add More
                </button>
            </td>
        </tr>
        </tfoot>
    </table>
</div>