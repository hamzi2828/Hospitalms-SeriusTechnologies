<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form method="get" autocomplete="off">
                <div class="form-group col-lg-4 col-lg-offset-1">
                    <label for="account-head">Account Head</label>
                    <select name="account-head" class="form-control select2me" id="account-head"
                            data-placeholder="Select" data-allow-clear="true">
                        <option></option>
                        <?php echo $list ?>
                    </select>
                </div>
                <?php $access = get_user_access ( get_logged_in_user_id () ) ?>
                <div class="form-group col-lg-2">
                    <label for="start-date">Start Date</label>
                    <input type="text" name="start-date" id="start-date"
                           class="<?php echo ( !in_array ( 'allow-back-date-entries', explode ( ',', $access -> access ) ) ) ? 'financial-year' : 'date date-picker' ?> form-control"
                           placeholder="Start date" data-date-format="dd-mm-yyyy"
                           required="required" <?php echo ( !in_array ( 'allow-back-date-entries', explode ( ',', $access -> access ) ) ) ? 'readonly="readonly"' : '' ?>
                           value="<?php echo $this -> input -> get ( 'start-date' ) ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="end-date">End Date</label>
                    <input type="text" name="end-date"
                           class="<?php echo ( !in_array ( 'allow-back-date-entries', explode ( ',', $access -> access ) ) ) ? 'financial-year' : 'date date-picker' ?> form-control"
                           placeholder="End date"
                           required="required" id="end-date"
                           data-date-format="dd-mm-yyyy" <?php echo ( !in_array ( 'allow-back-date-entries', explode ( ',', $access -> access ) ) ) ? 'readonly="readonly"' : '' ?>
                           value="<?php echo $this -> input -> get ( 'end-date' ) ?>">
                </div>
                <div class="col-lg-1" style="padding-top: 25px">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>
                    <?php echo !empty( $parent_account_head ) ? $parent_account_head -> title : 'General' ?> Ledger
                </div>
                <?php if ( !empty( trim ( $ledgers[ 'html' ] ) ) ) : ?>
                    <a href="<?php echo base_url ( '/invoices/general-ledgers?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                    
                    <a href="javascript:void(0)" onclick="downloadExcel()" style="margin-right: 10px"
                       class="pull-right print-btn">Download Excel</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="general-ledgers">
                    <thead>
                    <tr>
                        <th align="center" class="text-center"> Sr. No</th>
                        <th align="left"> Trans. ID</th>
                        <th align="left"> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                        <th align="left"> Chq/Trans. No</th>
                        <th align="left"> Voucher No.</th>
                        <th align="left"> Date</th>
                        <th align="left"> Description</th>
                        <th align="left"> Debit</th>
                        <th align="left"> Credit</th>
                        <th align="left"> Running Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php echo $ledgers[ 'html' ] ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="9" align="right" style="font-size: 12pt; color: #FF0000">
                            <strong>Net Closing</strong>
                        </td>
                        <td align="left" style="font-size: 12pt; color: #FF0000">
                            <strong><?php echo number_format ( $ledgers[ 'net_closing' ], 2 ) ?></strong>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
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
        a.download = "General Ledger.xlsx";
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
