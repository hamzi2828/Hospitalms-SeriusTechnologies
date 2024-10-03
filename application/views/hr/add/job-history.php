<div class="col-lg-12 text-center bg-dark" style="margin: 15px 0;">
    <h3 style="margin: 0; padding: 10px;"> Last Employment Details </h3>
</div>

<div class="form-group col-lg-3">
    <label for="company">Company Name</label>
    <input name="company" id="company" class="form-control" value="<?php echo set_value ( 'company' ) ?>">
</div>

<div class="form-group col-lg-3">
    <label for="address">Address</label>
    <input name="address" id="address" class="form-control" value="<?php echo set_value ( 'address' ) ?>">
</div>

<div class="form-group col-lg-3">
    <label for="contact">Contact No.</label>
    <input name="contact" id="contact" class="form-control" value="<?php echo set_value ( 'contact' ) ?>">
</div>

<div class="form-group col-lg-3">
    <label for="designation">Post/Designation <sup style="color: #FF0000; font-weight: 700">*</sup></label>
    <select name="designation" id="designation" class="form-control select2me" data-placeholder="Select"
            data-allow-clear="true" required="required">
        <option></option>
        <?php
            if ( count ( $posts ) > 0 ) {
                foreach ( $posts as $post ) {
                    ?>
                    <option value="<?php echo $post -> id; ?>" <?php echo $this -> input -> post ( 'designation' ) == $post -> id ? 'selected="selected"' : '' ?>>
                        <?php echo $post -> title; ?>
                    </option>
                    <?php
                }
            }
        ?>
    </select>
</div>

<div class="form-group col-lg-4">
    <label for="duration">Duration of Job</label>
    <input name="duration" id="duration" class="form-control" value="<?php echo set_value ( 'duration' ) ?>">
</div>

<div class="form-group col-lg-4">
    <label for="salary">Salary Package</label>
    <input type="number" name="salary" id="salary" class="form-control" value="<?php echo set_value ( 'salary' ) ?>">
</div>

<div class="form-group col-lg-4">
    <label for="benefits">Benefits </label>
    <input name="benefits" id="benefits" class="form-control" value="<?php echo set_value ( 'benefits' ) ?>">
</div>

<div class="form-group col-lg-12">
    <label for="leaving_reason">Reason for Leaving Job </label>
    <textarea name="leaving_reason" id="leaving_reason" class="form-control"
              rows="5"><?php echo set_value ( 'leaving_reason' ) ?></textarea>
</div>