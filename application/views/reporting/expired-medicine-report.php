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
                    <i class="fa fa-globe"></i> Expired Medicine List
                </div>
                <?php if ( count ( $medicines ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/expired-medicine-report' ); ?>" target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-bordered">
                    <tbody>
                    <?php
                        if ( count ( $medicines ) > 0 ) {
                            foreach ( $medicines as $medicine ) {
                                $stocks = get_expired_medicine_stocks ( $medicine -> id );
                                
                                if ( count ( $stocks ) > 0 ) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td class="text-center">
                                            <h5 class="text-center">
                                                <strong><?php echo $medicine -> name . '(' . get_strength ( $medicine -> strength_id ) -> title . ')' ?></strong>
                                            </h5>
                                        </td>
                                    </tr>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th> Sr. No</th>
                                            <th> Medicine</th>
                                            <th> Supplier</th>
                                            <th> Batch No.</th>
                                            <th> Expiry Date</th>
                                            <th> Invoice#</th>
                                            <th> Quantity</th>
                                            <th> Cost</th>
                                            <th> Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $counter = 1;
                                            if ( count ( $stocks ) > 0 ) {
                                                foreach ( $stocks as $stock ) {
                                                    $medicine          = get_medicine ( $stock -> medicine_id );
                                                    $strength          = get_strength ( $medicine -> strength_id );
                                                    $form              = get_form ( $medicine -> form_id );
                                                    $supplier          = get_supplier ( $stock -> supplier_id );
                                                    $sold              = get_sold_quantity_by_stock ( $stock -> medicine_id, $stock -> id );
                                                    $returned          = get_medicine_returned_quantity ( $medicine -> id );
                                                    $sold              = get_sold_quantity_by_stock ( $stock -> medicine_id, $stock -> id );
                                                    $supplier_returned = get_stock_returned_quantity ( $stock -> id );
                                                    $returned_customer = get_stock_returned_quantity_by_customer ( $stock -> medicine_id, $stock -> id );
                                                    $issued            = check_stock_issued_quantity ( $stock -> id );
                                                    $ipd_med           = get_ipd_medication_assigned_count_by_stock ( $stock -> id );
                                                    $adjustment_qty    = count_medicine_adjustment_by_medicine_id ( $stock -> medicine_id, $stock -> id );
                                                    $available         = $stock -> quantity - $sold - $ipd_med - $issued - $supplier_returned - $adjustment_qty;
                                                    $cost              = $stock -> tp_unit * $available;
                                                    $isDiscarded       = check_if_medicine_discarded ( $stock -> medicine_id, $stock -> id, $stock -> batch );
                                                    $expired           = get_expired_quantity_medicine_id ( $stock -> medicine_id );
                                                    if ( $expired > 0 and !$isDiscarded ) {
                                                        ?>
                                                        <tr class="odd gradeX" <?php if ( $stock -> expiry_date < date ( 'Y-m-d' ) )
                                                            echo 'style="background: rgba(255,0,0, 0.5)"' ?>>
                                                            <td> <?php echo $counter ++ ?> </td>
                                                            <td><?php echo $medicine -> name . ' ' . $strength -> title . '(' . $form -> title . ')' ?></td>
                                                            <td><?php echo $supplier -> title ?></td>
                                                            <td><?php echo $stock -> batch ?></td>
                                                            <td><?php echo date ( 'm/d/Y', strtotime ( $stock -> expiry_date ) ) ?></td>
                                                            <td><?php echo $stock -> supplier_invoice ?></td>
                                                            <td><?php echo $expired ?></td>
                                                            <td><?php echo number_format ( $cost, 2 ) ?></td>
                                                            <td>
                                                                <a href="<?php echo base_url ( '/medicines/discard-expired-medicine/?medicine-id=' . $stock -> medicine_id . '&stock-id=' . $stock -> id . '&batch=' . $stock -> batch . '&quantity=' . $expired . '&net-cost=' . $cost ) ?>"
                                                                   class="btn btn-xs red"
                                                                   onclick="return confirm('Are you sure?')">Discard</a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php
                                }
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
