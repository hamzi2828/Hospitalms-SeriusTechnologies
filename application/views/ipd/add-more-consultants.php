<div class="sale-<?php echo $added ?> sale-fields">
    <div class="form-group col-lg-3">
        <a href="javascript:void(0)" onclick="remove_ipd_medication_row(<?php echo $added ?>, 0)"
           style="position: absolute;left: 0;top: 30px;">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="exampleInputEmail1">Procedure</label>
        <select name="service_id[]" class="form-control consultants-<?php echo $added ?>">
            <option value="">Select</option>
            <?php
                if ( count ( $services ) > 0 ) {
                    foreach ( $services as $service ) {
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
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Doctor</label>
        <select name="doctor_id[]" class="form-control consultants-<?php echo $added ?>">
            <option value="">Select</option>
            <?php
                if ( count ( $doctors ) > 0 ) {
                    foreach ( $doctors as $doctor ) {
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
    <div class="form-group col-lg-3">
        <label for="Commission">Commission</label>
        <input type="number" step="0.01" class="form-control fixed-<?php echo $added ?>" name="commission[]"
               required="required" value="0"
               onchange="toggleCommissions(this.value, 'fixed', <?php echo $added ?>)">
    </div>
    <div class="form-group col-lg-3">
        <label for="Commission">
            Commission (%) On IPD Charges <sup style="color: #FF0000; font-weight: 700">*</sup>
        </label>
        <input type="number" step="0.01" max="100" min="0" class="form-control bill-<?php echo $added ?>"
               name="bill-commission[]" value="0" required="required"
               onchange="toggleCommissions(this.value, 'bill', <?php echo $added ?>)">
    </div>
</div>