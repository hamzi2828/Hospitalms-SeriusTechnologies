<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger panel-info hidden"></div>
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
                    <i class="fa fa-reorder"></i> Sale Service
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_sale_service">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                                <input type="text" name="patient_id" class="form-control" placeholder="Add <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>"
                                       autofocus="autofocus" value="<?php echo set_value ( 'patient_id' ) ?>"
                                       required="required" onchange="get_patient(this.value)">
                                <!--  onchange="check_if_patient_has_admission_order(this.value)" -->
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control name" id="patient-name" readonly="readonly">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">CNIC</label>
                                <input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Mobile No</label>
                                <input type="text" class="form-control mobile" id="patient-mobile" readonly="readonly">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">City</label>
                                <input type="text" class="form-control city" id="patient-city" readonly="readonly">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="exampleInputEmail1">Purpose</label>
                                <textarea rows="5" class="form-control" name="purpose"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="sales-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .add-more-services {
        width: 100%;
        display: block;
        float: left;
    }
</style>