<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger panel-info hidden"></div>
        <div class="alert alert-danger panel-discount-info hidden"></div>
        <?php if (validation_errors() != false) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('response')) : ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('response'); ?>
            </div>
        <?php endif; ?>
        <?php if ($patient->panel_id > 0) : ?>
            <div class="alert alert-danger">
                <strong>Note!</strong> Patient is a panel customer.
            </div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="action" value="do_edit_lab_sale_discount">
            <input type="hidden" name="id" value="<?php echo $sale->id ?>">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                   value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_token">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Edit Lab Sale Discount
                    </div>
                </div>
                <div class="portlet-body" style="overflow: hidden">
                    <div class="form-group col-lg-3" style="padding-left: 0">
                        <label>Patient EMR</label>
                        <input type="text" class="form-control" value="<?php echo $patient->id ?>" readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Patient Name</label>
                        <input type="text" class="form-control" value="<?php echo get_patient_name(0, $patient) ?>" readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Patient Contact No</label>
                        <input type="text" class="form-control" value="<?php echo $patient->mobile ?>" readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Invoice ID</label>
                        <input type="text" class="form-control" value="<?php echo $sale->id ?>" readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3" style="padding-left: 0">
                        <label>Price</label>
                        <input type="text" class="form-control" id="total_amount_display"
                            value="<?php echo number_format($sale->net, 2); ?>" readonly="readonly">
                        <input type="hidden" name="total_amount" id="total_amount" value="<?php echo $sale->net; ?>">
                    </div>

                    <div class="form-group col-lg-3">
                        <label>Discount (%)</label>
                        <input type="text" class="form-control" id="discount" name="discount"
                            value="<?php echo isset($sale->discount) ? $sale->discount : '0'; ?>"
                            <?php echo (!empty($sale->discount) && $sale->discount > 0) ? '' : 'readonly="readonly"'; ?>>
                    </div>

                    <div class="form-group col-lg-3">
                        <label>Flat Discount</label>
                        <input type="text" class="form-control" id="flat_discount" name="flat_discount"
                            value="<?php echo isset($sale->flat_discount) ? $sale->flat_discount : '0'; ?>"
                            <?php echo (!empty($sale->flat_discount) && $sale->flat_discount > 0) ? '' : 'readonly="readonly"'; ?>>
                    </div>

                    <div class="form-group col-lg-3">
                        <label>Net Price</label>
                        <input type="text" class="form-control" id="net_price" name="net_price"
                            value="<?php echo number_format($sale->net, 2); ?>" readonly="readonly">
                    </div>

                    <div class="form-group col-lg-3" style="padding-left: 0">
                        <label>Paid Amount</label>
                        <input type="hidden" value="<?php echo $sale->paid_amount ?>" id="original-paid-amount">
                        <input type="text" class="form-control" id="paid_amount"
                            value="<?php echo $sale->paid_amount ?>" name="paid_amount" readonly="readonly">
                    </div>
                    
                    <div class="form-group col-lg-3">
                        <label>Balance</label>
                        <input type="text" class="form-control" id="balance" 
                            value="<?php echo number_format($sale->total - $sale->paid_amount, 2); ?>" readonly="readonly">
                        <input type="hidden" name="balance" id="balance_hidden"
                            value="<?php echo $sale->total - $sale->paid_amount; ?>">
                    </div>

                    <?php if (($sale->total - $sale->paid_amount) > 0 and ($patient->panel_id < 1 or empty(trim($patient->panel_id)))) : ?>
                        <div class="form-actions">
                            <button type="submit" class="btn blue">Update</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .form-actions {
        float: left;
        width: 100%;
    }
</style>


<script>
    $(document).ready(function () {
        function updateNetPriceAndBalance() {
            let totalAmount = parseFloat($('#total_amount').val()); // Get original price
            let discount = parseFloat($('#discount').val()) || 0; // Get discount (%)
            let flatDiscount = parseFloat($('#flat_discount').val()) || 0; // Get flat discount
            let paidAmount = parseFloat($('#paid_amount').val()); // Get paid amount
            let balance_hidden = parseFloat($('#balance_hidden').val());

            // Calculate net price after discount
            let netPrice = totalAmount;
            if (discount > 0) {
                netPrice -= (totalAmount * (discount / 100)); // Apply percentage discount
            }
            if (flatDiscount > 0) {
                netPrice -= flatDiscount; // Apply flat discount
            }
            netPrice = Math.max(0, netPrice); // Ensure net price is not negative
            if(flatDiscount > balance_hidden ){
                alert("Flat discount cannot be greater than balance");
                window.location.reload();
            }

            // Update Net Price field
            $('#net_price').val(netPrice.toFixed(2));

            // Calculate new balance
            let balance = netPrice - paidAmount;
            balance = Math.max(0, balance); // Ensure balance is not negative

            // Update Balance field
            $('#balance').val(balance.toFixed(2));
            $('#balance_hidden').val(balance.toFixed(2)); // Update hidden balance input
        }

        // Listen for changes in the discount fields
        $('#discount, #flat_discount').on('input', function () {
            updateNetPriceAndBalance();
        });

    });
</script>
