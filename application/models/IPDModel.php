<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class IPDModel extends CI_Model {
        
        /**
         * --------------
         * IPDModel constructor.
         * --------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * --------------
         * @param $panel_id
         * get parent services
         * @return mixed
         * --------------
         */
        
        public function get_parent_services ( $panel_id = 0 ) {
            $sql = "Select * from hmis_ipd_services where 1";
            if ( $panel_id > 0 ) {
                $sql .= " and id IN (Select service_id from hmis_panel_ipd_services where panel_id=$panel_id)";
            }
            else {
                $sql .= " and (parent_id='0' or parent_id IS NULL)";
            }
            $services = $this -> db -> query ( $sql );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @return mixed
         * get all services
         * --------------
         */
        
        public function get_services () {
            $services = $this -> db -> query ( "Select * from hmis_ipd_services where (parent_id='0' or parent_id IS NULL)" );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @return mixed
         * get all services
         * --------------
         */
        
        public function get_all_services () {
            $services = $this -> db -> get ( 'ipd_services' );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @param $service_id
         * @param $panel_id
         * get sub services
         * @return mixed
         * --------------
         */
        
        public function get_sub_child ( $service_id, $panel_id = 0 ) {
            $sql = "Select * from hmis_ipd_services where parent_id=$service_id";
            if ( $panel_id > 0 ) {
                $sql .= " and id IN (Select service_id from hmis_panel_ipd_services where panel_id=$panel_id)";
            }
            $services = $this -> db -> query ( $sql );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * insert services
         * --------------
         */
        
        public function add_ipd_services ( $info ) {
            $this -> db -> insert ( 'ipd_services', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * insert ot timings
         * --------------
         */
        
        public function ot_timings ( $info ) {
            $this -> db -> insert ( 'ipd_ot_timings', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * add ipd consultants
         * --------------
         */
        
        public function add_ipd_consultants ( $info ) {
            $this -> db -> insert ( 'ipd_patient_consultants', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * get ipd consultants
         * --------------
         */
        
        public function get_consultants ( $sale_id ) {
            $consultants = $this -> db -> get_where ( 'ipd_patient_consultants', array ( 'sale_id' => $sale_id ) );
            return $consultants -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * get ipd ot timings
         * --------------
         */
        
        public function get_ot_timings ( $sale_id ) {
            $timings = $this -> db -> get_where ( 'ipd_ot_timings', array ( 'sale_id' => $sale_id ) );
            return $timings -> row ();
        }
        
        /**
         * --------------
         * @param $id
         * @return mixed
         * get ipd ot timings
         * --------------
         */
        
        public function get_ot_timings_by_id ( $id ) {
            $timings = $this -> db -> get_where ( 'ipd_ot_timings', array ( 'id' => $id ) );
            return $timings -> row ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * insert per minute charges
         * --------------
         */
        
        public function add_per_minute_charges ( $info ) {
            $this -> db -> insert ( 'ipd_service_per_minute_charges', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $id
         * @return bool
         * check if service has child services
         * --------------
         */
        
        public function check_if_service_has_child ( $id ) {
            $query = $this -> db -> query ( "Select COUNT(*) as total from hmis_ipd_services where parent_id=$id" );
            if ( $query -> row () -> total > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * @param $service_id
         * get service by id
         * --------------
         * @return mixed
         */
        
        public function get_service_by_id ( $service_id ) {
            $services = $this -> db -> get_where ( 'ipd_services', array ( 'id' => $service_id ) );
            return $services -> row ();
        }
        
        /**
         * --------------
         * @param $service_id
         * delete service and child
         * --------------
         */
        
        public function delete_service ( $service_id ) {
            $this -> db -> delete ( 'ipd_services', array ( 'id' => $service_id ) );
            $this -> db -> delete ( 'ipd_services', array ( 'parent_id' => $service_id ) );
        }
        
        /**
         * --------------
         * @param $consultant_id
         * delete ipd consultant
         * --------------
         */
        
        public function delete_ipd_consultants ( $consultant_id ) {
            $this -> db -> delete ( 'ipd_patient_consultants', array ( 'id' => $consultant_id ) );
        }
        
        /**
         * --------------
         * @param $service_id
         * get service by parent id
         * --------------
         * @return mixed
         */
        
        public function get_child_services ( $service_id ) {
            $services = $this -> db -> get_where ( 'ipd_services', array ( 'parent_id' => $service_id ) );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * insert packages
         * --------------
         */
        
        public function add_ipd_packages ( $info ) {
            $this -> db -> insert ( 'ipd_packages', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * insert package services
         * --------------
         */
        
        public function add_ipd_package_services ( $info ) {
            $this -> db -> insert ( 'ipd_package_services', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @return mixed
         * get packages
         * --------------
         */
        
        public function get_packages () {
            $this -> db -> order_by ( 'id', 'DESC' );
            $packages = $this -> db -> get ( 'ipd_packages' );
            return $packages -> result ();
        }
        
        /**
         * --------------
         * @param $package_id
         * @return mixed
         * get package services
         * --------------
         */
        
        public function get_package_services ( $package_id ) {
            $query    = $this -> db -> query ( "Select GROUP_CONCAT(service_id) as services, GROUP_CONCAT(price) as prices from hmis_ipd_package_services where package_id=$package_id group by package_id" );
            $services = $query -> row ();
            return $services;
        }
        
        /**
         * --------------
         * @param $package_id
         * delete package
         * --------------
         */
        
        public function delete_packages ( $package_id ) {
            $this -> db -> delete ( 'ipd_packages', array ( 'id' => $package_id ) );
        }
        
        /**
         * --------------
         * @param $package_id
         * @return mixed
         * get package by id
         * --------------
         */
        
        public function get_package_by_id ( $package_id ) {
            $package = $this -> db -> get_where ( 'ipd_packages', array ( 'id' => $package_id ) );
            return $package -> row ();
        }
        
        /**
         * --------------
         * @param $package_id
         * @return mixed
         * get package services
         * --------------
         */
        
        public function get_package_all_services ( $package_id ) {
            $services = $this -> db -> get_where ( 'ipd_package_services', array ( 'package_id' => $package_id ) );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @param $package_id
         * @return mixed
         * delete package services
         * --------------
         */
        
        public function delete_ipd_package_services ( $package_id ) {
            $this -> db -> delete ( 'ipd_package_services', array ( 'package_id' => $package_id ) );
        }
        
        /**
         * --------------
         * @param $service_id
         * @param $info
         * @return mixed
         * delete package services
         * --------------
         */
        
        public function edit_ipd_services ( $info, $service_id ) {
            $this -> db -> update ( 'ipd_services', $info, array ( 'id' => $service_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @param $info
         * @return mixed
         * update ot timings
         * --------------
         */
        
        public function update_ot_timings ( $info, $sale_id ) {
            $this -> db -> update ( 'ipd_ot_timings', $info, array ( 'sale_id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * sale service
         * --------------
         */
        
        public function sale_service ( $info ) {
            $this -> db -> insert ( 'ipd_sales', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * add patient info
         * --------------
         */
        
        public function add_patient_info ( $info ) {
            $this -> db -> insert ( 'ipd_sold_services', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * delete patient admission slip
         * --------------
         */
        
        public function delete_admission_slip ( $sale_id ) {
            $this -> db -> delete ( 'ipd_patient_admission_slip', array ( 'sale_id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $info
         * @param $sale_id
         * @return mixed
         * add patient admission slip
         * --------------
         */
        
        public function do_update_admission_slip ( $info, $sale_id ) {
            $row = $this -> db -> get_where ( 'ipd_patient_admission_slip', array ( 'sale_id' => $sale_id ) );
            if ( $row -> num_rows () > 0 ) {
                unset( $info[ 'date_added' ] );
                $this -> db -> update ( 'ipd_patient_admission_slip', $info, array ( 'sale_id' => $sale_id ) );
                return $this -> db -> affected_rows ();
            }
            else {
                $this -> db -> insert ( 'ipd_patient_admission_slip', $info );
                return $this -> db -> insert_id ();
            }
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * add payment
         * --------------
         */
        
        public function do_add_ipd_sale_payment ( $info ) {
            $this -> db -> insert ( 'ipd_sale_payments', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $payment_id
         * @return mixed
         * delete payment
         * --------------
         */
        
        public function delete_payment ( $payment_id ) {
            $this -> db -> delete ( 'ipd_sale_payments', array ( 'id' => $payment_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * count payment
         * --------------
         */
        
        public function count_payment ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(amount) as amount from hmis_ipd_sale_payments where sale_id=$sale_id" );
            if ( $query -> num_rows () > 0 )
                return $query -> row () -> amount;
            else
                return 0;
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * get payments
         * --------------
         */
        
        public function get_ipd_payments ( $sale_id ) {
            $payments = $this -> db -> get_where ( 'ipd_sale_payments', array ( 'sale_id' => $sale_id ) );
            return $payments -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * get admission slip
         * --------------
         */
        
        public function get_admission_slip ( $sale_id ) {
            $row = $this -> db -> get_where ( 'ipd_patient_admission_slip', array ( 'sale_id' => $sale_id ) );
            return $row -> row ();
        }
        
        /**
         * --------------
         * @param $info
         * @param $sale_id
         * @return mixed
         * edit patient info
         * --------------
         */
        
        public function do_edit_patient ( $info, $sale_id ) {
            $this -> db -> update ( 'ipd_sold_services', $info, array ( 'sale_id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $service_id
         * @return int
         * get parent service id
         * --------------
         */
        
        public function get_service_parent_id ( $service_id ) {
            $parent = $this -> db -> get_where ( 'ipd_services', array ( 'id' => $service_id ) );
            if ( $parent -> num_rows () > 0 )
                return $parent -> row () -> parent_id;
            else
                return 0;
        }
        
        /**
         * --------------
         * @return mixed
         * get anesthetist service
         * --------------
         */
        
        public function get_anesthetist_service () {
            $service = $this -> db -> get_where ( 'ipd_services', array ( 'charge' => 'anesthetist_charges' ) );
            return $service -> row ();
        }
        
        /**
         * --------------
         * @param $info
         * @return int
         * assign services
         * --------------
         */
        
        public function assign_services_to_patient_info ( $info ) {
            $this -> db -> insert ( 'ipd_patient_associated_services', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $info
         * @param $id
         * @return int
         * update assign services
         * --------------
         */
        
        public function update_assigned_services_to_patient_info ( $info, $id ) {
            $this -> db -> update ( 'ipd_patient_associated_services', $info, array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @return mixed
         * count cash sales
         * --------------
         */
        
        public function count_sales () {
            $sql = "Select COUNT(*) as totalRows from hmis_ipd_sold_services where discharged='0' and trash='0' and patient_id IN (Select id from hmis_patients where type='cash')";
            if ( isset( $_REQUEST[ 'sale_id' ] ) and $_REQUEST[ 'sale_id' ] > 0 ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'service_id' ] ) and $_REQUEST[ 'service_id' ] > 0 ) {
                $service_id = $_REQUEST[ 'service_id' ];
                $sql        .= " and id IN (Select sale_id from hmis_ipd_patient_associated_services where service_id=$service_id)";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and id IN (Select sale_id from hmis_ipd_patient_associated_services where doctor_id=$doctor_id)";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql  .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$name%')";
            }
            $sales = $this -> db -> query ( $sql );
            return $sales -> row () -> totalRows;
        }
        
        /**
         * --------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get cash sales
         * --------------
         */
        
        public function get_sales ( $limit, $offset ) {
            $sql = "Select * from hmis_ipd_sold_services where discharged='0' and trash='0' and patient_id IN (Select id from hmis_patients where type='cash')";
            if ( isset( $_REQUEST[ 'sale_id' ] ) and $_REQUEST[ 'sale_id' ] > 0 ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'service_id' ] ) and $_REQUEST[ 'service_id' ] > 0 ) {
                $service_id = $_REQUEST[ 'service_id' ];
                $sql        .= " and id IN (Select sale_id from hmis_ipd_patient_associated_services where service_id=$service_id)";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and id IN (Select sale_id from hmis_ipd_patient_associated_services where doctor_id=$doctor_id)";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql  .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$name%')";
            }
            $sql   .= " order by id DESC limit $limit offset $offset";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * --------------
         * @param $patient_id
         * @return mixed
         * fetch ipd patient info
         * --------------
         */
        
        public function fetch_ipd_patient_details ( $patient_id ) {
            $data = $this -> db -> query ( "Select * from hmis_ipd_sold_services where discharged='1' and trash='0' and patient_id=$patient_id order by id DESC limit 1" );
            return $data -> row ();
        }
        
        /**
         * --------------
         * @param $admission_no
         * @return mixed
         * fetch ipd patient info
         * --------------
         */
        
        public function get_ipd_admission_slip ( $admission_no ) {
            $data = $this -> db -> query ( "Select * from hmis_ipd_patient_admission_slip where sale_id=$admission_no order by id DESC limit 1" );
            return $data -> row ();
        }
        
        /**
         * --------------
         * @return mixed
         * count panel sales
         * --------------
         */
        
        public function count_panel_sales () {
            $sql = "Select COUNT(*) as totalRows from hmis_ipd_sold_services where discharged='0' and trash='0' and patient_id IN (Select id from hmis_patients where panel_id > 0 AND panel_id IS NOT NULL AND panel_id != '')";
            if ( isset( $_REQUEST[ 'sale_id' ] ) and $_REQUEST[ 'sale_id' ] > 0 ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'service_id' ] ) and $_REQUEST[ 'service_id' ] > 0 ) {
                $service_id = $_REQUEST[ 'service_id' ];
                $sql        .= " and id IN (Select sale_id from hmis_ipd_patient_associated_services where service_id=$service_id)";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and id IN (Select sale_id from hmis_ipd_patient_associated_services where doctor_id=$doctor_id)";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql  .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'panel_id' ] ) and !empty( trim ( $_REQUEST[ 'panel_id' ] ) ) and $_REQUEST[ 'panel_id' ] > 0 ) {
                $panel_id = $_REQUEST[ 'panel_id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            $sales = $this -> db -> query ( $sql );
            return $sales -> row () -> totalRows;
        }
        
        /**
         * --------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get  panel sales
         * --------------
         */
        
        public function get_panel_sales ( $limit, $offset ) {
            $sql = "Select * from hmis_ipd_sold_services where discharged='0' and trash='0' and patient_id IN (Select id from hmis_patients where panel_id > 0 AND panel_id IS NOT NULL AND panel_id != '')";
            if ( isset( $_REQUEST[ 'sale_id' ] ) and $_REQUEST[ 'sale_id' ] > 0 ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'service_id' ] ) and $_REQUEST[ 'service_id' ] > 0 ) {
                $service_id = $_REQUEST[ 'service_id' ];
                $sql        .= " and id IN (Select sale_id from hmis_ipd_patient_associated_services where service_id=$service_id)";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and id IN (Select sale_id from hmis_ipd_patient_associated_services where doctor_id=$doctor_id)";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql  .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'panel_id' ] ) and !empty( trim ( $_REQUEST[ 'panel_id' ] ) ) and $_REQUEST[ 'panel_id' ] > 0 ) {
                $panel_id = $_REQUEST[ 'panel_id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            $sql   .= " order by id DESC limit $limit offset $offset";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * --------------
         * @return mixed
         * count discharged sales
         * --------------
         */
        
        public function count_discharged_sales () {
            $sql = "Select COUNT(*) as totalRows from hmis_ipd_sold_services where discharged='1' and trash='0'";
            if ( isset( $_REQUEST[ 'sale_id' ] ) and $_REQUEST[ 'sale_id' ] > 0 ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'service_id' ] ) and $_REQUEST[ 'service_id' ] > 0 ) {
                $service_id = $_REQUEST[ 'service_id' ];
                $sql        .= " and id IN (Select sale_id from hmis_ipd_patient_consultants where service_id=$service_id)";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and id IN (Select sale_id from hmis_ipd_patient_admission_slip where doctor_id=$doctor_id)";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql  .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'panel_id' ] ) and !empty( trim ( $_REQUEST[ 'panel_id' ] ) ) and $_REQUEST[ 'panel_id' ] > 0 ) {
                $panel_id = $_REQUEST[ 'panel_id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            $sales = $this -> db -> query ( $sql );
            return $sales -> row () -> totalRows;
        }
        
        /**
         * --------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get discharged sales
         * --------------
         */
        
        public function get_dischaged_sales ( $limit, $offset ) {
            $sql = "Select * from hmis_ipd_sold_services where discharged='1' and trash='0'";
            if ( isset( $_REQUEST[ 'sale_id' ] ) and $_REQUEST[ 'sale_id' ] > 0 ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'service_id' ] ) and $_REQUEST[ 'service_id' ] > 0 ) {
                $service_id = $_REQUEST[ 'service_id' ];
                $sql        .= " and id IN (Select sale_id from hmis_ipd_patient_consultants where service_id=$service_id)";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and id IN (Select sale_id from hmis_ipd_patient_admission_slip where doctor_id=$doctor_id)";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql  .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'panel_id' ] ) and !empty( trim ( $_REQUEST[ 'panel_id' ] ) ) and $_REQUEST[ 'panel_id' ] > 0 ) {
                $panel_id = $_REQUEST[ 'panel_id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
            }
            $sql   .= " order by id DESC limit $limit offset $offset";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * get sale by Invoice ID
         * --------------
         * @return mixed
         */
        
        public function get_ipd_sale ( $sale_id ) {
            $sale = $this -> db -> get_where ( 'ipd_sales', array ( 'id' => $sale_id ) );
            return $sale -> row ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * get sale by Invoice ID
         * --------------
         * @return mixed
         */
        
        public function get_ipd_discharged_date ( $sale_id ) {
            $sale = $this -> db -> get_where ( 'hmis_ipd_sold_services', array ( 'sale_id' => $sale_id ) );
            return $sale -> row ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @param $patient_id
         * get patient associated services
         * --------------
         * @return mixed
         */
        
        public function get_ipd_patient_associated_services ( $patient_id, $sale_id ) {
            $services = $this -> db -> get_where ( 'ipd_patient_associated_services', array (
                'sale_id'    => $sale_id,
                'patient_id' => $patient_id
            ) );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * get sale info
         * --------------
         * @return mixed
         */
        
        public function get_sale_info ( $sale_id ) {
            $service = $this -> db -> get_where ( 'ipd_sold_services', array ( 'sale_id' => $sale_id ) );
            return $service -> row ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * update sale to trash
         * --------------
         */
        
        public function delete_sale ( $sale_id ) {
            $this -> db -> update ( 'ipd_sold_services', array ( 'trash' => '1' ), array ( 'sale_id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $ids
         * @return mixed
         * delete patient associated services
         * --------------
         */
        
        public function delete_ipd_patient_associated_services ( $ids ) {
            if ( !empty( trim ( $ids ) ) )
                $this -> db -> query ( "Delete from hmis_ipd_patient_associated_services where id IN($ids)" );
        }
        
        /**
         * --------------
         * @param $sale_id
         * @param $info
         * @return mixed
         * update sale total
         * --------------
         */
        
        public function update_sale_total ( $info, $sale_id ) {
            $this -> db -> update ( 'ipd_sales', $info, array ( 'id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * get sale billing info
         * --------------
         * @return mixed
         */
        
        public function get_sale_billing_info ( $sale_id ) {
            $service = $this -> db -> get_where ( 'ipd_sales', array ( 'id' => $sale_id ) );
            return $service -> row ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * check if ipd medication bill cleared
         * --------------
         */
        
        public function check_if_ipd_medication_bill_cleared ( $sale_id ) {
            $query = $this -> db -> query ( "Select COUNT(*) as totalRows from hmis_ipd_medication_bill_cleared where sale_id='$sale_id'" );
            if ( $query -> row () -> totalRows > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * get ipd medication bill cleared
         * --------------
         */
        
        public function get_ipd_medication_bill_cleared ( $sale_id ) {
            $query = $this -> db -> query ( "Select * from hmis_ipd_medication_bill_cleared where sale_id='$sale_id'" );
            return $query -> row ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * check if ipd lab bill cleared
         * --------------
         */
        
        public function check_if_ipd_lab_bill_cleared ( $sale_id ) {
            $query = $this -> db -> query ( "Select COUNT(*) as totalRows from hmis_ipd_lab_bill_cleared where sale_id='$sale_id'" );
            if ( $query -> row () -> totalRows > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * get ipd lab bill cleared
         * --------------
         */
        
        public function get_ipd_lab_bill_cleared ( $sale_id ) {
            $query = $this -> db -> query ( "Select * from hmis_ipd_lab_bill_cleared where sale_id='$sale_id'" );
            return $query -> row ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * get patient associated services
         * --------------
         * @return mixed
         */
        
        public function get_patient_ipd_associated_services ( $sale_id, $included = '1' ) {
            $services = $this -> db -> get_where ( 'ipd_patient_associated_services', array (
                'sale_id'  => $sale_id,
                'included' => $included
            ) );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * get patient associated services
         * --------------
         */
        
        public function get_patient_ipd_associated_services_total_price ( $sale_id ) {
            $services = $this -> db -> query ( "Select SUM(net_price) as net_price from hmis_ipd_patient_associated_services where sale_id=$sale_id" );
            return $services -> row () -> net_price;
        }
        
        /**
         * --------------
         * @param $sale_id
         * get patient associated services
         * --------------
         * @return mixed
         */
        
        public function get_patient_ipd_associated_services_not_in_type ( $sale_id ) {
            $service_type = ipd_service_types;
            $services     = $this -> db -> query ( "Select * from hmis_ipd_patient_associated_services where sale_id=$sale_id and service_id IN (Select id from hmis_ipd_services where service_type NOT IN ($service_type) or service_type IS NULL)" );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * get patient associated services
         * --------------
         * @return mixed
         */
        
        public function get_patient_ipd_associated_services_consolidated_not_in_type ( $sale_id, $included = '1' ) {
            $service_type = ipd_service_types;
            $services     = $this -> db -> query ( "Select id, user_id, sale_id, patient_id, service_id, GROUP_CONCAT(DISTINCT doctor_id) as doctors, COUNT(service_id) as services_count, SUM(price) as price, SUM(net_price) as net_price, charge_per, charge_per_value, date_added from hmis_ipd_patient_associated_services where sale_id=$sale_id and included='$included' and service_id IN (Select id from hmis_ipd_services where service_type NOT IN ($service_type)) group by service_id, doctor_id" );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @param $type
         * get patient associated services by type
         * --------------
         * @return mixed
         */
        
        public function get_patient_associated_services_by_type ( $sale_id, $type ) {
            $services = $this -> db -> query ( "Select * from hmis_ipd_patient_associated_services where sale_id=$sale_id and service_id IN (Select id from hmis_ipd_services where service_type IN ('$type'))" );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @param $info
         * @return int
         * assign services
         * --------------
         */
        
        public function add_opd_sale_service ( $info ) {
            $this -> db -> insert ( 'ipd_opd_patient_associated_services', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * get patient associated services
         * --------------
         * @return mixed
         */
        
        public function get_patient_opd_associated_services ( $sale_id ) {
            $services = $this -> db -> get_where ( 'ipd_opd_patient_associated_services', array ( 'sale_id' => $sale_id ) );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * get patient associated services
         * --------------
         * @return mixed
         */
        
        public function get_patient_opd_associated_services_not_in_type ( $sale_id ) {
            $service_type = ipd_service_types;
            $services     = $this -> db -> query ( "Select * from hmis_ipd_opd_patient_associated_services where sale_id=$sale_id and service_id IN (Select id from hmis_opd_services where service_type NOT IN ($service_type))" );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * delete patient associated services
         * --------------
         */
        
        public function delete_opd_patient_associated_services ( $sale_id ) {
            $this -> db -> delete ( 'ipd_opd_patient_associated_services', array ( 'sale_id' => $sale_id ) );
        }
        
        /**
         * --------------
         * @param $ids
         * @param $sale_id
         * @return mixed
         * delete patient associated services
         * --------------
         */
        
        public function delete_ipd_patient_associated_tests ( $ids, $sale_id ) {
            
            $Sids = explode ( ',', $ids );
            if ( count ( $Sids ) > 0 ) {
                foreach ( $Sids as $id ) {
                    $sql   = $this -> db -> query ( "Select test_id from hmis_ipd_patient_associated_lab_tests where id=$id" );
                    $tests = $sql -> result ();
                    if ( count ( $tests ) > 0 ) {
                        foreach ( $tests as $test_id ) {
                            $testIDS = get_child_tests_ids ( $test_id -> test_id );
                            if ( !empty( $testIDS -> ids ) ) {
                                $childTestIds = explode ( ',', $testIDS -> ids );
                                foreach ( $childTestIds as $childTestId ) {
                                    $this -> db -> query ( "Delete from hmis_ipd_patient_associated_lab_tests where sale_id=$sale_id and test_id=$childTestId" );
                                }
                            }
                        }
                    }
                }
            }
            if ( !empty( trim ( $ids ) ) )
                $this -> db -> query ( "Delete from hmis_ipd_patient_associated_lab_tests where id IN($ids)" );
        }
        
        /**
         * --------------
         * @param $info
         * @return int
         * assign services
         * --------------
         */
        
        public function add_test_sale_service ( $info ) {
            $this -> db -> insert ( 'ipd_patient_associated_lab_tests', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $info
         * @param $id
         * @return int
         * assign services
         * --------------
         */
        
        public function update_added_test_sale_service ( $info, $id ) {
            $this -> db -> update ( 'ipd_patient_associated_lab_tests', $info, array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return int
         * get assigned tests
         * --------------
         */
        
        public function get_ipd_patient_tests ( $sale_id ) {
            $tests = $this -> db -> get_where ( 'ipd_patient_associated_lab_tests', array ( 'sale_id' => $sale_id ) );
            return $tests -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @param $limit
         * @param $offset
         * @return int
         * get assigned tests
         * --------------
         */
        
        public function get_ipd_patient_tests_without_parent ( $sale_id, $limit = 0, $offset ) {
            if ( $limit > 0 )
                $this -> db -> limit ( $limit, $offset );
            $tests = $this -> db -> get_where ( 'ipd_patient_associated_lab_tests', array (
                'sale_id'   => $sale_id,
                'parent_id' => '0'
            ) );
            return $tests -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return int
         * get assigned tests
         * --------------
         */
        
        public function count_ipd_patient_tests_without_parent ( $sale_id ) {
            $tests = $this -> db -> get_where ( 'ipd_patient_associated_lab_tests', array (
                'sale_id'   => $sale_id,
                'parent_id' => '0'
            ) );
            return $tests -> num_rows ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return int
         * get assigned tests
         * --------------
         */
        
        public function get_ipd_patient_tests_net_price ( $sale_id ) {
            $tests = $this -> db -> query ( "Select SUM(net_price) as net_price from hmis_ipd_patient_associated_lab_tests where sale_id=$sale_id and parent_id='0'" );
            return $tests -> row () -> net_price;
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return int
         * get assigned tests
         * --------------
         */
        
        public function get_ipd_patient_tests_consolidated ( $sale_id ) {
            $tests = $this -> db -> query ( "Select id, user_id, sale_id, patient_id, COUNT(test_id) as tests_count, test_id, SUM(price) as price, SUM(net_price) as net_price, date_added from hmis_ipd_patient_associated_lab_tests where sale_id=$sale_id group by test_id" );
            return $tests -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return int
         * get assigned tests
         * --------------
         */
        
        public function get_ipd_patient_tests_sum ( $sale_id ) {
            $tests = $this -> db -> query ( "Select SUM(net_price) as net_price from hmis_ipd_patient_associated_lab_tests where sale_id=$sale_id" );
            return $tests -> row () -> net_price;
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return int
         * get requisitions
         * --------------
         */
        
        public function get_ipd_requisitions ( $sale_id ) {
            $requisitions = $this -> db -> get_where ( 'ipd_requisitions', array ( 'sale_id' => $sale_id ) );
            return $requisitions -> result ();
        }
        
        /**
         * --------------
         * @param $ids
         * @return mixed
         * delete patient associated services
         * --------------
         */
        
        public function delete_ipd_patient_medication ( $ids ) {
            $medications = explode ( ',', $ids );
            if ( count ( $medications ) > 0 ) {
                foreach ( $medications as $medication ) {
                    if ( $medication > 0 ) {
                        $this -> db -> query ( "Delete from hmis_ipd_medication where id=$medication" );
                    }
                }
            }
            //		if ( !empty( trim ( $ids ) ) ) {
            //            $this -> db -> query ("Delete from hmis_ipd_medication where id IN ($ids)");
            //        }
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * delete ipd requisitions
         * --------------
         */
        
        public function delete_ipd_requisitions ( $sale_id ) {
            $this -> db -> delete ( 'ipd_requisitions', array ( 'sale_id' => $sale_id ) );
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * add patient associated services
         * --------------
         */
        
        public function sale_medicine ( $info ) {
            $this -> db -> insert ( 'ipd_medication', $info );
        }
        
        /**
         * --------------
         * @param $info
         * @param $medication_id
         * update medication
         * --------------
         * @return mixed
         */
        
        public function update_sale_medicine ( $info, $medication_id ) {
            $this -> db -> update ( 'ipd_medication', $info, array ( 'id' => $medication_id ) );
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * add requisitions
         * --------------
         */
        
        public function add_medicine_requisition ( $info ) {
            $this -> db -> insert ( 'ipd_requisitions', $info );
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return int
         * get assigned medicines
         * --------------
         */
        
        public function get_ipd_patient_medication ( $sale_id ) {
            $tests = $this -> db -> get_where ( 'ipd_medication', array ( 'sale_id' => $sale_id ) );
            return $tests -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return int
         * get assigned medicines
         * --------------
         */
        
        public function get_ipd_patient_medication_consolidated ( $sale_id ) {
            $medication = $this -> db -> query ( "Select id, user_id, sale_id, patient_id, COUNT(medicine_id) as medicines_count, medicine_id, SUM(quantity) as quantity_count, SUM(price) as price, SUM(net_price) as net_price, date_added from hmis_ipd_medication where sale_id=$sale_id group by medicine_id" );
            return $medication -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return int
         * get assigned medicines
         * --------------
         */
        
        public function get_ipd_patient_medication_sum ( $sale_id ) {
            $tests = $this -> db -> query ( "Select SUM(net_price) as net_price from hmis_ipd_medication where sale_id=$sale_id" );
            return $tests -> row () -> net_price;
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return int
         * total of ipd services
         * --------------
         */
        
        public function total_ipd_services ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(net_price) as total from hmis_ipd_patient_associated_services where sale_id=$sale_id" );
            if ( $query -> num_rows () > 0 )
                return $query -> row () -> total;
            else
                return 0;
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return int
         * total of opd services
         * --------------
         */
        
        public function total_opd_services ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(net_price) as total from hmis_ipd_opd_patient_associated_services where sale_id=$sale_id" );
            if ( $query -> num_rows () > 0 )
                return $query -> row () -> total;
            else
                return 0;
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return int
         * total of lab services
         * --------------
         */
        
        public function total_lab_services ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(net_price) as total from hmis_ipd_patient_associated_lab_tests where sale_id=$sale_id" );
            if ( $query -> num_rows () > 0 )
                return $query -> row () -> total;
            else
                return 0;
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return int
         * total of medication
         * --------------
         */
        
        public function total_medication ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(net_price) as total from hmis_ipd_medication where sale_id=$sale_id" );
            if ( $query -> num_rows () > 0 )
                return $query -> row () -> total;
            else
                return 0;
        }
        
        /**
         * --------------
         * @param $sale_id
         * @param $info
         * @return mixed
         * discharge patient
         * --------------
         */
        
        public function do_discharge_patient ( $info, $sale_id ) {
            $this -> db -> update ( 'ipd_sold_services', $info, array ( 'sale_id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @param $info
         * @return mixed
         * update requisition status
         * --------------
         */
        
        public function do_update_requisition_status ( $info, $sale_id ) {
            $this -> db -> update ( 'ipd_requisitions', $info, array ( 'sale_id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * add mo order info
         * --------------
         */
        
        public function do_mo_add_admission_orders ( $info ) {
            $this -> db -> insert ( 'hmis_mo_orders', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * add mo order record
         * --------------
         */
        
        public function do_mo_add_admission_record ( $info ) {
            $this -> db -> insert ( 'hmis_mo_order_record', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @return mixed
         * get mo orders
         * --------------
         */
        
        public function get_mo_admission_orders () {
            $this -> db -> order_by ( 'id', 'DESC' );
            $orders = $this -> db -> get ( 'hmis_mo_orders' );
            return $orders -> result ();
        }
        
        /**
         * --------------
         * @param $order_id
         * get mo orders
         * --------------
         * @return mixed
         */
        
        public function get_mo_order_record ( $order_id ) {
            $record = $this -> db -> get_where ( 'hmis_mo_order_record', array ( 'order_id' => $order_id ) );
            return $record -> result ();
        }
        
        /**
         * --------------
         * @param $order_id
         * get mo orders
         * --------------
         * @return mixed
         */
        
        public function get_mo_order_record_by_id ( $order_id ) {
            $record = $this -> db -> get_where ( 'hmis_mo_order_record', array ( 'order_id' => $order_id ) );
            return $record -> row ();
        }
        
        /**
         * --------------
         * @param $order_id
         * delete mo orders
         * --------------
         * @return mixed
         */
        
        public function delete_admission_order ( $order_id ) {
            $this -> db -> delete ( 'hmis_mo_orders', array ( 'id' => $order_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $order_id
         * get mo order
         * --------------
         * @return mixed
         */
        
        public function get_mo_admission_order_record ( $order_id ) {
            $record = $this -> db -> get_where ( 'hmis_mo_order_record', array ( 'order_id' => $order_id ) );
            return $record -> result ();
        }
        
        /**
         * --------------
         * @param $order_id
         * get mo order
         * --------------
         * @return mixed
         */
        
        public function get_mo_admission_order ( $order_id ) {
            $record = $this -> db -> get_where ( 'hmis_mo_orders', array ( 'id' => $order_id ) );
            return $record -> row ();
        }
        
        /**
         * --------------
         * @param $record_id
         * delete mo record
         * --------------
         * @return mixed
         */
        
        public function delete_admission_order_record ( $record_id ) {
            $this -> db -> delete ( 'hmis_mo_order_record', array ( 'id' => $record_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $record_id
         * delete admission record
         * --------------
         * @return mixed
         */
        
        public function delete_mo_add_admission_record ( $record_id ) {
            $this -> db -> delete ( 'mo_order_record', array ( 'order_id' => $record_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * add mo physical examination
         * --------------
         */
        
        public function do_mo_add_physical_examination ( $info ) {
            $this -> db -> insert ( 'hmis_physical_examination_history', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @return mixed
         * get physical examinations
         * --------------
         */
        
        public function get_physical_examination () {
            $this -> db -> order_by ( 'id', 'DESC' );
            $examination = $this -> db -> get ( 'physical_examination_history' );
            return $examination -> result ();
        }
        
        /**
         * --------------
         * @param $examination_id
         * delete physical examination
         * --------------
         * @return mixed
         */
        
        public function delete_physical_examination ( $examination_id ) {
            $this -> db -> delete ( 'physical_examination_history', array ( 'id' => $examination_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $examination_id
         * get physical examination
         * --------------
         * @return mixed
         */
        
        public function get_physical_examination_by_id ( $examination_id ) {
            $record = $this -> db -> get_where ( 'physical_examination_history', array ( 'id' => $examination_id ) );
            return $record -> row ();
        }
        
        /**
         * --------------
         * @param $examination_id
         * @param $info
         * update physical examination
         * --------------
         * @return mixed
         */
        
        public function do_mo_edit_physical_examination ( $info, $examination_id ) {
            $this -> db -> update ( 'physical_examination_history', $info, array ( 'id' => $examination_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $date
         * @param $where
         * update discharge date
         * --------------
         * @return mixed
         */
        
        public function do_update_discharge_date ( $date, $where ) {
            $this -> db -> update ( 'hmis_ipd_sold_services', $date, $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * add progress
         * --------------
         */
        
        public function add_progress ( $info ) {
            $this -> db -> insert ( 'mo_progress', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * add progress notes
         * --------------
         */
        
        public function do_mo_add_progress_notes ( $info ) {
            $this -> db -> insert ( 'mo_progress_notes', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @return mixed
         * get progress notes
         * --------------
         */
        
        public function get_progress_notes () {
            $this -> db -> order_by ( 'id', 'DESC' );
            $notes = $this -> db -> get ( 'mo_progress' );
            return $notes -> result ();
        }
        
        /**
         * --------------
         * @param $progress_id
         * delete progress notes
         * --------------
         * @return mixed
         */
        
        public function delete_progress_notes ( $progress_id ) {
            $this -> db -> delete ( 'mo_progress', array ( 'id' => $progress_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $progress_id
         * get progress notes
         * --------------
         * @return mixed
         */
        
        public function get_progress ( $progress_id ) {
            $record = $this -> db -> get_where ( 'mo_progress', array ( 'id' => $progress_id ) );
            return $record -> row ();
        }
        
        /**
         * --------------
         * @param $progress_id
         * get progress notes
         * --------------
         * @return mixed
         */
        
        public function get_progress_notes_by_id ( $progress_id ) {
            $record = $this -> db -> get_where ( 'mo_progress_notes', array ( 'progress_id' => $progress_id ) );
            return $record -> result ();
        }
        
        /**
         * --------------
         * @param $progress_id
         * delete progress notes
         * --------------
         * @return mixed
         */
        
        public function delete_progress_notes_by_id ( $progress_id ) {
            $this -> db -> delete ( 'mo_progress_notes', array ( 'progress_id' => $progress_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $note_id
         * delete progress note
         * --------------
         * @return mixed
         */
        
        public function delete_progress_note ( $note_id ) {
            $this -> db -> delete ( 'mo_progress_notes', array ( 'id' => $note_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * add blood transfusion
         * --------------
         */
        
        public function do_mo_add_blood_transfusion ( $info ) {
            $this -> db -> insert ( 'mo_blood_transfusion', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @return mixed
         * get blood transfusions
         * --------------
         */
        
        public function get_blood_transfusions () {
            $query = $this -> db -> query ( "Select * from hmis_mo_blood_transfusion GROUP BY patient_id order by id DESC" );
            return $query -> result ();
        }
        
        /**
         * --------------
         * @param $patient_id
         * delete blood transfusion
         * --------------
         * @return mixed
         */
        
        public function delete_blood_transfusion ( $patient_id ) {
            $this -> db -> delete ( 'mo_blood_transfusion', array ( 'patient_id' => $patient_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $patient_id
         * get blood transfusion
         * --------------
         * @return mixed
         */
        
        public function get_blood_transfusion ( $patient_id ) {
            $record = $this -> db -> get_where ( 'mo_blood_transfusion', array ( 'patient_id' => $patient_id ) );
            return $record -> result ();
        }
        
        /**
         * --------------
         * @param $admission_number
         * get patient by admission no
         * --------------
         * @return mixed
         */
        
        public function get_patient_by_admission_no ( $admission_number ) {
            $record = $this -> db -> get_where ( 'hmis_mo_progress', array ( 'admission_no' => $admission_number ) );
            return $record -> row ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * add discharge slip
         * --------------
         */
        
        public function do_mo_add_discharge_slip ( $info ) {
            $this -> db -> insert ( 'discharge_slips', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @return mixed
         * get discharge slip
         * --------------
         */
        
        public function get_all_discharge_slips () {
            $query = $this -> db -> query ( "Select * from hmis_discharge_slips order by id DESC" );
            return $query -> result ();
        }
        
        /**
         * --------------
         * @param $id
         * @return mixed
         * get discharge slip
         * --------------
         */
        
        public function get_discharge_slip_by_id ( $id ) {
            $query = $this -> db -> get_where ( "discharge_slips", array ( 'id' => $id ) );
            return $query -> row ();
        }
        
        /**
         * --------------
         * @param $info
         * @param $where
         * @return mixed
         * update discharge slip
         * --------------
         */
        
        public function do_mo_update_discharge_slip ( $info, $where ) {
            $this -> db -> update ( "discharge_slips", $info, $where );
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * discharge patient
         * --------------
         */
        
        public function discharge_patient ( $sale_id ) {
            $this -> db -> update ( 'ipd_sold_services', array (
                'discharged'      => '1',
                'discharged_by'   => get_logged_in_user_id (),
                'date_discharged' => current_date_time ()
            ),                      array ( 'sale_id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $payment_id
         * @return mixed
         * get payment by id
         * --------------
         */
        
        public function get_payment_by_id ( $payment_id ) {
            $query = $this -> db -> get_where ( 'ipd_sale_payments', array ( 'id' => $payment_id ) );
            return $query -> row ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * get payment by Invoice ID
         * --------------
         */
        
        public function gets_payment_by_id ( $sale_id ) {
            $query = $this -> db -> get_where ( 'ipd_sale_payments', array ( 'sale_id' => $sale_id ) );
            return $query -> result ();
        }
        
        /**
         * --------------
         * @param $info
         * @return mixed
         * add diagnostics flow sheet
         * --------------
         */
        
        public function do_mo_add_diagnostic_flow_sheet ( $info ) {
            $this -> db -> insert ( 'mo_diagnostics', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @return mixed
         * get diagnostics
         * --------------
         */
        
        public function get_diagnostics_sheet () {
            $query = $this -> db -> query ( "Select id, patient_id, GROUP_CONCAT(test_id) as tests, GROUP_CONCAT(test_date) as test_date, date_added from hmis_mo_diagnostics group by patient_id order by id DESC" );
            return $query -> result ();
        }
        
        /**
         * --------------
         * @param $patient_id
         * delete diagnostics
         * --------------
         * @return mixed
         */
        
        public function delete_diagnostic_flow_sheet ( $patient_id ) {
            $this -> db -> delete ( 'mo_diagnostics', array ( 'patient_id' => $patient_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $diagnostic_id
         * delete diagnostic
         * --------------
         * @return mixed
         */
        
        public function delete_diagnostic ( $diagnostic_id ) {
            $this -> db -> delete ( 'mo_diagnostics', array ( 'id' => $diagnostic_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $payment_id
         * @return mixed
         * get diagnostics
         * --------------
         */
        
        public function get_diagnostics_sheet_by_patient_id ( $payment_id ) {
            $query = $this -> db -> get_where ( 'mo_diagnostics', array ( 'patient_id' => $payment_id ) );
            return $query -> result ();
        }
        
        /**
         * --------------
         * @param $info
         * add discharge summary
         * --------------
         * @return mixed
         */
        
        public function do_mo_add_discharge_summary ( $info ) {
            $this -> db -> insert ( 'discharge_summary', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $info
         * add discharge summary
         * --------------
         * @return mixed
         */
        
        public function do_mo_add_discharge_summary_medicines_hosp ( $info ) {
            $this -> db -> insert ( 'discharge_summary_medications_during_hosp', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $info
         * add discharge summary
         * --------------
         * @return mixed
         */
        
        public function do_mo_add_discharge_summary_services ( $info ) {
            $this -> db -> insert ( 'discharge_summary_services', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $info
         * add discharge summary
         * --------------
         * @return mixed
         */
        
        public function do_mo_add_discharge_summary_instructions ( $info ) {
            $this -> db -> insert ( 'discharge_summary_medications', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $patient_id
         * @return int
         * get ipd admission no
         * --------------
         */
        
        public function get_ipd_admission_no ( $patient_id ) {
            $row = $this -> db -> get_where ( 'ipd_sold_services', array (
                'patient_id' => $patient_id,
                'discharged' => '0'
            ) );
            if ( $row -> num_rows () > 0 )
                return $row -> row () -> sale_id;
            else
                return 0;
        }
        
        /**
         * --------------
         * @return mixed
         * get discharge summary
         * --------------
         */
        
        public function get_discharge_summary () {
            $query = $this -> db -> query ( "Select * from hmis_discharge_summary order by id DESC" );
            return $query -> result ();
        }
        
        /**
         * --------------
         * @param $summary_id
         * get discharge summary
         * --------------
         * @return mixed
         */
        
        public function get_discharge_summary_by_id ( $summary_id ) {
            $query = $this -> db -> get_where ( 'discharge_summary', array ( 'id' => $summary_id ) );
            return $query -> row ();
        }
        
        /**
         * --------------
         * @param $summary_id
         * get discharge summary
         * --------------
         * @return mixed
         */
        
        public function get_discharge_summary_medication ( $summary_id ) {
            $query = $this -> db -> get_where ( 'discharge_summary_medications', array ( 'discharge_id' => $summary_id ) );
            return $query -> result ();
        }
        
        /**
         * --------------
         * @param $summary_id
         * get discharge summary
         * --------------
         * @return mixed
         */
        
        public function get_discharge_summary_medication_during_hosp ( $summary_id ) {
            $query = $this -> db -> get_where ( 'discharge_summary_medications_during_hosp', array ( 'discharge_id' => $summary_id ) );
            return $query -> result ();
        }
        
        /**
         * --------------
         * @param $summary_id
         * get discharge summary
         * --------------
         * @return mixed
         */
        
        public function get_discharge_summary_services ( $summary_id ) {
            $query = $this -> db -> get_where ( 'hmis_discharge_summary_services', array ( 'discharge_id' => $summary_id ) );
            return $query -> result ();
        }
        
        /**
         * --------------
         * @param $discharge_id
         * delete summary
         * --------------
         * @return mixed
         */
        
        public function delete_discharge_summary ( $discharge_id ) {
            $this -> db -> delete ( 'discharge_summary', array ( 'id' => $discharge_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $patient_id
         * @return bool
         * check if patient has admission order filled
         * --------------
         */
        
        public function check_if_patient_has_admission_order ( $patient_id ) {
            $record = $this -> db -> query ( "Select * from hmis_mo_orders where patient_id=$patient_id order by id DESC" );
            if ( $record -> num_rows () > 0 ) {
                $order_id  = $record -> row () -> id;
                $adm_order = $this -> db -> query ( "Select * from hmis_mo_order_record where order_id=$order_id and admission_no IS NULL or admission_no='' or admission_no='0'" );
                if ( $adm_order -> num_rows () > 0 )
                    return true;
                else
                    return false;
            }
            else
                return false;
        }
        
        /**
         * --------------
         * @param $sale_id
         * @param $patient_id
         * @return bool
         * update patient mo order info
         * --------------
         */
        
        public function update_patient_mo_order_info ( $sale_id, $patient_id ) {
            $record = $this -> db -> query ( "Select * from hmis_mo_orders where patient_id=$patient_id order by id DESC" );
            if ( $record -> num_rows () > 0 ) {
                $order_id  = $record -> row () -> id;
                $adm_order = $this -> db -> query ( "Select * from hmis_mo_order_record where order_id=$order_id and (admission_no IS NULL or admission_no='' or admission_no='0')" );
                if ( $adm_order -> num_rows () > 0 ) {
                    $adm_order_id = $adm_order -> row () -> id;
                    $this -> db -> update ( 'mo_order_record', array ( 'admission_no' => $sale_id ), array ( 'id' => $adm_order_id ) );
                }
                else
                    return false;
            }
            else
                return false;
        }
        
        /**
         * --------------
         * @param $patient_id
         * @return bool
         * checks if already in ipd
         * --------------
         */
        
        public function check_if_patient_is_already_in_ipd_and_not_discharged ( $patient_id ) {
            $query = $this -> db -> query ( "Select * from hmis_ipd_sold_services where patient_id=$patient_id and discharged='0'" );
            if ( $query -> num_rows () > 0 )
                return false;
            else
                return true;
        }
        
        /**
         * --------------
         * @param $test_id
         * @return mixed
         * get ipd lab test
         * --------------
         */
        
        public function get_ipd_lab_test ( $test_id ) {
            $test = $this -> db -> get_where ( 'hmis_ipd_patient_associated_lab_tests', array ( 'id' => $test_id ) );
            return $test -> row ();
        }
        
        /**
         * --------------
         * @param $test_id
         * @return mixed
         * get ipd lab tests
         * --------------
         */
        
        public function get_ipd_lab_tests ( $test_id ) {
            $sql = "Select * from hmis_ipd_patient_associated_lab_tests where sale_id=$test_id";
            if ( isset( $_REQUEST[ 'ids' ] ) and !empty( trim ( $_REQUEST[ 'ids' ] ) ) ) {
                $ids = $_REQUEST[ 'ids' ];
                $sql .= " and id IN($ids)";
            }
            $tests = $this -> db -> query ( $sql );
            return $tests -> result ();
        }
        
        /**
         * --------------
         * @param $test_id
         * @return mixed
         * get ipd medication
         * --------------
         */
        
        public function get_ipd_medication ( $test_id ) {
            $tests = $this -> db -> get_where ( 'hmis_ipd_medication', array ( 'sale_id' => $test_id ) );
            return $tests -> result ();
        }
        
        /**
         * --------------
         * @param $company_id
         * @return mixed
         * get company panels
         * --------------
         */
        
        public function get_company_panels ( $company_id ) {
            $user     = get_user ( get_logged_in_user_id () );
            $panel_id = $user -> panel_id;
            if ( $user -> panel_id > 0 )
                $panels = $this -> db -> query ( "Select * from hmis_panel_companies where company_id=$company_id and panel_id=$panel_id and panel_id IN (Select id from hmis_panels where status='1')" );
            else
                $panels = $this -> db -> query ( "Select * from hmis_panel_companies where company_id=$company_id and panel_id IN (Select id from hmis_panels where status='1')" );
            return $panels -> result ();
        }
        
        /**
         * --------------
         * @param $service_id
         * @param $panel_id
         * @return int
         * get service discount
         * --------------
         */
        
        public function get_patient_discount ( $service_id, $panel_id ) {
            $discount = $this -> db -> get_where ( 'panel_ipd_services', array (
                'panel_id'   => $panel_id,
                'service_id' => $service_id
            ) );
            if ( $discount -> num_rows () > 0 )
                return $discount -> row ();
            else
                return 0;
        }
        
        /**
         * --------------
         * @return mixed
         * get cash sales
         * --------------
         */
        
        public function get_cash_sales_report () {
            $search = false;
            $sql    = "Select * from hmis_ipd_sold_services where trash='0' and patient_id IN (Select id from hmis_patients where (panel_id='0' OR panel_id IS NULL))";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
                $search     = true;
            }
            if ( isset( $_REQUEST[ 'discharge_start_date' ] ) and !empty( trim ( $_REQUEST[ 'discharge_start_date' ] ) ) and isset( $_REQUEST[ 'discharge_end_date' ] ) and !empty( trim ( $_REQUEST[ 'discharge_end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'discharge_start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'discharge_end_date' ] ) );
                $sql        .= " and DATE(date_discharged) BETWEEN '$start_date' and '$end_date' AND discharged='1'";
                $search     = true;
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and !empty( trim ( $_REQUEST[ 'patient_id' ] ) ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
                $search     = true;
            }
            if ( isset( $_REQUEST[ 'admitted_to' ] ) and !empty( trim ( $_REQUEST[ 'admitted_to' ] ) ) ) {
                $admitted_to = $_REQUEST[ 'admitted_to' ];
                $sql         .= " and sale_id IN (Select sale_id from hmis_ipd_patient_admission_slip where admitted_to='$admitted_to')";
                $search      = true;
            }
            if ( isset( $_REQUEST[ 'reference-id' ] ) and !empty( $_REQUEST[ 'reference-id' ] ) ) {
                $reference_id = $_REQUEST[ 'reference-id' ];
                $sql          .= " and sale_id IN (Select id from hmis_ipd_patient_admission_slip where reference_id='$reference_id')";
                $search       = true;
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and !empty( $_REQUEST[ 'doctor_id' ] ) ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and sale_id IN (Select sale_id from hmis_ipd_patient_admission_slip where doctor_id='$doctor_id')";
                $search    = true;
            }
            
            if ( isset( $_GET[ 'service-id' ] ) and !empty( trim ( $_GET[ 'service-id' ] ) ) and $_GET[ 'service-id' ] > 0 ) {
                $service_id = $_GET[ 'service-id' ];
                $sql        .= " and sale_id IN (Select sale_id from hmis_ipd_patient_consultants where service_id='$service_id')";
                $search     = true;
            }
            
            $sql   .= " order by id DESC";
            $sales = $this -> db -> query ( $sql );
            if ( $search )
                return $sales -> result ();
            else
                return array ();
        }
        
        /**
         * --------------
         * @return mixed
         * get cash sales
         * --------------
         */
        
        public function get_panel_sales_report () {
            $search = false;
            $sql    = "Select * from hmis_ipd_sold_services where trash='0' and patient_id IN (Select id from hmis_patients where type='panel')";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
                $search     = true;
            }
            if ( isset( $_REQUEST[ 'discharge_start_date' ] ) and !empty( trim ( $_REQUEST[ 'discharge_start_date' ] ) ) and isset( $_REQUEST[ 'discharge_end_date' ] ) and !empty( trim ( $_REQUEST[ 'discharge_end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'discharge_end_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'discharge_end_date' ] ) );
                $sql        .= " and DATE(date_discharged) BETWEEN '$start_date' and '$end_date'";
                $search     = true;
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and !empty( trim ( $_REQUEST[ 'patient_id' ] ) ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
                $search     = true;
            }
            if ( isset( $_REQUEST[ 'panel_id' ] ) and !empty( trim ( $_REQUEST[ 'panel_id' ] ) ) and $_REQUEST[ 'panel_id' ] > 0 ) {
                $panel_id = $_REQUEST[ 'panel_id' ];
                $sql      .= " and  patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
                $search   = true;
            }
            if ( isset( $_REQUEST[ 'admitted_to' ] ) and !empty( trim ( $_REQUEST[ 'admitted_to' ] ) ) ) {
                $admitted_to = $_REQUEST[ 'admitted_to' ];
                $sql         .= " and sale_id IN (Select sale_id from hmis_ipd_patient_admission_slip where admitted_to='$admitted_to')";
                $search      = true;
            }
            if ( isset( $_REQUEST[ 'reference-id' ] ) and !empty( $_REQUEST[ 'reference-id' ] ) ) {
                $reference_id = $_REQUEST[ 'reference-id' ];
                $sql          .= " and sale_id IN (Select id from hmis_ipd_patient_admission_slip where reference_id='$reference_id')";
                $search       = true;
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and !empty( $_REQUEST[ 'doctor_id' ] ) ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and sale_id IN (Select sale_id from hmis_ipd_patient_admission_slip where doctor_id='$doctor_id')";
                $search    = true;
            }
            
            if ( isset( $_GET[ 'service-id' ] ) and !empty( trim ( $_GET[ 'service-id' ] ) ) and $_GET[ 'service-id' ] > 0 ) {
                $service_id = $_GET[ 'service-id' ];
                $sql        .= " and sale_id IN (Select sale_id from hmis_ipd_patient_consultants where service_id='$service_id')";
                $search     = true;
            }
            
            $sql   .= " order by id DESC";
            $sales = $this -> db -> query ( $sql );
            if ( $search )
                return $sales -> result ();
            else
                return array ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return string
         * get ipd total
         * --------------
         */
        
        public function get_ipd_total ( $sale_id ) {
            $medication_sum   = $this -> get_ipd_medication_sum ( $sale_id );
            $lab_sum          = $this -> get_ipd_lab_sum ( $sale_id );
            $ipd_services_sum = $this -> get_ipd_services_sum ( $sale_id );
            $net_total        = $medication_sum + $lab_sum + $ipd_services_sum;
            return $net_total;
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return string
         * get ipd total
         * --------------
         */
        
        public function get_ipd_services_total ( $sale_id ) {
            return $this -> get_ipd_services_sum ( $sale_id );
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * ipd medication sum
         * --------------
         */
        
        public function get_ipd_medication_sum ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(net_price) as total from hmis_ipd_medication where sale_id=$sale_id" );
            return $query -> row () -> total;
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * ipd lab sum
         * --------------
         */
        
        public function get_ipd_lab_sum ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(net_price) as total from hmis_ipd_patient_associated_lab_tests where sale_id=$sale_id" );
            return $query -> row () -> total;
        }
        
        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * ipd services sum
         * --------------
         */
        
        public function get_ipd_services_sum ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(net_price) as total from hmis_ipd_patient_associated_services where sale_id=$sale_id" );
            return $query -> row () -> total;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get lab general report
         * -------------------------
         */
        
        public function get_lab_general_report () {
            $sql = "Select sale_id, patient_id, GROUP_CONCAT(test_id) as tests, GROUP_CONCAT(discount) as discounts, SUM(price) as price, SUM(net_price) as net_price, date_added from hmis_ipd_patient_associated_lab_tests where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            if ( isset( $_REQUEST[ 'test_id' ] ) and !empty( trim ( $_REQUEST[ 'test_id' ] ) ) and is_numeric ( $_REQUEST[ 'test_id' ] ) > 0 ) {
                $test_id = $_REQUEST[ 'test_id' ];
                $sql     .= " and test_id=$test_id";
            }
            if ( isset( $_REQUEST[ 'sale_id' ] ) and !empty( trim ( $_REQUEST[ 'sale_id' ] ) ) and is_numeric ( $_REQUEST[ 'sale_id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            if ( isset( $_REQUEST[ 'start_time' ] ) and isset( $_REQUEST[ 'end_time' ] ) and !empty( $_REQUEST[ 'start_time' ] ) and !empty( $_REQUEST[ 'end_time' ] ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'start_time' ] ) );
                $end_time   = date ( 'H:i:s', strtotime ( $_REQUEST[ 'end_time' ] ) );
                $sql        .= " and TIME(date_added) BETWEEN '$start_time' and '$end_time'";
            }
            $sql   .= " group by sale_id order by DATE(date_added) ASC";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @param $med_id
         * @param $sale_id
         * @return mixed
         * get medication
         * -------------------------
         */
        
        public function get_medication_by_id ( $med_id, $sale_id ) {
            $medication = $this -> db -> get_where ( 'ipd_medication', array (
                'id'      => $med_id,
                'sale_id' => $sale_id
            ) );
            return $medication -> row ();
        }
        
        /**
         * -------------------------
         * @param $med_id
         * @return mixed
         * delete ipd medication
         * -------------------------
         */
        
        public function delete_ipd_medication ( $med_id ) {
            $this -> db -> delete ( 'ipd_medication', array ( 'id' => $med_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get ipd total sale
         * by date range
         * -------------------------
         */
        
        public function get_total_sale_by_date_range () {
            $sql = "Select SUM(net_total) as net from hmis_ipd_sales where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) Between '$start_date' and '$end_date'";
            }
            if ( isset( $_REQUEST[ 'start_time' ] ) and isset( $_REQUEST[ 'end_time' ] ) and !empty( $_REQUEST[ 'start_time' ] ) and !empty( $_REQUEST[ 'end_time' ] ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'start_time' ] ) );
                $end_time   = date ( 'H:i:s', strtotime ( $_REQUEST[ 'end_time' ] ) );
                $sql        .= " and TIME(date_added) BETWEEN '$start_time' and '$end_time'";
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
         * @param $data
         * @return mixed
         * clear bill
         * -------------------------
         */
        
        public function clear_bill ( $data ) {
            $this -> db -> insert ( 'ipd_medication_bill_cleared', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * clear bill
         * -------------------------
         */
        
        public function clear_lab_bill ( $data ) {
            $this -> db -> insert ( 'ipd_lab_bill_cleared', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get sales by invoice id
         * or by date added
         * -------------------------
         */
        
        public function get_sale_tests () {
            $sql = "Select * from hmis_ipd_patient_associated_lab_tests where 1";
            if ( isset( $_REQUEST[ 'invoice_id' ] ) and !empty( trim ( $_REQUEST[ 'invoice_id' ] ) ) and is_numeric ( $_REQUEST[ 'invoice_id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'invoice_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            if ( isset( $_REQUEST[ 'date' ] ) and !empty( trim ( $_REQUEST[ 'date' ] ) ) ) {
                $date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'date' ] ) );
                $sql  .= " and DATE(date_added)='$date'";
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
            $sql = "Select * from hmis_ipd_patient_associated_lab_tests where (parent_id IS NULL OR parent_id='' OR parent_id=0)";
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
            $sql = "Select * from hmis_ipd_patient_associated_lab_tests where 1";
            if ( isset( $_REQUEST[ 'sale-id' ] ) and !empty( trim ( $_REQUEST[ 'sale-id' ] ) ) and is_numeric ( $_REQUEST[ 'sale-id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'sale-id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            if ( isset( $_REQUEST[ 'sale-table-id' ] ) and !empty( trim ( $_REQUEST[ 'sale-table-id' ] ) ) and is_numeric ( $_REQUEST[ 'sale-table-id' ] ) > 0 ) {
                $sale_table_id = $_REQUEST[ 'sale-table-id' ];
                $getSaleDate   = $this -> db -> query ( "Select * from hmis_ipd_patient_associated_lab_tests where id=$sale_table_id" );
                $saleDate      = $getSaleDate -> row () -> date_added;
                $date          = date ( 'Y-m-d H:i', strtotime ( $saleDate ) );
                $sql           .= " and date_added LIKE '$date%'";
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
        
        /**
         * -------------------------
         * @param $id
         * @param $sale_id
         * @param $sale_table_id
         * get_test_results
         * -------------------------
         * @return mixed
         */
        
        public function get_ipd_test_results ( $sale_id, $id, $sale_table_id ) {
            $tests = $this -> db -> get_where ( 'ipd_test_results', array (
                'test_id'       => $id,
                'sale_id'       => $sale_id,
                'sale_table_id' => $sale_table_id
            ) );
            return $tests -> row ();
        }
        
        /**
         * -------------------------
         * @param $id
         * @param $sale_id
         * get_test_results
         * @return mixed
         * -------------------------
         */
        
        public function get_ipd_test_result ( $sale_id, $id ) {
            $tests = $this -> db -> get_where ( 'ipd_test_results', array (
                'test_id' => $id,
                'sale_id' => $sale_id,
            ) );
            return $tests -> row ();
        }
        
        /**
         * -------------------------
         * @param $id
         * @param $sale_id
         * @param $sale_table_id
         * get_test_results
         * @return mixed
         * -------------------------
         */
        
        public function get_ipd_test_result_associated_to_sale_table_id ( $sale_id, $id, $sale_table_id ) {
            $tests = $this -> db -> get_where ( 'ipd_test_results', array (
                'test_id'       => $id,
                'sale_id'       => $sale_id,
                'sale_table_id' => $sale_table_id,
            ) );
            return $tests -> row ();
        }
        //
        
        /**
         * -------------------------
         * @param $sale_id
         * delete_results
         * -------------------------
         */
        
        public function delete_results ( $sale_id ) {
            $this -> db -> delete ( 'ipd_test_results', array ( 'sale_id' => $sale_id ) );
        }
        //
        
        /**
         * -------------------------
         * @param $sale_id
         * @param $result_id
         * delete_results
         * -------------------------
         */
        
        public function delete_ipd_results ( $sale_id, $result_id ) {
            if ( $result_id > 0 ) {
                $sql = "Delete from hmis_ipd_test_results where sale_id=$sale_id and result_id=$result_id";
                $this -> db -> query ( $sql );
                $sql2 = "Delete from hmis_ipd_test_results where sale_id=$sale_id and id=$result_id";
                $this -> db -> query ( $sql2 );
            }
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @param $result_id
         * delete_results
         * -------------------------
         */
        
        public function delete_ipd_results_associated_by_sale_table_id ( $sale_id, $result_id, $sale_table_id ) {
            if ( $result_id > 0 ) {
                $sql = "Delete from hmis_ipd_test_results where sale_id=$sale_id and result_id=$result_id and sale_table_id=$sale_table_id";
                $this -> db -> query ( $sql );
                $sql2 = "Delete from hmis_ipd_test_results where sale_id=$sale_id and id=$result_id and sale_table_id=$sale_table_id";
                $this -> db -> query ( $sql2 );
            }
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save tests result into database
         * -------------------------
         */
        
        public function do_add_test_results ( $data ) {
            $this -> db -> insert ( 'ipd_test_results', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get test results by Invoice ID
         * -------------------------
         */
        
        public function get_lab_results_by_sale_id ( $sale_id ) {
            $sql = "Select * from hmis_ipd_test_results where 1";
            
            if ( $sale_id > 0 )
                $sql .= " and sale_id=$sale_id";
            
            if ( isset( $_REQUEST[ 'selected' ] ) and !empty( trim ( $_REQUEST[ 'selected' ] ) ) ) {
                $selected = $_REQUEST[ 'selected' ];
                $sql      .= " and id IN($selected)";
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
            $sales = $this -> db -> get_where ( 'ipd_test_results', array (
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
            $sql = "Select * from hmis_ipd_test_results where sale_id=$sale_id and test_id IN($ids)";
            if ( $result_id > 0 ) {
                $sql .= " and result_id=$result_id";
            }
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * get test parameters info by id
         * -------------------------
         * @return mixed
         */
        
        public function get_patient_id_by_sale_id ( $sale_id ) {
            $patient = $this -> db -> get_where ( 'hmis_ipd_patient_associated_lab_tests', array ( 'sale_id' => $sale_id ) );
            return $patient -> row () -> patient_id;
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * get test parameters info by id
         * -------------------------
         * @return mixed
         */
        
        public function get_ipd_patient_id_by_sale_id ( $sale_id ) {
            $patient = $this -> db -> get_where ( 'ipd_patient_admission_slip', array ( 'sale_id' => $sale_id ) );
            return $patient -> row () -> patient_id;
        }
        
        /**
         * -------------------------
         * @param $id
         * get ipd service by id
         * @return mixed
         * -------------------------
         */
        
        public function get_ipd_patient_ipd_service_by_id ( $id ) {
            $service = $this -> db -> get_where ( 'ipd_patient_associated_services', array ( 'id' => $id ) );
            return $service -> row ();
        }
        
        /**
         * -------------------------
         * @param $ids
         * @return mixed
         * get ipd medications by ids
         * -------------------------
         */
        
        public function getIPDMedicationByID ( $ids ) {
            $medications    = explode ( ',', $ids );
            $medication_IDS = array ();
            if ( count ( $medications ) > 0 ) {
                foreach ( $medications as $medication ) {
                    if ( $medication > 0 ) {
                        array_push ( $medication_IDS, $medication );
                    }
                }
            }
            if ( count ( $medication_IDS ) > 0 ) {
                $ids = implode ( ',', $medication_IDS );
                $med = $this -> db -> query ( "Select * from hmis_ipd_medication where id IN ($ids)" );
                return $med -> result ();
            }
        }
        
        /**
         * -------------------------
         * @return mixed
         * get consultant commission
         * -------------------------
         */
        
        public function get_consultant_commission ( $commissionExists = false ) {
            $search = false;
            $sql    = "Select * from hmis_ipd_patient_consultants where 1";
            
            if ( $commissionExists ) {
                $sql    .= " and commission > 0";
            }
            
            if ( isset( $_GET[ 'start_date' ] ) and !empty( trim ( $_GET[ 'start_date' ] ) ) and isset( $_GET[ 'end_date' ] ) and !empty( trim ( $_GET[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_GET[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_GET[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' AND '$end_date'";
                $search     = true;
            }
            
            if ( isset( $_GET[ 'doctor-id' ] ) and !empty( trim ( $_GET[ 'doctor-id' ] ) ) and $_GET[ 'doctor-id' ] > 0 ) {
                $doctor_id = $_GET[ 'doctor-id' ];
                $sql       .= " and doctor_id=$doctor_id";
                $search    = true;
            }
            
            if ( isset( $_GET[ 'service-id' ] ) and !empty( trim ( $_GET[ 'service-id' ] ) ) and $_GET[ 'service-id' ] > 0 ) {
                $service_id = $_GET[ 'service-id' ];
                $sql        .= " and service_id=$service_id";
                $search     = true;
            }
            
            if ( isset( $_GET[ 'panel_id' ] ) and !empty( trim ( $_GET[ 'panel_id' ] ) ) and $_GET[ 'panel_id' ] > 0 ) {
                $panel_id = $_GET[ 'panel_id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
                $search   = true;
            }
            
            if ( isset( $_GET[ 'cash' ] ) and !empty( trim ( $_GET[ 'cash' ] ) ) and $_GET[ 'panel_id' ] == 'cash' ) {
                $sql    .= " and patient_id NOT IN (Select id from hmis_patients where panel_id > 0)";
                $search = true;
            }
            
            $query = $this -> db -> query ( $sql );
            return $search ? $query -> result () : array ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get ipd medication net price
         * -------------------------
         */
        
        public function get_ipd_medication_net_price ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(net_price) as net_price from hmis_ipd_medication where sale_id=$sale_id" );
            return $query -> row () -> net_price;
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get ipd lab net price
         * -------------------------
         */
        
        public function get_ipd_lab_net_price ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(net_price) as net_price from hmis_ipd_patient_associated_lab_tests where sale_id=$sale_id" );
            return $query -> row () -> net_price;
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return bool
         * check if consultant added
         * -------------------------
         */
        
        public function if_consultant_added ( $sale_id ) {
            $query = $this -> db -> query ( "Select count(*) as totalRows from hmis_ipd_patient_consultants where sale_id=$sale_id" );
            if ( $query -> row () -> totalRows > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * @return mixed
         * get ipd ot timings
         * --------------
         */
        
        public function get_ot_timings_by_filter () {
            $search = false;
            $sql    = "Select * from hmis_ipd_ot_timings where 1";
            
            if ( isset( $_GET[ 'start_date' ] ) and !empty( trim ( $_GET[ 'start_date' ] ) ) and isset( $_GET[ 'end_date' ] ) and !empty( trim ( $_GET[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_GET[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_GET[ 'end_date' ] ) );
                $sql        .= " and DATE(created_at) BETWEEN '$start_date' AND '$end_date'";
                $search     = true;
            }
            
            if ( isset( $_GET[ 'sale-id' ] ) and !empty( trim ( $_GET[ 'sale-id' ] ) ) and $_GET[ 'sale-id' ] > 0 ) {
                $sale_id = $_GET[ 'sale-id' ];
                $sql     .= " and sale_id=$sale_id";
                $search  = true;
            }
            
            if ( isset( $_GET[ 'patient-id' ] ) and !empty( trim ( $_GET[ 'patient-id' ] ) ) and $_GET[ 'patient-id' ] > 0 ) {
                $patient_id = $_GET[ 'patient-id' ];
                $sql        .= " and patient_id=$patient_id";
                $search     = true;
            }
            
            if ( isset( $_GET[ 'admitted-to' ] ) and !empty( trim ( $_GET[ 'admitted-to' ] ) ) ) {
                $admitted_to = $_GET[ 'admitted-to' ];
                $sql         .= " and patient_id IN (Select patient_id from hmis_ipd_patient_admission_slip where admitted_to='$admitted_to')";
                $search      = true;
            }
            
            if ( isset( $_GET[ 'service-id' ] ) and !empty( trim ( $_GET[ 'service-id' ] ) ) ) {
                $service_id = $_GET[ 'service-id' ];
                $sql        .= " and patient_id IN (Select patient_id from hmis_ipd_patient_consultants where service_id='$service_id')";
                $search     = true;
            }
            
            if ( isset( $_GET[ 'panel_id' ] ) and !empty( trim ( $_GET[ 'panel_id' ] ) ) and $_GET[ 'panel_id' ] > 0 ) {
                $panel_id = $_GET[ 'panel_id' ];
                $sql      .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
                $search   = true;
            }
            
            if ( isset( $_GET[ 'panel_id' ] ) and !empty( trim ( $_GET[ 'panel_id' ] ) ) and $_GET[ 'panel_id' ] == 'cash' ) {
                $sql    .= " and patient_id NOT IN (Select id from hmis_patients where panel_id > 0)";
                $search = true;
            }
            
            $timings = $this -> db -> query ( $sql );
            if ( $search )
                return $timings -> result ();
            else
                return array ();
        }
        
        /**
         * --------------
         * @param $bed_id
         * @return mixed
         * get admission slip by bed id
         * --------------
         */
        
        public function get_ipd_admission_slip_by_bed ( $bed_id ) {
            $slip = $this -> db -> query ( "Select * from hmis_ipd_patient_admission_slip where bed_id=$bed_id and sale_id IN (Select sale_id from hmis_ipd_sold_services where discharged='0')" );
            return $slip -> row ();
        }
        
        public function get_unselected_services ( $package_id ) {
            $query = $this
                -> db
                -> select ( '*' )
                -> from ( 'ipd_services' )
                -> where ( "id NOT IN (SELECT service_id FROM hmis_ipd_package_services WHERE package_id=$package_id)" )
                -> get ();
            return $query -> result ();
        }
        
        public function edit_ipd_package ( $info, $package_id ) {
            $this -> db -> update ( 'ipd_packages', $info, array ( 'id' => $package_id ) );
        }
        
        public function get_all_services_array ( $panel_id = 0 ) {
            $sql = "Select * from hmis_ipd_services where 1";
            if ( $panel_id > 0 ) {
                $sql .= " and id IN (Select service_id from hmis_panel_ipd_services where panel_id=$panel_id)";
            }
            $services = $this -> db -> query ( $sql );
            return $services -> result_array ();
//            $this -> db -> order_by ( 'title', 'ASC' );
//            $services = $this -> db -> get ( 'ipd_services' );
//            return $services -> result_array ();
        }
        
        public function get_not_selected_services_array ( $package_id ) {
            $sql      = "Select * from hmis_ipd_services where id NOT IN (Select service_id from hmis_ipd_package_services where package_id=$package_id)";
            $sql      .= " order by title ASC";
            $services = $this -> db -> query ( $sql );
            return $services -> result_array ();
        }
        
        public function get_doctors_summary_report () {
            $start_date = $this -> input -> get ( 'start-date' );
            $end_date   = $this -> input -> get ( 'end-date' );
            $doctor_id  = $this -> input -> get ( 'doctor-id' );
            $search     = false;
            
            if ( isset( $start_date ) && isset( $end_date ) && !empty( trim ( $start_date ) ) && !empty( trim ( $end_date ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                
                $this -> db -> where ( "DATE(admission_date) BETWEEN '$start_date' AND '$end_date'" );
                $search = true;
            }
            
            if ( isset( $doctor_id ) && !empty( trim ( $doctor_id ) ) && $doctor_id > 0 ) {
                $this -> db -> where ( 'doctor_id', $doctor_id );
                $search = true;
            }
            
            $this -> db -> select ( '*, COUNT(*) as totalRows, GROUP_CONCAT(patient_id) as patients' );
            $this -> db -> group_by ( 'doctor_id' );
            $sales = $this -> db -> get ( 'ipd_patient_admission_slip' );
            
            return $search ? $sales -> result () : array ();
            
        }
        
        public function get_ipd_total_report () {
            
            $start_date = $this -> input -> get ( 'start_date' );
            $end_date   = $this -> input -> get ( 'end_date' );
            $start_time = $this -> input -> get ( 'start_time' );
            $end_time   = $this -> input -> get ( 'end_time' );
            $user_id    = $this -> input -> get ( 'user_id' );
            
            $this
                -> db
                -> select ( 'SUM(amount) as net' )
                -> from ( 'ipd_sale_payments' )
                -> where ( "patient_id IN (Select id FROM hmis_patients WHERE (panel_id IS NULL OR panel_id='0' OR panel_id=''))" );
            
            if ( isset( $start_date ) and !empty( trim ( $start_date ) ) and isset( $end_date ) and !empty( trim ( $end_date ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                $this -> db -> where ( "DATE(date_added) Between '$start_date' and '$end_date'" );
            }
            
            if ( isset( $start_time ) and isset( $end_time ) and !empty( $start_time ) and !empty( $end_time ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $start_time ) );
                $end_time   = date ( 'H:i:s', strtotime ( $end_time ) );
                $this -> db -> where ( "TIME(date_added) BETWEEN '$start_time' and '$end_time'" );
            }
            
            if ( isset( $user_id ) and $user_id > 0 ) {
                $this -> db -> where ( 'user_id', $user_id );
            }
            
            $query = $this -> db -> get ();
            return $query -> row () -> net;
        }
        
        public function get_ipd_cash_by_panel ( $panel_id ) {
            
            $start_date = $this -> input -> get ( 'start_date' );
            $end_date   = $this -> input -> get ( 'end_date' );
            $start_time = $this -> input -> get ( 'start_time' );
            $end_time   = $this -> input -> get ( 'end_time' );
            $user_id    = $this -> input -> get ( 'user_id' );
            
            $this
                -> db
                -> select ( 'SUM(amount) as net' )
                -> from ( 'ipd_sale_payments' )
                -> where ( "patient_id IN (Select id FROM hmis_patients WHERE panel_id=$panel_id)" );
            
            if ( isset( $start_date ) and !empty( trim ( $start_date ) ) and isset( $end_date ) and !empty( trim ( $end_date ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                $this -> db -> where ( "DATE(date_added) Between '$start_date' and '$end_date'" );
            }
            
            if ( isset( $start_time ) and isset( $end_time ) and !empty( $start_time ) and !empty( $end_time ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $start_time ) );
                $end_time   = date ( 'H:i:s', strtotime ( $end_time ) );
                $this -> db -> where ( "TIME(date_added) BETWEEN '$start_time' and '$end_time'" );
            }
            
            if ( isset( $user_id ) and $user_id > 0 ) {
                $this -> db -> where ( 'user_id', $user_id );
            }
            
            $query = $this -> db -> get ();
            return $query -> row () -> net;
        }
        
        public function do_send_claim ( $sale_id ) {
            $this -> db -> insert ( 'ipd_claims_sent', array ( 'user_id' => get_logged_in_user_id (), 'sale_id' => $sale_id ) );
            $this -> db -> update ( 'ipd_sales', array ( 'claimed' => '1' ), array ( 'id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        public function total_ipd_services_included ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(net_price) as total from hmis_ipd_patient_associated_services where sale_id=$sale_id and included='1'" );
            if ( $query -> num_rows () > 0 )
                return $query -> row () -> total;
            else
                return 0;
        }
        
        public function total_ipd_services_excluded ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(net_price) as total from hmis_ipd_patient_associated_services where sale_id=$sale_id and included='0'" );
            if ( $query -> num_rows () > 0 )
                return $query -> row () -> total;
            else
                return 0;
        }
        
        public function sum_ipd_payments ( $sale_id ) {
            $payments = $this -> db -> query ( "Select SUM(amount) as amount FROM hmis_ipd_sale_payments WHERE sale_id=$sale_id" );
            return $payments -> row () -> amount;
        }
        
        public function get_sum_patient_ipd_associated_services_consolidated_not_in_type ( $sale_id, $included = '1' ) {
            $service_type = ipd_service_types;
            $services     = $this -> db -> query ( "Select SUM(net_price) as net_price from hmis_ipd_patient_associated_services where sale_id=$sale_id and included='$included' and service_id IN (Select id from hmis_ipd_services where service_type NOT IN ($service_type)) group by sale_id" );
            if ( $services -> num_rows () > 0 )
                return $services -> row () -> net_price;
            else
                return 0;
        }
        
        public function get_receivable_report () {
            
            $start_date = $this -> input -> get ( 'start-date' );
            $end_date   = $this -> input -> get ( 'end-date' );
            $claim      = $this -> input -> get ( 'claim' );
            $discharged = $this -> input -> get ( 'discharged' );
            $search     = false;
            
            $this
                -> db
                -> select ( '*' )
                -> from ( 'ipd_sold_services' )
                -> where ( "patient_id IN (Select id FROM hmis_patients WHERE panel_id='4')" );
            
            if ( isset( $start_date ) and !empty( trim ( $start_date ) ) and isset( $end_date ) and !empty( trim ( $end_date ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                $this -> db -> where ( "DATE(date_added) Between '$start_date' and '$end_date'" );
                $search = true;
            }
            
            if ( in_array ( $claim, [ '0', '1' ] ) ) {
                $this -> db -> where ( "sale_id IN (Select id FROM hmis_ipd_sales WHERE ssp_claimed='$claim')" );
                $search = true;
            }
            
            if ( in_array ( $discharged, [ '0', '1' ] ) ) {
                $this -> db -> where ( "discharged='$discharged'" );
                $search = true;
            }
            
            $query = $this -> db -> get ();
            return $search ? $query -> result () : array ();
        }
        
        public function get_ipd_included_services_sum ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(net_price) as total from hmis_ipd_patient_associated_services where sale_id=$sale_id AND included='1'" );
            return $query -> row () -> total;
        }
        
        public function get_ipd_receivable_by_sale_id ( $sale_id ) {
            $data = $this -> db -> get_where ( 'ipd_receivables', array ( 'sale_id' => $sale_id ) );
            return $data -> row ();
        }
        
        public function count_ipd_payments_received_by_patient ( $sale_id, $patient_id ) {
            $payments = $this -> db -> query ( "Select SUM(amount) as amount FROM hmis_ipd_sale_payments WHERE sale_id='$sale_id' AND patient_id='$patient_id'" );
            $sale     = $this -> get_ipd_sale ( $sale_id );
            return ( $payments -> row () -> amount + $sale -> initial_deposit );
        }
        
        public function get_sum_patient_associated_services_by_type ( $sale_id, $type ) {
            $services = $this -> db -> query ( "Select SUM(net_price) as net_price from hmis_ipd_patient_associated_services where sale_id=$sale_id and service_id IN (Select id from hmis_ipd_services where service_type IN ('$type')) group by sale_id" );
            
            return $services -> num_rows () > 0 ? $services -> row () -> net_price : 0;
        }
        
        public function get_patient_sum_ipd_associated_services_consolidated_not_in_type ( $sale_id, $included = '1' ) {
            $service_type = ipd_service_types;
            $services     = $this -> db -> query ( "Select SUM(net_price) as net_price from hmis_ipd_patient_associated_services where sale_id=$sale_id and included='$included' and service_id IN (Select id from hmis_ipd_services where service_type NOT IN ($service_type)) group by sale_id" );
            if ( $services -> num_rows () > 0 )
                return $services -> row () -> net_price;
            else
                return 0;
        }
        
        public function get_ipd_visits () {
            $this
                -> db
                -> select ( '*' )
                -> from ( 'ipd_patient_admission_slip' )
                -> where ( "(visit_no IS NOT NULL AND visit_no!='') AND sale_id NOT IN (Select sale_id FROM hmis_ipd_receivables)" );
            $admissions = $this -> db -> get ();
            return $admissions -> result ();
        }
        
        public function process_receivables ( $data ) {
            $this -> db -> insert ( 'ipd_receivables', $data );
        }
        
        public function count_ipd_admitted_patients_by_month ( $month ) {
            $this
                -> db
                -> select ( 'COUNT(patient_id) as totalRows' )
                -> from ( 'ipd_patient_admission_slip' )
                -> where ( "MONTH(admission_date)='$month' AND patient_id IN (Select id FROM hmis_patients WHERE panel_id > 0)" );
            $sql = $this -> db -> get ();
            return $sql -> row () -> totalRows;
        }
        
        public function count_ipd_discharged_patients_by_month ( $month ) {
            $this
                -> db
                -> select ( 'COUNT(patient_id) as totalRows' )
                -> from ( 'ipd_sold_services' )
                -> where ( "MONTH(date_discharged)='$month' AND discharged='1' AND patient_id IN (Select id FROM hmis_patients WHERE panel_id > 0)" );
            $sql = $this -> db -> get ();
            return $sql -> row () -> totalRows;
        }
        
        public function count_ipd_claims_sent_by_month ( $month ) {
            $this
                -> db
                -> select ( 'COUNT(*) as totalRows' )
                -> from ( 'ipd_claims_sent' )
                -> where ( "MONTH(created_at)='$month'" );
            $sql = $this -> db -> get ();
            return $sql -> row () -> totalRows;
        }
        
        public function count_ipd_pending_claims_by_month ( $month ) {
            $this
                -> db
                -> select ( 'COUNT(patient_id) as totalRows' )
                -> from ( 'ipd_patient_admission_slip' )
                -> where ( "MONTH(admission_date)='$month' AND patient_id IN (Select id FROM hmis_patients WHERE panel_id > 0) AND sale_id IN (Select id FROM hmis_ipd_sales WHERE claimed='0')" );
            $sql = $this -> db -> get ();
            return $sql -> row () -> totalRows;
        }
        
        public function sum_of_ipd_services_of_admitted_patients_by_month ( $month ) {
            $this
                -> db
                -> select ( 'SUM(net_price) as netPrice' )
                -> from ( 'ipd_patient_associated_services' )
                -> where ( "sale_id IN (Select sale_id FROM hmis_ipd_patient_admission_slip WHERE MONTH(date_added)='$month') AND included='1' AND sale_id IN (Select sale_id FROM hmis_ipd_sold_services WHERE discharged='0') AND patient_id IN (Select id FROM hmis_patients WHERE panel_id > 0)" );
            $sql = $this -> db -> get ();
            return $sql -> row () -> netPrice;
        }
        
        public function sum_of_ipd_services_of_discharged_patients_by_month ( $month ) {
            $this
                -> db
                -> select ( 'SUM(net_price) as netPrice' )
                -> from ( 'ipd_patient_associated_services' )
                -> where ( "sale_id IN (Select sale_id FROM hmis_ipd_patient_admission_slip WHERE MONTH(date_added)='$month') AND included='1' AND sale_id IN (Select sale_id FROM hmis_ipd_sold_services WHERE discharged='1') AND patient_id IN (Select id FROM hmis_patients WHERE panel_id > 0)" );
            $sql = $this -> db -> get ();
            return $sql -> row () -> netPrice;
        }
        
        public function sum_of_ipd_deduction_by_month ( $month, $discharged = '0' ) {
            $this
                -> db
                -> select ( 'SUM(deduction) as deduction' )
                -> from ( 'ipd_sales' )
                -> where ( "id IN (Select sale_id FROM hmis_ipd_patient_admission_slip WHERE MONTH(date_added)='$month' AND id IN (Select sale_id FROM hmis_ipd_sold_services WHERE discharged='$discharged') AND patient_id IN (Select id FROM hmis_patients WHERE panel_id > 0))" );
            $sql = $this -> db -> get ();
            return $sql -> row () -> deduction;
        }
        
        public function get_average_tax_by_month ( $month ) {
            $this
                -> db
                -> select ( 'SUM(tax) as tax, COUNT(*) as totalRows' )
                -> from ( 'ipd_sales' )
                -> where ( "id IN (Select sale_id FROM hmis_ipd_patient_admission_slip WHERE MONTH(date_added)='$month' AND patient_id IN (Select id FROM hmis_patients WHERE panel_id > 0))" );
            $sql = $this -> db -> get ();
            return $sql -> row () -> totalRows > 0 ? ( $sql -> row () -> tax / $sql -> row () -> totalRows ) : 0;
        }
        
        public function sum_of_ipd_received_claimed_amount_by_month ( $month ) {
            $this
                -> db
                -> select ( '*' )
                -> from ( 'ipd_receivables' )
                -> where ( "MONTH(cheque_date)='$month'" );
            $sql         = $this -> db -> get ();
            $receivables = $sql -> result ();
            
            $net      = 0;
            $multiple = array ();
            if ( count ( $receivables ) > 0 ) {
                foreach ( $receivables as $receivable ) {
                    $ledgers = explode ( ',', $receivable -> general_ledger_ids );
                    $ledger  = $ledgers[ 0 ];
                    $ledger  = get_ledger ( array ( 'id' => $ledger ) );
                    
                    if ( !empty( $ledger ) && !in_array ( $ledgers[ 0 ], $multiple ) )
                        $net += ( $ledger -> credit + $ledger -> debit );
                    
                    $multiple[] = $ledgers[ 0 ];
                }
            }
            return $net;
        }
        
        public function sum_ipd_claims_sent_by_month ( $month ) {
            $this
                -> db
                -> select ( '*' )
                -> from ( 'ipd_claims_sent' )
                -> where ( "MONTH(created_at)='$month'" );
            $sql    = $this -> db -> get ();
            $claims = $sql -> result ();
            
            $ipd_services_sum = 0;
            if ( count ( $claims ) > 0 ) {
                foreach ( $claims as $claim ) {
                    $sale             = $this -> get_ipd_sale ( $claim -> sale_id );
                    $deduction        = $sale -> deduction;
                    $tax              = $sale -> tax;
                    $ipdServices      = $this -> get_ipd_included_services_sum ( $claim -> sale_id );
                    $tax_value        = ( $ipdServices * ( $tax / 100 ) );
                    $ipdServices      = $ipdServices - $deduction - $tax_value;
                    $ipd_services_sum += $ipdServices;
                }
            }
            return $ipd_services_sum;
        }
        
        public function claim_aging_report () {
            $month = $this -> input -> get ( 'month' );
            $this
                -> db
                -> select ( '*' )
                -> from ( 'ipd_claims_sent' );
            
            if ( !empty( trim ( $month ) ) )
                $this -> db -> where ( "MONTH(created_at)='$month'" );
            
            $sql = $this -> db -> get ();
            return $sql -> result ();
        }
        
        public function sum_ipd_claims_by_sale_id ( $sale ) {
            $deduction   = $sale -> deduction;
            $tax         = $sale -> tax;
            $ipdServices = $this -> get_ipd_included_services_sum ( $sale -> id );
            $tax_value   = ( $ipdServices * ( $tax / 100 ) );
            return ( $ipdServices - $deduction - $tax_value );
        }
        
        public function get_ipd_receivables ( $general_ledger_ids ) {
            $data = $this -> db -> query ( "Select GROUP_CONCAT(visit_no) as visits FROM hmis_ipd_receivables WHERE general_ledger_ids IN ($general_ledger_ids) GROUP BY general_ledger_ids" );
            return $data -> row ();
        }
        
        public function get_anesthesia_services () {
            $services = $this -> db -> get_where ( 'ipd_services', array ( 'parent_id' => Anesthetist_Charges ) );
            return $services -> result ();
        }
        
        public function get_anesthesia_charges ( $sale_id ) {
            $charges = $this -> db -> get_where ( 'ipd_patient_anesthesia_charges', array ( 'sale_id' => $sale_id ) );
            return $charges -> result ();
        }
        
        public function add_ipd_anesthesia_charges ( $info ) {
            $this -> db -> insert ( 'ipd_patient_anesthesia_charges', $info );
            return $this -> db -> insert_id ();
        }
        
        public function get_ipd_patient_consultant_by_id ( $id ) {
            $charges = $this -> db -> get_where ( 'ipd_patient_consultants', array ( 'id' => $id ) );
            return $charges -> row ();
        }
        
        public function get_ipd_patient_anesthesia_doctor_by_id ( $id ) {
            $charges = $this -> db -> get_where ( 'ipd_patient_anesthesia_charges', array ( 'id' => $id ) );
            return $charges -> row ();
        }
        
        public function delete_ipd_anesthesia_doctor ( $id ) {
            $this -> db -> delete ( 'ipd_patient_anesthesia_charges', array ( 'id' => $id ) );
        }
        
        public function get_ipd_excluded_services_sum ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(net_price) as total from hmis_ipd_patient_associated_services where sale_id=$sale_id AND included='0'" );
            return $query -> row () -> total;
        }
        
        public function get_ipd_services_not_in_panel ( $panel_id ) {
            $this
                -> db
                -> select ( '*' )
                -> from ( 'ipd_services' )
                -> where ( "id NOT IN (Select service_id From hmis_panel_ipd_services WHERE panel_id=$panel_id)" );
            $services = $this -> db -> get ();
            return $services -> result_array ();
        }
        
        public function cash_receiving_report () {
            $search = false;
            $this
                -> db
                -> select ( '*' )
                -> from ( 'ipd_sale_payments' )
                -> where ( "sale_id IN (Select sale_id FROM hmis_ipd_patient_admission_slip WHERE patient_id IN (Select id from hmis_patients where (panel_id='0' OR panel_id IS NULL)))" );
            
            if ( !empty( trim ( $this -> input -> get ( 'start-date' ) ) ) and !empty( trim ( $this -> input -> get ( 'end-date' ) ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $this -> input -> get ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $this -> input -> get ( 'end-date' ) ) );
                $this -> db -> where ( "DATE(date_added) BETWEEN '$start_date' and '$end_date'" );
                $search = true;
            }
            
            $sales = $this -> db -> get ();
            return $search ? $sales -> result () : array ();
        }
        
        public function cash_receiving_report_panel () {
            $search = false;
            $this
                -> db
                -> select ( '*' )
                -> from ( 'ipd_sale_payments' )
                -> where ( "sale_id IN (Select sale_id FROM hmis_ipd_patient_admission_slip WHERE patient_id IN (Select id from hmis_patients where (panel_id > 0)))" );
            
            if ( !empty( trim ( $this -> input -> get ( 'start-date' ) ) ) and !empty( trim ( $this -> input -> get ( 'end-date' ) ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $this -> input -> get ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $this -> input -> get ( 'end-date' ) ) );
                $this -> db -> where ( "DATE(date_added) BETWEEN '$start_date' and '$end_date'" );
                $search = true;
            }
            
            $sales = $this -> db -> get ();
            return $search ? $sales -> result () : array ();
        }
    }
