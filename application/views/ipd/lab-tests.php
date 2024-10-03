<style>
    .counter {
        position: absolute;
        left: -10px;
        font-size: 16px;
        font-weight: 800;
        top: 31px;
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
        <li <?php if ( ( $_REQUEST[ 'tab' ] == 'lab-tests' and !isset( $_REQUEST[ 'inner-tab' ] ) ) or ( $_REQUEST[ 'tab' ] == 'lab-tests' and @$_REQUEST[ 'inner-tab' ] == 'add' ) ) echo 'class="active"' ?>>
            <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $_REQUEST[ 'sale_id' ] . '&tab=lab-tests&inner-tab=add' ) ?>">
                Add Lab Tests
            </a>
        </li>
        <li <?php if ( $_REQUEST[ 'tab' ] == 'lab-tests' and @$_REQUEST[ 'inner-tab' ] == 'view' ) echo 'class="active"' ?>>
            <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $_REQUEST[ 'sale_id' ] . '&tab=lab-tests&inner-tab=view' ) ?>">
                View Lab Tests
            </a>
        </li>
    </ul>
</div>
<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'lab-tests' ) echo 'active' ?>">
    <?php
        if ( ( $_REQUEST[ 'tab' ] == 'lab-tests' and !isset( $_REQUEST[ 'inner-tab' ] ) ) or ( $_REQUEST[ 'tab' ] == 'lab-tests' and @$_REQUEST[ 'inner-tab' ] == 'add' ) )
            require_once 'add-lab-tests.php';
        
        if ( $_REQUEST[ 'tab' ] == 'lab-tests' and @$_REQUEST[ 'inner-tab' ] == 'view' )
            require_once 'view-lab-tests.php';
    ?>
</div>