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
                <div class="caption"><i class="fa fa-edit"></i> Edit Blood Inventory</div>
            </div>
            <div class="portlet-body form">
                <form action="<?php echo base_url('blood-bank/update-blood/'.$blood['id']); ?>" method="post" class="form-horizontal">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                <input type="hidden" name="id" value="<?php echo $blood['id']; ?>" />
                    <div class="form-body">
                        <!-- Blood Source Selector -->
                        <div class="form-group">
                            <label class="control-label col-md-3">Add Blood From</label>
                            <div class="col-md-6">
                                <select name="source" class="form-control" id="bloodSource" onchange="toggleBloodSource()" required>
                                    <option value="">-- Select --</option>
                                    <option value="purchase" <?php echo ($blood['source'] == 'purchase') ? 'selected' : ''; ?>>Purchase</option>
                                    <option value="donor" <?php echo ($blood['source'] == 'donor') ? 'selected' : ''; ?>>Donor</option>
                                </select>
                            </div>
                        </div>

                        <!-- Purchase Section -->
                        <div id="purchaseFields" style="display: <?php echo ($blood['source'] == 'purchase') ? 'block' : 'none'; ?>">
                            <div class="form-group">
                                <label class="control-label col-md-3">From</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="from" value="<?php echo $blood['from']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Purchase Price</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="purchase_price" value="<?php echo $blood['purchase_price']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Blood Type</label>
                                <div class="col-md-6">
                                    <select name="blood_type" class="form-control select2" required>
                                        <option value=""></option>
                                        <option value="A+" <?php echo ($blood['blood_type'] == 'A+') ? 'selected' : ''; ?>>A+</option>
                                        <option value="A-" <?php echo ($blood['blood_type'] == 'A-') ? 'selected' : ''; ?>>A-</option>
                                        <option value="B+" <?php echo ($blood['blood_type'] == 'B+') ? 'selected' : ''; ?>>B+</option>
                                        <option value="B-" <?php echo ($blood['blood_type'] == 'B-') ? 'selected' : ''; ?>>B-</option>
                                        <option value="O+" <?php echo ($blood['blood_type'] == 'O+') ? 'selected' : ''; ?>>O+</option>
                                        <option value="O-" <?php echo ($blood['blood_type'] == 'O-') ? 'selected' : ''; ?>>O-</option>
                                        <option value="AB+" <?php echo ($blood['blood_type'] == 'AB+') ? 'selected' : ''; ?>>AB+</option>
                                        <option value="AB-" <?php echo ($blood['blood_type'] == 'AB-') ? 'selected' : ''; ?>>AB-</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Expiry Date</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control date-picker" name="expiry_date" placeholder="Expiry Date" value="<?php echo $blood['expiry_date']; ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Donor Section -->
                        <div id="donorFields" style="display: <?php echo ($blood['source'] == 'donor') ? 'block' : 'none'; ?>">
                            <div class="form-group">
                                <label class="control-label col-md-3">Donor Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="donor_name" value="<?php echo $blood['donor_name']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Age</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="donor_age" value="<?php echo $blood['donor_age']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Gender</label>
                                <div class="col-md-6">
                                    <select name="donor_gender" class="form-control">
                                        <option value="male" <?php echo ($blood['donor_gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                                        <option value="female" <?php echo ($blood['donor_gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Contact No.</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="contact_no" value="<?php echo $blood['contact_no']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Blood Type</label>
                                <div class="col-md-6">
                                    <select name="donor_blood_type" class="form-control select2" required>
                                        <option value="">   </option>
                                        <option value="A+" <?php echo ($blood['blood_type'] == 'A+') ? 'selected' : ''; ?>>A+</option>
                                        <option value="A-" <?php echo ($blood['blood_type'] == 'A-') ? 'selected' : ''; ?>>A-</option>
                                        <option value="B+" <?php echo ($blood['blood_type'] == 'B+') ? 'selected' : ''; ?>>B+</option>
                                        <option value="B-" <?php echo ($blood['blood_type'] == 'B-') ? 'selected' : ''; ?>>B-</option>
                                        <option value="O+" <?php echo ($blood['blood_type'] == 'O+') ? 'selected' : ''; ?>>O+</option>
                                        <option value="O-" <?php echo ($blood['blood_type'] == 'O-') ? 'selected' : ''; ?>>O-</option>
                                        <option value="AB+" <?php echo ($blood['blood_type'] == 'AB+') ? 'selected' : ''; ?>>AB+</option>
                                        <option value="AB-" <?php echo ($blood['blood_type'] == 'AB-') ? 'selected' : ''; ?>>AB-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Expiry Date</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control date-picker" name="donor_expiry" placeholder="Expiry Date" value="<?php echo $blood['expiry_date']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Remarks</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="remarks"><?php echo $blood['remarks']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Charity</label>
                                <div class="col-md-6">
                                    <select name="charity" class="form-control">
                                        <option value="no" <?php echo ($blood['charity'] == 'no') ? 'selected' : ''; ?>>No</option>
                                        <option value="yes" <?php echo ($blood['charity'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Submit -->
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-6">
                                <button type="submit" class="btn blue">Update</button>
                                <a href="<?php echo base_url('blood-bank/all-blood-inventory'); ?>" class="btn default">Cancel</a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleBloodSource() {
        var value = document.getElementById('bloodSource').value;
        document.getElementById('purchaseFields').style.display = value === 'purchase' ? 'block' : 'none';
        document.getElementById('donorFields').style.display = value === 'donor' ? 'block' : 'none';
    }
    // Initialize the form based on the source
    document.addEventListener('DOMContentLoaded', function() {
        // Form is already initialized by PHP display settings
        // Initialize Select2 for all select2 fields
        if (window.jQuery && $.fn.select2) {
            $('.select2').select2();
        }
        // Initialize date-picker if needed (assuming bootstrap-datepicker or similar)
        if (window.jQuery && $.fn.datepicker) {
            $('.date-picker').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd', // Change format as needed
                todayHighlight: true
            });
        }
    });
</script>
