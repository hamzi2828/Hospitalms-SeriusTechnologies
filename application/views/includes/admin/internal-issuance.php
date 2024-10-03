<?php if ( !empty( $access ) and in_array ( 'internal-issuance', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( ( $parent_uri == 'internal-issuance' ) and !isset( $_REQUEST[ 'active' ] ) )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fas fa-door-open"></i>
            <span class="title">
						Internal Issuance (Med)
					</span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'issue_internal_medicine', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'issue' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/internal-issuance/issue' ) ?>">
                        Issue Medicine
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'search_internal_issuance', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'search-issuance' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/internal-issuance/search-issuance' ) ?>">
                        Search Issuance
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'all_internal_issuance', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'issuance' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/internal-issuance/issuance' ) ?>">
                        All Issuance
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>