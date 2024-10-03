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
                    <i class="fa fa-reorder"></i> Edit Online Referral Portals
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                    <input type="hidden" name="action" value="do_edit_online_reference">
                    <input type="hidden" name="reference-id" value="<?php echo $reference -> id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-lg-8 form-group">
                                <label for="title">Title</label>
                                <input id="title" type="text" name="title" class="form-control"
                                       autofocus="autofocus"
                                       required="required"
                                       value="<?php echo set_value ( 'title', $reference -> title ) ?>">
                            </div>
                            <div class="col-lg-4 form-group">
                                <label for="commission">Commission(%)</label>
                                <input id="commission" type="number" style="any" name="commission" class="form-control"
                                       required="required"
                                       value="<?php echo set_value ( 'commission', $reference -> commission ) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>