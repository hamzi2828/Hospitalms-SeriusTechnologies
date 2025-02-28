<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OnlineInvoices extends CI_Controller {

    /**
     * -------------------------
     * Login constructor.
     * loads helpers, modal or libraries
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
        // $this -> is_logged_in();
        // $this -> lang -> load ( 'general', 'english' );
        // $this -> load -> model('LoginModel');
        $this -> load -> model ( 'VaccinationModel' );
        $this -> load -> model('SettingModel');
        $this -> load -> model ( 'LabModel' );
        $this -> load -> model ( 'SectionModel' );
        $this -> load -> model ( 'LocationModel' );
        $this -> load -> library ( 'pdf' );
    }
    

    /**
     * -------------------------
     * @param $title
     * login header template
     * -------------------------
     */

     public function header($title) {
        $data['title'] = $title;
		$data[ 'background' ] = $this -> SettingModel -> getBackground ();
		$data[ 'logo' ] = $this -> SettingModel -> getLogo ();
        $this -> load -> view('/includes/login/header', $data);
    }

    /**
     * -------------------------
     * login footer template
     * -------------------------
     */

    public function footer() {
        $this -> load -> view('/includes/login/footer');
    }


    public function index() {
        
        if(isset($_POST['action']) and $_POST['action'] == 'do_verify_invoice_info')
        {
            $this -> do_verify_invoice_info();
        }
        

        $title = site_name . ' - Login';
        $this -> header($title);
        $this -> load -> view ( '/online_Invoices/index' );

        $this -> footer();

    }

    public function do_verify_invoice_info () {

        $sale_id = $_POST['sale_id'];
        $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice_check_password ();
        if(empty($data[ 'online_report_info' ]))
        {
            $this -> session -> set_flashdata('error', 'Wrong Invoice No. or Password');
            redirect(base_url().'onlinereports');
            exit;
        }

        redirect( base_url( "invoices/get/online/Reports?sale_id=$sale_id" ) );
    }

    
    public function all_added_test_results () {

        $title = site_name . ' - All Added Test Results';
        $this -> header ( $title );
        $sale_id = (isset($_GET['sale_id']) and $_GET['sale_id'] > 0) ? $_GET['sale_id'] : 0;
        $data[ 'sales' ]    = $this -> LabModel -> all_added_test_results_for_online (  $sale_id );
        // $data[ 'locations' ]    = $this -> LocationModel -> get_locations ();
        $this -> load -> view ( '/online_Invoices/added-test-results', $data );
        $this -> footer ();
    }


}
