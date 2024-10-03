<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ComplainModel extends CI_Model {

    /**
     * -------------------------
     * ComplainModel constructor.
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
    }

    /**
     * -------------------------
     * @return mixed
     * get all complains
     * -------------------------
     */

    public function get_complains() {
    	$this -> db -> order_by('priority', 'DESC');
        $complains = $this -> db -> get('complains');
        return $complains -> result();
    }

    /**
     * -------------------------
     * @return mixed
	 * @param $complain_id
     * get complain by id
     * -------------------------
     */

    public function get_complain_by_id($complain_id) {
		$complain = $this -> db -> get_where('complains', array('id'	=> $complain_id));
        return $complain -> row();
    }

    /**
     * -------------------------
     * @return mixed
	 * @param $complain_id
     * get complain attachments by id
     * -------------------------
     */

    public function get_complain_attachments_by_id($complain_id) {
		$attachments = $this -> db -> get_where('complain_attachments', array('complain_id'	=> $complain_id));
        return $attachments -> result();
    }

    /**
     * -------------------------
     * @param $data
     * @return mixed
     * insert complains
     * -------------------------
     */

    public function add($data) {
        $this -> db -> insert('complains', $data);
        return $this -> db -> insert_id();
    }

    /**
     * -------------------------
     * @param $data
     * @return mixed
     * insert complains attachments
     * -------------------------
     */

    public function add_complain_attachments($data) {
        $this -> db -> insert('complain_attachments', $data);
        return $this -> db -> insert_id();
    }

    /**
     * -------------------------
     * @param $data
     * @param $complain_id
     * @return mixed
     * update complains
     * -------------------------
     */

    public function edit($data, $complain_id) {
        $this -> db -> update('complains', $data, array('id' => $complain_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @param $complain_id
     * @return mixed
     * delete complains permanently
     * -------------------------
     */

    public function delete($complain_id) {
        $this -> db -> delete('complains', array('id' => $complain_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @param $complain_id
     * @return mixed
     * delete complains attachments
     * -------------------------
     */

    public function delete_attachments($complain_id) {
        $this -> db -> delete('complain_attachments', array('complain_id' => $complain_id));
        return $this -> db -> affected_rows();
    }

}