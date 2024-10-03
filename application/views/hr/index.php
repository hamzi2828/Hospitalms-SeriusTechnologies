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
                    <i class="fa fa-globe"></i> <?php echo $title ?>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Code</th>
                        <th> Name</th>
                        <th> Father Name</th>
                        <th> Mother Name</th>
                        <th> Gender</th>
                        <th> CNIC</th>
                        <th> Mobile</th>
                        <th> Contract Date</th>
                        <th> Hiring Date</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $employees ) > 0 ) {
                            foreach ( $employees as $employee ) {
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $employee -> code ?></td>
                                    <td><?php echo $employee -> name ?></td>
                                    <td><?php echo $employee -> father_name ?></td>
                                    <td><?php echo $employee -> mother_name ?></td>
                                    <td><?php echo ( $employee -> gender == '1' ) ? 'Male' : 'Female' ?></td>
                                    <td><?php echo $employee -> cnic ?></td>
                                    <td><?php echo $employee -> mobile ?></td>
                                    <td><?php echo date ( 'd/m/Y', strtotime ( $employee -> contract_date ) ) ?></td>
                                    <td><?php echo date ( 'd/m/Y', strtotime ( $employee -> hiring_date ) ) ?></td>
                                    <td>
                                        <?php echo date_setter ( $employee -> date_added ); ?>
                                    </td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_hr_members', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/hr/edit/' . $employee -> id ) ?>">Edit</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'active_deactive_hr_members', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <?php if ( $employee -> active == 1 ) : ?>
                                                <a onclick="return confirm('Employee is active. Are you sure to deactivate?')"
                                                   type="button" class="btn green"
                                                   href="<?php echo base_url ( '/hr/update_status/' . $employee -> id . '?status=0' ) ?>">Active</a>
                                            <?php else : ?>
                                                <a onclick="return confirm('Employee is deactivate. Are you sure to active?')"
                                                   type="button" class="btn red"
                                                   href="<?php echo base_url ( '/hr/update_status/' . $employee -> id . '?status=1' ) ?>">Deactivate</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_hr_members', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/hr/delete/' . $employee -> id ) ?>"
                                               onclick="return confirm('Are you sure?')">Delete</a>
                                        <?php endif; ?>
                                        <a type="button" class="btn purple" target="_blank"
                                           href="<?php echo base_url ( '/invoices/employee/' . $employee -> id ) ?>">Print</a>
                                        
                                        <a type="button" class="btn purple" target="_blank"
                                           href="<?php echo base_url ( '/invoices/employee-loan-details/?employee_id=' . $employee -> id ) ?>">
                                            Print Loan History
                                        </a>
                                        
                                        <a type="button" class="btn btn-block dark" target="_blank"
                                           href="<?php echo base_url ( '/invoices/employee-card/' . $employee -> id ) ?>">
                                            Print Card
                                        </a>
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
