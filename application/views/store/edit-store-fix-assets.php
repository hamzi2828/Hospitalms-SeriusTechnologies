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
                    <i class="fa fa-reorder"></i> Edit Store - Fix Assets
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_store_fix_assets">
                    <input type="hidden" name="asset_id" value="<?php echo $fix_asset -> id ?>">
                    <div class="form-body" style="overflow: auto">
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Item</label>
                            <select name="store_id" class="form-control select2me" required="required">
                                <?php
                                    if ( count ( $items ) > 0 ) {
                                        foreach ( $items as $item ) {
                                            ?>
                                            <option
                                                value="<?php echo $item -> id ?>" <?php if ( $fix_asset -> store_id == $item -> id ) echo 'selected="selected"' ?>>
                                                <?php echo $item -> item ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Account Head</label>
                            <select name="account_head_id" class="form-control select2me" required="required">
                                <option value="<?php echo $fix_asset -> account_head_id ?>">
                                    <?php echo get_account_head ( $fix_asset -> account_head_id ) -> title ?>
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Department</label>
                            <select name="department_id" class="form-control select2me" required="required">
                                <?php
                                    if ( count ( $departments ) > 0 ) {
                                        foreach ( $departments as $department ) {
                                            ?>
                                            <option
                                                value="<?php echo $department -> id ?>" <?php if ( $fix_asset -> department_id == $department -> id ) echo 'selected="selected"' ?>>
                                                <?php echo $department -> name ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Invoice</label>
                            <input type="text" name="invoice" class="form-control" placeholder="Invoice No"
                                   value="<?php echo $fix_asset -> invoice ?>" maxlength="255" required="required">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Value</label>
                            <input type="text" name="value" class="form-control" placeholder="Value"
                                   value="<?php echo $fix_asset -> value ?>" maxlength="255" required="required">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Date</label>
                            <input type="text" name="date_added" class="form-control date-picker" placeholder="Date"
                                   value="<?php echo date ( 'm/d/Y', strtotime ( $fix_asset -> purchase_date ) ) ?>"
                                   maxlength="255" required="required">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="location">Location</label>
                            <input type="text" id="location" name="location" class="form-control"
                                   placeholder="Location"
                                   value="<?php echo set_value ( 'location', $fix_asset -> location ) ?>"
                                   maxlength="255">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="depreciation">Depreciation (%)</label>
                            <input type="number" id="depreciation" name="depreciation" class="form-control"
                                   placeholder="Depreciation Value (%)" step="0.01"
                                   value="<?php echo set_value ( 'depreciation', $fix_asset -> depreciation ) ?>"
                                   min="0"
                                   max="100">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="depreciation-charge">Depreciation Charge</label>
                            <select id="depreciation-charge" name="depreciation-charge"
                                    class="form-control select2me" data-placeholder="Select"
                                    required="required">
                                <option></option>
                                <option
                                    value="purchase-date" <?php if ( $fix_asset -> depreciation_charge == 'purchase-date' ) echo 'selected="selected"' ?>>
                                    Date of Purchase
                                </option>
                                <option
                                    value="annual" <?php if ( $fix_asset -> depreciation_charge == 'annual' ) echo 'selected="selected"' ?>>
                                    Annual
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-9">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Description"
                                      rows="5"><?php echo $fix_asset -> description ?></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="patient-reg-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>