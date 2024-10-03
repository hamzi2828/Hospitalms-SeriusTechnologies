<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'range' )
    echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>">
        <input type="hidden" name="action" value="do_add_test_reference_range">
        <input type="hidden" name="test_id" value="<?php echo @$_REQUEST[ 'test-id' ] ?>">
        <div class="form-body" style="overflow: auto">
            <div class="row">
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
                                <?php if ( count ( $units ) > 0 ) : foreach ( $units as $unit ) : ?>
                                    <option value="<?php echo $unit -> id ?>">
                                        <?php echo $unit -> name ?>
                                    </option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Machine Name</label>
                            <input type="text" name="machine-name" class="form-control"
                                   value="<?php echo set_value ( 'machine-name' ) ?>" autofocus="autofocus">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" style="padding: 0; margin-top: 10px">
                    <h3 class="sample-information">Panic Value</h3>
                    <div class="info">
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Minimum</label>
                            <input type="text" name="min_value" class="form-control">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Maximum</label>
                            <input type="text" name="max_value" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" style="padding: 0; margin-top: 10px">
                    <h3 class="sample-information">Reference Ranges</h3>
                    <div class="info">
                        <?php for ( $range = 1; $range <= 10; $range++ ) : ?>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Gender</label>
                                <select name="gender[]" class="form-control select2me">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="child">Child</option>
                                    <option value="infant">Infant</option>
                                    <option value="m/f">M/F</option>
                                    <!--                                <option value="both">Both</option>-->
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
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Save & Next</button>
        </div>
    </form>
</div>