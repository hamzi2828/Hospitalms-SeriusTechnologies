<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class BirthCertificates extends CI_Controller {
        
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
            $this -> load -> model ( 'BirthCertificateModel' );
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
         * Birth certificates main page
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - Birth Certificates';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'certificates' ] = $this -> BirthCertificateModel -> get_certificates ();
            $this -> load -> view ( '/birth-certificates/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Birth certificates add main page
         * -------------------------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'add_birth_certificate' )
                $this -> do_add_birth_certificate ();
            
            $title = site_name . ' - Add Birth certificate';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $this -> load -> view ( '/birth-certificates/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add new certificates
         * -------------------------
         */
        
        public function do_add_birth_certificate () {
            $this -> form_validation -> set_rules ( 'patient_id', 'EMR', 'required|trim|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'name', 'baby name', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'gender', 'gender', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'father-name', 'father name', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'father-cnic', 'father cnic', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'father-phone', 'father phone', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'mother-name', 'mother name', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'mother-cnic', 'mother cnic', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'address', 'address', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'birth-date', 'date of birth', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'birth-time', 'time of birth', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'doctor_id', 'consultant', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'weight', 'weight', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'disability', 'disability', 'xss_clean' );
            
            if ( $this -> form_validation -> run () != false ) {
                $patient_id   = $this -> input -> post ( 'patient_id', true );
                $name         = $this -> input -> post ( 'name', true );
                $gender       = $this -> input -> post ( 'gender', true );
                $father_name  = $this -> input -> post ( 'father-name', true );
                $father_cnic  = $this -> input -> post ( 'father-cnic', true );
                $father_phone = $this -> input -> post ( 'father-phone', true );
                $mother_name  = $this -> input -> post ( 'mother-name', true );
                $mother_cnic  = $this -> input -> post ( 'mother-cnic', true );
                $address      = $this -> input -> post ( 'address', true );
                $birth_date   = $this -> input -> post ( 'birth-date', true );
                $birth_time   = $this -> input -> post ( 'birth-time', true );
                $weight       = $this -> input -> post ( 'weight', true );
                $doctor_id    = $this -> input -> post ( 'doctor_id', true );
                $disability   = $this -> input -> post ( 'disability', true );
                
                $info = array (
                    'user_id'       => get_logged_in_user_id (),
                    'patient_id'    => $patient_id,
                    'doctor_id'     => $doctor_id,
                    'name'          => $name,
                    'gender'        => $gender,
                    'father_name'   => $father_name,
                    'father_cnic'   => $father_cnic,
                    'father_mobile' => $father_phone,
                    'mother_name'   => $mother_name,
                    'mother_cnic'   => $mother_cnic,
                    'address'       => $address,
                    'birth_date'    => date ( 'Y-m-d', strtotime ( $birth_date ) ),
                    'birth_time'    => date ( 'H:i:s', strtotime ( $birth_time ) ),
                    'weight'        => $weight,
                    'disability'    => $disability,
                );
                
                $certificate_id = $this -> BirthCertificateModel -> add ( $info );
                if ( $certificate_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Birth certificate added.' );
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
            if ( empty( trim ( $id ) ) or !is_numeric ( decode ( $id ) ) or decode ( $id ) < 1 )
                return redirect ( base_url ( '/birth-certificates/index' ) );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'edit_birth_certificate' )
                $this -> do_edit_birth_certificate ();
            
            $title = site_name . ' - Edit Birth Crtificate';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'certificate' ] = $this -> BirthCertificateModel -> get_certificate_by_id ( decode ( $id ) );
            $data[ 'doctors' ]     = $this -> DoctorModel -> get_doctors ();
            $this -> load -> view ( '/birth-certificates/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * update certificate info
         * -------------------------
         */
        
        public function do_edit_birth_certificate () {
            $this -> form_validation -> set_rules ( 'certificate-id', 'certificate id', 'required|trim|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'name', 'baby name', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'gender', 'gender', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'father-name', 'father name', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'father-cnic', 'father cnic', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'father-phone', 'father phone', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'mother-name', 'mother name', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'mother-cnic', 'mother cnic', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'address', 'address', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'birth-date', 'date of birth', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'birth-time', 'time of birth', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'doctor_id', 'consultant', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'weight', 'weight', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'disability', 'disability', 'xss_clean' );
            
            if ( $this -> form_validation -> run () != false ) {
                $certificate_id = $this -> input -> post ( 'certificate-id', true );
                $patient_id     = $this -> input -> post ( 'patient_id', true );
                $name           = $this -> input -> post ( 'name', true );
                $gender         = $this -> input -> post ( 'gender', true );
                $father_name    = $this -> input -> post ( 'father-name', true );
                $father_cnic    = $this -> input -> post ( 'father-cnic', true );
                $father_phone   = $this -> input -> post ( 'father-phone', true );
                $mother_name    = $this -> input -> post ( 'mother-name', true );
                $mother_cnic    = $this -> input -> post ( 'mother-cnic', true );
                $address        = $this -> input -> post ( 'address', true );
                $birth_date     = $this -> input -> post ( 'birth-date', true );
                $birth_time     = $this -> input -> post ( 'birth-time', true );
                $weight         = $this -> input -> post ( 'weight', true );
                $doctor_id      = $this -> input -> post ( 'doctor_id', true );
                $disability     = $this -> input -> post ( 'disability', true );
                
                $info    = array (
                    'doctor_id'     => $doctor_id,
                    'name'          => $name,
                    'gender'        => $gender,
                    'father_name'   => $father_name,
                    'father_cnic'   => $father_cnic,
                    'father_mobile' => $father_phone,
                    'mother_name'   => $mother_name,
                    'mother_cnic'   => $mother_cnic,
                    'address'       => $address,
                    'birth_date'    => date ( 'Y-m-d', strtotime ( $birth_date ) ),
                    'birth_time'    => date ( 'H:i:s', strtotime ( $birth_time ) ),
                    'weight'        => $weight,
                    'disability'    => $disability,
                );
                $where   = array (
                    'id' => $certificate_id,
                );
                $updated = $this -> BirthCertificateModel -> edit ( $info, $where );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Certificate updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Note! Certificate already updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * delete member type permanently
         * -------------------------
         */
        
        public function delete () {
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !is_numeric ( decode ( $id ) ) or decode ( $id ) < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> BirthCertificateModel -> delete ( decode ( $id ) );
            $this -> session -> set_flashdata ( 'response', 'Success! Certificate deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
    }
