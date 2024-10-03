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
                    <i class="fa fa-reorder"></i> Edit Issued Medicine(s)
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger expiry-response" style="display: none"></div>
                <div class="alert alert-danger type-response" style="display: none"></div>
                <?php if ( count ( $issuance ) > 0 ) : ?>
                    <form role="form" method="post" autocomplete="off" id="sale-medicine-form">
                        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                               value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                        <input type="hidden" name="selected" value="" id="selected_batch">
                        <input type="hidden" name="action" value="do_update_issued_medicine_internal">
                        <input type="hidden" name="sale_id" value="<?php echo $_REQUEST[ 'sale_id' ] ?>">
                        <input type="hidden" value="1" id="added">
                        <div class="form-body" style="overflow: auto">
                            <div class="form-group col-lg-12" style="padding: 0">
                                <div class="col-lg-3 col-lg-offset-3">
                                    <label for="exampleInputEmail1">Department</label>
                                    <select name="department_id" class="form-control select2me" id="department"
                                            required="required">
                                        <option value="">Select</option>
                                        <?php
                                            if ( count ( $departments ) > 0 ) {
                                                foreach ( $departments as $department ) {
                                                    ?>
                                                    <option value="<?php echo $department -> id ?>" <?php if ( $issuance[ 0 ] -> department_id == $department -> id ) echo 'selected="selected"' ?>>
                                                        <?php echo $department -> name ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="exampleInputEmail1">Member</label>
                                    <select name="user_id" class="form-control select2me" required="required">
                                        <option value="">Select</option>
                                        <?php
                                            if ( count ( $users ) > 0 ) {
                                                foreach ( $users as $user ) {
                                                    ?>
                                                    <option value="<?php echo $user -> id ?>" <?php if ( $issuance[ 0 ] -> issue_to == $user -> id ) echo 'selected="selected"' ?>>
                                                        <?php echo $user -> name ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php $counter = 1;
                                foreach ( $issuance as $item ) :
                                    $counter++;
                                    $medicine = get_medicine ( $item -> medicine_id );
                                    $stock = get_stock ( $item -> stock_id );
                                    ?>
                                    <div class="sale-<?php echo $counter ?> sale-fields">
                                        <div class="form-group col-lg-5">
                                            <a href="<?php echo base_url ( '/internal-issuance/delete-single-issuance/' . $item -> id ) ?>"
                                               onclick="return confirm('Are you sure?')">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            <label for="exampleInputEmail1">Medicine</label>
                                            <select name="medicine_id[]" class="form-control select2me"
                                                    required="required">
                                                <option value="<?php echo $item -> medicine_id ?>">
                                                    <?php echo $medicine -> name ?>
                                                    <?php if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 ) : ?>
                                                        (<?php echo get_form ( $medicine -> form_id ) -> title ?> - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
                                                    <?php endif ?>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-3">
                                            <label for="exampleInputEmail1">Batch No#</label>
                                            <select name="stock_id[]" class="form-control select2me"
                                                    required="required">
                                                <option value="<?php echo $item -> stock_id ?>">
                                                    <?php echo $stock -> batch ?>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <label for="exampleInputEmail1">Available</label>
                                            <input type="text" class="form-control available-qty-<?php echo $counter ?>"
                                                   readonly="readonly" id="available-qty"
                                                   value="<?php echo count_stock_available_quantity ( $item -> medicine_id, $stock ) ?>">
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <label for="exampleInputEmail1">Issued</label>
                                            <input type="text" class="form-control quantity-<?php echo $counter ?>"
                                                   name="quantity[]"
                                                   onchange="check_if_quantity_is_valid(this.value, <?php echo $counter ?>)"
                                                   readonly="readonly" id="quantity" required="required"
                                                   value="<?php echo $item -> quantity + $item -> returned ?>">
                                        </div>
                                        <div class="form-group col-lg-1 hidden">
                                            <label for="exampleInputEmail1">Returned</label>
                                            <input type="text" class="form-control" name="return[]"
                                                   value="<?php echo $item -> returned ?>">
                                        </div>
                                        <div class="form-group col-lg-2 hidden">
                                            <label for="exampleInputEmail1">Used Qty.</label>
                                            <input type="text" class="form-control" readonly="readonly"
                                                   value="<?php echo $item -> quantity ?>">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <div id="sale-more-medicine"></div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn blue" id="issue-button">Submit</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .total-net-price {
        float: right;
        padding-top: 8px;
        font-size: 16px;
    }
    
    .sale-fields {
        width: 100%;
        display: block;
        float: left;
    }
</style>