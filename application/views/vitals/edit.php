<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if ( validation_errors () != false ) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors (); ?>
            </div>
        <?php } ?>
        <?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata ( 'error' ) ?>
            </div>
        <?php endif; ?>
        <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
        <?php endif; ?>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Patient Vitals
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_patient_vitals">
                    <input type="hidden" name="vital_id" value="<?php echo $this -> uri -> segment ( 3 ) ?>">
                    <input type="hidden" name="patient_id" value="<?php echo $vitals[ 0 ] -> patient_id ?>">
                    <div class="form-body">
                        <?php
                            if ( count ( $vitals ) > 0 ) {
                                foreach ( $vitals as $vital ) {
                                    ?>
                                    <div class="row" style="margin-bottom: 15px">
                                        <div class="col-lg-6">
                                            <input type="text" name="vital_key[]" class="form-control"
                                                   value="<?php echo $vital -> vital_key ?>">
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" name="vital_value[]" class="form-control"
                                                   placeholder="Vital Value"
                                                   value="<?php echo $vital -> vital_value ?>">
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="sales-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>