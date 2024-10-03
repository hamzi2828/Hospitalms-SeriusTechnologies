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
                    <i class="fa fa-globe"></i> Requisitions (Others)
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Requisition No</th>
                        <th> Request From</th>
                        <th> Department</th>
                        <th> Item</th>
                        <th> Quantity</th>
                        <th> Est. Price</th>
                        <th> Purpose</th>
                        <th> Status</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $requests ) > 0 ) {
                            foreach ( $requests as $requisition ) {
                                $user = get_user ( $requisition -> request_from );
                                if ( $user -> department_id > 0 )
                                    $department = get_department ( $user -> department_id ) -> name;
                                else
                                    $department = 'No department assigned';
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $requisition -> requisitions_id ?></td>
                                    <td><?php echo $user -> name ?></td>
                                    <td><?php echo $department ?></td>
                                    <td><?php echo $requisition -> name ?></td>
                                    <td><?php echo $requisition -> quantity ?></td>
                                    <td><?php echo number_format ( $requisition -> price, 2 ) ?></td>
                                    <td><?php echo $requisition -> description ?></td>
                                    <td><?php echo ucfirst ( $requisition -> status ) ?></td>
                                    <td><?php echo date_setter ( $requisition -> date_added ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_demand_requisitions', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/requisition/edit-demand/' . $requisition -> id ) ?>" <?php if ( $requisition -> status != 'pending' ) echo 'disabled="disabled"' ?>>Edit</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_demand_requisitions', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/requisition/delete-demand/' . $requisition -> id ) ?>" <?php if ( $requisition -> status != 'pending' ) echo 'disabled="disabled"' ?>
                                               onclick="return confirm('Are you sure to delete?')">Delete</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print_demand_requisitions', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn btn-block dark" target="_blank"
                                               href="<?php echo base_url ( '/invoices/demand-requisition/' . $requisition -> requisitions_id ) ?>">
                                                Print
                                            </a>
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