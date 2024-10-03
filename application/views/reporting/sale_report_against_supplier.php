<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-3 col-lg-offset-2">
                    <label for="exampleInputEmail1">Supplier</label>
                    <select name="acc_head_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $suppliers ) > 0 ) {
                                foreach ( $suppliers as $suppliers ) {
                                    ?>
                                    <option value="<?php echo $suppliers -> id ?>" <?php echo @$_REQUEST[ 'acc_head_id' ] == $suppliers -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $suppliers -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
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
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-block btn-primary" style="margin-top: 25px;">Search</button>
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
                    <a href="<?php echo base_url ( '/invoices/sale-report-against-supplier?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
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
                        <th> Sold By</th>
                        <th> Medicine</th>
                        <th> Batch</th>
                        <th> Account Head</th>
                        <th> Sold Qty</th>
                        <th> Price</th>
                        <th> Net Price</th>
                        <th> Discount(%)</th>
                        <th> Flat Disc.</th>
                        <th> Total</th>
                        <th> Date Sold</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $reports ) > 0 ) {
                            $count         = 1;
                            $total         = 0;
                            $net           = 0;
                            $flat_discount = 0;
                            $net_quantity  = 0;
                            foreach ( $reports as $report ) {
                                $medicine      = explode ( ',', $report -> medicine_id );
                                $stock         = explode ( ',', $report -> stock_id );
                                $quantities    = explode ( ',', $report -> quantity );
                                $prices        = explode ( ',', $report -> price );
                                $acc_head      = get_account_head ( $report -> patient_id );
                                $total         = $total + $report -> net_price;
                                $sale          = get_sale ( $report -> sale_id );
                                $net           = $net + $sale -> total;
                                $flat_discount = $flat_discount + $sale -> flat_discount;
                                $user          = get_user ( $report -> user_id );
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $report -> sale_id; ?></td>
                                    <td><?php echo $user -> name; ?></td>
                                    <td>
                                        <?php
                                            foreach ( $medicine as $id ) {
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
                                    <td><?php echo $acc_head -> title; ?></td>
                                    <td>
                                        <?php
                                            foreach ( $quantities as $quantity ) {
                                                echo $quantity . '<br>';
                                                $net_quantity = $net_quantity + $quantity;
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
                                    <td><?php echo date_setter ( $report -> date_sold ); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="6" class="text-left"></td>
                                <td class="text-left"><?php echo $net_quantity ?></td>
                                <td class="text-right">
                                    <strong>Total:</strong>
                                </td>
                                <td class="text-left">
                                    <?php echo number_format ( $total, 2 ) ?>
                                </td>
                                <td class="text-right"></td>
                                <td>
                                    <?php echo number_format ( $flat_discount, 2 ) ?>
                                </td>
                                <td class="text-left">
                                    <?php echo number_format ( $net, 2 ) ?>
                                </td>
                                <td></td>
                            </tr>
                            <?php
                        }
                        else {
                            ?>
                            <tr>
                                <td colspan="13">
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
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>