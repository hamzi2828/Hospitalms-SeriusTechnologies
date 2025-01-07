<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if (validation_errors() != false) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('response')) : ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('response'); ?>
            </div>
        <?php endif; ?>

        <!-- Filter Form -->
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-2">
                    <label for="start_date">Start Date</label>
                    <input type="text" name="start_date" class="form-control date-picker" value="<?php echo isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="end_date">End Date</label>
                    <input type="text" name="end_date" class="form-control date-picker" value="<?php echo isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : ''; ?>">
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>

        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>  Cafe Sales Report
                </div>
                <?php if ( count ( $grouped_sales ) > 0 ) : ?>
                     
                    <a href="<?php echo base_url ( '/invoices/general-report?' . http_build_query(array_merge($_REQUEST, ['cafesales_report' => true])) ) ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>

                       
                    <a href="javascript:void(0)" onclick="downloadExcel()" style="margin-right: 10px"
                       class="pull-right print-btn">Download Excel</a>
                <?php endif ?>
                
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover" id="sales_report_table">
                    <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>Invoice ID</th>
                            <th>Items</th>
                            <th>Sale Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Discount(Flat)</th>
                            <th>Net Total</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1; 
                        $total_net_total = 0; // Initialize total variable
                        $total_grand_total_discount = 0;
                        foreach ($grouped_sales as $invoice_id => $group) { 
                            $total_net_total += $group['grand_total'];
                            $total_grand_total_discount += $group['grand_total_discount'];
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td>
                                    <?php echo $group['invoice_id']; ?>
                                    <?php if ($group['refunded'] == 1): ?>
                                        <span class="badge badge-danger">Refunded</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo implode('<br>', $group['items']); ?></td>
                                <td><?php echo implode('<br>', $group['sale_qtys']); ?></td>
                                <td><?php echo implode('<br>', $group['prices']); ?></td>
                                <td><?php echo implode('<br>', $group['net_prices']); ?></td>
                                <td><?php echo $group['grand_total_discount']; ?></td>
                                <td><?php echo $group['grand_total']; ?></td>
                                <td><?php echo $group['created_at']; ?></td>
                            </tr>
                        <?php $i++; } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" style="text-align: right; font-weight: bold;">Total:</td>
                            <td style="font-weight: bold;"><?php echo $total_grand_total_discount; ?></td>
                            <td style="font-weight: bold;"><?php echo $total_net_total; ?></td>
                            <td></td>
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
        let table = document.getElementById ( "sales_report_table" );
        
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
        a.download = "General Report(sales).xlsx";
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

