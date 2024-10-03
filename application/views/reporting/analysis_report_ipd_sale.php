<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Medicine</label>
                    <select name="medicine_id" class="form-control select2me">
                        <option value="0">All</option>
                        <?php
                            if ( count ( $medicines ) > 0 ) {
                                foreach ( $medicines as $medicine ) {
                                    ?>
                                    <option value="<?php echo $medicine -> id ?>" <?php echo @$_REQUEST[ 'medicine_id' ] == $medicine -> id ? 'selected="selected"' : '' ?>>
                                        <?php
                                            if ( $medicine -> strength_id > 1 )
                                                $strength = get_strength ( $medicine -> strength_id ) -> title;
                                            else
                                                $strength = '';
                                            if ( $medicine -> form_id > 1 )
                                                $form = get_form ( $medicine -> form_id ) -> title;
                                            else
                                                $form = '';
                                            echo $medicine -> name . ' ' . $strength . ' ' . $form;
                                        ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-block btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Analysis Report - IPD Sale
                </div>
                <?php if ( count ( $analysis ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/analysis-report-ipd-sale?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                       target="_blank" class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Medicines</th>
                        <th> Supplier(s)</th>
                        <th> Quantity (Cash)</th>
                        <th> Quantity (IPD)</th>
                        <th> Total Amount (Cash)</th>
                        <th> Total Amount (IPD)</th>
                        <th> Net Total Amount</th>
                        <th> Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $analysis ) > 0 ) {
                            $counter         = 1;
                            $total           = 0;
                            $total_quantity  = 0;
                            $array           = array ();
                            $sales_total     = 0;
                            $net_sales_total = 0;
                            $total_sum       = 0;
                            foreach ( $analysis as $sale ) {
                                $cash_net_price = 0;
                                $total          = $total + $sale -> net_price;
                                $suppliers      = get_supplier_by_medicine_id ( $sale -> medicine_id );
                                $cash_quantity  = get_medicine_issued_quantity ( $sale -> medicine_id );
                                $cash_med_price = get_issued_medicine_net_price ( $sale -> medicine_id );
                                $cash_net_price = $cash_net_price + $cash_med_price;
                                $total_sum      = $sale -> net_price + $cash_net_price;
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $counter; ?>
                                    </td>
                                    <td>
                                        <?php
                                            $med = get_medicine ( $sale -> medicine_id );
                                            if ( $med -> strength_id > 1 )
                                                $strength = get_strength ( $med -> strength_id ) -> title;
                                            else
                                                $strength = '';
                                            if ( $med -> form_id > 1 )
                                                $form = get_form ( $med -> form_id ) -> title;
                                            else
                                                $form = '';
                                            echo $med -> name . ' ' . $strength . ' ' . $form;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $suppliers ) > 0 ) {
                                                foreach ( $suppliers as $supplier ) {
                                                    echo get_account_head ( $supplier -> supplier_id ) -> title . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td> <?php echo $cash_quantity ?> </td>
                                    <td> <?php echo $sale -> quantity; ?> </td>
                                    <td> <?php echo number_format ( $cash_net_price, 2 ) ?> </td>
                                    <td> <?php echo number_format ( $sale -> net_price, 2 ) ?> </td>
                                    <td> <?php echo number_format ( $sale -> net_price + $cash_med_price, 2 ) ?> </td>
                                    <td> <?php echo date_setter ( $sale -> date_sold ) ?> </td>
                                </tr>
                                <?php
                                $counter++;
                            }
                            ?>
                            <tr>
                                <td colspan="5">
                                    <strong style="color: #ff0000">The following total is shown excluding the discount,
                                                                   as the discount is on over sale, not single
                                                                   medicine.</strong>
                                </td>
                                <td><strong><?php echo number_format ( $total, 2 ); ?></strong></td>
                                <td><strong><?php echo number_format ( $cash_net_price, 2 ); ?></strong></td>
                                <td><strong><?php echo number_format ( $total_sum, 2 ); ?></strong></td>
                                <td></td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>