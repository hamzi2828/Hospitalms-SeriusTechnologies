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
    <tr>
        <td align="left" colspan="2">
            <span style="font-weight: 900; font-size: 14px">
                <?php
                    $testDetails = get_test_by_id ( URINE_RE );
                    echo '<strong>' . $testDetails -> report_title . '</strong>';
                ?>
            </span>
        </td>
        
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
    <tr>
        <td colspan="4" style="font-size: 9pt; padding-top: 10px; border-bottom: 0">
            <strong>
                <u>Physical Examination</u>
            </strong>
        </td>
    </tr>
    <?php
        if ( count ( urine_r_e_physical_examination ) > 0 ) {
            foreach ( urine_r_e_physical_examination as $key => $test_id ) {
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
                        <?php echo @$result -> result ?>
                    </td>
                    <?php
                        if ( count ( $previous_results ) > 0 ) {
                            foreach ( $previous_results as $previous_result ) {
                                $previousResultTestIDS = get_child_tests_ids ( $previous_result -> test_id );
                                $previousSubTests      = get_lab_test_results_by_ids ( $previous_result -> sale_id, $previousResultTestIDS -> ids, $previous_result -> id );
                                ?>
                                <td style="font-size: 8px" align="center">
                                    <?php echo $previous_result -> result; ?>
                                </td>
                                <?php
                            }
                        }
                        $td = 2 - count ( $previous_results );
                        for ( $loop = 1; $loop <= $td; $loop++ ) {
                            echo '<td></td>';
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
        <td colspan="4" style="font-size: 9pt; padding-top: 10px; border-bottom: 0">
            <strong>
                <u>Chemical Examination</u>
            </strong>
        </td>
    </tr>
    <?php
        if ( count ( urine_r_e_chemical_examination ) > 0 ) {
            foreach ( urine_r_e_chemical_examination as $key => $test_id ) {
                $test_info        = get_test_by_id ( $test_id );
                $unit             = get_test_unit_id_by_id ( $test_id );
                $ranges           = get_reference_ranges_by_test_id ( $test_id );
                $result           = get_test_results ( $sale_id, $test_id );
                $previous_results = get_previous_test_results ( $sale_id, $test_id );
                ?>
                <tr>
                    <td align="left" style="font-size: 9pt">
                        <?php echo $test_info -> report_title ?>
                    </td>
                    <td align="center" style="font-size: 9pt; <?php if ( $result -> abnormal == '1' )
                        echo 'color: #FF0000; font-weight: bold' ?>">
                        <?php echo @$result -> result ?>
                    </td>
                    <?php
                        if ( count ( $previous_results ) > 0 ) {
                            foreach ( $previous_results as $previous_result ) {
                                $previousResultTestIDS = get_child_tests_ids ( $previous_result -> test_id );
                                $previousSubTests      = get_lab_test_results_by_ids ( $previous_result -> sale_id, $previousResultTestIDS -> ids, $previous_result -> id );
                                ?>
                                <td style="font-size: 8px" align="center">
                                    <?php echo $previous_result -> result; ?>
                                </td>
                                <?php
                            }
                        }
                        $td = 2 - count ( $previous_results );
                        for ( $loop = 1; $loop <= $td; $loop++ ) {
                            echo '<td></td>';
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
        <td colspan="4" style="font-size: 9pt; padding-top: 10px; border-bottom: 0">
            <strong>
                <u>Microscopic Examination</u>
            </strong>
        </td>
    </tr>
    <?php
        if ( count ( urine_r_e_microscopic_examination ) > 0 ) {
            foreach ( urine_r_e_microscopic_examination as $key => $test_id ) {
                $test_info        = get_test_by_id ( $test_id );
                $unit             = get_test_unit_id_by_id ( $test_id );
                $ranges           = get_reference_ranges_by_test_id ( $test_id );
                $result           = get_test_results ( $sale_id, $test_id );
                $previous_results = get_previous_test_results ( $sale_id, $test_id );
                ?>
                <tr>
                    <td align="left" style="font-size: 9pt">
                        <?php echo $test_info -> report_title ?>
                    </td>
                    <td align="center" style="font-size: 9pt; <?php if ( $result -> abnormal == '1' )
                        echo 'color: #FF0000; font-weight: bold' ?>">
                        <?php echo @$result -> result ?>
                    </td>
                    <?php
                        if ( count ( $previous_results ) > 0 ) {
                            foreach ( $previous_results as $previous_result ) {
                                $previousResultTestIDS = get_child_tests_ids ( $previous_result -> test_id );
                                $previousSubTests      = get_lab_test_results_by_ids ( $previous_result -> sale_id, $previousResultTestIDS -> ids, $previous_result -> id );
                                ?>
                                <td style="font-size: 8px" align="center">
                                    <?php echo $previous_result -> result; ?>
                                </td>
                                <?php
                            }
                        }
                        $td = 2 - count ( $previous_results );
                        for ( $loop = 1; $loop <= $td; $loop++ ) {
                            echo '<td></td>';
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