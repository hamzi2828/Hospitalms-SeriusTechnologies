<?php
    
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class InternalIssuance extends CI_Controller {
        
        /**
         * -------------------------
         * InternalIssuance constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'MedicineModel' );
            $this -> load -> model ( 'SupplierModel' );
            $this -> load -> model ( 'UserModel' );
            $this -> load -> model ( 'MemberModel' );
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
         * Internal Issuance main page
         * -------------------------
         */
        
        public function issuance () {
            $title = site_name . ' - Internal Issuance';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'internal-issuance/issuance' );
            $total_row                      = $this -> MedicineModel -> count_issuance ();
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
            
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines_that_has_stock ();
            $data[ 'users' ]     = $this -> UserModel -> get_active_users ();
            $data[ 'issuance' ]  = $this -> MedicineModel -> get_issuance ( $config[ "per_page" ], $offset );
            $str_links           = $this -> pagination -> create_links ();
            $data[ "links" ]     = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/medicines/issuance', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * issue medicine page
         * -------------------------
         */
        
        public function issue () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_issue_medicine_internal' )
                $this -> do_issue_medicine_internal ( $_POST );
            
            $title = site_name . ' - Issue Medicine';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $data[ 'medicines' ]   = $this -> MedicineModel -> get_medicines_that_has_stock ();
            $data[ 'users' ]       = $this -> UserModel -> get_active_users ();
            $this -> load -> view ( '/medicines/internal-issue', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do issue medicines
         * add issuance
         * -------------------------
         */
        
        public function do_issue_medicine_internal ( $POST ) {
            $data      = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $issue_to  = $data[ 'user_id' ];
            $dept_id   = $data[ 'department_id' ];
            $medicines = array_filter ( $data[ 'medicine_id' ] );
            $net       = 0;
            
            $this -> MedicineModel -> clear_medicine_sale ( get_logged_in_user_id () );
            if ( count ( $medicines ) > 0 ) {
                $sale        = array (
                    'user_id'    => get_logged_in_user_id (),
                    'date_added' => current_date_time ()
                );
                $issuance_id = $this -> MedicineModel -> add_issuance ( $sale );
                foreach ( $medicines as $key => $value ) {
                    if ( !empty( trim ( $value ) ) and $value > 0 ) {
                        $medicine_id = $value;
                        $stock_id    = $data[ 'stock_id' ][ $key ];
                        $quantity    = $data[ 'quantity' ][ $key ];
                        
                        if ( $stock_id > 0 ) {
                            $stock_price = get_stock ( $stock_id ) -> tp_unit;
                            $net         = $net + ( $stock_price * $quantity );
                            
                            $info = array (
                                'user_id'       => get_logged_in_user_id (),
                                'sale_id'       => $issuance_id,
                                'issue_to'      => $issue_to,
                                'medicine_id'   => $medicine_id,
                                'stock_id'      => $stock_id,
                                'department_id' => $dept_id,
                                'quantity'      => $quantity,
                                'date_added'    => current_date_time (),
                            );
                            $this -> MedicineModel -> issue_medicine ( $info );
                            
                            /***********LOGS*************/
                            
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'sale_id'      => $issuance_id,
                                'action'       => 'internal_issuance_added',
                                'log'          => json_encode ( $info ),
                                'after_update' => '',
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'internal_issuance_logs', $log );
                            
                            /***********END LOG*************/
                        }
                    }
                }
                
                /***********LEDGER*************/
                $ledger = array (
                    'user_id'              => get_logged_in_user_id (),
                    'acc_head_id'          => $dept_id != housekeeping_dept ? COS_Procedures : COS_Other_Direct_Cost_Procedures,
                    'internal_issuance_id' => $issuance_id,
                    'department_id'        => $dept_id,
                    'trans_date'           => date ( 'Y-m-d' ),
                    'payment_mode'         => 'cash',
                    'paid_via'             => 'cash',
                    'credit'               => $net,
                    'debit'                => 0,
                    'transaction_type'     => 'credit',
                    'description'          => 'Internal Issuance.',
                    'date_added'           => current_date_time (),
                );
                $this -> AccountModel -> add_ledger ( $ledger );
                
                $ledger[ 'acc_head_id' ]      = medical_supply_inventory;
                $ledger[ 'credit' ]           = 0;
                $ledger[ 'debit' ]            = $net;
                $ledger[ 'transaction_type' ] = 'debit';
                $this -> AccountModel -> add_ledger ( $ledger );
                
                /***********END LEDGER*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Medicine issued.' );
                return redirect ( base_url ( '/internal-issuance/issue' ) );
            }
        }
        
        /**
         * -------------------------
         * delete issuance medicine
         * -------------------------
         */
        
        public function delete () {
            $issuance_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $issuance_id ) ) or !is_numeric ( $issuance_id ) or $issuance_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'sale_id'      => $issuance_id,
                'action'       => 'internal_issuance_deleted',
                'log'          => json_encode ( $this -> MedicineModel -> get_issuance_by_id ( $issuance_id ) ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'internal_issuance_logs', $log );
            
            /***********END LOG*************/
            
            $this -> MedicineModel -> delete_issue_sale ( $issuance_id );
            $this -> AccountModel -> delete_ledger ( [ 'internal_issuance_id' => $issuance_id ] );
            $this -> session -> set_flashdata ( 'response', 'Success! Issued medicine deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * edit issuance medicine
         * -------------------------
         */
        
        public function edit () {
            $issuance_id = @$_REQUEST[ 'sale_id' ];
            if ( !isset( $issuance_id ) or empty( trim ( $issuance_id ) ) or !is_numeric ( $issuance_id ) or $issuance_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_issued_medicine_internal' )
                $this -> do_update_issued_medicine_internal ( $_POST );
            
            $title = site_name . ' - Edit Issuance';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $data[ 'issuance' ]    = $this -> MedicineModel -> get_issuance_by_id ( $issuance_id );
            $data[ 'users' ]       = $this -> UserModel -> get_active_users ();
            $this -> load -> view ( '/medicines/edit-internal-issue', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do issue medicines
         * add issuance
         * -------------------------
         */
        
        public function do_update_issued_medicine_internal ( $POST ) {
            $data      = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $issue_to  = $data[ 'user_id' ];
            $dept_id   = $data[ 'department_id' ];
            $sale_id   = $data[ 'sale_id' ];
            $medicines = array_filter ( $data[ 'medicine_id' ] );
            $net       = 0;
            
            $this -> MedicineModel -> delete_issue_medicine_returned ( $sale_id );
            $this -> MedicineModel -> delete_issue_medicine_by_issuance_id ( $sale_id );
            if ( count ( $medicines ) > 0 ) {
                $issuance_id = $sale_id;
                foreach ( $medicines as $key => $value ) {
                    if ( !empty( trim ( $value ) ) and $value > 0 ) {
                        $medicine_id = $value;
                        $stock_id    = $data[ 'stock_id' ][ $key ];
                        $quantity    = $data[ 'quantity' ][ $key ];
                        $return      = $data[ 'return' ][ $key ];
                        
                        $stock_price = get_stock ( $stock_id ) -> tp_unit;
                        $net         = $net + ( $stock_price * $quantity );
                        
                        $info = array (
                            'user_id'       => get_logged_in_user_id (),
                            'sale_id'       => $issuance_id,
                            'issue_to'      => $issue_to,
                            'medicine_id'   => $medicine_id,
                            'stock_id'      => $stock_id,
                            'department_id' => $dept_id,
                            'quantity'      => $quantity - $return,
                            'returned'      => $return,
                            'date_added'    => current_date_time (),
                        );
                        $this -> MedicineModel -> issue_medicine ( $info );
                        
                        /***********LOGS*************/
                        
                        $log = array (
                            'user_id'      => get_logged_in_user_id (),
                            'sale_id'      => $issuance_id,
                            'action'       => 'internal_issuance_updated',
                            'log'          => ' ',
                            'after_update' => json_encode ( $info ),
                            'date_added'   => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'internal_issuance_logs', $log );
                        
                        /***********END LOG*************/
                        
                        if ( isset( $return ) and $return > 0 ) {
                            $info = array (
                                'user_id'       => get_logged_in_user_id (),
                                'sale_id'       => $issuance_id,
                                'issue_to'      => $issue_to,
                                'medicine_id'   => $medicine_id,
                                'stock_id'      => $stock_id,
                                'department_id' => $dept_id,
                                'quantity'      => $return,
                                'date_added'    => current_date_time (),
                            );
                            $this -> MedicineModel -> return_issued_medicine ( $info );
                        }
                    }
                    
                    /***********LEDGER*************/
                    $where  = array (
                        'internal_issuance_id' => $issuance_id,
                        'acc_head_id'          => $dept_id != housekeeping_dept ? COS_Procedures : COS_Other_Direct_Cost_Procedures,
                    );
                    $ledger = array (
                        'credit' => $net,
                    );
                    $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                    
                    $where  = array (
                        'internal_issuance_id' => $issuance_id,
                        'acc_head_id'          => medical_supply_inventory
                    );
                    $ledger = array ( 'debit' => $net );
                    $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                    /***********END LEDGER*************/
                    
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Medicine issuance updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete single issuance medicine
         * -------------------------
         */
        
        public function delete_single_issuance () {
            $issuance_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $issuance_id ) ) or !is_numeric ( $issuance_id ) or $issuance_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'sale_id'      => $issuance_id,
                'action'       => 'single_internal_issuance_deleted',
                'log'          => json_encode ( $issuance_id ),
                'after_update' => json_encode ( $issuance_id ),
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'internal_issuance_logs', $log );
            
            /***********END LOG*************/
            
            $this -> MedicineModel -> delete_single_issuance ( $issuance_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Issued medicine deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * search issuance
         * -------------------------
         */
        
        public function search () {
            $title = site_name . ' - Search Issuance';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'users' ]    = $this -> UserModel -> get_active_users ();
            $data[ 'issuance' ] = $this -> MedicineModel -> search_issuance ();
            $this -> load -> view ( '/medicines/search-issuance', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * get medicine stock
         * check expiry date and status
         * -------------------------
         */
        
        public function get_stock_for_issuance () {
            $data           = filter_var_array ( $_POST, FILTER_SANITIZE_STRING );
            $medicine_id    = $data[ 'medicine_id' ];
            $selected       = $data[ 'selected' ];
            $selected_batch = explode ( ',', $data[ 'selected_batch' ] );
            $row            = $data[ 'row' ];
            if ( !empty( trim ( $medicine_id ) ) and is_numeric ( $medicine_id ) > 0 ) {
                
                $session = $this -> MedicineModel -> get_medicine_sale_session ( $medicine_id );
                if ( !empty( $session ) )
                    $stock_id = $session -> stocks;
                else
                    $stock_id = 0;
                
                $data[ 'stock' ]          = $this -> MedicineModel -> get_medicine_stock_not_in_current_session ( $medicine_id, $stock_id );
                $data[ 'row' ]            = $row;
                $data[ 'medicine_id' ]    = $medicine_id;
                $data[ 'medicine' ]       = get_medicine ( $medicine_id );
                $data[ 'selected' ]       = $selected;
                $data[ 'selected_batch' ] = $selected_batch;
                $this -> load -> view ( '/medicines/internal-issue-row', $data );
            }
            else {
                echo 'false';
            }
        }
        
    }
