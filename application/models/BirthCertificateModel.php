<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class BirthCertificateModel extends CI_Model {
        
        /**
         * -------------------------
         * MemberModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get certificates
         * -------------------------
         */
        
        public function get_certificates () {
            $this -> db -> order_by ( 'id', 'DESC' );
            $members = $this -> db -> get ( 'birth_certificates' );
            return $members -> result ();
        }
        
        /**
         * -------------------------
         * @param $certificate_id
         * get certificate by id
         * @return mixed
         * -------------------------
         */
        
        public function get_certificate_by_id ( $certificate_id ) {
            $member = $this -> db -> get_where ( 'birth_certificates', array ( 'id' => $certificate_id ) );
            return $member -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add certificate
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'birth_certificates', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $where
         * @return mixed
         * update certificate
         * -------------------------
         */
        
        public function edit ( $data, $where ) {
            $this -> db -> update ( 'birth_certificates', $data, $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $certificate_id
         * @return mixed
         * delete certificate
         * -------------------------
         */
        
        public function delete ( $certificate_id ) {
            $this -> db -> delete ( 'birth_certificates', array ( 'id' => $certificate_id ) );
            return $this -> db -> affected_rows ();
        }
        
    }