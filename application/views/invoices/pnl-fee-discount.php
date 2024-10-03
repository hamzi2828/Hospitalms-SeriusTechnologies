<?php
    $fee_discounts_credit = 0;
    if ( count ( $fee_discounts_account_head ) > 0 ) {
        foreach ( $fee_discounts_account_head as $fee_discount_account_head ) {
            $childAccHeads        = get_child_account_heads_data ( $fee_discount_account_head -> id );
            $acc_head_id          = $fee_discount_account_head -> id;
            $transaction          = calculate_acc_head_transaction ( $acc_head_id );
            $fee_discounts_credit = abs ( $fee_discounts_credit + $transaction -> credit );
            ?>
            <tr>
                <td>
                    <strong>
                        <?php
                            echo $fee_discount_account_head -> title;
                            if ( $fee_discount_account_head -> role_id > 0 ) {
                                $role = get_account_head_role ( $fee_discount_account_head -> role_id );
                                if ( !empty( $role ) )
                                    echo '(' . get_account_head_role ( $fee_discount_account_head -> role_id ) -> name . ')';
                            }
                        ?>
                    </strong>
                </td>
                <td><?php
                        echo number_format ( abs ( -$transaction -> credit + $transaction -> debit ), 2 ) ?></td>
            </tr>
            <?php
            if ( count ( $childAccHeads ) > 0 ) {
                foreach ( $childAccHeads as $childAccHead ) {
                    $acc_head_id = $childAccHead -> id;
                    $transaction = calculate_acc_head_transaction ( $acc_head_id );
//                    $fee_discounts_credit = $fee_discounts_credit + $transaction -> credit;
                    $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                    $sub_transaction    = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                    
                    //                                        if ( $sub_transaction )
                    //                                            $fee_discounts_credit = $fee_discounts_credit + $sub_transaction -> credit;
                    
                    $fee_discounts_credit += abs ( ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) ) );
                    
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
                        <td><?php
                                echo number_format ( abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) ), 2 ) ?></td>
                    </tr>
                    <?php
                }
            }
        }
    }
?>
<tr>
    <td align="right"><strong>Total:</strong></td>
    <td align="left">
        <strong><?php
                echo number_format ( abs ( $fee_discounts_credit ), 2 ) ?></strong>
    </td>
</tr>