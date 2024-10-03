<?php if ( !empty( $access ) and in_array ( 'member-settings', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'settings' and @$_REQUEST[ 'settings' ] == 'member-settings' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <span class="title"> Department Settings </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'all_departments', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'departments' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/departments?settings=member-settings' ) ?>">
                        All Departments
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_departments', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-departments' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-departments?settings=member-settings' ) ?>">
                        Add Departments
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>