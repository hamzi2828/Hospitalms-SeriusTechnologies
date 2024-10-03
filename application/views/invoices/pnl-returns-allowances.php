<tr>
    <td>
        <strong>
            <?php
                $allowances_credit = 0;
                echo $returns_allowances_account_head -> title;
                $acc_head_id = $returns_allowances_account_head -> id;
                $transaction = calculate_acc_head_transaction ( $acc_head_id );
                //            $allowances_credit = $allowances_credit + $transaction -> debit;
                
                $allowances_credit = abs ( $allowances_credit + ( -$transaction -> credit + $transaction -> debit ) );
                
                if ( $returns_allowances_account_head -> role_id > 0 ) {
                    $role = get_account_head_role ( $returns_allowances_account_head -> role_id );
                    if ( !empty( $role ) )
                        echo ' (' . get_account_head_role ( $returns_allowances_account_head -> role_id ) -> name . ')';
                }
            ?>
        </strong>
    </td>
    <td>
        <strong><?php echo number_format ( abs ( -$transaction -> credit + $transaction -> debit ), 2 ) ?></strong>
    </td>
</tr>