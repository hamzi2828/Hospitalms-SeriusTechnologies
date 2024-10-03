<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class PurchaseOrderModel extends CI_Model {
        
        /**
         * -------------------------
         * PurchaseOrderModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @return mixed
         * add purchase orders
         * -------------------------
         */
        
        public function add ( $info ) {
            $this -> db -> insert ( 'purchase_orders', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @return mixed
         * add store purchase orders
         * -------------------------
         */
        
        public function add_store_order ( $info ) {
            $this -> db -> insert ( 'store_purchase_orders', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all orders, order
         * by pending
         * -------------------------
         */
        
        public function get_orders () {
            $this -> db -> order_by ( 'status', 'ASC' );
            $orders = $this -> db -> query ( "Select GROUP_CONCAT(tp) as tp, SUM(total) as total, supplier_id, unique_id, GROUP_CONCAT(medicine_id) as medicine_id, GROUP_CONCAT(box_qty) as box_qty, status, order_date from hmis_purchase_orders GROUP BY unique_id order by ID DESC" );
            return $orders -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all orders, order
         * by pending
         * -------------------------
         */
        
        public function get_store_orders () {
            $this -> db -> order_by ( 'status', 'ASC' );
            $orders = $this -> db -> query ( "Select GROUP_CONCAT(tp) as tp, SUM(total) as total, supplier_id, unique_id, GROUP_CONCAT(store_id) as stores, GROUP_CONCAT(box_qty) as box_qty, status, order_date from hmis_store_purchase_orders GROUP BY unique_id order by ID DESC" );
            return $orders -> result ();
        }
        
        /**
         * -------------------------
         * @param $order_id
         * get all orders, by id
         * -------------------------
         * @return mixed
         */
        
        public function get_orders_by_id ( $order_id ) {
            $orders = $this -> db -> query ( "Select * from hmis_purchase_orders where unique_id=$order_id" );
            return $orders -> result ();
        }
        
        /**
         * -------------------------
         * @param $order_id
         * get all orders, by id
         * -------------------------
         * @return mixed
         */
        
        public function get_store_orders_by_id ( $order_id ) {
            $orders = $this -> db -> query ( "Select * from hmis_store_purchase_orders where unique_id=$order_id" );
            return $orders -> result ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $where
         * @return mixed
         * update purchase order
         * -------------------------
         */
        
        public function update ( $info, $where ) {
            $this -> db -> update ( 'purchase_orders', $info, $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $where
         * @return mixed
         * delete purchase order
         * -------------------------
         */
        
        public function delete ( $where ) {
            $this -> db -> delete ( 'purchase_orders', $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $where
         * @return mixed
         * delete purchase order
         * -------------------------
         */
        
        public function delete_store ( $where ) {
            $this -> db -> delete ( 'store_purchase_orders', $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $order_id
         * get all orders, order
         * by pending
         * -------------------------
         * @return mixed
         */
        
        public function get_order ( $order_id ) {
            $order = $this -> db -> get_where ( 'purchase_orders', array ( 'id' => $order_id ) );
            return $order -> row ();
        }
        
        /**
         * -------------------------
         * @param $supplier_id
         * @return mixed
         * get all medicines that has low threshold values
         * -------------------------
         */
        
        public function get_low_threshold_medicines ( $supplier_id ) {
            $query = $this -> db -> query ( "Select SUM(quantity) as quantity, medicine_id from hmis_medicines_stock where supplier_id=$supplier_id group by medicine_id" );
            return $query -> result ();
        }
        
    }