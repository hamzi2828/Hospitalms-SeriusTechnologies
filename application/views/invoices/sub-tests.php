<?php
    if ( count ( $sub_tests ) > 0 ) {
        foreach ( $sub_tests as $sub_test ) {
            $result               = get_test_results ( $test -> sale_id, $sub_test -> id );
            $sub_test_info        = get_test_by_id ( $sub_test -> id );
            $sub_previous_results = get_previous_test_results ( $test -> sale_id, $sub_test -> id );
            $sub_unit             = get_test_unit_id_by_id ( $sub_test -> id );
            $sub_ranges           = get_reference_ranges_by_test_id ( $sub_test -> id );
            
            if ( !empty( $result ) && !empty( trim ( $result -> result ) ) ) {
                ?>
                <tr>
                    <td align="left">
                        <?php $style = 'style="font-weight: 900; font-size: 9pt"'; ?>
                        <span <?php echo $style ?>>
                        <?php echo $sub_test_info -> report_title; ?>
                    </span>
                    </td>
                    
                    <td align="left" style="font-weight: 900; font-size: 9pt">
                        <?php
                            if ( $sub_test_info -> category == 'covid' )
                                echo $result -> detected == 'detected' ? 'Detected' : 'Not Detected';
                            else
                                echo $result -> result;
                        ?>
                    </td>
                    
                    <?php
                        if ( count ( $sub_previous_results ) > 0 ) {
                            foreach ( $sub_previous_results as $key => $previous_result ) {
                                ?>
                                <td>
                                    <?php echo @$previous_result -> result; ?>
                                </td>
                                <?php
                            }
                        }
                        $td = 2 - count ( $sub_previous_results );
                        for ( $loop = 1; $loop <= $td; $loop++ ) {
                            echo '<td></td>';
                        }
                    ?>
                    
                    <td align="left"
                        style="font-weight: 900; font-size: 9pt"><?php echo @get_unit_by_id ( $sub_unit ) ?></td>
                    <td align="left" style="font-weight: 900; font-size: 9pt">
                        <?php
                            if ( count ( $sub_ranges ) > 0 ) {
                                foreach ( $sub_ranges as $range ) {
                                    if ( !empty( trim ( $range -> gender ) ) )
                                        echo '<b>' . ucwords ( str_replace ( 'f', 'F', $range -> gender ) ) . '</b>: ';
                                    echo $range -> start_range . '-' . $range -> end_range . '<br/>';
                                }
                            }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    }