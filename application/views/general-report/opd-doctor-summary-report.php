<table class="table table-striped table-bordered table-hover" style="margin-top: 25px">
    <thead>
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center">
            <strong><?php echo $panelCount++ ?></strong>
        </td>
        <th colspan="14" style="color: #ff0000; font-size: 18px">
            <strong>OPD Doctor's Share</strong>
        </th>
    </tr>
    <tr>
        <th></th>
        <th> Sr. No</th>
        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
        <th> Doctor(s)</th>
        <th> Service(s)</th>
        <th> Price</th>
        <th> Total</th>
        <th> Discount (%)</th>
        <th> Discount (Flat)</th>
        <th> Net Price</th>
        <th> Doctor's Share (%)</th>
        <th> Doctor's Share (Value)</th>
        <th> Refunded</th>
        <th> Refund Reason</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter        = 1;
        $total          = 0;
        $net            = 0;
        $doctorNetShare = 0;
        if ( count ( $sales ) > 0 ) {
            foreach ( $sales as $sale ) {
                $patient   = get_patient ( $sale -> patient_id );
                $sale_info = get_opd_sale ( $sale -> sale_id );
                
                if ( $sale_info -> refund !== '1' ) {
                    $total          = $total + $sale_info -> net;
                    $net            += $sale -> net_price;
                    $doctorNetShare += ( $sale_info -> total * ( $sale_info -> doctor_share / 100 ) );
                }
                
                $refunded = $sale_info -> refund == '1' ? 'Yes' : 'No';
                ?>
                <tr class="odd gradeX">
                    <td></td>
                    <td> <?php echo $counter++ ?> </td>
                    <td><?php echo $sale -> sale_id ?></td>
                    <td>
                        <?php echo get_patient_name ( 0, $patient ) ?>
                        <?php
                            if ( $sale_info -> refund == '1' ) {
                                echo '<span class="badge badge-danger">Refunded</span>';
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( $sale_info -> doctor_id > 0 )
                                echo get_doctor ( $sale_info -> doctor_id ) -> name . '<br>';
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php
                            $services = explode ( ',', $sale -> services );
                            if ( count ( $services ) > 0 ) {
                                foreach ( $services as $service ) {
                                    echo get_service_by_id ( $service ) -> title . '<br>';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            $prices = explode ( ',', $sale -> prices );
                            if ( count ( $prices ) > 0 ) {
                                foreach ( $prices as $price ) {
                                    echo $price . '<br>';
                                }
                            }
                        ?>
                    </td>
                    <td><?php echo $sale -> net_price ?></td>
                    <td><?php echo $sale_info -> discount ?></td>
                    <td><?php echo $sale_info -> flat_discount ?></td>
                    <td><?php echo $sale_info -> net ?></td>
                    <td>
                        <?php
                            $doctor_share = $sale_info -> doctor_share;
                            if ( $doctor_share > 0 )
                                echo $sale_info -> doctor_share . '%';
                        ?>
                    </td>
                    <td>
                        <?php
                            $doctor_share = $sale_info -> doctor_share;
                            if ( $doctor_share > 0 )
                                echo ( $sale_info -> total * ( $sale_info -> doctor_share / 100 ) );
                        ?>
                    </td>
                    <td><?php echo $refunded ?></td>
                    <td><?php echo $sale_info -> refund_reason ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="7"></td>
                <td>
                    <strong><?php echo number_format ( $net, 2 ) ?></strong>
                </td>
                <td colspan="2"></td>
                <td>
                    <strong><?php echo number_format ( $total, 2 ) ?></strong>
                </td>
                <td></td>
                <td>
                    <strong><?php echo number_format ( $doctorNetShare, 2 ) ?></strong>
                </td>
                <td colspan="3"></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>