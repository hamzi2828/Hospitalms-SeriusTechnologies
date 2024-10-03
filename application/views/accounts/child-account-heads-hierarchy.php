<ul>
    <?php
        if ( count ( $account_heads ) > 0 ) {
            foreach ( $account_heads as $account_head ) {
                $child = if_has_child ( $account_head -> id );
                ?>
                <li class="<?php if ( $child > 0 )
                    echo 'has-sub-child';
                else echo 'child'; ?>">
                    <?php echo $account_head -> title ?>
                    <?php
                        if ( $account_head -> role_id > 0 ) {
                            $role = get_account_head_role ( $account_head -> role_id );
                            if ( !empty( $role ) )
                                echo '(' . get_account_head_role ( $account_head -> role_id ) -> name . ')';
                        }
                    ?>
                    <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_chart_of_accounts', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                        <a href="<?php echo base_url ( '/accounts/delete/' . $account_head -> id ) ?>"
                           onclick="return confirm('Are you sure to delete?')"> <i class="fa fa-trash-o"></i> </a>
                    <?php endif; ?>
                    <?php if ( $account_head -> editable == '1' ) : ?>
                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_chart_of_accounts', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                            <a href="<?php echo base_url ( '/accounts/edit/' . $account_head -> id ) ?>"> <i
                                        class="fa fa-pencil"></i> </a>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php
                        if ( $account_head -> status == '0' )
                            echo '<strong style="color: #ff0000">Inactive</strong>';
                    ?>
                
                </li>
                <?php
                echo get_sub_child_account_heads_hierarchy ( $account_head -> id );
            }
        }
    ?>
</ul>
