<div class="tab-pane <?php if ( !isset( $current_tab ) or $current_tab == 'general' )
    echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>">
        <input type="hidden" name="action" value="do_add_general_test_info">
        <div class="form-body">
            <div class="row">
                <div class="col-lg-8" style="padding: 0">
                    <div class="form-group col-lg-4">
                        <label for="exampleInputEmail1">Parent Test</label>
                        <select name="parent_id" class="form-control select2me">
                            <option value="">Select Test</option>
                            <?php if ( count ( $parent_tests ) > 0 ) : foreach ( $parent_tests as $parent_test ) : ?>
                                <option value="<?php echo $parent_test -> id ?>">
                                    <?php echo $parent_test -> name ?>
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">Test Code</label>
                        <input type="text" name="code" class="form-control" placeholder="Add test code"
                               autofocus="autofocus" value="<?php echo set_value ( 'code' ) ?>" required="required">
                    </div>
                    <div class="form-group col-lg-5">
                        <label for="exampleInputEmail1">Test Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Add test name"
                               value="<?php echo set_value ( 'name' ) ?>" required="required">
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputEmail1">Test Type</label>
                        <select name="type" class="form-control select2me" required="required">
                            <option value="test">Test</option>
                            <option value="profile">Profile</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="exampleInputEmail1">TAT</label>
                        <input type="text" name="tat" class="form-control" placeholder="Process time"
                               value="<?php echo set_value ( 'tat' ) ?>" required="required">
                    </div>
                    <div class="form-group col-lg-5">
                        <label for="exampleInputEmail1">Test Category</label>
                        <select name="category" class="form-control select2me" required="required">
                            <option value="general">General</option>
                            <option value="covid">Covid</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="exampleInputEmail1" class="pull-left">Show Graphs</label>
                        <select name="show-graph" class="form-control select2me" required="required">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputEmail1" class="pull-left">Uploading Test Results as Image</label>
                        <select name="require-image" class="form-control select2me" required="required">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="exampleInputEmail1">Report Title</label>
                        <input type="text" name="report_title" class="form-control" placeholder="Add test report title"
                               value="<?php echo set_value ( 'report_title' ) ?>" required="required">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="exampleInputEmail1">Report Footer</label>
                        <textarea class="form-control ckeditor" name="report_footer"
                                  placeholder="Add test report footer information"
                                  rows="8"><?php echo set_value ( 'report_footer' ) ?></textarea>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h3 class="sample-information">Sample Information</h3>
                    <div class="info">
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Add Specimen</label>
                            <select name="sample_id" class="form-control select2me">
                                <?php if ( count ( $samples ) > 0 ) : foreach ( $samples as $sample ) : ?>
                                    <option value="<?php echo $sample -> id ?>">
                                        <?php echo $sample -> name ?>
                                    </option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Quantity</label>
                            <input type="text" name="quantity" value="0" class="form-control" placeholder="Test quantity">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Test Tube Color</label>
                            <select name="color_id" class="form-control select2me">
                                <?php if ( count ( $colors ) > 0 ) : foreach ( $colors as $color ) : ?>
                                    <option value="<?php echo $color -> id ?>">
                                        <?php echo $color -> name ?>
                                    </option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Section</label>
                            <select name="section_id" class="form-control select2me">
                                <?php if ( count ( $sections ) > 0 ) : foreach ( $sections as $section ) : ?>
                                    <option value="<?php echo $section -> id ?>">
                                        <?php echo $section -> name ?>
                                    </option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Save & Next</button>
        </div>
    </form>
</div>