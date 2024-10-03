<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) : ''; ?>"
                           style="font-size: 10px">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) : ''; ?>"
                           style="font-size: 10px">
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
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Sold By</label>
                    <select name="user_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $users ) > 0 ) {
                                foreach ( $users as $user_info ) {
                                    ?>
                                    <option value="<?php echo $user_info -> id ?>" <?php echo @$_REQUEST[ 'user_id' ] == $user_info -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $user_info -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Type</label>
                    <select name="patient-type" class="form-control select2me">
                        <option value="">All</option>
                        <option value="cash" <?php if ( @$_REQUEST[ 'patient-type' ] == 'cash' ) echo 'selected="selected"' ?>>
                            Cash
                        </option>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    ?>
                                    
                                    <option
                                            value="<?php echo $panel -> id ?>" <?php if ( @$_REQUEST[ 'patient-type' ] == $panel -> id ) echo 'selected="selected"' ?>>
                                        <?php echo $panel -> name ?>
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
                    <i class="fa fa-reorder"></i> General Report IPD Medication
                </div>
                <?php if ( count ( $reports ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/general-report-ipd-medication?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                        <th> Sold By</th>
                        <th> Medicine</th>
                        <th> Batch</th>
                        <th> Sold Qty</th>
                        <th> Price</th>
                        <th> Net Price</th>
                        <th> Date Added</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $reports ) > 0 ) {
                            $count         = 1;
                            $total         = 0;
                            $net           = 0;
                            $flat_discount = 0;
                            foreach ( $reports as $report ) {
                                $medicine   = explode ( ',', $report -> medicine_id );
                                $stock      = explode ( ',', $report -> stock_id );
                                $quantities = explode ( ',', $report -> quantity );
                                $prices     = explode ( ',', $report -> price );
                                $total      = $total + $report -> net_price;
                                $user       = get_user ( $report -> user_id );
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $report -> sale_id; ?></td>
                                    <td><?php echo $report -> patient_id; ?></td>
                                    <td><?php echo get_patient ( $report -> patient_id ) -> name; ?></td>
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
                                    <td>
                                        <?php
                                            foreach ( $quantities as $quantity ) {
                                                echo $quantity . '<br>';
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
                                    <td><?php echo date_setter ( $report -> date_added ); ?></td>
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
                                <td class="text-right"></td>
                            </tr>
                            <?php
                        }
                        else {
                            ?>
                            <tr>
                                <td colspan="11">
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