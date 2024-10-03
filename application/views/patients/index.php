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
                    <label>Start Date</label>
                    <input type="text" class="form-control date-picker" value="<?php echo @$_GET[ 'start_date' ] ?>"
                           name="start_date">
                </div>
                <div class="col-sm-2 form-group">
                    <label>End Date</label>
                    <input type="text" class="form-control date-picker" value="<?php echo @$_GET[ 'end_date' ] ?>"
                           name="end_date">
                </div>
                <div class="col-sm-2 form-group">
                    <label>EMR.No</label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'id' ] ?>" name="id">
                </div>
                <div class="col-sm-3 form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'name' ] ?>" name="name">
                </div>
                <div class="col-sm-3 form-group">
                    <label>CNIC</label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'cnic' ] ?>" name="cnic">
                </div>
                <div class="col-sm-3 form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'phone' ] ?>" name="phone">
                </div>
                <div class="col-sm-3 form-group">
                    <label>Cash/Panel</label>
                    <select name="patient-type" class="form-control select2me">
                        <option value="">Select</option>
                        <option
                                value="cash" <?php if ( @$_REQUEST[ 'patient-type' ] == 'cash' ) echo 'selected="selected"' ?>>
                            Cash
                        </option>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    ?>
                                    
                                    <option
                                            value="<?php echo $panel -> id ?>" <?php if ( @$_REQUEST[ 'patient-type' ] == $panel -> id ) echo 'selected="selected"' ?>>
                                        <?php echo $panel -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button type="submit" style="margin-top: 25px" class="btn btn-primary btn-block">Search</button>
                </div>
            </form>
        </div>
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Patients List
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                        <th> Picture</th>
                        <th> Name</th>
                        <th> CNIC</th>
                        <th> Phone</th>
                        <th> Age</th>
                        <th> Gender</th>
                        <th> Type</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1 + ( isset( $_REQUEST[ 'per_page' ] ) ? $_REQUEST[ 'per_page' ] : 0 );
                        if ( count ( $patients ) > 0 ) {
                            foreach ( $patients as $patient ) {
                                if ( $patient -> panel_id > 0 )
                                    $type = 'panel';
                                else
                                    $type = 'cash';
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo emr_prefix . $patient -> id ?></td>
                                    <td>
                                        <?php if ( !empty( trim ( $patient -> picture ) ) ) : ?>
                                            <div class="image"
                                                 style="background-image: url('<?php echo $patient -> picture ?>')"></div>
                                        <?php endif ?>
                                    </td>
                                    <td><?php echo get_patient_name (0, $patient) ?></td>
                                    <td><?php echo $patient -> cnic ?></td>
                                    <td><?php echo $patient -> mobile ?></td>
                                    <td><?php echo $patient -> age ?></td>
                                    <td>
                                        <?php echo ( $patient -> gender == '1' ) ? 'Male' : 'Female' ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( $patient -> panel_id > 0 )
                                                echo 'Panel / ' . get_panel_by_id ( $patient -> panel_id ) -> name;
                                            else
                                                echo 'Cash';
                                        ?>
                                    </td>
                                    <td><?php echo date_setter ( $patient -> date_registered ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'patient_medical_history', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/patients/history/' . $patient -> id ) ?>">Medical
                                                                                                                       History</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_patient', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn green"
                                               href="<?php echo base_url ( '/patients/edit-' . $type . '/' . $patient -> id ) ?>">Edit</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_patient', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/patients/delete/' . $patient -> id ) ?>"
                                               onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print_patient', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn purple"
                                               href="<?php echo base_url ( '/invoices/patient-invoice/' . $patient -> id ) ?>"
                                               target="_blank">Print Face Sheet</a>
                                        <?php endif; ?>
                                        
                                        <a type="button" class="btn btn-warning btn-block"
                                           href="<?php echo base_url ( '/invoices/patient-card/' . $patient -> id ) ?>"
                                           target="_blank">Print Card</a>
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

    .image {
        width: 50px;
        height: 50px;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        border-radius: 50% !important;
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.8);
    }
</style>