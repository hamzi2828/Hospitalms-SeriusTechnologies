<?php if ( count ( $tests ) > 0 ) : ?>
    <div class="form-group col-lg-12">
        <label
                style="display: block; float: left; width: 100%; font-size: 18px; font-weight: 900">Lab
                                                                                                    Tests</label>
        <select name="tests[]" class="form-control select2me" multiple="multiple">
            <option value="">Select</option>
            <?php
                foreach ( $tests as $test ) {
                    ?>
                    <option
                            value="<?php echo $test -> id ?>" <?php if ( check_if_test_added_with_consultancy ( @$_REQUEST[ 'consultancy_id' ], $test -> id ) ) echo 'selected="selected"'; ?>>
                        <?php echo $test -> name ?>
                    </option>
                    <?php
                }
            ?>
        </select>
    </div>
<?php endif; ?>