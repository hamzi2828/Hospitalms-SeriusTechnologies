<?php
    
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class StockReturn extends CI_Controller {
        
        /**
         * -------------------------
         * StockReturn constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'MedicineModel' );
            $this -> load -> model ( 'AccountModel' );
            $this -> load -> model ( 'SupplierModel' );
            $this -> load -> model ( 'AccountModel' );
            $this -> load -> model ( 'StockReturnModel' );
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
         * stock return main page
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - Stock Return';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'returned' ] = $this -> StockReturnModel -> get_returned_stock ();
            $this -> load -> view ( '/stock-return/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add stock return page
         * -------------------------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_return_stock' )
                $this -> do_add_return_stock ( $_POST );
            
            $title = site_name . ' - Add Stock Return';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'stocks' ] = $this -> MedicineModel -> get_supplier_stock ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $this -> load -> view ( '/stock-return/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add return stock
         * update ledger
         * add return total
         * -------------------------
         */
        
        public function do_add_return_stock ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            if ( count ( $data[ 'medicine_id' ] ) > 0 ) {
                $total = $data[ 'total' ];
                $supplier_id = $data[ 'supplier_id' ];
                $invoice = $data[ 'invoice' ];
                $return = array (
                    'user_id'     => get_logged_in_user_id (),
                    'total'       => $total,
                    'supplier_id' => $supplier_id,
                    'invoice'     => $invoice,
                    'date_added'  => current_date_time (),
                );
                $return_id = $this -> StockReturnModel -> add ( $return );
                foreach ( $data[ 'medicine_id' ] as $key => $medicine ) {
                    if ( !empty( trim ( $medicine ) ) and is_numeric ( $medicine ) > 0 ) {
                        $supplier = $supplier_id;
                        $medicine_id = $medicine;
                        $stock_id = $data[ 'stock_id' ][ $key ];
                        $return_qty = $data[ 'return_qty' ][ $key ];
                        $cost_unit = $data[ 'cost_unit' ][ $key ];
                        $net_price = $data[ 'net_price' ][ $key ];
                        $info = array (
                            'return_id'   => $return_id,
                            'user_id'     => get_logged_in_user_id (),
                            'supplier_id' => $supplier,
                            'medicine_id' => $medicine_id,
                            'stock_id'    => $stock_id,
                            'invoice'     => $invoice,
                            'return_qty'  => $return_qty,
                            'cost_unit'   => $cost_unit,
                            'net_price'   => $net_price,
                            'date_added'  => current_date_time (),
                        );
                        $this -> StockReturnModel -> add_return ( $info );
                    }
                }
                $ledger_description = 'Stock return. Invoice# ' . $invoice;
                $ledger = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => $supplier_id,
                    'stock_id'         => $invoice,
                    'invoice_id'       => $invoice,
                    'payment_mode'     => 'none',
                    'paid_via'         => '',
                    'transaction_type' => 'credit',
                    'credit'           => $total,
                    'debit'            => '0',
                    'description'      => $ledger_description,
                    'trans_date'       => date ( 'Y-m-d' ),
                    'date_added'       => current_date_time (),
                );
                $this -> AccountModel -> add_ledger ( $ledger );
                
                $ledger[ 'acc_head_id' ] = medical_supply_inventory;
                $ledger[ 'transaction_type' ] = 'credit';
                $ledger[ 'credit' ] = '0';
                $ledger[ 'debit' ] = $total;
                $this -> AccountModel -> add_ledger ( $ledger );
                
                
                $this -> session -> set_flashdata ( 'response', 'Success! Stock returned. <a href="' . base_url ( '/invoices/stock-return-invoice/' . $return_id ) . '" target="_blank" style="font-weight: 800; font-size: 16px">Print</a>' );
                return redirect ( base_url ( '/stock-return/add-stock-returns' ) );
            }
        }
        
        /**
         * -------------------------
         * check if stock exists
         * by supplier and invoice
         * -------------------------
         */
        
        public function check_invoice_exists () {
            $invoice = $this -> input -> post ( 'invoice', true );
            $supplier_id = $this -> input -> post ( 'supplier_id', true );
            if ( !empty( trim ( $invoice ) ) and !empty( trim ( $supplier_id ) ) and is_numeric ( $supplier_id ) > 0 ) {
                $exists = $this -> StockReturnModel -> check_invoice_exists ( $invoice, $supplier_id );
                if ( $exists )
                    echo 'true';
                else
                    echo 'false';
            }
        }
        
        /**
         * -------------------------
         * delete entire sale
         * put an entry in ledger
         * -------------------------
         */
        
        public function delete () {
            $return_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $return_id ) ) and is_numeric ( $return_id ) > 0 ) {
                $return = get_return ( $return_id );
                if ( !empty( $return ) ) {
                    $ledger_description = 'Returned stock deleted. Invoice#' . $return -> invoice;
                    $ledger = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => $return -> supplier_id,
                        'stock_id'         => $return -> invoice,
                        'invoice_id'       => $return -> invoice,
                        'payment_mode'     => 'none',
                        'paid_via'         => '',
                        'transaction_type' => 'debit',
                        'credit'           => $return -> total,
                        'debit'            => '0',
                        'description'      => $ledger_description,
                        'trans_date'       => date ( 'Y-m-d' ),
                    );
                    $this -> AccountModel -> add_ledger ( $ledger );
                    $this -> StockReturnModel -> delete ( $return_id );
                    $this -> session -> set_flashdata ( 'response', 'Success! Returned stock deleted.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
            else {
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * edit stock return page
         * -------------------------
         */
        
        public function edit () {
            
            $return_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $return_id ) ) or !is_numeric ( $return_id ) or $return_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_return_stock' )
                $this -> do_edit_return_stock ( $_POST );
            
            $title = site_name . ' - Edit Stock Return';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $data[ 'returns' ] = $this -> StockReturnModel -> get_returns ( $return_id );
            $data[ 'return_info' ] = $this -> StockReturnModel -> get_return ( $return_id );
            $this -> load -> view ( '/stock-return/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit return stock
         * update ledger
         * edit return total
         * -------------------------
         */
        
        public function do_edit_return_stock ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $return_id = $data[ 'return_id' ];
            if ( count ( $data[ 'return' ] ) > 0 ) {
                $total = $data[ 'total' ];
                $return = array (
                    'total' => $total,
                );
                $this -> StockReturnModel -> update_return ( $return, $return_id );
                foreach ( $data[ 'return' ] as $key => $return ) {
                    if ( !empty( trim ( $return ) ) and is_numeric ( $return ) > 0 ) {
                        $return_qty = $data[ 'return_qty' ][ $key ];
                        $cost_unit = $data[ 'cost_unit' ][ $key ];
                        $net_price = $data[ 'net_price' ][ $key ];
                        $info = array (
                            'return_qty' => $return_qty,
                            'cost_unit'  => $cost_unit,
                            'net_price'  => $net_price
                        );
                        $this -> StockReturnModel -> update_returns ( $info, $return );
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Stock return updated.' );
            }
        }
        
        /**
         * -------------------------
         * delete entire sale
         * put an entry in ledger
         * -------------------------
         */
        
        public function delete_return () {
            $return_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $return_id ) ) and is_numeric ( $return_id ) > 0 ) {
                $single_return = $this -> StockReturnModel -> get_single_return ( $return_id );
                $net_price = $single_return -> net_price;
                $this -> StockReturnModel -> update_return_total ( $net_price, $single_return -> return_id );
                $return = get_return ( $single_return -> return_id );
                if ( !empty( $return ) ) {
                    $ledger_description = 'Returned stock deleted. Invoice#' . $return -> invoice . ' Return ID#' . $return_id;
                    $ledger = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => $return -> supplier_id,
                        'stock_id'         => $return -> invoice,
                        'invoice_id'       => $return -> invoice,
                        'payment_mode'     => 'none',
                        'paid_via'         => '',
                        'transaction_type' => 'debit',
                        'credit'           => $return -> total,
                        'debit'            => '0',
                        'description'      => $ledger_description,
                        'trans_date'       => date ( 'Y-m-d' ),
                    );
                    $this -> AccountModel -> add_ledger ( $ledger );
                    $this -> StockReturnModel -> delete_return ( $return_id );
                    $this -> session -> set_flashdata ( 'response', 'Success! Returned stock deleted.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
            else {
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
    }
