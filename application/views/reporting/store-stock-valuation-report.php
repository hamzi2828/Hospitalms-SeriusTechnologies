<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.full.min.js"></script>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-offset-3 col-lg-4">
                    <label>Type</label>
                    <select name="type" class="form-control select2me" data-placeholder="Select">
                        <option></option>
                        <option
                            value="consumable-lab" <?php echo $this -> input -> get ( 'type' ) == 'consumable-lab' ? 'selected="selected"' : '' ?>>
                            Consumable (Lab)
                        </option>
                        <option value="consumable" <?php echo $this -> input -> get ( 'type' ) == 'consumable' ? 'selected="selected"' : '' ?>>Consumable (General)</option>
                        <option value="fix-assets" <?php echo $this -> input -> get ( 'type' ) == 'fix-assets' ? 'selected="selected"' : '' ?>>Fix Assets</option>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn-block btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Stock Evaluation Report
                </div>
                <?php if ( count ( $stores ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/store-stock-evaluation-report?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
                
                <a href="javascript:void(0)" onclick="downloadExcel()" style="margin-right: 10px"
                   class="pull-right print-btn">Download Excel</a>
            </div>
            <div class="portlet-body" style="overflow: auto;">
                <table class="table table-striped table-bordered table-hover" id="excel-report">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Name</th>
                        <th> Type</th>
                        <th> Total Qty.</th>
                        <th> Issued Qty.</th>
                        <th> Available Qty.</th>
                        <th> Net Value</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $total   = 0;
                        $counter = 1;
                        if ( count ( $stores ) > 0 ) {
                            foreach ( $stores as $store ) {
                                $sold      = get_store_stock_sold_quantity ( $store -> id );
                                $quantity  = get_store_stock_total_quantity ( $store -> id );
                                $available = $quantity - $sold;
                                $net_value = get_available_stock_price ( $store -> id );
                                $total     = $total + $net_value;
                                
                                if ( $quantity > 0 ) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td> <?php echo $counter ++ ?> </td>
                                        <td><?php echo $store -> item ?></td>
                                        <td><?php echo ucwords ( $store -> type ) ?></td>
                                        <td><?php echo $quantity > 0 ? $quantity : 0 ?></td>
                                        <td><?php echo $sold > 0 ? $sold : 0 ?></td>
                                        <td><?php echo $available ?></td>
                                        <td><?php echo number_format ( $net_value, 2 ) ?></td>
                                        <td class="btn-group-xs">
                                            <a type="button" class="btn green"
                                               href="<?php echo base_url ( '/store/stock/' . $store -> id ) ?>">Stock</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            <tr>
                                <td colspan="6" class="text-right">
                                    <strong>Total:</strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $total, 2 ) ?></strong>
                                </td>
                                <td></td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
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
</style>

<script type="text/javascript">
    function downloadExcel () {
        // Get the HTML table
        let table = document.getElementById ( "excel-report" );

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
        let url = window.URL.createObjectURL ( blob );
        let a = document.createElement ( "a" );
        a.href = url;
        a.download = "Stock valuation report.xlsx";
        a.click ();
        window.URL.revokeObjectURL ( url );
    }

    function s2ab ( s ) {
        let buf = new ArrayBuffer ( s.length );
        let view = new Uint8Array ( buf );
        for ( let i = 0; i < s.length; i++ ) view[ i ] = s.charCodeAt ( i ) & 0xff;
        return buf;
    }

</script>