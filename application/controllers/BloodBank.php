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
        $data['blood_inventory'] = $this->BloodBankModel->get_avilable_blood_inventory();
        $this->load->view('bloodbank/blood_status', $data);
        $this->footer();
    }

    

 
    

}

