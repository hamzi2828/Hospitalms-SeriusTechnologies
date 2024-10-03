<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UnitModel extends CI_Model {

    /**
     * -------------------------
     * UnitModel constructor.
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
    }

    /**
     * -------------------------
     * @param $data
     * @return mixed
     * save units into database
     * -------------------------
     */

    public function add($data) {
        $this -> db -> insert('units', $data);
        return $this -> db -> insert_id();
    }

    /**
     * -------------------------
     * @return mixed
     * get units
     * -------------------------
     */

    public function get_units() {
        $suppliers = $this -> db -> get_where('units');
        return $suppliers -> result();
    }

    /**
     * -------------------------
     * @return mixed
     * @param $unit_id
     * get units by id
     * -------------------------
     */

    public function get_unit_by_id($unit_id) {
        $suppliers = $this -> db -> get_where('units', array('id'    =>  $unit_id));
        return $suppliers -> row();
    }

    /**
     * -------------------------
     * @param $data
     * @param $unit_id
     * @return mixed
     * update units info
     * -------------------------
     */

    public function edit($data, $unit_id) {
        $this -> db -> update('units', $data, array('id'    =>  $unit_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @param $unit_id
     * @return mixed
     * delete units
     * -------------------------
     */

    public function delete($unit_id) {
        $this -> db -> delete('units', array('id'    =>  $unit_id));
        return $this -> db -> affected_rows();
    }

}