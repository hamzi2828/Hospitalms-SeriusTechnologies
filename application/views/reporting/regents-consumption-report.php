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
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Test</label>
                    <select name="test_id" class="form-control select2me">
                        <option value="">Select Test</option>
                        <?php
                            if ( count ( $tests ) > 0 ) {
                                foreach ( $tests as $test ) {
                                    ?>
                                    <option value="<?php echo $test -> id ?>" <?php if ( $test -> id == $_REQUEST[ 'test_id' ] ) echo 'selected="selected"' ?>>
                                        <?php echo $test -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label>Regent/Item</label>
                    <select name="regent-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $regents ) > 0 ) :
                                foreach ( $regents as $regent ) :
                                    ?>
                                    <option value="<?php echo $regent -> id ?>" <?php if ( $regent -> id == $_REQUEST[ 'regent-id' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $regent -> item ?>
                                    </option>
                                <?php
                                endforeach;
                            endif; ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-block btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Regents Consumption Report
                </div>
                <?php if ( count ( $regent_consumption ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/regents-consumption-invoice?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       class="pull-right print-btn" target="_blank">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Test</th>
                        <th> No. of Times Performed</th>
                        <th> No. of Times Calibrated</th>
                        <th> Regents/Items <br /> (Standard Values)</th>
                        <th> Usability Against Sale</th>
                        <th> Usability Against Calibrations</th>
                        <th> Total Usage</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        $used    = 0;
                        if ( count ( $regent_consumption ) > 0 ) {
                            foreach ( $regent_consumption as $consumption ) {
                                $sale_id      = $consumption -> sale_id;
                                $calibrations = get_regent_calibrations ( $consumption -> test_id );
                                ?>
                                <tr>
                                    <td><?php echo $counter++; ?></td>
                                    <td>
                                        <?php
                                            $testInfo = get_test_by_id ( $consumption -> test_id );
                                            echo $testInfo -> name;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            //                                                $results = get_regent_test_results ( $consumption -> test_id);
                                            //                                                $regents = get_test_regents ( $consumption -> test_id );
                                            //                                                $totalRegents = 0;
                                            //                                                $regents = get_test_regents ( $consumption -> test_id );
                                            //                                                if ( count ( $results ) > 0 ) {
                                            //                                                    foreach ( $results as $result ) {
                                            //                                                        if ( count ( $regents ) > 0 ) {
                                            //                                                            foreach ( $regents as $regent ) {
                                            //                                                                $totalRegents += $result -> regents * $regent -> usable_quantity;
                                            //                                                            }
                                            //                                                        }
                                            //                                                    }
                                            //                                                }
                                            //                                                echo $totalRegents;
                                            $results = get_regent_test_results ( $consumption -> test_id );
                                            //                                                $regents = get_test_regents ( $consumption -> test_id );
                                            $totalRegents = 0;
                                            //                                                $regents = get_test_regents ( $consumption -> test_id );
                                            if ( count ( $results ) > 0 ) {
                                                foreach ( $results as $result ) {
                                                    $totalRegents += $result -> regents;
                                                }
                                            }
                                            echo $totalRegents;
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $calibrations ?>
                                    </td>
                                    <td>
                                        <?php
                                            $regents = get_test_regents ( $consumption -> test_id );
                                            if ( count ( $regents ) > 0 ) {
                                                foreach ( $regents as $regent ) {
                                                    $store = get_store_by_id ( $regent -> regent_id );
                                                    echo '<b>' . $store -> item . '</b> = ' . $regent -> usable_quantity . '<br/>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $regents = get_test_regents ( $consumption -> test_id );
                                            if ( count ( $regents ) > 0 ) {
                                                foreach ( $regents as $regent ) {
                                                    $store = get_store_by_id ( $regent -> regent_id );
                                                    echo '<b>' . $store -> item . '</b> = ' . $regent -> usable_quantity * $totalRegents . '<br/>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $regents = get_test_regents ( $consumption -> test_id );
                                            if ( count ( $regents ) > 0 ) {
                                                foreach ( $regents as $regent ) {
                                                    $store = get_store_by_id ( $regent -> regent_id );
                                                    echo '<b>' . $store -> item . '</b> = ' . $regent -> usable_quantity * $calibrations . '<br/>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $regents = get_test_regents ( $consumption -> test_id );
                                            if ( count ( $regents ) > 0 ) {
                                                foreach ( $regents as $regent ) {
                                                    $store = get_store_by_id ( $regent -> regent_id );
                                                    $val1  = $regent -> usable_quantity * $calibrations;
                                                    $val2  = $regent -> usable_quantity * $totalRegents;
                                                    echo '<b>' . $store -> item . '</b> = ' . ( $val1 + $val2 ) . '<br/>';
                                                }
                                            }
                                        ?>
                                    </td>
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