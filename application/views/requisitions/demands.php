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
                    <i class="fa fa-reorder"></i> Add Other Requisitions
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_demands">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label for="item">Item</label>
                                <input type="text" name="name[]" id="item" class="form-control" autofocus="autofocus">
                            </div>
                            
                            <div class="form-group col-lg-3">
                                <label for="quantity">Quantity</label>
                                <input type="number" id="quantity" name="quantity[]" class="form-control">
                            </div>
                            
                            <div class="form-group col-lg-3">
                                <label for="price">Est. Price</label>
                                <input type="number" step="0.01" id="price" name="price[]" class="form-control">
                            </div>
                            
                            <div class="form-group col-lg-3">
                                <label for="description">Purpose</label>
                                <textarea name="description[]" id="description" class="form-control"
                                          rows="3"></textarea>
                            </div>
                        </div>
                        <div class="issue"></div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="submit-btn">Submit</button>
                        <button type="button" class="btn purple" onclick="add_more_demands()">Add More</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>