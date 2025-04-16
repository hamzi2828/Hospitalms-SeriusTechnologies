<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BloodBank extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('BloodBankModel'); 
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

    public function store_blood() {
        $source = $this->input->post('source', true);
    
        if (!$source) {
            $this->session->set_flashdata('error', 'Please select a blood source (Purchase or Donor).');
            redirect('BloodBank/add_blood');
        }
    
        // Load model for insert if not already
        $this->load->model('BloodBankModel');
    
        if ($source === 'purchase') {
            $data = [
                'source'         => 'purchase',
                'from'           => $this->input->post('from', true),
                'purchase_price' => $this->input->post('purchase_price', true),
                'blood_type'     => $this->input->post('blood_type', true),
                'expiry_date'    => $this->input->post('expiry_date', true),
                'created_at'     => date('Y-m-d H:i:s'),
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
                'created_at'     => date('Y-m-d H:i:s'),
            ];
        } else {
            $this->session->set_flashdata('error', 'Invalid blood source selected.');
            redirect('BloodBank/add_blood');
        }
    
        // Save to DB using model
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

    

 
    

}
