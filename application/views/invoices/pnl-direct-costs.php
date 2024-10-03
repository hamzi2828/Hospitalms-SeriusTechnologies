<?php
    $direct_cost_credit = 0;
    if ( count ( $Direct_Costs_account_head ) > 0 ) {
        foreach ( $Direct_Costs_account_head as $Direct_Cost_account_head ) {
            $childAccHeads = get_child_account_heads_data ( $Direct_Cost_account_head -> id );
            $acc_head_id   = $Direct_Cost_account_head -> id;
            $transaction   = calculate_acc_head_transaction ( $acc_head_id );
            //            $direct_cost_credit = $direct_cost_credit + $transaction -> credit;
            $direct_cost_credit += abs ( -$transaction -> credit + $transaction -> debit );
            ?>
            <tr>
                <td>
                    <strong>
                        <?php
                            echo $Direct_Cost_account_head -> title;
                            if ( $Direct_Cost_account_head -> role_id > 0 ) {
                                $role = get_account_head_role ( $Direct_Cost_account_head -> role_id );
                                if ( !empty( $role ) )
                                    echo '(' . get_account_head_role ( $Direct_Cost_account_head -> role_id ) -> name . ')';
                            }
                        ?>
                    </strong>
                </td>
                <td><?php echo number_format ( abs ( -$transaction -> credit + $transaction -> debit ), 2 ) ?></td>
            </tr>
            <?php
            if ( count ( $childAccHeads ) > 0 ) {
                foreach ( $childAccHeads as $childAccHead ) {
                    $subChildAccHeads = get_child_account_heads_data ( $childAccHead -> id );
                    $acc_head_id      = $childAccHead -> id;
                    $transaction      = calculate_acc_head_transaction ( $acc_head_id );
                    //                    $direct_cost_credit = $direct_cost_credit + $transaction -> credit;
                    //									$subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                    //									$sub_transaction = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                    //									if ( $sub_transaction )
                    //										$direct_cost_credit = $direct_cost_credit + $sub_transaction -> credit;
                    
                    $direct_cost_credit += abs ( -$transaction -> credit + $transaction -> debit );
                    
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
                        <td><?php echo number_format ( abs ( ( -$transaction -> credit + $transaction -> debit ) ), 2 ) ?></td>
                    </tr>
                    <?php
                    if ( count ( $subChildAccHeads ) > 0 ) {
                        foreach ( $subChildAccHeads as $subChildAccHead ) {
                            $acc_head_id = $subChildAccHead -> id;
                            $transaction = calculate_acc_head_transaction ( $acc_head_id );
//                            $direct_cost_credit = $direct_cost_credit + $transaction -> credit;
                            
                            $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                            $sub_transaction    = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                            
                            //                                                if ( $sub_transaction )
                            //                                                    $direct_cost_credit = $direct_cost_credit + $sub_transaction -> credit;
                            
                            $direct_cost_credit += abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) );
                            
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
    <td align="left"><strong><?php echo number_format ( abs ( $direct_cost_credit ), 2 ) ?></strong>
    </td>
</tr>