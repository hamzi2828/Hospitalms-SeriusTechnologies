<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Medicines List
                </div>
                <a href="javascript:void(0)" onclick="downloadExcel()" style="margin-right: 10px"
                   class="pull-right print-btn">Download Excel</a>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover" id="excel-table">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Name</th>
                        <th> Generic</th>
                        <th> Form</th>
                        <th> Strength</th>
                        <th> Type</th>
                        <th> TP/Unit</th>
                        <th> SP/Unit</th>
                        <th> Total Qty.</th>
                        <th> Sold Qty.</th>
                        <th> Returned Customer.</th>
                        <th> Returned Supplier.</th>
                        <th> Internally Issued Qty.</th>
                        <th> IPD Issued Qty.</th>
                        <th> Adjustment Qty.</th>
                        <th> Expired Qty.</th>
                        <th> Available Qty.</th>
                        <th> Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $medicines ) > 0 ) {
                            foreach ( $medicines as $medicine ) {
                                $generic         = get_generic ( $medicine -> generic_id );
                                $form            = get_form ( $medicine -> form_id );
                                $strength        = get_strength ( $medicine -> strength_id );
                                $returned        = get_medicine_returned_quantity ( $medicine -> id );
                                $stock           = get_latest_medicine_stock ( $medicine -> id );
                                $quantity        = get_stock_quantity ( $medicine -> id );
                                $sold            = get_sold_quantity ( $medicine -> id );
                                $return_supplier = get_returned_medicines_quantity_by_supplier ( $medicine -> id );
                                $issued          = get_issued_quantity ( $medicine -> id );
                                $ipd_issuance    = get_ipd_issued_medicine_quantity ( $medicine -> id );
                                $adjustment_qty  = get_total_adjustments_by_medicine_id ( $medicine -> id );
                                $expired         = get_expired_quantity_medicine_id ( $medicine -> id );
                                $available       = get_medicines_available_quantity_by_medicine_id ( $medicine -> id );
                                
                                if ( $expired <= $available )
                                    $available = $available - $expired;
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $medicine -> name ?></td>
                                    <td><?php if ( $medicine -> generic_id > 1 )
                                            echo $generic -> title ?></td>
                                    <td><?php if ( $medicine -> form_id > 1 )
                                            echo $form -> title ?></td>
                                    <td><?php if ( $medicine -> strength_id > 1 )
                                            echo $strength -> title ?></td>
                                    <td><?php echo ucfirst ( $medicine -> type ) ?></td>
                                    <td><?php echo @$medicine -> tp_unit ?></td>
                                    <td><?php echo @$medicine -> sale_unit ?></td>
                                    <td><?php echo $quantity > 0 ? $quantity : 0 ?></td>
                                    <td><?php echo $sold > 0 ? $sold : 0 ?></td>
                                    <td><?php echo $returned > 0 ? $returned : 0 ?></td>
                                    <td><?php echo $return_supplier > 0 ? $return_supplier : 0 ?></td>
                                    <td><?php echo $issued > 0 ? $issued : 0 ?></td>
                                    <td><?php echo $ipd_issuance > 0 ? $ipd_issuance : 0 ?></td>
                                    <td><?php echo $adjustment_qty > 0 ? $adjustment_qty : 0 ?></td>
                                    <td><?php echo $expired ?></td>
                                    <td>
                                        <?php echo $available ?>
                                    </td>
                                    <td>
                                        <?php echo ( $medicine -> status == '1' ) ? 'Active' : 'Inactive' ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
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
        a.download = "Accounts Payable.xlsx";
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