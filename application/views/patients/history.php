<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
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
        <?php $current_tab = @$_REQUEST[ 'tab' ];
            $id            = $this -> uri -> segment ( 3 ) ?>
        <div class="tabbable-custom ">
            <ul class="nav nav-tabs ">
                <li class="<?php if ( !isset( $current_tab ) or $current_tab == 'vitals' ) echo 'active' ?>">
                    <a href="<?php echo base_url ( '/patients/history/' . $id . '?tab=vitals' ) ?>">Vitals</a>
                </li>
                
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'consultancies' ) echo 'active' ?>">
                    <a href="<?php echo base_url ( '/patients/history/' . $id . '?tab=consultancies' ) ?>">Consultancies</a>
                </li>
                
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'services' ) echo 'active' ?>">
                    <a href="<?php echo base_url ( '/patients/history/' . $id . '?tab=services' ) ?>">OPD Services</a>
                </li>
                
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'ipd-services' ) echo 'active' ?>">
                    <a href="<?php echo base_url ( '/patients/history/' . $id . '?tab=ipd-services' ) ?>">IPD Services</a>
                </li>
                
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'medicines' ) echo 'active' ?>">
                    <a href="<?php echo base_url ( '/patients/history/' . $id . '?tab=medicines' ) ?>">Pharmacy Medication</a>
                </li>
                
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'ipd-medicines' ) echo 'active' ?>">
                    <a href="<?php echo base_url ( '/patients/history/' . $id . '?tab=ipd-medicines' ) ?>">IPD Medication</a>
                </li>
                
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'lab-tests' ) echo 'active' ?>">
                    <a href="<?php echo base_url ( '/patients/history/' . $id . '?tab=lab-tests' ) ?>">Lab Tests</a>
                </li>
                
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'ipd-lab-tests' ) echo 'active' ?>">
                    <a href="<?php echo base_url ( '/patients/history/' . $id . '?tab=ipd-lab-tests' ) ?>">IPD Lab Tests</a>
                </li>
                
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'ipd' ) echo 'active' ?>">
                    <a href="<?php echo base_url ( '/patients/history/' . $id . '?tab=ipd' ) ?>">IPD</a>
                </li>
                
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'files' ) echo 'active' ?>">
                    <a href="<?php echo base_url ( '/patients/history/' . $id . '?tab=files' ) ?>">Previous History Files</a>
                </li>
            </ul>
            <div class="tab-content">
                <?php require_once ( 'history/vitals.php' ) ?>
                <?php require_once ( 'history/consultancies.php' ) ?>
                <?php require_once ( 'history/services.php' ) ?>
                <?php require_once ( 'history/ipd-services.php' ) ?>
                <?php require_once ( 'history/medicines.php' ) ?>
                <?php require_once ( 'history/ipd-medicines.php' ) ?>
                <?php require_once ( 'history/lab-tests.php' ) ?>
                <?php require_once ( 'history/ipd-lab-tests.php' ) ?>
                <?php require_once ( 'history/ipd.php' ) ?>
                <?php require_once ( 'history/files.php' ) ?>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>