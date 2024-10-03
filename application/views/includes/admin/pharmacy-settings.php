<?php if ( !empty( $access ) and in_array ( 'pharmacy_settings', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( ( $parent_uri == 'settings' and @$_REQUEST[ 'settings' ] == 'pharmacy' ) or ( $parent_uri == 'medicines' and @$_REQUEST[ 'settings' ] == 'pharmacy' ) )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-cog"></i>
            <span class="title"> Pharmacy Settings </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'add_medicines', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/add?active=false&settings=pharmacy' ) ?>">
                        Add Medicines
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'generics', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'generic' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/generic?settings=pharmacy' ) ?>">
                        Generics
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'add_generics', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-generic' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-generic?settings=pharmacy' ) ?>">
                        Add Generic
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'strength', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'strength' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/strength?settings=pharmacy' ) ?>">
                        Strength
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_strength', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-strength' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-strength?settings=pharmacy' ) ?>">
                        Add Strength
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'forms', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'form' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/forms?settings=pharmacy' ) ?>">
                        Forms
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_forms', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-form' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-form?settings=pharmacy' ) ?>">
                        Add Form
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'manufacturers', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'manufacturers' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/manufacturers?settings=pharmacy' ) ?>">
                        Manufacturers
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_manufacturers', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-manufacturers' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-manufacturers?settings=pharmacy' ) ?>">
                        Add Manufacturer
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'pack_size', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'pack-sizes' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/pack-sizes?settings=pharmacy' ) ?>">
                        Pack Sizes
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_pack_size', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-pack-size' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-pack-size?settings=pharmacy' ) ?>">
                        Add Pack Size
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>