<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Dashboard extends CI_Controller {
        
        /**
         * -------------------------
         * Login constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'GraphModel' );
            $this -> load -> model ( 'MedicineModel' );
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
         * -------------------------
         * dashboard main page
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - Dashboard';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/dashboard/index' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * dashboard main page
         * -------------------------
         */
        
        public function stats_dashboard () {
            $title = site_name . ' - Stats Dashboard';
            $this -> header ( $title );
            $this -> sidebar ();
            
            $currentMonth = date ( 'm-Y' );
            $previousMonth = date ( "m-Y", strtotime ( "-1 months" ) );
            
            $data[ 'opd_sale_this_month' ] = $this -> GraphModel -> get_opd_sales_by_month ( $currentMonth );
            $data[ 'opd_sale_prev_month' ] = $this -> GraphModel -> get_opd_sales_by_month ( $previousMonth );
            
            $data[ 'ipd_sale_this_month' ] = $this -> GraphModel -> get_ipd_sales_by_month ( $currentMonth );
            $data[ 'ipd_sale_prev_month' ] = $this -> GraphModel -> get_ipd_sales_by_month ( $previousMonth );
            
            $data[ 'consultancy_sale_this_month' ] = $this -> GraphModel -> get_consultancy_sales_by_month ( $currentMonth );
            $data[ 'consultancy_sale_prev_month' ] = $this -> GraphModel -> get_consultancy_sales_by_month ( $previousMonth );
            
            $data[ 'pharmacy_sale_this_month' ] = $this -> GraphModel -> get_pharmacy_sales_by_month ( $currentMonth );
            $data[ 'pharmacy_sale_prev_month' ] = $this -> GraphModel -> get_pharmacy_sales_by_month ( $previousMonth );
            
            $data[ 'dialysis_sale_this_month' ] = $this -> GraphModel -> get_dialysis_sales_by_month ( $currentMonth );
            $data[ 'dialysis_sale_prev_month' ] = $this -> GraphModel -> get_dialysis_sales_by_month ( $previousMonth );
            
            $data[ 'lab_sale_this_month' ] = $this -> GraphModel -> get_lab_sales_by_month ( $currentMonth );
            $data[ 'lab_sale_prev_month' ] = $this -> GraphModel -> get_lab_sales_by_month ( $previousMonth );
            
            $data[ 'xray_sale_this_month' ] = $this -> GraphModel -> get_xray_sales_by_month ( $currentMonth );
            $data[ 'xray_sale_prev_month' ] = $this -> GraphModel -> get_xray_sales_by_month ( $previousMonth );
            
            $data[ 'ultrasound_sale_this_month' ] = $this -> GraphModel -> get_ultrasound_sales_by_month ( $currentMonth );
            $data[ 'ultrasound_sale_prev_month' ] = $this -> GraphModel -> get_ultrasound_sales_by_month ( $previousMonth );
            
            $data[ 'opd_graph' ] = $this -> GraphModel -> get_opd_sales_chart ();
            $data[ 'ipd_graph' ] = $this -> GraphModel -> get_ipd_sales_chart ();
            $data[ 'pharmacy' ] = $this -> GraphModel -> get_sale_reports ();
            $data[ 'consultancies' ] = $this -> GraphModel -> get_consultancies_sales_chart ();
            $data[ 'lab' ] = $this -> GraphModel -> get_lab_sales_chart ();
            $data[ 'dialysis' ] = $this -> GraphModel -> get_opd_sales_chart_by_type ( 'dialysis' );
            $data[ 'xray' ] = $this -> GraphModel -> get_opd_sales_chart_by_type ( 'xray' );
            $data[ 'ultrasound' ] = $this -> GraphModel -> get_opd_sales_chart_by_type ( 'ultrasound' );
            $this -> load -> view ( '/dashboard/index_2', $data );
            $this -> footer ();
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
         * ---------------------
         * logout user
         * redirect to main page
         * ---------------------
         */
        
        public function Logout () {
            
            $this -> MedicineModel -> clear_medicine_sale ( get_logged_in_user_id () );
            
            $log = array (
                'user_id'    => get_logged_in_user_id (),
                'action'     => 'logged_out',
                'log'        => json_encode ( get_logged_in_user () ),
                'date_added' => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'user_logs', $log );
            
            $this -> session -> sess_destroy ();
            return redirect ( base_url () );
        }
        
    }
