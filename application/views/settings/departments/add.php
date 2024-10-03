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
                    <i class="fa fa-reorder"></i> Add Departments
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                    <input type="hidden" name="action" value="do_add_department">
                    <div class="form-body" style="overflow:hidden;">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label for="code">Code</label>
                                <input type="text" id="code" name="code" class="form-control" placeholder="Add code"
                                       required="required"
                                       autofocus="autofocus" value="<?php echo set_value ( 'code' ) ?>">
                            </div>
                            
                            <div class="form-group col-lg-9">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Add name"
                                       required="required"
                                       value="<?php echo set_value ( 'name' ) ?>">
                            </div>
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