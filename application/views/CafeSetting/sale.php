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
        <!-- <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
        <?php endif; ?> -->

        <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <script type='text/javascript'
                    language='Javascript'>window.open ( '<?php echo base_url ( 'invoices/cafesale-invoice/' . $this -> session -> flashdata ( 'response' ) ) ?>' );</script>
        <?php endif; ?>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Cafe Sale 
                </div>
            </div>
            <div class="portlet-body form">
            <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_store_stock_for_cafe">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body">
                        
                        <div class="row" style="min-height: 300px">
                            <div class="col-md-4">
                                <select name="store_id[]" id="store-items-add-stock-dropdown" data-placeholder="Select"
                                        class="form-control select2me"
                                        onchange="load_store_item_cafe_sale(this.value)">
                                    <option></option>
                                    <?php
                                        if ( count ( $products ) > 0 ) {
                                            foreach ( $products as $store ) {
                                                ?>
                                                <option value="<?php echo $store -> id ?>"
                                                        class="option-<?php echo $store -> id ?>">
                                                    <?php echo $store -> name ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="add-more-store-stock"></div>
                            </div>
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
                                <strong>Dis.(Flat) </strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                                <input type="text" name="grand_total_discount" class="form-control grand_total_discount"
                                       onchange="calculate_grand_total_discount_for_cafe(this.value)"  value="0.00">
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
                                <strong>Dis.(%) </strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                                <input type="text" name="grand_total_discount_percentage" class="form-control grand_total_discount"
                                       onchange="calculate_grand_total_discount_for_cafe(this.value)"  value="0.00">
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
                                <strong>G. Total</strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                                <input type="text" name="grand_total" class="form-control grand_total"
                                       readonly="readonly">
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
                                <strong>Paid</strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                            <input type="text" name="paid_amount" class="form-control paid_amount"
                                  oninput="calculate_balance_after_payment_for_cafe(this.value)">

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
                                <strong>Balance</strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                                <input type="text" name="net_balance_remaning" class="form-control net_balance_remaning"
                                       readonly="readonly">
                            </div>
                        </div> -->
                    </div>
                    
                    <div class="form-actions" style="padding-left: 10px">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .form {
        width: 100%;
        display: block;
        overflow-x: hidden;
        /* float: left; */
        clear: both;
        overflow-y: hidden;
    }

    .stock-rows {
        display: block;
        width: 100%;
        float: left;
        background: #e3e3e3;
        padding: 10px 0;
    }
</style>