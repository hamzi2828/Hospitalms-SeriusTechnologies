<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'range' )
    echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>">
        <input type="hidden" name="action" value="do_edit_test_reference_range">
        <input type="hidden" name="test_id" value="<?php echo $test_id ?>">
        <input type="hidden" name="test_id" value="<?php echo @$_REQUEST[ 'test-id' ] ?>">
        <div class="form-body" style="overflow: auto">
            <div class="col-lg-12" style="padding: 0">
                <h3 class="sample-information">Parameter Information</h3>
                <div class="info">
                    <div class="form-group col-lg-2">
                        <label for="exampleInputEmail1">Test Code</label>
                        <input type="text" readonly="readonly" class="form-control"
                               value="<?php echo @$test -> code ?>">
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputEmail1">Test Name</label>
                        <input type="text" readonly="readonly" class="form-control"
                               value="<?php echo @$test -> name ?>">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">Units</label>
                        <select name="unit_id" class="form-control select2me">
                            <option value="">Select</option>
                            <?php if ( count ( $units ) > 0 ) : foreach ( $units as $unit ) : ?>
                                <option value="<?php echo $unit -> id ?>" <?php if ( @$parameter -> unit_id == $unit -> id )
                                    echo 'selected="selected"' ?>>
                                    <?php echo $unit -> name ?>
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">Machine Name</label>
                        <input type="text" name="machine-name" class="form-control"
                               value="<?php echo @$parameter -> machine_name ?>" autofocus="autofocus">
                    </div>
                </div>
            </div>
            <div class="col-lg-12" style="padding: 0; margin-top: 10px">
                <h3 class="sample-information">Panic Value</h3>
                <div class="info">
                    <div class="form-group col-lg-6">
                        <label for="exampleInputEmail1">Minimum</label>
                        <input type="text" name="min_value" class="form-control"
                               value="<?php echo @$panic -> min_value ?>">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="exampleInputEmail1">Maximum</label>
                        <input type="text" name="max_value" class="form-control"
                               value="<?php echo @$panic -> max_value ?>">
                    </div>
                </div>
            </div>
            <div class="col-lg-12" style="padding: 0; margin-top: 10px">
                <h3 class="sample-information">Reference Ranges</h3>
                <div class="info">
                    <?php
                        $count = count ( $ranges );
                        $remaning = 10 - $count;
                        if ( count ( $ranges ) > 0 ) {
                            foreach ( $ranges as $range ) {
                                ?>
                                <div class="form-group col-lg-4">
                                    <label for="exampleInputEmail1">Gender</label>
                                    <select name="gender[]" class="form-control select2me">
                                        <option value="">Select</option>
                                        <option value="male" <?php if ( $range -> gender == 'male' )
                                            echo 'selected="selected"' ?>>Male
                                        </option>
                                        <option value="female" <?php if ( $range -> gender == 'female' )
                                            echo 'selected="selected"' ?>>Female
                                        </option>
                                        <option value="child" <?php if ( $range -> gender == 'child' )
                                            echo 'selected="selected"' ?>>Child
                                        </option>
                                        <option value="infant" <?php if ( $range -> gender == 'infant' )
                                            echo 'selected="selected"' ?>>Infant
                                        </option>
                                        <option value="m/f" <?php if ( $range -> gender == 'm/f' )
                                            echo 'selected="selected"' ?>>M/F
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Min. Age</label>
                                    <input type="text" name="min_age[]" class="form-control"
                                           value="<?php echo $range -> min_age ?>">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Max. Age</label>
                                    <input type="text" name="max_age[]" class="form-control"
                                           value="<?php echo $range -> max_age ?>">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">Start Range</label>
                                    <input type="text" name="start_range[]" class="form-control"
                                           value="<?php echo $range -> start_range ?>">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail1">End Range</label>
                                    <input type="text" name="end_range[]" class="form-control"
                                           value="<?php echo $range -> end_range ?>">
                                </div>
                                <?php
                            }
                        }
                        for ( $i = 1; $i <= $remaning; $i++ ) :
                            ?>
                            
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Gender</label>
                                <select name="gender[]" class="form-control select2me">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="child">Child</option>
                                    <option value="infant">Infant</option>
                                    <option value="m/f">M/F</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Min. Age</label>
                                <input type="text" name="min_age[]" class="form-control">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Max. Age</label>
                                <input type="text" name="max_age[]" class="form-control">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Start Range</label>
                                <input type="text" name="start_range[]" class="form-control">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">End Range</label>
                                <input type="text" name="end_range[]" class="form-control">
                            </div>
                        <?php endfor; ?>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Update & Next</button>
        </div>
    </form>
</div>