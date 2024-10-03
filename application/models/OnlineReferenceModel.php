<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class OnlineReferenceModel extends CI_Model {
        
        public function __construct () {
            parent ::__construct ();
        }
        
        public function add ( $data ) {
            $this -> db -> insert ( 'online_references', $data );
            return $this -> db -> affected_rows ();
        }
        
        public function edit ( $data, $where ) {
            $this -> db -> update ( 'online_references', $data, $where );
        }
        
        public function get_references () {
            $data = $this -> db -> get ( 'online_references' );
            return $data -> result ();
        }
        
        public function get_reference_by_id ( $id ) {
            $data = $this -> db -> get_where ( 'online_references', array ( 'id' => $id ) );
            return $data -> row ();
        }
        
        public function delete ( $id ) {
            $this -> db -> delete ( 'online_references', array ( 'id' => $id ) );
        }
        
    }