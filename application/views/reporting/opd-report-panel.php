<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Services</label>
                    <select name="service_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $services ) > 0 ) {
                                foreach ( $services as $service ) {
                                    ?>
                                    <option
                                            value="<?php echo $service -> id ?>" <?php echo @$_REQUEST[ 'service_id' ] == $service -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $service -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Panel</label>
                    <select name="panel_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    ?>
                                    <option
                                            value="<?php echo $panel -> id ?>" <?php echo @$_REQUEST[ 'panel_id' ] == $panel -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $panel -> name ?>
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
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Time</label>
                    <select class="form-control select2me" name="start_time">
                        <option value="">Select</option>
                        <?php
                            $times = create_time_range ( '01:00', '23:00', '60 mins', '24' );
                            foreach ( $times as $time ) :
                                ?>
                                <option
                                        value="<?php echo $time ?>" <?php if ( $time == @$_REQUEST[ 'start_time' ] ) echo 'selected="selected"' ?>><?php echo $time ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">End Time</label>
                    <select class="form-control select2me" name="end_time">
                        <option value="">Select</option>
                        <?php
                            $times = create_time_range ( '01:00', '23:00', '60 mins', '24' );
                            foreach ( $times as $time ) :
                                ?>
                                <option
                                        value="<?php echo $time ?>" <?php if ( $time == @$_REQUEST[ 'end_time' ] ) echo 'selected="selected"' ?>><?php echo $time ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="doctor-id">Doctor</label>
                    <select name="doctor-id" class="form-control select2me" id="doctor-id">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $doctors ) > 0 ) {
                                foreach ( $doctors as $doctor ) {
                                    ?>
                                    <option value="<?php echo $doctor -> id ?>"
                                        <?php echo $this -> input -> get ( 'doctor-id' ) == $doctor -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $doctor -> name ?>
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
                    <i class="fa fa-reorder"></i> General Report (Panel)
                </div>
                <?php if ( count ( $sales ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/opd-general-report-panel?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                        <th> Doctor(s)</th>
                        <th> Service(s)</th>
                        <th> Panel Code</th>
                        <th> Panel Name</th>
                        <th> Actual Charges</th>
                        <th> Price</th>
                        <th> Total</th>
                        <th> Discount (%)</th>
                        <th> Discount (Flat)</th>
                        <th> Net Price</th>
                        <th> Doctor's Share (%)</th>
                        <th> Doctor's Share (Value)</th>
                        <th> Refunded</th>
                        <th> Refund Reason</th>
                        <th> Date Added</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter        = 1;
                        $total          = 0;
                        $net            = 0;
                        $doctorNetShare = 0;
                        if ( count ( $sales ) > 0 ) {
                            foreach ( $sales as $sale ) {
                                $patient   = get_patient ( $sale -> patient_id );
                                $sale_info = get_opd_sale ( $sale -> sale_id );
                                $panel     = get_panel_by_id ( $patient -> panel_id );
                                
                                if ( $sale_info -> refund !== '1' ) {
                                    $total          = $total + $sale_info -> net;
                                    $net            += $sale -> net_price;
                                    $doctorNetShare += ( $sale_info -> net * ( $sale_info -> doctor_share / 100 ) );
                                }
                                
                                $refunded = $sale_info -> refund == '1' ? 'Yes' : 'No';
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $sale -> sale_id ?></td>
                                    <td>
                                        <?php echo get_patient_name ( 0, $patient ) ?>
                                        <?php
                                            if ( $sale_info -> refund == '1' ) {
                                                echo '<span class="badge badge-danger">Refunded</span>';
                                            }
                                        ?>
                                    
                                    <td>
                                        <?php
                                            if ( $sale_info -> doctor_id > 0 )
                                                echo get_doctor ( $sale_info -> doctor_id ) -> name . '<br>';
                                            else
                                                echo '-';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $services = explode ( ',', $sale -> services );
                                            if ( count ( $services ) > 0 ) {
                                                foreach ( $services as $service ) {
                                                    echo get_service_by_id ( $service ) -> title . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $panel -> code ?></td>
                                    <td><?php echo $panel -> name ?></td>
                                    <td>
                                        <?php
                                            $services = explode ( ',', $sale -> services );
                                            if ( count ( $services ) > 0 ) {
                                                foreach ( $services as $service ) {
                                                    echo get_service_by_id ( $service ) -> price . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $prices = explode ( ',', $sale -> prices );
                                            if ( count ( $prices ) > 0 ) {
                                                foreach ( $prices as $price ) {
                                                    echo $price . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $sale -> net_price ?></td>
                                    <td><?php echo $sale_info -> discount ?></td>
                                    <td><?php echo $sale_info -> flat_discount ?></td>
                                    <td><?php echo $sale_info -> net ?></td>
                                    <td>
                                        <?php
                                            $doctor_share = $sale_info -> doctor_share;
                                            if ( $doctor_share > 0 )
                                                echo $sale_info -> doctor_share . '%';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $doctor_share = $sale_info -> doctor_share;
                                            if ( $doctor_share > 0 )
                                                echo ( $sale_info -> net * ( $sale_info -> doctor_share / 100 ) );
                                        ?>
                                    </td>
                                    <td><?php echo $refunded ?></td>
                                    <td><?php echo $sale_info -> refund_reason ?></td>
                                    <td><?php echo date_setter ( $sale -> date_added ) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="9"></td>
                                <td>
                                    <strong><?php echo number_format ( $net, 2 ) ?></strong>
                                </td>
                                <td colspan="2"></td>
                                <td>
                                    <strong><?php echo number_format ( $total, 2 ) ?></strong>
                                </td>
                                <td></td>
                                <td>
                                    <strong><?php echo number_format ( $doctorNetShare, 2 ) ?></strong>
                                </td>
                                <td colspan="3"></td>
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