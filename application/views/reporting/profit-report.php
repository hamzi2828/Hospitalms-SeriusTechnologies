<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Sale From</label>
                    <input type="text" name="sale_from" class="form-control"
                           value="<?php echo @$_REQUEST[ 'sale_from' ]; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Sale To</label>
                    <input type="text" name="sale_to" class="form-control"
                           value="<?php echo @$_REQUEST[ 'sale_to' ]; ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Medicine</label>
                    <select name="medicine_id" class="form-control select2me">
                        <option value="">Select Medicine</option>
                        <?php
                            if ( count ( $medicines ) > 0 ) {
                                foreach ( $medicines as $medicine ) {
                                    ?>
                                    <option value="<?php echo $medicine -> id ?>" <?php echo @$_REQUEST[ 'medicine_id' ] == $medicine -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $medicine -> name ?>
                                        (<?php echo get_form ( $medicine -> form_id ) -> title ?>
                                        - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
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
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> General Report
                </div>
                <?php if ( count ( $reports ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/profit-report?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                        <th> Medicine</th>
                        <th> Batch</th>
                        <th> Account Head</th>
                        <th> Sold Qty</th>
                        <th> S. Price</th>
                        <th> P. Price</th>
                        <th> Price</th>
                        <th> Net Price</th>
                        <th> Discount(%)</th>
                        <th> Flat Disc.</th>
                        <th> Total</th>
                        <th> Gross Profit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $count         = 1;
                        $total         = 0;
                        $net           = 0;
                        $total_profit  = 0;
                        $flat_discount = 0;
                        if ( count ( $reports ) > 0 ) {
                            foreach ( $reports as $report ) {
                                $medicine      = explode ( ',', $report -> medicine_id );
                                $stock         = explode ( ',', $report -> stock_id );
                                $quantities    = explode ( ',', $report -> quantity );
                                $prices        = explode ( ',', $report -> price );
                                $acc_head      = get_account_head ( $report -> patient_id );
                                $total         = $total + $report -> net_price;
                                $sale          = get_sale ( $report -> sale_id );
                                $net           = $net + $sale -> total;
                                $profit        = 0;
                                $flat_discount = $flat_discount + $sale -> flat_discount;
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $report -> sale_id; ?></td>
                                    <td>
                                        <?php
                                            foreach ( $medicine as $id ) {
                                                $med = get_medicine ( $id );
                                                echo $med -> name . '<br>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            foreach ( $stock as $id ) {
                                                $sto = get_stock ( $id );
                                                echo $sto -> batch . '<br>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( !empty( $acc_head ) )
                                                echo $acc_head -> title;
                                            else
                                                echo get_patient ( $report -> patient_id ) -> name;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            foreach ( $quantities as $quantity ) {
                                                echo $quantity . '<br>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            foreach ( $stock as $key => $id ) {
                                                $sto = get_stock ( $id );
                                                echo $sto -> sale_unit . '<br>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            foreach ( $stock as $id ) {
                                                $sto = get_stock ( $id );
                                                echo $sto -> tp_unit . '<br>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            foreach ( $prices as $price ) {
                                                echo $price . '<br>';
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo number_format ( $report -> net_price, 2 ); ?></td>
                                    <td><?php echo $sale -> discount; ?></td>
                                    <td><?php echo $sale -> flat_discount; ?></td>
                                    <td><?php echo number_format ( $sale -> total, 2 ); ?></td>
                                    <td>
                                        <?php
                                            foreach ( $stock as $key => $id ) {
                                                $sto    = get_stock ( $id );
                                                $profit += ( $prices[ $key ] * $quantities[ $key ] ) - ( $sto -> tp_unit * $quantities[ $key ] );
                                                //$purchase_price = $sto -> tp_unit * $quantities[$key];
                                                //$profit = $sale -> total - $purchase_price;
//                                        if(get_logged_in_user_id() == 1) {
//                                            $purchase_price = $sto -> tp_unit * $quantities[$key];
//                                            $ppp = $sale -> total - $purchase_price;
//                                            print_data('Purchase Price: ' . $purchase_price);
//                                            print_data('Profit: ' . $ppp);
//                                        }
                                            }
                                            $total_profit += $profit;
                                            echo number_format ( $profit, 2 );
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="8" class="text-right"></td>
                                <td class="text-right">
                                    <strong>Total:</strong>
                                </td>
                                <td class="text-left">
                                    <?php echo number_format ( $total, 2 ) ?>
                                </td>
                                <td class="text-left"></td>
                                <td>
                                    <?php echo number_format ( $flat_discount, 2 ) ?>
                                </td>
                                <td class="text-left">
                                    <?php echo number_format ( $net, 2 ) ?>
                                </td>
                                <td><?php echo number_format ( $total_profit, 2 ) ?></td>
                            </tr>
                            <?php
                        }
                        else {
                            ?>
                            <tr>
                                <td colspan="14">
                                    No record found.
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> General Report - Sale Return
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Medicine</th>
                        <th> Batch</th>
                        <th> Return Qty</th>
                        <th> S. Price</th>
                        <th> P. Price</th>
                        <th> Paid To Customer</th>
                        <th> Gross Profit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $sr_no        = 1;
                        $return_gross = 0;
                        if ( count ( $returns ) > 0 ) {
                            foreach ( $returns as $return ) {
                                $medicine      = get_medicine ( $return -> medicine_id );
                                $return_profit = $return -> paid_to_customer - ( $return -> quantity * $return -> tp_unit );
                                $return_gross  = $return_gross + $return_profit;
                                ?>
                                <tr>
                                    <td> <?php echo $sr_no++ ?> </td>
                                    <td> <?php echo $medicine -> name ?> </td>
                                    <td> <?php echo $return -> batch ?> </td>
                                    <td> <?php echo $return -> quantity ?> </td>
                                    <td> <?php echo $return -> sale_unit ?> </td>
                                    <td> <?php echo $return -> tp_unit ?> </td>
                                    <td> <?php echo $return -> paid_to_customer ?> </td>
                                    <td> <?php echo number_format ( $return_profit, 2 ) ?> </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="7"></td>
                                <td> <?php echo number_format ( $return_gross, 2 ) ?> </td>
                            </tr>
                            <?php
                        }
                        else {
                            ?>
                            <tr>
                                <td colspan="8">
                                    No record found.
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
                <h2 class="text-right"> Total
                                        Profit: <?php echo number_format ( $total_profit - $return_gross ); ?> </h2>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>