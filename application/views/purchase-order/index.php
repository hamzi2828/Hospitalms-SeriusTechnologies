<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Purchase Orders
                </div>
            </div>
            <div class="portlet-body">
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
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Order ID#</th>
                        <th> Supplier</th>
                        <th> Medicine</th>
                        <th> Pack Size</th>
                        <th> Quantity</th>
                        <th> TP</th>
                        <th> App Amount</th>
                        <!--                        <th> Status </th>-->
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $orders ) > 0 ) {
                            foreach ( $orders as $order ) {
                                $medicines = explode ( ',', $order -> medicine_id );
                                $tp = explode ( ',', $order -> tp );
                                $box_qty = explode ( ',', $order -> box_qty );
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $order -> unique_id ?></td>
                                    <td> <?php echo get_supplier ( $order -> supplier_id ) -> title; ?> </td>
                                    <td>
                                        <?php
                                            foreach ( $medicines as $medicine_id )
                                                echo get_medicine ( $medicine_id ) -> name . '<br>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            foreach ( $medicines as $medicine_id )
                                                echo get_medicine ( $medicine_id ) -> quantity . '<br>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            foreach ( $box_qty as $item )
                                                echo $item . '<br>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            foreach ( $tp as $item )
                                                echo $item . '<br>';
                                        ?>
                                    </td>
                                    <td><?php echo number_format ( $order -> total, 2 ) ?></td>
                                    
                                    <td><?php echo date_setter ( $order -> order_date ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_purchase_orders', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <?php if ( $order -> status == '0' ) : ?>
                                                <a type="button" class="btn purple"
                                                   href="<?php echo base_url ( '/purchase-order/received/' . $order -> unique_id ) ?>">Received</a>
                                            <?php endif; ?>
                                            <?php if ( $order -> status == '1' ) : ?>
                                                <a type="button" class="btn purple"
                                                   href="<?php echo base_url ( '/purchase-order/pending/' . $order -> unique_id ) ?>">Pending</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print_purchase_orders', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/invoices/purchase-order-invoice/' . $order -> unique_id ) ?>"
                                               target="_blank">Print</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_purchase_orders', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/purchase-order/delete/' . $order -> unique_id ) ?>"
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