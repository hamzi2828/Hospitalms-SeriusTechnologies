<div id="addMedicinePopup"></div>
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
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="caption" style="font-size: 16px">
                        <i class="fa fa-reorder"></i> Add Medicine Stock
                    </div>
                    <button data-toggle="modal" id="addNewMedicineBtn" type="button" class="btn btn-warning"
                            style="margin-top: -5px;">Add New Medicine
                    </button>
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_medicine_stock">
                    <div class="form-body">
                        
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Supplier</label>
                            <select name="supplier_id" class="form-control select2me" data-placeholder="Select" required="required"
                                    onchange="check_if_invoice_already_exists()" id="supplier_id">
                                <option></option>
                                <?php
                                    if ( count ( $suppliers ) > 0 ) {
                                        foreach ( $suppliers as $supplier ) {
                                            ?>
                                            <option value="<?php echo $supplier -> id ?>">
                                                <?php echo $supplier -> title ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">
                                Supplier Invoice
                                <small style="color: #ff0000">
                                    (Slashes (/,\ and space) are not allowed)
                                </small>
                            </label>
                            <input type="text" name="supplier_invoice" class="form-control" required="required"
                                   id="invoice_number" onchange="check_if_invoice_already_exists()">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Date</label>
                            <input type="text" name="date_added" class="date date-picker form-control"
                                   required="required" value="<?php echo date ( 'm/d/Y' ) ?>">
                        </div>
                        
                        <input type="hidden" id="added" value="1">
                        
                        <div class="col-md-4">
                            <select class="form-control select2me"
                                    onchange="get_medicine_for_add_stock(this.value)"
                                    data-placeholder="Select"
                                    id="add-stock-medicines-dropdown">
                                <option></option>
                                <?php
                                    if ( count ( $medicines ) > 0 ) {
                                        foreach ( $medicines as $medicine ) {
                                            ?>
                                            <option value="<?php echo $medicine -> id ?>"
                                                    class="medicine-option-<?php echo $medicine -> id ?>">
                                                <?php
                                                    echo $medicine -> name . ' ' . get_strength ( $medicine -> strength_id ) -> title . ' (' . get_form ( $medicine -> form_id ) -> title . ')';
                                                ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="add-stock-rows"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
                                <strong>Disc. (%)</strong>
                            </div>
                            <div class="col-md-2" style="margin-top: 10px">
                                <input type="text" name="grand_total_discount"
                                       class="form-control grand_total_discount"
                                       onchange="calculate_grand_total_discount(this.value)" value="0">
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
                    <div class="form-actions col-lg-12">
                        <button type="submit" class="btn blue" id="submit-btn">Submit</button>
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
        margin-bottom: 10px;
    }
</style>