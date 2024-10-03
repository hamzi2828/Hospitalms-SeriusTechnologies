<?php
    
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class ChReport extends CI_Controller {
        
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
         * General report culture
         * display sale report
         * -------------------------
         */
        
        public function general_report_culture () {
            $title = site_name . ' - General Report (Culture)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ]   = $title;
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'sales' ]   = $this -> ReportingModel -> get_culture_reporting ();
            $this -> load -> view ( '/reporting/general-report-culture', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * General report histopathology
         * display sale report
         * -------------------------
         */
        
        public function general_report_histopathology () {
            $title = site_name . ' - General Report (Histopathology)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ]   = $title;
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'sales' ]   = $this -> ReportingModel -> get_histopathology_reporting ();
            $this -> load -> view ( '/reporting/general-report-histopathology', $data );
            $this -> footer ();
        }
        
    }
