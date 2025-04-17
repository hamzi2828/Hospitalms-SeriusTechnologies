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

        <!-- BEGIN BLOOD STATUS TABLE PORTLET -->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-tint"></i> Blood Inventory Status
                </div>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr style="background-color:#f2f2f2;">
                            <th>Sr. No.</th>
                            <th>Blood Type</th>
                            <th>Total Qty</th>
                            <th>Used Qty</th>
                            <th>Expired Qty</th>
                            <th>Available Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sr = 1;
                        foreach ($blood_status as $status):
                        ?>
                        <tr>
                            <td><?= $sr++; ?></td>
                            <td><?= htmlspecialchars($status['blood_type']); ?></td>
                            <td><?= $status['total_qty']; ?></td>
                            <td><?= $status['used_qty']; ?></td>
                            <td><?= $status['expired_qty']; ?></td>
                            <td><?= $status['available_qty']; ?></td>
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
