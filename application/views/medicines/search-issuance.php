<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger expiry-response" style="display: none"></div>
        <div class="alert alert-danger type-response" style="display: none"></div>
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
        <div class="search-form">
            <form method="get" autocomplete="off">
                <div class="form-group col-lg-2 col-lg-offset-2">
                    <label for="exampleInputEmail1">Issuance ID</label>
                    <input type="text" name="issuance_id" class="form-control"
                           value="<?php echo @$_REQUEST[ 'issuance_id' ] ?>">
                </div>
                <div class="form-group col-lg-3" style="padding-left: 0">
                    <label for="exampleInputEmail1">Issue To</label>
                    <select name="user_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $users ) > 0 ) {
                                foreach ( $users as $user ) {
                                    ?>
                                    <option value="<?php echo $user -> id ?>" <?php if ( $user -> id == @$_REQUEST[ 'user_id' ] ) echo 'selected="selected"' ?>>
                                        <?php echo $user -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Date</label>
                    <input type="text" name="date" class="form-control date-picker"
                           value="<?php if ( isset( $_REQUEST[ 'date' ] ) and !empty( trim ( $_REQUEST[ 'date' ] ) ) ) echo date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'date' ] ) ) ?>">
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" style="margin-top: 25px" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Issue Medicine
                </div>
            </div>
            <div class="portlet-body form">
                <?php if ( count ( $issuance ) > 0 ) : ?>
                    <form role="form" method="post" autocomplete="off" id="sale-medicine-form">
                        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                               value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                        <input type="hidden" name="action" value="do_issue_medicine_internal">
                        <input type="hidden" value="1" id="added">
                        <div class="form-body">
                            <div class="row">
                                <?php $counter = 1;
                                    foreach ( $issuance as $item ) : $counter++; ?>
                                        <?php $medicine = get_medicine ( $item -> medicine_id ); ?>
                                        <div class="sale-<?php echo $counter ?> sale-fields">
                                            <div class="form-group col-lg-4">
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
                                            <div class="form-group col-lg-4">
                                                <label for="exampleInputEmail1">Batch No#</label>
                                                <select name="stock_id[]" class="form-control select2me"
                                                        required="required">
                                                    <option value="<?php echo $item -> stock_id ?>">
                                                        <?php echo get_stock ( $item -> stock_id ) -> batch ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Available</label>
                                                <input type="text" class="form-control available-qty-<?php echo $counter ?>"
                                                       readonly="readonly" id="available-qty"
                                                       value="<?php echo count_stock_available_quantity ( $item -> medicine_id, get_stock ( $item -> stock_id ) ) ?>">
                                            </div>
                                            <div class="form-group col-lg-2">
                                                <label for="exampleInputEmail1">Sale Qty.</label>
                                                <input type="text" class="form-control quantity-<?php echo $counter ?>"
                                                       name="quantity[]"
                                                       onchange="check_if_quantity_is_valid(this.value, <?php echo $counter ?>)"
                                                       id="quantity" required="required"
                                                       value="<?php echo $item -> quantity ?>">
                                            </div>
                                        </div>
                                    <?php endforeach;
                                ?>
                            </div>
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