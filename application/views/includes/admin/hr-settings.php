<?php if ( !empty( $access ) and in_array ( 'hr-settings', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'hr-settings' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-cogs"></i>
            <span class="title"> HR Settings </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'hr-posts', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'posts' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/hr-settings/posts' ) ?>">
                        All Posts
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'add-hr-posts', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-post' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/hr-settings/add-post' ) ?>">
                        Add Post
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>