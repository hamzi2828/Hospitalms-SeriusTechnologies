<?php if ( !empty( $access ) and in_array ( 'doctor_settings', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'doctors' or $parent_uri == 'specialization' or $parent_uri == 'instructions' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-user-md" aria-hidden="true"></i>
            <span class="title"> Doctor Settings </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'all_doctors', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/doctors/index' ) ?>">
                        All Doctors
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_doctors', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/doctors/add' ) ?>">
                        Add Doctor
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'all_specializations', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'specializations' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/specialization/specializations' ) ?>">
                        All Specializations
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_specializations', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-specialization' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/specialization/add-specialization' ) ?>">
                        Add Specialization
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'all_follow_ups', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'follow-up' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/doctors/follow-up' ) ?>">
                        All Follow Ups
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_follow_up', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-follow-up' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/doctors/add-follow-up' ) ?>">
                        Add Follow Up
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'medicine_rx', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/instructions/index' ) ?>">
                        Medicines R<sub>x</sub>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_medicine_rx', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/instructions/add' ) ?>">
                        Add Medicine R<sub>x</sub>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>