<?php if ( !empty( $access ) and in_array ( 'members', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'user' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-users"></i>
            <span class="title"> Members </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <li class="<?php if ( $child_uri == 'all_members' )
                echo 'active'; ?>">
                <a href="<?php echo base_url ( '/user/index' ) ?>">
                    All Members
                </a>
            </li>
            <li class="<?php if ( $child_uri == 'add_members' )
                echo 'active'; ?>">
                <a href="<?php echo base_url ( '/user/add' ) ?>">
                    Add Member (System Users)
                </a>
            </li>
            <li class="<?php if ( $child_uri == 'add_members_panel' )
                echo 'active'; ?>">
                <a href="<?php echo base_url ( '/user/add-panel' ) ?>">
                    Add Member (Panel)
                </a>
            </li>
        </ul>
    </li>
<?php endif; ?>