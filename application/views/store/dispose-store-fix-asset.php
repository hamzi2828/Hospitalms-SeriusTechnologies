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
                    <i class="fa fa-reorder"></i> Dispose Store Asset
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="dispose_store_fix_asset">
                    <input type="hidden" name="id" value="<?php echo $assetInfo -> id ?>">
                    <input type="hidden" name="store-id" value="<?php echo $assetInfo -> store_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label for="item">Item</label>
                                <select id="item" class="form-control select2me" required="required"
                                        disabled="disabled">
                                    <?php
                                        if ( count ( $items ) > 0 ) {
                                            foreach ( $items as $item ) {
                                                ?>
                                                <option
                                                        value="<?php echo $item -> id ?>" <?php if ( $assetInfo -> store_id == $item -> id ) echo 'selected="selected"' ?>>
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
                                <select id="account-head" class="form-control select2me"
                                        required="required" disabled="disabled">
                                    <?php
                                        if ( count ( $assets ) > 0 ) {
                                            foreach ( $assets as $asset ) {
                                                ?>
                                                <option
                                                        value="<?php echo $asset -> id ?>" <?php if ( $assetInfo -> account_head_id == $asset -> id ) echo 'selected="selected"' ?>>
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
                                <select id="department" class="form-control select2me"
                                        required="required" disabled="disabled">
                                    <?php
                                        if ( count ( $departments ) > 0 ) {
                                            foreach ( $departments as $department ) {
                                                ?>
                                                <option
                                                        value="<?php echo $department -> id ?>" <?php if ( $assetInfo -> department_id == $department -> id ) echo 'selected="selected"' ?>>
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
                                <input type="text" id="invoice" class="form-control"
                                       placeholder="Invoice No"
                                       value="<?php echo set_value ( 'invoice', $assetInfo -> invoice ) ?>"
                                       maxlength="255" readonly="readonly"
                                       required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="value">Value</label>
                                <input type="number" step="0.01" id="value" name="total-asset-value" class="form-control"
                                       placeholder="Value" readonly="readonly"
                                       value="<?php echo set_value ( 'value', $assetInfo -> value ) ?>" maxlength="255"
                                       required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="date">Date</label>
                                <input type="text" id="date" class="form-control date-picker"
                                       placeholder="Date" readonly="readonly"
                                       value="<?php echo set_value ( 'date_added', $assetInfo -> purchase_date ) ?>"
                                       maxlength="255"
                                       required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="location">Location</label>
                                <input type="text" id="location" class="form-control"
                                       placeholder="Location" readonly="readonly"
                                       value="<?php echo set_value ( 'location', $assetInfo -> location ) ?>"
                                       maxlength="255">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="code">Code</label>
                                <input type="text" id="code" class="form-control"
                                       placeholder="Code" readonly="readonly"
                                       value="<?php echo set_value ( 'code', $assetInfo -> code ) ?>" maxlength="255">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="quantity">Quantity</label>
                                <input type="number" min="0" id="quantity" class="form-control"
                                       placeholder="Quantity" readonly="readonly"
                                       value="<?php echo set_value ( 'quantity', $assetInfo -> quantity ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="depreciation">Depreciation (%)</label>
                                <input type="number" id="depreciation" class="form-control"
                                       placeholder="Depreciation Value (%)" step="0.01" readonly="readonly"
                                       value="<?php echo set_value ( 'depreciation', $assetInfo -> depreciation ) ?>"
                                       min="0" max="100">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="depreciation-charge">Depreciation Charge</label>
                                <select id="depreciation-charge" disabled="disabled"
                                        class="form-control select2me" data-placeholder="Select"
                                        required="required">
                                    <option></option>
                                    <option
                                            value="purchase-date" <?php if ( $assetInfo -> depreciation_charge == 'purchase-date' ) echo 'selected="selected"' ?>>
                                        Date of Purchase
                                    </option>
                                    <option
                                            value="annual" <?php if ( $assetInfo -> depreciation_charge == 'annual' ) echo 'selected="selected"' ?>>
                                        Annual
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="total-accumulative-depreciation">Total Accumulative Depreciation</label>
                                <input type="text" id="total-accumulative-depreciation" readonly="readonly"
                                       class="form-control" name="total-accumulative-depreciation"
                                       placeholder="Total Accumulative Depreciation"
                                       value="<?php echo $total_accumulative_dep ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="dispose-quantity">Dispose Quantity</label>
                                <input type="number" id="dispose-quantity" name="dispose-quantity"
                                       class="form-control" min="1" max="<?php echo $assetInfo -> quantity ?>"
                                       placeholder="Dispose Quantity" autofocus="autofocus"
                                       value="<?php echo set_value ( 'dispose-quantity' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="dispose-value">Dispose Value</label>
                                <input type="number" id="dispose-value" name="dispose-value"
                                       class="form-control" min="0"
                                       placeholder="Dispose Value" step="0.01"
                                       value="<?php echo set_value ( 'dispose-value' ) ?>">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="description">Description</label>
                                <textarea id="description" class="form-control"
                                          placeholder="Description" readonly="readonly"
                                          rows="3"><?php echo set_value ( 'description', $assetInfo -> description ) ?></textarea>
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