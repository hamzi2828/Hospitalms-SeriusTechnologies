<?php if ( !empty( $access ) and in_array ( 'lab_settings', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'settings' and @$_REQUEST[ 'settings' ] == 'lab' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-cog"></i>
            <span class="title"> Lab Settings </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'locations', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'locations' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/locations?settings=lab' ) ?>">
                        All Locations
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_locations', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-location' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-location?settings=lab' ) ?>">
                        Add Location
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'units', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'units' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/units?settings=lab' ) ?>">
                        All Units
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_units', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-unit' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-unit?settings=lab' ) ?>">
                        Add Units
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'sections', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sections' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/sections?settings=lab' ) ?>">
                        All Sections
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_sections', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-section' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-section?settings=lab' ) ?>">
                        Add Sections
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'test_tube_colors', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'test-tube-colors' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/test-tube-colors?settings=lab' ) ?>">
                        All Test Tube Colors
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_test_tube_colors', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-test-tube-colors' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-test-tube-colors?settings=lab' ) ?>">
                        Add Test Tube Colors
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'samples', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'samples' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/samples?settings=lab' ) ?>">
                        All Specimen
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_samples', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-sample' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-sample?settings=lab' ) ?>">
                        Add Specimen
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'destinations', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'destinations' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/destinations?settings=lab' ) ?>">
                        All Destinations
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-destinations', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-destinations' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-destinations?settings=lab' ) ?>">
                        Add Destinations
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'airlines', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'airlines' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/airlines?settings=lab' ) ?>">
                        All Airlines
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-airlines', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-airlines' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-airlines?settings=lab' ) ?>">
                        Add Airlines
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php /* if ( !empty( $access ) and in_array ( 'specimen', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'specimen' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/specimen?settings=lab' ) ?>">
                                    All Specimen
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_specimen', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-specimen' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-specimen?settings=lab' ) ?>">
                                    Add Specimen
                                </a>
                            </li>
                        <?php endif; */ ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'remarks', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'remarks' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/remarks?settings=lab' ) ?>">
                        All Remarks
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_remarks', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-remarks' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-remarks?settings=lab' ) ?>">
                        Add Remarks
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'packages', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'packages' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/packages?settings=lab' ) ?>">
                        All Packages
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-packages', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-packages' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/settings/add-packages?settings=lab' ) ?>">
                        Add Packages
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>