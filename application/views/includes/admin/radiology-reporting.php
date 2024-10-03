<?php if ( !empty( $access ) and in_array ( 'radiology-reporting', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'RadiologyReport' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-search"></i>
            <span class="title"> Radiology Reporting </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'xray_general_reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report-xray' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/RadiologyReport/general-report-xray' ) ?>">
                        General Report (X-Ray)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'ultrasound_general_reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report-ultrasound' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/RadiologyReport/general-report-ultrasound' ) ?>">
                        General Report (UltraSound)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'ct_scan_general_reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report-ct-scan' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/RadiologyReport/general-report-ct-scan' ) ?>">
                        General Report (CT-Scan)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'mri_general_reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report-mri' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/RadiologyReport/general-report-mri' ) ?>">
                        General Report (MRI)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'echo_general_reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report-echo' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/RadiologyReport/general-report-echo' ) ?>">
                        General Report (ECHO)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'ecg_general_reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report-ecg' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/RadiologyReport/general-report-ecg' ) ?>">
                        General Report (ECG)
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>