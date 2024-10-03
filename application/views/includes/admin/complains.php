<?php if ( !empty( $access ) and in_array ( 'complains', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'complaints' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-bug"></i>
            <span class="title"> Complaints </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'all_complains', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/complaints/index' ) ?>">
                        All Complaints
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_complains', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/complaints/add' ) ?>">
                        Add Complaints
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>