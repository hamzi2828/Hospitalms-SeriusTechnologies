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
                
                <div class="form-group col-lg-3" style="position: relative">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" name="patient-name" class="form-control"
                           placeholder="Enter <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?>"
                           autofocus="autofocus" value="<?php echo @$_REQUEST[ 'patient-name' ] ?>">
                </div>
                
                <div class="form-group col-lg-3" style="position: relative">
                    <label for="exampleInputEmail1">Mobile No</label>
                    <input type="text" name="patient-mobile" class="form-control"
                           placeholder="Enter <?php echo $this -> lang -> line ( 'PATIENT_PHONE' ); ?> no"
                           autofocus="autofocus" value="<?php echo @$_REQUEST[ 'patient-mobile' ] ?>">
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
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Test</label>
                    <select name="test-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $tests ) > 0 ) {
                                foreach ( $tests as $test ) {
                                    ?>
                                    <option value="<?php echo $test -> id ?>" <?php if ( $test -> id == @$_GET[ 'test-id' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $test -> report_title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Panel</label>
                    <select name="panel-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    ?>
                                    <option value="<?php echo $panel -> id ?>" <?php if ( $panel -> id == @$_GET[ 'panel-id' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $panel -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Airline</label>
                    <select name="airline-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $airlines ) > 0 ) {
                                foreach ( $airlines as $airline ) {
                                    ?>
                                    <option value="<?php echo $airline -> id ?>" <?php if ( $airline -> id == @$_GET[ 'airline-id' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $airline -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Section</label>
                    <select name="section-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $sections ) > 0 ) :
                                foreach ( $sections as $section ) :
                                    ?>
                                    <option value="<?php echo $section -> id ?>" <?php if ( $section -> id == @$_GET[ 'section-id' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $section -> name ?>
                                    </option>
                                <?php
                                endforeach;
                            endif;
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="col-sm-12" style="padding-left: 0">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> All Added Test Results
                    </div>
                    <?php if ( isset( $_GET[ 'invoice_id' ] ) and $_GET[ 'invoice_id' ] > 0 ) : ?>
                        <a href="<?php echo base_url ( '/invoices/complete-test-results-report/?sale-id=' . $_GET[ 'invoice_id' ] . '&logo=true' ) ?>"
                           id="print-selected" target="_blank" class="pull-right print-btn">Print Selected</a>
                    <?php endif; ?>
                </div>
                <div class="portlet-body">
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
                                <th></th>
                                <th> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $counter = 1 + ( isset( $_GET[ 'per_page' ] ) and @$_GET[ 'per_page' ] > 0 ) ? ( @$_GET[ 'per_page' ] + 1 ) : 0;
                                $user    = get_user ( get_logged_in_user_id () );
                                if ( count ( $sales ) > 0 ) {
                                    foreach ( $sales as $sale ) {
                                        $results   = @get_test_results ( $sale -> sale_id, $sale -> test_id );
                                        $test      = @get_test_by_id ( $sale -> test_id );
                                        $isParent  = check_if_test_has_sub_tests ( $sale -> test_id );
                                        $parent_id = ( !empty( $test ) and $test -> type == 'test' ) ? 0 : $sale -> test_id;
                                        $saleInfo  = get_lab_sale ( $sale -> sale_id );
                                        $verified  = get_result_verification_data ( $sale -> sale_id, ( !empty( $results ) ) ? $results -> id : 0 );
                                        $patient   = get_patient ( $sale -> patient_id );
                                        $balance   = $saleInfo -> total - $saleInfo -> paid_amount;
                                        $travel    = get_patient_travel_details ( $sale -> sale_id );
                                        $delivery  = get_report_delivery_status ( $sale -> sale_id, $sale -> test_id );
                                        ?>
                                        <tr class="odd gradeX">
                                            <td>
                                                <?php echo $counter++ ?>
                                                <?php if ( isset( $_GET[ 'invoice_id' ] ) and $_GET[ 'invoice_id' ] > 0 ) : ?>
                                                    <input type="checkbox" value="<?php echo $sale -> test_id ?>"
                                                           onclick="upsertPrintSelected(this.value)"
                                                           id="selected-<?php echo $sale -> test_id ?>">
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $sale -> sale_id ?></td>
                                            <td><?php echo get_patient_name ( 0, $patient ) ?></td>
                                            <td>
                                                <?php
                                                    if ( $patient -> panel_id > 0 )
                                                        echo get_panel_by_id ( $patient -> panel_id ) -> name;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ( $sale -> airline_id > 0 )
                                                        echo get_airlines_by_id ( $sale -> airline_id ) -> title;
                                                ?>
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
                                                    if ( $results and !empty ( $results ) > 0 ) {
                                                        echo '<span class="label label-success">Results Added</span><br/>';
                                                        echo '<strong>Added By: </strong>' . get_user ( $results -> user_id ) -> name . '<br/>';
                                                        echo date_setter ( $results -> date_added );
                                                    }
                                                    else
                                                        echo '<span class="label label-warning">Results Not Added</span>';
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ( !empty( $verified ) ) {
                                                        echo '<span class="label label-success">Results Verified</span><br/>';
                                                        echo '<strong>Added By: </strong>' . get_user ( $verified -> user_id ) -> name . '<br/>';
                                                        echo date_setter ( $verified -> created_at );
                                                    }
                                                    else
                                                        echo '<span class="label label-warning">Results Not Verified</span>';
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ( $patient -> panel_id > 0 )
                                                        $link = base_url ( '/patients/edit-panel/' . $patient -> id );
                                                    else
                                                        $link = base_url ( '/patients/edit-cash/' . $patient -> id );
                                                    
                                                    if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'lab-add-added-results-edit-patient-btn', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                                        <a href="<?php echo $link ?>"
                                                           class="btn purple btn-xs btn-block"
                                                           target="_blank">
                                                            Edit Patient
                                                        </a>
                                                    <?php endif; ?>
                                                
                                                <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'lab-add-added-results-add-airline-details-btn', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                                    
                                                    <a href="<?php echo base_url ( '/lab/airline-details/?sale-id=' . $sale -> sale_id ) ?>"
                                                       class="btn btn-success btn-xs btn-block"
                                                       target="_blank">
                                                        Add Airline Details
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ( $test -> id == CP_Peripheral_Film ) {
                                                        ?>
                                                        <a href="<?php echo base_url ( '/invoices/cp-peripheral-film-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&machine=' . $results -> machine ) ?>"
                                                           class="btn <?php echo ( $isParent or $test -> parent_id < 1 ) ? 'green btn-xs' : 'purple btn-xs' ?>"
                                                           target="_blank">Print</a>
                                                        <a href="<?php echo base_url ( '/invoices/cp-peripheral-film-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                           class="btn purple btn-xs" target="_blank">L-Print</a>
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/cp-peripheral-film-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=false' . '&machine=' . $results -> machine ) ?>"
                                                           class="btn purple btn-block btn-xs"
                                                           target="_blank">Print All</a>
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == STOOL_EXAMINATION ) {
                                                        ?>
                                                        <a href="<?php echo base_url ( '/invoices/stool-examination-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&machine=' . $results -> machine ) ?>"
                                                           class="btn <?php echo ( $isParent or $test -> parent_id < 1 ) ? 'green btn-xs' : 'purple btn-xs' ?>"
                                                           target="_blank">Print</a>
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/stool-examination-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                           class="btn purple btn-xs" target="_blank">L-Print</a>
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == SEMEN_ANALYSIS ) {
                                                        ?>
                                                        <a href="<?php echo base_url ( '/invoices/semen-analysis-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&machine=' . $results -> machine ) ?>"
                                                           class="btn <?php echo ( $isParent or $test -> parent_id < 1 ) ? 'green btn-xs' : 'purple btn-xs' ?>"
                                                           target="_blank">Print</a>
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/semen-analysis-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                           class="btn purple btn-xs" target="_blank">L-Print</a>
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == URINE_RE ) {
                                                        ?>
                                                        <a href="<?php echo base_url ( '/invoices/urine-re-analysis-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&machine=' . $results -> machine ) ?>"
                                                           class="btn <?php echo ( $isParent or $test -> parent_id < 1 ) ? 'green btn-xs' : 'purple btn-xs' ?>"
                                                           target="_blank">Print</a>
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/urine-re-analysis-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                           class="btn purple btn-xs" target="_blank">L-Print</a>
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == CSF_ANALYSIS ) {
                                                        ?>
                                                        <a href="<?php echo base_url ( '/invoices/csf-analysis-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&machine=' . $results -> machine ) ?>"
                                                           class="btn <?php echo ( $isParent or $test -> parent_id < 1 ) ? 'green btn-xs' : 'purple btn-xs' ?>"
                                                           target="_blank">Print</a>
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/csf-analysis-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                           class="btn purple btn-xs" target="_blank">L-Print</a>
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == Ascitic_Fluid_Analysis ) {
                                                        ?>
                                                        <a href="<?php echo base_url ( '/invoices/ascitic-fluid-analysis/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&machine=' . $results -> machine ) ?>"
                                                           class="btn <?php echo ( $isParent or $test -> parent_id < 1 ) ? 'green btn-xs' : 'purple btn-xs' ?>"
                                                           target="_blank">Print</a>
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/ascitic-fluid-analysis/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                           class="btn purple btn-xs" target="_blank">L-Print</a>
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == Pericardial_Fluid ) {
                                                        ?>
                                                        <a href="<?php echo base_url ( '/invoices/pericardial-fluid-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&machine=' . $results -> machine ) ?>"
                                                           class="btn <?php echo ( $isParent or $test -> parent_id < 1 ) ? 'green btn-xs' : 'purple btn-xs' ?>"
                                                           target="_blank">Print</a>
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/pericardial-fluid-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                           class="btn purple btn-xs" target="_blank">L-Print</a>
                                                        <?php
                                                    }
                                                    
                                                    else if ( $patient -> panel_id > 0 ) {
                                                        ?>
                                                        <a href="<?php echo base_url ( '/invoices/print_lab_single_invoice_lab/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&machine=' . $results -> machine ) ?>"
                                                           class="btn <?php echo ( $isParent or $test -> parent_id < 1 ) ? 'green btn-xs' : 'purple btn-xs' ?>"
                                                           target="_blank">Print</a>
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/print_lab_single_invoice_lab/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                           class="btn purple btn-xs" target="_blank">L-Print</a>
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/complete-test-results-report/?sale-id=' . $sale -> sale_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                           class="btn dark btn-block btn-xs"
                                                           target="_blank">L-Print All</a>
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/complete-test-results-report/?sale-id=' . $sale -> sale_id . '&logo=false' . '&machine=' . $results -> machine ) ?>"
                                                           class="btn dark btn-block btn-xs"
                                                           target="_blank">Print All</a>
                                                        <?php
                                                    }
                                                    
                                                    else if ( $balance <= 0 or ( $balance >= 1 and $user -> department_id == ADMINISTRATION_DEPT ) ) { ?>
                                                        <a href="<?php echo base_url ( '/invoices/print_lab_single_invoice_lab/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&machine=' . $results -> machine ) ?>"
                                                           class="btn <?php echo ( $isParent or $test -> parent_id < 1 ) ? 'green btn-xs' : 'purple btn-xs' ?>"
                                                           target="_blank">Print</a>
                                                        <a href="<?php echo base_url ( '/invoices/print_lab_single_invoice_lab/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                           class="btn purple btn-xs" target="_blank">L-Print</a>
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/complete-test-results-report/?sale-id=' . $sale -> sale_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                           class="btn dark btn-block btn-xs"
                                                           target="_blank">L-Print All</a>
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/complete-test-results-report/?sale-id=' . $sale -> sale_id . '&logo=false' . '&machine=' . $results -> machine ) ?>"
                                                           class="btn dark btn-block btn-xs"
                                                           target="_blank">Print All</a>
                                                    <?php } ?>
                                                
                                                <?php if ( empty( $delivery ) ) : ?>
                                                    <a href="<?php echo base_url ( '/lab/update-delivery-status/?sale-id=' . $sale -> sale_id . '&test-id=' . $sale -> test_id ) ?>"
                                                       class="btn blue btn-block btn-xs">Not Delivered</a>
                                                <?php else : ?>
                                                    <a href="javascript:void(0)"
                                                       class="btn yellow btn-block btn-xs">Delivered</a>
                                                <?php endif; ?>
                                            
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