<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SectionModel extends CI_Model {

    /**
     * -------------------------
     * SectionModel constructor.
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
    }

    /**
     * -------------------------
     * @param $data
     * @return mixed
     * save sections into database
     * -------------------------
     */

    public function add($data) {
        $this -> db -> insert('sections', $data);
        return $this -> db -> insert_id();
    }

    /**
     * -------------------------
     * @return mixed
     * get sections
     * -------------------------
     */

    public function get_sections() {
        $suppliers = $this -> db -> get_where('sections');
        return $suppliers -> result();
    }

    /**
     * -------------------------
     * @return mixed
     * @param $section_id
     * get units by id
     * -------------------------
     */

    public function get_section_by_id($section_id) {
        $suppliers = $this -> db -> get_where('sections', array('id'    =>  $section_id));
        return $suppliers -> row();
    }

    /**
     * -------------------------
     * @param $data
     * @param $section_id
     * @return mixed
     * update sections info
     * -------------------------
     */

    public function edit($data, $section_id) {
        $this -> db -> update('sections', $data, array('id'    =>  $section_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @param $section_id
     * @return mixed
     * delete section
     * -------------------------
     */

    public function delete($section_id) {
        $this -> db -> delete('sections', array('id'    =>  $section_id));
        return $this -> db -> affected_rows();
    }

}