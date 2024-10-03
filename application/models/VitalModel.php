<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class VitalModel extends CI_Model {
        
        /**
         * -------------------------
         * VitalModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add vitals
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'patient_vitals', $data );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * total vitals
         * -------------------------
         */
        
        public function count_vitals () {
            $sql = "Select COUNT(*) as total from hmis_patient_vitals where 1";
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'cnic' ] ) and !empty( trim ( $_REQUEST[ 'cnic' ] ) ) ) {
                $cnic = $_REQUEST[ 'cnic' ];
                $sql .= " and patient_id IN (Select id from hmis_patients where cnic='$cnic')";
            }
            if ( isset( $_REQUEST[ 'phone' ] ) and !empty( trim ( $_REQUEST[ 'phone' ] ) ) ) {
                $phone = $_REQUEST[ 'phone' ];
                $sql .= " and patient_id IN (Select id from hmis_patients where phone='$phone')";
            }
            $vitals = $this -> db -> query ( $sql );
            return $vitals -> row () -> total;
        }
        
        /**
         * -------------------------
         * @return mixed
         * total vitals
         * -------------------------
         */
        
        public function count_vitals_grouped () {
            $sql = "Select COUNT(DISTINCT vital_id) as total from hmis_patient_vitals where 1";
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'cnic' ] ) and !empty( trim ( $_REQUEST[ 'cnic' ] ) ) ) {
                $cnic = $_REQUEST[ 'cnic' ];
                $sql .= " and patient_id IN (Select id from hmis_patients where cnic='$cnic')";
            }
            if ( isset( $_REQUEST[ 'phone' ] ) and !empty( trim ( $_REQUEST[ 'phone' ] ) ) ) {
                $phone = $_REQUEST[ 'phone' ];
                $sql .= " and patient_id IN (Select id from hmis_patients where phone='$phone')";
            }
            $vitals = $this -> db -> query ( $sql );
            return $vitals -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get patients and their vitals
         * -------------------------
         */
        
        public function get_patient_vitals ( $limit, $offset ) {
            $sql = "Select * from hmis_patient_vitals where 1";
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'cnic' ] ) and !empty( trim ( $_REQUEST[ 'cnic' ] ) ) ) {
                $cnic = $_REQUEST[ 'cnic' ];
                $sql .= " and patient_id IN (Select id from hmis_patients where cnic='$cnic')";
            }
            if ( isset( $_REQUEST[ 'phone' ] ) and !empty( trim ( $_REQUEST[ 'phone' ] ) ) ) {
                $phone = $_REQUEST[ 'phone' ];
                $sql .= " and patient_id IN (Select id from hmis_patients where phone='$phone')";
            }
            $sql .= " order by id DESC limit $limit offset $offset";
            $vitals = $this -> db -> query ( $sql );
            return $vitals -> result ();
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get patients and their vitals
         * -------------------------
         */
        
        public function get_patient_vitals_grouped ( $limit, $offset ) {
            $sql = "Select id, user_id, patient_id, vital_id, GROUP_CONCAT(vital_key) as vital_keys, GROUP_CONCAT(vital_value) as vital_values, date_added from hmis_patient_vitals where 1";
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'cnic' ] ) and !empty( trim ( $_REQUEST[ 'cnic' ] ) ) ) {
                $cnic = $_REQUEST[ 'cnic' ];
                $sql .= " and patient_id IN (Select id from hmis_patients where cnic='$cnic')";
            }
            if ( isset( $_REQUEST[ 'phone' ] ) and !empty( trim ( $_REQUEST[ 'phone' ] ) ) ) {
                $phone = $_REQUEST[ 'phone' ];
                $sql .= " and patient_id IN (Select id from hmis_patients where phone='$phone')";
            }
            $sql .= " group by vital_id order by id DESC limit $limit offset $offset";
            $vitals = $this -> db -> query ( $sql );
            return $vitals -> result ();
        }
        
        /**
         * -------------------------
         * @param $vital_id
         * @return mixed
         * delete vitals
         * -------------------------
         */
        
        public function delete ( $vital_id ) {
            $this -> db -> delete ( 'patient_vitals', array ( 'vital_id' => $vital_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $vital_id
         * @return mixed
         * get vitals by vital id
         * -------------------------
         */
        
        public function get_patient_vitals_by_vital_id ( $vital_id ) {
            $vitals = $this -> db -> get_where ( 'patient_vitals', array ( 'vital_id' => $vital_id ) );
            return $vitals -> result ();
        }
        
        /**
         * -------------------------
         * @param $patient_id
         * @param $date
         * @return mixed
         * get vitals
         * -------------------------
         */
        
        public function fetch_vitals ( $patient_id, $date ) {
            $vitals = $this -> db -> get_where ( 'patient_vitals', array ( 'patient_id'       => $patient_id,
                                                                           'DATE(date_added)' => $date
            ) );
            if ( $vitals -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
    }