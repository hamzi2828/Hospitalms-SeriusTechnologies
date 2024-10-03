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
                    <label><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'patient_id' ] ?>"
                           name="patient_id">
                </div>
                <div class="col-sm-3 form-group">
                    <label><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'name' ] ?>" name="name">
                </div>
                <div class="col-sm-3 form-group">
                    <label><?php echo $this -> lang -> line('PATIENT_CNIC') ?></label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'cnic' ] ?>" name="cnic">
                </div>
                <div class="col-sm-3 form-group">
                    <label><?php echo $this -> lang -> line('PATIENT_PHONE') ?></label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'phone' ] ?>" name="phone">
                </div>
                <div class="col-sm-1">
                    <button type="submit" style="margin-top: 25px" class="btn btn-primary btn-block">Search</button>
                </div>
            </form>
        </div>
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Patient Vitals List
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
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
                        if ( count ( $vitals ) > 0 ) {
                            $counter = 1 + ( isset( $_REQUEST[ 'per_page' ] ) ? $_REQUEST[ 'per_page' ] : 0 );
                            foreach ( $vitals as $vital ) {
                                $patient = get_patient ( $vital -> patient_id );
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo emr_prefix . $patient -> id ?></td>
                                    <td><?php echo get_patient_name (0, $patient) ?></td>
                                    <td><?php echo $patient -> cnic ?></td>
                                    <td><?php echo $patient -> mobile ?></td>
                                    <td><?php echo $patient -> age ?></td>
                                    <td>
                                        <?php echo ( $patient -> gender == '1' ) ? 'Male' : 'Female' ?>
                                    </td>
                                    <td>
                                        <?php echo ucfirst ( $patient -> type ) ?>
                                    </td>
                                    <td><?php echo date_setter ( $vital -> date_added ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_vitals', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/vitals/edit/' . $vital -> vital_id ) ?>">Edit</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_vitals', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/vitals/delete/' . $vital -> vital_id ) ?>">Delete</a>
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
                </ul>
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