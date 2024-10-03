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
        <div class="search-form">
            <form method="get" autocomplete="off">
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
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">Medicine Name</label>
                    <input type="text" name="medicine" class="form-control" placeholder="Medicine Name"
                           value="<?php echo @$_REQUEST[ 'medicine' ] ?>">
                </div>
                <div class="col-lg-1" style="padding-top: 25px">
                    <button type="submit" class="btn btn-block btn-primary">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Adjustments List (Decrease)
                </div>
                <?php if ( count ( $sales ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/adjustments?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Adjustment ID#</th>
                        <th> Medicine</th>
                        <th> Batch#</th>
                        <th> Quantity</th>
                        <th> Cost/Unit</th>
                        <th> G.Total</th>
                        <th> Date</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $sales ) > 0 ) {
                            $counter = 1;
                            foreach ( $sales as $sale ) {
                                $medicine_id = explode ( ',', $sale -> medicine_id );
                                $stock_id = explode ( ',', $sale -> stock_id );
                                $quantities = explode ( ',', $sale -> quantity );
                                $prices = explode ( ',', $sale -> price );
                                $sale_info = get_adjustment_by_id ( $sale -> adjustment_id );
                                $total = $sale_info -> total;
                                
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $sale -> adjustment_id ?> </td>
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
                                    <td>
                                        <?php echo round ( $total, 2 ) ?>
                                    </td>
                                    <td>
                                        <?php echo date_setter ( $sale -> date_added ) ?>
                                    </td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_medicine_sale_invoice', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/medicines/edit-adjustment?adjustment_id=' . $sale -> adjustment_id ) ?>">
                                                Edit
                                            </a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_medicine_sale_invoice', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/medicines/delete_entire_adjustment/' . $sale -> adjustment_id ) ?>"
                                               onclick="return confirm('Are you sure you want to delete?')">
                                                Delete
                                            </a>
                                        <?php endif; ?>
                                        <a type="button" class="btn purple"
                                           href="<?php echo base_url ( '/invoices/adjustment-invoice/' . $sale -> adjustment_id ) ?>">
                                            Print </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                </table>
                <div id="pagination">
                    <ul class="tsc_pagination">
                        <!-- Show pagination links -->
                        <?php foreach ( $links as $link ) {
                            echo "<li>" . $link . "</li>";
                        } ?>
                </div>
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