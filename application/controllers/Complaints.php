<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complaints extends CI_Controller {

    /**
     * -------------------------
     * User constructor.
     * loads helpers, modal or libraries
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
        $this -> is_logged_in();
        $this -> lang -> load ( 'general', 'english' );
        $this -> load -> model('ComplainModel');
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
     * complains main page
     * -------------------------
     */

    public function index() {
        $title = site_name . ' - Complaints';
        $this -> header($title);
        $this -> sidebar();

        $data['complains'] = $this -> ComplainModel -> get_complains();
        $this -> load -> view('/complains/index', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * add complains main page
     * -------------------------
     */

    public function add() {

        if(isset($_POST['action']) and $_POST['action'] == 'do_add_complains')
            $this -> do_add_complains($_POST);

        $title = site_name . ' - Add Complaints';
        $this -> header($title);
        $this -> sidebar();
        $this -> load -> view('/complains/add');
        $this -> footer();
    }

    /**
     * -------------------------
     * @param $post
     * add complains
     * -------------------------
     */

    public function do_add_complains($post) {
        $data = filter_var_array($post, FILTER_SANITIZE_STRING);
        $this -> form_validation -> set_rules('subject', 'subject', 'required|trim|min_length[1]|xss_clean');
        $this -> form_validation -> set_rules('complain', 'complain', 'required|trim|min_length[1]|xss_clean');
        if($this -> form_validation -> run() == true) {

            $array = array(
            	'user_id'		=>	get_logged_in_user_id(),
                'subject'       =>  $data['subject'],
                'priority'      =>  $data['priority'],
                'complain'      =>  $data['complain'],
				'seen' => 0,
				'date_added'	=>	current_date_time()
            );
            $complain_id = $this -> ComplainModel -> add($array);

            if($complain_id > 0) {

				$this -> add_complain_attachments($complain_id);

                $this -> session -> set_flashdata('response', 'Success! Complain added.');
                return redirect($_SERVER['HTTP_REFERER']);
            }
            else {
                $this -> session -> set_flashdata('error', 'Oops! An unknown error occurred. Please try again.');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

	/**
	 * -------
	 * @param $id
	 * add documents
	 * -------
	 */

	public function add_complain_attachments($id) {
		if (!empty($_FILES['attachment']['name'])) {
			$this -> ComplainModel -> delete_attachments($id);
			$filesCount = count($_FILES['attachment']['name']);
			for ($i = 0; $i < $filesCount; $i++) {
				$_FILES['file']['name'] = $_FILES['attachment']['name'][$i];
				$_FILES['file']['type'] = $_FILES['attachment']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['attachment']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['attachment']['error'][$i];
				$_FILES['file']['size'] = $_FILES['attachment']['size'][$i];

				if (!is_dir('uploads/')) {
					mkdir('./uploads/', 0777, TRUE);
				}

				$upload_path = 'uploads/';
				$config['upload_path'] = $upload_path;
				$config['allowed_types'] = 'jpg|png|gif|pdf|zip|jpeg|PNG';
				$config['max_size'] = '0';
				$config['max_filename'] = '255';
				$config['encrypt_name'] = true;

				$this -> load -> library('upload', $config);
				$this -> upload -> initialize($config);

				if ($this -> upload -> do_upload('file')) {
					$fileData = $this -> upload -> data();
					$uploadData[$i]['file_name'] = $fileData['file_name'];
					$info = array(
						'complain_id' 	=> $id,
						'attachment'    => base_url('/uploads/' . $uploadData[$i]['file_name']),
						'date_added'  	=> current_date_time(),
					);
					$this -> ComplainModel -> add_complain_attachments($info);
				}
			}
		}
	}

    /**
     * -------------------------
     * add user main page
     * -------------------------
     */

    public function edit() {

		$complain_id = $this -> uri -> segment(3);
        if(empty(trim($complain_id)) or $complain_id < 1 or !is_numeric($complain_id))
            return redirect($_SERVER['HTTP_REFERER']);

        if(isset($_POST['action']) and $_POST['action'] == 'do_update_complain')
            $this -> do_update_complain($_POST);

        $title = site_name . ' - Edit Complaint';
        $this -> header($title);
        $this -> sidebar();
		$array = array(
			'seen'  => '1',
		);
		$this -> ComplainModel -> edit($array, $complain_id);
        $data['complain'] = $this -> ComplainModel -> get_complain_by_id($complain_id);
        $data['attachments'] = $this -> ComplainModel -> get_complain_attachments_by_id($complain_id);
        $this -> load -> view('/complains/edit', $data);
        $this -> footer();
    }

    /**
     * -------------------------
     * @param $post
     * edit complain
     * -------------------------
     */

    public function do_update_complain($post) {
		$data = filter_var_array($post, FILTER_SANITIZE_STRING);
		$this -> form_validation -> set_rules('remarks', 'remarks', 'required|trim|min_length[1]|xss_clean');
		$this -> form_validation -> set_rules('complain_id', 'complain id', 'required|trim|min_length[1]|xss_clean');
		if ($this -> form_validation -> run() == true) {
			$array = array(
				'remarks'   	=> $data['remarks'],
			);
			$this -> ComplainModel -> edit($array, $data['complain_id']);
			$this -> session -> set_flashdata('response', 'Success! Complain updated.');
			return redirect($_SERVER['HTTP_REFERER']);
		}
    }

    /**
     * -------------------------
     * delete complain
     * -------------------------
     */

    public function delete() {
        $complain_id = $this -> uri -> segment(3);
        if(!empty(trim($complain_id)) and $complain_id > 0 and is_numeric($complain_id)) {
            $this -> ComplainModel -> delete($complain_id);
			$this -> session -> set_flashdata('response', 'Success! Complain deleted.');
        }
		return redirect($_SERVER['HTTP_REFERER']);
    }



}
