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
    

}
