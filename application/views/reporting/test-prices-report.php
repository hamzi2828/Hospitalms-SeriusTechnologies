<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Test</label>
                    <select class="form-control select2me" name="test-id">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $tests ) > 0 ) {
                                foreach ( $tests as $test ) {
                                    ?>
                                    <option value="<?php echo $test -> id ?>" <?php if ( $test -> id == @$_REQUEST[ 'test-id' ] )
                                        echo 'selected="selected"' ?>><?php echo $test -> name ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Panel</label>
                    <select class="form-control select2me" name="panel-id">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    ?>
                                    <option value="<?php echo $panel -> id ?>" <?php if ( $panel -> id == @$_REQUEST[ 'panel-id' ] )
                                        echo 'selected="selected"' ?>><?php echo $panel -> name ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Section</label>
                    <select name="section-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $sections ) > 0 ) :
                                foreach ( $sections as $section ) :
                                    ?>
                                    <option value="<?php echo $section -> id ?>" <?php if ( $section -> id == @$_GET[ 'section-id' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $section -> name ?>
                                    </option>
                                <?php
                                endforeach;
                            endif;
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Test Prices Report
                </div>
                <?php if ( count ( $reports ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/test-prices-report?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       class="pull-right print-btn" target="_blank">Print</a>
                    
                    <a href="javascript:void(0)" onclick="downloadExcel()" style="margin-right: 10px"
                       class="pull-right print-btn">Download Excel</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="excel-table">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Code</th>
                        <th> Name</th>
                        <th> Type</th>
                        <th> Category</th>
                        <th> Panel</th>
                        <th> Price</th>
                        <th> Date Added</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        $net     = 0;
                        if ( count ( $reports ) > 0 ) {
                            foreach ( $reports as $report ) {
                                $test   = get_test_by_id ( $report -> test_id );
                                $panels = get_test_panels ( $report -> test_id );
                                ?>
                                <tr>
                                    <td> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $test -> id . ' ' . $test -> code ?> </td>
                                    <td> <?php echo $test -> name ?> </td>
                                    <td> <?php echo ucwords ( $test -> type ) ?> </td>
                                    <td> <?php echo ucwords ( $test -> category ) ?> </td>
                                    <td>
                                        <?php
                                            if ( count ( $panels ) > 0 ) {
                                                foreach ( $panels as $panel ) {
                                                    $panelInfo = get_panel_by_id ( $panel -> panel_id );
                                                    echo $panelInfo -> name . '<br/>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $panels ) > 0 ) {
                                                foreach ( $panels as $panel ) {
                                                    $net += $panel -> price;
                                                    echo number_format ( $panel -> price, 2 ) . '<br/>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td> <?php echo date_setter ( $test -> date_added ) ?> </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6" align="right">
                            <strong>Total</strong>
                        </td>
                        <td colspan="2"><?php echo number_format ( $net, 2 ) ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
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
        a.download = "Lab-Test-Price-Report.xlsx";
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
