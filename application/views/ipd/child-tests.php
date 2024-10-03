<ul>
    <?php
        if ( count ( $child_tests ) > 0 ) {
            foreach ( $child_tests as $child_test ) {
                ?>
                <option value="<?php echo $child_test -> id ?>"
                        class="child option-<?php echo $child_test -> id ?>" <?php if ( $single_test_id == $child_test -> id ) echo 'selected="selected"' ?>>
                    <?php echo $child_test -> name ?>
                </option>
                <?php
            }
        }
    ?>
</ul>
