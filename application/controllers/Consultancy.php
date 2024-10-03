<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Consultancy extends CI_Controller {
        
        /**
         * -------------------------
         * Consultancy constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'DoctorModel' );
            $this -> load -> model ( 'ConsultancyModel' );
            $this -> load -> model ( 'LabModel' );
            $this -> load -> model ( 'MedicineModel' );
            $this -> load -> model ( 'AccountModel' );
            $this -> load -> model ( 'InstructionModel' );
            $this -> load -> model ( 'PatientModel' );
            $this -> load -> model ( 'OnlineReferenceModel' );
            $this -> load -> model ( 'OPDModel' );
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
         * consultancies main page
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - Cash Consultancy Invoices';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'consultancy/index' );
            $total_row                      = $this -> ConsultancyModel -> count_consultancies ();
            $config[ "total_rows" ]         = $total_row;
            $config[ "per_page" ]           = $limit;
            $config[ 'use_page_numbers' ]   = false;
            $config[ 'page_query_string' ]  = TRUE;
            $config[ 'reuse_query_string' ] = TRUE;
            $config[ 'num_links' ]          = 10;
            $config[ 'cur_tag_open' ]       = '&nbsp;<a class="current">';
            $config[ 'cur_tag_close' ]      = '</a>';
            $config[ 'next_link' ]          = 'Next';
            $config[ 'prev_link' ]          = 'Previous';
            
            $this -> pagination -> initialize ( $config );
            
            /**********END PAGINATION***********/
            
            if ( isset( $_REQUEST[ 'per_page' ] ) and $_REQUEST[ 'per_page' ] > 0 ) {
                $offset = $_REQUEST[ 'per_page' ];
            }
            else {
                $offset = 0;
            }
            
            $data[ 'consultancies' ]   = $this -> ConsultancyModel -> get_consultancies ( $config[ "per_page" ], $offset );
            $str_links                 = $this -> pagination -> create_links ();
            $data[ 'specializations' ] = $this -> DoctorModel -> get_specializations ();
            $data[ 'doctors' ]         = $this -> DoctorModel -> get_doctors ();
            $data[ "links" ]           = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/consultancy/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * consultancies main page
         * -------------------------
         */
        
        public function panel_consultancy_invoices () {
            $title = site_name . ' - Panel Consultancy Invoices';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'consultancy/panel-consultancy-invoices' );
            $total_row                      = $this -> ConsultancyModel -> count_panel_consultancies ();
            $config[ "total_rows" ]         = $total_row;
            $config[ "per_page" ]           = $limit;
            $config[ 'use_page_numbers' ]   = false;
            $config[ 'page_query_string' ]  = TRUE;
            $config[ 'reuse_query_string' ] = TRUE;
            $config[ 'num_links' ]          = 10;
            $config[ 'cur_tag_open' ]       = '&nbsp;<a class="current">';
            $config[ 'cur_tag_close' ]      = '</a>';
            $config[ 'next_link' ]          = 'Next';
            $config[ 'prev_link' ]          = 'Previous';
            
            $this -> pagination -> initialize ( $config );
            
            /**********END PAGINATION***********/
            
            if ( isset( $_REQUEST[ 'per_page' ] ) and $_REQUEST[ 'per_page' ] > 0 ) {
                $offset = $_REQUEST[ 'per_page' ];
            }
            else {
                $offset = 0;
            }
            
            $data[ 'consultancies' ]   = $this -> ConsultancyModel -> get_panel_consultancies ( $config[ "per_page" ], $offset );
            $str_links                 = $this -> pagination -> create_links ();
            $data[ 'specializations' ] = $this -> DoctorModel -> get_specializations ();
            $data[ 'doctors' ]         = $this -> DoctorModel -> get_doctors ();
            $data[ "links" ]           = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/consultancy/panel_consultancy_invoices', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * doctors add main page
         * -------------------------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_consultancy' )
                $this -> do_add_consultancy ( $_POST );
            
            $title = site_name . ' - Add Consultancy';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'specializations' ] = $this -> DoctorModel -> get_specializations ();
            $data[ 'references' ]      = $this -> OnlineReferenceModel -> get_references ();
            $this -> load -> view ( '/consultancy/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add doctors
         * -------------------------
         */
        
        public function do_add_consultancy ( $POST ) {
            $this -> form_validation -> set_rules ( 'patient_id', 'patient id', 'required|numeric|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'specialization_id', 'specialization id', 'required|numeric|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'doctor_id', 'doctor id', 'required|numeric|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'available_from', 'available from', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'available_till', 'available till', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'charges', 'charges', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'net_bill', 'net bill', 'required|trim|min_length[1]|xss_clean|numeric' );
            
            if ( $this -> form_validation -> run () == true ) {
                $patient         = get_patient ( $this -> input -> post ( 'patient_id' ) );
                $doc_acc_head_id = get_doctor_linked_account_head_id ( $this -> input -> post ( 'doctor_id' ) );
                $accHeadID       = 0;
                if ( $patient -> panel_id > 0 ) {
                    $accHeadID = get_account_head_id_by_panel_id ( $patient -> panel_id );
                }
                
                if ( empty( $accHeadID ) and $patient -> panel_id > 0 ) {
                    $this -> session -> set_flashdata ( 'error', 'Alert! No account head is linked against patient panel id.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                
                $this -> db -> trans_begin ();
                
                try {
                    if ( $doc_acc_head_id > 0 ) {
                        
                        $doctor_info = get_doctor ( $this -> input -> post ( 'doctor_id' ) );
                        $info        = array (
                            'user_id'             => get_logged_in_user_id (),
                            'specialization_id'   => $this -> input -> post ( 'specialization_id' ),
                            'patient_id'          => $this -> input -> post ( 'patient_id' ),
                            'doctor_id'           => $this -> input -> post ( 'doctor_id' ),
                            'account_head_id'     => $this -> input -> post ( 'bank-id' ),
                            'online_reference_id' => $this -> input -> post ( 'online-reference-id' ),
                            'payment_method'      => $this -> input -> post ( 'payment-method' ),
                            'transaction_no'      => $this -> input -> post ( 'transaction-no' ),
                            'available_from'      => date ( "H:i", strtotime ( $this -> input -> post ( 'available_from' ) ) ),
                            'available_till'      => date ( "H:i", strtotime ( $this -> input -> post ( 'available_till' ) ) ),
                            'charges'             => $this -> input -> post ( 'charges' ),
                            'discount'            => 0,
                            'flat_discount'       => 0,
                            'hospital_share'      => $this -> input -> post ( 'hospital-commission' ),
                            'hospital_discount'   => $this -> input -> post ( 'hospital-discount' ),
                            'doctor_charges'      => $this -> input -> post ( 'doctor-commission' ),
                            'doctor_discount'     => $this -> input -> post ( 'doctor-discount' ),
                            'net_bill'            => $this -> input -> post ( 'net_bill' ),
                            'remarks'             => $this -> input -> post ( 'remarks' ),
                            'date_added'          => current_date_time (),
                        );
                        
                        if ( $this -> input -> post ( 'online-reference-id' ) > 0 ) {
                            $reference_id                          = $this -> input -> post ( 'online-reference-id' );
                            $onlineReference                       = $this -> OnlineReferenceModel -> get_reference_by_id ( $reference_id );
                            $commission                            = $this -> input -> post ( 'net_bill' ) * ( $onlineReference -> commission / 100 );
                            $info[ 'online_reference_commission' ] = $this -> input -> post ( 'online-reference' );
                        }
                        
                        $consultancy_id = $this -> ConsultancyModel -> add ( $info );
                        
                        $log = array (
                            'user_id'        => get_logged_in_user_id (),
                            'consultancy_id' => $consultancy_id,
                            'action'         => 'consultancy_added',
                            'log'            => json_encode ( $info ),
                            'after_update'   => '',
                            'date_added'     => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                        
                        if ( $consultancy_id > 0 ) {
                            
                            $description = 'Refereed to: ' . $doctor_info -> name;
                            if ( $patient -> panel_id > 0 ) {
                                $panel       = get_panel_by_id ( $patient -> panel_id );
                                $description .= ' / ' . $panel -> name;
                            }
                            
                            $commission = 0;
                            if ( $this -> input -> post ( 'online-reference-id' ) > 0 ) {
                                $reference_id    = $this -> input -> post ( 'online-reference-id' );
                                $onlineReference = $this -> OnlineReferenceModel -> get_reference_by_id ( $reference_id );
                                
                                if ( !empty( $onlineReference ) )
                                    $commission = $this -> input -> post ( 'net_bill' ) * ( $onlineReference -> commission / 100 );
                                
                                $description .= ' - Online Referral Portal - ' . $onlineReference -> title;
                            }
                            
                            if ( $this -> input -> post ( 'online-reference-id' ) > 0 ) {
                                $reference_id    = $this -> input -> post ( 'online-reference-id' );
                                $onlineReference = $this -> OnlineReferenceModel -> get_reference_by_id ( $reference_id );
                                
                                if ( !empty( $onlineReference ) ) {
                                    $commission = $this -> input -> post ( 'online-reference' );
                                    $ledger     = array (
                                        'user_id'            => get_logged_in_user_id (),
                                        'acc_head_id'        => $onlineReference -> account_head_id,
                                        'opd_consultancy_id' => $consultancy_id,
                                        'trans_date'         => date ( 'Y-m-d' ),
                                        'payment_mode'       => 'cash',
                                        'paid_via'           => 'cash',
                                        'credit'             => 0,
                                        'debit'              => $commission,
                                        'transaction_type'   => 'credit',
                                        'description'        => $description,
                                        'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
                                        'date_added'         => current_date_time (),
                                    );
                                    $this -> AccountModel -> add_ledger ( $ledger );
                                    
                                    $ledger[ 'acc_head_id' ] = COS_Online_Referral_Portal;
                                    $ledger[ 'credit' ]      = $commission;
                                    $ledger[ 'debit' ]       = 0;
                                    $this -> AccountModel -> add_ledger ( $ledger );
                                }
                            }
                            
                            $cashAccountHead = cash_from_opd_consultancy;
                            if ( $this -> input -> post ( 'payment-method' ) == 'card' )
                                $cashAccountHead = CARD;
                            else if ( $this -> input -> post ( 'payment-method' ) == 'bank' )
                                $cashAccountHead = $this -> input -> post ( 'bank-id' );
                            
                            $revenue_consultancy = array (
                                'user_id'            => get_logged_in_user_id (),
                                'acc_head_id'        => sales_consultancy_service,
                                'opd_consultancy_id' => $consultancy_id,
                                'trans_date'         => date ( 'Y-m-d' ),
                                'payment_mode'       => 'cash',
                                'paid_via'           => 'cash',
                                'credit'             => 0,
                                'debit'              => $this -> input -> post ( 'charges' ),
                                'transaction_type'   => 'credit',
                                'description'        => $description,
                                'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
                                'date_added'         => current_date_time (),
                            );
                            if ( $patient -> panel_id > 0 ) {
                                $revenue_consultancy[ 'acc_head_id' ] = sales_consultancy_service_panel;
                            }
                            $this -> AccountModel -> add_ledger ( $revenue_consultancy );
                            
                            $ledger = array (
                                'user_id'            => get_logged_in_user_id (),
                                'acc_head_id'        => $cashAccountHead,
                                'opd_consultancy_id' => $consultancy_id,
                                'trans_date'         => date ( 'Y-m-d' ),
                                'payment_mode'       => 'cash',
                                'paid_via'           => 'cash',
                                'credit'             => $this -> input -> post ( 'net_bill' ),
                                'debit'              => 0,
                                'transaction_type'   => 'credit',
                                'description'        => $description,
                                'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
                                'date_added'         => current_date_time (),
                            );
                            if ( $patient -> panel_id > 0 ) {
                                $accHeadID               = get_account_head_id_by_panel_id ( $patient -> panel_id );
                                $ledger[ 'acc_head_id' ] = $accHeadID -> id;
                            }
                            $this -> AccountModel -> add_ledger ( $ledger );
                            
                            $doctors_share = $this -> input -> post ( 'doctor-commission' );
                            $doctor_share  = array (
                                'user_id'            => get_logged_in_user_id (),
                                'acc_head_id'        => $doc_acc_head_id,
                                'opd_consultancy_id' => $consultancy_id,
                                'trans_date'         => date ( 'Y-m-d' ),
                                'payment_mode'       => 'cash',
                                'paid_via'           => 'cash',
                                'credit'             => 0,
                                'debit'              => $doctors_share,
                                'transaction_type'   => 'credit',
                                'description'        => $description,
                                'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
                                'date_added'         => current_date_time (),
                            );
                            $this -> AccountModel -> add_ledger ( $doctor_share );
                            
                            $COS_consultancy = array (
                                'user_id'            => get_logged_in_user_id (),
                                'acc_head_id'        => COS_Consultancy_Charges,
                                'opd_consultancy_id' => $consultancy_id,
                                'trans_date'         => date ( 'Y-m-d' ),
                                'payment_mode'       => 'cash',
                                'paid_via'           => 'cash',
                                'credit'             => $doctors_share,
                                'debit'              => 0,
                                'transaction_type'   => 'credit',
                                'description'        => $description,
                                'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
                                'date_added'         => current_date_time (),
                            );
                            $this -> AccountModel -> add_ledger ( $COS_consultancy );
                            
                            $discount_consultancy = array (
                                'user_id'            => get_logged_in_user_id (),
                                'acc_head_id'        => discount_consultancy_service,
                                'opd_consultancy_id' => $consultancy_id,
                                'trans_date'         => date ( 'Y-m-d' ),
                                'payment_mode'       => 'cash',
                                'paid_via'           => 'cash',
                                'credit'             => $this -> input -> post ( 'hospital-discount' ),
                                'debit'              => 0,
                                'transaction_type'   => 'credit',
                                'description'        => $description,
                                'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
                                'date_added'         => current_date_time (),
                            );
                            if ( $patient -> panel_id > 0 ) {
                                $discount_consultancy[ 'acc_head_id' ] = discount_consultancy_service_panel;
                            }
                            $this -> AccountModel -> add_ledger ( $discount_consultancy );
                            
                            $doctor_ledger = array (
                                'user_id'            => get_logged_in_user_id (),
                                'acc_head_id'        => $doc_acc_head_id,
                                'opd_consultancy_id' => $consultancy_id,
                                'trans_date'         => date ( 'Y-m-d' ),
                                'payment_mode'       => 'cash',
                                'paid_via'           => 'cash',
                                'credit'             => $this -> input -> post ( 'doctor-discount' ),
                                'debit'              => 0,
                                'transaction_type'   => 'debit',
                                'description'        => 'Doctor discount',
                                'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
                                'date_added'         => current_date_time (),
                            );
                            $this -> AccountModel -> add_ledger ( $doctor_ledger );
                            
                            $log = array (
                                'user_id'        => get_logged_in_user_id (),
                                'consultancy_id' => $consultancy_id,
                                'action'         => 'consultancy_ledger_added',
                                'log'            => json_encode ( $ledger ),
                                'after_update'   => '',
                                'date_added'     => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                            
                            $log = array (
                                'user_id'        => get_logged_in_user_id (),
                                'consultancy_id' => $consultancy_id,
                                'action'         => 'consultancy_revenue_ledger_added',
                                'log'            => json_encode ( $revenue_consultancy ),
                                'after_update'   => '',
                                'date_added'     => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                            
                            $log = array (
                                'user_id'        => get_logged_in_user_id (),
                                'consultancy_id' => $consultancy_id,
                                'action'         => 'consultancy_doctor_share_ledger_added',
                                'log'            => json_encode ( $doctor_share ),
                                'after_update'   => '',
                                'date_added'     => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                            
                            $log = array (
                                'user_id'        => get_logged_in_user_id (),
                                'consultancy_id' => $consultancy_id,
                                'action'         => 'discount_consultancy_ledger_added',
                                'log'            => json_encode ( $discount_consultancy ),
                                'after_update'   => '',
                                'date_added'     => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                            
                            $this -> db -> trans_commit ();
                            
                            $this -> session -> set_flashdata ( 'response', 'Success! Consultancy added. <a href="' . base_url ( '/invoices/consultancy-invoice/' . $consultancy_id ) . '" target="_blank" style="font-weight: 800; font-size: 16px">Print</a>' );
                            
                            return redirect ( base_url ( '/consultancy/prescriptions?consultancy_id=' . $consultancy_id ) );
                            
                        }
                        else {
                            $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                        }
                    }
                    else
                        $this -> session -> set_flashdata ( 'error', 'Error! Doctor account head is either not created or not linked with account head. Please add account head first or link if there is already.' );
                    return redirect ( base_url ( '/consultancy/add' ) );
                }
                catch ( Exception $e ) {
                    $this -> db -> trans_rollback ();
                    $this -> session -> set_flashdata ( 'error', $e -> getMessage () );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }


//        public function do_add_consultancy ( $POST ) {
//            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
//            $this -> form_validation -> set_rules ( 'patient_id', 'patient id', 'required|numeric|trim|min_length[1]|xss_clean' );
//            $this -> form_validation -> set_rules ( 'specialization_id', 'specialization id', 'required|numeric|trim|min_length[1]|xss_clean' );
//            $this -> form_validation -> set_rules ( 'doctor_id', 'doctor id', 'required|numeric|trim|min_length[1]|xss_clean' );
//            $this -> form_validation -> set_rules ( 'available_from', 'available from', 'required|trim|min_length[1]|xss_clean' );
//            $this -> form_validation -> set_rules ( 'available_till', 'available till', 'required|trim|min_length[1]|xss_clean' );
//            $this -> form_validation -> set_rules ( 'charges', 'charges', 'required|trim|min_length[1]|xss_clean|numeric' );
//            //            $this -> form_validation -> set_rules ( 'discount', 'discount', 'required|trim|min_length[1]|xss_clean|numeric' );
//            $this -> form_validation -> set_rules ( 'net_bill', 'net bill', 'required|trim|min_length[1]|xss_clean|numeric' );
//
//            if ( $this -> form_validation -> run () == true ) {
//                $patient         = get_patient ( $data[ 'patient_id' ] );
//                $doc_acc_head_id = get_doctor_linked_account_head_id ( $data[ 'doctor_id' ] );
//                $accHeadID       = 0;
//                if ( $patient -> panel_id > 0 ) {
//                    $accHeadID = get_account_head_id_by_panel_id ( $patient -> panel_id );
//                }
//
//                if ( empty( $accHeadID ) and $patient -> panel_id > 0 ) {
//                    $this -> session -> set_flashdata ( 'error', 'Alert! No account head is linked against patient panel id.' );
//                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
//                }
//
//                if ( $doc_acc_head_id > 0 ) {
//
//                    $doctor_info = get_doctor ( $data[ 'doctor_id' ] );
//                    $info        = array (
//                        'user_id'             => get_logged_in_user_id (),
//                        'specialization_id'   => $data[ 'specialization_id' ],
//                        'patient_id'          => $data[ 'patient_id' ],
//                        'doctor_id'           => $data[ 'doctor_id' ],
//                        'account_head_id'     => $this -> input -> post ( 'bank-id' ),
//                        'online_reference_id' => $this -> input -> post ( 'online-reference-id' ),
//                        'payment_method'      => $this -> input -> post ( 'payment-method' ),
//                        'transaction_no'      => $this -> input -> post ( 'transaction-no' ),
//                        'available_from'      => date ( "H:i", strtotime ( $data[ 'available_from' ] ) ),
//                        'available_till'      => date ( "H:i", strtotime ( $data[ 'available_till' ] ) ),
//                        'charges'             => $data[ 'charges' ],
//                        'discount'            => $data[ 'discount' ],
//                        'flat_discount'       => $data[ 'flat-discount' ],
//                        'net_bill'            => $data[ 'net_bill' ],
//                        'remarks'             => $data[ 'remarks' ],
//                        'doctor_charges'      => $doctor_info -> doctor_share,
//                        'date_added'          => current_date_time (),
//                    );
//
//                    if ( $this -> input -> post ( 'online-reference-id' ) > 0 ) {
//                        $reference_id                          = $this -> input -> post ( 'online-reference-id' );
//                        $onlineReference                       = $this -> OnlineReferenceModel -> get_reference_by_id ( $reference_id );
//                        $commission                            = $data[ 'net_bill' ] * ( $onlineReference -> commission / 100 );
//                        $info[ 'online_reference_commission' ] = $commission;
//                    }
//
//                    $consultancy_id = $this -> ConsultancyModel -> add ( $info );
//
//                    $log = array (
//                        'user_id'        => get_logged_in_user_id (),
//                        'consultancy_id' => $consultancy_id,
//                        'action'         => 'consultancy_added',
//                        'log'            => json_encode ( $info ),
//                        'after_update'   => '',
//                        'date_added'     => current_date_time ()
//                    );
//                    $this -> load -> model ( 'LogModel' );
//                    $this -> LogModel -> create_log ( 'consultancy_logs', $log );
//
//                    if ( $consultancy_id > 0 ) {
//
//                        $description = 'Refereed to: ' . $doctor_info -> name;
//                        if ( $patient -> panel_id > 0 ) {
//                            $panel       = get_panel_by_id ( $patient -> panel_id );
//                            $description .= ' / ' . $panel -> name;
//                        }
//
//                        $commission = 0;
//                        if ( $this -> input -> post ( 'online-reference-id' ) > 0 ) {
//                            $reference_id    = $this -> input -> post ( 'online-reference-id' );
//                            $onlineReference = $this -> OnlineReferenceModel -> get_reference_by_id ( $reference_id );
//
//                            if ( !empty( $onlineReference ) )
//                                $commission = $data[ 'net_bill' ] * ( $onlineReference -> commission / 100 );
//
//                            $description .= ' - Online Referral Portal - ' . $onlineReference -> title;
//                        }
//
//                        $cashAccountHead = cash_from_opd_consultancy;
//                        if ( $this -> input -> post ( 'payment-method' ) == 'card' )
//                            $cashAccountHead = CARD;
//                        else if ( $this -> input -> post ( 'payment-method' ) == 'bank' )
//                            $cashAccountHead = $this -> input -> post ( 'bank-id' );
//
//                        $ledger = array (
//                            'user_id'            => get_logged_in_user_id (),
//                            'acc_head_id'        => $cashAccountHead,
//                            'opd_consultancy_id' => $consultancy_id,
//                            'trans_date'         => date ( 'Y-m-d' ),
//                            'payment_mode'       => 'cash',
//                            'paid_via'           => 'cash',
//                            'credit'             => $data[ 'net_bill' ],
//                            'debit'              => 0,
//                            'transaction_type'   => 'credit',
//                            'description'        => $description,
//                            'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
//                            'date_added'         => current_date_time (),
//                        );
//                        if ( $patient -> panel_id > 0 ) {
//                            $accHeadID               = get_account_head_id_by_panel_id ( $patient -> panel_id );
//                            $ledger[ 'acc_head_id' ] = $accHeadID -> id;
//                        }
//                        $this -> AccountModel -> add_ledger ( $ledger );
//
//                        if ( $data[ 'discount' ] > 0 || $data[ 'flat-discount' ] > 0 ) {
//
//                            $share         = $doctor_info -> doctor_share;
//                            $doctors_share = ( ( ( $data[ 'charges' ] - $commission ) * $share ) / 100 );
//
//                            $revenue_consultancy = array (
//                                'user_id'            => get_logged_in_user_id (),
//                                'acc_head_id'        => sales_consultancy_service,
//                                'opd_consultancy_id' => $consultancy_id,
//                                'trans_date'         => date ( 'Y-m-d' ),
//                                'payment_mode'       => 'cash',
//                                'paid_via'           => 'cash',
//                                'credit'             => 0,
//                                'debit'              => $data[ 'charges' ],
//                                'transaction_type'   => 'credit',
//                                'description'        => $description,
//                                'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
//                                'date_added'         => current_date_time (),
//                            );
//                            if ( $patient -> panel_id > 0 ) {
//                                $revenue_consultancy[ 'acc_head_id' ] = sales_consultancy_service_panel;
//                            }
//                            $this -> AccountModel -> add_ledger ( $revenue_consultancy );
//
//                            $doctor_share = array (
//                                'user_id'            => get_logged_in_user_id (),
//                                'acc_head_id'        => $doc_acc_head_id,
//                                'opd_consultancy_id' => $consultancy_id,
//                                'trans_date'         => date ( 'Y-m-d' ),
//                                'payment_mode'       => 'cash',
//                                'paid_via'           => 'cash',
//                                'credit'             => 0,
//                                'debit'              => $doctors_share,
//                                'transaction_type'   => 'credit',
//                                'description'        => $description,
//                                'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
//                                'date_added'         => current_date_time (),
//                            );
//                            $this -> AccountModel -> add_ledger ( $doctor_share );
//
//                            $discount_consultancy = array (
//                                'user_id'            => get_logged_in_user_id (),
//                                'acc_head_id'        => discount_consultancy_service,
//                                'opd_consultancy_id' => $consultancy_id,
//                                'trans_date'         => date ( 'Y-m-d' ),
//                                'payment_mode'       => 'cash',
//                                'paid_via'           => 'cash',
//                                'credit'             => $data[ 'charges' ] - $data[ 'net_bill' ],
//                                'debit'              => 0,
//                                'transaction_type'   => 'credit',
//                                'description'        => $description,
//                                'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
//                                'date_added'         => current_date_time (),
//                            );
//                            if ( $patient -> panel_id > 0 ) {
//                                $discount_consultancy[ 'acc_head_id' ] = discount_consultancy_service_panel;
//                            }
//                            $this -> AccountModel -> add_ledger ( $discount_consultancy );
//
//                            $COS_consultancy = array (
//                                'user_id'            => get_logged_in_user_id (),
//                                'acc_head_id'        => COS_Consultancy_Charges,
//                                'opd_consultancy_id' => $consultancy_id,
//                                'trans_date'         => date ( 'Y-m-d' ),
//                                'payment_mode'       => 'cash',
//                                'paid_via'           => 'cash',
//                                'credit'             => $doctors_share,
//                                'debit'              => 0,
//                                'transaction_type'   => 'credit',
//                                'description'        => $description,
//                                'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
//                                'date_added'         => current_date_time (),
//                            );
//                            $this -> AccountModel -> add_ledger ( $COS_consultancy );
//
//                            $log = array (
//                                'user_id'        => get_logged_in_user_id (),
//                                'consultancy_id' => $consultancy_id,
//                                'action'         => 'discount_consultancy_ledger_added',
//                                'log'            => json_encode ( $discount_consultancy ),
//                                'after_update'   => '',
//                                'date_added'     => current_date_time ()
//                            );
//                            $this -> load -> model ( 'LogModel' );
//                            $this -> LogModel -> create_log ( 'consultancy_logs', $log );
//
//                        }
//                        else {
//                            $share         = $doctor_info -> doctor_share;
//                            $doctors_share = ( ( ( $data[ 'charges' ] - $commission ) * $share ) / 100 );
//
//                            $revenue_consultancy = array (
//                                'user_id'            => get_logged_in_user_id (),
//                                'acc_head_id'        => sales_consultancy_service,
//                                'opd_consultancy_id' => $consultancy_id,
//                                'trans_date'         => date ( 'Y-m-d' ),
//                                'payment_mode'       => 'cash',
//                                'paid_via'           => 'cash',
//                                'credit'             => 0,
//                                'debit'              => $data[ 'charges' ],
//                                'transaction_type'   => 'credit',
//                                'description'        => $description,
//                                'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
//                                'date_added'         => current_date_time (),
//                            );
//                            if ( $patient -> panel_id > 0 ) {
//                                $revenue_consultancy[ 'acc_head_id' ] = sales_consultancy_service_panel;
//                            }
//                            $this -> AccountModel -> add_ledger ( $revenue_consultancy );
//
//                            $doctor_share = array (
//                                'user_id'            => get_logged_in_user_id (),
//                                'acc_head_id'        => $doc_acc_head_id,
//                                'opd_consultancy_id' => $consultancy_id,
//                                'trans_date'         => date ( 'Y-m-d' ),
//                                'payment_mode'       => 'cash',
//                                'paid_via'           => 'cash',
//                                'credit'             => 0,
//                                'debit'              => $doctors_share,
//                                'transaction_type'   => 'credit',
//                                'description'        => $description,
//                                'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
//                                'date_added'         => current_date_time (),
//                            );
//                            $this -> AccountModel -> add_ledger ( $doctor_share );
//
//                            $COS_consultancy = array (
//                                'user_id'            => get_logged_in_user_id (),
//                                'acc_head_id'        => COS_Consultancy_Charges,
//                                'opd_consultancy_id' => $consultancy_id,
//                                'trans_date'         => date ( 'Y-m-d' ),
//                                'payment_mode'       => 'cash',
//                                'paid_via'           => 'cash',
//                                'credit'             => $doctors_share,
//                                'debit'              => 0,
//                                'transaction_type'   => 'credit',
//                                'description'        => $description,
//                                'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
//                                'date_added'         => current_date_time (),
//                            );
//                            $this -> AccountModel -> add_ledger ( $COS_consultancy );
//
//                            $discount_consultancy = array (
//                                'user_id'            => get_logged_in_user_id (),
//                                'acc_head_id'        => discount_consultancy_service,
//                                'opd_consultancy_id' => $consultancy_id,
//                                'trans_date'         => date ( 'Y-m-d' ),
//                                'payment_mode'       => 'cash',
//                                'paid_via'           => 'cash',
//                                'credit'             => $data[ 'charges' ] - $data[ 'net_bill' ],
//                                'debit'              => 0,
//                                'transaction_type'   => 'credit',
//                                'description'        => $description,
//                                'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
//                                'date_added'         => current_date_time (),
//                            );
//                            if ( $patient -> panel_id > 0 ) {
//                                $discount_consultancy[ 'acc_head_id' ] = discount_consultancy_service_panel;
//                            }
//                            $this -> AccountModel -> add_ledger ( $discount_consultancy );
//                        }
//
//                        if ( $this -> input -> post ( 'online-reference-id' ) > 0 ) {
//                            $reference_id    = $this -> input -> post ( 'online-reference-id' );
//                            $onlineReference = $this -> OnlineReferenceModel -> get_reference_by_id ( $reference_id );
//
//                            if ( !empty( $onlineReference ) ) {
//                                $commission = $data[ 'net_bill' ] * ( $onlineReference -> commission / 100 );
//                                $ledger     = array (
//                                    'user_id'            => get_logged_in_user_id (),
//                                    'acc_head_id'        => $onlineReference -> account_head_id,
//                                    'opd_consultancy_id' => $consultancy_id,
//                                    'trans_date'         => date ( 'Y-m-d' ),
//                                    'payment_mode'       => 'cash',
//                                    'paid_via'           => 'cash',
//                                    'credit'             => 0,
//                                    'debit'              => $commission,
//                                    'transaction_type'   => 'credit',
//                                    'description'        => $description,
//                                    'transaction_no'     => $this -> input -> post ( 'transaction-no' ),
//                                    'date_added'         => current_date_time (),
//                                );
//                                $this -> AccountModel -> add_ledger ( $ledger );
//
//                                $ledger[ 'acc_head_id' ] = COS_Online_Referral_Portal;
//                                $ledger[ 'credit' ]      = $commission;
//                                $ledger[ 'debit' ]       = 0;
//                                $this -> AccountModel -> add_ledger ( $ledger );
//                            }
//                        }
//
//                        $log = array (
//                            'user_id'        => get_logged_in_user_id (),
//                            'consultancy_id' => $consultancy_id,
//                            'action'         => 'consultancy_ledger_added',
//                            'log'            => json_encode ( $ledger ),
//                            'after_update'   => '',
//                            'date_added'     => current_date_time ()
//                        );
//                        $this -> load -> model ( 'LogModel' );
//                        $this -> LogModel -> create_log ( 'consultancy_logs', $log );
//
//                        $log = array (
//                            'user_id'        => get_logged_in_user_id (),
//                            'consultancy_id' => $consultancy_id,
//                            'action'         => 'consultancy_revenue_ledger_added',
//                            'log'            => json_encode ( $revenue_consultancy ),
//                            'after_update'   => '',
//                            'date_added'     => current_date_time ()
//                        );
//                        $this -> load -> model ( 'LogModel' );
//                        $this -> LogModel -> create_log ( 'consultancy_logs', $log );
//
//                        $log = array (
//                            'user_id'        => get_logged_in_user_id (),
//                            'consultancy_id' => $consultancy_id,
//                            'action'         => 'consultancy_doctor_share_ledger_added',
//                            'log'            => json_encode ( $doctor_share ),
//                            'after_update'   => '',
//                            'date_added'     => current_date_time ()
//                        );
//                        $this -> load -> model ( 'LogModel' );
//                        $this -> LogModel -> create_log ( 'consultancy_logs', $log );
//
//
//                        $this -> session -> set_flashdata ( 'response', 'Success! Consultancy added. <a href="' . base_url ( '/invoices/consultancy-invoice/' . $consultancy_id ) . '" target="_blank" style="font-weight: 800; font-size: 16px">Print</a>' );
//
//                        return redirect ( base_url ( '/consultancy/prescriptions?consultancy_id=' . $consultancy_id ) );
//
//                    }
//                    else {
//                        $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
//                    }
//                }
//                else
//                    $this -> session -> set_flashdata ( 'error', 'Error! Doctor account head is either not created or not linked with account head. Please add account head first or link if there is already.' );
//                return redirect ( base_url ( '/consultancy/add' ) );
//            }
//        }
        
        /**
         * -------------------------
         * consultancy edit main page
         * -------------------------
         */
        
        public function edit () {
            
            $consultancy_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $consultancy_id ) ) or !is_numeric ( $consultancy_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_consultancy' )
                $this -> do_edit_consultancy ( $_POST );
            
            $title = site_name . ' - Edit Consultancy';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'consultancy' ] = $this -> ConsultancyModel -> get_consultancy_by_id ( $consultancy_id );
            $data[ 'banks' ]       = $this -> AccountModel -> get_banks ( banks );
            $data[ 'patient' ]     = get_patient ( $data[ 'consultancy' ] -> patient_id );
            $this -> load -> view ( '/consultancy/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit consultancy
         * -------------------------
         */
        
        public function do_edit_consultancy ( $POST ) {
            $this -> form_validation -> set_rules ( 'consultancy_id', 'consultancy id', 'required|numeric|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'charges', 'charges', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'net_bill', 'net bill', 'required|trim|min_length[1]|xss_clean|numeric' );
            
            $consultancy_id   = $this -> input -> post ( 'consultancy_id' );
            $consultancy_info = $this -> ConsultancyModel -> get_consultancy_by_id ( $consultancy_id );
            $doc_acc_head_id  = get_doctor_linked_account_head_id ( $this -> input -> post ( 'doctor_id' ) );
            if ( $this -> form_validation -> run () ) {
                
                $info = array (
                    'charges'           => $this -> input -> post ( 'charges' ),
                    'hospital_discount' => $this -> input -> post ( 'hospital-discount' ),
                    'doctor_discount'   => $this -> input -> post ( 'doctor-discount' ),
                    'net_bill'          => $this -> input -> post ( 'net_bill' ),
                    'remarks'           => $this -> input -> post ( 'remarks' ),
                    'transaction_no'    => $this -> input -> post ( 'transaction-no' )
                );
                
                $log = array (
                    'user_id'        => get_logged_in_user_id (),
                    'consultancy_id' => $consultancy_id,
                    'action'         => 'consultancy_updated',
                    'log'            => json_encode ( $this -> ConsultancyModel -> get_consultancy_by_id ( $consultancy_id ) ),
                    'after_update'   => json_encode ( $info ),
                    'date_added'     => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                
                $this -> ConsultancyModel -> edit ( $info, $consultancy_id );
                $doctor_info = get_doctor ( $this -> input -> post ( 'doctor_id' ) );
                
                $revenue_consultancy       = array (
                    'acc_head_id'        => sales_consultancy_service,
                    'opd_consultancy_id' => $consultancy_id,
                    'debit'              => $this -> input -> post ( 'charges' ),
                );
                $revenue_consultancy_where = array (
                    'acc_head_id'        => sales_consultancy_service,
                    'opd_consultancy_id' => $consultancy_id,
                );
                $this -> AccountModel -> update_general_ledger ( $revenue_consultancy, $revenue_consultancy_where );
                
                $cashAccountHead = cash_from_opd_consultancy;
                $consultancy     = $this -> ConsultancyModel -> get_consultancy_by_id ( $consultancy_id );
                if ( $consultancy -> payment_method == 'card' )
                    $cashAccountHead = CARD;
                else if ( $consultancy -> payment_method == 'bank' )
                    $cashAccountHead = $consultancy -> account_head_id;
                
                $consultancy_ledger       = array (
                    'credit'         => $this -> input -> post ( 'net_bill' ),
                    'transaction_no' => $this -> input -> post ( 'transaction-no' )
                );
                $consultancy_ledger_where = array (
                    'acc_head_id'        => $cashAccountHead,
                    'opd_consultancy_id' => $consultancy_id,
                );
                $this -> AccountModel -> update_general_ledger ( $consultancy_ledger, $consultancy_ledger_where );
                
                $doctor_discount = $this -> input -> post ( 'doctor-discount' );
                $doctor_share    = array (
                    'credit' => $doctor_discount,
                );
                
                $doctor_share_where = array (
                    'acc_head_id'        => $doc_acc_head_id,
                    'opd_consultancy_id' => $consultancy_id,
                    'transaction_type'   => 'debit'
                );
                $this -> AccountModel -> update_general_ledger ( $doctor_share, $doctor_share_where );
                
                $discount_consultancy       = array (
                    'credit' => $this -> input -> post ( 'hospital-discount' ),
                    'debit'  => 0,
                );
                $discount_consultancy_where = array (
                    'acc_head_id'        => discount_consultancy_service,
                    'opd_consultancy_id' => $consultancy_id,
                );
                $this -> AccountModel -> update_general_ledger ( $discount_consultancy, $discount_consultancy_where );
                
                if ( $consultancy_info -> online_reference_id > 0 ) {
                    $reference_id    = $consultancy_info -> online_reference_id;
                    $onlineReference = $this -> OnlineReferenceModel -> get_reference_by_id ( $reference_id );
                    
                    if ( !empty( $onlineReference ) ) {
                        $commission            = $this -> input -> post ( 'online-reference' );
                        $referral_ledger       = array (
                            'debit' => $commission,
                        );
                        $referral_ledger_where = array (
                            'acc_head_id'        => $onlineReference -> account_head_id,
                            'opd_consultancy_id' => $consultancy_id,
                        );
                        $this -> AccountModel -> update_general_ledger ( $referral_ledger, $referral_ledger_where );
                        
                        $cos_referral_ledger       = array (
                            'credit' => $commission,
                        );
                        $cos_referral_ledger_where = array (
                            'acc_head_id'        => COS_Online_Referral_Portal,
                            'opd_consultancy_id' => $consultancy_id,
                        );
                        $this -> AccountModel -> update_general_ledger ( $cos_referral_ledger, $cos_referral_ledger_where );
                    }
                }
                
                $log = array (
                    'user_id'        => get_logged_in_user_id (),
                    'consultancy_id' => $consultancy_id,
                    'action'         => 'consultancy_revenue_ledger_added',
                    'log'            => json_encode ( $revenue_consultancy ),
                    'after_update'   => '',
                    'date_added'     => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                
                $log = array (
                    'user_id'        => get_logged_in_user_id (),
                    'consultancy_id' => $consultancy_id,
                    'action'         => 'consultancy_doctor_share_ledger_added',
                    'log'            => json_encode ( $doctor_share ),
                    'after_update'   => '',
                    'date_added'     => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                
                
                $log = array (
                    'user_id'        => get_logged_in_user_id (),
                    'consultancy_id' => $consultancy_id,
                    'action'         => 'consultancy_ledger_updated',
                    'log'            => ' ',
                    'after_update'   => json_encode ( $this -> input -> post ( 'net_bill' ) ),
                    'date_added'     => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                
                $this -> session -> set_flashdata ( 'response', 'Success! Consultancy updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete consultancy
         * -------------------------
         */
        
        public function delete () {
            $consultancy_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $consultancy_id ) ) or !is_numeric ( $consultancy_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $log = array (
                'user_id'        => get_logged_in_user_id (),
                'consultancy_id' => $consultancy_id,
                'action'         => 'consultancy_deleted',
                'log'            => json_encode ( $this -> ConsultancyModel -> get_consultancy_by_id ( $consultancy_id ) ),
                'after_update'   => '',
                'date_added'     => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'consultancy_logs', $log );
            
            $this -> ConsultancyModel -> delete ( $consultancy_id );
            $this -> AccountModel -> delete_opd_consultancy_ledger ( $consultancy_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Consultancy deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * prescriptions add main page
         * -------------------------
         */
        
        public function prescriptions () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_prescriptions' )
                $this -> do_add_prescriptions ( $_POST );
            
            $title = site_name . ' - Prescriptions';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'consultancy' ]          = $this -> ConsultancyModel -> search_consultancy ();
            $data[ 'prescription' ]         = $prescription = $this -> ConsultancyModel -> get_prescription ();
            $data[ 'medicines' ]            = $this -> MedicineModel -> get_medicines ();
            $data[ 'tests' ]                = $this -> LabModel -> get_tests ();
            $data[ 'follow_ups' ]           = $this -> DoctorModel -> get_follow_up ();
            $data[ 'instructions' ]         = $this -> InstructionModel -> get_instructions ();
            $data[ 'prescribed_medicines' ] = $this -> ConsultancyModel -> get_prescribed_medicines ();
            
            $this -> load -> view ( '/consultancy/edit-prescription', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add prescriptions
         * -------------------------
         */
        
        public function do_add_prescriptions ( $POST ) {
            $consultancy = $this -> ConsultancyModel -> search_consultancy ();
            $info        = array (
                'doctor_id'      => $consultancy -> doctor_id,
                'patient_id'     => $consultancy -> patient_id,
                'consultancy_id' => $_REQUEST[ 'consultancy_id' ],
                'complaints'     => $POST[ 'complaints' ],
                'diagnosis'      => $POST[ 'diagnosis' ],
                'follow_up'      => $POST[ 'follow_up' ],
                'follow_up_date' => !empty( trim ( $POST[ 'follow-up-date' ] ) ) ? date ( 'Y-m-d', strtotime ( $POST[ 'follow-up-date' ] ) ) : null,
                'date_added'     => current_date_time (),
            );
            $this -> ConsultancyModel -> delete_prescriptions ( $_REQUEST[ 'consultancy_id' ] );
            $prescription_id = $this -> ConsultancyModel -> do_add_prescriptions ( $info );
            if ( $prescription_id > 0 ) {
                
                $log = array (
                    'user_id'        => get_logged_in_user_id (),
                    'consultancy_id' => $_REQUEST[ 'consultancy_id' ],
                    'action'         => 'consultancy_prescriptions_added',
                    'log'            => json_encode ( $info ),
                    'after_update'   => '', 
                    'date_added'     => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                
                $this -> ConsultancyModel -> delete_consultancy_medication ( $_REQUEST[ 'consultancy_id' ] );
                $this -> ConsultancyModel -> add_doctor_prescribed_medicines ( $POST, $prescription_id, $consultancy );
                $this -> ConsultancyModel -> add_doctor_prescribed_tests ( $POST, $prescription_id, $consultancy );

                $this->session->set_flashdata('response', 'Success! Prescriptions added.
                <a href="' . base_url('/invoices/prescription-invoice/' . $prescription_id) . '" target="_blank" style="font-weight: 800; font-size: 16px; color: #007bff; text-decoration: none; margin-right: 15px;">L-Print</a> 
                <a href="' . base_url('/invoices/prescription-invoice/' . $prescription_id) . '" target="_blank" style="font-weight: 800; font-size: 16px; color: #28a745; text-decoration: none;">S-Print</a>
            ');
            
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
            return redirect ( base_url ( '/consultancy/prescriptions' ) );
        }
        
        /**
         * -------------------------
         * add more prescribed medicines
         * -------------------------
         */
        
        public function add_more_prescribed_medicines () {
            $data[ 'row' ]          = $_POST[ 'added' ];
            $data[ 'medicines' ]    = $this -> MedicineModel -> get_medicines ();
            $data[ 'instructions' ] = $this -> InstructionModel -> get_instructions ();
            $this -> load -> view ( '/consultancy/add_more_prescribed_medicines', $data );
        }
        
        /**
         * -------------------------
         * @param $POST
         * refund consultancy
         * -------------------------
         */
        
        public function refund () {
            
            $consultancy_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $consultancy_id ) ) or $consultancy_id < 1 or !is_numeric ( $consultancy_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_refund_consultancy' )
                $this -> do_refund_consultancy ( $_POST );
            
            $title = site_name . ' - Refund';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'consultancy' ] = $this -> ConsultancyModel -> get_consultancy_by_id ( $consultancy_id );
            $this -> load -> view ( '/consultancy/refund', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * do refund consultancy
         * -------------------------
         */
        
        public function do_refund_consultancy () {
            $consultancy_id = $_POST[ 'consultancy_id' ];
            $net_charges    = $_POST[ 'net_charges' ];
            if ( empty( trim ( $consultancy_id ) ) or $consultancy_id < 1 or !is_numeric ( $consultancy_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $consultancy = (array)$this -> ConsultancyModel -> get_consultancy_by_id ( $consultancy_id );
            $patient     = get_patient ( $consultancy[ 'patient_id' ] );
            if ( !empty( $consultancy ) ) {
                $doctor_charges = $consultancy[ 'doctor_charges' ];
                $doctor_id      = $consultancy[ 'doctor_id' ];
                $discount       = $consultancy[ 'discount' ];
                $flat_discount  = $consultancy[ 'flat_discount' ];
                array_shift ( $consultancy );
                $consultancy[ 'user_id' ]                     = get_logged_in_user_id ();
                $consultancy[ 'charges' ]                     = -$_POST[ 'amount_paid_to_customer' ];
                $consultancy[ 'net_bill' ]                    = -$_POST[ 'amount_paid_to_customer' ];
                $consultancy[ 'flat_discount' ]               = -$consultancy[ 'flat_discount' ];
                $consultancy[ 'hospital_share' ]              = -$consultancy[ 'hospital_share' ];
                $consultancy[ 'hospital_discount' ]           = -$consultancy[ 'hospital_discount' ];
                $consultancy[ 'doctor_charges' ]              = -$consultancy[ 'doctor_charges' ];
                $consultancy[ 'doctor_discount' ]             = -$consultancy[ 'doctor_discount' ];
                $consultancy[ 'online_reference_commission' ] = $consultancy[ 'online_reference_commission' ] > 0 ? -$consultancy[ 'online_reference_commission' ] : 0;
                $consultancy[ 'refunded' ]                    = '1';
                $consultancy[ 'refund_reason' ]               = $_POST[ 'description' ];
                $new_consultancy_id                           = $this -> ConsultancyModel -> add ( $consultancy );
                $this -> ConsultancyModel -> edit ( array ( 'refunded' => '1' ), $consultancy_id );
//                $new_consultancy_id = $consultancy_id;
                
                $log = array (
                    'user_id'        => get_logged_in_user_id (),
                    'consultancy_id' => $_REQUEST[ 'consultancy_id' ],
                    'action'         => 'consultancy_refunded',
                    'log'            => json_encode ( $consultancy ),
                    'after_update'   => '',
                    'date_added'     => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                
                $description = 'Consultancy refunded. ID# ' . $consultancy_id;
                $commission  = 0;
                if ( $consultancy[ 'online_reference_id' ] > 0 ) {
                    $reference_id    = $consultancy[ 'online_reference_id' ];
                    $onlineReference = $this -> OnlineReferenceModel -> get_reference_by_id ( $reference_id );
                    
                    $description .= ' - Online Referral Portal - ' . $onlineReference -> title;
                    
                    if ( !empty( $onlineReference ) ) {
                        $commission = $net_charges * ( $onlineReference -> commission / 100 );
                        $ledger     = array (
                            'user_id'            => get_logged_in_user_id (),
                            'acc_head_id'        => $onlineReference -> account_head_id,
                            'opd_consultancy_id' => $new_consultancy_id,
                            'trans_date'         => date ( 'Y-m-d' ),
                            'payment_mode'       => 'cash',
                            'paid_via'           => 'cash',
                            'credit'             => $commission,
                            'debit'              => 0,
                            'transaction_type'   => 'credit',
                            'description'        => $description,
                            'date_added'         => current_date_time (),
                        );
                        $this -> AccountModel -> add_ledger ( $ledger );
                        
                        $ledger[ 'acc_head_id' ] = COS_Online_Referral_Portal;
                        $ledger[ 'credit' ]      = 0;
                        $ledger[ 'debit' ]       = $commission;
                        $this -> AccountModel -> add_ledger ( $ledger );
                    }
                }
                
                $cashAccountHead = cash_from_opd_consultancy;
                $consultancyInfo = $this -> ConsultancyModel -> get_consultancy_by_id ( $consultancy_id );
                if ( $consultancyInfo -> payment_method == 'card' )
                    $cashAccountHead = CARD;
                else if ( $consultancyInfo -> payment_method == 'bank' )
                    $cashAccountHead = $consultancyInfo -> account_head_id;
                
                $ledger[ 'user_id' ]            = get_logged_in_user_id ();
                $ledger[ 'acc_head_id' ]        = $cashAccountHead;
                $ledger[ 'opd_consultancy_id' ] = $new_consultancy_id;
                $ledger[ 'credit' ]             = '0';
                $ledger[ 'trans_date' ]         = date ( 'Y-m-d', strtotime ( $_POST[ 'date_added' ] ) );
                $ledger[ 'debit' ]              = $_POST[ 'amount_paid_to_customer' ];
                $ledger[ 'description' ]        = $description;
                $ledger[ 'date_added' ]         = date ( 'Y-m-d', strtotime ( $_POST[ 'date_added' ] ) ) . ' ' . date ( 'H:i:s' );
                
                if ( $patient -> panel_id > 0 ) {
                    $accHeadID               = get_account_head_id_by_panel_id ( $patient -> panel_id );
                    $ledger[ 'acc_head_id' ] = $accHeadID -> id;
                }
                $this -> AccountModel -> add_ledger ( $ledger );
                
                $doc_acc_head_id = get_doctor_linked_account_head_id ( $doctor_id );
                if ( $doc_acc_head_id > 0 ) {
                    $ledger = array (
                        'user_id'            => get_logged_in_user_id (),
                        'acc_head_id'        => $doc_acc_head_id,
                        'opd_consultancy_id' => $new_consultancy_id,
                        'trans_date'         => date ( 'Y-m-d' ),
                        'payment_mode'       => 'cash',
                        'paid_via'           => 'cash',
                        'credit'             => abs ( $consultancy[ 'doctor_charges' ] ),
                        'debit'              => 0,
                        'transaction_type'   => 'credit',
                        'description'        => $description,
                        'date_added'         => current_date_time (),
                    );
                    
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    $ledger[ 'acc_head_id' ]      = COS_Consultancy_Charges;
                    $ledger[ 'credit' ]           = 0;
                    $ledger[ 'transaction_type' ] = 'debit';
                    $ledger[ 'debit' ]            = abs ( $consultancy[ 'doctor_charges' ] );
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    $ledger = array (
                        'user_id'            => get_logged_in_user_id (),
                        'acc_head_id'        => $doc_acc_head_id,
                        'opd_consultancy_id' => $new_consultancy_id,
                        'trans_date'         => date ( 'Y-m-d' ),
                        'payment_mode'       => 'cash',
                        'paid_via'           => 'cash',
                        'credit'             => 0,
                        'debit'              => abs ( $consultancy[ 'doctor_discount' ] ),
                        'transaction_type'   => 'credit',
                        'description'        => $description,
                        'date_added'         => current_date_time (),
                    );
                    
                    $this -> AccountModel -> add_ledger ( $ledger );
                }
                
                $ledger[ 'acc_head_id' ]      = discount_consultancy_service;
                $ledger[ 'credit' ]           = 0;
                $ledger[ 'transaction_type' ] = 'debit';
                $ledger[ 'debit' ]            = abs ( $consultancy[ 'hospital_discount' ] );
                if ( $patient -> panel_id > 0 ) {
                    $ledger[ 'acc_head_id' ] = discount_consultancy_service_panel;
                }
                $this -> AccountModel -> add_ledger ( $ledger );
                
                $log = array (
                    'user_id'        => get_logged_in_user_id (),
                    'consultancy_id' => $_REQUEST[ 'consultancy_id' ],
                    'action'         => 'consultancy_refunded_ledger',
                    'log'            => json_encode ( $ledger ),
                    'after_update'   => '',
                    'date_added'     => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                
                $ledger[ 'acc_head_id' ]      = sales_consultancy_service;
                $ledger[ 'credit' ]           = $this -> input -> post ( 'net_charges' );
                $ledger[ 'debit' ]            = '0';
                $ledger[ 'transaction_type' ] = 'credit';
                $ledger[ 'description' ]      = $description;
                if ( $patient -> panel_id > 0 ) {
                    $ledger[ 'acc_head_id' ] = sales_consultancy_service_panel;
                }
                $this -> AccountModel -> add_ledger ( $ledger );
                $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                
                $this -> session -> set_flashdata ( 'response', 'Success! Consultancy refunded. <a href="' . base_url ( '/invoices/consultancy-invoice/' . $new_consultancy_id ) . '" target="_blank" style="font-weight: 800; font-size: 16px">Print</a>' );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
            return redirect ( base_url ( '/consultancy/index' ) );
        }
        
        public function get_patient () {
            $patient_id = $this -> input -> post ( 'patient_id' );
            if ( !empty( trim ( $patient_id ) ) and is_numeric ( $patient_id ) and $patient_id > 0 ) {
                $patient = $this -> PatientModel -> get_patient ( $patient_id );
                if ( !empty( $patient ) ) {
                    $array = array (
                        'name'          => get_patient_name ( 0, $patient ),
                        'cnic'          => $patient -> cnic,
                        'mobile'        => $patient -> mobile,
                        'panel_id'      => $patient -> panel_id == NULL ? 0 : $patient -> panel_id,
                        'city'          => @get_city_by_id ( $patient -> city ) -> title,
                        'gender'        => $patient -> gender == 1 ? 'Male' : 'Female',
                        'admission_no'  => get_ipd_admission_no ( $patient_id ),
                        'panel_patient' => ( $patient -> type == 'panel' ) ? 'yes' : 'no',
                        'panel'         => $patient -> panel_id > 0 ? get_panel_by_id ( $patient -> panel_id ) -> name : ''
                    );
                    echo json_encode ( $array );
                }
                else {
                    echo 'false';
                }
            }
            else {
                echo 'false';
            }
        }
        
        public function load_medical_department () {
            $panel_id = $this -> input -> post ( 'panel_id' );
            if ( !empty( trim ( $panel_id ) ) && $panel_id > 0 ) {
                $data[ 'specializations' ] = $this -> DoctorModel -> get_specializations_by_panel ( $panel_id );
                $this -> load -> view ( '/consultancy/medical-departments', $data );
            }
        }
        
        public function add_more_prescription_medications () {
            $data[ 'counter' ]      = $this -> input -> get ( 'counter' );
            $data[ 'instructions' ] = $this -> InstructionModel -> get_instructions ();
            $this -> load -> view ( '/consultancy/add-prescribe-medication', $data );
        }
        
        public function delete_prescription_medication ( $id ) {
            
            if ( empty( trim ( $id ) ) or !is_numeric ( $id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> ConsultancyModel -> delete_prescription_medication ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! Consultancy medication deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        public function prescriptions_follow_ups () {
            $title = site_name . ' - Consultancy Follow Ups';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'prescriptions' ] = $this -> ConsultancyModel -> get_prescriptions ();
            $data[ 'doctors' ]       = $this -> DoctorModel -> get_doctors ();
            $this -> load -> view ( '/consultancy/follow-ups', $data );
            $this -> footer ();
        }
        
        public function getPaymentMethodFields () {
            $data[ 'payment_method' ] = $this -> input -> get ( 'payment_method' );
            $data[ 'banks' ]          = $this -> AccountModel -> get_banks ( banks );
            $this -> load -> view ( '/consultancy/payment-method-fields', $data );
        }
        
        public function pay_consultant () {
            
            if ( $this -> input -> post ( 'action' ) == 'do_pay_consultant' )
                $this -> do_pay_consultant ();
            
            $title = site_name . ' - Pay Consultant';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $this -> load -> view ( '/consultancy/pay-consultant', $data );
            $this -> footer ();
        }
        
        public function get_doctor_daily_payable () {
            $doctor_id = $this -> input -> get ( 'doctor_id' );
            if ( $doctor_id > 0 ) {
                $consultancy_payable = $this -> ConsultancyModel -> get_doctor_daily_payable ( $doctor_id );
                $opd_payable         = $this -> OPDModel -> get_doctor_daily_payable ( $doctor_id );
                $lab_payable         = $this -> LabModel -> get_doctor_daily_payable ( $doctor_id );
                $info                = array (
                    'consultancy_payable' => max ( $consultancy_payable -> net, 0 ),
                    'opd_payable'         => max ( $opd_payable[ 'net' ], 0 ),
                    'lab_payable'         => max ( $lab_payable[ 'net' ], 0 ),
                    'total'               => ( $consultancy_payable -> net + $opd_payable[ 'net' ] + $lab_payable[ 'net' ] )
                );
                echo json_encode ( $info );
            }
            else {
                $info = array (
                    'consultancy_payable' => 0,
                    'opd_payable'         => 0,
                    'lab_payable'         => 0,
                    'total'               => 0
                );
                echo json_encode ( $info );
            }
        }
        
        public function do_pay_consultant () {
            $this -> form_validation -> set_rules ( 'doctor-id', 'doctor', 'required|numeric' );
            $this -> form_validation -> set_rules ( 'payment-mode', 'payment mode', 'required' );
            
            if ( $this -> form_validation -> run () ) {
                $doctor_id               = $this -> input -> post ( 'doctor-id' );
                $payment_mode            = $this -> input -> post ( 'payment-mode' );
                $consultancy_paid_amount = $this -> input -> post ( 'consultancy-paid-amount' );
                $opd_paid_amount         = $this -> input -> post ( 'opd-paid-amount' );
                $lab_paid_amount         = $this -> input -> post ( 'lab-paid-amount' );
                $description             = $this -> input -> post ( 'description' );
                $consultancy_payable     = $this -> ConsultancyModel -> get_doctor_daily_payable ( $doctor_id );
                $opd_payable             = $this -> OPDModel -> get_doctor_daily_payable ( $doctor_id );
                $lab_payable             = $this -> LabModel -> get_doctor_daily_payable ( $doctor_id );
                
                if ( $consultancy_paid_amount > $consultancy_payable -> net ) {
                    $this -> session -> set_flashdata ( 'error', 'Error! Consultancy paid amount cannot be greater than total payable.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                
                if ( $opd_paid_amount > $opd_payable[ 'net' ] ) {
                    $this -> session -> set_flashdata ( 'error', 'Error! OPD paid amount cannot be greater than total payable.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                
                if ( $lab_paid_amount > $lab_payable[ 'net' ] ) {
                    $this -> session -> set_flashdata ( 'error', 'Error! Lab paid amount cannot be greater than total payable.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                
                $this -> db -> trans_begin ();
                try {
                    
                    $voucher_no = $this -> AccountModel -> generate_voucher_number ( 'cpv' );
                    
                    if ( $consultancy_paid_amount > 0 )
                        $this -> AccountModel -> pay_consultant_consultancy ( $doctor_id, $consultancy_paid_amount, $payment_mode, $description, $voucher_no, $consultancy_payable );
                    
                    if ( $opd_paid_amount > 0 )
                        $this -> AccountModel -> pay_consultant_opd ( $doctor_id, $opd_paid_amount, $payment_mode, $description, $voucher_no, $opd_payable );
                    
                    if ( $lab_paid_amount > 0 )
                        $this -> AccountModel -> pay_consultant_lab ( $doctor_id, $lab_paid_amount, $payment_mode, $description, $voucher_no, $lab_payable );
                    
                    $this -> db -> trans_commit ();
                    
                    $response = '<a href="' . base_url ( '/invoices/voucher_transaction/' . $voucher_no ) . '" style="margin-left: 10px;text-decoration: underline;" target="_blank">Print Voucher</a><br>';
                    $this -> session -> set_flashdata ( 'response', 'Success! Consultant commission paid. Voucher No: ' . $voucher_no . $response );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                catch ( Exception $e ) {
                    $this -> db -> trans_rollback ();
                    $this -> session -> set_flashdata ( 'error', $e -> getMessage () );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
    }
