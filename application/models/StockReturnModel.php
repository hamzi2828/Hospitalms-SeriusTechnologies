<?php
    defined ('BASEPATH') OR exit('No direct script access allowed');
    
    class StockReturnModel extends CI_Model {
        
        /**
         * -------------------------
         * StockReturnModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * insert return into database
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ('returns', $data);
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * insert returns into database
         * -------------------------
         */
        
        public function add_return ( $data ) {
            $this -> db -> insert ('return_stock', $data);
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $invoice
         * @param $supplier_id
         * @return bool
         * check if stock exists
         * by supplier and invoice
         * -------------------------
         */
        
        public function check_invoice_exists ( $invoice, $supplier_id ) {
            $stock = $this -> db -> get_where ('medicines_stock', array ( 'supplier_id' => $supplier_id, 'supplier_invoice' => $invoice ));
            if ( $stock -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get returned stock
         * by latest
         * -------------------------
         */
        
        public function get_returned_stock () {
            $stock = $this -> db -> query ("SELECT return_id, date_added, supplier_id, cost_unit, invoice, GROUP_CONCAT(medicine_id) as medicines, GROUP_CONCAT(cost_unit) as cost_unit, GROUP_CONCAT(stock_id) as stock, SUM(return_qty) as return_qty, SUM(net_price) as net_price FROM `hmis_return_stock` GROUP BY return_id ORDER BY id DESC");
            return $stock -> result ();
        }
        
        /**
         * -------------------------
         * @param $return_id
         * get return
         * @return mixed
         * -------------------------
         */
        
        public function get_return ( $return_id ) {
            $return = $this -> db -> get_where ('returns', array ( 'id' => $return_id ));
            return $return -> row ();
        }
        
        /**
         * -------------------------
         * @param $return_id
         * delete returned stock as whole
         * -------------------------
         */
        
        public function delete ( $return_id ) {
            $this -> db -> delete ('returns', array ( 'id' => $return_id ));
        }
        
        /**
         * -------------------------
         * @param $return_id
         * get returns
         * @return mixed
         * -------------------------
         */
        
        public function get_returns ( $return_id ) {
            $return = $this -> db -> get_where ('return_stock', array ( 'return_id' => $return_id ));
            return $return -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $return_id
         * @return mixed
         * update stock return main table
         * -------------------------
         */
        
        public function update_return ( $data, $return_id ) {
            $this -> db -> update ('returns', $data, array ( 'id' => $return_id ));
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $return_id
         * @return mixed
         * update stock returns
         * -------------------------
         */
        
        public function update_returns ( $data, $return_id ) {
            $this -> db -> update ('return_stock', $data, array ( 'id' => $return_id ));
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $return_id
         * get single return
         * @return mixed
         * -------------------------
         */
        
        public function get_single_return ( $return_id ) {
            $return = $this -> db -> get_where ('return_stock', array ( 'id' => $return_id ));
            return $return -> row ();
        }
        
        /**
         * -------------------------
         * @param $net_price
         * @param $return_id
         * update return total
         * -------------------------
         */
        
        public function update_return_total ( $net_price, $return_id ) {
            $qry = "UPDATE hmis_returns SET total = (total - $net_price) WHERE id=$return_id";
            $this -> db -> query ($qry);
        }
        
        /**
         * -------------------------
         * @param $return_id
         * delete returned stock
         * -------------------------
         */
        
        public function delete_return ( $return_id ) {
            $this -> db -> delete ('return_stock', array ( 'id' => $return_id ));
        }
        
    }