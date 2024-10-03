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
                    <i class="fa fa-reorder"></i> Summary Report (Sales)
                </div>
                <a href="<?php echo base_url ( '/invoices/general-summary-report?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                   target="_blank"
                   class="pull-right print-btn">Print</a>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Total Consultancy Sale</th>
                        <th> Total OPD Sale</th>
                        <th> Total Pharmacy Sale</th>
                        <th> Total Lab Sale</th>
                        <th> Total IPD Sale</th>
                        <th> Grand Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo number_format ( $consultancy_total -> net, 2 ) ?></td>
                        <td><?php echo number_format ( $opd_total -> net, 2 ) ?></td>
                        <td><?php echo number_format ( $med_total -> net, 2 ) ?></td>
                        <td><?php echo number_format ( $lab_total -> net, 2 ) ?></td>
                        <td><?php echo number_format ( $ipd_total -> net, 2 ) ?></td>
                        <td><?php echo number_format ( $lab_total -> net + $consultancy_total -> net + $opd_total -> net + $med_total -> net + $ipd_total -> net, 2 ) ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>