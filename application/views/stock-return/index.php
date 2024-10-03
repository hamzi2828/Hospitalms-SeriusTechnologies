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
                    <i class="fa fa-globe"></i> Stock Return
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Supplier</th>
                        <th> Medicine</th>
                        <th> Batch</th>
                        <th> Invoice</th>
                        <th> Return Qty</th>
                        <th> Cost/Unit</th>
                        <th> Net Price</th>
                        <th> Date Return</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $returned ) > 0 ) {
                            $counter = 1;
                            foreach ( $returned as $item ) {
                                $medicine_id = explode ( ',', $item -> medicines );
                                $stock_id = explode ( ',', $item -> stock );
                                $cost = explode ( ',', $item -> cost_unit );
                                $supplier = get_account_head ( $item -> supplier_id );
                                
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $supplier -> title ?></td>
                                    <td>
                                        <?php
                                            if ( count ( $medicine_id ) > 0 ) {
                                                foreach ( $medicine_id as $id ) {
                                                    $medicine = get_medicine ( $id );
                                                    $generic = get_generic ( $medicine -> generic_id );
                                                    $form = get_form ( $medicine -> form_id );
                                                    $strength = get_strength ( $medicine -> strength_id );
                                                    echo $medicine -> name;
                                                    
                                                    if ( $medicine -> form_id > 1 )
                                                        echo ' ' .$form -> title;
                                                    
                                                    if ( $medicine -> strength_id > 1 )
                                                        echo ' ' . $strength -> title;
                                                    echo '<br/>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $stock_id ) > 0 ) {
                                                foreach ( $stock_id as $id ) {
                                                    echo get_stock ( $id ) -> batch . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $item -> invoice ?></td>
                                    <td><?php echo $item -> return_qty ?></td>
                                    <td>
                                        <?php
                                            if ( count ( $cost ) > 0 ) {
                                                foreach ( $cost as $value ) {
                                                    echo $value . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $item -> net_price ?></td>
                                    <td><?php echo date_setter ( $item -> date_added ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print_medicine_return_button', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn purple"
                                               href="<?php echo base_url ( '/invoices/stock-return-invoice/' . $item -> return_id ) ?>"
                                               target="_blank">Print</a>
                                        <?php endif; ?>
                                        <a type="button" class="btn blue"
                                           href="<?php echo base_url ( '/stock-return/edit/' . $item -> return_id ) ?>">View</a>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_medicine_return_button', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/stock-return/delete/' . $item -> return_id ) ?>"
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