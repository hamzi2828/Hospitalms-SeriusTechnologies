<?php
    if ( count ( $account_heads ) > 0 ) {
        foreach ( $account_heads as $account_head ) {
            ?>
            <option
                    data-role-id="<?php echo $account_head -> role_id ?>"
                    value="<?php echo $account_head -> id; ?>" <?php if ( $parent_id == $account_head -> id ) echo 'selected' ?>
                    class="child">
                <?php echo $account_head -> title ?>
            </option>
            <?php
        }
    }
?>