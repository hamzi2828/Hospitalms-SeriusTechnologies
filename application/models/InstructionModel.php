<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InstructionModel extends CI_Model {

    /**
     * -------------------------
     * InstructionModel constructor.
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
    }

    /**
     * -------------------------
     * @param $data
     * @return mixed
     * save instructions into database
     * -------------------------
     */

    public function add($data) {
        $this -> db -> insert('instructions', $data);
        return $this -> db -> insert_id();
    }

    /**
     * -------------------------
     * @return mixed
     * get Instructions
     * -------------------------
     */

    public function get_instructions() {
        $this -> db -> order_by('id', 'DESC');
        $consultancies = $this -> db -> get('instructions');
        return $consultancies -> result();
    }

    /**
     * -------------------------
     * @return mixed
     * @param $instruction_id
     * get Instructions by id
     * -------------------------
     */

    public function get_instruction_by_id($instruction_id) {
        $consultancy = $this -> db -> get_where('instructions', array('id' =>  $instruction_id));
        return $consultancy -> row();
    }

    /**
     * -------------------------
     * @param $info
     * @param $instruction_id
     * @return mixed
     * update Instructions
     * -------------------------
     */

    public function edit($info, $instruction_id) {
        $this -> db -> update('instructions', $info, array('id'   =>  $instruction_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @param $instruction_id
     * @return mixed
     * delete Instructions
     * -------------------------
     */

    public function delete($instruction_id) {
        $this -> db -> delete('instructions', array('id'    =>  $instruction_id));
        return $this -> db -> affected_rows();
    }

}