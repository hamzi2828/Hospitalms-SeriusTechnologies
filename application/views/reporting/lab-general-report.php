<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></label>
                    <input type="text" name="sale_id" class="form-control"
                           value="<?php echo @$_REQUEST[ 'sale_id' ]; ?>">
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Test</label>
                    <select name="test_id" class="form-control select2me">
                        <option value="">Select Test</option>
                        <?php
                            if ( count ( $tests ) > 0 ) {
                                foreach ( $tests as $test ) {
                                    ?>
                                    <option value="<?php echo $test -> id ?>" <?php if ( $test -> id == $_REQUEST[ 'test_id' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $test -> name ?>
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
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Time</label>
                    <select class="form-control" name="start_time">
                        <option value="">Select</option>
                        <?php
                            $times = create_time_range ( '01:00', '23:00', '60 mins', '24' );
                            foreach ( $times as $time ) :
                                ?>
                                <option value="<?php echo $time ?>" <?php if ( $time == @$_REQUEST[ 'start_time' ] )
                                    echo 'selected="selected"' ?>><?php echo $time ?></option>
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
                                <option value="<?php echo $time ?>" <?php if ( $time == @$_REQUEST[ 'end_time' ] )
                                    echo 'selected="selected"' ?>><?php echo $time ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Panel</label>
                    <select class="form-control select2me" name="panel-id">
                        <option value="">Select</option>
                        <option value="cash" <?php if ( @$_REQUEST[ 'panel-id' ] == 'cash' )
                            echo 'selected="selected"' ?>>Cash
                        </option>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    ?>
                                    <option value="<?php echo $panel -> id ?>" <?php if ( $panel -> id == @$_REQUEST[ 'panel-id' ] )
                                        echo 'selected="selected"' ?>><?php echo $panel -> name ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Reference</label>
                    <select name="reference-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $references ) > 0 ) {
                                foreach ( $references as $reference ) {
                                    ?>
                                    <option value="<?php echo $reference -> id ?>" <?php echo @$_REQUEST[ 'reference-id' ] == $reference -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $reference -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">User</label>
                    <select name="user-id" class="form-control select2me">
                        <?php
                            if ( count ( $users ) > 0 ) {
                                echo '<option value="">Select</option>';
                                foreach ( $users as $user ) {
                                    ?>
                                    <option value="<?php echo $user -> id ?>" <?php echo @$_REQUEST[ 'user-id' ] == $user -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $user -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                            else {
                                ?>
                                <option value="<?php echo $user -> id ?>" selected="selected">
                                    <?php echo $user -> name ?>
                                </option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Doctor</label>
                    <select class="form-control select2me" name="doctor-id">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $doctors ) > 0 ) {
                                foreach ( $doctors as $doctor ) {
                                    ?>
                                    <option value="<?php echo $doctor -> id ?>" <?php if ( $doctor -> id == @$_REQUEST[ 'doctor-id' ] )
                                        echo 'selected="selected"' ?>><?php echo $doctor -> name ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2" style="padding-top: 23px;">
                    <input type="checkbox" name="exclude-cash"
                           value="yes" <?php if ( isset( $_GET[ 'exclude-cash' ] ) and $_GET[ 'exclude-cash' ] == 'yes' )
                        echo 'checked="checked"' ?>>
                    <label for="exampleInputEmail1">Exclude Cash</label>
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
                    <a href="<?php echo base_url ( '/invoices/lab-general-invoice?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       class="pull-right print-btn" target="_blank">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                        <th> Test</th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                        <th> Patient Type</th>
                        <th> Doctor(s)</th>
                        <th> Price</th>
                        <th> Discount(%)</th>
                        <th> Discount(Flat)</th>
                        <th> Paid Amount</th>
                        <th> Net Amount</th>
                        <th> Doctor's Share (%)</th>
                        <th> Doctor's Share Value</th>
                        <th> Remarks</th>
                        <th> Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter             = 1;
                        $total               = 0;
                        $p_total             = 0;
                        $total_flat_discount = 0;
                        $totalPaidAmount     = 0;
                        $doctorShareNet      = 0;
                        if ( count ( $reports ) > 0 ) {
                            foreach ( $reports as $report ) {
                                $patient   = get_patient ( $report -> patient_id );
                                $sale      = get_lab_sale ( $report -> sale_id );
                                $tests     = explode ( ',', $report -> tests );
                                $receiving = get_lab_sale_receiving ( $report -> sale_id );
                                $saleInfo  = get_lab_sale ( $report -> sale_id );
                                
                                if ( $report -> refunded !== '1' )
                                    $p_total = $p_total + $report -> price;
                                
                                $netReceiving = 0;
                                if ( count ( $receiving ) > 0 ) {
                                    foreach ( $receiving as $received ) {
                                        $netReceiving += $received -> amount;
                                    }
                                }
                                
                                if ( $report -> refunded != '1' )
                                    $total_flat_discount = $total_flat_discount + $sale -> flat_discount;
                                
                                $netPrice = $report -> price;
                                
                                if ( $sale -> discount > 0 )
                                    $netPrice = $netPrice - ( $netPrice * ( $sale -> discount / 100 ) );
                                if ( $sale -> flat_discount > 0 )
                                    $netPrice = $netPrice - $sale -> flat_discount;
                                $netPrice     = $netPrice - $sale -> paid_amount;
                                $saleTotal    = get_lab_sales_total ( $report -> sale_id );
                                $doctor_share = $saleInfo -> doctor_share;
                                
                                if ( $report -> refunded !== '1' ) {
                                    $totalPaidAmount = $totalPaidAmount + $sale -> paid_amount;
                                    $total           = $total + $saleInfo -> total;
                                    $doctorShareNet  += ( $saleInfo -> net * ( $saleInfo -> doctor_share / 100 ) );
                                }
                                
                                $totalPaidAmount = $totalPaidAmount - $netReceiving;
                                ?>
                                <tr>
                                    <td> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $report -> sale_id ?> </td>
                                    <td>
                                        <?php
                                            if ( count ( $tests ) > 0 ) {
                                                foreach ( $tests as $test ) {
                                                    if ( !check_if_test_is_child ( $test ) )
                                                        echo get_test_by_id ( $test ) -> name . '<br>';
                                                }
                                            } ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo get_patient_name ( 0, $patient );
                                            if ( $report -> refunded == '1' ) {
                                                echo '<span class="badge badge-danger">Refunded</span>';
                                            }
                                        ?>
                                    </td>
                                    <td> <?php echo $patient -> panel_id > 0 ? get_panel_by_id ( $patient -> panel_id ) -> name : 'Cash' ?> </td>
                                    <td>
                                        <?php
                                            if ( $saleInfo -> doctor_id > 0 )
                                                echo get_doctor ( $saleInfo -> doctor_id ) -> name . '<br>';
                                            else
                                                echo '-';
                                        ?>
                                    </td>
                                    <td><?php echo number_format ( $saleInfo -> net, 2 ) ?></td>
                                    <td> <?php echo $sale -> discount ?> </td>
                                    <td>
                                        <?php
                                            if ( $report -> refunded == '1' and !empty( trim ( $report -> remarks ) ) )
                                                echo '-' . $sale -> flat_discount;
                                            else
                                                echo $sale -> flat_discount;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( $report -> refunded == '1' and !empty( trim ( $report -> remarks ) ) )
                                                echo '-' . ( $sale -> paid_amount - $netReceiving );
                                            else
                                                echo ( $sale -> paid_amount - $netReceiving );
                                            
                                            if ( count ( $receiving ) > 0 ) {
                                                echo '<br/>';
                                                foreach ( $receiving as $received ) {
                                                    $receivedBy = get_user ( $received -> user_id );
                                                    echo '<small>' . number_format ( $received -> amount, 2 ) . ' received by ' . $receivedBy -> name . '</small> <br/>';
                                                }
                                            }
                                        
                                        ?>
                                    </td>
                                    <td><?php echo number_format ( $saleInfo -> total, 2 ) ?></td>
                                    <td>
                                        <?php
                                            if ( $doctor_share > 0 ) {
                                                echo $saleInfo -> doctor_share . '%';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( $doctor_share > 0 ) {
                                                echo ( $saleInfo -> net * ( $saleInfo -> doctor_share / 100 ) );
                                            }
                                        ?>
                                    </td>
                                    <td> <?php echo $report -> remarks ?> </td>
                                    <td> <?php echo date_setter ( $report -> date_added ) ?> </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="6" class="text-right"></td>
                                <td>
                                    <b><?php echo number_format ( $p_total, 2 ) ?></b>
                                </td>
                                <td class="text-right"></td>
                                <td>
                                    <b><?php echo number_format ( $total_flat_discount, 2 ) ?></b>
                                </td>
                                <td>
                                    <b><?php echo number_format ( $totalPaidAmount, 2 ) ?></b>
                                </td>
                                <td>
                                    <b><?php echo number_format ( $total, 2 ) ?></b>
                                </td>
                                <td></td>
                                <td>
                                    <b><?php echo number_format ( $doctorShareNet, 2 ) ?></b>
                                </td>
                                <td colspan="2"></td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
                <br />
                <?php require_once 'lab-receiving.php'; ?>
                <br>
                <table class="table">
                    <tbody>
                    <tr>
                        <td colspan="5" align="right">
                            <h3>
                                <strong>G. Total: </strong>
                                <?php echo number_format ( ( $totalPaidAmount + $totalReceivedAmount ), 2 ) ?>
                            </h3>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
