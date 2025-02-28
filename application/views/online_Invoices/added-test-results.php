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
       
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="col-sm-12" >
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> All  Test Results  
                    </div>
                    <?php if ( isset( $_GET[ 'invoice_id' ] ) and $_GET[ 'invoice_id' ] > 0 ) : ?>
                        <a href="<?php echo base_url ( '/invoices/complete-test-results-report/?sale-id=' . $_GET[ 'invoice_id' ] . '&logo=true' ) ?>"
                           id="print-selected" target="_blank" class="pull-right print-btn">Print Selected</a>
                    <?php endif; ?>
                </div>
               <div class="portlet-body" style="overflow: auto">
                    <form method="post">
                        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                               value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th> Sr. No</th>
                                <th>Patient </th>
                                <th> Test Name</th>
                                <th> Print Single Report</th>
                                <th > Print Report (All In One)</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $counter = 1 + ( isset( $_GET[ 'per_page' ] ) and @$_GET[ 'per_page' ] > 0 ) ? ( @$_GET[ 'per_page' ] + 1 ) : 0;
                                $user    = 0;
                                if ( count ( $sales ) > 0 ) {
                                    foreach ( $sales as $sale ) {
                                        $results   = @get_test_results ( $sale -> sale_id, $sale -> test_id );
                                        $test      = @get_test_by_id ( $sale -> test_id );
                                        
                                        $sale_info = get_lab_sale ( $sale -> sale_id );
                                        $location  = ( is_object ( $sale_info ) ) ? get_location_by_id ( $sale_info -> locations_id ) : new stdClass();
                                        $location_sale_id = get_location_sale_id_by_hmis_lab_sales_id($sale -> sale_id);
                                        $daily_location_sale_id = get_daily_location_sale_id_by_hmis_lab_sales_id($sale -> sale_id);


                                        // $balance   = check_remaning_balance_by_invoice ( $sale -> invoice_number );
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
                                           
                                            <td><?php echo get_patient_name ( 0, $patient ) ?></td>
                                          
                                            <td><?php echo $test -> name ?></td>
                                           
                                            
                                           
                                            <td>
                                                <?php
                                                    if ( $test -> id == CP_Peripheral_Film ) {
                                                        ?>
                                                       
                                                        <a href="<?php echo base_url ( '/invoices/cp-peripheral-film-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                        style="padding: 5px 30px; font-weight: bold;" class="btn btn-success "  target="_blank">L-Print </a>
                                                        
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == STOOL_EXAMINATION ) {
                                                        ?>
                                               
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/stool-examination-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                        style="padding: 5px 30px; font-weight: bold;" class="btn btn-success " target="_blank">L-Print</a>
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == SEMEN_ANALYSIS ) {
                                                        ?>
                                                      
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/semen-analysis-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                        style="padding: 5px 30px; font-weight: bold;" class="btn btn-success "  target="_blank">L-Print</a>
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == URINE_RE ) {
                                                        ?>
                                                      
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/urine-re-analysis-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                        style="padding: 5px 30px; font-weight: bold;" class="btn btn-success "  target="_blank">L-Print</a>
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == CSF_ANALYSIS ) {
                                                        ?>
                                                    
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/csf-analysis-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                        style="padding: 5px 30px; font-weight: bold;" class="btn btn-success "  target="_blank">L-Print</a>
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == Ascitic_Fluid_Analysis ) {
                                                        ?>
                                                     
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/ascitic-fluid-analysis/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                        style="padding: 5px 30px; font-weight: bold;" class="btn btn-success "  target="_blank">L-Print</a>
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == Pericardial_Fluid ) {
                                                        ?>
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/pericardial-fluid-report/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                        style="padding: 5px 30px; font-weight: bold;" class="btn btn-success "  target="_blank">L-Print</a>
                                                        <?php
                                                    }
                                                    
                                                    else if ( $patient -> panel_id > 0 ) {
                                                        ?>
                                                        
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/print_lab_single_invoice_lab/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                        style="padding: 5px 30px; font-weight: bold;" class="btn btn-success " target="_blank">L-Print</a>
                                                        
                                                  
                                                        
                                                
                                                        <?php
                                                    }
                                                    
                                                    else if ( $balance <= 0  ) { ?>
                                                    
                                                        <a href="<?php echo base_url ( '/invoices/print_lab_single_invoice_lab/?id=' . @$results -> id . '&sale-id=' . $sale -> sale_id . '&parent-id=' . $sale -> test_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                        style="padding: 5px 30px; font-weight: bold;" class="btn btn-success "  target="_blank">L-Print</a>
                                          
                                                        
                                           
                                                    <?php } ?>
                                                

                                                

                                            
                                            </td>
                                            <td>
                                                <?php
                                                    if ( $test -> id == CP_Peripheral_Film ) {
                                                        ?>
                                                       
                                                       
                                                        
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == STOOL_EXAMINATION ) {
                                                        ?>
                                               
                                                        
                                                  
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == SEMEN_ANALYSIS ) {
                                                        ?>
                                                      
                                                        
                                                    
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == URINE_RE ) {
                                                        ?>
                                                      
                                         
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == CSF_ANALYSIS ) {
                                                        ?>
                                                    
                                                        
                                                 
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == Ascitic_Fluid_Analysis ) {
                                                        ?>
                                                     
                                                        
                                                      
                                                        <?php
                                                    }
                                                    
                                                    else if ( $test -> id == Pericardial_Fluid ) {
                                                        ?>
                                                        
                                                     
                                                        <?php
                                                    }
                                                    
                                                    else if ( $patient -> panel_id > 0 ) {
                                                        ?>
                                                        
                                                        
                                                
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/complete-test-results-report/?sale-id=' . $sale -> sale_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                        style="padding: 5px 30px; font-weight: bold;" class="btn btn-success " 
                                                           target="_blank">L-Print All</a>
                                                        
                                                
                                                        <?php
                                                    }
                                                    
                                                    else if ( $balance <= 0  ) { ?>
                                                    
                                            
                                                        
                                                        <a href="<?php echo base_url ( '/invoices/complete-test-results-report/?sale-id=' . $sale -> sale_id . '&logo=true' . '&machine=' . $results -> machine ) ?>"
                                                        style="padding: 5px 30px; font-weight: bold;" class="btn btn-success " 
                                                           target="_blank">L-Print All </a>
                                                        
                                           
                                                    <?php } ?>
                                                

                                                

                                            
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




            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>