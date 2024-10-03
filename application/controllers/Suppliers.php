<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends CI_Controller {

    /**
     * -------------------------
     * Suppliers constructor.
     * loads helpers, modal or libraries
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
        $this -> is_logged_in();
        $this -> lang -> load ( 'general', 'english' );
        $this -> load -> model('SupplierModel');
        $this -> load -> model('MedicineModel');
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
     * suppliers main page
     * -------------------------
     */

    public function index() {
        $title = site_name . ' - Suppliers';
        $this -> header($title);
        $this -> sidebar();
        $data['suppliers'] = $this -> SupplierModel -> get_suppliers();
        $this -> load -> view('/suppliers/index', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * supplier add main page
     * -------------------------
     */

    public function add() {

        if(isset($_POST['action']) and $_POST['action'] == 'do_add_supplier')
            $this -> do_add_supplier($_POST);

        $title = site_name . ' - Add Supplier';
        $this -> header($title);
        $this -> sidebar();
        $this -> load -> view('/suppliers/add');
        $this -> footer();
	}

    /**
     * -------------------------
     * @param $POST
     * add new suppliers
     * -------------------------
     */

	public function do_add_supplier($POST) {
        $data = filter_var_array($POST, FILTER_SANITIZE_STRING);
        $this -> form_validation -> set_rules('name', 'name', 'required|trim|min_length[1]|xss_clean');
        $this -> form_validation -> set_rules('cnic', 'cnic', 'required|trim|min_length[1]|xss_clean');
        $this -> form_validation -> set_rules('phone', 'phone', 'required|trim|min_length[1]|xss_clean');
        $this -> form_validation -> set_rules('company', 'company', 'required|trim|min_length[1]|xss_clean');
        $this -> form_validation -> set_rules('address', 'address', 'required|trim|min_length[1]|xss_clean');

        if($this -> form_validation -> run() != false) {
            $info = array(
                'user_id'       =>  get_logged_in_user_id(),
                'name'          =>  $data['name'],
                'cnic'          =>  $data['cnic'],
                'phone'         =>  $data['phone'],
                'company'       =>  $data['company'],
                'address'       =>  $data['address'],
            );
            $supplier_id = $this -> SupplierModel -> add($info);
            if($supplier_id > 0) {
                $this -> session -> set_flashdata('response', 'Success! Supplier added.');
                return redirect(base_url('/suppliers/add/'));
            }
            else {
                $this -> session -> set_flashdata('error', 'Error! Supplier not added. Please try again');
                return redirect(base_url('/suppliers/add/'));
            }
        }
    }

    /**
     * -------------------------
     * supplier edit main page
     * -------------------------
     */

    public function edit() {

        $supplier_id = $this -> uri -> segment(3);
        if(empty(trim($supplier_id)) or !is_numeric($supplier_id) or $supplier_id < 1)
            return redirect(base_url('/suppliers/index'));

        if(isset($_POST['action']) and $_POST['action'] == 'do_edit_supplier')
            $this -> do_edit_supplier($_POST);

        $title = site_name . ' - Edit Supplier';
        $this -> header($title);
        $this -> sidebar();
        $data['supplier'] = $this -> SupplierModel -> get_supplier_by_id($supplier_id);
        $this -> load -> view('/suppliers/edit', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * @param $POST
     * update supplier info
     * -------------------------
     */

	public function do_edit_supplier($POST) {
        $data = filter_var_array($POST, FILTER_SANITIZE_STRING);
        $this -> form_validation -> set_rules('name', 'name', 'required|trim|min_length[1]|xss_clean');
        $this -> form_validation -> set_rules('cnic', 'cnic', 'required|trim|min_length[1]|xss_clean');
        $this -> form_validation -> set_rules('phone', 'phone', 'required|trim|min_length[1]|xss_clean');
        $this -> form_validation -> set_rules('company', 'company', 'required|trim|min_length[1]|xss_clean');
        $this -> form_validation -> set_rules('address', 'address', 'required|trim|min_length[1]|xss_clean');

        $supplier_id = $data['supplier_id'];
        if(empty(trim($supplier_id)) or !is_numeric($supplier_id) or $supplier_id < 1)
            return redirect(base_url('/suppliers/index'));

        if($this -> form_validation -> run() != false) {
            $info = array(
                'name'          =>  $data['name'],
                'cnic'          =>  $data['cnic'],
                'phone'         =>  $data['phone'],
                'company'       =>  $data['company'],
                'address'       =>  $data['address'],
                'status'        =>  $data['status']
            );
            $updated = $this -> SupplierModel -> edit($info, $supplier_id);
            if($updated) {
                $this -> session -> set_flashdata('response', 'Success! Supplier updated.');
                return redirect(base_url('/suppliers/edit/'.$supplier_id));
            }
            else {
                $this -> session -> set_flashdata('error', 'Note! Supplier already updated.');
                return redirect(base_url('/suppliers/add/'.$supplier_id));
            }
        }
    }

    /**
     * -------------------------
     * update status of supplier to inactive
     * records are not being deleted permanently
     * -------------------------
     */

    public function delete() {
        $supplier_id = $this -> uri -> segment(3);
        if(empty(trim($supplier_id)) or !is_numeric($supplier_id) or $supplier_id < 1)
            return redirect(base_url('/suppliers/index'));

        $this -> SupplierModel -> delete($supplier_id);
        $this -> session -> set_flashdata('response', 'Success! Supplier updated.');
        return redirect(base_url('/suppliers/index/'));

    }

    /**
     * -------------------------
     * update status of supplier to active
     * -------------------------
     */

    public function reactive() {
        $supplier_id = $this -> uri -> segment(3);
        if(empty(trim($supplier_id)) or !is_numeric($supplier_id) or $supplier_id < 1)
            return redirect(base_url('/suppliers/index'));

        $this -> SupplierModel -> reactive($supplier_id);
        $this -> session -> set_flashdata('response', 'Success! Supplier activated.');
        return redirect(base_url('/suppliers/index/'));

    }

    /**
     * -------------------------
     * supplier stock page
     * stocks provided by supplier
     * -------------------------
     */

    public function stock() {

        $supplier_id = $this -> uri -> segment(3);
        if(empty(trim($supplier_id)) or !is_numeric($supplier_id) or $supplier_id < 1)
            return redirect(base_url('/suppliers/index'));

        $title = site_name . ' - Supplier Stocks';
        $this -> header($title);
        $this -> sidebar();
        $data['stocks'] = $this -> SupplierModel -> get_stocks_by_supplier_id($supplier_id);
        $this -> load -> view('/suppliers/stock', $data);
        $this -> footer();
    }

    /**
     * -------------------------
     * generate invoice of single stock
     * requires stock id and supplier id
     * uses codeigniter dompdf library
     * -------------------------
     */

    public function invoice() {
        $stock_id = $this -> uri -> segment(3);
        $supplier_id = $this -> uri -> segment(4);
        if(!empty(trim($stock_id)) and is_numeric($stock_id) and $stock_id > 0 and !empty(trim($supplier_id)) and is_numeric($supplier_id) and $supplier_id > 0) {
            $stock = $this -> MedicineModel -> get_stock($stock_id);
            $data = array(
                'invoice_number'        =>  $stock -> id,
                'date_generated'        =>  date('l jS F Y'),
                'supplier'              =>  get_supplier($stock -> supplier_id),
                'stock'                 =>  $stock
            );
            $html = $this -> load -> view('suppliers/invoice', $data, true);
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf([
                'margin_left' => 20,
                'margin_right' => 15,
                'margin_top' => 48,
                'margin_bottom' => 25,
                'margin_header' => 10,
                'margin_footer' => 10
            ]);
            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle(site_name);
            $mpdf->SetAuthor(site_name);
            $mpdf->SetWatermarkText(site_name);
            $mpdf->showWatermarkText = true;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->WriteHTML($html);
            $mpdf->Output($stock -> batch.'.pdf','I');
        }
    }

}
