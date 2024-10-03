<div class="col-lg-12 text-center bg-dark" style="margin: 15px 0;">
    <h3 style="margin: 0; padding: 10px;"> Employment Details </h3>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Department <sup style="color: #FF0000; font-weight: 700">*</sup></label>
    <select name="department_id" class="form-control select2me" required="required">
        <option value="">Select</option>
        <?php
            if ( count ( $departments ) > 0 ) {
                foreach ( $departments as $department ) {
                    ?>
                    <option value="<?php echo $department -> id ?>" <?php if ( $personal -> department_id == $department -> id ) echo 'selected=selected"' ?>>
                        <?php echo $department -> name ?>
                    </option>
                    <?php
                }
            }
        ?>
    </select>
</div>

<div class="form-group col-lg-3">
    <label for="post-id">Post/Designation <sup style="color: #FF0000; font-weight: 700">*</sup></label>
    <select name="post-id" id="post-id" class="form-control select2me" data-placeholder="Select"
            data-allow-clear="true" required="required">
        <option></option>
        <?php
            if ( count ( $posts ) > 0 ) {
                foreach ( $posts as $post ) {
                    ?>
                    <option value="<?php echo $post -> id; ?>" <?php echo ( !empty( $personal ) && $personal -> post_id === $post -> id ) ? 'selected="selected"' : '' ?>>
                        <?php echo $post -> title; ?>
                    </option>
                    <?php
                }
            }
        ?>
    </select>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Hiring Date <sup style="color: #FF0000; font-weight: 700">*</sup></label>
    <input type="text" name="hiring_date" class="form-control date-picker" placeholder="Add employee hiring date"
           value="<?php echo date ( 'm/d/Y', strtotime ( !empty( $personal ) ? $personal -> hiring_date : date ( 'Y-m-d' ) ) ) ?>"
           required="required">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Contract Date <sup style="color: #FF0000; font-weight: 700">*</sup></label>
    <input type="text" name="contract_date" class="form-control date-picker" placeholder="Add employee contract date"
           value="<?php echo date ( 'm/d/Y', strtotime ( !empty( $personal ) ? $personal -> contract_date : date ( 'Y-m-d' ) ) ) ?>"
           required="required">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Basic Pay</label>
    <input type="number" name="basic_pay" class="form-control" placeholder="Add employee basic pay"
           value="<?php echo !empty( $personal ) ? $personal -> basic_pay : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Medical Allowance</label>
    <input type="number" name="medical_allowance" class="form-control" placeholder="Add employee medical allowance"
           value="<?php echo !empty( $personal ) ? $personal -> medical_allowance : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Transport Allowance</label>
    <input type="number" name="transport_allowance" class="form-control" placeholder="Add employee transport allowance"
           value="<?php echo !empty( $personal ) ? $personal -> transport_allowance : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Accommodation Allowance</label>
    <input type="number" name="rent_allowance" class="form-control" placeholder="Add employee house rent allowance"
           value="<?php echo !empty( $personal ) ? $personal -> rent_allowance : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Mobile Allowance</label>
    <input type="number" name="mobile_allowance" class="form-control" placeholder="Add employee mobile allowance"
           value="<?php echo !empty( $personal ) ? $personal -> mobile_allowance : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Food Allowance</label>
    <input type="number" name="food_allowance" class="form-control" placeholder="Add employee food allowance"
           value="<?php echo !empty( $personal ) ? $personal -> food_allowance : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Other Allowance</label>
    <input type="number" name="other_allowance" class="form-control" placeholder="Add employee other allowance"
           value="<?php echo !empty( $personal ) ? $personal -> other_allowance : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Working Hours</label>
    <input type="number" name="working_hours" class="form-control"
           value="<?php echo !empty( $personal ) ? $personal -> working_hours : '' ?>">
</div>
