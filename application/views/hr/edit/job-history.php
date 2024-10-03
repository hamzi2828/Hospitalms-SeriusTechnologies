<div class="col-lg-12 text-center bg-dark" style="margin: 15px 0;">
    <h3 style="margin: 0; padding: 10px;"> Last Employment Details </h3>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Company Name</label>
    <input name="company" class="form-control" placeholder="Add Company Name"
           value="<?php echo !empty( $history ) ? $history -> company : '' ?>">
</div>

<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Address</label>
    <input name="address" class="form-control" placeholder="Add Address"
           value="<?php echo !empty( $history ) ? $history -> address : '' ?>">
</div>

<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Contact No.</label>
    <input name="contact" class="form-control" placeholder="Add Contact No."
           value="<?php echo !empty( $history ) ? $history -> contact : '' ?>">
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
                    <option value="<?php echo $post -> id; ?>" <?php echo ( !empty( $history ) && $history -> designation === $post -> id ) ? 'selected="selected"' : '' ?>>
                        <?php echo $post -> title; ?>
                    </option>
                    <?php
                }
            }
        ?>
    </select>
</div>

<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Duration of Job</label>
    <input name="duration" class="form-control" placeholder="Add Duration of Job"
           value="<?php echo !empty( $history ) ? $history -> duration : '' ?>">
</div>

<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Salary Package</label>
    <input type="number" name="salary" class="form-control" placeholder="Add Salary Package"
           value="<?php echo !empty( $history ) ? $history -> salary : '' ?>">
</div>

<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Benefits </label>
    <input name="benefits" class="form-control" placeholder="Add Benefits"
           value="<?php echo !empty( $history ) ? $history -> benefits : '' ?>">
</div>

<div class="form-group col-lg-12">
    <label for="exampleInputEmail1">Reason for Leaving Job </label>
    <textarea name="leaving_reason" class="form-control" placeholder="Add Reason for Leaving Job"
              rows="5"><?php echo !empty( $history ) ? $history -> leaving_reason : '' ?></textarea>
</div>