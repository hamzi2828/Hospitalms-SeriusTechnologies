<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'ipd-services' ) echo 'active' ?>">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th> Sr. No</th>
            <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
            <th> Doctor</th>
            <th> Services</th>
            <th> Prices</th>
            <th> Net Price</th>
            <th> Date Added</th>
            <th> Date Discharged</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $counter = 1;
            $total   = 0;
            if ( count ( $services ) > 0 ) {
                foreach ( $services as $service ) {
                    $patient     = get_patient ( $service -> patient_id );
                    $service_net = get_opd_sale ( $service -> sale_id );
                    $name        = get_patient_name ( 0, $patient );
                    $date        = get_ipd_discharged_date ( $service -> sale_id );
                    $consultants = get_consultants ( $service -> sale_id );
                    ?>
                    <tr class="odd gradeX">
                        <td> <?php echo $counter++ ?> </td>
                        <td><?php echo $service -> sale_id ?></td>
                        <td><?php echo $patient -> id ?></td>
                        <td><?php echo $name ?></td>
                        <td>
                            <?php
                                if ( count ( $consultants ) > 0 ) {
                                    foreach ( $consultants as $consultant )
                                        if ( $consultant -> service_id > 0 ) {
                                            echo get_ipd_service_by_id ( $consultant -> service_id ) -> title . ' / ' . get_doctor ( $consultant -> doctor_id ) -> name . '<br>';
                                        }
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                $services_info = explode ( ',', $service -> services );
                                if ( count ( $services_info ) > 0 ) {
                                    foreach ( $services_info as $key => $value ) {
                                        $service_details = get_ipd_service_by_id ( $value );
                                        echo $service_details -> title . '<br>';
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                $prices = explode ( ',', $service -> prices );
                                if ( count ( $prices ) > 0 ) {
                                    foreach ( $prices as $price ) {
                                        echo number_format ( $price, 2 ) . '<br>';
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                $net_prices = explode ( ',', $service -> net_prices );
                                if ( count ( $net_prices ) > 0 ) {
                                    foreach ( $net_prices as $net_price ) {
                                        echo number_format ( $net_price, 2 ) . '<br>';
                                        $total = $total + $net_price;
                                    }
                                }
                            ?>
                        </td>
                        <td><?php echo date_setter ( $service -> date_added ) ?></td>
                        <td><?php echo !empty( trim ( $date -> date_discharged ) ) ? date_setter ( $date -> date_discharged ) : '' ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="7"></td>
                    <td>
                        <strong><?php echo number_format ( $total, 2 ) ?></strong>
                    </td>
                    <td colspan="2"></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
    </table>
</div>