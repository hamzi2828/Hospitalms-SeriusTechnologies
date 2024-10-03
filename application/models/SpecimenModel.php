<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class SpecimenModel extends CI_Model {
        
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
         * save specimen into database
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'specimen', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get specimen
         * -------------------------
         */
        
        public function get_specimen () {
            $specimen = $this -> db -> get ( 'specimen' );
            return $specimen -> result ();
        }
        
        /**
         * -------------------------
         * @param $specimen_id
         * @return mixed
         * get specimen by id
         * -------------------------
         */
        
        public function get_specimen_by_id ( $specimen_id ) {
            $patient = $this -> db -> get_where ( 'specimen', array ( 'id' => $specimen_id ) );
            return $patient -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $specimen_id
         * @return mixed
         * update specimen info
         * -------------------------
         */
        
        public function edit ( $data, $specimen_id ) {
            $this -> db -> update ( 'specimen', $data, array ( 'id' => $specimen_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $specimen_id
         * @return mixed
         * delete specimen info
         * -------------------------
         */
        
        public function delete ( $specimen_id ) {
            $this -> db -> delete ( 'specimen', array ( 'id' => $specimen_id ) );
            return $this -> db -> affected_rows ();
        }
        
    }