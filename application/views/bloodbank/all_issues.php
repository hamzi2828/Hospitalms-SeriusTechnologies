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
                    <i class="fa fa-globe"></i> All Issuance
                </div>
            </div>
           <div class="portlet-body" style="overflow: auto">
           <table class="table table-striped table-bordered table-hover" id="sample_1">
            <thead>
                <tr>
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

                <?php
                // Group by issuance_number
                $grouped = [];
                foreach ($blood_issuance as $issue) {
                    $grouped[$issue['issuance_number']][] = $issue;
                }
                $sr = 1;
                if (!empty($grouped)):
                    foreach ($grouped as $issuance_number => $issues):
                        $first = $issues[0];
                        // Gather all inventory reference numbers for this issuance_number
                        $inventory_refs = array_map(function($i) {
                            return get_blood_inventory_reference_number($i['inventory_id']);
                        }, $issues);
                        $inventory_refs_str = htmlspecialchars(implode(', ', $inventory_refs));
                ?>
                        <tr>
                            <td><?php echo $sr++; ?></td>
                            <td><?php echo htmlspecialchars($issuance_number); ?></td>
                            <td><?php echo htmlspecialchars($first['patient_id']); ?></td>
                            <td><?php echo get_patient_name($first['patient_id']); ?></td>
                            <td><?php echo htmlspecialchars($first['blood_type']); ?></td>
                            <td><?php echo $inventory_refs_str; ?></td>
                            <td><?php echo isset($first['issued_at']) ? htmlspecialchars($first['issued_at']) : htmlspecialchars($first['created_at']); ?></td>
                            <td>
                                <a type="button" class="btn btn-xs red" href="<?php echo base_url('blood-bank/delete-issue/').$first['id']; ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                            </td>
                        </tr>
                <?php
                    endforeach;
                else:
                ?>
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




