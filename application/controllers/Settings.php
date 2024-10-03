<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Settings extends CI_Controller {
        
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
            $this -> load -> model ( 'MemberModel' );
            $this -> load -> model ( 'CompanyModel' );
            $this -> load -> model ( 'PanelModel' );
            $this -> load -> model ( 'MedicineModel' );
            $this -> load -> model ( 'LocationModel' );
            $this -> load -> model ( 'UnitModel' );
            $this -> load -> model ( 'SectionModel' );
            $this -> load -> model ( 'TestTubeColorModel' );
            $this -> load -> model ( 'SampleModel' );
            $this -> load -> model ( 'OPDModel' );
            $this -> load -> model ( 'StoreModel' );
            $this -> load -> model ( 'IPDModel' );
            $this -> load -> model ( 'PatientModel' );
            $this -> load -> model ( 'DoctorModel' );
            $this -> load -> model ( 'SettingModel' );
            $this -> load -> model ( 'SpecimenModel' );
            $this -> load -> model ( 'RemarksModel' );
            $this -> load -> model ( 'DestinationModel' );
            $this -> load -> model ( 'AirlineModel' );
            $this -> load -> model ( 'RoomModel' );
            $this -> load -> model ( 'ReferenceModel' );
            $this -> load -> model ( 'PackageModel' );
            $this -> load -> model ( 'LabModel' );
            $this -> load -> model ( 'OnlineReferenceModel' );
            $this -> load -> model ( 'AccountModel' );
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
         * Members main page
         * -------------------------
         */
        
        public function members () {
            $title = site_name . ' - Member Types';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'members' ] = $this -> MemberModel -> get_members ();
            $this -> load -> view ( '/settings/members/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * member type add main page
         * -------------------------
         */
        
        public function add_members () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'add_member' )
                $this -> do_add_member ( $_POST );
            
            $title = site_name . ' - Add Member Type';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/members/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add new member type
         * -------------------------
         */
        
        public function do_add_member ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'title', 'title', 'required|trim|min_length[1]|xss_clean|is_unique[member_types.title]' );
            
            if ( $this -> form_validation -> run () != false ) {
                $info      = array (
                    'user_id'    => get_logged_in_user_id (),
                    'title'      => $data[ 'title' ],
                    'date_added' => current_date_time (),
                );
                $member_id = $this -> MemberModel -> add ( $info );
                if ( $member_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Member type added.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Member type not added. Please try again' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * member type edit main page
         * -------------------------
         */
        
        public function edit_member () {
            
            $member_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $member_id ) ) or !is_numeric ( $member_id ) or $member_id < 1 )
                return redirect ( base_url ( '/settings/members' ) );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'edit_member' )
                $this -> do_edit_member ( $_POST );
            
            $title = site_name . ' - Edit Member';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'member' ] = $this -> MemberModel -> get_member_by_id ( $member_id );
            $this -> load -> view ( '/settings/members/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * update member type info
         * -------------------------
         */
        
        public function do_edit_member ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'title', 'title', 'required|trim|min_length[1]|xss_clean' );
            
            $member_id = $data[ 'member_id' ];
            if ( empty( trim ( $member_id ) ) or !is_numeric ( $member_id ) or $member_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( $this -> form_validation -> run () != false ) {
                $info    = array (
                    'title' => $data[ 'title' ],
                );
                $updated = $this -> MemberModel -> edit ( $info, $member_id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Member updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Note! Member already updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * delete member type permanently
         * -------------------------
         */
        
        public function delete_member () {
            $member_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $member_id ) ) or !is_numeric ( $member_id ) or $member_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> MemberModel -> delete ( $member_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Member deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * Companies main page
         * -------------------------
         */
        
        public function companies () {
            $title = site_name . ' - Companies';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'companies' ] = $this -> CompanyModel -> get_companies ();
            $this -> load -> view ( '/settings/companies/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * companies add main page
         * -------------------------
         */
        
        public function add_companies () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'add_companies' )
                $this -> do_add_companies ( $_POST );
            
            $title = site_name . ' - Add Company';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'companies' ] = $this -> CompanyModel -> get_parent_companies ();
            $this -> load -> view ( '/settings/companies/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add new company
         * -------------------------
         */
        
        public function do_add_companies ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean|is_unique[companies.name]' );
            $this -> form_validation -> set_rules ( 'email', 'email', 'trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'address', 'address', 'trim|xss_clean' );
            
            if ( $this -> form_validation -> run () != false ) {
                $info      = array (
                    'user_id'    => get_logged_in_user_id (),
                    'name'       => $data[ 'name' ],
                    'email'      => $data[ 'email' ],
                    'address'    => $data[ 'address' ],
                    'parent_id'  => $data[ 'parent_id' ],
                    'date_added' => current_date_time (),
                );
                $member_id = $this -> CompanyModel -> add ( $info );
                if ( $member_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Company added.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Company not added. Please try again' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Companies members page
         * -------------------------
         */
        
        public function company_members () {
            
            $company_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $company_id ) ) or !is_numeric ( $company_id ) or $company_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $title = site_name . ' - Company Members';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'members' ] = $this -> CompanyModel -> get_company_members ( $company_id );
            $this -> load -> view ( '/settings/companies/members', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * member type edit main page
         * -------------------------
         */
        
        public function edit_company () {
            
            $company_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $company_id ) ) or !is_numeric ( $company_id ) or $company_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'edit_company' )
                $this -> do_edit_company ( $_POST );
            
            $title = site_name . ' - Edit Company';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'company' ]   = $this -> CompanyModel -> get_company_by_id ( $company_id );
            $data[ 'companies' ] = $this -> CompanyModel -> get_parent_companies ();
            $this -> load -> view ( '/settings/companies/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit company
         * -------------------------
         */
        
        public function do_edit_company ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'email', 'email', 'required|trim|min_length[1]|xss_clean|valid_email' );
            $this -> form_validation -> set_rules ( 'address', 'address', 'required|trim|min_length[1]|xss_clean' );
            
            $company_id = $data[ 'company_id' ];
            if ( empty( trim ( $company_id ) ) or !is_numeric ( $company_id ) or $company_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( $this -> form_validation -> run () != false ) {
                $info    = array (
                    'name'    => $data[ 'name' ],
                    'email'   => $data[ 'email' ],
                    'address' => $data[ 'address' ],
                );
                $updated = $this -> CompanyModel -> edit ( $info, $company_id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Company updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Note! Company already updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * delete company permanently
         * -------------------------
         */
        
        public function delete_company () {
            $company_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $company_id ) ) or !is_numeric ( $company_id ) or $company_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> CompanyModel -> delete ( $company_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Company deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * Panels main page
         * -------------------------
         */
        
        public function panels () {
            $title = site_name . ' - Panels';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'panels' ] = $this -> PanelModel -> get_all_panels ();
            $this -> load -> view ( '/settings/panels/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Panels add  page
         * -------------------------
         */
        
        public function add_panel () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'add_panel' )
                $this -> do_add_panel ( $_POST );
            
            $title = site_name . ' - Add Panel';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'companies' ] = $this -> CompanyModel -> get_companies ();
            $data[ 'members' ]   = $this -> MemberModel -> get_members ();
            $this -> load -> view ( '/settings/panels/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * load ipd services
         * -------------------------
         */
        
        public function load_ipd_services () {
            $data[ 'services' ] = $this -> IPDModel -> get_all_services ();
            $this -> load -> view ( '/settings/panels/load-ipd-services', $data );
        }
        
        /**
         * -------------------------
         * load opd services
         * -------------------------
         */
        
        public function load_opd_services () {
            $data[ 'opd_services' ] = $this -> OPDModel -> get_all_services ();
            $this -> load -> view ( '/settings/panels/load-opd-services', $data );
        }
        
        /**
         * -------------------------
         * load opd services
         * -------------------------
         */
        
        public function load_consultancies () {
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $this -> load -> view ( '/settings/panels/load-consultancies', $data );
        }
        
        /**
         * -------------------------
         * Add more panels  page
         * -------------------------
         */
        
        public function add_more_panel_services () {
            $data[ 'row' ]        = $this -> input -> get ( 'added' );
            $data[ 'service_id' ] = $this -> input -> get ( 'service_id' );
            $this -> load -> view ( '/settings/panels/add_more_panel_services', $data );
        }
        
        /**
         * -------------------------
         * Add more panels doctors
         * -------------------------
         */
        
        public function add_more_panel_doctors () {
            $data[ 'row' ]       = $this -> input -> get ( 'added' );
            $data[ 'doctor_id' ] = $this -> input -> get ( 'doctor_id' );
            $this -> load -> view ( '/settings/panels/add_more_panel_doctors', $data );
        }
        
        /**
         * -------------------------
         * Add more panels opd services
         * -------------------------
         */
        
        public function add_more_panel_opd_services () {
            $data[ 'row' ]        = $this -> input -> get ( 'added' );
            $data[ 'service_id' ] = $this -> input -> get ( 'service_id' );
            $this -> load -> view ( '/settings/panels/add_more_panel_opd_services', $data );
        }
        
        /**
         * -------------------------
         * Panels add more page
         * -------------------------
         */
        
        public function add_more_panel () {
            $data[ 'row' ]       = $_POST[ 'added' ];
            $data[ 'companies' ] = $this -> CompanyModel -> get_companies ();
            $data[ 'members' ]   = $this -> MemberModel -> get_members ();
            $this -> load -> view ( '/settings/panels/add_more_panel', $data );
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add panel
         * -------------------------
         */
        
        public function do_add_panel ( $POST ) {
            $data         = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $services     = @$_POST[ 'service_id' ];
            $opd_services = @$_POST[ 'opd_service_id' ];
            $doctors      = @$_POST[ 'doctor_id' ];
            $info         = array (
                'user_id'     => get_logged_in_user_id (),
                'name'        => $data[ 'name' ],
                'code'        => $data[ 'code' ],
                'contact_no'  => $data[ 'contact_no' ],
                'email'       => $data[ 'email' ],
                'ntn'         => $data[ 'ntn' ],
                'address'     => $data[ 'address' ],
                'description' => $data[ 'description' ],
                'date_added'  => current_date_time (),
            );
            $panel_id     = $this -> PanelModel -> add_panel ( $info );
            if ( $panel_id > 0 ) {
                
                $this -> add_panel_account_head ( $panel_id );
                
                if ( count ( array_filter ( $data[ 'company_id' ] ) ) > 0 ) {
                    foreach ( $data[ 'company_id' ] as $company_id ) {
                        if ( !empty( trim ( $company_id ) ) and is_numeric ( $company_id ) > 0 ) {
                            $panel_info = array (
                                'user_id'    => get_logged_in_user_id (),
                                'panel_id'   => $panel_id,
                                'company_id' => $company_id,
                            );
                            $this -> PanelModel -> add_panel_companies ( $panel_info );
                        }
                    }
                }
                
                if ( isset( $services ) and count ( $services ) > 0 ) {
                    foreach ( $services as $key => $service ) {
                        if ( !empty( trim ( $service ) ) ) {
                            $panel_service = array (
                                'user_id'    => get_logged_in_user_id (),
                                'panel_id'   => $panel_id,
                                'service_id' => $service,
                                'price'      => $data[ 'service_price' ][ $key ],
                                'discount'   => $data[ 'discount' ][ $key ],
                                'type'       => $data[ 'type' ][ $key ],
                                'date_added' => current_date_time ()
                            );
                            $this -> PanelModel -> add_panel_services ( $panel_service );
                        }
                    }
                }
                
                if ( isset( $opd_services ) and count ( $opd_services ) > 0 ) {
                    foreach ( $opd_services as $key => $service ) {
                        if ( !empty( trim ( $service ) ) ) {
                            $panel_service = array (
                                'user_id'    => get_logged_in_user_id (),
                                'panel_id'   => $panel_id,
                                'service_id' => $service,
                                'price'      => $data[ 'opd_service_price' ][ $key ],
                                'discount'   => $data[ 'opd_discount' ][ $key ],
                                'type'       => $data[ 'opd_type' ][ $key ],
                                'date_added' => current_date_time ()
                            );
                            $this -> PanelModel -> add_panel_opd_services ( $panel_service );
                        }
                    }
                }
                
                if ( isset( $doctors ) and count ( $doctors ) > 0 ) {
                    foreach ( $doctors as $key => $doctor ) {
                        if ( !empty( trim ( $doctor ) ) ) {
                            $panel_doctor = array (
                                'user_id'    => get_logged_in_user_id (),
                                'panel_id'   => $panel_id,
                                'doctor_id'  => $doctor,
                                'price'      => $data[ 'consultancy_price' ][ $key ],
                                'discount'   => $data[ 'doc_discount' ][ $key ],
                                'type'       => $data[ 'doc_disc_type' ][ $key ],
                                'date_added' => current_date_time ()
                            );
                            $this -> PanelModel -> add_panel_doctors ( $panel_doctor );
                        }
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Panel added.' );
                return redirect ( base_url ( '/settings/edit-panel/' . $panel_id . '?settings=general' ) );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Panel not added. Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        public function add_panel_account_head ( $panel_id ) {
            $panel        = $this -> PanelModel -> get_panel_by_id ( $panel_id );
            $account_head = get_account_head ( RECEIVABLE_FROM_PANELS );
            
            $info = array (
                'title'          => $panel -> name,
                'parent_id'      => RECEIVABLE_FROM_PANELS,
                'role_id'        => $account_head -> role_id,
                'panel_id'       => $panel -> id,
                'contact_person' => $panel -> name,
                'phone'          => $panel -> contact_no,
                'status'         => '1',
                'type'           => 15,
                'deleteable'     => '0',
                'description'    => $panel -> description,
                'date_added'     => current_date_time (),
            );
            $this -> AccountModel -> insert ( $info );
        }
        
        /**
         * -------------------------
         * Panels edit page
         * -------------------------
         */
        
        public function edit_panel () {
            
            $panel_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $panel_id ) ) or !is_numeric ( $panel_id ) or $panel_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_panel' )
                $this -> do_edit_panel ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_panel_ipd' )
                $this -> do_edit_panel_ipd ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_panel_opd' )
                $this -> do_edit_panel_opd ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_panel_consultancy' )
                $this -> do_edit_panel_consultancy ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_panel_lab' )
                $this -> do_edit_panel_lab ();
            
            $title = site_name . ' - Edit Panel';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'companies' ]          = $this -> CompanyModel -> get_companies ();
            $data[ 'members' ]            = $this -> MemberModel -> get_members ();
            $data[ 'panel' ]              = $this -> PanelModel -> get_panel_by_id ( $panel_id );
            $data[ 'services' ]           = $this -> IPDModel -> get_all_services ();
            $data[ 'ipd_services' ]       = $this -> PanelModel -> get_panel_ipd_services ( $panel_id );
            $data[ 'doctors' ]            = $this -> DoctorModel -> get_doctors_not_in_panel ( $panel_id );
            $data[ 'panel_doctors' ]      = $this -> PanelModel -> get_panel_doctors ( $panel_id );
            $data[ 'opd_services' ]       = $this -> OPDModel -> get_services_not_in_panel ( $panel_id );
            $data[ 'added_opd_services' ] = $this -> PanelModel -> get_panel_opd_services ( $panel_id );
            $data[ 'tests' ]              = $this -> LabModel -> get_tests_not_in_panel ( $panel_id );
            $data[ 'panel_tests' ]        = $this -> PanelModel -> get_panel_lab_tests ( $panel_id );
            $services                     = $this -> IPDModel -> get_ipd_services_not_in_panel ( $panel_id );
            $tree                         = buildTree ( $services );
            $options                      = '';
            $list                         = buildList ( $tree, $options, 0, true );
            $data[ 'list' ]               = $list;
            $this -> load -> view ( '/settings/panels/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * delete ipd service
         * -------------------------
         */
        
        public function delete_ipd_service () {
            
            $service_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $service_id ) ) or !is_numeric ( $service_id ) or $service_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            $this -> PanelModel -> delete_ipd_service ( $service_id );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @param $POST
         * do edit panel
         * -------------------------
         */
        
        public function do_edit_panel ( $POST ) {
            $data     = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $panel_id = $data[ 'panel_id' ];
            
            if ( !empty( trim ( $panel_id ) ) and is_numeric ( $panel_id ) and $panel_id > 0 ) {
                $info    = array (
                    'user_id'          => get_logged_in_user_id (),
                    'name'             => $data[ 'name' ],
                    'code'             => $data[ 'code' ],
                    'contact_no'       => $data[ 'contact_no' ],
                    'email'            => $data[ 'email' ],
                    'ntn'              => $data[ 'ntn' ],
                    'address'          => $data[ 'address' ],
                    'description'      => $data[ 'description' ],
                    'exclude_pharmacy' => $data[ 'exclude-pharmacy' ],
                    'exclude_lab'      => $data[ 'exclude-lab' ],
                    'exclude_xray'     => $data[ 'exclude-xray' ],
                    'tax'              => $data[ 'tax' ],
                );
                $updated = $this -> PanelModel -> edit_panel ( $info, $panel_id );
                $this -> PanelModel -> delete_panel_companies ( $panel_id );
                foreach ( $data[ 'company_id' ] as $company_id ) {
                    if ( !empty( trim ( $company_id ) ) and is_numeric ( $company_id ) > 0 ) {
                        $panel_info = array (
                            'user_id'    => get_logged_in_user_id (),
                            'panel_id'   => $panel_id,
                            'company_id' => $company_id,
                        );
                        $this -> PanelModel -> add_panel_companies ( $panel_info );
                    }
                }
                
                $this -> session -> set_flashdata ( 'response', 'Success! Panel updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        public function do_edit_panel_ipd ( $POST ) {
            $data     = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $panel_id = $data[ 'panel_id' ];
            $services = $data[ 'service_id' ];
            
            if ( !empty( trim ( $panel_id ) ) and is_numeric ( $panel_id ) and $panel_id > 0 ) {
                $this -> PanelModel -> delete_ipd_panel_services ( $panel_id );
                if ( isset( $services ) and count ( $services ) > 0 ) {
                    foreach ( $services as $key => $service ) {
                        if ( !empty( trim ( $service ) ) ) {
                            $panel_service = array (
                                'user_id'    => get_logged_in_user_id (),
                                'panel_id'   => $panel_id,
                                'service_id' => $service,
                                'price'      => $data[ 'service_price' ][ $key ],
                                'discount'   => 0,
                                'type'       => 'flat',
                                'date_added' => current_date_time ()
                            );
                            $this -> PanelModel -> add_panel_services ( $panel_service );
                        }
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Panel updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        public function do_edit_panel_opd ( $POST ) {
            $data         = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $panel_id     = $data[ 'panel_id' ];
            $opd_services = $data[ 'opd_service_id' ];
            
            if ( !empty( trim ( $panel_id ) ) and is_numeric ( $panel_id ) and $panel_id > 0 ) {
                $this -> PanelModel -> delete_opd_panel_services ( $panel_id );
                if ( isset( $opd_services ) and count ( $opd_services ) > 0 ) {
                    foreach ( $opd_services as $key => $service ) {
                        if ( !empty( trim ( $service ) ) ) {
                            $panel_service = array (
                                'user_id'    => get_logged_in_user_id (),
                                'panel_id'   => $panel_id,
                                'service_id' => $service,
                                'price'      => $data[ 'opd_service_price' ][ $key ],
                                'discount'   => 0,
                                'type'       => 'flat',
                                'date_added' => current_date_time ()
                            );
                            $this -> PanelModel -> add_panel_opd_services ( $panel_service );
                        }
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Panel updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        public function do_edit_panel_consultancy ( $POST ) {
            $data     = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $panel_id = $data[ 'panel_id' ];
            $doctors  = $data[ 'doctor_id' ];
            
            if ( !empty( trim ( $panel_id ) ) and is_numeric ( $panel_id ) and $panel_id > 0 ) {
                $this -> PanelModel -> delete_panel_doctors ( $panel_id );
                if ( isset( $doctors ) and count ( $doctors ) > 0 ) {
                    foreach ( $doctors as $key => $doctor ) {
                        if ( !empty( trim ( $doctor ) ) ) {
                            $panel_doctor = array (
                                'user_id'    => get_logged_in_user_id (),
                                'panel_id'   => $panel_id,
                                'doctor_id'  => $doctor,
                                'price'      => $data[ 'consultancy_price' ][ $key ],
                                'discount'   => 0,
                                'type'       => 'flat',
                                'date_added' => current_date_time ()
                            );
                            $this -> PanelModel -> add_panel_doctors ( $panel_doctor );
                        }
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Panel updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * Panels edit page
         * -------------------------
         */
        
        public function delete_panel () {
            $panel_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $panel_id ) ) or !is_numeric ( $panel_id ) or $panel_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $hasPatients = $this -> PatientModel -> check_if_panel_has_patients ( $panel_id );
            if ( $hasPatients ) {
                $this -> session -> set_flashdata ( 'error', 'Alert! Patients are registered in this panel. You cannot delete it!' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            
            $this -> PanelModel -> delete_panel ( $panel_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Panel deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * Generics main page
         * -------------------------
         */
        
        public function generic () {
            $title = site_name . ' - Generic';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'generics' ] = $this -> MedicineModel -> get_generics ();
            $this -> load -> view ( '/settings/generic/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add generics main page
         * -------------------------
         */
        
        public function add_generic () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_generic' )
                $this -> do_add_generic ( $_POST );
            
            $title = site_name . ' - Add Generic';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/generic/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add generic
         * -------------------------
         */
        
        public function do_add_generic ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'title', 'title', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info       = array (
                    'user_id'    => get_logged_in_user_id (),
                    'title'      => $data[ 'title' ],
                    'date_added' => current_date_time (),
                );
                $generic_id = $this -> MedicineModel -> add_generic ( $info );
                if ( $generic_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Generic added.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Edit generics main page
         * -------------------------
         */
        
        public function edit_generic () {
            
            $generic_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $generic_id ) ) or !is_numeric ( $generic_id ) or $generic_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_generic' )
                $this -> do_edit_generic ( $_POST );
            
            $title = site_name . ' - Edit Generic';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'generic' ] = $this -> MedicineModel -> get_generic ( $generic_id );
            $this -> load -> view ( '/settings/generic/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do edit generic
         * -------------------------
         */
        
        public function do_edit_generic ( $POST ) {
            $data       = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $generic_id = $data[ 'generic_id' ];
            $this -> form_validation -> set_rules ( 'title', 'title', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info    = array (
                    'title' => $data[ 'title' ],
                );
                $updated = $this -> MedicineModel -> edit_generic ( $info, $generic_id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Generic updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Already updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Delete generics main page
         * -------------------------
         */
        
        public function delete_generic () {
            
            $generic_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $generic_id ) ) or !is_numeric ( $generic_id ) or $generic_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> MedicineModel -> delete_generic ( $generic_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Generic deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * strength main page
         * -------------------------
         */
        
        public function strength () {
            $title = site_name . ' - Strength';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'strengths' ] = $this -> MedicineModel -> get_strengths ();
            $this -> load -> view ( '/settings/strength/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add strength main page
         * -------------------------
         */
        
        public function add_strength () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_strength' )
                $this -> do_add_strength ( $_POST );
            
            $title = site_name . ' - Add strength';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/strength/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add strength
         * -------------------------
         */
        
        public function do_add_strength ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'title', 'title', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info       = array (
                    'user_id'    => get_logged_in_user_id (),
                    'title'      => $data[ 'title' ],
                    'date_added' => current_date_time (),
                );
                $generic_id = $this -> MedicineModel -> add_strength ( $info );
                if ( $generic_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Strength added.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Edit strength main page
         * -------------------------
         */
        
        public function edit_strength () {
            
            $strength_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $strength_id ) ) or !is_numeric ( $strength_id ) or $strength_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_strength' )
                $this -> do_edit_strength ( $_POST );
            
            $title = site_name . ' - Edit strength';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'strength' ] = $this -> MedicineModel -> get_strength ( $strength_id );
            $this -> load -> view ( '/settings/strength/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do edit strength
         * -------------------------
         */
        
        public function do_edit_strength ( $POST ) {
            $data       = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $generic_id = $data[ 'generic_id' ];
            $this -> form_validation -> set_rules ( 'title', 'title', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info    = array (
                    'title' => $data[ 'title' ],
                );
                $updated = $this -> MedicineModel -> edit_strength ( $info, $generic_id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Strength updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Already updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Delete strength main page
         * -------------------------
         */
        
        public function delete_strength () {
            
            $strength_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $strength_id ) ) or !is_numeric ( $strength_id ) or $strength_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> MedicineModel -> delete_strength ( $strength_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Strength deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * form main page
         * -------------------------
         */
        
        public function forms () {
            $title = site_name . ' - Forms';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'forms' ] = $this -> MedicineModel -> get_forms ();
            $this -> load -> view ( '/settings/form/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add form main page
         * -------------------------
         */
        
        public function add_form () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_form' )
                $this -> do_add_form ( $_POST );
            
            $title = site_name . ' - Add form';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/form/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add form
         * -------------------------
         */
        
        public function do_add_form ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'title', 'title', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info    = array (
                    'user_id'    => get_logged_in_user_id (),
                    'title'      => $data[ 'title' ],
                    'date_added' => current_date_time (),
                );
                $form_id = $this -> MedicineModel -> add_form ( $info );
                if ( $form_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Form added.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Edit form main page
         * -------------------------
         */
        
        public function edit_form () {
            
            $form_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $form_id ) ) or !is_numeric ( $form_id ) or $form_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_form' )
                $this -> do_edit_form ( $_POST );
            
            $title = site_name . ' - Edit form';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'form' ] = $this -> MedicineModel -> get_form ( $form_id );
            $this -> load -> view ( '/settings/form/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do edit form
         * -------------------------
         */
        
        public function do_edit_form ( $POST ) {
            $data    = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $form_id = $data[ 'form_id' ];
            $this -> form_validation -> set_rules ( 'title', 'title', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info    = array (
                    'title' => $data[ 'title' ],
                );
                $updated = $this -> MedicineModel -> edit_form ( $info, $form_id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Form updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Already updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Delete form main page
         * -------------------------
         */
        
        public function delete_form () {
            
            $form_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $form_id ) ) or !is_numeric ( $form_id ) or $form_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> MedicineModel -> delete_form ( $form_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Form deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * Locations main page
         * -------------------------
         */
        
        public function locations () {
            $title = site_name . ' - Locations';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'locations' ] = $this -> LocationModel -> get_locations ();
            $this -> load -> view ( '/settings/locations/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Locations main page
         * -------------------------
         */
        
        public function add_location () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_location' )
                $this -> do_add_location ( $_POST );
            
            $title = site_name . ' - Add Locations';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/locations/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add location
         * -------------------------
         */
        
        public function do_add_location ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info    = array (
                    'user_id'    => get_logged_in_user_id (),
                    'name'       => $data[ 'name' ],
                    'date_added' => current_date_time (),
                );
                $city_id = $this -> LocationModel -> add ( $info );
                if ( $city_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Location added.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Locations edit page
         * -------------------------
         */
        
        public function edit_location () {
            
            $location_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $location_id ) ) or !is_numeric ( $location_id ) or $location_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_location' )
                $this -> do_edit_location ( $_POST );
            
            $title = site_name . ' - Edit Locations';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'location' ] = $this -> LocationModel -> get_location_by_id ( $location_id );
            $this -> load -> view ( '/settings/locations/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do edit location
         * -------------------------
         */
        
        public function do_edit_location ( $POST ) {
            $data        = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $location_id = $data[ 'location_id' ];
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info    = array (
                    'name' => $data[ 'name' ],
                );
                $updated = $this -> LocationModel -> edit ( $info, $location_id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Location updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Already updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Delete location main page
         * -------------------------
         */
        
        public function delete_location () {
            
            $location_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $location_id ) ) or !is_numeric ( $location_id ) or $location_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> LocationModel -> delete ( $location_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Location deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * units main page
         * -------------------------
         */
        
        public function units () {
            $title = site_name . ' - Units';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'units' ] = $this -> UnitModel -> get_units ();
            $this -> load -> view ( '/settings/units/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * units add page
         * -------------------------
         */
        
        public function add_unit () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_unit' )
                $this -> do_add_unit ( $_POST );
            
            $title = site_name . ' - Add units';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/units/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add location
         * -------------------------
         */
        
        public function do_add_unit ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info    = array (
                    'user_id'    => get_logged_in_user_id (),
                    'name'       => $data[ 'name' ],
                    'date_added' => current_date_time (),
                );
                $unit_id = $this -> UnitModel -> add ( $info );
                if ( $unit_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Unit added.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Locations edit page
         * -------------------------
         */
        
        public function edit_unit () {
            
            $unit_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $unit_id ) ) or !is_numeric ( $unit_id ) or $unit_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_unit' )
                $this -> do_edit_unit ( $_POST );
            
            $title = site_name . ' - Edit units';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'unit' ] = $this -> UnitModel -> get_unit_by_id ( $unit_id );
            $this -> load -> view ( '/settings/units/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do edit location
         * -------------------------
         */
        
        public function do_edit_unit ( $POST ) {
            $data    = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $unit_id = $data[ 'unit_id' ];
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info    = array (
                    'name' => $data[ 'name' ],
                );
                $updated = $this -> UnitModel -> edit ( $info, $unit_id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Unit updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Already updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Delete location main page
         * -------------------------
         */
        
        public function delete_unit () {
            
            $unit_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $unit_id ) ) or !is_numeric ( $unit_id ) or $unit_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> UnitModel -> delete ( $unit_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Unit deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * section main page
         * -------------------------
         */
        
        public function sections () {
            $title = site_name . ' - Sections';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'sections' ] = $this -> SectionModel -> get_sections ();
            $this -> load -> view ( '/settings/sections/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * section add page
         * -------------------------
         */
        
        public function add_section () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_section' )
                $this -> do_add_section ( $_POST );
            
            $title = site_name . ' - Add sections';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/sections/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add section
         * -------------------------
         */
        
        public function do_add_section ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info       = array (
                    'user_id'    => get_logged_in_user_id (),
                    'name'       => $data[ 'name' ],
                    'date_added' => current_date_time (),
                );
                $section_id = $this -> SectionModel -> add ( $info );
                if ( $section_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Section added.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * section edit page
         * -------------------------
         */
        
        public function edit_section () {
            
            $section_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $section_id ) ) or !is_numeric ( $section_id ) or $section_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_section' )
                $this -> do_edit_section ( $_POST );
            
            $title = site_name . ' - Edit sections';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'section' ] = $this -> SectionModel -> get_section_by_id ( $section_id );
            $this -> load -> view ( '/settings/sections/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do section location
         * -------------------------
         */
        
        public function do_edit_section ( $POST ) {
            $data       = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $section_id = $data[ 'section_id' ];
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info    = array (
                    'name' => $data[ 'name' ],
                );
                $updated = $this -> SectionModel -> edit ( $info, $section_id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Section updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Already updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Delete section main page
         * -------------------------
         */
        
        public function delete_section () {
            
            $section_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $section_id ) ) or !is_numeric ( $section_id ) or $section_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> SectionModel -> delete ( $section_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Section deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * test_tube_colors main page
         * -------------------------
         */
        
        public function test_tube_colors () {
            $title = site_name . ' - Test Tube Colors';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'colors' ] = $this -> TestTubeColorModel -> get_colors ();
            $this -> load -> view ( '/settings/colors/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add_test_tube_colors add page
         * -------------------------
         */
        
        public function add_test_tube_colors () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_test_tube_colors' )
                $this -> do_add_test_tube_colors ( $_POST );
            
            $title = site_name . ' - Add colors';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/colors/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add add_test_tube_colors
         * -------------------------
         */
        
        public function do_add_test_tube_colors ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'color', 'color', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info     = array (
                    'user_id'    => get_logged_in_user_id (),
                    'name'       => $data[ 'name' ],
                    'color'      => $data[ 'color' ],
                    'date_added' => current_date_time (),
                );
                $color_id = $this -> TestTubeColorModel -> add ( $info );
                if ( $color_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Color added.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * edit_test_tube_colors edit page
         * -------------------------
         */
        
        public function edit_test_tube_colors () {
            
            $color_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $color_id ) ) or !is_numeric ( $color_id ) or $color_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_test_tube_colors' )
                $this -> do_edit_test_tube_colors ( $_POST );
            
            $title = site_name . ' - Edit colors';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'color' ] = $this -> TestTubeColorModel -> get_color_by_id ( $color_id );
            $this -> load -> view ( '/settings/colors/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do edit edit_test_tube_colors
         * -------------------------
         */
        
        public function do_edit_test_tube_colors ( $POST ) {
            $data     = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $color_id = $data[ 'color_id' ];
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'color', 'color', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info    = array (
                    'name'  => $data[ 'name' ],
                    'color' => $data[ 'color' ],
                );
                $updated = $this -> TestTubeColorModel -> edit ( $info, $color_id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Color updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Already updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Delete edit_test_tube_colors main page
         * -------------------------
         */
        
        public function delete_test_tube_colors () {
            
            $color_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $color_id ) ) or !is_numeric ( $color_id ) or $color_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> TestTubeColorModel -> delete ( $color_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Color deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * sample main page
         * -------------------------
         */
        
        public function samples () {
            $title = site_name . ' - Samples';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'samples' ] = $this -> SampleModel -> get_samples ();
            $this -> load -> view ( '/settings/samples/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * samples add page
         * -------------------------
         */
        
        public function add_sample () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_sample' )
                $this -> do_add_sample ( $_POST );
            
            $title = site_name . ' - Add samples';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/samples/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add samples
         * -------------------------
         */
        
        public function do_add_sample ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info      = array (
                    'user_id'    => get_logged_in_user_id (),
                    'name'       => $data[ 'name' ],
                    'date_added' => current_date_time (),
                );
                $sample_id = $this -> SampleModel -> add ( $info );
                if ( $sample_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Sample added.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * sample edit page
         * -------------------------
         */
        
        public function edit_sample () {
            
            $sample_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $sample_id ) ) or !is_numeric ( $sample_id ) or $sample_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_sample' )
                $this -> do_edit_sample ( $_POST );
            
            $title = site_name . ' - Edit sample';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'sample' ] = $this -> SampleModel -> get_sample_by_id ( $sample_id );
            $this -> load -> view ( '/settings/samples/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do edit sample
         * -------------------------
         */
        
        public function do_edit_sample ( $POST ) {
            $data      = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $sample_id = $data[ 'sample_id' ];
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info    = array (
                    'name' => $data[ 'name' ],
                );
                $updated = $this -> SampleModel -> edit ( $info, $sample_id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Sample updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Already updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Delete sample main page
         * -------------------------
         */
        
        public function delete_sample () {
            
            $sample_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $sample_id ) ) or !is_numeric ( $sample_id ) or $sample_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> SampleModel -> delete ( $sample_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Sample deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * Manufacturers main page
         * -------------------------
         */
        
        public function manufacturers () {
            $title = site_name . ' - Manufacturers';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'manufacturers' ] = $this -> MedicineModel -> get_manufacturers ();
            $this -> load -> view ( '/settings/manufacturers/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add manufacturers main page
         * -------------------------
         */
        
        public function add_manufacturers () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_manufacturer' )
                $this -> do_add_manufacturer ( $_POST );
            
            $title = site_name . ' - Add Manufacturers';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/manufacturers/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add manufacturers
         * -------------------------
         */
        
        public function do_add_manufacturer ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info            = array (
                    'user_id'    => get_logged_in_user_id (),
                    'name'       => $data[ 'name' ],
                    'date_added' => current_date_time (),
                );
                $manufacturer_id = $this -> MedicineModel -> add_manufacturers ( $info );
                if ( $manufacturer_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Manufacturer updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Pleae try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * manufacturer edit page
         * -------------------------
         */
        
        public function edit_manufacturers () {
            
            $manufacturer_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $manufacturer_id ) ) or !is_numeric ( $manufacturer_id ) or $manufacturer_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_manufacturer' )
                $this -> do_edit_manufacturer ( $_POST );
            
            $title = site_name . ' - Edit manufacturer';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'manufacturer' ] = $this -> MedicineModel -> get_manufacturer_by_id ( $manufacturer_id );
            $this -> load -> view ( '/settings/manufacturers/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do edit manufacturer
         * -------------------------
         */
        
        public function do_edit_manufacturer ( $POST ) {
            $data            = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $manufacturer_id = $data[ 'manufacturer_id' ];
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info    = array (
                    'name' => $data[ 'name' ],
                );
                $updated = $this -> MedicineModel -> edit_manufacturers ( $info, $manufacturer_id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Manufacturer updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Already updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Delete manufacturer main page
         * -------------------------
         */
        
        public function delete_manufacturers () {
            
            $manufacturer_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $manufacturer_id ) ) or !is_numeric ( $manufacturer_id ) or $manufacturer_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> MedicineModel -> delete_manufacturers ( $manufacturer_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Manufacturer deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * OPD services main page
         * -------------------------
         */
        
        public function opd_services () {
            $title = site_name . ' - OPD Services';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'services' ] = $this -> OPDModel -> get_parent_services ();
            $this -> load -> view ( '/settings/opd/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add OPD services main page
         * -------------------------
         */
        
        public function add_opd_services () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_opd_services' )
                $this -> do_add_opd_services ( $_POST );
            
            $title = site_name . ' - Add OPD Services';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'services' ] = $this -> OPDModel -> get_parent_services ();
            $this -> load -> view ( '/settings/opd/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add services
         * -------------------------
         */
        
        public function do_add_opd_services ( $POST ) {
            $data       = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $info       = array (
                'user_id'    => get_logged_in_user_id (),
                'parent_id'  => $data[ 'parent_id' ],
                'code'       => $data[ 'code' ],
                'title'      => $data[ 'title' ],
                'price'      => $data[ 'price' ],
                'date_added' => current_date_time (),
            );
            $service_id = $this -> OPDModel -> add ( $info );
            if ( $service_id > 0 ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Service added.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete service
         * by service id
         * -------------------------
         */
        
        public function delete_service () {
            $service_id = $this -> uri -> segment ( 3 );
            if ( !empty( $service_id ) and is_numeric ( $service_id ) and $service_id > 0 ) {
                $deleted = $this -> OPDModel -> delete ( $service_id );
                if ( $deleted ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Service deleted.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * edit service
         * -------------------------
         */
        
        public function edit_service () {
            $service_id = $this -> uri -> segment ( 3 );
            if ( empty( $service_id ) or !is_numeric ( $service_id ) or $service_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_opd_services' )
                $this -> do_edit_opd_services ( $_POST );
            
            $title = site_name . ' - Edit OPD Service';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'services' ]     = $this -> OPDModel -> get_parent_services ();
            $data[ 'service_info' ] = $this -> OPDModel -> get_service_by_id ( $service_id );
            $this -> load -> view ( '/settings/opd/edit', $data );
            $this -> footer ();
            
        }
        
        /**
         * -------------------------
         * @param $POST
         * do update service
         * -------------------------
         */
        
        public function do_edit_opd_services ( $POST ) {
            $data       = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $service_id = $data[ 'service_id' ];
            $info       = array (
                'parent_id'    => $data[ 'parent_id' ],
                'code'         => $data[ 'code' ],
                'title'        => $data[ 'title' ],
                'price'        => $data[ 'price' ],
                'service_type' => $data[ 'service_type' ],
            );
            $updated    = $this -> OPDModel -> edit ( $info, $service_id );
            if ( $updated ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Service updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Already updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * sub services main page
         * -------------------------
         */
        
        public function sub_services () {
            $service_id = $this -> uri -> segment ( 3 );
            if ( empty( $service_id ) or !is_numeric ( $service_id ) or $service_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $title = site_name . ' - Sub Services';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'services' ] = $this -> OPDModel -> get_services_by_parent_id ( $service_id );
            $this -> load -> view ( '/settings/opd/sub-services', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * departments main page
         * -------------------------
         */
        
        public function departments () {
            $title = site_name . ' - Departments';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $this -> load -> view ( '/settings/departments/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add departments main page
         * -------------------------
         */
        
        public function add_departments () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_department' )
                $this -> do_add_department ( $_POST );
            
            $title = site_name . ' - Departments';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/departments/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add department
         * -------------------------
         */
        
        public function do_add_department ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            
            $this -> form_validation -> set_rules ( 'code', 'code', 'required|trim|is_unique[departments.code]|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                $info          = array (
                    'user_id'    => get_logged_in_user_id (),
                    'code'       => $data[ 'code' ],
                    'name'       => $data[ 'name' ],
                    'date_added' => current_date_time (),
                );
                $department_id = $this -> MemberModel -> do_add_department ( $info );
                if ( $department_id > 0 ) {
                    $this -> add_department_account_head ( $department_id );
                    $this -> session -> set_flashdata ( 'response', 'Success! Department added.' );
                    return redirect ( base_url ( '/settings/add-departments?settings=member-settings' ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( base_url ( '/settings/add-departments?settings=member-settings' ) );
                }
            }
        }
        
        public function add_department_account_head ( $department_id ) {
            $department   = $this -> MemberModel -> get_department_by_id ( $department_id );
            $account_head = $this -> AccountModel -> get_account_head_by_id ( COST_OF_SERVICES );
            
            $accountHeadInfo = array (
                'title'      => 'COS - ' . $department -> name,
                'parent_id'  => COST_OF_SERVICES,
                'role_id'    => $account_head -> role_id,
                'status'     => '1',
                'type'       => 14,
                'deleteable' => '0',
                'date_added' => current_date_time (),
            );
            
            $department_account_head_id = $this -> AccountModel -> insert ( $accountHeadInfo );
            $this -> MemberModel -> do_edit_department ( array ( 'account_head_id' => $department_account_head_id ), $department_id );
        }
        
        /**
         * -------------------------
         * edit departments main page
         * -------------------------
         */
        
        public function edit_department () {
            
            $department_id = $this -> uri -> segment ( 3 );
            if ( empty( $department_id ) or !is_numeric ( $department_id ) or $department_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_department' )
                $this -> do_edit_department ( $_POST );
            
            $title = site_name . ' - Edit Departments';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'department' ] = $this -> MemberModel -> get_department_by_id ( $department_id );
            $this -> load -> view ( '/settings/departments/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do update department
         * -------------------------
         */
        
        public function do_edit_department ( $POST ) {
            $data          = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $department_id = $data[ 'department_id' ];
            $info          = array (
                'code' => $data[ 'code' ],
                'name' => $data[ 'name' ],
            );
            $this -> MemberModel -> do_edit_department ( $info, $department_id );
            
            if ( !empty( trim ( $department -> account_head_id ) ) ) {
                $department      = $this -> MemberModel -> get_department_by_id ( $department_id );
                $accountHeadInfo = array (
                    'title' => 'COS - ' . $this -> input -> post ( 'name' ),
                );
                $this -> AccountModel -> edit ( $accountHeadInfo, $department -> account_head_id );
            }
            else
                $this -> add_department_account_head ( $department_id );
            
            $this -> session -> set_flashdata ( 'response', 'Success! Department updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * delete department
         * by service id
         * -------------------------
         */
        
        public function delete_department () {
            $department_id = $this -> uri -> segment ( 3 );
            if ( !empty( $department_id ) and is_numeric ( $department_id ) and $department_id > 0 ) {
                $deleted = $this -> MemberModel -> delete_department ( $department_id );
                if ( $deleted ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Department deleted.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * par levels main page
         * -------------------------
         */
        
        public function par_levels () {
            $title = site_name . ' - Par Levels';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'levels' ] = $this -> StoreModel -> get_par_levels ();
            $this -> load -> view ( '/settings/par-levels/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add par levels main page
         * -------------------------
         */
        
        public function add_par_levels () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_par_levels' )
                $this -> do_add_par_levels ( $_POST );
            
            $title = site_name . ' - Add Par Levels';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $data[ 'items' ]       = $this -> StoreModel -> get_all_store ();
            $this -> load -> view ( '/settings/par-levels/add-par-levels', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add more par levels main page
         * -------------------------
         */
        
        public function add_more_par_levels () {
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $data[ 'items' ]       = $this -> StoreModel -> get_all_store ();
            $data[ 'row' ]         = $this -> input -> post ( 'row', true );
            $this -> load -> view ( '/settings/par-levels/add-more-par-levels', $data );
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add par levels
         * -------------------------
         */
        
        public function do_add_par_levels ( $POST ) {
            $data       = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $department = $this -> input -> post ( 'department_id', true );
            $items      = $this -> input -> post ( 'item_id', true );
            if ( isset( $department ) and $department > 0 and count ( array_filter ( $items ) ) > 0 ) {
                $this -> StoreModel -> delete_par_level ( $department );
                foreach ( $items as $key => $item ) {
                    if ( !empty( trim ( $item ) ) and $item > 0 ) {
                        $info = array (
                            'user_id'       => get_logged_in_user_id (),
                            'department_id' => $department,
                            'item_id'       => $item,
                            'allowed'       => $data[ 'allowed' ][ $key ],
                            'date_added'    => current_date_time (),
                        );
                        $this -> StoreModel -> define_par_levels ( $info );
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Par level added.' );
                return redirect ( base_url ( '/settings/add-par-levels?settings=store-settings' ) );
            }
        }
        
        /**
         * -------------------------
         * delete par level by id
         * -------------------------
         */
        
        public function delete_par_level_by_id () {
            $par_level = $this -> uri -> segment ( 3 );
            if ( $par_level > 0 ) {
                $this -> StoreModel -> delete_par_level_by_id ( $par_level );
                $this -> session -> set_flashdata ( 'response', 'Success! Par level deleted.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * edit par levels main page
         * -------------------------
         */
        
        public function edit_par_levels () {
            
            $department_id = $this -> uri -> segment ( 3 );
            if ( empty( $department_id ) or !is_numeric ( $department_id ) or $department_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_par_levels' )
                $this -> do_edit_par_levels ( $_POST );
            
            $title = site_name . ' - Edit Par Levels';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $data[ 'items' ]       = $this -> StoreModel -> get_all_store ();
            $data[ 'levels' ]      = $this -> StoreModel -> get_levels_by_department ( $department_id );
            $this -> load -> view ( '/settings/par-levels/edit-par-levels', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add par levels
         * -------------------------
         */
        
        public function do_edit_par_levels ( $POST ) {
            $data       = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $department = $this -> input -> post ( 'department_id', true );
            $items      = $this -> input -> post ( 'item_id', true );
            if ( isset( $department ) and $department > 0 and count ( array_filter ( $items ) ) > 0 ) {
                $this -> StoreModel -> delete_par_level ( $department );
                foreach ( $items as $key => $item ) {
                    if ( !empty( trim ( $item ) ) and $item > 0 ) {
                        $info = array (
                            'user_id'       => get_logged_in_user_id (),
                            'department_id' => $department,
                            'item_id'       => $item,
                            'allowed'       => $data[ 'allowed' ][ $key ],
                            'date_added'    => current_date_time (),
                        );
                        $this -> StoreModel -> define_par_levels ( $info );
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Par level added.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete par level
         * by department id
         * -------------------------
         */
        
        public function delete_par_levels () {
            $department_id = $this -> uri -> segment ( 3 );
            if ( !empty( $department_id ) and is_numeric ( $department_id ) and $department_id > 0 ) {
                $deleted = $this -> StoreModel -> delete_par_level ( $department_id );
                if ( $deleted ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Par level deleted.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * ipd services
         * -------------------------
         */
        
        public function ipd_services () {
            $title = site_name . ' - IPD Services';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'services' ] = $this -> IPDModel -> get_services ();
            $this -> load -> view ( '/settings/ipd/services', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add ipd services
         * -------------------------
         */
        
        public function add_ipd_services () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_ipd_services' )
                $this -> do_add_ipd_services ( $_POST );
            
            $title = site_name . ' - Add IPD Services';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'times' ]    = create_time_range ( '01:00', '23:00', '60 mins', '24' );
            $services = $this -> IPDModel -> get_all_services_array ();
            $tree                    = buildTree ( $services );
            $options                 = '';
            $list                    = buildList ( $tree, $options );
            $data['services'] = $list;
            $this -> load -> view ( '/settings/ipd/add-services', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add more ipd charges
         * -------------------------
         */
        
        public function add_more_charges () {
            $data[ 'added' ] = $this -> input -> post ( 'added', true );
            $this -> load -> view ( '/settings/ipd/add-more-charges', $data );
        }
        
        /**
         * -------------------------
         * @param $POST
         * save ipd services
         * -------------------------
         */
        
        public function do_add_ipd_services ( $POST ) {
            $data            = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $requires_doctor = isset( $_POST[ 'requires_doctor' ] ) ? $_POST[ 'requires_doctor' ] : '0';
            $info            = array (
                'user_id'         => get_logged_in_user_id (),
                'parent_id'       => $data[ 'parent_id' ],
                'code'            => $data[ 'code' ],
                'title'           => $data[ 'title' ],
                'charge'          => $data[ 'charge' ],
                'requires_doctor' => $requires_doctor,
                'service_type'    => $_POST[ 'service_type' ],
                'price'           => $data[ 'price' ],
                'description'     => $data[ 'description' ],
                'date_added'      => current_date_time (),
            );
            $service_id      = $this -> IPDModel -> add_ipd_services ( $info );
            if ( $service_id > 0 ) {
                if ( isset( $_POST[ 'add_in_opd' ] ) and $_POST[ 'add_in_opd' ] == '1' ) {
                    $opd_info = array (
                        'user_id'         => get_logged_in_user_id (),
                        'parent_id'       => 0,
                        'code'            => $data[ 'code' ],
                        'title'           => $data[ 'title' ],
                        'charge'          => $data[ 'charge' ],
                        'requires_doctor' => $requires_doctor,
                        'service_type'    => $_POST[ 'service_type' ],
                        'price'           => $data[ 'price' ],
                        'description'     => $data[ 'description' ],
                        'date_added'      => current_date_time (),
                    );
                    $this -> OPDModel -> add ( $opd_info );
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Service added.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * edit ipd services
         * -------------------------
         */
        
        public function edit_ipd_services () {
            
            $service_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $service_id ) ) or !is_numeric ( $service_id ) or $service_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_ipd_services' )
                $this -> do_edit_ipd_services ( $_POST );
            
            $title = site_name . ' - Edit IPD Services';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'service_info' ] = $this -> IPDModel -> get_service_by_id ( $service_id );
            $services = $this -> IPDModel -> get_all_services_array ();
            $tree                    = buildTree ( $services );
            $options                 = '';
            $list                    = buildList ( $tree, $options, 0, false, null, $data[ 'service_info' ] -> parent_id );
            $data['services'] = $list;
            $this -> load -> view ( '/settings/ipd/edit-services', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * save ipd services
         * -------------------------
         */
        
        public function do_edit_ipd_services ( $POST ) {
            $data            = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $service_id      = $_POST[ 'service_id' ];
            $requires_doctor = isset( $_POST[ 'requires_doctor' ] ) ? $_POST[ 'requires_doctor' ] : '0';
            $info            = array (
                'parent_id'       => $data[ 'parent_id' ],
                'code'            => $data[ 'code' ],
                'title'           => $data[ 'title' ],
                'charge'          => $data[ 'charge' ],
                'requires_doctor' => $requires_doctor,
                'service_type'    => $_POST[ 'service_type' ],
                'price'           => $data[ 'price' ],
                'description'     => $data[ 'description' ],
            );
            $service_id      = $this -> IPDModel -> edit_ipd_services ( $info, $service_id );
            if ( $service_id > 0 ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Service updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete services
         * -------------------------
         */
        
        public function delete_ipd_services () {
            $service_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $service_id ) ) or !is_numeric ( $service_id ) or $service_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> IPDModel -> delete_service ( $service_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Service deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * sub ipd services
         * -------------------------
         */
        
        public function sub_ipd_services () {
            $service_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $service_id ) ) or !is_numeric ( $service_id ) or $service_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $title = site_name . ' - IPD Services';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'services' ] = $this -> IPDModel -> get_child_services ( $service_id );
            $this -> load -> view ( '/settings/ipd/services', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add ipd packages
         * -------------------------
         */
        
        public function add_ipd_packages () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_ipd_packages' )
                $this -> do_add_ipd_packages ( $_POST );
            
            $title = site_name . ' - Add IPD Packages';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'services' ] = $this -> IPDModel -> get_parent_services ();
            $this -> load -> view ( '/settings/ipd/add-packages', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add more ipd packages
         * -------------------------
         */
        
        public function add_more_ipd_services () {
            $data[ 'added' ]    = $this -> input -> post ( 'row', true );
            $data[ 'services' ] = $this -> IPDModel -> get_all_services ();
            $this -> load -> view ( '/settings/ipd/add-more-packages', $data );
        }
        
        /**
         * -------------------------
         * @param $POST
         * save ipd package
         * -------------------------
         */
        
        public function do_add_ipd_packages ( $POST ) {
            $data     = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $services = $data[ 'service_id' ];
            $info     = array (
                'user_id'    => get_logged_in_user_id (),
                'title'      => $data[ 'title' ],
                'price'      => $data[ 'net-price' ],
                'date_added' => current_date_time (),
            );
            $saved    = $this -> IPDModel -> add_ipd_packages ( $info );
            if ( $saved > 0 ) {
                if ( isset( $services ) and count ( array_filter ( $services ) ) > 0 ) {
                    foreach ( $services as $key => $service ) {
                        if ( !empty( $service ) and $service > 0 ) {
                            $array = array (
                                'user_id'    => get_logged_in_user_id (),
                                'package_id' => $saved,
                                'service_id' => $service,
                                'price'      => $_POST[ 'price' ][ $key ],
                                'date_added' => current_date_time (),
                            );
                            $this -> IPDModel -> add_ipd_package_services ( $array );
                        }
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Package added.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * ipd packages
         * -------------------------
         */
        
        public function ipd_packages () {
            $title = site_name . ' - IPD Packages';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'packages' ] = $this -> IPDModel -> get_packages ();
            $this -> load -> view ( '/settings/ipd/packages', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * delete package
         * -------------------------
         */
        
        public function delete_ipd_packages () {
            $package_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $package_id ) ) or !is_numeric ( $package_id ) or $package_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> IPDModel -> delete_packages ( $package_id );
            $this -> IPDModel -> delete_ipd_package_services ( $package_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Package deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * edit ipd services
         * -------------------------
         */
        
        public function edit_ipd_packages () {
            
            $package_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $package_id ) ) or !is_numeric ( $package_id ) or $package_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_ipd_package' )
                $this -> do_edit_ipd_package ( $_POST );
            
            $title = site_name . ' - Edit IPD Package';
            $this -> header ( $title );
            $this -> sidebar ();
//            $data[ 'services' ]         = $this -> IPDModel -> get_all_services ();
            $services                   = $this -> OPDModel -> servicesToTree ( $this -> OPDModel -> get_not_selected_services_array ( $package_id ) );
            $data[ 'services_options' ] = $this -> OPDModel -> services_to_options ( $services );
            $data[ 'package' ]          = $this -> IPDModel -> get_package_by_id ( $package_id );
            $data[ 'package_services' ] = $this -> IPDModel -> get_package_all_services ( $package_id );
            $this -> load -> view ( '/settings/ipd/edit-packages', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit ipd package
         * -------------------------
         */

//        public function do_edit_ipd_package ( $POST ) {
//            $data       = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
//            $package_id = $data[ 'package_id' ];
//            $services   = $data[ 'service_id' ];
//            if ( $package_id > 0 ) {
//                if ( isset( $services ) and count ( array_filter ( $services ) ) > 0 ) {
//                    $this -> IPDModel -> delete_ipd_package_services ( $package_id );
//                    foreach ( $services as $service ) {
//                        if ( !empty( $service ) and $service > 0 ) {
//                            $array = array (
//                                'user_id'    => get_logged_in_user_id (),
//                                'package_id' => $package_id,
//                                'service_id' => $service,
//                                'date_added' => current_date_time (),
//                            );
//                            $this -> IPDModel -> add_ipd_package_services ( $array );
//                        }
//                    }
//                }
//                $this -> session -> set_flashdata ( 'response', 'Success! Package update.' );
//                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
//            }
//            else {
//                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
//                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
//            }
//        }
        
        /**
         * -------------------------
         * par levels main page
         * -------------------------
         */
        
        public function internal_issuance_medicines_par_levels () {
            $title = site_name . ' - Par Levels';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'levels' ] = $this -> StoreModel -> get_internal_issuance_par_levels ();
            $this -> load -> view ( '/settings/par-levels/internal-issuance-index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add more par levels main page
         * -------------------------
         */
        
        public function add_more_internal_issuance_par_levels () {
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $data[ 'medicines' ]   = $this -> MedicineModel -> get_all_medicines ();
            $data[ 'row' ]         = $this -> input -> post ( 'row', true );
            $this -> load -> view ( '/settings/par-levels/add-more-internal-issuance-par-levels', $data );
        }
        
        /**
         * -------------------------
         * add internal issuance medicines
         * par level
         * -------------------------
         */
        
        public function add_internal_issuance_medicines_par_levels () {
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_internal_issuance_medicines_par_levels' )
                $this -> do_add_internal_issuance_medicines_par_levels ( $_POST );
            
            $title = site_name . ' - Add Internal Issuance Medicines Par Levels';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $data[ 'medicines' ]   = $this -> MedicineModel -> get_all_medicines ();
            $this -> load -> view ( '/settings/par-levels/add-internal-issuance-par-levels', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add par levels
         * -------------------------
         */
        
        public function do_add_internal_issuance_medicines_par_levels ( $POST ) {
            $data       = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $department = $this -> input -> post ( 'department_id', true );
            $medicines  = $this -> input -> post ( 'medicine_id', true );
            if ( isset( $department ) and $department > 0 and count ( array_filter ( $medicines ) ) > 0 ) {
                $this -> StoreModel -> delete_internal_issuance_medicines_par_level ( $department );
                foreach ( $medicines as $key => $medicine_id ) {
                    if ( !empty( trim ( $medicine_id ) ) and $medicine_id > 0 ) {
                        $info = array (
                            'user_id'       => get_logged_in_user_id (),
                            'department_id' => $department,
                            'medicine_id'   => $medicine_id,
                            'allowed'       => $data[ 'allowed' ][ $key ],
                            'date_added'    => current_date_time (),
                        );
                        $this -> StoreModel -> define_internal_issuance_par_levels ( $info );
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Par level added.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * edit par levels main page
         * -------------------------
         */
        
        public function edit_issuance_medicines_par_levels () {
            
            $department_id = $this -> uri -> segment ( 3 );
            if ( empty( $department_id ) or !is_numeric ( $department_id ) or $department_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_issuance_medicines_par_levels' )
                $this -> do_edit_issuance_medicines_par_levels ( $_POST );
            
            $title = site_name . ' - Edit Par Levels';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $data[ 'medicines' ]   = $this -> MedicineModel -> get_all_medicines ();
            $data[ 'levels' ]      = $this -> StoreModel -> get_internal_issuance_levels_by_department ( $department_id );
            $this -> load -> view ( '/settings/par-levels/edit-internal-issuance-par-levels', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add par levels
         * -------------------------
         */
        
        public function do_edit_issuance_medicines_par_levels ( $POST ) {
            $data       = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $department = $this -> input -> post ( 'department_id', true );
            $medicines  = $this -> input -> post ( 'medicine_id', true );
            if ( isset( $department ) and $department > 0 and count ( array_filter ( $medicines ) ) > 0 ) {
                $this -> StoreModel -> delete_internal_issuance_medicines_par_level ( $department );
                foreach ( $medicines as $key => $medicine_id ) {
                    if ( !empty( trim ( $medicine_id ) ) and $medicine_id > 0 ) {
                        $info = array (
                            'user_id'       => get_logged_in_user_id (),
                            'department_id' => $department,
                            'medicine_id'   => $medicine_id,
                            'allowed'       => $data[ 'allowed' ][ $key ],
                            'date_added'    => current_date_time (),
                        );
                        $this -> StoreModel -> define_internal_issuance_par_levels ( $info );
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Par level updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete par levels
         * -------------------------
         */
        
        public function delete_internal_issuance_par_level_by_id () {
            $level_id = $this -> uri -> segment ( 3 );
            if ( $level_id > 0 ) {
                $this -> StoreModel -> delete_internal_issuance_par_level_by_id ( $level_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Par level deleted.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete par level
         * by department id
         * -------------------------
         */
        
        public function delete_issuance_medicines_par_levels () {
            $department_id = $this -> uri -> segment ( 3 );
            if ( !empty( $department_id ) and is_numeric ( $department_id ) and $department_id > 0 ) {
                $deleted = $this -> StoreModel -> delete_internal_issuance_medicines_par_level ( $department_id );
                if ( $deleted ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Par level deleted.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * add pack sizes
         * for medicines
         * -------------------------
         */
        
        public function pack_sizes () {
            $title = site_name . ' - Pack sizes';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'packs' ] = $this -> MedicineModel -> get_pack_sizes ();
            $this -> load -> view ( '/settings/pack-size/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add pack sizes
         * for medicines
         * -------------------------
         */
        
        public function add_pack_sizes () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_pack_sizes' )
                $this -> do_add_pack_sizes ( $_POST );
            
            $title = site_name . ' - Add pack size';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/pack-size/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add pack sizes
         * -------------------------
         */
        
        public function do_add_pack_sizes ( $POST ) {
            $data  = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $title = $data[ 'title' ];
            if ( isset( $title ) and count ( array_filter ( $title ) ) > 0 ) {
                foreach ( $title as $size ) {
                    if ( !empty( trim ( $size ) ) ) {
                        $info = array (
                            'user_id'    => get_logged_in_user_id (),
                            'title'      => $size,
                            'date_added' => current_date_time (),
                        );
                        $this -> MedicineModel -> do_add_pack_sizes ( $info );
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Pack size added.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete pack size
         * -------------------------
         */
        
        public function delete_pack () {
            $pack_id = $this -> uri -> segment ( 3 );
            if ( !empty( $pack_id ) and is_numeric ( $pack_id ) and $pack_id > 0 ) {
                $deleted = $this -> MedicineModel -> delete_pack ( $pack_id );
                if ( $deleted ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Pack size deleted.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * edit pack size
         * -------------------------
         */
        
        public function edit_pack () {
            
            $pack_id = $this -> uri -> segment ( 3 );
            if ( empty( $pack_id ) or !is_numeric ( $pack_id ) or $pack_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_pack_size' )
                $this -> do_edit_pack_size ( $_POST );
            
            $title = site_name . ' - Edit Pack size';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'pack' ] = $this -> MedicineModel -> get_pack_size_by_id ( $pack_id );
            $this -> load -> view ( '/settings/pack-size/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do edit pack sizes
         * -------------------------
         */
        
        public function do_edit_pack_size ( $POST ) {
            $data    = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $title   = $data[ 'title' ];
            $pack_id = $data[ 'pack_id' ];
            if ( !empty( trim ( $title ) ) ) {
                $info = array (
                    'title' => $title,
                );
                $this -> MedicineModel -> do_edit_pack_size ( $info, $pack_id );
            }
            $this -> session -> set_flashdata ( 'response', 'Success! Pack size updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * add cities main page
         * -------------------------
         */
        
        public function add_city () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_city' )
                $this -> do_add_city ( $_POST );
            
            $title = site_name . ' - Add City';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/cities/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add city
         * -------------------------
         */
        
        public function do_add_city ( $POST ) {
            $data  = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $title = $data[ 'title' ];
            if ( isset( $title ) and count ( array_filter ( $title ) ) > 0 ) {
                foreach ( $title as $name ) {
                    if ( !empty( trim ( $name ) ) ) {
                        $info = array (
                            'user_id'    => get_logged_in_user_id (),
                            'title'      => $name,
                            'date_added' => current_date_time (),
                        );
                        $this -> PatientModel -> do_add_city ( $info );
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Cities added.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * cities main page
         * -------------------------
         */
        
        public function cities () {
            $title = site_name . ' - Cities';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'cities' ] = $this -> PatientModel -> get_cities ();
            $this -> load -> view ( '/settings/cities/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * delete city
         * -------------------------
         */
        
        public function delete_city () {
            $city_id = $this -> uri -> segment ( 3 );
            if ( !empty( $city_id ) and is_numeric ( $city_id ) and $city_id > 0 ) {
                $deleted = $this -> PatientModel -> delete_city ( $city_id );
                if ( $deleted ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! City deleted.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * edit cities main page
         * -------------------------
         */
        
        public function edit_city () {
            
            $city_id = $this -> uri -> segment ( 3 );
            if ( empty( $city_id ) or !is_numeric ( $city_id ) or $city_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_city' )
                $this -> do_edit_city ( $_POST );
            
            $title = site_name . ' - Edit City';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'city' ] = $this -> PatientModel -> get_city_by_id ( $city_id );
            $this -> load -> view ( '/settings/cities/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do edit city
         * -------------------------
         */
        
        public function do_edit_city ( $POST ) {
            $data    = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $title   = $data[ 'title' ];
            $city_id = $data[ 'city_id' ];
            if ( !empty( trim ( $title ) ) ) {
                $info = array (
                    'title'      => $title,
                    'date_added' => current_date_time (),
                );
                $this -> PatientModel -> do_edit_city ( $info, $city_id );
                $this -> session -> set_flashdata ( 'response', 'Success! City updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete ip services panel
         * -------------------------
         */
        
        public function delete_panel_ipd_service () {
            $service_id = $this -> uri -> segment ( 3 );
            if ( empty( $service_id ) or !is_numeric ( $service_id ) or $service_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> PanelModel -> delete_panel_ipd_service ( $service_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Service Deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * delete ip services panel
         * -------------------------
         */
        
        public function delete_panel_opd_service () {
            $service_id = $this -> uri -> segment ( 3 );
            if ( empty( $service_id ) or !is_numeric ( $service_id ) or $service_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> PanelModel -> delete_panel_opd_service ( $service_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Service Deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * delete ip services doctor
         * -------------------------
         */
        
        public function delete_panel_ipd_doctor () {
            $doctor_id = $this -> uri -> segment ( 3 );
            if ( empty( $doctor_id ) or !is_numeric ( $doctor_id ) or $doctor_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> PanelModel -> delete_panel_ipd_doctor ( $doctor_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Doctor Deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * edit cities main page
         * -------------------------
         */
        
        public function site_settings () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_login_page_images' )
                $this -> do_add_login_page_images ();
            
            $title = site_name . ' - Site Settings';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'background' ] = $this -> SettingModel -> getBackground ();
            $data[ 'logo' ]       = $this -> SettingModel -> getLogo ();
            $this -> load -> view ( '/settings/site-settings/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add login page
         * background and logo
         * -------------------------
         */
        
        public function do_add_login_page_images () {
            $loginBackground = upload_files ( 'background_image' );
            $logo            = upload_files ( 'logo' );
            $data            = array (
                'user_id'          => get_logged_in_user_id (),
                'login_background' => $loginBackground,
                'logo'             => $logo
            );
            $this -> SettingModel -> add ( $data );
            $this -> session -> set_flashdata ( 'response', 'Success! Page settings updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        public function panel_status () {
            $status = $this -> input -> get ( 'status', true );
            $id     = $this -> input -> get ( 'id' );
            
            if ( empty( $id ) or decode ( $id ) < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $info  = array (
                'status' => $status
            );
            $where = array (
                'id' => decode ( $id )
            );
            
            $this -> PanelModel -> update ( $info, $where );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * specimen main page
         * -------------------------
         */
        
        public function specimen () {
            $title = site_name . ' - Specimen';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'specimen' ] = $this -> SpecimenModel -> get_specimen ();
            $this -> load -> view ( '/settings/specimen/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add specimen main page
         * -------------------------
         */
        
        public function add_specimen () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_specimen' )
                $this -> process_add_specimen ();
            
            $title = site_name . ' - Add Specimen';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/specimen/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add specimen
         * redirect with message
         * -------------------------
         */
        
        private function process_add_specimen () {
            $title = $this -> input -> post ( 'title' );
            
            if ( count ( array_filter ( $title ) ) > 0 ) {
                foreach ( $title as $item ) {
                    if ( !empty( trim ( $item ) ) ) {
                        $info = array (
                            'user_id' => get_logged_in_user_id (),
                            'title'   => $item,
                        );
                        $this -> SpecimenModel -> add ( $info );
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Specimen added.' );
                return redirect ( base_url ( '/settings/add-specimen?settings=lab' ) );
            }
        }
        
        
        /**
         * -------------------------
         * edit specimen main page
         * -------------------------
         */
        
        public function edit_specimen () {
            
            $id = $this -> uri -> segment ( 3 );
            if ( empty( $id ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_specimen' )
                $this -> process_edit_specimen ();
            
            $title = site_name . ' - Edit Specimen';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'specimen' ] = $this -> SpecimenModel -> get_specimen_by_id ( $id );
            $this -> load -> view ( '/settings/specimen/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * process edit specimen
         * -------------------------
         */
        
        public function process_edit_specimen () {
            $title = $this -> input -> post ( 'title' );
            $id    = $this -> input -> post ( 'id' );
            
            if ( !empty( trim ( $title ) ) ) {
                $info = array (
                    'title' => $title,
                );
                $this -> SpecimenModel -> edit ( $info, $id );
                $this -> session -> set_flashdata ( 'response', 'Success! Specimen updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete specimen
         * -------------------------
         */
        
        public function delete_specimen () {
            $id = $this -> uri -> segment ( 3 );
            if ( empty( $id ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> SpecimenModel -> delete ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! Specimen deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * remarks main page
         * -------------------------
         */
        
        public function remarks () {
            $title = site_name . ' - Remarks';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'remarks' ] = $this -> RemarksModel -> get_remarks ();
            $this -> load -> view ( '/settings/remarks/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add remarks main page
         * -------------------------
         */
        
        public function add_remarks () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_remarks' )
                $this -> process_add_remarks ();
            
            $title = site_name . ' - Add Remarks';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/remarks/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add remarks
         * redirect with message
         * -------------------------
         */
        
        private function process_add_remarks () {
            $remarks = $this -> input -> post ( 'remarks' );
            
            if ( count ( array_filter ( $remarks ) ) > 0 ) {
                foreach ( $remarks as $remark ) {
                    if ( !empty( trim ( $remark ) ) ) {
                        $info = array (
                            'user_id' => get_logged_in_user_id (),
                            'remarks' => $remark,
                        );
                        $this -> RemarksModel -> add ( $info );
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Remarks added.' );
                return redirect ( base_url ( '/settings/add-remarks?settings=lab' ) );
            }
        }
        
        /**
         * -------------------------
         * edit remarks main page
         * -------------------------
         */
        
        public function edit_remarks () {
            
            $id = $this -> uri -> segment ( 3 );
            if ( empty( $id ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_remarks' )
                $this -> process_edit_remarks ();
            
            $title = site_name . ' - Edit Remarks';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'remarks' ] = $this -> RemarksModel -> get_remarks_by_id ( $id );
            $this -> load -> view ( '/settings/remarks/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * process edit remarks
         * -------------------------
         */
        
        public function process_edit_remarks () {
            $remarks = $this -> input -> post ( 'remarks' );
            $id      = $this -> input -> post ( 'id' );
            
            if ( !empty( trim ( $remarks ) ) ) {
                $info = array (
                    'remarks' => $remarks,
                );
                $this -> RemarksModel -> edit ( $info, $id );
                $this -> session -> set_flashdata ( 'response', 'Success! Remarks updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete remarks
         * -------------------------
         */
        
        public function delete_remarks () {
            $id = $this -> uri -> segment ( 3 );
            if ( empty( $id ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> RemarksModel -> delete ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! Remarks deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * destinations main page
         * -------------------------
         */
        
        public function destinations () {
            $title = site_name . ' - Destinations';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'destinations' ] = $this -> DestinationModel -> get_destinations ();
            $this -> load -> view ( '/settings/destinations/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * destinations add page
         * -------------------------
         */
        
        public function add_destinations () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_destinations' )
                $this -> do_add_destinations ( $_POST );
            
            $title = site_name . ' - Add Destinations';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/destinations/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add destinations
         * redirect with message
         * -------------------------
         */
        
        private function do_add_destinations () {
            $this -> form_validation -> set_rules ( 'title', 'destination', 'required|trim|is_unique[destinations.title]|xss_clean' );
            
            if ( $this -> form_validation -> run () ) {
                $title = $this -> input -> post ( 'title' );
                
                if ( !empty( trim ( $title ) ) ) {
                    $info = array (
                        'user_id' => get_logged_in_user_id (),
                        'title'   => $title,
                    );
                    $this -> DestinationModel -> add ( $info );
                }
            }
            $this -> session -> set_flashdata ( 'response', 'Success! Destination added.' );
            return redirect ( base_url ( '/settings/add-destinations?settings=lab' ) );
        }
        
        /**
         * -------------------------
         * destinations edit page
         * -------------------------
         */
        
        public function edit_destination () {
            
            $id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_destination' )
                $this -> do_edit_destination ( $_POST );
            
            $title = site_name . ' - Edit Destination';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'destination' ] = $this -> DestinationModel -> get_destinations_by_id ( $id );
            $this -> load -> view ( '/settings/destinations/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * do edit destinations
         * -------------------------
         */
        
        public function do_edit_destination () {
            $this -> form_validation -> set_rules ( 'title', 'destination', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'destination-id', 'destination id', 'required|trim|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                
                $title   = $this -> input -> post ( 'title' );
                $id      = $this -> input -> post ( 'destination-id' );
                $info    = array (
                    'title' => $title,
                );
                $updated = $this -> DestinationModel -> edit ( $info, $id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Destination updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Already updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Delete destinations main page
         * -------------------------
         */
        
        public function delete_destination () {
            
            $id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> DestinationModel -> delete ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! Destination deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * airlines main page
         * -------------------------
         */
        
        public function airlines () {
            $title = site_name . ' - Airlines';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'airlines' ] = $this -> AirlineModel -> get_airlines ();
            $this -> load -> view ( '/settings/airlines/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * airlines add page
         * -------------------------
         */
        
        public function add_airlines () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_airlines' )
                $this -> do_add_airlines ( $_POST );
            
            $title = site_name . ' - Add Airlines';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/airlines/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add airlines
         * redirect with message
         * -------------------------
         */
        
        private function do_add_airlines () {
            $this -> form_validation -> set_rules ( 'title', 'airlines', 'required|trim|is_unique[airlines.title]|xss_clean' );
            
            if ( $this -> form_validation -> run () ) {
                $title = $this -> input -> post ( 'title' );
                
                if ( !empty( trim ( $title ) ) ) {
                    $info = array (
                        'user_id' => get_logged_in_user_id (),
                        'title'   => $title,
                    );
                    $this -> AirlineModel -> add ( $info );
                }
            }
            $this -> session -> set_flashdata ( 'response', 'Success! Airline added.' );
            return redirect ( base_url ( '/settings/add-airlines?settings=lab' ) );
        }
        
        /**
         * -------------------------
         * airlines edit page
         * -------------------------
         */
        
        public function edit_airlines () {
            
            $id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_airlines' )
                $this -> do_edit_airlines ( $_POST );
            
            $title = site_name . ' - Edit Airline';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'airline' ] = $this -> AirlineModel -> get_airlines_by_id ( $id );
            $this -> load -> view ( '/settings/airlines/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * do edit airlines
         * -------------------------
         */
        
        public function do_edit_airlines () {
            $this -> form_validation -> set_rules ( 'title', 'airline', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'airline-id', 'airline id', 'required|trim|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                
                $title   = $this -> input -> post ( 'title' );
                $id      = $this -> input -> post ( 'airline-id' );
                $info    = array (
                    'title' => $title,
                );
                $updated = $this -> AirlineModel -> edit ( $info, $id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Airline updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Already updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Delete airlines main page
         * -------------------------
         */
        
        public function delete_airlines () {
            
            $id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> AirlineModel -> delete ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! Dirline deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * rooms
         * -------------------------
         */
        
        public function rooms () {
            $title = site_name . ' - Rooms';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'rooms' ] = $this -> RoomModel -> get_rooms ();
            $this -> load -> view ( '/settings/rooms/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add rooms
         * -------------------------
         */
        
        public function add_rooms () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_rooms' )
                $this -> do_add_rooms ();
            
            $title = site_name . ' - Add Rooms';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/rooms/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * process add rooms
         * -------------------------
         */
        
        public function do_add_rooms () {
            $title = $this -> input -> post ( 'title' );
            $beds  = $this -> input -> post ( 'beds' );
            
            $info = array (
                'user_id' => get_logged_in_user_id (),
                'title'   => $title,
            );
            $id   = $this -> RoomModel -> add ( $info );
            if ( $id > 0 ) {
                if ( isset( $beds ) and count ( array_filter ( $beds ) ) > 0 ) {
                    foreach ( $beds as $bed ) {
                        if ( !empty( $bed ) ) {
                            $array = array (
                                'user_id' => get_logged_in_user_id (),
                                'room_id' => $id,
                                'title'   => $bed,
                            );
                            $this -> RoomModel -> add_beds ( $array );
                        }
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Room & beds added.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * edit rooms
         * -------------------------
         */
        
        public function edit_rooms () {
            
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !is_numeric ( decode ( $id ) ) or decode ( $id ) < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_rooms' )
                $this -> do_edit_rooms ();
            
            $title = site_name . ' - Edit Rooms';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'room' ] = $this -> RoomModel -> get_room_by_id ( decode ( $id ) );
            $data[ 'beds' ] = $this -> RoomModel -> get_beds_by_room_id ( decode ( $id ) );
            $this -> load -> view ( '/settings/rooms/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * edit rooms & beds
         * -------------------------
         */
        
        public function do_edit_rooms () {
            $id    = $this -> input -> post ( 'room_id' );
            $title = $this -> input -> post ( 'title' );
            $beds  = $this -> input -> post ( 'beds' );
            
            $info = array (
                'title' => $title,
            );
            $this -> RoomModel -> edit ( $info, $id );
            $this -> RoomModel -> delete_beds ( $id );
            if ( $id > 0 ) {
                if ( isset( $beds ) and count ( array_filter ( $beds ) ) > 0 ) {
                    foreach ( $beds as $bed ) {
                        if ( !empty( $bed ) ) {
                            $array = array (
                                'user_id' => get_logged_in_user_id (),
                                'room_id' => $id,
                                'title'   => $bed,
                            );
                            $this -> RoomModel -> add_beds ( $array );
                        }
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Room & beds updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete rooms/beds
         * -------------------------
         */
        
        public function delete_rooms () {
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !is_numeric ( decode ( $id ) ) or decode ( $id ) < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> RoomModel -> delete ( decode ( $id ) );
            $this -> RoomModel -> delete_beds ( decode ( $id ) );
            $this -> session -> set_flashdata ( 'response', 'Success! Rooms & beds deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * add references main page
         * -------------------------
         */
        
        public function add_references () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_references' )
                $this -> do_add_references ( $_POST );
            
            $title = site_name . ' - Add References';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/references/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add references
         * -------------------------
         */
        
        public function do_add_references ( $POST ) {
            $data  = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $title = $data[ 'title' ];
            if ( isset( $title ) and count ( array_filter ( $title ) ) > 0 ) {
                foreach ( $title as $name ) {
                    if ( !empty( trim ( $name ) ) ) {
                        $info = array (
                            'user_id'    => get_logged_in_user_id (),
                            'title'      => $name,
                            'created_at' => current_date_time (),
                        );
                        $this -> ReferenceModel -> add ( $info );
                    }
                }
            }
            $this -> session -> set_flashdata ( 'response', 'Success! References added.' );
            return redirect ( base_url ( '/settings/add-references?settings=general' ) );
        }
        
        /**
         * -------------------------
         * references main page
         * -------------------------
         */
        
        public function references () {
            $title = site_name . ' - References';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'references' ] = $this -> ReferenceModel -> get_references ();
            $this -> load -> view ( '/settings/references/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * edit reference main page
         * -------------------------
         */
        
        public function edit_reference () {
            
            $id = $this -> uri -> segment ( 3 );
            if ( empty( $id ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_reference' )
                $this -> do_edit_reference ( $_POST );
            
            $title = site_name . ' - Edit Reference';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'reference' ] = $this -> ReferenceModel -> get_reference_by_id ( $id );
            $this -> load -> view ( '/settings/references/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do edit reference
         * -------------------------
         */
        
        public function do_edit_reference ( $POST ) {
            $data         = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $title        = $data[ 'title' ];
            $reference_id = $data[ 'reference-id' ];
            if ( !empty( trim ( $title ) ) ) {
                $where = array (
                    'id' => $reference_id,
                );
                $info  = array (
                    'title'      => $title,
                    'created_at' => current_date_time (),
                );
                $this -> ReferenceModel -> edit ( $info, $where );
                $this -> session -> set_flashdata ( 'response', 'Success! Reference updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete reference
         * -------------------------
         */
        
        public function delete_reference () {
            $id = $this -> uri -> segment ( 3 );
            if ( empty( $id ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( base_url ( '/settings/references?settings=general' ) );
            
            $deleted = $this -> ReferenceModel -> delete ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! Reference deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        public function load_ipd_services_row () {
            $service_id    = $this -> input -> get ( 'service_id' );
            $data[ 'row' ] = $this -> input -> get ( 'row' );
            
            if ( isset( $service_id ) && $service_id > 0 ) {
                $data[ 'service' ] = get_ipd_service_by_id ( $service_id );
                $this -> load -> view ( 'settings/ipd/add-ipd-service-row', $data );
            }
            
        }
        
        public function edit_ipd_package ( $id ) {
            
            if ( empty( $id ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( base_url ( '/settings/ipd-packages?settings=ipd' ) );
            
            if ( isset( $_POST[ 'action' ] ) and $this -> input -> post ( 'action' ) == 'do_edit_ipd_package' )
                $this -> do_edit_ipd_package ();
            
            $title = site_name . ' - Edit IPD Package';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'services' ]         = $this -> IPDModel -> get_unselected_services ( $id );
            $data[ 'package' ]          = $this -> IPDModel -> get_package_by_id ( $id );
            $data[ 'package_services' ] = $this -> IPDModel -> get_package_all_services ( $id );
            $this -> load -> view ( '/settings/ipd/edit-package', $data );
            $this -> footer ();
        }
        
        public function do_edit_ipd_package () {
            
            $services   = $this -> input -> post ( 'service_id' );
            $package_id = $this -> input -> post ( 'package-id' );
            
            $info = array (
                'title' => $this -> input -> post ( 'title' ),
                'price' => $this -> input -> post ( 'net-price' ),
            );
            $this -> IPDModel -> edit_ipd_package ( $info, $package_id );
            
            $this -> IPDModel -> delete_ipd_package_services ( $package_id );
            
            if ( isset( $services ) and count ( array_filter ( $services ) ) > 0 ) {
                foreach ( $services as $key => $service_id ) {
                    if ( !empty( $service_id ) and $service_id > 0 ) {
                        $array = array (
                            'user_id'    => get_logged_in_user_id (),
                            'package_id' => $package_id,
                            'service_id' => $service_id,
                            'price'      => $_POST[ 'price' ][ $key ],
                            'date_added' => current_date_time (),
                        );
                        $this -> IPDModel -> add_ipd_package_services ( $array );
                    }
                }
            }
            $this -> session -> set_flashdata ( 'response', 'Success! Package updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        public function opd_service_status ( $id ) {
            $this -> OPDModel -> opd_service_status ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! Service status updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * packages main page
         * -------------------------
         */
        
        public function packages () {
            $title = site_name . ' - Packages';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'packages' ] = $this -> PackageModel -> get_lab_packages ();
            $this -> load -> view ( '/settings/packages/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * packages add page
         * -------------------------
         */
        
        public function add_packages () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_packages' )
                $this -> do_add_packages ( $_POST );
            
            $title = site_name . ' - Add Packages';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'tests' ] = $this -> LabModel -> get_parent_tests ();
            $this -> load -> view ( '/settings/packages/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add more tests
         * -------------------------
         */
        
        public function addMoreTestsForPackage () {
            $data[ 'tests' ] = $this -> LabModel -> get_parent_tests ();
            $data[ 'row' ]   = $this -> input -> get ( 'row', true );
            $this -> load -> view ( '/settings/packages/add-more', $data );
        }
        
        /**
         * -------------------------
         * add packages
         * redirect with message
         * -------------------------
         */
        
        private function do_add_packages () {
            $this -> form_validation -> set_rules ( 'title', 'package title', 'required|trim|is_unique[lab_packages.title]|xss_clean' );
            $this -> form_validation -> set_rules ( 'price', 'package price', 'required|trim|xss_clean' );
            
            if ( $this -> form_validation -> run () ) {
                $title = $this -> input -> post ( 'title' );
                $price = $this -> input -> post ( 'price' );
                $tests = $this -> input -> post ( 'test-id' );
                
                if ( !empty( trim ( $title ) ) ) {
                    $info = array (
                        'user_id' => get_logged_in_user_id (),
                        'title'   => $title,
                        'price'   => $price,
                    );
                    $id   = $this -> PackageModel -> add ( $info );
                    
                    /***********LOGS*************/
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'action'       => 'package_added',
                        'log'          => json_encode ( $this -> PackageModel -> get_lab_packages_by_id ( $id ) ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_package_logs', $log );
                    /***********END LOG*************/
                    
                    if ( $id > 0 and count ( $tests ) > 0 ) {
                        foreach ( $tests as $test ) {
                            if ( !empty( trim ( $test ) ) and $test > 0 ) {
                                $package = array (
                                    'user_id'    => get_logged_in_user_id (),
                                    'package_id' => $id,
                                    'test_id'    => $test
                                );
                                $this -> PackageModel -> addPackageTests ( $package );
                                
                                /***********LOGS*************/
                                $log = array (
                                    'user_id'      => get_logged_in_user_id (),
                                    'action'       => 'package_tests_added',
                                    'log'          => json_encode ( $package ),
                                    'after_update' => '',
                                    'date_added'   => current_date_time ()
                                );
                                $this -> load -> model ( 'LogModel' );
                                $this -> LogModel -> create_log ( 'lab_package_logs', $log );
                                /***********END LOG*************/
                                
                            }
                        }
                    }
                    
                }
            }
            $this -> session -> set_flashdata ( 'response', 'Success! Package added.' );
            return redirect ( base_url ( '/settings/add-packages?settings=lab' ) );
        }
        
        /**
         * -------------------------
         * packages edit page
         * -------------------------
         */
        
        public function edit_packages () {
            
            $id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_packages' )
                $this -> do_edit_packages ( $_POST );
            
            $title = site_name . ' - Edit Package';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'package' ] = $this -> PackageModel -> get_lab_packages_by_id ( $id );
            $data[ 'tests' ]   = $this -> PackageModel -> get_lab_package_tests ( $id );
            $this -> load -> view ( '/settings/packages/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * do edit packages
         * -------------------------
         */
        
        public function do_edit_packages () {
            $this -> form_validation -> set_rules ( 'title', 'package title', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'price', 'package price', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'package-id', 'package id', 'required|trim|xss_clean' );
            
            if ( $this -> form_validation -> run () ) {
                $title      = $this -> input -> post ( 'title' );
                $price      = $this -> input -> post ( 'price' );
                $package_id = $this -> input -> post ( 'package-id' );
                $tests      = $this -> input -> post ( 'test-id' );
                
                if ( !empty( trim ( $title ) ) ) {
                    $info  = array (
                        'user_id' => get_logged_in_user_id (),
                        'title'   => $title,
                        'price'   => $price,
                    );
                    $where = array (
                        'id' => $package_id
                    );
                    $this -> PackageModel -> edit ( $info, $where );
                    
                    /***********LOGS*************/
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'action'       => 'package_updated',
                        'log'          => json_encode ( $this -> PackageModel -> get_lab_packages_by_id ( $package_id ) ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_package_logs', $log );
                    /***********END LOG*************/
                    
                    foreach ( $tests as $test ) {
                        if ( !empty( trim ( $test ) ) and $test > 0 ) {
                            $package = array (
                                'user_id'    => get_logged_in_user_id (),
                                'package_id' => $package_id,
                                'test_id'    => $test
                            );
                            $this -> PackageModel -> addPackageTests ( $package );
                            
                            /***********LOGS*************/
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'action'       => 'package_tests_added',
                                'log'          => json_encode ( $package ),
                                'after_update' => '',
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'lab_package_logs', $log );
                            /***********END LOG*************/
                        }
                    }
                }
            }
            $this -> session -> set_flashdata ( 'response', 'Success! Package updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * Delete packages tests main page
         * -------------------------
         */
        
        public function delete_lab_package_test () {
            
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            /***********LOGS*************/
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'action'       => 'package_test_deleted',
                'log'          => json_encode ( $this -> PackageModel -> get_lab_package_test_by_id ( $id ) ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'lab_package_logs', $log );
            /***********END LOG*************/
            
            $this -> PackageModel -> delete_lab_package_test ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! Package test deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * Delete packages main page
         * -------------------------
         */
        
        public function delete_package () {
            
            $id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            /***********LOGS*************/
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'action'       => 'package_deleted',
                'log'          => json_encode ( $this -> PackageModel -> get_lab_packages_by_id ( $id ) ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'lab_package_logs', $log );
            /***********END LOG*************/
            
            $this -> PackageModel -> delete ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! Package deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        public function online_references () {
            $title = site_name . ' - Online Referral Portals';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'references' ] = $this -> OnlineReferenceModel -> get_references ();
            $this -> load -> view ( '/settings/online-references/index', $data );
            $this -> footer ();
        }
        
        public function add_online_references () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_online_references' )
                $this -> do_add_online_references ();
            
            $title = site_name . ' - Add Online Referral Portals';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/settings/online-references/add' );
            $this -> footer ();
        }
        
        public function do_add_online_references () {
            $title      = $this -> input -> post ( 'title', true );
            $commission = $this -> input -> post ( 'commission', true );
            
            $account_head    = get_account_head ( payable_accounts );
            $info            = array (
                'title'          => $title,
                'parent_id'      => payable_accounts,
                'role_id'        => $account_head -> role_id,
                'panel_id'       => null,
                'contact_person' => $title,
                'phone'          => null,
                'status'         => '1',
                'type'           => 15,
                'deleteable'     => '0',
                'description'    => null,
                'date_added'     => current_date_time (),
            );
            $account_head_id = $this -> AccountModel -> insert ( $info );
            
            $info = array (
                'user_id'         => get_logged_in_user_id (),
                'account_head_id' => $account_head_id,
                'title'           => $title,
                'commission'      => $commission,
            );
            $this -> OnlineReferenceModel -> add ( $info );
            
            $this -> session -> set_flashdata ( 'response', 'Success! References added.' );
            return redirect ( base_url ( '/settings/add-online-references?settings=general' ) );
        }
        
        public function edit_online_references () {
            
            $id = $this -> uri -> segment ( 3 );
            if ( empty( $id ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_online_reference' )
                $this -> do_edit_online_reference ();
            
            $title = site_name . ' - Edit Online Referral Portal';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'reference' ] = $this -> OnlineReferenceModel -> get_reference_by_id ( $id );
            $this -> load -> view ( '/settings/online-references/edit', $data );
            $this -> footer ();
        }
        
        public function do_edit_online_reference () {
            $title        = $this -> input -> post ( 'title', true );
            $commission   = $this -> input -> post ( 'commission', true );
            $reference_id = $this -> input -> post ( 'reference-id', true );
            
            $info  = array (
                'title'      => $title,
                'commission' => $commission,
            );
            $where = array (
                'id' => $reference_id,
            );
            
            $this -> OnlineReferenceModel -> edit ( $info, $where );
            $this -> session -> set_flashdata ( 'response', 'Success! Reference updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        public function delete_online_references () {
            $id = $this -> uri -> segment ( 3 );
            if ( empty( $id ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( base_url ( '/settings/online-references?settings=general' ) );
            
            $this -> OnlineReferenceModel -> delete ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! Reference deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        public function add_more_panel_tests () {
            $data[ 'row' ]     = $this -> input -> get ( 'added' );
            $data[ 'test_id' ] = $this -> input -> get ( 'test_id' );
            $this -> load -> view ( '/settings/panels/add_more_panel_tests', $data );
        }
        
        public function do_edit_panel_lab () {
            $panel_id = $this -> input -> post ( 'panel_id' );
            $tests    = $this -> input -> post ( 'test_id' );
            $price    = $this -> input -> post ( 'price' );
            $discount = $this -> input -> post ( 'discount' );
            $type     = $this -> input -> post ( 'type' );
            
            if ( !empty( trim ( $panel_id ) ) and is_numeric ( $panel_id ) and $panel_id > 0 ) {
                $this -> PanelModel -> delete_panel_lab_tests ( $panel_id );
                if ( isset( $tests ) and count ( $tests ) > 0 ) {
                    foreach ( $tests as $key => $test ) {
                        if ( !empty( trim ( $test ) ) ) {
                            $info = array (
                                'user_id'    => get_logged_in_user_id (),
                                'panel_id'   => $panel_id,
                                'test_id'    => $test,
                                'price'      => $price[ $key ],
                                'discount'   => 0,
                                'type'       => 'flat',
                                'date_added' => current_date_time ()
                            );
                            $this -> PanelModel -> add_panel_lab_tests ( $info );
                        }
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Panel updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
    }
