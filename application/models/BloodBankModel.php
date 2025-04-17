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

    
    public function get_sequence_number(){
        $date = date('Ymd'); // format: YYYYMMDD
        $prefix = 'B-' . $date;
    
        // Fetch the maximum existing sequence for today's date
        $this->db->select('MAX(sequence_number) as sequence_number');
        $this->db->from('blood_inventory');
        $this->db->where("sequence_number LIKE '$prefix%'");
        $query = $this->db->get();
        $result = $query->row_array();
    
        if (empty($result['sequence_number'])) {
            $new_number = 1;
        } else {
            // Extract the numeric suffix after the date part
            $last_sequence = $result['sequence_number'];
            $number_part = intval(substr($last_sequence, strlen($prefix))); // extract suffix
            $new_number = $number_part + 1;
        }
    
        // Final sequence number
        $sequence_number = $prefix . $new_number;
        return $sequence_number;
    }
    
    

}
