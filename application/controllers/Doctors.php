<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Doctors extends CI_Controller {
        
        /**
         * -------------------------
         * Doctors constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'DoctorModel' );
            $this -> load -> model ( 'IPDModel' );
            $this -> load -> model ( 'AccountModel' );
            $this -> load -> model ( 'OnlineReferenceModel' );
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
         * doctors main page
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - Doctors';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ]         = $this -> DoctorModel -> get_all_doctors ();
            $data[ 'specializations' ] = $this -> DoctorModel -> get_specializations ();
            $this -> load -> view ( '/doctors/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * doctors add main page
         * -------------------------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_doctors' )
                $this -> do_add_doctors ( $_POST );
            
            $title = site_name . ' - Add Doctors';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'specializations' ] = $this -> DoctorModel -> get_specializations ();
            $data[ 'services' ]        = $this -> IPDModel -> get_parent_services ();
            $this -> load -> view ( '/doctors/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add more doctor services
         * -------------------------
         */
        
        public function add_more_doctor_services () {
            $data[ 'services' ] = $this -> IPDModel -> get_parent_services ();
            $data[ 'row' ]      = $_POST[ 'row' ];
            $this -> load -> view ( '/doctors/add_more_doctor_services', $data );
        }
        
        /**
         * -------------------------
         * @param $POST
         * add doctors
         * -------------------------
         */
        
        public function do_add_doctors ( $POST ) {
            $data = $POST;
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'phone', 'phone', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'cnic', 'cnic', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'available_from', 'available from', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'available_till', 'available till', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'charges_type', 'charges type', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'hospital_charges', 'hospital charges', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'specialization_id', 'specialization', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'doctor_share', 'doctor share', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'description', 'description', 'xss_clean' );
            
            $anesthesiologist = ( isset( $_POST[ 'anesthesiologist' ] ) and $_POST[ 'anesthesiologist' ] == '1' ) ? '1' : '0';
            if ( $this -> form_validation -> run () == true ) {
                $info      = array (
                    'user_id'           => get_logged_in_user_id (),
                    'specialization_id' => $data[ 'specialization_id' ],
                    'name'              => $data[ 'name' ],
                    'phone'             => $data[ 'phone' ],
                    'cnic'              => $data[ 'cnic' ],
                    'anesthesiologist'  => $anesthesiologist,
                    'available_from'    => date ( "H:i", strtotime ( $data[ 'available_from' ] ) ),
                    'available_till'    => date ( "H:i", strtotime ( $data[ 'available_till' ] ) ),
                    'qualification'     => $data[ 'qualification' ],
                    'charges_type'      => $data[ 'charges_type' ],
                    'hospital_charges'  => $data[ 'hospital_charges' ],
                    'doctor_share'      => $data[ 'doctor_share' ],
                    'description'       => $data[ 'description' ],
                    'stamp'             => $data[ 'stamp' ],
                    'date_added'        => current_date_time (),
                );
                $doctor_id = $this -> DoctorModel -> add ( $info );
                $this -> add_doctor_services ( $doctor_id );
                if ( $doctor_id > 0 ) {
                    $this -> add_doctor_account_head ( $doctor_id );
                    $this -> session -> set_flashdata ( 'response', 'Success! Doctor added.' );
                    return redirect ( base_url ( '/doctors/add' ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( base_url ( '/doctors/add' ) );
                }
            }
        }
        
        public function add_doctor_account_head ( $doctor_id ) {
            $doctor       = $this -> DoctorModel -> get_doctor_id ( $doctor_id );
            $account_head = get_account_head ( CONSULTANCY_SHARES_DOCTOR );
            
            $info = array (
                'title'          => $doctor -> name,
                'parent_id'      => CONSULTANCY_SHARES_DOCTOR,
                'role_id'        => $account_head -> role_id,
                'doctor_id'      => $doctor_id,
                'panel_id'       => 0,
                'contact_person' => $doctor -> name,
                'phone'          => $doctor -> phone,
                'status'         => '1',
                'type'           => 14,
                'deleteable'     => '0',
                'description'    => $doctor -> description,
                'date_added'     => current_date_time (),
            );
            $this -> AccountModel -> insert ( $info );
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * add doctor services
         * -------------------------
         */
        
        public function add_doctor_services ( $doctor_id ) {
            if ( isset( $_POST[ 'service_id' ] ) and count ( $_POST[ 'service_id' ] ) > 0 ) {
                $service_id = $_POST[ 'service_id' ];
                foreach ( $service_id as $key => $service ) {
                    if ( !empty( $service ) and $service > 0 ) {
                        $services = array (
                            'user_id'    => get_logged_in_user_id (),
                            'doctor_id'  => $doctor_id,
                            'service_id' => $service,
                            'charges'    => $_POST[ 'charges' ][ $key ],
                            'date_added' => current_date_time ()
                        );
                        $this -> DoctorModel -> add_doctor_services ( $services );
                    }
                }
            }
        }
        
        /**
         * -------------------------
         * doctors edit main page
         * -------------------------
         */
        
        public function edit () {
            
            $doctor_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $doctor_id ) ) or !is_numeric ( $doctor_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_doctors' )
                $this -> do_edit_doctors ( $_POST );
            
            $title = site_name . ' - Edit Doctor';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'specializations' ] = $this -> DoctorModel -> get_specializations ();
            $data[ 'doctor' ]          = $this -> DoctorModel -> get_doctor_id ( $doctor_id );
            $data[ 'doctor_services' ] = $this -> DoctorModel -> get_doctor_services ( $doctor_id );
            $data[ 'services' ]        = $this -> IPDModel -> get_parent_services ();
            $this -> load -> view ( '/doctors/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * doctors edit main page
         * -------------------------
         */
        
        public function view () {
            
            $doctor_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $doctor_id ) ) or !is_numeric ( $doctor_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $title = site_name . ' - View Doctor';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'specializations' ] = $this -> DoctorModel -> get_specializations ();
            $data[ 'doctor' ]          = $this -> DoctorModel -> get_doctor_id ( $doctor_id );
            $data[ 'doctor_services' ] = $this -> DoctorModel -> get_doctor_services ( $doctor_id );
            $data[ 'services' ]        = $this -> IPDModel -> get_parent_services ();
            $this -> load -> view ( '/doctors/view', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit doctor
         * -------------------------
         */
        
        public function do_edit_doctors ( $POST ) {
            $data = $POST;
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'phone', 'phone', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'cnic', 'cnic', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'charges_type', 'charges type', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'hospital_charges', 'hospital charges', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'specialization_id', 'specialization', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'doctor_share', 'doctor share', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'description', 'description', 'xss_clean' );
            $doctor_id        = $data[ 'doctor_id' ];
            $anesthesiologist = ( isset( $_POST[ 'anesthesiologist' ] ) and $_POST[ 'anesthesiologist' ] == '1' ) ? '1' : '0';
            
            $this -> DoctorModel -> delete_doctor_services ( $doctor_id );
            if ( $this -> form_validation -> run () == true ) {
                $info = array (
                    'specialization_id' => $data[ 'specialization_id' ],
                    'name'              => $data[ 'name' ],
                    'phone'             => $data[ 'phone' ],
                    'cnic'              => $data[ 'cnic' ],
                    'anesthesiologist'  => $anesthesiologist,
                    'qualification'     => $data[ 'qualification' ],
                    'charges_type'      => $data[ 'charges_type' ],
                    'hospital_charges'  => $data[ 'hospital_charges' ],
                    'doctor_share'      => $data[ 'doctor_share' ],
                    'description'       => $data[ 'description' ],
                    'stamp'             => $data[ 'stamp' ],
                );
                
                if ( isset( $data[ 'available_from' ] ) and !empty( trim ( $data[ 'available_from' ] ) ) and isset( $data[ 'available_till' ] ) and !empty( trim ( $data[ 'available_till' ] ) ) ) {
                    $info[ 'available_from' ] = date ( "H:i", strtotime ( $data[ 'available_from' ] ) );
                    $info[ 'available_till' ] = date ( "H:i", strtotime ( $data[ 'available_till' ] ) );
                }
                $this -> DoctorModel -> edit ( $info, $doctor_id );
                $this -> add_doctor_services ( $doctor_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Doctor updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * update status of supplier to inactive
         * records are not being deleted permanently
         * -------------------------
         */
        
        public function delete () {
            $doctor_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $doctor_id ) ) or !is_numeric ( $doctor_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> DoctorModel -> delete ( $doctor_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Doctor deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * specializations main page
         * -------------------------
         */
        
        public function specializations () {
            $title = site_name . ' - Specializations';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'specializations' ] = $this -> DoctorModel -> get_specializations ();
            $this -> load -> view ( '/specialization/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add specialization main page
         * -------------------------
         */
        
        public function add_specialization () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_specialization' )
                $this -> do_add_specialization ( $_POST );
            
            $title = site_name . ' - Add Specialization';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/specialization/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add specialization
         * -------------------------
         */
        
        public function do_add_specialization ( $POST ) {
            $data           = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $specialization = array_filter ( $data[ 'specialization' ] );
            if ( count ( $specialization ) > 0 ) {
                foreach ( $specialization as $special ) {
                    if ( !empty( trim ( $special ) ) ) {
                        $info = array (
                            'user_id'    => get_logged_in_user_id (),
                            'title'      => $special,
                            'date_added' => current_date_time (),
                        );
                        $this -> DoctorModel -> add_specialization ( $info );
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Specializations added.' );
                return redirect ( base_url ( '/specialization/add-specialization' ) );
            }
        }
        
        /**
         * -------------------------
         * delete specialization
         * -------------------------
         */
        
        public function delete_specialization () {
            $specialization_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $specialization_id ) ) or !is_numeric ( $specialization_id ) > 0 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> DoctorModel -> delete_specialization ( $specialization_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Specialization deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * add specialization main page
         * -------------------------
         */
        
        public function edit_specialization () {
            
            $specialization_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $specialization_id ) ) or !is_numeric ( $specialization_id ) > 0 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_specialization' )
                $this -> do_edit_specialization ( $_POST );
            
            $title = site_name . ' - Edit Specialization';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'specialization' ] = $this -> DoctorModel -> get_specialization_by_id ( $specialization_id );
            $this -> load -> view ( '/specialization/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit specialization
         * -------------------------
         */
        
        public function do_edit_specialization ( $POST ) {
            $data              = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $specialization    = $data[ 'specialization' ];
            $specialization_id = $data[ 'specialization_id' ];
            if ( !empty( trim ( $specialization ) ) ) {
                $info = array (
                    'title' => $specialization
                );
                $this -> DoctorModel -> edit_specialization ( $info, $specialization_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Specializations updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * get doctors by specializations
         * convert into json and pass to jquery
         * -------------------------
         */
        
        public function get_doctors_by_specializations () {
            $specialization_id = $this -> input -> post ( 'specialization_id', true );
            $patient_id        = $this -> input -> post ( 'patient_id', true );
            $panel_id          = 0;
            if ( $patient_id > 0 and isset( $patient_id ) ) {
                $patient  = get_patient ( $patient_id );
                $panel_id = $patient -> panel_id;
            }
            if ( !empty( trim ( $specialization_id ) ) and is_numeric ( $specialization_id ) > 0 ) {
                $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors_by_specializations ( $specialization_id, $panel_id );
                $doctors           = $this -> load -> view ( '/consultancy/doctors', $data, true );
                $info              = array (
                    'doctors' => $doctors
                );
                echo json_encode ( $info );
            }
            else {
                echo 'false';
            }
        }
        
        /**
         * -------------------------
         * get doctors by id
         * convert into json and pass to jquery
         * -------------------------
         */
        
        public function get_doctor_info () {
            $doctor_id           = $this -> input -> post ( 'doctor_id', true );
            $patient_id          = $this -> input -> post ( 'patient_id', true );
            $online_reference_id = $this -> input -> post ( 'online_reference_id', true );
            
            if ( !empty( trim ( $doctor_id ) ) and is_numeric ( $doctor_id ) > 0 ) {
                $doctor   = $this -> DoctorModel -> get_doctor_id ( $doctor_id );
                $patient  = get_patient ( $patient_id );
                $discount = 0;
                $dis_type = 'flat';
                if ( $patient -> panel_id > 0 ) {
                    $panel = $this -> DoctorModel -> get_doctor_panel ( $doctor_id, $patient -> panel_id );
                    if ( !empty( $panel ) )
                        $charges = $panel -> price;
                    else
                        $charges = $doctor -> hospital_charges;
                }
                else
                    $charges = $doctor -> hospital_charges;
                
                $isLinked = $this -> AccountModel -> check_if_doctor_is_linked_with_account_head ( $doctor_id );
                
                $hospital_charges = $charges;
                $commission       = 0;
                
                if ( $online_reference_id && $online_reference_id > 0 ) {
                    $reference        = $this -> OnlineReferenceModel -> get_reference_by_id ( $online_reference_id );
                    $commission       = $hospital_charges * ( $reference -> commission / 100 );
                    $hospital_charges -= $commission;
                }
                
                $doctor_share   = $hospital_charges * ( $doctor -> doctor_share / 100 );
                $hospital_share = $hospital_charges - $doctor_share;
                
                $info = array (
                    'available_from'              => date ( 'g:i a', strtotime ( $doctor -> available_from ) ),
                    'available_till'              => date ( 'g:i a', strtotime ( $doctor -> available_till ) ),
                    'discount'                    => $discount,
                    'act_charges'                 => $doctor -> hospital_charges,
                    'charges'                     => $charges,
                    'dis_type'                    => $dis_type,
                    'patient_type'                => $patient -> type,
                    'isLinked'                    => $isLinked ? 'true' : 'false',
                    'hospital_share'              => $hospital_share,
                    'doctor_share'                => $doctor_share,
                    'online_reference_commission' => $commission,
                    'net_bill'                    => $doctor -> hospital_charges
                );
                echo json_encode ( $info );
            }
            else {
                echo 'false';
            }
        }
        
        /**
         * -------------------------
         * follow_up main page
         * -------------------------
         */
        
        public function follow_up () {
            $title = site_name . ' - Follow up';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'follow_ups' ] = $this -> DoctorModel -> get_follow_up ();
            $this -> load -> view ( '/doctors/follow-up', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add add_follow_up main page
         * -------------------------
         */
        
        public function add_follow_up () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_follow_up' )
                $this -> do_add_follow_up ( $_POST );
            
            $title = site_name . ' - Add Follow Up';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/doctors/add-follow-up' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add follow_up
         * -------------------------
         */
        
        public function do_add_follow_up ( $POST ) {
            $data  = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $title = array_filter ( $data[ 'title' ] );
            if ( count ( $title ) > 0 ) {
                foreach ( $title as $value ) {
                    if ( !empty( trim ( $value ) ) ) {
                        $info = array (
                            'user_id'    => get_logged_in_user_id (),
                            'title'      => $value,
                            'date_added' => current_date_time (),
                        );
                        $this -> DoctorModel -> do_add_follow_up ( $info );
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Follow up added.' );
                return redirect ( base_url ( '/doctors/add-follow-up' ) );
            }
        }
        
        /**
         * -------------------------
         * delete follow up
         * -------------------------
         */
        
        public function delete_follow_up () {
            $follow_up = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $follow_up ) ) or !is_numeric ( $follow_up ) > 0 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> DoctorModel -> delete_follow_up ( $follow_up );
            $this -> session -> set_flashdata ( 'response', 'Success! Follow up deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * add specialization main page
         * -------------------------
         */
        
        public function edit_follow_up () {
            
            $follow_up_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $follow_up_id ) ) or !is_numeric ( $follow_up_id ) > 0 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_follow_up' )
                $this -> do_edit_follow_up ( $_POST );
            
            $title = site_name . ' - Edit Follow Up';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'follow_up' ] = $this -> DoctorModel -> get_follow_up_by_id ( $follow_up_id );
            $this -> load -> view ( '/doctors/edit-follow-up', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit specialization
         * -------------------------
         */
        
        public function do_edit_follow_up ( $POST ) {
            $data         = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $title        = $data[ 'title' ];
            $follow_up_id = $data[ 'follow_up_id' ];
            if ( !empty( trim ( $follow_up_id ) ) ) {
                $info = array (
                    'title' => $title
                );
                $this -> DoctorModel -> do_edit_follow_up_id ( $info, $follow_up_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Follow up updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        public function status ( $id ) {
            if ( !empty( trim ( $id ) ) && $id > 0 ) {
                $this -> DoctorModel -> status ( $id );
                $this -> session -> set_flashdata ( 'response', 'Success! Doctor status has been changed.' );
                return redirect ( base_url ( '/doctors/index' ) );
            }
            return redirect ( base_url ( '/doctors/index' ) );
        }
        
    }
