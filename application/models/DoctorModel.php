<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class DoctorModel extends CI_Model {
        
        /**
         * -------------------------
         * DoctorModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save doctors into database
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'doctors', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save doctors services into database
         * -------------------------
         */
        
        public function add_doctor_services ( $data ) {
            $this -> db -> insert ( 'doctor_services', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save specializations into database
         * -------------------------
         */
        
        public function add_specialization ( $data ) {
            $this -> db -> insert ( 'specializations', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all specializations
         * -------------------------
         */
        
        public function get_specializations () {
            $specializations = $this -> db -> get ( 'specializations' );
            return $specializations -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all doctors
         * -------------------------
         */
        
        public function get_doctors () {
            $doctors = $this -> db -> get_where ( 'doctors', array ( 'active' => '1' ) );
            return $doctors -> result ();
        }
        
        public function get_doctors_not_in_ipd_sale ( $sale_id ) {
            $this
                -> db
                -> select ( '*' )
                -> from ( 'doctors' )
                -> where ( "active='1' AND anesthesiologist='0' AND id NOT IN (SELECT doctor_id FROM hmis_ipd_patient_consultants WHERE sale_id='$sale_id')" );
            $doctors = $this -> db -> get ();
            return $doctors -> result ();
        }
        
        public function get_all_doctors () {
            $specialization_id = $this -> input -> get ( 'specialization-id' );
            
            if ( $specialization_id > 0 )
                $this -> db -> where ( array ( 'specialization_id' => $specialization_id ) );
            $doctors = $this -> db -> get ( 'doctors' );
            return $doctors -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get anesthesiologists
         * -------------------------
         */
        
        public function get_anesthesiologists () {
            $doctors = $this -> db -> get_where ( 'doctors', array ( 'anesthesiologist' => '1' ) );
            return $doctors -> result ();
        }
        
        public function get_anesthesiologists_not_in_ipd_sale ( $sale_id ) {
            $this
                -> db
                -> select ( '*' )
                -> from ( 'doctors' )
                -> where ( "anesthesiologist='1' AND id NOT IN (SELECT doctor_id FROM hmis_ipd_patient_anesthesia_charges WHERE sale_id='$sale_id')" );
            $doctors = $this -> db -> get ();
            return $doctors -> result ();
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * get doctor by id
         * -------------------------
         * @return mixed
         */
        
        public function get_doctor_id ( $doctor_id ) {
            $doctor = $this -> db -> get_where ( 'doctors', array ( 'id' => $doctor_id ) );
            return $doctor -> row ();
        }
        
        /**
         * -------------------------
         * @param $specialization_id
         * @return mixed
         * delete specializations
         * -------------------------
         */
        
        public function delete_specialization ( $specialization_id ) {
            $this -> db -> delete ( 'specializations', array ( 'id' => $specialization_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $specialization_id
         * get specialization by id
         * -------------------------
         * @return mixed
         */
        
        public function get_specialization_by_id ( $specialization_id ) {
            $specialization = $this -> db -> get_where ( 'specializations', array ( 'id' => $specialization_id ) );
            return $specialization -> row ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $specialization_id
         * @return mixed
         * update specialization
         * -------------------------
         */
        
        public function edit_specialization ( $info, $specialization_id ) {
            $this -> db -> update ( 'specializations', $info, array ( 'id' => $specialization_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $doctor_id
         * @return mixed
         * update doctor
         * -------------------------
         */
        
        public function edit ( $info, $doctor_id ) {
            $this -> db -> update ( 'doctors', $info, array ( 'id' => $doctor_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * @return mixed
         * delete doctor
         * -------------------------
         */
        
        public function delete ( $doctor_id ) {
            $this -> db -> delete ( 'doctors', array ( 'id' => $doctor_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $specialization_id
         * @param $panel_id
         * @return mixed
         * get doctors by specialization id
         * -------------------------
         */
        
        public function get_doctors_by_specializations ( $specialization_id, $panel_id = 0 ) {
            $sql = "Select * from hmis_doctors where specialization_id=$specialization_id and active='1'";
            if ( $panel_id > 0 ) {
                $sql .= " and id IN (Select doctor_id from hmis_panel_doctors where panel_id=$panel_id)";
            }
            $doctors = $this -> db -> query ( $sql );
            return $doctors -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * do_add_follow_up into database
         * -------------------------
         */
        
        public function do_add_follow_up ( $data ) {
            $this -> db -> insert ( 'follow_ups', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $follow_up
         * @return mixed
         * delete_follow_up
         * -------------------------
         */
        
        public function delete_follow_up ( $follow_up ) {
            $this -> db -> delete ( 'follow_ups', array ( 'id' => $follow_up ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get_follow_up
         * -------------------------
         */
        
        public function get_follow_up () {
            $doctors = $this -> db -> get ( 'follow_ups' );
            return $doctors -> result ();
        }
        
        /**
         * -------------------------
         * @param $follow_up_id
         * @return mixed
         * get get_follow_up_by_id
         * -------------------------
         */
        
        public function get_follow_up_by_id ( $follow_up_id ) {
            $doctors = $this -> db -> get_where ( 'follow_ups', array ( 'id' => $follow_up_id ) );
            return $doctors -> row ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $follow_up_id
         * @return mixed
         * update do_edit_follow_up_id
         * -------------------------
         */
        
        public function do_edit_follow_up_id ( $info, $follow_up_id ) {
            $this -> db -> update ( 'follow_ups', $info, array ( 'id' => $follow_up_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * @return mixed
         * get doctor services
         * -------------------------
         */
        
        public function get_doctor_services ( $doctor_id ) {
            $services = $this -> db -> get_where ( 'doctor_services', array ( 'doctor_id' => $doctor_id ) );
            return $services -> result ();
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * @return mixed
         * delete doctor services
         * -------------------------
         */
        
        public function delete_doctor_services ( $doctor_id ) {
            $this -> db -> delete ( 'doctor_services', array ( 'doctor_id' => $doctor_id ) );
        }
        
        /**
         * -------------------------
         * @param $service_id
         * @param $doctor_id
         * @return int
         * get doctor percentage value
         * -------------------------
         */
        
        public function get_doctor_percentage_value_by_service_id ( $service_id, $doctor_id ) {
            $percentage = $this -> db -> get_where ( 'doctor_services', array (
                'service_id' => $service_id,
                'doctor_id'  => $doctor_id
            ) );
            if ( $percentage -> num_rows () > 0 )
                return $percentage -> row ();
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get doctors by filter
         * -------------------------
         */
        
        public function get_doctors_by_filter () {
            $search = false;
            $sql    = "Select * from hmis_doctors where 1";
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and !empty( trim ( $_REQUEST[ 'doctor_id' ] ) ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and id=$doctor_id";
                $search    = true;
            }
            $query = $this -> db -> query ( $sql );
            if ( $search )
                return $query -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * @param $panel_id
         * @return mixed
         * get doctor panel
         * -------------------------
         */
        
        public function get_doctor_panel ( $doctor_id, $panel_id ) {
            $panel = $this -> db -> get_where ( 'panel_doctors', array (
                'doctor_id' => $doctor_id,
                'panel_id'  => $panel_id
            ) );
            return $panel -> row ();
        }
        
        public function get_doctors_consultancy_summary_report () {
            
            $start_date = $this -> input -> get ( 'start_date' );
            $end_date   = $this -> input -> get ( 'end_date' );
            $panel_id   = $this -> input -> get ( 'panel-id' );
            $search     = false;
            
            $sql = "Select * from hmis_doctors  where id IN (Select doctor_id from hmis_consultancies)";
            
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and !empty( trim ( $_REQUEST[ 'doctor_id' ] ) ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and id=$doctor_id";
                $search    = true;
            }
            
            if ( isset( $start_date ) and !empty( trim ( $end_date ) ) and isset ( $end_date ) and !empty( trim ( $end_date ) ) ) {
                $search = true;
            }
            
            if ( isset( $panel_id ) and !empty( trim ( $panel_id ) ) and $panel_id > 0 ) {
                $sql    .= " and id IN (Select doctor_id from hmis_consultancies WHERE patient_id IN (Select id from hmis_patients where panel_id=$panel_id))";
                $search = true;
            }
            
            if ( isset( $panel_id ) and !empty( trim ( $panel_id ) ) and $panel_id === 'cash' ) {
                $sql    .= " and id IN (Select doctor_id from hmis_consultancies WHERE patient_id IN (Select id from hmis_patients where panel_id IS NULL OR panel_id=''))";
                $search = true;
            }
            
            $query = $this -> db -> query ( $sql );
            
            return $search ? $query -> result () : array ();
        }
        
        public function get_consultancy_doctors () {
            $doctors = $this -> db -> query ( 'Select * from hmis_doctors where id IN (Select doctor_id from hmis_consultancies)' );
            return $doctors -> result ();
        }
        
        public function get_doctor_specializations () {
            $specialization_id = $this -> input -> get ( 'specialization-id' );
            if ( $specialization_id > 0 )
                $this -> db -> where ( "id IN (Select specialization_id FROM hmis_doctors WHERE specialization_id=$specialization_id)" );
            
            $doctors = $this
                -> db
                -> from ( 'specializations' )
                -> where ( "id IN (Select specialization_id FROM hmis_doctors)" )
                -> get ();
            return $doctors -> result ();
        }
        
        public function get_doctor_by_specialization ( $specialization_id ) {
            $doctors = $this
                -> db
                -> get_where ( 'doctors', array ( 'specialization_id' => $specialization_id, 'active' => '1' ) );
            return $doctors -> result ();
        }
        
        public function get_specializations_by_panel ( $panel_id ) {
            $doctors = $this
                -> db
                -> select ( '*' )
                -> from ( 'hmis_specializations' )
                -> where ( "id IN (Select specialization_id FROM hmis_doctors WHERE id IN (Select doctor_id FROM hmis_panel_doctors WHERE panel_id='$panel_id'))" )
                -> get ();
            return $doctors -> result ();
        }
        
        public function status ( $doctor_id ) {
            $sql    = $this -> db -> get_where ( 'doctors', array ( 'id' => $doctor_id ) );
            $doctor = $sql -> row ();
            
            if ( !empty( $doctor ) ) {
                $active = !$doctor -> active;
                $this -> db -> update ( 'doctors', array ( 'active' => $active ), array ( 'id' => $doctor_id ) );
            }
        }
        
        public function get_doctors_not_in_panel ( $panel_id ) {
            $this
                -> db
                -> select ( '*' )
                -> from ( 'doctors' )
                -> where ( "id NOT IN (Select doctor_id From hmis_panel_doctors WHERE panel_id=$panel_id)" );
            $services = $this -> db -> get ();
            return $services -> result ();
        }
        
    }
