<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BloodBank extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('BloodBankModel');
        $this->load->library('session');
    }

    /** 
     * -------------------------
     * Header template
     * -------------------------
     */
    public function header($title) {
        $data['title'] = $title;
        $this->load->view('/includes/admin/header', $data);
    }

    /**
     * -------------------------
     * Sidebar template
     * -------------------------
     */
    public function sidebar() {
        $this->load->view('/includes/admin/general-sidebar');
    }

    /**
     * -------------------------
     * Footer template
     * -------------------------
     */
    public function footer() {
        $this->load->view('/includes/admin/footer');
    }

    /**
     * -------------------------
     * All Products page
     * -------------------------
     */
    public function all_blood_inventory() {
        $title = site_name . ' - All Blood Inventory';
        $this->header($title);
        $this->sidebar();
        $data['blood_inventory'] = $this->BloodBankModel->get_all_blood_inventory();
        $this->load->view('bloodbank/all_bloodBank_inventory', $data);
        $this->footer();
    }

    public function add_blood() {
        $title = site_name . ' - Add Blood';
        $this->header($title);
        $this->sidebar();
        $this->load->view('bloodbank/add_blood');
        $this->footer();
    }

    public function store_blood()
    {
        $source = $this->input->post('source', true);
    
        if (!$source) {
            $this->session->set_flashdata('error', 'Please select a blood source (Purchase or Donor).');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }
    
        $this->load->model('BloodBankModel');
        $today = date('Y-m-d');
    
        // Get and normalize expiry dates
        $expiry_date = $this->input->post('expiry_date', true);
        $donor_expiry = $this->input->post('donor_expiry', true);
    
        // Normalize expiry_date
        if ($expiry_date) {
            // Try both possible formats
            $dateObj = DateTime::createFromFormat('Y-m-d', $expiry_date);
            if (!$dateObj) {
                $dateObj = DateTime::createFromFormat('m/d/Y', $expiry_date);
            }
            $expiry_date = $dateObj ? $dateObj->format('Y-m-d') : null;
        }
    
        // Normalize donor_expiry
        if ($donor_expiry) {
            $dateObj = DateTime::createFromFormat('Y-m-d', $donor_expiry);
            if (!$dateObj) {
                $dateObj = DateTime::createFromFormat('m/d/Y', $donor_expiry);
            }
            $donor_expiry = $dateObj ? $dateObj->format('Y-m-d') : null;
        }
    
        // Validate expiry dates
        if ($expiry_date && $expiry_date < $today) {
            $this->session->set_flashdata('error', 'Expiry date should be today or a future date.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }
        if ($donor_expiry && $donor_expiry < $today) {
            $this->session->set_flashdata('error', 'Expiry date should be today or a future date.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }
    
        if ($source === 'purchase') {
            $data = [
                'source'            => 'purchase',
                'reference_number'  => $this->BloodBankModel->get_reference_number(),
                'from'              => $this->input->post('from', true),
                'purchase_price'    => $this->input->post('purchase_price', true),
                'blood_type'        => $this->input->post('blood_type', true),
                'expiry_date'       => $expiry_date,
                'created_at'        => date('Y-m-d H:i:s'),
            ];
        } elseif ($source === 'donor') {
            $data = [
                'source'            => 'donor',
                'reference_number'  => $this->BloodBankModel->get_reference_number(),
                'donor_name'        => $this->input->post('donor_name', true),
                'donor_age'         => $this->input->post('donor_age', true),
                'donor_gender'      => $this->input->post('donor_gender', true),
                'contact_no'        => $this->input->post('contact_no', true),
                'blood_type'        => $this->input->post('donor_blood_type', true),
                'expiry_date'       => $donor_expiry,
                'remarks'           => $this->input->post('remarks', true),
                'charity'           => $this->input->post('charity', true),
                'created_at'        => date('Y-m-d H:i:s'),
            ];
        } else {
            $this->session->set_flashdata('error', 'Invalid blood source selected.');
            redirect('BloodBank/add_blood');
        }
    
        // Insert into DB
        $saved = $this->BloodBankModel->insert_blood($data);
    
        if ($saved) {
            $this->session->set_flashdata('response', 'Blood entry saved successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to save blood entry.');
        }
    
        redirect('BloodBank/add_blood');
    }
    
    public function edit_blood($id)
    {
        $data['blood'] = $this->BloodBankModel->get_by_id($id);
    
        $title = site_name . ' - Edit Blood';
        $this->header($title);
        $this->sidebar();

        $this->load->view('bloodbank/edit_blood', $data);
        $this->footer();
    }
    
    public function update_blood($id)
    {
        // Debug: Check the ID value
        if (!$id) {
            $this->session->set_flashdata('error', 'No ID provided for update.');
            redirect('blood-bank/all-blood-inventory');
            return;
        }

        $source = $this->input->post('source', true);
    
        if (!$source) {
            $this->session->set_flashdata('error', 'Please select blood source.');
            redirect('blood-bank/edit-blood/' . $id);
        }
    
        print_r($this->input->post());
        exit;
        
        if ($source === 'purchase') {
            $data = [
                'source'         => 'purchase',
                'from'           => $this->input->post('from', true),
                'purchase_price' => $this->input->post('purchase_price', true),
                'blood_type'     => $this->input->post('blood_type', true),
                'expiry_date'    => $this->input->post('expiry_date', true),
                'updated_at'     => date('Y-m-d H:i:s')
            ];
        } elseif ($source === 'donor') {
            $data = [
                'source'         => 'donor',
                'donor_name'     => $this->input->post('donor_name', true),
                'donor_age'      => $this->input->post('donor_age', true),
                'donor_gender'   => $this->input->post('donor_gender', true),
                'contact_no'     => $this->input->post('contact_no', true),
                'blood_type'     => $this->input->post('donor_blood_type', true),
                'expiry_date'    => $this->input->post('donor_expiry', true),
                'remarks'        => $this->input->post('remarks', true),
                'charity'        => $this->input->post('charity', true),
                'updated_at'     => date('Y-m-d H:i:s')
            ];
        }
    
        $where = ['id' => $id];
        $result = $this->BloodBankModel->update_blood($where, $data);
        
        if ($result) {
            $this->session->set_flashdata('response', 'Blood inventory updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update blood inventory. Database error.');
        }
        
        redirect('blood-bank/all-blood-inventory');
    }
    

    public function delete_blood($id) {
        $this->BloodBankModel->delete($id);
        $this->session->set_flashdata('response', 'Blood entry deleted successfully.');
        redirect('BloodBank/all_blood_inventory');
    }

    public function all_issues() {
        $title = site_name . ' - All Issues';

        $this->header($title);
        $this->sidebar();
        $data['blood_issuance'] = $this->BloodBankModel->get_all_blood_issuance();
                
        $this->load->view('bloodbank/all_issues',$data);
        $this->footer();
    }

    public function issue_blood() {
        $title = site_name . ' - Issue Blood';
        $this->header($title);
        $this->sidebar();
        $this->load->model('BloodBankModel');
        $data['blood_inventory'] = $this->BloodBankModel->get_avilable_blood_inventory();
        $this->load->view('bloodbank/issue_blood', $data);
        $this->footer();
    }
    
    public function store_issue_blood() {
        $patient_id = $this->input->post('patient_id', true);
        $blood_type = $this->input->post('blood_type', true);
        $inventory_ids = $this->input->post('inventory_id', true); // This will be an array if multi-select

        $issuance_number = $this->BloodBankModel->get_issuance_number();

        
        if (!empty($inventory_ids) && is_array($inventory_ids)) {
            foreach ($inventory_ids as $inventory_id) {
                $data = [
                    'patient_id' => $patient_id,
                    'blood_type' => $blood_type,
                    'inventory_id' => $inventory_id,
                    'issued_by' => get_logged_in_user_id(),
                    'issuance_number' => $issuance_number,
                    // 'issued_at' and 'created_at' handled by DB defaults
                ];
                $this->BloodBankModel->insert_blood_issuance($data);
            }
        }

        $this->session->set_flashdata('response', 'Blood issued successfully.');
        redirect('blood-bank/all-issues');
    }


    
    public function blood_status() {
        $title = site_name . ' - Blood Status';
        $this->header($title);
        $this->sidebar();
        $this->load->model('BloodBankModel');
        $blood_inventory = $this->BloodBankModel->get_all_blood_inventory();
        $blood_issuance = $this->BloodBankModel->get_all_blood_issuance();
        $blood_types = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
        $today = date('Y-m-d');
        $blood_status = [];
        foreach ($blood_types as $type) {
            $total_qty = $used_qty = $expired_qty = $available_qty = 0;
            // Collect all inventory IDs for this type
            $inventory_ids = [];
            foreach ($blood_inventory as $item) {
                if ($item['blood_type'] == $type) {
                    $total_qty++;
                    $inventory_ids[] = $item['id'];
                    if ($item['expiry_date'] < $today) $expired_qty++;
                    if ($item['expiry_date'] >= $today) $available_qty++; // We'll subtract used below
                }
            }
            // Count used_qty from issuance table
            foreach ($blood_issuance as $issue) {
                if (in_array($issue['inventory_id'], $inventory_ids)) {
                    $used_qty++;
                    $available_qty--; // Decrement available if issued
                }
            }
            // Prevent negative available_qty
            if ($available_qty < 0) $available_qty = 0;
            $blood_status[] = [
                'blood_type' => $type,
                'total_qty' => $total_qty,
                'used_qty' => $used_qty,
                'expired_qty' => $expired_qty,
                'available_qty' => $available_qty
            ];
        }
        $data['blood_status'] = $blood_status;
        $this->load->view('bloodbank/blood_status', $data);
        $this->footer();
    }

    public function all_x_match_reports(){
        $title = site_name . ' - All X-Match Reports';
        $this->header($title);
        $this->sidebar();
        $this->load->model('BloodBankModel');
        $data['x_match_reports'] = $this->BloodBankModel->get_all_x_match_reports();
        $this->load->view('bloodbank/all_x_match_reports', $data);
        $this->footer();
    }


    public function add_x_match_report(){
        $title = site_name . ' - Add X-Match Report';
        $this->header($title);
        $this->sidebar();
        $this->load->model('BloodBankModel');

        $this->load->view('bloodbank/add_x_match_report');
        $this->footer();
    }

    public function store_x_match_report()
    {
        $this->load->model('BloodBankModel');
        $this->load->helper(['url', 'general_2']);

        $patient_id = $this->input->post('patient_id');
        $tests = $this->input->post('tests');
        $report_collection_date_time = $this->input->post('report-collection-date-time');
        $donor_name = $this->input->post('donor_name');
        $remarks = $this->input->post('remarks');


        // Fetch actual patient name using helper
        $patient_name = get_patient_name($patient_id);

        // Optionally extract blood type from tests if available
        $blood_type = '';
        foreach ($tests as $test) {
            if (
                isset($test['name']) &&
                (stripos($test['name'], 'Blood Group') !== false || stripos($test['name'], 'Blood Type') !== false)
                && !empty($test['patient_value'])
            ) {
                $blood_type = $test['patient_value'];
                break;
            }
        }

        // Insert into x_match_reports table via model
        $report_data = array(
            'patient_id'   => $patient_id,
            'blood_type'   => $blood_type,
            'report_collection_date_time' => $report_collection_date_time,
            'donor_name'   => $donor_name,
            'remarks'      => $remarks,
            'created_at'   => date('Y-m-d H:i:s'),
        );

        $report_id = $this->BloodBankModel->insert_x_match_report($report_data);

        // Insert each test into x_match_report_tests table via model
        foreach ($tests as $test) {
            $test_data = array(
                'report_id'      => $report_id,
                'test_name'      => $test['name'],
                'cut_off_value'  => $test['cut_off'],
                'patient_value'  => $test['patient_value'],
                'result'         => $test['result']
            );
            $this->BloodBankModel->insert_x_match_report_test($test_data);
        }

        // Set flash message and redirect
        $this->session->set_flashdata('response', 'X Match Report saved successfully!');
        redirect('blood-bank/add-x-match-report');
    }

    public function delete_x_match_report($id) {
        $this->BloodBankModel->delete_x_match_report($id);
        $this->session->set_flashdata('response', 'X Match Report deleted successfully.');
        redirect('blood-bank/all-x-match-reports');
    }

    public function edit_x_match_report($id) {
        $this->load->model('BloodBankModel');
        $title = site_name . ' - Edit X-Match Report';
        $this->header($title);
        $this->sidebar();
        $data['report'] = $this->BloodBankModel->get_x_match_report($id);
        $data['report_tests'] = $this->BloodBankModel->get_x_match_report_tests($id);
        $this->load->view('bloodbank/edit_x_match_report', $data);
        $this->footer();
    }

    
    public function update_x_match_report($id) {
        $this->load->model('BloodBankModel');
    
        $tests = $this->input->post('tests');
    

        // Optionally extract blood type from tests if available (like in store)
        $blood_type = '';
        foreach ($tests as $test) {
            if (
                isset($test['name']) &&
                (stripos($test['name'], 'Blood Group') !== false || stripos($test['name'], 'Blood Type') !== false)
                && !empty($test['patient_value'])
            ) {
                $blood_type = $test['patient_value'];
                break;
            }
        }
    
        $report_data = array(
            'patient_id'   => $this->input->post('patient_id', true),
            'donor_name'   => $this->input->post('donor_name', true),
            'remarks'      => $this->input->post('remarks', true),
            'blood_type'   => $blood_type,
        );
    
        // Update the report
        $this->BloodBankModel->update_x_match_report($id, $report_data);
    
        // Update each test row
        foreach ($tests as $test) {
            if (!empty($test['id'])) { // Only update if test row has an ID
                $test_data = array(
                    'test_name'      => $test['name'],
                    'cut_off_value'  => $test['cut_off'],
                    'patient_value'  => $test['patient_value'],
                    'result'         => $test['result']
                );
                $this->BloodBankModel->update_x_match_report_test($test['id'], $test_data);
            }
        }
    
        $this->session->set_flashdata('response', 'X Match Report updated successfully!');
        redirect('blood-bank/edit-x-match-report/' . $id);
    }

    public function issuance_report() {
        $title = site_name . ' - Issuance Report';

        $this->header($title);
        $this->sidebar();

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['blood_issuance'] = $this->BloodBankModel->get_all_blood_issuance($start_date, $end_date);
                
        $this->load->view('bloodbank/issues_report', $data);
        $this->footer();
    }

    public function issuance_summary_report() {
        $title = site_name . ' - Summary Report';
        $this->header($title);
        $this->sidebar();
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $this->load->model('BloodBankModel');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['blood_issuance'] = $this->BloodBankModel->get_all_blood_issuance($start_date, $end_date);
        $this->load->view('bloodbank/issuance_summary_report', $data);
        $this->footer();
    }

}
