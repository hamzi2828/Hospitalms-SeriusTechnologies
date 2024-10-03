<?php $access = get_user_access ( get_logged_in_user_id () ); ?>
<!-- BEGIN PAGE CONTENT-->
<style>
    .tab-content {
        padding : 0 !important;
    }
    
    .tabbable-custom > .nav-tabs {
        border        : 1px solid #e3e3e3;
        border-bottom : 0;
    }
    
    .tabbable-custom .nav-tabs > li {
        margin-right  : 0;
        border-bottom : 1px solid #e3e3e3;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <?php if ( $patient -> panel_id > 0 ) : $panel = get_panel_by_id ( $patient -> panel_id ); ?>
            <div class="alert alert-info">
                <strong>Note!</strong> Patient is a panel customer.
                <strong>(<?php echo $panel -> name ?>)</strong>
            </div>
        <?php endif; ?>
        <?php if ( validation_errors () != false ) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors (); ?>
            </div>
        <?php } ?>
        <?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata ( 'error' ) ?>
            </div>
        <?php endif; ?>
        <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
        <?php endif; ?>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <?php if ( !if_consultant_added ( $sale -> sale_id ) ) : ?>
            <div class="alert alert-danger">
                Please add atleast one consultant in Consultant Commission tab.
                <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=consultants' ) ?>">
                    Consultant Commissioning
                </a>
            </div>
        <?php endif; ?>
        <?php
            $current_tab     = @$_REQUEST[ 'tab' ];
            $user_department = get_logged_in_user_department_id ();
        ?>
        <div class="tabbable-custom ">
            <ul class="nav nav-tabs ">
                <?php /* <li class="<?php if(!isset($current_tab) or $current_tab == 'general') echo 'active' ?>">
                    <a href="<?php echo base_url('/IPD/edit-sale/?sale_id='.$sale -> sale_id.'&tab=general') ?>" <?php if($user_department == pharmacy_dept) echo 'onclick="return false;"' ?>>
						<?php if($user_department == pharmacy_dept) echo '<i class="fa fa-lock"></i>' ?> General
                    </a>
                </li> */ ?>
                <?php if ( !empty( $access ) and in_array ( 'ipd_admission_slip', explode ( ',', $access -> access ) ) ) : ?>
                    <li class="<?php if ( !isset( $current_tab ) or $current_tab == 'admission-slip' )
                        echo 'active' ?>">
                        <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=admission-slip' ) ?>" <?php if ( $user_department == pharmacy_dept )
                            echo 'onclick="return false;"' ?>>
                            <?php if ( $user_department == pharmacy_dept )
                                echo '<i class="fa fa-lock"></i>' ?> Admission Slip
                        </a>
                    </li>
                <?php endif ?>
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'ipd-general' )
                    echo 'active' ?>">
                    <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=ipd-general' ) ?>">
                        General </a>
                </li>
                <?php if ( !empty( $access ) and in_array ( 'ipd_tab_services', explode ( ',', $access -> access ) ) ) : ?>
                    <li class="<?php if ( isset( $current_tab ) and $current_tab == 'ipd-services' )
                        echo 'active' ?>">
                        <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=ipd-services' ) ?>" <?php if ( $user_department == pharmacy_dept )
                            echo 'onclick="return false;"' ?>>
                            <?php if ( $user_department == pharmacy_dept )
                                echo '<i class="fa fa-lock"></i>' ?> IPD Services (Included)
                        </a>
                    </li>
                <?php endif ?>
                <?php if ( !empty( $access ) and in_array ( 'ipd_tab_services', explode ( ',', $access -> access ) ) && $patient -> panel_id > 0 ) : ?>
                    <li class="<?php if ( isset( $current_tab ) and $current_tab == 'ipd-services-excluded' )
                        echo 'active' ?>">
                        <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=ipd-services-excluded' ) ?>" <?php if ( $user_department == pharmacy_dept )
                            echo 'onclick="return false;"' ?>>
                            <?php if ( $user_department == pharmacy_dept )
                                echo '<i class="fa fa-lock"></i>' ?> IPD Services (Excluded)
                        </a>
                    </li>
                <?php endif ?>
                <?php if ( !empty( $access ) and in_array ( 'ipd_lab_tests', explode ( ',', $access -> access ) ) ) : ?>
                    <li class="<?php if ( isset( $current_tab ) and $current_tab == 'lab-tests' )
                        echo 'active' ?>">
                        <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=lab-tests' ) ?>" <?php if ( $user_department == pharmacy_dept )
                            echo 'onclick="return false;"' ?>>
                            <?php if ( $user_department == pharmacy_dept )
                                echo '<i class="fa fa-lock"></i>' ?> Lab Tests
                        </a>
                    </li>
                <?php endif ?>
                <?php if ( !empty( $access ) and in_array ( 'ipd_generate_requisitions', explode ( ',', $access -> access ) ) ) : ?>
                    <li class="<?php if ( isset( $current_tab ) and $current_tab == 'requisition' )
                        echo 'active' ?>">
                        <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=requisition' ) ?>">
                            Generate Requisition
                        </a>
                    </li>
                <?php endif ?>
                <?php if ( !empty( $access ) and in_array ( 'ipd_medications', explode ( ',', $access -> access ) ) ) : ?>
                    <li class="<?php if ( isset( $current_tab ) and $current_tab == 'medication' )
                        echo 'active' ?>">
                        <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=medication' ) ?>">
                            Medication
                        </a>
                    </li>
                <?php endif ?>
                <?php if ( !empty( $access ) and in_array ( 'consultants', explode ( ',', $access -> access ) ) ) : ?>
                    <li class="<?php if ( isset( $current_tab ) and $current_tab == 'consultants' )
                        echo 'active' ?>">
                        <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=consultants' ) ?>">
                            Consultant Commissioning
                        </a>
                    </li>
                <?php endif ?>
                <?php if ( !empty( $access ) and in_array ( 'anesthesia-charges', explode ( ',', $access -> access ) ) ) : ?>
                    <li class="<?php if ( isset( $current_tab ) and $current_tab == 'anesthesia-charges' )
                        echo 'active' ?>">
                        <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=anesthesia-charges' ) ?>">
                            Anesthesia Commissioning
                        </a>
                    </li>
                <?php endif ?>
                <?php if ( !empty( $access ) and in_array ( 'ipd_billing', explode ( ',', $access -> access ) ) ) : ?>
                    <li class="<?php if ( isset( $current_tab ) and $current_tab == 'billing' )
                        echo 'active' ?>">
                        <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=billing' ) ?>" <?php if ( $user_department == pharmacy_dept )
                            echo 'onclick="return false;"' ?>>
                            <?php if ( $user_department == pharmacy_dept )
                                echo '<i class="fa fa-lock"></i>' ?> Billing
                        </a>
                    </li>
                <?php endif ?>
                <?php if ( !empty( $access ) and in_array ( 'ipd_add_payment', explode ( ',', $access -> access ) ) ) : ?>
                    <li class="<?php if ( isset( $current_tab ) and $current_tab == 'payments' )
                        echo 'active' ?>">
                        <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=payments' ) ?>" <?php if ( $user_department == pharmacy_dept )
                            echo 'onclick="return false;"' ?>>
                            <?php if ( $user_department == pharmacy_dept )
                                echo '<i class="fa fa-lock"></i>' ?> Add Payment
                        </a>
                    </li>
                <?php endif ?>
                <?php if ( !empty( $access ) and in_array ( 'ipd_discharge_date', explode ( ',', $access -> access ) ) ) : ?>
                    <li class="<?php if ( isset( $current_tab ) and $current_tab == 'discharge-date' )
                        echo 'active' ?>">
                        <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=discharge-date' ) ?>" <?php if ( $user_department == pharmacy_dept )
                            echo 'onclick="return false;"' ?>>
                            <?php if ( $user_department == pharmacy_dept )
                                echo '<i class="fa fa-lock"></i>' ?> Discharge Date
                        </a>
                    </li>
                <?php endif ?>
                <?php if ( !empty( $access ) and in_array ( 'ipd_ot_timings', explode ( ',', $access -> access ) ) ) : ?>
                    <li class="<?php if ( isset( $current_tab ) and $current_tab == 'ot-timings' )
                        echo 'active' ?>">
                        <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=ot-timings' ) ?>">
                            OT Timings
                        </a>
                    </li>
                <?php endif ?>
            </ul>
            <div class="tab-content">
                <?php if ( !isset( $current_tab ) or $current_tab == 'admission-slip' )
                    require_once ( 'admission-slip.php' ) ?>
                <?php if ( isset( $current_tab ) and $current_tab == 'ipd-general' )
                    require_once ( 'general-info.php' ) ?>
                <?php if ( isset( $current_tab ) and $current_tab == 'ipd-services' )
                    require_once ( 'ipd-services.php' ) ?>
                <?php if ( isset( $current_tab ) and $current_tab == 'ipd-services-excluded' )
                    require_once ( 'ipd-services-excluded.php' ) ?>
                <?php //if(!isset($current_tab) or $current_tab == 'lab-tests') require_once('opd-services.php') ?>
                <?php if ( isset( $current_tab ) and $current_tab == 'lab-tests' )
                    require_once ( 'lab-tests.php' ) ?>
                <?php if ( isset( $current_tab ) and $current_tab == 'requisition' )
                    require_once ( 'requisition.php' ) ?>
                <?php if ( isset( $current_tab ) and $current_tab == 'medication' )
                    require_once ( 'medication.php' ) ?>
                <?php if ( isset( $current_tab ) and $current_tab == 'billing' )
                    require_once ( 'billing.php' ) ?>
                <?php if ( isset( $current_tab ) and $current_tab == 'consultants' )
                    require_once ( 'consultants.php' ) ?>
                <?php if ( isset( $current_tab ) and $current_tab == 'anesthesia-charges' )
                    require_once ( 'anesthesia-charges.php' ) ?>
                <?php if ( isset( $current_tab ) and $current_tab == 'payments' )
                    require_once ( 'payments.php' ) ?>
                <?php if ( isset( $current_tab ) and $current_tab == 'discharge-date' )
                    require_once ( 'discharge-date.php' ) ?>
                <?php if ( isset( $current_tab ) and $current_tab == 'ot-timings' )
                    require_once ( 'ot-timings.php' ) ?>
            </div>
        </div>
    </div>
    <?php if ( $sale -> discharged == '1' ) : ?>
        <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&action=update-billing' ) ?>"
           style="    position: fixed; top: 75px; right: 20px; z-index: 999;"
           class="btn btn-warning">
            Update GL Billing
        </a>
    <?php endif; ?>
</div>