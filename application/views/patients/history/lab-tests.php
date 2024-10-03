<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'lab-tests' )
    echo 'active' ?>">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th> Sr. No</th>
            <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
            <th> Tests</th>
            <th> Price</th>
            <th> Discount</th>
            <th> Total</th>
            <th> Date Added</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $counter = 1;
            $total   = 0;
            if ( count ( $sales ) > 0 ) {
                foreach ( $sales as $sale ) {
                    $patient   = get_patient ( $sale -> patient_id );
                    $sale_info = get_lab_sale ( $sale -> sale_id );
                    $total     = $total + $sale_info -> total;
                    $name      = get_patient_name ( 0, $patient );
                    ?>
                    <tr class="odd gradeX">
                        <td> <?php echo $counter++ ?> </td>
                        <td><?php echo $sale -> sale_id ?></td>
                        <td><?php echo $patient -> id ?></td>
                        <td><?php echo $name ?></td>
                        <td>
                            <?php
                                $tests = explode ( ',', $sale -> tests );
                                if ( count ( $tests ) > 0 ) {
                                    foreach ( $tests as $test ) {
                                        $test_detail = get_test_by_id ( $test );
                                        echo $test_detail -> name . '<br>';
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                $prices = explode ( ',', $sale -> prices );
                                if ( count ( $prices ) > 0 ) {
                                    foreach ( $prices as $price ) {
                                        echo number_format ( $price, 2 ) . '<br>';
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php echo number_format ( $sale_info -> discount, 2 ) ?>
                        </td>
                        <td>
                            <?php echo number_format ( $sale_info -> total, 2 ) ?>
                        </td>
                        <td><?php echo date_setter ( $sale -> date_added ) ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="7"></td>
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