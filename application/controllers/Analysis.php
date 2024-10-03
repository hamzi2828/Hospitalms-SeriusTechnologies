<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Analysis extends CI_Controller {
        
        /**
         * -------------------------
         * Accounts constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'PatientModel' );
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
         * patients analysis
         * -------------------------
         */
        
        public function patients () {
            $title = site_name . ' - Patients Analysis';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'cash_patients' ] = $this -> PatientModel -> getPatients ( false );
            $data[ 'panel_patients' ] = $this -> PatientModel -> getPatients ( true );
            $data[ 'count_cash_patients' ] = $this -> PatientModel -> countPatients ( false );
            $data[ 'count_panel_patients' ] = $this -> PatientModel -> countPatients ( true );
            $data[ 'panel_wise_patients_line' ] = $this -> PatientModel -> getPanelPatientsLineChart ();
            $data[ 'panel_wise_patients' ] = $this -> PatientModel -> getPanelPatients ();
            $data[ 'city_wise_patients' ] = $this -> PatientModel -> getCityWisePatients ();
            $this -> load -> view ( '/analysis/patients', $data );
            $this -> footer ();
        }
        
    }
