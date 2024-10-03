<?php if ( !empty( $access ) and in_array ( 'store-reporting', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'StoreReporting' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-search"></i>
            <span class="title"> Store Reporting </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'store-stock-valuation-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'stock-valuation' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/StoreReporting/stock-valuation' ) ?>">
                        Stock Valuation Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'store_general_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/StoreReporting/general-report' ) ?>">
                        Issuance Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'store-threshold-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'threshold-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/StoreReporting/threshold-report' ) ?>">
                        Threshold Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'store-purchase-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'purchase-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/StoreReporting/purchase-report' ) ?>">
                        Purchase Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'store-fix-assets-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'fix-assets-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/StoreReporting/fix-assets-report' ) ?>">
                        Fix Assets Register
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>