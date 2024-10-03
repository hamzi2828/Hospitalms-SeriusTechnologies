<table class="table table-striped table-bordered table-hover" style="margin-top: 25px">
    <thead>
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center">
            <strong><?php echo $panelCount++ ?></strong>
        </td>
        <th colspan="6" style="color: #ff0000; font-size: 18px">
            <strong>GL - Consultants Share</strong>
        </th>
    </tr>
    <tr>
        <td></td>
        <th>Sr.No</th>
        <th>Consultant</th>
        <th>Opening Balance</th>
        <th>Debit</th>
        <th>Credit</th>
        <th>Running Balance</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter    = 1;
        $net_credit = 0;
        $net_debit  = 0;
        $net_rb     = 0;
        $start_date = $this -> input -> get ( 'start_date' );
        $start_date = !empty( $start_date ) ? $start_date : date ( 'Y-m-d' );
        
        if ( count ( $consultants ) > 0 ) {
            foreach ( $consultants as $consultant ) {
                $opening_balance = !empty( $start_date ) ? get_opening_balance_previous_than_searched_start_date ( $start_date, $consultant -> id ) : 0;
                $transaction     = calculate_acc_head_transaction ( $consultant -> id );
                $runningBalance  = 0;
                
                if ( !empty( $transaction ) && ( $transaction -> credit > 0 || $transaction -> debit > 0 ) ) {
                    $net_credit = $net_credit + $transaction -> credit;
                    $net_debit  = $net_debit + $transaction -> debit;
                    
                    if ( in_array ( $consultant -> role_id, array ( assets, expenditure ) ) )
                        $runningBalance = $runningBalance + $transaction -> credit - $transaction -> debit;
                    
                    else if ( in_array ( $consultant -> role_id, array ( liabilities, capitals, income ) ) )
                        $runningBalance = $runningBalance - $transaction -> credit + $transaction -> debit;
                    
                    $net_rb =+ $runningBalance;
                    ?>
                    <tr>
                        <td></td>
                        <td><?php echo $counter++ ?></td>
                        <td><?php echo $consultant -> title ?></td>
                        <td><?php echo number_format ( $opening_balance, 2 ) ?></td>
                        <td><?php echo number_format ( $transaction -> credit, 2 ) ?></td>
                        <td><?php echo number_format ( $transaction -> debit, 2 ) ?></td>
                        <td><?php echo number_format ( ( $runningBalance + $opening_balance ), 2 ) ?></td>
                    </tr>
                    <?php
                }
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="4"></th>
        <th>
            <strong><?php echo number_format ( $net_credit, 2 ) ?></strong>
        </th>
        <td></td>
        <th></th>
    </tr>
    </tfoot>
</table>