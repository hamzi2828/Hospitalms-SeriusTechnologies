<option></option>
<?php
    if ( count ( $specializations ) > 0 ) {
        foreach ( $specializations as $specialization ) {
            ?>
            <option value="<?php echo $specialization -> id ?>">
                <?php echo $specialization -> title ?>
            </option>
            <?php
        }
    }