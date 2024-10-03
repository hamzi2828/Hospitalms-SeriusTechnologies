<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class ReferenceModel extends CI_Model {
        
        /**
         * -------------------------
         * SettingModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add references
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'references', $data );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $where
         * edit references
         * -------------------------
         */
        
        public function edit ( $data, $where ) {
            $this -> db -> update ( 'references', $data, $where );
        }
        
        /**
         * -------------------------
         * get references
         * -------------------------
         */
        
        public function get_references () {
            $data = $this -> db -> get ( 'references' );
            return $data -> result ();
        }
        
        /**
         * -------------------------
         * @param $id
         * get references
         * -------------------------
         */
        
        public function get_reference_by_id ( $id ) {
            $data = $this -> db -> get_where ( 'references', array ( 'id' => $id ) );
            return $data -> row ();
        }
        
        /**
         * -------------------------
         * @param $id
         * delete reference
         * -------------------------
         */
        
        public function delete ( $id ) {
            $this -> db -> delete ( 'references', array (
                'id' => $id,
            ) );
        }
        
    }