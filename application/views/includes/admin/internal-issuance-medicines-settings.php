<?php if ( !empty( $access ) and in_array ( 'internal-issuance-medicines-settings', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'settings' and @$_REQUEST[ 'settings' ] == 'internal-issuance-medicines-settings' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <span class="title"> Internal Issuance (Med) Settings </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'internal_issuance_par_levels', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'internal-issuance-medicines-par-levels' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/internal-issuance-medicines-par-levels?settings=internal-issuance-medicines-settings' ) ?>">
                        All Par Levels
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_internal_issuance_par_levels', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-internal-issuance-medicines-par-levels' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-internal-issuance-medicines-par-levels?settings=internal-issuance-medicines-settings' ) ?>">
                        Add Par Level
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>