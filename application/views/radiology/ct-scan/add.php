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
                    <i class="fa fa-reorder"></i> Add CT-Scan Report
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_ct_scan_report">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></label>
                                <input type="text" name="sale-id" class="form-control" placeholder="<?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>"
                                       autofocus="autofocus" value="<?php echo set_value ( 'sale-id' ) ?>"
                                       required="required" onchange="get_patient_by_lab_sale_id(this.value)">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control name" id="patient-name" readonly="readonly">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">CNIC</label>
                                <input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Ordered By</label>
                                <select name="order_by" class="form-control select2me" required="required">
                                    <option value="">Select</option>
                                    <?php
                                        if ( count ( $doctors ) > 0 ) {
                                            foreach ( $doctors as $doctor ) {
                                                ?>
                                                <option value="<?php echo $doctor -> id ?>">
                                                    <?php echo $doctor -> name ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Radiologist</label>
                                <select name="doctor_id" class="form-control select2me" required="required">
                                    <option value="">Select</option>
                                    <?php
                                        if ( count ( $doctors ) > 0 ) {
                                            foreach ( $doctors as $doctor ) {
                                                ?>
                                                <option value="<?php echo $doctor -> id ?>">
                                                    <?php echo $doctor -> name ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Report Title</label>
                                <select name="template-id" class="form-control select2me" required="required"
                                        onchange="get_ct_scan_template(this.value)">
                                    <option value="">Select</option>
                                    <?php
                                        if ( count ( $templates ) > 0 ) {
                                            foreach ( $templates as $template ) {
                                                ?>
                                                <option value="<?php echo $template -> id ?>">
                                                    <?php echo $template -> title ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Doctor Stamp</label>
                                <select name="doctor_stamp" class="form-control select2me" required="required">
                                    <option value="">Select</option>
                                    <?php
                                        if ( count ( $doctors ) > 0 ) {
                                            foreach ( $doctors as $doctor ) {
                                                ?>
                                                <option value="<?php echo $doctor -> id ?>">
                                                    <?php echo $doctor -> name ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="film">Film</label>
                                <input type="file" name="film" id="film" class="form-control" accept="image/*">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="exampleInputEmail1">Study</label>
                                <textarea rows="5" class="form-control ckeditor" id="study" name="study"></textarea>
                            </div>
                            <div class="form-group col-lg-12 hidden">
                                <label for="exampleInputEmail1">Conclusion</label>
                                <textarea rows="5" class="form-control ckeditor" id="conclusion"
                                          name="conclusion"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>