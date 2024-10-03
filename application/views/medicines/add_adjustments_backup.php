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
                    <i class="fa fa-reorder"></i> Medicine Adjustments (Decrease)
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger expiry-response" style="display: none"></div>
                <div class="alert alert-danger type-response" style="display: none"></div>
                <form role="form" method="post" autocomplete="off" id="sale-medicine-form">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_medicine_adjustments">
                    <input type="hidden" value="1" id="added">
                    <div class="form-body" style="overflow: auto">
                        <div class="sale-1 sale-fields">
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Medicine</label>
                                <select name="medicine_id[]" class="form-control select2me" required="required"
                                        onchange="get_stock_adjustments(this.value, 1)">
                                    <option value="">Select Medicine</option>
                                    <?php
                                        if ( count ( $medicines ) > 0 ) {
                                            foreach ( $medicines as $medicine ) {
                                                ?>
                                                <option value="<?php echo $medicine -> id ?>">
                                                    <?php echo $medicine -> name ?>
                                                    <?php if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 ) : ?>
                                                        (<?php echo get_form ( $medicine -> form_id ) -> title ?> - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
                                                    <?php endif ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Batch</label>
                                <div class="batch">
                                    <input type="text" class="form-control" readonly="readonly">
                                </div>
                            </div>
                            <div class="form-group col-lg-1">
                                <label for="exampleInputEmail1">Available</label>
                                <input type="text" class="form-control" readonly="readonly" id="available-qty">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Sale Qty.</label>
                                <input type="text" class="form-control" name="quantity[]"
                                       onchange="calculate_net_price(this.value, '1')" id="quantity"
                                       required="required">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Price</label>
                                <input type="text" class="form-control" readonly="readonly" name="price[]" id="price">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Net Price</label>
                                <input type="text" class="form-control net-price" readonly="readonly" name="net_price[]"
                                       value="">
                            </div>
                        </div>
                        <div id="sale-more-medicine"></div>
                        <div class="col-lg-1 col-lg-offset-9">
                            <strong class="total-net-price">Total</strong>
                        </div>
                        <div class="col-lg-2" style="margin-bottom: 5px;">
                            <input type="text" class="form-control total" readonly="readonly" value="0">
                        </div>
                        <div class="col-lg-1 col-lg-offset-9 hidden">
                            <strong class="total-net-price">Disc(%)</strong>
                        </div>
                        <div class="col-lg-2 hidden" style="margin-bottom: 5px;">
                            <input type="text" class="form-control sale_discount grand_total_discount"
                                   name="sale_discount" onchange="calculate_sale_discount(this.value)" value="0">
                        </div>
                        <div class="col-lg-1 col-lg-offset-9 hidden">
                            <strong class="total-net-price">Flat Disc.</strong>
                        </div>
                        <div class="col-lg-2 hidden" style="margin-bottom: 5px;">
                            <input type="text" class="form-control flat_discount" name="flat_discount"
                                   onchange="calculate_flat_sale_discount(this.value)" value="0">
                        </div>
                        <div class="col-lg-2 col-lg-offset-8 hidden">
                            <strong class="total-net-price">Add Amount</strong>
                        </div>
                        <div class="col-lg-2 hidden" style="margin-bottom: 5px;">
                            <input type="text" class="form-control added_amount" name="added_amount"
                                   onchange="calculate_added_amount_total(this.value)" value="0">
                        </div>
                        <div class="col-lg-1 col-lg-offset-9" style="margin-bottom: 5px;">
                            <strong class="total-net-price">Net Total</strong>
                        </div>
                        <div class="col-lg-2">
                            <input type="text" name="total" id="total-net-price" readonly="readonly"
                                   class="form-control grand_total">
                        </div>
                        <div class="col-lg-1 col-lg-offset-9 hidden" style="margin-bottom: 5px;">
                            <strong class="total-net-price">Paid</strong>
                        </div>
                        <div class="col-lg-2 hidden">
                            <input type="text" name="paid_amount" class="form-control"
                                   onchange="calculate_balance_after_payment(this.value)">
                        </div>
                        <div class="col-lg-1 col-lg-offset-9 hidden" style="margin-bottom: 5px;">
                            <strong class="total-net-price">Balance</strong>
                        </div>
                        <div class="col-lg-2 hidden">
                            <input type="text" readonly="readonly" class="form-control balance">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="sales-btn">Submit</button>
                        <button type="button" class="btn purple" onclick="add_more_sale_adjustments()">Add More</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .total-net-price {
        float: right;
        padding-top: 8px;
        font-size: 14px;
    }
    
    .sale-fields {
        width: 100%;
        display: block;
        float: left;
    }
</style>