<?php if ( !empty( $access ) and in_array ( 'lab_reporting', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'reporting' and @$_GET[ 'menu' ] == 'lab' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-search"></i>
            <span class="title"> Lab Reporting </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'lab_general_reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'lab-general-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/lab-general-report/?menu=lab' ) ?>">
                        General Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'lab_covid_reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'lab-covid-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/lab-covid-report/?menu=lab' ) ?>">
                        General Report (COVID-19)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'lab_general_reporting_ipd', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'lab-general-report-ipd' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/lab-general-report-ipd/?menu=lab' ) ?>">
                        General Report (IPD)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'regents_consumption_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'regents-consumption-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/regents-consumption-report/?menu=lab' ) ?>">
                        Regents Consumption Report (Cash)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'regents_consumption_report_ipd', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'regents-consumption-report-ipd' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/regents-consumption-report-ipd/?menu=lab' ) ?>">
                        Regents Consumption Report (IPD)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'test_prices_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'test-prices-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/test-prices-report/?menu=lab' ) ?>">
                        Test Prices Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'referred-by-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'referred-by-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/referred-by-report/?menu=lab' ) ?>">
                        Referred By Report
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>