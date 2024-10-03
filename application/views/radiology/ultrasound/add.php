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
                    <i class="fa fa-reorder"></i> Add Ultrasound Report
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_ultrasound_report">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></label>
                                <input type="text" name="sale-id" class="form-control" placeholder="<?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>"
                                       autofocus="autofocus" value="<?php echo set_value ( 'sale-id' ) ?>"
                                       onchange="get_patient_by_lab_sale_id(this.value)">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="patient-id"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                                <input type="text" id="patient-id" name="patient-id" class="form-control"
                                       placeholder="<?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>"
                                       value="<?php echo set_value ( 'patient-id' ) ?>"
                                       onchange="get_patient(this.value)">
                            </div>
                            <div class="form-group col-lg-3">
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
                            <div class="form-group col-lg-6">
                                <label for="exampleInputEmail1">Report Title</label>
                                <select name="template-id" class="form-control select2me" required="required"
                                        onchange="get_template(this.value)">
                                    <option value="">Select</option>
                                    <?php
                                        if ( count ( $templates ) > 0 ) {
                                            foreach ( $templates as $template ) {
                                                ?>
                                                <option value="<?php echo $template -> id ?>">
                                                    <?php
                                                        echo $template -> title;
                                                        if ( !empty( trim ( $template -> gender ) ) )
                                                            echo ' (' . ucwords ( $template -> gender ) . ')';
                                                    ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <!--							<input type="text" class="form-control" name="report_title" required="required">-->
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="film">Film</label>
                                <input type="file" name="film" id="film" class="form-control" accept="image/*">
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
