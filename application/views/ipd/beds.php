<?php
    if ( count ( $beds ) > 0 ) {
        foreach ( $beds as $bed ) {
            ?>
            <option value="<?php echo $bed -> id ?>"><?php echo $bed -> title ?></option>
            <?php
        }
    }