<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class User extends CI_Controller {
        
        /**
         * -------------------------
         * User constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'UserModel' );
            $this -> load -> model ( 'MemberModel' );
            $this -> load -> model ( 'PanelModel' );
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
         * user main page
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - Members';
            $this -> header ( $title );
            $this -> sidebar ();
            
            $data[ 'members' ] = $this -> UserModel -> get_users ();
            $this -> load -> view ( '/users/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add user main page
         * -------------------------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_register_member' )
                $this -> do_register_member ( $_POST );
            
            $title = site_name . ' - Add Member (System Users)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'access' ] = $this -> UserModel -> get_user_access ( 0 );
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $this -> load -> view ( '/users/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add user main page
         * -------------------------
         */
        
        public function add_panel () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_register_member' )
                $this -> do_register_panel_member ( $_POST );
            
            $title = site_name . ' - Add Member (Panel)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'access' ] = $this -> UserModel -> get_user_access ( 0 );
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $data[ 'panels' ] = $this -> PanelModel -> get_panels ();
            $this -> load -> view ( '/users/add-panel', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $post
         * register user
         * -------------------------
         */
        
        public function do_register_member ( $post ) {
            $data = filter_var_array ( $post, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'gender', 'gender', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'password', 'password', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $username = get_username ( $data[ 'name' ] );
                $array = array (
                    'name'          => $data[ 'name' ],
                    'username'      => $username,
                    'email'         => $data[ 'email' ],
                    'address'       => $data[ 'address' ],
                    'phone'         => $data[ 'phone' ],
                    'cnic'          => $data[ 'cnic' ],
                    'department_id' => $data[ 'department_id' ],
                    'password'      => password_hash ( $data[ 'password' ], PASSWORD_BCRYPT ),
                );
                $user_id = $this -> UserModel -> add ( $array );
                
                $log = array (
                    'user_id'    => get_logged_in_user_id (),
                    'action'     => 'user_created',
                    'log'        => json_encode ( $array ),
                    'date_added' => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'user_logs', $log );
                
                
                if ( isset( $_POST[ 'access' ] ) and count ( array_filter ( $_POST[ 'access' ] ) ) > 0 ) {
                    $access = implode ( ',', array_filter ( $_POST[ 'access' ] ) );
                    $access_info = array (
                        'user_id'     => $user_id,
                        'assigned_by' => get_logged_in_user_id (),
                        'access'      => $access,
                    );
                    $this -> UserModel -> add_access ( $access_info );
                }
                if ( $user_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Member added.' );
                    return redirect ( '/user/edit/?id=' . encode ( $user_id ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Oops! An unknown error occurred. Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * @param $post
         * register panel user
         * -------------------------
         */
        
        public function do_register_panel_member ( $post ) {
            $data = filter_var_array ( $post, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'gender', 'gender', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'password', 'password', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'panel_id', 'panel', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $username = get_username ( $data[ 'name' ] );
                $array = array (
                    'name'          => $data[ 'name' ],
                    'username'      => $username,
                    'email'         => $data[ 'email' ],
                    'address'       => $data[ 'address' ],
                    'phone'         => $data[ 'phone' ],
                    'cnic'          => $data[ 'cnic' ],
                    'department_id' => $data[ 'department_id' ],
                    'panel_id'      => $data[ 'panel_id' ],
                    'password'      => password_hash ( $data[ 'password' ], PASSWORD_BCRYPT ),
                );
                $user_id = $this -> UserModel -> add ( $array );
                
                $log = array (
                    'user_id'    => get_logged_in_user_id (),
                    'action'     => 'user_created',
                    'log'        => json_encode ( $array ),
                    'date_added' => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'user_logs', $log );
                
                
                if ( isset( $_POST[ 'access' ] ) and count ( array_filter ( $_POST[ 'access' ] ) ) > 0 ) {
                    $access = implode ( ',', array_filter ( $_POST[ 'access' ] ) );
                    $access_info = array (
                        'user_id'     => $user_id,
                        'assigned_by' => get_logged_in_user_id (),
                        'access'      => $access,
                    );
                    $this -> UserModel -> add_access ( $access_info );
                }
                if ( $user_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Member added.' );
                    return redirect ( '/user/edit-panel/?id=' . encode ( $user_id ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Oops! An unknown error occurred. Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * add user main page
         * -------------------------
         */
        
        public function edit () {
            
            $user_id = decode ( $this -> input -> get ( 'id' ) );
            if ( empty( trim ( $user_id ) ) or $user_id < 1 or !is_numeric ( $user_id ) )
                return redirect ( base_url ( '/user/index' ) );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_member' )
                $this -> do_update_member ( $_POST );
            
            $title = site_name . ' - Edit Member';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'user' ] = $this -> UserModel -> get_user_by_id ( $user_id );
            $data[ 'access' ] = $this -> UserModel -> get_user_access ( $user_id );
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $this -> load -> view ( '/users/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * edit panel user main page
         * -------------------------
         */
        
        public function edit_panel () {
            
            $user_id = decode ( $this -> input -> get ( 'id' ) );
            if ( empty( trim ( $user_id ) ) or $user_id < 1 or !is_numeric ( $user_id ) )
                return redirect ( base_url ( '/user/index' ) );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_member' )
                $this -> do_update_panel_member ( $_POST );
            
            $title = site_name . ' - Edit Member (Panel)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'user' ] = $this -> UserModel -> get_user_by_id ( $user_id );
            $data[ 'access' ] = $this -> UserModel -> get_user_access ( $user_id );
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $data[ 'panels' ] = $this -> PanelModel -> get_panels ();
            $this -> load -> view ( '/users/edit-panel', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add user main page
         * -------------------------
         */
        
        public function profile () {
            
            $user_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $user_id ) ) or $user_id < 1 or !is_numeric ( $user_id ) or $user_id != get_logged_in_user_id () )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_user' )
                $this -> do_update_user ( $_POST );
            
            $title = site_name . ' - Edit User';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'user' ] = $this -> UserModel -> get_user_by_id ( $user_id );
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $this -> load -> view ( '/users/profile', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $post
         * edit user
         * -------------------------
         */
        
        public function do_update_user ( $post ) {
            $data = filter_var_array ( $post, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'password', 'password', 'xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $user_id = $data[ 'user_id' ];
                $array = array (
                    'name'    => $data[ 'name' ],
                    'email'   => $data[ 'email' ],
                    'address' => $data[ 'address' ],
                    'phone'   => $data[ 'phone' ],
                    'cnic'    => $data[ 'cnic' ],
                );
                if ( isset( $data[ 'password' ] ) and !empty( trim ( $data[ 'password' ] ) ) )
                    $array[ 'password' ] = password_hash ( $data[ 'password' ], PASSWORD_BCRYPT );
                
                $this -> UserModel -> edit ( $array, $user_id );
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'action'       => 'user_updated_his_profile',
                    'log'          => json_encode ( get_logged_in_user () ),
                    'after_update' => json_encode ( $array ),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'user_logs', $log );
                
                $this -> session -> set_flashdata ( 'response', 'Success! Profile updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * @param $post
         * edit user
         * -------------------------
         */
        
        public function do_update_member ( $post ) {
            $data = filter_var_array ( $post, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'gender', 'gender', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'password', 'password', 'xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $user_id = $data[ 'user_id' ];
                $array = array (
                    'name'          => $data[ 'name' ],
                    'email'         => $data[ 'email' ],
                    'address'       => $data[ 'address' ],
                    'phone'         => $data[ 'phone' ],
                    'cnic'          => $data[ 'cnic' ],
                    'department_id' => $data[ 'department_id' ],
                );
                if ( isset( $data[ 'password' ] ) and !empty( trim ( $data[ 'password' ] ) ) )
                    $array[ 'password' ] = password_hash ( $data[ 'password' ], PASSWORD_BCRYPT );
                
                $this -> UserModel -> delete_access ( $user_id );
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'action'       => 'user_updated_member_profile',
                    'log'          => json_encode ( get_user ( $user_id ) ),
                    'after_update' => json_encode ( $array ),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'user_logs', $log );
                
                if ( isset( $data[ 'access' ] ) and count ( array_filter ( $data[ 'access' ] ) ) > 0 ) {
                    $access = implode ( ',', array_filter ( $data[ 'access' ] ) );
                    $access_info = array (
                        'assigned_by' => get_logged_in_user_id (),
                        'user_id'     => $user_id,
                        'access'      => $access
                    );
                    $this -> UserModel -> add_access ( $access_info );
                }
                
                $this -> UserModel -> edit ( $array, $user_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Member updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * @param $post
         * edit user
         * -------------------------
         */
        
        public function do_update_panel_member ( $post ) {
            $data = filter_var_array ( $post, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'gender', 'gender', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'password', 'password', 'xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $user_id = $data[ 'user_id' ];
                $array = array (
                    'name'          => $data[ 'name' ],
                    'email'         => $data[ 'email' ],
                    'address'       => $data[ 'address' ],
                    'phone'         => $data[ 'phone' ],
                    'cnic'          => $data[ 'cnic' ],
                    'department_id' => $data[ 'department_id' ],
                    'panel_id'      => $data[ 'panel_id' ],
                );
                if ( isset( $data[ 'password' ] ) and !empty( trim ( $data[ 'password' ] ) ) )
                    $array[ 'password' ] = password_hash ( $data[ 'password' ], PASSWORD_BCRYPT );
                
                $this -> UserModel -> delete_access ( $user_id );
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'action'       => 'user_updated_member_profile',
                    'log'          => json_encode ( get_user ( $user_id ) ),
                    'after_update' => json_encode ( $array ),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'user_logs', $log );
                
                if ( isset( $data[ 'access' ] ) and count ( array_filter ( $data[ 'access' ] ) ) > 0 ) {
                    $access = implode ( ',', array_filter ( $data[ 'access' ] ) );
                    $access_info = array (
                        'assigned_by' => get_logged_in_user_id (),
                        'user_id'     => $user_id,
                        'access'      => $access
                    );
                    $this -> UserModel -> add_access ( $access_info );
                }
                
                $this -> UserModel -> edit ( $array, $user_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Member updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * update user
         * -------------------------
         */
        
        public function delete () {
            $user_id = decode ( $this -> input -> get ( 'id' ) );
            if ( !empty( trim ( $user_id ) ) and $user_id > 0 and is_numeric ( $user_id ) ) {
                
                $log = array (
                    'user_id'    => get_logged_in_user_id (),
                    'action'     => 'user_account_deleted',
                    'log'        => json_encode ( get_user ( $user_id ) ),
                    'date_added' => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'user_logs', $log );
                
                $info = array (
                    'status' => $_REQUEST[ 'status' ]
                );
                $updated = $this -> UserModel -> delete ( $info, $user_id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Action successful.' );
                    return redirect ( base_url ( '/user/index' ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( base_url ( '/user/index' ) );
                }
            }
        }
        
    }
