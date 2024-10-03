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
                    <i class="fa fa-reorder"></i> Add Store Stock
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_store_stock">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body">
                        
                        <div class="row">
                            <div style="display: flex; width: 100%; border-bottom: 1px solid #d5d5d5; float: left; margin-bottom: 15px;">
                                <div class="form-group col-lg-4">
                                    <label for="supplier_id">Supplier</label>
                                    <select name="supplier_id" class="form-control select2me" id="supplier_id"
                                            data-placeholder="Select" required="required">
                                        <option></option>
                                        <optgroup label="Store Suppliers">
                                            <?php
                                                if ( count ( $suppliers ) > 0 ) {
                                                    foreach ( $suppliers as $supplier ) {
                                                        echo '<option value="' . $supplier -> id . '">' . $supplier -> title . '</option>';
                                                    }
                                                }
                                            ?>
                                        </optgroup>
                                        <optgroup label="Lab Suppliers">
                                            <?php
                                                if ( count ( $lab_suppliers ) > 0 ) {
                                                    foreach ( $lab_suppliers as $supplier ) {
                                                        echo '<option value="' . $supplier -> id . '">' . $supplier -> title . '</option>';
                                                    }
                                                }
                                            ?>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="Invoice">Supplier Invoice</label>
                                    <input type="text" name="invoice" class="form-control invoice" id="Invoice"
                                           onchange="validate_store_stock_invoice_number(this.value)"
                                           required="required">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="Date">Date</label>
                                    <input type="text" name="date_added" class="date date-picker form-control" id="Date"
                                           value="<?php echo date ( 'm/d/Y' ) ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" style="min-height: 300px">
                            <div class="col-md-4">
                                <select name="store_id[]" id="store-items-add-stock-dropdown" data-placeholder="Select"
                                        class="form-control select2me"
                                        onchange="load_store_item_for_stock(this.value)">
                                    <option></option>
                                    <?php
                                        if ( count ( $stores ) > 0 ) {
                                            foreach ( $stores as $store ) {
                                                ?>
                                                <option value="<?php echo $store -> id ?>"
                                                        class="option-<?php echo $store -> id ?>">
                                                    <?php echo $store -> item ?>
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
                                <strong>Disc. (%)</strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                                <input type="text" name="grand_total_discount" class="form-control grand_total_discount"
                                       onchange="calculate_grand_total_discount(this.value)">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
                                <strong>G.Total</strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                                <input type="text" name="grand_total" class="form-control grand_total"
                                       readonly="readonly">
                            </div>
                        </div>
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