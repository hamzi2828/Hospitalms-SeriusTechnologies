<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            size          : auto;
            header        : myheader;
            footer        : myfooter;
            margin-header : 5mm; /* <any of the usual CSS values for margins> */
            margin-footer : 0;
        }
        
        body {
            font-family : sans-serif;
            font-size   : 8pt;
        }
        
        p {
            margin : 0pt;
        }
        
        
        td {
            vertical-align : top;
        }
        
        .items td {
            border-bottom : 0.1mm dotted #000000;
        }
        
        table thead td {
            background-color : #EEEEEE;
            text-align       : center;
            /*border: 0.1mm solid #000000;*/
            font-variant     : small-caps;
        }
        
        .items td.blanktotal {
            background-color : #EEEEEE;
            border           : 0.1mm solid #000000;
            background-color : #FFFFFF;
            border           : 0mm none #000000;
            border-top       : 0.1mm solid #000000;
            border-right     : 0.1mm solid #000000;
        }
        
        .items td.totals {
            text-align  : right;
            border      : 0.1mm solid #000000;
            font-weight : 800 !important;
        }
        
        .items td.cost {
            text-align : center;
        }
        
        .totals {
            font-weight : 800 !important;
        }
        
        .parent {
            padding-left : 25px;
        }
        
        .previous-results {
            text-align : left !important;
        }
        
        .previous-results tr {
            text-align : left !important;
        }
        
        .previous-results td {
            text-align : left !important;
        }
        
        .previous-results td:first-child {
            width : 5px !important;
        }
        
        .previous-results td:nth-child(2) {
            text-align : left !important;
            width      : 105px !important;
        }
        
        .doctors {
            border-top    : 1px solid #000000;
            border-bottom : 1px solid #000000;
        }
        
        .doctors td {
            font-size : 8px;
        }
    </style>
</head>
<body>
<?php
    $note = '';
    if ( isset( $_REQUEST[ 'parent-id' ] ) and !empty( trim ( $_REQUEST[ 'parent-id' ] ) ) ) {
        $testInfo = get_test_by_id ( $_REQUEST[ 'parent-id' ] );
        $note     = $testInfo -> report_footer;
    }
    $verified = get_result_verification_data ( $_GET[ 'sale-id' ], $_GET[ 'id' ] );
?>
<!--mpdf
<htmlpageheader name="myheader">
<?php if ( $this -> input -> get ( 'logo' ) == 'true' ) : ?>
    <?php require 'pdf-header.php'; ?>
<?php endif; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
    <div style="width:100%; display:block; text-align:left">
        <small><b>Note:This is a digitally verified report and does not require manual signature.</small></b><br/>
        <b>Verified By:</b><?php echo get_user ( $verified -> user_id ) -> name ?> &nbsp;&nbsp;&nbsp;&nbsp;<br/>
        <b>Print Date/Time: </b><?php echo date ( 'd-m-Y' ) . ' ' . date ( 'g:i a' ) ?> <br/>
    </div>
    <?php if ( $this -> input -> get ( 'logo' ) == 'true' ) : ?>
        <?php require 'pdf-footer.php'; ?>
    <?php endif; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<?php
    
    if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
        $link = "https";
    else $link = "http";
    
    // Here append the common URL characters.
    $link .= "://";
    
    // Append the host(domain name, ip) to the URL.
    $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];

?>

<table width="100%">
    <tr>
        <?php
            $password     = !empty( $online_report_info ) ? encode ( $online_report_info -> password ) : '';
            $barcodeValue = str_replace ( '&', ',', $link ) . ',qrcode=true';
            
            if ( empty( $airline ) ) {
                ?>
                <td width="50%" style="color:#000; font-size: 9pt">
                    <b>Name: </b><?php echo get_patient_name ( 0, $patient ) ?><br />
                    <?php
                        if ( !empty( trim ( $patient -> father_name ) ) )
                            echo '<b>' . $patient -> relationship . ': </b>' . $patient -> father_name . '<br/>';
                        if ( !empty( trim ( $patient -> passport ) ) )
                            echo '<b>Patient Passport: </b>' . $patient -> passport . '<br/>';
                        if ( !empty( trim ( $patient -> cnic ) ) )
                            echo '<b>CNIC: </b>' . $patient -> cnic . '<br/>';
                        
                        if ( $patient -> panel_id > 0 )
                            echo '<b>Panel Name: </b>' . get_panel_by_id ( $patient -> panel_id ) -> name . '<br/>';
                    ?>
                    <b>Contact No: </b><?php echo $patient -> mobile ?><br />
                    <b>Gender: </b><?php echo ( $patient -> gender == 1 ) ? 'Male' : 'Female' ?><br />
                    <?php if ( !empty( trim ( $patient -> age ) ) ) : ?>
                        <b>Age: </b><?php echo $patient -> age . ' ' . $patient -> age_year_month ?><br />
                    <?php endif; ?>
                    <?php
                        if ( $tests[ 0 ] -> doctor_id > 0 ) {
                            ?>
                            <b>Referred By: </b><?php echo get_doctor ( $tests[ 0 ] -> doctor_id ) -> name ?><br />
                            <?php
                        }
                    ?>
                    <b><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>: </b><?php echo $_GET[ 'sale-id' ] ?><br />
                </td>
                <td width="50%" style="text-align: right;">
                    <img src="https://quickchart.io/qr?text=<?php echo $barcodeValue ?>&size=120" />
                </td>
                <?php
            }
            else {
                ?>
                <td width="33%" style="color:#000; font-size: 9pt">
                    <b>Name: </b><?php echo get_patient_name ( 0, $patient ) ?><br />
                    <?php
                        if ( !empty( trim ( $patient -> father_name ) ) )
                            echo '<b>' . $patient -> relationship . ': </b>' . $patient -> father_name . '<br/>';
                        if ( !empty( trim ( $patient -> passport ) ) )
                            echo '<b>Patient Passport: </b>' . $patient -> passport . '<br/>';
                        if ( !empty( trim ( $patient -> cnic ) ) )
                            echo '<b>CNIC: </b>' . $patient -> cnic . '<br/>';
                        
                        if ( $patient -> panel_id > 0 )
                            echo '<b>Panel Name: </b>' . get_panel_by_id ( $patient -> panel_id ) -> name . '<br/>';
                    ?>
                    <b>Contact No: </b><?php echo $patient -> mobile ?><br />
                    <b>Gender: </b><?php echo ( $patient -> gender == 1 ) ? 'Male' : 'Female' ?><br />
                    <?php if ( !empty( trim ( $patient -> age ) ) ) : ?>
                        <b>Age: </b><?php echo $patient -> age . ' ' . $patient -> age_year_month ?><br />
                    <?php
                    endif;
                        if ( $tests[ 0 ] -> doctor_id > 0 ) {
                            ?>
                            <b>Referred By: </b><?php echo get_doctor ( $tests[ 0 ] -> doctor_id ) -> name ?><br />
                            <?php
                        }
                    ?>
                    <b><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>: </b><?php echo $_GET[ 'sale-id' ] ?><br />
                </td>
                <td width="25%" style="color:#000; ">
                    <b>Flight No: </b><?php echo $airline -> flight_no ?><br />
                    <b>Ticket No: </b><?php echo $airline -> ticket_no ?><br />
                    <b>Destination: </b><?php echo @get_destinations_by_id ( $airline -> destination_id ) -> title ?>
                    <br />
                    <b>Flight Date: </b><?php echo date_setter ( $airline -> flight_date ) ?><br />
                    <b>PNR: </b><?php echo $airline -> pnr ?><br />
                    <b>Airline: </b><?php echo @get_airlines_by_id ( $airline -> airline_id ) -> title ?><br />
                    <?php if ( !empty( trim ( $patient -> nationality ) ) ) : ?>
                        <b>Nationality: </b><?php echo $patient -> nationality ?><br />
                    <?php endif; ?>
                    <?php
                        if ( $airline -> location_id > 0 ) {
                            ?>
                            <b>Airport: </b><?php echo @get_location_by_id ( $airline -> location_id ) -> name ?><br />
                            <?php
                        }
                    ?>
                </td>
                <td width="17%" style="color:#000; ">
                    <?php if ( $airline -> show_picture == '1' ) : ?>
                        <img src="<?php echo $patient -> picture; ?>" style="height: 100px">
                    <?php endif; ?>
                </td>
                <td width="25%" style="text-align: right;">
                    <?php include_once 'bar-code.php'; ?>
                </td>
                <?php
            }
        ?>
    </tr>
</table>

<div style="text-align: right; float:left; width: 100%; display: block; font-size: 9pt">
    <?php if ( !empty( trim ( @$tests[ 0 ] -> batch_no ) ) ) : ?>
        <strong>Batch No:</strong> <?php echo @$tests[ 0 ] -> batch_no ?>
        <br />
    <?php endif; ?>
    <strong>Sample Date:</strong> <?php echo date_setter ( $sale -> date_sale ) ?>
    <br />
    <strong>Verify Date/Time:</strong> <?php echo date_setter ( $verified -> created_at ) ?>
    <br />
    <br />
</div>

<table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; margin-top: 15px; border: 0"
       cellpadding="8" border="0">
    <thead>
    <tr style="background: #f5f5f5;">
        <th align="left">Test Name</th>
        <th align="left">
            Results
        </th>
        <th colspan="2" align="center">
            Previous Results
        </th>
        <th align="left">Units</th>
        <th align="left">Reference Ranges</th>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <?php
        if ( count ( $tests ) > 0 ) {
            foreach ( $tests as $test ) {
                $test_info  = get_test_by_id ( $test -> test_id );
                $unit       = get_test_unit_id_by_id ( $test -> test_id );
                $ranges     = get_reference_ranges_by_test_id ( $test -> test_id );
                $isParent   = check_if_test_has_sub_tests ( $test -> test_id );
                $isChild    = check_if_test_is_child ( $test -> test_id );
                $testIDS    = get_child_tests_ids ( $test -> test_id );
                $sampleInfo = get_test_sample_info ( $test -> test_id );
                $result_id  = $_REQUEST[ 'id' ];
                if ( !empty( $testIDS -> ids ) )
                    $subTests = get_lab_test_results_by_ids ( $test -> sale_id, $testIDS -> ids, $result_id );
                else
                    $subTests = array ();
                
                $previous_results = get_previous_test_results ( $test -> sale_id, $test -> test_id );
                
                if ( !empty( $sampleInfo ) and $test_info -> parent_id < 1 ) {
                    $section_id = $sampleInfo -> section_id;
                    $section    = get_section_by_id ( $section_id );
                    if ( !empty( $section ) ) {
                        ?>
                        <tr>
                            <td colspan="6">
                                <h3 style="color: #ff0000">
                                    <?php echo $section -> name ?>
                                </h3>
                            </td>
                        </tr>
                        <?php
                    }
                }
                
                ?>
                <tr>
                    <td align="left" <?php if ( ( isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] > 0 ) or $isParent )
                        echo '';
                    else if ( $test_info -> parent_id < 1 )
                        echo ''; ?>>
                    <span <?php if ( ( isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] > 0 ) or $isParent )
                        echo 'style="font-weight: 900; font-size: 14px"' . $test_info -> report_title;
                    else if ( $test_info -> parent_id < 1 )
                        echo 'style="font-weight: 900; font-size: 9pt"'; ?>>
                        <?php if ( ( isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] > 0 ) or $isParent or $test_info -> parent_id < 1 )
                            echo '<strong>' . $test_info -> report_title . '</strong>';
                        else echo $test_info -> report_title ?>
                    </span>
                    </td>
                    
                    <td align="left" style="font-weight: 900; font-size: 9pt; <?php if ( $test -> abnormal == '1' )
                        echo 'color: #FF0000; font-weight: bold' ?>">
                        <?php
                            if ( $test_info -> category == 'covid' ) {
                                echo !empty( trim ( $test -> result ) ) ? $test -> result . '&nbsp;&nbsp;&nbsp;' : '';
                                echo $test -> detected == 'detected' ? 'Detected' : 'Not Detected';
                            }
                            else
                                echo $test -> result;
                        ?>
                    </td>
                    
                    <?php
                        if ( count ( $previous_results ) > 0 ) {
                            foreach ( $previous_results as $key => $previous_result ) {
                                ?>
                                <td style="font-weight: 900; font-size: 9pt">
                                    <?php echo date ( 'd-m-Y', strtotime ( $previous_result -> date_added ) ) ?>
                                </td>
                                <?php
                            }
                        }
                        $td = 2 - count ( $previous_results );
                        for ( $loop = 1; $loop <= $td; $loop++ ) {
                            echo '<td></td>';
                        }
                    ?>
                    
                    <td align="left"
                        style="font-weight: 900; font-size: 9pt"><?php echo @get_unit_by_id ( $unit ) ?></td>
                    <td align="left" style="font-weight: 900; font-size: 9pt">
                        <?php
                            if ( count ( $ranges ) > 0 ) {
                                foreach ( $ranges as $range ) {
                                    if ( !empty( trim ( $range -> gender ) ) )
                                        echo '<b>' . ucwords ( str_replace ( 'f', 'F', $range -> gender ) ) . '</b>: ';
                                    
                                    if ( !empty( trim ( $range -> start_range ) ) and !empty( trim ( $range -> end_range ) ) )
                                        echo $range -> start_range . ' - ' . $range -> end_range . '<br/>';
                                    
                                    else if ( !empty( trim ( $range -> start_range ) ) and empty( trim ( $range -> end_range ) ) )
                                        echo $range -> start_range . '<br/>';
                                    
                                    else if ( empty( trim ( $range -> start_range ) ) and !empty( trim ( $range -> end_range ) ) )
                                        echo $range -> end_range . '<br/>';
                                    
                                    else if ( empty( trim ( $range -> start_range ) ) and empty( trim ( $range -> end_range ) ) )
                                        echo '';
                                }
                            }
                        ?>
                    </td>
                </tr>
                <?php
                
                if ( count ( $subTests ) > 0 ) {
                    foreach ( $subTests as $key => $subTest ) {
                        $sub_test_info = get_test_by_id ( $subTest -> test_id );
                        $sub_unit      = @get_test_unit_id_by_id ( $subTest -> test_id );
                        $sub_ranges    = get_reference_ranges_by_test_id ( $subTest -> test_id );
                        if ( !empty( trim ( $subTest -> result ) ) ) {
                            ?>
                            <tr>
                                <td align="left" style="font-size: 9pt">
                                    <?php echo $sub_test_info -> report_title ?>
                                </td>
                                <td align="left"
                                    style="font-weight: 900; font-size: 9pt; <?php if ( $subTest -> abnormal == '1' )
                                        echo 'color: #FF0000; font-weight: bold' ?>">
                                    <?php echo @$subTest -> result; ?>
                                </td>
                                <?php
                                    if ( count ( $previous_results ) > 0 ) {
                                        foreach ( $previous_results as $previous_result ) {
                                            $previousResultTestIDS = get_child_tests_ids ( $previous_result -> test_id );
                                            $previousSubTests      = get_lab_test_results_by_ids ( $previous_result -> sale_id, $previousResultTestIDS -> ids, $previous_result -> id );
                                            ?>
                                            <td style="font-size: 8pt">
                                                <?php echo @$previousSubTests[ $key ] -> result; ?>
                                            </td>
                                            <?php
                                        }
                                    }
                                    $td = 2 - count ( $previous_results );
                                    for ( $loop = 1; $loop <= $td; $loop++ ) {
                                        echo '<td></td>';
                                    }
                                ?>
                                <td align="left"
                                    style="font-weight: 900; font-size: 9pt"><?php echo @get_unit_by_id ( $sub_unit ) ?></td>
                                <td align="left" style="font-weight: 900; font-size: 9pt">
                                    <?php
                                        if ( count ( $sub_ranges ) > 0 ) {
                                            foreach ( $sub_ranges as $sub_range ) {
                                                if ( !empty( trim ( $sub_range -> gender ) ) )
                                                    echo '<b>' . ucwords ( str_replace ( 'f', 'F', $sub_range -> gender ) ) . '</b>: ';
                                                
                                                if ( !empty( trim ( $sub_range -> start_range ) ) and !empty( trim ( $sub_range -> end_range ) ) )
                                                    echo $sub_range -> start_range . '-' . $sub_range -> end_range . '<br/>';
                                                
                                                else if ( !empty( trim ( $sub_range -> start_range ) ) and empty( trim ( $sub_range -> end_range ) ) )
                                                    echo $sub_range -> start_range . '<br/>';
                                                
                                                else if ( empty( trim ( $sub_range -> start_range ) ) and !empty( trim ( $sub_range -> end_range ) ) )
                                                    echo $sub_range -> end_range . '<br/>';
                                                
                                                else if ( empty( trim ( $sub_range -> start_range ) ) and empty( trim ( $sub_range -> end_range ) ) )
                                                    echo '';
                                            }
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
                else {
                    if ( count ( $previous_results ) > 0 ) {
                        echo '<tr><td colspan="2"></td>';
                        foreach ( $previous_results as $previous_result ) {
                            ?>
                            <td style="font-weight: 900; font-size: 9pt">
                                <?php echo @$previous_result -> result; ?>
                            </td>
                            <?php
                        }
                        $td = 2 - count ( $previous_results );
                        for ( $loop = 1; $loop <= $td; $loop++ ) {
                            echo '<td></td>';
                        }
                        echo '<td colspan="2"></td>';
                        echo '</tr>';
                    }
                }
            }
        }
    ?>
    </tbody>
</table>
<div class="remarks">
    <h3>Remarks:</h3>
    <?php
        $machine = get_test_parameters ( @$_GET[ 'parent-id' ] );
        if ( count ( $tests ) > 0 ) {
            foreach ( $tests as $test ) {
                $test_info = get_test_by_id ( $test -> test_id );
                ?>
                <span>
                    <?php
                        if ( count ( $remarks ) > 0 ) {
                            foreach ( $remarks as $remark ) {
                                $remarkInfo = get_remarks_by_id ( $remark -> remarks_id );
                                echo $remarkInfo -> remarks . '<br/>';
                            }
                        }
                    ?>
                    <?php echo !empty( trim ( $test -> remarks ) ) ? $test -> remarks : '' ?>
                </span>
                <br />
                
                <?php
            }
        }
        if ( !empty( $machine ) and !empty( trim ( $machine -> machine_name ) ) )
            echo '<br/><small><b>Performed On: ' . $machine -> machine_name . '</b></small>';
    ?>
</div>
<?php
    if ( !empty( trim ( $note ) ) )
        if ( !empty( trim ( $test -> remarks ) ) )
            echo '<br/><br/><br/><span style="font-size: 12px">' . $note . '</span>';
        else
            echo '<span style="font-size: 12px">' . $note . '</span>';
    
    $showStamp = true;
    if ( isset( $_GET[ 'parent-id' ] ) and $_GET[ 'parent-id' ] > 0 ) {
        $testInfo = get_test_by_id ( $_GET[ 'parent-id' ] );
        if ( $testInfo -> show_graph == '1' ) {
            $detected = $tests[ 0 ] -> covid_detected;
            if ( $detected == '1' ) {
                $showStamp = false;
                ?>
                <img src="<?php echo base_url ( '/assets/img/covid-detected.png' ) ?>"
                     style="padding-top: 15px; height: 200px">
                <?php
            }
            else {
                $showStamp = false;
                ?>
                <img src="<?php echo base_url ( '/assets/img/covid-not-detected.png' ) ?>"
                     style="margin-top: 15px; max-height: 380px">
                <?php
            }
        }
    }
    if ( !empty( $test_result_image ) and !empty( trim ( $test_result_image -> image ) ) ) : ?>
        <img src="<?php echo $test_result_image -> image ?>" style="margin-top: 0; max-height: 380px">
    <?php
    endif;
?>
</body>
</html>