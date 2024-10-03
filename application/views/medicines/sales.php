<style>
    .search {
        width: 100%;
        display: block;
        float: left;
        background: #f5f5f5;
        padding: 15px 0 0 0;
        margin-bottom: 15px;
    }
</style>
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
        
        <div class="search">
            <form method="get" autocomplete="off">
                <?php /* <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Choose Account Head</label>
                    <select name="patient_id" class="form-control select2me">
                        <option value="">Select Account Head</option>
                        <?php
                        if (isset($_REQUEST['patient_id'])) {
                            $id = $_REQUEST['patient_id'];
                        }
                        else {
                            $id = '';
                        }
                        if(count($customers) > 0) {
                            foreach ($customers as $customer) {
                                ?>
                                <option value="<?php echo $customer -> id ?>" <?php if($id == $customer -> id) echo 'selected' ?>>
                                    <?php echo $customer -> title ?>
                                </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div> */ ?>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="date date-picker form-control" placeholder="Start date"
                           required="required"
                           value="<?php echo ( @$_REQUEST[ 'start_date' ] ) ? @$_REQUEST[ 'start_date' ] : date ( 'm/d/Y' ) ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="date date-picker form-control" placeholder="End date"
                           required="required"
                           value="<?php echo ( @$_REQUEST[ 'end_date' ] ) ? @$_REQUEST[ 'end_date' ] : date ( 'm/d/Y' ) ?>">
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Customer Name</label>
                    <input type="text" name="customer" class="form-control" placeholder="Customer Name"
                           value="<?php echo @$_GET[ 'customer' ] ?>">
                </div>
                <div class="col-lg-2" style="padding-top: 25px">
                    <button type="submit" class="btn btn-block btn-primary">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Medicines List
                </div>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                        <th> Medicine</th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                        <th> Batch#</th>
                        <th> Quantity</th>
                        <th> Price</th>
                        <th> Discount (%)</th>
                        <th> Discount (Flat)</th>
                        <th> Net Price</th>
                        <th> Date</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $sales ) > 0 ) {
                            foreach ( $sales as $sale ) {
                                $medicine_id   = explode ( ',', $sale -> medicine_id );
                                $stock_id      = explode ( ',', $sale -> stock_id );
                                $quantities    = explode ( ',', $sale -> quantity );
                                $prices        = explode ( ',', $sale -> price );
                                $patient       = get_account_head ( $sale -> patient_id );
                                $sale_info     = get_sale ( $sale -> sale_id );
                                $discount      = $sale_info -> discount;
                                $flat_discount = $sale_info -> flat_discount;
                                $total         = $sale_info -> total;
                                
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td>
                                        <?php
                                            echo $sale -> sale_id;
                                            if ( $sale_info -> refunded == '1' )
                                                echo '&nbsp;&nbsp; <span class="badge badge-important">Refunded</span>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $medicine_id ) > 0 ) {
                                                foreach ( $medicine_id as $id ) {
                                                    $med = get_medicine ( $id );
                                                    if ( $med -> strength_id > 1 )
                                                        $strength = get_strength ( $med -> strength_id ) -> title;
                                                    else
                                                        $strength = '';
                                                    if ( $med -> form_id > 1 )
                                                        $form = get_form ( $med -> form_id ) -> title;
                                                    else
                                                        $form = '';
                                                    echo $med -> name . ' ' . $strength . ' ' . $form . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( !empty( trim ( $sale_info -> customer_name ) ) )
                                                echo $sale_info -> customer_name;
                                            else
                                                echo $patient -> title
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
                                    <td>
                                        <?php
                                            if ( count ( $quantities ) > 0 ) {
                                                foreach ( $quantities as $quantity ) {
                                                    echo $quantity . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $prices ) > 0 ) {
                                                foreach ( $prices as $price ) {
                                                    echo $price . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $discount ?></td>
                                    <td><?php echo $flat_discount ?></td>
                                    <td>
                                        <?php
                                            if ( $sale_info -> refunded == '1' ) {
                                                echo $sale_info -> total;
                                            }
                                            else {
                                                if ( $discount > 0 ) { ?>
                                                    <p style="text-decoration: line-through;">
                                                        <?php echo round ( $sale -> net_price, 2 ) ?>
                                                    </p>
                                                    <?php echo round ( $total, 2 ) ?>
                                                    <?php
                                                }
                                                else if ( $flat_discount > 0 ) { ?>
                                                    <p style="text-decoration: line-through;">
                                                        <?php echo round ( $sale -> net_price, 2 ) ?>
                                                    </p>
                                                    <?php
                                                    echo round ( $sale -> net_price - $flat_discount, 2 );
                                                }
                                                else {
                                                    echo round ( $sale -> net_price, 2 );
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo date_setter ( $sale -> date_sold ) ?>
                                    </td>
                                    <td class="btn-group-xs">
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print_medicine_sale_invoice', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn purple"
                                               href="<?php echo base_url ( '/invoices/sale-invoice/' . $sale -> sale_id ) ?>"
                                               target="_blank">
                                                Print
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_medicine_sale_invoice', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) && $sale_info -> refunded == '0' ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/medicines/edit-sale?sale_id=' . $sale -> sale_id ) ?>">
                                                Edit
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_medicine_sale_invoice', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) && $sale_info -> refunded == '0' ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/medicines/delete-entire-sale/' . $sale -> sale_id ) ?>"
                                               onclick="return confirm('Are you sure you want to delete?')">
                                                Delete
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'refund_medicine_sale_invoice', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) && $sale_info -> refunded == '0' ) : ?>
                                            <a type="button" class="btn dark btn-block"
                                               href="<?php echo base_url ( '/medicines/refund/' . $sale -> sale_id ) ?>"
                                               onclick="return confirm('Are you sure you want to refund?')">
                                                Refund
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
            <div id="pagination">
                <ul class="tsc_pagination">
                    <!-- Show pagination links -->
                    <?php foreach ( $links as $link ) {
                        echo "<li>" . $link . "</li>";
                    } ?>
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