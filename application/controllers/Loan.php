<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loan extends CI_Controller {

    /**
	 * -------
     * Loan constructor.
     * loads helpers, modal or libraries
	 * -------
     */

    public function __construct() {
        parent::__construct();
        $this -> is_logged_in();
        $this -> lang -> load ( 'general', 'english' );
        $this -> load -> model('HrModel');
        $this -> load -> model('LoanModel');
    }

    /**
	 * -------
     * @param $title
     * header template
	 * -------
     */

    public function header($title) {
        $data['title'] = $title;
        $this -> load -> view('/includes/admin/header', $data);
    }

    /**
	 * -------
     * sidebar template
	 * -------
     */

    public function sidebar() {
        $this -> load -> view('/includes/admin/general-sidebar');
    }

    /**
	 * -------
     * footer template
	 * -------
     */

    public function footer() {
        $this -> load -> view('/includes/admin/footer');
    }

    /**
	 * -------
     * checks if user is logged in
	 * -------
     */

    public function is_logged_in() {
        if (empty($this -> session -> userdata('user_data'))) {
            return redirect(base_url());
        }
    }

    /**
	 * -------
     * List of employees
	 * -------
     */

    public function index() {
        $title = site_name . ' - Loans';
        $this -> header($title);
        $this -> sidebar();
        $data['loans'] = $this -> LoanModel -> get_loans_employee_wise();
        $this -> load -> view('/loans/index', $data);
        $this -> footer();
	}

    /**
     * -------
     * add loans
	 * -------
     */

    public function add() {

    	if(isset($_POST['action']) and $_POST['action'] == 'do_add_loan')
    		$this -> do_add_loan();

        $title = site_name . ' - Add Loans';
        $this -> header($title);
        $this -> sidebar();
        $data['title'] = 'Add Loans';
        $data['employees'] = $this -> HrModel -> get_active_employees();
        $this -> load -> view('/loans/add', $data);
        $this -> footer();
	}

	/**
	 * -------
	 * add loan
	 * -------
	 */

	public function do_add_loan() {
    	$this -> form_validation -> set_rules('employee_id', 'employee', 'required|xss_clean');
    	$this -> form_validation -> set_rules('loan', 'loan', 'required|xss_clean');

		if($this -> form_validation -> run() == true) {
			$employee_id 	= $this -> input -> post('employee_id', true);
			$loan 			= $this -> input -> post('loan', true);
			$description 	= $this -> input -> post('description', true);

			$info = array(
				'user_id'				=>	get_logged_in_user_id(),
				'employee_id'			=>	$employee_id,
				'loan'					=>	$loan,
				'description'			=>	$description,
				'date_added'			=>	current_date_time()
			);

			$id = $this -> LoanModel -> add($info);
			if($id > 0) {
				$this -> session -> set_flashdata('response', 'Success! Loan added.');
				return redirect($_SERVER['HTTP_REFERER']);
			}
			else {
				$this -> session -> set_flashdata('error', 'Error! Please try again.');
				return redirect($_SERVER['HTTP_REFERER']);
			}
		}

	}

    /**
     * -------
     * edit loan
	 * -------
     */

    public function edit() {

    	$loan_id = $this -> uri -> segment(3);
    	if(empty($loan_id) or !is_numeric($loan_id) or $loan_id < 1)
    		return redirect($_SERVER['HTTP_REFERER']);

    	if(isset($_POST['action']) and $_POST['action'] == 'do_edit_loan')
    		$this -> do_edit_loan();

        $title = site_name . ' - Edit Loan';
        $this -> header($title);
        $this -> sidebar();
        $data['title'] = 'Edit Loan';
		$data['loan'] = $this -> LoanModel -> get_loan_by_id($loan_id);
        $this -> load -> view('/loans/edit', $data);
        $this -> footer();
	}

    /**
     * -------
     * edit loan
	 * -------
     */

    public function edit_paid() {

    	$paid_id = $this -> uri -> segment(3);
    	if(empty($paid_id) or !is_numeric($paid_id) or $paid_id < 1)
    		return redirect($_SERVER['HTTP_REFERER']);

    	if(isset($_POST['action']) and $_POST['action'] == 'do_edit_paid_loan')
    		$this -> do_edit_paid_loan();

        $title = site_name . ' - Edit Paid Loan';
        $this -> header($title);
        $this -> sidebar();
        $data['title'] = 'Edit Loan';
		$data['paid'] = $this -> LoanModel -> get_paid_loan_by_id($paid_id);
        $this -> load -> view('/loans/edit_paid', $data);
        $this -> footer();
	}

    /**
     * -------
     * pay loan
	 * -------
     */

    public function pay() {

    	if(isset($_POST['action']) and $_POST['action'] == 'do_pay_loan')
    		$this -> do_pay_loan();

        $title = site_name . ' - Pay Loan';
        $this -> header($title);
        $this -> sidebar();
        $data['title'] = 'Pay Loan';
		$data['employees'] = $this -> HrModel -> get_active_employees();
        $this -> load -> view('/loans/pay', $data);
        $this -> footer();
	}

    /**
     * -------
     * pay loan
	 * -------
     */

    public function paid() {
        $title = site_name . ' - Paid Loans';
        $this -> header($title);
        $this -> sidebar();
        $data['title'] = 'Paid Loans';
		$data['loans'] = $this -> LoanModel -> get_paid_loans();
        $this -> load -> view('/loans/paid', $data);
        $this -> footer();
	}

	/**
	 * -------
	 * edit loan
	 * -------
	 */

	public function do_edit_loan() {
    	$this -> form_validation -> set_rules('employee_id', 'employee', 'required|xss_clean');
    	$this -> form_validation -> set_rules('loan_id', 'loan_id', 'required|xss_clean');
    	$this -> form_validation -> set_rules('loan', 'loan', 'required|xss_clean');

		if($this -> form_validation -> run() == true) {
			$loan_id 		= $this -> input -> post('loan_id', true);
			$loan 			= $this -> input -> post('loan', true);
			$description 	= $this -> input -> post('description', true);

			$info = array(
				'loan'					=>	$loan,
				'description'			=>	$description,
			);

			$id = $this -> LoanModel -> update($info, $loan_id);
			if($id > 0) {
				$this -> session -> set_flashdata('response', 'Success! Loan updated.');
				return redirect($_SERVER['HTTP_REFERER']);
			}
			else {
				$this -> session -> set_flashdata('error', 'Error! Please try again.');
				return redirect($_SERVER['HTTP_REFERER']);
			}
		}

	}

	/**
	 * -------
	 * do pay loan
	 * -------
	 */

	public function do_pay_loan() {
    	$this -> form_validation -> set_rules('employee_id', 'employee', 'required|xss_clean');
    	$this -> form_validation -> set_rules('loan', 'loan', 'required|xss_clean');

		if($this -> form_validation -> run() == true) {
			$employee_id 	= $this -> input -> post('employee_id', true);
			$loan 			= $this -> input -> post('loan', true);
			$description 	= $this -> input -> post('description', true);

			$info = array(
				'user_id'				=>	get_logged_in_user_id(),
				'employee_id'			=>	$employee_id,
				'paid'					=>	$loan,
				'description'			=>	$description,
				'date_added'			=>	current_date_time()
			);

			$id = $this -> LoanModel -> do_pay_loan($info);
			if($id > 0) {
				$this -> session -> set_flashdata('response', 'Success! Loan paid.');
				return redirect($_SERVER['HTTP_REFERER']);
			}
			else {
				$this -> session -> set_flashdata('error', 'Error! Please try again.');
				return redirect($_SERVER['HTTP_REFERER']);
			}
		}

	}

	/**
	 * -------
	 * do edi tpay loan
	 * -------
	 */

	public function do_edit_paid_loan() {
    	$this -> form_validation -> set_rules('loan', 'loan', 'required|xss_clean');
    	$this -> form_validation -> set_rules('paid_id', 'paid id', 'required|xss_clean');

		if($this -> form_validation -> run() == true) {
			$paid_id 		= $this -> input -> post('paid_id', true);
			$loan 			= $this -> input -> post('loan', true);
			$description 	= $this -> input -> post('description', true);

			$info = array(
				'paid'					=>	$loan,
				'description'			=>	$description,
			);

			$this -> LoanModel -> do_edit_paid_loan($info, $paid_id);
			$this -> session -> set_flashdata('response', 'Success! Loan paid.');
			return redirect($_SERVER['HTTP_REFERER']);
		}

	}

	/**
     * -------
	 * get employee standing loan
     * -------
	 */

	public function get_employee_standing_loan() {
		$employee_id = $this -> input -> post('employee_id', true);
		if($employee_id > 0) {
			$loan 		= $this -> LoanModel -> get_employee_loan_by_id($employee_id);
			$paid_loan 	= $this -> LoanModel -> get_employee_paid_loan_by_id($employee_id);
			$standing	= $loan - $paid_loan;
			echo $standing;
		}
		else
			echo 0;
	}

    /**
     * -------
     * delete loan
	 * -------
     */

    public function delete() {

    	$loan_id = $this -> uri -> segment(3);
    	if(empty($loan_id) or !is_numeric($loan_id) or $loan_id < 1)
    		return redirect($_SERVER['HTTP_REFERER']);

		$deleted = $this -> LoanModel -> delete($loan_id);

    	if($deleted) {
			$this -> session -> set_flashdata('response', 'Success! Loan deleted.');
			return redirect($_SERVER['HTTP_REFERER']);
		}
		else {
			$this -> session -> set_flashdata('error', 'Error! Please try again.');
			return redirect($_SERVER['HTTP_REFERER']);
		}
	}

    /**
     * -------
     * delete loan
	 * -------
     */

    public function delete_paid() {

    	$loan_id = $this -> uri -> segment(3);
    	if(empty($loan_id) or !is_numeric($loan_id) or $loan_id < 1)
    		return redirect($_SERVER['HTTP_REFERER']);

		$deleted = $this -> LoanModel -> delete_paid($loan_id);

    	if($deleted) {
			$this -> session -> set_flashdata('response', 'Success! Paid Loan deleted.');
			return redirect($_SERVER['HTTP_REFERER']);
		}
		else {
			$this -> session -> set_flashdata('error', 'Error! Please try again.');
			return redirect($_SERVER['HTTP_REFERER']);
		}
	}


}
