<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form method="get" autocomplete="off">
                <div class="form-group col-lg-offset-3 col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="financial-year form-control" placeholder="Start date"
                           required="required"
                           value="<?php echo ( isset( $_REQUEST[ 'start_date' ] ) ) ? $_REQUEST[ 'start_date' ] : '' ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="financial-year form-control" placeholder="End date"
                           required="required"
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) ) ? $_REQUEST[ 'end_date' ] : '' ?>">
                </div>
                <div class="col-lg-1" style="padding-top: 25px">
                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                </div>
            </form>
        </div>
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>
                    Expanse Report
                </div>
                <a href="<?php echo base_url ( '/invoices/expanse-report?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                   class="pull-right print-btn" target="_blank">Print</a>
                
                <a href="javascript:void(0)" onclick="downloadExcel()" style="margin-right: 10px"
                   class="pull-right print-btn">Download Excel</a>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="general-ledgers">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Account Head</th>
                        <th> Trans. No</th>
                        <th> Voucher No.</th>
                        <th> Description</th>
                        <th> Debit</th>
                        <th> Credit</th>
                        <th> Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $netDebit  = 0;
                        $netCredit = 0;
                        if ( count ( $accounts ) > 0 ) {
                            foreach ( $accounts as $account ) {
                                $ledgers          = get_ledger_by_account_head ( $account[ 'id' ] );
                                $accountNetCredit = 0;
                                $accountNetDebit  = 0;
                                if ( count ( $ledgers ) > 0 ) {
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td style="background: rgba(53, 170, 71, 0.7)"><?php echo $account[ 'title' ]; ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                }
                                
                                if ( count ( $ledgers ) > 0 ) {
                                    $counter = 1;
                                    foreach ( $ledgers as $ledger ) {
                                        $netDebit         = $netDebit + $ledger -> debit;
                                        $netCredit        = $netCredit + $ledger -> credit;
                                        $accountNetDebit  = $accountNetDebit + $ledger -> debit;
                                        $accountNetCredit = $accountNetCredit + $ledger -> credit;
                                        ?>
                                        <tr>
                                            <td><?php echo $counter++ ?></td>
                                            <td></td>
                                            <td><?php echo $ledger -> id ?></td>
                                            <td><?php echo $ledger -> voucher_number ?></td>
                                            <td><?php echo $ledger -> description ?></td>
                                            <td><?php echo number_format ( $ledger -> debit, 2 ) ?></td>
                                            <td><?php echo number_format ( $ledger -> credit, 2 ) ?></td>
                                            <td><?php echo date_setter_without_time ( $ledger -> trans_date ) ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <strong><?php echo number_format ( $accountNetDebit, 2 ) ?></strong>
                                        </td>
                                        <td>
                                            <strong><?php echo number_format ( $accountNetCredit, 2 ) ?></strong>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php
                                }
                                
                                if ( isset( $account[ 'children' ] ) and count ( $account[ 'children' ] ) > 0 ) {
                                    foreach ( $account[ 'children' ] as $childAccount ) {
                                        $childLedgers     = get_ledger_by_account_head ( $childAccount[ 'id' ] );
                                        $accountNetCredit = 0;
                                        $accountNetDebit  = 0;
                                        if ( count ( $childLedgers ) > 0 ) {
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td style="background: rgba(53, 170, 71, 0.7)"><?php echo $childAccount[ 'title' ]; ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                        }
                                        if ( count ( $childLedgers ) > 0 ) {
                                            $counter = 1;
                                            foreach ( $childLedgers as $childLedger ) {
                                                $netDebit         = $netDebit + $childLedger -> debit;
                                                $netCredit        = $netCredit + $childLedger -> credit;
                                                $accountNetDebit  = $accountNetDebit + $childLedger -> debit;
                                                $accountNetCredit = $accountNetCredit + $childLedger -> credit;
                                                ?>
                                                <tr>
                                                    <td><?php echo $counter++ ?></td>
                                                    <td></td>
                                                    <td><?php echo $childLedger -> id ?></td>
                                                    <td><?php echo $childLedger -> voucher_number ?></td>
                                                    <td><?php echo $childLedger -> description ?></td>
                                                    <td><?php echo number_format ( $childLedger -> debit, 2 ) ?></td>
                                                    <td><?php echo number_format ( $childLedger -> credit, 2 ) ?></td>
                                                    <td><?php echo date_setter_without_time ( $childLedger -> trans_date ) ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <strong><?php echo number_format ( $accountNetDebit, 2 ) ?></strong>
                                                </td>
                                                <td>
                                                    <strong><?php echo number_format ( $accountNetCredit, 2 ) ?></strong>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                            }
                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5" align="right"></td>
                        <td>
                            <strong><?php echo number_format ( $netDebit, 2 ) ?></strong>
                        </td>
                        <td colspan="2">
                            <strong><?php echo number_format ( $netCredit, 2 ) ?></strong>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<script src="<?php echo base_url ( '/assets/js/xlxs.js' ) ?>"></script>
<script type="text/javascript">
    function downloadExcel () {
        // Get the HTML table
        let table = document.getElementById ( "general-ledgers" );
        
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
        a.download = "Expanse Report.xlsx";
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