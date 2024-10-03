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
                    <i class="fa fa-reorder"></i> Site Settings
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                    <input type="hidden" name="action" value="do_add_login_page_images">
                    <div class="form-body" style="overflow: auto">
                        <div class="col-lg-6 form-group">
                            <label for="exampleInputEmail1">Background Image</label>
                            <input type="file" name="background_image" class="form-control">
                            <?php
                                if ( !empty( $background ) ) {
                                    ?>
                                    <img src="<?php echo $background -> login_background ?>"
                                         style="width: 100%;margin-top: 15px;">
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="exampleInputEmail1">Logo</label>
                            <input type="file" name="logo" class="form-control">
                            <?php
                                if ( !empty( $logo ) ) {
                                    ?>
                                    <img src="<?php echo $logo -> logo ?>" style="margin-top: 15px;">
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>