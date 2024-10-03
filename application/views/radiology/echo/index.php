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
                    <label>Patient EMR</label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'patient_id' ] ?>"
                           name="patient_id">
                </div>
                <div class="col-sm-2 form-group">
                    <label>Patient Name</label>
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
                    <i class="fa fa-globe"></i> ECHO Reports
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Report No.</th>
                        <th> Patient EMR</th>
                        <th> Patient Name</th>
                        <th> Patient Phone</th>
                        <th> Ordered By</th>
                        <th> Transcribed By</th>
                        <th> Performed By</th>
                        <th> Report Title</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $reports ) > 0 ) {
                            $counter = 1;
                            foreach ( $reports as $report ) {
                                $patient = get_patient ( $report -> patient_id );
                                if ( !empty( trim ( $report -> order_by ) ) )
                                    $order_by = get_doctor ( $report -> order_by );
                                else
                                    $order_by = '';
                                $user   = get_user ( $report -> user_id );
                                $doctor = get_doctor ( $report -> doctor_id );
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $report -> id ?> </td>
                                    <td><?php echo $patient -> id ?></td>
                                    <td><?php echo $patient -> name ?></td>
                                    <td><?php echo $patient -> mobile ?></td>
                                    <td><?php echo $order_by -> name ?></td>
                                    <td><?php echo $doctor -> name ?></td>
                                    <td><?php echo $user -> name ?></td>
                                    <td><?php echo $report -> report_title ?></td>
                                    <td>
                                        <?php echo date_setter ( $report -> date_added ); ?>
                                    </td>
                                    <td class="btn-group-xs">
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print_echo_report', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn purple"
                                               href="<?php echo base_url ( '/invoices/echo-report?report-id=' . $report -> id ) ?>"
                                               target="_blank">Print</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_echo_report', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/radiology/echo/edit-echo-report?report_id=' . $report -> id ) ?>">Edit</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_echo_report', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/radiology/echo/delete-echo-report/' . $report -> id ) ?>"
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