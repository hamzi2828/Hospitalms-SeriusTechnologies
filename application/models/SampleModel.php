<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SampleModel extends CI_Model {

    /**
     * -------------------------
     * SampleModel constructor.
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
    }

    /**
     * -------------------------
     * @param $data
     * @return mixed
     * save samples into database
     * -------------------------
     */

    public function add($data) {
        $this -> db -> insert('samples', $data);
        return $this -> db -> insert_id();
    }

    /**
     * -------------------------
     * @return mixed
     * get samples
     * -------------------------
     */

    public function get_samples() {
        $suppliers = $this -> db -> get_where('samples');
        return $suppliers -> result();
    }

    /**
     * -------------------------
     * @return mixed
     * @param $sample_id
     * get sample by id
     * -------------------------
     */

    public function get_sample_by_id($sample_id) {
        $suppliers = $this -> db -> get_where('samples', array('id'    =>  $sample_id));
        return $suppliers -> row();
    }

    /**
     * -------------------------
     * @param $data
     * @param $sample_id
     * @return mixed
     * update sample info
     * -------------------------
     */

    public function edit($data, $sample_id) {
        $this -> db -> update('samples', $data, array('id'    =>  $sample_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @param $sample_id
     * @return mixed
     * delete samples
     * -------------------------
     */

    public function delete($sample_id) {
        $this -> db -> delete('samples', array('id'    =>  $sample_id));
        return $this -> db -> affected_rows();
    }

}