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
                    <i class="fa fa-reorder"></i> Add Report
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_report">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Invoice ID</label>
                            <input type="text" name="sale-id" class="form-control" placeholder="Invoice ID"
                                   required="required" autofocus="autofocus"
                                   onchange="get_patient_by_lab_sale_id(this.value)">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                            <input type="text" class="form-control" placeholder="EMR" readonly="readonly"
                                   id="patient-id">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control name" id="patient-name" readonly="readonly">
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
                            <label for="exampleInputEmail1">Performed By</label>
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
                            <label for="exampleInputEmail1">Specimen</label>
                            <select name="sample-id" class="form-control select2me" required="required">
                                <option value="">Select</option>
                                <?php
                                    if ( count ( $samples ) > 0 ) {
                                        foreach ( $samples as $sample ) {
                                            ?>
                                            <option value="<?php echo $sample -> id ?>">
                                                <?php echo $sample -> name ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-8">
                            <label for="exampleInputEmail1">Report Title</label>
                            <select name="template-id" class="form-control select2me" required="required"
                                    onchange="get_histopathology_template(this.value)">
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
                            <!--							<input type="text" class="form-control" name="report_title" required="required">-->
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Study</label>
                            <textarea rows="5" class="form-control ckeditor" id="study" name="study"></textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Conclusion</label>
                            <textarea rows="5" class="form-control ckeditor" id="conclusion"
                                      name="conclusion"></textarea>
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
<style>
    iframe, .wysihtml5-sandbox {
        height: 400px !important;
    }
</style>