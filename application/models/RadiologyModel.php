<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class RadiologyModel extends CI_Model {
        
        /**
         * ----------------
         * RadiologyModel constructor.
         * ----------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * ----------------
         * @param $info
         * @return mixed
         * save xray report
         * ----------------
         */
        
        public function add_xray_report ( $info ) {
            $this -> db -> insert ( 'xray', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------------
         * @param $info
         * @return mixed
         * save ultrasound report
         * ----------------
         */
        
        public function add_ultrasound_report ( $info ) {
            $this -> db -> insert ( 'ultrasound', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get xray report by id
         * ----------------
         */
        
        public function get_xray_report_by_id ( $report_id ) {
            $report = $this -> db -> get_where ( 'xray', array ( 'id' => $report_id ) );
            return $report -> row ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get xray report by id
         * ----------------
         */
        
        public function get_ultrasound_report_by_id ( $report_id ) {
            $report = $this -> db -> get_where ( 'ultrasound', array ( 'id' => $report_id ) );
            return $report -> row ();
        }
        
        /**
         * ----------------
         * @return mixed
         * count xray reports
         * ----------------
         */
        
        public function count_xray_reports () {
            $sql = "Select COUNT(*) as totalRows from hmis_xray where 1";
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
         * get xray reports
         * ----------------
         */
        
        public function get_xray_reports ( $limit, $offset ) {
            $sql = "Select * from hmis_xray where 1";
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
         * count ultrasound reports
         * ----------------
         */
        
        public function count_ultrasound_reports () {
            $sql = "Select COUNT(*) as totalRows from hmis_ultrasound where 1";
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
         * @param $limit
         * @param $offset
         * @return mixed
         * get ultrasound reports
         * ----------------
         */
        
        public function get_ultrasound_reports ( $limit, $offset ) {
            $sql = "Select * from hmis_ultrasound where 1";
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
         * @param $report_id
         * @return mixed
         * get xray reports
         * ----------------
         */
        
        public function delete_xray_report ( $report_id ) {
            $this -> db -> delete ( 'xray', array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get ultrasound reports
         * ----------------
         */
        
        public function delete_ultrasound_report ( $report_id ) {
            $this -> db -> delete ( 'ultrasound', array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @return mixed
         * search xray report
         * ----------------
         */
        
        public function search_xray_report () {
            $search = false;
            $sql    = "Select * from hmis_xray where 1";
            if ( isset( $_REQUEST[ 'report_id' ] ) and !empty( trim ( $_REQUEST[ 'report_id' ] ) ) ) {
                $report_id = $_REQUEST[ 'report_id' ];
                $sql       .= " and id=$report_id";
                $search    = true;
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and !empty( trim ( $_REQUEST[ 'patient_id' ] ) ) ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
                $search     = true;
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
            return $search ? $report -> row () : '';
        }
        
        /**
         * ----------------
         * @return mixed
         * search ultrasound report
         * ----------------
         */
        
        public function search_ultrasound_report () {
            $sql = "Select * from hmis_ultrasound where 1";
            if ( isset( $_REQUEST[ 'report_id' ] ) and !empty( trim ( $_REQUEST[ 'report_id' ] ) ) ) {
                $report_id = $_REQUEST[ 'report_id' ];
                $sql       .= " and id=$report_id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and !empty( trim ( $_REQUEST[ 'patient_id' ] ) ) ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and !empty( trim ( $_REQUEST[ 'doctor_id' ] ) ) ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'order_by' ] ) and !empty( trim ( $_REQUEST[ 'order_by' ] ) ) ) {
                $order_by = $_REQUEST[ 'order_by' ];
                $sql      .= " and order_by=$order_by";
            }
            if ( isset( $_REQUEST[ 'date' ] ) and !empty( trim ( $_REQUEST[ 'date' ] ) ) ) {
                $date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'date' ] ) );
                $sql  .= " and DATE(date_added)='$date'";
            }
            $sql    .= " order by id DESC limit 1";
            $report = $this -> db -> query ( $sql );
            return $report -> row ();
        }
        
        /**
         * ----------------
         * @param $info
         * @param $report_id
         * @return mixed
         * update xray report
         * ----------------
         */
        
        public function update_xray_report ( $info, $report_id ) {
            $this -> db -> update ( 'xray', $info, array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $info
         * @param $report_id
         * @return mixed
         * update ultrasound report
         * ----------------
         */
        
        public function update_ultrasound_report ( $info, $report_id ) {
            $this -> db -> update ( 'ultrasound', $info, array ( 'id' => $report_id ) );
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
         * @return mixed
         * count ct scan reports
         * ----------------
         */
        
        public function count_ct_scan_reports () {
            $sql = "Select COUNT(*) as totalRows from hmis_ct_scan where 1";
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
         * get ct scan reports
         * ----------------
         */
        
        public function get_ct_scan_reports ( $limit, $offset ) {
            $sql = "Select * from hmis_ct_scan where 1";
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
         * @param $info
         * @return mixed
         * save ct scan report
         * ----------------
         */
        
        public function add_ct_scan_report ( $info ) {
            $this -> db -> insert ( 'ct_scan', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------------
         * @return mixed
         * search ct scan report
         * ----------------
         */
        
        public function search_ct_scan_report () {
            $search = false;
            $sql    = "Select * from hmis_ct_scan where 1";
            if ( isset( $_REQUEST[ 'report_id' ] ) and !empty( trim ( $_REQUEST[ 'report_id' ] ) ) ) {
                $report_id = $_REQUEST[ 'report_id' ];
                $sql       .= " and id=$report_id";
                $search    = true;
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and !empty( trim ( $_REQUEST[ 'patient_id' ] ) ) ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
                $search     = true;
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
            return $search ? $report -> row () : null;
        }
        
        /**
         * ----------------
         * @param $info
         * @param $report_id
         * @return mixed
         * update ct scan report
         * ----------------
         */
        
        public function update_ct_scan_report ( $info, $report_id ) {
            $this -> db -> update ( 'ct_scan', $info, array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get ct scan reports
         * ----------------
         */
        
        public function delete_ct_scan_report ( $report_id ) {
            $this -> db -> delete ( 'ct_scan', array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get ct scan report by id
         * ----------------
         */
        
        public function get_ct_scan_report_by_id ( $report_id ) {
            $report = $this -> db -> get_where ( 'ct_scan', array ( 'id' => $report_id ) );
            return $report -> row ();
        }
        
        /**
         * ----------------
         * @return mixed
         * count mri reports
         * ----------------
         */
        
        public function count_mri_reports () {
            $sql = "Select COUNT(*) as totalRows from hmis_mri where 1";
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
         * get mri reports
         * ----------------
         */
        
        public function get_mri_reports ( $limit, $offset ) {
            $sql = "Select * from hmis_mri where 1";
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
         * @param $info
         * @return mixed
         * save mri report
         * ----------------
         */
        
        public function add_mri_report ( $info ) {
            $this -> db -> insert ( 'mri', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------------
         * @return mixed
         * search mri report
         * ----------------
         */
        
        public function search_mri_report () {
            $search = false;
            $sql    = "Select * from hmis_mri where 1";
            if ( isset( $_REQUEST[ 'report_id' ] ) and !empty( trim ( $_REQUEST[ 'report_id' ] ) ) ) {
                $report_id = $_REQUEST[ 'report_id' ];
                $sql       .= " and id=$report_id";
                $search    = true;
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and !empty( trim ( $_REQUEST[ 'patient_id' ] ) ) ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
                $search     = true;
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
            return $search ? $report -> row () : null;
        }
        
        /**
         * ----------------
         * @param $info
         * @param $report_id
         * @return mixed
         * update mri report
         * ----------------
         */
        
        public function update_mri_report ( $info, $report_id ) {
            $this -> db -> update ( 'mri', $info, array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get mri reports
         * ----------------
         */
        
        public function delete_mri_report ( $report_id ) {
            $this -> db -> delete ( 'mri', array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get mri report by id
         * ----------------
         */
        
        public function get_mri_report_by_id ( $report_id ) {
            $report = $this -> db -> get_where ( 'mri', array ( 'id' => $report_id ) );
            return $report -> row ();
        }
        
        public function get_report_verify_status ( $report_id, $table ) {
            $this -> db -> order_by ( 'id', 'DESC' );
            $this -> db -> limit ( 1 );
            $status = $this -> db -> get_where ( 'lab_reports_status', array ( 'report_id' => $report_id, '_table' => $table ) );
            return $status -> row ();
        }
        
        public function verify_report ( $report_id, $table ) {
            $this -> db -> insert ( 'lab_reports_status', array ( 'user_id' => get_logged_in_user_id (), 'report_id' => $report_id, '_table' => $table ) );
        }
        
        public function delete_report_verify_status ( $report_id, $table ) {
            $this -> db -> delete ( 'lab_reports_status', array ( 'report_id' => $report_id, '_table' => $table ) );
        }
        
        /**
         * ----------------
         * @param $info
         * @param $report_id
         * @return mixed
         * update echo report
         * ----------------
         */
        
        public function update_echo_report ( $info, $report_id ) {
            $this -> db -> update ( 'echo', $info, array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $info
         * @param $report_id
         * @return mixed
         * update echo report
         * ----------------
         */
        
        public function update_ecg_report ( $info, $report_id ) {
            $this -> db -> update ( 'ecg', $info, array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $info
         * @return mixed
         * save echo report
         * ----------------
         */
        
        public function add_echo_report ( $info ) {
            $this -> db -> insert ( 'echo', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get echo report by id
         * ----------------
         */
        
        public function get_echo_report_by_id ( $report_id ) {
            $report = $this -> db -> get_where ( 'echo', array ( 'id' => $report_id ) );
            return $report -> row ();
        }
        
        /**
         * ----------------
         * @return mixed
         * count echo reports
         * ----------------
         */
        
        public function count_echo_reports () {
            $sql = "Select COUNT(*) as totalRows from hmis_echo where 1";
            if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
                $id = $_REQUEST[ 'id' ];
                $sql .= " and id=$id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql .= " and patient_id IN (select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'report_title' ] ) and !empty( trim ( $_REQUEST[ 'report_title' ] ) ) ) {
                $report_title = $_REQUEST[ 'report_title' ];
                $sql .= " and report_title='$report_title'";
            }
            $reports = $this -> db -> query ( $sql );
            return $reports -> row () -> totalRows;
        }
        
        /**
         * ----------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get echo reports
         * ----------------
         */
        
        public function get_echo_reports ( $limit, $offset ) {
            $sql = "Select * from hmis_echo where 1";
            if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
                $id = $_REQUEST[ 'id' ];
                $sql .= " and id=$id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql .= " and patient_id IN (select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'report_title' ] ) and !empty( trim ( $_REQUEST[ 'report_title' ] ) ) ) {
                $report_title = $_REQUEST[ 'report_title' ];
                $sql .= " and report_title='$report_title'";
            }
            $sql .= " order by id DESC limit $limit offset $offset";
            $reports = $this -> db -> query ( $sql );
            return $reports -> result ();
        }
        
        /**
         * ----------------
         * @return mixed
         * search echo report
         * ----------------
         */
        
        public function search_echo_report () {
            $search = false;
            $sql = "Select * from hmis_echo where 1";
            if ( isset( $_REQUEST[ 'report_id' ] ) and !empty( trim ( $_REQUEST[ 'report_id' ] ) ) ) {
                $report_id = $_REQUEST[ 'report_id' ];
                $sql .= " and id=$report_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and !empty( trim ( $_REQUEST[ 'patient_id' ] ) ) ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql .= " and patient_id=$patient_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and !empty( trim ( $_REQUEST[ 'doctor_id' ] ) ) ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql .= " and doctor_id=$doctor_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'order_by' ] ) and !empty( trim ( $_REQUEST[ 'order_by' ] ) ) ) {
                $order_by = $_REQUEST[ 'order_by' ];
                $sql .= " and order_by=$order_by";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'date' ] ) and !empty( trim ( $_REQUEST[ 'date' ] ) ) ) {
                $date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'date' ] ) );
                $sql .= " and DATE(date_added)='$date'";
                $search = true;
            }
            $sql .= " order by id DESC limit 1";
            $report = $this -> db -> query ( $sql );
            if ( $search )
                return $report -> row ();
            else
                return '';
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * delete echo reports
         * ----------------
         */
        
        public function delete_echo_report ( $report_id ) {
            $this -> db -> delete ( 'echo', array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $info
         * @return mixed
         * save ecg report
         * ----------------
         */
        
        public function add_ecg_report ( $info ) {
            $this -> db -> insert ( 'ecg', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get ecg report by id
         * ----------------
         */
        
        public function get_ecg_report_by_id ( $report_id ) {
            $report = $this -> db -> get_where ( 'ecg', array ( 'id' => $report_id ) );
            return $report -> row ();
        }
        
        /**
         * ----------------
         * @return mixed
         * count ecg reports
         * ----------------
         */
        
        public function count_ecg_reports () {
            $sql = "Select COUNT(*) as totalRows from hmis_ecg where 1";
            if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
                $id = $_REQUEST[ 'id' ];
                $sql .= " and id=$id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql .= " and patient_id IN (select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'report_title' ] ) and !empty( trim ( $_REQUEST[ 'report_title' ] ) ) ) {
                $report_title = $_REQUEST[ 'report_title' ];
                $sql .= " and report_title='$report_title'";
            }
            $reports = $this -> db -> query ( $sql );
            return $reports -> row () -> totalRows;
        }
        
        /**
         * ----------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get ecg reports
         * ----------------
         */
        
        public function get_ecg_reports ( $limit, $offset ) {
            $sql = "Select * from hmis_ecg where 1";
            if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
                $id = $_REQUEST[ 'id' ];
                $sql .= " and id=$id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql .= " and patient_id IN (select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'report_title' ] ) and !empty( trim ( $_REQUEST[ 'report_title' ] ) ) ) {
                $report_title = $_REQUEST[ 'report_title' ];
                $sql .= " and report_title='$report_title'";
            }
            $sql .= " order by id DESC limit $limit offset $offset";
            $reports = $this -> db -> query ( $sql );
            return $reports -> result ();
        }
        
        /**
         * ----------------
         * @return mixed
         * search ecg report
         * ----------------
         */
        
        public function search_ecg_report () {
            $search = false;
            $sql = "Select * from hmis_ecg where 1";
            if ( isset( $_REQUEST[ 'report_id' ] ) and !empty( trim ( $_REQUEST[ 'report_id' ] ) ) ) {
                $report_id = $_REQUEST[ 'report_id' ];
                $sql .= " and id=$report_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and !empty( trim ( $_REQUEST[ 'patient_id' ] ) ) ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql .= " and patient_id=$patient_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and !empty( trim ( $_REQUEST[ 'doctor_id' ] ) ) ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql .= " and doctor_id=$doctor_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'order_by' ] ) and !empty( trim ( $_REQUEST[ 'order_by' ] ) ) ) {
                $order_by = $_REQUEST[ 'order_by' ];
                $sql .= " and order_by=$order_by";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'date' ] ) and !empty( trim ( $_REQUEST[ 'date' ] ) ) ) {
                $date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'date' ] ) );
                $sql .= " and DATE(date_added)='$date'";
                $search = true;
            }
            $sql .= " order by id DESC limit 1";
            $report = $this -> db -> query ( $sql );
            if ( $search )
                return $report -> row ();
            else
                return '';
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * delete ecg reports
         * ----------------
         */
        
        public function delete_ecg_report ( $report_id ) {
            $this -> db -> delete ( 'ecg', array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
    }