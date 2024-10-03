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
                    <select class="form-control select2me" name="start_time">
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
                    <select class="form-control select2me" name="end_time">
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
                    <label for="exampleInputEmail1">Member</label>
                    <select class="form-control select2me" name="user_id">
                        <option value="">Select</option>
                        <?php
                            foreach ( $users as $user ) :
                                ?>
                                <option value="<?php echo $user -> id ?>" <?php if ( $user -> id == @$_REQUEST[ 'user_id' ] ) echo 'selected="selected"' ?>> <?php echo $user -> name ?> </option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn-block btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Summary Report (Cash)
                </div>
                <a href="<?php echo base_url ( '/invoices/general-summary-report-cash?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                   target="_blank"
                   class="pull-right print-btn">Print</a>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>1</th>
                        <th width="33%">Consultancy Cash</th>
                        <th width="33%">Consultancy Refund</th>
                        <th width="33%">Net Cash</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td><?php echo number_format ( ( $consultancies + abs ( $consultancies_refunded ) ), 2 ) ?></td>
                        <td><?php echo number_format ( abs ( $consultancies_refunded ), 2 ) ?></td>
                        <td>
                            <strong>
                                <?php echo number_format ( $consultancies, 2 ); ?>
                            </strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
                
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>2</th>
                        <th width="33%">OPD Cash</th>
                        <th width="33%">OPD Refund</th>
                        <th width="33%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td><?php echo number_format ( ( $opd + abs ( $opd_refunded ) ), 2 ) ?></td>
                        <td><?php echo number_format ( abs ( $opd_refunded ), 2 ) ?></td>
                        <td>
                            <strong>
                                <?php echo number_format ( $opd, 2 ); ?>
                            </strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
                
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>3</th>
                        <th width="33%">Lab Cash</th>
                        <th width="33%">Lab Refund</th>
                        <th width="33%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td><?php echo number_format ( $lab, 2 ) ?></td>
                        <td><?php echo number_format ( abs ( $lab_refunded ), 2 ) ?></td>
                        <td>
                            <strong>
                                <?php
                                    $lab_net = $lab - abs ( $lab_refunded );
                                    echo number_format ( $lab_net, 2 );
                                ?>
                            </strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
                
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>4</th>
                        <th width="33%">Pharmacy Cash</th>
                        <th width="33%">Pharmacy Refund</th>
                        <th width="33%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td><?php echo number_format ( $pharmacy, 2 ) ?></td>
                        <td><?php echo number_format ( abs ( $pharmacy_refunded ), 2 ) ?></td>
                        <td>
                            <strong>
                                <?php
                                    $pharmacy_net = $pharmacy - abs ( $pharmacy_refunded );
                                    echo number_format ( $pharmacy_net, 2 );
                                ?>
                            </strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
                
                <table class="table table-striped table-bordered table-hover" style="margin-bottom: 25px">
                    <thead>
                    <tr>
                        <th>5</th>
                        <th width="66%">IPD Cash (Paid by Cash Patient)</th>
                        <th width="33%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td><?php echo number_format ( $ipd_total, 2 ) ?></td>
                        <td>
                            <strong><?php echo number_format ( $ipd_total, 2 ) ?></strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
                
                <?php
                    $row         = 6;
                    $grand_total = ( $consultancies + $opd + $lab + $pharmacy + $ipd_total );
                    if ( count ( $panels ) > 0 ) {
                        foreach ( $panels as $panel ) {
                            $panel_cash  = get_ipd_cash_by_panel ( $panel -> id );
                            $grand_total += $panel_cash;
                            if ( $panel_cash > 0 ) {
                                ?>
                                <table class="table table-striped table-bordered table-hover"
                                       style="margin-bottom: 25px">
                                    <thead>
                                    <tr>
                                        <th><?php echo $row++ ?></th>
                                        <th width="66%">IPD Cash (Paid By <?php echo $panel -> name ?>)</th>
                                        <th width="33%"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td></td>
                                        <td><?php echo number_format ( $panel_cash, 2 ) ?></td>
                                        <td>
                                            <strong><?php echo number_format ( $panel_cash, 2 ) ?></strong>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?php
                            }
                        }
                    }
                ?>
                
                <table class="table table-striped table-bordered table-hover" style="margin-bottom: 25px">
                    <thead>
                    <tr>
                        <th colspan="3" align="center" style="text-align: center;">
                            <strong>Grand Total</strong>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td width="33%">
                            <strong><?php echo number_format ( $grand_total, 2 ) ?></strong>
                        </td>
                        <td width="33%">
                            <strong>
                                <?php
                                    $totalRefund = abs ( $consultancies_refunded ) + abs ( $opd_refunded ) + abs ( $lab_refunded ) + abs ( $pharmacy_refunded );
                                    echo number_format ( $totalRefund, 2 ) ?>
                            </strong>
                        </td>
                        <td width="33%">
                            <strong>
                                <?php echo number_format ( ( $grand_total - $totalRefund ), 2 ) ?>
                            </strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>