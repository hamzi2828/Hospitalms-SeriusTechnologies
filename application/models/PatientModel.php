<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class PatientModel extends CI_Model {
        
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
         * save patients into database
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'patients', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save patient panel info into database
         * -------------------------
         */
        
        public function add_panel_patient_link_with_company ( $data ) {
            $this -> db -> insert ( 'panel_patient', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $patient_id
         * delete patient panel info
         * -------------------------
         */
        
        public function delete_panel_record ( $patient_id ) {
            $this -> db -> delete ( 'panel_patient', array ( 'patient_id' => $patient_id ) );
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * get patients
         * -------------------------
         * @return mixed
         */
        
        public function get_patients ( $limit = 0, $offset = 0 ) {
            $user     = get_user ( get_logged_in_user_id () );
            $user_id  = $user -> id;
            $panel_id = $user -> panel_id;
            
            $sql = "Select * from hmis_patients where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_registered) BETWEEN '$start_date' AND '$end_date'";
            }
            if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
                $id  = $_REQUEST[ 'id' ];
                $sql .= " and id=$id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql  .= " and name LIKE '%$name%'";
            }
            if ( isset( $_REQUEST[ 'cnic' ] ) and !empty( trim ( $_REQUEST[ 'cnic' ] ) ) ) {
                $cnic = $_REQUEST[ 'cnic' ];
                $sql  .= " and cnic='$cnic'";
            }
            if ( isset( $_REQUEST[ 'phone' ] ) and !empty( trim ( $_REQUEST[ 'phone' ] ) ) ) {
                $phone = $_REQUEST[ 'phone' ];
                $sql   .= " and mobile='$phone'";
            }
            if ( isset( $_REQUEST[ 'patient-type' ] ) and !empty( trim ( $_REQUEST[ 'patient-type' ] ) ) ) {
                $type = $_REQUEST[ 'patient-type' ];
                if ( $type != 'cash' )
                    $sql .= " and panel_id='$type'";
                else
                    $sql .= " and (panel_id < 1 OR panel_id IS NULL or panel_id='')";
                $search = true;
            }
            
            if ( $panel_id > 0 ) {
                $sql .= " and user_id=$user_id";
            }
            
            $sql .= " order by id DESC";
            if ( $limit > 0 )
                $sql .= " limit $limit offset $offset";
            $patients = $this -> db -> query ( $sql );
            return $patients -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * count patients
         * -------------------------
         */
        
        public function count_patients () {
            $user     = get_user ( get_logged_in_user_id () );
            $user_id  = $user -> id;
            $panel_id = $user -> panel_id;
            
            $sql = "Select COUNT(*) as totalRows from hmis_patients where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_registered) BETWEEN '$start_date' AND '$end_date'";
            }
            if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
                $id  = $_REQUEST[ 'id' ];
                $sql .= " and id=$id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql  .= " and name LIKE '%$name%'";
            }
            if ( isset( $_REQUEST[ 'cnic' ] ) and !empty( trim ( $_REQUEST[ 'cnic' ] ) ) ) {
                $cnic = $_REQUEST[ 'cnic' ];
                $sql  .= " and cnic='$cnic'";
            }
            if ( isset( $_REQUEST[ 'phone' ] ) and !empty( trim ( $_REQUEST[ 'phone' ] ) ) ) {
                $phone = $_REQUEST[ 'phone' ];
                $sql   .= " and mobile='$phone'";
            }
            if ( isset( $_REQUEST[ 'patient-type' ] ) and !empty( trim ( $_REQUEST[ 'patient-type' ] ) ) ) {
                $type = $_REQUEST[ 'patient-type' ];
                if ( $type != 'cash' )
                    $sql .= " and panel_id='$type'";
                else
                    $sql .= " and (panel_id < 1 OR panel_id IS NULL or panel_id='')";
                $search = true;
            }
            
            if ( $panel_id > 0 ) {
                $sql .= " and user_id=$user_id";
            }
            
            $patients = $this -> db -> query ( $sql );
            return $patients -> row () -> totalRows;
        }
        
        /**
         * -------------------------
         * @param $patient_id
         * @return mixed
         * get patients by id
         * -------------------------
         */
        
        public function get_patient_by_id ( $patient_id ) {
            $patient = $this -> db -> get_where ( 'patients', array ( 'id' => $patient_id ) );
            return $patient -> row ();
        }
        
        /**
         * -------------------------
         * @param $patient_id
         * @return mixed
         * get patients by id
         * -------------------------
         */
        
        public function get_patient ( $patient_id ) {
            $patient = $this -> db -> get_where ( 'patients', array ( 'id' => $patient_id ) );
            return $patient -> row ();
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * @return mixed
         * get panel by id
         * -------------------------
         */
        
        public function get_panel_by_id ( $panel_id ) {
            $panel = $this -> db -> get_where ( 'panels', array ( 'id' => $panel_id ) );
            return $panel -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $patient_id
         * @return mixed
         * update patients info
         * -------------------------
         */
        
        public function edit ( $data, $patient_id ) {
            $this -> db -> update ( 'patients', $data, array ( 'id' => $patient_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $patient_id
         * @return mixed
         * update patients info
         * -------------------------
         */
        
        public function delete ( $patient_id ) {
            $this -> db -> delete ( 'patients', array ( 'id' => $patient_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $patient_id
         * @return mixed
         * update patients info
         * -------------------------
         */
        
        public function reactive ( $patient_id ) {
            $this -> db -> update ( 'patients', array ( 'status' => '1' ), array ( 'id' => $patient_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $cnic
         * @return mixed
         * check if patient exists by cnic
         * -------------------------
         */
        
        public function check_customer_exists_by_cnic ( $cnic ) {
            $patient = $this -> db -> get_where ( 'patients', array ( 'cnic' => $cnic ) );
            return $patient -> row ();
        }
        
        /**
         * -------------------------
         * @param $patient_id
         * @return mixed
         * get patient vitals by id
         * -------------------------
         */
        
        public function get_patient_vitals ( $patient_id ) {
            $vitals = $this -> db -> query ( "Select GROUP_CONCAT(vital_key) as vital_key, GROUP_CONCAT(vital_value) as vital_value, patient_id, date_added from hmis_patient_vitals where patient_id=$patient_id group by vital_id order by DATE(date_added) DESC" );
            return $vitals -> result ();
        }
        
        /**
         * -------------------------
         * @param $patient_id
         * @return mixed
         * get patient consultancies by id
         * -------------------------
         */
        
        public function get_patient_consultancies ( $patient_id ) {
            $consultancies = $this -> db -> query ( "Select * from hmis_consultancies where patient_id=$patient_id order by DATE(date_added) DESC" );
            return $consultancies -> result ();
        }
        
        /**
         * -------------------------
         * @param $patient_id
         * @return mixed
         * get patient vitals by id
         * -------------------------
         */
        
        public function get_patient_services ( $patient_id ) {
            $services = $this -> db -> query ( "Select sale_id, GROUP_CONCAT(service_id) as services, GROUP_CONCAT(price) as prices, GROUP_CONCAT(discount) as discounts, GROUP_CONCAT(net_price) as net_prices, patient_id, date_added from hmis_opd_services_sales where patient_id=$patient_id group by sale_id order by DATE(date_added) DESC" );
            return $services -> result ();
        }
        
        /**
         * -------------------------
         * @param $patient_id
         * @return mixed
         * get patient vitals by id
         * -------------------------
         */
        
        public function get_patient_medicines ( $patient_id ) {
            $services = $this -> db -> query ( "Select sale_id, GROUP_CONCAT(medicine_id) as medicines, GROUP_CONCAT(stock_id) as stocks, GROUP_CONCAT(quantity) as quantities, GROUP_CONCAT(price) as prices, GROUP_CONCAT(net_price) as net_prices, patient_id, date_sold from hmis_medicines_sold where patient_id=$patient_id group by sale_id order by DATE(date_sold) DESC" );
            return $services -> result ();
        }
        
        public function get_patient_ipd_medicines ( $patient_id ) {
            $services = $this -> db -> query ( "Select sale_id, GROUP_CONCAT(medicine_id) as medicines, GROUP_CONCAT(stock_id) as stocks, GROUP_CONCAT(quantity) as quantities, GROUP_CONCAT(price) as prices, GROUP_CONCAT(net_price) as net_prices, patient_id, date_added from hmis_ipd_medication where patient_id=$patient_id group by sale_id order by DATE(date_added) DESC" );
            return $services -> result ();
        }
        
        /**
         * -------------------------
         * @param $patient_id
         * @return mixed
         * get patient vitals by id
         * -------------------------
         */
        
        public function get_patient_lab_tests ( $patient_id ) {
            $services = $this -> db -> query ( "Select sale_id, patient_id, GROUP_CONCAT(test_id) as tests, GROUP_CONCAT(price) as prices, date_added from hmis_test_sales where patient_id=$patient_id and status='1' group by sale_id order by DATE(date_added) DESC" );
            return $services -> result ();
        }
        
        public function get_patient_ipd_lab_tests ( $patient_id ) {
            $services = $this -> db -> query ( "Select sale_id, patient_id, GROUP_CONCAT(test_id) as tests, GROUP_CONCAT(price) as prices, date_added from hmis_ipd_patient_associated_lab_tests where patient_id=$patient_id group by sale_id order by DATE(date_added) DESC" );
            return $services -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * search patients
         * -------------------------
         */
        
        public function search_patients () {
            $search = false;
            $sql    = "Select * from hmis_patients where 1";
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name   = $_REQUEST[ 'name' ];
                $sql    .= " and name LIKE '%$name%'";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'cnic' ] ) and !empty( trim ( $_REQUEST[ 'cnic' ] ) ) ) {
                $cnic   = $_REQUEST[ 'cnic' ];
                $sql    .= " and cnic LIKE '%$cnic%'";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'phone' ] ) and !empty( trim ( $_REQUEST[ 'phone' ] ) ) ) {
                $phone  = $_REQUEST[ 'phone' ];
                $sql    .= " and mobile LIKE '%$phone%'";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'emr' ] ) and !empty( trim ( $_REQUEST[ 'emr' ] ) ) ) {
                $emr    = $_REQUEST[ 'emr' ];
                $sql    .= " and id=$emr";
                $search = true;
            }
            $query = $this -> db -> query ( $sql );
            if ( $search )
                return $query -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add cities
         * -------------------------
         */
        
        public function do_add_city ( $data ) {
            $this -> db -> insert ( 'cities', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get cities
         * -------------------------
         */
        
        public function get_cities () {
            $this -> db -> order_by ( 'title', 'ASC' );
            $cities = $this -> db -> get ( 'cities' );
            return $cities -> result ();
        }
        
        /**
         * -------------------------
         * @param $city_id
         * @return mixed
         * delete city
         * -------------------------
         */
        
        public function delete_city ( $city_id ) {
            $this -> db -> delete ( 'cities', array ( 'id' => $city_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $patient_id
         * @return mixed
         * get cities by id
         * -------------------------
         */
        
        public function get_city_by_id ( $patient_id ) {
            $city = $this -> db -> get_where ( 'cities', array ( 'id' => $patient_id ) );
            return $city -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $city_id
         * @return mixed
         * update city info
         * -------------------------
         */
        
        public function do_edit_city ( $data, $city_id ) {
            $this -> db -> update ( 'cities', $data, array ( 'id' => $city_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $patient_id
         * check patient type
         * -------------------------
         * @return mixed
         */
        
        public function check_patient_type ( $patient_id ) {
            $patient = $this -> db -> get_where ( 'patients', array ( 'id' => $patient_id ) );
            if ( $patient )
                return $patient -> row () -> type;
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * @return bool
         * check if panel has patients
         * -------------------------
         */
        
        public function check_if_panel_has_patients ( $panel_id ) {
            $patients = $this -> db -> get_where ( 'patients', array ( 'panel_id' => $panel_id ) );
            if ( $patients -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param bool $panel
         * @return mixed
         * get patients panel/without panel
         * -------------------------
         */
        
        public function getPatients ( $panel = false ) {
            $year = date ( 'Y' );
            $sql  = "Select COUNT(*) as totalRows, date_registered from hmis_patients where 1";
            
            if ( isset( $_REQUEST[ 'start-date' ] ) and !empty( trim ( $_REQUEST[ 'start-date' ] ) ) and isset( $_REQUEST[ 'end-date' ] ) and !empty( trim ( $_REQUEST[ 'end-date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start-date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end-date' ] ) );
                $sql        .= " and DATE(date_registered) BETWEEN '$start_date' AND '$end_date'";
            }
            else {
                $sql .= " and YEAR(date_registered)='$year'";
            }
            
            if ( $panel )
                $sql .= " and panel_id > 0";
            else
                $sql .= " and (panel_id = 0 or panel_id < 1 or panel_id IS NULL)";
            $sql      .= " group by DATE_FORMAT(date_registered, '%Y-%m') order by DATE_FORMAT(date_registered, '%Y-%m') ASC";
            $patients = $this -> db -> query ( $sql );
            return $patients -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get patients panel
         * -------------------------
         */
        
        public function getPanelPatients () {
            $sql = "Select COUNT(*) as totalRows, panel_id, date_registered from hmis_patients where 1";
            
            if ( isset( $_REQUEST[ 'start-date' ] ) and !empty( trim ( $_REQUEST[ 'start-date' ] ) ) and isset( $_REQUEST[ 'end-date' ] ) and !empty( trim ( $_REQUEST[ 'end-date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start-date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end-date' ] ) );
                $sql        .= " and DATE(date_registered) BETWEEN '$start_date' AND '$end_date'";
            }
            
            $sql      .= " and (panel_id != 0 AND panel_id > 0 AND panel_id IS NOT NULL)";
            $sql      .= " group by panel_id order by DATE_FORMAT(date_registered, '%Y-%m') ASC";
            $patients = $this -> db -> query ( $sql );
            return $patients -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get patients panel
         * -------------------------
         */
        
        public function getPanelPatientsLineChart () {
            $sql = "Select COUNT(*) as totalRows, panel_id, date_registered from hmis_patients where 1";
            
            if ( isset( $_REQUEST[ 'start-date' ] ) and !empty( trim ( $_REQUEST[ 'start-date' ] ) ) and isset( $_REQUEST[ 'end-date' ] ) and !empty( trim ( $_REQUEST[ 'end-date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start-date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end-date' ] ) );
                $sql        .= " and DATE(date_registered) BETWEEN '$start_date' AND '$end_date'";
            }
            
            $sql      .= " and (panel_id != 0 AND panel_id > 0 AND panel_id IS NOT NULL)";
            $sql      .= " group by panel_id order by DATE_FORMAT(date_registered, '%Y-%m') ASC";
            $patients = $this -> db -> query ( $sql );
            return $patients -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get patients city wise
         * -------------------------
         */
        
        public function getCityWisePatients () {
            $sql = "Select COUNT(*) as totalRows, city from hmis_patients where city IS NOT NULL and city!=''";
            
            if ( isset( $_REQUEST[ 'start-date' ] ) and !empty( trim ( $_REQUEST[ 'start-date' ] ) ) and isset( $_REQUEST[ 'end-date' ] ) and !empty( trim ( $_REQUEST[ 'end-date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start-date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end-date' ] ) );
                $sql        .= " and DATE(date_registered) BETWEEN '$start_date' AND '$end_date'";
            }
            
            $sql      .= " group by city";
            $patients = $this -> db -> query ( $sql );
            return $patients -> result ();
        }
        
        /**
         * -------------------------
         * @param bool $panel
         * @return mixed
         * count patients panel/without panel
         * -------------------------
         */
        
        public function countPatients ( $panel = false ) {
            $year = date ( 'Y' );
            $sql  = "Select COUNT(*) as totalRows from hmis_patients where 1";
            
            if ( isset( $_REQUEST[ 'start-date' ] ) and !empty( trim ( $_REQUEST[ 'start-date' ] ) ) and isset( $_REQUEST[ 'end-date' ] ) and !empty( trim ( $_REQUEST[ 'end-date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start-date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end-date' ] ) );
                $sql        .= " and DATE(date_registered) BETWEEN '$start_date' AND '$end_date'";
            }
            
            if ( $panel )
                $sql .= " and panel_id > 0";
            else
                $sql .= " and (panel_id = 0 or panel_id < 1 or panel_id IS NULL)";
            $patients = $this -> db -> query ( $sql );
            return $patients -> row () -> totalRows;
        }
        
        public function get_patient_ipd_services ( $patient_id ) {
            $services = $this -> db -> query ( "Select sale_id, GROUP_CONCAT(service_id) as services, GROUP_CONCAT(price) as prices, GROUP_CONCAT(net_price) as net_prices, patient_id, date_added from hmis_ipd_patient_associated_services where patient_id=$patient_id group by sale_id order by DATE(date_added) DESC" );
            return $services -> result ();
        }
        
        public function get_patient_ipd_record ( $patient_id ) {
            $this -> db -> order_by ( 'id', 'DESC' );
            $record = $this -> db -> get_where ( 'ipd_sold_services', array ( 'patient_id' => $patient_id, 'trash' => '0' ) );
            return $record -> result ();
        }
        
        public function get_patient_history_files ( $patient_id ) {
            $this -> db -> order_by ( 'id', 'DESC' );
            $record = $this -> db -> get_where ( 'patient_history_files', array ( 'patient_id' => $patient_id ) );
            return $record -> result ();
        }
        
        public function add_files ( $data ) {
            $this -> db -> insert ( 'patient_history_files', $data );
            return $this -> db -> insert_id ();
        }
        
        public function count_patients_doctor ( $patients ) {
            $cash  = 0;
            $panel = 0;
            
            if ( count ( $patients ) > 0 ) {
                foreach ( $patients as $patient_id ) {
                    $query  = $this -> db -> query ( "Select COUNT(*) as totalRows From hmis_patients WHERE id=$patient_id AND panel_id > 0" );
                    $record = $query -> row ();
                    ( $record -> totalRows > 0 ) ? $panel++ : $cash++;
                }
            }
            
            return array ( $cash, $panel );
        }
        
        public function count_panel_patients_doctor ( $patients, $panel_id = 0 ) {
            $cash  = 0;
            $panel = 0;
            
            if ( count ( $patients ) > 0 ) {
                foreach ( $patients as $patient_id ) {
                    $query  = $this -> db -> query ( "Select COUNT(*) as totalRows From hmis_patients WHERE id=$patient_id AND panel_id='$panel_id'" );
                    $record = $query -> row ();
                    ( $record -> totalRows > 0 ) ? $panel++ : $cash++;
                }
            }
            
            return $panel;
        }
        
        public function delete_history_file ( $id ) {
            $this -> db -> delete ( 'patient_history_files', array ( 'id' => $id ) );
        }
        
    }