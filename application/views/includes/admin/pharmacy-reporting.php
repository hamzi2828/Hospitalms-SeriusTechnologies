<?php if ( !empty( $access ) and in_array ( 'pharmacy_reporting', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'reporting' and @$_GET[ 'menu' ] == 'pharmacy' and !isset( $_REQUEST[ 'active' ] ) )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-search"></i>
            <span class="title"> Pharmacy Reporting </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'general_report_ipd_medication', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report-ipd-medication' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/general-report-ipd-medication/?menu=pharmacy' ) ?>">
                        General Report (IPD Med)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'sales_general_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/general-report/?menu=pharmacy' ) ?>">
                        General Report (Sales)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'returns_general_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report-customer-return' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/general-report-customer-return/?menu=pharmacy' ) ?>">
                        General Report (Return)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'sale_report_against_supplier', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sale-report-against-supplier' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/sale-report-against-supplier/?menu=pharmacy' ) ?>">
                        Sale Report Against Supplier
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'stock_valuation_report_tp_wise', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'stock-valuation-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/stock-valuation-report/?menu=pharmacy' ) ?>">
                        Stock Valuation Report (TP Wise)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'stock_valuation_report_sale_wise', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'stock-valuation-report-sale-price' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/stock-valuation-report-sale-price/?menu=pharmacy' ) ?>">
                        Stock Valuation Report (Sale Price Wise)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'threshold_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'threshold-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/threshold-report/?menu=pharmacy' ) ?>">
                        Threshold Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'profit_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'profit-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/profit-report/?menu=pharmacy' ) ?>">
                        Profit Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'profit_report_ipd_medication', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'profit-report-ipd-medication' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/profit-report-ipd-medication/?menu=pharmacy' ) ?>">
                        Profit Report (IPD Med)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'detailed_stock_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'detailed-stock-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/detailed-stock-report/?menu=pharmacy' ) ?>">
                        Detailed Stock Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'bonus_stock_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'bonus-stock-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/bonus-stock-report/?menu=pharmacy' ) ?>">
                        Bonus Stock Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'form_wise_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'form-wise-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/form-wise-report/?menu=pharmacy' ) ?>">
                        Form Wise Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'supplier_wise_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'supplier-wise-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/supplier-wise-report/?menu=pharmacy' ) ?>">
                        Supplier Wise Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'analysis_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'analysis-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/analysis-report/?menu=pharmacy' ) ?>">
                        Analysis Report (Purchase)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'analysis_report_sale', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'analysis-report-sale' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/analysis-report-sale/?menu=pharmacy' ) ?>">
                        Analysis Report (Sale)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'analysis_report_ipd_sale', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'analysis-report-ipd-sale' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/analysis-report-ipd-sale/?menu=pharmacy' ) ?>">
                        Analysis Report (IPD Sale)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'summary_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'summary-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/summary-report/?menu=pharmacy' ) ?>">
                        Summary Report
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>