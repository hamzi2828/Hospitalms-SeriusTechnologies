<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoanModel extends CI_Model {

    /**
     * -------------------------
     * LoanModel constructor.
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
    }

    /**
     * -------------------------
     * @return mixed
     * get loans
     * -------------------------
     */

    public function get_loans() {
        $employees = $this -> db -> get('loans');
        return $employees -> result();
    }

    /**
     * -------------------------
     * @return mixed
     * get paid loans
     * -------------------------
     */

    public function get_paid_loans() {
    	$this -> db -> order_by('id', 'DESC');
        $employees = $this -> db -> get('paid_loans');
        return $employees -> result();
    }

    /**
     * -------------------------
     * @return mixed
	 * @param $info
     * add loans
     * -------------------------
     */

    public function add($info) {
        $this -> db -> insert('loans', $info);
        return $this -> db -> insert_id();
    }

    /**
     * -------------------------
     * @return mixed
	 * @param $info
     * pay loans
     * -------------------------
     */

    public function do_pay_loan($info) {
        $this -> db -> insert('paid_loans', $info);
        return $this -> db -> insert_id();
    }

    /**
     * -------------------------
     * @return mixed
	 * @param $loan_id
     * get loans by id
     * -------------------------
     */

    public function get_loan_by_id($loan_id) {
		$loan = $this -> db -> get_where('loans', array('id'	=>	$loan_id));
        return $loan -> row();
    }

    /**
     * -------------------------
     * @return mixed
	 * @param $paid_id
     * get paid loans by id
     * -------------------------
     */

    public function get_paid_loan_by_id($paid_id) {
		$loan = $this -> db -> get_where('paid_loans', array('id'	=>	$paid_id));
        return $loan -> row();
    }

    /**
     * -------------------------
     * @return mixed
	 * @param $loan_id
	 * @param $info
     * update loan by id
     * -------------------------
     */

    public function update($info, $loan_id) {
		$this -> db -> update('loans', $info, array('id'	=>	$loan_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @return mixed
	 * @param $paid_id
	 * @param $info
     * update paid loan by id
     * -------------------------
     */

    public function do_edit_paid_loan($info, $paid_id) {
		$this -> db -> update('paid_loans', $info, array('id'	=>	$paid_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @return mixed
	 * @param $loan_id
	 * @param $info
     * update paid loan by id
     * -------------------------
     */

    public function do_update_paid_loan($info, $loan_id) {
		$this -> db -> update('paid_loans', $info, array('employee_id'	=>	$loan_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @return mixed
	 * @param $loan_id
     * delete loan by id
     * -------------------------
     */

    public function delete($loan_id) {
		$this -> db -> delete('loans', array('id'	=>	$loan_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @return mixed
	 * @param $loan_id
     * delete paid loan by id
     * -------------------------
     */

    public function delete_paid($loan_id) {
		$this -> db -> delete('paid_loans', array('id'	=>	$loan_id));
        return $this -> db -> affected_rows();
    }

	/**
     * -------------------------
	 * @param $employee_id
	 * @return mixed
	 * get employee loan
     * -------------------------
	 */

    public function get_employee_loan_by_id($employee_id) {
    	$query = $this -> db -> query("Select SUM(loan) as loan from hmis_loans where employee_id=$employee_id");
    	return $query -> row() -> loan;
	}

	/**
     * -------------------------
	 * @param $employee_id
	 * @return mixed
	 * get employee paid loan
     * -------------------------
	 */

    public function get_employee_paid_loan_by_id($employee_id) {
    	$query = $this -> db -> query("Select SUM(paid) as paid from hmis_paid_loans where employee_id=$employee_id");
    	return $query -> row() -> paid;
	}

	/**
     * -------------------------
	 * @param $employee_id
	 * @return mixed
	 * get employee paid loan
     * -------------------------
	 */

    public function get_employee_paid_loan_history($employee_id) {
    	$query = $this -> db -> query("Select * from hmis_paid_loans where employee_id=$employee_id");
    	return $query -> result();
	}

	/**
     * -------------------------
	 * @return mixed
	 * get employee loans
     * -------------------------
	 */

    public function get_loans_employee_wise() {
    	$query = $this -> db -> query("Select GROUP_CONCAT(loan) as loans, GROUP_CONCAT(date_added) as date_added, SUM(loan) as loan, employee_id, GROUP_CONCAT(id) as ids from hmis_loans group by employee_id");
    	return $query -> result();
	}

	/**
     * -------------------------
	 * @return mixed
	 * @param $employee_id
	 * get employee loans
     * -------------------------
	 */

    public function get_loans_by_employee($employee_id) {
    	$query = $this -> db -> query("Select GROUP_CONCAT(loan) as loans, GROUP_CONCAT(date_added) as date_added, SUM(loan) as loan, employee_id, GROUP_CONCAT(id) as ids from hmis_loans where employee_id=$employee_id group by employee_id");
    	return $query -> result();
	}

	/**
     * -------------------------
	 * @param $employee_id
	 * @return mixed
	 * get employee standing loan
     * -------------------------
	 */

    public function get_employee_standing_loan($employee_id) {
    	$loan = $this -> get_employee_loan_by_id($employee_id);
    	$paid = $this -> get_employee_paid_loan_by_id($employee_id);
    	return $loan - $paid;
	}

}