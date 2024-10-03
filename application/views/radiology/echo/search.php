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
        <div class="search">
            <form method="get">
                <div class="col-lg-2">
                    <label>Report ID#</label>
                    <input type="text" name="report_id" class="form-control"
                           value="<?php echo @$_REQUEST[ 'report_id' ] ?>">
                </div>
                <div class="col-lg-2">
                    <label>Patient EMR#</label>
                    <input type="text" name="patient_id" class="form-control"
                           value="<?php echo @$_REQUEST[ 'patient_id' ] ?>">
                </div>
                <div class="col-lg-3">
                    <label>Radiologist</label>
                    <select name="doctor_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $doctors ) > 0 ) {
                                foreach ( $doctors as $doctor ) {
                                    ?>
                                    <option value="<?php echo $doctor -> id ?>" <?php if ( $doctor -> id == @$_REQUEST[ 'doctor_id' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $doctor -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <label>Order By</label>
                    <select name="order_by" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $doctors ) > 0 ) {
                                foreach ( $doctors as $doctor ) {
                                    ?>
                                    <option value="<?php echo $doctor -> id ?>" <?php if ( $doctor -> id == @$_REQUEST[ 'order_by' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $doctor -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <label>Date</label>
                    <input type="text" name="date" class="form-control date-picker"
                           value="<?php if ( isset( $_REQUEST[ 'date' ] ) and !empty( trim ( $_REQUEST[ 'date' ] ) ) )
                               echo date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'date' ] ) ) ?>">
                </div>
                <div class="col-lg-1" style="margin-top: 25px">
                    <button type="submit" class="btn-block btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Search ECHO Report
                </div>
            </div>
            <div class="portlet-body form">
                <?php
                    if ( $report and !empty( $report ) ) {
                        $patient = get_patient ( $report -> patient_id );
                        $order_by = get_doctor ( $report -> order_by );
                        $doctor = get_doctor ( $report -> doctor_id );
                        ?>
                        <form role="form" method="post" autocomplete="off">
                            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                            <input type="hidden" name="action" value="do_edit_echo_report">
                            <input type="hidden" name="report_id" value="<?php echo $report -> id ?>">
                            <div class="form-body" style="overflow:auto;">
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Patient EMR#</label>
                                    <input type="text" name="patient_id" class="form-control" placeholder="EMR#"
                                           autofocus="autofocus" value="<?php echo $report -> patient_id; ?>"
                                           required="required" onchange="get_patient(this.value)">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control name" id="patient-name" readonly="readonly"
                                           value="<?php echo $patient -> name ?>">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">CNIC</label>
                                    <input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly"
                                           value="<?php echo $patient -> cnic ?>">
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="exampleInputEmail1">Ordered By</label>
                                    <select name="order_by" class="form-control select2me" required="required">
                                        <option value="">Select</option>
                                        <?php
                                            if ( count ( $doctors ) > 0 ) {
                                                foreach ( $doctors as $doctor ) {
                                                    ?>
                                                    <option value="<?php echo $doctor -> id ?>" <?php if ( $doctor -> id == $report -> order_by )
                                                        echo 'selected="selected"' ?>>
                                                        <?php echo $doctor -> name ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="exampleInputEmail1">Performed By</label>
                                    <select name="doctor_id" class="form-control select2me" required="required">
                                        <option value="">Select</option>
                                        <?php
                                            if ( count ( $doctors ) > 0 ) {
                                                foreach ( $doctors as $doctor ) {
                                                    ?>
                                                    <option value="<?php echo $doctor -> id ?>" <?php if ( $doctor -> id == $report -> doctor_id )
                                                        echo 'selected="selected"' ?>>
                                                        <?php echo $doctor -> name ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="exampleInputEmail1">Report Title</label>
                                    <input type="text" class="form-control" name="report_title" required="required"
                                           value="<?php echo $report -> report_title ?>">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="exampleInputEmail1">Study</label>
                                    <textarea rows="5" class="form-control wysihtml5"
                                              name="study"><?php echo $report -> study ?></textarea>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="exampleInputEmail1">Conclusion</label>
                                    <textarea rows="5" class="form-control wysihtml5"
                                              name="conclusion"><?php echo $report -> conclusion ?></textarea>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue">Update</button>
                            </div>
                        </form>
                        <?php
                    }
                ?>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    iframe, .wysihtml5-sandbox {
        height: 400px !important;
    }
</style>