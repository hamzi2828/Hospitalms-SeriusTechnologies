<?php if ( !empty( $access ) and in_array ( 'accounts', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'accounts' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-briefcase"></i>
            <span class="title"> Accounts </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'chart_of_accounts', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'chart-of-accounts' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/chart-of-accounts' ) ?>">
                        Chart of Accounts
                    </a>
                </li>
                
                <li class="<?php if ( $child_uri == 'charts-of-accounts' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/charts-of-accounts' ) ?>">
                        Chart of Accounts (Display)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_account_head', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-account-head' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/add-account-head' ) ?>">
                        Add Account Head
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_transactions', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-transactions' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/add-transactions' ) ?>">
                        Add Transactions
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_transactions_panel', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-transactions-panel' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/add-transactions-panel' ) ?>">
                        Add Transactions (Panel)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_transactions_multiple', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-transactions-multiple' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/add-transactions-multiple' ) ?>">
                        Add Transactions (Multiple)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_opening_balance', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-opening-balance' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/add-opening-balance' ) ?>">
                        Add Opening Balances
                    </a>
                </li>
            <?php endif; ?>
            <?php /*if ( !empty( $access ) and in_array ( 'general_ledger', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-ledger' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/accounts/general-ledger' ) ?>">
                                    General Ledger
                                </a>
                            </li>
                        <?php endif;*/ ?>
            <?php if ( !empty( $access ) and in_array ( 'general_ledger', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'general-ledgers' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/general-ledgers' ) ?>">
                        General Ledger (New)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'expanse-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'expanse-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/expanse-report' ) ?>">
                        Expanse Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'search_transactions', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'search-transactions' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/search-transactions' ) ?>">
                        Search Transaction
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'search-transactions-advance', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'search-transactions-advance' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/search-transactions-advance' ) ?>">
                        Search Transaction (Adv)
                    </a>
                </li>
            <?php endif; ?>
            <?php /*if ( !empty( $access ) and in_array ( 'edit-transactions-bulk', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'edit-transactions-bulk' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/edit-transactions-bulk' ) ?>">
                        Edit Transactions
                    </a>
                </li>
            <?php endif; */ ?>
            <?php if ( !empty( $access ) and in_array ( 'supplier_invoices', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'supplier-invoices' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/supplier-invoices' ) ?>">
                        Supplier Invoices
                    </a>
                </li>
            <?php endif; ?>
            <?php /*if ( !empty( $access ) and in_array ( 'trial_balance_sheet_detail', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'trial-balance-detail' and isset( $_GET[ 'detail' ] ) )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/accounts/trial-balance-detail/?detail=true' ) ?>">
                                    Trial Balance Sheet (Detail)
                                </a>
                            </li>
                        <?php endif; */ ?>
            <?php if ( !empty( $access ) and in_array ( 'trial_balance_sheet_detail', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'trial_balance' and !isset( $_GET[ 'detail' ] ) )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/trial_balance' ) ?>">
                        Trial Balance Sheet
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'balance_sheet', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'balance-sheet' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/balance-sheet' ) ?>">
                        Balance Sheet
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'balance_sheet_ii', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'balance-sheets' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/balance-sheets' ) ?>">
                        Balance Sheet (II)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'profit_loss_statement', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'profit-loss-statement' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/profit-loss-statement' ) ?>">
                        Profit and Loss Statement
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'accounts-receivable-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'accounts-receivable' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/accounts-receivable' ) ?>">
                        Accounts Receivable Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'accounts-payable-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'accounts-payable' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/accounts/accounts-payable' ) ?>">
                        Accounts Payable Report
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>
