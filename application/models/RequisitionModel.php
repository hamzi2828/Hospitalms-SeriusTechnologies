<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class RequisitionModel extends CI_Model {
        
        /**
         * -------------------------
         * RequisitionModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all requisitions
         * -------------------------
         */
        
        public function get_requisitions () {
            $this -> db -> order_by ( 'id', 'DESC' );
            $procurements = $this -> db -> get_where ( 'requisitions', array ( 'request_by' => get_logged_in_user_id () ) );
            return $procurements -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * insert requisitions
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'requisitions', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $requisition_id
         * get requisitions by id
         * -------------------------
         * @return mixed
         */
        
        public function get_requisition_by_id ( $requisition_id ) {
            $requisitions = $this -> db -> get_where ( 'requisitions', array ( 'id' => $requisition_id ) );
            return $requisitions -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $requisition_id
         * @return mixed
         * update requisitions
         * -------------------------
         */
        
        public function edit ( $data, $requisition_id ) {
            $this -> db -> update ( 'requisitions', $data, array ( 'id' => $requisition_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $requisition_id
         * @return mixed
         * delete requisitions permanently
         * -------------------------
         */
        
        public function delete ( $requisition_id ) {
            $this -> db -> delete ( 'requisitions', array ( 'id' => $requisition_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * insert requisitions demands
         * -------------------------
         */
        
        public function add_demands ( $data ) {
            $this -> db -> insert ( 'requisitions_demand', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all requisitions demands
         * -------------------------
         */
        
        public function get_facility_manager_requisition_demands () {
            $status = !empty( $this -> input -> get ( 'status' ) ) ? $this -> input -> get ( 'status' ) : 'pending';
            $this -> db -> order_by ( 'id', 'DESC' );
            $demands = $this -> db -> get_where ( 'requisitions_demand', array ( 'status' => $status ) );
            return $demands -> result ();
        }
        
        public function get_requisition_demands () {
            $this -> db -> order_by ( 'id', 'DESC' );
            $demands = $this -> db -> get_where ( 'requisitions_demand', array ( 'request_from' => get_logged_in_user_id () ) );
            return $demands -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all requisitions demands
         * -------------------------
         */
        
        public function count_requisition_demands () {
            $status = !empty( $this -> input -> get ( 'status' ) ) ? $this -> input -> get ( 'status' ) : 'pending';
            $demands = $this -> db -> query ( "Select COUNT(*) as total from hmis_requisitions_demand WHERE status='$status'" );
            return $demands -> row () -> total;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all requisitions demands
         * -------------------------
         */
        
        public function get_requisition_demands_store () {
            $this -> db -> order_by ( 'id', 'DESC' );
            $demands = $this -> db -> get_where ( 'requisitions_demand', array ( 'status' => 'approved' ) );
            return $demands -> result ();
        }
        
        public function get_demand_requisitions_by_requisition_id ( $requisition_id ) {
            $demands = $this -> db -> get_where ( 'requisitions_demand', array ( 'requisitions_id' => $requisition_id ) );
            return $demands -> result ();
        }
        
        public function get_requisitions_by_requisition_id ( $requisition_id ) {
            $demands = $this -> db -> get_where ( 'requisitions', array ( 'requisition_id' => $requisition_id ) );
            return $demands -> result ();
        }
        
        public function get_requisition_demand_by_id ( $id ) {
            $demands = $this -> db -> get_where ( 'requisitions_demand', array ( 'id' => $id ) );
            return $demands -> row ();
        }
        
        public function edit_demands ( $info, $where ) {
            $this -> db -> update ( 'requisitions_demand', $info, $where );
        }
        
        public function delete_demand ( $id ) {
            $this -> db -> delete ( 'requisitions_demand', array ( 'id' => $id ) );
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all requisitions demands
         * -------------------------
         */
        
        public function count_requisition_demands_store () {
            $demands = $this -> db -> query ( "Select COUNT(*) as total from hmis_requisitions_demand where status='approved'" );
            return $demands -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $requisition_id
         * @return mixed
         * update requisitions
         * -------------------------
         */
        
        public function update_demands ( $data, $requisition_id ) {
            $this -> db -> update ( 'requisitions_demand', $data, array ( 'id' => $requisition_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $requisition_id
         * @return mixed
         * delete requisitions permanently
         * -------------------------
         */
        
        public function delete_demands ( $requisition_id ) {
            $this -> db -> delete ( 'requisitions_demand', array ( 'id' => $requisition_id ) );
            return $this -> db -> affected_rows ();
        }
        
    }