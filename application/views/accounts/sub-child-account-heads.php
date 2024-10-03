<?php
    if ( count ( $account_heads ) > 0 ) {
        foreach ( $account_heads as $account_head ) {
            $child = if_has_child ( $account_head -> id );
            ?>
            <option value="<?php if ( $single_account_head != '-1' ) {
                echo 'sc-' . $account_head -> id;
            }
            else {
                echo $account_head -> id;
            } ?>"
                    data-role-id="<?php echo $account_head -> role_id ?>" <?php if ( $child > 0 ) echo 'disabled="disabled"' ?>
                    class="sub-child" <?php if ( $single_account_head == $account_head -> id ) echo 'selected' ?>><?php echo $account_head -> title ?></option>
            <?php
        }
    }
?>