<?php if ( !empty( $access ) and in_array ( 'ipd', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'IPD' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-italic"></i>
            <span class="title"> IPD </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'ipd_register_patient', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sale' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/IPD/sale' ) ?>">
                        Admin. & Discharge
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'ipd_invoice', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sales' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/IPD/sales' ) ?>">
                        Sale Invoices (Cash)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'ipd_invoice_panel', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'panel-sales' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/IPD/panel-sales' ) ?>">
                        Sale Invoices (Panel)
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'ipd_discharged_patient', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'discharged' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/IPD/discharged' ) ?>">
                        Discharged Patients
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'ipd_mo', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'mo' )
                    echo 'active'; ?>">
                    <a href="javascript:void(0);" style="<?php if ( $child_uri == 'mo' )
                        echo 'background: #e02222 !important;'; ?>">
                        <i class="fas fa-user-md"></i>
                        <span class="title"> MO </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'ipd_mo_add_admissions', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'add-admission-order' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'IPD/mo/add-admission-order' ) ?>">
                                    Add Admission Orders
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'ipd_mo_admissions', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'mo-admission-orders' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'IPD/mo/mo-admission-orders' ) ?>">
                                    All Admission Orders
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'physical_examination', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'add-physical-examination' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'IPD/mo/add-physical-examination' ) ?>">
                                    Add Physical Examination
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all_physical_examination', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'all-physical-examination' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'IPD/mo/all-physical-examination' ) ?>">
                                    All Physical Examinations
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'add_progress_notes', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'add-progress-notes' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'IPD/mo/add-progress-notes' ) ?>">
                                    Add Progress Notes
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all_progress_notes', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'all-progress-notes' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'IPD/mo/all-progress-notes' ) ?>">
                                    All Progress Notes
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'add_diagnostic_flow_sheet', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'add-diagnostic-flow-sheet' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'IPD/mo/add-diagnostic-flow-sheet' ) ?>">
                                    Add Diagnostics
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all_diagnostic_flow_sheet', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'all-diagnostic-flow-sheet' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'IPD/mo/all-diagnostic-flow-sheet' ) ?>">
                                    All Diagnostics
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'add_blood_transfusion', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'add-blood-transfusion' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'IPD/mo/add-blood-transfusion' ) ?>">
                                    Add Blood Transfusion
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all_blood_transfusion', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'all-blood-transfusions' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'IPD/mo/all-blood-transfusions' ) ?>">
                                    All Blood Transfusions
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'add_discharge_slip', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'add-discharge-slip' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'IPD/mo/add-discharge-slip' ) ?>">
                                    Add Discharge Slip
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all_discharge_slips', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'all-discharge-slips' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'IPD/mo/all-discharge-slips' ) ?>">
                                    All Discharge Slips
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'add_discharge_summary', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'add-discharge-summary' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'IPD/mo/add-discharge-summary' ) ?>">
                                    Add Discharge Summary
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all_discharge_summary', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'all-discharge-summary' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'IPD/mo/all-discharge-summary' ) ?>">
                                    All Discharge Summary
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>