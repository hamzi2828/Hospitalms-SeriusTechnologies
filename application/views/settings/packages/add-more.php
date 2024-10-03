<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Test</label>
    <select name="test-id[]" class="form-control select2-<?php echo $row ?>">
        <option value="0">Select</option>
        <?php
            if ( count ( $tests ) > 0 ) {
                foreach ( $tests as $test ) {
                    ?>
                    <option value="<?php echo $test -> id ?>">
                        <?php echo $test -> name ?>
                    </option>
                    <?php
                }
            }
        ?>
    </select>
</div>