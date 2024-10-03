<?php if ( !empty( $access ) and in_array ( 'general_reporting', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'general-reporting' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-search"></i>
            <span class="title"> General Reporting </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'general_summary_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-summary-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/general-reporting/general-summary-report' ) ?>">
                        Summary Report (Sales)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'general_summary_report_cash', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-summary-report-cash' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/general-reporting/general-summary-report-cash' ) ?>">
                        Summary Report (Cash)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'general_summary_report_cash_ii', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-summary-report-cash-ii' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/general-reporting/general-summary-report-cash-ii' ) ?>">
                        Summary Report (Cash II)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'daily-closing-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'daily-closing-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/general-reporting/daily-closing-report' ) ?>">
                        Daily Closing (User Wise)
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>