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
    
        // Fetch the maximum existing sequence for today's date
        $this->db->select('MAX(reference_number) as reference_number');
        $this->db->from('blood_inventory');
        $this->db->where("reference_number LIKE '$prefix%'");
        $query = $this->db->get();
        $result = $query->row_array();
    
        if (empty($result['reference_number'])) {
            $new_number = 1;
        } else {
            // Extract the numeric suffix after the date part
            $last_sequence = $result['reference_number'];
            $number_part = intval(substr($last_sequence, strlen($prefix))); // extract suffix
            $new_number = $number_part + 1;
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

    public function get_all_blood_issuance() {
        $this->db->select('*');
        $this->db->from('blood_issuance');
        $query = $this->db->get();
        return $query->result_array();
    }

    
    public function get_issuance_number(){
        $date = date('Ymd'); // format: YYYYMMDD
        $prefix = 'ISS-' . $date;
    
        // Fetch the maximum existing sequence for today's date
        $this->db->select('MAX(issuance_number) as issuance_number');
        $this->db->from('blood_issuance');
        $this->db->where("issuance_number LIKE '$prefix%'");
        $query = $this->db->get();
        $result = $query->row_array();
    
        if (empty($result['issuance_number'])) {
            $new_number = 1;
        } else {
            // Extract the numeric suffix after the date part
            $last_sequence = $result['issuance_number'];
            $number_part = intval(substr($last_sequence, strlen($prefix))); // extract suffix
            $new_number = $number_part + 1;
        }
    
        // Final sequence number
        $issuance_number = $prefix . $new_number;
        return $issuance_number;
    }

}
