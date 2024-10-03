<table width="100%" style="font-size: 10pt; border-collapse: collapse;" cellpadding="5" border="0">
    <tbody>
    <tr>
        <td>
            <strong><?php echo @$testInfo -> report_title; ?></strong>
        </td>
    </tr>
    </tbody>
</table>
<table class="items" width="100%" style="font-size: 10pt; border-collapse: collapse; margin-top: 0; border: 0"
       cellpadding="4" border="0">
    <thead>
    <tr style="background: #FFFFFF;">
        <th align="left">
            <u>Test Name</u>
        </th>
        <th align="center">
            <u>Results</u>
        </th>
        <th align="left">
            <u>Units</u>
        </th>
        <th align="left">
            <u>Reference Ranges</u>
        </th>
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