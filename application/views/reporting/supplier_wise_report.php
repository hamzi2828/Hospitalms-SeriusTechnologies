<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-3 col-lg-offset-2">
                    <label for="exampleInputEmail1">Supplier</label>
                    <select name="supplier_id" class="form-control select2me">
                        <option value="0">All</option>
                        <?php
                            if ( count ( $suppliers ) > 0 ) {
                                foreach ( $suppliers as $supplier ) {
                                    ?>
                                    <option value="<?php echo $supplier -> id ?>" <?php echo @$_REQUEST[ 'supplier_id' ] == $supplier -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $supplier -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Supplier Wise Report
                </div>
                <?php if ( count ( $stocks ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/supplier-wise-report?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Supplier</th>
                        <th> Invoice No.</th>
                        <th> Total</th>
                        <th> Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $stocks ) > 0 ) {
                            $counter = 1;
                            $total   = 0;
                            foreach ( $stocks as $stock ) {
                                $invoices = explode ( ',', $stock -> invoices );
                                $total    = $total + $stock -> net_price;
                                ?>
                                <tr>
                                    <td> <?php echo $counter; ?> </td>
                                    <td> <?php echo get_supplier ( $stock -> supplier_id ) -> title ?> </td>
                                    <td>
                                        <?php
                                            if ( count ( $invoices ) > 0 ) {
                                                foreach ( $invoices as $invoice ) {
                                                    echo $invoice . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td> <?php echo number_format ( $stock -> net_price, 2 ) ?> </td>
                                    <td> <?php echo date_setter ( $stock -> date_added ) ?> </td>
                                </tr>
                                <?php
                                $counter++;
                            }
                            ?>
                            <tr>
                                <td colspan="3" align="right">
                                    <strong>Total:</strong>
                                </td>
                                <td><?php echo number_format ( $total, 2 ); ?></td>
                                <td></td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>