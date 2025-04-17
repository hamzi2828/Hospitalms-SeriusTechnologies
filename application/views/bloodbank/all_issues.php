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
                <tr style="background-color:#f2f2f2;">
                    <th>Sr.</th>
                    <th>Issuance ID</th>
                    <th>EMR No.</th>
                    <th>Name</th>
                    <th>Blood Type</th>
                    <th>Reference ID</th>
                    <th>Date Added</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($blood_issuance)): ?>
                    <?php $sr = 1; foreach ($blood_issuance as $issue): ?>
                        <tr>
                            <td><?php echo $sr++; ?></td>
                            <td><?php echo 'ISS-' . str_pad($issue['id'], 6, '0', STR_PAD_LEFT); ?></td>
                            <td><?php echo htmlspecialchars($issue['patient_id']); ?></td>
                            <td><!-- Name: Not available --></td>
                            <td><?php echo htmlspecialchars($issue['blood_type']); ?></td>
                            <td><?php echo htmlspecialchars($issue['inventory_id']); ?></td>
                            <td><?php echo isset($issue['issued_at']) ? htmlspecialchars($issue['issued_at']) : htmlspecialchars($issue['created_at']); ?></td>
                            <td>
                                <a type="button" class="btn btn-xs blue" href="<?php echo base_url('blood-bank/edit-issue/').$issue['id']; ?>">Edit</a>
                                
                                <a type="button" class="btn btn-xs red" href="<?php echo base_url('blood-bank/delete-issue/').$issue['id']; ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8">No blood issuance records found.</td></tr>
                <?php endif; ?>
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




