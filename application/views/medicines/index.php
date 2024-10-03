<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        
        <div class="search">
            <form method="get">
                <div class="form-group col-md-4">
                    <label>Name</label>
                    <input type="text" name="medicine_name" class="form-control" placeholder="Medicine name"
                           value="<?php echo @$_REQUEST[ 'medicine_name' ] ?>" autofocus="autofocus">
                </div>
                <div class="form-group col-md-3">
                    <label>Generic</label>
                    <select name="generic" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $generics ) > 0 ) {
                                foreach ( $generics as $genericInfo ) {
                                    ?>
                                    <option value="<?php echo $genericInfo -> id ?>" <?php if ( $genericInfo -> id == @$_REQUEST[ 'generic' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $genericInfo -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Form</label>
                    <select name="form" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $forms ) > 0 ) {
                                foreach ( $forms as $formInfo ) {
                                    ?>
                                    <option value="<?php echo $formInfo -> id ?>" <?php if ( $formInfo -> id == @$_REQUEST[ 'form' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $formInfo -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top: 25px">Search</button>
                </div>
            </form>
        </div>
        
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
                    <i class="fa fa-globe"></i> Medicines List
                </div>
                <?php if ( count ( $medicines ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/medicines' ); ?>" class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Name</th>
                        <th> Generic</th>
                        <th> Form</th>
                        <th> Strength</th>
                        <th> Type</th>
                        <th> TP/Unit</th>
                        <th> SP/Unit</th>
                        <th> Total Qty.</th>
                        <th> Sold Qty.</th>
                        <th> Returned Customer.</th>
                        <th> Returned Supplier.</th>
                        <th> Internally Issued Qty.</th>
                        <th> IPD Issued Qty.</th>
                        <th> Adjustment Qty.</th>
                        <th> Expired Qty.</th>
                        <th> Available Qty.</th>
                        <th> Status</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1 + ( isset( $_REQUEST[ 'per_page' ] ) ? $_REQUEST[ 'per_page' ] : 0 );
                        if ( count ( $medicines ) > 0 ) {
                            foreach ( $medicines as $medicine ) {
                                $generic = get_generic ( $medicine -> generic_id );
                                $form = get_form ( $medicine -> form_id );
                                $strength = get_strength ( $medicine -> strength_id );
                                $returned = get_medicine_returned_quantity ( $medicine -> id );
                                $stock = get_latest_medicine_stock ( $medicine -> id );
                                $quantity = get_stock_quantity ( $medicine -> id );
                                $sold = get_sold_quantity ( $medicine -> id );
                                $return_supplier = get_returned_medicines_quantity_by_supplier ( $medicine -> id );
                                $issued = get_issued_quantity ( $medicine -> id );
                                $ipd_issuance = get_ipd_issued_medicine_quantity ( $medicine -> id );
                                $adjustment_qty = get_total_adjustments_by_medicine_id ( $medicine -> id );
                                $expired = get_expired_quantity_medicine_id ( $medicine -> id );
                                $available = get_medicines_available_quantity_by_medicine_id ( $medicine -> id );

//                                print_data ('Quantity: ' . $quantity);
//                                print_data ('Sold: ' . $sold);
//                                print_data ('Return Supplier: ' . $return_supplier);
//                                print_data ('Issued: ' . $issued);
//                                print_data ('IPD Issuance: ' . $ipd_issuance);
//                                print_data ('Adjust Qty: ' . $adjustment_qty);
//                                print_data ('Expired: ' . $expired);
                                
                                if ( $expired <= $available )
                                    $available = $available - $expired;
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $medicine -> name ?></td>
                                    <td><?php if ( $medicine -> generic_id > 1 )
                                            echo $generic -> title ?></td>
                                    <td><?php if ( $medicine -> form_id > 1 )
                                            echo $form -> title ?></td>
                                    <td><?php if ( $medicine -> strength_id > 1 )
                                            echo $strength -> title ?></td>
                                    <td><?php echo ucfirst ( $medicine -> type ) ?></td>
                                    <td><?php echo @$medicine -> tp_unit ?></td>
                                    <td><?php echo @$medicine -> sale_unit ?></td>
                                    <td><?php echo $quantity > 0 ? $quantity : 0 ?></td>
                                    <td><?php echo $sold > 0 ? $sold : 0 ?></td>
                                    <td><?php echo $returned > 0 ? $returned : 0 ?></td>
                                    <td><?php echo $return_supplier > 0 ? $return_supplier : 0 ?></td>
                                    <td><?php echo $issued > 0 ? $issued : 0 ?></td>
                                    <td><?php echo $ipd_issuance > 0 ? $ipd_issuance : 0 ?></td>
                                    <td><?php echo $adjustment_qty > 0 ? $adjustment_qty : 0 ?></td>
                                    <td><?php echo $expired ?></td>
                                    <td>
                                        <?php echo $available ?>
                                    </td>
                                    <td>
                                        <?php echo ( $medicine -> status == '1' ) ? 'Active' : 'Inactive' ?>
                                    </td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'medicine_stock', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn green"
                                               href="<?php echo base_url ( '/medicines/stock/' . $medicine -> id ) ?>">Stock</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_medicine', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/medicines/edit/' . $medicine -> id ) ?>">Edit</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'inactive_medicine', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <?php if ( $medicine -> status == '1' ) : ?>
                                                <a type="button" class="btn red"
                                                   href="<?php echo base_url ( '/medicines/delete/' . $medicine -> id ) ?>"
                                                   onclick="return confirm('Are you sure you want to inactive?')">Inactive</a>
                                            <?php else : ?>
                                                <a type="button" class="btn purple"
                                                   href="<?php echo base_url ( '/medicines/reactivate/' . $medicine -> id ) ?>"
                                                   onclick="return confirm('Are you sure you want to active?')">Active</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_medicine', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) && ( $quantity == $available ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/medicines/delete_medicine/' . $medicine -> id ) ?>"
                                               onclick="return confirm('Are you sure? Deleting medicine will delete all its stocks and reverts the supplier ledger. Action will be permanent and id irreversible.')">Delete</a>
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
    
    .portlet.box > .portlet-body {
        background-color: #fff;
        padding: 10px;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>