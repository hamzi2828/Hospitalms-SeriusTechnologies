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
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> All Blood Inventory
                </div>
            </div>
           <div class="portlet-body" style="overflow: auto">
           <table class="table table-striped table-bordered table-hover" id="sample_1">
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Reference ID</th>
                    <th>Blood Type</th>
                    <th>Source</th>
                    <th>From / Donor Name</th>
                    <th>Contact</th>
                    <th>Expiry Date</th>
                    <th>Remarks</th>    
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($blood_inventory)) {
                    $count = 1;
                    foreach ($blood_inventory as $row) { ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo htmlspecialchars($row['reference_number']);  echo "<br>";
                                if ($this->BloodBankModel->is_inventory_id_issued($row['id'])) {
                                    echo ' <span class="label label-success">Issued</span>';
                                } ?></td>
                            <td><?php echo htmlspecialchars($row['blood_type']); ?></td>
                            <td><?php echo ucfirst($row['source']); ?></td>
                            
                            <!-- Show either Purchase From or Donor Name -->
                            <td>
                                <?php 
                                    echo $row['source'] == 'purchase' 
                                        ? htmlspecialchars($row['from']) 
                                        : htmlspecialchars($row['donor_name']);
                                ?>
                            </td>
                            
                            <!-- Contact for donor only -->
                            <td>
                                <?php echo $row['source'] == 'donor' ? htmlspecialchars($row['contact_no']) : '-'; ?>
                            </td>

                            <td>
                                <?php
                                    $expiry = strtotime($row['expiry_date']);
                                    $today = strtotime(date('Y-m-d'));
                                    echo date('d-M-Y', $expiry); echo "<br>";
                                    if ($expiry < $today) {
                                        echo ' <span class="label label-danger">Expired</span>';
                                    }
                                ?>
                            </td>

                            <!-- Show remarks for donor, or 'N/A' -->
                            <td> 
                                <?php echo $row['source'] == 'donor' ? htmlspecialchars($row['remarks']) : 'N/A'; ?>
                            </td>
                            <td>
                            <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit-blood-inventory', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                <a type="button" class="btn btn-xs blue" href="<?php echo base_url('blood-bank/edit-blood/').$row['id']; ?>">Edit</a>
                                <?php endif; ?>
                                <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete-blood-inventory', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                <a type="button" class="btn btn-xs red" href="<?php echo base_url('blood-bank/delete-blood/').$row['id']; ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                <?php }
                } else { ?>
                    <tr>
                        <td colspan="8" class="text-center">No records found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .input-xsmall {
        width: 100px !important;
    }
</style>




