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
                    <i class="fa fa-reorder"></i> Add Patient Vitals
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_patient_vitals">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <input type="text" name="patient_id" class="form-control"
                                       placeholder="<?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?> Number" onchange="get_patient(this.value)"
                                       required="required" autofocus="autofocus">
                            </div>
                            
                            <div class="form-group col-lg-4">
                                <input type="text" readonly="readonly" class="form-control"
                                       id="patient-name"
                                       placeholder="Enter <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?> Number">
                            </div>
                            
                            <div class="form-group col-lg-4">
                                <input type="text" readonly="readonly" class="form-control"
                                       id="patient-cnic"
                                       placeholder="Enter <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?> Number">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input type="text" name="vital_key[]" class="form-control" value="BP"
                                       readonly="readonly">
                            </div>
                            <div class="form-group col-lg-6">
                                <input type="text" name="vital_value[]" class="form-control" placeholder="Vital Value">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input type="text" name="vital_key[]" class="form-control" value="Weight"
                                       readonly="readonly">
                            </div>
                            <div class="form-group col-lg-6">
                                <input type="text" name="vital_value[]" class="form-control" placeholder="Vital Value">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input type="text" name="vital_key[]" class="form-control" value="Body Temperature"
                                       readonly="readonly">
                            </div>
                            <div class="form-group col-lg-6">
                                <input type="text" name="vital_value[]" class="form-control" placeholder="Vital Value">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input type="text" name="vital_key[]" class="form-control" value="Pulse"
                                       readonly="readonly">
                            </div>
                            <div class="form-group col-lg-6">
                                <input type="text" name="vital_value[]" class="form-control" placeholder="Vital Value">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <input type="text" name="vital_key[]" class="form-control" value="SPO2"
                                       readonly="readonly">
                            </div>
                            <div class="form-group col-lg-6">
                                <input type="text" name="vital_value[]" class="form-control" placeholder="Vital Value">
                            </div>
                        </div>
                        <div class="add-more-vitals"></div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="sales-btn">Submit</button>
                        <button type="button" class="btn purple" id="add-more-vitals">Add More</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>