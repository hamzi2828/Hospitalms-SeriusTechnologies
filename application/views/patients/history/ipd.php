<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'ipd' )
    echo 'active' ?>">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th> Sr. No</th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
            <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
            <th> Total</th>
            <th> Net Total</th>
            <th> Initial Deposit</th>
            <th> Payment Received</th>
            <th> Due Payment</th>
            <th> Date Discharged</th>
            <th> Date Added</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $counter = 1;
            if ( count ( $sales ) > 0 ) {
                foreach ( $sales as $sale ) {
                    $patient     = get_patient ( $sale -> patient_id );
                    $sale_info   = get_ipd_sale ( $sale -> sale_id );
                    $date        = get_ipd_discharged_date ( $sale -> sale_id );
                    $services    = get_ipd_patient_associated_services ( $sale -> patient_id, $sale -> sale_id );
                    $name        = get_patient_name ( 0, $patient );
                    $received    = count_ipd_payment_received ( $sale -> sale_id );
                    $due_payment = ( $sale_info -> total > 0 ? $sale_info -> net_total : $sale_info -> total ) - $sale_info -> initial_deposit - $received;
                    ?>
                    <tr class="odd gradeX">
                        <td> <?php echo $counter++ ?> </td>
                        <td><?php echo $patient -> id ?></td>
                        <td><?php echo $name ?></td>
                        <td><?php echo $sale -> sale_id ?></td>
                        <td><?php echo $sale_info -> total ?></td>
                        <td><?php echo $sale_info -> total > 0 ? $sale_info -> net_total : $sale_info -> total ?></td>
                        <td><?php echo $sale_info -> initial_deposit ?></td>
                        <td><?php echo $received ?></td>
                        <td><?php echo $due_payment ?></td>
                        <td><?php echo !empty( trim ( $date -> date_discharged ) ) ? date_setter ( $date -> date_discharged ) : '' ?></td>
                        <td><?php echo date_setter ( $sale -> date_added ) ?></td>
                    </tr>
                    <?php
                }
            }
        ?>
        </tbody>
    </table>
</div>