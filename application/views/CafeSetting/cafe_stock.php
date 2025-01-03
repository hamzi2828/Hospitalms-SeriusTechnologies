<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Cafe Stock List
                </div>
            </div>
            <div class="portlet-body" style="overflow-y: auto">
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
                <table class="table table-striped table-bordered table-hover">
        <thead>
                <tr>
                <th>Sr. No</th>
                <th>Supplier</th>
                <th>Product</th>
                <th>Invoice</th>
                <th>Stock No</th>
                <!-- <th>Expiry</th> -->
                <!-- <th>Quantity (Units)</th> -->
                <th>TP/Box</th>
                <th>Pack Size</th>
                <th>TP/Unit</th>
                <th>Sale/Box</th>
                <th>Sale/Unit</th>
                <th>Discount</th>
                <th>Net Prices</th>
                <th> Total Quantity</th>
                <th> Date Added</th>
                <th> Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            if (count($stocks) > 0) {
                foreach ($stocks as $stock) {
                    $supplier = get_supplier($stock->supplier_id);
                    $product = get_product_by_id($stock->product_id); 
                    $total_quantity = get_stock_total_quantity($stock->id);
                    $sold_quantity = get_stock_sold_quantity($stock->id);
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $counter++ ?></td>
                        <td><?php echo @$supplier->title ?></td>
                        <td><?php echo $product->name; ?></td> 
                        <td><?php echo $stock->invoice ?></td>
                        <td><?php echo $stock->stock_no ?></td> 
                        <!-- <td><?php echo date_setter($stock->expiry) ?></td> -->
                        <!-- <td><?php echo $stock->quantity ?></td> -->
                        <td><?php echo $stock->tp_box ?></td>
                        <td><?php echo $stock->pack_size ?></td>
                        <td><?php echo $stock->tp_unit ?></td> 
                        <td><?php echo $stock->sale_box ?></td>
                        <td><?php echo $stock->sale_unit ?></td>
                        <td><?php echo $stock->discount ? number_format($stock->discount, 2) : '0.00' ?></td>
                        <td><?php echo $stock->net_price ?></td>
                        <td><?php echo get_product_total_quantity_by_id($stock->product_id) ?></td> 
                        <td><?php echo date_setter($stock->date_added); ?></td>
                        <td class="btn-group-xs">
                            <?php if ($sold_quantity < 1) : ?>
                                <a type="button" class="btn red" 
                                href="<?php echo base_url('cafe-setting/delete-stock/' . $stock->id) ?>" 
                                onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                            <?php endif; ?>
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