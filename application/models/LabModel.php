<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class LabModel extends CI_Model {
        
        /**
         * -------------------------
         * LabModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save tests into database
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'tests', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save online tests invoice info into database
         * -------------------------
         */
        
        public function add_online_invoice_info ( $data ) {
            $this -> db -> insert ( 'online_test_invoice', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save specimen info into database
         * -------------------------
         */
        
        public function add_specimen_info ( $data ) {
            $this -> db -> insert ( 'test_sale_specimen', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save tests result into database
         * -------------------------
         */
        
        public function do_add_test_results ( $data ) {
            $this -> db -> insert ( 'test_results', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save tests result remarks into database
         * -------------------------
         */
        
        public function do_add_test_result_remarks ( $data ) {
            $this -> db -> insert ( 'test_result_remarks', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * verify tests results
         * -------------------------
         */
        
        public function do_lab_result_verify ( $data ) {
            $this -> db -> insert ( 'lab_results_verified', $data );
        }
        
        /**
         * -------------------------
         * @param $data
         * add airline details
         * -------------------------
         */
        
        public function add_airline_details ( $data ) {
            $this -> db -> insert ( 'patient_travel_details', $data );
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $where
         * add airline details
         * -------------------------
         */
        
        public function edit_airline_details ( $data, $where ) {
            $this -> db -> update ( 'patient_travel_details', $data, $where );
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * add airline details
         * -------------------------
         */
        
        public function get_airline_details ( $sale_id ) {
            $data = $this -> db -> get_where ( 'patient_travel_details', array ( 'lab_sale_id' => $sale_id ) );
            return $data -> row ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @param $result_id
         * @return mixed
         * verify tests results
         * -------------------------
         */
        
        public function delete_lab_result_verify ( $sale_id, $result_id ) {
            $this -> db -> delete ( 'lab_results_verified', array (
                'sale_id'   => $sale_id,
                'result_id' => $result_id
            ) );
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save tests sample info into database
         * -------------------------
         */
        
        public function add_sample_info ( $data ) {
            $this -> db -> insert ( 'test_sample_info', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save tests details info into database
         * -------------------------
         */
        
        public function add_test_detail ( $data ) {
            $this -> db -> insert ( 'test_details', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save tests parameters info into database
         * -------------------------
         */
        
        public function add_test_parameters ( $data ) {
            $this -> db -> insert ( 'test_parameters', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save tests parameters info into database
         * -------------------------
         */
        
        public function add_test_regents ( $data ) {
            $this -> db -> insert ( 'test_regents', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save tests panic info into database
         * -------------------------
         */
        
        public function add_test_panic_values ( $data ) {
            $this -> db -> insert ( 'test_panic_values', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save tests reference ranges info into database
         * -------------------------
         */
        
        public function add_test_reference_range ( $data ) {
            $this -> db -> insert ( 'test_reference_range', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save tests prices info into database
         * -------------------------
         */
        
        public function add_test_price ( $data ) {
            $this -> db -> insert ( 'test_price', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save tests locations info into database
         * -------------------------
         */
        
        public function add_test_location ( $data ) {
            $this -> db -> insert ( 'test_locations', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get tests
         * -------------------------
         */
        
        public function get_tests () {
            $this -> db -> order_by ( 'name', 'ASC' );
            $tests = $this -> db -> get ( 'tests' );
            return $tests -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get parent tests
         * -------------------------
         */
        
        public function get_parent_tests () {
            $this -> db -> order_by ( 'name', 'ASC' );
            $tests = $this -> db -> get_where ( 'tests', array ( 'parent_id' => '0' ) );
            return $tests -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get tests prices by test & airline id
         * -------------------------
         */
        
        public function get_test_prices_by_airline_and_test_id ( $test_id, $airline_id ) {
            $tests = $this -> db -> get_where ( 'test_price', array (
                'test_id'    => $test_id,
                'airline_id' => $airline_id
            ) );
            return $tests -> result ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @param $id
         * @return mixed
         * get parent tests
         * -------------------------
         */
        
        public function get_saved_regent_value ( $test_id, $id ) {
            $regent = $this -> db -> get_where ( 'test_regents', array (
                'test_id'   => $test_id,
                'regent_id' => $id
            ) );
            return $regent -> row ();
        }
        
        /**
         * -------------------------
         * @param $result_id
         * @param $sale_id
         * @return mixed
         * get test verification data
         * -------------------------
         */
        
        public function get_result_verification_data ( $sale_id, $result_id ) {
            $data = $this -> db -> get_where ( 'lab_results_verified', array (
                'result_id' => $result_id,
                'sale_id'   => $sale_id
            ) );
            return $data -> row ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get test sale specimens
         * -------------------------
         */
        
        public function get_lab_sale_specimens ( $sale_id ) {
            $specimens = $this -> db -> query ( "Select DISTINCT (sample_id) from hmis_test_sample_info where test_id IN (Select test_id from hmis_test_sales where sale_id=$sale_id)" );
            return $specimens -> result ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @return mixed
         * get_test_regents
         * -------------------------
         */
        
        public function get_test_regents ( $test_id ) {
            $sql = "Select * from hmis_test_regents where test_id=$test_id";
            if ( isset( $_REQUEST[ 'regent-id' ] ) and !empty( trim ( $_REQUEST[ 'regent-id' ] ) ) and is_numeric ( $_REQUEST[ 'regent-id' ] ) > 0 ) {
                $regent_id = $_REQUEST[ 'regent-id' ];
                $sql       .= " and regent_id=$regent_id";
            }
            $regent = $this -> db -> query ( $sql );
            return $regent -> result ();
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * get parent tests
         * @return mixed
         * -------------------------
         */

//        public function get_active_parent_tests ( $panel_id = 0, $category = 'general' ) {
//            //		$this -> db -> order_by('name', 'ASC');
//            //        $tests = $this -> db -> get_where('tests', array('parent_id'    =>  '0', 'status' => '1'));
//            $sql = "Select * from hmis_tests where parent_id='0' and status='1' and category='$category'";
//            if ( $panel_id > 0 ) {
//                $sql .= " and id IN (Select test_id from hmis_test_price where panel_id=$panel_id)";
//            }
//            $sql   .= " order by name ASC";
//            $tests = $this -> db -> query ( $sql );
//            return $tests -> result ();
//        }
        
        public function get_active_parent_tests ( $panel_id = 0, $category = 'general' ) {
            $this -> db -> order_by ( 'name', 'ASC' );
            $this -> db -> select ( '*' ) -> from ( 'tests' ) -> where ( array ( 'parent_id' => '0', 'status' => '1', 'category' => $category ) );
            
            if ( $panel_id > 0 ) {
                $this -> db -> where ( " id IN (Select test_id from hmis_panel_lab_tests where panel_id=$panel_id)" );
            }
            
            $tests = $this -> db -> get ();
            return $tests -> result ();
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * get parent tests
         * @return mixed
         * -------------------------
         */
        
        public function get_active_parent_tests_for_covid ( $panel_id = 0, $category = 'general' ) {
            $sql = "Select * from hmis_tests where parent_id='0' and status='1' and category='$category'";
            if ( $panel_id > 0 ) {
                $sql .= " and id IN (Select test_id from hmis_test_price where panel_id=$panel_id)";
            }
            $sql   .= " order by name ASC";
            $tests = $this -> db -> query ( $sql );
            return $tests -> result ();
        }
        
        /**
         * -------------------------
         * @param $id
         * @param $sale_id
         * get_test_results
         * -------------------------
         * @return mixed
         */
        
        public function get_test_results ( $sale_id, $id ) {
            if ( empty( trim ( $id ) ) )
                $id = $_REQUEST[ 'test-id' ];
            $tests = $this -> db -> get_where ( 'test_results', array (
                'test_id' => $id,
                'sale_id' => $sale_id
            ) );
            return $tests -> row ();
        }
        
        /**
         * -------------------------
         * @param $id
         * get_test_results
         * -------------------------
         * @return mixed
         */
        
        public function get_regent_test_results ( $id ) {
            $sql = "Select * from hmis_test_results where test_id=$id";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $tests = $this -> db -> query ( $sql );
            return $tests -> result ();
        }
        
        /**
         * -------------------------
         * @param $id
         * get_test_results
         * -------------------------
         * @return mixed
         */
        
        public function get_ipd_regent_test_results ( $id ) {
            $sql = "Select * from hmis_ipd_test_results where test_id=$id";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $tests = $this -> db -> query ( $sql );
            return $tests -> result ();
        }
        
        /**
         * -------------------------
         * @param $id
         * @return mixed
         * get_regents_used_by_test
         * -------------------------
         */
        
        public function get_regents_used_by_test ( $id ) {
            $sql = "Select * from hmis_test_results where test_id=$id";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $tests = $this -> db -> query ( $sql );
            return $tests -> result ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * check if test has sub tests
         * -------------------------
         * @return mixed
         */
        
        public function check_if_test_has_sub_tests ( $test_id ) {
            $total = $this -> db -> query ( "Select COUNT(*) as totalRows from hmis_tests where parent_id=$test_id" );
            if ( $total -> row () -> totalRows > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $test_id
         * check if test is child
         * -------------------------
         * @return mixed
         */
        
        public function check_if_test_is_child ( $test_id ) {
            $total = $this -> db -> query ( "Select * from hmis_tests where id=$test_id" );
            if ( $total -> row () -> parent_id > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $test_id
         * get test by id
         * -------------------------
         * @return mixed
         */
        
        public function get_test_by_id ( $test_id ) {
            $test = $this -> db -> get_where ( 'tests', array ( 'id' => $test_id ) );
            return $test -> row ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @param $panel_id
         * get test price by id
         * @return mixed
         * -------------------------
         */

//        public function get_test_price ( $test_id, $panel_id = 0 ) {
//            $sql = "Select * from hmis_test_price where test_id=$test_id";
//            if ( $panel_id > 0 )
//                $sql .= " and panel_id=$panel_id";
//            $test = $this -> db -> query ( $sql );
//            if ( $test -> num_rows () > 0 ) {
//                return $test -> row ();
//            }
//            else {
//                $sql  = "Select * from hmis_test_price where test_id=$test_id";
//                $test = $this -> db -> query ( $sql );
//                return $test -> row ();
//            }
//        }
        
        public function get_test_price ( $test_id, $panel_id = 0 ) {
            if ( $panel_id > 0 ) {
                $this
                    -> db
                    -> select ( '*' )
                    -> from ( 'hmis_panel_lab_tests' )
                    -> where ( array ( 'test_id' => $test_id, 'panel_id' => $panel_id ) );
            }
            else {
                $this
                    -> db
                    -> select ( '*' )
                    -> from ( 'hmis_test_price' )
                    -> where ( array ( 'test_id' => $test_id ) );
            }
            $query = $this -> db -> get ();
            return $query -> row ();
        }
        
        
        /**
         * -------------------------
         * @param $test_id
         * @param $panel_id
         * @param $airline_id
         * get test price by airline id
         * @return mixed
         * -------------------------
         */
        
        public function get_test_price_by_airline ( $test_id, $panel_id = 0, $airline_id ) {
            $sql = "Select * from hmis_test_price where test_id=$test_id and airline_id=$airline_id";
            if ( $panel_id > 0 )
                $sql .= " and panel_id=$panel_id";
            $test = $this -> db -> query ( $sql );
            if ( $test -> num_rows () > 0 ) {
                return $test -> row ();
            }
            else {
                $sql  = "Select * from hmis_test_price where test_id=$test_id and airline_id=$airline_id";
                $test = $this -> db -> query ( $sql );
                return $test -> row ();
            }
        }
        
        /**
         * -------------------------
         * @param $test_id
         * get regular test price by id
         * -------------------------
         * @return mixed
         */
        
        public function get_regular_test_price ( $test_id ) {
            $test = $this -> db -> get_where ( 'test_price', array (
                'test_id'  => $test_id,
                'panel_id' => 1
            ) );
            return $test -> row ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @return mixed
         * get airlines linked with test
         * -------------------------
         */
        
        public function get_airlines_associated_to_test ( $test_id ) {
            $test = $this -> db -> query ( "Select DISTINCT (airline_id) as airline_id from hmis_test_price where test_id=$test_id and airline_id>'0'" );
            return $test -> result ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * get test sample info by id
         * -------------------------
         * @return mixed
         */
        
        public function get_test_sample_info ( $test_id ) {
            $sample = $this -> db -> get_where ( 'test_sample_info', array ( 'test_id' => $test_id ) );
            return $sample -> row ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * get test procedure info by id
         * -------------------------
         * @return mixed
         */
        
        public function get_test_procedure_info ( $test_id ) {
            $procedure = $this -> db -> get_where ( 'test_details', array ( 'test_id' => $test_id ) );
            return $procedure -> row ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * get test parameters info by id
         * -------------------------
         * @return mixed
         */
        
        public function get_test_parameters ( $test_id ) {
            $parameters = $this -> db -> get_where ( 'test_parameters', array (
                'test_id' => $test_id,
                'machine' => @$_GET[ 'machine' ]
            ) );
            return $parameters -> row ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * get test parameters info by id
         * -------------------------
         * @return mixed
         */
        
        public function get_patient_id_by_sale_id ( $sale_id ) {
            $patient = $this -> db -> get_where ( 'test_sales', array ( 'sale_id' => $sale_id ) );
            return $patient -> row () -> patient_id;
        }
        
        /**
         * -------------------------
         * @param $test_id
         * get test panic values info by id
         * -------------------------
         * @return mixed
         */
        
        public function get_test_panic_values ( $test_id ) {
            $panic = $this -> db -> get_where ( 'test_panic_values', array (
                'test_id' => $test_id,
                'machine' => @$_GET[ 'machine' ]
            ) );
            return $panic -> row ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * get_test_unit_id_by_id
         * -------------------------
         * @return mixed
         */
        
        public function get_test_unit_id_by_id ( $test_id ) {
            $sql = "Select * from hmis_test_parameters where test_id=$test_id";
            if ( isset( $_REQUEST[ 'machine' ] ) and !empty( trim ( $_REQUEST[ 'machine' ] ) ) ) {
                $machine = $_REQUEST[ 'machine' ];
                $sql     .= " and machine='$machine'";
            }
            $panic = $this -> db -> query ( $sql ) -> row ();
            return !empty( $panic ) ? $panic -> unit_id : '';
        }
        
        /**
         * -------------------------
         * @param $unit_id
         * get_unit_by_id
         * -------------------------
         * @return mixed
         */
        
        public function get_unit_by_id ( $unit_id ) {
            $panic = $this -> db -> get_where ( 'units', array ( 'id' => $unit_id ) );
            return $panic -> row () -> name;
        }
        
        /**
         * -------------------------
         * @param $test_id
         * get_reference_ranges_by_test_id
         * -------------------------
         * @return mixed
         */
        
        public function get_reference_ranges_by_test_id ( $test_id ) {
            $sql = "Select * from hmis_test_reference_range where test_id=$test_id";
            if ( isset( $_REQUEST[ 'machine' ] ) and !empty( trim ( $_REQUEST[ 'machine' ] ) ) ) {
                $machine = $_REQUEST[ 'machine' ];
                $sql     .= " and machine='$machine'";
            }
            $panic = $this -> db -> query ( $sql );
            return $panic -> result ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * get test reference range values info by id
         * -------------------------
         * @return mixed
         */
        
        public function get_test_reference_range ( $test_id ) {
            $range = $this -> db -> get_where ( 'test_reference_range', array (
                'test_id' => $test_id,
                'machine' => @$_GET[ 'machine' ]
            ) );
            return $range -> result ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * get test price info by id
         * -------------------------
         * @return mixed
         */
        
        public function get_test_prices ( $test_id ) {
            $range = $this -> db -> get_where ( 'test_price', array ( 'test_id' => $test_id ) );
            return $range -> result ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @param $location_id
         * get test price info by id
         * -------------------------
         * @return mixed
         */
        
        public function get_selected_location ( $location_id, $test_id ) {
            $location = $this -> db -> get_where ( 'test_locations', array (
                'test_id'     => $test_id,
                'location_id' => $location_id
            ) );
            return $location -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $test_id
         * @return mixed
         * update test general info
         * -------------------------
         */
        
        public function edit ( $data, $test_id ) {
            $this -> db -> update ( 'tests', $data, array ( 'id' => $test_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $test_id
         * @return mixed
         * update test sample info
         * -------------------------
         */
        
        public function edit_sample_info ( $data, $test_id ) {
            $this -> db -> update ( 'test_sample_info', $data, array ( 'test_id' => $test_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $test_id
         * @return mixed
         * update test detail info
         * -------------------------
         */
        
        public function edit_test_detail ( $data, $test_id ) {
            $this -> db -> update ( 'test_details', $data, array ( 'test_id' => $test_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $test_id
         * @return mixed
         * edit tests parameters info into database
         * -------------------------
         */
        
        public function edit_test_parameters ( $data, $test_id ) {
            $values = $this -> db -> get_where ( 'test_parameters', array (
                'test_id' => $test_id,
                'machine' => $_GET[ 'machine' ]
            ) );
            if ( $values -> num_rows () > 0 ) {
                $this -> db -> update ( 'test_parameters', $data, array (
                    'test_id' => $test_id,
                    'machine' => $_GET[ 'machine' ]
                ) );
                return $this -> db -> affected_rows ();
            }
            else {
                $this -> db -> insert ( 'test_parameters', $data );
                return $this -> db -> insert_id ();
            }
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $test_id
         * @return mixed
         * edit tests panic values info into database
         * -------------------------
         */
        
        public function edit_test_panic_values ( $data, $test_id ) {
            $values = $this -> db -> get_where ( 'test_panic_values', array (
                'test_id' => $test_id,
                'machine' => $_GET[ 'machine' ]
            ) );
            if ( $values -> num_rows () > 0 ) {
                $this -> db -> update ( 'test_panic_values', $data, array (
                    'test_id' => $test_id,
                    'machine' => $_GET[ 'machine' ]
                ) );
                return $this -> db -> affected_rows ();
            }
            else {
                $this -> db -> insert ( 'test_panic_values', $data );
                return $this -> db -> insert_id ();
            }
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @return mixed
         * delete lab test
         * -------------------------
         */
        
        public function delete ( $test_id ) {
            $this -> db -> delete ( 'tests', array ( 'id' => $test_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $calibration_id
         * @return mixed
         * delete calibration_id
         * -------------------------
         */
        
        public function delete_calibration ( $calibration_id ) {
            $this -> db -> delete ( 'test_calibrations', array ( 'calibration_id' => $calibration_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @param $result_id
         * @param $parent_test_id
         * delete_results
         * -------------------------
         */
        
        public function delete_results ( $sale_id, $result_id, $parent_test_id ) {
            $sql = "Delete from hmis_test_results where sale_id=$sale_id";
            if ( $result_id > 0 )
                $sql .= " and result_id=$result_id";
            if ( $result_id < 1 or empty( trim ( $result_id ) ) )
                $sql .= " and test_id=$parent_test_id";
            $this -> db -> query ( $sql );
            
            $sql2 = "Delete from hmis_test_results where sale_id=$sale_id and id=$parent_test_id";
            $this -> db -> query ( $sql2 );
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @param $test_id
         * delete_results
         * -------------------------
         */
        
        public function delete_result_remarks ( $sale_id, $test_id ) {
            $sql = "Delete from hmis_test_result_remarks where sale_id=$sale_id and test_id=$test_id";
            $this -> db -> query ( $sql );
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @return mixed
         * delete test reference ranges
         * -------------------------
         */
        
        public function delete_test_reference_range ( $test_id ) {
            $this -> db -> delete ( 'test_reference_range', array (
                'test_id' => $test_id,
                'machine' => $_GET[ 'machine' ]
            ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @return mixed
         * delete test prices
         * -------------------------
         */
        
        public function delete_test_prices ( $test_id ) {
            $this -> db -> delete ( 'test_price', array ( 'test_id' => $test_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @param $airline_id
         * @return mixed
         * delete test prices
         * -------------------------
         */
        
        public function delete_test_prices_by_airline ( $test_id, $airline_id ) {
            $this -> db -> delete ( 'test_price', array (
                'test_id'    => $test_id,
                'airline_id' => $airline_id
            ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @return mixed
         * delete test regents
         * -------------------------
         */
        
        public function delete_test_regents ( $test_id ) {
            $this -> db -> delete ( 'test_regents', array ( 'test_id' => $test_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @return mixed
         * delete test locations
         * -------------------------
         */
        
        public function delete_test_location ( $test_id ) {
            $this -> db -> delete ( 'test_locations', array ( 'test_id' => $test_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * get sub tests
         * -------------------------
         * @return mixed
         */
        
        public function get_child_tests ( $test_id ) {
            $this -> db -> order_by ( 'sort_order', 'ASC' );
            $tests = $this -> db -> get_where ( 'tests', array ( 'parent_id' => $test_id ) );
            return $tests -> result ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * get sub tests
         * -------------------------
         * @return mixed
         */
        
        public function get_child_tests_ids ( $test_id ) {
            if ( $test_id > 0 ) {
                $tests = $this -> db -> query ( "Select GROUP_CONCAT(id) as ids from hmis_tests where parent_id=$test_id" );
                return $tests -> row ();
            }
            return false;
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @param $panel_id
         * @return mixed
         * get sub tests
         * -------------------------
         */
        
        public function get_active_child_tests ( $test_id, $panel_id = 0 ) {
            $sql = "Select * from hmis_tests where parent_id=$test_id and status='1'";
            if ( $panel_id > 0 ) {
                $sql .= " and id IN (Select test_id from hmis_test_price where panel_id=$panel_id)";
            }
            $sql   .= " order by sort_order ASC";
            $tests = $this -> db -> query ( $sql );
            return $tests -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $sale_id
         * add sale
         * -------------------------
         */
        
        public function add_sale ( $data, $sale_id ) {
            $if_sale_exists = $this -> db -> get_where ( 'lab_sales', array ( 'id' => $sale_id ) );
            if ( $if_sale_exists -> num_rows () < 1 ) {
                $this -> db -> insert ( 'lab_sales', $data );
            }
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add sale
         * -------------------------
         */
        
        public function add_lab_sale ( $data ) {
            $this -> db -> insert ( 'lab_sales', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add sale
         * -------------------------
         */
        
        public function add_calibrations ( $data ) {
            $this -> db -> insert ( 'test_calibrations', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * add sale
         * -------------------------
         */
        
        public function get_added_tests ( $sale_id ) {
            $tests = $this -> db -> get_where ( 'test_sales', array ( 'sale_id' => $sale_id ) );
            return $tests -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * assign tests
         * -------------------------
         */
        
        public function assign_test ( $data ) {
            $this -> db -> insert ( 'test_sales', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return int|string
         * get next Invoice ID
         * -------------------------
         */
        
        public function get_next_sale_id () {
            $id = $this -> db -> query ( "Select id from hmis_lab_sales order by id DESC limit 1" );
            if ( $id -> num_rows () > 0 )
                return ( $id -> row () -> id ) + 1;
            else
                return '1';
        }
        
        /**
         * -------------------------
         * @param $id
         * delete test
         * -------------------------
         */
        
        public function remove_test ( $id ) {
            $test_id    = 0;
            $check_type = $this -> db -> query ( "Select test_id, type from hmis_test_sales where id=$id" );
            if ( $check_type -> row () -> type == 'profile' ) {
                $test_id = $check_type -> row () -> test_id;
            }
            $this -> db -> delete ( 'test_sales', array ( 'id' => $id ) );
            $this -> db -> delete ( 'test_sales', array ( 'parent_id' => $test_id ) );
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @param $patient_id
         * @return mixed
         * get test price
         * -------------------------
         */
        
        public function get_test_price_by_patient_type ( $test_id, $patient_id ) {
            //        $patient = $this -> db -> query("Select company_id from hmis_patients where id=$patient_id");
            //        $company_id = $patient -> row() -> company_id;
            //        if(!empty(trim($company_id)) and is_numeric($company_id) > 0) {
            //            $panel = $this->db->query("Select panel_id from hmis_panel_companies where company_id=$company_id");
            //            $panel_id = $panel->row()->panel_id;
            //            $test_price = $this->db->query("Select price from hmis_test_price where test_id=$test_id and panel_id=$panel_id");
            //            $price = $test_price->row();
            //            return $price;
            //        }
            //        else {
            //            return $this -> get_regular_test_price($test_id);
            //        }
            
            $patient  = $this -> db -> query ( "Select panel_id from hmis_patients where id=$patient_id" );
            $panel_id = $patient -> row () -> panel_id;
            if ( !empty( trim ( $panel_id ) ) and is_numeric ( $panel_id ) > 0 ) {
                $test_price = $this -> db -> query ( "Select price from hmis_test_price where test_id=$test_id and panel_id=$panel_id" );
                $price      = $test_price -> row ();
                return $price;
            }
            else {
                return $this -> get_regular_test_price ( $test_id );
            }
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @param $panel_id
         * @return mixed
         * get test price
         * -------------------------
         */
        
        public function get_test_price_panel_id ( $test_id, $panel_id ) {
            $test_price = $this -> db -> query ( "Select price from hmis_panel_lab_tests where test_id=$test_id and panel_id=$panel_id" );
            $price      = $test_price -> row ();
            if ( !empty( $price ) )
                return $price;
            else
                return $this -> get_regular_test_price ( $test_id );
        }
        
        /**
         * -------------------------
         * @param $patient_id
         * @return mixed
         * get_patient_monthly_gained_allowance
         * -------------------------
         */
        
        public function get_patient_monthly_gained_allowance ( $patient_id ) {
            $month = date ( 'm' );
            $total = $this -> db -> query ( "Select SUM(price) as total from hmis_test_sales where patient_id=$patient_id and MONTH(date_added)=$month" );
            return $total -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $where
         * update lab test
         * -------------------------
         */
        
        public function update ( $info, $where ) {
            $this -> db -> update ( 'tests', $info, $where );
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @param $total
         * update total sale
         * -------------------------
         */
        
        public function update_total ( $sale_id, $total ) {
            $this -> db -> update ( 'lab_sales', array ( 'total' => $total ), array ( 'id' => $sale_id ) );
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $where
         * update total sale
         * -------------------------
         */
        
        public function update_lab_sale ( $info, $where ) {
            $this -> db -> update ( 'lab_sales', $info, $where );
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get sales by Invoice ID
         * -------------------------
         */
        
        public function get_lab_sales_by_sale_id ( $sale_id ) {
            $sales = $this -> db -> get_where ( 'test_sales', array ( 'sale_id' => $sale_id ) );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $sale_id
         * @return mixed
         * update sales by Invoice ID
         * -------------------------
         */
        
        public function update_lab_sales_by_sale_id ( $info, $sale_id ) {
            $this -> db -> update ( 'lab_sales', $info, array ( 'id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get sales by Invoice ID
         * -------------------------
         */
        
        public function get_test_sale_by_id ( $sale_id ) {
            $sales = $this -> db -> get_where ( 'test_sales', array ( 'sale_id' => $sale_id ) );
            return $sales -> row ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get sales by Invoice ID
         * -------------------------
         */
        
        public function get_ipd_test_sale_by_id ( $sale_id ) {
            $sales = $this -> db -> get_where ( 'hmis_ipd_patient_associated_lab_tests', array ( 'sale_id' => $sale_id ) );
            return $sales -> row ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get total sales by Invoice ID
         * -------------------------
         */
        
        public function get_lab_sales_total_by_sale_id ( $sale_id ) {
            $sales = $this -> db -> query ( "Select SUM(price) as total from hmis_test_sales where sale_id=$sale_id" );
            return $sales -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param bool $panelSales
         * @param $limit
         * @param $offset
         * get sales by Invoice ID
         * start and end date
         * @return mixed
         * -------------------------
         */
        
        public function get_sales_by_sale_id ( $panelSales = false, $limit, $offset ) {
            $user_id  = get_logged_in_user_id ();
            $user     = get_user ( $user_id );
            $panel_id = $user -> panel_id;
            
            $sql = "Select sale_id, patient_id, GROUP_CONCAT(test_id) as tests, SUM(price) as price, date_added, remarks, refunded from hmis_test_sales where (parent_id='0' OR parent_id < 1 or parent_id IS NULL)";
            if ( isset( $_REQUEST[ 'sale_id' ] ) and is_numeric ( $_REQUEST[ 'sale_id' ] ) > 0 and !empty( trim ( $_REQUEST[ 'sale_id' ] ) ) ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            
            if ( isset( $_REQUEST[ 'patient_id' ] ) and is_numeric ( $_REQUEST[ 'patient_id' ] ) > 0 and !empty( trim ( $_REQUEST[ 'patient_id' ] ) ) ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            
            if ( isset( $_REQUEST[ 'patient_name' ] ) and !empty( trim ( $_REQUEST[ 'patient_name' ] ) ) ) {
                $patient_name = $_REQUEST[ 'patient_name' ];
                $sql          .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$patient_name%')";
            }
            
            if ( isset( $_REQUEST[ 'patient_mobile' ] ) and !empty( trim ( $_REQUEST[ 'patient_mobile' ] ) ) ) {
                $patient_mobile = $_REQUEST[ 'patient_mobile' ];
                $sql            .= " and patient_id IN (Select id from hmis_patients where mobile='$patient_mobile')";
            }
            
            if ( $panelSales ) {
                $sql .= " and patient_id IN (Select id from hmis_patients where panel_id > 0)";
            }
            
            else {
                $sql .= " and patient_id IN (Select id from hmis_patients where panel_id < 1 or panel_id = 0 or panel_id IS NULL)";
            }
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            
            if ( !empty( trim ( $panel_id ) ) and $panel_id > 0 ) {
                $sql .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            
            $sql   .= " group by sale_id order by id DESC limit $limit offset $offset";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @param bool $panelSales
         * get sales by Invoice ID
         * start and end date
         * @return mixed
         * -------------------------
         */
        
        public function count_sales ( $panelSales = false ) {
            $user_id  = get_logged_in_user_id ();
            $user     = get_user ( $user_id );
            $panel_id = $user -> panel_id;
            
            $sql = "Select * from hmis_test_sales where (parent_id='0' OR parent_id < 1 or parent_id IS NULL)";
            if ( isset( $_REQUEST[ 'sale_id' ] ) and is_numeric ( $_REQUEST[ 'sale_id' ] ) > 0 and !empty( trim ( $_REQUEST[ 'sale_id' ] ) ) ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            
            if ( isset( $_REQUEST[ 'patient_id' ] ) and is_numeric ( $_REQUEST[ 'patient_id' ] ) > 0 and !empty( trim ( $_REQUEST[ 'patient_id' ] ) ) ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            
            if ( isset( $_REQUEST[ 'patient_name' ] ) and !empty( trim ( $_REQUEST[ 'patient_name' ] ) ) ) {
                $patient_name = $_REQUEST[ 'patient_name' ];
                $sql          .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$patient_name%')";
            }
            
            if ( isset( $_REQUEST[ 'patient_mobile' ] ) and !empty( trim ( $_REQUEST[ 'patient_mobile' ] ) ) ) {
                $patient_mobile = $_REQUEST[ 'patient_mobile' ];
                $sql            .= " and patient_id IN (Select id from hmis_patients where mobile='$patient_mobile')";
            }
            
            if ( $panelSales ) {
                $sql .= " and patient_id IN (Select id from hmis_patients where panel_id > 0)";
            }
            
            else {
                $sql .= " and patient_id IN (Select id from hmis_patients where panel_id < 1 or panel_id = 0 or panel_id IS NULL)";
            }
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            
            if ( !empty( trim ( $panel_id ) ) and $panel_id > 0 ) {
                $sql .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            
            $sql   .= " group by sale_id order by id DESC";
            $sales = $this -> db -> query ( $sql );
            return $sales -> num_rows ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * delete sale test
         * -------------------------
         */
        
        public function delete_sale ( $sale_id ) {
            $this -> db -> delete ( 'lab_sales', array ( 'id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * delete sale test ledger
         * -------------------------
         */
        
        public function delete_sale_ledger ( $sale_id ) {
            $this -> db -> delete ( 'general_ledger', array ( 'lab_sale_id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get sales
         * -------------------------
         */
        
        public function get_sale_by_sale_id ( $sale_id ) {
            $sales = $this -> db -> get_where ( 'test_sales', array ( 'sale_id' => $sale_id ) );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get test results by Invoice ID
         * -------------------------
         */
        
        public function get_lab_results_by_sale_id ( $sale_id ) {
            
            $sql = "Select * from hmis_test_results where 1";
            
            if ( $sale_id > 0 )
                $sql .= " and sale_id=$sale_id";
            
            if ( isset( $_REQUEST[ 'selected' ] ) and !empty( trim ( $_REQUEST[ 'selected' ] ) ) ) {
                $selected = $_REQUEST[ 'selected' ];
                $sql      .= " and id IN($selected)";
            }
            
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
            
            //            $sales = $this -> db -> get_where ( 'test_results', array ( 'sale_id' => $sale_id ) );
            //            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get test results by Invoice ID
         * -------------------------
         */
        
        public function get_lab_sale_parent_tests_by_sale_id ( $sale_id ) {
            
            $sql = "Select * from hmis_test_results where test_id IN (Select id from hmis_tests where (parent_id IS NULL OR parent_id < 1))";
            
            if ( $sale_id > 0 )
                $sql .= " and sale_id=$sale_id";
            
            if ( isset( $_REQUEST[ 'selected' ] ) and !empty( trim ( $_REQUEST[ 'selected' ] ) ) ) {
                $selected = rtrim ( $_REQUEST[ 'selected' ], ',' );
                $sql      .= " and test_id IN($selected)";
            }
            
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @param $result_id
         * @return mixed
         * get test results by Invoice ID
         * -------------------------
         */
        
        public function get_lab_results_by_sale_id_result_id ( $sale_id, $result_id ) {
            $sales = $this -> db -> get_where ( 'hmis_test_results', array (
                'sale_id' => $sale_id,
                'id'      => $result_id
            ) );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @param $ids
         * @param $result_id
         * @return mixed
         * get test results by Invoice ID
         * -------------------------
         */
        
        public function get_sub_lab_results_by_sale_id_result_id ( $sale_id, $ids, $result_id ) {
            if ( empty( trim ( $ids ) ) )
                return array ();
            
            $sql = "Select * from hmis_test_results where sale_id=$sale_id and test_id IN($ids)";
            if ( $result_id > 0 ) {
                $sql .= " and result_id=$result_id";
            }
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @param $ids
         * @param $result_id
         * @return mixed
         * get test results by Invoice ID
         * -------------------------
         */
        
        public function get_ipd_lab_test_results_by_ids ( $sale_id, $ids, $result_id ) {
            $sql = "Select * from hmis_ipd_test_results where sale_id=$sale_id and test_id IN($ids)";
            if ( $result_id > 0 ) {
                $sql .= " and result_id=$result_id";
            }
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get sales by invoice id
         * or by date added
         * -------------------------
         */
        
        public function get_sale_tests () {
            $sql = "Select * from hmis_test_sales where 1";
            if ( isset( $_REQUEST[ 'invoice_id' ] ) and !empty( trim ( $_REQUEST[ 'invoice_id' ] ) ) and is_numeric ( $_REQUEST[ 'invoice_id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'invoice_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            if ( isset( $_REQUEST[ 'date' ] ) and !empty( trim ( $_REQUEST[ 'date' ] ) ) ) {
                $date = $_REQUEST[ 'date' ];
                $sql  .= " and date_added='$date'";
            }
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get sales by invoice id
         * or by date added
         * -------------------------
         */
        
        public function get_sale_parent_tests () {
            $sql = "Select * from hmis_test_sales where (parent_id IS NULL OR parent_id='' OR parent_id=0) AND refunded='0'";
            if ( isset( $_REQUEST[ 'invoice_id' ] ) and !empty( trim ( $_REQUEST[ 'invoice_id' ] ) ) and is_numeric ( $_REQUEST[ 'invoice_id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'invoice_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            if ( isset( $_REQUEST[ 'date' ] ) and !empty( trim ( $_REQUEST[ 'date' ] ) ) ) {
                $date = $_REQUEST[ 'date' ];
                $sql  .= " and date_added='$date'";
            }
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get sales by invoice id
         * or by date added
         * -------------------------
         */
        
        public function get_sale_tests_by_parent () {
            $sql = "Select * from hmis_test_sales where refunded='0'";
            if ( isset( $_REQUEST[ 'sale-id' ] ) and !empty( trim ( $_REQUEST[ 'sale-id' ] ) ) and is_numeric ( $_REQUEST[ 'sale-id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'sale-id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            if ( isset( $_REQUEST[ 'parent-id' ] ) and !empty( trim ( $_REQUEST[ 'parent-id' ] ) ) and is_numeric ( $_REQUEST[ 'parent-id' ] ) > 0 ) {
                $parent_id = $_REQUEST[ 'parent-id' ];
                $sql       .= " and parent_id=$parent_id";
            }
            else if ( isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] == 0 ) {
                $test_id = $_REQUEST[ 'test-id' ];
                $sql     .= " and test_id=$test_id";
            }
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        public function get_lab_sale_tests () {
            $sql = "Select * from hmis_test_sales where 1";
            if ( isset( $_REQUEST[ 'sale-id' ] ) and !empty( trim ( $_REQUEST[ 'sale-id' ] ) ) and is_numeric ( $_REQUEST[ 'sale-id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'sale-id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            
            if ( isset( $_REQUEST[ 'test-id' ] ) and !empty( trim ( $_REQUEST[ 'test-id' ] ) ) and is_numeric ( $_REQUEST[ 'test-id' ] ) > 0 ) {
                $test_id = $_REQUEST[ 'test-id' ];
                $sql     .= " and test_id=$test_id";
            }
            
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get regents consumption report
         * -------------------------
         */
        
        public function get_regents_consumption_report () {
            $search = false;
            $sql    = "Select test_id, sale_id, date_added from hmis_test_sales where (parent_id IS NULL or parent_id=0 or parent_id='')";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' AND '$end_date'";
                $search     = true;
            }
            if ( isset( $_REQUEST[ 'test_id' ] ) and !empty( trim ( $_REQUEST[ 'test_id' ] ) ) and is_numeric ( $_REQUEST[ 'test_id' ] ) > 0 ) {
                $test_id = $_REQUEST[ 'test_id' ];
                $sql     .= " and test_id=$test_id";
                $search  = true;
            }
            if ( isset( $_REQUEST[ 'regent-id' ] ) and !empty( trim ( $_REQUEST[ 'regent-id' ] ) ) and is_numeric ( $_REQUEST[ 'regent-id' ] ) > 0 ) {
                $regent_id = $_REQUEST[ 'regent-id' ];
                $sql       .= " and test_id IN (Select test_id from hmis_test_regents where regent_id=$regent_id)";
                $search    = true;
            }
            $sql   .= " group by test_id";
            $sales = $this -> db -> query ( $sql );
            if ( $search )
                return $sales -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get regents consumption report
         * -------------------------
         */
        
        public function get_regents_ipd_consumption_report () {
            $search = false;
            $sql    = "Select test_id, sale_id, date_added from hmis_ipd_patient_associated_lab_tests where (parent_id IS NULL or parent_id=0 or parent_id='')";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' AND '$end_date'";
                $search     = true;
            }
            if ( isset( $_REQUEST[ 'test_id' ] ) and !empty( trim ( $_REQUEST[ 'test_id' ] ) ) and is_numeric ( $_REQUEST[ 'test_id' ] ) > 0 ) {
                $test_id = $_REQUEST[ 'test_id' ];
                $sql     .= " and test_id=$test_id";
                $search  = true;
            }
            if ( isset( $_REQUEST[ 'regent-id' ] ) and !empty( trim ( $_REQUEST[ 'regent-id' ] ) ) and is_numeric ( $_REQUEST[ 'regent-id' ] ) > 0 ) {
                $regent_id = $_REQUEST[ 'regent-id' ];
                $sql       .= " and test_id IN (Select test_id from hmis_test_regents where regent_id=$regent_id)";
                $search    = true;
            }
            $sql   .= " group by test_id";
            $sales = $this -> db -> query ( $sql );
            if ( $search )
                return $sales -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get general report
         * -------------------------
         */
        
        public function get_general_report () {
            $search = false;
            $sql    = "Select sale_id, patient_id, GROUP_CONCAT(test_id) as tests, parent_id, type, SUM(price) as price, status, remarks, refunded, date_added from hmis_test_sales where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
                $search     = true;
            }
            if ( isset( $_REQUEST[ 'panel-id' ] ) and !empty( trim ( $_REQUEST[ 'panel-id' ] ) ) and is_numeric ( $_REQUEST[ 'panel-id' ] ) > 0 ) {
                $panel_id = $_REQUEST[ 'panel-id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
                $search   = true;
            }
            else if ( isset( $_REQUEST[ 'panel-id' ] ) and !empty( trim ( $_REQUEST[ 'panel-id' ] ) ) and $_REQUEST[ 'panel-id' ] == 'cash' ) {
                $sql    .= " and patient_id IN (Select id from hmis_patients where (panel_id IS NULL OR panel_id='0' OR panel_id=''))";
                $search = true;
            }
            else if ( isset( $_REQUEST[ 'exclude-cash' ] ) and !empty( trim ( $_REQUEST[ 'exclude-cash' ] ) ) and $_REQUEST[ 'exclude-cash' ] == 'yes' ) {
                $sql    .= " and patient_id IN (Select id from hmis_patients where (panel_id IS NOT NULL AND panel_id > 0 OR panel_id!=''))";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'panel-id' ] ) and $_REQUEST[ 'panel-id' ] == 'cash' ) {
                $sql    .= " and patient_id NOT IN (Select id from hmis_patients where panel_id > 0)";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'test_id' ] ) and !empty( trim ( $_REQUEST[ 'test_id' ] ) ) and is_numeric ( $_REQUEST[ 'test_id' ] ) > 0 ) {
                $test_id = $_REQUEST[ 'test_id' ];
                $sql     .= " and test_id=$test_id";
                $search  = true;
            }
            if ( isset( $_REQUEST[ 'sale_id' ] ) and !empty( trim ( $_REQUEST[ 'sale_id' ] ) ) and is_numeric ( $_REQUEST[ 'sale_id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sql     .= " and sale_id=$sale_id";
                $search  = true;
            }
            if ( isset( $_REQUEST[ 'start_time' ] ) and isset( $_REQUEST[ 'end_time' ] ) and !empty( $_REQUEST[ 'start_time' ] ) and !empty( $_REQUEST[ 'end_time' ] ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'start_time' ] ) );
                $end_time   = date ( 'H:i:s', strtotime ( $_REQUEST[ 'end_time' ] ) );
                $sql        .= " and TIME(date_added) BETWEEN '$start_time' and '$end_time'";
                $search     = true;
            }
            if ( isset( $_GET[ 'user-id' ] ) and !empty( trim ( $_GET[ 'user-id' ] ) ) and $_GET[ 'user-id' ] > 0 ) {
                $user_id = $_GET[ 'user-id' ];
                $sql     .= " and user_id=$user_id";
                $search  = true;
            }
            if ( isset( $_REQUEST[ 'reference-id' ] ) and $_REQUEST[ 'reference-id' ] > 0 ) {
                $reference_id = $_GET[ 'reference-id' ];
                $sql          .= " and sale_id IN (Select id from hmis_lab_sales where reference_id=$reference_id)";
                $search       = true;
            }
            if ( isset( $_REQUEST[ 'doctor-id' ] ) and $_REQUEST[ 'doctor-id' ] > 0 ) {
                $doctor_id = $_GET[ 'doctor-id' ];
                $sql       .= " and sale_id IN (Select id from hmis_lab_sales where doctor_id=$doctor_id)";
                $search    = true;
            }
            $sql   .= " group by sale_id order by DATE(date_added) ASC";
            $sales = $this -> db -> query ( $sql );
            if ( $search )
                return $sales -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get lab receiving general report
         * -------------------------
         */
        
        public function get_lab_receiving_general_report () {
            $search = false;
            $sql    = "Select * from hmis_lab_sales_receiving where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(created_at) BETWEEN '$start_date' and '$end_date'";
                $search     = true;
            }
            
            if ( isset( $_GET[ 'user-id' ] ) and !empty( trim ( $_GET[ 'user-id' ] ) ) and $_GET[ 'user-id' ] > 0 ) {
                $user_id = $_GET[ 'user-id' ];
                $sql     .= " and user_id=$user_id";
                $search  = true;
            }
            $sales = $this -> db -> query ( $sql );
            if ( $search )
                return $sales -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get general report covid
         * -------------------------
         */
        
        public function get_general_report_covid () {
            $user = get_user ( get_logged_in_user_id () );
            $sql  = "Select GROUP_CONCAT(test_id) as tests, airline_id, SUM(price) as price, COUNT(patient_id) as patients from hmis_test_sales where airline_id>0 and test_id IN (Select id from hmis_tests where category='covid')";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            if ( isset( $_REQUEST[ 'panel-id' ] ) and !empty( trim ( $_REQUEST[ 'panel-id' ] ) ) and is_numeric ( $_REQUEST[ 'panel-id' ] ) > 0 ) {
                $panel_id = $_REQUEST[ 'panel-id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            if ( isset( $_REQUEST[ 'panel-id' ] ) and $_REQUEST[ 'panel-id' ] == 'cash' ) {
                $sql .= " and patient_id NOT IN (Select id from hmis_patients where panel_id > 0)";
            }
            if ( isset( $_REQUEST[ 'airline-id' ] ) and !empty( trim ( $_REQUEST[ 'airline-id' ] ) ) and is_numeric ( $_REQUEST[ 'airline-id' ] ) > 0 ) {
                $airline_id = $_REQUEST[ 'airline-id' ];
                $sql        .= " and airline_id=$airline_id";
            }
            if ( $user -> panel_id > 0 ) {
                $panel_id = $user -> panel_id;
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            $sql   .= " group by airline_id order by DATE(date_added) ASC";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get lab cash balance report
         * -------------------------
         */
        
        public function get_lab_cash_balance_report () {
            $sql = "Select sale_id, patient_id, GROUP_CONCAT(test_id) as tests, SUM(price) as price, date_added, remarks, refunded from hmis_test_sales where (parent_id='0' OR parent_id < 1 or parent_id IS NULL) AND patient_id IN (Select id from hmis_patients where panel_id IS NULL OR panel_id < 1)";
            if ( isset( $_REQUEST[ 'sale_id' ] ) and is_numeric ( $_REQUEST[ 'sale_id' ] ) > 0 and !empty( trim ( $_REQUEST[ 'sale_id' ] ) ) ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and is_numeric ( $_REQUEST[ 'patient_id' ] ) > 0 and !empty( trim ( $_REQUEST[ 'patient_id' ] ) ) ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'patient_name' ] ) and !empty( trim ( $_REQUEST[ 'patient_name' ] ) ) ) {
                $patient_name = $_REQUEST[ 'patient_name' ];
                $sql          .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$patient_name%')";
            }
            
            if ( isset( $_REQUEST[ 'patient_mobile' ] ) and !empty( trim ( $_REQUEST[ 'patient_mobile' ] ) ) ) {
                $patient_mobile = $_REQUEST[ 'patient_mobile' ];
                $sql            .= " and patient_id IN (Select id from hmis_patients where mobile='$patient_mobile')";
            }
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $sql   .= " group by sale_id order by id DESC";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * set test sale status to 1
         * @return mixed
         * -------------------------
         */
        
        public function update_test_status ( $sale_id ) {
            $this -> db -> update ( 'test_sales', array ( 'status' => '1' ), array ( 'sale_id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @param $sale_id
         * @return mixed
         * get single sold test price
         * -------------------------
         */
        
        public function get_sold_test_price ( $test_id, $sale_id ) {
            $test = $this -> db -> get_where ( 'test_sales', array (
                'sale_id' => $sale_id,
                'test_id' => $test_id
            ) );
            return $test -> row ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @param $sale_id
         * @return mixed
         * delete single sold test
         * -------------------------
         */
        
        public function delete_lab_sale_test ( $test_id, $sale_id ) {
            $this -> db -> delete ( 'test_sales', array (
                'sale_id' => $sale_id,
                'test_id' => $test_id
            ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $price
         * @param $sale_id
         * @return mixed
         * update general ledger
         * -------------------------
         */
        
        public function update_general_ledger ( $sale_id, $price ) {
            $this -> db -> query ( "Update hmis_general_ledger SET credit=credit-$price where lab_sale_id=$sale_id" );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $price
         * @param $sale_id
         * @return mixed
         * update general sale
         * -------------------------
         */
        
        public function update_general_sale ( $sale_id, $price ) {
            $this -> db -> query ( "Update hmis_lab_sales SET total=total-$price where id=$sale_id" );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get sale by id
         * -------------------------
         */
        
        public function get_lab_sale ( $sale_id ) {
            $sale = $this -> db -> get_where ( 'lab_sales', array ( 'id' => $sale_id ) );
            return $sale -> row ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get test sale by id
         * -------------------------
         */
        
        public function get_test_sale ( $sale_id ) {
            $sale = $this -> db -> get_where ( 'test_sales', array ( 'sale_id' => $sale_id ) );
            return $sale -> row ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get lab total sale
         * by date range
         * -------------------------
         */
        
        public function get_total_sale_by_date_range () {
            $sql = "Select SUM(total) as net from hmis_lab_sales where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_sale) Between '$start_date' and '$end_date'";
            }
            if ( isset( $_REQUEST[ 'start_time' ] ) and isset( $_REQUEST[ 'end_time' ] ) and !empty( $_REQUEST[ 'start_time' ] ) and !empty( $_REQUEST[ 'end_time' ] ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'start_time' ] ) );
                $end_time   = date ( 'H:i:s', strtotime ( $_REQUEST[ 'end_time' ] ) );
                $sql        .= " and TIME(date_sale) BETWEEN '$start_time' and '$end_time'";
            }
            if ( isset( $_REQUEST[ 'user_id' ] ) and $_REQUEST[ 'user_id' ] > 0 ) {
                $user_id = $_REQUEST[ 'user_id' ];
                $sql     .= " and user_id=$user_id";
            }
            $query = $this -> db -> query ( $sql );
            return $query -> row ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * set to refunded
         * -------------------------
         */
        
        public function set_refunded_to_1 ( $sale_id ) {
            $this -> db -> update ( 'hmis_test_sales', array ( 'refunded' => 1 ), array ( 'sale_id' => $sale_id ) );
        }
        
        /**
         * -------------------------
         * @param $test_id
         * get test price
         * @return mixed
         * -------------------------
         */
        
        public function get_lab_test_price ( $test_id ) {
            $price = $this -> db -> get_where ( 'hmis_test_price', array ( 'test_id' => $test_id ) );
            if ( $price -> num_rows () > 0 )
                return $price -> row () -> price;
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * get online report data
         * @return mixed
         * -------------------------
         */
        
        public function online_test_invoice ( $sale_id ) {
            $data = $this -> db -> get_where ( 'online_test_invoice', array ( 'sale_id' => $sale_id ) );
            return $data -> row ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get parent
         * -------------------------
         */
        
        public function get_parents_by_sale_id ( $sale_id ) {
            $query = $this -> db -> query ( "Select parent_id, sale_id from hmis_test_sales where sale_id='$sale_id' and parent_id > 0 group by parent_id" );
            return $query -> result ();
        }
        
        public function is_lab_invoice_already_refunded ( $sale_id ) {
            $query = $this -> db -> query ( "Select * from hmis_test_sales where sale_id=$sale_id and refunded='1'" );
            if ( $query -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        public function get_lab_sales_total ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(price) as price from hmis_test_sales where sale_id=$sale_id group by sale_id" );
            return $query -> row () -> price;
        }
        
        public function get_previous_test_results ( $sale_id, $test_id ) {
            
            // $sale_id say patient id
            // hmis_test_results is k andar jo Invoice ID aygi wo match krni hai above patient id say
            
            $sale = $this -> get_test_sale_by_id ( $sale_id );
            if ( !empty( $sale ) ) {
                $patient_id = $sale -> patient_id;

//                $query = $this -> db -> query ( "Select * from hmis_test_results where sale_id < $sale_id and test_id=$test_id and sale_id IN (Select sale_id from hmis_test_sales where patient_id=$patient_id) limit 2" );
                
                $sql = "Select * from hmis_test_results where sale_id < $sale_id and test_id=$test_id and sale_id IN (Select sale_id from hmis_test_sales where patient_id=$patient_id)";
                
                if ( isset( $_GET[ 'machine' ] ) && !empty( trim ( $_GET[ 'machine' ] ) ) ) {
                    $machine = $_GET[ 'machine' ];
                    $sql     .= " and machine='$machine'";
                }
                
                $sql .= " order by id DESC limit 2";
                
                $query = $this -> db -> query ( $sql );
                
                return $query -> result ();
            }
            else
                return array ();
        }
        
        public function get_ipd_previous_test_results ( $sale_id, $test_id ) {
            
            // $sale_id say patient id
            // hmis_test_results is k andar jo Invoice ID aygi wo match krni hai above patient id say
            
            $sale = $this -> get_ipd_test_sale_by_id ( $sale_id );
            if ( !empty( $sale ) ) {
                $patient_id = $sale -> patient_id;
                
                $query = $this -> db -> query ( "Select * from hmis_ipd_test_results where sale_id < $sale_id and test_id=$test_id and sale_id IN (Select sale_id from hmis_ipd_patient_associated_lab_tests where patient_id=$patient_id) limit 2" );
                return $query -> result ();
            }
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * get store
         * -------------------------
         * @return mixed
         */
        
        public function get_regents ( $limit = 10000, $offset = 0 ) {
            $sql   = "Select * from hmis_store where type='consumable-lab'";
            $sql   .= " order by item ASC limit $limit offset $offset";
            $store = $this -> db -> query ( $sql );
            return $store -> result ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @return mixed
         * get lab regents
         * -------------------------
         */
        
        public function get_lab_regents ( $test_id ) {
            $regents = $this -> db -> get_where ( 'test_regents', array ( 'test_id' => $test_id ) );
            return $regents -> result ();
        }
        
        /**
         * -------------------------
         * @param $regent_id
         * @param $test_id
         * delete lab regents
         * -------------------------
         */
        
        public function delete_test_regent ( $regent_id, $test_id ) {
            $this -> db -> delete ( 'test_regents', array (
                'id'      => $regent_id,
                'test_id' => $test_id
            ) );
        }
        
        /**
         * -------------------------
         * @return mixed
         * get calibrations
         * -------------------------
         */
        
        public function get_calibrations () {
            $calibrations = $this -> db -> query ( "Select calibration_id, GROUP_CONCAT(test_id) as tests, GROUP_CONCAT(calibration) as calibrations, created_at from hmis_test_calibrations group by calibration_id order by id DESC" );
            return $calibrations -> result ();
        }
        
        /**
         * -------------------------
         * @param $calibration_id
         * @return mixed
         * get calibrations by id
         * -------------------------
         */
        
        public function get_calibrations_by_id ( $calibration_id ) {
            $calibrations = $this -> db -> get_where ( 'test_calibrations', array ( 'calibration_id' => $calibration_id ) );
            return $calibrations -> result ();
        }
        
        /**
         * -------------------------
         * @param $remarks_id
         * @param $sale_id
         * @param $test_id
         * @return mixed
         * get calibrations by id
         * -------------------------
         */
        
        public function check_if_remark_added ( $remarks_id, $sale_id, $test_id ) {
            $added = $this -> db -> get_where ( 'test_result_remarks', array (
                'sale_id'    => $sale_id,
                'remarks_id' => $remarks_id,
                'test_id'    => $test_id
            ) );
            if ( $added -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @param $test_id
         * @return mixed
         * get calibrations by id
         * -------------------------
         */
        
        public function get_test_remarks ( $sale_id, $test_id ) {
            $remarks = $this -> db -> get_where ( 'test_result_remarks', array (
                'sale_id' => $sale_id,
                'test_id' => $test_id
            ) );
            return $remarks -> result ();
        }
        
        /**
         * -------------------------
         * @param $test_id
         * @return mixed
         * get_regent_calibrations
         * -------------------------
         */
        
        public function get_regent_calibrations ( $test_id ) {
            $sql = "Select SUM(calibration) as calibrations from hmis_test_calibrations where test_id=$test_id";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(created_at) BETWEEN '$start_date' and '$end_date'";
            }
            $calibrations = $this -> db -> query ( $sql );
            return $calibrations -> row () -> calibrations;
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * get parent covid tests
         * @return mixed
         * -------------------------
         */
        
        public function get_active_parent_covid_tests ( $panel_id = 0, $category = 'general' ) {
            $sql = "Select * from hmis_tests where parent_id='0' and status='1' and category='$category'";
            if ( $panel_id > 0 ) {
                $sql .= " and id IN (Select test_id from hmis_test_price where panel_id=$panel_id)";
            }
            $sql   .= " order by name ASC";
            $tests = $this -> db -> query ( $sql );
            return $tests -> result ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed|void
         * get patient by Invoice ID
         * -------------------------
         */
        
        public function get_patient_by_lab_sale_id ( $sale_id ) {
            $query = $this -> db -> get_where ( 'test_sales', array ( 'sale_id' => $sale_id ) );
            $data  = $query -> row ();
            if ( !empty( $data ) ) {
                $patient_id = $data -> patient_id;
                if ( $patient_id > 0 )
                    return get_patient ( $patient_id );
            }
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get sale pending results
         * -------------------------
         */
        
        public function get_sale_pending_results ( $limit, $offset ) {
            $user_id  = get_logged_in_user_id ();
            $user     = get_user ( $user_id );
            $panel_id = $user -> panel_id;
            
            $sql = "Select * from hmis_test_sales where (parent_id IS NULL OR parent_id='' OR parent_id=0) and (sale_id, test_id) NOT IN (Select sale_id, test_id from hmis_test_results where id IN (Select result_id from hmis_lab_results_verified)) AND refunded='0'";
            
            if ( isset( $_REQUEST[ 'invoice_id' ] ) and !empty( trim ( $_REQUEST[ 'invoice_id' ] ) ) and is_numeric ( $_REQUEST[ 'invoice_id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'invoice_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            
            if ( isset( $_REQUEST[ 'user-id' ] ) and !empty( trim ( $_REQUEST[ 'user-id' ] ) ) and is_numeric ( $_REQUEST[ 'user-id' ] ) > 0 ) {
                $user_id = $_REQUEST[ 'user-id' ];
                $sql     .= " and user_id=$user_id";
            }
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            
            if ( isset( $_GET[ 'panel-id' ] ) and !empty( trim ( $_GET[ 'panel-id' ] ) ) and $_GET[ 'panel-id' ] > 0 ) {
                $panel_id = $_GET[ 'panel-id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            
            if ( isset( $_GET[ 'airline-id' ] ) and !empty( trim ( $_GET[ 'airline-id' ] ) ) and $_GET[ 'airline-id' ] > 0 ) {
                $airline_id = $_GET[ 'airline-id' ];
                $sql        .= " and airline_id=$airline_id";
            }
            
            if ( !empty( trim ( $panel_id ) ) and $panel_id > 0 ) {
                $sql .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            
            $sql   .= " order by sale_id DESC limit $limit offset $offset";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get all added test results
         * -------------------------
         */
        
        public function all_added_test_results ( $limit, $offset ) {
            $user_id  = get_logged_in_user_id ();
            $user     = get_user ( $user_id );
            $panel_id = $user -> panel_id;
            
            $sql = "Select * from hmis_test_sales where (parent_id IS NULL OR parent_id='' OR parent_id=0) and (sale_id, test_id) IN (Select sale_id, test_id from hmis_test_results where id IN (Select result_id from hmis_lab_results_verified))";
            
            if ( isset( $_REQUEST[ 'invoice_id' ] ) and !empty( trim ( $_REQUEST[ 'invoice_id' ] ) ) and is_numeric ( $_REQUEST[ 'invoice_id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'invoice_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            
            if ( isset( $_GET[ 'panel-id' ] ) and !empty( trim ( $_GET[ 'panel-id' ] ) ) and $_GET[ 'panel-id' ] > 0 ) {
                $panel_id = $_GET[ 'panel-id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            
            if ( isset( $_GET[ 'section-id' ] ) and !empty( trim ( $_GET[ 'section-id' ] ) ) and $_GET[ 'section-id' ] > 0 ) {
                $section_id = $_GET[ 'section-id' ];
                $sql        .= " and test_id IN (Select test_id from hmis_test_sample_info where section_id=$section_id)";
            }
            
            if ( isset( $_GET[ 'patient-name' ] ) and !empty( trim ( $_GET[ 'patient-name' ] ) ) ) {
                $patient_name = $_GET[ 'patient-name' ];
                $sql          .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$patient_name%')";
            }
            
            if ( isset( $_GET[ 'patient-mobile' ] ) and !empty( trim ( $_GET[ 'patient-mobile' ] ) ) ) {
                $patient_mobile = $_GET[ 'patient-mobile' ];
                $sql            .= " and patient_id IN (Select id from hmis_patients where mobile='$patient_mobile')";
            }
            
            if ( isset( $_GET[ 'airline-id' ] ) and !empty( trim ( $_GET[ 'airline-id' ] ) ) and $_GET[ 'airline-id' ] > 0 ) {
                $airline_id = $_GET[ 'airline-id' ];
                $sql        .= " and airline_id=$airline_id";
            }
            
            if ( isset( $_REQUEST[ 'test-id' ] ) and !empty( trim ( $_REQUEST[ 'test-id' ] ) ) and is_numeric ( $_REQUEST[ 'test-id' ] ) > 0 ) {
                $test_id = $_REQUEST[ 'test-id' ];
                $sql     .= " and test_id=$test_id";
            }
            
            if ( !empty( trim ( $panel_id ) ) and $panel_id > 0 ) {
                $sql .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            
            $sql   .= " order by sale_id DESC limit $limit offset $offset";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * count all added test results
         * -------------------------
         */
        
        public function count_all_added_test_results () {
            
            $sql = "Select COUNT(*) as totalRows from hmis_test_sales where (parent_id IS NULL OR parent_id='' OR parent_id=0) and (sale_id, test_id) IN (Select sale_id, test_id from hmis_test_results where id IN (Select result_id from hmis_lab_results_verified))";
            
            if ( isset( $_REQUEST[ 'invoice_id' ] ) and !empty( trim ( $_REQUEST[ 'invoice_id' ] ) ) and is_numeric ( $_REQUEST[ 'invoice_id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'invoice_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            
            if ( isset( $_REQUEST[ 'test-id' ] ) and !empty( trim ( $_REQUEST[ 'test-id' ] ) ) and is_numeric ( $_REQUEST[ 'test-id' ] ) > 0 ) {
                $test_id = $_REQUEST[ 'test-id' ];
                $sql     .= " and test_id=$test_id";
            }
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            
            if ( isset( $_GET[ 'panel-id' ] ) and !empty( trim ( $_GET[ 'panel-id' ] ) ) and $_GET[ 'panel-id' ] > 0 ) {
                $panel_id = $_GET[ 'panel-id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            
            if ( isset( $_GET[ 'section-id' ] ) and !empty( trim ( $_GET[ 'section-id' ] ) ) and $_GET[ 'section-id' ] > 0 ) {
                $section_id = $_GET[ 'section-id' ];
                $sql        .= " and test_id IN (Select test_id from hmis_test_sample_info where section_id=$section_id)";
            }
            
            if ( isset( $_GET[ 'patient-name' ] ) and !empty( trim ( $_GET[ 'patient-name' ] ) ) ) {
                $patient_name = $_GET[ 'patient-name' ];
                $sql          .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$patient_name%')";
            }
            
            if ( isset( $_GET[ 'patient-mobile' ] ) and !empty( trim ( $_GET[ 'patient-mobile' ] ) ) ) {
                $patient_mobile = $_GET[ 'patient-mobile' ];
                $sql            .= " and patient_id IN (Select id from hmis_patients where mobile='$patient_mobile')";
            }
            
            if ( isset( $_GET[ 'airline-id' ] ) and !empty( trim ( $_GET[ 'airline-id' ] ) ) and $_GET[ 'airline-id' ] > 0 ) {
                $airline_id = $_GET[ 'airline-id' ];
                $sql        .= " and airline_id=$airline_id";
            }
            
            $sql   .= " order by sale_id DESC";
            $sales = $this -> db -> query ( $sql );
            return $sales -> row () -> totalRows;
        }
        
        /**
         * -------------------------
         * @return mixed
         * count sale pending results
         * -------------------------
         */
        
        public function count_sale_pending_results () {
            
            $sql = "Select COUNT(*) as totalRows from hmis_test_sales where (parent_id IS NULL OR parent_id='' OR parent_id=0) and (sale_id, test_id) NOT IN (Select sale_id, test_id from hmis_test_results where id IN (Select result_id from hmis_lab_results_verified))";
            
            if ( isset( $_REQUEST[ 'user-id' ] ) and !empty( trim ( $_REQUEST[ 'user-id' ] ) ) and is_numeric ( $_REQUEST[ 'user-id' ] ) > 0 ) {
                $user_id = $_REQUEST[ 'user-id' ];
                $sql     .= " and user_id=$user_id";
            }
            
            if ( isset( $_REQUEST[ 'invoice_id' ] ) and !empty( trim ( $_REQUEST[ 'invoice_id' ] ) ) and is_numeric ( $_REQUEST[ 'invoice_id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'invoice_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            
            if ( isset( $_GET[ 'panel-id' ] ) and !empty( trim ( $_GET[ 'panel-id' ] ) ) and $_GET[ 'panel-id' ] > 0 ) {
                $panel_id = $_GET[ 'panel-id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            
            if ( isset( $_GET[ 'airline-id' ] ) and !empty( trim ( $_GET[ 'airline-id' ] ) ) and $_GET[ 'airline-id' ] > 0 ) {
                $airline_id = $_GET[ 'airline-id' ];
                $sql        .= " and airline_id=$airline_id";
            }
            
            $sql .= " order by sale_id DESC";
            
            $sales = $this -> db -> query ( $sql );
            return $sales -> row () -> totalRows;
        }
        
        public function get_lab_sale_previous_receiving_total ( $sale_id ) {
            $data = $this -> db -> query ( "Select SUM(amount) as  totalAmount from hmis_lab_sales_receiving where sale_id=$sale_id" );
            return $data -> row () -> totalAmount;
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save tests into database
         * -------------------------
         */
        
        public function add_lab_receiving ( $data ) {
            $this -> db -> insert ( 'lab_sales_receiving', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add test result image
         * -------------------------
         */
        
        public function add_test_result_image ( $data ) {
            $this -> db -> insert ( 'test_result_image', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get lab sale receiving
         * -------------------------
         */
        
        public function get_lab_sale_receiving ( $sale_id ) {
            $data = $this -> db -> get_where ( 'lab_sales_receiving', array ( 'sale_id' => $sale_id ) );
            return $data -> result ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @param $test_id
         * @return mixed
         * get lab test result image
         * -------------------------
         */
        
        public function get_test_result_image ( $sale_id, $test_id ) {
            $this -> db -> order_by ( 'id', 'DESC' );
            $data = $this -> db -> get_where ( 'test_result_image', array (
                'sale_id' => $sale_id,
                'test_id' => $test_id
            ) );
            return $data -> row ();
        }
        
        public function get_lab_sale_received_amount ( $sale_id ) {
            $sql = "Select SUM(amount) as totalAmount from hmis_lab_sales_receiving where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(created_at) BETWEEN '$start_date' and '$end_date'";
            }
            if ( isset( $_REQUEST[ 'user-id' ] ) and !empty( trim ( $_REQUEST[ 'user-id' ] ) ) ) {
                $user_id = $_REQUEST[ 'user-id' ];
                $sql     .= " and user_id=$user_id";
            }
            $tests = $this -> db -> query ( $sql );
            return $tests -> row () -> totalAmount;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get lab sales total sale
         * by date range
         * -------------------------
         */
        
        public function get_lab_sales_daily_closing_report () {
            $search = false;
            $sql    = "Select user_id, GROUP_CONCAT(total) as totalCharges from hmis_lab_sales where id IN (Select sale_id from hmis_test_sales where refunded='0')";
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_sale) Between '$start_date' and '$end_date'";
                $search     = true;
            }
            
            if ( isset( $_REQUEST[ 'user_id' ] ) and $_REQUEST[ 'user_id' ] > 0 ) {
                $user_id = $_REQUEST[ 'user_id' ];
                $sql     .= " and user_id=$user_id";
                $search  = true;
            }
            
            $sql   .= " group by user_id";
            $query = $this -> db -> query ( $sql );
            if ( $search )
                return $query -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * count sale pending ipd results
         * -------------------------
         */
        
        public function count_sale_pending_results_ipd () {
            
            $sql = "Select COUNT(*) as totalRows from hmis_ipd_patient_associated_lab_tests where (parent_id IS NULL OR parent_id='' OR parent_id=0) and (sale_id, test_id) NOT IN (Select sale_id, test_id from hmis_ipd_test_results)";
            
            if ( isset( $_REQUEST[ 'invoice_id' ] ) and !empty( trim ( $_REQUEST[ 'invoice_id' ] ) ) and is_numeric ( $_REQUEST[ 'invoice_id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'invoice_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            
            if ( isset( $_GET[ 'panel-id' ] ) and !empty( trim ( $_GET[ 'panel-id' ] ) ) and $_GET[ 'panel-id' ] > 0 ) {
                $panel_id = $_GET[ 'panel-id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            
            $sql .= " order by sale_id DESC";
            
            $sales = $this -> db -> query ( $sql );
            return $sales -> row () -> totalRows;
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get sale pending ipd results
         * -------------------------
         */
        
        public function get_sale_pending_results_ipd ( $limit, $offset ) {
            
            $sql = "Select * from hmis_ipd_patient_associated_lab_tests where (parent_id IS NULL OR parent_id='' OR parent_id=0) and (sale_id, test_id) NOT IN (Select sale_id, test_id from hmis_ipd_test_results)";
            
            if ( isset( $_REQUEST[ 'invoice_id' ] ) and !empty( trim ( $_REQUEST[ 'invoice_id' ] ) ) and is_numeric ( $_REQUEST[ 'invoice_id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'invoice_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            
            if ( isset( $_GET[ 'panel-id' ] ) and !empty( trim ( $_GET[ 'panel-id' ] ) ) and $_GET[ 'panel-id' ] > 0 ) {
                $panel_id = $_GET[ 'panel-id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            
            $sql .= " order by sale_id DESC limit $limit offset $offset";
            
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * count sale added ipd results
         * -------------------------
         */
        
        public function count_sale_added_results_ipd () {
            
            $sql = "Select COUNT(*) as totalRows from hmis_ipd_patient_associated_lab_tests where (parent_id IS NULL OR parent_id='' OR parent_id=0) and (sale_id, test_id) IN (Select sale_id, test_id from hmis_ipd_test_results)";
            
            if ( isset( $_REQUEST[ 'invoice_id' ] ) and !empty( trim ( $_REQUEST[ 'invoice_id' ] ) ) and is_numeric ( $_REQUEST[ 'invoice_id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'invoice_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            
            if ( isset( $_GET[ 'panel-id' ] ) and !empty( trim ( $_GET[ 'panel-id' ] ) ) and $_GET[ 'panel-id' ] > 0 ) {
                $panel_id = $_GET[ 'panel-id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            
            $sql .= " order by sale_id DESC";
            
            $sales = $this -> db -> query ( $sql );
            return $sales -> row () -> totalRows;
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get sale added ipd results
         * -------------------------
         */
        
        public function get_sale_added_results_ipd ( $limit, $offset ) {
            
            $sql = "Select * from hmis_ipd_patient_associated_lab_tests where (parent_id IS NULL OR parent_id='' OR parent_id=0) and (sale_id, test_id) IN (Select sale_id, test_id from hmis_ipd_test_results)";
            
            if ( isset( $_REQUEST[ 'invoice_id' ] ) and !empty( trim ( $_REQUEST[ 'invoice_id' ] ) ) and is_numeric ( $_REQUEST[ 'invoice_id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'invoice_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            
            if ( isset( $_GET[ 'panel-id' ] ) and !empty( trim ( $_GET[ 'panel-id' ] ) ) and $_GET[ 'panel-id' ] > 0 ) {
                $panel_id = $_GET[ 'panel-id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            
            $sql .= " order by sale_id DESC limit $limit offset $offset";
            
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * ---------------------
         * @param $sale_id
         * @param $test_id
         * @return mixed
         * get report delivery status
         * ---------------------
         */
        
        public function get_report_delivery_status ( $sale_id, $test_id ) {
            $delivery = $this -> db -> get_where ( 'lab_report_delivery', array (
                'sale_id' => $sale_id,
                'test_id' => $test_id
            ) );
            return $delivery -> row ();
        }
        
        /**
         * ---------------------
         * @param $sale_id
         * @param $test_id
         * @return mixed
         * update report delivery status
         * ---------------------
         */
        
        public function update_delivery_status ( $sale_id, $test_id ) {
            $this -> db -> insert ( 'lab_report_delivery', array (
                'user_id' => get_logged_in_user_id (),
                'sale_id' => $sale_id,
                'test_id' => $test_id
            ) );
        }
        
        public function bulk_update_prices () {
            $panels    = $this -> input -> post ( 'panels' );
            $tests     = $this -> input -> post ( 'tests' );
            $increment = $this -> input -> post ( 'increment' );
            $type      = $this -> input -> post ( 'type' );
            
            if ( $type == 'percentage' ) {
                $sql = "Update hmis_test_price SET price=price + (price * $increment / 100.0) where 1";
            }
            
            else {
                $sql = "Update hmis_test_price SET price=price+$increment where 1";
            }
            
            if ( isset( $panels ) and count ( $panels ) > 0 ) {
                $panels = implode ( ',', $panels );
                $sql    .= " and panel_id IN ($panels)";
            }
            
            if ( isset( $tests ) and count ( $tests ) > 0 ) {
                $tests = implode ( ',', $tests );
                $sql   .= " and test_id IN ($tests)";
            }
            
            $this -> db -> query ( $sql );
            
        }
        
        public function get_test_protocols () {
            $this
                -> db
                -> select ( 'hmis_tests.id, hmis_tests.code, hmis_tests.name, hmis_test_details.protocol' )
                -> from ( 'hmis_tests' )
                -> join ( 'hmis_test_details', 'hmis_tests.id = hmis_test_details.test_id AND hmis_test_details.protocol IS NOT NULL AND hmis_test_details.protocol != ""' );
            $tests = $this -> db -> get ();
            return $tests -> result ();
        }
        
        public function get_lab_total ( $refunded = false ) {
            
            $start_date = $this -> input -> get ( 'start_date' );
            $end_date   = $this -> input -> get ( 'end_date' );
            $start_time = $this -> input -> get ( 'start_time' );
            $end_time   = $this -> input -> get ( 'end_time' );
            $user_id    = $this -> input -> get ( 'user_id' );
            
            $this
                -> db
                -> select ( 'SUM(total) as net' )
                -> from ( 'lab_sales' )
                -> where ( "patient_id IN (Select id FROM hmis_patients WHERE (panel_id='0' OR panel_id='' OR panel_id < 1 OR panel_id IS NULL))" );
            
            if ( isset( $start_date ) and !empty( trim ( $start_date ) ) and isset( $end_date ) and !empty( trim ( $end_date ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                $this -> db -> where ( "DATE(date_sale) Between '$start_date' and '$end_date'" );
            }
            
            if ( isset( $start_time ) and isset( $end_time ) and !empty( $start_time ) and !empty( $end_time ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $start_time ) );
                $end_time   = date ( 'H:i:s', strtotime ( $end_time ) );
                $this -> db -> where ( "TIME(date_sale) BETWEEN '$start_time' and '$end_time'" );
            }
            
            if ( isset( $user_id ) and $user_id > 0 ) {
                $this -> db -> where ( 'user_id', $user_id );
            }
            
            if ( $refunded ) {
                $this -> db -> where ( "id IN (Select sale_id FROM hmis_test_sales WHERE refunded='1')" );
            }
            
            $query = $this -> db -> get ();
            return $query -> row () -> net;
        }
        
        public function update_child_tests_status ( $test_id, $status ) {
            $this -> db -> update ( 'tests', array ( 'status' => $status ), array ( 'parent_id' => $test_id ) );
        }
        
        public function set_lab_sort_order () {
            $parent_id = $this -> input -> post ( 'parent_id' );
            if ( $parent_id > 0 ) {
                $this -> db -> select ( "MAX(sort_order) as sort_order" ) -> from ( 'tests' ) -> where ( "parent_id=$parent_id" );
                $query = $this -> db -> get ();
                $order = $query -> row () -> sort_order;
                return $order + 1;
            }
            
            return '0';
        }
        
        public function get_tests_not_in_panel ( $panel_id ) {
            $this -> db -> order_by ( 'name', 'ASC' );
            $this
                -> db -> select ( '*' )
                -> from ( 'tests' )
                -> where ( array ( 'parent_id' => '0', 'status' => '1', 'category' => 'general' ) )
                -> where ( "id NOT IN (Select test_id From hmis_panel_lab_tests WHERE panel_id=$panel_id)" );
            $services = $this -> db -> get ();
            return $services -> result ();
        }
        
        public function get_lab_total_by_payment_method ( $method = 'cash' ) {
            
            $start_date = $this -> input -> get ( 'start_date' );
            $end_date   = $this -> input -> get ( 'end_date' );
            $user_id    = $this -> input -> get ( 'user_id' );
            
            $this
                -> db
                -> select ( 'SUM(ABS(total)) as net' )
                -> from ( 'lab_sales' )
                -> where ( "id IN (Select sale_id FROM hmis_test_sales WHERE patient_id IN (Select id FROM hmis_patients WHERE (panel_id < 1 OR panel_id IS NULL OR panel_id='')))" );
            
            if ( isset( $start_date ) and !empty( trim ( $start_date ) ) and isset( $end_date ) and !empty( trim ( $end_date ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                $this -> db -> where ( "DATE(date_sale) Between '$start_date' and '$end_date'" );
            }
            
            if ( isset( $user_id ) and $user_id > 0 ) {
                $this -> db -> where ( 'user_id', $user_id );
            }
            
            $this -> db -> where ( 'payment_method', $method );
            $query = $this -> db -> get ();
            return $query -> row () -> net;
        }
        
        public function get_lab_refunded_total () {
            
            $start_date = $this -> input -> get ( 'start_date' );
            $end_date   = $this -> input -> get ( 'end_date' );
            $user_id    = $this -> input -> get ( 'user_id' );
            
            $this
                -> db
                -> select ( 'SUM(ABS(total)) as net' )
                -> from ( 'lab_sales' )
                -> where ( "id IN (Select sale_id FROM hmis_test_sales WHERE patient_id IN (Select id FROM hmis_patients WHERE (panel_id < 1 OR panel_id IS NULL OR panel_id='')))" );
            
            if ( isset( $start_date ) and !empty( trim ( $start_date ) ) and isset( $end_date ) and !empty( trim ( $end_date ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                $this -> db -> where ( "DATE(date_sale) Between '$start_date' and '$end_date'" );
            }
            
            if ( isset( $user_id ) and $user_id > 0 ) {
                $this -> db -> where ( 'user_id', $user_id );
            }
            
            $this -> db -> where ( "id IN (Select sale_id FROM hmis_test_sales WHERE refunded='1')" );
            $query = $this -> db -> get ();
            return $query -> row () -> net;
        }
        
        public function update_test_sale ( $info, $sale_id ) {
            $this -> db -> update ( 'test_sales', $info, array ( 'id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        public function get_doctor_daily_payable () {
            
            $start_date = date ( 'Y-m-d' );
            $end_date   = date ( 'Y-m-d' );
            $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
            $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
            $sales      = array ();
            
            $this
                -> db
                -> select ( 'id as sale_id, doctor_id, net, doctor_share' )
                -> from ( 'lab_sales' );
            
            $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
            $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
            $this -> db -> where ( "DATE(date_sale) Between '$start_date' and '$end_date'" );
            
            $this -> db -> where ( "id IN (Select sale_id FROM hmis_test_sales WHERE refunded='0')" );
            $query  = $this -> db -> get ();
            $shares = $query -> result ();
            
            $netShare = 0;
            if ( count ( $shares ) > 0 ) {
                foreach ( $shares as $share ) {
                    $netShare += ( ( $share -> net * $share -> doctor_share ) / 100 );
                    $sales[]  = $share -> sale_id;
                }
            }
            return array (
                'net'   => $netShare,
                'sales' => $sales
            );
        }
        
        public function get_doctor_share_general_report () {
            $search = false;
            $sql    = "Select sale_id, patient_id, GROUP_CONCAT(test_id) as tests, parent_id, type, SUM(price) as price, status, remarks, refunded, date_added from hmis_test_sales where sale_id IN (Select id FROM hmis_lab_sales WHERE doctor_share > 0)";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
                $search     = true;
            }
            if ( isset( $_REQUEST[ 'panel-id' ] ) and !empty( trim ( $_REQUEST[ 'panel-id' ] ) ) and is_numeric ( $_REQUEST[ 'panel-id' ] ) > 0 ) {
                $panel_id = $_REQUEST[ 'panel-id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
                $search   = true;
            }
            else if ( isset( $_REQUEST[ 'panel-id' ] ) and !empty( trim ( $_REQUEST[ 'panel-id' ] ) ) and $_REQUEST[ 'panel-id' ] == 'cash' ) {
                $sql    .= " and patient_id IN (Select id from hmis_patients where (panel_id IS NULL OR panel_id='0' OR panel_id=''))";
                $search = true;
            }
            else if ( isset( $_REQUEST[ 'exclude-cash' ] ) and !empty( trim ( $_REQUEST[ 'exclude-cash' ] ) ) and $_REQUEST[ 'exclude-cash' ] == 'yes' ) {
                $sql    .= " and patient_id IN (Select id from hmis_patients where (panel_id IS NOT NULL AND panel_id > 0 OR panel_id!=''))";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'panel-id' ] ) and $_REQUEST[ 'panel-id' ] == 'cash' ) {
                $sql    .= " and patient_id NOT IN (Select id from hmis_patients where panel_id > 0)";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'test_id' ] ) and !empty( trim ( $_REQUEST[ 'test_id' ] ) ) and is_numeric ( $_REQUEST[ 'test_id' ] ) > 0 ) {
                $test_id = $_REQUEST[ 'test_id' ];
                $sql     .= " and test_id=$test_id";
                $search  = true;
            }
            if ( isset( $_REQUEST[ 'sale_id' ] ) and !empty( trim ( $_REQUEST[ 'sale_id' ] ) ) and is_numeric ( $_REQUEST[ 'sale_id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sql     .= " and sale_id=$sale_id";
                $search  = true;
            }
            if ( isset( $_REQUEST[ 'start_time' ] ) and isset( $_REQUEST[ 'end_time' ] ) and !empty( $_REQUEST[ 'start_time' ] ) and !empty( $_REQUEST[ 'end_time' ] ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'start_time' ] ) );
                $end_time   = date ( 'H:i:s', strtotime ( $_REQUEST[ 'end_time' ] ) );
                $sql        .= " and TIME(date_added) BETWEEN '$start_time' and '$end_time'";
                $search     = true;
            }
            if ( isset( $_GET[ 'user-id' ] ) and !empty( trim ( $_GET[ 'user-id' ] ) ) and $_GET[ 'user-id' ] > 0 ) {
                $user_id = $_GET[ 'user-id' ];
                $sql     .= " and user_id=$user_id";
                $search  = true;
            }
            if ( isset( $_REQUEST[ 'reference-id' ] ) and $_REQUEST[ 'reference-id' ] > 0 ) {
                $reference_id = $_GET[ 'reference-id' ];
                $sql          .= " and sale_id IN (Select id from hmis_lab_sales where reference_id=$reference_id)";
                $search       = true;
            }
            $sql   .= " group by sale_id order by DATE(date_added) ASC";
            $sales = $this -> db -> query ( $sql );
            if ( $search )
                return $sales -> result ();
            else
                return array ();
        }
        
        public function get_test_panels ( $test_id ) {
            $this
                -> db -> select ( '*' )
                -> from ( 'panel_lab_tests' )
                -> where ( array ( 'test_id' => $test_id ) );
            $services = $this -> db -> get ();
            return $services -> result ();
        }
    }
