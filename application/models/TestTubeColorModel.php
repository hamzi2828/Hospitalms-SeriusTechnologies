<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TestTubeColorModel extends CI_Model {

    /**
     * -------------------------
     * TestTubeColorModel constructor.
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
    }

    /**
     * -------------------------
     * @param $data
     * @return mixed
     * save colors into database
     * -------------------------
     */

    public function add($data) {
        $this -> db -> insert('colors', $data);
        return $this -> db -> insert_id();
    }

    /**
     * -------------------------
     * @return mixed
     * get colors
     * -------------------------
     */

    public function get_colors() {
        $suppliers = $this -> db -> get_where('colors');
        return $suppliers -> result();
    }

    /**
     * -------------------------
     * @return mixed
     * @param $color_id
     * get color by id
     * -------------------------
     */

    public function get_color_by_id($color_id) {
        $suppliers = $this -> db -> get_where('colors', array('id'    =>  $color_id));
        return $suppliers -> row();
    }

    /**
     * -------------------------
     * @param $data
     * @param $color_id
     * @return mixed
     * update color info
     * -------------------------
     */

    public function edit($data, $color_id) {
        $this -> db -> update('colors', $data, array('id'    =>  $color_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @param $color_id
     * @return mixed
     * delete color
     * -------------------------
     */

    public function delete($color_id) {
        $this -> db -> delete('colors', array('id'    =>  $color_id));
        return $this -> db -> affected_rows();
    }

}