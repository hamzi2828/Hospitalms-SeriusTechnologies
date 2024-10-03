<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form method="get" autocomplete="off">
                <div class="form-group col-lg-4 col-lg-offset-3">
                    <label for="exampleInputEmail1">Date</label>
                    <input type="text" name="trans_date" class="financial-year form-control"
                           placeholder="Transaction date" required="required" data-date-format="dd-mm-yyyy"
                           value="<?php echo ( @$_REQUEST[ 'trans_date' ] ) ? @$_REQUEST[ 'trans_date' ] : date ( 'd-m-Y' ) ?>">
                </div>
                <div class="col-lg-1" style="padding-top: 25px">
                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Balance Sheet
                    <?php
                        $trans_date = @$_REQUEST[ 'trans_date' ];
                        if ( isset( $trans_date ) and !empty( $trans_date ) ) {
                            ?>
                            (<small><?php echo date ( 'jS F Y', strtotime ( $trans_date ) ) ?></small>)
                            <?php
                        }
                    ?>
                </div>
                
                <?php if ( isset( $trans_date ) and !empty( $trans_date ) ) : ?>
                    <a href="<?php echo base_url ( '/invoices/balance-sheets?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                    
                    <a href="javascript:void(0)" onclick="downloadExcel()" style="margin-right: 10px"
                       class="pull-right print-btn">Download Excel</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="excel-table">
                    <thead>
                    <tr>
                        <th> Account Head</th>
                        <th> Closing Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <h6 style="color: #000000; font-weight: 800 !important;"> Current Assets: </h6>
                        </td>
                        <td></td>
                    </tr>
                    <?php
                        $netCurrentAssets = 0;
                        if ( count ( $currentAssets ) > 0 ) {
                            foreach ( $currentAssets as $currentAsset ) {
                                $balance_sheet    = filter_balance_sheet ( $currentAsset -> id );
                                $netCurrentAssets += $balance_sheet[ 'net_closing' ];
                                ?>
                                <tr>
                                    <td style="padding-left: 25px">
                                        <?php echo $currentAsset -> title ?>
                                    </td>
                                    <td style="padding-left: 25px">
                                        <?php echo number_format ( $balance_sheet[ 'net_closing' ], 2 ) ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    
                    <tr>
                        <td align="right">
                            <h6 style="color: #000000; font-weight: 800 !important;"> Total: </h6>
                        </td>
                        <td style="padding-left: 25px">
                            <h6 style="color: #000000; font-weight: 800 !important;">
                                <?php
                                    $A = $netCurrentAssets;
                                    echo number_format ( $A, 2 );
                                ?>
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h6 style="color: #000000; font-weight: 800 !important;"> Non-Current assets:</h6>
                        </td>
                        <td></td>
                    </tr>
                    <?php
                        $netNonCurrentAssets = 0;
                        if ( count ( $nonCurrentAssets ) > 0 ) {
                            foreach ( $nonCurrentAssets as $nonCurrentAsset ) {
                                $balance_sheet       = filter_balance_sheet ( $nonCurrentAsset -> id );
                                $netNonCurrentAssets += $balance_sheet[ 'net_closing' ];
                                ?>
                                <tr>
                                    <td style="padding-left: 25px">
                                        <?php echo $nonCurrentAsset -> title ?>
                                    </td>
                                    <td style="padding-left: 25px">
                                        <?php echo number_format ( $balance_sheet[ 'net_closing' ], 2 ) ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    <tr>
                        <td align="right">
                            <h6 style="color: #000000; font-weight: 800 !important;"> Total: </h6>
                        </td>
                        <td style="padding-left: 25px">
                            <h6 style="color: #000000; font-weight: 800 !important;">
                                <?php
                                    $B = $netNonCurrentAssets;
                                    echo number_format ( abs ( $B ), 2 );
                                ?>
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <td>Total Accumulated Depreciation</td>
                        <td style="padding-left: 25px">
                            <strong>
                                <?php
                                    $TAD = $total_accumulative_depreciation;
                                    echo number_format ( $TAD, 2 );
                                ?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo get_account_head ( $accumulated_depreciation[ 'account_head_id' ] ) -> title ?>
                        </td>
                        <td style="padding-left: 25px">
                            <?php
                                echo number_format ( abs ( $accumulated_depreciation[ 'net_closing' ] ), 2 );
                                $U = $accumulated_depreciation[ 'net_closing' ];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h6 style="color: #000000; font-weight: 800 !important; float: left"> Net Non-Current
                                                                                                  Assets</h6>
                            <h6 style="color: #000000; font-weight: 800 !important; float: right"> Total: </h6>
                        </td>
                        <td style="padding-left: 25px">
                            <strong style="margin-top: 5px; display: block;">
                                <?php
                                    $P = ( $B ) - ( $U ) - ( $TAD );
                                    echo number_format ( @abs ( $P ), 2 );
                                ?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h6 style="color: #000000; font-weight: 800 !important;"> Current liabilities:
                            </h6>
                        </td>
                        <td></td>
                    </tr>
                    <?php
                        $netCurrentLiabilities = 0;
                        if ( count ( $currentLiabilities ) > 0 ) {
                            foreach ( $currentLiabilities as $currentLiability ) {
                                $balance_sheet         = filter_balance_sheet ( $currentLiability -> id );
                                $netCurrentLiabilities += $balance_sheet[ 'net_closing' ];
                                ?>
                                <tr>
                                    <td style="padding-left: 25px">
                                        <?php echo $currentLiability -> title ?>
                                    </td>
                                    <td style="padding-left: 25px">
                                        <?php echo number_format ( $balance_sheet[ 'net_closing' ], 2 ) ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    <tr>
                        <td align="right">
                            <h6 style="color: #000000; font-weight: 800 !important;"> Total: </h6>
                        </td>
                        <td style="padding-left: 25px">
                            <h6 style="color: #000000; font-weight: 800 !important;">
                                <?php echo $D = number_format ( abs ( $netCurrentLiabilities ), 2 ) ?>
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo get_account_head ( $long_term_debt[ 'account_head_id' ] ) -> title ?>
                        </td>
                        <td style="padding-left: 25px">
                            <?php echo number_format ( abs ( $long_term_debt[ 'net_closing' ] ), 2 ) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo get_account_head ( $other_long_term_liabilities[ 'account_head_id' ] ) -> title ?>
                        </td>
                        <td style="padding-left: 25px">
                            <?php echo number_format ( abs ( $other_long_term_liabilities[ 'net_closing' ] ), 2 ) ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <h6 style="color: #000000; font-weight: 800 !important;"> Total: </h6>
                        </td>
                        <td style="padding-left: 25px">
                            <h6 style="color: #000000; font-weight: 800 !important;">
                                <?php echo $E = number_format ( abs ( $long_term_debt[ 'net_closing' ] + $other_long_term_liabilities[ 'net_closing' ] ), 2 ) ?>
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3 style="font-size: 18px; font-weight: 800 !important;"> Shareholder's Equity
                            
                            </h3>
                        </td>
                        <td>
                            <h3 style="font-size: 18px; font-weight: 800 !important;"></h3>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo get_account_head ( $capital[ 'account_head_id' ] ) -> title ?>
                        </td>
                        <td style="padding-left: 25px">
                            <?php
                                $G = $capital[ 'net_closing' ];
                                echo number_format ( abs ( $G ), 2 )
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Net Profit</td>
                        <td style="padding-left: 25px">
                            <?php
                                $net_other_incomes = 0;
                                if ( count ( $other_incomes ) > 0 ) {
                                    foreach ( $other_incomes as $other_income ) {
                                        $childAccHeads     = get_child_account_heads_data ( $other_income -> id );
                                        $acc_head_id       = $other_income -> id;
                                        $transaction       = calculate_acc_head_transaction ( $acc_head_id, true );
                                        $net_other_incomes = abs ( $net_other_incomes + $transaction -> debit );
                                        
                                        if ( count ( $childAccHeads ) > 0 ) {
                                            foreach ( $childAccHeads as $childAccHead ) {
                                                $subChildAccHeads   = get_child_account_heads_data ( $childAccHead -> id );
                                                $childAccHeads      = get_child_account_heads_data ( $other_income -> id );
                                                $acc_head_id        = $childAccHead -> id;
                                                $transaction        = calculate_acc_head_transaction ( $acc_head_id, true );
                                                $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                                                $sub_transaction    = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                                                $subChildAccHeads   = get_child_account_heads_data ( $childAccHead -> id );
                                                $sub_transaction    = abs ( ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) ) );
                                                $net_other_incomes  += abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) );
                                                
                                                if ( count ( $subChildAccHeads ) > 0 ) {
                                                    foreach ( $subChildAccHeads as $subChildAccHead ) {
                                                        $acc_head_id        = $subChildAccHead -> id;
                                                        $transaction        = calculate_acc_head_transaction ( $acc_head_id, true );
                                                        $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                                                        $sub_transaction    = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                                                        
                                                        $net_other_incomes += abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) );
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                $H = ( $calculate_net_profit - $TAD ) + ( abs ( $net_other_incomes ) );
                                echo number_format ( abs ( $H ), 2 )
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <h6 style="color: #000000; font-weight: 800 !important;"> Total: </h6>
                        </td>
                        <td style="padding-left: 25px">
                            <h6 style="color: #000000; font-weight: 800 !important;">
                                <?php echo $I = number_format ( ( $G + $H ), 2 ) ?>
                            </h6>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .input-xsmall {
        width : 100px !important;
    }
    
    .opening td {
        background-color : rgba(0, 255, 0, 0.3) !important;
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
        a.download = "Balance Sheet.xlsx";
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
