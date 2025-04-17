<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if (validation_errors()) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('response')) { ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('response'); ?>
            </div>
        <?php } ?>

        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-plus"></i> Add Blood Inventory</div>
            </div>
            <div class="portlet-body form">
                <form action="<?php echo base_url('blood-bank/store-blood'); ?>" method="post" class="form-horizontal">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                    <div class="form-body">
                        <!-- Blood Source Selector -->
                        <div class="form-group">
                            <label class="control-label col-md-3">Add Blood From</label>
                            <div class="col-md-6">
                                <select name="source" class="form-control" id="bloodSource" onchange="toggleBloodSource()" required>
                                    <option value="">-- Select --</option>
                                    <option value="purchase">Purchase</option>
                                    <option value="donor">Donor</option>
                                </select>
                            </div>
                        </div>

                        <!-- Purchase Section -->
                        <div id="purchaseFields" style="display: none;">
                            <div class="form-group">
                                <label class="control-label col-md-3">From</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="from" required data-required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Purchase Price</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="purchase_price" required data-required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Blood Type</label>
                                <div class="col-md-6">
                                    <select name="blood_type" class="form-control select2" required data-required>
                                        <option value=""></option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Expiry Date</label>
                                <div class="col-md-6">
                                    
                                    <input type="text" name="expiry_date" class="form-control date-picker" placeholder="Expiry Date" required data-required>
                                </div>
                            </div>
                        </div>

                        <!-- Donor Section -->
                        <div id="donorFields" style="display: none;">
                            <div class="form-group">
                                <label class="control-label col-md-3">Donor Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="donor_name" required data-required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Age</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="donor_age" required data-required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Gender</label>
                                <div class="col-md-6">
                                    <select name="donor_gender" class="form-control" required data-required>
                                        <option value="">-- Select --</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Contact No.</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="contact_no" required data-required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Blood Type</label>
                                <div class="col-md-6">
                                    <select name="donor_blood_type" class="form-control select2" required data-required>
                                        <option value=""></option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Expiry Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="donor_expiry" class="form-control date-picker" placeholder="Expiry Date" required data-required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Remarks</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="remarks"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Charity</label>
                                <div class="col-md-6">
                                    <select name="charity" class="form-control" required data-required>
                                        <option value="">-- Select --</option>
                                        <option value="no">No</option>
                                        <option value="yes">Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-6">
                                <button type="submit" class="btn blue">Submit</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script to toggle fields -->
<script>
    function toggleBloodSource() {
        var value = document.getElementById('bloodSource').value;
        var purchaseFields = document.getElementById('purchaseFields');
        var donorFields = document.getElementById('donorFields');

        // Show/hide sections
        purchaseFields.style.display = value === 'purchase' ? 'block' : 'none';
        donorFields.style.display = value === 'donor' ? 'block' : 'none';

        // Toggle required attributes for purchase fields
        purchaseFields.querySelectorAll('[data-required]')?.forEach(function(input) {
            if (value === 'purchase') {
                input.setAttribute('required', 'required');
            } else {
                input.removeAttribute('required');
            }
        });
        // Toggle required attributes for donor fields
        donorFields.querySelectorAll('[data-required]')?.forEach(function(input) {
            if (value === 'donor') {
                input.setAttribute('required', 'required');
            } else {
                input.removeAttribute('required');
            }
        });
    }
    document.addEventListener("DOMContentLoaded", function () {
        toggleBloodSource();
    });

    // Call this on page load in case validation fails and the form reloads
    document.addEventListener("DOMContentLoaded", function () {
        toggleBloodSource();
    });



    $(document).ready(function() {
    // Initialize Select2 for all select2 fields
    if ($.fn.select2) {
        $('.select2').select2();
    }
    // Initialize date-picker if needed (assuming bootstrap-datepicker or similar)
    if ($.fn.datepicker) {
        $('.date-picker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd', // Change format as needed
            todayHighlight: true
        });
    }
});
</script>
