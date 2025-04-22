
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

        <div class="search-form">
        <!-- BEGIN PAGE CONTENT-->
        <form method="get" action="">
     
                <div class="form-group col-lg-2" style="position: relative">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="<?php echo isset($start_date) ? htmlspecialchars($start_date) : ''; ?>">
                </div>
                <div class="form-group col-lg-2" style="position: relative">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="<?php echo isset($end_date) ? htmlspecialchars($end_date) : ''; ?>">
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Issuance Report
                </div>
                <a href="<?php echo base_url ( '/invoices/issuance-report?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                   target="_blank"
                   class="pull-right print-btn">Print</a>
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




