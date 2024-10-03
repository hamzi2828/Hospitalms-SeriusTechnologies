<?php if ( !empty( $access ) and in_array ( 'general_settings', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'settings' and @$_REQUEST[ 'settings' ] == 'general' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-cog"></i>
            <span class="title"> General Settings </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'companies', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'companies' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/companies?settings=general' ) ?>">
                        Companies
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_companies', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-companies' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-companies?settings=general' ) ?>">
                        Add Company
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'panels', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'panels' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/panels?settings=general' ) ?>">
                        Panels
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_panels', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-panel' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-panel?settings=general' ) ?>">
                        Add Panel
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'member_types', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'members' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/members?settings=general' ) ?>">
                        Member Types
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_member_types', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-members' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-members?settings=general' ) ?>">
                        Add Member Type
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'cities', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'cities' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/cities?settings=general' ) ?>">
                        All Cities
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_city', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-city' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-city?settings=general' ) ?>">
                        Add City
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'references', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'references' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/references?settings=general' ) ?>">
                        All References
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-references', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-references' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-references?settings=general' ) ?>">
                        Add References
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'online-references', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'online-references' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/online-references?settings=general' ) ?>">
                        All Online Referral Portals
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-online-references', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-online-references' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-online-references?settings=general' ) ?>">
                        Add Online Referral Portals
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'site_settings', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'site-settings' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/site-settings?settings=general' ) ?>">
                        Site Settings
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>