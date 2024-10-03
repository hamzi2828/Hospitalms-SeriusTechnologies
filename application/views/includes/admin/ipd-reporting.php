<?php if ( !empty( $access ) and in_array ( 'ipd-reporting', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'ipd-reporting' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-search"></i>
            <span class="title"> IPD Reporting </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'ipd_general_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ipd-reporting/general-report' ) ?>">
                        General Report (Cash)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'ipd_general_report_panel', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report-panel' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ipd-reporting/general-report-panel' ) ?>">
                        General Report (Panel)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'consultant_commission', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'consultant-commission' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ipd-reporting/consultant-commission' ) ?>">
                        Consultant Commission
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'ot_timings_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'ot-timings' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ipd-reporting/ot-timings' ) ?>">
                        OT Timings Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'bed_status_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'beds-status-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ipd-reporting/beds-status-report' ) ?>">
                        Bed Status Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'ipd-summary-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'summary-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ipd-reporting/summary-report' ) ?>">
                        IPD Summary Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'ipd-receivable-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'receivable-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ipd-reporting/receivable-report' ) ?>">
                        Receivable Report (SSP)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'ipd-claim-status-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'claim-status-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ipd-reporting/claim-status-report' ) ?>">
                        Claim Status Report (SSP)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'ipd-claim-aging-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'ipd-claim-aging-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ipd-reporting/claim-aging-report' ) ?>">
                        Claim Ageing Report (SSP)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'ipd-cash-receiving-report-cash', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'cash-receiving-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( 'ipd-reporting/cash-receiving-report' ) ?>">
                        Cash Receiving Report (Cash)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'ipd-cash-receiving-report-panel', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'cash-receiving-report-panel' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( 'ipd-reporting/cash-receiving-report-panel' ) ?>">
                        Cash Receiving Report (Panel)
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>