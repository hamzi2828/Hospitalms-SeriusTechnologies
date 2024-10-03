<?php
    
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class OpdReport extends CI_Controller {
        
        /**
         * -------------------------
         * OpdReport constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'DoctorModel' );
            $this -> load -> model ( 'ReportingModel' );
            $this -> load -> model ( 'OPDModel' );
            $this -> load -> model ( 'PanelModel' );
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
         * General report
         * display sale report
         * -------------------------
         */
        
        public function general_report () {
            $title = site_name . ' - General Report Cash';
            $this -> header ( $title );
            $this -> sidebar ();
            
            $user = get_user ( get_logged_in_user_id () );
            if ( $user -> department_id == ADMINISTRATION_DEPT )
                $data[ 'users' ] = $this -> UserModel -> get_active_users_except_logged_in ();
            else
                $data[ 'users' ] = array ();
            
            $data[ 'user' ]     = get_logged_in_user ();
            $data[ 'doctors' ]  = $this -> DoctorModel -> get_doctors ();
            $data[ 'sales' ]    = $this -> ReportingModel -> get_sales_by_sale_grouped ();
            $data[ 'services' ] = $this -> OPDModel -> get_all_services ();
            $this -> load -> view ( '/reporting/opd-report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * General report
         * display sale report
         * -------------------------
         */
        
        public function general_report_panel () {
            $title = site_name . ' - General Report Panel';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ]  = $this -> DoctorModel -> get_doctors ();
            $data[ 'sales' ]    = $this -> ReportingModel -> get_panel_sales_by_sale_grouped ();
            $data[ 'services' ] = $this -> OPDModel -> get_all_services ();
            $data[ 'panels' ]   = $this -> PanelModel -> get_panels ();
            $this -> load -> view ( '/reporting/opd-report-panel', $data );
            $this -> footer ();
        }
        
    }
