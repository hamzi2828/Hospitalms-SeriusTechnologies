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
                    <i class="fa fa-reorder"></i> Add Store Items
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_store">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="item" class="form-control"
                                       placeholder="Add item name"
                                       autofocus="autofocus" value="<?php echo set_value ( 'item' ) ?>" maxlength="255"
                                       required="required">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="threshold">Threshold</label>
                                <input type="text" id="threshold" name="threshold" class="form-control"
                                       placeholder="Add item threshold"
                                       value="<?php echo set_value ( 'threshold' ) ?>" maxlength="255"
                                       required="required">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="type">Type</label>
                                <select name="type" class="form-control select2me" id="type">
                                    <option value="">Select</option>
                                    <option value="consumable-lab">Consumable (Lab)</option>
                                    <option value="consumable">Consumable (General)</option>
                                    <option value="fix-assets">Fix Assets</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="department">Department</label>
                                <select name="department-id" class="form-control select2me"
                                        id="department" data-placeholder="Select" data-allow-clear="true">
                                    <option></option>
                                    <?php
                                        if ( count ( $departments ) > 0 ) {
                                            foreach ( $departments as $department ) {
                                                ?>
                                                <option
                                                        value="<?php echo $department -> id ?>"><?php echo $department -> name ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="regent-quantity">Regent Quantity (ML)</label>
                                <input type="text" name="regent_quantity" class="form-control"
                                       placeholder="Quantity (ML)" id="regent-quantity"
                                       value="<?php echo set_value ( 'regent_quantity' ) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="patient-reg-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>