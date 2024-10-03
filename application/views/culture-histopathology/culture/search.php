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
                    <label>Report ID</label>
                    <input type="text" name="report_id" class="form-control"
                           value="<?php echo @$_REQUEST[ 'report_id' ] ?>">
                </div>
                <div class="col-lg-2">
                    <label><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                    <input type="text" name="sale_id" class="form-control"
                           value="<?php echo @$_REQUEST[ 'sale_id' ] ?>">
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
                    <i class="fa fa-reorder"></i> Search Report
                </div>
            </div>
            <div class="portlet-body form">
                <?php
                    if ( !empty( $report ) ) {
                        $patient_id = get_patient_id_by_sale_id ( $report -> sale_id );
                        $patient = get_patient ( $patient_id );
                        $order_by = get_doctor ( $report -> order_by );
                        $doctor = get_doctor ( $report -> doctor_id );
                        ?>
                        <form role="form" method="post" autocomplete="off">
                            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                            <input type="hidden" name="action" value="do_edit_report">
                            <input type="hidden" name="report_id" value="<?php echo $report -> id ?>">
                            <div class="form-body" style="overflow:auto;">
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Invoice ID</label>
                                    <input type="text" class="form-control" placeholder="Invoice ID"
                                           autofocus="autofocus" value="<?php echo $report -> sale_id; ?>"
                                           required="required" readonly="readonly">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                                    <input type="text" class="form-control" placeholder="EMR"
                                           value="<?php echo $patient -> id; ?>" readonly="readonly">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control name" id="patient-name" readonly="readonly"
                                           value="<?php echo get_patient_name (0, $patient) ?>">
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
                                <div class="form-group col-lg-4">
                                    <label for="exampleInputEmail1">Specimen</label>
                                    <select name="sample-id" class="form-control select2me" required="required">
                                        <option value="">Select</option>
                                        <?php
                                            if ( count ( $samples ) > 0 ) {
                                                foreach ( $samples as $sample ) {
                                                    ?>
                                                    <option value="<?php echo $sample -> id ?>" <?php if ( $report -> sample_id == $sample -> id )
                                                        echo 'selected="selected"' ?>>
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
                                    <input type="text" class="form-control" name="report_title" required="required"
                                           value="<?php echo $report -> report_title ?>">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="exampleInputEmail1">Study</label>
                                    <textarea rows="5" class="form-control ckeditor"
                                              name="study"><?php echo $report -> study ?></textarea>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="exampleInputEmail1">Conclusion</label>
                                    <textarea rows="5" class="form-control ckeditor"
                                              name="conclusion"><?php echo $report -> conclusion ?></textarea>
                                </div>
                                
                                <div class="form-group col-lg-12">
                                    <h3><strong>Antibiotic (Susceptibility)</strong></h3>
                                    <hr/>
                                    
                                    <table class="table table-striped table-bordered" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Antibiotic</th>
                                            <th>
                                                <table class="table table-striped table-bordered"
                                                       style="background-color: transparent;">
                                                    <thead>
                                                    <tr>
                                                        <th>Organism 1</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="organism-1" class="form-control"
                                                                   value="<?php echo $report -> organism_1 ?>">
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                Result
                                            </th>
                                            <th>
                                                <table class="table table-striped table-bordered"
                                                       style="background-color: transparent;">
                                                    <thead>
                                                    <tr>
                                                        <th>Organism 2</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="organism-2" class="form-control"
                                                                   value="<?php echo $report -> organism_2 ?>">
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                Result
                                            </th>
                                            <th>
                                                <table class="table table-striped table-bordered"
                                                       style="background-color: transparent;">
                                                    <thead>
                                                    <tr>
                                                        <th>Organism 3</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="organism-3" class="form-control"
                                                                   value="<?php echo $report -> organism_3 ?>">
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                Result
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $counter = 1;
                                            if ( count ( $addedAntibiotics ) > 0 ) {
                                                foreach ( $addedAntibiotics as $addedAntibiotic ) {
                                                    $antibioticInfo = get_antibiotic_by_id ( $addedAntibiotic -> antibiotic_id );
                                                    ?>
                                                    <input type="hidden" name="antibiotic[]"
                                                           value="<?php echo $addedAntibiotic -> antibiotic_id ?>">
                                                    <tr>
                                                        <td><?php echo $counter++; ?></td>
                                                        <td><?php echo $antibioticInfo -> title ?></td>
                                                        <td>
                                                            <select name="result-1[]" class="form-control select2me">
                                                                <option value="">Select</option>
                                                                <option value="S" <?php if ( $addedAntibiotic -> result_1 == 'S' )
                                                                    echo 'selected="selected"' ?>>S
                                                                </option>
                                                                <option value="IS" <?php if ( $addedAntibiotic -> result_1 == 'IS' )
                                                                    echo 'selected="selected"' ?>>IS
                                                                </option>
                                                                <option value="IR" <?php if ( $addedAntibiotic -> result_1 == 'IR' )
                                                                    echo 'selected="selected"' ?>>IR
                                                                </option>
                                                                <option value="R" <?php if ( $addedAntibiotic -> result_1 == 'R' )
                                                                    echo 'selected="selected"' ?>>R
                                                                </option>
                                                            </select>
                                                        </td>
                                                        
                                                        <td>
                                                            <select name="result-2[]" class="form-control select2me">
                                                                <option value="">Select</option>
                                                                <option value="S" <?php if ( $addedAntibiotic -> result_2 == 'S' )
                                                                    echo 'selected="selected"' ?>>S
                                                                </option>
                                                                <option value="IS" <?php if ( $addedAntibiotic -> result_2 == 'IS' )
                                                                    echo 'selected="selected"' ?>>IS
                                                                </option>
                                                                <option value="IR" <?php if ( $addedAntibiotic -> result_2 == 'IR' )
                                                                    echo 'selected="selected"' ?>>IR
                                                                </option>
                                                                <option value="R" <?php if ( $addedAntibiotic -> result_2 == 'R' )
                                                                    echo 'selected="selected"' ?>>R
                                                                </option>
                                                            </select>
                                                        </td>
                                                        
                                                        <td>
                                                            <select name="result-3[]" class="form-control select2me">
                                                                <option value="">Select</option>
                                                                <option value="S" <?php if ( $addedAntibiotic -> result_3 == 'S' )
                                                                    echo 'selected="selected"' ?>>S
                                                                </option>
                                                                <option value="IS" <?php if ( $addedAntibiotic -> result_3 == 'IS' )
                                                                    echo 'selected="selected"' ?>>IS
                                                                </option>
                                                                <option value="IR" <?php if ( $addedAntibiotic -> result_3 == 'IR' )
                                                                    echo 'selected="selected"' ?>>IR
                                                                </option>
                                                                <option value="R" <?php if ( $addedAntibiotic -> result_3 == 'R' )
                                                                    echo 'selected="selected"' ?>>R
                                                                </option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            
                                            if ( count ( $antibiotics ) > 0 ) {
                                                foreach ( $antibiotics as $antibiotic ) {
                                                    ?>
                                                    <input type="hidden" name="antibiotic[]"
                                                           value="<?php echo $antibiotic -> id ?>">
                                                    <tr>
                                                        <td><?php echo $counter++; ?></td>
                                                        <td><?php echo $antibiotic -> title ?></td>
                                                        <td>
                                                            <select name="result-1[]" class="form-control select2me">
                                                                <option value="">Select</option>
                                                                <option value="R">R
                                                                </option>
                                                                <option value="S">S
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="result-2[]" class="form-control select2me">
                                                                <option value="">Select</option>
                                                                <option value="R">R
                                                                </option>
                                                                <option value="S">S
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="result-3[]" class="form-control select2me">
                                                                <option value="">Select</option>
                                                                <option value="R">R
                                                                </option>
                                                                <option value="S">S
                                                                </option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        ?>
                                        </tbody>
                                    </table>
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