<?php if ( !empty( $access ) and in_array ( 'opd', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'OPD' or $parent_uri == 'settings' and !isset( $_REQUEST[ 'settings' ] ) )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-opera" aria-hidden="true"></i>
            <span class="title"> OPD </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'all_opd_services', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'opd-services' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/opd-services' ) ?>">
                        All Services
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'sale_opd_services', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sale' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/OPD/sale' ) ?>">
                        Sale Services
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'sale_opd_invoices', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sales' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/OPD/sales' ) ?>">
                        Sale Invoices (Cash)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'panel_sale_opd_invoices', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'panel_sales' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/OPD/panel_sales' ) ?>">
                        Sale Invoices (Panel)
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>