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
                    <i class="fa fa-reorder"></i> Edit Requisition
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_requisition">
                    <input type="hidden" name="requisition_id" value="<?php echo $requisition -> id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label for="store">Store Item</label>
                                <select name="store_id" id="store" class="form-control select2me"
                                        data-placeholder="Select"
                                        required="required">
                                    <option></option>
                                    <?php
                                        if ( count ( $stores ) > 0 ) {
                                            foreach ( $stores as $store ) {
                                                ?>
                                                <option value="<?php echo $store -> id ?>" <?php if ( $requisition -> item_id == $store -> id ) echo 'selected="selected"' ?>>
                                                    <?php echo $store -> item ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="quantity">Quantity</label>
                                <input type="number" min="1" name="quantity" id="quantity" class="form-control"
                                       value="<?php echo $requisition -> quantity ?>">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="price">Price</label>
                                <input type="number" step="0.01" min="0" name="price" id="price" class="form-control"
                                       value="<?php echo $requisition -> price ?>">
                            </div>
                            <div class="form-group col-lg-5">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control"
                                          rows="3"><?php echo $requisition -> description ?></textarea>
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