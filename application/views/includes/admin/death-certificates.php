<?php if ( !empty( $access ) and in_array ( 'death-certificates', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'death-certificates' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-address-card"></i>
            <span class="title"> Death Certificates </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'all-death-certificates', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/death-certificates/index' ) ?>">
                        All Certificates
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-death-certificates', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/death-certificates/add' ) ?>">
                        Add Certificates
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>