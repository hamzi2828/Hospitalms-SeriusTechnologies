<?php if ( !empty( $access ) and in_array ( 'opd-reporting', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'OpdReport' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-search"></i>
            <span class="title"> OPD Reporting </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'opd_general_reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/OpdReport/general-report' ) ?>">
                        General Report (Cash)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'opd_general_reporting_panel', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report-panel' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/OpdReport/general-report-panel' ) ?>">
                        General Report (Panel)
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>