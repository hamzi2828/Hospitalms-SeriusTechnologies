<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green" style="overflow:scroll">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Stocks List
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
                        <th> Medicine</th>
                        <th> Supplier</th>
                        <th> Batch No.</th>
                        <th> Trans. ID</th>
                        <th> Expiry</th>
                        <th> Invoice#</th>
                        <th> Quantity</th>
                        <th> Sold</th>
                        <th> Returned Customer</th>
                        <th> Returned Supplier</th>
                        <th> Internally Issued Qty.</th>
                        <th> IPD Issued Qty.</th>
                        <th> Adjustment Qty.</th>
                        <th> Available</th>
                        <th> TP</th>
                        <th> Value</th>
                        <th> Sale Price</th>
                        <th> Disc.(%)</th>
                        <th> S.Tax</th>
                        <th> Total Stock Value</th>
                        <th> Status</th>
                        <th> Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $availableQty = 0;
                        $counter = 1;
                        if ( count ( $stocks ) > 0 ) {
                            foreach ( $stocks as $stock ) {
                                $medicine = get_medicine ( $stock -> medicine_id );
                                $strength = get_strength ( $medicine -> strength_id );
                                $form = get_form ( $medicine -> form_id );
                                $supplier = get_supplier ( $stock -> supplier_id );
                                $sold = get_sold_quantity_by_stock ( $stock -> medicine_id, $stock -> id );
                                $supplier_returned = get_stock_returned_quantity ( $stock -> id );
                                $returned_customer = get_stock_returned_quantity_by_customer ( $stock -> medicine_id, $stock -> id );
                                $issued = check_stock_issued_quantity ( $stock -> id );
                                $ipd_med = get_ipd_medication_assigned_count_by_stock_and_medicine ( $medicine -> id, $stock -> id );
                                $adjustment_qty = count_medicine_adjustment_by_medicine_id ( $stock -> medicine_id, $stock -> id );
                                $available = $stock -> quantity - $sold - $ipd_med - $issued - $supplier_returned - $adjustment_qty;
                                $availableQty = $availableQty + $available;
                                //                                $expired = get_expired_quantity_medicine_id ( $stock -> id );
                                
                                //                                print_data ( 'Quantity: ' . $stock -> quantity );
                                //                                print_data ('Sold: ' . $sold);
                                //                                print_data ('Return Supplier: ' . $supplier_returned);
                                //                                print_data ('Issued: ' . $issued);
                                //                                print_data ('IPD Issuance: ' . $ipd_med);
                                //                                print_data ('Adjust Qty: ' . $adjustment_qty);
                                //                                print_data ('Expired: ' . $expired);
                                
                                ?>
                                <tr class="odd gradeX <?php if ( $stock -> expiry_date < date ( 'Y-m-d' ) )
                                    echo 'expired' ?> <?php if ( $stock -> quantity < $sold )
                                    echo 'less-quantity' ?>">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $medicine -> name . ' ' . $strength -> title . '(' . $form -> title . ')' ?></td>
                                    <td><?php echo $supplier -> title ?></td>
                                    <td><?php echo $stock -> batch ?></td>
                                    <td><?php echo get_transaction_id_by_stock_id ( $stock -> supplier_invoice ) ?></td>
                                    <td><?php echo date_setter ( $stock -> expiry_date ) ?></td>
                                    <td><?php echo $stock -> supplier_invoice ?></td>
                                    <td><?php echo $stock -> quantity ?></td>
                                    <td><?php echo $sold > 0 ? $sold : 0 ?></td>
                                    <td><?php echo $returned_customer > 0 ? $returned_customer : 0 ?></td>
                                    <td><?php echo $supplier_returned > 0 ? $supplier_returned : 0 ?></td>
                                    <td><?php echo $issued > 0 ? $issued : 0 ?></td>
                                    <td><?php echo $ipd_med > 0 ? $ipd_med : 0 ?></td>
                                    <td><?php echo $adjustment_qty > 0 ? $adjustment_qty : 0 ?></td>
                                    <td><?php echo $available ?></td>
                                    <td><?php echo $stock -> tp_unit ?></td>
                                    <td><?php echo number_format ( ( $available ) * $stock -> tp_unit, 2 ) ?></td>
                                    <td><?php echo $stock -> sale_unit ?></td>
                                    <td><?php echo $stock -> discount ?></td>
                                    <td><?php echo $stock -> sales_tax ?></td>
                                    <td><?php echo $stock -> net_price ?></td>
                                    <td><?php echo ( $stock -> status == '1' ) ? 'Active' : 'Inactive'; ?></td>
                                    <td><?php echo date_setter ( $stock -> date_added ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php /* <a type="button" class="btn blue" href="<?php echo base_url('/medicines/edit-stock/'.$stock -> id) ?>">Edit</a> */ ?>
                                        <a class="btn purple"
                                           href="<?php echo base_url ( '/invoices/stock-invoice/' . $stock -> supplier_invoice ); ?>"
                                           target="_blank">Print</a>
                                        
                                        <?php if ( $stock -> status == '1' ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/medicines/delete-stock/' . $stock -> id ) ?>"
                                               onclick="return confirm('Are you sure you want to inactive this stock?')">Inactive</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( $stock -> status == '0' ) : ?>
                                            <a type="button" class="btn purple"
                                               href="<?php echo base_url ( '/medicines/activate-stock/' . $stock -> id ) ?>">Reactivate</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_medicine_stock', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) && ( $stock -> quantity == $available ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/medicines/delete-stock-permanently/' . $stock -> id ) ?>"
                                               onclick="return confirm('Are you sure you want to delete this stock?')">Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                    <!--                    <tfoot>-->
                    <!--                        <tr>-->
                    <!--                            <td colspan="14"></td>-->
                    <!--                            <td>-->
                    <!--                                <strong>--><?php //echo $availableQty; ?><!--</strong>-->
                    <!--                            </td>-->
                    <!--                            <td colspan="9"></td>-->
                    <!--                        </tr>-->
                    <!--                    </tfoot>-->
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
    
    .expired td {
        background-color: rgba(255, 0, 0, 0.5) !important;
    }
    
    .less-quantity td {
        background-color: rgba(255, 165, 0, 0.5) !important;
    }
    
    .portlet.box > .portlet-body {
        background-color: #fff;
        padding: 10px;
        width: 100%;
        display: block;
        float: left;
        overflow: auto;
    }
</style>
