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
                    <i class="fa fa-globe"></i> Panels List
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Code</th>
                        <th> Name</th>
                        <th> Status</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $panels ) > 0 ) {
                            $counter = 1;
                            foreach ( $panels as $panel ) {
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $panel -> code ?></td>
                                    <td><?php echo $panel -> name ?></td>
                                    <td><?php echo ( $panel -> status == '1' ) ? 'Active' : 'Inactive' ?></td>
                                    <td><?php echo date_setter ( $panel -> date_added ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_panels', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/settings/edit-panel/' . $panel -> id . '?settings=general&tab=general' ) ?>">Edit</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_panels', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/settings/delete-panel/' . $panel -> id . '?settings=general' ) ?>"
                                               onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print_panels', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn purple"
                                               href="<?php echo base_url ( '/invoices/print-panel/?id=' . $panel -> id ) ?>">Print</a>
                                        <?php endif; ?>
                                        <?php if ( $panel -> status == '1' ) : ?>
                                            <a type="button" class="btn green"
                                               href="<?php echo base_url ( '/settings/panel-status/?id=' . encode ( $panel -> id ) . '&status=0' ) ?>"
                                               onclick="return confirm('Are you sure you want to inactive?')">Active</a>
                                        <?php endif; ?>
                                        <?php if ( $panel -> status == '0' ) : ?>
                                            <a type="button" class="btn red"
                                               onclick="return confirm('Are you sure you want to activate?')"
                                               href="<?php echo base_url ( '/settings/panel-status/?id=' . encode ( $panel -> id ) . '&status=1' ) ?>">Inactive</a>
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
        width : 100px !important;
    }
</style>