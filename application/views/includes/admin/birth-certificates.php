<?php if ( !empty( $access ) and in_array ( 'birth-certificates', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'birth-certificates' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-address-card"></i>
            <span class="title"> Birth Certificates </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'all-birth-certificates', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/birth-certificates/index' ) ?>">
                        All Certificates
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-birth-certificates', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/birth-certificates/add' ) ?>">
                        Add Certificates
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>