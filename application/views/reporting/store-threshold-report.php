<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Threshold Report
                </div>
                <?php if ( count ( $stores ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/store-threshold-report' ); ?>" target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Name</th>
                        <th> Threshold</th>
                        <th> Type</th>
                        <th> Total Quantity</th>
                        <th> Issued Quantity</th>
                        <th> Available Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $stores ) > 0 ) {
                            foreach ( $stores as $store ) {
                                $total_quantity = get_store_stock_total_quantity ( $store -> id );
                                $sold_quantity  = get_store_stock_sold_quantity ( $store -> id );
                                $available      = $total_quantity - $sold_quantity;
                                if ( $store -> threshold > $available ) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td> <?php echo $counter++ ?> </td>
                                        <td><?php echo $store -> item ?></td>
                                        <td><?php echo $store -> threshold ?></td>
                                        <td><?php echo ucfirst ( $store -> type ) ?></td>
                                        <td><?php echo $total_quantity > 0 ? $total_quantity : 0; ?></td>
                                        <td><?php echo $sold_quantity > 0 ? $sold_quantity : 0; ?></td>
                                        <td><?php echo $total_quantity - $sold_quantity ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>