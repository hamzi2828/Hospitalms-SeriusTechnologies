<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger panel-info hidden"></div>
        <div class="alert alert-danger panel-discount-info hidden"></div>
		<?php if ( validation_errors () != false ) { ?>
            <div class="alert alert-danger validation-errors">
				<?php echo validation_errors (); ?>
            </div>
		<?php } ?>
		<?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
            <div class="alert alert-danger">
				<?php echo $this -> session -> flashdata ( 'error' ) ?>
            </div>
		<?php endif; ?>
		<?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
				<?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
		<?php endif; ?>
        <form method="post">
            <input type="hidden" name="action" value="do_edit_calibrations">
            <input type="hidden" name="id" value="<?php echo $calibrations[0] -> calibration_id ?>">
            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
            <input type="hidden" id="added" value="<?php echo count ( $calibrations ) ?>">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Edit Calibrations
                    </div>
                </div>
                <div class="portlet-body" style="overflow: auto">
                    <?php
                        if (count ($calibrations) > 0) {
                            foreach ($calibrations as $calibration) {
                                ?>
                                <div class="form-group col-lg-6" style="padding-left: 0">
                                    <label>Test</label>
                                    <select name="test_id[]" class="form-control select2me">
                                        <option value="">Select</option>
                                        <?php
                                            if ( count ( $tests ) > 0 ) {
                                                foreach ( $tests as $test ) {
                                                    $hasChild = check_if_test_has_sub_tests ( $test -> id );
                                                    ?>
                                                    <option value="<?php echo $test -> id ?>"
                                                            class="<?php if ( $hasChild )
                                                                echo 'has-child'; ?>" <?php if ( $calibration -> test_id == $test -> id) echo 'selected="selected"' ?>>
                                                        <?php echo '(' . $test -> code . ') ' . $test -> name ?>
                                                    </option>
                                                    <?php
                                                    echo @get_sub_lab_tests ( $test -> id );
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6" style="padding-left: 0">
                                    <label>No. of Time Calibrated</label>
                                    <input type="text" class="form-control" name="calibrated[]" required="required" value="<?php echo $calibration -> calibration ?>">
                                </div>
                    <?php
                            }
                        }
                    ?>
                    <div class="form-group col-lg-6" style="padding-left: 0">
                        <label>Test</label>
                        <select name="test_id[]" class="form-control select2me">
                            <option value="">Select</option>
                            <?php
                                if ( count ( $tests ) > 0 ) {
                                    foreach ( $tests as $test ) {
                                        $hasChild = check_if_test_has_sub_tests ( $test -> id );
                                        ?>
                                        <option value="<?php echo $test -> id ?>" class="<?php if ( $hasChild )
                                            echo 'has-child'; ?>">
                                            <?php echo '(' . $test -> code . ') ' . $test -> name ?>
                                        </option>
                                        <?php
                                        echo @get_sub_lab_tests ( $test -> id );
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-6" style="padding-left: 0">
                        <label>No. of Time Calibrated</label>
                        <input type="text" class="form-control" name="calibrated[]" required="required">
                    </div>
                    <div class="add-more"></div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="sales-btn">Update</button>
                        <button type="button" class="btn purple" onclick="add_more_calibrations()">Add More</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .form-actions {
        float: left;
        width: 100%;
    }
</style>