<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class IPD extends CI_Controller {
        
        /**
         * -------------------------
         * IPD constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'IPDModel' );
            $this -> load -> model ( 'OPDModel' );
            $this -> load -> model ( 'DoctorModel' );
            $this -> load -> model ( 'LabModel' );
            $this -> load -> model ( 'InstructionModel' );
            $this -> load -> model ( 'MedicineModel' );
            $this -> load -> model ( 'AccountModel' );
            $this -> load -> model ( 'PanelModel' );
            $this -> load -> model ( 'RoomModel' );
            $this -> load -> model ( 'ReferenceModel' );
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
         * sale ipd service main page
         * -------------------------
         */
        
        public function sale () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_sale_service' )
                $this -> do_sale_service ( $_POST );
            
            $title = site_name . ' - Sale Service';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'services' ] = $this -> IPDModel -> get_parent_services ();
            $this -> load -> view ( '/ipd/sale', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * get company panels
         * -------------------------
         */
        
        public function get_company_panels () {
            $company_id = $this -> input -> post ( 'company_id', true );
            if ( isset( $company_id ) and $company_id > 0 ) {
                $data[ 'panels' ] = $this -> IPDModel -> get_company_panels ( $company_id );
                $this -> load -> view ( '/patients/panels', $data );
            }
        }
        
        /**
         * -------------------------
         * get service parameters
         * -------------------------
         */
        
        public function get_service_parameters () {
            $service_id = $this -> input -> post ( 'service_id', true );
            $added      = $this -> input -> post ( 'added', true );
            $patient_id = $this -> input -> post ( 'patient_id', true );
            if ( isset( $service_id ) and $service_id > 0 ) {
                
                $patient = get_patient_by_id ( $patient_id );
                if ( $patient -> type == 'panel' )
                    $discount = $this -> IPDModel -> get_patient_discount ( $service_id, $patient -> panel_id );
                else
                    $discount = 0;
                
                $data[ 'row' ]               = $added;
                $data[ 'service' ]           = $this -> IPDModel -> get_service_by_id ( $service_id );
                $data[ 'doctors' ]           = $this -> DoctorModel -> get_doctors ();
                $data[ 'discount' ]          = $discount;
                $data[ 'anesthesiologists' ] = $this -> DoctorModel -> get_anesthesiologists ();
                $this -> load -> view ( '/ipd/service-parameters', $data );
            }
            else
                echo 'false';
        }
        
        /**
         * -------------------------
         * add more sale ipd service
         * -------------------------
         */
        
        public function add_more_sale_services () {
            $data[ 'panel_id' ] = $_POST[ 'panel_id' ];
            $data[ 'services' ] = $this -> IPDModel -> get_parent_services ( $data[ 'panel_id' ] );
            $data[ 'row' ]      = $_POST[ 'added' ];
            $this -> load -> view ( '/ipd/add_more_sale_services', $data );
        }
        
        /**
         * -------------------------
         * @param $POST
         * sale service
         * register patient
         * -------------------------
         */
        
        public function do_sale_service ( $POST ) {
            $data       = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $patient_id = $data[ 'patient_id' ];
            $purpose    = $data[ 'purpose' ];
            $package_id = $this -> input -> post ( 'package-id' );
            $patient    = get_patient_by_id ( $patient_id );
            
            $info = array (
                'user_id'         => get_logged_in_user_id (),
                'total'           => 0,
                'discount'        => 0,
                'initial_deposit' => 0,
                'net_total'       => 0,
                'tax'             => 0,
                'date_added'      => current_date_time (),
            );
            
            if ( !empty( $patient ) && $patient -> panel_id > 0 ) {
                $panel         = get_panel_by_id ( $patient -> panel_id );
                $info[ 'tax' ] = max ( $panel -> tax, 0 );
            }
            
            $sale_id = $this -> IPDModel -> sale_service ( $info );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'patient_id'   => $patient_id,
                'sale_id'      => $sale_id,
                'action'       => 'ipd_sale_added',
                'log'          => json_encode ( $info ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
            
            /***********END LOG*************/
            
            $patient = array (
                'sale_id'    => $sale_id,
                'patient_id' => $patient_id,
                'purpose'    => $purpose,
                'date_added' => current_date_time (),
            );
            $this -> IPDModel -> add_patient_info ( $patient );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'patient_id'   => $patient_id,
                'sale_id'      => $sale_id,
                'action'       => 'ipd_patient_added',
                'log'          => json_encode ( $patient ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
            
            /***********END LOG*************/
            
            $slip = array (
                'user_id'        => get_logged_in_user_id (),
                'patient_id'     => $patient_id,
                'sale_id'        => $sale_id,
                'doctor_id'      => '',
                'panel_pvt'      => '',
                'room_id'        => 0,
                'bed_id'         => 0,
                'package_id'     => $package_id,
                'admission_no'   => $sale_id,
                'admission_date' => date ( 'Y-m-d' ),
                'contact_no'     => '',
                'date_added'     => current_date_time (),
            );
            
            $this -> IPDModel -> do_update_admission_slip ( $slip, $sale_id );
            
            // $this -> IPDModel -> update_patient_mo_order_info($sale_id, $patient_id);
            $this -> session -> set_flashdata ( 'response', 'Success! Patient registered into IPD' );
            return redirect ( base_url ( '/IPD/edit-sale/?sale_id=' . $sale_id . '&tab=admission-slip' ) );
        }
        
        /**
         * -------------------------
         * get doctor percentage
         * by doctor and service id
         * -------------------------
         */
        
        public function get_doctor_percentage_value_by_service_id () {
            $service_id = $_POST[ 'service_id' ];
            $doctor_id  = $_POST[ 'doctor_id' ];
            if ( isset( $service_id ) and $service_id > 0 and isset( $doctor_id ) and $doctor_id > 0 ) {
                $percentage = $this -> DoctorModel -> get_doctor_percentage_value_by_service_id ( $service_id, $doctor_id );
                echo $percentage;
            }
        }
        
        /**
         * -------------------------
         * all sales
         * which are not yet discharged
         * -------------------------
         */
        
        public function sales () {
            $title = site_name . ' - IPD Invoices (Cash)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'discharged' ] = false;
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( '/IPD/sales' );
            $total_row                      = $this -> IPDModel -> count_sales ();
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
            
            $data[ 'doctors' ]  = $this -> DoctorModel -> get_doctors ();
            $data[ 'services' ] = $this -> IPDModel -> get_all_services ();
            $data[ 'sales' ]    = $this -> IPDModel -> get_sales ( $config[ "per_page" ], $offset );
            $str_links          = $this -> pagination -> create_links ();
            $data[ "links" ]    = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/ipd/sales', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * all sales
         * which are not yet discharged
         * -------------------------
         */
        
        public function panel_sales () {
            $title = site_name . ' - IPD Invoices (Panel)';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( '/IPD/panel-sales' );
            $total_row                      = $this -> IPDModel -> count_panel_sales ();
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
            
            $data[ 'discharged' ] = false;
            $data[ 'sales' ]      = $this -> IPDModel -> get_panel_sales ( $config[ "per_page" ], $offset );
            $data[ 'doctors' ]    = $this -> DoctorModel -> get_doctors ();
            $data[ 'services' ]   = $this -> IPDModel -> get_parent_services ();
            $data[ 'panels' ]     = $this -> PanelModel -> get_panels ();
            $str_links            = $this -> pagination -> create_links ();
            $data[ "links" ]      = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/ipd/panel_sales', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * delete sale
         * by Invoice ID
         * -------------------------
         */
        
        public function delete_sale () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $sale_id ) ) and is_numeric ( $sale_id ) and $sale_id > 0 ) {
                
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => 0,
                    'sale_id'      => $sale_id,
                    'action'       => 'ipd_sale_deleted',
                    'log'          => json_encode ( $sale_id ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                
                /***********END LOG*************/
                
                $this -> IPDModel -> delete_sale ( $sale_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Sale has been deleted' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * edit sale
         * by Invoice ID
         * -------------------------
         */
        
        public function edit_sale () {
            
            $sale_id          = @$_REQUEST[ 'sale_id' ];
            $printLabSelected = @$_POST[ 'print-lab-selected' ];
            
            if ( isset( $printLabSelected ) and count ( @$printLabSelected ) > 0 ) {
                $ids = implode ( ',', $printLabSelected );
                return redirect ( base_url ( '/invoices/ipd-lab-tests?sale_id=' . $_REQUEST[ 'sale_id' ] . '&ids=' . $ids ) );
            }
            
            if ( !isset( $sale_id ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale' ] = $this -> IPDModel -> get_sale_info ( $sale_id );
            if ( isset( $_GET[ 'action' ] ) && $_GET[ 'action' ] === 'update-billing' && $data[ 'sale' ] -> discharged == '1' ) {
                $this -> update_ipd_ledger ( $data[ 'sale' ] );
            }
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_patient' )
                $this -> do_edit_patient ( $_POST );
            
            if ( isset( $_GET[ 'action' ] ) and $_GET[ 'action' ] == 'clear-sale' )
                $this -> clear_medicine_sale ();
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_admission_slip' )
                $this -> do_update_admission_slip ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_ipd_services' )
                $this -> do_add_ipd_services ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_opd_services' )
                $this -> do_add_opd_services ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_ipd_lab_tests' )
                $this -> do_add_ipd_lab_tests ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_ipd_requisitions' )
                $this -> do_add_ipd_requisitions ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_ipd_medication' )
                $this -> do_add_ipd_medication ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_ipd_billing' )
                $this -> do_update_ipd_billing ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_ipd_sale_payment' )
                $this -> do_add_ipd_sale_payment ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_discharge_date' )
                $this -> do_update_discharge_date ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_ipd_consultants' )
                $this -> do_add_ipd_consultants ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_ipd_anesthesia_charges' )
                $this -> do_add_ipd_anesthesia_charges ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_ot_timings' )
                $this -> do_update_ot_timings ( $_POST );
            
            if ( isset( $_REQUEST[ 'discharge' ] ) and $_REQUEST[ 'discharge' ] == 'true' )
                $this -> do_discharge_patient ();
            
            if ( isset( $_REQUEST[ 'status' ] ) and $_REQUEST[ 'status' ] == 'seen' )
                $this -> do_update_requisition_status ( $_REQUEST[ 'sale_id' ] );
            
            $title = site_name . ' - Edit Sale';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'patient' ]      = get_patient ( $data[ 'sale' ] -> patient_id );
            $data[ 'services' ]     = $this -> IPDModel -> get_parent_services ( $data[ 'patient' ] -> panel_id );
            $data[ 'sale_billing' ] = $this -> IPDModel -> get_sale_billing_info ( $sale_id );
            
            if ( isset( $_GET[ 'tab' ] ) && $_GET[ 'tab' ] == 'ipd-services-excluded' )
                $data[ 'ipd_associated_services' ] = $this -> IPDModel -> get_patient_ipd_associated_services ( $sale_id, '0' );
            else
                $data[ 'ipd_associated_services' ] = $this -> IPDModel -> get_patient_ipd_associated_services ( $sale_id );
            
            $data[ 'ipd_associated_services_net_price' ] = $this -> IPDModel -> get_patient_ipd_associated_services_total_price ( $sale_id );
            $data[ 'doctors' ]                           = $this -> DoctorModel -> get_doctors_not_in_ipd_sale ( $sale_id );
            $data[ 'active_doctors' ]                    = $this -> DoctorModel -> get_doctors ();
            $data[ 'opd_services' ]                      = $this -> OPDModel -> get_all_services ();
            $data[ 'opd_associated_services' ]           = $this -> IPDModel -> get_patient_opd_associated_services ( $sale_id );
            $data[ 'lab_tests' ]                         = $this -> LabModel -> get_active_parent_tests ( $data[ 'patient' ] -> panel_id );
            $data[ 'ot_timings' ]                        = $this -> IPDModel -> get_ot_timings ( $sale_id );
            
            // PAGINATION FOR IPD LAB TESTS
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( '/IPD/edit-sale/?sale_id=' . $sale_id . '&tab=lab-tests&inner-tab=view' );
            $total_row                      = $this -> IPDModel -> count_ipd_patient_tests_without_parent ( $sale_id );
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
            
            if ( isset( $_REQUEST[ 'per_page' ] ) and $_REQUEST[ 'per_page' ] > 0 ) {
                $offset = $_REQUEST[ 'per_page' ];
            }
            else {
                $offset = 0;
            }
            // END PAGINATION FOR IPD LAB TESTS
            
            $data[ 'ipd_lab_tests' ] = $this -> IPDModel -> get_ipd_patient_tests_without_parent ( $sale_id, $config[ "per_page" ], $offset );
            $str_links               = $this -> pagination -> create_links ();
            $data[ "links" ]         = explode ( '&nbsp;', $str_links );
            
            $data[ 'ipd_lab_tests_net_price' ]     = $this -> IPDModel -> get_ipd_patient_tests_net_price ( $sale_id );
            $data[ 'medicines' ]                   = $this -> MedicineModel -> get_medicines_that_has_stock ();
            $data[ 'medication' ]                  = $this -> IPDModel -> get_ipd_patient_medication ( $sale_id );
            $data[ 'requisitions' ]                = $this -> IPDModel -> get_ipd_requisitions ( $sale_id );
            $data[ 'total_ipd_services' ]          = $this -> IPDModel -> total_ipd_services ( $sale_id );
            $data[ 'total_ipd_services_included' ] = $this -> IPDModel -> total_ipd_services_included ( $sale_id );
            $data[ 'total_ipd_services_excluded' ] = $this -> IPDModel -> total_ipd_services_excluded ( $sale_id );
            $data[ 'total_opd_services' ]          = $this -> IPDModel -> total_opd_services ( $sale_id );
            $data[ 'total_lab_services' ]          = $this -> IPDModel -> total_lab_services ( $sale_id );
            $data[ 'total_medication' ]            = $this -> IPDModel -> total_medication ( $sale_id );
            $data[ 'admission_slip' ]              = $this -> IPDModel -> get_admission_slip ( $sale_id );
            $data[ 'payments' ]                    = $this -> IPDModel -> get_ipd_payments ( $sale_id );
            $data[ 'count_payment' ]               = $this -> IPDModel -> count_payment ( $sale_id );
            $data[ 'consultants' ]                 = $this -> IPDModel -> get_consultants ( $sale_id );
            $data[ 'rooms' ]                       = $this -> RoomModel -> get_rooms ();
            $data[ 'packages' ]                    = $this -> IPDModel -> get_packages ();
            $data[ 'references' ]                  = $this -> ReferenceModel -> get_references ();
            $data[ 'anesthesiologists' ]           = $this -> DoctorModel -> get_anesthesiologists_not_in_ipd_sale ( $sale_id );
            $data[ 'anesthesia_services' ]         = $this -> IPDModel -> get_anesthesia_services ();
            $data[ 'anesthesia_charges' ]          = $this -> IPDModel -> get_anesthesia_charges ( $sale_id );
            $this -> load -> view ( '/ipd/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * clear medicine sale
         * -------------------------
         */
        
        public function clear_medicine_sale () {
            $user_id = get_logged_in_user_id ();
            $this -> MedicineModel -> clear_medicine_sale ( $user_id );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @param $POST
         * sale service
         * edit patient
         * -------------------------
         */
        
        public function do_edit_patient ( $POST ) {
            $data    = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $purpose = $data[ 'purpose' ];
            $sale_id = $data[ 'sale_id' ];
            
            $patient = array (
                'purpose' => $purpose,
            );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'patient_id'   => $this -> IPDModel -> get_sale_info ( $sale_id ) -> patient_id,
                'sale_id'      => $sale_id,
                'action'       => 'ipd_patient_updated',
                'log'          => json_encode ( $this -> IPDModel -> get_sale_info ( $sale_id ) ),
                'after_update' => json_encode ( $patient ),
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
            
            /***********END LOG*************/
            
            $this -> IPDModel -> do_edit_patient ( $patient, $sale_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Patient profile updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @param $POST
         * sale service
         * edit admission slip
         * -------------------------
         */
        
        public function do_update_admission_slip ( $POST ) {
            $data           = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $patient_id     = $data[ 'patient_id' ];
            $sale_id        = $data[ 'sale_id' ];
            $panel_pvt      = $data[ 'panel_pvt' ];
            $room_id        = $data[ 'room-id' ];
            $bed_id         = $data[ 'bed-id' ];
            $doctor_id      = $data[ 'doctor_id' ];
            $package_id     = $this -> input -> post ( 'package-id' );
            $admission_no   = $data[ 'admission_no' ];
            $admission_date = $data[ 'admission_date' ];
            $contact_no     = $data[ 'contact_no' ];
            $remarks        = $data[ 'remarks' ];
            $package        = $data[ 'package' ];
            $admitted_to    = $data[ 'admitted_to' ];
            $visit_no       = $data[ 'visit-no' ];
            
            $admissionSlip = $this -> IPDModel -> get_admission_slip ( $sale_id );
            if ( $admissionSlip -> bed_id !== $data[ 'bed-id' ] )
                $this -> RoomModel -> release_bed ( $admissionSlip -> bed_id );
            
            $slip = array (
                'user_id'        => get_logged_in_user_id (),
                'patient_id'     => $patient_id,
                'sale_id'        => $sale_id,
                'reference_id'   => $this -> input -> post ( 'reference-id' ),
                'doctor_id'      => $doctor_id,
                'panel_pvt'      => $panel_pvt,
                'package'        => $package,
                'room_id'        => $room_id,
                'bed_id'         => $bed_id,
                'admission_no'   => $admission_no,
                'admission_date' => date ( 'Y-m-d', strtotime ( $admission_date ) ),
                'contact_no'     => $contact_no,
                'admitted_to'    => $admitted_to,
                'visit_no'       => $visit_no,
                'remarks'        => $remarks,
                'date_added'     => current_date_time (),
            );
            
            if ( isset( $package_id ) && !empty( trim ( $package_id ) ) && $package_id > 0 )
                $slip[ 'package_id' ] = $package_id;
            
            //$this -> IPDModel -> delete_admission_slip($sale_id);
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'patient_id'   => $patient_id,
                'sale_id'      => $sale_id,
                'action'       => 'ipd_admission_slip_updated',
                'log'          => json_encode ( $this -> IPDModel -> get_admission_slip ( $sale_id ) ),
                'after_update' => json_encode ( $slip ),
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
            
            /***********END LOG*************/
            
            $this -> IPDModel -> do_update_admission_slip ( $slip, $sale_id );
            
            if ( isset( $package_id ) && $package_id > 0 )
                $this -> add_package_services ( $package_id );
            
            if ( isset( $bed_id ) && $bed_id > 0 )
                $this -> RoomModel -> mark_bed_occupied ( $bed_id );
            
            $this -> session -> set_flashdata ( 'response', 'Success! Patient admission slip updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @param $POST
         * sale service
         * add/update patient associated services
         * -------------------------
         */
        
        public function do_add_ipd_services ( $POST ) {
            $data                 = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $sale_id              = $data[ 'sale_id' ];
            $patient_id           = $data[ 'patient_id' ];
            $services             = $data[ 'service_id' ];
            $ipd_service_id       = @$data[ 'ipd_service_id' ];
            $deleted_ipd_services = $data[ 'deleted_ipd_services' ];
            
            if ( isset( $deleted_ipd_services ) and !empty( trim ( $deleted_ipd_services ) ) ) {
                $ids = explode ( ',', $deleted_ipd_services );
                $this -> IPDModel -> delete_ipd_patient_associated_services ( implode ( ',', array_filter ( $ids ) ) );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $patient_id,
                    'sale_id'      => $sale_id,
                    'action'       => 'ipd_sale_services_deleted',
                    'log'          => json_encode ( $ids ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                
                /***********END LOG*************/
                
            }
            
            if ( isset( $_GET[ 'tab' ] ) && $_GET[ 'tab' ] == 'ipd-services-excluded' )
                $included = '0';
            else
                $included = '1';
            
            if ( isset( $services ) and count ( $services ) > 0 ) {
                //$this -> IPDModel -> delete_ipd_patient_associated_services($sale_id);
                foreach ( $services as $key => $value ) {
                    if ( !empty( $value ) and $value > 0 ) {
                        $ipd_info = get_ipd_service_by_id ( $value );
                        if ( isset( $ipd_service_id[ $key ] ) ) {
                            $associated_service = array (
                                'user_id'           => get_logged_in_user_id (),
                                'parent_id'         => get_service_parent_id ( $value ),
                                'service_id'        => $value,
                                'doctor_id'         => $data[ 'doctor_id' ][ $key ],
                                'price'             => $ipd_info -> price,
                                'charge_per'        => $data[ 'charge_per' ][ $key ],
                                'charge_per_value'  => $data[ 'charge_per_value' ][ $key ],
                                'doctor_discount'   => $data[ 'doctor_discount' ][ $key ],
                                'hospital_discount' => $data[ 'hospital_discount' ][ $key ],
                                'net_price'         => $data[ 'net_price' ][ $key ],
                                'included'          => $included
                            );
                            $this -> IPDModel -> update_assigned_services_to_patient_info ( $associated_service, $ipd_service_id[ $key ] );
                            
                            /***********LOGS*************/
                            
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'patient_id'   => $patient_id,
                                'sale_id'      => $sale_id,
                                'action'       => 'ipd_sale_services_updated',
                                'log'          => json_encode ( $associated_service ),
                                'after_update' => '',
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                            
                            /***********END LOG*************/
                            
                        }
                        else {
                            $associated_service = array (
                                'user_id'           => get_logged_in_user_id (),
                                'sale_id'           => $sale_id,
                                'patient_id'        => $patient_id,
                                'parent_id'         => get_service_parent_id ( $value ),
                                'service_id'        => $value,
                                'doctor_id'         => $data[ 'doctor_id' ][ $key ],
                                'price'             => $ipd_info -> price,
                                'charge_per'        => $data[ 'charge_per' ][ $key ],
                                'charge_per_value'  => $data[ 'charge_per_value' ][ $key ],
                                'doctor_discount'   => $data[ 'doctor_discount' ][ $key ],
                                'hospital_discount' => $data[ 'hospital_discount' ][ $key ],
                                'net_price'         => $data[ 'net_price' ][ $key ],
                                'included'          => $included,
                                'date_added'        => current_date_time (),
                            );
                            $this -> IPDModel -> assign_services_to_patient_info ( $associated_service );
                            
                            /***********LOGS*************/
                            
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'patient_id'   => $patient_id,
                                'sale_id'      => $sale_id,
                                'action'       => 'ipd_sale_services_added',
                                'log'          => json_encode ( $associated_service ),
                                'after_update' => '',
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                            
                            /***********END LOG*************/
                            
                        }
                    }
                }
                
                $info = array (
                    'total'           => get_ipd_total ( $sale_id ),
                    'discount'        => $data[ 'discount' ],
                    'initial_deposit' => $data[ 'initial_deposit' ],
                    'net_total'       => get_ipd_total ( $sale_id ),
                );
                $this -> IPDModel -> update_sale_total ( $info, $sale_id );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $patient_id,
                    'sale_id'      => $sale_id,
                    'action'       => 'ipd_sale_total_updated',
                    'log'          => json_encode ( $info ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                
                /***********END LOG*************/
                
            }
            $this -> session -> set_flashdata ( 'response', 'Success! IPD Services added.   <a href="' . base_url () . '/invoices/ipd-invoice-customer?sale_id=' . $sale_id . '" target="_blank" style="font-weight: 800;">Print</a>' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * add more sale service main page
         * -------------------------
         */
        
        public function add_more_opd_sale_services_for_ipd () {
            $data[ 'row' ]      = $this -> input -> post ( 'added', true );
            $data[ 'services' ] = $this -> OPDModel -> get_all_services ();
            $this -> load -> view ( '/ipd/add-more-opd-services', $data );
        }
        
        /**
         * -------------------------
         * @param $POST
         * sale opd service
         * -------------------------
         */
        
        public function do_add_opd_services ( $POST ) {
            $data       = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $service_id = $data[ 'service_id' ];
            $sale_id    = $data[ 'sale_id' ];
            $patient_id = $data[ 'patient_id' ];
            
            if ( isset( $service_id ) and count ( $service_id ) > 0 ) {
                $this -> IPDModel -> delete_opd_patient_associated_services ( $sale_id );
                foreach ( $service_id as $key => $value ) {
                    if ( $value > 0 and !empty( $value ) ) {
                        $info = array (
                            'user_id'    => get_logged_in_user_id (),
                            'patient_id' => $patient_id,
                            'sale_id'    => $sale_id,
                            'service_id' => $value,
                            'price'      => $data[ 'price' ][ $key ],
                            'discount'   => $data[ 'opd_discount' ][ $key ],
                            'net_price'  => $data[ 'net_bill' ][ $key ],
                            'date_added' => current_date_time (),
                        );
                        $this -> IPDModel -> add_opd_sale_service ( $info );
                        
                        /***********LOGS*************/
                        
                        $log = array (
                            'user_id'      => get_logged_in_user_id (),
                            'patient_id'   => $patient_id,
                            'sale_id'      => $sale_id,
                            'action'       => 'ipd_sale_opd_services_added',
                            'log'          => json_encode ( $info ),
                            'after_update' => '',
                            'date_added'   => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                        
                        /***********END LOG*************/
                        
                    }
                }
                
                $info = array (
                    'total'           => $data[ 'total' ],
                    'discount'        => $data[ 'discount' ],
                    'initial_deposit' => $data[ 'initial_deposit' ],
                    'net_total'       => $data[ 'net_total' ],
                );
                $this -> IPDModel -> update_sale_total ( $info, $sale_id );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $patient_id,
                    'sale_id'      => $sale_id,
                    'action'       => 'ipd_sale_total_updated',
                    'log'          => json_encode ( $info ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! OPD Services added.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            
            $this -> session -> set_flashdata ( 'error', 'Error! No service selected.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * get test price
         * by test id
         * -------------------------
         */
        
        public function get_test_price () {
            $test_id  = $_POST[ 'test_id' ];
            $panel_id = $_POST[ 'panel_id' ];
            if ( isset( $test_id ) and $test_id > 0 ) {
                if ( $panel_id > 0 )
                    $price = get_test_price_panel_id ( $test_id, $panel_id );
                else
                    $price = get_regular_test_price ( $test_id );
                if ( !empty( $price ) )
                    echo $price -> price;
                else
                    echo '0';
            }
            else
                echo 'false';
        }
        
        /**
         * -------------------------
         * add more sale service main page
         * -------------------------
         */
        
        public function add_more_ipd_sale_test () {
            $data[ 'row' ]       = $this -> input -> post ( 'added', true );
            $data[ 'panel_id' ]  = $this -> input -> post ( 'panel_id', true );
            $data[ 'lab_tests' ] = $this -> LabModel -> get_active_parent_tests ( $data[ 'panel_id' ] );
            $this -> load -> view ( '/ipd/add-more-tests', $data );
        }
        
        /**
         * -------------------------
         * @param $POST
         * sale ipd lab tests
         * -------------------------
         */
        
        public function do_add_ipd_lab_tests ( $POST ) {
            $data                  = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $tests                 = @$data[ 'test_id' ];
            $sale_id               = @$data[ 'sale_id' ];
            $patient_id            = @$data[ 'patient_id' ];
            $ipd_lab_test_id       = @$data[ 'ipd_lab_test_id' ];
            $deleted_ipd_lab_tests = @$data[ 'deleted_ipd_lab_tests' ];
            $patient               = get_patient ( $patient_id );
            
            if ( isset( $deleted_ipd_lab_tests ) and !empty( trim ( $deleted_ipd_lab_tests ) ) ) {
                $ids = explode ( ',', $deleted_ipd_lab_tests );
                $this -> IPDModel -> delete_ipd_patient_associated_tests ( implode ( ',', array_filter ( $ids ) ), $sale_id );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $patient_id,
                    'sale_id'      => $sale_id,
                    'action'       => 'ipd_sale_lat_test_deleted',
                    'log'          => json_encode ( $ids ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                
                /***********END LOG*************/
                
            }
            //$this -> IPDModel -> delete_ipd_patient_associated_tests($sale_id);
            if ( isset( $tests ) and count ( $tests ) > 0 ) {
                foreach ( $tests as $key => $value ) {
                    if ( $value > 0 and !empty( $value ) ) {
                        if ( $patient -> panel_id > 0 ) {
                            $test_price = get_test_price_panel_id ( $value, $patient -> panel_id );
                            if ( !empty( $test_price ) )
                                $test_price = $test_price -> price;
                        }
                        else {
                            $test_price = get_lab_test_price ( $value );
                        }
                        $sub_tests = $this -> LabModel -> get_active_child_tests ( $value );
                        
                        if ( isset( $ipd_lab_test_id[ $key ] ) ) {
                            $info = array (
                                'user_id'   => get_logged_in_user_id (),
                                'test_id'   => $value,
                                'price'     => $test_price,
                                'discount'  => $data[ 'test_discount' ][ $key ],
                                'net_price' => $test_price - ( $test_price * ( $data[ 'test_discount' ][ $key ] / 100 ) ),
                            );
                            $this -> IPDModel -> update_added_test_sale_service ( $info, $ipd_lab_test_id[ $key ] );
                            
                            /***********LOGS*************/
                            
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'patient_id'   => $patient_id,
                                'sale_id'      => $sale_id,
                                'action'       => 'ipd_sale_lab_test_updated',
                                'log'          => json_encode ( $info ),
                                'after_update' => '',
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                            
                            /***********END LOG*************/
                            
                        }
                        else {
                            $info = array (
                                'user_id'    => get_logged_in_user_id (),
                                'patient_id' => $patient_id,
                                'sale_id'    => $sale_id,
                                'test_id'    => $value,
                                'price'      => $test_price,
                                'discount'   => $data[ 'test_discount' ][ $key ],
                                'net_price'  => $test_price - ( $test_price * ( $data[ 'test_discount' ][ $key ] / 100 ) ),
                                'date_added' => current_date_time (),
                            );
                            $this -> IPDModel -> add_test_sale_service ( $info );
                            foreach ( $sub_tests as $sub_test ) {
                                $subTests[ 'test_id' ] = $sub_test -> id;
                                $subTests              = array (
                                    'user_id'    => get_logged_in_user_id (),
                                    'patient_id' => $patient_id,
                                    'sale_id'    => $sale_id,
                                    'parent_id'  => $value,
                                    'test_id'    => $sub_test -> id,
                                    'price'      => 0,
                                    'discount'   => 0,
                                    'net_price'  => 0,
                                    'date_added' => current_date_time (),
                                );
                                $this -> IPDModel -> add_test_sale_service ( $subTests );
                                
                            }
                            
                            /***********LOGS*************/
                            
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'patient_id'   => $patient_id,
                                'sale_id'      => $sale_id,
                                'action'       => 'ipd_sale_lab_test_added',
                                'log'          => json_encode ( $info ),
                                'after_update' => '',
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                            
                            /***********END LOG*************/
                            
                        }
                    }
                }
                
                $info = array (
                    'total'           => get_ipd_total ( $sale_id ),
                    'discount'        => $data[ 'discount' ],
                    'initial_deposit' => $data[ 'initial_deposit' ],
                    'net_total'       => get_ipd_total ( $sale_id ),
                );
                $this -> IPDModel -> update_sale_total ( $info, $sale_id );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $patient_id,
                    'sale_id'      => $sale_id,
                    'action'       => 'ipd_sale_total_updated',
                    'log'          => json_encode ( $info ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Lab Test(s) added.  <a href="' . base_url () . '/invoices/ipd-invoice-customer?sale_id=' . $sale_id . '" target="_blank" style="font-weight: 800;">Print</a>' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * get medicine stock
         * check expiry date and status
         * -------------------------
         */
        
        public function get_stock () {
            $data        = filter_var_array ( $_POST, FILTER_SANITIZE_STRING );
            $medicine_id = $data[ 'medicine_id' ];
            $selected    = $data[ 'selected' ];
            $row         = $data[ 'row' ];
            if ( !empty( trim ( $medicine_id ) ) and is_numeric ( $medicine_id ) > 0 ) {
                $data[ 'stock' ]    = $this -> MedicineModel -> get_medicine_stock ( $medicine_id );
                $data[ 'row' ]      = $row;
                $data[ 'selected' ] = $selected;
                $this -> load -> view ( '/ipd/stock-dropdown', $data );
            }
            else {
                echo 'false';
            }
        }
        
        /**
         * -------------------------
         * add more sales input fields
         * -------------------------
         */
        
        public function add_more_medication_sale () {
            $data[ 'added' ]     = $this -> input -> post ( 'added' );
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines_that_has_stock ();
            $this -> load -> view ( '/ipd/sale-more-medicine', $data );
        }
        
        /**
         * -------------------------
         * add more sales input fields
         * -------------------------
         */
        
        public function add_more_consultants () {
            $panel_id = 0;
            $patient  = get_patient_by_id ( $this -> input -> post ( 'patient_id' ) );
            
            if ( $patient -> panel_id > 0 )
                $panel_id = $patient -> panel_id;
            
            $data[ 'added' ]    = $this -> input -> post ( 'added' );
            $data[ 'doctors' ]  = $this -> DoctorModel -> get_doctors ();
            $data[ 'services' ] = $this -> IPDModel -> get_parent_services ( $panel_id );
            $this -> load -> view ( '/ipd/add-more-consultants', $data );
        }
        
        /**
         * -------------------------
         * add more sales input fields
         * -------------------------
         */
        
        public function add_more_ipd_requisitions () {
            $data[ 'added' ]     = $this -> input -> post ( 'added' );
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines_that_has_stock ();
            $this -> load -> view ( '/ipd/add-more-requisitions', $data );
        }
        
        /**
         * -------------------------
         * @param $POST
         * sale ipd medications
         * -------------------------
         */
        
        public function do_add_ipd_medication ( $POST ) {
            $data               = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $medicines          = $data[ 'medicine_id' ];
            $sale_id            = $data[ 'sale_id' ];
            $patient_id         = $data[ 'patient_id' ];
            $medication_id      = @$data[ 'medication_id' ];
            $deleted_medication = $data[ 'deleted_medication' ];
            
            $this -> MedicineModel -> clear_medicine_sale ( get_logged_in_user_id () );
            
            if ( isset( $deleted_medication ) and !empty( trim ( $deleted_medication ) ) ) {
                $deletedMedicationRecord = $this -> IPDModel -> getIPDMedicationByID ( $deleted_medication );
                $ids                     = explode ( ',', $deleted_medication );
                $this -> IPDModel -> delete_ipd_patient_medication ( implode ( ',', array_filter ( $ids ) ) );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $patient_id,
                    'sale_id'      => $sale_id,
                    'action'       => 'ipd_sale_medication_deleted',
                    'log'          => json_encode ( $deletedMedicationRecord ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                
                /***********END LOG*************/
                
            }
            
            if ( isset( $medicines ) and count ( $medicines ) > 0 ) {
                foreach ( $medicines as $key => $value ) {
                    if ( !empty( trim ( $value ) ) and $value > 0 and $data[ 'stock_id' ][ $key ] > 0 and $data[ 'quantity' ][ $key ] > 0 ) {
                        $stock_info  = get_stock ( $data[ 'stock_id' ][ $key ] );
                        $medicine_id = $value;
                        $stock_id    = $data[ 'stock_id' ][ $key ];
                        $quantity    = $data[ 'quantity' ][ $key ];
                        $price       = $stock_info -> sale_unit;
                        $net_price   = $quantity * $price;
                        if ( isset( $medication_id[ $key ] ) ) {
                            $info = array (
                                'quantity'  => $quantity,
                                'price'     => $price,
                                'net_price' => $net_price,
                            );
                            $this -> IPDModel -> update_sale_medicine ( $info, $medication_id[ $key ] );
                            
                            /***********LOGS*************/
                            
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'patient_id'   => $patient_id,
                                'sale_id'      => $sale_id,
                                'action'       => 'ipd_sale_medication_updated',
                                'log'          => json_encode ( $info ),
                                'after_update' => '',
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                            
                            /***********END LOG*************/
                            
                        }
                        else {
                            $info = array (
                                'user_id'     => get_logged_in_user_id (),
                                'sale_id'     => $sale_id,
                                'medicine_id' => $medicine_id,
                                'patient_id'  => $patient_id,
                                'stock_id'    => $stock_id,
                                'quantity'    => $quantity,
                                'price'       => $price,
                                'net_price'   => $net_price,
                                'date_added'  => current_date_time (),
                            );
                            $this -> IPDModel -> sale_medicine ( $info );
                            
                            /***********LOGS*************/
                            
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'patient_id'   => $patient_id,
                                'sale_id'      => $sale_id,
                                'action'       => 'ipd_sale_medication_added',
                                'log'          => json_encode ( $info ),
                                'after_update' => '',
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                            
                            /***********END LOG*************/
                            
                        }
                    }
                }
                
                $info = array (
                    'total'           => get_ipd_total ( $sale_id ),
                    'discount'        => $data[ 'discount' ],
                    'initial_deposit' => $data[ 'initial_deposit' ],
                    'net_total'       => get_ipd_total ( $sale_id ),
                );
                $this -> IPDModel -> update_sale_total ( $info, $sale_id );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $patient_id,
                    'sale_id'      => $sale_id,
                    'action'       => 'ipd_sale_total_updated',
                    'log'          => json_encode ( $info ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Medication added. <a href="' . base_url () . '/invoices/ipd-medication-invoices?sale_id=' . $sale_id . '" target="_blank" style="font-weight: 800;">Print</a>' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            
            $this -> session -> set_flashdata ( 'error', 'Error! No medicine selected.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * delete ipd medications
         * -------------------------
         */
        
        public function delete_ipd_medication () {
            
            $med_id  = $_REQUEST[ 'med_id' ];
            $sale_id = $_REQUEST[ 'sale_id' ];
            if ( isset( $med_id ) and $med_id > 0 and isset( $sale_id ) and $sale_id > 0 ) {
                $deletedMedicationRecord = $this -> IPDModel -> getIPDMedicationByID ( $med_id );
                $this -> IPDModel -> delete_ipd_medication ( $med_id );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $this -> IPDModel -> get_sale_info ( $sale_id ) -> patient_id,
                    'sale_id'      => $sale_id,
                    'action'       => 'ipd_sale_medication_deleted',
                    'log'          => json_encode ( $deletedMedicationRecord ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                
                /***********END LOG*************/
                
                $info = array (
                    'total'     => get_ipd_total ( $sale_id ),
                    'net_total' => get_ipd_total ( $sale_id ),
                );
                $this -> IPDModel -> update_sale_total ( $info, $sale_id );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $this -> IPDModel -> get_sale_info ( $sale_id ) -> patient_id,
                    'sale_id'      => $sale_id,
                    'action'       => 'ipd_sale_total_updated',
                    'log'          => json_encode ( $info ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                
                /***********END LOG*************/
                
            }
            
            $this -> session -> set_flashdata ( 'response', 'Success! Medication deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @param $POST
         * sale ipd requisitons
         * -------------------------
         */
        
        public function do_add_ipd_requisitions ( $POST ) {
            $data       = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $medicines  = $data[ 'medicine_id' ];
            $sale_id    = $data[ 'sale_id' ];
            $patient_id = $data[ 'patient_id' ];
            
            if ( isset( $medicines ) and count ( $medicines ) > 0 ) {
                $this -> IPDModel -> delete_ipd_requisitions ( $sale_id );
                foreach ( $medicines as $key => $value ) {
                    if ( !empty( trim ( $value ) ) and $value > 0 ) {
                        $medicine_id = $value;
                        $quantity    = $data[ 'quantity' ][ $key ];
                        $frequency   = $data[ 'frequency' ][ $key ];
                        
                        $info = array (
                            'user_id'     => get_logged_in_user_id (),
                            'sale_id'     => $sale_id,
                            'medicine_id' => $medicine_id,
                            'patient_id'  => $patient_id,
                            'frequency'   => $frequency,
                            'quantity'    => $quantity,
                            'date_added'  => current_date_time (),
                        );
                        $this -> IPDModel -> add_medicine_requisition ( $info );
                        
                        /***********LOGS*************/
                        
                        $log = array (
                            'user_id'      => get_logged_in_user_id (),
                            'patient_id'   => $this -> IPDModel -> get_sale_info ( $sale_id ) -> patient_id,
                            'sale_id'      => $sale_id,
                            'action'       => 'ipd_sale_requisition_added',
                            'log'          => json_encode ( $info ),
                            'after_update' => '',
                            'date_added'   => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                        
                        /***********END LOG*************/
                        
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Medication requisition generated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            
            $this -> session -> set_flashdata ( 'error', 'Error! No medicine selected.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @param $POST
         * update ipd billing
         * -------------------------
         */
        
        public function do_update_ipd_billing ( $POST ) {
            $data    = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $sale_id = $data[ 'sale_id' ];
            
            $info = array (
                'total'           => get_ipd_total ( $sale_id ),
                'discount'        => $data[ 'discount' ],
                'initial_deposit' => $data[ 'initial_deposit' ],
                'deduction'       => $data[ 'deduction' ],
                'net_total'       => $data[ 'net_total' ],
            );
            $this -> IPDModel -> update_sale_total ( $info, $sale_id );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'patient_id'   => $this -> IPDModel -> get_sale_info ( $sale_id ) -> patient_id,
                'sale_id'      => $sale_id,
                'action'       => 'ipd_sale_total_updated',
                'log'          => json_encode ( $info ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
            
            /***********END LOG*************/
            
            $this -> session -> set_flashdata ( 'response', 'Success! IPD bill updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @param $POST
         * sale service
         * add payments
         * -------------------------
         */
        
        public function do_add_ipd_sale_payment ( $POST ) {
            $data        = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $patient_id  = $data[ 'patient_id' ];
            $sale_id     = $data[ 'sale_id' ];
            $type        = $data[ 'type' ];
            $amount      = $data[ 'amount' ];
            $description = $data[ 'description' ];
            
            $payment    = array (
                'user_id'     => get_logged_in_user_id (),
                'patient_id'  => $patient_id,
                'sale_id'     => $sale_id,
                'type'        => $type,
                'amount'      => $amount,
                'description' => $description,
                'date_added'  => current_date_time (),
            );
            $payment_id = $this -> IPDModel -> do_add_ipd_sale_payment ( $payment );
            
            $patient_name = get_patient_name ( $patient_id );
            $description  .= '- Payment from IPD Add Payments. Patient EMR# ' . $patient_id . ' Sale ID# ' . $sale_id . ' Patient Name# ' . $patient_name;
            if ( is_patient_panel ( $patient_id ) )
                $description .= ' Panel# ' . get_panel_by_id ( get_patient ( $patient_id ) -> panel_id ) -> name;
            
            $ledger = array (
                'user_id'          => get_logged_in_user_id (),
                'acc_head_id'      => cash_from_ipd,
                'ipd_sale_id'      => $sale_id,
                'invoice_id'       => $sale_id,
                'payment_id'       => $payment_id,
                'trans_date'       => date ( 'Y-m-d' ),
                'payment_mode'     => $type,
                'paid_via'         => 'cash',
                'transaction_type' => 'credit',
                'credit'           => $amount,
                'debit'            => 0,
                'description'      => $description,
                'date_added'       => current_date_time (),
            );
            $this -> AccountModel -> add_ledger ( $ledger );
            
            $ledger[ 'acc_head_id' ]      = unearned_revenue;
            $ledger[ 'transaction_type' ] = 'debit';
            $ledger[ 'credit' ]           = 0;
            $ledger[ 'debit' ]            = $amount;
            $this -> AccountModel -> add_ledger ( $ledger );

//            $ledger = array (
//                'user_id'          => get_logged_in_user_id (),
//                'acc_head_id'      => cash_from_ipd,
//                'ipd_sale_id'      => $sale_id,
//                'invoice_id'       => $sale_id,
//                'trans_date'       => date ( 'Y-m-d' ),
//                'payment_mode'     => $type,
//                'paid_via'         => 'cash',
//                'transaction_type' => 'credit',
//                'credit'           => $amount,
//                'debit'            => 0,
//                'description'      => $description,
//                'date_added'       => current_date_time (),
//            );
//            $this -> AccountModel -> add_ledger ( $ledger );
//
//            $ledger[ 'acc_head_id' ]      = Sales_IPD_Services;
//            $ledger[ 'transaction_type' ] = 'debit';
//            $ledger[ 'credit' ]           = 0;
//            $ledger[ 'debit' ]            = $amount;
//            $this -> AccountModel -> add_ledger ( $ledger );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'patient_id'   => $this -> IPDModel -> get_sale_info ( $sale_id ) -> patient_id,
                'sale_id'      => $sale_id,
                'action'       => 'ipd_sale_payment_added',
                'log'          => json_encode ( $patient_id ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
            
            /***********END LOG*************/
            
            $this -> session -> set_flashdata ( 'response', 'Success! Payment added.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @param $POST
         * sale service
         * update discharge date
         * -------------------------
         */
        
        public function do_update_discharge_date ( $POST ) {
            $data           = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $sale_id        = $data[ 'sale_id' ];
            $discharge_date = $data[ 'discharge_date' ];
            
            $date  = array (
                'date_discharged' => date ( 'Y-m-d', strtotime ( $discharge_date ) ) . ' ' . date ( 'H:i:s' ),
            );
            $where = array (
                'sale_id' => $sale_id,
            );
            $this -> IPDModel -> do_update_discharge_date ( $date, $where );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'patient_id'   => $this -> IPDModel -> get_sale_info ( $sale_id ) -> patient_id,
                'sale_id'      => $sale_id,
                'action'       => 'ipd_sale_discharge_date_updated',
                'log'          => json_encode ( $date ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
            
            /***********END LOG*************/
            
            $this -> session -> set_flashdata ( 'response', 'Success! Discharge date updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @param $POST
         * sale service
         * update ipd consultants
         * -------------------------
         */
        
        public function do_add_ipd_consultants ( $POST ) {
            $data            = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $services        = $data[ 'service_id' ];
            $doctors         = $data[ 'doctor_id' ];
            $patient_id      = $data[ 'patient_id' ];
            $sale_id         = $data[ 'sale_id' ];
            $commission      = $data[ 'commission' ];
            $bill_commission = $data[ 'bill-commission' ];
            
            if ( count ( $services ) > 0 ) {
                foreach ( $services as $key => $service_id ) {
                    if ( $service_id > 0 ) {
                        $info = array (
                            'user_id'         => get_logged_in_user_id (),
                            'sale_id'         => $sale_id,
                            'patient_id'      => $patient_id,
                            'service_id'      => $service_id,
                            'doctor_id'       => $doctors[ $key ],
                            'commission'      => $commission[ $key ],
                            'bill_commission' => $bill_commission[ $key ],
                            'date_added'      => current_date_time (),
                        );
                        $this -> IPDModel -> add_ipd_consultants ( $info );
                        
                        /***********LOGS*************/
                        $log = array (
                            'user_id'      => get_logged_in_user_id (),
                            'patient_id'   => $patient_id,
                            'sale_id'      => $sale_id,
                            'action'       => 'ipd_patient_consultant_added',
                            'log'          => json_encode ( $info ),
                            'after_update' => '',
                            'date_added'   => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'ipd_consultant_logs', $log );
                        /***********END LOG*************/
                    }
                }
            }
            
            $this -> session -> set_flashdata ( 'response', 'Success! Consultants added.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        public function do_add_ipd_anesthesia_charges ( $POST ) {
            $data       = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $services   = $data[ 'service_id' ];
            $doctors    = $data[ 'doctor_id' ];
            $patient_id = $data[ 'patient_id' ];
            $sale_id    = $data[ 'sale_id' ];
            $commission = $data[ 'commission' ];
            
            if ( count ( $services ) > 0 ) {
                foreach ( $services as $key => $service_id ) {
                    if ( $service_id > 0 ) {
                        $info = array (
                            'user_id'    => get_logged_in_user_id (),
                            'sale_id'    => $sale_id,
                            'patient_id' => $patient_id,
                            'service_id' => $service_id,
                            'doctor_id'  => $doctors[ $key ],
                            'commission' => $commission[ $key ],
                            'date_added' => current_date_time (),
                        );
                        $this -> IPDModel -> add_ipd_anesthesia_charges ( $info );
                        
                        /***********LOGS*************/
                        $log = array (
                            'user_id'      => get_logged_in_user_id (),
                            'patient_id'   => $patient_id,
                            'sale_id'      => $sale_id,
                            'action'       => 'ipd_patient_anesthesia_charges_added',
                            'log'          => json_encode ( $info ),
                            'after_update' => '',
                            'date_added'   => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'ipd_consultant_logs', $log );
                        /***********END LOG*************/
                    }
                }
            }
            
            $this -> session -> set_flashdata ( 'response', 'Success! Anesthesia charges have been added.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @param $POST
         * sale service
         * update ipd consultants
         * -------------------------
         */
        
        public function do_update_ot_timings ( $POST ) {
            
            $in_time  = $this -> input -> post ( 'in_time' );
            $out_time = $this -> input -> post ( 'out_time' );
            
            $in_date  = explode ( '-', $in_time );
            $out_date = explode ( '-', $out_time );
            
            $in_time  = $in_date[ 1 ];
            $out_time = $out_date[ 1 ];
            
            $inDate  = explode ( ' ', $in_date[ 0 ] );
            $outDate = explode ( ' ', $out_date[ 0 ] );
            
            $inMonth  = date ( "m", strtotime ( $inDate[ 1 ] ) );
            $outMonth = date ( "m", strtotime ( $outDate[ 1 ] ) );
            
            $formattedInTime  = $inDate[ 0 ] . '-' . $inMonth . '-' . $inDate[ 2 ] . $in_time;
            $formattedOutTime = $outDate[ 0 ] . '-' . $outMonth . '-' . $outDate[ 2 ] . $out_time;
            
            $info = array (
                'user_id'    => get_logged_in_user_id (),
                'sale_id'    => $this -> input -> post ( 'sale_id' ),
                'patient_id' => $this -> input -> post ( 'patient_id' ),
                'in_time'    => $formattedInTime,
                'out_time'   => $formattedOutTime,
            );
            
            $timings = $this -> IPDModel -> get_ot_timings ( $this -> input -> post ( 'sale_id' ) );
            if ( empty( $timings ) )
                $this -> IPDModel -> ot_timings ( $info );
            else
                $this -> IPDModel -> update_ot_timings ( $info, $this -> input -> post ( 'sale_id' ) );
            
            $this -> session -> set_flashdata ( 'response', 'Success! OT Timings added.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @param $POST
         * sale service
         * delete ipd consultants
         * -------------------------
         */
        
        public function delete_consultant () {
            
            $consultant_id = $_REQUEST[ 'id' ];
            $patient_id    = $_REQUEST[ 'patient_id' ];
            $sale_id       = $_REQUEST[ 'sale_id' ];
            
            if ( isset( $consultant_id ) and isset( $patient_id ) and isset( $sale_id ) and $consultant_id > 0 ) {
                
                $consultant  = $this -> IPDModel -> get_ipd_patient_consultant_by_id ( $consultant_id );
                $accountHead = get_account_head_by ( 'doctor_id', $consultant -> doctor_id );
                $this -> AccountModel -> delete_ipd_consultant ( $consultant -> sale_id, $accountHead -> id );
                $this -> IPDModel -> delete_ipd_consultants ( $consultant_id );
                
                /***********LOGS*************/
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $patient_id,
                    'sale_id'      => $sale_id,
                    'action'       => 'ipd_patient_consultant_deleted',
                    'log'          => json_encode ( $consultant_id ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'ipd_consultant_logs', $log );
                /***********END LOG*************/
            }
            
            $this -> session -> set_flashdata ( 'response', 'Success! Consultant deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        public function delete_anesthesia_doctor () {
            
            $id         = $_REQUEST[ 'id' ];
            $patient_id = $_REQUEST[ 'patient_id' ];
            $sale_id    = $_REQUEST[ 'sale_id' ];
            
            if ( isset( $id ) and isset( $patient_id ) and isset( $sale_id ) and $id > 0 ) {
                
                $anesthesia  = $this -> IPDModel -> get_ipd_patient_anesthesia_doctor_by_id ( $id );
                $accountHead = get_account_head_by ( 'doctor_id', $anesthesia -> doctor_id );
                $this -> AccountModel -> delete_ipd_anesthesia_doctor ( $anesthesia -> sale_id, $accountHead -> id );
                $this -> IPDModel -> delete_ipd_anesthesia_doctor ( $id );
                
                /***********LOGS*************/
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $patient_id,
                    'sale_id'      => $sale_id,
                    'action'       => 'ipd_patient_anesthesia_deleted',
                    'log'          => json_encode ( $id ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'ipd_consultant_logs', $log );
                /***********END LOG*************/
            }
            
            $this -> session -> set_flashdata ( 'response', 'Success! Anesthesia doctor deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * discharge patient
         * -------------------------
         */
        
        public function do_discharge_patient () {
            $sale_id = $_REQUEST[ 'sale_id' ];
            if ( isset( $sale_id ) and is_numeric ( $sale_id ) and $sale_id > 0 ) {
                
                $sale_info                   = $this -> IPDModel -> get_sale_info ( $sale_id );
                $sale                        = get_ipd_sale ( $sale_id );
                $sale_info                   = $this -> IPDModel -> get_sale_info ( $sale_id );
                $ipd_total                   = @$sale -> total;
                $discount                    = @$sale -> discount;
                $ipd_net                     = @$sale -> net_total;
                $date_discharged             = @date ( 'Y-m-d', strtotime ( $sale_info -> date_discharged ) );
                $patient_id                  = get_ipd_patient_id_by_sale_id ( $sale_id );
                $patient                     = get_patient ( $patient_id );
                $total_ipd_services_excluded = $this -> IPDModel -> total_ipd_services_excluded ( $sale_id );
                
                if ( $patient -> panel_id > 0 ) {
                    $accountHead = get_account_head_id_by_panel_id ( $patient -> panel_id );
                    if ( !empty( $accountHead ) )
                        $accountHeadID = $accountHead -> id;
                    else
                        $accountHeadID = 0;
                }
                else {
                    $accountHeadID = 0;
                }
                
                
                if ( empty( trim ( $sale_info -> date_discharged ) ) or $sale_info -> date_discharged == NULL ) {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please update discharge date.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                
                if ( !if_consultant_added ( $sale_id ) ) {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please add atleast one consultant in Consultant Commission tab.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                
                $info = array (
                    'discharged_by'   => get_logged_in_user_id (),
                    'discharged'      => '1',
                    'date_discharged' => $sale_info -> date_discharged,
                );
                $this -> IPDModel -> do_discharge_patient ( $info, $sale_id );
                
                $admission_info = $this -> IPDModel -> get_admission_slip ( $sale_id );
                if ( !empty( $admission_info ) && $admission_info -> bed_id > 0 )
                    $this -> RoomModel -> release_bed ( $admission_info -> bed_id );
                
                $description = 'Patient discharged. IPD Invoice ID# ' . $sale_id . ' Patient EMR# ' . $patient_id . ' Patient Name# ' . get_patient_name ( 0, $patient );
                if ( $patient -> panel_id > 0 )
                    $description .= ". Panel# " . get_panel_by_id ( $patient -> panel_id ) -> name;
                
                /*if ( empty( trim ( $discount ) ) or $discount == NULL or $discount < 1 ) {
                    $ledger = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => cash_from_ipd,
                        'invoice_id'       => $sale_id,
                        'ipd_sale_id'      => $sale_id,
                        'trans_date'       => $date_discharged,
                        'payment_mode'     => 'cash',
                        'paid_via'         => 'cash',
                        'transaction_type' => 'credit',
                        'credit'           => $ipd_total,
                        'debit'            => 0,
                        'description'      => $description,
                        'date_added'       => current_date_time (),
                    );
                    if ( $accountHeadID > 0 ) {
//                        $ledger[ 'credit' ]      = $ipd_total - $sale -> deduction;
                        $ledger[ 'acc_head_id' ] = $accountHeadID;
                    }
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    $ledger[ 'acc_head_id' ] = Sales_IPD_Services;
                    if ( $accountHeadID > 0 )
                        $ledger[ 'acc_head_id' ] = sales_ipd_services_panel;
                    $ledger[ 'transaction_type' ] = 'debit';
                    $ledger[ 'credit' ]           = 0;
                    $ledger[ 'debit' ]            = $ipd_total;
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                }
                else {
                    $ledger = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => cash_from_ipd,
                        'ipd_sale_id'      => $sale_id,
                        'invoice_id'       => $sale_id,
                        'trans_date'       => $date_discharged,
                        'payment_mode'     => 'cash',
                        'paid_via'         => 'cash',
                        'transaction_type' => 'credit',
                        'credit'           => $ipd_total - $discount,
                        'debit'            => 0,
                        'description'      => $description,
                        'date_added'       => current_date_time (),
                    );
                    if ( $accountHeadID > 0 ) {
//                        $ledger[ 'credit' ]      = $ipd_total - $sale -> deduction;
                        $ledger[ 'acc_head_id' ] = $accountHeadID;
                    }
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    $ledger[ 'acc_head_id' ] = Sales_IPD_Services;
                    if ( $accountHeadID > 0 )
                        $ledger[ 'acc_head_id' ] = sales_ipd_services_panel;
                    $ledger[ 'transaction_type' ] = 'debit';
                    $ledger[ 'credit' ]           = 0;
                    $ledger[ 'debit' ]            = $ipd_total;
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    $ledger[ 'acc_head_id' ] = Discount_on_IPD_Services;
                    if ( $accountHeadID > 0 )
                        $ledger[ 'acc_head_id' ] = discount_ipd_services_panel;
                    $ledger[ 'transaction_type' ] = 'credit';
                    $ledger[ 'credit' ]           = $discount;
                    $ledger[ 'debit' ]            = 0;
                    $this -> AccountModel -> add_ledger ( $ledger );
                }*/
                
                $description .= '- Total of Added Payments.';
                $ledger      = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => is_patient_panel ( 0, $patient ) ? sales_ipd_services_panel : Sales_IPD_Services,
                    'ipd_sale_id'      => $sale_id,
                    'invoice_id'       => $sale_id,
                    'trans_date'       => date ( 'Y-m-d' ),
                    'payment_mode'     => 'cash',
                    'paid_via'         => 'cash',
                    'transaction_type' => 'debit',
                    'credit'           => 0,
                    'debit'            => $ipd_total,
                    'description'      => $description,
                    'date_added'       => current_date_time (),
                );
                $this -> AccountModel -> add_ledger ( $ledger );
                
                $ledger[ 'acc_head_id' ]      = unearned_revenue;
                $ledger[ 'transaction_type' ] = 'credit';
                $ledger[ 'credit' ]           = count_ipd_payment_received ( $sale_id );
                $ledger[ 'debit' ]            = 0;
                $this -> AccountModel -> add_ledger ( $ledger );
                
                if ( $discount > 0 ) {
                    $ledger[ 'acc_head_id' ]      = Discount_on_IPD_Services;
                    $ledger[ 'transaction_type' ] = 'credit';
                    $ledger[ 'credit' ]           = $discount;
                    $ledger[ 'debit' ]            = 0;
                    $this -> AccountModel -> add_ledger ( $ledger );
                }
                
                if ( is_patient_panel ( 0, $patient ) ) {
                    $ledger[ 'acc_head_id' ]      = $accountHeadID;
                    $ledger[ 'transaction_type' ] = 'credit';
                    $ledger[ 'credit' ]           = $ipd_total - count_ipd_payment_received ( $sale_id ) - $total_ipd_services_excluded;
                    $ledger[ 'debit' ]            = 0;
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    $ledger[ 'acc_head_id' ]      = COS_EXCLUDE_SSP;
                    $ledger[ 'transaction_type' ] = 'credit';
                    $ledger[ 'credit' ]           = $total_ipd_services_excluded;
                    $ledger[ 'debit' ]            = 0;
                    $this -> AccountModel -> add_ledger ( $ledger );
                }

//                $ipdServicesSum = get_ipd_included_services_sum ( $sale_id );
//                $tax            = $sale -> tax;
//                $tax_value      = ( $ipdServicesSum * ( $tax / 100 ) );
//                $taxLedger      = array (
//                    'user_id'          => get_logged_in_user_id (),
//                    'acc_head_id'      => SSP_ADVANCE_TAX,
//                    'ipd_sale_id'      => $sale_id,
//                    'invoice_id'       => $sale_id,
//                    'trans_date'       => $date_discharged,
//                    'payment_mode'     => 'cash',
//                    'paid_via'         => 'cash',
//                    'transaction_type' => 'credit',
//                    'credit'           => $tax_value,
//                    'debit'            => 0,
//                    'description'      => $description,
//                    'date_added'       => current_date_time (),
//                );
//                $this -> AccountModel -> add_ledger ( $taxLedger );
//
//                $taxLedger[ 'credit' ]      = $sale -> tax;
//                $taxLedger[ 'acc_head_id' ] = COS_DEDUCTION_SSP;
//                $this -> AccountModel -> add_ledger ( $taxLedger );
//
//                if ( $patient -> panel_id > 0 ) {
//                    $panel               = get_panel_by_id ( $patient -> panel_id );
//                    $excludedServicesSum = get_ipd_included_services_sum ( $sale_id );
//                    $medicationSum       = get_ipd_medication_net_price ( $sale_id );
//                    $labSum              = get_ipd_lab_net_price ( $sale_id );
//                    $net                 = $sale -> total;
//
//                    if ( $panel && $panel -> exclude_pharmacy == '1' )
//                        $net -= $medicationSum;
//
//                    if ( $panel && $panel -> exclude_lab == '1' )
//                        $net -= $labSum;
//
//                    $net -= $excludedServicesSum;
//
//                    $taxLedger[ 'credit' ]      = $net;
//                    $taxLedger[ 'acc_head_id' ] = COS_EXCLUDE_SSP;
//                    $this -> AccountModel -> add_ledger ( $taxLedger );
//                }
                
                $this -> addConsultantCommissioningLedger ( $sale_id );
                $this -> addAnesthesiaChargesLedger ( $sale_id );
                
                $TP_UNIT_COST = calculate_cost_of_ipd_medicines_sold ( $sale_id );
                $description  = ' - Cost of medicines sold.';
                $ledger       = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => cost_of_medicine_sold,
                    'ipd_sale_id'      => $sale_id,
                    //                    'invoice_id'       => $sale_id,
                    'trans_date'       => $date_discharged,
                    'payment_mode'     => 'cash',
                    'paid_via'         => 'cash',
                    'transaction_type' => 'credit',
                    'credit'           => $TP_UNIT_COST,
                    'debit'            => 0,
                    'description'      => $description,
                    'date_added'       => current_date_time (),
                );
                $this -> AccountModel -> add_ledger ( $ledger );
                
                $ledger[ 'acc_head_id' ]      = medical_supply_inventory;
                $ledger[ 'transaction_type' ] = 'debit';
                $ledger[ 'credit' ]           = 0;
                $ledger[ 'debit' ]            = $TP_UNIT_COST;
                $this -> AccountModel -> add_ledger ( $ledger );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $this -> IPDModel -> get_sale_info ( $sale_id ) -> patient_id,
                    'sale_id'      => $sale_id,
                    'action'       => 'ipd_sale_patient_discharged',
                    'log'          => json_encode ( $info ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! IPD patient has been discharged.' );
                return redirect ( 'IPD/sales' );
            }
            else
                return redirect ( 'IPD/sales' );
        }
        
        public function addConsultantCommissioningLedger ( $sale_id ) {
            $consultants     = $this -> IPDModel -> get_consultants ( $sale_id );
            $sale            = get_ipd_admission_slip ( $sale_id );
            $sale_info       = $this -> IPDModel -> get_sale_info ( $sale_id );
            $ipd_sale_info   = $this -> IPDModel -> get_ipd_sale ( $sale_id );
            $date_discharged = date ( 'Y-m-d', strtotime ( $sale_info -> date_discharged ) );
            $patient         = get_patient_by_id ( $sale -> patient_id );
            
            if ( count ( $consultants ) > 0 ) {
                foreach ( $consultants as $consultant ) {
                    $accountHead = get_account_head_by ( 'doctor_id', $consultant -> doctor_id );
                    $netBill     = $patient -> panel_id > 0 ? get_ipd_net_amount_excluding ( $sale_info ) : get_ipd_included_services_sum ( $sale_id );
                    $service     = get_ipd_service_by_id ( $consultant -> service_id );
                    $doctor      = get_doctor ( $consultant -> doctor_id );
                    
                    if ( $consultant -> commission > 0 )
                        $commission = $consultant -> commission;
                    else
                        $commission = $netBill * ( $consultant -> bill_commission / 100 );
                    
                    $description = 'Cost of Procedure (' . $service -> title . '). IPD Invoice ID# ' . $sale_id . ' Patient EMR# ' . $sale -> patient_id . ' Doctor# ' . $doctor -> name;
                    $ledger      = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => COS_Procedures_IPD,
                        'ipd_sale_id'      => $sale_id,
                        'trans_date'       => $date_discharged,
                        'payment_mode'     => 'cash',
                        'paid_via'         => 'cash',
                        'transaction_type' => 'credit',
                        'credit'           => $commission,
                        'debit'            => 0,
                        'description'      => $description,
                        'date_added'       => current_date_time (),
                    );
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    
                    $description = 'Consultant commission. IPD Invoice ID# ' . $sale_id;
                    if ( !empty( $accountHead ) && $accountHead -> id > 0 ) {
                        $ledger[ 'acc_head_id' ]      = $accountHead -> id;
                        $ledger[ 'transaction_type' ] = 'debit';
                        $ledger[ 'credit' ]           = 0;
                        $ledger[ 'debit' ]            = $commission;
                        $ledger[ 'description' ]      = $description;
                        
                        $this -> AccountModel -> add_ledger ( $ledger );
                    }
                }
            }
        }
        
        public function addAnesthesiaChargesLedger ( $sale_id ) {
            $anesthesia_charges = $this -> IPDModel -> get_anesthesia_charges ( $sale_id );
            $sale_info          = $this -> IPDModel -> get_sale_info ( $sale_id );
            $date_discharged    = date ( 'Y-m-d', strtotime ( $sale_info -> date_discharged ) );
            
            if ( count ( $anesthesia_charges ) > 0 ) {
                foreach ( $anesthesia_charges as $anesthesia_charge ) {
                    $accountHead = get_account_head_by ( 'doctor_id', $anesthesia_charge -> doctor_id );
                    $service     = get_ipd_service_by_id ( $anesthesia_charge -> service_id );
                    
                    $description = 'Anesthesia charges, (' . $service -> title . '). IPD Invoice ID# ' . $sale_id;
                    $ledger      = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => COS_Anesthesia_Fee,
                        'ipd_sale_id'      => $sale_id,
                        'trans_date'       => $date_discharged,
                        'payment_mode'     => 'cash',
                        'paid_via'         => 'cash',
                        'transaction_type' => 'credit',
                        'credit'           => $anesthesia_charge -> commission,
                        'debit'            => 0,
                        'description'      => $description,
                        'date_added'       => current_date_time (),
                    );
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    
                    $description = 'Anesthesia charges. IPD Invoice ID# ' . $sale_id;
                    if ( !empty( $accountHead ) && $accountHead > 0 ) {
                        $ledger[ 'acc_head_id' ]      = $accountHead -> id;
                        $ledger[ 'transaction_type' ] = 'debit';
                        $ledger[ 'credit' ]           = 0;
                        $ledger[ 'debit' ]            = $anesthesia_charge -> commission;
                        $ledger[ 'description' ]      = $description;
                        
                        $this -> AccountModel -> add_ledger ( $ledger );
                    }
                }
            }
        }
        
        public function update_ipd_ledger ( $sale ) {
            
            $sale_id                     = $sale -> id;
            $sale                        = get_ipd_sale ( $sale_id );
            $sale_info                   = $this -> IPDModel -> get_sale_info ( $sale_id );
            $ipd_total                   = $sale -> total;
            $discount                    = $sale -> discount;
            $ipd_net                     = $sale -> net_total;
            $date_discharged             = date ( 'Y-m-d', strtotime ( $sale_info -> date_discharged ) );
            $patient_id                  = get_ipd_patient_id_by_sale_id ( $sale_id );
            $patient                     = get_patient ( $patient_id );
            $total_ipd_services_excluded = $this -> IPDModel -> total_ipd_services_excluded ( $sale_id );
            
            if ( $patient -> panel_id > 0 ) {
                $accountHead = get_account_head_id_by_panel_id ( $patient -> panel_id );
                if ( !empty( $accountHead ) )
                    $accountHeadID = $accountHead -> id;
                else
                    $accountHeadID = 0;
            }
            else {
                $accountHeadID = 0;
            }
            
            
            if ( empty( trim ( $sale_info -> date_discharged ) ) or $sale_info -> date_discharged == NULL ) {
                $this -> session -> set_flashdata ( 'error', 'Error! Please update discharge date.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            
            if ( !if_consultant_added ( $sale_id ) ) {
                $this -> session -> set_flashdata ( 'error', 'Error! Please add atleast one consultant in Consultant Commission tab.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            
            if ( empty( trim ( $discount ) ) or $discount == NULL or $discount < 1 ) {
                $ledger = array (
                    'user_id'          => get_logged_in_user_id (),
                    'trans_date'       => $date_discharged,
                    'payment_mode'     => 'cash',
                    'paid_via'         => 'cash',
                    'transaction_type' => 'credit',
                    'credit'           => $ipd_total,
                    'debit'            => 0,
                    'date_added'       => current_date_time (),
                );
                
                if ( $accountHeadID > 0 ) {
                    $ledger[ 'credit' ] = $ipd_total - count_ipd_payment_received ( $sale_id ) - $total_ipd_services_excluded;
                    $where              = array (
                        'acc_head_id' => $accountHeadID,
                        'invoice_id'  => $sale_id,
                        'ipd_sale_id' => $sale_id,
                    );
                    
                    $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                }
                
                $ledger[ 'transaction_type' ] = 'debit';
                $ledger[ 'credit' ]           = 0;
                $ledger[ 'debit' ]            = $ipd_total;
                
                $where = array (
                    'acc_head_id' => $accountHeadID > 0 ? sales_ipd_services_panel : Sales_IPD_Services,
                    'invoice_id'  => $sale_id,
                    'ipd_sale_id' => $sale_id,
                );
                
                $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                
            }
            
            else {
                $ledger = array (
                    'user_id'          => get_logged_in_user_id (),
                    'trans_date'       => $date_discharged,
                    'payment_mode'     => 'cash',
                    'paid_via'         => 'cash',
                    'transaction_type' => 'credit',
                    'credit'           => $ipd_total - $discount,
                    'debit'            => 0,
                    'date_added'       => current_date_time (),
                );
                
                if ( $accountHeadID > 0 ) {
                    $ledger[ 'credit' ] = $ipd_total - count_ipd_payment_received ( $sale_id ) - $total_ipd_services_excluded;
                    $where              = array (
                        'acc_head_id' => $accountHeadID,
                        'invoice_id'  => $sale_id,
                        'ipd_sale_id' => $sale_id,
                    );
                    
                    $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                }
                
                $ledger[ 'transaction_type' ] = 'debit';
                $ledger[ 'credit' ]           = 0;
                $ledger[ 'debit' ]            = $ipd_total;
                
                $where = array (
                    'acc_head_id' => $accountHeadID > 0 ? sales_ipd_services_panel : Sales_IPD_Services,
                    'invoice_id'  => $sale_id,
                    'ipd_sale_id' => $sale_id,
                );
                
                $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                
                $ledger[ 'transaction_type' ] = 'credit';
                $ledger[ 'credit' ]           = $discount;
                $ledger[ 'debit' ]            = 0;
                
                $where = array (
                    'acc_head_id' => $accountHeadID > 0 ? discount_ipd_services_panel : Discount_on_IPD_Services,
                    'invoice_id'  => $sale_id,
                    'ipd_sale_id' => $sale_id,
                );
                
                $this -> AccountModel -> update_general_ledger ( $ledger, $where );
            }
            
            $TP_UNIT_COST = calculate_cost_of_ipd_medicines_sold ( $sale_id );
            $ledger       = array (
                'user_id'          => get_logged_in_user_id (),
                'trans_date'       => $date_discharged,
                'payment_mode'     => 'cash',
                'paid_via'         => 'cash',
                'transaction_type' => 'credit',
                'credit'           => $TP_UNIT_COST,
                'debit'            => 0,
                'date_added'       => current_date_time (),
            );
            
            $where = array (
                'acc_head_id' => cost_of_medicine_sold,
                'ipd_sale_id' => $sale_id,
            );
            
            $this -> AccountModel -> update_general_ledger ( $ledger, $where );
            
            $ledger[ 'transaction_type' ] = 'debit';
            $ledger[ 'credit' ]           = 0;
            $ledger[ 'debit' ]            = $TP_UNIT_COST;
            
            $where = array (
                'acc_head_id' => medical_supply_inventory,
                'ipd_sale_id' => $sale_id,
            );
            
            $this -> AccountModel -> update_general_ledger ( $ledger, $where );

//            $ipdServicesSum = get_ipd_included_services_sum ( $sale_id );
//            $tax            = $sale -> tax;
//            $tax_value      = ( $ipdServicesSum * ( $tax / 100 ) );
//            $where          = array (
//                'acc_head_id' => SSP_ADVANCE_TAX,
//                'ipd_sale_id' => $sale_id,
//            );
//            $taxLedger      = array (
//                'user_id'          => get_logged_in_user_id (),
//                'acc_head_id'      => SSP_ADVANCE_TAX,
//                'ipd_sale_id'      => $sale_id,
//                'invoice_id'       => $sale_id,
//                'trans_date'       => $date_discharged,
//                'payment_mode'     => 'cash',
//                'paid_via'         => 'cash',
//                'transaction_type' => 'credit',
//                'credit'           => $tax_value,
//                'debit'            => 0,
//                'date_added'       => current_date_time (),
//            );
//            $this -> AccountModel -> update_general_ledger ( $taxLedger, $where );
//
//            $where                      = array (
//                'acc_head_id' => COS_DEDUCTION_SSP,
//                'ipd_sale_id' => $sale_id,
//            );
//            $taxLedger[ 'credit' ]      = $sale -> tax;
//            $taxLedger[ 'acc_head_id' ] = COS_DEDUCTION_SSP;
//            $this -> AccountModel -> update_general_ledger ( $taxLedger, $where );
//
//            if ( $patient -> panel_id > 0 ) {
//                $panel               = get_panel_by_id ( $patient -> panel_id );
//                $excludedServicesSum = get_ipd_included_services_sum ( $sale_id );
//                $medicationSum       = get_ipd_medication_net_price ( $sale_id );
//                $labSum              = get_ipd_lab_net_price ( $sale_id );
//                $net                 = $sale -> total;
//
//                if ( $panel && $panel -> exclude_pharmacy == '1' )
//                    $net -= $medicationSum;
//
//                if ( $panel && $panel -> exclude_lab == '1' )
//                    $net -= $labSum;
//
//                $net -= $excludedServicesSum;
//
//                $where                      = array (
//                    'acc_head_id' => COS_EXCLUDE_SSP,
//                    'ipd_sale_id' => $sale_id,
//                );
//                $taxLedger[ 'credit' ]      = $net;
//                $taxLedger[ 'acc_head_id' ] = COS_EXCLUDE_SSP;
//
//                $this -> AccountModel -> update_general_ledger ( $taxLedger, $where );
//            }
            
            $this -> updateCOSProcedures ( $sale_id );
            $this -> updateAnesthesiaCharges ( $sale_id );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'patient_id'   => $this -> IPDModel -> get_sale_info ( $sale_id ) -> patient_id,
                'sale_id'      => $sale_id,
                'action'       => 'ipd_sale_patient_discharged_updated',
                'log'          => json_encode ( $sale ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
            
            /***********END LOG*************/
            
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        public function updateCOSProcedures ( $sale_id ) {
            $consultants     = $this -> IPDModel -> get_consultants ( $sale_id );
            $sale            = get_ipd_admission_slip ( $sale_id );
            $sale_info       = $this -> IPDModel -> get_sale_info ( $sale_id );
            $ipd_sale_info   = $this -> IPDModel -> get_ipd_sale ( $sale_id );
            $date_discharged = date ( 'Y-m-d', strtotime ( $sale_info -> date_discharged ) );
            $patient         = get_patient_by_id ( $sale -> patient_id );
            
            if ( count ( $consultants ) > 0 ) {
                
                $where = array (
                    'acc_head_id' => COS_Procedures_IPD,
                    'ipd_sale_id' => $sale_id,
                );
                $this -> AccountModel -> delete_ledger ( $where );
                
                foreach ( $consultants as $consultant ) {
                    $accountHead = get_account_head_by ( 'doctor_id', $consultant -> doctor_id );
                    $netBill     = $patient -> panel_id > 0 ? get_ipd_net_amount_excluding ( $sale_info ) : get_ipd_included_services_sum ( $sale_id );
                    $service     = get_ipd_service_by_id ( $consultant -> service_id );
                    $doctor      = get_doctor ( $consultant -> doctor_id );
                    
                    if ( $consultant -> commission > 0 )
                        $commission = $consultant -> commission;
                    else
                        $commission = $netBill * ( $consultant -> bill_commission / 100 );
                    
                    $description = 'Cost of Procedure (' . $service -> title . '). IPD Invoice ID# ' . $sale_id . ' Patient EMR# ' . $sale -> patient_id . ' Doctor# ' . $doctor -> name;
                    $where       = array (
                        'acc_head_id' => COS_Procedures_IPD,
                        'ipd_sale_id' => $sale_id,
                    );
                    $ledger      = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => COS_Procedures_IPD,
                        'ipd_sale_id'      => $sale_id,
                        'trans_date'       => $date_discharged,
                        'payment_mode'     => 'cash',
                        'paid_via'         => 'cash',
                        'transaction_type' => 'credit',
                        'credit'           => $commission,
                        'debit'            => 0,
                        'description'      => $description,
                        'date_added'       => current_date_time (),
                    );
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    
                    $description = 'Consultant commission. IPD Invoice ID# ' . $sale_id;
                    if ( !empty( $accountHead ) && $accountHead -> id > 0 ) {
                        $where                        = array (
                            'acc_head_id' => $accountHead -> id,
                            'ipd_sale_id' => $sale_id,
                        );
                        $ledger[ 'acc_head_id' ]      = $accountHead -> id;
                        $ledger[ 'transaction_type' ] = 'debit';
                        $ledger[ 'credit' ]           = 0;
                        $ledger[ 'debit' ]            = $commission;
                        $ledger[ 'description' ]      = $description;
                        
                        $generalLedger = $this -> AccountModel -> get_ledger ( $where );
                        
                        if ( !empty( $generalLedger ) )
                            $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                        else
                            $this -> AccountModel -> add_ledger ( $ledger );
                    }
                }
            }
        }
        
        public function updateAnesthesiaCharges ( $sale_id ) {
            $anesthesia_charges = $this -> IPDModel -> get_anesthesia_charges ( $sale_id );
            $sale_info          = $this -> IPDModel -> get_sale_info ( $sale_id );
            $date_discharged    = date ( 'Y-m-d', strtotime ( $sale_info -> date_discharged ) );
            
            if ( count ( $anesthesia_charges ) > 0 ) {
                
                $where = array (
                    'acc_head_id' => COS_Anesthesia_Fee,
                    'ipd_sale_id' => $sale_id,
                );
                $this -> AccountModel -> delete_ledger ( $where );
                
                foreach ( $anesthesia_charges as $anesthesia_charge ) {
                    $accountHead = get_account_head_by ( 'doctor_id', $anesthesia_charge -> doctor_id );
                    $service     = get_ipd_service_by_id ( $anesthesia_charge -> service_id );
                    
                    $description = 'Anesthesia charges, (' . $service -> title . '). IPD Invoice ID# ' . $sale_id;
                    $where       = array (
                        'acc_head_id' => COS_Anesthesia_Fee,
                        'ipd_sale_id' => $sale_id,
                    );
                    $ledger      = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => COS_Anesthesia_Fee,
                        'ipd_sale_id'      => $sale_id,
                        'trans_date'       => $date_discharged,
                        'payment_mode'     => 'cash',
                        'paid_via'         => 'cash',
                        'transaction_type' => 'credit',
                        'credit'           => $anesthesia_charge -> commission,
                        'debit'            => 0,
                        'description'      => $description,
                        'date_added'       => current_date_time (),
                    );
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    
                    $description = 'Anesthesia charges. IPD Invoice ID# ' . $sale_id;
                    if ( !empty( $accountHead ) && $accountHead > 0 ) {
                        $where                        = array (
                            'acc_head_id' => $accountHead -> id,
                            'ipd_sale_id' => $sale_id,
                        );
                        $ledger[ 'acc_head_id' ]      = $accountHead -> id;
                        $ledger[ 'transaction_type' ] = 'debit';
                        $ledger[ 'credit' ]           = 0;
                        $ledger[ 'debit' ]            = $anesthesia_charge -> commission;
                        $ledger[ 'description' ]      = $description;
                        
                        $generalLedger = $this -> AccountModel -> get_ledger ( $where );
                        
                        if ( !empty( $generalLedger ) )
                            $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                        else
                            $this -> AccountModel -> add_ledger ( $ledger );
                    }
                }
            }
        }
        
        /**
         * -------------------------
         * update requisition status
         * @param $sale_id
         * -------------------------
         */
        
        public function do_update_requisition_status ( $sale_id ) {
            if ( isset( $sale_id ) and is_numeric ( $sale_id ) and $sale_id > 0 ) {
                $info = array (
                    'seen' => '1'
                );
                $this -> IPDModel -> do_update_requisition_status ( $info, $sale_id );
            }
        }
        
        /**
         * -------------------------
         * all sales
         * which are discharged
         * -------------------------
         */
        
        public function discharged () {
            
            if ( isset( $_GET[ 'send-claim' ] ) and $_GET[ 'send-claim' ] == 'true' )
                $this -> do_send_claim ();
            
            $title = site_name . ' - Discharged Patient Invoices';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( '/IPD/discharged' );
            $total_row                      = $this -> IPDModel -> count_discharged_sales ();
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

//            $data[ 'services' ]   = $this -> IPDModel -> get_all_services ();
            $data[ 'doctors' ]    = $this -> DoctorModel -> get_doctors ();
            $data[ 'services' ]   = $this -> IPDModel -> get_parent_services ();
            $data[ 'panels' ]     = $this -> PanelModel -> get_panels ();
            $data[ 'discharged' ] = true;
            $data[ 'sales' ]      = $this -> IPDModel -> get_dischaged_sales ( $config[ "per_page" ], $offset );
            $str_links            = $this -> pagination -> create_links ();
            $data[ "links" ]      = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/ipd/discharged', $data );
            $this -> footer ();
        }
        
        public function do_send_claim () {
            $sale_id = $this -> input -> get ( 'sale_id' );
            if ( $sale_id > 0 ) {
                $this -> IPDModel -> do_send_claim ( $sale_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Claim has ben sent.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * discharge patient
         * -------------------------
         */
        
        public function discharge_patient () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( $sale_id > 0 ) {
                $this -> IPDModel -> discharge_patient ( $sale_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Patient has been discharged.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * all sales
         * which are discharged
         * -------------------------
         */
        
        public function add_admission_order () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_mo_add_admission_orders' )
                $this -> do_mo_add_admission_orders ();
            
            $title = site_name . ' - Add Admission Orders';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ]   = $this -> DoctorModel -> get_doctors ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines_that_has_stock ();
            $this -> load -> view ( '/ipd/mo/add_admission_order', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add more admission orders
         * -------------------------
         */
        
        public function add_more_admission_orders () {
            $data[ 'services' ]  = $this -> IPDModel -> get_parent_services ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines_that_has_stock ();
            $data[ 'row' ]       = $_POST[ 'added' ];
            $this -> load -> view ( '/ipd/mo/add-more', $data );
        }
        
        /**
         * -------------------------
         * do add MO admission orders
         * -------------------------
         */
        
        public function do_mo_add_admission_orders () {
            $this -> form_validation -> set_rules ( 'drug_allergies', 'drug allergies', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'patient_id', 'patient id', 'required|trim|min_length[1]|xss_clean|numeric' );
            if ( $this -> form_validation -> run () == true ) {
                $drug_allergies = $_POST[ 'drug_allergies' ];
                $patient_id     = $_POST[ 'patient_id' ];
                $date_time      = $_POST[ 'date_time' ];
                $doctor_id      = $_POST[ 'doctor_id' ];
                $diagnosis      = $_POST[ 'diagnosis' ];
                $condition      = $_POST[ 'condition' ];
                $activity       = $_POST[ 'activity' ];
                $vital_signs    = $_POST[ 'vital_signs' ];
                $diet           = $_POST[ 'diet' ];
                $investigations = $_POST[ 'investigations' ];
                $medicine       = $_POST[ 'medicine' ];
                $nurse_initials = $_POST[ 'nurse_initials' ];
                $admission_no   = $_POST[ 'admission_no' ];
                
                //			if($admission_no > 0) {
                $order    = array (
                    'user_id'        => get_logged_in_user_id (),
                    'patient_id'     => $patient_id,
                    'drug_allergies' => $drug_allergies,
                    'date_added'     => current_date_time (),
                );
                $order_id = $this -> IPDModel -> do_mo_add_admission_orders ( $order );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $patient_id,
                    'order_id'     => $order_id,
                    'action'       => 'mo_admission_order_added',
                    'log'          => json_encode ( $order ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'mo_logs', $log );
                
                /***********END LOG*************/
                
                if ( $order_id > 0 ) {
                    if ( count ( $date_time ) > 0 ) {
                        foreach ( $date_time as $key => $value ) {
                            $info = array (
                                'user_id'         => get_logged_in_user_id (),
                                'order_id'        => $order_id,
                                'admission_no'    => $admission_no,
                                'medicine'        => $medicine[ $key ],
                                'doctor_id'       => $doctor_id[ $key ],
                                'order_date_time' => date ( "Y-m-d H:i:s", strtotime ( $value ) ),
                                'diagnosis'       => $diagnosis[ $key ],
                                'condition'       => $condition[ $key ],
                                'activity'        => $activity[ $key ],
                                'vital_signs'     => $vital_signs[ $key ],
                                'diet'            => $diet[ $key ],
                                'investigation'   => $investigations[ $key ],
                                'nurse_initials'  => $nurse_initials[ $key ],
                                'date_added'      => current_date_time ()
                            );
                            $this -> IPDModel -> do_mo_add_admission_record ( $info );
                            
                            /***********LOGS*************/
                            
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'patient_id'   => $patient_id,
                                'order_id'     => $order_id,
                                'action'       => 'mo_admission_order_info_added',
                                'log'          => json_encode ( $info ),
                                'after_update' => '',
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'mo_logs', $log );
                            
                            /***********END LOG*************/
                            
                        }
                    }
                    
                    
                    $this -> session -> set_flashdata ( 'response', 'Success! MO record has been saved.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                //			}
                //			else {
                //				$this -> session -> set_flashdata('error', 'Error! Admission number does not exists.');
                //				return redirect($_SERVER['HTTP_REFERER']);
                //			}
            }
        }
        
        /**
         * -------------------------
         * load all admission orders
         * by latest
         * -------------------------
         */
        
        public function mo_admission_orders () {
            $title = site_name . ' - All Admission Orders';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'orders' ] = $this -> IPDModel -> get_mo_admission_orders ();
            $this -> load -> view ( '/ipd/mo/admission_orders', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * delete admission orders
         * -------------------------
         */
        
        public function delete_admission_order () {
            $order_id = $this -> uri -> segment ( 4 );
            if ( $order_id > 0 ) {
                $this -> IPDModel -> delete_admission_order ( $order_id );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => 0,
                    'order_id'     => $order_id,
                    'action'       => 'mo_admission_order_deleted',
                    'log'          => json_encode ( $order_id ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'mo_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! MO order has been deleted.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * delete payment
         * -------------------------
         */
        
        public function delete_payment () {
            $payment_id = $this -> uri -> segment ( 3 );
            if ( $payment_id > 0 ) {
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => 0,
                    'sale_id'      => 0,
                    'action'       => 'ipd_sale_payment_deleted',
                    'log'          => json_encode ( $payment_id ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                
                /***********END LOG*************/
                
                $this -> IPDModel -> delete_payment ( $payment_id );
                $this -> AccountModel -> delete_payment ( $payment_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Payment deleted.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * edit order page
         * -------------------------
         */
        
        public function edit_admission_order () {
            
            $order_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $order_id ) ) or !is_numeric ( $order_id ) or $order_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_mo_edit_admission_orders' )
                $this -> do_mo_edit_admission_orders ();
            
            $title = site_name . ' - Edit Admission Order';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'orders' ] = $this -> IPDModel -> get_mo_admission_order_record ( $order_id );
            $data[ 'order' ]  = $this -> IPDModel -> get_mo_admission_order ( $order_id );
            $this -> load -> view ( '/ipd/mo/edit_admission_order', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * do edit MO admission orders
         * -------------------------
         */
        
        public function do_mo_edit_admission_orders () {
            $this -> form_validation -> set_rules ( 'drug_allergies', 'drug allergies', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'patient_id', 'patient id', 'required|trim|min_length[1]|xss_clean|numeric' );
            if ( $this -> form_validation -> run () == true ) {
                $date_time      = $_POST[ 'date_time' ];
                $doctor_id      = $_POST[ 'doctor_id' ];
                $diagnosis      = $_POST[ 'diagnosis' ];
                $condition      = $_POST[ 'condition' ];
                $activity       = $_POST[ 'activity' ];
                $vital_signs    = $_POST[ 'vital_signs' ];
                $diet           = $_POST[ 'diet' ];
                $investigations = $_POST[ 'investigations' ];
                $medicine       = $_POST[ 'medicine' ];
                $nurse_initials = $_POST[ 'nurse_initials' ];
                $order_id       = $_POST[ 'order_id' ];
                
                if ( $order_id > 0 ) {
                    if ( count ( $date_time ) > 0 ) {
                        $this -> IPDModel -> delete_mo_add_admission_record ( $order_id );
                        foreach ( $date_time as $key => $value ) {
                            $info = array (
                                'user_id'         => get_logged_in_user_id (),
                                'order_id'        => $order_id,
                                'medicine'        => $medicine[ $key ],
                                'doctor_id'       => $doctor_id[ $key ],
                                'order_date_time' => date ( "Y-m-d H:i:s", strtotime ( $value ) ),
                                'diagnosis'       => $diagnosis[ $key ],
                                'condition'       => $condition[ $key ],
                                'activity'        => $activity[ $key ],
                                'vital_signs'     => $vital_signs[ $key ],
                                'diet'            => $diet[ $key ],
                                'investigation'   => $investigations[ $key ],
                                'nurse_initials'  => $nurse_initials[ $key ],
                                'date_added'      => current_date_time ()
                            );
                            $this -> IPDModel -> do_mo_add_admission_record ( $info );
                            
                            /***********LOGS*************/
                            
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'patient_id'   => 0,
                                'order_id'     => $order_id,
                                'action'       => 'mo_admission_order_updated',
                                'log'          => json_encode ( $info ),
                                'after_update' => '',
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'mo_logs', $log );
                            
                            /***********END LOG*************/
                            
                        }
                    }
                    $this -> session -> set_flashdata ( 'response', 'Success! MO record has been updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * edit order page
         * -------------------------
         */
        
        public function delete_admission_order_order () {
            
            $record_id = $_REQUEST[ 'record_id' ];
            if ( empty( trim ( $record_id ) ) or !is_numeric ( $record_id ) or $record_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'patient_id'   => 0,
                'order_id'     => $record_id,
                'action'       => 'mo_admission_order_deleted',
                'log'          => json_encode ( $record_id ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'mo_logs', $log );
            
            /***********END LOG*************/
            
            $this -> IPDModel -> delete_admission_order_record ( $record_id );
            $this -> session -> set_flashdata ( 'response', 'Success! MO record has been deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * add physical examination
         * page
         * -------------------------
         */
        
        public function add_physical_examination () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_mo_add_physical_examination' )
                $this -> do_mo_add_physical_examination ();
            
            $title = site_name . ' - Add Physical Examination';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $this -> load -> view ( '/ipd/mo/add_physical_examination', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add physical examination
         * page
         * -------------------------
         */
        
        public function add_more_physical_examination () {
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'row' ]     = $_POST[ 'added' ];
            $this -> load -> view ( '/ipd/mo/add_more_physical_examination', $data );
        }
        
        /**
         * -------------------------
         * do add physical examination
         * -------------------------
         */
        
        public function do_mo_add_physical_examination () {
            $this -> form_validation -> set_rules ( 'patient_id', 'patient id', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'examination_date', 'examination date', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $patient_id       = $_POST[ 'patient_id' ];
                $examination_date = $_POST[ 'examination_date' ];
                $doctor_id        = $_POST[ 'doctor_id' ];
                $admission_no     = $_POST[ 'admission_no' ];
                $room_bed_no      = $_POST[ 'room_bed_no' ];
                $complaints       = $_POST[ 'complaints' ];
                $illness          = $_POST[ 'illness' ];
                $medical_history  = $_POST[ 'medical_history' ];
                $family_history   = $_POST[ 'family_history' ];
                $physical_exam    = $_POST[ 'physical_exam' ];
                $git              = $_POST[ 'git' ];
                $resp             = $_POST[ 'resp' ];
                $cvs              = $_POST[ 'cvs' ];
                $cns              = $_POST[ 'cns' ];
                $p_diag           = $_POST[ 'p_diag' ];
                
                if ( isset( $doctor_id ) and count ( $doctor_id ) > 0 ) {
                    foreach ( $doctor_id as $key => $value ) {
                        $order = array (
                            'user_id'          => get_logged_in_user_id (),
                            'patient_id'       => $patient_id,
                            'doctor_id'        => $value,
                            'examination_date' => date ( 'Y-m-d', strtotime ( $examination_date ) ),
                            'admission_no'     => $admission_no[ $key ],
                            'room_bed_no'      => $room_bed_no[ $key ],
                            'complaints'       => $complaints[ $key ],
                            'illness'          => $illness[ $key ],
                            'past_history'     => $medical_history[ $key ],
                            'family_history'   => $family_history[ $key ],
                            'physical_exam'    => $physical_exam[ $key ],
                            'git'              => $git[ $key ],
                            'resp_s'           => $resp[ $key ],
                            'cvs'              => $cvs[ $key ],
                            'cns'              => $cns[ $key ],
                            'p_diag'           => $p_diag[ $key ],
                            'date_added'       => current_date_time (),
                        );
                        $this -> IPDModel -> do_mo_add_physical_examination ( $order );
                        
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Physical examination has been saved.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * load all physical examinations
         * by latest
         * -------------------------
         */
        
        public function all_physical_examination () {
            $title = site_name . ' - All Physical Examinations';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'examinations' ] = $this -> IPDModel -> get_physical_examination ();
            $this -> load -> view ( '/ipd/mo/physical_examinations', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * delete physical examination
         * -------------------------
         */
        
        public function delete_physical_examination () {
            
            $examination_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $examination_id ) ) or !is_numeric ( $examination_id ) or $examination_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> IPDModel -> delete_physical_examination ( $examination_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Physical examination has been deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * edit physical examination
         * -------------------------
         */
        
        public function edit_physical_examination () {
            
            $examination_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $examination_id ) ) or !is_numeric ( $examination_id ) or $examination_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_mo_edit_physical_examination' )
                $this -> do_mo_edit_physical_examination ();
            
            $title = site_name . ' - Edit Physical Examination';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ]     = $this -> DoctorModel -> get_doctors ();
            $data[ 'examination' ] = $this -> IPDModel -> get_physical_examination_by_id ( $examination_id );
            $this -> load -> view ( '/ipd/mo/edit_physical_examination', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * update physical examination
         * -------------------------
         */
        
        public function do_mo_edit_physical_examination () {
            $this -> form_validation -> set_rules ( 'patient_id', 'patient id', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'examination_date', 'examination date', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'examination_id', 'examination id', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $patient_id       = $_POST[ 'patient_id' ];
                $examination_date = $_POST[ 'examination_date' ];
                $doctor_id        = $_POST[ 'doctor_id' ];
                $admission_no     = $_POST[ 'admission_no' ];
                $room_bed_no      = $_POST[ 'room_bed_no' ];
                $complaints       = $_POST[ 'complaints' ];
                $illness          = $_POST[ 'illness' ];
                $medical_history  = $_POST[ 'medical_history' ];
                $family_history   = $_POST[ 'family_history' ];
                $physical_exam    = $_POST[ 'physical_exam' ];
                $git              = $_POST[ 'git' ];
                $resp             = $_POST[ 'resp' ];
                $cvs              = $_POST[ 'cvs' ];
                $cns              = $_POST[ 'cns' ];
                $p_diag           = $_POST[ 'p_diag' ];
                $examination_id   = $_POST[ 'examination_id' ];
                
                if ( isset( $doctor_id ) and count ( $doctor_id ) > 0 ) {
                    foreach ( $doctor_id as $key => $value ) {
                        $order = array (
                            'patient_id'       => $patient_id,
                            'doctor_id'        => $value,
                            'examination_date' => date ( 'Y-m-d', strtotime ( $examination_date ) ),
                            'admission_no'     => $admission_no[ $key ],
                            'room_bed_no'      => $room_bed_no[ $key ],
                            'complaints'       => $complaints[ $key ],
                            'illness'          => $illness[ $key ],
                            'past_history'     => $medical_history[ $key ],
                            'family_history'   => $family_history[ $key ],
                            'physical_exam'    => $physical_exam[ $key ],
                            'git'              => $git[ $key ],
                            'resp_s'           => $resp[ $key ],
                            'cvs'              => $cvs[ $key ],
                            'cns'              => $cns[ $key ],
                            'p_diag'           => $p_diag[ $key ],
                        );
                        $this -> IPDModel -> do_mo_edit_physical_examination ( $order, $examination_id );
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Physical examination has been updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * add progress notes
         * page
         * -------------------------
         */
        
        public function add_progress_notes () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_mo_add_progress_notes' )
                $this -> do_mo_add_progress_notes ();
            
            $title = site_name . ' - Add Progress notes';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/ipd/mo/add_progress_notes' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add progress notes
         * -------------------------
         */
        
        public function do_mo_add_progress_notes () {
            $this -> form_validation -> set_rules ( 'patient_id', 'patient id', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'date_admit', 'date admit', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'admission_no', 'admission no', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'room_bed_no', 'room bed no', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $patient_id   = $_POST[ 'patient_id' ];
                $date_admit   = $_POST[ 'date_admit' ];
                $admission_no = $_POST[ 'admission_no' ];
                $room_bed_no  = $_POST[ 'room_bed_no' ];
                $notes        = $_POST[ 'notes' ];
                
                if ( isset( $notes ) and count ( $notes ) > 0 ) {
                    $progress = array (
                        'user_id'      => get_logged_in_user_id (),
                        'patient_id'   => $patient_id,
                        'room'         => $room_bed_no,
                        'admission_no' => $admission_no,
                        'date_admit'   => date ( 'Y-m-d', strtotime ( $date_admit ) ),
                        'date_added'   => current_date_time ()
                    );
                    $id       = $this -> IPDModel -> add_progress ( $progress );
                    foreach ( $notes as $note ) {
                        if ( !empty( trim ( $note ) ) ) {
                            $notes = array (
                                'progress_id' => $id,
                                'notes'       => $note,
                                'date_added'  => current_date_time ()
                            );
                            $this -> IPDModel -> do_mo_add_progress_notes ( $notes );
                        }
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Progress notes has been updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * load all progress notes
         * by latest
         * -------------------------
         */
        
        public function all_progress_notes () {
            $title = site_name . ' - Progress Notes';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'notes' ] = $this -> IPDModel -> get_progress_notes ();
            $this -> load -> view ( '/ipd/mo/all_progress_notes', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * delete progress notes
         * -------------------------
         */
        
        public function delete_progress_notes () {
            
            $progress_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $progress_id ) ) or !is_numeric ( $progress_id ) or $progress_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> IPDModel -> delete_progress_notes ( $progress_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Progress notes has been deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * edit progress notes
         * -------------------------
         */
        
        public function edit_progress_notes () {
            
            $progress_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $progress_id ) ) or !is_numeric ( $progress_id ) or $progress_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_mo_edit_progress_notes' )
                $this -> do_mo_edit_progress_notes ();
            
            $title = site_name . ' - Edit Physical Examination';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'progress' ] = $this -> IPDModel -> get_progress ( $progress_id );
            $data[ 'notes' ]    = $this -> IPDModel -> get_progress_notes_by_id ( $progress_id );
            $this -> load -> view ( '/ipd/mo/edit_progress_notes', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add progress notes
         * -------------------------
         */
        
        public function do_mo_edit_progress_notes () {
            $this -> form_validation -> set_rules ( 'patient_id', 'patient id', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'progress_id', 'progress id', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'date_admit', 'date admit', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'admission_no', 'admission no', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'room_bed_no', 'room bed no', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $notes       = $_POST[ 'notes' ];
                $progress_id = $_POST[ 'progress_id' ];
                
                if ( isset( $notes ) and count ( $notes ) > 0 ) {
                    $this -> IPDModel -> delete_progress_notes_by_id ( $progress_id );
                    foreach ( $notes as $note ) {
                        if ( !empty( trim ( $note ) ) ) {
                            $notes = array (
                                'progress_id' => $progress_id,
                                'notes'       => $note,
                                'date_added'  => current_date_time ()
                            );
                            $this -> IPDModel -> do_mo_add_progress_notes ( $notes );
                        }
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Progress notes has been updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete progress notes
         * -------------------------
         */
        
        public function delete_progress_note () {
            
            $note_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $note_id ) ) or !is_numeric ( $note_id ) or $note_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> IPDModel -> delete_progress_note ( $note_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Progress note has been deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * add blood transfusion
         * page
         * -------------------------
         */
        
        public function add_blood_transfusion () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_mo_add_blood_transfusion' )
                $this -> do_mo_add_blood_transfusion ();
            
            $title = site_name . ' - Add Blood Transfusion';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/ipd/mo/add_blood_transfusion' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add blood transfusion
         * -------------------------
         */
        
        public function do_mo_add_blood_transfusion () {
            $patient_id              = $_POST[ 'patient_id' ];
            $diagnosis               = $_POST[ 'diagnosis' ];
            $blood_group             = $_POST[ 'blood_group' ];
            $no_of_blood_transferred = $_POST[ 'no_of_blood_transferred' ];
            $rh                      = $_POST[ 'rh' ];
            $indication              = $_POST[ 'indication' ];
            $components              = $_POST[ 'components' ];
            $units                   = $_POST[ 'units' ];
            $admission_no            = $_POST[ 'admission_no' ];
            if ( count ( $diagnosis ) > 0 ) {
                foreach ( $diagnosis as $key => $value ) {
                    $info = array (
                        'user_id'                 => get_logged_in_user_id (),
                        'patient_id'              => $patient_id,
                        'admission_no'            => $admission_no,
                        'diagnosis'               => $value,
                        'blood_group'             => $blood_group[ $key ],
                        'no_of_blood_transferred' => $no_of_blood_transferred[ $key ],
                        'rh'                      => $rh[ $key ],
                        'indication'              => $indication[ $key ],
                        'components'              => $components[ $key ],
                        'units'                   => $units[ $key ],
                        'date_added'              => current_date_time (),
                    );
                    $this -> IPDModel -> do_mo_add_blood_transfusion ( $info );
                }
            }
            $this -> session -> set_flashdata ( 'response', 'Success! Blood transfusion record has been saved.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * all blood transfusion
         * page
         * -------------------------
         */
        
        public function all_blood_transfusion () {
            $title = site_name . ' - All Blood Transfusion';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'transfusions' ] = $this -> IPDModel -> get_blood_transfusions ();
            $this -> load -> view ( '/ipd/mo/all_blood_transfusion', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * delete progress notes
         * -------------------------
         */
        
        public function delete_blood_transfusion () {
            
            $trans_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $trans_id ) ) or !is_numeric ( $trans_id ) or $trans_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> IPDModel -> delete_blood_transfusion ( $trans_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Blood transfusion has been deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * edit blood transfusion
         * -------------------------
         */
        
        public function edit_blood_transfusion () {
            
            $patient_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $patient_id ) ) or !is_numeric ( $patient_id ) or $patient_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_mo_edit_blood_transfusion' )
                $this -> do_mo_edit_blood_transfusion ();
            
            $title = site_name . ' - Edit Blood Transfusion';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'transfusions' ] = $this -> IPDModel -> get_blood_transfusion ( $patient_id );
            $this -> load -> view ( '/ipd/mo/edit_blood_transfusion', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * edit blood transfusion
         * -------------------------
         */
        
        public function do_mo_edit_blood_transfusion () {
            $patient_id              = $_POST[ 'patient_id' ];
            $diagnosis               = $_POST[ 'diagnosis' ];
            $blood_group             = $_POST[ 'blood_group' ];
            $no_of_blood_transferred = $_POST[ 'no_of_blood_transferred' ];
            $rh                      = $_POST[ 'rh' ];
            $indication              = $_POST[ 'indication' ];
            $components              = $_POST[ 'components' ];
            $units                   = $_POST[ 'units' ];
            if ( count ( $diagnosis ) > 0 ) {
                $this -> IPDModel -> delete_blood_transfusion ( $patient_id );
                foreach ( $diagnosis as $key => $value ) {
                    $info = array (
                        'user_id'                 => get_logged_in_user_id (),
                        'patient_id'              => $patient_id,
                        'diagnosis'               => $value,
                        'blood_group'             => $blood_group[ $key ],
                        'no_of_blood_transferred' => $no_of_blood_transferred[ $key ],
                        'rh'                      => $rh[ $key ],
                        'indication'              => $indication[ $key ],
                        'components'              => $components[ $key ],
                        'units'                   => $units[ $key ],
                        'date_added'              => current_date_time (),
                    );
                    $this -> IPDModel -> do_mo_add_blood_transfusion ( $info );
                }
            }
            $this -> session -> set_flashdata ( 'response', 'Success! Blood transfusion record has been saved.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * add discharge slip
         * page
         * -------------------------
         */
        
        public function add_discharge_slip () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_mo_add_discharge_slip' )
                $this -> do_mo_add_discharge_slip ();
            
            $title = site_name . ' - Add Discharge Slip';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $this -> load -> view ( '/ipd/mo/add_discharge_slip', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * do add discharge slip
         * -------------------------
         */
        
        public function do_mo_add_discharge_slip () {
            $doctor_id           = $_POST[ 'doctor_id' ];
            $admission_no        = $_POST[ 'admission_no' ];
            $patient_id          = $_POST[ 'patient_id' ];
            $panel_pvt           = $_POST[ 'panel_pvt' ];
            $room_bed_no         = $_POST[ 'room_bed_no' ];
            $admission_date      = $_POST[ 'admission_date' ];
            $discharge_date      = $_POST[ 'discharge_date' ];
            $diagnosis           = $_POST[ 'diagnosis' ];
            $operation_procedure = $_POST[ 'operation_procedure' ];
            $rest_advise         = $_POST[ 'rest_advise' ];
            $days_week           = $_POST[ 'days_week' ];
            $follow_up_treatment = $_POST[ 'follow_up_treatment' ];
            $revisit_on          = $_POST[ 'revisit_on' ];
            if ( $admission_no > 0 ) {
                $info = array (
                    'user_id'             => get_logged_in_user_id (),
                    'doctor_id'           => $doctor_id,
                    'admission_no'        => $admission_no,
                    'patient_id'          => $patient_id,
                    'panel_pvt'           => $panel_pvt,
                    'room_bed_no'         => $room_bed_no,
                    'admission_date'      => date ( 'Y-m-d', strtotime ( $admission_date ) ),
                    'discharge_date'      => date ( 'Y-m-d', strtotime ( $discharge_date ) ),
                    'diagnosis'           => $diagnosis,
                    'operation_procedure' => $operation_procedure,
                    'rest_advise'         => $rest_advise,
                    'days_week'           => $days_week,
                    'follow_up_treatment' => $follow_up_treatment,
                    'revisit_on'          => $revisit_on,
                    'date_added'          => current_date_time (),
                );
                $this -> IPDModel -> do_mo_add_discharge_slip ( $info );
                $this -> session -> set_flashdata ( 'response', 'Success! Discharge slip has been saved.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Admission number does not exists.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * edit discharge slip
         * page
         * -------------------------
         */
        
        public function edit_discharge_slip () {
            
            $id = $this -> uri -> segment ( 4 );
            if ( !$id or !is_numeric ( $id ) or $id < 1 )
                return redirect ( base_url ( '/IPD/mo/all-discharge-slips' ) );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_mo_edit_discharge_slip' )
                $this -> do_mo_edit_discharge_slip ();
            
            $title = site_name . ' - Edit Discharge Slip';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'slip' ]    = $this -> IPDModel -> get_discharge_slip_by_id ( $id );
            $data[ 'patient' ] = get_patient_by_id ( $data[ 'slip' ] -> patient_id );
            $this -> load -> view ( '/ipd/mo/edit_discharge_slip', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * do edit discharge slip
         * -------------------------
         */
        
        public function do_mo_edit_discharge_slip () {
            $doctor_id           = $_POST[ 'doctor_id' ];
            $admission_no        = $_POST[ 'admission_no' ];
            $panel_pvt           = $_POST[ 'panel_pvt' ];
            $room_bed_no         = $_POST[ 'room_bed_no' ];
            $admission_date      = $_POST[ 'admission_date' ];
            $discharge_date      = $_POST[ 'discharge_date' ];
            $diagnosis           = $_POST[ 'diagnosis' ];
            $operation_procedure = $_POST[ 'operation_procedure' ];
            $rest_advise         = $_POST[ 'rest_advise' ];
            $days_week           = $_POST[ 'days_week' ];
            $follow_up_treatment = $_POST[ 'follow_up_treatment' ];
            $revisit_on          = $_POST[ 'revisit_on' ];
            $id                  = $_POST[ 'id' ];
            if ( $id > 0 ) {
                $info  = array (
                    'doctor_id'           => $doctor_id,
                    'admission_no'        => $admission_no,
                    'panel_pvt'           => $panel_pvt,
                    'room_bed_no'         => $room_bed_no,
                    'admission_date'      => date ( 'Y-m-d', strtotime ( $admission_date ) ),
                    'discharge_date'      => date ( 'Y-m-d', strtotime ( $discharge_date ) ),
                    'diagnosis'           => $diagnosis,
                    'operation_procedure' => $operation_procedure,
                    'rest_advise'         => $rest_advise,
                    'days_week'           => $days_week,
                    'follow_up_treatment' => $follow_up_treatment,
                    'revisit_on'          => $revisit_on,
                );
                $where = array (
                    'id' => $id
                );
                $this -> IPDModel -> do_mo_update_discharge_slip ( $info, $where );
                $this -> session -> set_flashdata ( 'response', 'Success! Discharge slip has been updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Slip id does not exists.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * get patient by admission number
         * -------------------------
         */
        
        public function get_patient_by_admission_no () {
            $admission_number = $_POST[ 'admission_number' ];
            if ( !empty( trim ( $admission_number ) ) ) {
                $record = $this -> IPDModel -> get_patient_by_admission_no ( $admission_number );
                if ( $record ) {
                    $patient = get_patient ( $record -> patient_id );
                    $info    = array (
                        'id'           => $patient -> id,
                        'name'         => get_patient_name ( 0, $patient ),
                        'age'          => $patient -> age,
                        'sex'          => $patient -> gender == '1' ? 'Male' : 'Female',
                        'admission_no' => $record -> admission_no,
                    );
                    echo json_encode ( $info );
                }
                else
                    echo 'false';
            }
            else
                echo 'false';
        }
        
        /**
         * -------------------------
         * all discharge slips
         * page
         * -------------------------
         */
        
        public function all_discharge_slips () {
            $title = site_name . ' - All Discharge Slips';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'slips' ] = $this -> IPDModel -> get_all_discharge_slips ();
            $this -> load -> view ( '/ipd/mo/all_discharge_slips', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * all discharge slips
         * page
         * -------------------------
         */
        
        public function add_diagnostic_flow_sheet () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_mo_add_diagnostic_flow_sheet' )
                $this -> do_mo_add_diagnostic_flow_sheet ();
            
            $title = site_name . ' - Add Diagnostic Flow Sheet';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'tests' ] = $this -> LabModel -> get_parent_tests ();
            $this -> load -> view ( '/ipd/mo/add_diagnostic_flow_sheet', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * all discharge slips
         * page
         * -------------------------
         */
        
        public function add_more_diagnostic_flow_sheet () {
            $data[ 'row' ]   = $_POST[ 'added' ];
            $data[ 'tests' ] = $this -> LabModel -> get_parent_tests ();
            $this -> load -> view ( '/ipd/mo/add_more_diagnostic_flow_sheet', $data );
        }
        
        /**
         * -------------------------
         * add diagnostics
         * -------------------------
         */
        
        public function do_mo_add_diagnostic_flow_sheet () {
            $tests        = $_POST[ 'test_id' ];
            $test_date    = $_POST[ 'test_date' ];
            $patient_id   = $_POST[ 'patient_id' ];
            $admission_no = $_POST[ 'admission_no' ];
            if ( count ( $tests ) > 0 ) {
                foreach ( $tests as $key => $test_id ) {
                    if ( !empty( trim ( $test_id ) ) and $test_id > 0 ) {
                        $info = array (
                            'user_id'      => get_logged_in_user_id (),
                            'patient_id'   => $patient_id,
                            'test_id'      => $test_id,
                            'admission_no' => $admission_no,
                            'test_date'    => date ( 'Y-m-d', strtotime ( $test_date[ $key ] ) ),
                            'date_added'   => current_date_time ()
                        );
                        $this -> IPDModel -> do_mo_add_diagnostic_flow_sheet ( $info );
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Diagnostics flow sheet has been updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * all diagnostics
         * page
         * -------------------------
         */
        
        public function all_diagnostic_flow_sheet () {
            $title = site_name . ' - All Diagnostic Flow Sheet';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'diagnostics' ] = $this -> IPDModel -> get_diagnostics_sheet ();
            $this -> load -> view ( '/ipd/mo/all_diagnostic_flow_sheet', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * delete diagnostic flow
         * -------------------------
         */
        
        public function delete_diagnostic_flow_sheet () {
            
            $patient_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $patient_id ) ) or !is_numeric ( $patient_id ) or $patient_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> IPDModel -> delete_diagnostic_flow_sheet ( $patient_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Diagnostics has been deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * edit diagnostics
         * page
         * -------------------------
         */
        
        public function edit_diagnostic_flow_sheet () {
            
            $patient_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $patient_id ) ) or !is_numeric ( $patient_id ) or $patient_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_mo_edit_diagnostic_flow_sheet' )
                $this -> do_mo_edit_diagnostic_flow_sheet ();
            
            $title = site_name . ' - Edit Diagnostic Flow Sheet';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'diagnostics' ] = $this -> IPDModel -> get_diagnostics_sheet_by_patient_id ( $patient_id );
            $this -> load -> view ( '/ipd/mo/edit_diagnostic_flow_sheet', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * edit diagnostics
         * -------------------------
         */
        
        public function do_mo_edit_diagnostic_flow_sheet () {
            $tests      = $_POST[ 'test_id' ];
            $test_date  = $_POST[ 'test_date' ];
            $patient_id = $_POST[ 'patient_id' ];
            if ( count ( $tests ) > 0 ) {
                $this -> IPDModel -> delete_diagnostic_flow_sheet ( $patient_id );
                foreach ( $tests as $key => $test_id ) {
                    if ( !empty( trim ( $test_id ) ) and $test_id > 0 ) {
                        $info = array (
                            'user_id'    => get_logged_in_user_id (),
                            'patient_id' => $patient_id,
                            'test_id'    => $test_id,
                            'test_date'  => date ( 'Y-m-d', strtotime ( $test_date[ $key ] ) ),
                            'date_added' => current_date_time ()
                        );
                        $this -> IPDModel -> do_mo_add_diagnostic_flow_sheet ( $info );
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Diagnostics flow sheet has been updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete diagnostic flow
         * -------------------------
         */
        
        public function delete_diagnostic () {
            
            $diagnostic_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $diagnostic_id ) ) or !is_numeric ( $diagnostic_id ) or $diagnostic_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> IPDModel -> delete_diagnostic ( $diagnostic_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Diagnostic has been deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * add discharge summary
         * page
         * -------------------------
         */
        
        public function add_discharge_summary () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_mo_add_discharge_summary' )
                $this -> do_mo_add_discharge_summary ();
            
            $title = site_name . ' - Add Discharge Summary';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ]      = $this -> DoctorModel -> get_doctors ();
            $data[ 'medicines' ]    = $this -> MedicineModel -> get_medicines_that_has_stock ();
            $data[ 'services' ]     = $this -> IPDModel -> get_parent_services ();
            $data[ 'instructions' ] = $this -> InstructionModel -> get_instructions ();
            $this -> load -> view ( '/ipd/mo/add_discharge_summary', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add discharge summary
         * -------------------------
         */
        
        public function do_mo_add_discharge_summary () {
            $info         = array (
                'user_id'              => get_logged_in_user_id (),
                'patient_id'           => $_POST[ 'patient_id' ],
                'admission_no'         => $_POST[ 'admission_no' ],
                'discharge_date'       => date ( 'Y-m-d', strtotime ( $_POST[ 'discharge_date' ] ) ),
                'admission_date'       => date ( 'Y-m-d', strtotime ( $_POST[ 'admission_date' ] ) ),
                'consultant_id'        => $_POST[ 'consultant_id' ],
                'medical_officer'      => $_POST[ 'medical_officer' ],
                'allergy'              => $_POST[ 'allergy' ],
                'primary_diagnosis'    => $_POST[ 'primary_diagnosis' ],
                'secondary_diagnosis'  => $_POST[ 'secondary_diagnosis' ],
                'course'               => $_POST[ 'course' ],
                'findings'             => $_POST[ 'findings' ],
                'pertinent_diagnostic' => $_POST[ 'pertinent_diagnostic' ],
                'patient_condition'    => $_POST[ 'patient_condition' ],
                'diet'                 => $_POST[ 'diet' ],
                'activity'             => $_POST[ 'activity' ],
                'instructions'         => $_POST[ 'instruction' ],
                'icoe'                 => $_POST[ 'icoe' ],
                'date_added'           => current_date_time ()
            );
            $discharge_id = $this -> IPDModel -> do_mo_add_discharge_summary ( $info );
            if ( $discharge_id > 0 ) {
                $medicine_id   = $_POST[ 'medicine_id' ];
                $service_id    = $_POST[ 'service_id' ];
                $medication_id = $_POST[ 'medicines' ];
                if ( count ( $medicine_id ) > 0 ) {
                    foreach ( $medicine_id as $medicine ) {
                        if ( $medicine > 0 ) {
                            $medicines = array (
                                'discharge_id' => $discharge_id,
                                'medicine_id'  => $medicine,
                                'date_added'   => current_date_time ()
                            );
                            $this -> IPDModel -> do_mo_add_discharge_summary_medicines_hosp ( $medicines );
                        }
                    }
                }
                if ( count ( $service_id ) > 0 ) {
                    foreach ( $service_id as $service ) {
                        if ( $service > 0 ) {
                            $services = array (
                                'discharge_id' => $discharge_id,
                                'service_id'   => $service,
                                'date_added'   => current_date_time ()
                            );
                            $this -> IPDModel -> do_mo_add_discharge_summary_services ( $services );
                        }
                    }
                }
                if ( count ( $medication_id ) > 0 ) {
                    foreach ( $medication_id as $key => $value ) {
                        if ( $value > 0 ) {
                            $services = array (
                                'discharge_id'   => $discharge_id,
                                'medicine_id'    => $value,
                                'instruction_id' => $_POST[ 'instructions' ][ $key ],
                                'dosage'         => $_POST[ 'dosage' ][ $key ],
                                'timings'        => $_POST[ 'timings' ][ $key ],
                                'days'           => $_POST[ 'days' ][ $key ],
                                'date_added'     => current_date_time ()
                            );
                            $this -> IPDModel -> do_mo_add_discharge_summary_instructions ( $services );
                        }
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Discharge summary has been updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * add more medications
         * -------------------------
         */
        
        public function add_more_medicines () {
            $data[ 'row' ]       = $_POST[ 'added' ];
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines_that_has_stock ();
            $this -> load -> view ( '/ipd/mo/add_more_medicines', $data );
        }
        
        /**
         * -------------------------
         * add more services
         * -------------------------
         */
        
        public function add_more_services () {
            $data[ 'row' ]      = $_POST[ 'added' ];
            $data[ 'services' ] = $this -> IPDModel -> get_parent_services ();
            $this -> load -> view ( '/ipd/mo/add_more_services', $data );
        }
        
        /**
         * -------------------------
         * all discharge summary
         * page
         * -------------------------
         */
        
        public function all_discharge_summary () {
            $title = site_name . ' - All Discharge Summary';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'summary' ] = $this -> IPDModel -> get_discharge_summary ();
            $this -> load -> view ( '/ipd/mo/all_discharge_summary', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * delete diagnostic flow
         * -------------------------
         */
        
        public function delete_discharge_summary () {
            
            $discharge_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $discharge_id ) ) or !is_numeric ( $discharge_id ) or $discharge_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> IPDModel -> delete_discharge_summary ( $discharge_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Discharge summary has been deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * check if patient has admission no
         * -------------------------
         */
        
        public function check_if_patient_has_admission_order () {
            $patient_id = $this -> input -> post ( 'patient_id' );
            if ( !empty( $patient_id ) and $patient_id > 0 ) {
                $record = $this -> IPDModel -> check_if_patient_has_admission_order ( $patient_id );
                if ( $record )
                    echo 'true';
                else
                    echo 'false';
            }
        }
        
        /**
         * -------------------------
         * check if patient is already
         * in ipd and not discharged
         * -------------------------
         */
        
        public function check_if_patient_is_already_in_ipd_and_not_discharged () {
            $patient_id = $this -> input -> post ( 'patient_id' );
            if ( !empty( $patient_id ) and $patient_id > 0 ) {
                $record = $this -> IPDModel -> check_if_patient_is_already_in_ipd_and_not_discharged ( $patient_id );
                if ( $record )
                    echo 'true';
                else
                    echo 'false';
            }
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * clear bill
         * -------------------------
         */
        
        public function clear_bill () {
            $sale_id = $_REQUEST[ 'sale_id' ];
            if ( $sale_id > 0 ) {
                $info = array (
                    'user_id'    => get_logged_in_user_id (),
                    'sale_id'    => $sale_id,
                    'cleared'    => 1,
                    'date_added' => current_date_time ()
                );
                $id   = $this -> IPDModel -> clear_bill ( $info );
                if ( $id > 0 )
                    $this -> session -> set_flashdata ( 'response', 'Success! Medication bill has been marked cleared.' );
                else
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * clear bill
         * -------------------------
         */
        
        public function clear_lab_bill () {
            $sale_id = $_REQUEST[ 'sale_id' ];
            if ( $sale_id > 0 ) {
                $info = array (
                    'user_id'    => get_logged_in_user_id (),
                    'sale_id'    => $sale_id,
                    'cleared'    => 1,
                    'date_added' => current_date_time ()
                );
                $id   = $this -> IPDModel -> clear_lab_bill ( $info );
                if ( $id > 0 )
                    $this -> session -> set_flashdata ( 'response', 'Success! Lab bill has been marked cleared.' );
                else
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * fetch ipd patient details
         * -------------------------
         */
        
        public function fetch_ipd_patient_details () {
            $patient_id = $this -> input -> post ( 'patient_id', true );
            if ( $patient_id > 0 ) {
                $data = $this -> IPDModel -> fetch_ipd_patient_details ( $patient_id );
                if ( !empty( $data ) ) {
                    $array = array (
                        'admission_no'    => $data -> sale_id,
                        'admission_data'  => date ( 'm/d/Y', strtotime ( $data -> date_added ) ),
                        'date_discharged' => date ( 'm/d/Y', strtotime ( $data -> date_discharged ) ),
                    );
                    echo json_encode ( $array );
                }
                else
                    echo 'false';
            }
        }
        
        /**
         * -------------------------
         * fetch ipd patient details
         * -------------------------
         */
        
        public function get_ipd_admission_slip () {
            $admission_no = $this -> input -> post ( 'admission_no', true );
            if ( $admission_no > 0 ) {
                $data = $this -> IPDModel -> get_ipd_admission_slip ( $admission_no );
                if ( !empty( $data ) ) {
                    $array = array (
                        'doctor_id'      => @$data -> doctor_id,
                        'doctor'         => @get_doctor ( $data -> doctor_id ) -> name,
                        'admission_data' => date ( 'm/d/Y', strtotime ( $data -> admission_date ) ),
                    );
                    echo json_encode ( $array );
                }
                else
                    echo 'false';
            }
        }
        
        /**
         * -------------------------
         * get beds by room id
         * -------------------------
         */
        
        public function get_room_available_beds () {
            $room_id = $this -> input -> post ( 'room_id', true );
            if ( $room_id > 0 ) {
                $data[ 'beds' ] = $this -> RoomModel -> get_available_beds_by_room_id ( $room_id );
                $this -> load -> view ( '/ipd/beds', $data );
            }
        }
        
        public function load_test_for_sale () {
            $test_id  = $this -> input -> post ( 'test_id' );
            $panel_id = $this -> input -> post ( 'panel_id' );
            $row      = $this -> input -> post ( 'row' );
            $price    = 0;
            
            if ( isset( $test_id ) and $test_id > 0 ) {
                if ( $panel_id > 0 )
                    $price = get_test_price_panel_id ( $test_id, $panel_id );
                else
                    $price = get_regular_test_price ( $test_id );
                
                if ( !empty( $price ) )
                    $price = $price -> price;
                
                $info = [
                    'test'  => get_test_by_id ( $test_id ),
                    'price' => $price,
                    'row'   => $row
                ];
                
                $this -> load -> view ( 'ipd/add-lab-test-row', $info );
                
            }
            else
                echo 'false';
        }
        
        public function load_medicine_for_requisition () {
            $medicine_id = $this -> input -> post ( 'medicine_id' );
            $row         = $this -> input -> post ( 'row' );
            
            if ( isset( $medicine_id ) and $medicine_id > 0 ) {
                
                $info = [
                    'medicine' => get_medicine ( $medicine_id ),
                    'row'      => $row
                ];
                
                $this -> load -> view ( 'ipd/add-requisition-row', $info );
                
            }
            else
                echo 'false';
        }
        
        public function get_package () {
            $package_id = $this -> input -> get ( 'package_id' );
            if ( isset( $package_id ) && is_numeric ( $package_id ) && $package_id > 0 )
                echo $this -> IPDModel -> get_package_by_id ( $package_id ) -> price;
            else
                echo '0';
        }
        
        public function add_package_services ( $package_id ) {
            $sale_id    = $this -> input -> post ( 'sale_id' );
            $patient_id = $this -> input -> post ( 'patient_id' );
            $services   = $this -> IPDModel -> get_package_all_services ( $package_id );
            
            if ( count ( $services ) > 0 ) {
                foreach ( $services as $service ) {
                    
                    $associated_service = array (
                        'user_id'           => get_logged_in_user_id (),
                        'sale_id'           => $sale_id,
                        'patient_id'        => $patient_id,
                        'parent_id'         => get_service_parent_id ( $service -> service_id ),
                        'service_id'        => $service -> service_id,
                        'doctor_id'         => 0,
                        'price'             => $service -> price,
                        'charge_per'        => null,
                        'charge_per_value'  => 0,
                        'doctor_discount'   => 0,
                        'hospital_discount' => 0,
                        'net_price'         => $service -> price,
                        'date_added'        => current_date_time (),
                    );
                    $this -> IPDModel -> assign_services_to_patient_info ( $associated_service );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'patient_id'   => $patient_id,
                        'sale_id'      => $sale_id,
                        'action'       => 'ipd_sale_services_added',
                        'log'          => json_encode ( $associated_service ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
                
                $info = array (
                    'total'           => get_ipd_total ( $sale_id ),
                    'discount'        => 0,
                    'initial_deposit' => 0,
                    'net_total'       => get_ipd_total ( $sale_id ),
                );
                $this -> IPDModel -> update_sale_total ( $info, $sale_id );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $patient_id,
                    'sale_id'      => $sale_id,
                    'action'       => 'ipd_sale_total_updated',
                    'log'          => json_encode ( $info ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'ipd_admission_logs', $log );
                
                /***********END LOG*************/
                
            }
        }
        
        public function add_more_anesthesia_charges () {
            $data[ 'added' ]               = $this -> input -> post ( 'added' );
            $data[ 'doctors' ]             = $this -> DoctorModel -> get_doctors ();
            $data[ 'anesthesia_services' ] = $this -> IPDModel -> get_anesthesia_services ();
            $this -> load -> view ( '/ipd/add-more-anesthesia-charges', $data );
        }
    }
