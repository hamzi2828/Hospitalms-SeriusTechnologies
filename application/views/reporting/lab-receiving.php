<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Previous Invoices Balance Receiving Report
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                        <th> Received By</th>
                        <th> Received Amount</th>
                        <th> Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        $totalReceivedAmount = 0;
                        if ( count ( $receivings ) > 0 ) {
                            foreach ( $receivings as $receive ) {
                                $totalReceivedAmount = $totalReceivedAmount + $receive -> amount;
                                $received_by = get_user ( $receive -> user_id );
                                ?>
                                <tr>
                                    <td> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $receive -> sale_id ?> </td>
                                    <td> <?php echo $received_by -> name ?> </td>
                                    <td>
                                        <?php echo number_format ( $receive -> amount, 2 ) ?>
                                    </td>
                                    <td> <?php echo date_setter ( $receive -> created_at ) ?> </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="3" class="text-right"></td>
                                <td colspan="2">
                                    <b><?php echo number_format ( $totalReceivedAmount, 2 ) ?></b>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>