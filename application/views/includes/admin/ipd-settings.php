<?php if ( !empty( $access ) and in_array ( 'ipd-settings', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'settings' and @$_REQUEST[ 'settings' ] == 'ipd' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-cog"></i>
            <span class="title"> IPD - OPD Settings </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'ipd_services', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'ipd-services' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/ipd-services?settings=ipd' ) ?>">
                        All Services
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_ipd_services', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-ipd-services' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-ipd-services?settings=ipd' ) ?>">
                        Add Services
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'ipd_packages', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'ipd-packages' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/ipd-packages?settings=ipd' ) ?>">
                        All Packages
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_ipd_packages', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-ipd-packages' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-ipd-packages?settings=ipd' ) ?>">
                        Add Packages
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'rooms', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'rooms' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/rooms?settings=ipd' ) ?>">
                        All Rooms/Beds
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-room', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-room' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-room?settings=ipd' ) ?>">
                        Add Rooms/Beds
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>