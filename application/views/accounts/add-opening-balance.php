<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Opening Balance
                </div>
            </div>
            <div class="portlet-body form">
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
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_opening_balances">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Choose Account Head</label>
                                <select name="acc_head_id" class="form-control select2me" required="required">
                                    <option value="">Select Account Head</option>
                                    <?php echo $account_heads ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Date</label>
                                <input type="text" name="date_added" class="date date-picker form-control"
                                       value="<?php echo date ( 'm/d/Y' ) ?>" required="required">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Amount</label>
                                <input type="text" name="amount" class="form-control" placeholder="Add amount"
                                       value="<?php echo set_value ( 'amount' ) ?>" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="">Transaction Type</label>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="transaction_type" value="credit"> Debit
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="transaction_type" value="debit"> Credit
                                    </label>
                                </div>
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
        font-weight : 600;
    }
    
    .child {
        padding-left : 15px;
    }
    
    .sub-child {
        padding-left : 30px;
    }
    
    .has-sub-child {
        font-weight  : 600;
        padding-left : 15px;
    }
</style>