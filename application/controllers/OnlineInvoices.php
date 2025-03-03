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

        $this -> session -> set_userdata('online_login_sale_id', $sale_id);
        redirect( base_url( "invoices/get/online/Reports?sale_id=$sale_id" ) );
    }

    
    public function all_added_test_results () {

 
        $online_login_sale_id = $this->session->userdata('online_login_sale_id');
        
        $title = site_name . ' - All Added Test Results';
        $this -> header ( $title );
        $sale_id = (isset($_GET['sale_id']) and $_GET['sale_id'] > 0) ? $_GET['sale_id'] : 0;
        if($online_login_sale_id != $sale_id)
        {
            $this -> session -> set_flashdata('error', 'You are not allowed to access this invoice');
            redirect(base_url().'onlinereports');
            exit;
        }
        $data[ 'sales' ]    = $this -> LabModel -> all_added_test_results_for_online (  $sale_id );
        // $data[ 'locations' ]    = $this -> LocationModel -> get_locations ();
        $this -> load -> view ( '/online_Invoices/added-test-results', $data );
        $this -> footer ();
    }



    public function print_lab_single_invoice_lab () {

        if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
            $link = "https";
        else $link = "http";

        // Here append the common URL characters.
        $link .= "://";

        // Append the host(domain name, ip) to the URL.
        $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];

        if ( strpos ( $link, ',qrcode=true' ) !== false ) {
            return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
        }

        $id      = $this -> input -> get ( 'id', true );
        $sale_id = $this -> input -> get ( 'sale-id', true );
        if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );

        $data[ 'sale_id' ]               = $sale_id;
        $data[ 'patient_id' ]            = get_patient_id_by_sale_id ( $sale_id );
        $data[ 'patient' ]               = get_patient ( $data[ 'patient_id' ] );
        $data[ 'user' ]                  = get_user ( get_logged_in_user_id () );
        $data[ 'sale' ]                  = $this -> LabModel -> get_lab_sale ( $sale_id );
        $data[ 'tests' ]                 = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
        $data[ 'previous_test_results' ] = get_previous_test_results ( $sale_id, @$_REQUEST[ 'parent-id' ] );
        $data[ 'remarks' ]               = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
        $data[ 'airline' ]               = $this -> LabModel -> get_airline_details ( $sale_id );
        $data[ 'online_report_info' ]    = $this -> LabModel -> online_test_invoice ( $sale_id );
        $data[ 'test_result_image' ]     = $this -> LabModel -> get_test_result_image ( $sale_id, $_REQUEST[ 'parent-id' ] );
        $html_content                    = $this -> load -> view ( '/invoices/lab-result-invoice-lab', $data, true );
        require_once FCPATH . '/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf( [
                                    'margin_left'   => 10,
                                    'margin_right'  => 10,
                                    'margin_top'    => 41,
                                    'margin_bottom' => 5,
                                    'margin_header' => 5,
                                    'margin_footer' => 5
                                ] );

        $mpdf -> SetTitle ( strip_tags ( site_name ) );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetDisplayMode ( 'real' );
        $mpdf -> WriteHTML ( $html_content );
        $mpdf -> Output ( 'IPD-Lab-test-result.pdf', 'I' );
    }


    public function complete_tests_results_report () {

        $sale_id = $this -> input -> get ( 'sale-id', true );
        if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );

        $data[ 'sale_id' ]            = $sale_id;
        $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
        $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] ); 
        $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
        $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
        $data[ 'tests' ]              = $this -> LabModel -> get_lab_sale_parent_tests_by_sale_id ( $sale_id );
        $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
        $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
        $html_content                 = $this -> load -> view ( '/invoices/complete-tests-results-report', $data, true );
        require_once FCPATH . '/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf( [
                                    'margin_left'   => 10,
                                    'margin_right'  => 10,
                                    'margin_top'    => 41,
                                    'margin_bottom' => 5,
                                    'margin_header' => 5,
                                    'margin_footer' => 5
                                ] );

        $mpdf -> SetTitle ( strip_tags ( site_name ) );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetDisplayMode ( 'real' );
        $mpdf -> WriteHTML ( $html_content );
        $mpdf -> Output ( 'Test-results-report' . rand () . '.pdf', 'I' );
    }

    
    public function stool_examination_report () {

        if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
            $link = "https";
        else $link = "http";

        // Here append the common URL characters.
        $link .= "://";

        // Append the host(domain name, ip) to the URL.
        $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];

        if ( strpos ( $link, ',qrcode=true' ) !== false ) {
            return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
        }

        $id      = $this -> input -> get ( 'id', true );
        $sale_id = $this -> input -> get ( 'sale-id', true );
        if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );

        $data[ 'sale_id' ]            = $sale_id;
        $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
        $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
        $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
        $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
        $data[ 'tests' ]              = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
        $data[ 'remarks' ]            = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
        $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
        $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
        $html_content                 = $this -> load -> view ( '/invoices/stool-examination-report', $data, true );
        require_once FCPATH . '/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf( [
                                    'margin_left'   => 10,
                                    'margin_right'  => 10,
                                    'margin_top'    => 35,
                                    'margin_bottom' => 25,
                                    'margin_header' => 0,
                                    'margin_footer' => 10
                                ] );

        $mpdf -> SetTitle ( strip_tags ( site_name ) );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetDisplayMode ( 'real' );
        $mpdf -> WriteHTML ( $html_content );
        $mpdf -> Output ( 'Stool-Examination-Report.pdf', 'I' );
    }

    public function ascitic_fluid_analysis () {

        if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
            $link = "https";
        else $link = "http";

        // Here append the common URL characters.
        $link .= "://";

        // Append the host(domain name, ip) to the URL.
        $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];

        if ( strpos ( $link, ',qrcode=true' ) !== false ) {
            return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
        }

        $id      = $this -> input -> get ( 'id', true );
        $sale_id = $this -> input -> get ( 'sale-id', true );
        if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );

        $data[ 'sale_id' ]            = $sale_id;
        $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
        $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
        $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
        $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
        $data[ 'tests' ]              = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
        $data[ 'remarks' ]            = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
        $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
        $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
        $html_content                 = $this -> load -> view ( '/invoices/ascitic-fluid-analysis-report', $data, true );
        require_once FCPATH . '/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf( [
                                    'margin_left'   => 10,
                                    'margin_right'  => 10,
                                    'margin_top'    => 35,
                                    'margin_bottom' => 25,
                                    'margin_header' => 0,
                                    'margin_footer' => 10
                                ] );

        $mpdf -> SetTitle ( strip_tags ( site_name ) );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetDisplayMode ( 'real' );
        $mpdf -> WriteHTML ( $html_content );
        $mpdf -> Output ( 'Ascitic-Fluid-Analysis.pdf', 'I' );
    }

    public function cp_peripheral_film_report () {

        if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
            $link = "https";
        else $link = "http";

        // Here append the common URL characters.
        $link .= "://";

        // Append the host(domain name, ip) to the URL.
        $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];

        if ( strpos ( $link, ',qrcode=true' ) !== false ) {
            return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
        }

        $id      = $this -> input -> get ( 'id', true );
        $sale_id = $this -> input -> get ( 'sale-id', true );
        if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );

        $data[ 'sale_id' ]            = $sale_id;
        $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
        $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
        $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
        $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
        $data[ 'tests' ]              = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
        $data[ 'remarks' ]            = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
        $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
        $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
        $html_content                 = $this -> load -> view ( '/invoices/cp-peripheral-film-report', $data, true );
        require_once FCPATH . '/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf( [
                                    'margin_left'   => 10,
                                    'margin_right'  => 10,
                                    'margin_top'    => 35,
                                    'margin_bottom' => 25,
                                    'margin_header' => 0,
                                    'margin_footer' => 10
                                ] );

        $mpdf -> SetTitle ( strip_tags ( site_name ) );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetDisplayMode ( 'real' );
        $mpdf -> WriteHTML ( $html_content );
        $mpdf -> Output ( 'CP-Peripheral-Film-Report.pdf', 'I' );
    }

    public function semen_analysis_report () {

        if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
            $link = "https";
        else $link = "http";

        // Here append the common URL characters.
        $link .= "://";

        // Append the host(domain name, ip) to the URL.
        $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];

        if ( strpos ( $link, ',qrcode=true' ) !== false ) {
            return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
        }

        $id      = $this -> input -> get ( 'id', true );
        $sale_id = $this -> input -> get ( 'sale-id', true );
        if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );

        $data[ 'sale_id' ]            = $sale_id;
        $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
        $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
        $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
        $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
        $data[ 'tests' ]              = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
        $data[ 'remarks' ]            = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
        $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
        $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
        $html_content                 = $this -> load -> view ( '/invoices/semen-analysis-report', $data, true );
        require_once FCPATH . '/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf( [
                                    'margin_left'   => 10,
                                    'margin_right'  => 10,
                                    'margin_top'    => 35,
                                    'margin_bottom' => 25,
                                    'margin_header' => 0,
                                    'margin_footer' => 10
                                ] );

        $mpdf -> SetTitle ( strip_tags ( site_name ) );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetDisplayMode ( 'real' );
        $mpdf -> WriteHTML ( $html_content );
        $mpdf -> Output ( 'Semen-Analysis-Report.pdf', 'I' );
    }
    public function urine_re_analysis_report () {

        if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
            $link = "https";
        else $link = "http";

        // Here append the common URL characters.
        $link .= "://";

        // Append the host(domain name, ip) to the URL.
        $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];

        if ( strpos ( $link, ',qrcode=true' ) !== false ) {
            return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
        }

        $id      = $this -> input -> get ( 'id', true );
        $sale_id = $this -> input -> get ( 'sale-id', true );
        if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );

        $data[ 'sale_id' ]            = $sale_id;
        $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
        $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
        $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
        $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
        $data[ 'tests' ]              = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
        $data[ 'remarks' ]            = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
        $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
        $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
        $html_content                 = $this -> load -> view ( '/invoices/urine-re-analysis-report', $data, true );
        require_once FCPATH . '/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf( [
                                    'margin_left'   => 10,
                                    'margin_right'  => 10,
                                    'margin_top'    => 35,
                                    'margin_bottom' => 25,
                                    'margin_header' => 0,
                                    'margin_footer' => 10
                                ] );

        $mpdf -> SetTitle ( strip_tags ( site_name ) );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetDisplayMode ( 'real' );
        $mpdf -> WriteHTML ( $html_content );
        $mpdf -> Output ( 'Urine-RE-Analysis-Report.pdf', 'I' );
    }
    public function csf_analysis_report () {

        if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
            $link = "https";
        else $link = "http";

        // Here append the common URL characters.
        $link .= "://";

        // Append the host(domain name, ip) to the URL.
        $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];

        if ( strpos ( $link, ',qrcode=true' ) !== false ) {
            return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
        }

        $id      = $this -> input -> get ( 'id', true );
        $sale_id = $this -> input -> get ( 'sale-id', true );
        if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );

        $data[ 'sale_id' ]            = $sale_id;
        $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
        $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
        $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
        $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
        $data[ 'tests' ]              = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
        $data[ 'remarks' ]            = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
        $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
        $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
        $html_content                 = $this -> load -> view ( '/invoices/csf-analysis-report', $data, true );
        require_once FCPATH . '/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf( [
                                    'margin_left'   => 10,
                                    'margin_right'  => 10,
                                    'margin_top'    => 35,
                                    'margin_bottom' => 25,
                                    'margin_header' => 0,
                                    'margin_footer' => 10
                                ] );

        $mpdf -> SetTitle ( strip_tags ( site_name ) );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetDisplayMode ( 'real' );
        $mpdf -> WriteHTML ( $html_content );
        $mpdf -> Output ( 'CSF-Analysis-Report.pdf', 'I' );
    }

    public function pericardial_fluid_report () {

        if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
            $link = "https";
        else $link = "http";

        // Here append the common URL characters.
        $link .= "://";

        // Append the host(domain name, ip) to the URL.
        $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];

        if ( strpos ( $link, ',qrcode=true' ) !== false ) {
            return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
        }

        $id      = $this -> input -> get ( 'id', true );
        $sale_id = $this -> input -> get ( 'sale-id', true );
        if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );

        $data[ 'sale_id' ]            = $sale_id;
        $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
        $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
        $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
        $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
        $data[ 'tests' ]              = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
        $data[ 'remarks' ]            = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
        $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
        $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
        $html_content                 = $this -> load -> view ( '/invoices/pericardial-fluid-report', $data, true );
        require_once FCPATH . '/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf( [
                                    'margin_left'   => 10,
                                    'margin_right'  => 10,
                                    'margin_top'    => 35,
                                    'margin_bottom' => 25,
                                    'margin_header' => 0,
                                    'margin_footer' => 10
                                ] );

        $mpdf -> SetTitle ( strip_tags ( site_name ) );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetAuthor ( site_name );
        $mpdf -> SetDisplayMode ( 'real' );
        $mpdf -> WriteHTML ( $html_content );
        $mpdf -> Output ( 'Pericardial-Fluid-Report.pdf', 'I' );
    }
}
