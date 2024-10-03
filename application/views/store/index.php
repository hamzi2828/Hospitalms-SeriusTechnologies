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
                    <i class="fa fa-globe"></i> All Items
                </div>
                <?php if ( count ( $stores ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/store-items' ); ?>" target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Name</th>
                        <th> Department</th>
                        <th> Threshold</th>
                        <th> Type</th>
                        <th> Total Quantity</th>
                        <th> Issued Quantity</th>
                        <th> Disposed Quantity</th>
                        <th> Available Quantity</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $stores ) > 0 ) {
                            foreach ( $stores as $store ) {
                                $total_quantity    = get_store_stock_total_quantity ( $store -> id );
                                $sold_quantity     = get_store_stock_sold_quantity ( $store -> id );
                                $disposed_quantity = get_store_disposed_quantity ( $store -> id );
                                $department        = get_department ( $store -> department_id );
                                $available         = $total_quantity - $sold_quantity - $disposed_quantity;
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $store -> item ?></td>
                                    <td><?php echo $department ? $department -> name : '-' ?></td>
                                    <td><?php echo $store -> threshold ?></td>
                                    <td>
                                        <?php
                                            if ( $store -> type == 'consumable-lab' )
                                                echo 'Consumable (Lab)';
                                            else if ( $store -> type == 'consumable' )
                                                echo 'Consumable (General)';
                                            else
                                                echo ucfirst ( $store -> type )
                                        ?>
                                    </td>
                                    <td><?php echo max ( $total_quantity, 0 ); ?></td>
                                    <td><?php echo max ( $sold_quantity, 0 ); ?></td>
                                    <td><?php echo max ( $disposed_quantity, 0 ); ?></td>
                                    <td><?php echo $available ?></td>
                                    <td>
                                        <?php echo date_setter ( $store -> date_added ); ?>
                                    </td>
                                    <td class="btn-group-xs">
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'stock_issued_items', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn purple"
                                               href="<?php echo base_url ( '/store/stock/' . $store -> id ) ?>">Stock</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_issued_items', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/store/edit/' . $store -> id ) ?>">Edit</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_issued_items', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) && $sold_quantity < 1 ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/store/delete/' . $store -> id ) ?>"
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