<h4 style="font-weight: 800 !important; color: #ff0000">
    Check whether the patient has been registered before?
</h4>

<div class="search-form" style="border: 1px solid #4b8df8; width: 100%; float: left; margin-bottom: 25px">
    <form role="form" method="get" autocomplete="off">
        <div class="form-group col-lg-3">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo @$_REQUEST['name']; ?>">
        </div>
        <div class="form-group col-lg-3">
            <label for="cnic">CNIC</label>
            <input type="text" name="cnic" class="form-control" value="<?php echo @$_REQUEST['cnic']; ?>">
        </div>
        <div class="form-group col-lg-3">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo @$_REQUEST['phone']; ?>">
        </div>
        <div class="form-group col-lg-2">
            <label for="emr">EMR</label>
            <input type="text" name="emr" class="form-control" value="<?php echo @$_REQUEST['emr']; ?>">
        </div>
        <div class="form-group col-lg-1" style="margin-top: 25px">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>

<?php if (!empty($patients) && count($patients) > 0) : ?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Sr. No</th>
                <th><?php echo $this->lang->line('PATIENT_EMR'); ?></th>
                <th>Name</th>
                <th>CNIC</th>
                <th>Phone</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Type</th>
                <th>Date Added</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $counter = 1;
            foreach ($patients as $patient) : ?>
                <tr class="odd gradeX">
                    <td><?php echo $counter++; ?></td>
                    <td><?php echo emr_prefix . $patient->id; ?></td>
                    <td><?php echo get_patient_name(0, $patient); ?></td>
                    <td><?php echo $patient->cnic; ?></td>
                    <td><?php echo $patient->mobile; ?></td>
                    <td><?php echo $patient->age; ?></td>
                    <td><?php echo ($patient->gender == '1') ? 'Male' : 'Female'; ?></td>
                    <td>
                        <?php
                            if ( $patient -> panel_id > 0 )
                                echo 'Panel / ' . get_panel_by_id ( $patient -> panel_id ) -> name;
                            else
                                echo '<span style="font-weight: bold; color: red;">Cash</span>';
                        ?>
                    </td>

                    <!-- <td><?php echo ucfirst($patient->type); ?></td> -->
                    <td><?php echo date_setter($patient->date_registered); ?></td>
                    <td>
                        <div style="display: flex; gap: 10px;">
                            <form method="get" action="<?php echo base_url('/consultancy/add'); ?>" style="margin: 0;">
                                <input type="hidden" name="patient_id" value="<?php echo $patient->id; ?>">
                                <button type="submit" class="btn btn-primary">Consultancy</button>
                            </form>

                            <form method="get" action="<?php echo base_url('/OPD/sale'); ?>" style="margin: 0;">
                                <input type="hidden" name="patient_id" value="<?php echo $patient->id; ?>">
                                <button type="submit" class="btn btn-success">OPD</button>
                            </form>

                            <form method="get" action="<?php echo base_url('/lab/sale'); ?>" style="margin: 0;">
                                <input type="hidden" name="patient_id" value="<?php echo $patient->id; ?>">
                                <button type="submit" class="btn btn-info">Lab</button>
                            </form>

                            <form method="get" action="<?php echo base_url('/IPD/sale'); ?>" style="margin: 0;">
                                <input type="hidden" name="patient_id" value="<?php echo $patient->id; ?>">
                                <button type="submit" class="btn btn-warning">IPD</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p style="color: red; font-weight: bold;">No patient records found.</p>
<?php endif; ?>
