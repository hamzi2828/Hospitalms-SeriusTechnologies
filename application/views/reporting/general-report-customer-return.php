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
                    <label for="exampleInputEmail1">Start Time</label>
                    <select class="form-control" name="start_time">
                        <option value="">Select</option>
                        <?php
                            $times = create_time_range ( '01:00', '23:00', '60 mins', '24' );
                            foreach ( $times as $time ) :
                                ?>
                                <option value="<?php echo $time ?>" <?php if ( $time == @$_REQUEST[ 'start_time' ] ) echo 'selected="selected"' ?>><?php echo $time ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Time</label>
                    <select class="form-control" name="end_time">
                        <option value="">Select</option>
                        <?php
                            $times = create_time_range ( '01:00', '23:00', '60 mins', '24' );
                            foreach ( $times as $time ) :
                                ?>
                                <option value="<?php echo $time ?>" <?php if ( $time == @$_REQUEST[ 'end_time' ] ) echo 'selected="selected"' ?>><?php echo $time ?></option>
                            <?php endforeach; ?>
                    </select>
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
                    <a href="<?php echo base_url ( '/invoices/general-report-customer-return?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Supplier</th>
                        <th> Medicine</th>
                        <th> Invoice</th>
                        <th> Batch</th>
                        <th> Expiry</th>
                        <th> Quantity</th>
                        <th> Paid To Customer</th>
                        <th> Date Returned</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $reports ) > 0 ) {
                            $count = 1;
                            $net   = 0;
                            foreach ( $reports as $report ) {
                                $medicine = get_medicine ( $report -> medicine_id );
                                $supplier = get_account_head ( $report -> supplier_id );
                                $net      = $net + $report -> paid_to_customer;
                                $generic  = get_generic ( $medicine -> generic_id );
                                $form     = get_form ( $medicine -> form_id );
                                $strength = get_strength ( $medicine -> strength_id );
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $supplier -> title; ?></td>
                                    <td>
                                        <?php
                                            echo $medicine -> name;
                                            if ( $medicine -> generic_id > 1 ) echo $generic -> title . ' ';
                                            if ( $medicine -> form_id > 1 ) echo $form -> title . ' ';
                                            if ( $medicine -> strength_id > 1 ) echo $strength -> title . ' ';
                                        ?>
                                    </td>
                                    <td><?php echo $report -> supplier_invoice ?></td>
                                    <td><?php echo $report -> batch ?></td>
                                    <td><?php echo $report -> expiry_date ?></td>
                                    <td><?php echo $report -> quantity ?></td>
                                    <td><?php echo $report -> paid_to_customer ?></td>
                                    <td><?php echo date_setter ( $report -> date_added ); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="6" class="text-right"></td>
                                <td class="text-right">
                                    <strong>Total:</strong>
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
                                <td colspan="9">
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