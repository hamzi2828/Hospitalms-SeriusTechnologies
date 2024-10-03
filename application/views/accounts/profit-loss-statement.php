<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form method="get" autocomplete="off">
                <div class="form-group col-lg-offset-3 col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="financial-year form-control" placeholder="Start date"
                           required="required" data-date-format="dd-mm-yyyy"
                           value="<?php
                               echo ( @$_REQUEST[ 'start_date' ] ) ? @$_REQUEST[ 'start_date' ] : date ( 'd-m-Y' ) ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="financial-year form-control" placeholder="End date"
                           required="required" data-date-format="dd-mm-yyyy"
                           value="<?php
                               echo ( @$_REQUEST[ 'end_date' ] ) ? @$_REQUEST[ 'end_date' ] : date ( 'd-m-Y' ) ?>">
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
                    <i class="fa fa-globe"></i> Profit Loss Statement
                    <?php
                        $start_date = $this -> input -> get ( 'start_date' );
                        $end_date   = $this -> input -> get ( 'end_date' );
                        if ( isset( $start_date ) and !empty( $start_date ) and isset( $end_date ) and !empty( $end_date ) ) {
                            ?>
                            (
                            <small><?php
                                    echo date ( 'jS F Y', strtotime ( $start_date ) ) . ' to ' . date ( 'jS F Y', strtotime ( $end_date ) ) ?></small>)
                            <?php
                        }
                    ?>
                </div>
                <?php if ( isset( $start_date ) and !empty( $start_date ) and isset( $end_date ) and !empty( $end_date ) ) : ?>
                    <a href="<?php
                        echo base_url ( '/invoices/profit-loss-statement?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                    
                    <a href="javascript:void(0)" onclick="downloadExcel()" style="margin-right: 10px"
                       class="pull-right print-btn">Download Excel</a>
                <?php endif; ?>
            </div>
            <?php if ( isset( $start_date ) and !empty( $start_date ) and isset( $end_date ) and !empty( $end_date ) ) : ?>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="excel-table">
                        <thead>
                        <tr>
                            <th align="left"> Account Head</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        <?php
                            include_once APPPATH . 'views/invoices/pnl-sales.php';
                            include_once APPPATH . 'views/invoices/pnl-sales-refunded.php';
                            include_once APPPATH . 'views/invoices/pnl-returns-allowances.php';
                            include_once APPPATH . 'views/invoices/pnl-fee-discount.php';
                        ?>
                        
                        <tr>
                            <td>
                                <!--                                <strong>Sales - Net - Returns and Allowances</strong>-->
                                <strong>Net Sale</strong>
                            </td>
                            <td>
                                <strong>
                                    <?php
                                        $sales_net = abs ( $sales_debit ) - abs ( $allowances_credit ) - abs ( $fee_discounts_credit ) - abs ( $sales_credit );
                                        echo @number_format ( abs ( $sales_net ), 2 ) ?>
                                </strong>
                            </td>
                        </tr>
                        
                        <?php
                            include_once APPPATH . 'views/invoices/pnl-direct-costs.php' ?>
                        
                        <tr>
                            <td>
                                <strong>Gross Profit / (Loss)</strong>
                            </td>
                            <td>
                                <strong>
                                    <?php
                                        $direct_cost_net = $sales_net - $direct_cost_credit;
                                        echo @number_format ( $direct_cost_net, 2 );
                                    ?>
                                </strong>
                            </td>
                        </tr>
                        
                        <?php
                            include_once APPPATH . 'views/invoices/pnl-general-admin-expenses.php' ?>
                        
                        <tr>
                            <td>
                                <?php
                                    $finance_cost_debit = 0;
                                    $acc_head_id        = $Finance_Cost_account_head -> id;
                                    $transaction        = calculate_acc_head_transaction ( $acc_head_id );
                                    $finance_cost_debit = $finance_cost_debit + $transaction -> credit;
                                    echo $Finance_Cost_account_head -> title;
                                    if ( $Finance_Cost_account_head -> role_id > 0 ) {
                                        $role = get_account_head_role ( $Finance_Cost_account_head -> role_id );
                                        if ( !empty( $role ) )
                                            echo ' (' . get_account_head_role ( $Finance_Cost_account_head -> role_id ) -> name . ')';
                                    }
                                ?>
                            </td>
                            <td><?php
                                    echo number_format ( abs ( -$transaction -> credit + $transaction -> debit ), 2 ) ?></td>
                        </tr>
                        
                        <?php include_once APPPATH . 'views/invoices/other-incomes.php' ?>
                        
                        <tr>
                            <td>
                                <strong>Net Profit / (Loss) before tax</strong>
                            </td>
                            <td>
                                <strong>
                                    <?php
                                        $net_revenue_before_tax = ( $direct_cost_net - $expense_account_credit - $finance_cost_debit ) + $net_other_incomes;
                                        echo @number_format ( $net_revenue_before_tax, 2 );
                                    ?>
                                </strong>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php
                                    $tax_debit   = 0;
                                    $acc_head_id = $Tax_account_head -> id;
                                    $transaction = calculate_acc_head_transaction ( $acc_head_id );
                                    $tax_debit   = $tax_debit + $transaction -> debit;
                                    echo $Tax_account_head -> title;
                                    if ( $Tax_account_head -> role_id > 0 ) {
                                        $role = get_account_head_role ( $Tax_account_head -> role_id );
                                        if ( !empty( $role ) )
                                            echo ' (' . get_account_head_role ( $Tax_account_head -> role_id ) -> name . ')';
                                    }
                                ?>
                            </td>
                            <td><?php
                                    echo number_format ( abs ( $transaction -> debit ), 2 ) ?></td>
                        </tr>
                        
                        <tr>
                            <td>
                                <strong>Net Profit / (Loss) after tax</strong>
                            </td>
                            <td>
                                <strong>
                                    <?php
                                        $net_revenue_before_tax = $net_revenue_before_tax - $tax_debit;
                                        echo @number_format ( $net_revenue_before_tax, 2 );
                                    ?>
                                </strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
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

<script src="<?php echo base_url ( '/assets/js/xlxs.js' ) ?>"></script>
<script type="text/javascript">
    function downloadExcel () {
        // Get the HTML table
        let table = document.getElementById ( "excel-table" );
        
        // Convert the table to a sheet object
        let sheet = XLSX.utils.table_to_sheet ( table );
        
        // Create a workbook object
        let workbook = XLSX.utils.book_new ();
        
        // Add the sheet to the workbook
        XLSX.utils.book_append_sheet ( workbook, sheet, "Sheet1" );
        
        // Convert the workbook to a binary string
        let wbout = XLSX.write ( workbook, { bookType: "xlsx", type: "binary" } );
        
        // Create a Blob object from the binary string
        let blob = new Blob ( [ s2ab ( wbout ) ], { type: "application/octet-stream" } );
        
        // Create a download link and click it
        let url    = window.URL.createObjectURL ( blob );
        let a      = document.createElement ( "a" );
        a.href     = url;
        a.download = "Profit and Loss Statement.xlsx";
        a.click ();
        window.URL.revokeObjectURL ( url );
    }
    
    function s2ab ( s ) {
        let buf  = new ArrayBuffer ( s.length );
        let view = new Uint8Array ( buf );
        for ( let i = 0; i < s.length; i++ ) view[ i ] = s.charCodeAt ( i ) & 0xff;
        return buf;
    }

</script>