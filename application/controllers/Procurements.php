<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Procurements extends CI_Controller {

    /**
     * -------------------------
     * Procurements constructor.
     * loads helpers, modal or libraries
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
        $this -> is_logged_in();
        $this -> lang -> load ( 'general', 'english' );
        $this -> load -> model('ProcurementModel');
        $this -> load -> model('StoreModel');
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
     * Procurements main page
     * -------------------------
     */

    public function index() {
        $title = site_name . ' - Procurements';
        $this -> header($title);
        $this -> sidebar();
        $data['procurements'] = $this -> ProcurementModel -> get_procurements();
        $this -> load -> view('/procurements/index', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * Procurements add main page
     * -------------------------
     */

    public function add() {

        if(isset($_POST['action']) and $_POST['action'] == 'do_add_procurements')
            $this -> do_add_procurements($_POST);

        $title = site_name . ' - Add Procurements';
        $this -> header($title);
        $this -> sidebar();
        $data['stores'] = $this -> StoreModel -> get_all_store();
        $this -> load -> view('/procurements/add', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * @param $POST
     * add procurements
     * -------------------------
     */

	public function do_add_procurements($POST) {
        $data       = filter_var_array($POST, FILTER_SANITIZE_STRING);
        $store_id   = $data['store_id'];
        if(isset($store_id) and count(array_filter($store_id)) > 0) {
            $user = get_user(get_logged_in_user_id());
            $department_id = $user -> department_id;
            if(!empty(trim($department_id)) and $department_id > 0) {
                foreach ($store_id as $key => $value) {
                    $info = array(
                        'request_by'    =>  get_logged_in_user_id(),
                        'department_id' =>  $department_id,
                        'item_id'       =>  $value,
                        'quantity'      =>  $data['quantity'][$key],
                        'description'   =>  $data['description'][$key],
                        'date_added'    =>  date('Y-m-d h:i:s')
                    );
                    $this -> ProcurementModel -> add($info);
                }
            }
        }
        $this -> session -> set_flashdata('response', 'Success! Procurement added.');
        return redirect(base_url('/procurements/add'));
    }

    /**
     * -------------------------
     * procurement edit main page
     * -------------------------
     */

    public function edit() {

        $procurement_id = $this -> uri -> segment(3);
        if(empty(trim($procurement_id)) or !is_numeric($procurement_id))
            return redirect($_SERVER['HTTP_REFERER']);

        if(isset($_POST['action']) and $_POST['action'] == 'do_edit_procurement')
            $this -> do_edit_procurement($_POST);

        $title = site_name . ' - Edit Procurement';
        $this -> header($title);
        $this -> sidebar();
        $data['stores'] = $this -> StoreModel -> get_all_store();
        $data['procurement'] = $this -> ProcurementModel -> get_procurement_by_id($procurement_id);
        $this -> load -> view('/procurements/edit', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * @param $POST
     * edit procurement
     * -------------------------
     */

    public function do_edit_procurement($POST) {
        $data = filter_var_array($POST, FILTER_SANITIZE_STRING);
        $procurement_id = $data['procurement_id'];
        $info = array(
            'item_id'       =>  $data['store_id'],
            'quantity'      =>  $data['quantity'],
            'description'   =>  $data['description'],
        );
        $updated = $this -> ProcurementModel -> edit($info, $procurement_id);
        if($updated) {
            $this -> session -> set_flashdata('response', 'Success! Procurement updated.');
            return redirect($_SERVER['HTTP_REFERER']);
        }
        else {
            $this -> session -> set_flashdata('error', 'Note! No record updated.');
            return redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * -------------------------
     * delete procurement
     * -------------------------
     */

    public function delete() {
        $procurement_id = $this -> uri -> segment(3);
        if(empty(trim($procurement_id)) or !is_numeric($procurement_id))
            return redirect($_SERVER['HTTP_REFERER']);

        $this -> ProcurementModel -> delete($procurement_id);
        $this -> session -> set_flashdata('response', 'Success! Procurement deleted.');
        return redirect($_SERVER['HTTP_REFERER']);

    }

    /**
     * -------------------------
     * update procurement status
     * -------------------------
     */

    public function status() {
        $procurement_id = $this -> uri -> segment(3);
        if(empty(trim($procurement_id)) or !is_numeric($procurement_id))
            return redirect($_SERVER['HTTP_REFERER']);

        $status = $_REQUEST['status'];
        $info = array(
            'status'    =>  $status
        );
        $this -> ProcurementModel -> edit($info, $procurement_id);
        $this -> session -> set_flashdata('response', 'Success! Procurement status updated.');
        return redirect($_SERVER['HTTP_REFERER']);

    }

}
