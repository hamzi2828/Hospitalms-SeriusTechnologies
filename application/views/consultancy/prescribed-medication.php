<?php
    if ( count ( $prescribed_medicines ) > 0 ) {
        foreach ( $prescribed_medicines as $prescribed_medicine ) {
            ?>
            <div class="form-group col-lg-12" style="padding: 0">
                <?php if ( count ( $medicines ) > 0 ) : ?>
                    <div class="form-group col-lg-3">
                        <label
                                style="display: block; float: left; width: 100%; font-size: 18px; font-weight: 900">Medicines</label>
                        <select name="medicines[]" class="form-control select2me">
                            <option value="">Select</option>
                            <?php
                                foreach ( $medicines as $medicine ) {
                                    ?>
                                    <option
                                            value="<?php echo $medicine -> id ?>" <?php if ( $prescribed_medicine -> medicine_id == $medicine -> id ) echo 'selected="selected"' ?>>
                                        <?php echo $medicine -> name ?>
                                        <?php if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 ) : ?>
                                            (<?php echo get_form ( $medicine -> form_id ) -> title ?> - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
                                        <?php endif ?>
                                    </option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                <?php endif; ?>
                <div class="form-group col-lg-2">
                    <label>Dosage</label>
                    <input type="text" name="dosage[]" class="form-control"
                           value="<?php echo $prescribed_medicine -> dosage ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label>Timings</label>
                    <input type="text" name="timings[]" class="form-control"
                           value="<?php echo $prescribed_medicine -> timings ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label>Days</label>
                    <input type="text" name="days[]" class="form-control"
                           value="<?php echo $prescribed_medicine -> days ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label>Instructions</label>
                    <select name="instructions[]" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $instructions ) > 0 ) {
                                foreach ( $instructions as $instruction ) {
                                    ?>
                                    <option
                                            value="<?php echo $instruction -> id ?>" <?php if ( @$prescribed_medicine -> instructions == $instruction -> id ) echo 'selected="selected"'; ?>>
                                        <?php echo $instruction -> instruction ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <?php
        }
    }
?>