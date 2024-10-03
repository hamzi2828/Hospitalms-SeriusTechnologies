<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MemberModel extends CI_Model {

    /**
     * -------------------------
     * MemberModel constructor.
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
    }

    /**
     * -------------------------
     * @return mixed
     * get all member types
     * -------------------------
     */

    public function get_members() {
        $members = $this -> db -> get('member_types');
        return $members -> result();
    }

    /**
     * -------------------------
     * @return mixed
     * @param $member_id
     * get member by id
     * -------------------------
     */

    public function get_member_by_id($member_id) {
        $member = $this -> db -> get_where('member_types', array('id'  =>  $member_id));
        return $member -> row();
    }

    /**
     * -------------------------
     * @param $data
     * @return mixed
     * insert member types
     * -------------------------
     */

    public function add($data) {
        $this -> db -> insert('member_types', $data);
        return $this -> db -> insert_id();
    }

    /**
     * -------------------------
     * @param $data
     * @param $member_id
     * @return mixed
     * update member types
     * -------------------------
     */

    public function edit($data, $member_id) {
        $this -> db -> update('member_types', $data, array('id' =>  $member_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @param $member_id
     * @return mixed
     * delete member type permanently
     * -------------------------
     */

    public function delete($member_id) {
        $this -> db -> delete('member_types', array('id' =>  $member_id));
        return $this -> db -> affected_rows();
    }

	/**
	 * -------------------------
	 * @return mixed
	 * get departments
	 * -------------------------
	 */

	public function get_departments() {
		$departments = $this -> db -> get('departments');
		return $departments -> result();
	}

	/**
	 * -------------------------
	 * @param $data
	 * @return mixed
	 * insert departments
	 * -------------------------
	 */

	public function do_add_department($data) {
		$this -> db -> insert('departments', $data);
		return $this -> db -> insert_id();
	}

	/**
	 * -------------------------
	 * @return mixed
	 * @param $department_id
	 * get department by id
	 * -------------------------
	 */

	public function get_department_by_id($department_id) {
		$member = $this -> db -> get_where('departments', array('id'  =>  $department_id));
		return $member -> row();
	}

	/**
	 * -------------------------
	 * @param $data
	 * @param $department_id
	 * @return mixed
	 * update department
	 * -------------------------
	 */

	public function do_edit_department($data, $department_id) {
		$this -> db -> update('departments', $data, array('id' =>  $department_id));
		return $this -> db -> affected_rows();
	}

	/**
	 * -------------------------
	 * @param $department_id
	 * @return mixed
	 * delete department
	 * -------------------------
	 */

	public function delete_department($department_id) {
		$this -> db -> delete('departments', array('id' =>  $department_id));
		return $this -> db -> affected_rows();
	}

}