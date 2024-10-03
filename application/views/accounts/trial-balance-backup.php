<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form method="get" autocomplete="off">
                <div class="form-group col-lg-offset-3 col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="date date-picker form-control" placeholder="Start date"
                           required="required"
                           value="<?php echo ( @$_REQUEST[ 'start_date' ] ) ? @$_REQUEST[ 'start_date' ] : date ( 'm/d/Y' ) ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="date date-picker form-control" placeholder="End date"
                           required="required"
                           value="<?php echo ( @$_REQUEST[ 'end_date' ] ) ? @$_REQUEST[ 'end_date' ] : date ( 'm/d/Y' ) ?>">
                </div>
                <div class="col-lg-1" style="padding-top: 25px">
                    <button type="submit" class="btn btn-block btn-primary">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Trial Balance Sheet
                    <?php
                        $start_date = @$_REQUEST[ 'start_date' ];
                        $end_date   = @$_REQUEST[ 'end_date' ];
                        if ( isset( $start_date ) and !empty( $start_date ) and isset( $end_date ) and !empty( $end_date ) ) {
                            ?>
                            (
                            <small><?php echo date ( 'jS F Y', strtotime ( $start_date ) ) . ' to ' . date ( 'jS F Y', strtotime ( $end_date ) ) ?></small>)
                            <?php
                        }
                    ?>
                </div>
                <?php if ( count ( $account_heads ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/trial-balance-sheet?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       class="pull-right print-btn" target="_blank">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Account Head</th>
                        <th> Opening Balance</th>
                        <th> Debit</th>
                        <th> Credit</th>
                        <th> Running Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter    = 1;
                        $net_debit  = 0;
                        $net_credit = 0;
                        if ( count ( $account_heads ) > 0 ) {
                            foreach ( $account_heads as $account_head ) {
                                
                                $acc_head_id = $account_head -> id;
                                
                                if ( isset( $start_date ) and !empty( trim ( $start_date ) ) )
                                    $opening_balance = get_opening_balance_previous_than_searched_start_date ( $start_date, $acc_head_id );
                                else
                                    $opening_balance = 0;
                                
                                $transaction = calculate_acc_head_transaction ( $acc_head_id );
                                
                                $net_credit     = $net_credit + $transaction -> credit;
                                $net_debit      = $net_debit + $transaction -> debit;
                                $runningBalance = $transaction -> debit - $transaction -> credit;
                                
                                if ( isset( $_GET[ 'detail' ] ) and $_GET[ 'detail' ] == 'true' ) {
                                    ?>
                                    <tr>
                                        <td> <?php echo $counter ++ ?> </td>
                                        <td> <?php echo $account_head -> title ?> </td>
                                        <td> <?php echo number_format ( $opening_balance, 2 ) ?> </td>
                                        <td> <?php echo number_format ( $transaction -> credit, 2 ) ?> </td>
                                        <td> <?php echo number_format ( $transaction -> debit, 2 ) ?> </td>
                                        <td> <?php echo number_format ( $runningBalance, 2 ) ?> </td>
                                    </tr>
                                    <?php
                                }
                                else if ( !isset( $_GET[ 'detail' ] ) and ( $runningBalance > 0 or $runningBalance < 0 ) ) {
                                    ?>
                                    <tr>
                                        <td> <?php echo $counter ++ ?> </td>
                                        <td> <?php echo $account_head -> title ?> </td>
                                        <td> <?php echo number_format ( $opening_balance, 2 ) ?> </td>
                                        <td> <?php echo number_format ( $transaction -> credit, 2 ) ?> </td>
                                        <td> <?php echo number_format ( $transaction -> debit, 2 ) ?> </td>
                                        <td> <?php echo number_format ( $runningBalance, 2 ) ?> </td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td><strong> <?php echo number_format ( $net_credit, 2 ) ?> </strong></td>
                        <td><strong> <?php echo number_format ( $net_debit, 2 ) ?> </strong></td>
                        <td><?php echo number_format ( $net_credit - $net_debit, 2 ) ?></td>
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

    .opening td {
        background-color: rgba(0, 255, 0, 0.3) !important;
    }
</style>
