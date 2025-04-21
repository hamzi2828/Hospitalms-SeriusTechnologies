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
                <div class="caption"><i class="fa fa-reorder"></i> Edit X Match Report</div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" action="<?php echo site_url('blood-bank/update-x-match-report/' . $report['id']); ?>" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                           value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_token">

                    <div class="form-body">
                        <hr style="margin-top: 0"/>

                        <!-- EMR and Name -->
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label>EMR No</label>
                                <input type="text" name="patient_id" class="form-control"
                                       placeholder="Enter EMR No"
                                       value="<?php echo htmlspecialchars($report['patient_id']); ?>"
                                       required id="patient_id" onchange="get_consultancy_patient(this.value)">
                            </div>

                            <div class="form-group col-lg-3">
                                <label>Patient Name</label>
                                <input type="text" class="form-control" id="patient-name" value="<?php echo get_patient_name($report['patient_id']); ?>" readonly>
                            </div>
                            

                            <div class="form-group col-lg-3">
                                <label><strong>Collection Date & Time</strong></label>
                                <input type="datetime-local" 
                                       name="report-collection-date-time" 
                                       class="form-control"
                                       value="<?php echo isset($report['collection_date_time']) ? date('Y-m-d\TH:i', strtotime($report['collection_date_time'])) : ''; ?>"
                                       placeholder="dd/mm/yyyy --:--">
                            </div>

                            <div class="form-group col-lg-3">
                                <label>Donor Name</label>
                                <input type="text" class="form-control"  name="donor_name"  id="donor-name" value="<?php echo htmlspecialchars($report['donor_name']); ?>">
                            </div>
                        </div>

                        <!-- Tests Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary text-white">
                                        <th>Test</th>
                                        <th>Cut Off Value</th>
                                        <th>Patient Value</th>
                                        <th>Results</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                            // Map test names to existing values for easy lookup
                            $test_map = [];
                            if (!empty($report_tests)) {
                                foreach ($report_tests as $test_row) {
                                    $test_map[$test_row['test_name']] = $test_row;
                                }
                            }
                            $tests = [
                                "<h4>DONOR</h4>",
                                "Donor Blood Group",
                                "Donor Rh Factor",
                                "Anti HCV by ELISA",
                                "HBsAg by ELISA",
                                "Anti HIV - 1 & 2 Antibodies",
                                "Malaria Parasite (MP)",
                                "Syphilis Antibodies",
                                "Recipient Name:",
                                "<h4>PATIENT</h4>",
                                "Patient Blood Group",
                                "Patient Rh Factor",
                                "Coombs Test (Direct)",
                                "Coombs Test (Indirect)",
                                "Compatibility"
                            ];
                            foreach ($tests as $index => $test) {
                                if ($test === '<h4>DONOR</h4>' || $test === '<h4>PATIENT</h4>') {
                                    echo '<tr><td colspan="4">'.$test.'</td></tr>';
                                } else {
                                    $cut_off = isset($test_map[$test]['cut_off_value']) ? htmlspecialchars($test_map[$test]['cut_off_value']) : '';
                                    $patient_value = isset($test_map[$test]['patient_value']) ? htmlspecialchars($test_map[$test]['patient_value']) : '';
                                    $result = isset($test_map[$test]['result']) ? htmlspecialchars($test_map[$test]['result']) : '';
                                    echo '<tr>';
                                    // Add hidden id input for test row
                                    echo '<input type="hidden" name="tests['.$index.'][id]" value="'.(isset($test_map[$test]['id']) ? $test_map[$test]['id'] : '').'">';
                                    echo '<td><input type="text" name="tests['.$index.'][name]" value="'.$test.'" class="form-control" readonly></td>';
                                    echo '<td><input type="text" name="tests['.$index.'][cut_off]" class="form-control" value="'.$cut_off.'"></td>';
                                    echo '<td><input type="text" name="tests['.$index.'][patient_value]" class="form-control" value="'.$patient_value.'"></td>';
                                    if ($test === 'Donor Blood Group' || $test === 'Patient Blood Group') {
                                        echo '<td><select name="tests['.$index.'][result]" class="form-control select2me" required>';
                                        echo '<option value=""></option>';
                                        $blood_groups = ["A+","A-","B+","B-","O+","O-","AB+","AB-"];
                                        foreach ($blood_groups as $bg) {
                                            $selected = ($result === $bg) ? 'selected' : '';
                                            echo '<option value="'.$bg.'" '.$selected.'>'.$bg.'</option>';
                                        }
                                        echo '</select></td>';
                                    } else {
                                        echo '<td><input type="text" name="tests['.$index.'][result]" class="form-control" value="'.$result.'"></td>';
                                    }
                                    echo '</tr>';
                                }
                            }
                            ?>
                            </tbody>
                            </table>
                        </div>
                        
                        <div class="form-group">
                        <label>Remarks</label>
                        <textarea name="remarks" class="form-control" rows="3"><?php echo isset($report['remarks']) ? htmlspecialchars($report['remarks']) : ''; ?></textarea>
                    </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Placeholder for patient fetch JS -->
<script>
    function get_consultancy_patient(patientId) {
        document.getElementById('patient-name').value = 'Fetched Patient Name'; // Replace with AJAX
    }
</script>