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
            <i class="fa fa-reorder"></i> Closing  Report
            <?php if (isset($_REQUEST['start_date']) && isset($_REQUEST['end_date'])) : ?>
                <small>(<?php echo date_setter($_REQUEST['start_date']) . ' - ' . date_setter($_REQUEST['end_date']); ?>)</small>
            <?php endif; ?>
        </div>
        <a href="<?php echo base_url('/invoices/closing-report?' . $_SERVER['QUERY_STRING']); ?>" target="_blank" class="pull-right print-btn">Print</a>
    </div>
    
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Payment Method</th>
                    <th>Sale</th>
                    <th>Return/Customer</th>
                    <th>Net</th>
                </tr>
            </thead>
            <tbody>
                <?php
                  
                   $cash_sale = $total_sale_by_cash ?? 0;
                   $card_sale = $total_sale_by_card ?? 0;
                   $bank_sale = $total_sale_by_bank ?? 0;
                   $return_customer = $total_returns ?? 0;

                    // Calculations
                    $net_cash = $cash_sale - $return_customer;
                    $total_sale = $cash_sale + $card_sale + $bank_sale;
                    $total_net = $total_sale - $return_customer;
                ?>
                <tr>
                    <td>Cash</td>
                    <td><?php echo number_format($cash_sale, 2); ?></td>
                    <td><?php echo number_format($return_customer, 2); ?></td>
            
                    <td><?php echo number_format($net_cash, 2); ?></td>
                </tr>
                <tr>
                    <td>Card</td>
                    <td><?php echo number_format($card_sale, 2); ?></td>
                    <td>0.00</td>
                    <td></td>
                    <!-- <td><?php echo number_format($card_sale, 2); ?></td> -->
                </tr>
                <tr>
                    <td>Bank</td>
                    <td><?php echo number_format($bank_sale, 2); ?></td>
                    <td>0.00</td>
                    <td></td>
                    <!-- <td><?php echo number_format($bank_sale, 2); ?></td> -->
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong><?php echo number_format($total_sale, 2); ?></strong></td>
                    <td><strong><?php echo number_format($return_customer, 2); ?></strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <p><strong>Cash in Hand = <?php echo number_format($total_sale, 2); ?> - <?php echo number_format($return_customer, 2); ?> = <?php echo number_format($total_net, 2); ?></strong></p>
    </div>
</div>

        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>