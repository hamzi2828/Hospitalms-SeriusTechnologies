<?php if ( !empty( $access ) and in_array ( 'store-settings', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'settings' and @$_REQUEST[ 'settings' ] == 'store-settings' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <span class="title"> Store Settings </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'store_par_levels', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'par-levels' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/par-levels?settings=store-settings' ) ?>">
                        All Par Levels
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_store_par_levels', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-par-levels' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-par-levels?settings=store-settings' ) ?>">
                        Add Par Level
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>