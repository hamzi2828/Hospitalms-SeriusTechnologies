<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class CultureModel extends CI_Model {
        
        /**
         * ----------------
         * CultureModel constructor.
         * ----------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * ----------------
         * @param $info
         * @return mixed
         * save report
         * ----------------
         */
        
        public function add ( $info ) {
            $this -> db -> insert ( 'culture', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------------
         * @param $info
         * @return mixed
         * save antibiotics
         * ----------------
         */
        
        public function add_antibiotic ( $info ) {
            $this -> db -> insert ( 'culture_antibiotics', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get report by id
         * ----------------
         */
        
        public function get_report_by_id ( $report_id ) {
            $report = $this -> db -> get_where ( 'culture', array ( 'id' => $report_id ) );
            return $report -> row ();
        }
        
        /**
         * ----------------
         * @return mixed
         * count reports
         * ----------------
         */
        
        public function count_reports () {
            $sql = "Select COUNT(*) as totalRows from hmis_culture where 1";
            if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
                $id  = $_REQUEST[ 'id' ];
                $sql .= " and id=$id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql  .= " and patient_id IN (select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'report_title' ] ) and !empty( trim ( $_REQUEST[ 'report_title' ] ) ) ) {
                $report_title = $_REQUEST[ 'report_title' ];
                $sql          .= " and report_title='$report_title'";
            }
            $reports = $this -> db -> query ( $sql );
            return $reports -> row () -> totalRows;
        }
        
        /**
         * ----------------
         * @param $offset
         * @param $limit
         * @return mixed
         * get reports
         * ----------------
         */
        
        public function get_reports ( $limit, $offset ) {
            $sql = "Select * from hmis_culture where 1";
            if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
                $id  = $_REQUEST[ 'id' ];
                $sql .= " and id=$id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql  .= " and patient_id IN (select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'report_title' ] ) and !empty( trim ( $_REQUEST[ 'report_title' ] ) ) ) {
                $report_title = $_REQUEST[ 'report_title' ];
                $sql          .= " and report_title='$report_title'";
            }
            $sql     .= " order by id DESC limit $limit offset $offset";
            $reports = $this -> db -> query ( $sql );
            return $reports -> result ();
        }
        
        /**
         * ----------------
         * @return mixed
         * search report
         * ----------------
         */
        
        public function search () {
            $search = false;
            $sql    = "Select * from hmis_culture where 1";
            if ( isset( $_REQUEST[ 'report_id' ] ) and !empty( trim ( $_REQUEST[ 'report_id' ] ) ) ) {
                $report_id = $_REQUEST[ 'report_id' ];
                $sql       .= " and id=$report_id";
                $search    = true;
            }
            if ( isset( $_REQUEST[ 'sale_id' ] ) and !empty( trim ( $_REQUEST[ 'sale_id' ] ) ) ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sql     .= " and sale_id=$sale_id";
                $search  = true;
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and !empty( trim ( $_REQUEST[ 'doctor_id' ] ) ) ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and doctor_id=$doctor_id";
                $search    = true;
            }
            if ( isset( $_REQUEST[ 'order_by' ] ) and !empty( trim ( $_REQUEST[ 'order_by' ] ) ) ) {
                $order_by = $_REQUEST[ 'order_by' ];
                $sql      .= " and order_by=$order_by";
                $search   = true;
            }
            if ( isset( $_REQUEST[ 'date' ] ) and !empty( trim ( $_REQUEST[ 'date' ] ) ) ) {
                $date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'date' ] ) );
                $sql    .= " and DATE(date_added)='$date'";
                $search = true;
            }
            $sql    .= " order by id DESC limit 1";
            $report = $this -> db -> query ( $sql );
            if ( $search )
                return $report -> row ();
            else
                return false;
        }
        
        /**
         * ----------------
         * @param $info
         * @param $report_id
         * @return mixed
         * update report
         * ----------------
         */
        
        public function update_report ( $info, $report_id ) {
            $this -> db -> update ( 'culture', $info, array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get reports
         * ----------------
         */
        
        public function delete_report ( $report_id ) {
            $this -> db -> delete ( 'culture', array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $info
         * @return mixed
         * save abdomen ultrasound report of female
         * ----------------
         */
        
        public function add_abdomen_pelvis_female ( $info ) {
            $this -> db -> insert ( 'abdomen_pelvis_female', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------------
         * @param $info
         * @return mixed
         * save abdomen ultrasound report of kidney female
         * ----------------
         */
        
        public function add_abdomen_pelvis_kidney_female ( $info ) {
            $this -> db -> insert ( 'abdomen_pelvis_kidney_female', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get abdomen female report
         * ----------------
         */
        
        public function get_abdomen_female_report ( $report_id ) {
            $query = $this -> db -> get_where ( 'abdomen_pelvis_female', array ( 'id' => $report_id ) );
            return $query -> row ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get abdomen female kidney report
         * ----------------
         */
        
        public function get_abdomen_female_kidney_report ( $report_id ) {
            $query = $this -> db -> get_where ( 'abdomen_pelvis_kidney_female', array ( 'abdomen_pelvis_id' => $report_id ) );
            return $query -> row ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @param $info
         * @return mixed
         * update abdomen female report
         * ----------------
         */
        
        public function update_abdomen_pelvis_female ( $info, $report_id ) {
            $this -> db -> update ( 'abdomen_pelvis_female', $info, array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @param $info
         * @return mixed
         * update abdomen female kidney report
         * ----------------
         */
        
        public function update_abdomen_pelvis_kidney_female ( $info, $report_id ) {
            $this -> db -> update ( 'abdomen_pelvis_kidney_female', $info, array ( 'abdomen_pelvis_id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $culture_id
         * @return mixed
         * get added antibiotics
         * ----------------
         */
        
        public function get_added_antibiotics ( $culture_id = 0 ) {
            if ( $culture_id > 0 ) {
                $data = $this -> db -> query ( "Select * from hmis_culture_antibiotics where culture_id=$culture_id" );
                return $data -> result ();
            }
            return array ();
        }
        
        /**
         * ----------------
         * @param $culture_id
         * @return mixed
         * get not added antibiotics
         * ----------------
         */
        
        public function get_antibiotics_not_added ( $culture_id = 0 ) {
            if ( $culture_id > 0 ) {
                $data = $this -> db -> query ( "Select * from hmis_antibiotics where id NOT IN (Select antibiotic_id from hmis_culture_antibiotics where culture_id=$culture_id)" );
                return $data -> result ();
            }
            return array ();
        }
        
        /**
         * ----------------
         * @param $culture_id
         * @return mixed
         * delete antibiotics
         * ----------------
         */
        
        public function delete_antibiotic ( $culture_id ) {
            $this -> db -> delete ( 'culture_antibiotics', array ( 'culture_id' => $culture_id ) );
            return $this -> db -> affected_rows ();
        }
        
    }