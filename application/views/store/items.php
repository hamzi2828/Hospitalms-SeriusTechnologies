<option></option>
<?php
    if ( count ( $items ) > 0 ) {
        foreach ( $items as $item ) {
            $allowed   = $item -> allowed;
            $sold      = get_sold_items_count ( $department_id, $item -> id );
            $available = $allowed - $sold;
            
            if ( $available > 0 ) {
                ?>
                <option value="<?php echo $item -> id ?>">
                    <?php echo $item -> item ?>
                </option>
                <?php
            }
        }
    }
?>