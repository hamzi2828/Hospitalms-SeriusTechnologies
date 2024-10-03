<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class DestinationModel extends CI_Model {
        
        /**
         * -------------------------
         * PatientModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save destinations into database
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'destinations', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get destinations
         * -------------------------
         */
        
        public function get_destinations () {
            $destinations = $this -> db -> get ( 'destinations' );
            return $destinations -> result ();
        }
        
        /**
         * -------------------------
         * @param $destinations_id
         * @return mixed
         * get destinations by id
         * -------------------------
         */
        
        public function get_destinations_by_id ( $destinations_id ) {
            $patient = $this -> db -> get_where ( 'destinations', array ( 'id' => $destinations_id ) );
            return $patient -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $destinations_id
         * @return mixed
         * update destinations info
         * -------------------------
         */
        
        public function edit ( $data, $destinations_id ) {
            $this -> db -> update ( 'destinations', $data, array ( 'id' => $destinations_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $destinations_id
         * @return mixed
         * delete destinations info
         * -------------------------
         */
        
        public function delete ( $destinations_id ) {
            $this -> db -> delete ( 'destinations', array ( 'id' => $destinations_id ) );
            return $this -> db -> affected_rows ();
        }
        
    }