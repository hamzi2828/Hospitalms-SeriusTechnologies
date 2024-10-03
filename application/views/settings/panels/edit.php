<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
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
        <div class="tabbable-custom">
            <ul class="nav nav-tabs">
                <li class="<?php echo $this -> input -> get ( 'tab' ) == 'general' ? 'active' : '' ?>">
                    <a href="<?php echo base_url ( '/settings/edit-panel/' . $panel -> id . '?settings=general&tab=general' ) ?>">
                        General
                    </a>
                </li>
                <li class="<?php echo $this -> input -> get ( 'tab' ) == 'ipd' ? 'active' : '' ?>">
                    <a href="<?php echo base_url ( '/settings/edit-panel/' . $panel -> id . '?settings=general&tab=ipd' ) ?>">
                        IPD Services
                    </a>
                </li>
                <li class="<?php echo $this -> input -> get ( 'tab' ) == 'opd' ? 'active' : '' ?>">
                    <a href="<?php echo base_url ( '/settings/edit-panel/' . $panel -> id . '?settings=general&tab=opd' ) ?>">
                        OPD Services
                    </a>
                </li>
                <li class="<?php echo $this -> input -> get ( 'tab' ) == 'consultancy' ? 'active' : '' ?>">
                    <a href="<?php echo base_url ( '/settings/edit-panel/' . $panel -> id . '?settings=general&tab=consultancy' ) ?>">
                        Consultancy Doctors
                    </a>
                </li>
                <li class="<?php echo $this -> input -> get ( 'tab' ) == 'lab' ? 'active' : '' ?>">
                    <a href="<?php echo base_url ( '/settings/edit-panel/' . $panel -> id . '?settings=general&tab=lab' ) ?>">
                        Lab Tests
                    </a>
                </li>
            </ul>
            <div class="tab-content" style="padding-bottom: 0;">
                <div class="tab-pane active">
                    <?php
                        if ( $this -> input -> get ( 'tab' ) == 'general' )
                            include 'general.php';
                        
                        if ( $this -> input -> get ( 'tab' ) == 'ipd' )
                            include 'ipd-services.php';
                        
                        if ( $this -> input -> get ( 'tab' ) == 'opd' )
                            include 'opd-services.php';
                        
                        if ( $this -> input -> get ( 'tab' ) == 'consultancy' )
                            include 'consultancy-doctors.php';
                        
                        if ( $this -> input -> get ( 'tab' ) == 'lab' )
                            include 'lab-tests.php';
                    ?>
                </div>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .counter {
        width           : 20px;
        height          : 20px;
        border          : 1px solid #000;
        border-radius   : 50% !important;
        display         : flex;
        justify-content : center;
        align-items     : center;
        margin-bottom   : 5px;
        font-size       : 10px;
    }
</style>