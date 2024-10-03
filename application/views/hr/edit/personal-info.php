<div class="col-lg-12 text-center bg-dark" style="margin: 15px 0;">
    <h3 style="margin: 0; padding: 10px;"> Personal Information </h3>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Name <sup style="color: #FF0000; font-weight: 700">*</sup></label>
    <input type="text" name="name" class="form-control" placeholder="Add employee name" autofocus="autofocus"
           value="<?php echo !empty( $personal ) ? $personal -> name : '' ?>" maxlength="100" required="required">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Father Name <sup style="color: #FF0000; font-weight: 700">*</sup></label>
    <input type="text" name="father_name" class="form-control" placeholder="Add employee father name"
           value="<?php echo !empty( $personal ) ? $personal -> father_name : '' ?>" maxlength="100"
           required="required">
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Mother Name</label>
    <input type="text" name="mother_name" class="form-control" placeholder="Add employee mother name"
           value="<?php echo !empty( $personal ) ? $personal -> mother_name : '' ?>" maxlength="100">
</div>
<div class="form-group col-lg-2">
    <label for="exampleInputEmail1">Gender</label>
    <select name="gender" class="form-control select2me">
        <option value="1" <?php if ( !empty( $personal ) ? $personal -> gender == '1' : '' ) echo 'selected="selected"' ?>>
            Male
        </option>
        <option value="0" <?php if ( !empty( $personal ) ? $personal -> gender == '0' : '' ) echo 'selected="selected"' ?>>
            Female
        </option>
    </select>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Blood Group</label>
    <select name="blood_group" class="form-control select2me">
        <option>Select</option>
        <option value="A-" <?php if ( $personal -> blood_group == 'A-' )
            echo 'selected="selected"' ?>>A-
        </option>
        <option value="A+" <?php if ( $personal -> blood_group == 'A+' )
            echo 'selected="selected"' ?>>A+
        </option>
        <option value="B-" <?php if ( $personal -> blood_group == 'B-' )
            echo 'selected="selected"' ?>>B-
        </option>
        <option value="B+" <?php if ( $personal -> blood_group == 'B+' )
            echo 'selected="selected"' ?>>B+
        </option>
        <option value="AB-" <?php if ( $personal -> blood_group == 'AB-' )
            echo 'selected="selected"' ?>>AB-
        </option>
        <option value="AB+" <?php if ( $personal -> blood_group == 'AB+' )
            echo 'selected="selected"' ?>>AB+
        </option>
        <option value="O-" <?php if ( $personal -> blood_group == 'O-' )
            echo 'selected="selected"' ?>>O-
        </option>
        <option value="O+" <?php if ( $personal -> blood_group == 'O+' )
            echo 'selected="selected"' ?>>O+
        </option>
    </select>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Date of Birth</label>
    <input type="text" name="dob" class="form-control date-picker" placeholder="Add employee date of birth"
           value="<?php echo date ( 'm/d/Y', strtotime ( !empty( $personal ) ? $personal -> dob : date ( 'Y-m-d' ) ) ) ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Place of Birth</label>
    <input type="text" name="birth_place" class="form-control" placeholder="Add employee place of birth"
           value="<?php echo !empty( $personal ) ? $personal -> birth_place : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Martial Status</label>
    <select name="martial_status" class="form-control select2me">
        <option value="Single" <?php if ( !empty( $personal ) ? $personal -> martial_status == 'Single' : '' ) echo 'selected="selected"' ?>>
            Single
        </option>
        <option value="Married" <?php if ( !empty( $personal ) ? $personal -> martial_status == 'Married' : '' ) echo 'selected="selected"' ?>>
            Married
        </option>
        <option value="Divorced" <?php if ( !empty( $personal ) ? $personal -> martial_status == 'Divorced' : '' ) echo 'selected="selected"' ?>>
            Divorced
        </option>
    </select>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Religion</label>
    <select name="religion" class="form-control select2me">
        <option value="Muslim" <?php if ( !empty( $personal ) ? $personal -> religion == 'Muslim' : '' ) echo 'selected="selected"' ?>>
            Muslim
        </option>
        <option value="Christan" <?php if ( !empty( $personal ) ? $personal -> religion == 'Christan' : '' ) echo 'selected="selected"' ?>>
            Christan
        </option>
        <option value="Hindu" <?php if ( !empty( $personal ) ? $personal -> religion == 'Hindu' : '' ) echo 'selected="selected"' ?>>
            Hindu
        </option>
    </select>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Nationality</label>
    <input type="text" name="nationality" class="form-control" placeholder="Add employee nationality" maxlength="13"
           value="<?php echo !empty( $personal ) ? $personal -> nationality : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">CNIC <sup style="color: #FF0000; font-weight: 700">*</sup></label>
    <input type="text" name="cnic" class="form-control" placeholder="Add employee cnic" maxlength="13"
           value="<?php echo !empty( $personal ) ? $personal -> cnic : '' ?>" required="required">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Tel (Land Line)</label>
    <input type="text" name="residence_mobile" class="form-control" placeholder="Add employee residence mobile"
           value="<?php echo !empty( $personal ) ? $personal -> residence_mobile : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Mobile #1</label>
    <input type="text" name="mobile" class="form-control" placeholder="Add employee mobile"
           value="<?php echo !empty( $personal ) ? $personal -> mobile : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Mobile #2</label>
    <input type="text" name="mobile_2" class="form-control" placeholder="Add employee mobile"
           value="<?php echo !empty( $personal ) ? $personal -> mobile_2 : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Email Address</label>
    <input type="email" name="email" class="form-control" placeholder="Add employee email"
           value="<?php echo !empty( $personal ) ? $personal -> email : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Residential Address <sup style="color: #FF0000; font-weight: 700">*</sup></label>
    <input type="text" name="permanent_address" class="form-control" placeholder="Employee residential address"
           required="required" value="<?php echo !empty( $personal ) ? $personal -> permanent_address : '' ?>">
</div>
<div class="form-group col-lg-12">
    <label for="disability">Disability (If any)</label>
    <input type="text" name="disability" class="form-control"
           value="<?php echo set_value ( 'disability', $family_details ? $family_details -> disability : '' ) ?>"
           id="disability">
</div>