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




<li class="<?php if ($parent_uri == 'cafe-setting') echo 'start active'; ?>">
    <a href="javascript:void(0);">
        <i class="fa fa-coffee"></i>
        <span class="title"> Cafe Setting </span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">

    <?php if (!empty($access) and !in_array('all-sale', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'all-sale') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/all-sale') ?>">
                    All Sale
                </a>
            </li>
        <?php endif; ?>

        <?php if (!empty($access) and !in_array('add-sale', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'add-sale') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/add-sale') ?>">
                    Add Sale
                </a>
            </li>
        <?php endif; ?>



        <?php if (!empty($access) and !in_array('all-stock', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'all-stock') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/all-stock') ?>">
                    All Stock
                </a>
            </li>
        <?php endif; ?>
        <?php if (!empty($access) and !in_array('add-stock', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'add-stock') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/add-stock') ?>">
                    Add Stock
                </a>
            </li>
        <?php endif; ?>







        <?php if (!empty($access) and !in_array('all-products', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'all-products') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/all-products') ?>">
                    All Products
                </a>
            </li>
        <?php endif; ?>
        <?php if (!empty($access) and !in_array('add-product', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'add-product') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/add-product') ?>">
                    Add Product
                </a>
            </li>
        <?php endif; ?>






        <?php if (!empty($access) and !in_array('all-category', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'all-category') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/all-category') ?>">
                    All Category
                </a>
            </li>
        <?php endif; ?>
        <?php if (!empty($access) and !in_array('add-category', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'add-category') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/add-category') ?>">
                    Add Category
                </a>
            </li>
        <?php endif; ?>



        
        <?php if (!empty($access) and !in_array('all-ingredients', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'all-ingredients') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/all-ingredients') ?>">
                    All Ingredients
                </a>
            </li>
        <?php endif; ?>
        <?php if (!empty($access) and !in_array('add-ingredients', explode(',', $access->access))) : ?>
            <li class="<?php if ($child_uri == 'add-ingredients') echo 'active'; ?>">
                <a href="<?php echo base_url('/cafe-setting/add-ingredients') ?>">
                    Add Ingredients
                </a>
            </li>
        <?php endif; ?>





    </ul>
</li>
