<?php if ( !empty( $access ) and in_array ( 'consultancy-reporting', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'ConsultancyReport' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-search"></i>
            <span class="title"> Consultancy Reporting </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'consultancy_general_reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ConsultancyReport/general-report' ) ?>">
                        General Report (Cash)
                    </a>
                </li>
                <li class="<?php if ( $child_uri == 'general-report-1' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ConsultancyReport/general-report-1' ) ?>">
                        General Report 1
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'consultancy_general_reporting_panel', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report-panel' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ConsultancyReport/general-report-panel' ) ?>">
                        General Report (Panel)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'doctor_consultancy_reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'doctor-consultancy-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ConsultancyReport/doctor-consultancy-report' ) ?>">
                        Doctor Wise Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'doctor_consultancy_reporting_summary', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'doctor-consultancy-report-summary' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ConsultancyReport/doctor-consultancy-report-summary' ) ?>">
                        Doctor Wise Report (Summary)
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>