<?php if ( !empty( $access ) and in_array ( 'store', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'store' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-shopping-cart"></i>
            <span class="title"> Store </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'issue_items', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sale' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/store/sale' ) ?>">
                        Issue Item
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'sold_items', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sales' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/store/sales' ) ?>">
                        All Issued Items
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'edit_issue_items', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'search' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/store/search' ) ?>">
                        Edit Issued Items
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'all_issued_items', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/store/index' ) ?>">
                        All Items
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_store_items', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/store/add' ) ?>">
                        Add Item
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_store_stock', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-stock' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/store/add-stock' ) ?>">
                        Add Stock
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'all_store_stock', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'store-stock' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/store/store-stock' ) ?>">
                        All Stock
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'edit_store_stock', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'edit-stock' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/store/edit-stock' ) ?>">
                        Edit Stock
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'requisition_store', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'requests' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/store/requests' ) ?>">
                        Requisition (Store)
                        <span
                            class="badge badge-roundless badge-important"><?php echo count_store_requisition_requests () ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'requisition_others', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'demands' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/store/demands' ) ?>">
                        Requisitions (Others)
                        <span
                            class="badge badge-roundless badge-important"><?php echo count_requisition_demands_store () ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'store_fix_assets', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'store-fix-assets' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/store/store-fix-assets' ) ?>">
                        All Store (Fix Assets)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_store_fix_assets', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-store-fix-assets' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/store/add-store-fix-assets' ) ?>">
                        Add Store (Fix Assets)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'disposed_store_fix_assets', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'disposed-store-fix-assets' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/store/disposed-store-fix-assets' ) ?>">
                        Disposed Fixed Assets
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>