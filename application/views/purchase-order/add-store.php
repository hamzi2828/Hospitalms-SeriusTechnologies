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
                    <i class="fa fa-reorder"></i> Add Purchase Order (Store)
                </div>
            </div>
            <div class="portlet-body" style="overflow: auto;overflow-x: hidden;">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_store_purchase_order">
                    <input type="hidden" id="added" value="1">
                    
                    <div class="row">
                        <div style="display: flex; width: 100%; border-bottom: 1px solid #d5d5d5; float: left; margin-bottom: 15px;">
                            <div class="form-group col-lg-offset-4 col-lg-3">
                                <label for="exampleInputEmail1">Supplier</label>
                                <select name="supplier_id" class="form-control select2me" required="required">
                                    <option value="">Select Supplier</option>
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
                        </div>
                    </div>
                    
                    <div class="row" style="min-height: 300px">
                        <div class="col-md-4">
                            <select data-placeholder="Select" class="form-control select2me"
                                    onchange="load_store_purchase_order(this.value)"
                                    id="purchase-order-store-dropdown">
                                <option></option>
                                <?php
                                    if ( count ( $stores ) > 0 ) {
                                        foreach ( $stores as $store ) {
                                            ?>
                                            <option value="<?php echo $store -> id ?>"
                                                    class="option-<?php echo $store -> id ?>">
                                                <?php echo $store -> item; ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <div class="low-threshold-medicines"></div>
                            <div class="add-more-purchase-order"></div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="form-group col-lg-offset-9 col-lg-3">
                            <label for="exampleInputEmail1"><b>Net Amount</b></label>
                            <input type="text" name="net_amount" class="form-control net_amount" value="0"
                                   readonly="readonly">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-actions" style="padding-left: 15px">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .add-more-purchase-order, .add-more-order {
        width: 100%;
        display: block;
        float: left;
    }
</style>