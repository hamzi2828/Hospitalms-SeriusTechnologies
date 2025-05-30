<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
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
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Package
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                    <input type="hidden" name="action" value="do_edit_packages">
                    <input type="hidden" name="package-id" value="<?php echo $package -> id ?>">
                    <div class="form-body" style="overflow:auto;">
                        
                        <div class="form-group col-lg-8">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Add Airline"
                                   autofocus="autofocus" value="<?php echo $package -> title ?>">
                        </div>
                        
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Price</label>
                            <input type="text" name="price" class="form-control" placeholder="Price" required="required"
                                   value="<?php echo $package -> price ?>">
                        </div>
                        
                        <?php
                            if ( count ( $tests ) > 0 ) {
                                foreach ( $tests as $test ) {
                                    $testInfo = get_test_by_id ( $test -> test_id );
                                    ?>
                                    <div class="form-group col-lg-4">
                                        <label for="exampleInputEmail1">
                                            <a href="<?php echo base_url ( '/settings/delete-lab-package-test/?id=' . $test -> id ) ?>"
                                               onclick="return confirm('Are you sure?')" style="color: #000000">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            Test
                                        </label>
                                        <select class="form-control select2me">
                                            <option value="<?php echo $testInfo -> id ?>">
                                                <?php echo $testInfo -> name ?>
                                            </option>
                                        </select>
                                    </div>
                                    <?php
                                }
                            }
                        ?>
                        <div id="add-more-tests"></div>
                    
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn purple" onclick="addMoreTestsForPackage()">Add More</button>
                        <button type="submit" class="btn blue">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>