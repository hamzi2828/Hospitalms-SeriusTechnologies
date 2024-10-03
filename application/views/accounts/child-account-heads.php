<?php
    if ( count ( $account_heads ) > 0 ) {
        foreach ( $account_heads as $account_head ) {
            $child = if_has_child ( $account_head -> id );
            ?>
            <option value="<?php if ( $single_account_head != '-1' ) {
                echo ( $child > 0 ) ? 'c-' . $account_head -> id : 'sc-' . $account_head -> id;
            }
            else {
                echo $account_head -> id;
            } ?>"
                    data-role-id="<?php echo $account_head -> role_id ?>"
                    class="<?php if ( $child > 0 ) echo 'has-sub-child'; else echo 'child'; ?>" <?php if ( $single_account_head == $account_head -> id ) echo 'selected' ?> <?php if ( $child > 0 ) echo 'disabled="disabled"' ?>>
                <?php echo $account_head -> title ?>
            </option>
            <?php
            echo get_active_sub_child_account_heads ( $account_head -> id, $single_account_head );
        }
    }
?>