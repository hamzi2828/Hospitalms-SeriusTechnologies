<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Item</label>
                    <select name="item-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $stores ) > 0 ) {
                                foreach ( $stores as $storeItem ) {
                                    ?>
                                    <option value="<?php echo $storeItem -> id ?>" <?php echo ( isset( $_REQUEST[ 'item-id' ] ) and !empty( $_REQUEST[ 'item-id' ] ) and $_REQUEST[ 'item-id' ] == $storeItem -> id ) ? 'selected="selected"' : ''; ?>>
                                        <?php echo $storeItem -> item ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn-block btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Purchase Report
                </div>
                <?php if ( count ( $stocks ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/purchase-report?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body" style="overflow: auto;">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Invoice</th>
                        <th> Item</th>
                        <th> Quantity</th>
                        <th> Price</th>
                        <th> Net Price</th>
                        <th> Total Amount</th>
                        <th> Date Added</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $net_total = 0;
                        if ( count ( $stocks ) > 0 ) {
                            $counter = 1;
                            foreach ( $stocks as $stock ) {
                                $store_items = explode ( ',', $stock -> store_items );
                                $quantities  = explode ( ',', $stock -> quantities );
                                $prices      = explode ( ',', $stock -> prices );
                                $discounts   = explode ( ',', $stock -> discounts );
                                $net_prices  = explode ( ',', $stock -> net_prices );
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td>
                                        <?php echo $stock -> invoice ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $store_items ) > 0 ) {
                                                foreach ( $store_items as $store_id ) {
                                                    $store = get_store_by_id ( $store_id );
                                                    echo @$store -> item . '<br/>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $quantities ) > 0 ) {
                                                foreach ( $quantities as $quantity ) {
                                                    echo $quantity . '<br/>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $prices ) > 0 ) {
                                                foreach ( $prices as $price ) {
                                                    echo number_format ( $price, 2 ) . '<br/>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $net_prices ) > 0 ) {
                                                foreach ( $net_prices as $net_price ) {
                                                    echo number_format ( $net_price, 2 ) . '<br/>';
                                                    $net_total = $net_total + $net_price;
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $net = 0;
                                            if ( count ( $net_prices ) > 0 ) {
                                                foreach ( $net_prices as $net_price ) {
                                                    $net = $net + $net_price;
                                                }
                                                echo number_format ( $net, 2 );
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo date_setter ( $stock -> date_added ); ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6"></td>
                        <td><strong><?php echo number_format ( $net_total, 2 ) ?></strong></td>
                        <td></td>
                    </tr>
                    </tfoot>
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
