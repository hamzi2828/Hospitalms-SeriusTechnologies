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
                    <i class="fa fa-reorder"></i> Add Account Head
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                    <input type="hidden" name="action" value="do_add_account_head">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Add account head"
                                       autofocus="autofocus" value="<?php echo set_value ( 'name' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="set-account-head-role">Choose Parent Account Head</label>
                                <select name="parent_id" class="form-control select2me" data-placeholder="Select"
                                        id="set-account-head-role">
                                    <option>Select</option>
                                    <?php echo $account_heads; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="role-id">Account Role</label>
                                <select name="role_id" id="role-id" class="form-control select2me">
                                    <option value="0">Select</option>
                                    <?php
                                        if ( count ( $roles ) > 0 ) {
                                            foreach ( $roles as $role ) {
                                                ?>
                                                <option value="<?php echo $role -> id ?>">
                                                    <?php echo $role -> name ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Contact Person</label>
                                <input type="text" name="contact_person" class="form-control"
                                       placeholder="Add contact person name"
                                       value="<?php echo set_value ( 'contact_person' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Contact Number</label>
                                <input type="text" name="phone" class="form-control"
                                       placeholder="Add contact person phone number"
                                       value="<?php echo set_value ( 'phone' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Status</label>
                                <select name="status" class="form-control select2me">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Account Type</label>
                                <select name="type" class="form-control select2me">
                                    <option value="">Select</option>
                                    <option value="<?php echo cash_patient ?>">Cash</option>
                                    <option value="<?php echo panel_patient ?>">Panel</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Balance Sheet</label>
                                <select name="balance-sheet" class="form-control select2me">
                                    <option value="">Select</option>
                                    <option value="current-assets">Current Assets</option>
                                    <option value="non-current-assets">Non-Current Assets</option>
                                    <option value="current-liabilities">Current Liabilities</option>
                                </select>
                            </div>
                            <?php /* <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Doctor</label>
                                <select name="doctor_id" class="form-control select2me">
                                    <option value="0">Select</option>
                                    <?php
                                        if ( count ( $doctors ) > 0 ) {
                                            foreach ( $doctors as $doctor ) {
                                                ?>
                                                <option value="<?php echo $doctor -> id ?>">
                                                    <?php echo $doctor -> name ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div> */ ?>
                            <div class="form-group col-lg-2 hidden">
                                <label for="exampleInputEmail1">Panel</label>
                                <select name="panel_id" class="form-control select2me">
                                    <option value="0">Select</option>
                                    <?php
                                        if ( count ( $panels ) > 0 ) {
                                            foreach ( $panels as $panel ) {
                                                ?>
                                                <option value="<?php echo $panel -> id ?>">
                                                    <?php echo $panel -> name ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea name="description" class="form-control" placeholder="Description"
                                          rows="5"><?php echo set_value ( 'description' ) ?></textarea>
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
<style>
    .has-child {
        font-weight: 600;
    }

    .child {
        padding-left: 15px;
    }

    .sub-child {
        padding-left: 30px;
    }

    .has-sub-child {
        font-weight: 600;
        padding-left: 15px;
    }
</style>
