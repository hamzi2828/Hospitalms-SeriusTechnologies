<?php
    $patient = get_patient ( $consultancy -> patient_id );
    $vitals  = get_vitals ( $consultancy -> patient_id );
?>
<form role="form" method="post" autocomplete="off">
    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
    <input type="hidden" name="action" value="do_add_prescriptions">
    <input type="hidden" id="added" value="1">
    <div class="form-body">
        <div class="row">
            <div class="form-group col-lg-5">
                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                <input type="text" readonly="readonly" class="form-control"
                       value="<?php echo get_patient_name ( 0, $patient ) ?>">
            </div>
            <div class="form-group col-lg-3">
                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_PHONE' ) ?></label>
                <input type="text" class="form-control" readonly="readonly"
                       value="<?php echo $patient -> mobile ?>">
            </div>
            <div class="form-group col-lg-2">
                <label for="exampleInputEmail1">Patient Gender</label>
                <input type="text" class="form-control" readonly="readonly"
                       value="<?php echo ( $patient -> gender == 1 ) ? 'Male' : 'Female'; ?>">
            </div>
            <div class="form-group col-lg-2">
                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_AGE' ); ?></label>
                <input type="text" class="form-control" readonly="readonly"
                       value="<?php echo $patient -> age ?>">
            </div>
            
            <?php require 'prescription-vitals.php' ?>
            
            <div class="form-group col-lg-12">
                <label for="complaints" style="display: block; width: 100%; font-size: 18px; font-weight: 900">
                    Complaints
                </label>
                <textarea id="complaints" class="ckeditor form-control" name="complaints"
                          rows="10"><?php echo !empty( $prescription ) ? $prescription -> complaints : '' ?></textarea>
            </div>
            <div class="form-group col-lg-12">
                <label for="diagnoses" style="display: block; width: 100%; font-size: 18px; font-weight: 900">
                    Diagnoses
                </label>
                <textarea id="diagnoses" class="ckeditor form-control" name="diagnosis"
                          rows="10"><?php echo !empty( $prescription ) ? $prescription -> diagnosis : '' ?></textarea>
            </div>
        </div>
        <div class="row">
            <?php require 'prescribe-medication.php' ?>
        </div>
        <div class="row">
            <?php require 'prescribe-lab.php' ?>
        </div>
        <div class="row">
            <?php require 'prescribe-follow-ups.php' ?>
        </div>
    </div>
    <?php if ( !empty( $patient ) ) : ?>
        <div class="form-actions">
            <button type="submit" class="btn blue" id="sales-btn">Submit</button>
            <?php if ( !empty( $prescription ) ) : ?>
                <a href="<?php echo base_url ( '/invoices/prescription-invoice/' . $prescription -> id ); ?>"
                   target="_blank" class="btn purple">Print</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</form>