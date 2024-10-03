<option value="">Select</option>
<?php
    if ( count ( $airlines ) > 0 ) {
        foreach ( $airlines as $airline ) {
            $airlineInfo = get_airlines_by_id ( $airline -> airline_id );
            ?>
            <option value="<?php echo $airlineInfo -> id ?>">
                <?php echo $airlineInfo -> title ?>
            </option>
            <?php
        }
    }
?>