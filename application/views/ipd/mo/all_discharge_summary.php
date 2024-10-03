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
                    <i class="fa fa-globe"></i> All Discharge Summary
                </div>
            </div>
            <div class="portlet-body" style="overflow:auto;">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Admission No</th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?> </th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?> </th>
                        <th> Consultant</th>
                        <th> Medical Officer</th>
                        <th> Admission Date</th>
                        <th> Discharge Date</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $summary ) > 0 ) {
                            $counter = 1;
                            foreach ( $summary as $row ) {
                                $patient         = get_patient ( $row -> patient_id );
                                $consultant      = get_doctor ( $row -> consultant_id );
                                $medical_officer = get_doctor ( $row -> medical_officer );
                                ?>
                                <tr>
                                    <td><?php echo $counter++ ?></td>
                                    <td><?php echo 'ADM-' . $row -> admission_no ?></td>
                                    <td><?php echo $row -> patient_id ?></td>
                                    <td><?php echo get_patient_name ( 0, $patient ) ?></td>
                                    <td><?php echo $consultant -> name ?></td>
                                    <td><?php echo $medical_officer -> name ?></td>
                                    <td><?php echo date ( 'm/d/Y', strtotime ( $row -> admission_date ) ) ?></td>
                                    <td><?php echo date ( 'm/d/Y', strtotime ( $row -> discharge_date ) ) ?></td>
                                    <td><?php echo date_setter ( $row -> date_added ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print_discharge_summary', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn-block btn purple"
                                               href="<?php echo base_url ( '/invoices/discharge-summary-invoice/' . $row -> id ) ?>">Print</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_discharge_summary', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn-block btn green"
                                               href="<?php echo base_url ( '/IPD/mo/edit-discharge-summary/' . $row -> id ) ?>">Edit</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_discharge_summary', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn-block btn red"
                                               href="<?php echo base_url ( '/IPD/mo/delete-discharge-summary/' . $row -> id ) ?>"
                                               onclick="return confirm('Are you sure you want to delete?')">Delete</a>
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