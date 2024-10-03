<?php if ( !empty( $access ) and in_array ( 'lab', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'lab' or ( $parent_uri == 'reporting' and !isset( $_GET[ 'menu' ] ) ) )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-flask"></i>
            <span class="title"> Lab </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'sale_test', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sale' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/sale' ) ?>">
                        Sale Test (General)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'sale_test_package', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sale-package' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/sale-package' ) ?>">
                        Sale Test (Package)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'sale_test_covid', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sale-covid' )
                    echo 'active'; ?>">
                    <?php
                        if ( isset( $_GET[ 'patient' ] ) and $_GET[ 'patient' ] > 0 and isset( $_GET[ 'redirect' ] ) and !empty( trim ( $_GET[ 'redirect' ] ) ) )
                            $url = base_url ( '/lab/sale-covid/?patient=' . $_GET[ 'patient' ] . '&redirect=' . $_GET[ 'redirect' ] );
                        else
                            $url = base_url ( '/patients/add-panel-patient/?category=covid&redirect=' . base_url ( '/lab/sale-covid' ) );
                    ?>
                    <a href="<?php echo base_url ( '/lab/sale-covid' ) ?>">
                        Sale Test (Covid-19 Panel)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'sale_invoices_cash', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sales' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/sales' ) ?>">
                        Sale Invoices (Cash)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'sale_invoices_panel', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sales-panel' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/sales-panel' ) ?>">
                        Sale Invoices (Panel)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'lab-cash-balance-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'lab-cash-balance-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/lab-cash-balance-report' ) ?>">
                        Sale Invoices (Cash-Balance)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'lab_sale_pending_results', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sale-pending-results' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/sale-pending-results' ) ?>">
                        Pending Results
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'lab_all_added_test_results', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'all-added-test-results' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/all-added-test-results' ) ?>">
                        All Added Test Results
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'lab_sale_pending_results_ipd', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sale-pending-results-ipd' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/sale-pending-results-ipd' ) ?>">
                        Pending Results (IPD)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'lab_all_added_test_results_ipd', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'all-added-test-results-ipd' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/all-added-test-results-ipd' ) ?>">
                        All Added Test Results (IPD)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'test-status-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'test-status-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/test-status-report' ) ?>">
                        Test Status
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'load-data-sheet', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'load-data-sheet' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/load-data-sheet' ) ?>">
                        Load Data Sheet
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'edit_lab_sale', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'search-sale' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/search-sale' ) ?>">
                        Edit Sale
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'all_lab_tests', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/index' ) ?>">
                        All Tests
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_lab_tests', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/add' ) ?>">
                        Add Lab Test
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_test_results', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-result' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/add-result' ) ?>">
                        Add Result
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_ipd_test_results', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-ipd-test-result' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/add-ipd-test-result' ) ?>">
                        Add Result (IPD)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_airline_details', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'airline-details' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/airline-details' ) ?>">
                        Add Airline Details
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'calibrations', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'calibrations' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/calibrations' ) ?>">
                        All Calibrations
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_calibrations', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-calibrations' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/add-calibrations' ) ?>">
                        Add Calibrations
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'update_prices_bulk', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'bulk-update-prices' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/lab/bulk-update-prices' ) ?>">
                        Prices Update (Bulk)
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>