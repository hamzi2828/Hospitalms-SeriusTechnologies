<?php
    
    error_reporting ( E_ALL );
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    require_once APPPATH . 'Services/PharmacyService.php';
    
    class Medicines extends CI_Controller {
        
        /**
         * -------------------------
         * Medicines constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'MedicineModel' );
            $this -> load -> model ( 'SupplierModel' );
            $this -> load -> model ( 'PatientModel' );
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
         * medicines main page
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - Medicines';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            if ( isset( $_REQUEST[ 'medicine_name' ] ) and !empty( trim ( $_REQUEST[ 'medicine_name' ] ) ) )
                $limit = 100;
            else if ( isset( $_REQUEST[ 'generic' ] ) and !empty( trim ( $_REQUEST[ 'generic' ] ) ) and is_numeric ( $_REQUEST[ 'generic' ] ) > 0 )
                $limit = 100;
            else if ( isset( $_REQUEST[ 'form' ] ) and !empty( trim ( $_REQUEST[ 'form' ] ) ) and is_numeric ( $_REQUEST[ 'form' ] ) > 0 )
                $limit = 100;
            else
                $limit = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'medicines/index' );
            $total_row                      = $this -> MedicineModel -> count_medicines ();
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
            
            $data[ 'medicines' ] = $this -> MedicineModel -> get_all_medicines ( $config[ "per_page" ], $offset );
            $str_links           = $this -> pagination -> create_links ();
            $data[ "links" ]     = explode ( '&nbsp;', $str_links );
            $data[ 'generics' ]  = $this -> MedicineModel -> get_generics ();
            $data[ 'forms' ]     = $this -> MedicineModel -> get_forms ();
            $this -> load -> view ( '/medicines/index', $data );
            $this -> footer ();
        }
        
        public function medicines () {
            $title = site_name . ' - Medicines';
            $this -> header ( $title );
            $this -> sidebar ();
            
            $data[ 'medicines' ] = $this -> MedicineModel -> get_all_medicines ();
            $data[ 'generics' ]  = $this -> MedicineModel -> get_generics ();
            $data[ 'forms' ]     = $this -> MedicineModel -> get_forms ();
            $this -> load -> view ( '/medicines/medicines', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * medicines main page
         * -------------------------
         */
        
        public function test () {
            $title = site_name . ' - Medicines';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            if ( isset( $_REQUEST[ 'medicine_name' ] ) and !empty( trim ( $_REQUEST[ 'medicine_name' ] ) ) )
                $limit = 100;
            else if ( isset( $_REQUEST[ 'generic' ] ) and !empty( trim ( $_REQUEST[ 'generic' ] ) ) and is_numeric ( $_REQUEST[ 'generic' ] ) > 0 )
                $limit = 100;
            else if ( isset( $_REQUEST[ 'form' ] ) and !empty( trim ( $_REQUEST[ 'form' ] ) ) and is_numeric ( $_REQUEST[ 'form' ] ) > 0 )
                $limit = 100;
            else
                $limit = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'medicines/test' );
            $total_row                      = $this -> MedicineModel -> count_medicines ();
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
            
            $data[ 'medicines' ] = $this -> MedicineModel -> get_all_medicines ( $config[ "per_page" ], $offset );
            $str_links           = $this -> pagination -> create_links ();
            $data[ "links" ]     = explode ( '&nbsp;', $str_links );
            $data[ 'generics' ]  = $this -> MedicineModel -> get_generics ();
            $data[ 'forms' ]     = $this -> MedicineModel -> get_forms ();
            $this -> load -> view ( '/medicines/test', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * inactive medicines main page
         * -------------------------
         */
        
        public function inactive () {
            $title = site_name . ' - Inactive Medicines';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_inactive_medicines ();
            $this -> load -> view ( '/medicines/inactive', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add medicines page
         * -------------------------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_medicine' )
                $this -> do_add_medicine ( $_POST );
            
            $title = site_name . ' - Add Medicine';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'generics' ]      = $this -> MedicineModel -> get_generics ();
            $data[ 'forms' ]         = $this -> MedicineModel -> get_forms ();
            $data[ 'strengths' ]     = $this -> MedicineModel -> get_strengths ();
            $data[ 'manufacturers' ] = $this -> MedicineModel -> get_manufacturers ();
            $data[ 'packs' ]         = $this -> MedicineModel -> get_pack_sizes ();
            $this -> load -> view ( '/medicines/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * edit medicines page
         * -------------------------
         */
        
        public function edit () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_medicine' )
                $this -> do_edit_medicine ( $_POST );
            
            $medicine_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $medicine_id ) ) or $medicine_id < 1 or !is_numeric ( $medicine_id ) ) {
                return redirect ( base_url ( '/medicines/index' ) );
            }
            
            $title = site_name . ' - Edit Medicine';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicine' ]      = $this -> MedicineModel -> get_medicine ( $medicine_id );
            $data[ 'generics' ]      = $this -> MedicineModel -> get_generics ();
            $data[ 'forms' ]         = $this -> MedicineModel -> get_forms ();
            $data[ 'strengths' ]     = $this -> MedicineModel -> get_strengths ();
            $data[ 'manufacturers' ] = $this -> MedicineModel -> get_manufacturers ();
            $data[ 'packs' ]         = $this -> MedicineModel -> get_pack_sizes ();
            $this -> load -> view ( '/medicines/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add medicines
         * -------------------------
         */
        
        public function do_add_medicine ( $POST ) {
            
            $user_id = get_logged_in_user_id ();
            $data    = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'name', 'medicine name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'generic_id', 'generic', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'strength_id', 'strength', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'form_id', 'form', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'manufacturer_id', 'manufacturer', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'pack_size_id', 'pack size', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'threshold', 'threshold', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'tp_box', 'tp/box', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'quantity', 'quantity', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'tp_unit', 'tp/unit', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'sale_box', 'sale/box', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'sale_unit', 'sale/unit', 'required|trim|min_length[1]|numeric|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                $info   = array (
                    'user_id'         => $user_id,
                    'name'            => $data[ 'name' ],
                    'generic_id'      => $data[ 'generic_id' ],
                    'strength_id'     => $data[ 'strength_id' ],
                    'form_id'         => $data[ 'form_id' ],
                    'manufacturer_id' => $data[ 'manufacturer_id' ],
                    'pack_size_id'    => $data[ 'pack_size_id' ],
                    'tp_box'          => $data[ 'tp_box' ],
                    'quantity'        => $data[ 'quantity' ],
                    'tp_unit'         => $data[ 'tp_unit' ],
                    'sale_box'        => $data[ 'sale_box' ],
                    'sale_unit'       => $data[ 'sale_unit' ],
                    'type'            => $data[ 'type' ],
                    'threshold'       => $data[ 'threshold' ],
                    'date_added'      => current_date_time (),
                );
                $where  = array (
                    'name'        => $data[ 'name' ],
                    'generic_id'  => $data[ 'generic_id' ],
                    'form_id'     => $data[ 'form_id' ],
                    'strength_id' => $data[ 'strength_id' ],
                );
                $exists = $this -> MedicineModel -> check_if_medicine_already_added ( $where );
                if ( !$exists ) {
                    $medicine_id = $this -> MedicineModel -> add ( $info );
                    if ( $medicine_id > 0 ) {
                        $this -> session -> set_flashdata ( 'response', 'Medicine added.' );
                    }
                    else {
                        $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    }
                    return redirect ( base_url ( '/medicines/add?active=false&settings=pharmacy' ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Medicine already exists.' );
                    return redirect ( base_url ( '/medicines/add?active=false&settings=pharmacy' ) );
                }
            }
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit medicines
         * -------------------------
         */
        
        public function do_edit_medicine ( $POST ) {
            $user_id     = get_logged_in_user_id ();
            $data        = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $medicine_id = $data[ 'medicine_id' ];
            if ( empty( trim ( $medicine_id ) ) or $medicine_id < 1 or !is_numeric ( $medicine_id ) ) {
                return redirect ( base_url ( '/medicines/index' ) );
            }
            $this -> form_validation -> set_rules ( 'name', 'medicine name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'threshold', 'threshold', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'tp_box', 'tp/box', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'quantity', 'quantity', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'tp_unit', 'tp/unit', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'sale_box', 'sale/box', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'sale_unit', 'sale/unit', 'required|trim|min_length[1]|numeric|xss_clean' );
            
            if ( $this -> form_validation -> run () != false ) {
                $info    = array (
                    'name'            => $data[ 'name' ],
                    'generic_id'      => $data[ 'generic_id' ],
                    'strength_id'     => $data[ 'strength_id' ],
                    'form_id'         => $data[ 'form_id' ],
                    'manufacturer_id' => $data[ 'manufacturer_id' ],
                    'pack_size_id'    => $data[ 'pack_size_id' ],
                    'tp_box'          => $data[ 'tp_box' ],
                    'quantity'        => $data[ 'quantity' ],
                    'tp_unit'         => $data[ 'tp_unit' ],
                    'sale_box'        => $data[ 'sale_box' ],
                    'sale_unit'       => $data[ 'sale_unit' ],
                    'type'            => $data[ 'type' ],
                    'threshold'       => $data[ 'threshold' ]
                );
                $updated = $this -> MedicineModel -> edit ( $info, $medicine_id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Medicine updated.' );
                    return redirect ( base_url ( '/medicines/edit/' . $medicine_id ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Note! Medicine already updated.' );
                    return redirect ( base_url ( '/medicines/edit/' . $medicine_id ) );
                }
            }
        }
        
        /**
         * -------------------------
         * reactivate medicine by id
         * -------------------------
         */
        
        public function reactivate () {
            $medicine_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $medicine_id ) ) and $medicine_id > 0 and is_numeric ( $medicine_id ) ) {
                $updated = $this -> MedicineModel -> reactivate ( $medicine_id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Medicine is reactive.' );
                    return redirect ( base_url ( '/medicines/index' ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Note! Medicine is already active.' );
                    return redirect ( base_url ( '/medicines/index' ) );
                }
            }
        }
        
        /**
         * -------------------------
         * inactive medicine by id
         * -------------------------
         */
        
        public function delete () {
            $medicine_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $medicine_id ) ) and $medicine_id > 0 and is_numeric ( $medicine_id ) ) {
                $updated = $this -> MedicineModel -> inactive ( $medicine_id );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Medicine has been marked inactivated.' );
                    return redirect ( base_url ( '/medicines/index' ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Note! Medicine is already inactive.' );
                    return redirect ( base_url ( '/medicines/index' ) );
                }
            }
        }
        
        /**
         * -------------------------
         * delete medicine by id
         * get all stock of medicine
         * delete stock and remove
         * supplier ledger as well
         * -------------------------
         */
        
        public function delete_medicine () {
            $medicine_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $medicine_id ) ) and $medicine_id > 0 and is_numeric ( $medicine_id ) ) {
                
                $sold = get_sold_quantity ( $medicine_id );
                if ( $sold > 0 ) {
                    $this -> session -> set_flashdata ( 'error', 'Medicine cannot be deleted.' );
                    return redirect ( base_url ( '/medicines/index' ) );
                }
                
                $stocks = $this -> MedicineModel -> get_stocks ( $medicine_id );
                if ( count ( $stocks ) > 0 ) {
                    foreach ( $stocks as $stock ) {
                        $condition = array (
                            'stock_id'   => $stock -> supplier_invoice,
                            'invoice_id' => $stock -> supplier_invoice
                        );
                        $this -> AccountModel -> delete_ledger ( $condition );
                    }
                }
                $this -> MedicineModel -> delete_medicine ( $medicine_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Medicine has been deleted permanently.' );
                return redirect ( base_url ( '/medicines/index' ) );
            }
        }
        
        /**
         * -------------------------
         * add stock
         * -------------------------
         */

//        public function add_stock_old () {
//
//            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_medicine_stock' )
//                $this -> do_add_medicine_stock ( $_POST );
//
//            $title = site_name . ' - Add Medicine Stock';
//            $this -> header ( $title );
//            $this -> sidebar ();
//            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines ();
//            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
//            $this -> load -> view ( '/medicines/add-stock', $data );
//            $this -> footer ();
//        }
        
        public function add_stock () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_medicine_stock' )
                $this -> do_add_medicine_stock ( $_POST );
            
            $title = site_name . ' - Add Medicine Stock';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ]     = $this -> MedicineModel -> get_active_medicines ();
            $data[ 'suppliers' ]     = $this -> SupplierModel -> get_active_suppliers ();
            $data[ 'generics' ]      = $this -> MedicineModel -> get_generics ();
            $data[ 'forms' ]         = $this -> MedicineModel -> get_forms ();
            $data[ 'strengths' ]     = $this -> MedicineModel -> get_strengths ();
            $data[ 'manufacturers' ] = $this -> MedicineModel -> get_manufacturers ();
            $data[ 'packs' ]         = $this -> MedicineModel -> get_pack_sizes ();
            
            $this -> load -> view ( '/medicines/add-stock-new', $data );
            $this -> footer ();
        }
        
        public function load_add_medicine_popup () {
            $data[ 'generics' ]      = $this -> MedicineModel -> get_generics ();
            $data[ 'forms' ]         = $this -> MedicineModel -> get_forms ();
            $data[ 'strengths' ]     = $this -> MedicineModel -> get_strengths ();
            $data[ 'manufacturers' ] = $this -> MedicineModel -> get_manufacturers ();
            $data[ 'packs' ]         = $this -> MedicineModel -> get_pack_sizes ();
            
            $this -> load -> view ( '/medicines/add-medicine-popup', $data );
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add stock
         * -------------------------
         */
        
        public function do_add_medicine_stock ( $POST ) {
            
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'supplier_id', 'supplier', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'supplier_invoice', 'supplier invoice number', 'required|trim|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () != false ) {
                
                $stock_id         = 0;
                $user_id          = get_logged_in_user_id ();
                $supplier_id      = $data[ 'supplier_id' ];
                $supplier_invoice = $data[ 'supplier_invoice' ];
                //                $grand_total = get_total_of_added_stock ( $_POST[ 'medicine_id' ] );
                $grand_total = $_POST[ 'grand_total' ];
                $date_added  = date ( 'Y-m-d', strtotime ( $data[ 'date_added' ] ) ) . ' ' . date ( 'H:i:s' );
                
                if ( isset( $data[ 'grand_total_discount' ] ) and !empty( trim ( $data[ 'grand_total_discount' ] ) ) ) {
                    $grand_total_discount                  = array (
                        'invoice_number' => $supplier_invoice,
                        'discount'       => $data[ 'grand_total_discount' ],
                        'date_added'     => $date_added
                    );
                    $grand_total_discount[ 'grand_total' ] = $grand_total;
                    $this -> MedicineModel -> add_grand_total_discount ( $grand_total_discount );
                }
                else {
                    $grand_total_discount                  = array (
                        'invoice_number' => $supplier_invoice,
                        'discount'       => 0,
                        'date_added'     => $date_added
                    );
                    $grand_total_discount[ 'grand_total' ] = $grand_total;
                    $this -> MedicineModel -> add_grand_total_discount ( $grand_total_discount );
                }
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'invoice'      => $supplier_invoice,
                    'action'       => 'pharmacy_stock_total_added',
                    'log'          => json_encode ( $grand_total_discount ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'pharmacy_stock_total_logs', $log );
                
                /***********END LOG*************/
                
                if ( isset( $data[ 'medicine_id' ] ) and count ( array_filter ( $data[ 'medicine_id' ] ) ) > 0 ) {
                    foreach ( $data[ 'medicine_id' ] as $key => $medicine_id ) {
                        if ( $medicine_id > 0 ) {
                            $info     = array (
                                'user_id'                 => $user_id,
                                'supplier_id'             => $supplier_id,
                                'supplier_invoice'        => $supplier_invoice,
                                'medicine_id'             => $medicine_id,
                                'batch'                   => $data[ 'batch' ][ $key ],
                                'expiry_date'             => date ( 'Y-m-d', strtotime ( $data[ 'expiry_date' ][ $key ] ) ),
                                'box_qty'                 => $data[ 'box_qty' ][ $key ],
                                'units'                   => $data[ 'units' ][ $key ],
                                'quantity'                => $data[ 'quantity' ][ $key ],
                                'box_price'               => $data[ 'box_price' ][ $key ],
                                'price'                   => $data[ 'price' ][ $key ],
                                'discount'                => $data[ 'discount' ][ $key ],
                                'sales_tax'               => $data[ 'sales_tax' ][ $key ],
                                'net_price'               => $data[ 'net' ][ $key ],
                                'tp_unit'                 => $data[ 'tp_unit' ][ $key ],
                                'sale_box'                => $data[ 'sale_box' ][ $key ],
                                'box_price_after_dis_tax' => $data[ 'box_price_after_dis_tax' ][ $key ],
                                'sale_unit'               => $data[ 'sale_unit' ][ $key ],
                                'date_added'              => $date_added
                            );
                            $stock_id = $this -> MedicineModel -> add_stock ( $info );
                            
                            $medicineInfo = array (
                                'tp_box'    => $data[ 'box_price' ][ $key ],
                                'tp_unit'   => $data[ 'tp_unit' ][ $key ],
                                'sale_box'  => $data[ 'sale_box' ][ $key ],
                                'sale_unit' => $data[ 'sale_unit' ][ $key ],
                            );
                            
                            $this -> MedicineModel -> edit ( $medicineInfo, $medicine_id );
                            
                            /***********LOGS*************/
                            
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'invoice'      => $supplier_invoice,
                                'action'       => 'pharmacy_stock_items_added',
                                'log'          => json_encode ( $info ),
                                'after_update' => '',
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'pharmacy_stock_logs', $log );
                            
                            /***********END LOG*************/
                        }
                    }
                }
                
                if ( $stock_id > 0 ) {
                    $ledger_description = 'Stock added. Invoice# ' . $supplier_invoice;
                    $ledger             = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => $supplier_id,
                        'stock_id'         => $supplier_invoice,
                        //                        'invoice_id'       => $supplier_invoice,
                        'payment_mode'     => 'none',
                        'paid_via'         => '',
                        'transaction_type' => 'credit',
                        'credit'           => 0,
                        'debit'            => $grand_total,
                        'description'      => $ledger_description,
                        'trans_date'       => date ( 'Y-m-d' ),
                        'date_added'       => $date_added
                    );
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'invoice'      => $supplier_invoice,
                        'action'       => 'pharmacy_stock_ledger_added',
                        'log'          => json_encode ( $ledger ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'pharmacy_stock_ledger_logs', $log );
                    
                    /***********END LOG*************/
                    
                    $ledger[ 'acc_head_id' ]      = medical_supply_inventory;
                    $ledger[ 'transaction_type' ] = 'debit';
                    $ledger[ 'credit' ]           = $grand_total;
                    $ledger[ 'debit' ]            = 0;
                    
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'invoice'      => $supplier_invoice,
                        'action'       => 'pharmacy_stock_ledger_added',
                        'log'          => json_encode ( $ledger ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'pharmacy_stock_ledger_logs', $log );
                    
                    /***********END LOG*************/
                    
                    return redirect ( base_url ( '/medicines/return-stock?supplier_id=' . $supplier_id . '&supplier_invoice=' . $supplier_invoice . '&request=verify' ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( base_url ( '/medicines/add-medicines-stock' ) );
                }
            }
        }
        
        /**
         * -------------------------
         * get medicine detail
         * -------------------------
         */
        
        public function get_medicine_detail () {
            $medicine_id = $this -> input -> post ( 'medicine_id' );
            if ( is_numeric ( $medicine_id ) and $medicine_id > 0 and !empty( trim ( $medicine_id ) ) ) {
                $medicine = $this -> MedicineModel -> get_medicine ( $medicine_id );
                if ( !empty( $medicine ) ) {
                    $array = array (
                        'generic'  => $medicine -> generic_id,
                        'strength' => $medicine -> strength_id,
                        'form'     => $medicine -> form_id
                    );
                    echo json_encode ( $array );
                }
            }
        }
        
        /**
         * -------------------------
         * get medicine
         * -------------------------
         */
        
        public function get_medicine () {
            $medicine_id = $this -> input -> post ( 'medicine_id' );
            if ( is_numeric ( $medicine_id ) and $medicine_id > 0 and !empty( trim ( $medicine_id ) ) ) {
                $medicine = $this -> MedicineModel -> get_medicine ( $medicine_id );
                if ( !empty( $medicine ) ) {
                    $array = array (
                        'tp_box'    => $medicine -> tp_box,
                        'tp_unit'   => $medicine -> tp_unit,
                        'sale_box'  => $medicine -> sale_box,
                        'sale_unit' => $medicine -> sale_unit,
                        'quantity'  => $medicine -> quantity,
                    );
                    echo json_encode ( $array );
                }
            }
        }
        
        /**
         * -------------------------
         * validate batch number
         * -------------------------
         */
        
        public function validate_batch_number () {
            $medicine_id  = $this -> input -> post ( 'medicine_id' );
            $batch_number = $this -> input -> post ( 'batch_number' );
            if ( is_numeric ( $medicine_id ) and $medicine_id > 0 and !empty( trim ( $medicine_id ) ) and !empty( trim ( $batch_number ) ) ) {
                $data   = array (
                    'medicine_id' => $medicine_id,
                    'batch'       => $batch_number,
                );
                $exists = $this -> MedicineModel -> validate_batch_number ( $data );
                if ( $exists > 0 ) {
                    echo 'true';
                }
                else {
                    echo 'false';
                }
            }
        }
        
        /**
         * -------------------------
         * validate invoice number
         * -------------------------
         */
        
        public function validate_invoice_number () {
            $medicine_id    = $this -> input -> post ( 'medicine_id' );
            $invoice_number = $this -> input -> post ( 'invoice_number' );
            if ( is_numeric ( $medicine_id ) and $medicine_id > 0 and !empty( trim ( $medicine_id ) ) and !empty( trim ( $invoice_number ) ) ) {
                $data   = array (
                    'medicine_id'      => $medicine_id,
                    'supplier_invoice' => $invoice_number,
                );
                $exists = $this -> MedicineModel -> validate_invoice_number ( $data );
                if ( $exists > 0 ) {
                    echo 'true';
                }
                else {
                    echo 'false';
                }
            }
        }
        
        /**
         * -------------------------
         * stock details
         * -------------------------
         */
        
        public function stock () {
            
            $medicine_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $medicine_id ) ) or $medicine_id < 1 or !is_numeric ( $medicine_id ) )
                return redirect ( base_url ( '/medicines/index' ) );
            
            $title = site_name . ' - Medicine Stock';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'stocks' ] = $this -> MedicineModel -> get_stocks ( $medicine_id );
            $this -> load -> view ( '/medicines/stock', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * stock details
         * -------------------------
         */
        
        public function edit_stock () {
            
            $stock_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $stock_id ) ) or $stock_id < 1 or !is_numeric ( $stock_id ) )
                return redirect ( base_url ( '/medicines/index' ) );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_medicine_stock' )
                $this -> do_update_medicine_stock ( $_POST );
            
            $title = site_name . ' - Edit Stock';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_suppliers ();
            $data[ 'stock' ]     = $this -> MedicineModel -> get_stock ( $stock_id );
            $this -> load -> view ( '/medicines/edit-stock', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do update stock
         * -------------------------
         */
        
        public function do_update_medicine_stock ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'medicine_id', 'medicine', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'supplier_id', 'supplier', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'batch', 'batch', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'expiry_date', 'expiry date', 'required|trim|min_length[1]|xss_clean|date' );
            $this -> form_validation -> set_rules ( 'supplier_invoice', 'supplier invoice', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'quantity', 'quantity', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'packs', 'packs', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'stripes', 'stripes', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'purchase_price', 'purchase price', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'sale_price', 'sale price', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'invoice_bill', 'invoice bill', 'required|trim|min_length[1]|xss_clean|numeric' );
            
            $stock_id = $data[ 'stock_id' ];
            if ( empty( trim ( $stock_id ) ) or $stock_id < 1 or !is_numeric ( $stock_id ) )
                return redirect ( base_url ( '/medicines/index' ) );
            
            if ( $this -> form_validation -> run () != false ) {
                $info    = array (
                    'medicine_id'      => $data[ 'medicine_id' ],
                    'supplier_id'      => $data[ 'supplier_id' ],
                    'batch'            => $data[ 'batch' ],
                    'expiry_date'      => date ( 'Y-m-d', strtotime ( $data[ 'expiry_date' ] ) ),
                    'supplier_invoice' => $data[ 'supplier_invoice' ],
                    'quantity'         => $data[ 'quantity' ],
                    'packs'            => $data[ 'packs' ],
                    'stripes'          => $data[ 'stripes' ],
                    'purchase_price'   => $data[ 'purchase_price' ],
                    'sale_price'       => $data[ 'sale_price' ],
                    'invoice_bill'     => $data[ 'invoice_bill' ],
                );
                $updated = $this -> MedicineModel -> update_stock ( $info, $stock_id );
                if ( $updated ) {
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'invoice'      => $data[ 'supplier_invoice' ],
                        'action'       => 'pharmacy_stock_updated',
                        'log'          => json_encode ( $info ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'pharmacy_stock_logs', $log );
                    
                    /***********END LOG*************/
                    
                    $this -> session -> set_flashdata ( 'response', 'Success! Medicine stock updated.' );
                    return redirect ( base_url ( '/medicines/edit-stock/' . $stock_id ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Note! Stock already updated.' );
                    return redirect ( base_url ( '/medicines/edit-stock/' . $stock_id ) );
                }
            }
        }
        
        /**
         * -------------------------
         * delete stock
         * stock is never deleted, status is updated
         * -------------------------
         */
        
        public function delete_stock () {
            $stock_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $stock_id ) ) and $stock_id > 0 and is_numeric ( $stock_id ) ) {
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'invoice'      => $this -> MedicineModel -> get_stock ( $stock_id ) -> supplier_invoice,
                    'action'       => 'pharmacy_stock_single_deleted',
                    'log'          => json_encode ( $stock_id ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'pharmacy_stock_logs', $log );
                
                /***********END LOG*************/
                
                $this -> MedicineModel -> delete_stock ( $stock_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Stock has been marked inactive.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete stock
         * stock will be deleted permanently
         * -------------------------
         */
        
        public function delete_stock_permanently () {
            $stock_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $stock_id ) ) and $stock_id > 0 and is_numeric ( $stock_id ) ) {
                
                $stock = get_stock ( $stock_id );
                $sold  = get_sold_quantity_by_stock ( $stock -> medicine_id, $stock_id );
                
                if ( $sold > 0 ) {
                    $this -> session -> set_flashdata ( 'error', 'Stock cannot be deleted.' );
                    return redirect ( base_url ( '/medicines/stock/' . $stock -> medicine_id ) );
                }
                
                if ( !empty( $stock ) ) {
                    $net_price = $stock -> net_price;
                    $this -> MedicineModel -> delete_stock_by_stock_id ( $stock_id );
                    $this -> MedicineModel -> update_stock_invoice_total ( $stock -> supplier_invoice, $net_price );
                    $stockTotal = $this -> MedicineModel -> get_stock_grand_total ( $stock -> supplier_invoice );
                    
                    $ledger = array (
                        'debit' => $stockTotal -> grand_total,
                    );
                    $where  = array (
                        'acc_head_id' => $stock -> supplier_id,
                        'stock_id'    => $stock -> supplier_invoice
                    );
                    $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                    
                    $ledger = array (
                        'credit' => $stockTotal -> grand_total,
                    );
                    $where  = array (
                        'acc_head_id' => medical_supply_inventory,
                        'stock_id'    => $stock -> supplier_invoice
                    );
                    $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'invoice'      => $stock -> supplier_invoice,
                        'action'       => 'pharmacy_stock_single_deleted',
                        'log'          => json_encode ( $stock_id ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'pharmacy_stock_logs', $log );
                    
                    /***********END LOG*************/
                    
                    $this -> session -> set_flashdata ( 'response', 'Success! Stock has been deleted.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Stock does not exists.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * delete stock
         * stock will be deleted permanently
         * -------------------------
         */
        
        public function delete_return_customer_stock () {
            $stock_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $stock_id ) ) and $stock_id > 0 and is_numeric ( $stock_id ) ) {
                $stock   = $this -> MedicineModel -> get_stock ( $stock_id );
                $invoice = $stock -> supplier_invoice;
                
                $totalStockValue = get_stock_total_value_by_invoice ( $invoice );
                $remaining       = $totalStockValue - $stock -> paid_to_customer;
                $this -> MedicineModel -> delete_stock_permanently_by_id ( $stock_id );
                
                $cost_of_medicines_sold = calculate_cost_of_medicines_returned_by_invoice ( $stock -> supplier_invoice );
                
                $ledger = array (
                    'debit'  => $remaining,
                    'credit' => 0,
                );
                
                $where = array (
                    'invoice_id'  => $stock -> supplier_invoice,
                    'acc_head_id' => cash_from_pharmacy,
                );
                $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                
                $return_ledger = array (
                    'credit' => $remaining,
                    'debit'  => 0,
                );
                
                $where = array (
                    'invoice_id'  => $stock -> supplier_invoice,
                    'acc_head_id' => returns_and_allowances,
                );
                $this -> AccountModel -> update_general_ledger ( $return_ledger, $where );
                
                $ledger = array (
                    'credit' => $cost_of_medicines_sold,
                    'debit'  => 0,
                );
                
                $where = array (
                    'invoice_id'  => $stock -> supplier_invoice,
                    'acc_head_id' => medical_supply_inventory,
                );
                $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                
                $ledger = array (
                    'credit' => 0,
                    'debit'  => $cost_of_medicines_sold,
                );
                
                $where = array (
                    'invoice_id'  => $stock -> supplier_invoice,
                    'acc_head_id' => cost_of_medicine_sold,
                );
                $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'invoice'      => $invoice,
                    'action'       => 'pharmacy_return_customer_stock_deleted',
                    'log'          => json_encode ( $stock_id ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'pharmacy_stock_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Stock has been deleted.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * activate stock
         * -------------------------
         */
        
        public function activate_stock () {
            $stock_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $stock_id ) ) and $stock_id > 0 and is_numeric ( $stock_id ) ) {
                $this -> MedicineModel -> activate_stock ( $stock_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Stock has been marked active.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * load sale medicine page
         * -------------------------
         */
        
        public function sale () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_sale_medicine' )
                $this -> do_sale_medicine ( $_POST );
            
            if ( isset( $_GET[ 'action' ] ) and $_GET[ 'action' ] == 'clear-sale' )
                $this -> clear_medicine_sale ();
            
            $title = site_name . ' - Sale Medicine';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines_that_has_stock ();
            $this -> load -> view ( '/medicines/sale', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * get patient by patient id
         * return <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?> as json
         * -------------------------
         */
        
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
                        'panel_name'    => $patient -> panel_id > 0 ? get_panel_by_id ( $patient -> panel_id ) -> name : ''
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
        
        /**
         * -------------------------
         * add more sales input fields
         * -------------------------
         */
        
        public function add_more_sale () {
            $data[ 'added' ]     = $this -> input -> post ( 'added' );
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines_that_has_stock ();
            $this -> load -> view ( '/medicines/sale-more-medicine', $data );
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
         * add more sales input fields
         * -------------------------
         */
        
        public function add_more_sale_adjustments () {
            $data[ 'added' ]     = $this -> input -> post ( 'added' );
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines_that_has_stock ();
            $this -> load -> view ( '/medicines/sale-more-medicine-adjustments', $data );
        }
        
        /**
         * -------------------------
         * add more issuance input fields
         * -------------------------
         */
        
        public function add_more_issuance () {
            $data[ 'added' ]     = $this -> input -> post ( 'added' );
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines_that_has_stock ();
            $this -> load -> view ( '/medicines/issue-more-medicine', $data );
        }
        
        /**
         * -------------------------
         * get medicine stock
         * check expiry date and status
         * -------------------------
         */
        
        public function get_stock () {
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
                $this -> load -> view ( '/medicines/stock-dropdown', $data );
            }
            else {
                echo 'false';
            }
        }
        
        /**
         * -------------------------
         * get medicine stock
         * check expiry date and status
         * -------------------------
         */
        
        public function get_stock_adjustments () {
            $data        = filter_var_array ( $_POST, FILTER_SANITIZE_STRING );
            $medicine_id = $data[ 'medicine_id' ];
            $selected    = $data[ 'selected' ];
            $row         = $data[ 'row' ];
            if ( !empty( trim ( $medicine_id ) ) and is_numeric ( $medicine_id ) > 0 ) {
                $data[ 'stock' ]       = $this -> MedicineModel -> get_medicine_stock ( $medicine_id );
                $data[ 'row' ]         = $row;
                $data[ 'medicine_id' ] = $medicine_id;
                $data[ 'selected' ]    = $selected;
                $this -> load -> view ( '/medicines/adjustment-stock-dropdown', $data );
            }
            else {
                echo 'false';
            }
        }
        
        /**
         * -------------------------
         * get medicine stock
         * check expiry date and status
         * -------------------------
         */
        
        public function get_stock_for_return () {
            $data        = filter_var_array ( $_POST, FILTER_SANITIZE_STRING );
            $medicine_id = $data[ 'medicine_id' ];
            $row         = $data[ 'row' ];
            if ( !empty( trim ( $medicine_id ) ) and !empty( trim ( $row ) ) and is_numeric ( $medicine_id ) > 0 and is_numeric ( $row ) > 0 ) {
                $data[ 'stock' ] = $this -> MedicineModel -> get_medicine_stock ( $medicine_id );
                $data[ 'row' ]   = $row;
                $this -> load -> view ( '/medicines/stock-dropdown-return', $data );
            }
            else {
                echo 'false';
            }
        }
        
        /**
         * -------------------------
         * get stock available quantity
         * by stock id
         * -------------------------
         */
        
        public function get_stock_available_quantity () {
            $stock_id          = $this -> input -> post ( 'stock_id' );
            $medicine_id       = $this -> input -> post ( 'medicine_id' );
            $required_tp_price = $this -> input -> post ( 'required_tp_price' );
            
            if ( !empty( trim ( $stock_id ) ) and is_numeric ( $stock_id ) and $stock_id > 0 ) {
                $available = $this -> MedicineModel -> get_stock_available_quantity_by_stock_and_medicine ( $medicine_id, $stock_id );
                
                $sold              = get_sold_quantity_by_stock ( $medicine_id, $stock_id );
                $issued            = check_stock_issued_quantity ( $stock_id );
                $ipd_med           = get_ipd_medication_assigned_count_by_stock_and_medicine ( $medicine_id, $stock_id );
                $returned_quantity = get_stock_returned_quantity ( $stock_id );                            // returned by supplier
                $adjustment_qty    = count_medicine_adjustment_by_medicine_id ( $medicine_id, $stock_id ); // returned by supplier
                
                $sale_session = array (
                    'user_id'     => get_logged_in_user_id (),
                    'medicine_id' => $medicine_id,
                    'stock_id'    => $stock_id,
                );
                $this -> MedicineModel -> save_current_session ( $sale_session );
                
                $stock = array (
                    'available' => $available -> quantity - $sold - $issued - $ipd_med - $returned_quantity - $adjustment_qty,
                    'price'     => ( $required_tp_price && $required_tp_price != 'false' ) ? $available -> tp_unit : $available -> sale_unit
                );
                echo json_encode ( $stock );
            }
            else {
                echo 'false';
            }
        }
        
        /**
         * -------------------------
         * get stock available quantity
         * by stock id
         * -------------------------
         */
        
        public function get_stock_available_quantity_adjustments () {
            $stock_id    = $this -> input -> post ( 'stock_id' );
            $medicine_id = $this -> input -> post ( 'medicine_id' );
            if ( !empty( trim ( $stock_id ) ) and is_numeric ( $stock_id ) and $stock_id > 0 ) {
                $available = $this -> MedicineModel -> get_stock_available_quantity ( $stock_id );
                
                $sold              = get_sold_quantity_by_stock ( $medicine_id, $stock_id );
                $issued            = check_stock_issued_quantity ( $stock_id );
                $ipd_med           = get_ipd_medication_assigned_count_by_stock_and_medicine ( $medicine_id, $stock_id );
                $returned_quantity = get_stock_returned_quantity ( $stock_id );                            // returned by supplier
                $adjustment_qty    = count_medicine_adjustment_by_medicine_id ( $medicine_id, $stock_id ); // returned by supplier
                
                $stock = array (
                    'available' => $available -> quantity - $sold - $issued - $ipd_med - $returned_quantity - $adjustment_qty,
                    'price'     => $available -> tp_unit
                );
                echo json_encode ( $stock );
            }
            else {
                echo 'false';
            }
        }
        
        /**
         * -------------------------
         * get stock available quantity
         * by stock id
         * -------------------------
         */
        
        public function get_stock_available_quantity_return () {
            $stock_id = $this -> input -> post ( 'stock_id' );
            if ( !empty( trim ( $stock_id ) ) and is_numeric ( $stock_id ) and $stock_id > 0 ) {
                $available = $this -> MedicineModel -> get_stock_available_quantity ( $stock_id );
                $returned  = get_stock_returned_quantity ( $stock_id );
                $stock     = array (
                    'available' => $available -> quantity - $available -> sold,
                    'price'     => round ( $available -> tp_unit, 2 )
                );
                echo json_encode ( $stock );
            }
            else {
                echo 'false';
            }
        }
        
        /**
         * -------------------------
         * @param $POST
         * do sale medicines
         * add ledger
         * add sale
         * -------------------------
         */
        
        public function do_sale_medicine ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            if ( isset( $_POST[ 'cash_from_pharmacy' ] ) )
                $patient_id = $data[ 'cash_from_pharmacy' ];
            else
                $patient_id = $data[ 'patient_id' ];
            
            $cashAccountHead = cash_from_pharmacy;
            if ( $this -> input -> post ( 'payment-method' ) == 'card' )
                $cashAccountHead = CARD;
            else if ( $this -> input -> post ( 'payment-method' ) == 'bank' )
                $cashAccountHead = $this -> input -> post ( 'bank-id' );
            
            $patient_id = ( isset( $data[ 'patient_id' ] ) && $data[ 'patient_id' ] > 0 ) ? $data[ 'patient_id' ] : $cashAccountHead;
            
            if ( empty( trim ( $patient_id ) ) or $patient_id < 1 )
                $patient_id = cash_from_pharmacy;
            
            $medicines = array_filter ( $data[ 'medicine_id' ] );
            
            $this -> MedicineModel -> clear_medicine_sale ( get_logged_in_user_id () );
            
            if ( count ( $medicines ) > 0 ) {
                
                $sale_total = calculate_medicines_sale_total ( $medicines );
                
                $sale    = array (
                    'user_id'         => get_logged_in_user_id (),
                    'account_head_id' => $this -> input -> post ( 'bank-id' ),
                    'total'           => $sale_total,
                    'discount'        => $data[ 'sale_discount' ],
                    'flat_discount'   => $data[ 'flat_discount' ],
                    'added_amount'    => $data[ 'added_amount' ],
                    'paid_amount'     => $data[ 'paid_amount' ],
                    'customer_name'   => $data[ 'customer_name' ],
                    'payment_method'  => $this -> input -> post ( 'payment-method' ),
                    'transaction_no'  => $this -> input -> post ( 'transaction-no' ),
                    'date_sale'       => current_date_time (),
                );
                $sale_id = $this -> MedicineModel -> add_sale ( $sale );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => $sale_id,
                    'action'       => 'pharmacy_sale_total_added',
                    'log'          => json_encode ( $sale ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'pharmacy_sale_total_logs', $log );
                
                /***********END LOG*************/
                
                foreach ( $medicines as $key => $value ) {
                    if ( !empty( trim ( $value ) ) and $value > 0 ) {
                        $medicine_id = $value;
                        $stock_id    = $data[ 'stock_id' ][ $key ];
                        $quantity    = $data[ 'quantity' ][ $key ];
                        
                        if ( isset( $stock_id ) and $stock_id > 0 ) {
                            $sale_unit = get_medicine_stock_sale_unit_price ( $stock_id );
                            $total     = $sale_unit * $quantity;
                            
                            $info = array (
                                'user_id'     => get_logged_in_user_id (),
                                'sale_id'     => $sale_id,
                                'medicine_id' => $medicine_id,
                                'patient_id'  => $patient_id,
                                'stock_id'    => $stock_id,
                                'quantity'    => $quantity,
                                'price'       => $sale_unit,
                                'net_price'   => $total,
                                'date_sold'   => current_date_time (),
                            );
                            $this -> MedicineModel -> sale_medicine ( $info );
                            
                            /***********LOGS*************/
                            
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'sale_id'      => $sale_id,
                                'action'       => 'pharmacy_sale_medication_added',
                                'log'          => json_encode ( $info ),
                                'after_update' => '',
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'pharmacy_sale_logs', $log );
                            
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'sale_id'      => $sale_id,
                                'action'       => 'pharmacy_sale_medication_added_2',
                                'log'          => json_encode ( $_POST ),
                                'after_update' => '',
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'pharmacy_sale_logs', $log );
                            
                            /***********END LOG*************/
                        }
                    }
                }
                
                $description = 'Medicine sold. Invoice# ' . $sale_id;
                $ledger      = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => $patient_id,
                    'invoice_id'       => $sale_id,
                    'trans_date'       => date ( 'Y-m-d' ),
                    'payment_mode'     => 'cash',
                    'paid_via'         => 'cash',
                    'transaction_type' => 'credit',
                    'credit'           => $sale_total,
                    'debit'            => 0,
                    'description'      => $description,
                    'date_added'       => current_date_time (),
                );
                $this -> AccountModel -> add_ledger ( $ledger );
                
                $pharmacy_sale_total = $data[ 'pharmacy_sale_total' ];
                
                if ( isset( $data[ 'sale_discount' ] ) and $data[ 'sale_discount' ] > 0 ) {
                    $ledger[ 'acc_head_id' ]      = sales_pharmacy;
                    $ledger[ 'transaction_type' ] = 'debit';
                    $ledger[ 'credit' ]           = 0;
                    $ledger[ 'debit' ]            = $pharmacy_sale_total;
                    
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    $ledger[ 'acc_head_id' ]      = discount_pharmacy;
                    $ledger[ 'transaction_type' ] = 'credit';
                    $ledger[ 'credit' ]           = $pharmacy_sale_total - $sale_total;
                    $ledger[ 'debit' ]            = 0;
                    
                    $this -> AccountModel -> add_ledger ( $ledger );
                }
                
                else if ( isset( $data[ 'flat_discount' ] ) and $data[ 'flat_discount' ] > 0 ) {
                    $ledger[ 'acc_head_id' ]      = sales_pharmacy;
                    $ledger[ 'transaction_type' ] = 'debit';
                    $ledger[ 'credit' ]           = 0;
                    $ledger[ 'debit' ]            = $pharmacy_sale_total;
                    
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    $ledger[ 'acc_head_id' ]      = discount_pharmacy;
                    $ledger[ 'transaction_type' ] = 'credit';
                    $ledger[ 'credit' ]           = $pharmacy_sale_total - $sale_total;
                    $ledger[ 'debit' ]            = 0;
                    
                    $this -> AccountModel -> add_ledger ( $ledger );
                }
                else {
                    $ledger[ 'acc_head_id' ]      = sales_pharmacy;
                    $ledger[ 'transaction_type' ] = 'debit';
                    $ledger[ 'credit' ]           = 0;
                    $ledger[ 'debit' ]            = $sale_total;
                    
                    $this -> AccountModel -> add_ledger ( $ledger );
                }
                
                $total_cost_tp_wise = calculate_cost_of_medicines_sold ( $sale_id );
                $description        = 'Medicine sold. Total TP wise. Invoice# ' . $sale_id;
                $tp_ledger          = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => cost_of_medicine_sold,
                    'invoice_id'       => $sale_id,
                    'trans_date'       => date ( 'Y-m-d' ),
                    'payment_mode'     => 'cash',
                    'paid_via'         => 'cash',
                    'transaction_type' => 'credit',
                    'credit'           => $total_cost_tp_wise,
                    'debit'            => 0,
                    'description'      => $description,
                    'date_added'       => current_date_time (),
                );
                $this -> AccountModel -> add_ledger ( $tp_ledger );
                
                $tp_ledger[ 'acc_head_id' ]      = medical_supply_inventory;
                $tp_ledger[ 'transaction_type' ] = 'debit';
                $tp_ledger[ 'credit' ]           = 0;
                $tp_ledger[ 'debit' ]            = $total_cost_tp_wise;
                $this -> AccountModel -> add_ledger ( $tp_ledger );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => $sale_id,
                    'action'       => 'pharmacy_sale_ledger_added',
                    'log'          => json_encode ( $ledger ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'pharmacy_sale_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', $sale_id );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * sales list
         * display all sales with edit, delete
         * and print invoice options
         * -------------------------
         */
        
        public function sales () {
            $title = site_name . ' - Sale Invoices';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'medicines/sales' );
            $total_row                      = $this -> MedicineModel -> count_sales ();
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
            
            $data[ 'customers' ] = $this -> AccountModel -> get_customers ( cash_in_hand );
            $data[ 'sales' ]     = $this -> MedicineModel -> get_sales ( $config[ "per_page" ], $offset );
            $str_links           = $this -> pagination -> create_links ();
            $data[ "links" ]     = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/medicines/sales', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * load sale medicine page
         * -------------------------
         */
        
        public function edit_sale () {
            
            if ( isset( $_REQUEST[ 'sale_id' ] ) && $_REQUEST[ 'sale_id' ] > 0 ) {
                $sale = get_sale ( $_REQUEST[ 'sale_id' ] );
                if ( $sale -> refunded == '1' ) {
                    $this -> session -> set_flashdata ( 'error', 'Sale cannot be edited.' );
                    return redirect ( base_url ( '/medicines/sales' ) );
                }
            }
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_sale' )
                $this -> do_edit_sale ( $_POST );
            
            $title = site_name . ' - Edit Sale';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'sales' ] = $this -> MedicineModel -> get_sale_by_sale_id ();
            $this -> load -> view ( '/medicines/edit-sale', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do edit sale
         * -------------------------
         */
        
        public function do_edit_sale ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            if ( isset( $_POST[ 'cash_from_pharmacy' ] ) )
                $patient_id = $data[ 'cash_from_pharmacy' ];
            else
                $patient_id = $data[ 'patient_id' ];
            
            $sale_id         = $data[ 'sale_id' ];
            $sale_ids        = array_filter ( $data[ 'id' ] );
            $total_net_price = $data[ 'total' ];
            $sale_discount   = $data[ 'sale_discount' ];
            $sale_discount   = $data[ 'sale_discount' ];
            $flat_discount   = $data[ 'flat_discount' ];
            $added_amount    = $data[ 'added_amount' ];
            $sold            = 0;
            
            $sale            = $this -> MedicineModel -> get_sale ( $sale_id );
            $cashAccountHead = cash_from_pharmacy;
            if ( $sale -> payment_method == 'card' )
                $cashAccountHead = CARD;
            else if ( $sale -> payment_method == 'bank' )
                $cashAccountHead = $sale -> account_head_id;
            
            $patient_id = ( isset( $data[ 'patient_id' ] ) && $data[ 'patient_id' ] > 0 ) ? $data[ 'patient_id' ] : $cashAccountHead;
            
            if ( count ( $sale_ids ) > 0 ) {
                $sale = $this -> MedicineModel -> get_sale ( $sale_id );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => $sale_id,
                    'action'       => 'pharmacy_sale_updated',
                    'log'          => ' ',
                    'after_update' => json_encode ( $sale ),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'pharmacy_sale_logs', $log );
                
                /***********END LOG*************/
                
                $sale_total = calculate_medicines_sale_total ( $sale_ids );
                
                foreach ( $sale_ids as $key => $value ) {
                    $id        = $value;
                    $quantity  = $data[ 'quantity' ][ $key ];
                    $price     = $data[ 'price' ][ $key ];
                    $net_price = $data[ 'net_price' ][ $key ];
                    
                    $info = array (
                        'patient_id' => $patient_id,
                        'quantity'   => $quantity,
                        'price'      => $price,
                        'net_price'  => $net_price,
                    );
                    $this -> MedicineModel -> edit_sale_medicine ( $info, $id );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'pharmacy_sale_medication_updated',
                        'log'          => ' ',
                        'after_update' => json_encode ( $info ),
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'pharmacy_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
                $ledger = array (
                    'credit' => $total_net_price,
                    'debit'  => 0,
                );
                $total  = array (
                    'discount'      => $sale_discount,
                    'flat_discount' => $flat_discount,
                    'added_amount'  => $added_amount,
                    'total'         => $total_net_price,
                );
                
                
                //            $this -> MedicineModel -> update_overall_sale_total($total_net_price, $sale_id);
                $this -> MedicineModel -> update_medicines_sale_total ( $total, $sale_id );
                $this -> AccountModel -> update_sale_ledger ( $ledger, $sale_id );
                
                
                $pharmacy_sale_total           = $data[ 'pharmacy_sale_total' ];
                $pharmacy_total_after_discount = $data[ 'total' ];
                
                if ( isset( $data[ 'sale_discount' ] ) and $data[ 'sale_discount' ] > 0 ) {
                    $where = array (
                        'acc_head_id' => discount_pharmacy,
                        'invoice_id'  => $sale_id
                    );
                    
                    $ifLedgerExists = check_if_ledger_exists ( $where );
                    
                    if ( $ifLedgerExists ) {
                        
                        $where = array (
                            'acc_head_id' => sales_pharmacy,
                            'invoice_id'  => $sale_id
                        );
                        
                        $ledger[ 'transaction_type' ] = 'debit';
                        $ledger[ 'credit' ]           = 0;
                        $ledger[ 'debit' ]            = ( $pharmacy_sale_total );
                        
                        $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                        
                        $where = array (
                            'acc_head_id' => discount_pharmacy,
                            'invoice_id'  => $sale_id
                        );
                        
                        $ledger[ 'transaction_type' ] = 'credit';
                        $ledger[ 'credit' ]           = ( $pharmacy_sale_total - $total_net_price );
                        $ledger[ 'debit' ]            = 0;
                        
                        $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                        
                    }
                    else {
                        
                        $where = array (
                            'acc_head_id' => sales_pharmacy,
                            'invoice_id'  => $sale_id
                        );
                        
                        $ledger[ 'acc_head_id' ]      = sales_pharmacy;
                        $ledger[ 'transaction_type' ] = 'debit';
                        $ledger[ 'credit' ]           = 0;
                        $ledger[ 'debit' ]            = $pharmacy_sale_total;
                        
                        $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                        
                        $ledger = array (
                            'user_id'          => get_logged_in_user_id (),
                            'acc_head_id'      => discount_pharmacy,
                            'invoice_id'       => $sale_id,
                            'trans_date'       => date ( 'Y-m-d' ),
                            'payment_mode'     => 'cash',
                            'paid_via'         => 'cash',
                            'transaction_type' => 'credit',
                            'credit'           => $pharmacy_sale_total - $total_net_price,
                            'debit'            => 0,
                            'date_added'       => current_date_time (),
                        );
                        $this -> AccountModel -> add_ledger ( $ledger );
                    }
                }
                
                else if ( isset( $data[ 'flat_discount' ] ) and $data[ 'flat_discount' ] > 0 ) {
                    $where = array (
                        'acc_head_id' => discount_pharmacy,
                        'invoice_id'  => $sale_id
                    );
                    
                    $ifLedgerExists = check_if_ledger_exists ( $where );
                    
                    if ( $ifLedgerExists ) {
                        
                        $where = array (
                            'acc_head_id' => sales_pharmacy,
                            'invoice_id'  => $sale_id
                        );
                        
                        $ledger[ 'transaction_type' ] = 'debit';
                        $ledger[ 'credit' ]           = 0;
                        $ledger[ 'debit' ]            = $pharmacy_sale_total;
                        
                        $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                        
                        $where = array (
                            'acc_head_id' => discount_pharmacy,
                            'invoice_id'  => $sale_id
                        );
                        
                        $ledger[ 'transaction_type' ] = 'credit';
                        $ledger[ 'credit' ]           = ( $pharmacy_sale_total - $total_net_price );
                        $ledger[ 'debit' ]            = 0;
                        
                        $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                        
                    }
                    else {
                        
                        $where = array (
                            'acc_head_id' => sales_pharmacy,
                            'invoice_id'  => $sale_id
                        );
                        
                        $ledger[ 'acc_head_id' ]      = sales_pharmacy;
                        $ledger[ 'transaction_type' ] = 'debit';
                        $ledger[ 'credit' ]           = 0;
                        $ledger[ 'debit' ]            = $pharmacy_sale_total;
                        
                        $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                        
                        $ledger = array (
                            'user_id'          => get_logged_in_user_id (),
                            'acc_head_id'      => discount_pharmacy,
                            'invoice_id'       => $sale_id,
                            'trans_date'       => date ( 'Y-m-d' ),
                            'payment_mode'     => 'cash',
                            'paid_via'         => 'cash',
                            'transaction_type' => 'credit',
                            'credit'           => $pharmacy_sale_total - $total_net_price,
                            'debit'            => 0,
                            'date_added'       => current_date_time (),
                        );
                        $this -> AccountModel -> add_ledger ( $ledger );
                    }
                }
                
                else {
                    $where = array (
                        'acc_head_id' => sales_pharmacy,
                        'invoice_id'  => $sale_id
                    );
                    
                    $ledger[ 'acc_head_id' ]      = sales_pharmacy;
                    $ledger[ 'transaction_type' ] = 'debit';
                    $ledger[ 'credit' ]           = 0;
                    $ledger[ 'debit' ]            = $pharmacy_sale_total;
                    
                    $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                    
                }
                
                $total_cost_tp_wise = calculate_cost_of_medicines_sold ();
                
                $where                   = array (
                    'acc_head_id' => cost_of_medicine_sold,
                    'invoice_id'  => $sale_id
                );
                $cost_ledger[ 'credit' ] = $total_cost_tp_wise;
                $this -> AccountModel -> update_general_ledger ( $cost_ledger, $where );
                
                $where                   = array (
                    'acc_head_id' => medical_supply_inventory,
                    'invoice_id'  => $sale_id
                );
                $cost_ledger[ 'credit' ] = 0;
                $cost_ledger[ 'debit' ]  = $total_cost_tp_wise;
                //                print_data ($cost_ledger);
                //                exit;
                $this -> AccountModel -> update_general_ledger ( $cost_ledger, $where );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => $sale_id,
                    'action'       => 'pharmacy_sale_ledger_updated',
                    'log'          => ' ',
                    'after_update' => json_encode ( $ledger ),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'pharmacy_sale_logs', $log );
                
                /***********END LOG*************/
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => $sale_id,
                    'action'       => 'pharmacy_sale_total_updated',
                    'log'          => ' ',
                    'after_update' => json_encode ( $total ),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'pharmacy_sale_total_logs', $log );
                
                /***********END LOG*************/
                
                
                $this -> session -> set_flashdata ( 'response', 'Success! Sale updated. <a href="' . base_url ( '/invoices/sale-invoice/' . $sale_id ) . '" target="_blank" style="font-weight: 800; font-size: 16px">Print</a>' );
                return redirect ( '/medicines/edit-sale?sale_id=' . $sale_id );
            }
        }
        
        /**
         * -------------------------
         * inactive medicine by id
         * -------------------------
         */
        
        public function delete_sale () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $sale_id ) ) and $sale_id > 0 and is_numeric ( $sale_id ) ) {
                $sale      = $this -> MedicineModel -> get_sales_by_id ( $sale_id );
                $net_price = $sale -> net_price;
                $this -> MedicineModel -> update_sale_total ( $net_price, $sale -> sale_id );
                $log = array (
                    'user_id'    => get_logged_in_user_id (),
                    'sale_id'    => $sale_id,
                    'invoice_id' => $sale_id,
                    'data'       => json_encode ( $sale )
                );
                $this -> MedicineModel -> add_sale_delete_log ( $log );
                $this -> MedicineModel -> delete_sale ( $sale_id );
//                $this -> MedicineModel -> update_pharmacy_ledger ( $net_price, $sale -> sale_id, cash_from_pharmacy );


//                $where = array (
//                    'acc_head_id' => sales_pharmacy,
//                    'invoice_id'  => $sale_id
//                );
//
//                $get_ledger = get_ledger ( $where );
//
//                $ledger[ 'acc_head_id' ] = sales_pharmacy;
//                $ledger[ 'transaction_type' ] = 'debit';
//                $ledger[ 'credit' ] = 0;
//                $ledger[ 'debit' ] = $get_ledger -> debit - $net_price;
//
//
//                $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => $sale -> sale_id,
                    'action'       => 'pharmacy_sale_deleted',
                    'log'          => ' ',
                    'after_update' => json_encode ( $sale_id ),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'pharmacy_sale_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Sale has been deleted. Please update the invoice.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * inactive medicine by id
         * -------------------------
         */
        
        public function delete_adjustment () {
            $adjustment_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $adjustment_id ) ) and $adjustment_id > 0 and is_numeric ( $adjustment_id ) ) {
                $adjustment = $this -> MedicineModel -> get_med_adjustment_by_id ( $adjustment_id );
                $net_price  = $adjustment -> net_price;
                $this -> MedicineModel -> update_adjustment_total ( $net_price, $adjustment -> adjustment_id );
                $this -> MedicineModel -> delete_adjustment ( $adjustment_id );
                
                $this -> session -> set_flashdata ( 'response', 'Success! Adjustment has been deleted.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete entire sale
         * do create log
         * -------------------------
         */
        
        public function delete_entire_sale () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $sale_id ) ) and $sale_id > 0 and is_numeric ( $sale_id ) ) {
                $sale = $this -> MedicineModel -> get_all_sales_by_sale_id ( $sale_id );
                $log  = array (
                    'user_id'    => get_logged_in_user_id (),
                    'sale_id'    => $sale_id,
                    'invoice_id' => $sale_id,
                    'data'       => json_encode ( $sale )
                );
                $this -> MedicineModel -> add_sale_delete_log ( $log );
                $this -> MedicineModel -> delete_entire_sale ( $sale_id );
                $condition = array (
                    'invoice_id' => $sale_id
                );
                $this -> AccountModel -> delete_ledger ( $condition );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => $sale_id,
                    'action'       => 'pharmacy_sale_deleted',
                    'log'          => ' ',
                    'after_update' => json_encode ( $sale_id ),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'pharmacy_sale_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Sale has been deleted.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete entire adjustment
         * do create log
         * -------------------------
         */
        
        public function delete_entire_adjustment () {
            $adjustment_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $adjustment_id ) ) and $adjustment_id > 0 and is_numeric ( $adjustment_id ) ) {
                $this -> MedicineModel -> delete_entire_adjustment ( $adjustment_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Adjustment has been deleted.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * add more stock input fields
         * -------------------------
         */
        
        public function add_more_stock () {
            $data[ 'added' ]     = $this -> input -> post ( 'added' );
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines ();
            $this -> load -> view ( '/medicines/add-more-stock', $data );
        }
        
        /**
         * -------------------------
         * return stock
         * search by supplier and
         * invoice number
         * -------------------------
         */
        
        public function return_stock () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_stock' )
                $this -> do_edit_stock ( $_POST );
            
            $title = site_name . ' - Return Stock';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $data[ 'stocks' ]    = $this -> MedicineModel -> get_stock_by_filter ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_active_medicines ();
            $this -> load -> view ( '/medicines/return-stock', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * update stock
         * update ledger
         * update grand total
         * -------------------------
         */
        
        public function do_edit_stock ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'supplier_id', 'supplier', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'supplier_invoice', 'supplier invoice number', 'required|trim|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () != false ) {
                $stock            = $this -> MedicineModel -> get_stock_by_invoice ( $data[ 'supplier_invoice' ] );
                $overall_discount = $this -> MedicineModel -> get_stock_over_all_discount_by_invoice ( $data[ 'supplier_invoice' ] );
                $stock_ledger     = $this -> MedicineModel -> get_stock_ledger_by_invoice ( $data[ 'supplier_invoice' ] );
                
                $stock_id         = 0;
                $user_id          = get_logged_in_user_id ();
                $supplier_id      = $data[ 'supplier_id' ];
                $supplier_invoice = $data[ 'supplier_invoice' ];
                $grand_total      = $data[ 'grand_total' ];
                
                if ( isset( $data[ 'medicine_id' ] ) and count ( array_filter ( $data[ 'medicine_id' ] ) ) > 0 ) {
                    foreach ( $data[ 'medicine_id' ] as $key => $medicine_id ) {
                        if ( isset( $data[ 'stock_id' ][ $key ] ) ) {
                            $stock_id = $data[ 'stock_id' ][ $key ];
                            $info     = array (
                                'user_id'                 => $user_id,
                                'batch'                   => $data[ 'batch' ][ $key ],
                                'expiry_date'             => date ( 'Y-m-d', strtotime ( $data[ 'expiry_date' ][ $key ] ) ),
                                'box_price'               => $data[ 'box_price' ][ $key ],
                                'box_qty'                 => $data[ 'box_qty' ][ $key ],
                                'quantity'                => $data[ 'quantity' ][ $key ],
                                'price'                   => $data[ 'price' ][ $key ],
                                'discount'                => $data[ 'discount' ][ $key ],
                                'sales_tax'               => $data[ 'sales_tax' ][ $key ],
                                'net_price'               => $data[ 'net' ][ $key ],
                                'units'                   => $data[ 'units' ][ $key ],
                                'tp_unit'                 => $data[ 'tp_unit' ][ $key ],
                                'sale_box'                => $data[ 'sale_box' ][ $key ],
                                'box_price_after_dis_tax' => $data[ 'box_price_after_dis_tax' ][ $key ],
                                'sale_unit'               => $data[ 'sale_unit' ][ $key ]
                            );
                            
                            /***********LOGS*************/
                            
                            $log = array (
                                'user_id'      => get_logged_in_user_id (),
                                'invoice'      => $data[ 'supplier_invoice' ],
                                'action'       => 'pharmacy_stock_medication_updated',
                                'log'          => ' ',
                                'after_update' => json_encode ( $info ),
                                'date_added'   => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'pharmacy_stock_logs', $log );
                            
                            /***********END LOG*************/
                            
                            
                            $this -> MedicineModel -> update_medicine_stock ( $info, $stock_id );
                            
                        }
                        else {
                            $info = array (
                                'user_id'                 => $user_id,
                                'supplier_id'             => $supplier_id,
                                'supplier_invoice'        => $supplier_invoice,
                                'medicine_id'             => $medicine_id,
                                'batch'                   => $data[ 'batch' ][ $key ],
                                'expiry_date'             => date ( 'Y-m-d', strtotime ( $data[ 'expiry_date' ][ $key ] ) ),
                                'box_qty'                 => $data[ 'box_qty' ][ $key ],
                                'units'                   => $data[ 'units' ][ $key ],
                                'quantity'                => $data[ 'quantity' ][ $key ],
                                'box_price'               => $data[ 'box_price' ][ $key ],
                                'price'                   => $data[ 'price' ][ $key ],
                                'discount'                => $data[ 'discount' ][ $key ],
                                'sales_tax'               => $data[ 'sales_tax' ][ $key ],
                                'net_price'               => $data[ 'net' ][ $key ],
                                'tp_unit'                 => $data[ 'tp_unit' ][ $key ],
                                'sale_box'                => $data[ 'sale_box' ][ $key ],
                                'box_price_after_dis_tax' => $data[ 'box_price_after_dis_tax' ][ $key ],
                                'sale_unit'               => $data[ 'sale_unit' ][ $key ],
                                'date_added'              => date ( 'Y-m-d H:i:s' )
                            );
                            $this -> MedicineModel -> add_stock ( $info );
                        }
                    }
                }
                
                if ( isset( $_POST[ 'grand_total_discount' ] ) ) {
                    $grand_total_discount = array (
                        'discount'    => $data[ 'grand_total_discount' ],
                        'grand_total' => $data[ 'grand_total' ],
                    );
                    
                    $this -> MedicineModel -> update_grand_total_discount ( $grand_total_discount, $supplier_invoice );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'invoice'      => $data[ 'supplier_invoice' ],
                        'action'       => 'pharmacy_stock_total_updated',
                        'log'          => ' ',
                        'after_update' => json_encode ( $grand_total_discount ),
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'pharmacy_stock_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
                
                $ledger = array (
                    'debit' => $grand_total,
                );
                $where  = array (
                    'acc_head_id' => $supplier_id,
                    'stock_id'    => $supplier_invoice
                );
                $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                
                $ledger = array (
                    'credit' => $grand_total,
                );
                $where  = array (
                    'acc_head_id' => medical_supply_inventory,
                    'stock_id'    => $supplier_invoice
                );
                $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'invoice'      => $data[ 'supplier_invoice' ],
                    'action'       => 'pharmacy_stock_ledger_updated',
                    'log'          => ' ',
                    'after_update' => json_encode ( $ledger ),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'pharmacy_stock_ledger_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Medicine stock updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            
        }
        
        /**
         * -------------------------
         * check stock expiry date
         * calculate difference
         * find out if stock will expire with in 90 days
         * prompt error, but let it selected.
         * -------------------------
         */
        
        public function check_stock_expiry_date_difference () {
            $stock_id = $this -> input -> post ( 'stock_id' );
            if ( !empty( trim ( $stock_id ) ) and is_numeric ( $stock_id ) and $stock_id > 0 ) {
                $expiry = $this -> MedicineModel -> check_stock_expiry_date_difference ( $stock_id );
                $date   = date ( 'Y-m-d' );
                
                $date1 = date_create ( $date );
                $date2 = date_create ( $expiry );
                
                $diff = date_diff ( $date1, $date2 );
                $days = $diff -> format ( "%a" );
                
                if ( $days <= 90 )
                    echo 'Stock will expire in <b>' . $days . '</b> days';
                else
                    echo 'false';
            }
            else {
                echo 'false';
            }
        }
        
        /**
         * -------------------------
         * check medicine type
         * determine if its special type
         * -------------------------
         */
        
        public function check_medicine_type () {
            $medicine_id = $this -> input -> post ( 'medicine_id' );
            if ( !empty( trim ( $medicine_id ) ) and is_numeric ( $medicine_id ) and $medicine_id > 0 ) {
                $medicine = get_medicine ( $medicine_id );
                if ( $medicine -> type == 'narcotics' or $medicine -> type == 'control' )
                    echo 'Medicine has a special type <b>' . ucfirst ( $medicine -> type ) . '</b>';
                else
                    echo 'false';
            }
            else {
                echo 'false';
            }
        }
        
        /**
         * -------------------------
         * return customer
         * add new stock as return customer
         * -------------------------
         */
        
        public function return_customer () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_return_customer' )
                $this -> do_return_customer ( $_POST );
            
            $title = site_name . ' - Return Customer';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines ();
            $this -> load -> view ( '/medicines/return-customer', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add customer return stock
         * -------------------------
         */
        
        public function do_return_customer ( $POST ) {
            $data             = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $date_added       = date ( 'Y-m-d', strtotime ( $data[ 'date_added' ] ) );
            $supplier_invoice = $data[ 'supplier_invoice' ];
            if ( isset( $data[ 'medicine_id' ] ) and count ( array_filter ( $data[ 'medicine_id' ] ) ) > 0 ) {
                $medicines        = array_filter ( $data[ 'medicine_id' ] );
                $paid_to_customer = 0;
                foreach ( $medicines as $key => $medicine ) {
                    if ( $medicine > 0 ) {
                        $paid_to_customer += $data[ 'paid_to_customer' ][ $key ];
                        $info             = array (
                            'user_id'          => get_logged_in_user_id (),
                            'supplier_id'      => $data[ 'supplier_id' ],
                            'supplier_invoice' => $data[ 'supplier_invoice' ],
                            'medicine_id'      => $medicine,
                            'batch'            => $data[ 'batch' ][ $key ],
                            'expiry_date'      => date ( 'Y-m-d', strtotime ( $data[ 'expiry_date' ][ $key ] ) ),
                            'box_qty'          => 0,
                            'units'            => 0,
                            'quantity'         => $data[ 'quantity' ][ $key ],
                            'box_price'        => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                            'price'            => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                            'discount'         => 0,
                            'sales_tax'        => 0,
                            'net_price'        => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                            'tp_unit'          => $data[ 'tp_unit' ][ $key ],
                            'sale_box'         => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                            'sale_unit'        => $data[ 'sale_unit' ][ $key ],
                            'paid_to_customer' => $data[ 'paid_to_customer' ][ $key ],
                            'returned'         => 1,
                            'date_added'       => $date_added . ' ' . date ( 'H:i:s' ),
                        );
                        
                        $this -> MedicineModel -> add_stock ( $info );
                        
                        /***********LOGS*************/
                        
                        $log = array (
                            'user_id'      => get_logged_in_user_id (),
                            'invoice'      => $data[ 'supplier_invoice' ],
                            'action'       => 'pharmacy_stock_return_customer_medication_added',
                            'log'          => json_encode ( $info ),
                            'after_update' => '',
                            'date_added'   => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'pharmacy_stock_logs', $log );
                        
                        /***********END LOG*************/
                    }
                    
                }
                $description = 'Medicine returned. Invoice# ' . $data[ 'supplier_invoice' ];
                $ledger      = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => cash_from_pharmacy,
                    'invoice_id'       => $data[ 'supplier_invoice' ],
                    'trans_date'       => $date_added,
                    'payment_mode'     => 'cash',
                    'paid_via'         => 'cash',
                    'transaction_type' => 'credit',
                    'credit'           => 0,
                    'debit'            => $paid_to_customer,
                    'description'      => $description,
                    'date_added'       => current_date_time (),
                );
                $this -> AccountModel -> add_ledger ( $ledger );
                
                $return_ledger = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => returns_and_allowances,
                    'invoice_id'       => $data[ 'supplier_invoice' ],
                    'trans_date'       => $date_added,
                    'payment_mode'     => 'cash',
                    'paid_via'         => 'cash',
                    'transaction_type' => 'credit',
                    'credit'           => $paid_to_customer,
                    'debit'            => 0,
                    'description'      => $description,
                    'date_added'       => current_date_time (),
                );
                $this -> AccountModel -> add_ledger ( $return_ledger );
                
                $return_ledger[ 'acc_head_id' ]      = medical_supply_inventory;
                $return_ledger[ 'transaction_type' ] = 'credit';
                $return_ledger[ 'credit' ]           = calculate_cost_of_medicines_returned ();
                $return_ledger[ 'debit' ]            = 0;
                $this -> AccountModel -> add_ledger ( $return_ledger );
                
                $return_ledger[ 'acc_head_id' ]      = cost_of_medicine_sold;
                $return_ledger[ 'transaction_type' ] = 'debit';
                $return_ledger[ 'credit' ]           = '0';
                $return_ledger[ 'debit' ]            = calculate_cost_of_medicines_returned ();
                $this -> AccountModel -> add_ledger ( $return_ledger );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'invoice'      => $data[ 'supplier_invoice' ],
                    'action'       => 'pharmacy_stock_return_customer_ledger_added',
                    'log'          => json_encode ( $ledger ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'pharmacy_stock_ledger_logs', $log );
                
                /***********END LOG*************/
                
                $print = '<a href="' . base_url ( '/invoices/return-customer-invoice/' . $supplier_invoice ) . '" target="_blank"> <strong>Print</strong> </a>';
                $this -> session -> set_flashdata ( 'response', 'Success! Returned medicine stock added. ' . $print );
                return redirect ( base_url ( '/medicines/return-customer' ) );
            }
        }
        
        /**
         * -------------------------
         * local purchases
         * -------------------------
         */
        
        public function local_purchases () {
            $title = site_name . ' - Local Purchases';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'medicines/local-purchases' );
            $total_row                      = $this -> MedicineModel -> count_local_purchases ();
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
            
            $data[ 'medicines' ] = $this -> MedicineModel -> get_all_medicines ();
            $data[ 'stocks' ]    = $this -> MedicineModel -> get_local_purchases ( $config[ "per_page" ], $offset );
            $str_links           = $this -> pagination -> create_links ();
            $data[ "links" ]     = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/medicines/local-purchases', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * local purchase
         * add new stock as local purchase
         * -------------------------
         */
        
        public function local_purchase () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_local_purchase' )
                $this -> do_add_local_purchase ( $_POST );
            
            $title = site_name . ' - Local Purchase';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines ();
            $this -> load -> view ( '/medicines/local-purchase', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add local purchase
         * -------------------------
         */
        
        public function do_add_local_purchase ( $POST ) {
            $data  = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $total = 0;
            if ( isset( $data[ 'medicine_id' ] ) and count ( array_filter ( $data[ 'medicine_id' ] ) ) > 0 ) {
                $medicines = array_filter ( $data[ 'medicine_id' ] );
                $invoice   = $data[ 'supplier_invoice' ];
                foreach ( $medicines as $key => $medicine ) {
                    $total = $total + ( $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ] );
                    $info  = array (
                        'user_id'          => get_logged_in_user_id (),
                        'supplier_id'      => local_purchase,
                        'supplier_invoice' => $data[ 'supplier_invoice' ],
                        'medicine_id'      => $medicine,
                        'batch'            => $data[ 'batch' ][ $key ],
                        'expiry_date'      => date ( 'Y-m-d', strtotime ( $data[ 'expiry_date' ][ $key ] ) ),
                        'box_qty'          => $data[ 'box_qty' ][ $key ],
                        'units'            => 0,
                        'quantity'         => $data[ 'quantity' ][ $key ],
                        'box_price'        => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                        'price'            => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                        'discount'         => 0,
                        'sales_tax'        => 0,
                        'net_price'        => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                        'tp_unit'          => $data[ 'tp_unit' ][ $key ],
                        'sale_box'         => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                        'sale_unit'        => $data[ 'sale_unit' ][ $key ],
                        'returned'         => 0,
                        'description'      => $data[ 'description' ][ $key ],
                        'date_added'       => date ( 'Y-m-d', strtotime ( $data[ 'date_added' ] ) ) . ' ' . date ( 'H"i:s' ),
                    );
                    $id    = $this -> MedicineModel -> add_stock ( $info );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'invoice'      => $data[ 'supplier_invoice' ],
                        'action'       => 'pharmacy_stock_local_purchase_added',
                        'log'          => json_encode ( $info ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'pharmacy_stock_logs', $log );
                    
                    /***********END LOG*************/
                    
                    $ledger = array (
                        'user_id'           => get_logged_in_user_id (),
                        'stock_id'          => $data[ 'supplier_invoice' ],
                        'invoice_id'        => $data[ 'supplier_invoice' ],
                        'acc_head_id'       => local_purchase,
                        'local_purchase_id' => $id,
                        'trans_date'        => date ( 'Y-m-d', strtotime ( $data[ 'date_added' ] ) ),
                        'payment_mode'      => 'cash',
                        'paid_via'          => 'cash',
                        'credit'            => 0,
                        'debit'             => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                        'transaction_type'  => 'debit',
                        'description'       => 'Local purchase customer.',
                        'date_added'        => current_date_time (),
                    );
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    $ledger[ 'credit' ] = $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ];
                    $ledger[ 'debit' ]  = 0;
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'invoice'      => $data[ 'supplier_invoice' ],
                        'action'       => 'pharmacy_stock_local_purchase_ledger_added',
                        'log'          => json_encode ( $ledger ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'pharmacy_stock_ledger_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
                
                $ledger = array (
                    'user_id'           => get_logged_in_user_id (),
                    'stock_id'          => $data[ 'supplier_invoice' ],
                    'invoice_id'        => $data[ 'supplier_invoice' ],
                    'acc_head_id'       => medical_supply_inventory,
                    'local_purchase_id' => local_purchase,
                    'trans_date'        => date ( 'Y-m-d', strtotime ( $data[ 'date_added' ] ) ),
                    'payment_mode'      => 'cash',
                    'paid_via'          => 'cash',
                    'credit'            => $total,
                    'debit'             => 0,
                    'transaction_type'  => 'credit',
                    'description'       => 'Local purchase customer.',
                    'date_added'        => current_date_time (),
                );
                $this -> AccountModel -> add_ledger ( $ledger );
                
                $ledger = array (
                    'user_id'           => get_logged_in_user_id (),
                    'acc_head_id'       => cash_from_pharmacy,
                    'local_purchase_id' => local_purchase,
                    'stock_id'          => $data[ 'supplier_invoice' ],
                    'invoice_id'        => $data[ 'supplier_invoice' ],
                    'trans_date'        => date ( 'Y-m-d', strtotime ( $data[ 'date_added' ] ) ),
                    'payment_mode'      => 'cash',
                    'paid_via'          => 'cash',
                    'credit'            => 0,
                    'debit'             => $total,
                    'transaction_type'  => 'debit',
                    'description'       => 'Local purchase customer.',
                    'date_added'        => current_date_time (),
                );
                $this -> AccountModel -> add_ledger ( $ledger );
                
                
                $this -> session -> set_flashdata ( 'response', 'Success! Local purchase stock added. <a href="' . base_url ( '/invoices/stock-invoice/' . $invoice . '?supplier_id=' . local_purchase ) . '" target="_blank"><strong>Print</strong></a>' );
                return redirect ( base_url ( '/medicines/local-purchase' ) );
            }
        }
        
        /**
         * -------------------------
         * return customer
         * edit stock as return customer
         * -------------------------
         */
        
        public function edit_return_customer () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_return_customer' )
                $this -> do_edit_return_customer ( $_POST );
            
            $title = site_name . ' - Edit Return Customer Stock';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines ();
            $data[ 'stock' ]     = $this -> MedicineModel -> get_medicine_stock_of_return_customer ();
            $this -> load -> view ( '/medicines/edit-return-customer', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit customer return stock
         * -------------------------
         */
        
        public function do_edit_return_customer ( $POST ) {
            $data        = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $search_date = @$_REQUEST[ 'date_added' ];
            $net_paid    = 0;
            
            if ( isset( $data[ 'stock_id' ] ) and count ( array_filter ( $data[ 'stock_id' ] ) ) > 0 ) {
                $stocks = array_filter ( $data[ 'stock_id' ] );
                foreach ( $stocks as $key => $value ) {
                    $supplier_invoice = $data[ 'supplier_invoice' ][ $key ];
                    $net_paid         += $data[ 'paid_to_customer' ][ $key ];
                    $info             = array (
                        'user_id'          => get_logged_in_user_id (),
                        'medicine_id'      => $data[ 'medicine_id' ][ $key ],
                        'expiry_date'      => date ( 'Y-m-d', strtotime ( $data[ 'expiry_date' ][ $key ] ) ),
                        'quantity'         => $data[ 'quantity' ][ $key ],
                        'box_price'        => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                        'price'            => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                        'net_price'        => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                        'tp_unit'          => $data[ 'tp_unit' ][ $key ],
                        'sale_box'         => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                        'sale_unit'        => $data[ 'sale_unit' ][ $key ],
                        'paid_to_customer' => $data[ 'paid_to_customer' ][ $key ],
                    );
                    $this -> MedicineModel -> update_return_customer_stock ( $info, $value );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'invoice'      => $supplier_invoice,
                        'action'       => 'pharmacy_stock_return_customer_updated',
                        'log'          => ' ',
                        'after_update' => json_encode ( $info ),
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'pharmacy_stock_logs', $log );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'invoice'      => $supplier_invoice,
                        'action'       => 'pharmacy_stock_return_customer_ledger_updated',
                        'log'          => ' ',
                        'after_update' => json_encode ( $ledger ),
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'pharmacy_stock_ledger_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
                
                $ledger = array (
                    'debit'  => $net_paid,
                    'credit' => 0,
                );
                
                $where = array (
                    'invoice_id'  => $supplier_invoice,
                    'acc_head_id' => cash_from_pharmacy,
                );
                $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                
                $return_ledger = array (
                    'credit' => $net_paid,
                    'debit'  => 0,
                );
                
                $where = array (
                    'invoice_id'  => $supplier_invoice,
                    'acc_head_id' => returns_and_allowances,
                );
                $this -> AccountModel -> update_general_ledger ( $return_ledger, $where );
                
                $ledger = array (
                    'credit' => calculate_cost_of_medicines_returned (),
                    'debit'  => 0,
                );
                
                $where = array (
                    'invoice_id'  => $supplier_invoice,
                    'acc_head_id' => medical_supply_inventory,
                );
                $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                
                $ledger = array (
                    'credit' => 0,
                    'debit'  => calculate_cost_of_medicines_returned (),
                );
                
                $where = array (
                    'invoice_id'  => $supplier_invoice,
                    'acc_head_id' => cost_of_medicine_sold,
                );
                $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                
                $this -> session -> set_flashdata ( 'response', 'Success! Returned medicine stock updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * local purchase
         * add new stock as local purchase
         * -------------------------
         */
        
        public function edit_local_purchase () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_local_purchase' )
                $this -> do_edit_local_purchase ( $_POST );
            
            $title = site_name . ' - Edit Local Purchase';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines ();
            $data[ 'purchases' ] = $this -> MedicineModel -> get_local_purchase ();
            $this -> load -> view ( '/medicines/edit-local-purchase', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit local purchase
         * -------------------------
         */
        
        public function do_edit_local_purchase ( $POST ) {
            $data  = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $total = 0;
            if ( isset( $data[ 'medicine_id' ] ) and count ( array_filter ( $data[ 'medicine_id' ] ) ) > 0 ) {
                $medicines = array_filter ( $data[ 'medicine_id' ] );
                foreach ( $medicines as $key => $medicine ) {
                    $total       = $total + ( $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ] );
                    $purchase_id = $data[ 'purchase_id' ][ $key ];
                    $info        = array (
                        'medicine_id' => $medicine,
                        'batch'       => $data[ 'batch' ][ $key ],
                        'expiry_date' => date ( 'Y-m-d', strtotime ( $data[ 'expiry_date' ][ $key ] ) ),
                        'box_qty'     => $data[ 'box_qty' ][ $key ],
                        'units'       => 0,
                        'quantity'    => $data[ 'quantity' ][ $key ],
                        'box_price'   => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                        'price'       => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                        'discount'    => 0,
                        'sales_tax'   => 0,
                        'net_price'   => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                        'tp_unit'     => $data[ 'tp_unit' ][ $key ],
                        'sale_box'    => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                        'sale_unit'   => $data[ 'sale_unit' ][ $key ],
                        'returned'    => 0,
                        'description' => $data[ 'description' ][ $key ],
                    );
                    $this -> MedicineModel -> update_stock ( $info, $purchase_id );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'invoice'      => $purchase_id,
                        'action'       => 'pharmacy_stock_local_purchase_updated',
                        'log'          => ' ',
                        'after_update' => json_encode ( $info ),
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'pharmacy_stock_logs', $log );
                    
                    /***********END LOG*************/
                    
                    $ledger = array (
                        'debit' => $data[ 'quantity' ][ $key ] * $data[ 'tp_unit' ][ $key ],
                    );
                    $this -> AccountModel -> update_local_ledger ( $ledger, $purchase_id );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'invoice'      => $purchase_id,
                        'action'       => 'pharmacy_stock_local_purchase_ledger_updated',
                        'log'          => ' ',
                        'after_update' => json_encode ( $ledger ),
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'pharmacy_stock_ledger_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
                
                $ledger = array (
                    'credit' => $total,
                    'debit'  => 0,
                );
                
                $where = array (
                    'acc_head_id'       => medical_supply_inventory,
                    'local_purchase_id' => local_purchase,
                    'trans_date'        => date ( 'Y-m-d' ),
                );
                $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                
                $ledger = array (
                    'credit' => 0,
                    'debit'  => $total,
                );
                
                $where = array (
                    'acc_head_id'       => cash_from_pharmacy,
                    'local_purchase_id' => local_purchase,
                    'trans_date'        => date ( 'Y-m-d' ),
                );
                $this -> AccountModel -> update_general_ledger ( $ledger, $where );
                
                $this -> session -> set_flashdata ( 'response', 'Success! Local purchase stock updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete stock
         * stock will be deleted permanently
         * -------------------------
         */
        
        public function delete_local_purchase () {
            $stock_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $stock_id ) ) ) {
                $this -> MedicineModel -> delete_local_purchase ( $stock_id );
                $this -> AccountModel -> delete_local_purchase ( $stock_id );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'invoice'      => $stock_id,
                    'action'       => 'pharmacy_stock_local_purchase_deleted',
                    'log'          => ' ',
                    'after_update' => json_encode ( $stock_id ),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'pharmacy_stock_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Stock has been deleted.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * get medicines last return
         * record to auto populate in form
         * -------------------------
         */
        
        public function get_medicine_last_return_record () {
            $medicine_id = $this -> input -> post ( 'medicine_id', true );
            $row         = $this -> input -> post ( 'row', true );
            if ( !empty( trim ( $medicine_id ) ) and $medicine_id > 0 and !empty( trim ( $row ) ) and $row > 0 ) {
                $stock = $this -> MedicineModel -> get_medicine_last_return_record ( $medicine_id );
                if ( !empty( $stock ) ) {
                    
                    if ( empty( trim ( $stock -> tp_unit ) ) )
                        $tp_unit = 0;
                    else
                        $tp_unit = $stock -> tp_unit;
                    
                    if ( empty( trim ( $stock -> sale_unit ) ) )
                        $sale_unit = 0;
                    else
                        $sale_unit = $stock -> sale_unit;
                    
                    if ( empty( trim ( $stock -> paid_to_customer ) ) )
                        $paid_to_customer = 0;
                    else
                        $paid_to_customer = $stock -> paid_to_customer;
                    
                    $info = array (
                        'tp_unit'          => $tp_unit,
                        'sale_unit'        => $sale_unit,
                        'paid_to_customer' => $paid_to_customer
                    );
                    echo json_encode ( $info );
                }
                else {
                    echo 'false';
                }
            }
            else {
                echo 'false';
            }
        }
        
        /**
         * -------------------------
         * check if invoice number already exists
         * -------------------------
         */
        
        public function check_if_invoice_already_exists () {
            $supplier_id    = $this -> input -> post ( 'supplier_id', true );
            $invoice_number = $this -> input -> post ( 'invoice_number', true );
            if ( !empty( trim ( $supplier_id ) ) and is_numeric ( $supplier_id ) and $supplier_id > 0 and !empty( trim ( $invoice_number ) ) ) {
                $isExists = $this -> MedicineModel -> check_if_invoice_number_already_exists ( $supplier_id, $invoice_number );
                if ( $isExists )
                    echo 'true';
                else
                    echo 'false';
            }
        }
        
        /**
         * -------------------------
         * get internal issuance par level
         * value by medicine id and department
         * -------------------------
         */
        
        public function get_internal_issuance () {
            $medicine      = $this -> input -> post ( 'medicine', true );
            $department_id = $this -> input -> post ( 'department_id', true );
            if ( !empty( trim ( $medicine ) ) and is_numeric ( $medicine ) and $medicine > 0 and !empty( trim ( $department_id ) ) ) {
                $issued = $this -> MedicineModel -> get_internal_issued_medicines_quantity ( $medicine, $department_id );
                $level  = $this -> MedicineModel -> get_internal_issuance_par_level ( $medicine, $department_id );
                //			echo $level - $issued;
                echo $level;
            }
        }
        
        /**
         * -------------------------
         * get ipd medicines requisitions
         * -------------------------
         */
        
        public function ipd_requisitions () {
            $title = site_name . ' - IPD Requisitions';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'requisitions' ] = $this -> MedicineModel -> get_ipd_medicine_requisitions ();
            $this -> load -> view ( '/medicines/ipd-requisitions', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * get medicine threshold value
         * by medicine id
         * -------------------------
         */
        
        public function get_medicine_threshold_value () {
            $medicine_id = $this -> input -> post ( 'medicine_id', true );
            if ( isset( $medicine_id ) and $medicine_id > 0 ) {
                $medicine = get_medicine ( $medicine_id );
                echo $medicine -> threshold;
            }
            else
                echo '0';
        }
        
        /**
         * -------------------------
         * get medicine threshold value
         * by medicine id
         * -------------------------
         */
        
        public function get_medicine_available_value () {
            $medicine_id = $this -> input -> post ( 'medicine_id', true );
            if ( isset( $medicine_id ) and $medicine_id > 0 ) {
                $medicine  = get_medicine ( $medicine_id );
                $sold      = get_sold_quantity ( $medicine -> id );
                $quantity  = get_stock_quantity ( $medicine -> id );
                $issued    = get_issued_quantity ( $medicine -> id );
                $available = $quantity - $sold - $issued;
                echo $available;
            }
            else
                echo '0';
        }
        
        /**
         * -------------------------
         * get medicine pack size value
         * by medicine id
         * -------------------------
         */
        
        public function get_medicine_pack_size () {
            $medicine_id = $this -> input -> post ( 'medicine_id', true );
            if ( isset( $medicine_id ) and $medicine_id > 0 ) {
                $medicine = get_medicine ( $medicine_id );
                echo $medicine -> quantity;
            }
            else
                echo '0';
        }
        
        /**
         * -------------------------
         * get medicine tp box value
         * by medicine id
         * -------------------------
         */
        
        public function get_medicine_tp_box_value () {
            $medicine_id = $this -> input -> post ( 'medicine_id', true );
            if ( isset( $medicine_id ) and $medicine_id > 0 ) {
                $medicine = get_medicine ( $medicine_id );
                echo $medicine -> tp_box;
            }
            else
                echo '0';
        }
        
        /**
         * -------------------------
         * all adjustments medicine page
         * -------------------------
         */
        
        public function adjustments () {
            $title = site_name . ' - Medicine Adjustments';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) )
                $limit = 50;
            else
                $limit = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'medicines/adjustments' );
            $total_row                      = $this -> MedicineModel -> count_adjustments ();
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
            
            $data[ 'sales' ] = $this -> MedicineModel -> get_adjustments ( $config[ "per_page" ], $offset );
            $str_links       = $this -> pagination -> create_links ();
            $data[ "links" ] = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/medicines/adjustments', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add adjustments medicine page
         * -------------------------
         */
        
        public function add_adjustments () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_medicine_adjustments' )
                $this -> do_add_medicine_adjustments ( $_POST );
            
            $title = site_name . ' - Add Adjustments';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines ();
            $this -> load -> view ( '/medicines/add_adjustments', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add medicines adjustments
         * -------------------------
         */
        
        public function do_add_medicine_adjustments ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            
            $medicines = array_filter ( $data[ 'medicine_id' ] );
            
            $this -> MedicineModel -> clear_medicine_sale ( get_logged_in_user_id () );
            if ( count ( $medicines ) > 0 ) {
                $sale          = array (
                    'user_id'    => get_logged_in_user_id (),
                    'total'      => $data[ 'total' ],
                    'date_added' => current_date_time (),
                );
                $adjustment_id = $this -> MedicineModel -> add_adjustments ( $sale );
                foreach ( $medicines as $key => $value ) {
                    if ( !empty( trim ( $value ) ) and $value > 0 ) {
                        $medicine_id = $value;
                        $stock_id    = $data[ 'stock_id' ][ $key ];
                        $quantity    = $data[ 'quantity' ][ $key ];
                        $price       = $data[ 'price' ][ $key ];
                        
                        if ( $stock_id > 0 ) {
                            $info = array (
                                'user_id'       => get_logged_in_user_id (),
                                'adjustment_id' => $adjustment_id,
                                'medicine_id'   => $medicine_id,
                                'stock_id'      => $stock_id,
                                'quantity'      => $quantity,
                                'price'         => $price,
                                'net_price'     => $quantity * $price,
                                'date_added'    => current_date_time (),
                            );
                            $this -> MedicineModel -> add_medicine_adjustments ( $info );
                        }
                    }
                }
                //			if ( $adjustment_id > 0 ) {
                //				$description = 'Medicine adjustment. Adjustment ID# ' . $adjustment_id;
                //				$ledger = array (
                //					'user_id'          => get_logged_in_user_id (),
                //					'acc_head_id'      => short_medicine_cost,
                //					'adjustment_id'    => $adjustment_id,
                //					'invoice_id'       => $adjustment_id,
                //					'trans_date'       => date ( 'Y-m-d' ),
                //					'payment_mode'     => 'cash',
                //					'paid_via'         => 'cash',
                //					'transaction_type' => 'credit',
                //					'credit'           => $data[ 'total' ],
                //					'debit'            => 0,
                //					'description'      => $description,
                //					'date_added'       => current_date_time (),
                //				);
                //				$this -> AccountModel -> add_ledger ( $ledger );
                //			}
                $this -> session -> set_flashdata ( 'response', 'Success! Adjustment added.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * edit adjustment page
         * -------------------------
         */
        
        public function edit_adjustment () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_adjustment' )
                $this -> do_edit_adjustment ( $_POST );
            
            $title = site_name . ' - Edit adjustment';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'sales' ] = $this -> MedicineModel -> get_adjustment_by_adjustment_id ();
            $this -> load -> view ( '/medicines/edit-adjustment', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do edit adjustment
         * -------------------------
         */
        
        public function do_edit_adjustment ( $POST ) {
            $data            = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $adjustment_id   = $data[ 'adjustment_id' ];
            $sale_ids        = array_filter ( $data[ 'id' ] );
            $total_net_price = $data[ 'total' ];
            
            if ( count ( $sale_ids ) > 0 ) {
                foreach ( $sale_ids as $key => $value ) {
                    $id        = $value;
                    $quantity  = $data[ 'quantity' ][ $key ];
                    $price     = $data[ 'price' ][ $key ];
                    $net_price = $data[ 'net_price' ][ $key ];
                    
                    $info = array (
                        'quantity'  => $quantity,
                        'price'     => $price,
                        'net_price' => $net_price,
                    );
                    $this -> MedicineModel -> edit_medicine_adjustment ( $info, $id );
                }
                $this -> MedicineModel -> update_overall_adjustment_total ( $total_net_price, $adjustment_id );
                if ( $adjustment_id > 0 ) {
                    $ledger = array (
                        'credit' => $data[ 'total' ],
                    );
                    $where  = array (
                        'adjustment_id' => $adjustment_id,
                    );
                    $this -> AccountModel -> update_adjustments_ledger ( $ledger, $where );
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Adjustment updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * save discarded medicines into DB
         * -------------------------
         */
        
        public function discard_expired_medicine () {
            $medicine_id = $this -> input -> get ( 'medicine-id', true );
            $stock_id    = $this -> input -> get ( 'stock-id', true );
            $batch       = $this -> input -> get ( 'batch', true );
            $quantity    = $this -> input -> get ( 'quantity', true );
            $net_cost    = $this -> input -> get ( 'net-cost', true );
            
            if ( !isset( $medicine_id ) or empty( trim ( $medicine_id ) ) or !isset( $stock_id ) or empty( trim ( $stock_id ) ) or !isset( $batch ) or empty( trim ( $batch ) ) ) {
                return redirect ( base_url ( '/medicines/expired-medicine-report/' ) );
            }
            
            $info = array (
                'user_id'     => get_logged_in_user_id (),
                'medicine_id' => $medicine_id,
                'stock_id'    => $stock_id,
                'batch_no'    => $batch,
                'quantity'    => $quantity,
                'net_cost'    => $net_cost,
            );
            $id   = $this -> MedicineModel -> discard_expired_medicine ( $info );
            if ( $id > 0 )
                $this -> session -> set_flashdata ( 'response', 'Success! Medicine has been discarded.' );
            else
                $this -> session -> set_flashdata ( 'response', 'Success! Adjustment updated.' );
            return redirect ( base_url ( '/medicines/expired-medicine-report/' ) );
        }
        
        /**
         * -------------------------
         * discarded expired medicines
         * -------------------------
         */
        
        public function discarded_expired_medicines () {
            $title = site_name . ' - Discarded Expired Medicines';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_discarded_expired_medicines ();
            $data[ 'users' ]     = $this -> UserModel -> get_active_users ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $this -> load -> view ( '/medicines/discarded-expired-medicines', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * return customer invoices
         * -------------------------
         */
        
        public function return_customer_invoices () {
            $title = site_name . ' - Return Customer Invoices';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'medicines/return-customer-invoices' );
            $total_row                      = $this -> MedicineModel -> count_return_medicines ();
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
            
            $data[ 'returns' ]  = $this -> MedicineModel -> get_return_medicines ( $config[ "per_page" ], $offset );
            $str_links          = $this -> pagination -> create_links ();
            $data[ "links" ]    = explode ( '&nbsp;', $str_links );
            $data[ 'generics' ] = $this -> MedicineModel -> get_generics ();
            $data[ 'forms' ]    = $this -> MedicineModel -> get_forms ();
            $data[ 'title' ]    = 'Return Customer Invoices';
            $this -> load -> view ( '/medicines/return-customer-invoices', $data );
            $this -> footer ();
        }
        
        public function get_medicine_for_add_stock () {
            $medicine_id = $this -> input -> post ( 'medicine_id' );
            $row         = $this -> input -> post ( 'row' );
            
            if ( is_numeric ( $medicine_id ) and $medicine_id > 0 and !empty( trim ( $medicine_id ) ) ) {
                $medicine = $this -> MedicineModel -> get_medicine ( $medicine_id );
                
                if ( !empty( $medicine ) ) {
                    
                    $name = $medicine -> name;
                    if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 )
                        $name .= get_form ( $medicine -> form_id ) -> title . '-' . get_strength ( $medicine -> strength_id ) -> title;
                    
                    $data = array (
                        'medicine' => $medicine,
                        'row'      => $row,
                        'name'     => $name
                    );
                    
                    $this -> load -> view ( 'medicines/add-stock-row', $data );
                }
            }
        }
        
        public function do_add_medicine_ajax () {
            
            $user_id = get_logged_in_user_id ();
            $data    = filter_var_array ( $_POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'name', 'medicine name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'generic_id', 'generic', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'strength_id', 'strength', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'form_id', 'form', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'manufacturer_id', 'manufacturer', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'threshold', 'threshold', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'tp_box', 'tp/box', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'quantity', 'quantity', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'tp_unit', 'tp/unit', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'sale_box', 'sale/box', 'required|trim|min_length[1]|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'sale_unit', 'sale/unit', 'required|trim|min_length[1]|numeric|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                
                $info = array (
                    'user_id'         => $user_id,
                    'name'            => $data[ 'name' ],
                    'generic_id'      => $data[ 'generic_id' ],
                    'strength_id'     => $data[ 'strength_id' ],
                    'form_id'         => $data[ 'form_id' ],
                    'manufacturer_id' => $data[ 'manufacturer_id' ],
                    'pack_size_id'    => $data[ 'pack_size_id' ],
                    'tp_box'          => $data[ 'tp_box' ],
                    'quantity'        => $data[ 'quantity' ],
                    'tp_unit'         => $data[ 'tp_unit' ],
                    'sale_box'        => $data[ 'sale_box' ],
                    'sale_unit'       => $data[ 'sale_unit' ],
                    'type'            => $data[ 'type' ],
                    'threshold'       => $data[ 'threshold' ],
                    'date_added'      => current_date_time (),
                );
                
                $where  = array (
                    'name'        => $data[ 'name' ],
                    'generic_id'  => $data[ 'generic_id' ],
                    'form_id'     => $data[ 'form_id' ],
                    'strength_id' => $data[ 'strength_id' ],
                );
                $exists = $this -> MedicineModel -> check_if_medicine_already_added ( $where );
                
                if ( !$exists ) {
                    $medicine_id = $this -> MedicineModel -> add ( $info );
                    if ( $medicine_id > 0 )
                        echo $medicine_id;
                    else
                        echo 'Error! Please try again.';
                }
                else {
                    echo 'Error! Medicine already exists.';
                }
            }
            else
                echo validation_errors ();
        }
        
        public function refund ( $id ) {
            
            try {
                $ci   = &get_instance ();
                $sale = get_sale ( $id );
                
                if ( !empty( $sale ) && $sale -> refunded == '0' ) {
                    $this -> db -> trans_start ();
                    ( new PharmacyService( $ci ) ) -> refund ( $sale );
                    $this -> db -> trans_complete ();
                    $this -> session -> set_flashdata ( 'response', 'Success! Invoice refunded.' );
                    return redirect ( base_url ( '/medicines/sales' ) );
                }
                else {
                    $this -> db -> trans_rollback ();
                    $this -> session -> set_flashdata ( 'error', 'Sale does not exists.' );
                    return redirect ( base_url ( '/medicines/sales' ) );
                }
                
            }
            catch ( Exception $exception ) {
                $this -> db -> trans_rollback ();
                $this -> session -> set_flashdata ( 'error', $exception -> getMessage () );
                return redirect ( base_url ( '/medicines/sales' ) );
            }
            
        }
        
        public function add_medicine_return_customer () {
            $medicine_id = $this -> input -> get ( 'medicine_id' );
            $row         = $this -> input -> get ( 'row' );
            
            if ( is_numeric ( $medicine_id ) and $medicine_id > 0 and !empty( trim ( $medicine_id ) ) ) {
                $medicine = $this -> MedicineModel -> get_medicine ( $medicine_id );
                
                if ( !empty( $medicine ) ) {
                    $name = $medicine -> name;
                    if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 )
                        $name .= get_form ( $medicine -> form_id ) -> title . '-' . get_strength ( $medicine -> strength_id ) -> title;
                    
                    $data = array (
                        'medicine'         => $medicine,
                        'row'              => $row,
                        'name'             => $name,
                        'tp_unit'          => $medicine -> tp_unit,
                        'sale_unit'        => $medicine -> sale_unit,
                        'paid_to_customer' => 0
                    );
                    
                    $this -> load -> view ( 'medicines/add-medicine-return-customer', $data );
                }
            }
        }
        
        public function add_local_purchase_row () {
            $medicine_id = $this -> input -> get ( 'medicine_id' );
            $row         = $this -> input -> get ( 'row' );
            
            if ( is_numeric ( $medicine_id ) and $medicine_id > 0 and !empty( trim ( $medicine_id ) ) ) {
                $medicine = $this -> MedicineModel -> get_medicine ( $medicine_id );
                
                if ( !empty( $medicine ) ) {
                    $name = $medicine -> name;
                    if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 )
                        $name .= get_form ( $medicine -> form_id ) -> title . '-' . get_strength ( $medicine -> strength_id ) -> title;
                    
                    $data = array (
                        'medicine'  => $medicine,
                        'row'       => $row,
                        'name'      => $name,
                        'tp_unit'   => $medicine -> tp_unit,
                        'sale_unit' => $medicine -> sale_unit,
                    );
                    
                    $this -> load -> view ( 'medicines/add-local-purchase', $data );
                }
            }
        }
        
        public function get_locked_medicines () {
            $data[ 'medicines' ] = $this -> MedicineModel -> get_locked_medicines ();
            $this -> load -> view ( 'medicines/locked-medicines', $data );
        }
        
    }
