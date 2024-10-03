<div class="form-group col-lg-12">
    <div class="col-md-6">
        <label>Regent</label>
        <select name="regent_id[]" class="form-control js-example-basic-single-<?php echo $row ?>">
            <option value="">Select</option>
            <?php
                if ( count ( $regents ) > 0 ) :
                    foreach ( $regents as $regent ) :
                        $savedRegent = get_saved_regent_value ( @$_REQUEST[ 'test-id' ], $regent -> id );
                        ?>
                        <option value="<?php echo $regent -> id ?>" <?php if ( !empty( $savedRegent ) and $savedRegent -> regent_id == $regent -> id )
                            echo 'selected="selected"' ?>>
                            <?php echo $regent -> item ?>
                        </option>
                    <?php
                    endforeach;
                endif; ?>
        </select>
    </div>
    <div class="col-md-6">
        <label>Usable Quantity (ML/Kit)</label>
        <input type="text" class="form-control" name="usable_quantity[]" value="">
    </div>
</div>