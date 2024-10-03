<?php if ( !empty( $access ) and in_array ( 'purchase_orders', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'purchase-order' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-shopping-cart"></i>
            <span class="title"> Purchase Orders </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'all_purchase_orders', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/purchase-order/index' ) ?>">
                        All P/O (Medicine)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'add_purchase_orders', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' and isset( $_GET[ 'supplier-list' ] ) and $_GET[ 'supplier-list' ] == 'false' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/purchase-order/add/?supplier-list=false' ) ?>">
                        Add P/O (Medicine)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'add_purchase_orders', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' and isset( $_GET[ 'supplier-list' ] ) and $_GET[ 'supplier-list' ] == 'true' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/purchase-order/add/?supplier-list=true' ) ?>">
                        Add P/O (Supplier Wise)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'all_store_purchase_orders', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/purchase-order/store-purchase-orders' ) ?>">
                        All P/O (Store)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'add_store_purchase_orders', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-store-purchase-order' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/purchase-order/add-store-purchase-order/' ) ?>">
                        Add P/O (Store)
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>