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
                <div class="form-group col-lg-2" style="position: relative">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></label>
                    <input type="text" name="invoice_id" class="form-control" placeholder="Enter invoice number"
                           autofocus="autofocus" value="<?php echo @$_REQUEST[ 'invoice_id' ] ?>">
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="date date-picker form-control" placeholder="Start date"
                           value="<?php echo ( @$_REQUEST[ 'start_date' ] ) ? @$_REQUEST[ 'start_date' ] : '' ?>">
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="date date-picker form-control" placeholder="End date"
                           value="<?php echo ( @$_REQUEST[ 'end_date' ] ) ? @$_REQUEST[ 'end_date' ] : '' ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Time</label>
                    <select class="form-control select2me" name="start_time">
                        <option value="">Select</option>
                        <?php
                            $times = create_time_range ( '01:00', '23:00', '60 mins', '24' );
                            foreach ( $times as $time ) :
                                ?>
                                <option value="<?php echo $time ?>" <?php if ( $time == @$_REQUEST[ 'start_time' ] ) echo 'selected="selected"' ?>><?php echo $time ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Time</label>
                    <select class="form-control select2me" name="end_time">
                        <option value="">Select</option>
                        <?php
                            $times = create_time_range ( '01:00', '23:00', '60 mins', '24' );
                            foreach ( $times as $time ) :
                                ?>
                                <option value="<?php echo $time ?>" <?php if ( $time == @$_REQUEST[ 'end_time' ] ) echo 'selected="selected"' ?>><?php echo $time ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Panel</label>
                    <select name="panel-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    ?>
                                    <option value="<?php echo $panel -> id ?>" <?php if ( $panel -> id == @$_GET[ 'panel-id' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $panel -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Airline</label>
                    <select name="airline-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $airlines ) > 0 ) {
                                foreach ( $airlines as $airline ) {
                                    ?>
                                    <option value="<?php echo $airline -> id ?>" <?php if ( $airline -> id == @$_GET[ 'airline-id' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $airline -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">User</label>
                    <select name="user-id" class="form-control select2me">
                        <?php
                            if ( count ( $users ) > 0 ) {
                                echo '<option value="">Select</option>';
                                foreach ( $users as $user ) {
                                    ?>
                                    <option value="<?php echo $user -> id ?>" <?php echo @$_REQUEST[ 'user-id' ] == $user -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $user -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-2">
                <label for="exampleInputEmail1">Sections</label>
                <select name="section-id[]" class="form-control select2me" multiple="multiple">
                    <?php
                        if (count($sections) > 0) {
                            foreach ($sections as $section) {
                                $selected = (!empty($_REQUEST['section-id']) && in_array($section->id, (array)$_REQUEST['section-id'])) ? 'selected="selected"' : '';
                                echo '<option value="' . $section->id . '" ' . $selected . '>' . $section->code . '</option>';
                            }
                        }
                    ?>
                </select>
            </div>


                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Sample Due</label>
                    <select name="sample_due" class="form-control select2me">
                        <option value="">Select</option>
                        <option value="1" <?php echo @$_REQUEST['sample_due'] == 1 ? 'selected="selected"' : '';?>>Yes</option>
                        <option value="0" <?php echo @$_REQUEST['sample_due'] == 0 ? 'selected="selected"' : '';?>>No</option>
                    </select>
                </div>


                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Status </label>
                    <select name="status" class="form-control select2me">
                        <option value="">Select</option>
                        <option value="not_added" <?php echo @$_REQUEST['status'] == 'not_added' ? 'selected="selected"' : '';?>>Results Not Added</option>
                        <option value="not_verified" <?php echo @$_REQUEST['status'] == 'not_verified' ? 'selected="selected"' : '';?>>Results Not Verified</option>
                    </select>
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
                        <i class="fa fa-globe"></i> Test Status Report
                    </div>
                    <a href="javascript:void(0)" onclick="downloadExcel()" style="margin-right: 10px"
                    class="pull-right print-btn">Download Excel</a>
                </div>
               <div class="portlet-body" style="overflow: auto">
                    <form method="post">
                        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                               value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                        <table class="table table-striped table-bordered table-hover"  id="excel-table">
                            <thead>
                            <tr>
                                <th> Sr. No</th>
                                <th>Date </th>
                                <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                                <th> Location</th>
                                <th> Location Sale ID</th>
                                <th> Daily Sale ID</th>
                                <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                                <th> Patient Panel</th>
                                <th> Airline</th>
                                <th> Lab. Ref</th>
                                <th> Test Name</th>
                                <th> Reporting Time </th>
                                <th> Phlebotomy</th>
                                <th> Sample Due</th>
                                <th> In Process</th>
                                <th> Results Added</th>
                                <th> Results Verified</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $counter = 1 + ( isset( $_GET[ 'per_page' ] ) and @$_GET[ 'per_page' ] > 0 ) ? ( @$_GET[ 'per_page' ] + 1 ) : 0;
                                if ( count ( $sales ) > 0 ) {
                                    foreach ( $sales as $sale ) {
                                        $results   = @get_test_results ( $sale -> sale_id, $sale -> test_id );
                                        $test      = @get_test_by_id ( $sale -> test_id );

                                        $sale_info = get_lab_sale ( $sale -> sale_id );
                                        $location  = ( is_object ( $sale_info ) ) ? get_location_by_id ( $sale_info -> locations_id ) : new stdClass();
                                        $location_sale_id = get_location_sale_id_by_hmis_lab_sales_id($sale -> sale_id);
                                        $daily_location_sale_id = get_daily_location_sale_id_by_hmis_lab_sales_id($sale -> sale_id);

                                        $verified  = get_result_verification_data ( $sale -> sale_id, ( !empty( $results ) ) ? $results -> id : 0 );
                                        $patient   = get_patient ( $sale -> patient_id );

                                        // ✅ If status=verified is in request, only show verified results
                                        if (!empty($_REQUEST['status']) && $_REQUEST['status'] === "not_verified" &&  !empty( $verified )) {
                                            continue; // Skip unverified rows
                                        }

                                        if (!empty($_REQUEST['status']) && $_REQUEST['status'] === "not_added" ) {
                                            if ( $results and !empty ( $results ) > 0 )
                                            continue; // Skip unverified rows
                                        }

     
                            ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $counter++ ?></td>
                                            <td><?php echo $sale -> date_added ?></td>
                                            <td><?php echo $sale -> sale_id ?></td>
                                            <td><?php echo $location->name ?? ''; ?></td>
                                            <td><?php echo $location_sale_id ?? ''; ?></td>
                                            <td><?php echo $daily_location_sale_id ?? ''; ?></td>

                                            <td><?php echo get_patient_name ( 0, $patient ) ?></td>
                                            <td>
                                                <?php
                                                    if ( $patient -> panel_id > 0 )
                                                        echo get_panel_by_id ( $patient -> panel_id ) -> name;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ( $sale -> airline_id > 0 )
                                                        echo get_airlines_by_id ( $sale -> airline_id ) -> title;
                                                ?>
                                            </td>
                                            <td><?php echo $sale -> reference_code ?></td>
                                            <td><?php echo $test -> name ?></td>
                                            <td><?php echo $sale -> report_collection_date_time ?></td>
                                            <td><span class="label label-success">Done</span></td>
                                            <td><?php echo $sale -> due ? '<p style="padding-left:15px; padding-right:15px;" class="btn btn-danger btn-xs btn-block ">Yes</p>' : ' '; ?></td>
                                            <td>
                                                <?php
                                                    if ( $results and !empty ( $results ) > 0 )
                                                        echo '<span class="label label-success">Done</span>';
                                                    else
                                                        echo '<span class="label label-warning">Pending</span>';
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ( $results and !empty ( $results ) > 0 )
                                                        echo '<span class="label label-success">Results Added</span>';
                                                    else
                                                        echo '<span class="label label-warning">Results Not Added</span>';
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ( !empty( $verified ) )
                                                        echo '<span class="label label-success">Results Verified</span>';
                                                    else
                                                        echo '<span class="label label-warning">Results Not Verified</span>';
                                                ?>
                                            </td>
                                        </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>

                        </table>
                    </form>
                </div>
                <div id="pagination">
                    <ul class="tsc_pagination">
                        <!-- Show pagination links -->
                        <?php foreach ( $links as $link ) {
                            echo "<li>" . $link . "</li>";
                        } ?>
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
        a.download = "Test Status Report.xlsx";
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
