<?php $access = get_user_access(get_logged_in_user_id()); ?>
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

        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-reorder"></i> Issue Blood</div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" action="<?php echo site_url('blood-bank/store-issue-blood'); ?>" autocomplete="off">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_token">

                    <div class="form-body">
                        <hr style="margin-top: 0"/>

                        <div class="row">
                            <!-- Patient EMR No -->
                            <div class="form-group col-lg-4">
                            <label>EMR. No</label>
                                <label><?php echo $this->lang->line('PATIENT_EMR'); ?></label>
                                <input type="text" name="patient_id" class="form-control"
                                       placeholder="Enter EMR No"
                                       value="<?php echo isset($patient_id) ? $patient_id : set_value('patient_id'); ?>"
                                       required id="patient_id" onchange="get_consultancy_patient(this.value)">
                            </div>

                            <!-- Patient Name -->
                            <div class="form-group col-lg-4">
                                <label>Name</label>
                                <input type="text" class="form-control" id="patient-name" readonly>
                            </div>

                        </div>

                        
                        <div class="row">
                         
                            <!-- Blood Type Dropdown -->
                            <div class="form-group col-lg-4">
                                <label>Blood Type</label>
                                <select name="blood_type" id="blood_type" class="form-control" required>
                                    <option value="">Select Blood Type</option>
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

                            <!-- Inventory Selection (Dynamic) -->
                            <div class="form-group col-lg-4" id="inventory_group" style="display:none;">
                                <label>Select Matching Inventory</label>
                                <select name="inventory_id[]" id="inventory_id" class="form-control select2me" multiple required>
                                    <!-- Populated via JS -->
                                </select>
                            </div>
                        </div>

                    </div>

                    <!-- Submit -->
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Blood Inventory JS Logic -->
<script>
    const bloodInventory = <?php echo json_encode($blood_inventory); ?>;

    document.getElementById('blood_type').addEventListener('change', function () {
        const selectedType = this.value;
        const inventorySelect = document.getElementById('inventory_id');
        const inventoryGroup = document.getElementById('inventory_group');

        inventorySelect.innerHTML = '';

        const filtered = bloodInventory.filter(item => item.blood_type === selectedType);

        if (filtered.length > 0) {
            inventoryGroup.style.display = 'block';

            const defaultOpt = document.createElement('option');
            defaultOpt.value = '';
            defaultOpt.textContent = 'Select Inventory Record';
            inventorySelect.appendChild(defaultOpt);

            filtered.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = `${item.reference_number}`;
                inventorySelect.appendChild(option);
            });

        } else {
            inventoryGroup.style.display = 'none';
        }
    });

    // Auto-fetch patient name if EMR is already set
    document.addEventListener('DOMContentLoaded', function () {
        const patientId = document.getElementById('patient_id').value;
        if (patientId) {
            get_consultancy_patient(patientId);
        }
    });

    function get_consultancy_patient(patientId) {
        // Replace this with your AJAX logic to fetch patient details
        // Here's a placeholder example
        document.getElementById('patient-name').value = 'Fetched Patient Name';
    }
</script>
