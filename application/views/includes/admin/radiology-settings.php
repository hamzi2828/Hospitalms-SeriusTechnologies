<?php if ( !empty( $access ) and in_array ( 'radiology-settings', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'templates' and !isset( $_GET[ 'menu' ] ) )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-cog"></i>
            <span class="title"> Radiology Settings </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'templates', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'templates' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/index' ) ?>">
                        All Templates (Ultrasound)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-templates', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/add' ) ?>">
                        Add Templates (Ultrasound)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'templates-xray', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'xray-templates' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/xray-templates' ) ?>">
                        All Templates (X-Ray)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-templates-xray', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-xray-templates' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/add-xray-templates' ) ?>">
                        Add Templates (X-Ray)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'templates-ct-scan', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'ct-scan-templates' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/ct-scan-templates' ) ?>">
                        All Templates (CT-Scan)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-templates-ct-scan', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-ct-scan-templates' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/add-ct-scan-templates' ) ?>">
                        Add Templates (CT-Scan)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'templates-mri', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'mri-templates' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/mri-templates' ) ?>">
                        All Templates (MRI)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-templates-mri', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-mri-templates' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/add-mri-templates' ) ?>">
                        Add Templates (MRI)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'echo-templates', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'echo' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/echo' ) ?>">
                        All Templates (ECHO)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'add-echo-templates', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-echo' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/add-echo' ) ?>">
                        Add Templates (ECHO)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'ecg-templates', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'ecg' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/ecg' ) ?>">
                        All Templates (ECG)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'add-ecg-templates', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-ecg' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/add-ecg' ) ?>">
                        Add Templates (ECG)
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>