<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start-date" class="form-control date-picker" placeholder="Start date"
                           value="<?php echo ( @$_REQUEST[ 'start-date' ] ) ? @$_REQUEST[ 'start-date' ] : '' ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end-date" class="form-control date-picker" placeholder="End date"
                           value="<?php echo ( @$_REQUEST[ 'end-date' ] ) ? @$_REQUEST[ 'end-date' ] : '' ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Panel</label>
                    <select class="form-control select2me" name="panel-id">
                        <option value="">Select</option>
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
                    <label for="exampleInputEmail1">Location</label>
                    <select class="form-control select2me" name="location-id">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $locations ) > 0 ) {
                                foreach ( $locations as $location ) {
                                    ?>
                                    <option value="<?php echo $location -> id ?>" <?php if ( $location -> id == @$_REQUEST[ 'location-id' ] )
                                        echo 'selected="selected"' ?>><?php echo $location -> name ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Referred By</label>
                    <select class="form-control select2me" name="airline-id">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $airlines ) > 0 ) {
                                foreach ( $airlines as $airline ) {
                                    ?>
                                    <option value="<?php echo $airline -> id ?>" <?php if ( $airline -> id == @$_REQUEST[ 'airline-id' ] )
                                        echo 'selected="selected"' ?>><?php echo $airline -> title ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Referred By Report
                </div>
                <?php if ( count ( $reports ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/referred-by-report?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       class="pull-right print-btn" target="_blank">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                        <th> Name</th>
                        <th> Flight Date/Time</th>
                        <th> Passport No</th>
                        <th> Ticket No</th>
                        <th> PNR</th>
                        <th> Panel</th>
                        <th> Ref By</th>
                        <th> Test</th>
                        <th> Price</th>
                        <th> Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $reports ) > 0 ) {
                            foreach ( $reports as $report ) {
                                $testSale    = get_test_sale ( $report -> lab_sale_id );
                                $patient_id  = get_patient_id_by_sale_id ( $report -> lab_sale_id );
                                $patient     = get_patient ( $patient_id );
                                $panelInfo   = get_panel_by_id ( $patient -> panel_id );
                                $airlineInfo = get_airlines_by_id ( $report -> airline_id );
                                $test_id     = $testSale -> test_id;
                                $test        = get_test_by_id ( $test_id );
                                ?>
                                <tr>
                                    <td> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $report -> lab_sale_id ?> </td>
                                    <td> <?php echo ucwords ( get_patient_name (0, $patient) ) ?> </td>
                                    <td> <?php echo date_setter ( $report -> flight_date ) ?> </td>
                                    <td> <?php echo $patient -> passport ?> </td>
                                    <td> <?php echo $report -> ticket_no ?> </td>
                                    <td> <?php echo $report -> pnr ?> </td>
                                    <td><?php echo $panelInfo -> name ?></td>
                                    <td><?php echo $airlineInfo -> title ?></td>
                                    <td><?php echo $test -> name . '(' . $test -> code . ')' ?></td>
                                    <td><?php echo number_format ( $testSale -> price, 2 ) ?></td>
                                    <td> <?php echo date_setter ( $report -> created_at ) ?> </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>