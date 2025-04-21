<?php
function get_xmatch_donor_name($report_id) {
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('patient_value');
    $ci->db->from('x_match_report_tests');
    $ci->db->where('report_id', $report_id);
    $ci->db->where('test_name', 'Donor Name:');
    $row = $ci->db->get()->row();
    return $row ? $row->patient_value : '';
}
?>
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
                    <i class="fa fa-globe"></i> All X-Match Reports
                </div>
            </div>
           <div class="portlet-body" style="overflow: auto">
           <table class="table table-striped table-bordered table-hover" id="sample_1">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Report ID</th>
                    <th>EMR No.</th>
                    <th>Name</th>
                    <th>Doner</th>
                    <th>Patient Blood Type</th>
                    <th>Date Added</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($x_match_reports)) { $i = 1; foreach ($x_match_reports as $report) { ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo htmlspecialchars($report['id']); ?></td>
                    <td><?php echo htmlspecialchars($report['patient_id']); ?></td>
                    <td><?php echo get_patient_name($report['patient_id']); ?></td>
                    <td><?php echo htmlspecialchars($report['donor_name']); ?></td>
                    <td><?php echo htmlspecialchars($report['blood_type']); ?></td>
                    <td><?php echo date('Y-m-d H:i', strtotime($report['created_at'])); ?></td>
                    <td>
                        <a href="<?php echo site_url('invoices/x-match-reports/' . $report['id']); ?>" class="btn btn-xs btn-info">View</a>
                    </td>
                </tr>
            <?php }} else { ?>
                <tr><td colspan="8" class="text-center">No reports found.</td></tr>
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





