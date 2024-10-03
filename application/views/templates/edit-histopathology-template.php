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
                    <i class="fa fa-reorder"></i> Edit Template (Histopathology)
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_histopathology_templates">
                    <input type="hidden" name="id" value="<?php echo $template -> id ?>">
                    <div class="form-body" style="overflow:auto;">
                        
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Title (Report Name)</label>
                            <input type="text" name="title" class="form-control" placeholder="Add title"
                                   autofocus="autofocus" value="<?php echo $template -> title ?>"
                                   required="required">
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Study</label>
                            <textarea class="form-control ckeditor" placeholder="Add study" name="study" rows="15"
                                      style="height: 100%"><?php echo $template -> study ?></textarea>
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Conclusion</label>
                            <textarea class="form-control ckeditor" placeholder="Add conclusion" name="conclusion"
                                      rows="15" style="height: 100%"><?php echo $template -> conclusion ?></textarea>
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
<style>
    iframe {
        height: 600px !important;
    }
</style>