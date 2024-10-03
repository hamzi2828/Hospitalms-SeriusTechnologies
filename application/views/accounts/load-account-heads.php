<option></option>
<?php
    if ( !empty( $account_head ) && $type !== 'all' ) {
        $child = if_has_child ( $account_head -> id );
        ?>
        <option value="<?php echo $account_head -> id ?>"
                class="<?php if ( $child > 0 ) echo 'has-child' ?>" <?php if ( $child > 0 ) echo 'disabled="disabled"' ?>>
            <?php echo $account_head -> title ?>
        </option>
        <?php
        echo get_active_child_account_heads ( $account_head -> id, '-1' );
    }
    else if ( $type === 'all' && count ( $account_heads ) > 0 ) {
        foreach ( $account_heads as $account_head ) {
            $child = if_has_child ( $account_head -> id );
            ?>
            <option value="<?php echo $account_head -> id ?>"
                    class="<?php if ( $child > 0 ) echo 'has-child' ?>" <?php if ( $child > 0 ) echo 'disabled="disabled"' ?>>
                <?php echo $account_head -> title ?>
            </option>
            <?php
            echo get_active_child_account_heads ( $account_head -> id, '-1' );
        }
    }
?>