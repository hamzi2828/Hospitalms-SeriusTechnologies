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
                    <i class="fa fa-reorder"></i> Add Reference
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                    <input type="hidden" name="action" value="do_add_references">
                    <div class="form-body" style="overflow: auto">
                        <div class="col-lg-6 form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" name="title[]" class="form-control" placeholder="Add reference"
                                   autofocus="autofocus" value="<?php echo set_value ( 'name' ) ?>">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" name="title[]" class="form-control" placeholder="Add reference"
                                   autofocus="autofocus" value="<?php echo set_value ( 'name' ) ?>">
                        </div>
                        
                        <div class="col-lg-6 form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" name="title[]" class="form-control" placeholder="Add reference"
                                   autofocus="autofocus" value="<?php echo set_value ( 'name' ) ?>">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" name="title[]" class="form-control" placeholder="Add reference"
                                   autofocus="autofocus" value="<?php echo set_value ( 'name' ) ?>">
                        </div>
                        
                        <div class="col-lg-6 form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" name="title[]" class="form-control" placeholder="Add reference"
                                   autofocus="autofocus" value="<?php echo set_value ( 'name' ) ?>">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" name="title[]" class="form-control" placeholder="Add reference"
                                   autofocus="autofocus" value="<?php echo set_value ( 'name' ) ?>">
                        </div>
                        
                        <div class="add-more"></div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                        <button type="button" class="btn purple" onclick="add_more_references()">Add More</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<script type="text/javascript">
    function add_more_references () {
        jQuery ( '.add-more' ).append ( '<div class="col-lg-6 form-group"><label for="exampleInputEmail1">Title</label><input type="text" name="title[]" class="form-control" placeholder="Add reference" autofocus="autofocus" value=""></div><div class="col-lg-6 form-group"><label for="exampleInputEmail1">Title</label><input type="text" name="title[]" class="form-control" placeholder="Add reference" autofocus="autofocus" value=""></div>' );
    }
</script>