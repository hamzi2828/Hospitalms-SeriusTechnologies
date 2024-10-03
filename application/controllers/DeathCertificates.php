<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class DeathCertificates extends CI_Controller {
        
        /**
         * -------------------------
         * Patients constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'DoctorModel' );
            $this -> load -> model ( 'DeathCertificateModel' );
            $this -> load -> model ( 'RoomModel' );
        }
        
        /**
         * -------------------------
         * @param $title
         * header template
         * -------------------------
         */
        
        public function header ( $title ) {
            $data[ 'title' ] = $title;
            $this -> load -> view ( '/includes/admin/header', $data );
        }
        
        /**
         * -------------------------
         * sidebar template
         * -------------------------
         */
        
        public function sidebar () {
            $this -> load -> view ( '/includes/admin/general-sidebar' );
        }
        
        /**
         * -------------------------
         * footer template
         * -------------------------
         */
        
        public function footer () {
            $this -> load -> view ( '/includes/admin/footer' );
        }
        
        /**
         * ---------------------
         * checks if user is logged in
         * ---------------------
         */
        
        public function is_logged_in () {
            if ( empty( $this -> session -> userdata ( 'user_data' ) ) ) {
                return redirect ( base_url () );
            }
        }
        
        /**
         * -------------------------
         * Death Certificates main page
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - Death Certificates';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'certificates' ] = $this -> DeathCertificateModel -> get_certificates ();
            $this -> load -> view ( '/death-certificates/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Death Certificates add main page
         * -------------------------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'add_death_certificate' )
                $this -> add_death_certificate ();
            
            $title = site_name . ' - Add Death Certificate';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'rooms' ]   = $this -> RoomModel -> get_rooms ();
            $this -> load -> view ( '/death-certificates/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add new certificates
         * -------------------------
         */
        
        public function add_death_certificate () {
            $this -> form_validation -> set_rules ( 'patient_id', 'EMR', 'required|trim|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'room-id', 'ward', 'trim|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'death-date', 'date of death', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'death-time', 'time of death', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'doctor-id', 'consultant', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'death-cause', 'cause of death', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'diagnosis', 'diagnosis', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'body-handed-to', 'body handed to', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'relation', 'relation', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'cnic', 'cnic', 'xss_clean' );
            
            if ( $this -> form_validation -> run () ) {
                $patient_id     = $this -> input -> post ( 'patient_id', true );
                $ward           = $this -> input -> post ( 'room-id', true );
                $death_date     = $this -> input -> post ( 'death-date', true );
                $death_time     = $this -> input -> post ( 'death-time', true );
                $doctor_id      = $this -> input -> post ( 'doctor-id', true );
                $death_cause    = $this -> input -> post ( 'death-cause', true );
                $diagnosis      = $this -> input -> post ( 'diagnosis', true );
                $body_handed_to = $this -> input -> post ( 'body-handed-to', true );
                $relation       = $this -> input -> post ( 'relation', true );
                $cnic           = $this -> input -> post ( 'cnic', true );
                
                $info = array (
                    'user_id'        => get_logged_in_user_id (),
                    'patient_id'     => $patient_id,
                    'doctor_id'      => $doctor_id,
                    'death_date'     => date ( 'Y-m-d', strtotime ( $death_date ) ),
                    'death_time'     => date ( 'H:i:s', strtotime ( $death_time ) ),
                    'room_id'        => $ward,
                    'death_cause'    => $death_cause,
                    'diagnosis'      => $diagnosis,
                    'body_handed_to' => $body_handed_to,
                    'relation'       => $relation,
                    'guardian_cnic'  => $cnic,
                );
                
                $certificate_id = $this -> DeathCertificateModel -> add ( $info );
                if ( $certificate_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Death Certificate added.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * certificates edit main page
         * -------------------------
         */
        
        public function edit () {
            
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !is_numeric ( $id ) )
                return redirect ( base_url ( '/death-certificates/index' ) );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'edit_death_certificate' )
                $this -> edit_death_certificate ();
            
            $title = site_name . ' - Edit Death Certificate';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'certificate' ] = $this -> DeathCertificateModel -> get_certificate_by_id ( $id );
            $data[ 'doctors' ]     = $this -> DoctorModel -> get_doctors ();
            $data[ 'patient' ]     = get_patient ( $data[ 'certificate' ] -> patient_id );
            $data[ 'rooms' ]       = $this -> RoomModel -> get_rooms ();
            $this -> load -> view ( '/death-certificates/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * update certificate info
         * -------------------------
         */
        
        public function edit_death_certificate () {
            $this -> form_validation -> set_rules ( 'certificate-id', 'certificate', 'required|trim|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'room-id', 'ward', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'patient_id', 'EMR', 'required|trim|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'death-date', 'date of death', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'death-time', 'time of death', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'doctor-id', 'consultant', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'death-cause', 'cause of death', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'diagnosis', 'diagnosis', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'body-handed-to', 'body handed to', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'relation', 'relation', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'cnic', 'cnic', 'xss_clean' );
            
            if ( $this -> form_validation -> run () ) {
                $certificate_id = $this -> input -> post ( 'certificate-id', true );
                $patient_id     = $this -> input -> post ( 'patient_id', true );
                $death_date     = $this -> input -> post ( 'death-date', true );
                $death_time     = $this -> input -> post ( 'death-time', true );
                $doctor_id      = $this -> input -> post ( 'doctor-id', true );
                $ward           = $this -> input -> post ( 'room-id', true );
                $death_cause    = $this -> input -> post ( 'death-cause', true );
                $diagnosis      = $this -> input -> post ( 'diagnosis', true );
                $body_handed_to = $this -> input -> post ( 'body-handed-to', true );
                $relation       = $this -> input -> post ( 'relation', true );
                $cnic           = $this -> input -> post ( 'cnic', true );
                
                $info = array (
                    'user_id'        => get_logged_in_user_id (),
                    'patient_id'     => $patient_id,
                    'doctor_id'      => $doctor_id,
                    'death_date'     => date ( 'Y-m-d', strtotime ( $death_date ) ),
                    'death_time'     => date ( 'H:i:s', strtotime ( $death_time ) ),
                    'room_id'        => $ward,
                    'death_cause'    => $death_cause,
                    'diagnosis'      => $diagnosis,
                    'body_handed_to' => $body_handed_to,
                    'relation'       => $relation,
                    'guardian_cnic'  => $cnic,
                );
                
                $this -> DeathCertificateModel -> edit ( $info, array ( 'id' => $certificate_id ) );
                $this -> session -> set_flashdata ( 'response', 'Success! Death Certificate added.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete member type permanently
         * -------------------------
         */
        
        public function delete () {
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !is_numeric ( $id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> DeathCertificateModel -> delete ( decode ( $id ) );
            $this -> session -> set_flashdata ( 'response', 'Success! Certificate deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
    }
