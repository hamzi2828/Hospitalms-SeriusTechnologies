<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'services' ) echo 'active' ?>">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th> Sr. No</th>
            <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
            <th> Services</th>
            <th> Prices</th>
            <th> Discounts</th>
            <th> Net Price</th>
            <th> Net Discount</th>
            <th> Net Total</th>
            <th> Date Added</th>
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
                    $total       = $total + $service_net -> net;
                    $name        = get_patient_name ( 0, $patient );
                    ?>
                    <tr class="odd gradeX">
                        <td> <?php echo $counter++ ?> </td>
                        <td><?php echo $service -> sale_id ?></td>
                        <td><?php echo $patient -> id ?></td>
                        <td><?php echo $name ?></td>
                        <td>
                            <?php
                                $services_info = explode ( ',', $service -> services );
                                if ( count ( $services_info ) > 0 ) {
                                    foreach ( $services_info as $key => $value ) {
                                        $service_details = get_service_by_id ( $value );
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
                                $discounts = explode ( ',', $service -> discounts );
                                if ( count ( $discounts ) > 0 ) {
                                    foreach ( $discounts as $discount ) {
                                        echo number_format ( $discount, 2 ) . '<br>';
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
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php echo number_format ( $service_net -> discount, 2 ) ?>
                        </td>
                        <td>
                            <?php echo number_format ( $service_net -> net, 2 ) ?>
                        </td>
                        <td><?php echo date_setter ( $service -> date_added ) ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="9"></td>
                    <td>
                        <strong><?php echo number_format ( $total, 2 ) ?></strong>
                    </td>
                    <td></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
    </table>
</div>