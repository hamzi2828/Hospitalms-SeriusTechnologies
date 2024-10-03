<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class SupplierModel extends CI_Model {
        
        /**
         * -------------------------
         * SupplierModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save suppliers into database
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'suppliers', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get suppliers
         * -------------------------
         */
        
        public function get_suppliers () {
            $suppliers = $this -> db -> get_where ( 'account_heads', array ( 'parent_id' => supplier_id ) );
            return $suppliers -> result ();
        }
        
        /**
         * -------------------------
         * @param $supplier_id
         * @return mixed
         * get supplier by id
         * -------------------------
         */
        
        public function get_supplier_by_id ( $supplier_id ) {
            $supplier = $this -> db -> get_where ( 'account_heads', array ( 'id' => $supplier_id ) );
            return $supplier -> row ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get active suppliers
         * -------------------------
         */
        
        public function get_active_suppliers () {
            $supplier = $this -> db -> get_where ( 'account_heads', array ( 'status' => '1', 'parent_id' => supplier_id ) );
            return $supplier -> result ();
        }
        
        public function get_child_suppliers ( $parent_id ) {
            $supplier = $this -> db -> get_where ( 'account_heads', array ( 'status' => '1', 'parent_id' => $parent_id ) );
            return $supplier -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get active suppliers
         * -------------------------
         */
        
        public function get_active_store_suppliers () {
            $supplier = $this -> db -> get_where ( 'account_heads', array ( 'status' => '1', 'parent_id' => STORE_SUPPLIER ) );
            return $supplier -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $supplier_id
         * @return mixed
         * update supplier info
         * -------------------------
         */
        
        public function edit ( $data, $supplier_id ) {
            $this -> db -> update ( 'suppliers', $data, array ( 'id' => $supplier_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $supplier_id
         * @return mixed
         * update supplier info
         * -------------------------
         */
        
        public function delete ( $supplier_id ) {
            $this -> db -> update ( 'suppliers', array ( 'status' => '0' ), array ( 'id' => $supplier_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $supplier_id
         * @return mixed
         * update supplier info
         * -------------------------
         */
        
        public function reactive ( $supplier_id ) {
            $this -> db -> update ( 'suppliers', array ( 'status' => '1' ), array ( 'id' => $supplier_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $supplier_id
         * @return mixed
         * get stocks provided by supplier
         * -------------------------
         */
        
        public function get_stocks_by_supplier_id ( $supplier_id ) {
            $this -> db -> order_by ( 'id', 'DESC' );
            $stocks = $this -> db -> get_where ( 'medicines_stock', array ( 'supplier_id' => $supplier_id ) );
            return $stocks -> result ();
        }
        
    }