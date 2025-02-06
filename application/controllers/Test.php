<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

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
        $this -> load -> library ( 'pdf' );
    }

    /**
     * -------------------------
     * @param $title
     * login header template
     * -------------------------
     */

    public function index() {
		print_r('i am here');
        exit;
    }

    public function vaccination_report () {

        if ( !isset( $_REQUEST[ 'report-id' ] ) or !is_numeric ( $_REQUEST[ 'report-id' ] ) or $_REQUEST[ 'report-id' ] < 1 )
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );

        $report_id        = $_REQUEST[ 'report-id' ];
        $data[ 'report' ] = $this -> VaccinationModel -> get_vaccination_by_id ( $report_id );
        $data[ 'lab' ]    = get_lab_sale ( $data[ 'report' ] -> sale_id );
        $data[ 'user' ]   = get_logged_in_user ();
        $html_content     = $this -> load -> view ( '/invoices/vaccination-report', $data, true );
        require_once FCPATH . '/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf( [
                                    'margin_left'   => 5,
                                    'margin_right'  => 5,
                                    'margin_top'    => 41,
                                    'margin_bottom' => 5,
                                    'margin_header' => 5,
                                    'margin_footer' => 5
                                ] );
        $name = 'Xray Report ' . rand () . '.pdf';

        $mpdf -> SetTitle ( strip_tags ( site_name ) );
        $mpdf -> SetAuthor ( site_name );

        $status = get_report_verify_status ( $report_id, 'hmis_xray' );
    

        $mpdf -> SetDisplayMode ( 'real' );
        $mpdf -> WriteHTML ( $html_content );
        $mpdf -> Output ( $name, 'I' );
    }


}
