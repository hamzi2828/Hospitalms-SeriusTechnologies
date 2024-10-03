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
                    <i class="fa fa-globe"></i> Members List
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Name</th>
                        <th> Email</th>
                        <th> Phone</th>
                        <th> CNIC</th>
                        <th> Gender</th>
                        <th> Department</th>
                        <th> Panel</th>
                        <th> Status</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $members ) > 0 ) {
                            foreach ( $members as $member ) {
                                $panel_id = $member -> panel_id;
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $member -> name ?></td>
                                    <td><?php echo $member -> email ?></td>
                                    <td><?php echo $member -> phone ?></td>
                                    <td><?php echo $member -> cnic ?></td>
                                    <td><?php echo ( $member -> gender == '1' ) ? 'Male' : 'Female' ?></td>
                                    <td>
                                        <?php echo @get_department ( $member -> department_id ) -> name ?>
                                    </td>
                                    <td>
                                        <?php echo @get_panel_by_id ( $panel_id ) -> name ?>
                                    </td>
                                    <td><?php echo ( $member -> status == '1' ) ? 'Active' : 'Inactive' ?></td>
                                    <td>
                                        <?php echo date_setter ( $member -> date_added ); ?>
                                    </td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_members', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <?php if ( $member -> panel_id > 0 ) : ?>
                                                <a type="button" class="btn blue"
                                                   href="<?php echo base_url ( '/user/edit-panel?id=' . encode ( $member -> id ) ) ?>">Edit</a>
                                            <?php else : ?>
                                                <a type="button" class="btn blue"
                                                   href="<?php echo base_url ( '/user/edit?id=' . encode ( $member -> id ) ) ?>">Edit</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_members', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <?php if ( $member -> status == '1' ) : ?>
                                                <a type="button" class="btn red"
                                                   href="<?php echo base_url ( '/user/delete?id=' . encode ( $member -> id ) . '&status=0' ) ?>"
                                                   onclick="return confirm('Are you sure you want to inactive?')">Inactive</a>
                                            <?php endif; ?>
                                            <?php if ( $member -> status == '0' ) : ?>
                                                <a type="button" class="btn purple"
                                                   href="<?php echo base_url ( '/user/delete?id=' . encode ( $member -> id ) . '&status=1' ) ?>">Active</a>
                                            <?php endif; ?>
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