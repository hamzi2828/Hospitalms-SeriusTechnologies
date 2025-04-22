<?php if ( !empty( $access ) and in_array ( 'death-certificates', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'death-certificates' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-address-card"></i>
            <span class="title"> Death Certificates </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'all-death-certificates', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/death-certificates/index' ) ?>">
                        All Certificates
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add-death-certificates', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/death-certificates/add' ) ?>">
                        Add Certificates
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>

<?php if (!empty($access) and in_array('vaccinations-module-sidebar', explode(',', $access->access))) : ?>
    <!--$parent_uri ==  main menue red highlight  depedn upon it   -->
<li class="<?php if ($parent_uri == 'vaccination-setting') echo 'start active'; ?>">
    <a href="javascript:void(0);">
        <i class="fa fa-medkit"></i>
        <span class="title"> Vaccination </span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">

        <?php if (!empty($access) and in_array('all-vaccinations', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'all-vaccinations') echo 'active'; ?>">
                <a href="<?php echo base_url('/vaccination-setting/all-vaccinations') ?>">
                    All Vaccinations
                </a>
            </li>
        <?php endif; ?>

        <?php if (!empty($access) and in_array('add-vaccinations', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'add-vaccinations') echo 'active'; ?>">
                <a href="<?php echo base_url('/vaccination-setting/add-vaccination') ?>">
                    Add Vaccination
                </a>
            </li>
        <?php endif; ?>

        </ul>
</li>

<?php endif; ?>

<?php if (!empty($access) && in_array('blood-bank-module-sidebar', explode(',', $access->access))) : ?>
    <?php
    // Open the menu if any blood-related route is active
    $is_blood_section_open = (
        $parent_uri == 'blood-bank-module' ||
        strpos($child_uri, 'blood') !== false ||
        in_array($child_uri, [
            'all-blood-inventory', 'add-blood', 'all-issues', 'issue-blood',
            'blood-status', 'all-x-match-reports', 'add-x-match-report',
            'issuance-report', 'summary-report'
        ])
    );
    ?>
    <li class="<?php echo $is_blood_section_open ? 'start active' : ''; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-tint"></i>
            <span class="title"> Blood Bank </span>
            <span class="arrow <?php echo $is_blood_section_open ? 'open' : ''; ?>"></span>
        </a>
        <ul class="sub-menu">
            <?php if (in_array('all-blood-inventory', explode(',', $access->access))) : ?>
                <li class="<?php if ($child_uri == 'all-blood-inventory') echo 'active'; ?>">
                    <a href="<?php echo base_url('/blood-bank/all-blood-inventory') ?>">
                        All Blood Inventory
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array('add-blood', explode(',', $access->access))) : ?>
                <li class="<?php if ($child_uri == 'add-blood') echo 'active'; ?>">
                    <a href="<?php echo base_url('/blood-bank/add-blood') ?>">
                        Add Blood
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array('all-issues', explode(',', $access->access))) : ?>
                <li class="<?php if ($child_uri == 'all-issues') echo 'active'; ?>">
                    <a href="<?php echo base_url('/blood-bank/all-issues') ?>">
                        All Issuance
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array('issue-blood', explode(',', $access->access))) : ?>
                <li class="<?php if ($child_uri == 'issue-blood') echo 'active'; ?>">
                    <a href="<?php echo base_url('/blood-bank/issue-blood') ?>">
                        Issue Blood
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array('blood-status', explode(',', $access->access))) : ?>
                <li class="<?php if ($child_uri == 'blood-status') echo 'active'; ?>">
                    <a href="<?php echo base_url('/blood-bank/blood-status') ?>">
                        Blood Status
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array('all-x-match-reports', explode(',', $access->access))) : ?>
                <li class="<?php if ($child_uri == 'all-x-match-reports') echo 'active'; ?>">
                    <a href="<?php echo base_url('/blood-bank/all-x-match-reports') ?>">
                        All X-Match Reports
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array('add-x-match-report', explode(',', $access->access))) : ?>
                <li class="<?php if ($child_uri == 'add-x-match-report') echo 'active'; ?>">
                    <a href="<?php echo base_url('/blood-bank/add-x-match-report') ?>">
                        Add X-Match Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array('issuance-report', explode(',', $access->access))) : ?>
                <li class="<?php if ($child_uri == 'issuance-report') echo 'active'; ?>">
                    <a href="<?php echo base_url('/blood-bank/issuance-report') ?>">
                        Issuance Report
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array('summary-report', explode(',', $access->access))) : ?>
                <li class="<?php if ($child_uri == 'summary-report') echo 'active'; ?>">
                    <a href="<?php echo base_url('/blood-bank/summary-report') ?>">
                        Summary Report
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>


<?php if (!empty($access) and in_array('cafe-module-sidebar', explode(',', $access->access))) : ?>

    <li class="<?php if ($parent_uri == 'cafe-module' || strpos($child_uri, 'cafe') !== false || 
    strpos($child_uri, 'sale') !== false || strpos($child_uri, 'stock') !== false || 
    strpos($child_uri, 'product') !== false || strpos($child_uri, 'category') !== false || 
    strpos($child_uri, 'ingredients') !== false) echo 'start active'; ?>">
    <a href="javascript:void(0);">
        <i class="fa fa-coffee"></i>
        <span class="title"> Cafe Module </span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">

         <?php if (!empty($access) and in_array('all-sale', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'all-sale') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/all-sale') ?>">
                    All Sales
                </a>
            </li>
        <?php endif; ?>

        <?php if (!empty($access) and in_array('add-sale', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'add-sale') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/add-sale') ?>">
                    Add Sale
                </a>
            </li>
        <?php endif; ?>



        <?php if (!empty($access) and in_array('all-stock', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'all-stock') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/all-stock') ?>">
                    All Stocks
                </a>
            </li>
        <?php endif; ?>
        <?php if (!empty($access) and in_array('add-stock', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'add-stock') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/add-stock') ?>">
                    Add Stock
                </a>
            </li>
        <?php endif; ?>






        <?php if (!empty($access) and in_array('all-products', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'all-products') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/all-products') ?>">
                    All Products
                </a>
            </li>
        <?php endif; ?>
        <?php if (!empty($access) and in_array('add-product', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'add-product') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/add-product') ?>">
                    Add Product
                </a>
            </li>
        <?php endif; ?>






        <?php if (!empty($access) and in_array('all-category', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'all-category') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/all-category') ?>">
                    All Category
                </a>
            </li>
        <?php endif; ?>
        <?php if (!empty($access) and in_array('add-category', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'add-category') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/add-category') ?>">
                    Add Category
                </a>
            </li>
        <?php endif; ?>



        
        <?php if (!empty($access) and in_array('all-ingredients', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'all-ingredients') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/all-ingredients') ?>">
                    All Ingredients
                </a>
            </li>
        <?php endif; ?>
        <?php if (!empty($access) and in_array('add-ingredients', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'add-ingredients') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/add-ingredients') ?>">
                    Add Ingredients
                </a>
            </li>
        <?php endif; ?>


        <?php if (!empty($access) and in_array('general-sale-report', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'general-sale-report') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/general-sale-report') ?>">
                    General Report (Sales)
                </a>
            </li>
        <?php endif; ?>

        <?php if (!empty($access) and in_array('stock-valuation-report', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'stock-valuation-report') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/stock-valuation-report') ?>">
                    Stock Valuation Report
                </a>
            </li>
        <?php endif; ?>

</li>

<?php endif; ?>


