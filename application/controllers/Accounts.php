<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Accounts extends CI_Controller {
        
        /**
         * -------------------------
         * Accounts constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'AccountModel' );
            $this -> load -> model ( 'SupplierModel' );
            $this -> load -> model ( 'DoctorModel' );
            $this -> load -> model ( 'PanelModel' );
            $this -> load -> model ( 'StoreModel' );
            $this -> load -> model ( 'IPDModel' );
            $this -> load -> model ( 'UserModel' );
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
         * Chart of accounts
         * -------------------------
         */
        
        public function chart_of_accounts () {
            $title = site_name . ' - Chart of accounts';
            $this -> header ( $title );
            $this -> sidebar ();
//            $data[ 'account_heads' ] = $this -> AccountModel -> get_all_account_heads ();
            $account_heads           = $this -> AccountModel -> get_chart_of_accounts ();
            $tree                    = buildTree ( $account_heads );
            $data[ 'account_heads' ] = $this -> AccountModel -> build_chart_of_accounts_table ( $tree );
            $this -> load -> view ( '/accounts/chart-of-accounts', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Chart of accounts
         * -------------------------
         */
        
        public function sub_account_heads () {
            
            $acc_head_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $acc_head_id ) ) or !is_numeric ( $acc_head_id ) )
                return redirect ( '/accounts/chart-of-accounts' );
            
            $title = site_name . ' - Chart of accounts';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_sub_account_heads ( $acc_head_id );
            $data[ 'account' ]       = $this -> AccountModel -> get_account_head_by_id ( $acc_head_id );
            $this -> load -> view ( '/accounts/sub-account-heads', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add account heads
         * -------------------------
         */
        
        public function add_account_head () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_account_head' )
                $this -> do_add_account_head ( $_POST );
            
            $title = site_name . ' - Add account heads';
            $this -> header ( $title );
            $this -> sidebar ();
//            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            
            $account_heads           = $this -> AccountModel -> get_chart_of_accounts ();
            $tree                    = buildTree ( $account_heads );
            $options                 = '';
            $list                    = buildList ( $tree, $options );
            $data[ 'account_heads' ] = $list;
            $data[ 'roles' ]         = $this -> AccountModel -> get_roles ();
            $data[ 'doctors' ]       = $this -> DoctorModel -> get_doctors ();
            $data[ 'panels' ]        = $this -> PanelModel -> get_panels ();
            $this -> load -> view ( '/accounts/add-account-head', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add account head
         * -------------------------
         */
        
        public function do_add_account_head ( $POST ) {
            $data      = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $doctor_id = $data[ 'doctor_id' ];
            $panel_id  = $data[ 'panel_id' ];
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|is_unique[account_heads.title]' );
            if ( $this -> form_validation -> run () == true ) {
                if ( !is_doctor_already_linked_with_account_head ( $doctor_id ) and !is_panel_already_linked_with_account_head ( $panel_id ) ) {
                    $info       = array (
                        'title'          => $data[ 'name' ],
                        'parent_id'      => $data[ 'parent_id' ],
                        'role_id'        => $data[ 'role_id' ],
                        'doctor_id'      => $data[ 'doctor_id' ],
                        'panel_id'       => $data[ 'panel_id' ],
                        'contact_person' => $data[ 'contact_person' ],
                        'phone'          => $data[ 'phone' ],
                        'status'         => $data[ 'status' ],
                        'type'           => $data[ 'type' ],
                        'balance_sheet'  => $data[ 'balance-sheet' ],
                        'deleteable'     => '1',
                        'description'    => $data[ 'description' ],
                        'date_added'     => current_date_time (),
                    );
                    $account_id = $this -> AccountModel -> insert ( $info );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'account_id'   => $account_id,
                        'action'       => 'account_head_added',
                        'log'          => json_encode ( $info ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'accounts_logs', $log );
                    
                    /***********END LOG*************/
                    
                    if ( $account_id > 0 ) {
                        $this -> session -> set_flashdata ( 'response', 'Success! Account head created' );
                        return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                    }
                    else {
                        $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                        return redirect ( base_url ( '/accounts/add-account-head' ) );
                    }
                }
                else {
                    if ( is_doctor_already_linked_with_account_head ( $doctor_id ) )
                        $this -> session -> set_flashdata ( 'error', 'Error! Doctor is already linked with another account head.' );
                    if ( is_panel_already_linked_with_account_head ( $panel_id ) )
                        $this -> session -> set_flashdata ( 'error', 'Error! Panel is already linked with another account head.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * @return mixed
         * edit page of account head
         * -------------------------
         */
        
        public function edit () {
            $acc_head_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $acc_head_id ) ) or !is_numeric ( $acc_head_id ) or $acc_head_id < 1 )
                return rediect ( '/accounts/chart-of-accounts' );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_account_head' )
                $this -> do_edit_account_head ( $_POST );
            
            $title = site_name . ' - Edit account heads';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'single_account_head' ] = $single_account_head = $this -> AccountModel -> get_account_head_by_id ( $acc_head_id );
            $account_heads                 = $this -> AccountModel -> get_chart_of_accounts ();
            $tree                          = buildTree ( $account_heads );
            $options                       = '';
            $list                          = buildList ( $tree, $options, 0, false, $single_account_head );
            $data[ 'list' ]                = $list;
            $data[ 'roles' ]               = $this -> AccountModel -> get_roles ();
            $data[ 'doctors' ]             = $this -> DoctorModel -> get_doctors ();
            $data[ 'panels' ]              = $this -> PanelModel -> get_panels ();
            $this -> load -> view ( '/accounts/edit-account-head', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do update account head
         * -------------------------
         */
        
        public function do_edit_account_head ( $POST ) {
            $data        = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $acc_head_id = $data[ 'acc_id' ];
            $info        = array (
                'title'          => $data[ 'name' ],
                'parent_id'      => $data[ 'parent_id' ],
                'role_id'        => $data[ 'role_id' ],
                'doctor_id'      => $data[ 'doctor_id' ],
                'panel_id'       => $data[ 'panel_id' ],
                'contact_person' => $data[ 'contact_person' ],
                'phone'          => $data[ 'phone' ],
                'status'         => $data[ 'status' ],
                'type'           => $data[ 'type' ],
                'balance_sheet'  => $data[ 'balance-sheet' ],
                'description'    => $data[ 'description' ],
            );
            $updated     = $this -> AccountModel -> edit ( $info, $acc_head_id );
            if ( $updated ) {
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'account_id'   => $acc_head_id,
                    'action'       => 'account_head_updated',
                    'log'          => ' ',
                    'after_update' => json_encode ( $info ),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'accounts_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Account head updated' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Note! Account head already updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * @return mixed
         * inactive account head
         * -------------------------
         */
        
        public function delete () {
            $acc_head_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $acc_head_id ) ) or !is_numeric ( $acc_head_id ) or $acc_head_id < 1 )
                return rediect ( '/accounts/chart-of-accounts' );
            
            $this -> AccountModel -> delete_acc_head ( $acc_head_id );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'account_id'   => $acc_head_id,
                'action'       => 'account_head_deleted',
                'log'          => json_encode ( $acc_head_id ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'accounts_logs', $log );
            
            /***********END LOG*************/
            
            $this -> session -> set_flashdata ( 'response', 'Success! Account head deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @return mixed
         * activate account head
         * -------------------------
         */
        
        public function reactivate () {
            $acc_head_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $acc_head_id ) ) or !is_numeric ( $acc_head_id ) or $acc_head_id < 1 )
                return rediect ( '/accounts/chart-of-accounts' );
            
            $info    = array (
                'status' => '1'
            );
            $updated = $this -> AccountModel -> delete ( $info, $acc_head_id );
            
            if ( $updated ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Account head active.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Note! Account head already updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * add transactions page
         * load all account heads
         * load banks
         * -------------------------
         */
        
        public function add_transactions () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_transaction' )
                $this -> do_add_transaction ( $_POST );
            
            $title = site_name . ' - Add Transactions';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'banks' ]         = $this -> AccountModel -> get_banks ( bank_id );
            $data[ 'admissions' ]    = array ();
            $account_heads           = $this -> AccountModel -> get_chart_of_accounts ();
            $tree                    = buildTree ( $account_heads );
            $options                 = '';
            $data[ 'account_heads' ] = buildList ( $tree, $options );
            $this -> load -> view ( '/accounts/add-transaction', $data );
            $this -> footer ();
        }
        
        public function add_transactions_panel () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_transaction' )
                $this -> do_add_transaction ( $_POST );
            
            $title = site_name . ' - Add Transactions (Panel)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'banks' ]         = $this -> AccountModel -> get_banks ( bank_id );
            $data[ 'admissions' ]    = $this -> IPDModel -> get_ipd_visits ();
            $account_heads           = $this -> AccountModel -> get_chart_of_accounts ();
            $tree                    = buildTree ( $account_heads );
            $options                 = '';
            $data[ 'account_heads' ] = buildList ( $tree, $options );
            $this -> load -> view ( '/accounts/add-transaction', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add transaction
         * -------------------------
         */
        
        public function do_add_transaction ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'acc_head_id', 'account head', 'trim|required|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'amount', 'amount', 'trim|required|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'trans_date', 'trans_date', 'trim|required|min_length[1]|date|xss_clean' );
            $this -> form_validation -> set_rules ( 'transaction_type', 'transaction type', 'trim|required|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'description', 'description', 'trim|required|min_length[1]|xss_clean' );
            //        $this -> form_validation -> set_rules('voucher_number', 'voucher number', 'trim|required|min_length[1]|xss_clean');
            
            if ( $this -> form_validation -> run () == true ) {
                $bank_trans_id  = 0;
                $voucher_number = generate_voucher_number ( $data[ 'voucher_number' ] );
                $info           = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => $data[ 'acc_head_id' ],
                    'voucher_number'   => $voucher_number,
                    'trans_date'       => date ( 'Y-m-d', strtotime ( $data[ 'trans_date' ] ) ),
                    'payment_mode'     => $data[ 'payment_mode' ],
                    'transaction_no'   => $data[ 'transaction-no' ],
                    'transaction_type' => $data[ 'transaction_type' ],
                    'description'      => $data[ 'description' ],
                    'date_added'       => current_date_time (),
                );
                if ( $data[ 'transaction_type' ] == 'credit' ) {
                    $info[ 'credit' ] = $data[ 'amount' ];
                }
                if ( $data[ 'transaction_type' ] == 'debit' ) {
                    $info[ 'debit' ] = $data[ 'amount' ];
                }
                
                $trans_id = $this -> AccountModel -> add_ledger ( $info );
                
                /*********** IF BANK ID EXISTS *************/
                
                if ( isset( $data[ 'acc_head_id_2' ] ) and !empty( trim ( $data[ 'acc_head_id_2' ] ) ) ) {
                    $bank_trans = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => $data[ 'acc_head_id_2' ],
                        'voucher_number'   => $voucher_number,
                        'trans_date'       => date ( 'Y-m-d', strtotime ( $data[ 'trans_date' ] ) ),
                        'payment_mode'     => $data[ 'payment_mode' ],
                        'transaction_no'   => $data[ 'transaction-no' ],
                        'transaction_type' => $data[ 'transaction_type_2' ],
                        'description'      => $data[ 'description' ],
                        'date_added'       => current_date_time (),
                    );
                    if ( $data[ 'transaction_type_2' ] == 'credit' ) {
                        $bank_trans[ 'credit' ] = $data[ 'amount' ];
                    }
                    if ( $data[ 'transaction_type_2' ] == 'debit' ) {
                        $bank_trans[ 'debit' ] = $data[ 'amount' ];
                    }
                    $bank_trans_id = $this -> AccountModel -> add_ledger ( $bank_trans );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'account_id'   => $bank_trans_id,
                        'action'       => 'bank_transaction_added',
                        'log'          => json_encode ( $bank_trans ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'accounts_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
                /*********** IF BANK ID EXISTS *************/
                
                $this -> add_ipd_receivables ( $trans_id, $bank_trans_id );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'account_id'   => $trans_id,
                    'action'       => 'transaction_added',
                    'log'          => json_encode ( $info ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'accounts_logs', $log );
                
                /***********END LOG*************/
                
                $response = 'Transaction ID# ' . $trans_id . '<a href="' . base_url ( '/invoices/voucher_transaction/' . $voucher_number ) . '" style="margin-left: 10px;text-decoration: underline;" target="_blank">Print Voucher</a><br>';
                
                if ( !empty( $bank_trans_id ) ) {
                    $response .= 'Second Transaction ID# ' . $bank_trans_id . '<br>';
                    $response .= 'Voucher Number# ' . $voucher_number . '<br>';
                }
                
                if ( $trans_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', $response );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        public function add_ipd_receivables ( $trans_id, $bank_trans_id ) {
            $sales          = $this -> input -> post ( 'sale-id' );
            $transaction_no = $this -> input -> post ( 'transaction-no' );
            $trans_date     = date ( 'Y-m-d', strtotime ( $this -> input -> post ( 'trans_date' ) ) );
            
            if ( isset( $sales ) && count ( $sales ) > 0 ) {
                foreach ( $sales as $sale_id ) {
                    if ( $sale_id > 0 ) {
                        $admission = get_ipd_admission_slip ( $sale_id );
                        $info      = array (
                            'user_id'            => get_logged_in_user_id (),
                            'general_ledger_ids' => $trans_id . ',' . $bank_trans_id,
                            'sale_id'            => $sale_id,
                            'visit_no'           => $admission -> visit_no,
                            'cheque_no'          => $transaction_no,
                            'cheque_date'        => $trans_date
                        );
                        $this -> IPDModel -> process_receivables ( $info );
                    }
                }
            }
        }
        
        /**
         * -------------------------
         * opening balances
         * main page
         * -------------------------
         */
        
        public function opening_balances () {
            $title = site_name . ' - Opening Balances';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'balances' ]      = $this -> AccountModel -> get_opening_balances ();
            $this -> load -> view ( '/accounts/opening-balances', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add opening balance
         * -------------------------
         */
        
        public function add_opening_balances () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_opening_balances' )
                $this -> do_add_opening_balances ( $_POST );
            
            $title = site_name . ' - Add Opening Balances';
            $this -> header ( $title );
            $this -> sidebar ();
            $account_heads           = $this -> AccountModel -> get_chart_of_accounts ();
            $tree                    = buildTree ( $account_heads );
            $options                 = '';
            $data[ 'account_heads' ] = buildList ( $tree, $options );
            $this -> load -> view ( '/accounts/add-opening-balance', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add opening balance
         * -------------------------
         */
        
        public function do_add_opening_balances ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'acc_head_id', 'account head', 'trim|required|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'amount', 'amount', 'trim|required|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'date_added', 'transaction date', 'trim|required|xss_clean' );
            $this -> form_validation -> set_rules ( 'transaction_type', 'transaction type', 'trim|required|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                $info           = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => $data[ 'acc_head_id' ],
                    'trans_date'       => date ( 'Y-m-d', strtotime ( $data[ 'date_added' ] ) ),
                    'payment_mode'     => 'opening_balance',
                    'paid_via'         => '',
                    'transaction_type' => 'opening_balance',
                    'description'      => 'opening balance',
                    'date_added'       => current_date_time (),
                );
                $parent_account = get_account_head ( $data[ 'acc_head_id' ] );
                
                /*********** IF ACCOUNT HEAD PARENT IS BANK ****************/
                if ( $parent_account -> parent_id == bank_id ) {
                    if ( $data[ 'transaction_type' ] == 'credit' ) {
                        $info[ 'credit' ] = $data[ 'amount' ];
                    }
                    if ( $data[ 'transaction_type' ] == 'debit' ) {
                        $info[ 'debit' ] = $data[ 'amount' ];
                    }
                }
                /*********** IF ACCOUNT HEAD PARENT IS SUPPLIER ****************/
                else {
                    if ( $data[ 'transaction_type' ] == 'credit' ) {
                        $info[ 'credit' ] = $data[ 'amount' ];
                    }
                    if ( $data[ 'transaction_type' ] == 'debit' ) {
                        $info[ 'debit' ] = $data[ 'amount' ];
                    }
                }
                $balance_id = $this -> AccountModel -> add_opening_balance ( $info );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'account_id'   => $balance_id,
                    'action'       => 'opening_balance_added',
                    'log'          => json_encode ( $info ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'accounts_logs', $log );
                
                /***********END LOG*************/
                
                if ( $balance_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Opening balance added.' );
                    return redirect ( base_url ( '/accounts/add-opening-balance' ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( base_url ( '/accounts/add-opening-balance' ) );
                }
            }
        }
        
        /**
         * -------------------------
         * delete opening balance
         * -------------------------
         */
        
        public function delete_opening_balance () {
            $balance_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $balance_id ) ) or !is_numeric ( $balance_id ) or $balance_id < 1 )
                return rediect ( '/accounts/opening-balances' );
            
            $this -> AccountModel -> delete_opening_balance ( $balance_id );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'account_id'   => $balance_id,
                'action'       => 'opening_balance_deleted',
                'log'          => json_encode ( $balance_id ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'accounts_logs', $log );
            
            /***********END LOG*************/
            
            $this -> session -> set_flashdata ( 'response', 'Success! Balance removed from system.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * get remaining balance
         * -------------------------
         */
        
        public function get_remaining_balance () {
            $acc_head_id = $this -> input -> post ( 'acc_head_id' );
            if ( !empty( trim ( $acc_head_id ) ) and is_numeric ( $acc_head_id ) ) {
                echo $this -> AccountModel -> get_remaining_balance ( $acc_head_id );
            }
        }
        
        /**
         * -------------------------
         * general ledger page
         * search ledgers
         * -------------------------
         */
        
        public function general_ledger () {
            $title = site_name . ' - General Ledger';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'ledgers' ]       = $this -> AccountModel -> get_ledgers ();
            $this -> load -> view ( '/accounts/general-ledger', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * general ledger page
         * search transactions
         * -------------------------
         */
        
        public function search_transaction () {
            $title = site_name . ' - Search Transactions';
            $this -> header ( $title );
            $this -> sidebar ();
            
            if ( isset( $_REQUEST[ 'transaction_number' ] ) and !empty( trim ( $_REQUEST[ 'transaction_number' ] ) ) and is_numeric ( $_REQUEST[ 'transaction_number' ] ) and $_REQUEST[ 'transaction_number' ] > 0 )
                $transaction_id = $_REQUEST[ 'transaction_number' ];
            else
                $transaction_id = 0;
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_transaction' )
                $this -> do_update_transaction ( $_POST );

//            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'banks' ]       = $this -> AccountModel -> get_banks ( bank_id );
            $data[ 'transaction' ] = $this -> AccountModel -> filter_general_ledger ();
            
            $singleAccountHeadId = null;
            if ( !empty( $data[ 'transaction' ] ) )
                $singleAccountHeadId = $data[ 'transaction' ] -> acc_head_id;
            
            $account_heads  = $this -> AccountModel -> get_chart_of_accounts ();
            $tree           = buildTree ( $account_heads );
            $options        = '';
            $list           = buildList ( $tree, $options, 0, false, null, $singleAccountHeadId );
            $data[ 'list' ] = $list;
            $this -> load -> view ( '/accounts/search-transaction', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do update transaction
         * -------------------------
         */
        
        public function do_update_transaction ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'acc_head_id', 'account head', 'trim|required|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'amount', 'amount', 'trim|required|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'trans_date', 'trans_date', 'trim|required|min_length[1]|date|xss_clean' );
            $this -> form_validation -> set_rules ( 'payment_mode', 'payment_mode', 'trim|required|min_length[1]|xss_clean' );
            
            $this -> form_validation -> set_rules ( 'transaction_type', 'transaction type', 'trim|required|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'description', 'description', 'trim|required|min_length[1]|xss_clean' );
            //		$this -> form_validation -> set_rules('voucher_number', 'voucher number', 'trim|required|min_length[1]|xss_clean');
            
            $transaction_id = $data[ 'transaction_id' ];
            $acc_head_id    = $data[ 'acc_head_id' ];
            
            if ( is_numeric ( $acc_head_id ) > 0 ) {
                $id = $acc_head_id;
            }
            else {
                $exp = explode ( '-', $acc_head_id );
                $id  = $exp[ 1 ];
            }
            
            $data[ 'acc_head_id' ] = $id;
            
            $parent = $this -> AccountModel -> get_account_head_parent ( $id );
            if ( $this -> form_validation -> run () == true ) {
                if ( $parent == bank_id )
                    $this -> update_bank_transaction ( $data, $transaction_id, $id );
                else
                    $this -> update_current_transaction ( $data, $transaction_id, $id );
                
                $this -> session -> set_flashdata ( 'response', 'Success! Transaction updated' );
                return redirect ( base_url ( '/accounts/search-transaction?transaction_number=' . $transaction_id ) );
            }
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $transaction_id
         * update current transaction
         * -------------------------
         */
        
        public function update_current_transaction ( $data, $transaction_id ) {
            $ledger         = get_ledger ( array ( 'id' => $transaction_id ) );
            $voucher_number = $data[ 'voucher_number' ];
            $info           = array (
                'user_id'          => get_logged_in_user_id (),
                'acc_head_id'      => $data[ 'acc_head_id' ],
                'payment_mode'     => $data[ 'payment_mode' ],
                'transaction_no'   => $data[ 'transaction-no' ],
                'transaction_type' => $data[ 'transaction_type' ],
                'trans_date'       => date ( 'Y-m-d', strtotime ( $data[ 'trans_date' ] ) ),
                'voucher_number'   => $voucher_number,
                'description'      => $data[ 'description' ],
            );
            if ( $data[ 'transaction_type' ] == 'credit' ) {
                $info[ 'credit' ] = $data[ 'amount' ];
                $info[ 'debit' ]  = 0;
            }
            if ( $data[ 'transaction_type' ] == 'debit' ) {
                $info[ 'debit' ]  = $data[ 'amount' ];
                $info[ 'credit' ] = 0;
            }
            do_create_log ( $info, $transaction_id, '' );
            $this -> AccountModel -> update_ledger ( $info, $transaction_id );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'account_id'   => $data[ 'acc_head_id' ],
                'action'       => 'transaction_updated',
                'log'          => ' ',
                'after_update' => json_encode ( $info ),
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'accounts_logs', $log );
            
            /***********END LOG*************/
            
            $bank_transaction = $this -> AccountModel -> check_if_bank_trans_exists ( $transaction_id );
            if ( !empty( trim ( $bank_transaction ) ) and $bank_transaction > 0 ) {
                $this -> do_update_bank_running_balance ( $data, $bank_transaction );
            }
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $transaction_id
         * update current transaction
         * -------------------------
         */
        
        public function update_bank_transaction ( $data, $transaction_id, $acc_head_id ) {
            $voucher_number = $data[ 'voucher_number' ];
            $info           = array (
                'user_id'          => get_logged_in_user_id (),
                'acc_head_id'      => $data[ 'acc_head_id' ],
                'payment_mode'     => $data[ 'payment_mode' ],
                'transaction_type' => $data[ 'transaction_type' ],
                'voucher_number'   => $voucher_number,
                'description'      => $data[ 'description' ],
            );
            if ( $data[ 'transaction_type' ] == 'credit' ) {
                $info[ 'debit' ] = $data[ 'amount' ];
            }
            if ( $data[ 'transaction_type' ] == 'debit' ) {
                $info[ 'credit' ] = $data[ 'amount' ];
            }
            do_create_log ( $info, $transaction_id, '' );
            $this -> AccountModel -> update_ledger ( $info, $transaction_id );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'account_id'   => $data[ 'acc_head_id' ],
                'action'       => 'bank_transaction_updated',
                'log'          => ' ',
                'after_update' => json_encode ( $info ),
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'accounts_logs', $log );
            
            /***********END LOG*************/
            
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $transaction_id
         * update bank transactions
         * -------------------------
         */
        
        public function do_update_bank_running_balance ( $data, $transaction_id ) {
            $transaction = $this -> AccountModel -> get_transaction_by_id ( $transaction_id );
            $acc_head_id = $transaction -> acc_head_id;
            $info        = array (
                'user_id'          => get_logged_in_user_id (),
                'acc_head_id'      => $acc_head_id,
                'payment_mode'     => $data[ 'payment_mode' ],
                'transaction_type' => $data[ 'transaction_type' ],
                'description'      => $data[ 'description' ],
            );
            if ( $data[ 'transaction_type' ] == 'credit' ) {
                $info[ 'debit' ] = $data[ 'amount' ];
            }
            if ( $data[ 'transaction_type' ] == 'debit' ) {
                $info[ 'credit' ] = $data[ 'amount' ];
            }
            do_create_log ( $info, $transaction_id, $transaction );
            $this -> AccountModel -> update_ledger ( $info, $transaction_id );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'account_id'   => $data[ 'acc_head_id' ],
                'action'       => 'bank_opening_balance_updated',
                'log'          => ' ',
                'after_update' => json_encode ( $info ),
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'accounts_logs', $log );
            
            /***********END LOG*************/
            
        }
        
        /**
         * -------------------------
         * supplier invoices page
         * search by supplier, date
         * -------------------------
         */
        
        public function supplier_invoices () {
            $title = site_name . ' - Supplier Invoice';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $data[ 'invoices' ]  = $this -> AccountModel -> get_supplier_invoices ();
            $this -> load -> view ( '/accounts/supplier-invoice', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * revert transaction by voucher number
         * -------------------------
         */
        
        public function revert_transaction () {
            $voucher_number = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $voucher_number ) ) ) {
                $transactions = $this -> AccountModel -> get_transactions_by_voucher ( $voucher_number );
                
                /***********LOGS*************/
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'account_id'   => $voucher_number,
                    'action'       => 'transaction_reverted_via_voucher_number',
                    'log'          => json_encode ( $transactions ),
                    'after_update' => json_encode ( $voucher_number ),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'accounts_logs', $log );
                /***********END LOG*************/
                
                $this -> AccountModel -> revert_transaction ( $voucher_number );
                
                $this -> session -> set_flashdata ( 'response', 'Transaction has been reverted.' );
                return redirect ( base_url ( '/accounts/search-transactions' ) );
            }
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * check if voucher number exists
         * echo 'true', else 'false'
         * -------------------------
         */
        
        public function validate_voucher_number () {
            $voucher_number = $this -> input -> post ( 'voucher_number', true );
            if ( isset( $voucher_number ) and !empty( trim ( $voucher_number ) ) ) {
                $exists = $this -> AccountModel -> validate_voucher_number ( $voucher_number );
                if ( $exists )
                    echo 'exists';
                else
                    echo 'false';
            }
        }
        
        /**
         * -------------------------
         * add multiple transactions page
         * load all account heads
         * load banks
         * -------------------------
         */
        
        public function add_transactions_multiple () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'add_transactions_multiple' )
                $this -> do_add_transactions_multiple ( $_POST );
            
            $title = site_name . ' - Add Transactions - Multiple';
            $this -> header ( $title );
            $this -> sidebar ();
            $account_heads           = $this -> AccountModel -> get_chart_of_accounts ();
            $tree                    = buildTree ( $account_heads );
            $options                 = '';
            $list                    = buildList ( $tree, $options );
            $data[ 'list' ]          = $list;
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'banks' ]         = $this -> AccountModel -> get_banks ( bank_id );
            $this -> load -> view ( '/accounts/add-transaction-multiple', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add multiple transactions page
         * load all account heads
         * load banks
         * -------------------------
         */
        
        public function add_more_transactions () {
            $account_heads              = $this -> AccountModel -> get_chart_of_accounts ();
            $tree                       = buildTree ( $account_heads );
            $options                    = '';
            $data[ 'account_heads' ]    = buildList ( $tree, $options );
            $data[ 'banks' ]            = $this -> AccountModel -> get_banks ( bank_id );
            $data[ 'row' ]              = $_POST[ 'added' ];
            $data[ 'transaction_type' ] = $this -> input -> post ( 'transaction_type' );
            $this -> load -> view ( '/accounts/add-more-transaction-multiple', $data );
        }
        
        /**
         * -------------------------
         * check if doctor is linked with ACC
         * -------------------------
         */
        
        public function check_if_doctor_is_linked_with_account_head () {
            $doctor_id = $_POST[ 'doctor_id' ];
            $isLinked  = $this -> AccountModel -> check_if_doctor_is_linked_with_account_head ( $doctor_id );
            if ( $isLinked )
                echo 'true';
            else
                echo 'false';
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add multiple transactions
         * -------------------------
         */
        
        public function do_add_transactions_multiple ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'trans_date', 'trans_date', 'trim|required|min_length[1]|date|xss_clean' );
            $this -> form_validation -> set_rules ( 'description', 'description', 'trim|required|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'voucher_number', 'voucher number', 'trim|required|min_length[1]|xss_clean' );
            
            
            if ( $this -> form_validation -> run () == true ) {
                
                $voucher_number = generate_voucher_number ( $data[ 'voucher_number' ] );
                $trans_date     = date ( 'Y-m-d', strtotime ( $data[ 'trans_date' ] ) );
                $acc_head_id    = $data[ 'acc_head_id' ];
                $user_id        = get_logged_in_user_id ();
                $payment_method = $this -> input -> post ( 'payment_mode' );
                
                if ( isset( $acc_head_id ) and count ( $acc_head_id ) > 0 ) {
                    foreach ( $acc_head_id as $key => $value ) {
                        
                        $transaction_type = $data[ 'transaction_type_' . $key ];
                        
                        $info = array (
                            'user_id'          => $user_id,
                            'acc_head_id'      => $value,
                            'voucher_number'   => $voucher_number,
                            'trans_date'       => $trans_date,
                            'payment_mode'     => $payment_method,
                            'transaction_no'   => $data[ 'transaction-no' ],
                            'transaction_type' => $transaction_type,
                            'is_multiple'      => '1',
                            'description'      => $data[ 'description' ],
                            'date_added'       => current_date_time (),
                        );
                        
                        if ( $transaction_type == 'credit' ) {
                            $info[ 'credit' ] = $data[ 'amount' ][ $key ];
                        }
                        
                        if ( $transaction_type == 'debit' ) {
                            $info[ 'debit' ] = $data[ 'amount' ][ $key ];
                        }
                        
                        $this -> AccountModel -> add_ledger ( $info );
                        
                        /***********LOGS*************/
                        
                        $log = array (
                            'user_id'      => get_logged_in_user_id (),
                            'account_id'   => $value,
                            'action'       => 'multiple_transactions_added',
                            'log'          => json_encode ( $info ),
                            'after_update' => ' ',
                            'date_added'   => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'accounts_logs', $log );
                        
                        /***********END LOG*************/
                        
                    }
                }
                
                $response = 'Success! Multiple transactions are added with voucher number: ' . $voucher_number . '<a href="' . base_url ( '/invoices/voucher_transaction/' . $voucher_number ) . '" style="margin-left: 10px;text-decoration: underline;" target="_blank">Print Voucher</a><br>';
                
                $this -> session -> set_flashdata ( 'response', $response );
                return redirect ( base_url ( '/accounts/add-transactions-multiple' ) );
            }
        }
        
        /**
         * -------------------------
         * check account type
         * -------------------------
         */
        
        public function check_account_type () {
            $acc_head_id = $this -> input -> post ( 'acc_head_id', true );
            if ( $acc_head_id > 0 ) {
                $account = get_account_head ( $acc_head_id );
                if ( !empty( $account ) ) {
                    $role_id = $account -> role_id;
                    if ( $role_id > 0 ) {
                        if ( $role_id == assets )
                            echo 'debit';
                        if ( $role_id == liabilities )
                            echo 'credit';
                        if ( $role_id == capitals )
                            echo 'credit';
                        if ( $role_id == income )
                            echo 'credit';
                        if ( $role_id == expenditure )
                            echo 'debit';
                    }
                    else
                        echo 'false';
                }
                else
                    echo 'false';
            }
            else
                echo 'false';
        }
        
        /**
         * -------------------------
         * trial balance sheet
         * -------------------------
         */
        
        public function trial_balance_detail () {
            $title = site_name . ' - Trial Balance Sheet (Detail)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_account_heads_not_in ( local_purchase );
            $this -> load -> view ( '/accounts/trial-balance', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * trial balance sheet
         * -------------------------
         */
        
        public function trial_balance () {
            $title = site_name . ' - Trial Balance Sheet (Detail)';
            $this -> header ( $title );
            $this -> sidebar ();
            $account_heads                 = $this -> AccountModel -> get_trial_balance_sheet ( local_purchase );
            $tree                          = buildTree ( $account_heads );
            $data[ 'balance_sheet' ]       = $this -> AccountModel -> build_table ( $tree );
            $data[ 'balance_sheet_total' ] = $this -> AccountModel -> trial_balance_total ();
            
            $this -> load -> view ( '/accounts/trial-balance-new', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * profit loss statement
         * -------------------------
         */
        
        public function profit_loss_statement () {
            $title = site_name . ' - Profit Loss Statement';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'sales_account_head' ]              = $this -> AccountModel -> get_specific_account_heads ( sales_id );
            $data[ 'returns_allowances_account_head' ] = get_account_head ( Returns_and_Allowances );
            $data[ 'fee_discounts_account_head' ]      = $this -> AccountModel -> get_specific_account_heads ( Fee_Discounts );
            $data[ 'Direct_Costs_account_head' ]       = $this -> AccountModel -> get_specific_account_heads ( Direct_Costs );
            $data[ 'expenses_account_head' ]           = $this -> AccountModel -> get_specific_account_heads ( expense_id );
            $data[ 'other_incomes' ]                   = $this -> AccountModel -> get_specific_account_heads ( OTHER_INCOME );
            $data[ 'total_accumulative_depreciation' ] = $this -> StoreModel -> calculate_total_accumulative_depreciation ( $this -> input -> get ( 'end_date' ) );
            $data[ 'Finance_Cost_account_head' ]       = get_account_head ( Finance_Cost );
            $data[ 'Tax_account_head' ]                = get_account_head ( Tax );
            $this -> load -> view ( '/accounts/profit-loss-statement', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * trial balance sheet
         * -------------------------
         */
        
        public function balance_sheet () {
            $title = site_name . ' - Balance Sheet';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'cash_balances' ]                   = $this -> AccountModel -> filter_balance_sheet ( cash_balances );
            $data[ 'banks' ]                           = $this -> AccountModel -> filter_balance_sheet ( banks );
            $data[ 'receivable_accounts' ]             = $this -> AccountModel -> filter_balance_sheet ( receivable_accounts );
            $data[ 'inventory' ]                       = $this -> AccountModel -> filter_balance_sheet ( inventory );
            $data[ 'furniture_fixture' ]               = $this -> AccountModel -> filter_balance_sheet ( furniture_fixture );
            $data[ 'intangible_assets' ]               = $this -> AccountModel -> filter_balance_sheet ( intangible_assets );
            $data[ 'bio_medical_surgical_items' ]      = $this -> AccountModel -> filter_balance_sheet ( bio_medical_surgical_items );
            $data[ 'machinery_equipment' ]             = $this -> AccountModel -> filter_balance_sheet ( machinery_equipment );
            $data[ 'electrical_equipment' ]            = $this -> AccountModel -> filter_balance_sheet ( electrical_equipment );
            $data[ 'it_equipment' ]                    = $this -> AccountModel -> filter_balance_sheet ( it_equipment );
            $data[ 'office_equipment' ]                = $this -> AccountModel -> filter_balance_sheet ( office_equipment );
            $data[ 'land_building' ]                   = $this -> AccountModel -> filter_balance_sheet ( land_building );
            $data[ 'accumulated_depreciation' ]        = $this -> AccountModel -> filter_balance_sheet ( accumulated_depreciation );
            $data[ 'payable_accounts' ]                = $this -> AccountModel -> filter_balance_sheet ( payable_accounts );
            $data[ 'accrued_expenses' ]                = $this -> AccountModel -> filter_balance_sheet ( accrued_expenses );
            $data[ 'unearned_revenue' ]                = $this -> AccountModel -> filter_balance_sheet ( unearned_revenue );
            $data[ 'WHT_payable' ]                     = $this -> AccountModel -> filter_balance_sheet ( WHT_payable );
            $data[ 'long_term_debt' ]                  = $this -> AccountModel -> filter_balance_sheet ( long_term_debt );
            $data[ 'other_long_term_liabilities' ]     = $this -> AccountModel -> filter_balance_sheet ( other_long_term_liabilities );
            $data[ 'capital' ]                         = $this -> AccountModel -> filter_balance_sheet ( capital );
            $data[ 'total_accumulative_depreciation' ] = $this -> StoreModel -> calculate_total_accumulative_depreciation ( $this -> input -> get ( 'trans_date' ) );
            
            // to calculate net profit
            if ( isset( $_REQUEST[ 'trans_date' ] ) and !empty( trim ( $_REQUEST[ 'trans_date' ] ) ) )
                $data[ 'calculate_net_profit' ] = $this -> AccountModel -> balance_sheet_net_profit ();
            else
                $data[ 'calculate_net_profit' ] = 0;
            
            $this -> load -> view ( '/accounts/balance-sheet', $data );
            $this -> footer ();
        }
        
        public function balance_sheets () {
            $title = site_name . ' - Balance Sheet';
            $this -> header ( $title );
            $this -> sidebar ();
            
            $data[ 'currentAssets' ]                   = $this -> AccountModel -> get_balance_sheet_account_heads ( 'current-assets' );
            $data[ 'nonCurrentAssets' ]                = $this -> AccountModel -> get_balance_sheet_account_heads ( 'non-current-assets' );
            $data[ 'currentLiabilities' ]              = $this -> AccountModel -> get_balance_sheet_account_heads ( 'current-liabilities' );
            $data[ 'accumulated_depreciation' ]        = $this -> AccountModel -> filter_balance_sheet ( accumulated_depreciation );
            $data[ 'payable_accounts' ]                = $this -> AccountModel -> filter_balance_sheet ( payable_accounts );
            $data[ 'accrued_expenses' ]                = $this -> AccountModel -> filter_balance_sheet ( accrued_expenses );
            $data[ 'unearned_revenue' ]                = $this -> AccountModel -> filter_balance_sheet ( unearned_revenue );
            $data[ 'WHT_payable' ]                     = $this -> AccountModel -> filter_balance_sheet ( WHT_payable );
            $data[ 'long_term_debt' ]                  = $this -> AccountModel -> filter_balance_sheet ( long_term_debt );
            $data[ 'other_long_term_liabilities' ]     = $this -> AccountModel -> filter_balance_sheet ( other_long_term_liabilities );
            $data[ 'capital' ]                         = $this -> AccountModel -> filter_balance_sheet ( capital );
            $data[ 'total_accumulative_depreciation' ] = $this -> StoreModel -> calculate_total_accumulative_depreciation ( $this -> input -> get ( 'trans_date' ) );
            $data[ 'other_incomes' ]                   = $this -> AccountModel -> get_specific_account_heads ( OTHER_INCOME );
            
            // to calculate net profit
            if ( isset( $_REQUEST[ 'trans_date' ] ) and !empty( trim ( $_REQUEST[ 'trans_date' ] ) ) )
                $data[ 'calculate_net_profit' ] = $this -> AccountModel -> balance_sheet_net_profit ();
            else
                $data[ 'calculate_net_profit' ] = 0;
            
            $this -> load -> view ( '/accounts/balance-sheets', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * general ledger page
         * search ledgers
         * -------------------------
         */
        
        public function expanse_report () {
            $title = site_name . ' - Expanse Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $accounts1          = $this -> AccountModel -> get_account_heads_by_id ( GENERAL_ADMINISTRATIVE_EXPENSES );
            $accounts2          = get_general_and_administrative_expenses_data ( GENERAL_ADMINISTRATIVE_EXPENSES );
            $data[ 'accounts' ] = array_merge ( $accounts1, $accounts2 );
            $this -> load -> view ( '/accounts/expanse-report', $data );
            $this -> footer ();
        }
        
        public function edit_transactions_bulk () {
            $title = site_name . ' - Edit Transactions (Bulk)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'transactions' ]  = $this -> AccountModel -> filter_transactions ();
            $this -> load -> view ( '/accounts/edit-transactions-bulk', $data );
            $this -> footer ();
        }
        
        public function update_transactions_bulk () {
            $action          = $this -> input -> post ( 'action', true );
            $general_ledgers = $this -> input -> post ( 'general-ledger-id', true );
            $acc_head_id     = $this -> input -> post ( 'acc_head_id', true );
            $amount          = $this -> input -> post ( 'amount', true );
            $trans_date      = $this -> input -> post ( 'trans_date', true );
            $payment_mode    = $this -> input -> post ( 'payment_mode', true );
            $description     = $this -> input -> post ( 'description', true );
            $transaction_no  = $this -> input -> post ( 'transaction-no', true );
            
            if ( isset( $action ) && $action === 'update_bulk_transactions' && count ( $general_ledgers ) > 0 ) {
                foreach ( $general_ledgers as $key => $general_ledger_id ) {
                    
                    $transaction_type = $this -> input -> post ( 'transaction_type_' . $general_ledger_id, true );
                    $exp              = explode ( '-', $acc_head_id[ $key ] );
                    $id               = $exp[ 1 ];
                    
                    $info = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => $id,
                        'payment_mode'     => $payment_mode,
                        'transaction_no'   => $transaction_no,
                        'transaction_type' => $transaction_type,
                        'trans_date'       => date ( 'Y-m-d', strtotime ( $trans_date ) ),
                        'description'      => $description,
                    );
                    if ( $transaction_type === 'credit' ) {
                        $info[ 'credit' ] = $amount[ $key ];
                        $info[ 'debit' ]  = 0;
                    }
                    if ( $transaction_type === 'debit' ) {
                        $info[ 'debit' ]  = $amount[ $key ];
                        $info[ 'credit' ] = 0;
                    }
                    
                    $this -> AccountModel -> update_ledger ( $info, $general_ledger_id );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'account_id'   => $acc_head_id[ $key ],
                        'action'       => 'transaction_updated',
                        'log'          => ' ',
                        'after_update' => json_encode ( $info ),
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'accounts_logs', $log );
                    
                    /***********END LOG*************/
                }
                
                $this -> session -> set_flashdata ( 'response', 'Success! Transactions has been updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                
            }
            
            $this -> session -> set_flashdata ( 'error', 'Error! Invalid request.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        public function load_account_head_transaction_dropdown () {
            $type                    = $this -> input -> get ( 'type' );
            $account_head            = $type === 'cash' ? cash_balances : banks;
            $data[ 'account_head' ]  = $this -> AccountModel -> get_account_head ( $account_head );
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'type' ]          = $type;
            
            if ( $type === 'all' ) {
                $account_heads = $this -> AccountModel -> get_chart_of_accounts ();
                $tree          = buildTree ( $account_heads );
                $options       = '';
                echo buildList ( $tree, $options );
            }
            else {
                echo $this -> load -> view ( '/accounts/load-account-heads', $data );
            }
        }
        
        public function accounts_receivable () {
            $title = site_name . ' - Accounts Receivable';
            $this -> header ( $title );
            $this -> sidebar ();
            $account_heads         = $this -> AccountModel -> getRecursiveAccountHeads ( receivable_accounts );
            $data[ 'receivables' ] = displayRecursiveAccountHeads ( $account_heads );
            $this -> load -> view ( '/accounts/accounts-receivable', $data );
            $this -> footer ();
        }
        
        public function accounts_payable () {
            $title = site_name . ' - Accounts Payable';
            $this -> header ( $title );
            $this -> sidebar ();
            $account_heads     = $this -> AccountModel -> getRecursiveAccountHeads ( payable_accounts );
            $data[ 'payable' ] = displayRecursiveAccountHeads ( $account_heads, 0, 0, 1, true );
            $this -> load -> view ( '/accounts/accounts-payable', $data );
            $this -> footer ();
        }
        
        public function general_ledgers () {
            $title = site_name . ' - General Ledgers';
            $this -> header ( $title );
            $this -> sidebar ();
            $account_heads                 = $this -> AccountModel -> get_chart_of_accounts ();
            $tree                          = buildTree ( $account_heads );
            $options                       = '';
            $list                          = buildList ( $tree, $options );
            $data[ 'list' ]                = $list;
            $account_heads                 = $this -> AccountModel -> getRecursiveAccountHeads ( $this -> input -> get ( 'account-head' ) );
            $data[ 'parent_account_head' ] = $this -> AccountModel -> get_account_head_by_id ( $this -> input -> get ( 'account-head' ) );
            $account_head[]                = $this -> AccountModel -> get_account_head_by_id ( $this -> input -> get ( 'account-head' ) );
            $account_heads_list            = ( array_merge ( $account_head, $account_heads ) );
            $data[ 'ledgers' ]             = build_ledgers_table ( $account_heads_list );
            $this -> load -> view ( '/accounts/general-ledgers', $data );
            $this -> footer ();
        }
        
        public function charts_of_accounts () {
            $title = site_name . ' - Charts of accounts';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'roles' ] = $this -> AccountModel -> get_roles ();
            $this -> load -> view ( '/accounts/charts-of-accounts', $data );
            $this -> footer ();
        }
        
        public function search_transactions () {
            $title = site_name . ' - Search Transactions';
            $this -> header ( $title );
            $this -> sidebar ();
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_transaction' )
                $this -> do_update_transactions ();
            
            $data[ 'transactions' ] = $this -> AccountModel -> search_transactions_by_voucher ();
            $account_heads          = $this -> AccountModel -> get_chart_of_accounts ();
            $data[ 'tree' ]         = buildTree ( $account_heads );
            $data[ 'options' ]      = '';
            $data[ 'access' ]       = $this -> UserModel -> get_user_access ( get_logged_in_user_id () );
            $this -> load -> view ( '/accounts/search-transactions', $data );
            $this -> footer ();
        }
        
        public function do_update_transactions () {
            $this -> form_validation -> set_rules ( 'trans-date', 'trans_date', 'trim|required|min_length[1]|date|xss_clean' );
            $this -> form_validation -> set_rules ( 'payment-mode', 'payment_mode', 'trim|required|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'description', 'description', 'trim|required|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () ) {
                $acc_head_id     = $this -> input -> post ( 'acc-head-id' );
                $transaction_no  = $this -> input -> post ( 'transaction-no' );
                $amount          = $this -> input -> post ( 'amount' );
                $trans_date      = $this -> input -> post ( 'trans-date' );
                $payment_mode    = $this -> input -> post ( 'payment-mode' );
                $description     = $this -> input -> post ( 'description' );
                $general_ledgers = $this -> input -> post ( 'general-ledger-id' );
                
                if ( count ( $general_ledgers ) > 0 ) {
                    foreach ( $general_ledgers as $key => $ledger ) {
                        $ledgerInfo = get_ledger ( array ( 'id' => $ledger ) );
                        
                        if ( $ledgerInfo -> transaction_type == 'credit' ) {
                            $debit  = 0;
                            $credit = $amount[ $key ];
                        }
                        else {
                            $debit  = $amount[ $key ];
                            $credit = 0;
                        }
                        
                        $info = array (
                            'acc_head_id'    => $acc_head_id[ $key ],
                            'trans_date'     => date ( 'Y-m-d', strtotime ( $trans_date ) ),
                            'payment_mode'   => $payment_mode,
                            'transaction_no' => $transaction_no,
                            'description'    => $description,
                            'credit'         => $credit,
                            'debit'          => $debit
                        );
                        $this -> AccountModel -> update_general_ledger ( $info, array ( 'id' => $ledger ) );
                    }
                }
                
                $this -> session -> set_flashdata ( 'response', 'Success! Transactions have been updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        public function search_transactions_advance () {
            $title = site_name . ' - Search Transactions (Advance)';
            $this -> header ( $title );
            $this -> sidebar ();
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_transaction' )
                $this -> do_update_transactions ();
            
            $data[ 'transactions' ] = $this -> AccountModel -> search_transactions_by_voucher ();
            $account_heads          = $this -> AccountModel -> get_chart_of_accounts ();
            $data[ 'tree' ]         = buildTree ( $account_heads );
            $data[ 'options' ]      = '';
            $data[ 'access' ]       = $this -> UserModel -> get_user_access ( get_logged_in_user_id () );
            
            $voucher_number = $this -> input -> get ( 'voucher' );
            $voucher        = explode ( '-', $voucher_number );
            
            // For First Account Head Dropdown
            if ( in_array ( strtolower ( $voucher[ 0 ] ), array ( 'cpv', 'crv' ) ) )
                $account_head = cash_balances;
            else if ( in_array ( strtolower ( $voucher[ 0 ] ), array ( 'bpv', 'brv' ) ) )
                $account_head = banks;
            else
                $account_head = 0;
            
            $first_account_heads           = $this -> AccountModel -> get_chart_of_accounts ( $account_head );
            $data[ 'first_account_heads' ] = $first_account_heads;
            // For First Account Head Dropdown Ends
            
            $this -> load -> view ( '/accounts/search-transactions-advance', $data );
            $this -> footer ();
        }
        
        public function delete_transaction ( $transaction_id ) {
            if ( $transaction_id > 0 ) {
                $ledger = get_ledger ( array ( 'id' => $transaction_id ) );
                
                /***********LOGS*************/
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'account_id'   => $ledger -> acc_head_id,
                    'action'       => 'transaction_deleted',
                    'log'          => json_encode ( $ledger ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'accounts_logs', $log );
                /***********END LOG*************/
                
                $this -> AccountModel -> delete_ledger ( array ( 'id' => $transaction_id ) );
                
                $this -> session -> set_flashdata ( 'response', 'Success! Transactions has been deleted.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            
            $this -> session -> set_flashdata ( 'error', 'Error! Invalid transaction.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
    }
