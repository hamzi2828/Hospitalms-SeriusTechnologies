<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class FacilityManager extends CI_Controller {
        
        /**
         * -------------------------
         * Requisition constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'RequisitionModel' );
            $this -> load -> model ( 'StoreModel' );
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
         * Requisition requests main page
         * -------------------------
         */
        
        public function requests () {
            $title = site_name . ' - Requisition Requests';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'requests' ] = $this -> StoreModel -> get_requests_facility_manager ();
            $data[ 'access' ]   = get_user_access ( get_logged_in_user_id () );
            $this -> load -> view ( '/requisitions/requests', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Requisition demands main page
         * -------------------------
         */
        
        public function demands () {
            $title = site_name . ' - Requisition Demands';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'requests' ] = $this -> RequisitionModel -> get_facility_manager_requisition_demands ();
            $data[ 'access' ]   = get_user_access ( get_logged_in_user_id () );
            $this -> load -> view ( '/requisitions/requisitions-demands', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * update demands status
         * -------------------------
         */
        
        public function status () {
            $requisition_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $requisition_id ) ) or !is_numeric ( $requisition_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $status = $_REQUEST[ 'status' ];
            $info   = array (
                'status'      => $status,
                'approved_by' => get_logged_in_user_id ()
            );
            $this -> RequisitionModel -> update_demands ( $info, $requisition_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Requisition status updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * delete requisitions
         * -------------------------
         */
        
        public function delete () {
            $procurement_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $procurement_id ) ) or !is_numeric ( $procurement_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> RequisitionModel -> delete_demands ( $procurement_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Requisition deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
    }
