<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class AirlineModel extends CI_Model {
        
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
         * save airlines into database
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'airlines', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get airlines
         * -------------------------
         */
        
        public function get_airlines () {
            $airlines = $this -> db -> get ( 'airlines' );
            return $airlines -> result ();
        }
        
        /**
         * -------------------------
         * @param $airlines_id
         * @return mixed
         * get airlines by id
         * -------------------------
         */
        
        public function get_airlines_by_id ( $airlines_id ) {
            $patient = $this -> db -> get_where ( 'airlines', array ( 'id' => $airlines_id ) );
            return $patient -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $airlines_id
         * @return mixed
         * update airlines info
         * -------------------------
         */
        
        public function edit ( $data, $airlines_id ) {
            $this -> db -> update ( 'airlines', $data, array ( 'id' => $airlines_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $airlines_id
         * @return mixed
         * delete airlines info
         * -------------------------
         */
        
        public function delete ( $airlines_id ) {
            $this -> db -> delete ( 'airlines', array ( 'id' => $airlines_id ) );
            return $this -> db -> affected_rows ();
        }
        
    }