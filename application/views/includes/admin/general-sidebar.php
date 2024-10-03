<?php
    $parent_uri    = $this -> uri -> segment ( 1 );
    $child_uri     = $this -> uri -> segment ( 2 );
    $sub_child_uri = $this -> uri -> segment ( 3 );
    $access        = get_user_access ( get_logged_in_user_id () );
?>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" id="nav">
            
            <li class="sidebar-toggler-wrapper margin-bottom-10">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler hidden-phone">
                </div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            
            <?php
                require_once 'dashboard.php';
                require_once 'stats-dashboard.php';
                require_once 'metrics-analysis.php';
                require_once 'patients.php';
                require_once 'consultancy.php';
                require_once 'consultancy-reporting.php';
                require_once 'doctor-prescriptions.php';
                require_once 'prescriptions-follow-ups.php';
                require_once 'nursing-station.php';
                require_once 'doctor-settings.php';
                require_once 'radiology.php';
                require_once 'radiology-reporting.php';
                require_once 'radiology-settings.php';
                require_once 'culture-histopathology.php';
                require_once 'culture-histopathology-reporting.php';
                require_once 'culture-histopathology-settings.php';
                require_once 'opd.php';
                require_once 'opd-reporting.php';
                require_once 'ipd.php';
                require_once 'ipd-reporting.php';
                require_once 'ipd-settings.php';
                require_once 'internal-issuance.php';
                require_once 'internal-issuance-medicines-settings.php';
                require_once 'internal-issuance-medicines-reporting.php';
                require_once 'pharmacy.php';
                require_once 'pharmacy-reporting.php';
                require_once 'pharmacy-settings.php';
                require_once 'lab.php';
                require_once 'lab-reporting.php';
                require_once 'lab-settings.php';
                require_once 'general-settings.php';
                require_once 'general-reporting.php';
                require_once 'accounts.php';
                require_once 'account-settings.php';
                require_once 'purchase-orders.php';
                require_once 'store.php';
                require_once 'store-reporting.php';
                require_once 'store-settings.php';
                require_once 'facility-manager.php';
                require_once 'requisition.php';
                require_once 'hr.php';
                require_once 'hr-settings.php';
                require_once 'loan.php';
                require_once 'complains.php';
                require_once 'members.php';
                require_once 'member-settings.php';
                require_once 'birth-certificates.php';
                require_once 'death-certificates.php';
            ?>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <?php echo ucwords ( str_replace ( '-', ' ', $this -> uri -> segment ( 1 ) ) ) ?>
                    <small><?php echo site_name ?></small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo base_url ( '/dashboard' ) ?>">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <?php echo ucwords ( str_replace ( '-', ' ', $this -> uri -> segment ( 1 ) ) ) ?>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <?php echo ucwords ( str_replace ( '-', ' ', $this -> uri -> segment ( 2 ) ) ) ?>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <?php echo ucwords ( str_replace ( '-', ' ', $this -> uri -> segment ( 3 ) ) ) ?>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
