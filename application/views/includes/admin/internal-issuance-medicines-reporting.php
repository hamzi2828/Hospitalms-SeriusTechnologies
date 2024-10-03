<?php if ( !empty( $access ) and in_array ( 'internal-issuance-medicines-reporting', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'reporting' and $child_uri == 'internal-issuance-medicines-general-report' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <span class="title"> Internal Issuance Reporting </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'internal-issuance-medicines-general-report', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'internal-issuance-medicines-general-report' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/reporting/internal-issuance-medicines-general-report?active=false' ) ?>">
                        General Report
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>