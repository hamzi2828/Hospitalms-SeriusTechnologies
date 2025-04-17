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
                        $blood_types = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
                        $today = date('Y-m-d');
                        $sr = 1;
                        foreach ($blood_types as $type):
                            $total_qty = $used_qty = $expired_qty = $available_qty = 0;
                            foreach ($blood_inventory as $item) {
                                if ($item['blood_type'] == $type) {
                                    $total_qty++;
                                    if ($item['expiry_date'] < $today) $expired_qty++;
                                    if (!empty($item['is_issued']) && $item['is_issued']) $used_qty++;
                                    if ($item['expiry_date'] >= $today && (empty($item['is_issued']) || !$item['is_issued'])) $available_qty++;
                                }
                            }
                            if ($total_qty == 0) continue;
                        ?>
                        <tr>
                            <td><?= $sr++; ?></td>
                            <td><?= htmlspecialchars($type); ?></td>
                            <td><?= $total_qty; ?></td>
                            <td><?= $used_qty; ?></td>
                            <td><?= $expired_qty; ?></td>
                            <td><?= $available_qty; ?></td>
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
