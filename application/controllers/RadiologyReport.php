<?php
    
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class RadiologyReport extends CI_Controller {
        
        /**
         * -------------------------
         * RadiologyReport constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'DoctorModel' );
            $this -> load -> model ( 'ReportingModel' );
        }
        
        /**
         * -------------------------
         * @param $title
         * header template
         * -------------------------
         */
        
        public function header ( $title ) {
            $data[ 'title' ] = $title;
            $this -> load -> view ( '/includes/admin/header', $data );
        }
        
        /**
         * -------------------------
         * sidebar template
         * -------------------------
         */
        
        public function sidebar () {
            $this -> load -> view ( '/includes/admin/general-sidebar' );
        }
        
        /**
         * -------------------------
         * footer template
         * -------------------------
         */
        
        public function footer () {
            $this -> load -> view ( '/includes/admin/footer' );
        }
        
        /**
         * ---------------------
         * checks if user is logged in
         * ---------------------
         */
        
        public function is_logged_in () {
            if ( empty( $this -> session -> userdata ( 'user_data' ) ) ) {
                return redirect ( base_url () );
            }
        }
        
        /**
         * -------------------------
         * General report xray
         * display sale report
         * -------------------------
         */
        
        public function general_report_xray () {
            $title = site_name . ' - General Report X-Ray';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ]   = $title;
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'sales' ]   = $this -> ReportingModel -> get_xray_reporting ();
            $this -> load -> view ( '/reporting/general-report-xray', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * General report ultrasound
         * display sale report
         * -------------------------
         */
        
        public function general_report_ultrasound () {
            $title = site_name . ' - General Report Ultrasound';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ]   = $title;
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'sales' ]   = $this -> ReportingModel -> get_ultrasound_reporting ();
            $this -> load -> view ( '/reporting/general-report-ultrasound', $data );
            $this -> footer ();
        }
        
        public function general_report_ct_scan () {
            $title = site_name . ' - General Report (CT-Scan)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ]   = $title;
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'sales' ]   = $this -> ReportingModel -> get_ct_scan_reporting ();
            $this -> load -> view ( '/reporting/general-report-ct-scan', $data );
            $this -> footer ();
        }
        
        public function general_report_mri () {
            $title = site_name . ' - General Report (MRI)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ]   = $title;
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'sales' ]   = $this -> ReportingModel -> get_mri_reporting ();
            $this -> load -> view ( '/reporting/general-report-mri', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * General report ultrasound
         * display sale report
         * -------------------------
         */
        
        public function general_report_echo () {
            $title = site_name . ' - General Report ECHO';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'sales' ] = $this -> ReportingModel -> get_echo_reporting ();
            $this -> load -> view ( '/reporting/general-report-echo', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * General report ultrasound
         * display sale report
         * -------------------------
         */
        
        public function general_report_ecg () {
            $title = site_name . ' - General Report ECG';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'sales' ] = $this -> ReportingModel -> get_ecg_reporting ();
            $this -> load -> view ( '/reporting/general-report-ecg', $data );
            $this -> footer ();
        }
        
    }
