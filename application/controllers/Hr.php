<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Hr extends CI_Controller {
        
        /**
         * -------
         * Hr constructor.
         * loads helpers, modal or libraries
         * -------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'HrModel' );
            $this -> load -> model ( 'PatientModel' );
            $this -> load -> model ( 'MemberModel' );
            $this -> load -> model ( 'LoanModel' );
            $this -> load -> model ( 'PostModel' );
        }
        
        /**
         * -------
         * @param $title
         * header template
         * -------
         */
        
        public function header ( $title ) {
            $data[ 'title' ] = $title;
            $this -> load -> view ( '/includes/admin/header', $data );
        }
        
        /**
         * -------
         * sidebar template
         * -------
         */
        
        public function sidebar () {
            $this -> load -> view ( '/includes/admin/general-sidebar' );
        }
        
        /**
         * -------
         * footer template
         * -------
         */
        
        public function footer () {
            $this -> load -> view ( '/includes/admin/footer' );
        }
        
        /**
         * -------
         * checks if user is logged in
         * -------
         */
        
        public function is_logged_in () {
            if ( empty( $this -> session -> userdata ( 'user_data' ) ) ) {
                return redirect ( base_url () );
            }
        }
        
        /**
         * -------
         * List of employees
         * -------
         */
        
        public function index () {
            $title = site_name . ' - Employees';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'employees' ] = $this -> HrModel -> get_employees ();
            $this -> load -> view ( '/hr/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------
         * add employees
         * -------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_register_employee' )
                $this -> do_register_employee ();
            
            $title = site_name . ' - Add Employees';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ]       = 'Add Employees';
            $data[ 'cities' ]      = $this -> PatientModel -> get_cities ();
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $data[ 'posts' ]       = $this -> PostModel -> get_posts ();
            $this -> load -> view ( '/hr/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------
         * add employee
         * -------
         */
        
        public function do_register_employee () {
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|xss_clean' );
            $this -> form_validation -> set_rules ( 'father_name', 'father name', 'required|xss_clean' );
            $this -> form_validation -> set_rules ( 'mother_name', 'mother name', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'gender', 'gender', 'required|xss_clean' );
            $this -> form_validation -> set_rules ( 'cnic', 'cnic', 'required|xss_clean' );
            $this -> form_validation -> set_rules ( 'dob', 'dob', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'birth_place', 'place of birth', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'martial_status', 'martial status', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'religion', 'religion', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'temporary_address', 'temporary address', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'permanent_address', 'permanent address', 'required|xss_clean' );
            $this -> form_validation -> set_rules ( 'mobile', 'mobile', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'mobile_2', 'mobile 2', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'residence_mobile', 'residence mobile', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'email', 'email', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'hiring_date', 'hiring date', 'required|xss_clean' );
            $this -> form_validation -> set_rules ( 'contract_date', 'contract date', 'required|xss_clean' );
            $this -> form_validation -> set_rules ( 'department_id', 'employee post', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'basic_pay', 'basic pay', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'acc_number', 'account number', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'bank_info', 'bank info', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'tax_number', 'tax number', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'working_hours', 'working hours', 'required|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                $code                = $this -> HrModel -> generate_code ( $this -> input -> post ( 'department_id', true ) );
                $post_id             = $this -> input -> post ( 'post-id', true );
                $name                = $this -> input -> post ( 'name', true );
                $father_name         = $this -> input -> post ( 'father_name', true );
                $mother_name         = $this -> input -> post ( 'mother_name', true );
                $gender              = $this -> input -> post ( 'gender', true );
                $blood_group         = $this -> input -> post ( 'blood_group', true );
                $cnic                = $this -> input -> post ( 'cnic', true );
                $dob                 = $this -> input -> post ( 'dob', true );
                $birth_place         = $this -> input -> post ( 'birth_place', true );
                $martial_status      = $this -> input -> post ( 'martial_status', true );
                $religion            = $this -> input -> post ( 'religion', true );
                $nationality         = $this -> input -> post ( 'nationality', true );
                $permanent_address   = $this -> input -> post ( 'permanent_address', true );
                $mobile              = $this -> input -> post ( 'mobile', true );
                $mobile_2            = $this -> input -> post ( 'mobile_2', true );
                $residence_mobile    = $this -> input -> post ( 'residence_mobile', true );
                $email               = $this -> input -> post ( 'email', true );
                $hiring_date         = $this -> input -> post ( 'hiring_date', true );
                $contract_date       = $this -> input -> post ( 'contract_date', true );
                $department_id       = $this -> input -> post ( 'department_id', true );
                $basic_pay           = $this -> input -> post ( 'basic_pay', true );
                $medical_allowance   = $this -> input -> post ( 'medical_allowance', true );
                $transport_allowance = $this -> input -> post ( 'transport_allowance', true );
                $rent_allowance      = $this -> input -> post ( 'rent_allowance', true );
                $mobile_allowance    = $this -> input -> post ( 'mobile_allowance', true );
                $food_allowance      = $this -> input -> post ( 'food_allowance', true );
                $other_allowance     = $this -> input -> post ( 'other_allowance', true );
                $bank_info           = $this -> input -> post ( 'bank_info', true );
                $swift_code          = $this -> input -> post ( 'swift_code', true );
                $acc_number          = $this -> input -> post ( 'acc_number', true );
                $ntn_number          = $this -> input -> post ( 'ntn_number', true );
                $company             = $this -> input -> post ( 'company', true );
                $address             = $this -> input -> post ( 'address', true );
                $contact             = $this -> input -> post ( 'contact', true );
                $designation         = $this -> input -> post ( 'designation', true );
                $duration            = $this -> input -> post ( 'duration', true );
                $salary              = $this -> input -> post ( 'salary', true );
                $benefits            = $this -> input -> post ( 'benefits', true );
                $leaving_reason      = $this -> input -> post ( 'leaving_reason', true );
                $working_hours       = $this -> input -> post ( 'working_hours', true );
                
                $info = array (
                    'user_id'             => get_logged_in_user_id (),
                    'post_id'             => $post_id,
                    'code'                => $code,
                    'name'                => $name,
                    'father_name'         => $father_name,
                    'mother_name'         => $mother_name,
                    'gender'              => $gender,
                    'blood_group'         => $blood_group,
                    'dob'                 => date ( 'Y-m-d', strtotime ( $dob ) ),
                    'birth_place'         => $birth_place,
                    'martial_status'      => $martial_status,
                    'religion'            => $religion,
                    'nationality'         => $nationality,
                    'cnic'                => $cnic,
                    'residence_mobile'    => $residence_mobile,
                    'mobile'              => $mobile,
                    'mobile_2'            => $mobile_2,
                    'email'               => $email,
                    'permanent_address'   => $permanent_address,
                    'department_id'       => $department_id,
                    'hiring_date'         => date ( 'Y-m-d', strtotime ( $hiring_date ) ),
                    'contract_date'       => date ( 'Y-m-d', strtotime ( $contract_date ) ),
                    'basic_pay'           => $basic_pay,
                    'medical_allowance'   => $medical_allowance,
                    'transport_allowance' => $transport_allowance,
                    'rent_allowance'      => $rent_allowance,
                    'mobile_allowance'    => $mobile_allowance,
                    'food_allowance'      => $food_allowance,
                    'other_allowance'     => $other_allowance,
                    'working_hours'       => $working_hours,
                    'date_added'          => current_date_time ()
                );
                
                if ( isset( $_FILES[ 'picture' ] ) and !empty( trim ( $_FILES[ 'picture' ][ 'name' ] ) ) )
                    $info[ 'picture' ] = upload_files ( 'picture' );
                
                if ( isset( $_FILES[ 'cnic_image' ] ) and !empty( trim ( $_FILES[ 'cnic_image' ][ 'name' ] ) ) )
                    $info[ 'cnic_image' ] = upload_files ( 'cnic_image' );
                
                if ( isset( $_FILES[ 'resume' ] ) and !empty( trim ( $_FILES[ 'resume' ][ 'name' ] ) ) )
                    $info[ 'resume' ] = upload_files ( 'resume' );
                
                
                $id = $this -> HrModel -> add ( $info );
                if ( $id > 0 ) {
                    
                    $bank = array (
                        'employee_id' => $id,
                        'bank_info'   => $bank_info,
                        'swift_code'  => $swift_code,
                        'acc_number'  => $acc_number,
                        'ntn_number'  => $ntn_number,
                        'date_added'  => current_date_time (),
                    );
                    $this -> add_bank_info ( $bank );
                    
                    $job_history = array (
                        'employee_id'    => $id,
                        'company'        => $company,
                        'address'        => $address,
                        'contact'        => $contact,
                        'designation'    => $designation,
                        'duration'       => $duration,
                        'salary'         => $salary,
                        'benefits'       => $benefits,
                        'leaving_reason' => $leaving_reason,
                        'date_added'     => current_date_time (),
                    );
                    $this -> add_job_history ( $job_history );
                    
                    $this -> add_documents ( $id );
                    $this -> add_family_details ( $id );
                    $this -> add_children ( $id );
                    
                    $this -> session -> set_flashdata ( 'response', 'Success! Employee record saved.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
            
        }
        
        /**
         * -------
         * @param $info
         * add bank info
         * -------
         */
        
        public function add_bank_info ( $info ) {
            $this -> HrModel -> add_bank_info ( $info );
        }
        
        /**
         * -------
         * @param $info
         * add job history
         * -------
         */
        
        public function add_job_history ( $info ) {
            $this -> HrModel -> add_job_history ( $info );
        }
        
        /**
         * -------
         * @param $id
         * add documents
         * -------
         */
        
        public function add_documents ( $id ) {
            if ( !empty( $_FILES[ 'documents' ][ 'name' ] ) ) {
                $filesCount = count ( $_FILES[ 'documents' ][ 'name' ] );
                for ( $i = 0; $i < $filesCount; $i++ ) {
                    $_FILES[ 'file' ][ 'name' ]     = $_FILES[ 'documents' ][ 'name' ][ $i ];
                    $_FILES[ 'file' ][ 'type' ]     = $_FILES[ 'documents' ][ 'type' ][ $i ];
                    $_FILES[ 'file' ][ 'tmp_name' ] = $_FILES[ 'documents' ][ 'tmp_name' ][ $i ];
                    $_FILES[ 'file' ][ 'error' ]    = $_FILES[ 'documents' ][ 'error' ][ $i ];
                    $_FILES[ 'file' ][ 'size' ]     = $_FILES[ 'documents' ][ 'size' ][ $i ];
                    
                    if ( !is_dir ( 'uploads/' ) ) {
                        mkdir ( './uploads/', 0777, TRUE );
                    }
                    
                    $upload_path               = 'uploads/';
                    $config[ 'upload_path' ]   = $upload_path;
                    $config[ 'allowed_types' ] = 'jpg|png|gif|pdf|zip|jpeg|PNG';
                    $config[ 'max_size' ]      = '0';
                    $config[ 'max_filename' ]  = '255';
                    $config[ 'encrypt_name' ]  = true;
                    
                    $this -> load -> library ( 'upload', $config );
                    $this -> upload -> initialize ( $config );
                    
                    if ( $this -> upload -> do_upload ( 'file' ) ) {
                        $fileData                        = $this -> upload -> data ();
                        $uploadData[ $i ][ 'file_name' ] = $fileData[ 'file_name' ];
                        $info                            = array (
                            'employee_id' => $id,
                            'document'    => base_url ( '/uploads/' . $uploadData[ $i ][ 'file_name' ] ),
                            'date_added'  => current_date_time (),
                        );
                        $this -> HrModel -> add_documents ( $info );
                    }
                }
            }
        }
        
        public function add_family_details ( $id ) {
            $wife_name            = $this -> input -> post ( 'wife-name', true );
            $wife_contact_no      = $this -> input -> post ( 'wife-contact-no', true );
            $wife_cnic            = $this -> input -> post ( 'wife-cnic', true );
            $wife_address         = $this -> input -> post ( 'wife-address', true );
            $father_name          = $this -> input -> post ( 'father-name', true );
            $father_contact_no    = $this -> input -> post ( 'father-contact-no', true );
            $father_cnic          = $this -> input -> post ( 'father-cnic', true );
            $father_address       = $this -> input -> post ( 'father-address', true );
            $mother_name          = $this -> input -> post ( 'mother-name', true );
            $mother_contact_no    = $this -> input -> post ( 'mother-contact-no', true );
            $mother_cnic          = $this -> input -> post ( 'mother-cnic', true );
            $mother_address       = $this -> input -> post ( 'mother-address', true );
            $next_of_kin          = $this -> input -> post ( 'next-of-kin', true );
            $child_contact_no     = $this -> input -> post ( 'child-contact-no', true );
            $child_cnic           = $this -> input -> post ( 'nok-cnic', true );
            $child_relation       = $this -> input -> post ( 'child-relation', true );
            $child_address        = $this -> input -> post ( 'child-address', true );
            $emergency_contact_no = $this -> input -> post ( 'emergency-contact-no', true );
            $disability           = $this -> input -> post ( 'disability', true );
            
            $info = array (
                'employee_id'       => $id,
                'wife_name'         => $wife_name,
                'wife_contact'      => $wife_contact_no,
                'wife_cnic'         => $wife_cnic,
                'wife_address'      => $wife_address,
                'father_name'       => $father_name,
                'father_contact'    => $father_contact_no,
                'father_cnic'       => $father_cnic,
                'father_address'    => $father_address,
                'mother_name'       => $mother_name,
                'mother_contact'    => $mother_contact_no,
                'mother_cnic'       => $mother_cnic,
                'mother_address'    => $mother_address,
                'nok'               => $next_of_kin,
                'nok_contact'       => $child_contact_no,
                'nok_cnic'          => $child_cnic,
                'nok_relation'      => $child_relation,
                'nok_address'       => $child_address,
                'emergency_contact' => $emergency_contact_no,
                'disability'        => $disability,
            );
            $this -> HrModel -> add_family_details ( $info );
        }
        
        public function add_children ( $id ) {
            $names = $this -> input -> post ( 'child-name', true );
            $cnic  = $this -> input -> post ( 'child-cnic', true );
            
            if ( count ( $names ) > 0 ) {
                foreach ( $names as $key => $name ) {
                    if ( !empty( trim ( $name ) ) ) {
                        $info = array (
                            'employee_id' => $id,
                            'name'        => $name,
                            'cnic'        => $cnic[ $key ],
                        );
                        $this -> HrModel -> add_children ( $info );
                    }
                }
            }
        }
        
        /**
         * -------
         * edit employee
         * -------
         */
        
        public function edit () {
            
            $employee_id = $this -> uri -> segment ( 3 );
            if ( empty( $employee_id ) or !is_numeric ( $employee_id ) or $employee_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_employee' )
                $this -> do_update_employee ();
            
            $title = site_name . ' - Edit Employees';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ]          = 'Edit Employees';
            $data[ 'cities' ]         = $this -> PatientModel -> get_cities ();
            $data[ 'departments' ]    = $this -> MemberModel -> get_departments ();
            $data[ 'personal' ]       = $this -> HrModel -> get_employee_by_id ( $employee_id );
            $data[ 'bank' ]           = $this -> HrModel -> get_bank_by_id ( $employee_id );
            $data[ 'history' ]        = $this -> HrModel -> get_history_by_id ( $employee_id );
            $data[ 'documents' ]      = $this -> HrModel -> get_documents_by_id ( $employee_id );
            $data[ 'family_details' ] = $this -> HrModel -> get_family_details_by_id ( $employee_id );
            $data[ 'children' ]       = $this -> HrModel -> get_employee_children ( $employee_id );
            $data[ 'posts' ]          = $this -> PostModel -> get_posts ();
            $this -> load -> view ( '/hr/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------
         * edit employee
         * -------
         */
        
        public function do_update_employee () {
            $this -> form_validation -> set_rules ( 'employee_id', 'employee id', 'numeric|required|xss_clean' );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|xss_clean' );
            $this -> form_validation -> set_rules ( 'father_name', 'father name', 'required|xss_clean' );
            $this -> form_validation -> set_rules ( 'mother_name', 'mother name', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'gender', 'gender', 'required|xss_clean' );
            $this -> form_validation -> set_rules ( 'cnic', 'cnic', 'required|xss_clean' );
            $this -> form_validation -> set_rules ( 'dob', 'dob', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'birth_place', 'place of birth', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'martial_status', 'martial status', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'religion', 'religion', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'temporary_address', 'temporary address', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'permanent_address', 'permanent address', 'required|xss_clean' );
            $this -> form_validation -> set_rules ( 'mobile', 'mobile', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'mobile_2', 'mobile 2', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'residence_mobile', 'residence mobile', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'email', 'email', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'hiring_date', 'hiring date', 'required|xss_clean' );
            $this -> form_validation -> set_rules ( 'contract_date', 'contract date', 'required|xss_clean' );
            $this -> form_validation -> set_rules ( 'department_id', 'employee post', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'basic_pay', 'basic pay', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'acc_number', 'account number', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'bank_info', 'bank info', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'tax_number', 'tax number', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'working_hours', 'working hours', 'required|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                $employee_id         = $this -> input -> post ( 'employee_id', true );
                $post_id             = $this -> input -> post ( 'post-id', true );
                $name                = $this -> input -> post ( 'name', true );
                $father_name         = $this -> input -> post ( 'father_name', true );
                $mother_name         = $this -> input -> post ( 'mother_name', true );
                $gender              = $this -> input -> post ( 'gender', true );
                $blood_group         = $this -> input -> post ( 'blood_group', true );
                $cnic                = $this -> input -> post ( 'cnic', true );
                $dob                 = $this -> input -> post ( 'dob', true );
                $birth_place         = $this -> input -> post ( 'birth_place', true );
                $martial_status      = $this -> input -> post ( 'martial_status', true );
                $religion            = $this -> input -> post ( 'religion', true );
                $nationality         = $this -> input -> post ( 'nationality', true );
                $permanent_address   = $this -> input -> post ( 'permanent_address', true );
                $mobile              = $this -> input -> post ( 'mobile', true );
                $mobile_2            = $this -> input -> post ( 'mobile_2', true );
                $residence_mobile    = $this -> input -> post ( 'residence_mobile', true );
                $email               = $this -> input -> post ( 'email', true );
                $hiring_date         = $this -> input -> post ( 'hiring_date', true );
                $contract_date       = $this -> input -> post ( 'contract_date', true );
                $department_id       = $this -> input -> post ( 'department_id', true );
                $basic_pay           = $this -> input -> post ( 'basic_pay', true );
                $medical_allowance   = $this -> input -> post ( 'medical_allowance', true );
                $transport_allowance = $this -> input -> post ( 'transport_allowance', true );
                $rent_allowance      = $this -> input -> post ( 'rent_allowance', true );
                $mobile_allowance    = $this -> input -> post ( 'mobile_allowance', true );
                $food_allowance      = $this -> input -> post ( 'food_allowance', true );
                $other_allowance     = $this -> input -> post ( 'other_allowance', true );
                $bank_info           = $this -> input -> post ( 'bank_info', true );
                $swift_code          = $this -> input -> post ( 'swift_code', true );
                $acc_number          = $this -> input -> post ( 'acc_number', true );
                $ntn_number          = $this -> input -> post ( 'ntn_number', true );
                $company             = $this -> input -> post ( 'company', true );
                $address             = $this -> input -> post ( 'address', true );
                $contact             = $this -> input -> post ( 'contact', true );
                $designation         = $this -> input -> post ( 'designation', true );
                $duration            = $this -> input -> post ( 'duration', true );
                $salary              = $this -> input -> post ( 'salary', true );
                $benefits            = $this -> input -> post ( 'benefits', true );
                $leaving_reason      = $this -> input -> post ( 'leaving_reason', true );
                $working_hours       = $this -> input -> post ( 'working_hours', true );
                
                $info = array (
                    'post_id'             => $post_id,
                    'name'                => $name,
                    'father_name'         => $father_name,
                    'mother_name'         => $mother_name,
                    'gender'              => $gender,
                    'blood_group'         => $blood_group,
                    'dob'                 => date ( 'Y-m-d', strtotime ( $dob ) ),
                    'birth_place'         => $birth_place,
                    'martial_status'      => $martial_status,
                    'religion'            => $religion,
                    'nationality'         => $nationality,
                    'cnic'                => $cnic,
                    'residence_mobile'    => $residence_mobile,
                    'mobile'              => $mobile,
                    'mobile_2'            => $mobile_2,
                    'email'               => $email,
                    'permanent_address'   => $permanent_address,
                    'department_id'       => $department_id,
                    'hiring_date'         => date ( 'Y-m-d', strtotime ( $hiring_date ) ),
                    'contract_date'       => date ( 'Y-m-d', strtotime ( $contract_date ) ),
                    'basic_pay'           => $basic_pay,
                    'medical_allowance'   => $medical_allowance,
                    'transport_allowance' => $transport_allowance,
                    'rent_allowance'      => $rent_allowance,
                    'mobile_allowance'    => $mobile_allowance,
                    'food_allowance'      => $food_allowance,
                    'other_allowance'     => $other_allowance,
                    'working_hours'       => $working_hours,
                );
                
                if ( isset( $_FILES[ 'picture' ] ) and !empty( trim ( $_FILES[ 'picture' ][ 'name' ] ) ) )
                    $info[ 'picture' ] = upload_files ( 'picture' );
                
                if ( isset( $_FILES[ 'cnic_image' ] ) and !empty( trim ( $_FILES[ 'cnic_image' ][ 'name' ] ) ) )
                    $info[ 'cnic_image' ] = upload_files ( 'cnic_image' );
                
                if ( isset( $_FILES[ 'resume' ] ) and !empty( trim ( $_FILES[ 'resume' ][ 'name' ] ) ) )
                    $info[ 'resume' ] = upload_files ( 'resume' );
                
                
                $this -> HrModel -> update ( $info, $employee_id );
                
                $this -> HrModel -> delete_bank_info ( $employee_id );
                $bank = array (
                    'employee_id' => $employee_id,
                    'bank_info'   => $bank_info,
                    'swift_code'  => $swift_code,
                    'acc_number'  => $acc_number,
                    'ntn_number'  => $ntn_number,
                    'date_added'  => current_date_time (),
                );
                $this -> add_bank_info ( $bank );
                
                $this -> HrModel -> delete_job_history ( $employee_id );
                $job_history = array (
                    'employee_id'    => $employee_id,
                    'company'        => $company,
                    'address'        => $address,
                    'contact'        => $contact,
                    'designation'    => $designation,
                    'duration'       => $duration,
                    'salary'         => $salary,
                    'benefits'       => $benefits,
                    'leaving_reason' => $leaving_reason,
                    'date_added'     => current_date_time (),
                );
                $this -> add_job_history ( $job_history );
                
                if ( isset( $_FILES[ 'documents' ] ) and count ( $_FILES[ 'documents' ][ 'name' ] ) > 0 ) {
                    $this -> HrModel -> delete_documents ( $employee_id );
                    $this -> add_documents ( $employee_id );
                }
                
                $this -> HrModel -> delete_family_details ( $employee_id );
                $this -> add_family_details ( $employee_id );
                
                $this -> HrModel -> delete_children ( $employee_id );
                $this -> add_children ( $employee_id );
                
                $this -> session -> set_flashdata ( 'response', 'Success! Employee record saved.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            
        }
        
        /**
         * -------
         * update employee status
         * -------
         */
        
        public function update_status () {
            
            $employee_id = $this -> uri -> segment ( 3 );
            $status      = $this -> input -> get ( 'status' );
            if ( empty( $employee_id ) or !is_numeric ( $employee_id ) or $employee_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $info = array (
                'active' => $status,
            );
            
            $this -> HrModel -> update ( $info, $employee_id );
            
            $this -> session -> set_flashdata ( 'response', 'Success! Employee status updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------
         * delete employee
         * -------
         */
        
        public function delete () {
            
            $employee_id = $this -> uri -> segment ( 3 );
            if ( empty( $employee_id ) or !is_numeric ( $employee_id ) or $employee_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $deleted = $this -> HrModel -> delete ( $employee_id );
            
            if ( $deleted ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Employee record deleted.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------
         * salary sheet employee
         * -------
         */
        
        public function sheet () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_salary_sheet' )
                $this -> do_add_salary_sheet ();
            
            $title = site_name . ' - Employees Salary Sheet';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ]     = 'Employees Salary Sheet';
            $data[ 'employees' ] = $this -> HrModel -> get_active_employees ();
            $this -> load -> view ( '/hr/sheet', $data );
            $this -> footer ();
        }
        
        /**
         * -------
         * do update salary sheet
         * -------
         */
        
        public function do_add_salary_sheet () {
            $employees           = $this -> input -> post ( 'employee_id', true );
            $salary_month        = $this -> input -> post ( 'salary_month', true );
            $selected_month_days = $this -> input -> post ( 'selected_month_days', true );
            if ( isset( $selected_month_days ) and $selected_month_days > 0 )
                $days = $selected_month_days;
            else
                $days = date ( "t" );
            $salary_id = unique_id ( 4 );
            
            if ( count ( $employees ) > 0 ) {
                foreach ( $employees as $key => $employee_id ) {
                    $employee            = $this -> HrModel -> get_employee_by_id ( $employee_id );
                    $basic_pay           = $employee -> basic_pay;
                    $medical_allowance   = $employee -> medical_allowance;
                    $transport_allowance = $employee -> transport_allowance;
                    $rent_allowance      = $employee -> rent_allowance;
                    $mobile_allowance    = $employee -> mobile_allowance;
                    $food_allowance      = $employee -> food_allowance;
                    $attended_days       = $_POST[ 'attended_days' ][ $key ];
                    $overtime            = $_POST[ 'overtime' ][ $key ];
                    $loan_deduction      = $_POST[ 'loan_deduction' ][ $key ];
                    $eobi_deduction      = $_POST[ 'eobi_deduction' ][ $key ];
                    $current_loan        = $_POST[ 'current_loan' ][ $key ];
                    $remarks             = $_POST[ 'remarks' ][ $key ];
                    $other_allowance     = $_POST[ 'other_allowance' ][ $key ];
                    $other_deduction     = $_POST[ 'other_deduction' ][ $key ];
                    $allowances          = $medical_allowance + $transport_allowance + $rent_allowance + $other_allowance + $mobile_allowance + $food_allowance;
                    
                    $salary_per_day  = $basic_pay / $days;
                    $salary_per_hour = $salary_per_day / $employee -> working_hours;
                    $payable         = ( $attended_days * $salary_per_day ) + $allowances;
                    
                    if ( $loan_deduction > 0 and $loan_deduction <= $current_loan )
                        $payable = $payable - $loan_deduction;
                    
                    if ( $eobi_deduction > 0 )
                        $payable = $payable - $eobi_deduction;
                    
                    if ( $other_deduction > 0 )
                        $payable = $payable - $other_deduction;
                    
                    if ( $overtime > 0 ) {
                        $overtime_pay = $overtime * $salary_per_hour;
                        $payable      = $payable + $overtime_pay;
                    }
                    
                    $info = array (
                        'user_id'             => get_logged_in_user_id (),
                        'salary_id'           => $salary_id,
                        'employee_id'         => $employee_id,
                        'days'                => $days,
                        'basic_salary'        => $basic_pay,
                        'medical_allowance'   => $medical_allowance,
                        'transport_allowance' => $transport_allowance,
                        'rent_allowance'      => $rent_allowance,
                        'mobile_allowance'    => $mobile_allowance,
                        'food_allowance'      => $food_allowance,
                        'other_allowance'     => $other_allowance,
                        'attended_days'       => $attended_days,
                        'overtime'            => $overtime,
                        'loan_deduction'      => $loan_deduction,
                        'eobi_deduction'      => $eobi_deduction,
                        'other_deduction'     => $other_deduction,
                        'net_salary'          => $payable,
                        'remarks'             => $remarks,
                        'salary_month'        => $salary_month,
                        'date_added'          => current_date_time (),
                    );
                    $this -> HrModel -> add_salary_sheets ( $info );
                    
                    if ( $loan_deduction > 0 ) {
                        $info = array (
                            'user_id'     => get_logged_in_user_id (),
                            'employee_id' => $employee_id,
                            'paid'        => $loan_deduction,
                            'date_added'  => current_date_time ()
                        );
                        $this -> LoanModel -> do_pay_loan ( $info );
                    }
                    
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Employees salary sheet added.' );
                return redirect ( 'invoices/salary-slips?salary_slip=' . $salary_id );
            }
            
        }
        
        /**
         * -------
         * salary sheets employees
         * -------
         */
        
        public function sheets () {
            
            $title = site_name . ' - All Employees Salary Sheet';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ]  = 'All Employees Salary Sheet';
            $data[ 'sheets' ] = $this -> HrModel -> get_sheets ();
            $this -> load -> view ( '/hr/sheets', $data );
            $this -> footer ();
        }
        
        /**
         * -------
         * salary sheets employees
         * -------
         */
        
        public function edit_sheet () {
            
            $salary_id = $this -> uri -> segment ( 3 );
            if ( empty( $salary_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_salary_sheet' )
                $this -> do_update_salary_sheet ();
            
            $title = site_name . ' - Edit Employees Salary Sheet';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ]  = 'Edit Employees Salary Sheet';
            $data[ 'sheets' ] = $this -> HrModel -> get_sheet_by_salary_id ( $salary_id );
            $this -> load -> view ( '/hr/edit_sheet', $data );
            $this -> footer ();
        }
        
        /**
         * -------
         * do update salary sheet
         * -------
         */
        
        public function do_update_salary_sheet () {
            $employees    = $this -> input -> post ( 'employee_id', true );
            $salary_id    = $this -> input -> post ( 'salary_id', true );
            $salary_month = $this -> input -> post ( 'salary_month', true );
            $days         = $this -> input -> post ( 'days', true );
            
            if ( count ( $employees ) > 0 ) {
                foreach ( $employees as $key => $employee_id ) {
                    $employee            = $this -> HrModel -> get_employee_by_id ( $employee_id );
                    $basic_pay           = $employee -> basic_pay;
                    $medical_allowance   = $employee -> medical_allowance;
                    $transport_allowance = $employee -> transport_allowance;
                    $rent_allowance      = $employee -> rent_allowance;
                    $mobile_allowance    = $employee -> mobile_allowance;
                    $food_allowance      = $employee -> food_allowance;
                    $attended_days       = $_POST[ 'attended_days' ][ $key ];
                    $overtime            = $_POST[ 'overtime' ][ $key ];
                    $loan_deduction      = $_POST[ 'loan_deduction' ][ $key ];
                    $eobi_deduction      = $_POST[ 'eobi_deduction' ][ $key ];
                    $current_loan        = $_POST[ 'current_loan' ][ $key ];
                    $remarks             = $_POST[ 'remarks' ][ $key ];
                    $other_allowance     = $_POST[ 'other_allowance' ][ $key ];
                    $other_deduction     = $_POST[ 'other_deduction' ][ $key ];
                    $allowances          = $medical_allowance + $transport_allowance + $rent_allowance + $other_allowance + $mobile_allowance + $food_allowance;
                    
                    $salary_per_day  = $basic_pay / $days;
                    $salary_per_hour = $salary_per_day / $employee -> working_hours;
                    $payable         = ( $attended_days * $salary_per_day ) + $allowances;
                    
                    if ( $loan_deduction > 0 and $loan_deduction <= $current_loan )
                        $payable = $payable - $loan_deduction;
                    
                    if ( $eobi_deduction > 0 )
                        $payable = $payable - $eobi_deduction;
                    
                    if ( $other_deduction > 0 )
                        $payable = $payable - $other_deduction;
                    
                    if ( $overtime > 0 ) {
                        $overtime_pay = $overtime * $salary_per_hour;
                        $payable      = $payable + $overtime_pay;
                    }
                    
                    $info = array (
                        'user_id'             => get_logged_in_user_id (),
                        'basic_salary'        => $basic_pay,
                        'medical_allowance'   => $medical_allowance,
                        'transport_allowance' => $transport_allowance,
                        'rent_allowance'      => $rent_allowance,
                        'mobile_allowance'    => $mobile_allowance,
                        'food_allowance'      => $food_allowance,
                        'other_allowance'     => $other_allowance,
                        'attended_days'       => $attended_days,
                        'overtime'            => $overtime,
                        'loan_deduction'      => $loan_deduction,
                        'eobi_deduction'      => $eobi_deduction,
                        'other_deduction'     => $other_deduction,
                        'net_salary'          => $payable,
                        'remarks'             => $remarks,
                        //					'salary_month'        => $salary_month,
                    );
                    $this -> HrModel -> update_salary_sheets ( $info, $salary_id, $employee_id );
                    
                    if ( $loan_deduction > 0 ) {
                        $info = array (
                            'paid' => $loan_deduction,
                        );
                        $this -> LoanModel -> do_update_paid_loan ( $info, $employee_id );
                    }
                    
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Employees salary sheet updated.' );
                return redirect ( 'invoices/salary-slips?salary_slip=' . $salary_id );
            }
            
        }
        
        /**
         * -------
         * delete employee sheet
         * -------
         */
        
        public function delete_sheet () {
            
            $salary_id = $this -> uri -> segment ( 3 );
            if ( empty( $salary_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $deleted = $this -> HrModel -> delete_sheet ( $salary_id );
            
            if ( $deleted ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Employee salary sheet deleted.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------
         * search salary sheets employees
         * -------
         */
        
        public function search () {
            $title = site_name . ' - Search Employees Salary Sheet';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = 'Search Employees Salary Sheet';
            
            if ( isset( $_REQUEST[ 'month' ] ) or isset( $_REQUEST[ 'year' ] ) )
                $data[ 'sheets' ] = $this -> HrModel -> search_sheets ();
            else
                $data[ 'sheets' ] = array ();
            
            $this -> load -> view ( '/hr/search', $data );
            $this -> footer ();
        }
        
    }
