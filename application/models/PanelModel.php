<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class PanelModel extends CI_Model {
        
        /**
         * -------------------------
         * PanelModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all panels
         * -------------------------
         */
        
        public function get_panels () {
            $panels = $this -> db -> get_where ( 'panels', array ( 'status' => '1' ) );
            return $panels -> result ();
        }
        
        public function get_all_panels () {
            $panels = $this -> db -> get ( 'panels' );
            return $panels -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get active panels
         * -------------------------
         */
        
        public function get_active_panels ( $not_in = array () ) {
            if ( count ( $not_in ) > 0 )
                $this -> db -> where_not_in ( 'id', $not_in );
            $panels = $this -> db -> get_where ( 'panels', array ( 'status' => '1' ) );
            return $panels -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get active panels by users
         * -------------------------
         */
        
        public function get_active_panels_by_user () {
            $user = get_user ( get_logged_in_user_id () );
            $sql  = "Select * from hmis_panels where status='1'";
            if ( $user -> panel_id > 0 ) {
                $panel_id = $user -> panel_id;
                $sql      .= " and id=$panel_id";
            }
            $panels = $this -> db -> query ( $sql );
            return $panels -> result ();
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * @param $company_id
         * get panel companies by id
         * -------------------------
         * @return mixed
         */
        
        public function get_panel_company ( $panel_id, $company_id ) {
            $panels = $this -> db -> get_where ( 'panel_companies', array (
                'panel_id'   => $panel_id,
                'company_id' => $company_id,
            ) );
            return $panels -> row ();
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * get panel companies by id
         * -------------------------
         * @return mixed
         */
        
        public function get_panel_companies ( $panel_id ) {
            $panels = $this -> db -> get_where ( 'panel_companies', array ( 'panel_id' => $panel_id ) );
            return $panels -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * add panel companies
         * -------------------------
         * @return mixed
         */
        
        public function add_panel_companies ( $data ) {
            $this -> db -> insert ( 'panel_companies', $data );
        }
        
        /**
         * -------------------------
         * @param $data
         * add panel services
         * -------------------------
         * @return mixed
         */
        
        public function add_panel_services ( $data ) {
            $this -> db -> insert ( 'panel_ipd_services', $data );
        }
        
        /**
         * -------------------------
         * @param $data
         * add panel opd services
         * -------------------------
         * @return mixed
         */
        
        public function add_panel_opd_services ( $data ) {
            $this -> db -> insert ( 'panel_opd_services', $data );
        }
        
        /**
         * -------------------------
         * @param $data
         * add panel doctors
         * -------------------------
         * @return mixed
         */
        
        public function add_panel_doctors ( $data ) {
            $this -> db -> insert ( 'panel_doctors', $data );
        }
        
        /**
         * -------------------------
         * @param $service_id
         * delete panel services
         * -------------------------
         * @return mixed
         */
        
        public function delete_ipd_service ( $service_id ) {
            $this -> db -> delete ( 'panel_ipd_services', array ( 'id' => $service_id ) );
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * delete panel services
         * -------------------------
         * @return mixed
         */
        
        public function delete_ipd_panel_services ( $panel_id ) {
            $this -> db -> delete ( 'panel_ipd_services', array ( 'panel_id' => $panel_id ) );
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * delete panel services
         * -------------------------
         * @return mixed
         */
        
        public function delete_opd_panel_services ( $panel_id ) {
            $this -> db -> delete ( 'panel_opd_services', array ( 'panel_id' => $panel_id ) );
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * get panel services
         * -------------------------
         * @return mixed
         */
        
        public function get_panel_ipd_services ( $panel_id ) {
            $services = $this -> db -> get_where ( 'panel_ipd_services', array ( 'panel_id' => $panel_id ) );
            return $services -> result ();
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * @param $service_id
         * get panel service
         * -------------------------
         * @return mixed
         */
        
        public function get_opd_panel_service_discount ( $service_id, $panel_id ) {
            $service = $this -> db -> get_where ( 'panel_opd_services', array (
                'panel_id'   => $panel_id,
                'service_id' => $service_id
            ) );
            return $service -> row ();
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * get panel services
         * -------------------------
         * @return mixed
         */
        
        public function get_panel_opd_services ( $panel_id ) {
            $services = $this -> db -> get_where ( 'panel_opd_services', array ( 'panel_id' => $panel_id ) );
            return $services -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * insert panel discounts
         * -------------------------
         */
        
        public function add_panel ( $data ) {
            $this -> db -> insert ( 'panels', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $member_type
         * @param $company_id
         * @return bool
         * check if panel already added
         * -------------------------
         */
        
        public function check_panel_exists ( $member_type, $company_id ) {
            $exists = $this -> db -> get_where ( 'panels', array (
                'member_type' => $member_type,
                'company_id'  => $company_id
            ) );
            if ( $exists -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * get panel by id
         * -------------------------
         * @return mixed
         */
        
        public function get_panel_by_id ( $panel_id ) {
            $panels = $this -> db -> get_where ( 'panels', array ( 'id' => $panel_id ) );
            return $panels -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $panel_id
         * @return mixed
         * update panel
         * -------------------------
         */
        
        public function edit_panel ( $data, $panel_id ) {
            $this -> db -> update ( 'panels', $data, array ( 'id' => $panel_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $where
         * @return mixed
         * update panel
         * -------------------------
         */
        
        public function update ( $data, $where ) {
            $this -> db -> update ( 'panels', $data, $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * @return mixed
         * delete panel
         * -------------------------
         */
        
        public function delete_panel ( $panel_id ) {
            $this -> db -> delete ( 'panels', array ( 'id' => $panel_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * @return mixed
         * delete panel companies
         * -------------------------
         */
        
        public function delete_panel_companies ( $panel_id ) {
            $this -> db -> delete ( 'panel_companies', array ( 'panel_id' => $panel_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * @return mixed
         * delete panel doctors
         * -------------------------
         */
        
        public function delete_panel_doctors ( $panel_id ) {
            $this -> db -> delete ( 'panel_doctors', array ( 'panel_id' => $panel_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * @return mixed
         * get panel doctors
         * -------------------------
         */
        
        public function get_panel_doctors ( $panel_id ) {
            $doctors = $this -> db -> get_where ( 'panel_doctors', array ( 'panel_id' => $panel_id ) );
            return $doctors -> result ();
        }
        
        /**
         * -------------------------
         * @param $service_id
         * @return mixed
         * delete panel services
         * -------------------------
         */
        
        public function delete_panel_ipd_service ( $service_id ) {
            $this -> db -> delete ( 'panel_ipd_services', array ( 'id' => $service_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $service_id
         * @return mixed
         * delete panel services
         * -------------------------
         */
        
        public function delete_panel_opd_service ( $service_id ) {
            $this -> db -> delete ( 'panel_opd_services', array ( 'id' => $service_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * @return mixed
         * delete panel doctors
         * -------------------------
         */
        
        public function delete_panel_ipd_doctor ( $doctor_id ) {
            $this -> db -> delete ( 'panel_doctors', array ( 'id' => $doctor_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * @param $panel_id
         * get panel doctor discount
         * @return mixed
         * -------------------------
         */
        
        public function get_panel_doctor_discount ( $doctor_id, $panel_id ) {
            $discount = $this -> db -> get_where ( 'panel_doctors', array (
                'panel_id'  => $panel_id,
                'doctor_id' => $doctor_id
            ) );
            return $discount -> row ();
        }
        
        /**
         * -------------------------
         * @param $service_id
         * @param $panel_id
         * get panel opd discount
         * @return mixed
         * -------------------------
         */
        
        public function get_panel_opd_discount ( $service_id, $panel_id ) {
            $discount = $this -> db -> get_where ( 'panel_opd_services', array (
                'panel_id'   => $panel_id,
                'service_id' => $service_id
            ) );
            return $discount -> row ();
        }
        
        public function get_panel_lab_tests ( $panel_id ) {
            $doctors = $this -> db -> get_where ( 'panel_lab_tests', array ( 'panel_id' => $panel_id ) );
            return $doctors -> result ();
        }
        
        public function delete_panel_lab_tests ( $panel_id ) {
            $this -> db -> delete ( 'panel_lab_tests', array ( 'panel_id' => $panel_id ) );
            return $this -> db -> affected_rows ();
        }
        
        public function add_panel_lab_tests ( $data ) {
            $this -> db -> insert ( 'panel_lab_tests', $data );
        }
        
    }