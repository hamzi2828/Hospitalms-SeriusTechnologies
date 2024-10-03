<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class OPDModel extends CI_Model {
        
        /**
         * --------------
         * OPDModel constructor.
         * --------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * --------------
         * @param $panel_id
         * @return mixed
         * get all services
         * --------------
         */
        
        public function get_all_services ( $panel_id = 0 ) {
            $sql = "Select * from hmis_opd_services where 1";
            if ( $panel_id > 0 ) {
                $sql .= " and id IN (Select service_id from hmis_panel_opd_services where panel_id=$panel_id)";
            }
            $sql      .= " order by title ASC";
            $services = $this -> db -> query ( $sql );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @return mixed
         * get parent services
         * --------------
         */
        
        public function get_parent_services () {
            $this -> db -> order_by ( 'title', 'ASC' );
            $services = $this -> db -> get_where ( 'opd_services', array ( 'parent_id' => 0 ) );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @param $service_id
         * check if service has children
         * --------------
         * @return boolean
         */
        
        public function opd_services_has_children ( $service_id ) {
            $services = $this -> db -> get_where ( 'opd_services', array ( 'parent_id' => $service_id ) );
            if ( $services -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * @param $info
         * add services
         * @return mixed
         * --------------
         */
        
        public function add ( $info ) {
            $this -> db -> insert ( 'opd_services', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $service_id
         * delete services
         * @return mixed
         * --------------
         */
        
        public function delete ( $service_id ) {
            $this -> db -> delete ( 'opd_services', array ( 'id' => $service_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $service_id
         * get service by id
         * @return mixed
         * --------------
         */
        
        public function get_service_by_id ( $service_id ) {
            $service = $this -> db -> get_where ( 'opd_services', array ( 'id' => $service_id ) );
            return $service -> row ();
        }
        
        /**
         * --------------
         * @param $service_id
         * get service price by id
         * @return mixed
         * --------------
         */
        
        public function get_service_price_by_id ( $service_id ) {
            $service = $this -> db -> get_where ( 'opd_services', array ( 'id' => $service_id ) );
            return $service -> row () -> price;
        }
        
        /**
         * --------------
         * @param $service_id
         * get sub services by id
         * @return mixed
         * --------------
         */
        
        public function get_services_by_parent_id ( $service_id ) {
            $services = $this -> db -> get_where ( 'opd_services', array ( 'parent_id' => $service_id ) );
            return $services -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * get sale by id
         * @return mixed
         * --------------
         */
        
        public function get_opd_sale ( $sale_id ) {
            $sale = $this -> db -> get_where ( 'opd_sales', array ( 'id' => $sale_id ) );
            return $sale -> row ();
        }
        
        /**
         * --------------
         * @param $service_id
         * @param $info
         * edit services
         * @return mixed
         * --------------
         */
        
        public function edit ( $info, $service_id ) {
            $this -> db -> update ( 'opd_services', $info, array ( 'id' => $service_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $service_id
         * @param $info
         * edit services
         * @return mixed
         * --------------
         */
        
        public function update_opd_sales ( $info, $service_id ) {
            $this -> db -> update ( 'opd_sales', $info, array ( 'id' => $service_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * --------------
         * @param $info
         * add sale total
         * @return mixed
         * --------------
         */
        
        public function add_opd_sale ( $info ) {
            $this -> db -> insert ( 'opd_sales', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * --------------
         * @param $info
         * add sale total
         * @return mixed
         * --------------
         */
        
        public function add_opd_sale_service ( $info ) {
            $this -> db -> insert ( 'opd_services_sales', $info );
            return $this -> db -> insert_id ();
        }
        
        public function update_opd_sale_service ( $info, $where ) {
            $this -> db -> update ( 'opd_services_sales', $info, $where );
        }
        
        /**
         * --------------
         * @param $sale_id
         * get sale services by id
         * @return mixed
         * --------------
         */
        
        public function get_sales ( $sale_id ) {
            $sales = $this -> db -> get_where ( 'opd_services_sales', array ( 'sale_id' => $sale_id ) );
            return $sales -> result ();
        }
        
        public function get_sale_by_id ( $id ) {
            $sales = $this -> db -> get_where ( 'opd_sales', array ( 'id' => $id ) );
            return $sales -> row ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * get sale services by id
         * @return mixed
         * --------------
         */
        
        public function get_doc_id_by_sale_id ( $sale_id ) {
            $sales = $this -> db -> query ( "Select doctor_id from hmis_opd_services_sales where sale_id=$sale_id" );
            return $sales -> row () -> doctor_id;
        }
        
        /**
         * --------------
         * @param $sale_id
         * get sale services by id
         * @return mixed
         * --------------
         */
        
        public function get_sold_services ( $sale_id ) {
            $sales = $this -> db -> get_where ( 'opd_services_sales', array ( 'sale_id' => $sale_id ) );
            return $sales -> result_array ();
        }
        
        /**
         * --------------
         * count sales grouped by Invoice ID
         * @return mixed
         * --------------
         */
        
        public function count_sales_by_sale_grouped () {
            $sql = "Select id from hmis_opd_services_sales where patient_id IN (Select id from hmis_patients where type='cash')";
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
                $sql        .= " and service_id=$service_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'patient_name' ] ) and !empty( trim ( $_REQUEST[ 'patient_name' ] ) ) ) {
                $patient_name = $_REQUEST[ 'patient_name' ];
                $sql          .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$patient_name%')";
            }
            $sql   .= " GROUP BY sale_id";
            $sales = $this -> db -> query ( $sql );
            return $sales -> num_rows ();
        }
        
        /**
         * --------------
         * get sales grouped by Invoice ID
         * @param $limit
         * @param $offset
         * @return mixed
         * --------------
         */
        
        public function get_sales_by_sale_grouped ( $limit, $offset ) {
            $sql = "Select GROUP_CONCAT(doctor_id) as doctors, patient_id, sale_id, GROUP_CONCAT(service_id) as services, GROUP_CONCAT(price) as prices, GROUP_CONCAT(discount) as discounts, GROUP_CONCAT(doctor_share) as doctor_share, SUM(net_price) as net_price, date_added from hmis_opd_services_sales where patient_id IN (Select id from hmis_patients where type='cash') and sale_id IN (Select id FROM hmis_opd_sales)";
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
                $sql        .= " and service_id=$service_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'patient_name' ] ) and !empty( trim ( $_REQUEST[ 'patient_name' ] ) ) ) {
                $patient_name = $_REQUEST[ 'patient_name' ];
                $sql          .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$patient_name%')";
            }
            $sql   .= " GROUP BY sale_id order by id DESC limit $limit offset $offset";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * --------------
         * count sales grouped by Invoice ID
         * @return mixed
         * --------------
         */
        
        public function count_panel_sales_by_sale_grouped () {
            $sql = "Select id from hmis_opd_services_sales where patient_id IN (Select id from hmis_patients where type='panel')";
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
                $sql        .= " and service_id=$service_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'patient_name' ] ) and !empty( trim ( $_REQUEST[ 'patient_name' ] ) ) ) {
                $patient_name = $_REQUEST[ 'patient_name' ];
                $sql          .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$patient_name%')";
            }
            $sql   .= " GROUP BY sale_id";
            $sales = $this -> db -> query ( $sql );
            return $sales -> num_rows ();
        }
        
        /**
         * --------------
         * get sales grouped by Invoice ID
         * @return mixed
         * --------------
         */
        
        public function get_panel_sales_by_sale_grouped ( $limit, $offset ) {
            $sql = "Select GROUP_CONCAT(doctor_id) as doctors, patient_id, sale_id, GROUP_CONCAT(service_id) as services, GROUP_CONCAT(price) as prices, GROUP_CONCAT(discount) as discounts, GROUP_CONCAT(doctor_share) as doctor_share, SUM(net_price) as net_price, date_added from hmis_opd_services_sales where patient_id IN (Select id from hmis_patients where type='panel')";
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
                $sql        .= " and service_id=$service_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'patient_name' ] ) and !empty( trim ( $_REQUEST[ 'patient_name' ] ) ) ) {
                $patient_name = $_REQUEST[ 'patient_name' ];
                $sql          .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$patient_name%')";
            }
            $sql   .= " GROUP BY sale_id order by id DESC limit $limit offset $offset";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * --------------
         * @param $sale_id
         * get sale
         * @return mixed
         * --------------
         */
        
        public function delete_sale ( $sale_id ) {
            $this -> db -> delete ( 'opd_sales', array ( 'id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get opd total sale
         * by date range
         * -------------------------
         */
        
        public function get_total_sale_by_date_range () {
            $sql = "Select SUM(net_price) as net from hmis_opd_services_sales where sale_id IN (Select id from hmis_opd_sales where refund='0')";
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
        
        public function get_opd_total_sale_value ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(price) as price from hmis_opd_services_sales where sale_id=$sale_id" );
            return $query -> row () -> price;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get opd total sale
         * by date range
         * -------------------------
         */

//        public function get_opd_sales_daily_closing_report () {
//            $search = false;
//            $sql    = "Select user_id, GROUP_CONCAT(net_price) as totalCharges, GROUP_CONCAT(doctor_id) as doctors, GROUP_CONCAT(doctor_share) as docCharges from hmis_opd_services_sales where sale_id IN (Select id from hmis_opd_sales where refund='0')";
//
//            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
//                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
//                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
//                $sql        .= " and DATE(date_added) Between '$start_date' and '$end_date'";
//                $search     = true;
//            }
//
//            if ( isset( $_REQUEST[ 'user_id' ] ) and $_REQUEST[ 'user_id' ] > 0 ) {
//                $user_id = $_REQUEST[ 'user_id' ];
//                $sql     .= " and user_id=$user_id";
//                $search  = true;
//            }
//
//            $sql   .= " group by user_id";
//            $query = $this -> db -> query ( $sql );
//            if ( $search )
//                return $query -> result ();
//            else
//                return array ();
//        }
        
        /**
         * --------------
         * @param $panel_id
         * @return mixed
         * get all services
         * --------------
         */
        
        public function get_all_services_array ( $panel_id = 0 ) {
            $sql = "Select * from hmis_opd_services where 1";
            if ( $panel_id > 0 ) {
                $sql .= " and id IN (Select service_id from hmis_panel_opd_services where panel_id=$panel_id)";
            }
            $sql      .= " order by title ASC";
            $services = $this -> db -> query ( $sql );
            return $services -> result_array ();
        }
        
        function servicesToTree ( $services, $parentID = 0, $panel_id = 0 ) {
            $tree = array ();
            
            foreach ( $services as $service ) {
                if ( $panel_id > 0 ) {
                    $child  = array (
                        'id'       => $service[ 'id' ],
                        'code'     => $service[ 'code' ],
                        'title'    => $service[ 'title' ],
                        'children' => array ()
                    );
                    $tree[] = $child;
                }
                else {
                    if ( $service[ 'parent_id' ] == $parentID ) {
                        $child  = array (
                            'id'       => $service[ 'id' ],
                            'code'     => $service[ 'code' ],
                            'title'    => $service[ 'title' ],
                            'children' => $this -> servicesToTree ( $services, $service[ 'id' ] )
                        );
                        $tree[] = $child;
                    }
                }
            }
            
            return $tree;
        }
        
        function services_to_options ( $services, $recursive = false ) {
            $html = '';
            
            if ( !$recursive )
                $html .= '<option></option>';
            
            foreach ( $services as $service ) {
                if ( count ( $service[ 'children' ] ) > 0 ) {
                    $html .= '<optgroup label="' . $service[ 'title' ] . '">';
                    $html .= $this -> services_to_options ( $service[ 'children' ], true );
                    $html .= '</optgroup>';
                }
                else {
                    $html .= '<option value="' . $service[ 'id' ] . '" class="option-' . $service[ 'id' ] . '">' . $service[ 'title' ] . '</option>';
                }
            }
            return $html;
        }
        
        function services_to_list ( $services, $recursive = false ) {
            
            $class = '';
            if ( !$recursive )
                $class = 'class="select2-ul"';
            
            $html = '<ul ' . $class . '>';
            
            foreach ( $services as $service ) {
                if ( count ( $service[ 'children' ] ) > 0 ) {
                    $html .= '<li>';
                    $html .= $service[ 'title' ];
                    $html .= $this -> services_to_options ( $service[ 'children' ], true );
                    $html .= '</li>';
                }
                else {
                    $html .= '<option value="' . $service[ 'id' ] . '" class="option-' . $service[ 'id' ] . '">' . $service[ 'title' ] . '</option>';
                }
            }
            $html .= '</ul>';
            return $html;
        }
        
        public function get_opd_total ( $refunded = false ) {
            
            $start_date = $this -> input -> get ( 'start_date' );
            $end_date   = $this -> input -> get ( 'end_date' );
            $start_time = $this -> input -> get ( 'start_time' );
            $end_time   = $this -> input -> get ( 'end_time' );
            $user_id    = $this -> input -> get ( 'user_id' );
            
            $this
                -> db
                -> select ( 'SUM(net) as net' )
                -> from ( 'opd_sales' )
                -> where ( "id IN (Select sale_id FROM hmis_opd_services_sales WHERE patient_id IN (Select id FROM hmis_patients WHERE (panel_id='0' OR panel_id='' OR panel_id < 1 OR panel_id IS NULL)))" );
            
            
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
            
            if ( $refunded ) {
                $this -> db -> where ( 'refund', '1' );
            }
            
            $query = $this -> db -> get ();
            return $query -> row () -> net;
        }
        
        public function opd_service_status ( $id ) {
            $service = $this -> get_service_by_id ( $id );
            if ( !empty( $service ) ) {
                $status = !$service -> active;
                $this -> db -> update ( 'opd_services', [ 'active' => $status ], [ 'id' => $id ] );
                $this -> db -> update ( 'opd_services', [ 'active' => $status ], [ 'parent_id' => $id ] );
            }
        }
        
        public function get_active_services ( $panel_id = 0, $array = false ) {
            $sql = "Select * from hmis_opd_services where active='1'";
            if ( $panel_id > 0 ) {
                $sql .= " and id IN (Select service_id from hmis_panel_opd_services where panel_id=$panel_id)";
            }
            $sql      .= " order by title ASC";
            $services = $this -> db -> query ( $sql );
            return $array ? $services -> result_array () : $services -> result ();
        }
        
        public function get_opd_sales_daily_closing_report () {
            $search = false;
            $this
                -> db
                -> select ( 'user_id, SUM(net) as net, SUM((net * (doctor_share/100))) as doctor_share' )
                -> from ( 'opd_sales' )
                -> where ( 'refund', '0' );
            
            if ( $this -> input -> get ( 'start_date' ) and $this -> input -> get ( 'end_date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $this -> input -> get ( 'start_date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $this -> input -> get ( 'end_date' ) ) );
                $this -> db -> where ( "DATE(date_added) Between '$start_date' and '$end_date'" );
                $search = true;
            }
            
            if ( $this -> input -> get ( 'user_id' ) > 0 ) {
                $user_id = $this -> input -> get ( 'user_id' );
                $this -> db -> where ( "user_id=$user_id" );
                $search = true;
            }
            
            $this -> db -> group_by ( 'user_id' );
            $sales = $this -> db -> get ();
            return $search ? $sales -> result () : array ();
        }
        
        public function get_services_not_in_panel ( $panel_id ) {
            $this
                -> db
                -> select ( '*' )
                -> from ( 'opd_services' )
                -> where ( "id NOT IN (Select service_id From hmis_panel_opd_services WHERE panel_id=$panel_id)" );
            $services = $this -> db -> get ();
            return $services -> result ();
        }
        
        public function get_opd_total_by_payment_method ( $method = 'cash' ) {
            
            $start_date = $this -> input -> get ( 'start_date' );
            $end_date   = $this -> input -> get ( 'end_date' );
            $user_id    = $this -> input -> get ( 'user_id' );
            
            $this
                -> db
                -> select ( 'SUM(ABS(net)) as net' )
                -> from ( 'opd_sales' )
                -> where ( "id IN (Select sale_id FROM hmis_opd_services_sales WHERE patient_id IN (Select id FROM hmis_patients WHERE (panel_id < 1 OR panel_id IS NULL OR panel_id='')))" );
            
            if ( isset( $start_date ) and !empty( trim ( $start_date ) ) and isset( $end_date ) and !empty( trim ( $end_date ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                $this -> db -> where ( "DATE(date_added) Between '$start_date' and '$end_date'" );
            }
            
            if ( isset( $user_id ) and $user_id > 0 ) {
                $this -> db -> where ( 'user_id', $user_id );
            }
            
            $this -> db -> where ( 'payment_method', $method );
            $query = $this -> db -> get ();
            return $query -> row () -> net;
        }
        
        public function get_opd_refunded_total () {
            
            $start_date = $this -> input -> get ( 'start_date' );
            $end_date   = $this -> input -> get ( 'end_date' );
            $user_id    = $this -> input -> get ( 'user_id' );
            
            $this
                -> db
                -> select ( 'SUM(ABS(net)) as net' )
                -> from ( 'opd_sales' )
                -> where ( "id IN (Select sale_id FROM hmis_opd_services_sales WHERE patient_id IN (Select id FROM hmis_patients WHERE (panel_id < 1 OR panel_id IS NULL OR panel_id='')))" );
            
            if ( isset( $start_date ) and !empty( trim ( $start_date ) ) and isset( $end_date ) and !empty( trim ( $end_date ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                $this -> db -> where ( "DATE(date_added) Between '$start_date' and '$end_date'" );
            }
            
            if ( isset( $user_id ) and $user_id > 0 ) {
                $this -> db -> where ( 'user_id', $user_id );
            }
            
            $this -> db -> where ( 'refund', '1' );
            $query = $this -> db -> get ();
            return $query -> row () -> net;
        }
        
        public function get_doctor_daily_payable ( $doctor_id ) {
            
            $start_date = date ( 'Y-m-d' );
            $end_date   = date ( 'Y-m-d' );
            $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
            $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
            $sales      = array ();
            
            $this
                -> db
                -> select ( 'id, doctor_id, total, doctor_share' )
                -> from ( 'opd_sales' )
                -> where ( array ( 'doctor_id' => $doctor_id ) )
                -> where ( "DATE(date_added) Between '$start_date' and '$end_date'" )
                -> where ( 'refund', '0' );
            
            $query  = $this -> db -> get ();
            $shares = $query -> result ();
            
            $netShare = 0;
            if ( count ( $shares ) > 0 ) {
                foreach ( $shares as $share ) {
                    $netShare += ( ( $share -> total * $share -> doctor_share ) / 100 );
                    $sales[]  = $share -> id;
                }
            }
            return array (
                'net'   => $netShare,
                'sales' => $sales
            );
        }
    }
