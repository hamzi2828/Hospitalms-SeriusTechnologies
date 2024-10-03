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
        
        <div class="search">
            <form method="get">
                <div class="col-sm-1">
                    <label>Report No</label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'id' ] ?>" name="id">
                </div>
                <div class="col-sm-2">
                    <label><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'patient_id' ] ?>"
                           name="patient_id">
                </div>
                <div class="col-sm-3">
                    <label><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'name' ] ?>" name="name">
                </div>
                <div class="col-sm-3">
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
                <div class="col-sm-2">
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
                    <i class="fa fa-globe"></i> Reports
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
                        <th> Performed By</th>
                        <th> Report Title</th>
                        <th> Report Status</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $reports ) > 0 ) {
                            foreach ( $reports as $report ) {
                                $patient_id = get_patient_id_by_sale_id ( $report -> sale_id );
                                $patient    = get_patient ( $patient_id );
                                
                                if ( !empty( trim ( $report -> order_by ) ) )
                                    $order_by = get_doctor ( $report -> order_by );
                                else
                                    $order_by = '';
                                
                                $user   = get_user ( $report -> user_id );
                                $doctor = get_doctor ( $report -> doctor_id );
                                $status = get_report_verify_status ( $report -> id, 'hmis_culture' );
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter ++ ?> </td>
                                    <td> <?php echo $report -> id ?> </td>
                                    <td> <?php echo $report -> sale_id ?> </td>
                                    <td><?php echo $patient -> id ?></td>
                                    <td><?php echo get_patient_name (0, $patient) ?></td>
                                    <td><?php echo $patient -> mobile ?></td>
                                    <td><?php echo $order_by -> name ?></td>
                                    <td><?php echo $doctor -> name ?></td>
                                    <td><?php echo $user -> name ?></td>
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
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print-culture-report', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn purple"
                                               href="<?php echo base_url ( '/invoices/culture-report?report-id=' . $report -> id . '&logo=true' ) ?>"
                                               target="_blank">L-Print</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print-culture-report', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn purple"
                                               href="<?php echo base_url ( '/invoices/culture-report?report-id=' . $report -> id ) ?>"
                                               target="_blank">Print</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit-culture-report', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/culture/culture/edit?report_id=' . $report -> id ) ?>">Edit</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'verify_culture_report_button', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) && empty( $status ) ) : ?>
                                            <a type="button" class="btn green"
                                               onclick="return confirm('Are you sure?')"
                                               href="<?php echo base_url ( '/culture/verify_report?report-id=' . $report -> id ) ?>">Verify</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete-culture-report', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/culture/culture/delete/' . $report -> id ) ?>"
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