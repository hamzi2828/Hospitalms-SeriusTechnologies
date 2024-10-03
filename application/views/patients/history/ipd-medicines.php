<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'ipd-medicines' ) echo 'active' ?>">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th> Sr. No</th>
            <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
            <th> Medicine</th>
            <th> Batch</th>
            <th> Quantity</th>
            <th> Price</th>
            <th> Net Price</th>
            <th> Date Added</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $counter = 1;
            $total   = 0;
            if ( count ( $medicines ) > 0 ) {
                foreach ( $medicines as $medicine ) {
                    $patient = get_patient ( $medicine -> patient_id );
                    $sale    = get_sale ( $medicine -> sale_id );
                    $name    = get_patient_name ( 0, $patient );
                    ?>
                    <tr class="odd gradeX">
                        <td> <?php echo $counter++ ?> </td>
                        <td><?php echo $medicine -> sale_id ?></td>
                        <td><?php echo $patient -> id ?></td>
                        <td><?php echo $name ?></td>
                        <td>
                            <?php
                                $medicines_info = explode ( ',', $medicine -> medicines );
                                if ( count ( $medicines_info ) > 0 ) {
                                    foreach ( $medicines_info as $key => $value ) {
                                        $medicine_detail = get_medicine ( $value );
                                        $strength        = get_strength ( $medicine_detail -> strength_id );
                                        $form            = get_form ( $medicine_detail -> form_id );
                                        echo $medicine_detail -> name . ' ' . $strength -> title . ' ' . $form -> title . '<br>';
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                $stocks = explode ( ',', $medicine -> stocks );
                                if ( count ( $stocks ) > 0 ) {
                                    foreach ( $stocks as $key => $value ) {
                                        $stock = get_stock ( $value );
                                        echo $stock -> batch . '<br>';
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                $quantities = explode ( ',', $medicine -> quantities );
                                if ( count ( $quantities ) > 0 ) {
                                    foreach ( $quantities as $quantity ) {
                                        echo $quantity . '<br>';
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                $prices = explode ( ',', $medicine -> prices );
                                if ( count ( $prices ) > 0 ) {
                                    foreach ( $prices as $price ) {
                                        echo $price . '<br>';
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                $net_prices = explode ( ',', $medicine -> net_prices );
                                if ( count ( $net_prices ) > 0 ) {
                                    foreach ( $net_prices as $net_price ) {
                                        echo $net_price . '<br>';
                                        $total = $total + $net_price;
                                    }
                                }
                            ?>
                        </td>
                        <td><?php echo date_setter ( $medicine -> date_added ) ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="8"></td>
                    <td>
                        <strong><?php echo $total ?></strong>
                    </td>
                    <td></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
    </table>
</div>