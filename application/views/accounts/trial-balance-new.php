<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form method="get" autocomplete="off">
                <div class="form-group col-lg-offset-3 col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="financial-year form-control" placeholder="Start date"
                           required="required" data-date-format="dd-mm-yyyy"
                           value="<?php echo $this -> input -> get ( 'start_date' ) ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="financial-year form-control" placeholder="End date"
                           required="required" data-date-format="dd-mm-yyyy"
                           value="<?php echo $this -> input -> get ( 'end_date' ) ?>">
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
                        $start_date = $this -> input -> get ( 'start_date' );
                        $end_date   = $this -> input -> get ( 'end_date' );
                        if ( isset( $start_date ) and !empty( $start_date ) and isset( $end_date ) and !empty( $end_date ) ) {
                            ?>
                            (
                            <small>
                                <?php echo date ( 'jS F Y', strtotime ( $start_date ) ) . ' to ' . date ( 'jS F Y', strtotime ( $end_date ) ) ?>
                            </small>
                            )
                            <?php
                        }
                    ?>
                </div>
                
                <a href="<?php echo base_url ( '/invoices/trial-balance-sheet?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                   class="pull-right print-btn" target="_blank">Print</a>
                
                <a href="javascript:void(0)" onclick="downloadExcel()" style="margin-right: 10px"
                   class="pull-right print-btn">Download Excel</a>
            
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="excel-table">
                    <thead>
                    <tr>
                        <th> Account Head</th>
                        <th> Opening Balance</th>
                        <th> Debit</th>
                        <th> Credit</th>
                        <th> Running Balance</th>
                    </tr>
                    </thead>
                    <?php echo $balance_sheet ?>
                    <?php echo $balance_sheet_total ?>
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
        a.download = "Trial Balance.xlsx";
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