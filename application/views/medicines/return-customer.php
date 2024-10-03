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
        <form method="post">
            <div class="form-group col-lg-4 margin-top-25">
                <select name="supplier_id" class="form-control select2me" required="required">
                    <option value="<?php echo return_customer ?>" selected="selected">
                        <?php echo get_account_head ( return_customer ) -> title ?>
                    </option>
                </select>
            </div>
            <div class="form-group col-lg-4">
                <label for="exampleInputEmail1">Auto System Invoice</label>
                <input type="text" name="supplier_invoice" readonly="readonly" class="form-control"
                       value="<?php echo unique_id ( 4 ); ?>">
            </div>
            <div class="form-group col-lg-4">
                <label for="exampleInputEmail1">Date</label>
                <input type="text" name="date_added" class="form-control date-picker"
                       value="<?php echo date ( 'm/d/Y' ) ?>">
            </div>
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Customer Return Stock Without Slip
                    </div>
                </div>
                <div class="portlet-body form">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_return_customer">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Medicine</label>
                                <select class="form-control select2me" data-placeholder="Select Medicine"
                                        id="return-customer-medicine-dropdown"
                                        onchange="add_medicine_return_customer(this.value)">
                                    <option></option>
                                    <?php
                                        if ( count ( $medicines ) > 0 ) {
                                            foreach ( $medicines as $medicine ) {
                                                if ( $medicine -> strength_id > 1 )
                                                    $strength = get_strength ( $medicine -> strength_id ) -> title;
                                                else
                                                    $strength = '';
                                                if ( $medicine -> form_id > 1 )
                                                    $form = get_form ( $medicine -> form_id ) -> title;
                                                else
                                                    $form = '';
                                                ?>
                                                <option value="<?php echo $medicine -> id ?>" class="medicine-<?php echo $medicine -> id ?>">
                                                    <?php
                                                        echo $medicine -> name . ' ' . $strength . ' ' . $form;
                                                    ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="col-md-8" style="padding: 0">
                                <div id="addMedicineReturnCustomer"></div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-offset-9 col-lg-1">
                                    <p class="text-right" style="padding-top: 9px;font-weight: 600">G.Total</p>
                                </div>
                                <div class="col-lg-2" style="padding-right: 0; padding-left: 25px">
                                    <input type="text" class="form-control" readonly="readonly" id="total">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END SAMPLE FORM PORTLET-->