<?php if ( !empty( $access ) and in_array ( 'consultancy', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'consultancy' and $child_uri != 'prescriptions' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-handshake-o" aria-hidden="true"></i>
            <span class="title"> Consultancy </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'cash_consultancies', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/consultancy/index' ) ?>">
                        Sale Invoices (Cash)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'panel_consultancies', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'panel-consultancy-invoices' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/consultancy/panel-consultancy-invoices' ) ?>">
                        Sale Invoices (Panel)
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'add_consultancies', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/consultancy/add' ) ?>">
                        Add Consultancy
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'pay-consultant', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'pay-consultant' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/consultancy/pay-consultant' ) ?>">
                        Pay Consultant
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>