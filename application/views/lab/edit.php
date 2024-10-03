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
        <?php
            $current_tab = @$_REQUEST[ 'tab' ];
            if ( isset( $_REQUEST[ 'test-id' ] ) and is_numeric ( $_REQUEST[ 'test-id' ] ) )
                $test = get_test_by_id ( $_REQUEST[ 'test-id' ] );
        ?>
        <div class="tabbable-custom ">
            <ul class="nav nav-tabs ">
                <li class="<?php if ( !isset( $current_tab ) or $current_tab == 'general' )
                    echo 'active' ?>">
                    <a href="<?php echo base_url ( '/lab/edit?tab=general&test-id=' . $test_id ) ?>">General</a>
                </li>
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'detail' )
                    echo 'active' ?>">
                    <a href="<?php echo base_url ( '/lab/edit?tab=detail&test-id=' . $test_id ) ?>">Detail</a>
                </li>
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'range' and $_GET[ 'machine' ] == 'default' )
                    echo 'active' ?>">
                    <a href="<?php echo base_url ( '/lab/edit?tab=range&machine=default&test-id=' . $test_id ) ?>">Reference Ranges (Default)</a>
                </li>
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'range' and $_GET[ 'machine' ] == 'machine-1' )
                    echo 'active' ?>">
                    <a href="<?php echo base_url ( '/lab/edit?tab=range&machine=machine-1&test-id=' . $test_id ) ?>">Reference Ranges (Machine 1)</a>
                </li>
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'range' and $_GET[ 'machine' ] == 'machine-2' )
                    echo 'active' ?>">
                    <a href="<?php echo base_url ( '/lab/edit?tab=range&machine=machine-2&test-id=' . $test_id ) ?>">Reference Ranges (Machine 2)</a>
                </li>
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'accounts' )
                    echo 'active' ?>">
                    <a href="<?php echo base_url ( '/lab/edit?tab=accounts&test-id=' . $test_id . '&airline-id=' . $airlines[ 0 ] -> id ) ?>">Accounts</a>
                </li>
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'locations' )
                    echo 'active' ?>">
                    <a href="<?php echo base_url ( '/lab/edit?tab=locations&test-id=' . $test_id ) ?>">Locations</a>
                </li>
                <li class="<?php if ( isset( $current_tab ) and $current_tab == 'regents' )
                    echo 'active' ?>">
                    <a href="<?php echo base_url ( '/lab/edit?tab=regents&test-id=' . $test_id ) ?>">Regents</a>
                </li>
            </ul>
            <div class="tab-content">
                <?php require_once ( 'edit/general-info.php' ) ?>
                <?php require_once ( 'edit/test-detail.php' ) ?>
                <?php require_once ( 'edit/reference-range.php' ) ?>
                <?php
                    if ( $general_info -> category == 'covid' )
                        require_once ( 'edit/accounts-covid.php' );
                    else
                        require_once ( 'edit/accounts.php' );
                ?>
                <?php require_once ( 'edit/locations.php' ) ?>
                <?php require_once ( 'edit/regents.php' ) ?>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>