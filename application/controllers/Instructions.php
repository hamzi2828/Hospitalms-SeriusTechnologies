<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instructions extends CI_Controller {

    /**
     * -------------------------
     * Instructions constructor.
     * loads helpers, modal or libraries
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
        $this -> is_logged_in();
        $this -> lang -> load ( 'general', 'english' );
        $this -> load -> model('InstructionModel');
    }

    /**
     * -------------------------
     * @param $title
     * header template
     * -------------------------
     */

    public function header($title) {
        $data['title'] = $title;
        $this -> load -> view('/includes/admin/header', $data);
    }

    /**
     * -------------------------
     * sidebar template
     * -------------------------
     */

    public function sidebar() {
        $this -> load -> view('/includes/admin/general-sidebar');
    }

    /**
     * -------------------------
     * footer template
     * -------------------------
     */

    public function footer() {
        $this -> load -> view('/includes/admin/footer');
    }

    /**
     * ---------------------
     * checks if user is logged in
     * ---------------------
     */

    public function is_logged_in() {
        if (empty($this -> session -> userdata('user_data'))) {
            return redirect(base_url());
        }
    }

    /**
     * -------------------------
     * Instructions main page
     * -------------------------
     */

    public function index() {
        $title = site_name . ' - Instructions';
        $this -> header($title);
        $this -> sidebar();
        $data['instructions'] = $this -> InstructionModel -> get_instructions();
        $this -> load -> view('/instructions/index', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * Instructions add main page
     * -------------------------
     */

    public function add() {

        if(isset($_POST['action']) and $_POST['action'] == 'do_add_instructions')
            $this -> do_add_instructions($_POST);

        $title = site_name . ' - Add Instructions';
        $this -> header($title);
        $this -> sidebar();
        $this -> load -> view('/instructions/add');
        $this -> footer();
	}

    /**
     * -------------------------
     * @param $POST
     * add Instructions
     * -------------------------
     */

	public function do_add_instructions($POST) {
        $data = filter_var_array($POST, FILTER_SANITIZE_STRING);
        $instructions = $data['instructions'];
        if(count($instructions) > 0) {
        	foreach ($instructions as $key => $value) {
        		$info = array(
        			'instruction'		=>	$value,
				);
        		$this -> InstructionModel -> add($info);
			}
			$this -> session -> set_flashdata('response', 'Success! Instructions added.');
			return redirect($_SERVER['HTTP_REFERER']);
		}
    }

    /**
     * -------------------------
     * instruction edit main page
     * -------------------------
     */

    public function edit() {

        $instruction_id = $this -> uri -> segment(3);
        if(empty(trim($instruction_id)) or !is_numeric($instruction_id))
            return redirect($_SERVER['HTTP_REFERER']);

        if(isset($_POST['action']) and $_POST['action'] == 'do_edit_instruction')
            $this -> do_edit_instruction($_POST);

        $title = site_name . ' - Edit Consultancy';
        $this -> header($title);
        $this -> sidebar();
        $data['instruction'] = $this -> InstructionModel -> get_instruction_by_id($instruction_id);
        $this -> load -> view('/instructions/edit', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * @param $POST
     * edit instruction
     * -------------------------
     */

    public function do_edit_instruction($POST) {
        $data = filter_var_array($POST, FILTER_SANITIZE_STRING);
        $this -> form_validation -> set_rules('instruction', 'instruction', 'required|trim|min_length[1]|xss_clean');
        $this -> form_validation -> set_rules('instruction_id', 'instruction id', 'required|trim|min_length[1]|xss_clean|numeric');

        $instruction_id = $data['instruction_id'];
        if($this -> form_validation -> run() == true) {
            $info = array(
                'instruction'	=>  $data['instruction'],
            );
            $updated = $this -> InstructionModel -> edit($info, $instruction_id);
            if($updated) {
                $this -> session -> set_flashdata('response', 'Success! Instruction updated.');
                return redirect($_SERVER['HTTP_REFERER']);
            }
            else {
                $this -> session -> set_flashdata('error', 'Note! No record updated.');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    /**
     * -------------------------
     * delete instruction
     * -------------------------
     */

    public function delete() {
		$instruction_id = $this -> uri -> segment(3);
        if(empty(trim($instruction_id)) or !is_numeric($instruction_id))
            return redirect($_SERVER['HTTP_REFERER']);

        $this -> InstructionModel -> delete($instruction_id);
        $this -> session -> set_flashdata('response', 'Success! Instruction deleted.');
        return redirect($_SERVER['HTTP_REFERER']);

    }

	/**
	 * -------------------------
	 * add more instructions
	 * -------------------------
	 */

	public function add_more_instructions() {
		$data['row'] = $_POST['row'];
		$this -> load -> view('/instructions/add_more_instructions', $data);
	}

}
