<div class="col-lg-12 text-center bg-dark" style="margin: 15px 0;">
    <h3 style="margin: 0; padding: 10px;"> Family Details </h3>
</div>
<div class="form-group col-lg-3">
    <label for="wife-name">Husband/Wife Name</label>
    <input type="text" name="wife-name" class="form-control" value="<?php echo set_value ( 'wife-name' ) ?>"
           id="wife-name">
</div>
<div class="form-group col-lg-3">
    <label for="wife-contact-no">Contact No</label>
    <input type="text" name="wife-contact-no" class="form-control" value="<?php echo set_value ( 'wife-contact-no' ) ?>"
           id="wife-contact-no">
</div>
<div class="form-group col-lg-3">
    <label for="wife-cnic">CNIC</label>
    <input type="text" name="wife-cnic" class="form-control" value="<?php echo set_value ( 'wife-cnic' ) ?>"
           id="wife-cnic">
</div>
<div class="form-group col-lg-3">
    <label for="wife-address">Address</label>
    <input type="text" name="wife-address" class="form-control" value="<?php echo set_value ( 'wife-address' ) ?>"
           id="wife-address">
</div>

<div class="form-group col-lg-3">
    <label for="father-name">Father Name</label>
    <input type="text" name="father-name" class="form-control" value="<?php echo set_value ( 'father-name' ) ?>"
           id="father-name">
</div>
<div class="form-group col-lg-3">
    <label for="father-contact-no">Contact No</label>
    <input type="text" name="father-contact-no" class="form-control"
           value="<?php echo set_value ( 'father-contact-no' ) ?>"
           id="father-contact-no">
</div>
<div class="form-group col-lg-3">
    <label for="father-cnic">CNIC</label>
    <input type="text" name="father-cnic" class="form-control" value="<?php echo set_value ( 'father-cnic' ) ?>"
           id="father-cnic">
</div>
<div class="form-group col-lg-3">
    <label for="father-address">Address</label>
    <input type="text" name="father-address" class="form-control" value="<?php echo set_value ( 'father-address' ) ?>"
           id="father-address">
</div>

<div class="form-group col-lg-3">
    <label for="mother-name">Mother Name</label>
    <input type="text" name="mother-name" class="form-control" value="<?php echo set_value ( 'mother-name' ) ?>"
           id="mother-name">
</div>
<div class="form-group col-lg-3">
    <label for="mother-contact-no">Contact No</label>
    <input type="text" name="mother-contact-no" class="form-control"
           value="<?php echo set_value ( 'mother-contact-no' ) ?>"
           id="mother-contact-no">
</div>
<div class="form-group col-lg-3">
    <label for="mother-cnic">CNIC</label>
    <input type="text" name="mother-cnic" class="form-control" value="<?php echo set_value ( 'mother-cnic' ) ?>"
           id="mother-cnic">
</div>
<div class="form-group col-lg-3">
    <label for="mother-address">Address</label>
    <input type="text" name="mother-address" class="form-control" value="<?php echo set_value ( 'mother-address' ) ?>"
           id="mother-address">
</div>

<div class="form-group col-lg-12">
    <h4 style="color: #FF0000; font-weight: 900 !important; border-bottom: 1px solid #FF0000;">Details of Children</h4>
</div>

<?php
    for ( $children = 1; $children <= 3; $children++ ) {
        ?>
        <div class="col-md-12">
            <div class="row">
                <div class="form-group col-lg-3">
                    <label for="child-name-<?php echo $children ?>">Children #<?php echo $children ?></label>
                    <input type="text" name="child-name[]" class="form-control"
                           value="<?php echo set_value ( 'children.' . ( $children - 1 ) ) ?>"
                           id="child-name-<?php echo $children ?>">
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="child-cnic-<?php echo $children ?>">CNIC</label>
                    <input type="text" name="child-cnic[]" class="form-control"
                           value="<?php echo set_value ( 'child-cnic.' . ( $children - 1 ) ) ?>"
                           id="child-cnic-<?php echo $children ?>">
                </div>
            </div>
        </div>
        <?php
    }
?>

<div class="form-group col-lg-12">
    <h4 style="color: #FF0000; font-weight: 900 !important; border-bottom: 1px solid #FF0000;">Next of Kin</h4>
</div>

<div class="form-group col-lg-3">
    <label for="next-of-kin">Next of Kin</label>
    <input type="text" name="next-of-kin" class="form-control" value="<?php echo set_value ( 'next-of-kin' ) ?>"
           id="next-of-kin">
</div>

<div class="form-group col-lg-3">
    <label for="child-contact-no">Contact No</label>
    <input type="text" name="child-contact-no" class="form-control"
           value="<?php echo set_value ( 'child-contact-no' ) ?>"
           id="child-contact-no">
</div>

<div class="form-group col-lg-3">
    <label for="child-cnic">CNIC</label>
    <input type="text" name="nok-cnic" class="form-control" value="<?php echo set_value ( 'child-cnic' ) ?>"
           id="child-cnic">
</div>

<div class="form-group col-lg-3">
    <label for="child-relation">Relation</label>
    <input type="text" name="child-relation" class="form-control" value="<?php echo set_value ( 'child-relation' ) ?>"
           id="child-relation">
</div>

<div class="form-group col-lg-3">
    <label for="child-address">Address</label>
    <input type="text" name="child-address" class="form-control" value="<?php echo set_value ( 'child-address' ) ?>"
           id="child-address">
</div>

<div class="form-group col-lg-3">
    <label for="emergency-contact-no">Emergency Contact Person</label>
    <input type="text" name="emergency-contact-no" class="form-control"
           value="<?php echo set_value ( 'emergency-contact-no' ) ?>"
           id="emergency-contact-no">
</div>