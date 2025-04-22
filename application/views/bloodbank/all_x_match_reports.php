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
                    <td><?php echo htmlspecialchars(get_xmatch_patient_blood_group($report['id'])); ?></td>
                    <td><?php echo date('Y-m-d H:i', strtotime($report['created_at'])); ?></td>
                    
                    <td class="btn-group-xs">

                    <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'cafe_all_product_stock', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                    <a type="button" class="btn purple" target="_blank"
                    href="<?php echo site_url('invoices/x-match-reports/' . $report['id']); ?>">Print</a>

                    <?php endif; ?>


                    <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'cafe_all_product_edit', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                    <a type="button" class="btn blue"
                    href="<?php echo base_url ( 'blood-bank/edit-x-match-report/' . $report['id'] ) ?>">Edit</a>
                    <?php endif; ?>



                    <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'cafe_all_product_delete', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                    <a type="button" class="btn red"
                               href="<?php echo base_url('blood-bank/delete-x-match-report/' . $report['id']) ?>"
                                onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                    <?php endif; ?>
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





