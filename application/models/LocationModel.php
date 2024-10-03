<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class LocationModel extends CI_Model {
        
        /**
         * -------------------------
         * LocationModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save locations into database
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'locations', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get locations
         * -------------------------
         */
        
        public function get_locations () {
            $suppliers = $this -> db -> get ( 'locations' );
            return $suppliers -> result ();
        }
        
        /**
         * -------------------------
         * @param $location_id
         * get location by id
         * -------------------------
         * @return mixed
         */
        
        public function get_location_by_id ( $location_id ) {
            $suppliers = $this -> db -> get_where ( 'locations', array ( 'id' => $location_id ) );
            return $suppliers -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $location_id
         * @return mixed
         * update location info
         * -------------------------
         */
        
        public function edit ( $data, $location_id ) {
            $this -> db -> update ( 'locations', $data, array ( 'id' => $location_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $location_id
         * @return mixed
         * delete location
         * -------------------------
         */
        
        public function delete ( $location_id ) {
            $this -> db -> delete ( 'locations', array ( 'id' => $location_id ) );
            return $this -> db -> affected_rows ();
        }
        
    }