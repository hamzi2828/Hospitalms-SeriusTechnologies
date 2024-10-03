<div class="col-lg-12 text-center bg-dark" style="margin: 15px 0;">
    <h3 style="margin: 0; padding: 10px;"> Family Details </h3>
</div>
<div class="form-group col-lg-3">
    <label for="wife-name">Husband/Wife Name</label>
    <input type="text" name="wife-name" class="form-control"
           value="<?php echo set_value ( 'wife-name', $family_details ? $family_details -> wife_name : '' ) ?>"
           id="wife-name">
</div>
<div class="form-group col-lg-3">
    <label for="wife-contact-no">Contact No</label>
    <input type="text" name="wife-contact-no" class="form-control"
           value="<?php echo set_value ( 'wife-contact-no', $family_details ? $family_details -> wife_contact : '' ) ?>"
           id="wife-contact-no">
</div>
<div class="form-group col-lg-3">
    <label for="wife-cnic">CNIC</label>
    <input type="text" name="wife-cnic" class="form-control"
           value="<?php echo set_value ( 'wife-cnic', $family_details ? $family_details -> wife_cnic : '' ) ?>"
           id="wife-cnic">
</div>
<div class="form-group col-lg-3">
    <label for="wife-address">Address</label>
    <input type="text" name="wife-address" class="form-control"
           value="<?php echo set_value ( 'wife-address', $family_details ? $family_details -> wife_address : '' ) ?>"
           id="wife-address">
</div>

<div class="form-group col-lg-3">
    <label for="father-name">Father Name</label>
    <input type="text" name="father-name" class="form-control"
           value="<?php echo set_value ( 'father-name', $family_details ? $family_details -> father_name : '' ) ?>"
           id="father-name">
</div>
<div class="form-group col-lg-3">
    <label for="father-contact-no">Contact No</label>
    <input type="text" name="father-contact-no" class="form-control"
           value="<?php echo set_value ( 'father-contact-no', $family_details ? $family_details -> father_contact : '' ) ?>"
           id="father-contact-no">
</div>
<div class="form-group col-lg-3">
    <label for="father-cnic">CNIC</label>
    <input type="text" name="father-cnic" class="form-control"
           value="<?php echo set_value ( 'father-cnic', $family_details ? $family_details -> father_cnic : '' ) ?>"
           id="father-cnic">
</div>
<div class="form-group col-lg-3">
    <label for="father-address">Address</label>
    <input type="text" name="father-address" class="form-control"
           value="<?php echo set_value ( 'father-address', $family_details ? $family_details -> father_address : '' ) ?>"
           id="father-address">
</div>

<div class="form-group col-lg-3">
    <label for="mother-name">Mother Name</label>
    <input type="text" name="mother-name" class="form-control"
           value="<?php echo set_value ( 'mother-name', $family_details ? $family_details -> mother_name : '' ) ?>"
           id="mother-name">
</div>
<div class="form-group col-lg-3">
    <label for="mother-contact-no">Contact No</label>
    <input type="text" name="mother-contact-no" class="form-control"
           value="<?php echo set_value ( 'mother-contact-no', $family_details ? $family_details -> mother_contact : '' ) ?>"
           id="mother-contact-no">
</div>
<div class="form-group col-lg-3">
    <label for="mother-cnic">CNIC</label>
    <input type="text" name="mother-cnic" class="form-control"
           value="<?php echo set_value ( 'mother-cnic', $family_details ? $family_details -> mother_cnic : '' ) ?>"
           id="mother-cnic">
</div>
<div class="form-group col-lg-3">
    <label for="mother-address">Address</label>
    <input type="text" name="mother-address" class="form-control"
           value="<?php echo set_value ( 'mother-address', $family_details ? $family_details -> mother_address : '' ) ?>"
           id="mother-address">
</div>

<div class="form-group col-lg-12">
    <h4 style="color: #FF0000; font-weight: 900 !important; border-bottom: 1px solid #FF0000;">Details of Children</h4>
</div>
<?php
    $childCount = 1;
    if ( count ( $children ) > 0 ) {
        foreach ( $children as $key => $child ) {
            ?>
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group col-lg-3">
                        <label for="child-name-<?php echo $child -> id ?>">Children #<?php echo $childCount++ ?></label>
                        <input type="text" name="child-name[]" class="form-control"
                               value="<?php echo set_value ( 'children.' . $key, $child -> name ) ?>"
                               id="child-name-<?php echo $child -> id ?>">
                    </div>
                    
                    <div class="form-group col-lg-3">
                        <label for="child-cnic-<?php echo $child -> id ?>">CNIC</label>
                        <input type="text" name="child-cnic[]" class="form-control"
                               value="<?php echo set_value ( 'child-cnic.' . $key, $child -> cnic ) ?>"
                               id="child-cnic-<?php echo $child -> id ?>">
                    </div>
                </div>
            </div>
            <?php
        }
    }
    
    for ( $childRow = ( count ( $children ) + 1 ); $childRow <= 3; $childRow++ ) {
        ?>
        <div class="col-md-12">
            <div class="row">
                <div class="form-group col-lg-3">
                    <label for="child-name-<?php echo $childRow ?>">Children #<?php echo $childRow ?></label>
                    <input type="text" name="child-name[]" class="form-control"
                           value="<?php echo set_value ( 'children.' . ( $childRow - 1 ) ) ?>"
                           id="child-name-<?php echo $childRow ?>">
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="child-cnic-<?php echo $childRow ?>">CNIC</label>
                    <input type="text" name="child-cnic[]" class="form-control"
                           value="<?php echo set_value ( 'child-cnic.' . ( $childRow - 1 ) ) ?>"
                           id="child-cnic-<?php echo $childRow ?>">
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
    <input type="text" name="next-of-kin" class="form-control"
           value="<?php echo set_value ( 'next-of-kin', $family_details ? $family_details -> nok : '' ) ?>"
           id="next-of-kin">
</div>

<div class="form-group col-lg-3">
    <label for="child-contact-no">Contact No</label>
    <input type="text" name="child-contact-no" class="form-control"
           value="<?php echo set_value ( 'child-contact-no', $family_details ? $family_details -> nok_contact : '' ) ?>"
           id="child-contact-no">
</div>

<div class="form-group col-lg-3">
    <label for="child-cnic">CNIC</label>
    <input type="text" name="nok-cnic" class="form-control"
           value="<?php echo set_value ( 'nok-cnic', $family_details ? $family_details -> nok_cnic : '' ) ?>"
           id="child-cnic">
</div>

<div class="form-group col-lg-3">
    <label for="child-relation">Relation</label>
    <input type="text" name="child-relation" class="form-control"
           value="<?php echo set_value ( 'child-relation', $family_details ? $family_details -> nok_relation : '' ) ?>"
           id="child-relation">
</div>

<div class="form-group col-lg-3">
    <label for="child-address">Address</label>
    <input type="text" name="child-address" class="form-control"
           value="<?php echo set_value ( 'child-address', $family_details ? $family_details -> nok_address : '' ) ?>"
           id="child-address">
</div>

<div class="form-group col-lg-3">
    <label for="emergency-contact-no">Emergency Contact Person</label>
    <input type="text" name="emergency-contact-no" class="form-control"
           value="<?php echo set_value ( 'emergency-contact-no', $family_details ? $family_details -> emergency_contact : '' ) ?>"
           id="emergency-contact-no">
</div>