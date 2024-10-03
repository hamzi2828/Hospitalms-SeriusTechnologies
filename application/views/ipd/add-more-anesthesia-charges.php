<div class="sale-<?php echo $added ?> sale-fields">
    <div class="form-group col-lg-4">
        <a href="javascript:void(0)" onclick="remove_ipd_medication_row(<?php echo $added ?>, 0)"
           style="position: absolute;left: 0;top: 30px;">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="exampleInputEmail1">Procedure</label>
        <select name="service_id[]" class="form-control consultants-<?php echo $added ?>">
            <option value="">Select</option>
            <?php
                if ( count ( $anesthesia_services ) > 0 ) {
                    foreach ( $anesthesia_services as $service ) {
                        $has_parent = check_if_service_has_child ( $service -> id );
                        ?>
                        <option value="<?php echo $service -> id ?>" class="<?php if ( $has_parent )
                            echo 'has-child' ?>" <?php if ( $has_parent ) echo 'disabled="disabled"' ?>>
                            <?php echo $service -> title ?>
                        </option>
                        <?php
                        echo get_sub_child ( $service -> id );
                    }
                }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Doctor</label>
        <select name="doctor_id[]" class="form-control consultants-<?php echo $added ?>">
            <option value="">Select</option>
            <?php
                if ( count ( $anesthesiologists ) > 0 ) {
                    foreach ( $anesthesiologists as $doctor ) {
                        ?>
                        <option value="<?php echo $doctor -> id ?>">
                            <?php echo $doctor -> name ?>
                        </option>
                        <?php
                    }
                }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label for="Commission">Commission</label>
        <input type="number" step="0.01" class="form-control fixed-<?php echo $added ?>" name="commission[]"
               required="required" value="0">
    </div>
</div>