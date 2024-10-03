<select class="form-control select2me doctors-drop-down" name="doctor_id" required="required" id="doctor-id"
        onchange="get_doctor_info(this.value)">
    <?php
        if ( count ( $doctors ) > 0 ) {
            ?>
            <option value="">Select Doctor</option>
            <?php
            foreach ( $doctors as $doctor ) {
                ?>
                <option value="<?php echo $doctor -> id ?>"><?php echo $doctor -> name ?></option>
                <?php
            }
        }
    ?>
</select>
