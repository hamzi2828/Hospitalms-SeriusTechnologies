<?php if ( !empty( $access ) and in_array ( 'facility-manager', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'FacilityManager' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-male"></i>
            <span class="title"> Facility Manager </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'facility_manager_store_requisition', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'requests' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/FacilityManager/requests' ) ?>">
                        Requisitions (Store)
                        <span
                                class="badge badge-roundless badge-important"><?php echo count_requests_facility_manager () ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'facility_manager_other_requisition', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'demands' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/FacilityManager/demands' ) ?>">
                        Requisitions (Others)
                        <span
                                class="badge badge-roundless badge-important"><?php echo count_requisition_demands () ?></span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>