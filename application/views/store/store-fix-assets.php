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
                    <i class="fa fa-globe"></i> All Store - Fix Assets
                </div>
                <a href="<?php echo base_url ( '/invoices/store-fix-assets-list?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                   target="_blank"
                   class="pull-right print-btn">Print</a>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Code</th>
                        <th> Item</th>
                        <th> Account Head</th>
                        <th> Department</th>
                        <th> Invoice</th>
                        <th> Value</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $assets ) > 0 ) {
                            foreach ( $assets as $asset ) {
                                $item       = get_store ( $asset -> store_id );
                                $acc_head   = get_account_head ( $asset -> account_head_id );
                                $department = get_department ( $asset -> department_id );
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $asset -> code ?></td>
                                    <td><?php echo $item -> item ?></td>
                                    <td><?php echo $acc_head -> title ?></td>
                                    <td><?php echo $department -> name ?></td>
                                    <td><?php echo $asset -> invoice ?></td>
                                    <td><?php echo number_format ( $asset -> value, 2 ) ?></td>
                                    <td><?php echo date_setter_without_time ( $asset -> purchase_date ) ?></td>
                                    <td>
                                        
                                        <a type="button" class="btn-xs btn dark btn-block" style="margin-bottom: 5px"
                                           target="_blank"
                                           href="<?php echo base_url ( '/invoices/store-code-ticket/' . $asset -> id ) ?>">
                                            Ticket
                                        </a>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_store_fix_assets', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn-xs btn blue"
                                               href="<?php echo base_url ( '/store/edit-store-fix-asset/' . $asset -> id ) ?>">
                                                Edit
                                            </a>
                                        <?php endif; ?>
                                        
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'dispose_store_fix_assets_btn', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) && !is_item_disposed ( $asset -> id ) ) : ?>
                                            <a type="button" class="btn-xs btn purple"
                                               href="<?php echo base_url ( '/store/dispose-store-fix-asset/' . $asset -> id ) ?>">
                                                Dispose
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_store_fix_assets', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn-xs btn red"
                                               href="<?php echo base_url ( '/store/delete_store_fix_asset/' . $asset -> id ) ?>"
                                               onclick="return confirm('Are you sure?')">
                                                Delete
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