<?php if ( !empty( $access ) and in_array ( 'nursing_station', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'vitals' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-stethoscope" aria-hidden="true"></i>
            <span class="title"> Nursing Station </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'vitals', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/vitals/index' ) ?>">
                        All Vitals
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_vitals', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/vitals/add' ) ?>">
                        Add Patient Vitals
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>