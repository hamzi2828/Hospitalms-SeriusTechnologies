<?php
    $net_other_incomes = 0;
    if ( count ( $other_incomes ) > 0 ) {
        foreach ( $other_incomes as $other_income ) {
            $childAccHeads     = get_child_account_heads_data ( $other_income -> id );
            $acc_head_id       = $other_income -> id;
            $transaction       = calculate_acc_head_transaction ( $acc_head_id );
            $net_other_incomes = abs ( $net_other_incomes + $transaction -> debit );
            ?>
            <tr>
                <td>
                    <strong>
                        <?php
                            echo $other_income -> title;
                            if ( $other_income -> role_id > 0 ) {
                                $role = get_account_head_role ( $other_income -> role_id );
                                if ( !empty( $role ) )
                                    echo '(' . get_account_head_role ( $other_income -> role_id ) -> name . ')';
                            }
                        ?>
                    </strong>
                </td>
                <td><?php echo number_format ( abs ( -$transaction -> credit + $transaction -> debit ), 2 ) ?></td>
            </tr>
            <?php
            if ( count ( $childAccHeads ) > 0 ) {
                foreach ( $childAccHeads as $childAccHead ) {
                    $subChildAccHeads   = get_child_account_heads_data ( $childAccHead -> id );
                    $childAccHeads      = get_child_account_heads_data ( $other_income -> id );
                    $acc_head_id        = $childAccHead -> id;
                    $transaction        = calculate_acc_head_transaction ( $acc_head_id );
                    $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                    $sub_transaction    = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                    $subChildAccHeads   = get_child_account_heads_data ( $childAccHead -> id );
                    $sub_transaction    = abs ( ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) ) );
                    $net_other_incomes  += abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) );
                    
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
                            
                            $net_other_incomes += abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) );
                            
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
    <td align="right"><strong>Total:</strong></td>
    <td align="left">
        <strong><?php echo number_format ( abs ( $net_other_incomes ), 2 ) ?></strong>
    </td>
</tr>