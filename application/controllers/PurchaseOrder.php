<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class PurchaseOrder extends CI_Controller {
        
        /**
         * -------------------------
         * PurchaseOrder constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'MedicineModel' );
            $this -> load -> model ( 'SupplierModel' );
            $this -> load -> model ( 'PurchaseOrderModel' );
            $this -> load -> model ( 'StoreModel' );
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
         * Purchase order main page
         * load all orders
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - Purchase Orders';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'orders' ] = $this -> PurchaseOrderModel -> get_orders ();
            $this -> load -> view ( '/purchase-order/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add purchase order main page
         * -------------------------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_purchase_order' )
                $this -> do_add_purchase_order ( $_POST );
            
            $title = site_name . ' - Add Purchase Orders';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $this -> load -> view ( '/purchase-order/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add more purchase order
         * -------------------------
         */
        
        public function add_more_purchase_order () {
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $data[ 'row' ] = $_POST[ 'added' ];
            $this -> load -> view ( '/purchase-order/add-more', $data );
        }
        
        /**
         * -------------------------
         * @param $POST
         * add purchase orders
         * -------------------------
         */
        
        public function do_add_purchase_order ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'supplier_id', 'supplier', 'required|trim|numeric|xss_clean' );
            $purchase_id = 0;
            $unique_id = time ();
            if ( $this -> form_validation -> run () == true ) {
                
                if ( count ( $data[ 'medicine_id' ] ) > 0 ) {
                    foreach ( $data[ 'medicine_id' ] as $key => $medicine_id ) {
                        if ( !empty( trim ( $medicine_id ) ) and is_numeric ( $medicine_id ) > 0 ) {
                            $info = array (
                                'unique_id'   => $unique_id,
                                'user_id'     => get_logged_in_user_id (),
                                'supplier_id' => $data[ 'supplier_id' ],
                                'medicine_id' => $medicine_id,
                                'box_qty'     => $data[ 'box_qty' ][ $key ],
                                'tp'          => $data[ 'tp' ][ $key ],
                                'total'       => $data[ 'total' ][ $key ],
                                'order_date'  => current_date_time (),
                            );
                            $purchase_id = $this -> PurchaseOrderModel -> add ( $info );
                        }
                    }
                }
                if ( $purchase_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Order placed.  <a href="' . base_url ( '/invoices/purchase-order-invoice/' . $unique_id ) . '" target="_blank" style="font-weight: 800; font-size: 16px">Print</a>' );
                    return redirect ( base_url ( '/purchase-order/add' ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( base_url ( '/purchase-order/add' ) );
                }
            }
        }
        
        /**
         * -------------------------
         * update status to received
         * based on order id
         * -------------------------
         */
        
        public function received () {
            $order_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $order_id ) ) or !is_numeric ( $order_id ) or $order_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $info = array (
                'status' => '1'
            );
            $where = array (
                'unique_id' => $order_id
            );
            
            $updated = $this -> PurchaseOrderModel -> update ( $info, $where );
            if ( $updated ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Order updated' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Note! Order is already updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * update status to pending
         * based on order id
         * -------------------------
         */
        
        public function pending () {
            $order_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $order_id ) ) or !is_numeric ( $order_id ) or $order_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $info = array (
                'status' => '0'
            );
            $where = array (
                'unique_id' => $order_id
            );
            
            $updated = $this -> PurchaseOrderModel -> update ( $info, $where );
            if ( $updated ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Order updated' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Note! Order is already updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete purchase orders
         * based on order id
         * -------------------------
         */
        
        public function delete () {
            $order_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $order_id ) ) or !is_numeric ( $order_id ) or $order_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $where = array (
                'unique_id' => $order_id
            );
            
            $updated = $this -> PurchaseOrderModel -> delete ( $where );
            if ( $updated ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Order deleted' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete purchase orders
         * based on order id
         * -------------------------
         */
        
        public function delete_store () {
            $order_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $order_id ) ) or !is_numeric ( $order_id ) or $order_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $where = array (
                'unique_id' => $order_id
            );
            
            $updated = $this -> PurchaseOrderModel -> delete_store ( $where );
            if ( $updated ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Order deleted' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * Edit purchase order main page
         * based on order id
         * -------------------------
         */
        
        public function edit () {
            
            $order_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $order_id ) ) or !is_numeric ( $order_id ) or $order_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_purchase_order' )
                $this -> do_edit_purchase_order ( $_POST );
            
            $title = site_name . ' - Edit Purchase Orders';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'order' ] = $this -> PurchaseOrderModel -> get_order ( $order_id );
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $this -> load -> view ( '/purchase-order/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit purchase orders
         * -------------------------
         */
        
        public function do_edit_purchase_order ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'supplier_id', 'supplier', 'required|trim|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'medicine_id', 'medicine', 'required|trim|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'box_qty', 'quantity', 'required|trim|numeric|xss_clean' );
            $order_id = $data[ 'order_id' ];
            if ( $this -> form_validation -> run () == true ) {
                
                $info = array (
                    'supplier_id' => $data[ 'supplier_id' ],
                    'medicine_id' => $data[ 'medicine_id' ],
                    'box_qty'     => $data[ 'box_qty' ],
                );
                $where = array (
                    'id' => $order_id
                );
                $updated = $this -> PurchaseOrderModel -> update ( $info, $where );
                if ( $updated ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Order deleted' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        public function get_low_threshold_medicines () {
            $supplier_id = $this -> input -> post ( 'supplier_id', true );
            if ( !empty( trim ( $supplier_id ) ) and $supplier_id > 0 ) {
                $data[ 'medicines' ] = $this -> PurchaseOrderModel -> get_low_threshold_medicines ( $supplier_id );
                $this -> load -> view ( '/purchase-order/low-threshold', $data );
            }
        }
        
        
        /**
         * -------------------------
         * Store Purchase order main page
         * load all store orders
         * -------------------------
         */
        
        public function store_purchase_orders () {
            $title = site_name . ' - Purchase Orders (Store)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'orders' ] = $this -> PurchaseOrderModel -> get_store_orders ();
            $this -> load -> view ( '/purchase-order/store-orders', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add purchase order main page
         * -------------------------
         */
        
        public function add_store () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_store_purchase_order' )
                $this -> do_add_store_purchase_order ();
            
            $title = site_name . ' - Add Purchase Orders (Store)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'stores' ] = $this -> StoreModel -> get_all_store ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_store_suppliers ();
            $this -> load -> view ( '/purchase-order/add-store', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add more purchase order
         * -------------------------
         */
        
        public function add_more_store_purchase_order () {
            $data[ 'stores' ] = $this -> StoreModel -> get_all_store ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $data[ 'row' ] = $_POST[ 'added' ];
            $this -> load -> view ( '/purchase-order/add-more-store-purchase', $data );
        }
        
        /**
         * -------------------------
         * add store purchase orders
         * -------------------------
         */
        
        public function do_add_store_purchase_order () {
            $supplier_id = $this -> input -> post ( 'supplier_id' );
            $stores = $this -> input -> post ( 'store_id' );
            $quantity = $this -> input -> post ( 'box_qty' );
            $price = $this -> input -> post ( 'tp' );
            
            $unique_id = time ();
            
            if ( count ( $stores ) > 0 ) {
                foreach ( $stores as $key => $store_id ) {
                    if ( !empty( trim ( $store_id ) ) and $store_id > 0 ) {
                        $info = array (
                            'user_id'     => get_logged_in_user_id (),
                            'unique_id'   => $unique_id,
                            'supplier_id' => $supplier_id,
                            'store_id'    => $store_id,
                            'box_qty'     => $quantity[ $key ],
                            'tp'          => $price[ $key ],
                            'total'       => $quantity[ $key ] * $price[ $key ],
                            'order_date'  => date ( 'Y-m-d H:i:s' ),
                        );
                        $this -> PurchaseOrderModel -> add_store_order ( $info );
                    }
                }
                
                $this -> session -> set_flashdata ( 'response', 'Success! Order placed.  <a href="' . base_url ( '/invoices/store-purchase-order-invoice/' . $unique_id ) . '" target="_blank" style="font-weight: 800; font-size: 16px">Print</a>' );
                
                return redirect ( base_url ( '/purchase-order/add-store-purchase-order' ) );
            }
            
            $this -> session -> set_flashdata ( 'error', 'Error! Please select at least one store item.' );
            return redirect ( base_url ( '/purchase-order/add-store-purchase-order' ) );
        }
        
        public function get_medicine_for_purchase_order () {
            $medicine_id = $this -> input -> get ( 'medicine_id', true );
            $row = $this -> input -> get ( 'row', true );
            
            $data[ 'medicine' ] = get_medicine ( $medicine_id );
            $data[ 'available' ] = get_medicines_available_quantity_by_medicine_id ( $medicine_id );
            $data[ 'row' ] = $row;
            $this -> load -> view ( '/purchase-order/load-medicine-purchase-order', $data );
        }
        
        /**
         * -------------------------
         * Add more purchase order
         * -------------------------
         */
        
        public function load_store_purchase_order () {
            $item_id = $this -> input -> get ( 'item_id' );
            $row = $this -> input -> get ( 'row' );
            $data[ 'item' ] = get_store_by_id ( $item_id );
            $data[ 'row' ] = $row;
            $this -> load -> view ( '/purchase-order/add-more-store-purchase', $data );
        }
        
    }