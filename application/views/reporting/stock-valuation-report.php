<script src="<?php echo base_url ( '/assets/js/xlxs.js' ) ?>"></script>

<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-4">
                    <label>Form</label>
                    <select name="form-id" class="form-control select2me" data-placeholder="Select">
                        <option></option>
                        <?php
                            if ( count ( $forms ) > 0 ) {
                                foreach ( $forms as $form ) {
                                    ?>
                                    <option
                                        value="<?php echo $form -> id ?>" <?php if ( $form -> id == $this -> input -> get ( 'form-id' ) ) echo 'selected="selected"' ?>>
                                        <?php echo $form -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-3">
                    <label>Generic</label>
                    <select name="generic-id" class="form-control select2me" data-placeholder="Select">
                        <option></option>
                        <?php
                            if ( count ( $generics ) > 0 ) {
                                foreach ( $generics as $generic ) {
                                    ?>
                                    <option
                                        value="<?php echo $generic -> id ?>" <?php if ( $generic -> id == $this -> input -> get ( 'generic-id' ) ) echo 'selected="selected"' ?>>
                                        <?php echo $generic -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-3">
                    <label>Strength</label>
                    <select name="strength-id" class="form-control select2me" data-placeholder="Select">
                        <option></option>
                        <?php
                            if ( count ( $strengths ) > 0 ) {
                                foreach ( $strengths as $strength ) {
                                    ?>
                                    <option
                                        value="<?php echo $strength -> id ?>" <?php if ( $strength -> id == $this -> input -> get ( 'strength-id' ) ) echo 'selected="selected"' ?>>
                                        <?php echo $strength -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn-block btn btn-primary" style="margin-top: 25px;">Search
                    </button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Stock Evaluation Report (TP Wise)
                </div>
                <?php if ( count ( $medicines ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/stock-evaluation-report?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                       class="pull-right print-btn">Print</a>
                    
                    <a href="javascript:void(0)" onclick="downloadExcel()" style="margin-right: 10px"
                       class="pull-right print-btn">Download Excel</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="stock-valuation-report">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Name</th>
                        <th> Generic</th>
                        <th> Form</th>
                        <th> Strength</th>
                        <th> Type</th>
                        <th> Total Qty.</th>
                        <th> Sold Qty.</th>
                        <th> Returned Customer.</th>
                        <th> Returned Supplier.</th>
                        <th> Expired Qty.</th>
                        <th> Internally Issued Qty.</th>
                        <th> IPD Issued Qty.</th>
                        <th> Adjustment Qty.</th>
                        <th> Available Qty.</th>
                        <th> Net Value</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        $total   = 0;
                        if ( count ( $medicines ) > 0 ) {
                            foreach ( $medicines as $medicine ) {
                                $sold            = get_sold_quantity_by_date_filter ( $medicine -> id );
                                $quantity        = get_stock_quantity_by_date_filter ( $medicine -> id );
                                $expired         = get_expired_quantity_medicine_id ( $medicine -> id );
                                $generic         = get_generic ( $medicine -> generic_id );
                                $form            = get_form ( $medicine -> form_id );
                                $strength        = get_strength ( $medicine -> strength_id );
                                $returned        = get_medicine_returned_quantity_by_date_filter ( $medicine -> id );
                                $issued          = get_issued_quantity_by_date_filter ( $medicine -> id );
                                $ipd_issuance    = get_ipd_issued_medicine_quantity_by_date_filter ( $medicine -> id );
                                $return_supplier = get_returned_medicines_quantity_by_supplier_by_date_filter ( $medicine -> id );
                                $adjustment_qty  = get_total_adjustments_by_medicine_id_by_date_filter ( $medicine -> id );
                                $available       = get_medicines_available_quantity_by_medicine_id ( $medicine -> id );
                                $net_value       = get_available_stock_price_by_medicine_id_by_date_filter ( $medicine -> id );
                                $total           = $total + $net_value;
                                
                                if ( $available > 0 ) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td> <?php echo $counter ++ ?> </td>
                                        <td><?php echo $medicine -> name ?></td>
                                        <td><?php echo $generic -> title ?></td>
                                        <td><?php echo $form -> title ?></td>
                                        <td><?php echo $strength -> title ?></td>
                                        <td><?php echo ucfirst ( $medicine -> type ) ?></td>
                                        <td><?php echo $quantity > 0 ? $quantity : 0 ?></td>
                                        <td><?php echo $sold > 0 ? $sold : 0 ?></td>
                                        <td><?php echo $returned > 0 ? $returned : 0 ?></td>
                                        <td><?php echo $return_supplier > 0 ? $return_supplier : 0 ?></td>
                                        <td><?php echo $expired > 0 ? $expired : 0 ?></td>
                                        <td><?php echo $issued > 0 ? $issued : 0 ?></td>
                                        <td><?php echo $ipd_issuance > 0 ? $ipd_issuance : 0 ?></td>
                                        <td><?php echo $adjustment_qty > 0 ? $adjustment_qty : 0 ?></td>
                                        <td><?php echo $available ?></td>
                                        <td><?php echo number_format ( $net_value, 2 ) ?></td>
                                        <td class="btn-group-xs">
                                            <a type="button" class="btn green"
                                               href="<?php echo base_url ( '/medicines/stock/' . $medicine -> id ) ?>">Stock</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            <tr>
                                <td colspan="15" class="text-right">
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
        let table = document.getElementById ( "stock-valuation-report" );

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