<?php if ( !empty( $access ) and in_array ( 'patients', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'patients' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-user"></i>
            <span class="title"> Patients </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'all_patients', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/patients/index' ) ?>">
                        All Patients
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_patient', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/patients/add' ) ?>">
                        Add Patient (Cash)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_patient_panel', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add-panel-patient' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/patients/add-panel-patient' ) ?>">
                        Add Patient (Panel)
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>