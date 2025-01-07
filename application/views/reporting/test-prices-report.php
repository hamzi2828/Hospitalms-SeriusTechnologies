<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- <div class="search-form">
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
        </div> -->




        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Test Prices List (Cash)
                </div>
                <?php if ( count ( $tests ) > 0 ) : ?>
                    <!-- <a href="<?php echo base_url ( '/invoices/test-prices-list-cash?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       class="pull-right print-btn" target="_blank">Print</a> -->
                    
                    <a href="javascript:void(0)" onclick="downloadExcel()" style="margin-right: 10px"
                       class="pull-right print-btn">Download Excel</a>
                <?php endif ?>
            </div>

           <div class="portlet-body" style="overflow: auto">
            <table class="table table-striped table-bordered table-hover" id="excel-table">
            <thead>
                <tr>
                    <th> Sr. No</th>
                    <th> Code</th>
                    <th> Name</th>
                    <th> Type</th>
                    <th> Price (REG)</th>
                    <th> Date Added</th>
                </tr>
            </thead>
            <tbody>
            <?php
if (count($tests) > 0) {
    $counter = 1;
    $current_section = ''; // To track the current section

    foreach ($tests as $test) {
        $price = get_regular_test_price($test->id);

        // Check if the section has changed
        if ($current_section != $test->section_name) {
            $current_section = $test->section_name;

            // Display section heading
            echo '<tr>';
            echo '<td colspan="6" style="font-weight: bold; background-color: #f5f5f5; text-align: left; color: red; font-size: 16px">';
            echo htmlspecialchars($current_section); // Output section name
            echo '</td>';
            echo '</tr>';
        }

        // Display the test details under the current section
        echo '<tr>';
        echo '<td>' . $counter++ . '</td>';
        echo '<td>' . htmlspecialchars($test->code) . '</td>';
        echo '<td>' . htmlspecialchars($test->name) . '</td>';
        echo '<td>' . ucfirst(htmlspecialchars($test->type)) . '</td>';
        echo '<td>' . (!empty($price) ? htmlspecialchars($price->price) : '0') . '</td>';
        echo '<td>' . htmlspecialchars(date_setter($test->date_added)) . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6" style="text-align: center;">No tests available</td></tr>';
}
?>

            </tbody>
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
