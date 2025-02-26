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
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> All Cafe Sales
                </div>
            </div>
           <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Invoice ID </th>    
                        <th> Items</th>
                        <th> Sale Qty</th>
                        <th> Price </th>
                        <th> Total</th>
                        <th> Discount(Flat) </th>
                        <th> Net Total </th>
                        <th> Date </th>
                        <th> Actions</th>
                    </tr>   
                    </thead>

                    <?php
                    // Group sales by invoice_id
                    $grouped_sales = [];
                    foreach ($sales as $sale) {

                        if (!isset($grouped_sales[$sale->invoice_id])) {
                            $grouped_sales[$sale->invoice_id] = [
                                'invoice_id' => $sale->invoice_id,
                                'items' => [],
                                'prices' => [],
                                'net_prices' => [],
                                'sale_qtys' => [],
                                'grand_total_discount' => $sale->grand_total_discount,
                                'grand_total' => $sale->grand_total,
                                'refunded' => $sale->refunded ?? 0,
                                'created_at' => $sale->created_at
                            ];
                        }
                        $product = get_product_by_id($sale->product_id);
                        $grouped_sales[$sale->invoice_id]['items'][] = $product->name;
                        $grouped_sales[$sale->invoice_id]['sale_qtys'][] = $sale->sale_qty;
                        $grouped_sales[$sale->invoice_id]['prices'][] = $sale->price;
                        $grouped_sales[$sale->invoice_id]['net_prices'][] = $sale->net_price;
                    }
                    ?>

                    <tbody>
                        <?php $i = 1; foreach ($grouped_sales as $invoice_id => $group) { ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td>
                                    <?php echo $group['invoice_id']; ?>
                                    <?php if ($group['refunded'] == 1): ?>
                                        <!-- <br> -->
                                        <span class="badge badge-danger">Refunded</span>
                                    <?php endif; ?>
                                </td>

                                <td><?php echo implode('<br>', $group['items']); ?></td>
                                <td><?php echo implode('<br>', $group['sale_qtys']); ?></td>
                                <td><?php echo implode('<br>', $group['prices']); ?></td>
                                <td><?php echo implode('<br>', $group['net_prices']); ?></td>
                                <td><?php echo $group['grand_total_discount']; ?></td>
                                <td>
                                <?php 
                                   
                                    echo $group['grand_total']; 
                                    ?>
                                </td>

                                <td><?php echo $group['created_at']; ?></td>
                                <td class="btn-group-xs">
                                <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'cafe_all_sales_print', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                    <a type="button" class="btn purple"
                                    href="<?php echo base_url('invoices/cafesale-invoice/' . $invoice_id); ?>">Print</a>
                                    <?php endif; ?>

                                    <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'cafe_all_sales_refund', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                    <?php if ($group['refunded'] == null): ?>
                                        <a type="button" class="btn green" onclick="return confirm('Are you sure you want to refund?')"
                                        href="<?php echo base_url('cafe-setting/Refund-sale/' . $invoice_id); ?>">Refund</a>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php $i++; } ?>
                    </tbody>


               
                </table>
            </div>
         </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .input-xsmall {
        width: 100px !important;
    }
</style>




