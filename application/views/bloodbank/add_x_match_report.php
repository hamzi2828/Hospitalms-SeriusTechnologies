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
                <div class="caption"><i class="fa fa-reorder"></i> Add X Match Report</div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" action="<?php echo site_url('blood-bank/store-x-match-report'); ?>" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                           value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_token">

                    <div class="form-body">
                        <hr style="margin-top: 0"/>

                        <!-- EMR and Name -->
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label>EMR No</label>
                                <input type="text" name="patient_id" class="form-control"
                                       placeholder="Enter EMR No"
                                       value="<?php echo isset($patient_id) ? $patient_id : set_value('patient_id'); ?>"
                                       required id="patient_id" onchange="get_consultancy_patient(this.value)">
                            </div>

                            <div class="form-group col-lg-4">
                                <label>Patient Name</label>
                                <input type="text" class="form-control" id="patient-name" readonly>
                            </div>
                        </div>

                        <!-- Static Table for Tests -->
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
                                    $tests = [
                                        "Donor Name",
                                        "Donor Blood Group",
                                        "Donor Rh Factor",
                                        "Anti HCV by ELISA",
                                        "HBsAg by ELISA",
                                        "Anti HIV - 1 & 2 Antibodies",
                                        "Malaria Parasite (MP)",
                                        "Syphilis Antibodies",
                                        "Coombs Test (Direct)",
                                        "Coombs Test (Indirect)",
                                        "Compatibility"
                                    ];
                                    foreach ($tests as $index => $test) {
                                        echo '<tr>';
                                        echo '<td><input type="text" name="tests['.$index.'][name]" value="'.$test.'" class="form-control" readonly></td>';
                                        echo '<td><input type="text" name="tests['.$index.'][cut_off]" class="form-control" required></td>';
                                        echo '<td><input type="text" name="tests['.$index.'][patient_value]" class="form-control" required></td>';
                                        echo '<td><input type="text" name="tests['.$index.'][result]" class="form-control" required></td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
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
