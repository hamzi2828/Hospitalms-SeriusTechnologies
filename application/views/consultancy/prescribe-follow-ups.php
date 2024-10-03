<?php if ( count ( $follow_ups ) > 0 ) : ?>
    <div class="form-group col-lg-9">
        <label style="display: block; float: left; width: 100%; font-size: 18px; font-weight: 900">
            Follow Up
        </label>
        <select name="follow_up" class="form-control select2me">
            <option value="">Select</option>
            <?php
                foreach ( $follow_ups as $follow_up ) {
                    ?>
                    <option
                            value="<?php echo $follow_up -> id ?>" <?php if ( @$prescription -> follow_up == $follow_up -> id ) echo 'selected="selected"'; ?>>
                        <?php echo $follow_up -> title ?>
                    </option>
                    <?php
                }
            ?>
        </select>
    </div>
<?php endif; ?>

<div class="form-group col-lg-3">
    <label for="follow-up-date" style="display: block; float: left; width: 100%; font-size: 18px; font-weight: 900">
        Next Follow Up Date
    </label>
    <input type="text" name="follow-up-date" class="form-control date date-picker" id="follow-up-date" data-date-format="m-d-Y"
           value="<?php echo ( !empty( $prescription ) && !empty( trim ( $prescription -> follow_up_date ) ) ) ? date ( 'm-d-Y', strtotime ( $prescription -> follow_up_date ) ) : '' ?>">
</div>