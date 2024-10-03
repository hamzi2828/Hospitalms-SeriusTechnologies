<?php if ( !empty( $access ) and in_array ( 'culture-histopathology-settings', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'templates' and @$_GET[ 'menu' ] == 'cs-settings' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-cog"></i>
            <span class="title"> Culture/Histopathology Settings </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'culture-templates', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'culture-templates' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/culture-templates/?menu=cs-settings' ) ?>">
                        All Templates (Culture)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-culture-templates', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-culture-templates' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/add-culture-templates/?menu=cs-settings' ) ?>">
                        Add Templates (Culture)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'templates-histopathology', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'histopathology-templates' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/histopathology-templates/?menu=cs-settings' ) ?>">
                        All Templates (Histopathology)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-templates-histopathology', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-histopathology-templates' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/add-histopathology-templates/?menu=cs-settings' ) ?>">
                        Add Templates (Histopathology)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'antibiotic-susceptibility', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'antibiotic-susceptibility' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/antibiotic-susceptibility/?menu=cs-settings' ) ?>">
                        All Antibiotic (Susceptibility)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-antibiotic-susceptibility', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-antibiotic-susceptibility' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/templates/add-antibiotic-susceptibility/?menu=cs-settings' ) ?>">
                        Add Antibiotic (Susceptibility)
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>