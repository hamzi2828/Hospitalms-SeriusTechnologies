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
                    <i class="fa fa-reorder"></i> Refund Lab
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="sale_id" value="<?php echo $lab -> id ?>">
                    <input type="hidden" name="lab_total" value="<?php echo $lab_total ?>">
                    <input type="hidden" name="action" value="do_refund_lab">
                    <div class="form-body" style="overflow:auto;">
                        <div class="row">
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Net Bill</label>
                                <input type="text" class="form-control" readonly="readonly"
                                       value="<?php echo ( $lab -> discount > 0 || $lab -> flat_discount > 0 ) ? $lab_sales_total : $lab -> total ?>"
                                       name="accounts_value">
                                <input type="hidden" class="form-control" readonly="readonly"
                                       value="<?php echo $lab -> total ?>" name="net_bill">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Discount (%)</label>
                                <input type="text" class="form-control" readonly="readonly"
                                       value="<?php echo $lab -> discount ?>" name="discount">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Discount (Flat)</label>
                                <input type="text" class="form-control" readonly="readonly"
                                       value="<?php echo $lab -> flat_discount ?>" name="flat_discount">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Amount Paid To Customer</label>
                                <input type="text" class="form-control" name="amount_paid_to_customer" required="required"
                                       readonly="readonly" value="<?php echo ( $lab -> total ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Date</label>
                                <input type="text" class="form-control date-picker" name="date_added" required="required"
                                       value="<?php echo date ( 'm/d/Y' ) ?>">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="exampleInputEmail1">Discharge Reason</label>
                                <textarea type="text" class="form-control" rows="5" name="description" required="required">Lab Test Return. Sale# <?php echo $lab -> id . $panel; ?></textarea>
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