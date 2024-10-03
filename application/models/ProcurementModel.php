<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProcurementModel extends CI_Model {

    /**
     * -------------------------
     * ProcurementModel constructor.
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
    }

    /**
     * -------------------------
     * @return mixed
     * get all procurements
     * -------------------------
     */

    public function get_procurements() {
        $this -> db -> order_by('id', 'DESC');
        $procurements = $this -> db -> get_where('procurements', array('request_by' =>  get_logged_in_user_id()));
        return $procurements -> result();
    }

    /**
     * -------------------------
     * @param $data
     * @return mixed
     * insert procurements
     * -------------------------
     */

    public function add($data) {
        $this -> db -> insert('procurements', $data);
        return $this -> db -> insert_id();
    }

    /**
     * -------------------------
     * @return mixed
     * @param $procurement_id
     * get procurements by id
     * -------------------------
     */

    public function get_procurement_by_id($procurement_id) {
        $procurement = $this -> db -> get_where('procurements', array('id'  =>  $procurement_id));
        return $procurement -> row();
    }

    /**
     * -------------------------
     * @param $data
     * @param $procurement_id
     * @return mixed
     * update procurements
     * -------------------------
     */

    public function edit($data, $procurement_id) {
        $this -> db -> update('procurements', $data, array('id' =>  $procurement_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @param $procurement_id
     * @return mixed
     * delete procurements permanently
     * -------------------------
     */

    public function delete($procurement_id) {
        $this -> db -> delete('procurements', array('id' =>  $procurement_id));
        return $this -> db -> affected_rows();
    }

}