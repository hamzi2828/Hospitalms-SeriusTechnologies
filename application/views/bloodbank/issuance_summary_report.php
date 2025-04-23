<!-- BEGIN PAGE CONTENT -->
<div class="row">
    <div class="col-md-12">
        <?php if (validation_errors()) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('response')) : ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('response'); ?>
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
<!-- END PAGE CONTENT-->    

        </div>
        <!-- BEGIN BLOOD ISSUANCE TABLE PORTLET -->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-tint"></i>Summary Report
                </div>
                <a href="<?php echo base_url ( '/invoices/issuance-summary-report?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                   target="_blank"
                   class="pull-right print-btn">Print</a>

            </div>
            <div class="portlet-body" style="overflow: auto">
            <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Blood Type</th>
                            <th>Total Issued Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $blood_types = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
                        $sr = 1;
                        // Aggregate quantities by blood type
                        $type_totals = array_fill_keys($blood_types, 0);
                        if (!empty($blood_issuance)) {
                            foreach ($blood_issuance as $issue) {
                                $type = $issue['blood_type'];
                                $qty = isset($issue['quantity']) ? (int)$issue['quantity'] : 1;
                                if (isset($type_totals[$type])) {
                                    $type_totals[$type] += $qty;
                                }
                            }
                        }
                        foreach ($blood_types as $type):
                        ?>
                        <tr>
                            <td><?= $sr++; ?></td>
                            <td><?= htmlspecialchars($type); ?></td>
                            <td><?= $type_totals[$type]; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<style>
    .input-xsmall {
        width: 100px !important;
    }
</style>
