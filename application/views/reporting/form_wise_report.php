<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-3 col-lg-offset-5">
                    <label for="exampleInputEmail1">Forms</label>
                    <select name="form_id" class="form-control select2me">
                        <option value="0">All</option>
                        <?php
                            if ( count ( $all_forms ) > 0 ) {
                                foreach ( $all_forms as $all_form ) {
                                    ?>
                                    <option value="<?php echo $all_form -> id ?>" <?php echo @$_REQUEST[ 'form_id' ] == $all_form -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $all_form -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Form Wise Report
                </div>
                <?php if ( count ( $forms ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/form-wise-report-c' ); ?>" class="pull-right print-btn"
                       target="_blank"
                       style="margin-left: 10px">Print C</a>
                    <a href="<?php echo base_url ( '/invoices/form-wise-report?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Form</th>
                        <th> Medicine</th>
                        <th> Generic</th>
                        <th> Strength</th>
                        <th> Type</th>
                        <th> Total Qty.</th>
                        <th> Sold Qty.</th>
                        <th> Returned Customer.</th>
                        <th> Returned Supplier.</th>
                        <th> Expired Qty.</th>
                        <th> Internally Issued Qty.</th>
                        <th> IPD Issued Qty.</th>
                        <th> Adjustment Qty.</th>
                        <th> Available Qty.</th>
                        <th> Net Value</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $forms ) > 0 ) {
                            $counter = 1;
                            foreach ( $forms as $form ) {
                                $medicines = get_medicines_by_form ( $form -> id );
                                ?>
                                <tr class="odd gradeX <?php if ( count ( $medicines ) > 0 ) echo 'has-medicines' ?>">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $form -> title ?></td>
                                    <td colspan="15"></td>
                                </tr>
                                <?php
                                if ( count ( $medicines ) > 0 ) {
                                    $m_counter = 1;
                                    $total     = 0;
                                    foreach ( $medicines as $medicine ) {
                                        $sold            = get_sold_quantity ( $medicine -> id );
                                        $quantity        = get_stock_quantity ( $medicine -> id );
                                        $expired         = get_stock_expired_quantity ( $medicine -> id );
                                        $generic         = get_generic ( $medicine -> generic_id );
                                        $form            = get_form ( $medicine -> form_id );
                                        $strength        = get_strength ( $medicine -> strength_id );
                                        $returned        = get_medicine_returned_quantity ( $medicine -> id );
                                        $issued          = get_issued_quantity ( $medicine -> id );
                                        $ipd_issuance    = get_ipd_issued_medicine_quantity ( $medicine -> id );
                                        $return_supplier = get_returned_medicines_quantity_by_supplier ( $medicine -> id );
                                        $adjustment_qty  = get_total_adjustments_by_medicine_id ( $medicine -> id );
                                        $available       = $quantity - $sold - $expired - $issued - $ipd_issuance - $return_supplier - $adjustment_qty;
                                        $net_value       = get_all_stock_price_by_medicine_id ( $medicine -> id );
                                        $total           = $total + $net_value;
                                        ?>
                                        <tr class="odd gradeX">
                                            <td></td>
                                            <td> <?php echo $m_counter++ ?> </td>
                                            <td><?php echo $medicine -> name ?></td>
                                            <td><?php echo $generic -> title ?></td>
                                            <td><?php echo $strength -> title ?></td>
                                            <td><?php echo ucfirst ( $medicine -> type ) ?></td>
                                            <td><?php echo $quantity > 0 ? $quantity : 0 ?></td>
                                            <td><?php echo $sold > 0 ? $sold : 0 ?></td>
                                            <td><?php echo $returned > 0 ? $returned : 0 ?></td>
                                            <td><?php echo $return_supplier > 0 ? $return_supplier : 0 ?></td>
                                            <td><?php echo $expired > 0 ? $expired : 0 ?></td>
                                            <td><?php echo $issued > 0 ? $issued : 0 ?></td>
                                            <td><?php echo $ipd_issuance > 0 ? $ipd_issuance : 0 ?></td>
                                            <td><?php echo $adjustment_qty > 0 ? $adjustment_qty : 0 ?></td>
                                            <td><?php echo $available ?></td>
                                            <td><?php echo number_format ( $net_value, 2 ) ?></td>
                                            <td class="btn-group-xs">
                                                <a type="button" class="btn green"
                                                   href="<?php echo base_url ( '/medicines/stock/' . $medicine -> id ) ?>">Stock</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="15" class="text-right">
                                            <strong>Total:</strong>
                                        </td>
                                        <td>
                                            <strong><?php echo number_format ( $total, 2 ) ?></strong>
                                        </td>
                                        <td></td>
                                    </tr>
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
    .has-medicines td {
        background: #bce8f1 !important;
        font-size: 16px;
        font-weight: 800;
    }
</style>