<?php
    $expense_account_credit = 0;
    if ( count ( $expenses_account_head ) > 0 ) {
        foreach ( $expenses_account_head as $expense_account_head ) {
            $childAccHeads          = get_child_account_heads_data ( $expense_account_head -> id );
            $acc_head_id            = $expense_account_head -> id;
            $transaction            = calculate_acc_head_transaction ( $acc_head_id );
            $expense_account_credit = abs ( $expense_account_credit + $transaction -> debit );
            ?>
            <tr>
                <td>
                    <strong>
                        <?php
                            echo $expense_account_head -> title;
                            if ( $expense_account_head -> role_id > 0 ) {
                                $role = get_account_head_role ( $expense_account_head -> role_id );
                                if ( !empty( $role ) )
                                    echo '(' . get_account_head_role ( $expense_account_head -> role_id ) -> name . ')';
                            }
                        ?>
                    </strong>
                </td>
                <td><?php echo number_format ( abs ( -$transaction -> credit + $transaction -> debit ), 2 ) ?></td>
            </tr>
            <?php
            if ( count ( $childAccHeads ) > 0 ) {
                foreach ( $childAccHeads as $childAccHead ) {
                    $subChildAccHeads       = get_child_account_heads_data ( $childAccHead -> id );
                    $childAccHeads          = get_child_account_heads_data ( $expense_account_head -> id );
                    $acc_head_id            = $childAccHead -> id;
                    $transaction            = calculate_acc_head_transaction ( $acc_head_id );
                    $subChildAccHeadIds     = get_sub_child_account_head_ids ( $acc_head_id );
                    $sub_transaction        = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                    $subChildAccHeads       = get_child_account_heads_data ( $childAccHead -> id );
                    $sub_transaction        = abs ( ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) ) );
                    $expense_account_credit += abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) );
                    
                    ?>
                    <tr>
                        <td style="padding-left: 40px">
                            <?php
                                echo $childAccHead -> title;
                                if ( $childAccHead -> role_id > 0 ) {
                                    $role = get_account_head_role ( $childAccHead -> role_id );
                                    if ( !empty( $role ) )
                                        echo ' (' . get_account_head_role ( $childAccHead -> role_id ) -> name . ')';
                                }
                            ?>
                        </td>
                        <td><?php echo number_format ( abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) ), 2 ) ?></td>
                    </tr>
                    <?php
                    if ( count ( $subChildAccHeads ) > 0 ) {
                        foreach ( $subChildAccHeads as $subChildAccHead ) {
                            $acc_head_id        = $subChildAccHead -> id;
                            $transaction        = calculate_acc_head_transaction ( $acc_head_id );
                            $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                            $sub_transaction    = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                            
                            $expense_account_credit += abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) );
                            
                            ?>
                            <tr>
                                <td style="padding-left: 80px">
                                    <?php
                                        echo $subChildAccHead -> title;
                                        if ( $subChildAccHead -> role_id > 0 ) {
                                            $role = get_account_head_role ( $subChildAccHead -> role_id );
                                            if ( !empty( $role ) )
                                                echo ' (' . get_account_head_role ( $subChildAccHead -> role_id ) -> name . ')';
                                        }
                                    ?>
                                </td>
                                <td><?php echo number_format ( abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) ), 2 ) ?></td>
                            </tr>
                            <?php
                        }
                    }
                }
            }
        }
    }
?>
<tr>
    <td><strong>Total Accumulated Depreciation</strong></td>
    <td>
        <strong>
            <?php
                $TAD = $total_accumulative_depreciation;
                echo number_format ( $TAD, 2 );
                
                $expense_account_credit += $TAD;
            ?>
        </strong>
    </td>
</tr>
<tr>
    <td align="right"><strong>Total:</strong></td>
    <td align="left">
        <strong><?php echo number_format ( abs ( $expense_account_credit ), 2 ) ?></strong>
    </td>
</tr>