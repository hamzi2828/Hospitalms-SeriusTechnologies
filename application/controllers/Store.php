<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Store extends CI_Controller {
        
        /**
         * -------------------------
         * Store constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'StoreModel' );
            $this -> load -> model ( 'SupplierModel' );
            $this -> load -> model ( 'AccountModel' );
            $this -> load -> model ( 'MedicineModel' );
            $this -> load -> model ( 'MemberModel' );
            $this -> load -> model ( 'RequisitionModel' );
            $this -> load -> model ( 'UserModel' );
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
         * -------------------------
         * Store main page
         * load all store items
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - Store';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'stores' ] = $this -> StoreModel -> get_store ();
            $this -> load -> view ( '/store/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add store items main page
         * -------------------------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_store' )
                $this -> do_add_store ( $_POST );
            
            $title = site_name . ' - Add Store Items';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $this -> load -> view ( '/store/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add store items
         * -------------------------
         */
        
        public function do_add_store ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'item', 'item name', 'required|trim|min_length[1]|xss_clean' );
            if ( $this -> form_validation -> run () == true ) {
                $info     = array (
                    'user_id'         => get_logged_in_user_id (),
                    'department_id'   => $data[ 'department-id' ],
                    'item'            => $data[ 'item' ],
                    'type'            => $data[ 'type' ],
                    'threshold'       => $data[ 'threshold' ],
                    'regent_quantity' => $data[ 'regent_quantity' ],
                    'date_added'      => current_date_time (),
                );
                $store_id = $this -> StoreModel -> add ( $info );
                if ( $store_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Store item added' );
                    return redirect ( base_url ( '/store/add' ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( base_url ( '/store/add' ) );
                }
            }
        }
        
        /**
         * -------------------------
         * delete store items
         * based on store id
         * -------------------------
         */
        
        public function delete () {
            $store_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $store_id ) ) or !is_numeric ( $store_id ) or $store_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $stocks = $this -> StoreModel -> get_stock ( $store_id );
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock ) {
                    $condition = array (
                        'stock_id'   => $stock -> invoice,
                        'invoice_id' => $stock -> invoice
                    );
                    $this -> AccountModel -> delete_ledger ( $condition );
                }
            }
            
            $where = array (
                'id' => $store_id
            );
            
            $deleted = $this -> StoreModel -> delete ( $where );
            if ( $deleted ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Store item deleted' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * Edit store item main page
         * based on store id
         * -------------------------
         */
        
        public function edit () {
            
            $store_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $store_id ) ) or !is_numeric ( $store_id ) or $store_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_store' )
                $this -> do_edit_store ( $_POST );
            
            $title = site_name . ' - Edit Store Item';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $data[ 'store' ]       = $this -> StoreModel -> get_store_by_id ( $store_id );
            $this -> load -> view ( '/store/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit store
         * -------------------------
         */
        
        public function do_edit_store ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'item', 'item name', 'required|trim|min_length[1]|xss_clean' );
            $store_id = $data[ 'store_id' ];
            if ( $this -> form_validation -> run () == true ) {
                
                $info    = array (
                    'department_id'   => $data[ 'department-id' ],
                    'item'            => $data[ 'item' ],
                    'threshold'       => $data[ 'threshold' ],
                    'type'            => $data[ 'type' ],
                    'regent_quantity' => $data[ 'regent_quantity' ],
                );
                $where   = array (
                    'id' => $store_id
                );
                $updated = $this -> StoreModel -> update ( $info, $where );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Store updated' );
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
         * Add store stock main page
         * -------------------------
         */
        
        public function add_stock () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_store_stock' )
                $this -> do_add_store_stock ( $_POST );
            
            $title = site_name . ' - Add Store Stock';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'suppliers' ]     = $this -> SupplierModel -> get_child_suppliers ( store_supplier );
            $data[ 'lab_suppliers' ] = $this -> SupplierModel -> get_child_suppliers ( lab_suppliers );
            $data[ 'stores' ]        = $this -> StoreModel -> get_all_store ();
            $this -> load -> view ( '/store/add-stock', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add more store stock
         * -------------------------
         */
        
        public function add_more_store_stock () {
            $data[ 'added' ]  = $this -> input -> post ( 'added', true );
            $data[ 'stores' ] = $this -> StoreModel -> get_all_store ();
            $this -> load -> view ( '/store/add-more-store-stock', $data );
        }
        
        /**
         * -------------------------
         * validate invoice number
         * by supplier id
         * -------------------------
         */
        
        public function validate_invoice_number () {
            $supplier_id = $this -> input -> post ( 'supplier_id', true );
            $invoice     = $this -> input -> post ( 'invoice', true );
            if ( !empty( trim ( $supplier_id ) ) and is_numeric ( $supplier_id ) and !empty( trim ( $invoice ) ) ) {
                $info   = array (
                    'supplier_id' => $supplier_id,
                    'invoice'     => $invoice
                );
                $exists = $this -> StoreModel -> validate_invoice_number ( $info );
                if ( $exists )
                    echo 'true';
                else
                    echo 'false';
            }
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add store stock
         * -------------------------
         */
        
        public function do_add_store_stock ( $POST ) {
            $data         = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $store_id     = $data[ 'store_id' ];
            $account_head = get_account_head ( $data[ 'supplier_id' ] );
            
            if ( count ( $store_id ) > 0 ) {
                foreach ( $store_id as $key => $value ) {
                    $info = array (
                        'user_id'     => get_logged_in_user_id (),
                        'supplier_id' => $data[ 'supplier_id' ],
                        'store_id'    => $value,
                        'invoice'     => $data[ 'invoice' ],
                        'batch'       => $data[ 'batch' ][ $key ],
                        'expiry'      => date ( 'Y-m-d', strtotime ( $data[ 'expiry' ][ $key ] ) ),
                        'quantity'    => $data[ 'quantity' ][ $key ],
                        'price'       => $data[ 'price' ][ $key ],
                        'discount'    => $data[ 'discount' ][ $key ],
                        'net_price'   => $data[ 'net_price' ][ $key ],
                        'date_added'  => date ( 'Y-m-d', strtotime ( $data[ 'date_added' ] ) ) . ' ' . date ( 'H:i:s' ),
                    );
                    $this -> StoreModel -> add_stock ( $info );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'invoice'      => $data[ 'invoice' ],
                        'action'       => 'store_stock_added',
                        'log'          => json_encode ( $info ),
                        'after_update' => ' ',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'store_stock_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
                $discount = array (
                    'user_id'    => get_logged_in_user_id (),
                    'invoice'    => $data[ 'invoice' ],
                    'discount'   => $data[ 'grand_total_discount' ],
                    'total'      => $data[ 'grand_total' ],
                    'date_added' => current_date_time ()
                );
                $this -> StoreModel -> add_stock_discount ( $discount );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'invoice'      => $data[ 'invoice' ],
                    'action'       => 'store_stock_total_added',
                    'log'          => json_encode ( $discount ),
                    'after_update' => ' ',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'store_stock_logs', $log );
                
                /***********END LOG*************/
                
                $ledger_description = 'Store stock added. Invoice# ' . $data[ 'invoice' ];
                $ledger             = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => $data[ 'supplier_id' ],
                    'stock_id'         => $data[ 'invoice' ],
                    'invoice_id'       => $data[ 'invoice' ],
                    'payment_mode'     => 'none',
                    'paid_via'         => '',
                    'transaction_type' => 'debit',
                    'credit'           => 0,
                    'debit'            => $data[ 'grand_total' ],
                    'description'      => $ledger_description,
                    'trans_date'       => date ( 'Y-m-d' ),
                    'date_added'       => current_date_time ()
                );
                $this -> AccountModel -> add_ledger ( $ledger );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'invoice'      => $data[ 'invoice' ],
                    'action'       => 'store_stock_ledger_added',
                    'log'          => json_encode ( $ledger ),
                    'after_update' => ' ',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'store_stock_logs', $log );
                
                /***********END LOG*************/
                
                $mm_ledger = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => $account_head -> parent_id == store_supplier ? store_inventory : lab_inventory,
                    'stock_id'         => $data[ 'invoice' ],
                    'invoice_id'       => $data[ 'invoice' ],
                    'payment_mode'     => 'none',
                    'paid_via'         => '',
                    'transaction_type' => 'credit',
                    'credit'           => $data[ 'grand_total' ],
                    'debit'            => 0,
                    'description'      => $ledger_description,
                    'trans_date'       => date ( 'Y-m-d' ),
                    'date_added'       => current_date_time ()
                );
                $this -> AccountModel -> add_ledger ( $mm_ledger );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'invoice'      => $data[ 'invoice' ],
                    'action'       => 'store_stock_mm_ledger_added',
                    'log'          => json_encode ( $mm_ledger ),
                    'after_update' => ' ',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'store_stock_logs', $log );
                
                /***********END LOG*************/
                
                $print = '<strong><a href="' . base_url ( '/invoices/store-stock-invoice?invoice=' . $data[ 'invoice' ] ) . '" target="_blank">Print</a></strong>';
                $this -> session -> set_flashdata ( 'response', 'Success! Stock added. ' . $print );
                return redirect ( base_url ( '/store/add-stock' ) );
            }
        }
        
        /**
         * -------------------------
         * Store stock main page
         * -------------------------
         */
        
        public function stock () {
            
            $store_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $store_id ) ) or !is_numeric ( $store_id ) or $store_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $title = site_name . ' - Store Stock';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'stocks' ] = $this -> StoreModel -> get_stock ( $store_id );
            $this -> load -> view ( '/store/stock', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * delete stock
         * stock will be deleted
         * -------------------------
         */
        
        public function delete_stock () {
            $stock_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $stock_id ) ) and $stock_id > 0 and is_numeric ( $stock_id ) ) {
                $stock = get_store_stock ( $stock_id );
                if ( !empty( $stock_id ) ) {
                    $net_price = $stock -> net_price;
                    //				$updated = $this -> MedicineModel -> update_supplier_ledger($net_price, $stock -> invoice);
                    //				if ($updated) {
                    $this -> StoreModel -> delete_stock ( $stock_id );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'invoice'      => $stock_id,
                        'action'       => 'store_stock_deleted',
                        'log'          => json_encode ( $stock_id ),
                        'after_update' => ' ',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'store_stock_logs', $log );
                    
                    /***********END LOG*************/
                    
                    $this -> session -> set_flashdata ( 'response', 'Success! Stock has been deleted.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                    //				}
                    //				else {
                    //					$this -> session -> set_flashdata('error', 'Error! Supplier ledger is not updated.');
                    //					return redirect($_SERVER['HTTP_REFERER']);
                    //				}
                }
            }
        }
        
        /**
         * -------------------------
         * Sale Store stock main page
         * -------------------------
         */
        
        public function sale () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_sale_store_stock' )
                $this -> do_sale_store_stock ( $_POST );
            
            $title = site_name . ' - Sale Store Stock';
            $this -> header ( $title );
            $this -> sidebar ();
//            $data[ 'stores' ]        = $this -> StoreModel -> get_all_store ();
            $data[ 'users' ]         = $this -> UserModel -> get_active_users ();
            $data[ 'departments' ]   = $this -> MemberModel -> get_departments ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_child_account_heads ( administrative_expenses );
            $this -> load -> view ( '/store/sale', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * get user departments
         * -------------------------
         */
        
        public function get_department_users () {
            
            $department_id = $_POST[ 'department_id' ];
            if ( isset( $department_id ) and $department_id > 0 ) {
                //			$data['users'] = $this -> UserModel -> get_active_users_by_department($department_id);
                $data[ 'users' ]         = $this -> UserModel -> get_active_users ();
                $data[ 'department_id' ] = $department_id;
                $this -> load -> view ( '/store/users', $data );
            }
        }
        
        public function get_department_store_items () {
            
            $department_id = $this -> input -> get ( 'department_id' );
            if ( isset( $department_id ) and $department_id > 0 ) {
                $data[ 'items' ]         = $this -> StoreModel -> get_department_store_items ( $department_id );
                $data[ 'department_id' ] = $department_id;
                $this -> load -> view ( '/store/items', $data );
            }
        }
        
        /**
         * -------------------------
         * add more sale services
         * -------------------------
         */
        
        public function add_more_store_sale () {
            
            $data[ 'added' ]         = $_POST[ 'added' ];
            $data[ 'stores' ]        = $this -> StoreModel -> get_all_store ();
            $data[ 'users' ]         = $this -> UserModel -> get_active_users ();
            $data[ 'departments' ]   = $this -> MemberModel -> get_departments ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_child_account_heads ( administrative_expenses );
            $this -> load -> view ( '/store/add_more_store_sale', $data );
        }
        
        /**
         * -------------------------
         * Sales Store main page
         * -------------------------
         */
        
        public function sales () {
            $title = site_name . ' - Store Issued Items';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'store/sales' );
            $total_row                      = $this -> StoreModel -> count_issued_items ();
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
            
            $data[ 'stores' ]      = $this -> StoreModel -> get_all_store ();
            $data[ 'users' ]       = $this -> UserModel -> get_active_users ();
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $data[ 'items' ]       = $this -> StoreModel -> get_issued_items ( $config[ "per_page" ], $offset );
            $str_links             = $this -> pagination -> create_links ();
            $data[ "links" ]       = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/store/sales', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Edit Sold Store main page
         * -------------------------
         */
        
        public function edit_issued_item () {
            
            $item_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $item_id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_store_sale' )
                $this -> do_update_store_sale ();
            
            $title = site_name . ' - Edit Issued Items';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'items' ] = $this -> StoreModel -> get_stock_sales_by_sale_id ( $item_id );
            $this -> load -> view ( '/store/edit_issued_item', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Delete Sold Store main page
         * -------------------------
         */
        
        public function delete_issued_item () {
            
            $item_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $item_id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'items' ] = $this -> StoreModel -> get_stock_sales_by_sale_id ( $item_id );
            $this -> StoreModel -> delete_issued_items_by_sale ( $item_id );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'invoice'      => $item_id,
                'action'       => 'store_issued_item_deleted',
                'log'          => json_encode ( $data[ 'items' ] ),
                'after_update' => ' ',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'store_stock_logs', $log );
            
            /***********END LOG*************/
            
            
            $department = $this -> MemberModel -> get_department_by_id ( $data[ 'items' ][ 0 ] -> department_id );
            $where      = array (
                'acc_head_id' => $department -> account_head_id,
                'stock_id'    => $data[ 'items' ][ 0 ] -> sale_id,
                'invoice_id'  => $data[ 'items' ][ 0 ] -> sale_id,
            );
            $this -> AccountModel -> delete_ledger ( $where );
            
            $where = array (
                'acc_head_id' => store_inventory,
                'stock_id'    => $data[ 'items' ][ 0 ] -> sale_id,
                'invoice_id'  => $data[ 'items' ][ 0 ] -> sale_id,
            );
            $this -> AccountModel -> delete_ledger ( $where );
            
            $this -> session -> set_flashdata ( 'response', 'Success! Sale delete.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * get store batches
         * -------------------------
         */
        
        public function get_store_batch () {
            $store_id       = $this -> input -> post ( 'store_id', true );
            $selected_batch = $this -> input -> post ( 'selected_batch', true );
            $batch          = explode ( ',', $selected_batch );
            $stock          = count ( array_filter ( $batch ) ) > 0 ? array_filter ( $batch ) : '0';
            if ( !empty( trim ( $store_id ) ) and $store_id > 0 and is_numeric ( $store_id ) ) {
                $data[ 'row' ]     = $_POST[ 'row' ];
                $data[ 'stock' ]   = $stock;
                $data[ 'batches' ] = $this -> StoreModel -> get_stock ( $store_id );
                $this -> load -> view ( '/store/batch-dropdown', $data );
            }
        }
        
        /**
         * -------------------------
         * get store stock available qty
         * deduct total qty from sold
         * -------------------------
         */
        
        public function get_store_stock_available_quantity_return () {
            $stock_id = $this -> input -> post ( 'stock_id', true );
            if ( !empty( trim ( $stock_id ) ) and $stock_id > 0 and is_numeric ( $stock_id ) ) {
                $stock = $this -> StoreModel -> get_store_stock ( $stock_id );
                $this -> StoreModel -> lock_stock ( $stock -> store_id, $stock_id );
                $disposed  = get_store_disposed_quantity ( $stock -> store_id );
                $available = $stock -> quantity - get_stock_sold_quantity ( $stock_id ) - $disposed;
                echo max ( $available, 0 );
            }
        }
        
        /**
         * -------------------------
         * @param $POST
         * do sale store
         * -------------------------
         */
        
        public function do_sale_store_stock ( $POST ) {
            $data          = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $department_id = $data[ 'department_id' ];
            $sold_to       = $data[ 'sold_to' ];
            $store_id      = $data[ 'store_id' ];
            $sale_id       = unique_id ( 4 );
            $total         = 0;
            
            if ( isset( $store_id ) and count ( array_filter ( $store_id ) ) > 0 ) {
                foreach ( $store_id as $key => $value ) {
                    if ( !empty( trim ( $value ) ) and is_numeric ( $value ) and $value > 0 ) {
                        $store_info = get_store_stock ( $data[ 'stock_id' ][ $key ] );
                        $info       = array (
                            'sale_id'       => $sale_id,
                            'sold_by'       => get_logged_in_user_id (),
                            'department_id' => $department_id,
                            'account_head'  => $data[ 'account_head' ][ $key ],
                            'sold_to'       => $sold_to,
                            'store_id'      => $value,
                            'stock_id'      => $data[ 'stock_id' ][ $key ],
                            'quantity'      => $data[ 'quantity' ][ $key ],
                            'date_added'    => date ( 'Y-m-d', strtotime ( $data[ 'issue_date' ] ) ) . ' ' . date ( 'H:i:s' ),
                        );
                        $id         = $this -> StoreModel -> sale_stock ( $info );
                        
                        /***********LOGS*************/
                        $log = array (
                            'user_id'      => get_logged_in_user_id (),
                            'sale_id'      => $sale_id,
                            'action'       => 'store_sale_added',
                            'log'          => json_encode ( $info ),
                            'after_update' => ' ',
                            'date_added'   => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'store_sale_logs', $log );
                        /***********END LOG*************/
                        
                        $total = $total + $data[ 'quantity' ][ $key ] * $store_info -> price;
                    }
                }
                
                $acc_exists = get_account_head ( store_supplier );
                
                if ( !empty( $acc_exists ) ) {
                    $ledger_description = 'Store sale.';
                    $ledger             = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => store_supplier,
                        'stock_id'         => store_supplier,
                        'invoice_id'       => store_supplier,
                        'payment_mode'     => 'none',
                        'paid_via'         => '',
                        'transaction_type' => 'debit',
                        'credit'           => 0,
                        'debit'            => $total,
                        'description'      => $ledger_description,
                        'trans_date'       => date ( 'Y-m-d' ),
                        'date_added'       => current_date_time ()
                    );
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    /***********LOGS*************/
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'store_sale_ledger_added',
                        'log'          => json_encode ( $ledger ),
                        'after_update' => ' ',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'store_sale_logs', $log );
                    /***********END LOG*************/
                }
                
                $user               = get_user ( $sold_to );
                $department         = $this -> MemberModel -> get_department_by_id ( $department_id );
                $ledger_description = 'Store stock issued to ' . $user -> name . '. Issuance ID# ' . $sale_id;
                $ledger             = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => $department -> account_head_id,
                    'stock_id'         => $sale_id,
                    'invoice_id'       => $sale_id,
                    'payment_mode'     => 'none',
                    'paid_via'         => '',
                    'transaction_type' => 'credit',
                    'credit'           => $total,
                    'debit'            => 0,
                    'description'      => $ledger_description,
                    'trans_date'       => date ( 'Y-m-d' ),
                    'date_added'       => current_date_time ()
                );
                $this -> AccountModel -> add_ledger ( $ledger );
                
                $ledger = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => store_inventory,
                    'stock_id'         => $sale_id,
                    'invoice_id'       => $sale_id,
                    'payment_mode'     => 'none',
                    'paid_via'         => '',
                    'transaction_type' => 'debit',
                    'credit'           => 0,
                    'debit'            => $total,
                    'description'      => $ledger_description,
                    'trans_date'       => date ( 'Y-m-d' ),
                    'date_added'       => current_date_time ()
                );
                $this -> AccountModel -> add_ledger ( $ledger );
                
                $this -> StoreModel -> clear_lock ();
                
                $print = '<strong><a href="' . base_url ( '/invoices/store-issuance-invoice?sale_id=' . $sale_id ) . '" target="_blank">Print</a></strong>';
                $this -> session -> set_flashdata ( 'response', 'Success! Sale added. ' . $print );
            }
            return redirect ( base_url ( '/store/sale' ) );
        }
        
        /**
         * -------------------------
         * do update sale store
         * -------------------------
         */
        
        public function do_update_store_sale () {
            $quantity = $_POST[ 'quantity' ];
            $id       = $_POST[ 'id' ];
            $sale_id  = $_POST[ 'sale_id' ];
            if ( isset( $id ) and count ( $id ) > 0 ) {
                foreach ( $id as $key => $item ) {
                    $info  = array (
                        'quantity' => $quantity[ $key ],
                    );
                    $where = array (
                        'id' => $item
                    );
                    $this -> StoreModel -> do_update_store_sale ( $info, $where );
                }
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => $sale_id,
                    'action'       => 'store_sale_updated',
                    'log'          => ' ',
                    'after_update' => json_encode ( $info ),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'store_sale_logs', $log );
                
                /***********END LOG*************/
                
                //                $store_info = get_store_stock ( $_POST[ 'stock_id' ] );
                //                $ledger_where = array (
                //                    'acc_head_id' => $_POST[ 'account_head' ],
                //                    'stock_id'    => $sale_id,
                //                    'invoice_id'  => $sale_id,
                //                );
                //                $ledger = array (
                //                    'credit' => $quantity * $store_info -> price,
                //                );
                //                $this -> AccountModel -> update_general_ledger ( $ledger, $ledger_where );
                
                /***********LOGS*************/
                
                //                $log = array (
                //                    'user_id'      => get_logged_in_user_id (),
                //                    'sale_id'      => $sale_id,
                //                    'action'       => 'store_sale__ledger_updated',
                //                    'log'          => ' ',
                //                    'after_update' => json_encode ( $ledger ),
                //                    'date_added'   => current_date_time ()
                //                );
                //                $this -> load -> model ( 'LogModel' );
                //                $this -> LogModel -> create_log ( 'store_sale_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Sale updated.' );
            }
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * Search Sale Store stock main page
         * -------------------------
         */
        
        public function search () {
            $title = site_name . ' - Search Sale';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'users' ]       = $this -> UserModel -> get_all_users ();
            $data[ 'sales' ]       = $this -> StoreModel -> get_sales ();
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $this -> load -> view ( '/store/search', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * delete sale store items
         * -------------------------
         */
        
        public function delete_store_sale () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $where = array (
                'id' => $sale_id
            );
            
            $deleted = $this -> StoreModel -> delete_store_sale ( $where );
            if ( $deleted ) {
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => $sale_id,
                    'action'       => 'store_sale_deleted',
                    'log'          => ' ',
                    'after_update' => json_encode ( $sale_id ),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'store_sale_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Sold item deleted' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * get user department
         * by user id
         * -------------------------
         */
        
        public function get_user_department () {
            $user_id = $this -> input -> post ( 'user_id', true );
            if ( !empty( trim ( $user_id ) ) and $user_id > 0 and is_numeric ( $user_id ) ) {
                $user          = $this -> UserModel -> get_user_by_id ( $user_id );
                $department_id = $user -> department_id;
                echo $department_id > 0 ? $department_id : 0;
            }
        }
        
        /**
         * -------------------------
         * get department par level
         * by department id
         * -------------------------
         */
        
        public function get_department_par_level () {
            $department_id = $this -> input -> post ( 'department', true );
            $store_id      = $this -> input -> post ( 'store_id', true );
            $row           = $this -> input -> post ( 'row', true );
            if ( !empty( trim ( $department_id ) ) and $department_id > 0 and is_numeric ( $department_id ) ) {
                $par_level = $this -> StoreModel -> get_par_level_by_dept_item ( $department_id, $store_id );
                if ( $par_level and !empty( $par_level ) ) {
                    $allowed = $par_level -> allowed;
                    $sold    = $this -> StoreModel -> get_issued_items_by_dept_item_id_date ( $department_id, $store_id );
                    echo $allowed - $sold;
                }
                else {
                    echo '0';
                }
            }
            else {
                echo '0';
            }
        }
        
        /**
         * -------------------------
         * Requisition requests main page
         * -------------------------
         */
        
        public function requests () {
            $title = site_name . ' - Requisition Requests';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'requests' ] = $this -> StoreModel -> get_requests ();
            $this -> load -> view ( '/store/requests', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Requisition demands main page
         * -------------------------
         */
        
        public function demands () {
            $title = site_name . ' - Requisition Demands';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'requests' ] = $this -> RequisitionModel -> get_requisition_demands_store ();
            $this -> load -> view ( '/store/requisitions-demands', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Edit store stock main page
         * -------------------------
         */
        
        public function edit_stock () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_store_stock' )
                $this -> do_update_store_stock ();
            
            $title = site_name . ' - Edit Store Stock';
            $this -> header ( $title );
            $this -> sidebar ();
            if ( isset( $_REQUEST[ 'invoice' ] ) and !empty( trim ( $_REQUEST[ 'invoice' ] ) ) ) {
                $data[ 'stock' ]      = $this -> StoreModel -> search_stock ();
                $data[ 'stock_info' ] = $this -> StoreModel -> get_stock_info ();
            }
            else {
                $data[ 'stock' ]      = array ();
                $data[ 'stock_info' ] = array ();
            }
            $this -> load -> view ( '/store/edit-stock', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * update store stock
         * -------------------------
         */
        
        public function do_update_store_stock () {
            $invoice              = $_POST[ 'invoice_number' ];
            $supplier_id          = $_POST[ 'supplier_id' ];
            $store_id             = $_POST[ 'store_id' ];
            $batch                = $_POST[ 'batch' ];
            $expiry               = $_POST[ 'expiry' ];
            $quantity             = $_POST[ 'quantity' ];
            $price                = $_POST[ 'price' ];
            $discount             = $_POST[ 'discount' ];
            $net_price            = $_POST[ 'net_price' ];
            $grand_total_discount = $_POST[ 'grand_total_discount' ];
            $grand_total          = $_POST[ 'grand_total' ];
            $stock_id             = $_POST[ 'stock_id' ];
            
            if ( isset( $invoice ) and !empty( trim ( $invoice ) ) and isset( $supplier_id ) and !empty( trim ( $supplier_id ) ) ) {
                if ( count ( $store_id ) > 0 ) {
                    $this -> StoreModel -> update_store_stock_net_bill ( $invoice, $grand_total_discount, $grand_total );
                    foreach ( $store_id as $key => $value ) {
                        if ( isset( $stock_id[ $key ] ) ) {
                            $info  = array (
                                'batch'     => $batch[ $key ],
                                'expiry'    => date ( 'Y-m-d', strtotime ( $expiry[ $key ] ) ),
                                'quantity'  => $quantity[ $key ],
                                'price'     => $price[ $key ],
                                'discount'  => $discount[ $key ],
                                'net_price' => $net_price[ $key ],
                            );
                            $where = array (
                                'supplier_id' => $supplier_id,
                                'store_id'    => $value,
                                'invoice'     => $invoice,
                            );
                            $this -> StoreModel -> update_store_stock ( $info, $where );
                            
                            /***********LOGS*************/
                            
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'invoice'      => $_POST[ 'invoice_number' ],
                                'action'       => 'store_stock_updated',
                                'log'          => ' ',
                                'after_update' => json_encode ( $info ),
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'store_stock_logs', $log );
                            
                            /***********END LOG*************/
                            
                        }
                        else {
                            $info = array (
                                'user_id'     => get_logged_in_user_id (),
                                'supplier_id' => $_POST[ 'supplier_id' ],
                                'store_id'    => $value,
                                'invoice'     => $invoice,
                                'batch'       => $_POST[ 'batch' ][ $key ],
                                'expiry'      => date ( 'Y-m-d', strtotime ( $_POST[ 'expiry' ][ $key ] ) ),
                                'quantity'    => $_POST[ 'quantity' ][ $key ],
                                'price'       => $_POST[ 'price' ][ $key ],
                                'discount'    => $_POST[ 'discount' ][ $key ],
                                'net_price'   => $_POST[ 'net_price' ][ $key ],
                                'date_added'  => date ( 'Y-m-d', strtotime ( $_POST[ 'date_added' ] ) ) . ' ' . date ( 'H:i:s' ),
                            );
                            $this -> StoreModel -> add_stock ( $info );
                            
                            /***********LOGS*************/
                            
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'invoice'      => $_POST[ 'invoice_number' ],
                                'action'       => 'store_stock_added',
                                'log'          => json_encode ( $info ),
                                'after_update' => '',
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'store_stock_logs', $log );
                            
                            /***********END LOG*************/
                            
                        }
                    }
                    
                    $stock        = $this -> StoreModel -> get_stock_supplier_by_invoice ( $invoice );
                    $account_head = get_account_head ( $stock -> supplier_id );
                    
                    $ledger = array (
                        'user_id' => get_logged_in_user_id (),
                        'credit'  => 0,
                        'debit'   => $grand_total
                    );
                    
                    $where = array (
                        'acc_head_id' => $stock -> supplier_id,
                        'stock_id'    => $stock -> invoice,
                        'invoice_id'  => $stock -> invoice
                    );
                    $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                    
                    $ledger = array (
                        'user_id'    => get_logged_in_user_id (),
                        'credit'     => $grand_total,
                        'debit'      => 0,
                        'date_added' => current_date_time ()
                    );
                    $where  = array (
                        'acc_head_id' => $account_head -> parent_id == store_supplier ? store_inventory : lab_inventory,
                        'stock_id'    => $stock -> invoice,
                        'invoice_id'  => $stock -> invoice
                    );
                    $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                    
                    $this -> session -> set_flashdata ( 'response', 'Success! Stock updated' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * update store stock
         * -------------------------
         */
        
        public function delete_individual_stock () {
            $stock_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $stock_id ) ) or $stock_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            $stock   = $this -> StoreModel -> get_individual_stock ( $stock_id );
            $deleted = $this -> StoreModel -> delete_individual_stock ( $stock_id );
            if ( $deleted ) {
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'invoice'      => $stock_id,
                    'action'       => 'store_stock_item_deleted',
                    'log'          => json_encode ( $stock_id ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'store_stock_logs', $log );
                
                /***********END LOG*************/
                
                $price   = $stock -> net_price;
                $invoice = $stock -> invoice;
                $this -> StoreModel -> update_store_stock_ledger ( $price, $invoice, store_supplier );
                $this -> StoreModel -> update_store_stock_total ( $price, $invoice );
            }
            $this -> session -> set_flashdata ( 'response', 'Success! Store stock updated' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * All store fix assets main page
         * -------------------------
         */
        
        public function store_fix_assets () {
            
            $title = site_name . ' - All Store - Fix Assets';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'assets' ] = $this -> StoreModel -> get_store_fix_assets ();
            $this -> load -> view ( '/store/store-fix-assets', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add store fix assets main page
         * -------------------------
         */
        
        public function add_store_fix_assets () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_store_fix_assets' )
                $this -> do_add_store_fix_assets ();
            
            $title = site_name . ' - Add Store - Fix Assets';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'items' ]       = $this -> StoreModel -> get_fix_store_items ();
            $data[ 'assets' ]      = $this -> AccountModel -> get_child_account_heads ( fixed_assets );
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $this -> load -> view ( '/store/add-store-fix-assets', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * do add store fix assets
         * -------------------------
         */
        
        public function do_add_store_fix_assets () {
            $store_id            = $this -> input -> post ( 'store_id' );
            $account_head_id     = $this -> input -> post ( 'account_head_id' );
            $department_id       = $this -> input -> post ( 'department_id' );
            $invoice             = $this -> input -> post ( 'invoice' );
            $value               = $this -> input -> post ( 'value' );
            $description         = $this -> input -> post ( 'description' );
            $date_added          = $this -> input -> post ( 'date_added' );
            $location            = $this -> input -> post ( 'location' );
            $quantity            = $this -> input -> post ( 'quantity' );
            $depreciation        = $this -> input -> post ( 'depreciation' );
            $depreciation_charge = $this -> input -> post ( 'depreciation-charge' );
            $code                = $this -> StoreModel -> generate_code ();
            
            $info     = array (
                'user_id'             => get_logged_in_user_id (),
                'store_id'            => $store_id,
                'account_head_id'     => $account_head_id,
                'department_id'       => $department_id,
                'invoice'             => $invoice,
                'value'               => $value,
                'description'         => $description,
                'location'            => $location,
                'code'                => $code,
                'quantity'            => $quantity,
                'depreciation'        => $depreciation,
                'depreciation_charge' => $depreciation_charge,
                'purchase_date'       => date ( 'Y-m-d', strtotime ( $date_added ) ),
            );
            $asset_id = $this -> StoreModel -> do_add_store_fix_assets ( $info );
            $this -> add_fix_assets_stock ();
            $store_acc_head_id = $this -> add_store_item_account_head ( $asset_id );
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'invoice'      => $invoice,
                'action'       => 'store_fix_assets_added',
                'log'          => json_encode ( $info ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'store_stock_logs', $log );
            
            /***********END LOG*************/
            
            $ledger_description = 'Store fix assets added. ID# ' . $asset_id;
            $ledger             = array (
                'user_id'            => get_logged_in_user_id (),
                'acc_head_id'        => $account_head_id,
                'stock_id'           => $invoice,
                'invoice_id'         => $invoice,
                'store_fix_asset_id' => $asset_id,
                'payment_mode'       => 'none',
                'paid_via'           => '',
                'transaction_type'   => 'debit',
                'credit'             => '0',
                'debit'              => $value,
                'description'        => $ledger_description,
                'trans_date'         => date ( 'Y-m-d' ),
                'date_added'         => current_date_time ()
            );
            $this -> AccountModel -> add_ledger ( $ledger );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'invoice'      => $_POST[ 'invoice' ],
                'action'       => 'store_fix_assets_ledger_added',
                'log'          => json_encode ( $ledger ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'store_stock_logs', $log );
            
            /***********END LOG*************/
            
            $redirectInfo = base_url ( '/accounts/add-transactions-multiple?amount=' . abs ( $value ) . '&date=' . $date_added . '&acc-head-id=' . $store_acc_head_id . '&trigger-change=false' );
            
            $this -> session -> set_flashdata ( 'response', 'Success! Store fix assets added.' );
            $this -> session -> set_flashdata ( 'redirect_url', $redirectInfo );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        public function add_store_item_account_head ( $item_id ) {
            $asset        = $this -> StoreModel -> get_fix_asset_by_id ( $item_id );
            $item         = $this -> StoreModel -> get_store_by_id ( $asset -> store_id );
            $account_head = get_account_head ( CONSULTANCY_SHARES_DOCTOR );
            
            $info = array (
                'title'          => $item -> item . ' (' . $asset -> code . ')',
                'parent_id'      => $asset -> account_head_id,
                'role_id'        => $account_head -> role_id,
                'store_id'       => $item_id,
                'doctor_id'      => 0,
                'panel_id'       => 0,
                'contact_person' => null,
                'phone'          => null,
                'status'         => '1',
                'type'           => 14,
                'description'    => $asset -> description,
                'date_added'     => current_date_time (),
            );
            return $this -> AccountModel -> insert ( $info );
        }
        
        /**
         * -------------------------
         * Add store fix assets main page
         * -------------------------
         */
        
        public function edit_store_fix_assets () {
            
            $asset_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $asset_id ) ) or !is_numeric ( $asset_id ) or $asset_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_store_fix_assets' )
                $this -> do_edit_store_fix_assets ();
            
            $title = site_name . ' - Edit Store - Fix Assets';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'items' ]       = $this -> StoreModel -> get_fix_store_items ();
            $data[ 'assets' ]      = $this -> AccountModel -> get_child_account_heads ( fixed_assets );
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $data[ 'fix_asset' ]   = $this -> StoreModel -> get_fix_asset_by_id ( $asset_id );
            $this -> load -> view ( '/store/edit-store-fix-assets', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * do edit store fix assets
         * -------------------------
         */
        
        public function do_edit_store_fix_assets () {
            $store_id            = $this -> input -> post ( 'store_id' );
            $account_head_id     = $this -> input -> post ( 'account_head_id' );
            $department_id       = $this -> input -> post ( 'department_id' );
            $invoice             = $this -> input -> post ( 'invoice' );
            $value               = $this -> input -> post ( 'value' );
            $description         = $this -> input -> post ( 'description' );
            $date_added          = $this -> input -> post ( 'date_added' );
            $asset_id            = $this -> input -> post ( 'asset_id' );
            $location            = $this -> input -> post ( 'location' );
            $depreciation        = $this -> input -> post ( 'depreciation' );
            $depreciation_charge = $this -> input -> post ( 'depreciation-charge' );
            
            $info     = array (
                'store_id'            => $store_id,
                'account_head_id'     => $account_head_id,
                'department_id'       => $department_id,
                'invoice'             => $invoice,
                'value'               => $value,
                'description'         => $description,
                'location'            => $location,
                'depreciation'        => $depreciation,
                'depreciation_charge' => $depreciation_charge,
                'purchase_date'       => date ( 'Y-m-d', strtotime ( $date_added ) ),
            );
            $where    = array (
                'id' => $asset_id
            );
            $asset_id = $this -> StoreModel -> update_store_fix_assets ( $info, $where );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'invoice'      => $_POST[ 'invoice' ],
                'action'       => 'store_fix_assets_updated',
                'log'          => ' ',
                'after_update' => json_encode ( $info ),
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'store_stock_logs', $log );
            
            /***********END LOG*************/
            
            $ledger       = array (
                'stock_id'   => $invoice,
                'invoice_id' => $invoice,
                'debit'      => $value,
            );
            $where_ledger = array (
                'store_fix_asset_id' => $asset_id,
            );
            $this -> AccountModel -> update_general_ledger ( $ledger, $where_ledger );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'invoice'      => $_POST[ 'invoice' ],
                'action'       => 'store_fix_assets_ledger_updated',
                'log'          => ' ',
                'after_update' => json_encode ( $ledger ),
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'store_stock_logs', $log );
            
            /***********END LOG*************/
            
            $this -> session -> set_flashdata ( 'response', 'Success! Store fix assets updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * Delete store fix assets main page
         * -------------------------
         */
        
        public function delete_store_fix_asset () {
            
            $asset_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $asset_id ) ) or !is_numeric ( $asset_id ) or $asset_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> StoreModel -> delete_store_fix_asset ( $asset_id );
            $this -> AccountModel -> delete_store_fix_asset ( $asset_id );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'invoice'      => $asset_id,
                'action'       => 'store_fix_assets_deleted',
                'log'          => json_encode ( $asset_id ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'store_stock_logs', $log );
            
            /***********END LOG*************/
            
            $this -> session -> set_flashdata ( 'response', 'Success! Store fix assets deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * validate store stock invoice number
         * -------------------------
         */
        
        public function validate_store_stock_invoice_number () {
            
            $invoice_number = $this -> input -> post ( 'invoice_number' );
            $valid          = $this -> StoreModel -> validate_store_stock_invoice_number ( $invoice_number );
            if ( !$valid )
                echo 'false';
            else
                echo 'true';
            
        }
        
        /**
         * -------------------------
         * store stock
         * -------------------------
         */
        
        public function store_stock () {
            $title = site_name . ' - Store Stock';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'stocks' ] = $this -> StoreModel -> get_store_stocks ();
            $this -> load -> view ( '/store/stocks', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * get store batches
         * -------------------------
         */
        
        public function add_store_item_for_issuance () {
            $store_id       = $this -> input -> get ( 'store_id', true );
            $selected_batch = $this -> input -> get ( 'selected_batch', true );
            $row            = $this -> input -> get ( 'row', true );
            $batch          = explode ( ',', $selected_batch );
            $stock          = count ( array_filter ( $batch ) ) > 0 ? array_filter ( $batch ) : '0';
            
            if ( !empty( trim ( $store_id ) ) and $store_id > 0 and is_numeric ( $store_id ) ) {
                $data[ 'row' ]     = $row;
                $data[ 'stock' ]   = $stock;
                $data[ 'batches' ] = $this -> StoreModel -> get_unlocked_stock ( $store_id );
                $data[ 'store' ]   = get_store_by_id ( $store_id, $batch );
                $this -> load -> view ( '/store/batch-dropdown', $data );
            }
        }
        
        public function load_store_item_for_stock () {
            $item_id = $this -> input -> get ( 'item_id', true );
            $row     = $this -> input -> get ( 'row', true );
            
            if ( !empty( trim ( $item_id ) ) and $item_id > 0 ) {
                $data[ 'row' ]   = $row;
                $data[ 'store' ] = get_store_by_id ( $item_id );
                $this -> load -> view ( '/store/add-store-stock-row', $data );
            }
        }
        
        public function clear_sale () {
            $this -> StoreModel -> clear_lock ();
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        public function get_locked_stock () {
            $data[ 'stores' ] = $this -> StoreModel -> get_locked_stock ();
            $this -> load -> view ( 'store/locked-stock', $data );
        }
        
        public function add_fix_assets_stock () {
            $info = array (
                'user_id'     => get_logged_in_user_id (),
                'supplier_id' => store_supplier,
                'store_id'    => $this -> input -> post ( 'store_id' ),
                'invoice'     => $this -> input -> post ( 'invoice' ),
                'batch'       => $this -> input -> post ( 'invoice' ) . '-' . rand (),
                'expiry'      => date ( 'Y-m-d', strtotime ( '+10 years' ) ),
                'quantity'    => $this -> input -> post ( 'quantity' ),
                'price'       => $this -> input -> post ( 'value' ),
                'discount'    => 0,
                'net_price'   => $this -> input -> post ( 'value' ),
                'date_added'  => date ( 'Y-m-d', strtotime ( $this -> input -> post ( 'date_added' ) ) ) . ' ' . date ( 'H:i:s' ),
            );
            $this -> StoreModel -> add_stock ( $info );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'invoice'      => $this -> input -> post ( 'invoice' ),
                'action'       => 'store_stock_added_fix_assets',
                'log'          => json_encode ( $info ),
                'after_update' => ' ',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'store_stock_logs', $log );
            
            /***********END LOG*************/
            
            $discount = array (
                'user_id'    => get_logged_in_user_id (),
                'invoice'    => $this -> input -> post ( 'invoice' ),
                'discount'   => 0,
                'total'      => 0,
                'date_added' => current_date_time ()
            );
            $this -> StoreModel -> add_stock_discount ( $discount );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'invoice'      => $this -> input -> post ( 'invoice' ),
                'action'       => 'store_stock_total_added_fix_assets',
                'log'          => json_encode ( $discount ),
                'after_update' => ' ',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'store_stock_logs', $log );
            
            /***********END LOG*************/
        }
        
        public function dispose_store_fix_asset ( $id ) {
            
            if ( is_item_disposed ( $id ) )
                return redirect ( base_url ( '/store/store-fix-assets' ) );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'dispose_store_fix_asset' )
                $this -> process_dispose_store_fix_asset ();
            
            $title = site_name . ' - Dispose Store Asset';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'items' ]                  = $this -> StoreModel -> get_fix_store_items ();
            $data[ 'assetInfo' ]              = $assetInfo = $this -> StoreModel -> get_store_fix_asset ( $id );
            $data[ 'assets' ]                 = $this -> AccountModel -> get_child_account_heads ( fixed_assets );
            $data[ 'departments' ]            = $this -> MemberModel -> get_departments ();
            $data[ 'total_accumulative_dep' ] = calculate_total_accumulative_depreciation ( $assetInfo );
            
            $this -> load -> view ( '/store/dispose-store-fix-asset', $data );
            $this -> footer ();
        }
        
        public function process_dispose_store_fix_asset () {
            
            $id                        = $this -> input -> post ( 'id' );
            $accumulative_depreciation = $this -> input -> post ( 'total-accumulative-depreciation' );
            $dispose_quantity          = $this -> input -> post ( 'dispose-quantity' );
            $dispose_value             = $this -> input -> post ( 'dispose-value' );
            $store_id                  = $this -> input -> post ( 'store-id' );
            $total_asset_value         = $this -> input -> post ( 'total-asset-value' );
            $disposed_account_head     = ( ( $total_asset_value - $accumulative_depreciation ) < $dispose_value ) ? GAIN_ON_DISPOSAL : LOSS_ON_DISPOSAL;
            $account_head              = get_account_head_by ( 'store_id', $id );
            $assetInfo                 = $this -> StoreModel -> get_store_fix_asset ( $id );
            $item                      = get_store ( $store_id );
            
            if ( is_item_disposed ( $id ) )
                return redirect ( base_url ( '/store/store-fix-assets' ) );
            
            $info       = array (
                'user_id'                   => get_logged_in_user_id (),
                'store_fix_asset_id'        => $id,
                'store_id'                  => $store_id,
                'quantity'                  => $dispose_quantity,
                'value'                     => $dispose_value,
                'accumulative_depreciation' => $accumulative_depreciation,
                'dispose_date'              => date ( 'Y-m-d' ),
            );
            $dispose_id = $this -> StoreModel -> dispose_store_fix_asset ( $info );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'invoice'      => $dispose_id,
                'action'       => 'store_fix_asset_disposed',
                'log'          => json_encode ( $info ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'store_stock_logs', $log );
            
            /***********END LOG*************/
            
            $redirectInfo = base_url ( '/accounts/add-transactions-multiple?amount=' . abs ( $total_asset_value ) . '&date=' . date ( 'Y-m-d' ) . '&trigger-change=false&total-asset-value=' . $total_asset_value . '&accumulative-depreciation=' . $accumulative_depreciation . '&disposed-value=' . $dispose_value . '&accounts=' . $account_head -> id . ',' . ACCUMULATED_DEPRECIATION . ',0,' . $disposed_account_head . '&asset-detail=' . $assetInfo -> code . ' - ' . $item -> item );
            
            $this -> session -> set_flashdata ( 'response', 'Success! Store fix asset disposed.' );
            return redirect ( $redirectInfo );
        }
        
        public function disposed_store_fix_assets () {
            
            $title = site_name . ' - Disposed Store Fix Assets';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'assets' ] = $this -> StoreModel -> get_disposed_store_fix_assets ();
            $this -> load -> view ( '/store/disposed-store-fix-assets', $data );
            $this -> footer ();
        }
    }