<?php
    $counter     = 1;
    $sales_debit = 0;
    if ( count ( $sales_account_head ) > 0 ) {
        foreach ( $sales_account_head as $sale_account_head ) {
            $childAccHeads = get_child_account_heads_data ( $sale_account_head -> id );
            $acc_head_id   = $sale_account_head -> id;
            $transaction   = calculate_acc_head_transaction ( $acc_head_id );
            
            if ( !empty( $transaction ) ) {
                $sales_debit += abs ( ( $transaction -> debit ) );
                ?>
                <tr>
                    <td>
                        <strong>
                            <?php
                                echo $sale_account_head -> title;
                                if ( $sale_account_head -> role_id > 0 ) {
                                    $role = get_account_head_role ( $sale_account_head -> role_id );
                                    if ( !empty( $role ) )
                                        echo '(' . get_account_head_role ( $sale_account_head -> role_id ) -> name . ')';
                                }
                            ?>
                        </strong>
                    </td>
                    <td>
                        <?php echo number_format ( abs ( $transaction -> debit ), 2 ) ?>
                    </td>
                </tr>
                <?php
                if ( count ( $childAccHeads ) > 0 ) {
                    foreach ( $childAccHeads as $childAccHead ) {
                        $acc_head_id        = $childAccHead -> id;
                        $transaction        = calculate_acc_head_transaction ( $acc_head_id );
                        $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                        $sub_transaction    = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids );
                        $sales_debit        += abs ( ( $transaction -> debit ) ) + abs ( ( @$sub_transaction -> debit ) );
                        
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
                            <td>
                                <?php
                                    echo number_format ( abs ( ( $transaction -> debit ) + ( @$sub_transaction -> debit ) ), 2 ) ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
            }
        }
    }
?>
<tr>
    <td align="right"><strong>Total:</strong></td>
    <td align="left"><strong><?php
                echo number_format ( abs ( $sales_debit ), 2 ) ?></strong></td>
</tr>