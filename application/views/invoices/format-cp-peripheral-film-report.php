
<table width="100%" style="font-size: 10pt; border-collapse: collapse;" cellpadding="5" border="0">
    <tbody>
    <tr>
    <td align="left" colspan="2" width="35%">
            <span style="font-weight: 900; font-size: 14px">
                <?php
                    $previous_results = get_previous_test_results ( $sale_id, CP_Peripheral_Film );
                    $testDetails      = get_test_by_id ( CP_Peripheral_Film );
                    echo '<strong>' . $testDetails -> report_title . '</strong>';
                ?>
            </span>
        </td>
    </tr>
    <tr>
        <td><strong>Haematology</strong></td>
    </tr>
    </tbody>
</table>

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 0; border: 0"
       cellpadding="4" border="0">
    <thead>
    <tr style="background: #f5f5f5;">
    
        <th align="left" style="width: 30%;">Test Name</th>
        <th align="left" style="width: 10%;">Results</th>
        <th colspan="2" align="center" style="width: 20%;">Previous Results</th>
        <th align="left" style="width: 10%;">Units</th>
        <th align="left" style="width: 20%;">Reference Ranges</th>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <td align="left" colspan="2" width="35%">
    </td>
    <tr>
   
        
        <?php
            if ( count ( $previous_results ) > 0 ) {
                foreach ( $previous_results as $key => $previous_result ) {
                    ?>
                    <td align="center">
                        <?php echo date ( 'd-m-Y', strtotime ( $previous_result -> date_added ) ) ?>
                    </td>
                    <?php
                }
                $td = 2 - count ( $previous_results );
                for ( $loop = 1; $loop <= $td; $loop++ ) {
                    echo '<td></td>';
                }
            }
            else
                echo '<td colspan="2"></td>';
        ?>
        
        <td colspan="2"></td>
    </tr>
    <?php
        if ( count ( cp_peripheral_film_general ) > 0 ) {
            foreach ( cp_peripheral_film_general as $test_id ) {
                $test_info        = get_test_by_id ( $test_id );
                $unit             = get_test_unit_id_by_id ( $test_id );
                $ranges           = get_reference_ranges_by_test_id ( $test_id );
                $result           = get_test_results ( $sale_id, $test_id );
                $previous_results = get_previous_test_results ( $sale_id, $test_id );
                ?>
                <tr>
                    <td align="left" style="font-size: 9pt" width="35%">
                        <?php echo $test_info -> report_title ?>
                    </td>
                    <td align="center" style="font-size: 9pt; <?php if ( $result -> abnormal == '1' )
                        echo 'color: #FF0000; font-weight: bold' ?>">
                        <?php echo $result -> result ?>
                    </td>
                    <?php
                        if ( count ( $previous_results ) > 0 ) {
                            foreach ( $previous_results as $previous_result ) {
                                $previousResultTestIDS = get_child_tests_ids ( $previous_result -> test_id );
                                $previousSubTests      = get_lab_test_results_by_ids ( $previous_result -> sale_id, $previousResultTestIDS -> ids, $previous_result -> id );
                                ?>
                                <td style="font-size: 9pt" align="center">
                                    <?php echo $previous_result -> result; ?>
                                </td>
                                <?php
                            }
                            $td = 2 - count ( $previous_results );
                            for ( $loop = 1; $loop <= $td; $loop++ ) {
                                echo '<td></td>';
                            }
                        }
                        else {
                            $td = 2 - count ( $previous_results );
                            for ( $loop = 1; $loop <= $td; $loop++ ) {
                                echo '<td></td>';
                            }
                        }
                    ?>
                    <td align="left" style="font-size: 9pt">
                        <?php echo @get_unit_by_id ( $unit ) ?>
                    </td>
                    <td align="left" style="font-size: 9pt">
                        <?php
                            if ( count ( $ranges ) > 0 ) {
                                foreach ( $ranges as $range ) {
                                    if ( !empty( trim ( $range -> gender ) ) )
                                        echo '<b>' . ucwords ( str_replace ( 'f', 'F', $range -> gender ) ) . '</b>: ';
                                    
                                    if ( !empty( trim ( $range -> start_range ) ) and !empty( trim ( $range -> end_range ) ) )
                                        echo $range -> start_range . '-' . $range -> end_range . '<br/>';
                                    
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
            }
        }
    ?>
    <tr>
        <td colspan="6" style="font-size: 9pt; padding-top: 30px">
            <strong>
                <u>Diff. Leuc. Count (DLC)</u>
            </strong>
        </td>
    </tr>
    <?php
        if ( count ( cp_peripheral_film_dlc ) > 0 ) {
            foreach ( cp_peripheral_film_dlc as $test_id ) {
                $test_info        = get_test_by_id ( $test_id );
                $unit             = get_test_unit_id_by_id ( $test_id );
                $ranges           = get_reference_ranges_by_test_id ( $test_id );
                $result           = get_test_results ( $sale_id, $test_id );
                $previous_results = get_previous_test_results ( $sale_id, $test_id );
                ?>
                <tr>
                    <td align="left" style="font-size: 9pt" width="35%">
                        <?php echo $test_info -> report_title ?>
                    </td>
                    <td align="center" style="font-size: 9pt; <?php if ( $result -> abnormal == '1' )
                        echo 'color: #FF0000; font-weight: bold' ?>">
                        <?php echo $result -> result ?>
                    </td>
                    <?php
                        if ( count ( $previous_results ) > 0 ) {
                            foreach ( $previous_results as $previous_result ) {
                                $previousResultTestIDS = get_child_tests_ids ( $previous_result -> test_id );
                                $previousSubTests      = get_lab_test_results_by_ids ( $previous_result -> sale_id, $previousResultTestIDS -> ids, $previous_result -> id );
                                ?>
                                <td style="font-size: 9pt" align="center">
                                    <?php echo $previous_result -> result; ?>
                                </td>
                                <?php
                            }
                            $td = 2 - count ( $previous_results );
                            for ( $loop = 1; $loop <= $td; $loop++ ) {
                                echo '<td></td>';
                            }
                        }
                        else {
                            $td = 2 - count ( $previous_results );
                            for ( $loop = 1; $loop <= $td; $loop++ ) {
                                echo '<td></td>';
                            }
                        }
                    ?>
                    <td align="left" style="font-size: 9pt">
                        <?php echo @get_unit_by_id ( $unit ) ?>
                    </td>
                    <td align="left" style="font-size: 9pt">
                        <?php
                            if ( count ( $ranges ) > 0 ) {
                                foreach ( $ranges as $range ) {
                                    if ( !empty( trim ( $range -> gender ) ) )
                                        echo '<b>' . ucwords ( str_replace ( 'f', 'F', $range -> gender ) ) . '</b>: ';
                                    
                                    if ( !empty( trim ( $range -> start_range ) ) and !empty( trim ( $range -> end_range ) ) )
                                        echo $range -> start_range . '-' . $range -> end_range . '<br/>';
                                    
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
            }
        }
    ?>
    <tr>
        <td colspan="6" style="font-size: 9pt; padding-top: 30px">
            <strong>
                <u>Red Cell Morphology</u>
            </strong>
        </td>
    </tr>
    <?php
        if ( count ( cp_peripheral_film_rcm ) > 0 ) {
            foreach ( cp_peripheral_film_rcm as $test_id ) {
                $test_info        = get_test_by_id ( $test_id );
                $unit             = get_test_unit_id_by_id ( $test_id );
                $ranges           = get_reference_ranges_by_test_id ( $test_id );
                $result           = get_test_results ( $sale_id, $test_id );
                $previous_results = get_previous_test_results ( $sale_id, $test_id );
                ?>
                <tr>
                    <td align="left" style="font-size: 9pt" width="35%">
                        <?php echo $test_info -> report_title ?>
                    </td>
                    <td align="center" style="font-size: 9pt; <?php if ( $result -> abnormal == '1' )
                        echo 'color: #FF0000; font-weight: bold' ?>">
                        <?php echo $result -> result ?>
                    </td>
                    <?php
                        if ( count ( $previous_results ) > 0 ) {
                            foreach ( $previous_results as $previous_result ) {
                                $previousResultTestIDS = get_child_tests_ids ( $previous_result -> test_id );
                                $previousSubTests      = get_lab_test_results_by_ids ( $previous_result -> sale_id, $previousResultTestIDS -> ids, $previous_result -> id );
                                ?>
                                <td style="font-size: 9pt" align="center">
                                    <?php echo $previous_result -> result; ?>
                                </td>
                                <?php
                            }
                            $td = 2 - count ( $previous_results );
                            for ( $loop = 1; $loop <= $td; $loop++ ) {
                                echo '<td></td>';
                            }
                        }
                        else {
                            $td = 2 - count ( $previous_results );
                            for ( $loop = 1; $loop <= $td; $loop++ ) {
                                echo '<td></td>';
                            }
                        }
                    ?>
                    <td align="left" style="font-size: 9pt">
                        <?php echo @get_unit_by_id ( $unit ) ?>
                    </td>
                    <td align="left" style="font-size: 9pt">
                        <?php
                            if ( count ( $ranges ) > 0 ) {
                                foreach ( $ranges as $range ) {
                                    if ( !empty( trim ( $range -> gender ) ) )
                                        echo '<b>' . ucwords ( str_replace ( 'f', 'F', $range -> gender ) ) . '</b>: ';
                                    
                                    if ( !empty( trim ( $range -> start_range ) ) and !empty( trim ( $range -> end_range ) ) )
                                        echo $range -> start_range . '-' . $range -> end_range . '<br/>';
                                    
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
            }
        }
    ?>
    </tbody>
</table>