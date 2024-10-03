<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class RemarksModel extends CI_Model {
        
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
         * save remarks into database
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'remarks', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get remarks
         * -------------------------
         */
        
        public function get_remarks () {
            $remarks = $this -> db -> get ( 'remarks' );
            return $remarks -> result ();
        }
        
        /**
         * -------------------------
         * @param $remarks_id
         * @return mixed
         * get remarks by id
         * -------------------------
         */
        
        public function get_remarks_by_id ( $remarks_id ) {
            $patient = $this -> db -> get_where ( 'remarks', array ( 'id' => $remarks_id ) );
            return $patient -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $remarks_id
         * @return mixed
         * update remarks info
         * -------------------------
         */
        
        public function edit ( $data, $remarks_id ) {
            $this -> db -> update ( 'remarks', $data, array ( 'id' => $remarks_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $remarks_id
         * @return mixed
         * delete remarks info
         * -------------------------
         */
        
        public function delete ( $remarks_id ) {
            $this -> db -> delete ( 'remarks', array ( 'id' => $remarks_id ) );
            return $this -> db -> affected_rows ();
        }
        
    }