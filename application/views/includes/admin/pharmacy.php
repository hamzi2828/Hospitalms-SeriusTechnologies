<?php if ( !empty( $access ) and in_array ( 'pharmacy', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( ( $parent_uri == 'medicines' or $parent_uri == 'stock-return' ) and !isset( $_REQUEST[ 'active' ] ) )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-medkit"></i>
            <span class="title">
						Pharmacy
					</span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'sale_medicine', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sale' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/sale' ) ?>" oncontextmenu="return false;">
                        Sale Medicine
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'pharmacy_sale_invoices', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sales' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/sales' ) ?>">
                        Sale Invoices
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'edit_medicine_sale', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'edit-sale' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/edit-sale' ) ?>">
                        Edit Sale
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'return_customer_invoices', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'return-customer-invoices' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/return-customer-invoices' ) ?>">
                        All Return Customer Invoices
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'return_customer', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'return-customer' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/return-customer' ) ?>">
                        Add Return Customer
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'edit_return_customer', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'edit-return-customer' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/edit-return-customer' ) ?>">
                        Edit Return Customer
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'local_purchases', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'local-purchases' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/local-purchases' ) ?>">
                        All Local Purchase
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_local_purchases', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'local-purchase' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/local-purchase' ) ?>">
                        Add Local Purchase
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'edit_local_purchases', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'edit-local-purchase' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/edit-local-purchase' ) ?>">
                        Edit Local Purchase
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'medicines', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/index' ) ?>">
                        All Medicines
                        <span class="badge badge-roundless badge-important">
								<?php echo count_medicines (); ?>
							</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'medicines-export', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'medicines' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/medicines' ) ?>">
                        All Medicines (Export)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_medicines_stock', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-medicines-stock' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/add-medicines-stock' ) ?>">
                        Add Medicines Stock
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'edit_medicines_stock', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'return-stock' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/return-stock' ) ?>">
                        Edit Medicine Stock
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'search-medicine-supplier-invoice', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'search-medicine-supplier-invoice' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/search-medicine-supplier-invoice' ) ?>">
                        Search Supplier Invoice
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'all_medicine_stock_returns', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'stock-returns' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/stock-return/stock-returns' ) ?>">
                        All Returns (Supplier)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_medicine_stock_returns', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-stock-returns' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/stock-return/add-stock-returns' ) ?>">
                        Add Stock Return (Supplier)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'ipd_requisitions', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'ipd-requisitions' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/ipd-requisitions' ) ?>">
                        IPD Requisitions
                        <span class="badge badge-roundless badge-important">
								<?php echo count_new_ipd_requisitions (); ?>
							</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'adjustments', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'adjustments' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/adjustments' ) ?>">
                        All Adjustments (Decrease)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_adjustments', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-adjustments' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/add-adjustments' ) ?>">
                        Add Adjustments (Decrease)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'expired_medicine_report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'expired-medicine-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/expired-medicine-report' ) ?>">
                        Expired Medicines
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'discarded_expired_medicines', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'discarded-expired-medicines' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/medicines/discarded-expired-medicines' ) ?>">
                        Discarded Expired Medicines
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>