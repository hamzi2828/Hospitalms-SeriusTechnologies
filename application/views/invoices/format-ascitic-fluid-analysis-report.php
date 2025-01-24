<table width="100%" style="font-size: 10pt; border-collapse: collapse;" cellpadding="5" border="0">
    <tbody>
    <tr>
    <td align="left" colspan="2" width="35%">
            <span style="font-weight: 900; font-size: 14px">
                <?php
                    $previous_results = get_previous_test_results ( $sale_id, Ascitic_Fluid_Analysis );
                    $testDetails      = get_test_by_id ( Ascitic_Fluid_Analysis );
                    echo '<strong>' . $testDetails -> report_title . '</strong>';
                ?>
            </span>
        </td>
    </tr>
    </tbody>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 0px; border: 0"
       cellpadding="8" border="0">
    <thead>

         

    <tr style="background: #f5f5f5;">
            <th align="left" style="width: 30%;">Test Name</th>
            <th align="center" style="width: 10%;">Results</th>
            <th align="left" style="width: 10%;">Units</th>
            <th align="left" style="width: 20%;">Reference Ranges</th>
        </tr>


    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <tr>
        <td colspan="6">
            <strong><u>Physical Examination</u></strong>
        </td>
    </tr>
    <?php
        if ( count ( afa_physical_examination ) > 0 ) {
            foreach ( afa_physical_examination as $test_id ) {
                $test_info = get_test_by_id ( $test_id );
                $unit = get_test_unit_id_by_id ( $test_id );
                $ranges = get_reference_ranges_by_test_id ( $test_id );
                $result = get_test_results ( $sale_id, $test_id );
                ?>
                <tr>
                    <td align="left" width="30%" style="font-size: 9pt">
                        <?php echo $test_info -> report_title ?>
                    </td>
                    <td align="center" width="20%" style="font-size: 9pt; <?php if ( $result -> abnormal == '1' )
                        echo 'color: #FF0000; font-weight: bold' ?>">
                        <?php echo @$result -> result ?>
                    </td>
                    <td align="left" width="20%" style="font-size: 9pt">
                        <?php echo @get_unit_by_id ( $unit ) ?>
                    </td>
                    <td align="left" width="30%" style="font-size: 9pt">
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
        <td colspan="4" style="font-size: 10pt; padding-top: 30px">
            <strong>
                <u>Chemical Examination</u>
            </strong>
        </td>
    </tr>
    <?php
        if ( count ( afa_chemical_examination ) > 0 ) {
            foreach ( afa_chemical_examination as $test_id ) {
                $test_info = get_test_by_id ( $test_id );
                $unit = get_test_unit_id_by_id ( $test_id );
                $ranges = get_reference_ranges_by_test_id ( $test_id );
                $result = get_test_results ( $sale_id, $test_id );
                ?>
                <tr>
                    <td align="left" width="30%" style="font-size: 9pt">
                        <?php echo $test_info -> report_title ?>
                    </td>
                    <td align="center" width="20%" style="font-size: 9pt; <?php if ( $result -> abnormal == '1' )
                        echo 'color: #FF0000; font-weight: bold' ?>">
                        <?php echo @$result -> result ?>
                    </td>
                    <td align="left" width="20%" style="font-size: 9pt">
                        <?php echo @get_unit_by_id ( $unit ) ?>
                    </td>
                    <td align="left" width="30%" style="font-size: 9pt">
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
        <td colspan="4" style="font-size: 10pt; padding-top: 30px">
            <strong>
                <u>Microscopic Examination</u>
            </strong>
        </td>
    </tr>
    <?php
        if ( count ( afa_microscopic_examination ) > 0 ) {
            foreach ( afa_microscopic_examination as $test_id ) {
                $test_info = get_test_by_id ( $test_id );
                $unit = get_test_unit_id_by_id ( $test_id );
                $ranges = get_reference_ranges_by_test_id ( $test_id );
                $result = get_test_results ( $sale_id, $test_id );
                ?>
                <tr>
                    <td align="left" width="30%" style="font-size: 9pt">
                        <?php echo $test_info -> report_title ?>
                    </td>
                    <td align="center" width="20%" style="font-size: 9pt; <?php if ( $result -> abnormal == '1' )
                        echo 'color: #FF0000; font-weight: bold' ?>">
                        <?php echo @$result -> result ?>
                    </td>
                    <td align="left" width="20%" style="font-size: 9pt">
                        <?php echo @get_unit_by_id ( $unit ) ?>
                    </td>
                    <td align="left" width="30%" style="font-size: 9pt">
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
        <td colspan="4" style="font-size: 10pt; padding-top: 30px">
            <strong>
                <u>Diff. Leuc. Count (DLC)</u>
            </strong>
        </td>
    </tr>
    <?php
        if ( count ( afa_dlc ) > 0 ) {
            foreach ( afa_dlc as $test_id ) {
                $test_info = get_test_by_id ( $test_id );
                $unit = get_test_unit_id_by_id ( $test_id );
                $ranges = get_reference_ranges_by_test_id ( $test_id );
                $result = get_test_results ( $sale_id, $test_id );
                ?>
                <tr>
                    <td align="left" width="30%" style="font-size: 9pt">
                        <?php echo $test_info -> report_title ?>
                    </td>
                    <td align="center" width="20%" style="font-size: 9pt; <?php if ( $result -> abnormal == '1' )
                        echo 'color: #FF0000; font-weight: bold' ?>">
                        <?php echo @$result -> result ?>
                    </td>
                    <td align="left" width="20%" style="font-size: 9pt">
                        <?php echo @get_unit_by_id ( $unit ) ?>
                    </td>
                    <td align="left" width="30%" style="font-size: 9pt">
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