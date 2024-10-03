<div class="tab-pane <?php if ( !isset( $current_tab ) or $current_tab == 'general' )
    echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>">
        <input type="hidden" name="action" value="do_edit_general_test_info">
        <input type="hidden" name="test_id" value="<?php echo $test_id ?>">
        <div class="form-body" style="overflow: auto">
            <div class="col-lg-8" style="padding: 0">
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Parent Test</label>
                    <select name="parent_id" class="form-control select2me">
                        <option value="">Select Test</option>
                        <?php if ( count ( $parent_tests ) > 0 ) : foreach ( $parent_tests as $parent_test ) : ?>
                            <option value="<?php echo $parent_test -> id ?>" <?php if ( $general_info -> parent_id == $parent_test -> id )
                                echo 'selected="selected"'; ?>>
                                <?php echo $parent_test -> name ?>
                            </option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Test Code</label>
                    <input type="text" name="code" class="form-control" placeholder="Add test code"
                           autofocus="autofocus" value="<?php echo $general_info -> code ?>">
                </div>
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">Test Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Add test name"
                           value="<?php echo $general_info -> name ?>">
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Test Type</label>
                    <select name="type" class="form-control select2me">
                        <option value="test" <?php if ( $general_info -> type == 'test' )
                            echo 'selected="selected"'; ?>>Test
                        </option>
                        <option value="profile" <?php if ( $general_info -> type == 'profile' )
                            echo 'selected="selected"'; ?>>Profile
                        </option>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">TAT</label>
                    <input type="text" name="tat" class="form-control" placeholder="Process time"
                           value="<?php echo $general_info -> tat; ?>" required="required">
                </div>
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">Test Category</label>
                    <select name="category" class="form-control select2me" required="required">
                        <option value="general" <?php echo $general_info -> category == 'general' ? 'selected="selected"' : ''; ?>>General</option>
                        <option value="covid" <?php echo $general_info -> category == 'covid' ? 'selected="selected"' : ''; ?>>Covid</option>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1" class="pull-left">Show Graphs</label>
                    <select name="show-graph" class="form-control select2me" required="required">
                        <option value="0" <?php echo $general_info -> show_graph == '0' ? 'selected="selected"' : ''; ?>>No</option>
                        <option value="1" <?php echo $general_info -> show_graph == '1' ? 'selected="selected"' : ''; ?>>Yes</option>
                    </select>
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1" class="pull-left">Uploading Test Results as Image</label>
                    <select name="require-image" class="form-control select2me" required="required">
                        <option value="0" <?php echo $general_info -> require_image == '0' ? 'selected="selected"' : ''; ?>>No</option>
                        <option value="1" <?php echo $general_info -> require_image == '1' ? 'selected="selected"' : ''; ?>>Yes</option>
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Report Title</label>
                    <input type="text" name="report_title" class="form-control" placeholder="Add test report title"
                           value="<?php echo $general_info -> report_title; ?>">
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1" class="pull-left">Invoice Logo</label>
                    <select name="invoice-logo" class="form-control select2me" required="required">
                        <option value="quest" <?php echo $general_info -> invoice_logo == 'quest' ? 'selected="selected"' : ''; ?>>Quest</option>
                        <option value="bio-gene" <?php echo $general_info -> invoice_logo == 'bio-gene' ? 'selected="selected"' : ''; ?>>Bio-Gene</option>
                    </select>
                </div>
                <div class="form-group col-lg-12">
                    <label for="exampleInputEmail1">Report Footer</label>
                    <textarea class="form-control ckeditor" name="report_footer"
                              placeholder="Add test report footer information"
                              rows="8"><?php echo $general_info -> report_footer ?></textarea>
                </div>
            </div>
            <div class="col-lg-4">
                <h3 class="sample-information">Sample Information</h3>
                <div class="info">
                    <div class="form-group col-lg-12">
                        <label for="exampleInputEmail1">Add Specimen</label>
                        <select name="sample_id" class="form-control select2me">
                            <?php if ( count ( $samples ) > 0 ) : foreach ( $samples as $sample ) : ?>
                                <option value="<?php echo $sample -> id ?>" <?php if ( $sample_info -> sample_id == $sample -> id )
                                    echo 'selected="selected"' ?>>
                                    <?php echo $sample -> name ?>
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="exampleInputEmail1">Quantity</label>
                        <input type="text" name="quantity" class="form-control" placeholder="Test quantity"
                               value="<?php echo $sample_info -> quantity ?>">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="exampleInputEmail1">Test Tube Color</label>
                        <select name="color_id" class="form-control select2me">
                            <?php if ( count ( $colors ) > 0 ) : foreach ( $colors as $color ) : ?>
                                <option value="<?php echo $color -> id ?>" <?php if ( $sample_info -> color_id == $color -> id )
                                    echo 'selected="selected"' ?>>
                                    <?php echo $color -> name ?>
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="exampleInputEmail1">Section</label>
                        <select name="section_id" class="form-control select2me">
                            <?php if ( count ( $sections ) > 0 ) : foreach ( $sections as $section ) : ?>
                                <option value="<?php echo $section -> id ?>" <?php if ( $sample_info -> section_id == $section -> id )
                                    echo 'selected="selected"' ?>>
                                    <?php echo $section -> name ?>
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Update & Next</button>
        </div>
    </form>
</div>