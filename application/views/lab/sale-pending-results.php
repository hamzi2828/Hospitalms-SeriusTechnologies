<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if ( validation_errors () != false ) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors (); ?>
            </div>
        <?php } ?>
        <?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata ( 'error' ) ?>
            </div>
        <?php endif; ?>
        <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
        <?php endif; ?>
        <div class="search-form">
            <form method="get" autocomplete="off">
                <div class="form-group col-lg-2" style="position: relative">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></label>
                    <input type="text" name="invoice_id" class="form-control" placeholder="Enter invoice number"
                           autofocus="autofocus" value="<?php echo @$_REQUEST[ 'invoice_id' ] ?>">
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="date date-picker form-control" placeholder="Start date"
                           value="<?php echo ( @$_REQUEST[ 'start_date' ] ) ? @$_REQUEST[ 'start_date' ] : '' ?>">
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="date date-picker form-control" placeholder="End date"
                           value="<?php echo ( @$_REQUEST[ 'end_date' ] ) ? @$_REQUEST[ 'end_date' ] : '' ?>">
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Panel</label>
                    <select name="panel-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    ?>
                                    <option
                                            value="<?php echo $panel -> id ?>" <?php if ( $panel -> id == @$_GET[ 'panel-id' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $panel -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Airline</label>
                    <select name="airline-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $airlines ) > 0 ) {
                                foreach ( $airlines as $airline ) {
                                    ?>
                                    <option
                                            value="<?php echo $airline -> id ?>" <?php if ( $airline -> id == @$_GET[ 'airline-id' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $airline -> title ?>
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
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="col-sm-12" style="padding-left: 0">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Pending Test Results
                    </div>
                </div>
                <div class="portlet-body" style="overflow: auto">
                    <form method="post">
                        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                               value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th> Sr. No</th>
                                <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                                <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                                <th> Patient Panel</th>
                                <th> Airline</th>
                                <th> Flight Date/Time</th>
                                <th> Test Name</th>
                                <th> Date Added</th>
                                <th> Results Added</th>
                                <th> Results Verified</th>
                                <th> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $counter = 1 + ( isset( $_GET[ 'per_page' ] ) and @$_GET[ 'per_page' ] > 0 ) ? ( @$_GET[ 'per_page' ] + 1 ) : 0;
                                if ( count ( $sales ) > 0 ) {
                                    foreach ( $sales as $sale ) {
                                        $results     = @get_test_results ( $sale -> sale_id, $sale -> test_id );
                                        $test        = @get_test_by_id ( $sale -> test_id );
                                        $isParent    = check_if_test_has_sub_tests ( $sale -> test_id );
                                        $parent_id   = $test -> type == 'test' ? 0 : $sale -> test_id;
                                        $saleInfo    = get_lab_sale ( $sale -> sale_id );
                                        $verified    = get_result_verification_data ( $sale -> sale_id, ( !empty( $results ) ) ? $results -> id : 0 );
                                        $patient     = get_patient ( $sale -> patient_id );
                                        $airlineInfo = get_airlines_by_id ( $sale -> airline_id );
                                        $travel      = get_patient_travel_details ( $sale -> sale_id );
                                        ?>
                                        <tr class="odd gradeX">
                                            <td>
                                                <?php echo $counter++ ?>
                                            </td>
                                            <td><?php echo $sale -> sale_id ?></td>
                                            <td><?php echo @get_patient_name ( 0, $patient ) ?></td>
                                            <td>
                                                <?php
                                                    if ( !empty( $patient ) && $patient -> panel_id > 0 )
                                                        echo get_panel_by_id ( $patient -> panel_id ) -> name;
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo @$airlineInfo -> title; ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ( !empty( $travel ) )
                                                        echo date_setter ( @$travel -> flight_date );
                                                ?>
                                            </td>
                                            <td><?php echo $test -> name ?></td>
                                            <td>
                                                <?php echo date_setter ( $saleInfo -> date_sale ); ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ( $results and !empty ( $results ) > 0 )
                                                        echo '<span class="label label-success">Results Added</span>';
                                                    else
                                                        echo '<span class="label label-warning">Results Not Added</span>';
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ( !empty( $verified ) )
                                                        echo '<span class="label label-success">Results Verified</span>';
                                                    else
                                                        echo '<span class="label label-warning">Results Not Verified</span>';
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'lab_add_pending_results_button', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) {
                                                        if ( $results and !empty ( $results ) > 0 ) {
                                                            ?>
                                                            <a href="<?php echo base_url ( '/lab/add-results/?sale-id=' . $sale -> sale_id . '&parent-id=' . $parent_id . '&test-id=' . $sale -> test_id . '&machine=' . $results -> machine ) ?>"
                                                               class="btn btn-warning btn-xs btn-block"
                                                               target="_blank">Edit Results
                                                            </a>
                                                            <?php
                                                        }
                                                        else {
                                                            ?>
                                                            <a href="<?php echo base_url ( '/lab/add-results/?sale-id=' . $sale -> sale_id . '&parent-id=' . $parent_id . '&test-id=' . $sale -> test_id . '&machine=default' ) ?>"
                                                               class="btn btn-primary btn-xs btn-block"
                                                               target="_blank">Add Results
                                                            </a>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                                <a href="<?php echo base_url ( '/lab/airline-details/?sale-id=' . $sale -> sale_id ) ?>"
                                                   class="btn btn-success btn-xs btn-block"
                                                   target="_blank">Add Airline Details
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div id="pagination">
                    <ul class="tsc_pagination">
                        <!-- Show pagination links -->
                        <?php foreach ( $links as $link ) {
                            echo "<li>" . $link . "</li>";
                        } ?>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>