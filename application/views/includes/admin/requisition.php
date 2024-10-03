<?php if ( !empty( $access ) and in_array ( 'requisition', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'requisition' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-first-order" aria-hidden="true"></i>
            <span class="title"> Requisitions </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'all_requisitions', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/requisition/index' ) ?>">
                        All Requisitions (Store)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_store_requisitions', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/requisition/add' ) ?>">
                        Add Requisitions (Store)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'demand_requisitions', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'requisition-demands' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/requisition/requisition-demands' ) ?>">
                        All Requisitions (Other)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_other_requisitions', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'demands' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/requisition/demands' ) ?>">
                        Add Requisitions (Other)
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>