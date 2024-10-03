<?php
    defined ('BASEPATH') or exit('No direct script access allowed');
    
    class AccountSettings extends CI_Controller {
        
        /**
         * -------------------------
         * AccountSettings constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ('AccountModel');
        }
        
        /**
         * -------------------------
         * @param $title
         * header template
         * -------------------------
         */
        
        public function header ( $title ) {
            $data[ 'title' ] = $title;
            $this -> load -> view ('/includes/admin/header', $data);
        }
        
        /**
         * -------------------------
         * sidebar template
         * -------------------------
         */
        
        public function sidebar () {
            $this -> load -> view ('/includes/admin/general-sidebar');
        }
        
        /**
         * -------------------------
         * footer template
         * -------------------------
         */
        
        public function footer () {
            $this -> load -> view ('/includes/admin/footer');
        }
        
        /**
         * ---------------------
         * checks if user is logged in
         * ---------------------
         */
        
        public function is_logged_in () {
            if ( empty($this -> session -> userdata ('user_data')) ) {
                return redirect (base_url ());
            }
        }
        
        /**
         * -------------------------
         * roles main page
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - All Roles';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'roles' ] = $this -> AccountModel -> get_roles ();
            $this -> load -> view ('/settings/account-roles/index', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add roles main page
         * -------------------------
         */
        
        public function add () {
            
            if ( isset($_POST[ 'action' ]) and $_POST[ 'action' ] == 'do_add_account_roles' )
                $this -> do_add_account_roles ();
            
            $title = site_name . ' - Add Roles';
            $this -> header ($title);
            $this -> sidebar ();
            $this -> load -> view ('/settings/account-roles/add');
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * edit roles main page
         * -------------------------
         */
        
        public function edit () {
            
            $role_id = $this -> uri -> segment (3);
            if ( empty(trim ($role_id)) or !is_numeric ($role_id) or $role_id < 1 )
                return redirect ($_SERVER[ 'HTTP_REFERER' ]);
            
            if ( isset($_POST[ 'action' ]) and $_POST[ 'action' ] == 'do_edit_account_roles' )
                $this -> do_edit_account_roles ();
            
            $title = site_name . ' - Edit Roles';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'role' ] = $this -> AccountModel -> get_account_role ($role_id);
            $this -> load -> view ('/settings/account-roles/edit', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * do add account roles
         * -------------------------
         */
        
        public function do_add_account_roles () {
            $this -> form_validation -> set_rules ('role', 'role', 'required|min_length[1]|xss_clean');
            if ( $this -> form_validation -> run () == true ) {
                $role = $this -> input -> post ('role', true);
                $info = array (
                    'user_id'    => get_logged_in_user_id (),
                    'name'       => $role,
                    'date_added' => current_date_time ()
                );
                $role_id = $this -> AccountModel -> add_roles ($info);
                if ( $role_id > 0 ) {
                    $this -> session -> set_flashdata ('response', 'Success! Role added.');
                }
                else {
                    $this -> session -> set_flashdata ('error', 'Error! Please try again');
                }
                return redirect ($_SERVER[ 'HTTP_REFERER' ]);
            }
        }
        
        /**
         * -------------------------
         * do add account roles
         * -------------------------
         */
        
        public function do_edit_account_roles () {
            $this -> form_validation -> set_rules ('role', 'role', 'required|min_length[1]|xss_clean');
            $this -> form_validation -> set_rules ('role_id', 'role id', 'required|min_length[1]|xss_clean');
            if ( $this -> form_validation -> run () == true ) {
                $role = $this -> input -> post ('role', true);
                $role_id = $this -> input -> post ('role_id', true);
                $info = array (
                    'name' => $role,
                );
                $where = array (
                    'id' => $role_id
                );
                $this -> AccountModel -> update_role ($info, $where);
                $this -> session -> set_flashdata ('response', 'Success! Role updated.');
                return redirect ($_SERVER[ 'HTTP_REFERER' ]);
            }
        }
        
        /**
         * -------------------------
         * delete role
         * -------------------------
         */
        
        public function delete () {
            $role_id = $this -> uri -> segment (3);
            if ( empty(trim ($role_id)) or !is_numeric ($role_id) or $role_id < 1 )
                return redirect ($_SERVER[ 'HTTP_REFERER' ]);
            
            $this -> AccountModel -> delete_role ($role_id);
            $this -> session -> set_flashdata ('response', 'Success! Role deleted.');
            return redirect ($_SERVER[ 'HTTP_REFERER' ]);
        }
        
        /**
         * -------------------------
         * add accounts financial year page
         * -------------------------
         */
        
        public function financial_year () {
            
            if ( isset($_POST[ 'action' ]) and $_POST[ 'action' ] == 'do_add_financial_year' )
                $this -> do_add_financial_year ();
            
            $title = site_name . ' - Add Financial Year';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'financial_year' ] = $this -> AccountModel -> get_financial_year ();
            $this -> load -> view ('/settings/account-roles/financial-year', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * do add financial year
         * -------------------------
         */
        
        public function do_add_financial_year () {
            $this -> form_validation -> set_rules ('start_date', 'start date', 'required|xss_clean');
            $this -> form_validation -> set_rules ('end_date', 'end_date', 'required|xss_clean');
            if ( $this -> form_validation -> run () == true ) {
                $start_date = $this -> input -> post ('start_date', true);
                $end_date = $this -> input -> post ('end_date', true);
                $info = array (
                    'user_id'    => get_logged_in_user_id (),
                    'start_date' => date ('Y-m-d', strtotime ($start_date)),
                    'end_date'   => date ('Y-m-d', strtotime ($end_date)),
                );
                $this -> AccountModel -> upsert_financial_year ($info);
                
                $log = array (
                    'user_id' => get_logged_in_user_id (),
                    'action'  => 'financial_year_updated',
                    'data'    => json_encode ($_POST),
                );
                $this -> load -> model ('LogModel');
                $this -> LogModel -> create_log ('financial_year_logs', $log);
                
                $this -> session -> set_flashdata ('response', 'Success! Financial year updated.');
                return redirect ($_SERVER[ 'HTTP_REFERER' ]);
            }
        }
        
    }
