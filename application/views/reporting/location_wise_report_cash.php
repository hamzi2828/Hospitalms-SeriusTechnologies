<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if ( validation_errors () != false ) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors (); ?>
            </div>
        <?php } ?>
        <?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata ( 'error' ) ?>
            </div>
        <?php endif; ?>
        <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
        <?php endif; ?>
  
        <div class="search-form">
            <form method="get" autocomplete="off">
                <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                       value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
              
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="form-control date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) ) ? date ( 'm/d/Y', strtotime ( $_REQUEST[ 'start_date' ] ) ) : '' ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="form-control date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) ? date ( 'm/d/Y', strtotime ( $_REQUEST[ 'end_date' ] ) ) : '' ?>">
                </div>
             
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>



                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="col-sm-12" style="padding-left: 0">
            <div class="portlet box green">
                
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Location Wise Report (Cash)
                    </div>
                    <?php if ( !empty($locations) ) : ?>
                        <a href="<?php echo base_url ( '/invoices/location_wise_report_cash?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                           target="_blank"
                           class="pull-right print-btn">Print</a>

                           <a href="javascript:void(0)" onclick="downloadExcel()" style="margin-right: 10px"
                           class="pull-right print-btn">Download Excel</a>
                    <?php endif ?>
                </div>
                <div class="portlet-body" style="overflow:auto;">
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                        <tr>
                            <th> Sr. No</th>
                            <th> Location Name</th>
                            <th> Location Code</th>
                            <!-- <th> Total Debit</th> -->
                            <!-- <th> Total Credit</th> -->
                            <th> Total Cash Sales</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $counter = 1;
                        if (!empty($locations)) {
                            foreach ($locations as $location) {
                                ?>
                                <tr>
                                    <td><?php echo $counter++; ?></td>
                                    <td><?php echo $location->name; ?></td>
                                    <td><?php echo $location->code; ?></td>
                                    <!-- <td><?php echo isset($location->total_debit) ? number_format($location->total_debit, 2) : '0.00'; ?></td> -->
                                    <!-- <td><?php echo isset($location->total_credit) ? number_format($location->total_credit, 2) : '0.00'; ?></td> -->
                                    <td><?php echo isset($location->total_sales) ? number_format($location->total_sales, 2) : '0.00'; ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->


    </div>
</div>

<script src="<?php echo base_url ( '/assets/js/xlxs.js' ) ?>"></script>
<script type="text/javascript">
    function downloadExcel () {
        // Get the HTML table
        let table = document.getElementById ( "sample_1" );
        
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
        a.download = "Location Wise Report (Cash).xlsx";
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

