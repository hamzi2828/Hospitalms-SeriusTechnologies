<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BloodBankModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_blood_inventory() {
        $this->db->select('*');
        $this->db->from('blood_inventory');
        $query = $this->db->get();
        return $query->result_array();
    }

    
    public function insert_blood($data) {
        return $this->db->insert('blood_inventory', $data);
    }
    public function update_blood($where, $data) {
        $this->db->where($where);
        return $this->db->update('blood_inventory', $data);
    }
    
    public function delete($id) {
        return $this->db->delete('blood_inventory', ['id' => $id]);
    }
    
    
    public function get_by_id($id) {
        $this->db->select('*');
        $this->db->from('blood_inventory');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    
    public function get_reference_number(){
        $date = date('Ymd'); // format: YYYYMMDD
        $prefix = 'B-' . $date;

        // Fetch the maximum numeric suffix for today's date
        $this->db->select("MAX(CAST(SUBSTRING(reference_number, " . (strlen($prefix) + 1) . ") AS UNSIGNED)) as max_suffix", false);
        $this->db->from('blood_inventory');
        $this->db->where("reference_number LIKE '$prefix%'");
        $query = $this->db->get();
        $result = $query->row_array();

        if (empty($result['max_suffix'])) {
            $new_number = 1;
        } else {
            $new_number = $result['max_suffix'] + 1;
        }

        // Final sequence number
        $reference_number = $prefix . $new_number;
        return $reference_number;
    }
    
        /**
     * Insert a blood issuance record
     */
    public function insert_blood_issuance($data) {
        $this->db->insert('blood_issuance', $data);
        return $this->db->insert_id();
    }

    public function get_all_blood_issuance($start_date = null, $end_date = null) {
        $this->db->select('*');
        $this->db->from('blood_issuance');
        if ($start_date && $end_date) {
            $this->db->where('created_at >=', $start_date . ' 00:00:00');
            $this->db->where('created_at <=', $end_date . ' 23:59:59');
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    
    public function get_issuance_number(){
        $date = date('Ymd'); // format: YYYYMMDD
        $prefix = 'ISS-' . $date;

        // Fetch the maximum numeric suffix for today's date
        $this->db->select("MAX(CAST(SUBSTRING(issuance_number, " . (strlen($prefix) + 1) . ") AS UNSIGNED)) as max_suffix", false);
        $this->db->from('blood_issuance');
        $this->db->where("issuance_number LIKE '$prefix%'");
        $query = $this->db->get();
        $result = $query->row_array();

        if (empty($result['max_suffix'])) {
            $new_number = 1;
        } else {
            $new_number = $result['max_suffix'] + 1;
        }

        // Final sequence number
        $issuance_number = $prefix . $new_number;
        return $issuance_number;
    }

    public function get_avilable_blood_inventory() {
        $today = date('Y-m-d');
        // Get all issued inventory IDs
        $issued = $this->db->select('inventory_id')->get('blood_issuance')->result_array();
        $issued_ids = array_column($issued, 'inventory_id');

        // Get inventory not issued and not expired
        $this->db->where('expiry_date >=', $today);
        if (!empty($issued_ids)) {
            $this->db->where_not_in('id', $issued_ids);
        }
        $query = $this->db->get('blood_inventory');

        return $query->result_array();
    }

    public function get_all_x_match_reports() {
        $this->db->select('*');
        $this->db->from('x_match_reports');
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_x_match_report($data) {
        $this->db->insert('x_match_reports', $data);
        return $this->db->insert_id();
    }

    public function insert_x_match_report_test($data) {
        $this->db->insert('x_match_report_tests', $data);
    }
    public function get_x_match_report_by_id_with_tests($id) {
        // Get the main report
        $this->db->select('*');
        $this->db->from('x_match_reports');
        $this->db->where('id', $id);
        $report = $this->db->get()->row_array();
    
        if ($report) {
            // Get all tests for this report
            $this->db->select('*');
            $this->db->from('x_match_report_tests');
            $this->db->where('report_id', $id);
            $tests = $this->db->get()->result_array();
    
            $report['tests'] = $tests;
        }
    
        return $report;
    }

    function get_xmatch_patient_blood_group($report_id) {
        $ci =& get_instance();
        $ci->load->database();
        $ci->db->select('result');
        $ci->db->from('x_match_report_tests');
        $ci->db->where('report_id', $report_id);
        $ci->db->where('test_name', 'Patient Blood Group');
        $row = $ci->db->get()->row();
        return $row ? $row->result : '';
    }

    
    public function delete_x_match_report($id) {
        $this->db->where('id', $id);
        $this->db->delete('x_match_reports');
        
        $this->db->where('report_id', $id);
        $this->db->delete('x_match_report_tests');
    }


    public function get_x_match_report($id) {
        $this->db->select('*');
        $this->db->from('x_match_reports');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_x_match_report_tests($id) {
        $this->db->select('*');
        $this->db->from('x_match_report_tests');
        $this->db->where('report_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
        
    public function update_x_match_report($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('x_match_reports', $data);
    }
    public function update_x_match_report_test($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('x_match_report_tests', $data);
    }

    
    public function is_inventory_id_issued($id) {
        $this->db->select('inventory_id');
        $this->db->from('blood_issuance');
        $this->db->where('inventory_id', $id);
        $query = $this->db->get();
        return $query->num_rows() > 0;
    }

    public function delete_issue($id) {
        $this->db->where('id', $id);
        $this->db->delete('blood_issuance');
    }

}
