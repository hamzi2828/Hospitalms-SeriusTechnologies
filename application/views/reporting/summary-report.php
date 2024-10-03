<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-2 col-lg-offset-3">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-block btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Summary Report
                    <?php if ( isset( $_REQUEST[ 'start_date' ] ) and $_REQUEST[ 'end_date' ] ) : ?>
                        <small>(<?php echo date_setter ( @$_REQUEST[ 'start_date' ] ) . ' - ' . date_setter ( @$_REQUEST[ 'end_date' ] ) ?>
                               )</small>
                    <?php endif; ?>
                </div>
                <a href="<?php echo base_url ( '/invoices/summary-report?' . $_SERVER[ 'QUERY_STRING' ] ); ?>" target="_blank"
                   class="pull-right print-btn">Print</a>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Total Pharmacy Sale</th>
                        <th> Total Discount <small>(Includes flat & percentage discount)</small></th>
                        <th> Total Sale Return</th>
                        <th> Net Sale</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $total_pharmacy = 0;
                        $total_return   = 0;
                    ?>
                    <tr>
                        <?php if ( $pharmacy_sales and !empty( $pharmacy_sales ) ) : ?>
                            <td>
                                <?php
                                    $total_pharmacy = $pharmacy_sales + $pharmacy_discount;
                                    echo number_format ( @$total_pharmacy, 2 )
                                ?>
                            </td>
                        <?php endif; ?>
                        <?php if ( $pharmacy_discount and !empty( $pharmacy_discount ) ) : ?>
                            <td>
                                <?php echo number_format ( $pharmacy_discount, 2 ) ?>
                            </td>
                        <?php endif; ?>
                        <?php if ( $return_sales and !empty( $return_sales ) ) : ?>
                            <td>
                                <?php
                                    $total_return = @$return_sales;
                                    echo number_format ( @$return_sales, 2 )
                                ?>
                            </td>
                        <?php else : $total_return = 0; ?>
                            <td>
                                <?php
                                    echo number_format ( $total_return, 2 )
                                ?>
                            </td>
                        <?php endif; ?>
                        <?php if ( $pharmacy_sales and !empty( $pharmacy_sales ) ) : ?>
                            <td>
                                <?php
                                    $net_sale = $pharmacy_sales - $total_return;
                                    echo number_format ( $net_sale, 2 )
                                ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>