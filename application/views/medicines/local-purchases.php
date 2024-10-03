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
        
        <div class="search">
            <form method="get">
                <div class="col-sm-3">
                    <label>Start Date</label>
                    <input type="text" class="form-control date-picker" value="<?php echo @$_GET[ 'start_date' ] ?>"
                           name="start_date">
                </div>
                <div class="col-sm-3">
                    <label>End Date</label>
                    <input type="text" class="form-control date-picker" value="<?php echo @$_GET[ 'end_date' ] ?>"
                           name="end_date">
                </div>
                <div class="col-sm-4">
                    <label>Medicine</label>
                    <select name="medicine_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $medicines ) > 0 ) {
                                foreach ( $medicines as $medicine ) {
                                    ?>
                                    <option value="<?php echo $medicine -> id ?>">
                                        <?php echo $medicine -> name ?>
                                        <?php if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 ) : ?>
                                            (<?php echo get_form ( $medicine -> form_id ) -> title ?> - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
                                        <?php endif ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button type="submit" style="margin-top: 25px" class="btn btn-primary btn-block">Search</button>
                </div>
            </form>
        </div>
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Local Purchase
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Supplier</th>
                        <th> Medicine</th>
                        <th> Expiry</th>
                        <th> Invoice#</th>
                        <th> Quantity</th>
                        <th> Sold</th>
                        <th> Returned</th>
                        <th> Available</th>
                        <th> TP</th>
                        <th> Value</th>
                        <th> Sale Price</th>
                        <th> Net Price</th>
                        <th> Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1 + ( isset( $_REQUEST[ 'per_page' ] ) ? $_REQUEST[ 'per_page' ] : 0 );
                        if ( count ( $stocks ) > 0 ) {
                            foreach ( $stocks as $key => $stock ) {
                                $stock_ids = explode ( ',', $stock -> ids );
                                $medicines = explode ( ',', $stock -> medicines );
                                $quantities = explode ( ',', $stock -> quantities );
                                $tps = explode ( ',', $stock -> tps );
                                $sales = explode ( ',', $stock -> sales );
                                $prices = explode ( ',', $stock -> prices );
                                $supplier = get_supplier ( $stock -> supplier_id );
                                $date = date ( 'Y-m-d', strtotime ( $stock -> date_added ) );
                                ?>
                                <tr class="odd gradeX <?php if ( $stock -> expiry_date < date ( 'Y-m-d' ) ) echo 'expired' ?>">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $supplier -> title ?></td>
                                    <td>
                                        <?php
                                            if ( count ( $medicines ) > 0 ) {
                                                foreach ( $medicines as $medicine_id ) {
                                                    $medicine = get_medicine ( $medicine_id );
                                                    $strength = get_strength ( $medicine -> strength_id );
                                                    $form = get_form ( $medicine -> form_id );
                                                    echo $medicine -> name . ' ' . $strength -> title . '(' . $form -> title . ')' . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo date_setter ( $stock -> expiry_date ) ?></td>
                                    <td><?php echo $stock -> supplier_invoice ?></td>
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
                                            if ( count ( $medicines ) > 0 ) {
                                                foreach ( $medicines as $key => $medicine_id ) {
                                                    $sold = get_sold_quantity_by_stock ( $medicine_id, $stock_ids[ $key ] );
                                                    echo $sold . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $medicines ) > 0 ) {
                                                foreach ( $medicines as $medicine_id ) {
                                                    $returned = get_stock_returned_quantity ( $medicine_id );
                                                    echo $returned . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $medicines ) > 0 ) {
                                                foreach ( $medicines as $key => $medicine_id ) {
                                                    $sold = get_sold_quantity_by_stock ( $medicine_id, $stock_ids[ $key ] );
                                                    $returned = get_stock_returned_quantity ( $medicine_id );
                                                    $quantity = $quantities[ $key ];
                                                    $available = $quantity - $sold;
                                                    echo $available . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $tps ) > 0 ) {
                                                foreach ( $tps as $tp ) {
                                                    echo $tp . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $medicines ) > 0 ) {
                                                foreach ( $medicines as $key => $medicine_id ) {
                                                    $sold = get_sold_quantity_by_stock ( $medicine_id, $stock_ids[ $key ] );
                                                    $returned = get_stock_returned_quantity ( $medicine_id );
                                                    $quantity = explode ( ',', $stock -> quantities );
                                                    $tps = explode ( ',', $stock -> tps );
                                                    echo number_format ( ( $quantity[ $key ] - $sold ) * $tps[ $key ], 2 ) . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $sales ) > 0 ) {
                                                foreach ( $sales as $sale ) {
                                                    echo $sale . '<br>';
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
                                    <td><?php echo date_setter ( $stock -> date_added ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_local_purchases', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/medicines/edit-local-purchase?supplier_invoice=' . $stock -> supplier_invoice ) ?>">Edit</a>
                                        <?php endif; ?>
                                        <a type="button" class="btn purple"
                                           href="<?php echo base_url ( '/invoices/local-purchase?supplier_invoice=' . $stock -> supplier_invoice ) ?>">Print</a>
                                        <?php /*if(get_user_access(get_logged_in_user_id()) and in_array('delete_local_purchases', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                    <a type="button" class="btn red" href="<?php echo base_url('/medicines/delete_local_purchase/'.$stock -> supplier_invoice) ?>" onclick="return confirm('Are you sure you want to delete this stock?')">Delete</a>
							<?php endif;*/ ?>
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
                </ul>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>