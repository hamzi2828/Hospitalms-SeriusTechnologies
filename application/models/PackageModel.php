<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class PackageModel extends CI_Model {
        
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
         * save  lab packages into database
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'lab_packages', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save packages tests into database
         * -------------------------
         */
        
        public function addPackageTests ( $data ) {
            $this -> db -> insert ( 'lab_package_tests', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get  lab packages
         * -------------------------
         */
        
        public function get_lab_packages () {
            $lab_packages = $this -> db -> get ( 'lab_packages' );
            return $lab_packages -> result ();
        }
        
        /**
         * -------------------------
         * @param $lab_packages_id
         * @return mixed
         * get lab package tests
         * -------------------------
         */
        
        public function get_lab_package_tests ( $lab_packages_id ) {
            $lab_packages = $this -> db -> get_where ( 'lab_package_tests', array ( 'package_id' => $lab_packages_id ) );
            return $lab_packages -> result ();
        }
        
        /**
         * -------------------------
         * @param $package_id
         * @return mixed
         * get lab package tests
         * -------------------------
         */
        
        public function get_lab_package_test_ids ( $package_id ) {
            $package = $this -> db -> query ( "Select GROUP_CONCAT(test_id) as test_ids from hmis_lab_package_tests where package_id=$package_id" );
            $tests = $package -> row () -> test_ids;
            if ( !empty( trim ( $tests ) ) )
                return explode ( ',', $tests );
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @param $lab_packages_id
         * @return mixed
         * get  lab packages by id
         * -------------------------
         */
        
        public function get_lab_packages_by_id ( $lab_packages_id ) {
            $patient = $this -> db -> get_where ( 'lab_packages', array ( 'id' => $lab_packages_id ) );
            return $patient -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $where
         * @return mixed
         * update  lab packages info
         * -------------------------
         */
        
        public function edit ( $data, $where ) {
            $this -> db -> update ( 'lab_packages', $data, $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $id
         * @return mixed
         * get lab package test by id
         * -------------------------
         */
        
        public function get_lab_package_test_by_id ( $id ) {
            $patient = $this -> db -> get_where ( 'lab_package_tests', array ( 'id' => $id ) );
            return $patient -> row ();
        }
        
        /**
         * -------------------------
         * @param $id
         * @return mixed
         * delete  lab packages info
         * -------------------------
         */
        
        public function delete_lab_package_test ( $id ) {
            $this -> db -> delete ( 'lab_package_tests', array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $lab_packages_id
         * @return mixed
         * delete  lab packages info
         * -------------------------
         */
        
        public function delete ( $lab_packages_id ) {
            $this -> db -> delete ( 'lab_packages', array ( 'id' => $lab_packages_id ) );
            return $this -> db -> affected_rows ();
        }
        
    }