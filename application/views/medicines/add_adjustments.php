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
                    <input type="hidden" name="selected" value="" id="selected_batch">
                    <input type="hidden" value="1" id="added">
                    <div class="form-body" style="overflow:auto; overflow-x: hidden">
                        
                        <div style="min-height: 300px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-control select2me"
                                            data-placeholder="Select Medicine" id="sale-medicines-dropdown"
                                            onchange="get_stock_for_sale(this.value, 0, true)">
                                        <option></option>
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
                                <div class="col-md-8">
                                    <table class="table table-bordered" border="1">
                                        <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Medicine</th>
                                            <th>Batch</th>
                                            <th>Available Qty.</th>
                                            <th>Sale Qty.</th>
                                            <th>Price</th>
                                            <th>Net Price</th>
                                        </tr>
                                        </thead>
                                        <tbody id="sale-more-medicine"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div id="sale-payment-info">
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
                            <div class="col-lg-1 col-lg-offset-9 hidden" style="margin-bottom: 5px;">
                                <strong class="total-net-price">Net Total</strong>
                            </div>
                            <div class="col-lg-2 hidden">
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
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                        <a href="<?php echo base_url ( '/medicines/sale/?action=clear-sale' ) ?>"
                           class="btn dark"
                           onclick="return confirm('Are you sure?')">Clear Adjustments</a>
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
<script type="text/javascript">
    $ ( window ).on ( 'load', function () {
        get_locked_medicines ();
        $ ( document ).on ( 'click', '#close-popup', function () {
            $ ( '#locked-medicines' ).remove ();
        } )
    } )
</script>