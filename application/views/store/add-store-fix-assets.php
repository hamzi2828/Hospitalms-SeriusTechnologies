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
        <?php if ( $this -> session -> flashdata ( 'redirect_url' ) ) : ?>
            <script type="text/javascript">
                window.location.href = "<?php echo $this -> session -> flashdata ( 'redirect_url' ) ?>";
            </script>
        <?php endif; ?>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Store - Fix Assets
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_store_fix_assets">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label for="item">Item</label>
                                <select name="store_id" id="item" class="form-control select2me" required="required">
                                    <?php
                                        if ( count ( $items ) > 0 ) {
                                            foreach ( $items as $item ) {
                                                ?>
                                                <option
                                                        value="<?php echo $item -> id ?>" <?php if ( $this -> input -> post ( 'store_id' ) == $item -> id ) echo 'selected="selected"' ?>>
                                                    <?php echo $item -> item ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="account-head">Account Head</label>
                                <select id="account-head" name="account_head_id" class="form-control select2me"
                                        required="required">
                                    <?php
                                        if ( count ( $assets ) > 0 ) {
                                            foreach ( $assets as $asset ) {
                                                ?>
                                                <option
                                                        value="<?php echo $asset -> id ?>" <?php if ( $this -> input -> post ( 'account_head_id' ) == $asset -> id ) echo 'selected="selected"' ?>>
                                                    <?php echo $asset -> title ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="department">Department</label>
                                <select id="department" name="department_id" class="form-control select2me"
                                        required="required">
                                    <?php
                                        if ( count ( $departments ) > 0 ) {
                                            foreach ( $departments as $department ) {
                                                ?>
                                                <option
                                                        value="<?php echo $department -> id ?>" <?php if ( $this -> input -> post ( 'department_id' ) == $department -> id ) echo 'selected="selected"' ?>>
                                                    <?php echo $department -> name ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="invoice">Invoice</label>
                                <input type="text" id="invoice" name="invoice" class="form-control"
                                       placeholder="Invoice No" autofocus="autofocus"
                                       value="<?php echo set_value ( 'invoice' ) ?>" maxlength="255"
                                       required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="value">Value</label>
                                <input type="number" step="0.01" id="value" name="value" class="form-control"
                                       placeholder="Value"
                                       value="<?php echo set_value ( 'value' ) ?>" maxlength="255" required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="date">Date</label>
                                <input type="text" id="date" name="date_added" class="form-control date-picker"
                                       placeholder="Date"
                                       value="<?php echo set_value ( 'date_added' ) ?>" maxlength="255"
                                       required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="location">Location</label>
                                <input type="text" id="location" name="location" class="form-control"
                                       placeholder="Location"
                                       value="<?php echo set_value ( 'location' ) ?>" maxlength="255">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="quantity">Quantity</label>
                                <input type="number" min="0" id="quantity" name="quantity" class="form-control"
                                       placeholder="Quantity"
                                       value="<?php echo set_value ( 'quantity', 0 ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="depreciation">Depreciation (%)</label>
                                <input type="number" id="depreciation" name="depreciation" class="form-control"
                                       placeholder="Depreciation Value (%)" step="0.01"
                                       value="<?php echo set_value ( 'depreciation' ) ?>" min="0" max="100">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="depreciation-charge">Depreciation Charge</label>
                                <select id="depreciation-charge" name="depreciation-charge"
                                        class="form-control select2me" data-placeholder="Select"
                                        required="required">
                                    <option></option>
                                    <option
                                            value="purchase-date" <?php if ( $this -> input -> post ( 'depreciation-charge' ) == 'purchase-date' ) echo 'selected="selected"' ?>>
                                        Date of Purchase
                                    </option>
                                    <option
                                            value="annual" <?php if ( $this -> input -> post ( 'depreciation-charge' ) == 'annual' ) echo 'selected="selected"' ?>>
                                        Annual
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control"
                                          placeholder="Description"
                                          rows="3"><?php echo set_value ( 'description' ) ?></textarea>
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