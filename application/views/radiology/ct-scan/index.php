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
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        
        <div class="search-form">
            <form method="get">
                <div class="col-sm-2 form-group">
                    <label>Report No</label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'id' ] ?>" name="id">
                </div>
                <div class="col-sm-2 form-group">
                    <label><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'patient_id' ] ?>"
                           name="patient_id">
                </div>
                <div class="col-sm-2 form-group">
                    <label><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'name' ] ?>" name="name">
                </div>
                <div class="col-sm-3 form-group">
                    <label>Doctor</label>
                    <select name="doctor_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $doctors ) > 0 ) {
                                foreach ( $doctors as $doctor ) {
                                    ?>
                                    <option
                                        value="<?php echo $doctor -> id ?>" <?php echo ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 and $_REQUEST[ 'doctor_id' ] == $doctor -> id ) ? 'selected="selected"' : ''; ?>><?php echo $doctor -> name ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-2 form-group">
                    <label>Report Title </label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'title' ] ?>" name="title">
                </div>
                <div class="col-sm-1">
                    <button type="submit" style="margin-top: 25px" class="btn btn-primary btn-block">Search</button>
                </div>
            </form>
        </div>
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> CT-Scan Reports
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Report No.</th>
                        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                        <th> <?php echo $this -> lang -> line('PATIENT_PHONE') ?></th>
                        <th> Ordered By</th>
                        <th> Transcribed By</th>
                        <th> Radiologist</th>
                        <th> Report Title</th>
                        <th> Report Status</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1 + ( isset( $_REQUEST[ 'per_page' ] ) ? $_REQUEST[ 'per_page' ] : 0 );
                        if ( count ( $reports ) > 0 ) {
                            foreach ( $reports as $report ) {
                                
                                $patient = get_patient ( $report -> patient_id );
                                if ( !empty( trim ( $report -> order_by ) ) )
                                    $order_by = get_doctor ( $report -> order_by );
                                else
                                    $order_by = '';
                                
                                $user   = get_user ( $report -> user_id );
                                $doctor = get_doctor ( $report -> doctor_id );
                                $status = get_report_verify_status ( $report -> id, 'hmis_ct_scan' );
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $report -> id ?> </td>
                                    <td> <?php echo $report -> sale_id ?> </td>
                                    <td><?php echo $patient -> id ?></td>
                                    <td><?php echo get_patient_name (0, $patient) ?></td>
                                    <td><?php echo $patient -> mobile ?></td>
                                    <td><?php echo $order_by -> name ?></td>
                                    <td><?php echo $user -> name ?></td>
                                    <td><?php echo $doctor -> name ?></td>
                                    <td><?php echo $report -> report_title ?></td>
                                    <td>
                                        <?php
                                            if ( empty( $status ) )
                                                echo '<span class="badge badge-warning">Not Verified</span>';
                                            else {
                                                echo '<span class="badge badge-success">Verified</span><br/><br/>';
                                                echo '<strong>Verified By: </strong>' . get_user ( $status -> user_id ) -> name . '<br/>';
                                                echo '<strong>Date/Time: </strong>' . date_setter ( $status -> created_at, 5 );
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo date_setter ( $report -> date_added ); ?>
                                    </td>
                                    <td class="btn-group-xs">
                                        
                                        <?php if ( !empty( trim ( $report -> film ) ) ) : ?>
                                            <a type="button" class="btn btn-primary margin-bottom-5"
                                               href="<?php echo $report -> film ?>"
                                               download="<?php echo url_title ( $report -> report_title . '-' . $report -> id, '-', true ) ?>">Download</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print_ct_scan_report', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn purple"
                                               href="<?php echo base_url ( '/invoices/ct-scan-report?logo=true&report-id=' . $report -> id ) ?>"
                                               target="_blank">L-Print</a>
                                            
                                            <a type="button" class="btn dark btn-block margin-bottom-5"
                                               href="<?php echo base_url ( '/invoices/ct-scan-report?logo=false&report-id=' . $report -> id ) ?>"
                                               target="_blank">Print</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_ct_scan_report', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/radiology/ct-scan/search-ct-scan-report?report_id=' . $report -> id ) ?>">Edit</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'verify_ct_scan_report_button', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) && empty( $status ) ) : ?>
                                            <a type="button" class="btn green"
                                               onclick="return confirm('Are you sure?')"
                                               href="<?php echo base_url ( '/radiology/x-ray/verify-ct-scan-report?report-id=' . $report -> id ) ?>">Verify</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_ct_scan_report', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/radiology/ct-scan/delete-ct-scan-report/' . $report -> id ) ?>"
                                               onclick="return confirm('Are you sure?')">Delete</a>
                                        <?php endif; ?>
                                    
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <div id="pagination">
                <ul class="tsc_pagination">
                    <!-- Show pagination links -->
                    <?php foreach ( $links as $link ) {
                        echo "<li>" . $link . "</li>";
                    } ?>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .input-xsmall {
        width: 100px !important;
    }
</style>