<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
		<?php if(validation_errors() != false) { ?>
            <div class="alert alert-danger validation-errors">
				<?php echo validation_errors(); ?>
            </div>
		<?php } ?>
		<?php if($this -> session -> flashdata('error')) : ?>
            <div class="alert alert-danger">
				<?php echo $this -> session -> flashdata('error') ?>
            </div>
		<?php endif; ?>
		<?php if($this -> session -> flashdata('response')) : ?>
            <div class="alert alert-success">
				<?php echo $this -> session -> flashdata('response') ?>
            </div>
		<?php endif; ?>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> All Items
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Invoice# </th>
                        <th> Supplier </th>
                        <th> Item </th>
                        <th> Quantity </th>
                        <th> Price </th>
                        <th> Discount </th>
                        <th> Net Price </th>
                        <th> Date Added </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($stocks) > 0) {
                        $counter = 1;
                        foreach ( $stocks as $stock) {
                            $store_items = explode (',', $stock -> store_items);
                            $quantities = explode (',', $stock -> quantities);
                            $prices = explode (',', $stock -> prices);
                            $discounts = explode (',', $stock -> discounts);
                            $net_prices = explode (',', $stock -> net_prices);
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td>
                                    <?php echo $stock -> invoice ?>
                                </td>
                                <td>
                                    <?php echo @get_account_head ( $stock -> supplier_id ) -> title ?>
                                </td>
                                <td>
                                    <?php
                                    if (count ( $store_items) > 0) {
                                        foreach ( $store_items as $store_id) {
                                            $store = get_store_by_id ( $store_id);
                                            echo @$store -> item . '<br/>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (count ( $quantities) > 0) {
                                        foreach ( $quantities as $quantity) {
                                            echo $quantity . '<br/>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (count ( $prices) > 0) {
                                        foreach ( $prices as $price) {
                                            echo number_format ( $price, 2) . '<br/>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (count ( $discounts) > 0) {
                                        foreach ( $discounts as $discount) {
                                            echo number_format ( $discount, 2) . '<br/>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (count ( $net_prices) > 0) {
                                        foreach ( $net_prices as $net_price) {
                                            echo number_format ( $net_price, 2) . '<br/>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo date_setter($stock -> date_added); ?>
                                </td>
                                <td>
                                    <a class="btn btn-xs purple" target="_blank" href="<?php echo base_url ( '/invoices/store-stock-invoice?invoice=' . $stock -> invoice ) ?>">
                                        Print
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>