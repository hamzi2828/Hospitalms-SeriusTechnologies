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
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Birth Certificates
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                        <th> Baby Name</th>
                        <th> Gender</th>
                        <th> Father Name</th>
                        <th> Mother Name</th>
                        <th> Birth Date/Time</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $certificates ) > 0 ) {
                            $counter = 1;
                            foreach ( $certificates as $certificate ) {
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo get_patient ( $certificate -> patient_id ) -> name ?></td>
                                    <td><?php echo $certificate -> name ?></td>
                                    <td><?php echo ucfirst ( $certificate -> gender ) ?></td>
                                    <td><?php echo $certificate -> father_name ?></td>
                                    <td><?php echo $certificate -> mother_name ?></td>
                                    <td><?php echo $certificate -> birth_date . '@' . $certificate -> birth_time ?></td>
                                    <td><?php echo date_setter ( $certificate -> created_at ); ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit-birth-certificate', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/birth-certificates/edit?id=' . encode ( $certificate -> id ) ) ?>">Edit</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete-birth-certificate', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/birth-certificates/delete?id=' . encode ( $certificate -> id ) ) ?>"
                                               onclick="return confirm('Are you sure?')">Delete</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print-birth-certificate', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn purple"
                                               href="<?php echo base_url ( '/invoices/birth-certificate?id=' . encode ( $certificate -> id ) ) ?>" target="_blank">Print</a>
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
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .input-xsmall {
        width: 100px !important;
    }
</style>