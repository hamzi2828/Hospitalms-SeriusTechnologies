<option></option>
<?php
    if ( count ( $services ) > 0 ) {
        foreach ( $services as $service ) {
            ?>
            <option value="<?php echo $service -> id ?>">
                <?php echo $service -> title ?>
            </option>
            <?php
        }
    }
?>