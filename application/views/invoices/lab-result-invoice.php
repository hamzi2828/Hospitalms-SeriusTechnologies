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
    </style>
</head>
<body>
<?php
    $note = '';
    if ( isset( $_REQUEST[ 'parent-id' ] ) and !empty( trim ( $_REQUEST[ 'parent-id' ] ) ) ) {
        $testInfo = get_test_by_id ( $_REQUEST[ 'parent-id' ] );
        $note     = $testInfo -> report_footer;
    }
?>
<!--mpdf
<htmlpageheader name="myheader">
<?php if ( isset( $_REQUEST[ 'logo' ] ) and $_REQUEST[ 'logo' ] == 'true' ) : ?>
<?php include 'pdf-header.php' ?>
<?php endif; ?>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<?php if ( isset( $_REQUEST[ 'logo' ] ) and $_REQUEST[ 'logo' ] == 'true' ) : ?>
<?php include 'pdf-footer.php' ?>
<?php endif; ?>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<div style="text-align: left">
    <b>MR Number: </b><?php echo $patient_id ?><br />
    <b><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?>: </b><?php echo get_patient_name ( 0, $patient ) ?><br />
    <b>Gender: </b><?php echo ( $patient -> gender == 1 ) ? 'Male' : 'Female' ?><br />
    <b><?php echo $this -> lang -> line ( 'PATIENT_PHONE' ); ?>: </b><?php echo $patient -> mobile ?><br />
    <b><?php echo $this -> lang -> line ( 'PATIENT_AGE' ); ?>: </b><?php echo $patient -> age ?><br />
    <?php
        if ( $patient -> panel_id > 0 ) {
            ?>
            <b>Panel: </b><?php echo get_panel_by_id ( $patient -> panel_id ) -> name ?><br />
            <?php
        }
    ?>
</div>
<div style="text-align: left">
    <strong>Sample Date:</strong> <?php echo date_setter ( @$tests[ 0 ] -> date_added ) ?>
    <br />
    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
    <br />
    <br />
</div>
<table width="100%" style="font-size: 8pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Lab Test Results </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; margin-top: 15px; border: 0"
       cellpadding="8" border="0">
    <thead>
    <tr style="background: #f5f5f5;">
        <th align="left">Test Name</th>
        <th>
            Results
        </th>
        <th colspan="2" align="center">
            Previous Results
        </th>
        <th>Units</th>
        <th>Reference Ranges</th>
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
                $result_id  = @$_REQUEST[ 'id' ];
                if ( !empty( $testIDS -> ids ) )
                    $subTests = get_test_results_by_ids ( $test -> sale_id, $testIDS -> ids, $result_id );
                else
                    $subTests = array ();
                
                $previous_results = get_ipd_previous_test_results ( $test -> sale_id, $test -> test_id );
                echo $this -> db -> last_query ();
//            if ( $test_info -> type == 'profile' ) {
                if ( !empty( $sampleInfo ) and $test_info -> parent_id < 1 ) {
                    $section_id = $sampleInfo -> section_id;
                    $section    = get_section_by_id ( $section_id );
                    if ( !empty( $section ) ) {
                        ?>
                        <tr>
                            <td colspan="9">
                                <h3 style="color: #ff0000"> <?php echo $section -> name ?> </h3>
                            </td>
                        </tr>
                        <?php
                    }
                }
//            }
                
                ?>
                <tr>
                    <td align="left" <?php if ( ( isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] > 0 ) or $isParent ) echo ''; else if ( $test_info -> parent_id < 1 ) echo ''; ?>>
                    <span <?php if ( ( isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] > 0 ) or $isParent ) echo 'style="font-weight: 900; font-size: 14px"' . $test_info -> name; else if ( $test_info -> parent_id < 1 ) echo 'style="font-weight: 900; font-size: 10px"'; ?>>
                        <?php if ( ( isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] > 0 ) or $isParent or $test_info -> parent_id < 1 ) echo '<strong>' . $test_info -> name . '</strong>'; else echo $test_info -> name ?>
                    </span>
                    </td>
                    <td align="center" <?php if ( ( isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] > 0 ) or $isParent ) echo ''; else if ( $test_info -> parent_id < 1 ) echo ''; ?>><?php echo $test -> result ?></td>
                    
                    <?php
                        if ( count ( $previous_results ) > 0 ) {
                            foreach ( $previous_results as $key => $previous_result ) {
                                ?>
                                <td>
                                    <?php echo date ( 'Y-m-d', strtotime ( $previous_result -> date_added ) ) ?>
                                </td>
                                <?php
                            }
                        }
                        $td = 2 - count ( $previous_results );
                        for ( $loop = 1; $loop <= $td; $loop++ ) {
                            echo '<td></td>';
                        }
                    ?>
                    
                    <td align="center" <?php if ( ( isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] > 0 ) or $isParent ) echo ''; else if ( $test_info -> parent_id < 1 ) echo ''; ?>><?php echo @get_unit_by_id ( $unit ) ?></td>
                    <td align="center">
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
                        ?>
                        <tr>
                            <td align="left" style="padding-left: 15px">
                                <?php echo $sub_test_info -> name ?>
                            </td>
                            <td align="center"><?php echo @$subTest -> result ?></td>
                            <?php
                                if ( count ( $previous_results ) > 0 ) {
                                    foreach ( $previous_results as $previous_result ) {
                                        $previousResultTestIDS = get_child_tests_ids ( $previous_result -> test_id );
                                        $previousSubTests      = get_ipd_lab_test_results_by_ids ( $previous_result -> sale_id, $previousResultTestIDS -> ids, $previous_result -> id );
                                        ?>
                                        <td>
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
                            <td align="center"><?php echo @get_unit_by_id ( $sub_unit ) ?></td>
                            <td align="center">
                                <?php
                                    if ( count ( $sub_ranges ) > 0 ) {
                                        foreach ( $sub_ranges as $sub_range ) {
                                            if ( !empty( trim ( $sub_range -> gender ) ) )
                                                echo '<b>' . ucwords ( str_replace ( 'f', 'F', $sub_range -> gender ) ) . '</b>: ';
                                            
                                            if ( !empty( trim ( $sub_range -> start_range ) ) and !empty( trim ( $sub_range -> end_range ) ) )
                                                echo $sub_range -> start_range . ' - ' . $sub_range -> end_range . '<br/>';
                                            
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
        }
    ?>
    </tbody>
</table>
<div class="remarks">
    <h3>Remarks:</h3>
    <?php
        if ( count ( $tests ) > 0 ) {
            foreach ( $tests as $test ) {
                $test_info = get_test_by_id ( $test -> test_id );
                ?>
                <span> <?php echo '<strong>' . $test_info -> name . '</strong>'; ?> </span> -
                <span><?php echo !empty( trim ( $test -> remarks ) ) ? $test -> remarks : 'No remarks added.' ?></span>
                <br />
                
                <?php
            }
        }
    ?>
</div>

<?php if ( !empty( trim ( $note ) ) )
    echo '<br/><br/><br/><span style="font-size: 12px">' . $note . '</span>' ?>
</body>
</html>