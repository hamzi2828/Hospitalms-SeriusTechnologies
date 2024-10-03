<table class="table table-striped table-bordered table-hover" style="margin-top: 25px">
    <thead>
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center">
            <strong><?php echo $panelCount++ ?></strong>
        </td>
        <th colspan="14" style="color: #ff0000; font-size: 18px">
            <strong>Lab Doctor's Share</strong>
        </th>
    </tr>
    <tr>
        <th></th>
        <th> Sr. No</th>
        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th> Test</th>
        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
        <th> Patient Type</th>
        <th> Doctor(s)</th>
        <th> Price</th>
        <th> Discount(%)</th>
        <th> Discount(Flat)</th>
        <th> Paid Amount</th>
        <th> Net Amount</th>
        <th> Doctor's Share (%)</th>
        <th> Doctor's Share Value</th>
        <th> Remarks</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter             = 1;
        $total               = 0;
        $p_total             = 0;
        $total_flat_discount = 0;
        $totalPaidAmount     = 0;
        $doctorShareNet      = 0;
        if ( count ( $reports ) > 0 ) {
            foreach ( $reports as $report ) {
                $patient   = get_patient ( $report -> patient_id );
                $sale      = get_lab_sale ( $report -> sale_id );
                $tests     = explode ( ',', $report -> tests );
                $receiving = get_lab_sale_receiving ( $report -> sale_id );
                $saleInfo  = get_lab_sale ( $report -> sale_id );
                
                if ( $report -> refunded !== '1' )
                    $p_total = $p_total + $report -> price;
                
                $netReceiving = 0;
                if ( count ( $receiving ) > 0 ) {
                    foreach ( $receiving as $received ) {
                        $netReceiving += $received -> amount;
                    }
                }
                
                if ( $report -> refunded != '1' )
                    $total_flat_discount = $total_flat_discount + $sale -> flat_discount;
                
                $netPrice = $report -> price;
                
                if ( $sale -> discount > 0 )
                    $netPrice = $netPrice - ( $netPrice * ( $sale -> discount / 100 ) );
                if ( $sale -> flat_discount > 0 )
                    $netPrice = $netPrice - $sale -> flat_discount;
                $netPrice     = $netPrice - $sale -> paid_amount;
                $saleTotal    = get_lab_sales_total ( $report -> sale_id );
                $doctor_share = $saleInfo -> doctor_share;
                
                if ( $report -> refunded !== '1' ) {
                    $totalPaidAmount = $totalPaidAmount + $sale -> paid_amount;
                    $total           = $total + $saleInfo -> total;
                    $doctorShareNet  += ( $saleInfo -> net * ( $saleInfo -> doctor_share / 100 ) );
                }
                
                $totalPaidAmount = $totalPaidAmount - $netReceiving;
                ?>
                <tr>
                    <td></td>
                    <td> <?php echo $counter++ ?> </td>
                    <td> <?php echo $report -> sale_id ?> </td>
                    <td>
                        <?php
                            if ( count ( $tests ) > 0 ) {
                                foreach ( $tests as $test ) {
                                    if ( !check_if_test_is_child ( $test ) )
                                        echo get_test_by_id ( $test ) -> name . '<br>';
                                }
                            } ?>
                    </td>
                    <td>
                        <?php
                            echo get_patient_name ( 0, $patient );
                            if ( $report -> refunded == '1' ) {
                                echo '<span class="badge badge-danger">Refunded</span>';
                            }
                        ?>
                    </td>
                    <td> <?php echo $patient -> panel_id > 0 ? get_panel_by_id ( $patient -> panel_id ) -> name : 'Cash' ?> </td>
                    <td>
                        <?php
                            if ( $saleInfo -> doctor_id > 0 )
                                echo get_doctor ( $saleInfo -> doctor_id ) -> name . '<br>';
                            else
                                echo '-';
                        ?>
                    </td>
                    <td><?php echo number_format ( $saleInfo -> net, 2 ) ?></td>
                    <td> <?php echo $sale -> discount ?> </td>
                    <td>
                        <?php
                            if ( $report -> refunded == '1' and !empty( trim ( $report -> remarks ) ) )
                                echo '-' . $sale -> flat_discount;
                            else
                                echo $sale -> flat_discount;
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( $report -> refunded == '1' and !empty( trim ( $report -> remarks ) ) )
                                echo '-' . ( $sale -> paid_amount - $netReceiving );
                            else
                                echo ( $sale -> paid_amount - $netReceiving );
                            
                            if ( count ( $receiving ) > 0 ) {
                                echo '<br/>';
                                foreach ( $receiving as $received ) {
                                    $receivedBy = get_user ( $received -> user_id );
                                    echo '<small>' . number_format ( $received -> amount, 2 ) . ' received by ' . $receivedBy -> name . '</small> <br/>';
                                }
                            }
                        
                        ?>
                    </td>
                    <td><?php echo number_format ( $saleInfo -> total, 2 ) ?></td>
                    <td>
                        <?php
                            if ( $doctor_share > 0 ) {
                                echo $saleInfo -> doctor_share . '%';
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( $doctor_share > 0 ) {
                                echo ( $saleInfo -> net * ( $saleInfo -> doctor_share / 100 ) );
                            }
                        ?>
                    </td>
                    <td> <?php echo $report -> remarks ?> </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="7" class="text-right"></td>
                <td>
                    <b><?php echo number_format ( $p_total, 2 ) ?></b>
                </td>
                <td class="text-right"></td>
                <td>
                    <b><?php echo number_format ( $total_flat_discount, 2 ) ?></b>
                </td>
                <td>
                    <b><?php echo number_format ( $totalPaidAmount, 2 ) ?></b>
                </td>
                <td>
                    <b><?php echo number_format ( $total, 2 ) ?></b>
                </td>
                <td></td>
                <td>
                    <b><?php echo number_format ( $doctorShareNet, 2 ) ?></b>
                </td>
                <td></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>