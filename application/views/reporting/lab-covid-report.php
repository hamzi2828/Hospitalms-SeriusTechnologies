<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
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
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Airline</label>
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
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> General Report (COVID-19)
                </div>
                <?php if ( count ( $reports ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/lab-covid-report?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       class="pull-right print-btn" target="_blank">Print</a>
                <?php endif ?>
                <?php if ( count ( $reports ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/lab-covid-invoice?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       class="pull-right print-btn" target="_blank" style="margin-right: 15px">Invoice</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Airline</th>
                        <th> Tests</th>
                        <th> Rates</th>
                        <th> Passenger</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        $p_total = 0;
                        if ( count ( $reports ) > 0 ) {
                            foreach ( $reports as $report ) {
                                $sale        = get_lab_sale ( $report -> sale_id );
                                $p_total     = $p_total + $report -> price;
                                $tests       = explode ( ',', $report -> tests );
                                $airlineInfo = get_airlines_by_id ( $report -> airline_id );
                                ?>
                                <tr>
                                    <td> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $airlineInfo -> title ?> </td>
                                    <td>
                                        <?php
                                            if ( count ( $tests ) > 0 ) {
                                                foreach ( $tests as $test ) {
                                                    if ( $test > 0 ) {
                                                        if ( !check_if_test_is_child ( $test ) )
                                                            echo get_test_by_id ( $test ) -> name . '<br>';
                                                    }
                                                }
                                            } ?>
                                    </td>
                                    <td> <?php echo number_format ( $report -> price, 2 ) ?> </td>
                                    <td> <?php echo $report -> patients ?> </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="3" class="text-right"><b>Total</b></td>
                                <td><?php echo number_format ( $p_total, 2 ) ?></td>
                                <td></td>
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