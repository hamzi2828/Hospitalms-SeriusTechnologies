
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

<table class="items" width="100%" style="font-size: 10pt; border-collapse: collapse; margin-top: 0; border: 0"
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
        <?php
        if (count(cp_peripheral_film_general) > 0) {
            foreach (cp_peripheral_film_general as $test_id) {
                $test_info = get_test_by_id($test_id);
                $unit = get_test_unit_id_by_id($test_id);
                $ranges = get_reference_ranges_by_test_id($test_id);
                $result = get_test_results($sale_id, $test_id);
                $previous_results = get_previous_test_results($sale_id, $test_id);
                ?>
                <tr>
                    <!-- Test Name -->
                    <td align="left" style="font-size: 9pt" width="35%">
                        <?php echo $test_info->report_title ?>
                    </td>
                    <!-- Results with abnormal check -->
                    <td align="center" style="font-size: 9pt; <?php if ($result->abnormal == '1') echo 'color: #FF0000; font-weight: bold;' ?>">
                        <?php echo $result->result ?>
                    </td>
                    <!-- Previous Results -->
                    <?php
                    if (count($previous_results) > 0) {
                        foreach ($previous_results as $previous_result) {
                            ?>
                            <td style="font-size: 9pt" align="center">
                                <?php echo $previous_result->result; ?>
                            </td>
                            <?php
                        }
                        // Fill empty cells for remaining previous result columns
                        $td = 2 - count($previous_results);
                        for ($loop = 1; $loop <= $td; $loop++) {
                            echo '<td></td>';
                        }
                    } else {
                        echo '<td colspan="2"></td>';
                    }
                    ?>
                    <!-- Units -->
                    <td align="left" style="font-size: 9pt">
                        <?php echo @get_unit_by_id($unit) ?>
                    </td>
                    <!-- Reference Ranges -->
                    <td align="left" style="font-size: 9pt">
                        <?php
                        if (count($ranges) > 0) {
                            foreach ($ranges as $range) {
                                if (!empty(trim($range->gender))) {
                                    echo '<b>' . ucwords(str_replace('f', 'F', $range->gender)) . '</b>: ';
                                }
                                if (!empty(trim($range->start_range)) && !empty(trim($range->end_range))) {
                                    echo $range->start_range . '-' . $range->end_range . '<br/>';
                                } elseif (!empty(trim($range->start_range))) {
                                    echo $range->start_range . '<br/>';
                                } elseif (!empty(trim($range->end_range))) {
                                    echo $range->end_range . '<br/>';
                                }
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
