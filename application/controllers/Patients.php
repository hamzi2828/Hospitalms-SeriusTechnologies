<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Patients extends CI_Controller {
        
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
            $this -> load -> model ( 'PatientModel' );
            $this -> load -> model ( 'CompanyModel' );
            $this -> load -> model ( 'MemberModel' );
            $this -> load -> model ( 'DoctorModel' );
            $this -> load -> model ( 'PanelModel' );
            $this -> load -> model ( 'OPDModel' );
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
         * Patients main page
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - Patients';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 50;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'patients/index' );
            $total_row                      = $this -> PatientModel -> count_patients ();
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
            $data[ 'patients' ] = $this -> PatientModel -> get_patients ( $config[ "per_page" ], $offset );
            $str_links          = $this -> pagination -> create_links ();
            $data[ "links" ]    = explode ( '&nbsp;', $str_links );
            $data[ 'panels' ]   = $this -> PanelModel -> get_active_panels_by_user ();
            $this -> load -> view ( '/patients/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * patients add main page
         * -------------------------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_patient' )
                $this -> do_add_patient ( $_POST );
            
            $title = site_name . ' - Add Patient';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'cities' ]     = $this -> PatientModel -> get_cities ();
            $data[ 'doctors' ]    = $this -> DoctorModel -> get_doctors ();
            $data[ 'services' ]   = $this -> OPDModel -> get_all_services ();
            $data[ 'cities' ]     = $this -> PatientModel -> get_cities ();
            $data[ 'references' ] = $this -> ReferenceModel -> get_references ();
            $data[ 'patients' ]   = $this -> PatientModel -> search_patients ();
            $this -> load -> view ( '/patients/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * panel patients add main page
         * -------------------------
         */
        
        public function add_panel_patient () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_patient' )
                $this -> do_add_patient ( $_POST );
            
            $title = site_name . ' - Add Panel Patient';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'cities' ]    = $this -> PatientModel -> get_cities ();
            $data[ 'companies' ] = $this -> CompanyModel -> get_companies ();
            $data[ 'doctors' ]   = $this -> DoctorModel -> get_doctors ();
            $data[ 'services' ]  = $this -> OPDModel -> get_all_services ();
            $data[ 'patients' ]  = $this -> PatientModel -> search_patients ();
            $this -> load -> view ( '/patients/add_panel_patient', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * check patient type while registering
         * if panel, load the panel fields, else good to go
         * -------------------------
         */
        
        public function check_patient_type () {
            $patient_type = $this -> input -> post ( 'patient_type' );
            if ( !empty( trim ( $patient_type ) ) and $patient_type == 'panel' ) {
                $data[ 'member_types' ] = $this -> MemberModel -> get_members ();
                $data[ 'companies' ]    = $this -> CompanyModel -> get_companies ();
                $this -> load -> view ( '/patients/panel-fields', $data );
            }
            else if ( !empty( trim ( $patient_type ) ) and $patient_type == 'cash' ) {
                echo 'cash';
            }
            else {
                echo 'invalid';
            }
        }
        
        /**
         * -------------------------
         * check if patient exists by cnic
         * if exists, show the <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?> number
         * -------------------------
         */
        
        public function check_customer_exists_by_cnic () {
            $cnic = $this -> input -> post ( 'cnic' );
            if ( !empty( trim ( $cnic ) ) and is_numeric ( $cnic ) ) {
                $patient = $this -> PatientModel -> check_customer_exists_by_cnic ( $cnic );
                if ( !empty( $patient ) ) {
                    echo 'PAT-' . $patient -> id;
                }
                else {
                    echo 'false';
                }
            }
            else {
                echo 'invalid';
            }
        }
        
        /**
         * @param $POST
         * @throws Exception
         * add new suppliers
         */
        
        public function do_add_patient ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'type', 'patient type', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'gender', 'gender', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'phone', 'phone', 'xss_clean' );
            
            if ( isset( $data[ 'member_id' ] ) and !empty( trim ( $data[ 'member_id' ] ) ) and isset( $data[ 'company_id' ] ) and !empty( trim ( $data[ 'company_id' ] ) ) ) {
                $this -> form_validation -> set_rules ( 'member_id', 'patient role', 'required|trim|min_length[1]|xss_clean' );
                $this -> form_validation -> set_rules ( 'company_id', 'company', 'required|trim|min_length[1]|xss_clean' );
            }
            
            $age          = $this -> input -> post ( 'age' );
            $relationship = $this -> input -> post ( 'relationship' );
            $dob          = calculateBirthdate ( $age, $data[ 'age_year_month' ] );
            
            if ( $this -> form_validation -> run () != false ) {
                $info = array (
                    'user_id'                   => get_logged_in_user_id (),
                    'doctor_id'                 => $data[ 'doctor_id' ],
                    'service_id'                => $data[ 'service_id' ],
                    'type'                      => $data[ 'type' ],
                    'category'                  => $data[ 'category' ],
                    'prefix'                    => $data[ 'prefix' ],
                    'relationship'              => $relationship,
                    'father_name'               => $data[ 'father_name' ],
                    'martial_status'            => $data[ 'martial_status' ],
                    'religion'                  => $data[ 'religion' ],
                    'dob'                       => $dob,
                    'passport'                  => $data[ 'passport' ],
                    'country'                   => $data[ 'country' ],
                    'email'                     => $data[ 'email' ],
                    'blood_group'               => $data[ 'blood_group' ],
                    'nationality'               => $data[ 'nationality' ],
                    'emergency_person_name'     => $data[ 'emergency_person_name' ],
                    'emergency_person_number'   => $data[ 'emergency_person_number' ],
                    'emergency_person_relation' => $data[ 'emergency_person_relation' ],
                    'gender'                    => $data[ 'gender' ],
                    'name'                      => $data[ 'name' ],
                    'cnic'                      => $data[ 'cnic' ],
                    'mobile'                    => $data[ 'phone' ],
                    'age'                       => $age,
                    'age_year_month'            => $data[ 'age_year_month' ],
                    'city'                      => $data[ 'city' ],
                    'address'                   => $data[ 'address' ],
                    'date_registered'           => current_date_time (),
                );
                
                if ( isset( $_FILES[ 'picture' ] ) and !empty( trim ( $_FILES[ 'picture' ][ 'name' ] ) ) )
                    $info[ 'picture' ] = upload_files ( 'picture' );
                
                if ( isset( $_POST[ 'reference-id' ] ) and !empty( trim ( $_POST[ 'reference-id' ] ) ) and $_POST[ 'reference-id' ] > 0 )
                    $info[ 'reference_id' ] = $_POST[ 'reference-id' ];
                
                if ( isset( $data[ 'company_id' ] ) and !empty( trim ( $data[ 'company_id' ] ) ) ) {
                    //                    $info[ 'designation_id' ] = $data[ 'designation_id' ];
                    $info[ 'company_id' ] = $data[ 'company_id' ];
                    //                    $info[ 'medical_allowance' ] = $data[ 'medical_allowance' ];
                    $info[ 'panel_id' ] = $data[ 'panel_id' ];
                }
                $patient_id = $this -> PatientModel -> add ( $info );
                if ( $patient_id > 0 ) {
                    
                    $log = array (
                        'user_id'    => get_logged_in_user_id (),
                        'patient_id' => $patient_id,
                        'action'     => 'new_patient_added',
                        'log'        => json_encode ( $info ),
                        'date_added' => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'patient_logs', $log );
                    
                    $this -> session -> set_flashdata ( 'response', 'Success! Patient added. EMR# ' . $patient_id );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
//                    if ( isset( $_POST[ 'redirect' ] ) and !empty( trim ( $_POST[ 'redirect' ] ) ) )
//                        return redirect ( $_POST[ 'redirect' ] . '?patient=' . $patient_id . '&redirect=' . base_url ( '/lab/airline-details' ) );
//                    else
//                        return redirect ( base_url ( '/lab/sale/?patient=' . $patient_id ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Patient not added. Please try again' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * patient edit main page
         * -------------------------
         */
        
        public function edit () {
            
            $patient_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $patient_id ) ) or !is_numeric ( $patient_id ) or $patient_id < 1 )
                return redirect ( base_url ( '/patients/index' ) );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_patient' )
                $this -> do_edit_patient ( $_POST );
            
            $title = site_name . ' - Edit Patient';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'patient' ] = $this -> PatientModel -> get_patient_by_id ( $patient_id );
            $data[ 'cities' ]  = $this -> PatientModel -> get_cities ();
            $this -> load -> view ( '/patients/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * patient panel edit main page
         * -------------------------
         */
        
        public function edit_panel () {
            
            $patient_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $patient_id ) ) or !is_numeric ( $patient_id ) or $patient_id < 1 )
                return redirect ( base_url ( '/patients/index' ) );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_patient' )
                $this -> do_edit_patient ( $_POST );
            
            $title = site_name . ' - Edit Panel Patient';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'patient' ]   = $this -> PatientModel -> get_patient_by_id ( $patient_id );
            $data[ 'cities' ]    = $this -> PatientModel -> get_cities ();
            $data[ 'companies' ] = $this -> CompanyModel -> get_companies ();
            $data[ 'doctors' ]   = $this -> DoctorModel -> get_doctors ();
            $data[ 'services' ]  = $this -> OPDModel -> get_all_services ();
            $this -> load -> view ( '/patients/edit_panel', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * patient panel edit main page
         * -------------------------
         */
        
        public function edit_cash () {
            
            $patient_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $patient_id ) ) or !is_numeric ( $patient_id ) or $patient_id < 1 )
                return redirect ( base_url ( '/patients/index' ) );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_patient' )
                $this -> do_edit_patient ( $_POST );
            
            $title = site_name . ' - Edit Cash Patient';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'patient' ]    = $this -> PatientModel -> get_patient_by_id ( $patient_id );
            $data[ 'cities' ]     = $this -> PatientModel -> get_cities ();
            $data[ 'doctors' ]    = $this -> DoctorModel -> get_doctors ();
            $data[ 'services' ]   = $this -> OPDModel -> get_all_services ();
            $data[ 'references' ] = $this -> ReferenceModel -> get_references ();
            $this -> load -> view ( '/patients/edit_cash', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * update supplier info
         * -------------------------
         */
        
        public function do_edit_patient ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'type', 'patient type', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'gender', 'gender', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'cnic', 'cnic', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'phone', 'phone', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'address', 'address', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'city', 'city', 'xss_clean' );
            $patient_id = $this -> input -> post ( 'patient_id' );
            
            $age          = $this -> input -> post ( 'age' );
            $relationship = $this -> input -> post ( 'relationship' );
            $dob          = calculateBirthdate ( $age, $data[ 'age_year_month' ] );
            
            if ( $this -> form_validation -> run () != false ) {
                $info = array (
                    'doctor_id'                 => $data[ 'doctor_id' ],
                    'service_id'                => $data[ 'service_id' ],
                    'type'                      => $data[ 'type' ],
                    'prefix'                    => $data[ 'prefix' ],
                    'relationship'              => $relationship,
                    'father_name'               => $data[ 'father_name' ],
                    'martial_status'            => $data[ 'martial_status' ],
                    'religion'                  => $data[ 'religion' ],
                    'dob'                       => $dob,
                    'passport'                  => $data[ 'passport' ],
                    'country'                   => $data[ 'country' ],
                    'email'                     => $data[ 'email' ],
                    'blood_group'               => $data[ 'blood_group' ],
                    'nationality'               => $data[ 'nationality' ],
                    'emergency_person_name'     => $data[ 'emergency_person_name' ],
                    'emergency_person_number'   => $data[ 'emergency_person_number' ],
                    'emergency_person_relation' => $data[ 'emergency_person_relation' ],
                    'gender'                    => $data[ 'gender' ],
                    'name'                      => $data[ 'name' ],
                    'cnic'                      => $data[ 'cnic' ],
                    'mobile'                    => $data[ 'phone' ],
                    'age'                       => $age,
                    'age_year_month'            => $data[ 'age_year_month' ],
                    'city'                      => $data[ 'city' ],
                    'address'                   => $data[ 'address' ],
                );
                
                if ( isset( $_FILES[ 'picture' ] ) and !empty( trim ( $_FILES[ 'picture' ][ 'name' ] ) ) )
                    $info[ 'picture' ] = upload_files ( 'picture' );
                
                if ( isset( $_POST[ 'reference-id' ] ) and !empty( trim ( $_POST[ 'reference-id' ] ) ) and $_POST[ 'reference-id' ] > 0 )
                    $info[ 'reference_id' ] = $_POST[ 'reference-id' ];
                
                if ( isset( $data[ 'company_id' ] ) and !empty( trim ( $data[ 'company_id' ] ) ) ) {
                    $info[ 'designation_id' ]    = @$data[ 'designation_id' ];
                    $info[ 'company_id' ]        = @$data[ 'company_id' ];
                    $info[ 'medical_allowance' ] = @$data[ 'medical_allowance' ];
                    $info[ 'panel_id' ]          = @$data[ 'panel_id' ];
                }
                
                $updated = $this -> PatientModel -> edit ( $info, $patient_id );
                if ( $updated ) {
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'patient_id'   => $patient_id,
                        'action'       => 'patient_updated',
                        'log'          => json_encode ( get_patient ( $patient_id ) ),
                        'after_update' => json_encode ( $info ),
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'patient_logs', $log );
                    
                    $this -> session -> set_flashdata ( 'response', 'Success! Patient updated. EMR# ' . $patient_id );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Patient not updated. Please try again' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * update status of supplier to inactive
         * records are not being deleted permanently
         * -------------------------
         */
        
        public function delete () {
            $patient_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $patient_id ) ) or !is_numeric ( $patient_id ) or $patient_id < 1 )
                return redirect ( base_url ( '/patients/index' ) );
            
            $log = array (
                'user_id'    => get_logged_in_user_id (),
                'patient_id' => $patient_id,
                'action'     => 'patient_deleted',
                'log'        => json_encode ( get_patient ( $patient_id ) ),
                'date_added' => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'patient_logs', $log );
            
            $this -> PatientModel -> delete ( $patient_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Patient deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * update status of supplier to active
         * -------------------------
         */
        
        public function reactive () {
            $supplier_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $supplier_id ) ) or !is_numeric ( $supplier_id ) or $supplier_id < 1 )
                return redirect ( base_url ( '/suppliers/index' ) );
            
            $this -> SupplierModel -> reactive ( $supplier_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Supplier activated.' );
            return redirect ( base_url ( '/suppliers/index/' ) );
            
        }
        
        /**
         * -------------------------
         * supplier stock page
         * stocks provided by supplier
         * -------------------------
         */
        
        public function stock () {
            
            $supplier_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $supplier_id ) ) or !is_numeric ( $supplier_id ) or $supplier_id < 1 )
                return redirect ( base_url ( '/suppliers/index' ) );
            
            $title = site_name . ' - Supplier Stocks';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'stocks' ] = $this -> SupplierModel -> get_stocks_by_supplier_id ( $supplier_id );
            $this -> load -> view ( '/suppliers/stock', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * generate invoice of single stock
         * requires stock id and supplier id
         * uses codeigniter dompdf library
         * -------------------------
         */
        
        public function invoice () {
            $stock_id    = $this -> uri -> segment ( 3 );
            $supplier_id = $this -> uri -> segment ( 4 );
            if ( !empty( trim ( $stock_id ) ) and is_numeric ( $stock_id ) and $stock_id > 0 and !empty( trim ( $supplier_id ) ) and is_numeric ( $supplier_id ) and $supplier_id > 0 ) {
                $stock = $this -> MedicineModel -> get_stock ( $stock_id );
                $data  = array (
                    'invoice_number' => $stock -> id,
                    'date_generated' => date ( 'l jS F Y' ),
                    'supplier'       => get_supplier ( $stock -> supplier_id ),
                    'stock'          => $stock
                );
                $html  = $this -> load -> view ( 'suppliers/invoice', $data, true );
                require_once FCPATH . '/vendor/autoload.php';
                $mpdf = new \Mpdf\Mpdf( [
                                            'margin_left'   => 20,
                                            'margin_right'  => 15,
                                            'margin_top'    => 48,
                                            'margin_bottom' => 25,
                                            'margin_header' => 10,
                                            'margin_footer' => 10
                                        ] );
                $mpdf -> SetProtection ( array ( 'print' ) );
                $mpdf -> SetTitle ( site_name );
                $mpdf -> SetAuthor ( site_name );
                $mpdf -> SetWatermarkText ( site_name );
                $mpdf -> showWatermarkText  = true;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'fullpage' );
                $mpdf -> WriteHTML ( $html );
                $mpdf -> Output ( $stock -> batch . '.pdf', 'I' );
            }
        }
        
        /**
         * -------------------------
         * patient history page
         * load all medical history
         * -------------------------
         */
        
        public function history () {
            $title = site_name . ' - Patient Medical History';
            $this -> header ( $title );
            $this -> sidebar ();
            $current_tab             = @$_REQUEST[ 'tab' ];
            $user_id                 = $this -> uri -> segment ( 3 );
            $data[ 'vitals' ]        = array ();
            $data[ 'consultancies' ] = array ();
            $data[ 'services' ]      = array ();
            $data[ 'medicines' ]     = array ();
            $data[ 'sales' ]         = array ();
            $data[ 'patient_id' ]    = $user_id;
            
            if ( !isset( $current_tab ) or $current_tab == 'vitals' )
                $data[ 'vitals' ] = $this -> PatientModel -> get_patient_vitals ( $user_id );
            
            if ( isset( $current_tab ) and $current_tab == 'consultancies' )
                $data[ 'consultancies' ] = $this -> PatientModel -> get_patient_consultancies ( $user_id );
            
            if ( isset( $current_tab ) and $current_tab == 'services' )
                $data[ 'services' ] = $this -> PatientModel -> get_patient_services ( $user_id );
            
            if ( isset( $current_tab ) and $current_tab == 'ipd-services' )
                $data[ 'services' ] = $this -> PatientModel -> get_patient_ipd_services ( $user_id );
            
            if ( isset( $current_tab ) and $current_tab == 'medicines' )
                $data[ 'medicines' ] = $this -> PatientModel -> get_patient_medicines ( $user_id );
            
            if ( isset( $current_tab ) and $current_tab == 'ipd-medicines' )
                $data[ 'medicines' ] = $this -> PatientModel -> get_patient_ipd_medicines ( $user_id );
            
            if ( isset( $current_tab ) and $current_tab == 'lab-tests' )
                $data[ 'sales' ] = $this -> PatientModel -> get_patient_lab_tests ( $user_id );
            
            if ( isset( $current_tab ) and $current_tab == 'ipd-lab-tests' )
                $data[ 'sales' ] = $this -> PatientModel -> get_patient_ipd_lab_tests ( $user_id );
            
            if ( isset( $current_tab ) and $current_tab == 'ipd' )
                $data[ 'sales' ] = $this -> PatientModel -> get_patient_ipd_record ( $user_id );
            
            if ( isset( $current_tab ) and $current_tab == 'files' )
                $data[ 'files' ] = $this -> PatientModel -> get_patient_history_files ( $user_id );
            
            $this -> load -> view ( '/patients/history', $data );
            $this -> footer ();
        }
        
        public function add_patient_files ( $patient_id ) {
            upload_patient_files ( $patient_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Patient files have been added.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        public function delete_history_file ( $id ) {
            $this -> PatientModel -> delete_history_file ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! Patient file has been deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
    }
