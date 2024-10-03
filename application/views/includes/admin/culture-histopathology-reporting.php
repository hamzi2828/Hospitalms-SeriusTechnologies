<?php if ( !empty( $access ) and in_array ( 'culture-histopathology-reporting', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'ChReport' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-search"></i>
            <span class="title"> Culture/Histopathology Reporting </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'culture-general-reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report-culture' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ChReport/general-report-culture' ) ?>">
                        General Report (Culture)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'histopathology-general-reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report-histopathology' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/ChReport/general-report-histopathology' ) ?>">
                        General Report (Histopathology)
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>