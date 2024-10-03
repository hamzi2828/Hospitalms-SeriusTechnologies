<style>
    .counter {
        position: absolute;
        left: -10px;
        font-size: 16px;
        font-weight: 800;
        top: -1px;
        color: #000000;
    }

    .inner-tabs {
        width: 100%;
        float: left;
    }

    .inner-tabs ul {
        list-style-type: none;
        padding: 0;
        float: left;
        width: 100%;
        border-bottom: 1px solid #e3e3e3;
    }

    .inner-tabs li {
        text-decoration: none;
        display: inline-block;
        margin-right: 2px;
        border-top: 2px solid transparent;
        float: left;
        margin-bottom: -1px;
        position: relative;
        padding: 10px 15px;
    }

    .inner-tabs li.active {
        border-top: 3px solid #d12610;
        margin-top: 0;
        position: relative;
        border-left: 1px solid #e3e3e3;
        border-right: 1px solid #e3e3e3;
    }
</style>
<div class="inner-tabs">
    <ul>
        <li <?php if ( ( $_REQUEST[ 'tab' ] == 'ipd-services-excluded' and !isset( $_REQUEST[ 'inner-tab' ] ) ) or ( $_REQUEST[ 'tab' ] == 'ipd-services-excluded' and @$_REQUEST[ 'inner-tab' ] == 'add' ) )
            echo 'class="active"' ?>>
            <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $_REQUEST[ 'sale_id' ] . '&tab=ipd-services-excluded&inner-tab=add' ) ?>">
                Add Services
            </a>
        </li>
        <li <?php if ( $_REQUEST[ 'tab' ] == 'ipd-services-excluded' and @$_REQUEST[ 'inner-tab' ] == 'view' )
            echo 'class="active"' ?>>
            <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $_REQUEST[ 'sale_id' ] . '&tab=ipd-services-excluded&inner-tab=view' ) ?>">
                View Services
            </a>
        </li>
    </ul>
</div>
<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'ipd-services-excluded' )
    echo 'active' ?>">
    <?php
        if ( ( $_REQUEST[ 'tab' ] == 'ipd-services-excluded' and !isset( $_REQUEST[ 'inner-tab' ] ) ) or ( $_REQUEST[ 'tab' ] == 'ipd-services-excluded' and @$_REQUEST[ 'inner-tab' ] == 'add' ) )
            require_once 'ipd-add-services.php';
        
        if ( $_REQUEST[ 'tab' ] == 'ipd-services-excluded' and @$_REQUEST[ 'inner-tab' ] == 'view' )
            require_once 'ipd-view-services.php';
    ?>
</div>
