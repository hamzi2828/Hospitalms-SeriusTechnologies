<?php if ( !empty( $access ) and in_array ( 'loan', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'loan' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-money" aria-hidden="true"></i>
            <span class="title"> Loans </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'all_loans', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/loan/index' ) ?>">
                        All Loans
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_loan', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/loan/add' ) ?>">
                        Add Loan
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'paid_loans', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'paid' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/loan/paid' ) ?>">
                        All Paid Loans
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'pay_loan', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'pay' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/loan/pay' ) ?>">
                        Pay Loan
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>