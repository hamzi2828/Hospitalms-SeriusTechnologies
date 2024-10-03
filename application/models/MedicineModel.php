<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class MedicineModel extends CI_Model {
        
        /**
         * -------------------------
         * MedicineModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save medicines into database
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'medicines', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * discard expired medicines into database
         * -------------------------
         */
        
        public function discard_expired_medicine ( $data ) {
            $this -> db -> insert ( 'discarded_expired_medicines', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get medicines
         * -------------------------
         */
        
        public function get_medicines () {
            $this -> db -> order_by ( 'name', 'ASC' );
            $medicines = $this -> db -> get_where ( 'medicines', array ( 'status' => '1' ) );
            return $medicines -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get medicines
         * -------------------------
         */
        
        public function get_medicines_that_has_stock () {
            $medicines = $this -> db -> query ( "Select * from hmis_medicines where status='1' and id IN (Select medicine_id from hmis_medicines_stock) order by name ASC" );
            return $medicines -> result ();
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * get all medicines
         * -------------------------
         * @return mixed
         */
        
        public function get_all_medicines ( $limit = -1, $offset = 0 ) {
            $sql = "Select * from hmis_medicines where 1";
            
            if ( isset( $_REQUEST[ 'medicine_name' ] ) and !empty( trim ( $_REQUEST[ 'medicine_name' ] ) ) ) {
                $medicine_name = filter_var ( $_REQUEST[ 'medicine_name' ], FILTER_SANITIZE_STRING );
                $sql           .= " and name LIKE '%$medicine_name%'";
            }
            
            if ( isset( $_REQUEST[ 'generic' ] ) and !empty( trim ( $_REQUEST[ 'generic' ] ) ) and is_numeric ( $_REQUEST[ 'generic' ] ) > 0 ) {
                $generic = $_REQUEST[ 'generic' ];
                $sql     .= " and generic_id=$generic";
            }
            
            if ( isset( $_REQUEST[ 'form' ] ) and !empty( trim ( $_REQUEST[ 'form' ] ) ) and is_numeric ( $_REQUEST[ 'form' ] ) > 0 ) {
                $form = $_REQUEST[ 'form' ];
                $sql  .= " and form_id=$form";
            }
            
            $sql .= " order by name ASC";
            
            if ( $limit > 0 )
                $sql .= " limit $limit offset $offset";
            
            $medicines = $this -> db -> query ( $sql );
            return $medicines -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get inactive medicines
         * -------------------------
         */
        
        public function get_inactive_medicines () {
            $medicines = $this -> db -> get_where ( 'medicines', array ( 'status' => '0' ) );
            return $medicines -> result ();
        }
        
        public function get_active_medicines () {
            $medicines = $this -> db -> get_where ( 'medicines', array ( 'status' => '1' ) );
            return $medicines -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * count active medicines
         * -------------------------
         */
        
        public function count_active_medicines () {
            $medicines = $this -> db -> get_where ( 'medicines', array ( 'status' => '1' ) );
            return $medicines -> num_rows ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * count all medicines
         * -------------------------
         */
        
        public function count_medicines () {
            $sql = "Select COUNT(*) as totalRows from hmis_medicines where 1";
            if ( isset( $_REQUEST[ 'medicine_name' ] ) and !empty( trim ( $_REQUEST[ 'medicine_name' ] ) ) ) {
                $medicine_name = filter_var ( $_REQUEST[ 'medicine_name' ], FILTER_SANITIZE_STRING );
                $sql           .= " and name LIKE '%$medicine_name%'";
            }
            
            if ( isset( $_REQUEST[ 'generic' ] ) and !empty( trim ( $_REQUEST[ 'generic' ] ) ) and is_numeric ( $_REQUEST[ 'generic' ] ) > 0 ) {
                $generic = $_REQUEST[ 'generic' ];
                $sql     .= " and generic_id=$generic";
            }
            
            if ( isset( $_REQUEST[ 'form' ] ) and !empty( trim ( $_REQUEST[ 'form' ] ) ) and is_numeric ( $_REQUEST[ 'form' ] ) > 0 ) {
                $form = $_REQUEST[ 'form' ];
                $sql  .= " and form_id=$form";
            }
            $medicines = $this -> db -> query ( $sql );
            return $medicines -> row () -> totalRows;
        }
        
        /**
         * -------------------------
         * @return mixed
         * count inactive medicines
         * -------------------------
         */
        
        public function count_inactive_medicines () {
            $medicines = $this -> db -> get_where ( 'medicines', array ( 'status' => '0' ) );
            return $medicines -> num_rows ();
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * reactivate medicine
         * -------------------------
         */
        
        public function reactivate ( $medicine_id ) {
            $this -> db -> update ( 'medicines', array ( 'status' => '1' ), array ( 'id' => $medicine_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * inactive medicine
         * -------------------------
         */
        
        public function inactive ( $medicine_id ) {
            $this -> db -> update ( 'medicines', array ( 'status' => '0' ), array ( 'id' => $medicine_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get medicine by id
         * -------------------------
         */
        
        public function get_medicine ( $medicine_id ) {
            $medicine = $this -> db -> get_where ( 'medicines', array ( 'id' => $medicine_id ) );
            return $medicine -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $medicine_id
         * @return mixed
         * update medicine
         * -------------------------
         */
        
        public function edit ( $data, $medicine_id ) {
            $this -> db -> update ( 'medicines', $data, array ( 'id' => $medicine_id ) );
            return $this -> db -> affected_rows ();
        }
        
        public function edit_sale ( $data, $sale_id ) {
            $this -> db -> update ( 'sales', $data, array ( 'id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add medicine stock
         * -------------------------
         */
        
        public function add_stock ( $data ) {
            $this -> db -> insert ( 'medicines_stock', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all medicine stock
         * -------------------------
         */
        
        public function get_all_stocks () {
            $stocks = $this -> db -> get ( 'medicines_stock' );
            return $stocks -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * validate batch number
         * -------------------------
         */
        
        public function validate_batch_number ( $data ) {
            $validate = $this -> db -> get_where ( 'medicines_stock', $data );
            return $validate -> num_rows ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * validate invoice number
         * -------------------------
         */
        
        public function validate_invoice_number ( $data ) {
            $validate = $this -> db -> get_where ( 'medicines_stock', $data );
            return $validate -> num_rows ();
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get stocks
         * -------------------------
         */
        
        public function get_stocks ( $medicine_id ) {
            $this -> db -> order_by ( 'id', 'DESC' );
            $stocks = $this -> db -> get_where ( 'medicines_stock', array ( 'medicine_id' => $medicine_id ) );
            return $stocks -> result ();
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get expired stocks
         * -------------------------
         */
        
        public function get_expired_stocks ( $medicine_id ) {
            //		$this -> db -> order_by ( 'id', 'DESC' );
            //		$stocks = $this -> db -> get_where ( 'medicines_stock', array (
            //			'medicine_id'    => $medicine_id,
            //			'expiry_date <=' => date ( 'Y-m-d' )
            //		) );
            $date   = date ( 'Y-m-d' );
            $stocks = $this -> db -> query ( "Select id, user_id, supplier_id, supplier_invoice, medicine_id, batch, expiry_date, box_qty, units, quantity, box_price, price, discount, sales_tax, box_price_after_dis_tax, net_price, tp_unit, sale_box, sale_unit, description, paid_to_customer, status, returned, date_added, date_updated, (SUM(quantity) - IFNULL((Select SUM(quantity) from hmis_medicines_sold where medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(return_qty) from hmis_return_stock where medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(quantity) from hmis_medicines_internal_issuance where medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(quantity) from hmis_medicines_adjustments where medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(quantity) from hmis_ipd_medication where medicine_id='$medicine_id'), 0)) as total from hmis_medicines_stock where medicine_id='$medicine_id' AND expiry_date <= '$date' having total > 0" );
            return $stocks -> result ();
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * return total number of sold medicines
         * -------------------------
         */
        
        public function get_sold_quantity ( $medicine_id ) {
            $sold = $this -> db -> query ( "Select SUM(quantity) as total from hmis_medicines_sold where medicine_id=$medicine_id and sale_id IN (Select id from hmis_sales where refunded='0')" );
            //            $sold = $this -> db -> query ( "Select SUM(quantity) as total from hmis_medicines_sold where medicine_id=$medicine_id and stock_id IN (Select id from hmis_medicines_stock where medicine_id=$medicine_id)" );
            return $sold -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * return total number of sold medicines
         * -------------------------
         */
        
        public function get_sold_quantity_by_date_filter ( $medicine_id ) {
            //            $sql = "Select SUM(quantity) as total from hmis_medicines_sold where medicine_id=$medicine_id and stock_id IN (Select id from hmis_medicines_stock where medicine_id=$medicine_id)";
            $sql = "Select SUM(quantity) as total from hmis_medicines_sold where medicine_id=$medicine_id and sale_id IN (Select id from hmis_sales where refunded='0')";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_sold) BETWEEN '$start_date' and '$end_date'";
            }
            $sold = $this -> db -> query ( $sql );
            return $sold -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @param $stock_id
         * @return mixed
         * return total number of sold medicines
         * -------------------------
         */
        
        public function get_sold_quantity_by_stock ( $medicine_id, $stock_id ) {
            $sold = $this -> db -> query ( "Select SUM(quantity) as total from hmis_medicines_sold where stock_id=$stock_id and medicine_id=$medicine_id and sale_id IN (Select id from hmis_sales where refunded='0')" );
            return $sold -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * return total number of medicines
         * -------------------------
         */
        
        public function get_stock_quantity ( $medicine_id ) {
            $date  = date ( 'Y-m-d' );
            $stock = $this -> db -> query ( "Select SUM(quantity) as total from hmis_medicines_stock where medicine_id=$medicine_id and status='1'" );
            return $stock -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * return total number of medicines
         * -------------------------
         */
        
        public function get_stock_quantity_by_date_filter ( $medicine_id ) {
            $date = date ( 'Y-m-d' );
            $sql  = "Select SUM(quantity) as total from hmis_medicines_stock where medicine_id=$medicine_id and status='1'";
            //            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
            //                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
            //                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
            //                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            //            }
            $stock = $this -> db -> query ( $sql );
            return $stock -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * return total number of expired medicines
         * -------------------------
         */
        
        public function get_stock_expired_quantity ( $medicine_id ) {
            $date = date ( 'Y-m-d' );
            //            if (get_logged_in_user_id () == 1) {
            //                $expired = $this -> db -> query ( "Select SUM(quantity) as total from hmis_medicines_stock where medicine_id=$medicine_id AND expiry_date < '$date'" );
            //
            //                $sold = $this -> db -> query ( "Select SUM(quantity) as total from hmis_medicines_sold where medicine_id=$medicine_id and stock_id  IN (Select id from hmis_medicines_stock where expiry_date < '$date')" );
            //
            //                $issued = $this -> db -> query ( "Select SUM(quantity) as total from hmis_medicines_internal_issuance where medicine_id=$medicine_id and stock_id  IN (Select id from hmis_medicines_stock where expiry_date < '$date')" );
            //
            //                $ipdIssued = $this -> db -> query ( "Select SUM(quantity) as total from hmis_ipd_medication where medicine_id=$medicine_id and stock_id  IN (Select id from hmis_medicines_stock where expiry_date < '$date')" );
            //
            //
            //                return ( $expired -> row () -> total - $sold -> row () -> total - $issued -> row () -> total - $ipdIssued -> row () -> total );
            
            //            }
            
            $stock = $this -> db -> query ( "Select SUM(quantity) as total from hmis_medicines_stock where medicine_id=$medicine_id AND expiry_date < '$date' and (id, medicine_id) NOT IN (Select stock_id, medicine_id from hmis_medicines_sold) and (id, medicine_id) NOT IN (Select stock_id, medicine_id from hmis_medicines_internal_issuance) and (id, medicine_id) NOT IN (Select stock_id, medicine_id from hmis_ipd_medication)" );
            return $stock -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * return total number of expired medicines
         * -------------------------
         */
        
        public function get_stock_expired_quantity_by_date_filter ( $medicine_id ) {
            $date = date ( 'Y-m-d' );
            $sql  = "Select (SUM(quantity) - IFNULL((Select SUM(quantity) from hmis_medicines_sold where medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(return_qty) from hmis_return_stock where medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(quantity) from hmis_medicines_internal_issuance where medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(quantity) from hmis_medicines_adjustments where medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(quantity) from hmis_ipd_medication where medicine_id='$medicine_id'), 0)) as total from hmis_medicines_stock where medicine_id=$medicine_id AND expiry_date < '$date' and id NOT IN (Select stock_id from hmis_medicines_sold) and id NOT IN (Select stock_id from hmis_medicines_internal_issuance) and id NOT IN (Select stock_id from hmis_ipd_medication)";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $stock = $this -> db -> query ( $sql );
            return $stock -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * return total number of expired medicines
         * -------------------------
         */
        
        public function get_expired_by_stock ( $stock_id, $medicine_id ) {
            $date  = date ( 'Y-m-d' );
            $stock = $this -> db -> query ( "Select (SUM(quantity) - IFNULL((Select SUM(quantity) from hmis_medicines_sold where stock_id='$stock_id' and medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(return_qty) from hmis_return_stock where stock_id='$stock_id' and medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(quantity) from hmis_medicines_internal_issuance where stock_id='$stock_id' and medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(quantity) from hmis_medicines_adjustments where stock_id='$stock_id' and medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(quantity) from hmis_ipd_medication where stock_id='$stock_id' and medicine_id='$medicine_id'), 0)) as total from hmis_medicines_stock where id=$stock_id and medicine_id='$medicine_id' and expiry_date < '$date'" );
            
            return $stock -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * return stock
         * -------------------------
         */
        
        public function get_stock ( $stock_id ) {
            $stock = $this -> db -> get_where ( 'medicines_stock', array ( 'id' => $stock_id ) );
            return $stock -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $stock_id
         * @return mixed
         * update stock
         * -------------------------
         */
        
        public function update_stock ( $data, $stock_id ) {
            $this -> db -> update ( 'medicines_stock', $data, array ( 'id' => $stock_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $stock_id
         * @return mixed
         * update stock
         * -------------------------
         */
        
        public function update_return_customer_stock ( $data, $stock_id ) {
            $this -> db -> update ( 'medicines_stock', $data, array ( 'id' => $stock_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * make stock inactive
         * -------------------------
         */
        
        public function delete_stock ( $stock_id ) {
            $this -> db -> update ( 'medicines_stock', array ( 'status' => '0' ), array ( 'id' => $stock_id ) );
        }
        
        /**
         * -------------------------
         * @param $supplier_invoice
         * @return mixed
         * delete stock
         * -------------------------
         */
        
        public function delete_stock_permanently ( $supplier_invoice ) {
            $this -> db -> delete ( 'medicines_stock', array ( 'supplier_invoice' => $supplier_invoice ) );
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * delete stock
         * -------------------------
         */
        
        public function delete_local_purchase ( $stock_id ) {
            $this -> db -> delete ( 'medicines_stock', array ( 'id' => $stock_id ) );
        }
        
        /**
         * -------------------------
         * @param $user_id
         * clear medicine sale
         * -------------------------
         */
        
        public function clear_medicine_sale ( $user_id ) {
            $this -> db -> delete ( 'medicine_sale_session', array ( 'user_id' => $user_id ) );
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * delete stock
         * -------------------------
         */
        
        public function delete_stock_permanently_by_id ( $stock_id ) {
            $this -> db -> delete ( 'medicines_stock', array ( 'id' => $stock_id ) );
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * delete stock
         * -------------------------
         */
        
        public function delete_stock_by_stock_id ( $stock_id ) {
            $this -> db -> delete ( 'medicines_stock', array ( 'id' => $stock_id ) );
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * make stock active
         * -------------------------
         */
        
        public function activate_stock ( $stock_id ) {
            $this -> db -> update ( 'medicines_stock', array ( 'status' => '1' ), array ( 'id' => $stock_id ) );
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get medicine stock
         * -------------------------
         */
        
        public function get_medicine_stock ( $medicine_id ) {
            $date  = date ( 'Y-m-d' );
            $stock = $this -> db -> query ( "Select * from hmis_medicines_stock where medicine_id=$medicine_id and expiry_date > '$date' and status='1' order by expiry_date ASC" );
            return $stock -> result ();
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @param $stock_id
         * @return int
         * count quantity sold
         * -------------------------
         */
        
        public function check_quantity_sold ( $medicine_id, $stock_id ) {
            if ( $medicine_id > 0 and $stock_id > 0 ) {
                $sold = $this -> db -> query ( "Select SUM(quantity) as sold from hmis_medicines_sold where medicine_id=$medicine_id and stock_id=$stock_id and sale_id IN (Select id from hmis_sales where refunded='0')" );
                return $sold -> row () -> sold;
            }
            else {
                return 0;
            }
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @param $stock_id
         * @return int
         * count quantity issued
         * -------------------------
         */
        
        public function check_issued_quantity ( $medicine_id, $stock_id ) {
            if ( $medicine_id > 0 and $stock_id > 0 ) {
                $sold = $this -> db -> query ( "Select SUM(quantity) as sold from hmis_medicines_internal_issuance where medicine_id=$medicine_id and stock_id=$stock_id" );
                return $sold -> row () -> sold;
            }
            else {
                return 0;
            }
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @param $stock_id
         * @return int
         * count quantity stock issued
         * -------------------------
         */
        
        public function check_stock_issued_quantity ( $stock_id ) {
            if ( $stock_id > 0 ) {
                $sold = $this -> db -> query ( "Select SUM(quantity) as sold from hmis_medicines_internal_issuance where stock_id=$stock_id" );
                return $sold -> row () -> sold;
            }
            else {
                return 0;
            }
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return int
         * get available stock by stock id
         * -------------------------
         */
        
        public function get_stock_available_quantity ( $stock_id = 0 ) {
            if ( $stock_id > 0 ) {
                $available = $this -> db -> query ( "Select sale_unit, tp_unit, quantity, (Select SUM(quantity) from hmis_medicines_sold where stock_id=$stock_id) as sold from hmis_medicines_stock where id=$stock_id and sale_id IN (Select id from hmis_sales where refunded='0')" );
                if ( $available -> num_rows () > 0 ) {
                    return $available -> row ();
                }
                else {
                    return 0;
                }
            }
            return 0;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @param $stock_id
         * @return int
         * get available stock by stock id
         * -------------------------
         */
        
        public function get_stock_available_quantity_by_stock_and_medicine ( $medicine_id, $stock_id ) {
            $available = $this -> db -> query ( "Select sale_unit, tp_unit, quantity, (Select SUM(quantity) from hmis_medicines_sold where stock_id=$stock_id and medicine_id=$medicine_id and sale_id IN (Select id from hmis_sales where refunded='0')) as sold from hmis_medicines_stock where id=$stock_id and medicine_id=$medicine_id" );
            if ( $available -> num_rows () > 0 ) {
                return $available -> row ();
            }
            else {
                return 0;
            }
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * get transaction id by stock id
         * -------------------------
         */
        
        public function get_transaction_id_by_stock_id ( $stock_id ) {
            $query = $this -> db -> query ( "Select id from hmis_general_ledger where stock_id='$stock_id'" );
            if ( $query -> num_rows () > 0 )
                return $query -> row () -> id;
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * create id for sale
         * -------------------------
         */
        
        public function add_sale ( $data ) {
            $this -> db -> insert ( 'sales', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * create id for adjustments
         * -------------------------
         */
        
        public function add_adjustments ( $data ) {
            $this -> db -> insert ( 'adjustments', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add adjustments
         * -------------------------
         */
        
        public function add_medicine_adjustments ( $data ) {
            $this -> db -> insert ( 'medicines_adjustments', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * create id for issuance
         * -------------------------
         */
        
        public function add_issuance ( $data ) {
            $this -> db -> insert ( 'issuance', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * do sale medicine
         * -------------------------
         */
        
        public function sale_medicine ( $data ) {
            $this -> db -> insert ( 'medicines_sold', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * do issue medicine
         * -------------------------
         */
        
        public function issue_medicine ( $data ) {
            $this -> db -> insert ( 'medicines_internal_issuance', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * do issue medicine
         * -------------------------
         */
        
        public function return_issued_medicine ( $data ) {
            $this -> db -> insert ( 'medicines_internal_issuance_return', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $id
         * @return mixed
         * delete issue medicine
         * -------------------------
         */
        
        public function delete_issue_medicine_by_issuance_id ( $id ) {
            $this -> db -> delete ( 'medicines_internal_issuance', array ( 'sale_id' => $id ) );
        }
        
        /**
         * -------------------------
         * @param $id
         * @return mixed
         * delete issue medicine
         * -------------------------
         */
        
        public function delete_issue_medicine_returned ( $id ) {
            $this -> db -> delete ( 'medicines_internal_issuance_return', array ( 'sale_id' => $id ) );
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $sale_id
         * @return mixed
         * do edit sale medicine
         * -------------------------
         */
        
        public function edit_sale_medicine ( $data, $sale_id ) {
            $this -> db -> update ( 'medicines_sold', $data, array ( 'id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $sale_id
         * @return mixed
         * do edit medicine adjustments
         * -------------------------
         */
        
        public function edit_medicine_adjustment ( $data, $sale_id ) {
            $this -> db -> update ( 'hmis_medicines_adjustments', $data, array ( 'id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $where
         * @return mixed
         * get sales by Invoice ID
         * -------------------------
         */
        
        public function get_sales_by_sale_id ( $where ) {
            $stock = $this -> db -> get_where ( 'medicines_sold', $where );
            return $stock -> result ();
        }
        
        /**
         * -------------------------
         * @param $id
         * @return mixed
         * get sales by id
         * -------------------------
         */
        
        public function get_sales_by_id ( $id ) {
            $sale = $this -> db -> get_where ( 'medicines_sold', array ( 'id' => $id ) );
            return $sale -> row ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get all sales by Invoice ID
         * -------------------------
         */
        
        public function get_all_sales_by_sale_id ( $sale_id ) {
            $sale = $this -> db -> get_where ( 'medicines_sold', array ( 'sale_id' => $sale_id ) );
            return $sale -> result ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * get sales by Invoice ID
         * -------------------------
         * @return mixed
         */
        
        public function get_sale ( $sale_id ) {
            $stock = $this -> db -> get_where ( 'medicines_sold', array ( 'sale_id' => $sale_id ) );
            return $stock -> result ();
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get sales
         * -------------------------
         */
        
        public function get_sales ( $limit, $offset ) {
            $sql = "Select sale_id, GROUP_CONCAT(quantity) as quantity, GROUP_CONCAT(price) as price, patient_id, GROUP_CONCAT(medicine_id) as medicine_id, GROUP_CONCAT(stock_id) as stock_id, SUM(net_price) as net_price, date_sold from hmis_medicines_sold where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_sold) BETWEEN '$start_date' and '$end_date'";
            }
            if ( isset( $_REQUEST[ 'customer' ] ) and !empty( trim ( $_REQUEST[ 'customer' ] ) ) ) {
                $name = stripcslashes ( strip_tags ( $_REQUEST[ 'customer' ] ) );
                $sql  .= " and sale_id IN (SELECT id FROM hmis_sales where customer_name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                if ( $patient_id > 0 and is_numeric ( $patient_id ) )
                    $sql .= " and patient_id=$patient_id";
            }
            $sql   .= " group by sale_id order by id DESC limit $limit offset $offset";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get adjustments
         * -------------------------
         */
        
        public function get_adjustments ( $limit, $offset ) {
            $sql = "Select adjustment_id, GROUP_CONCAT(quantity) as quantity, GROUP_CONCAT(price) as price, GROUP_CONCAT(medicine_id) as medicine_id, GROUP_CONCAT(stock_id) as stock_id, SUM(net_price) as net_price, date_added from hmis_medicines_adjustments where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            
            if ( isset( $_REQUEST[ 'medicine' ] ) and !empty( trim ( $_REQUEST[ 'medicine' ] ) ) ) {
                $medicine_name = filter_var ( $_REQUEST[ 'medicine' ], FILTER_SANITIZE_STRING );
                $sql           .= " and medicine_id IN (Select id from hmis_medicines where name LIKE '%$medicine_name%')";
            }
            
            $sql   .= " group by adjustment_id order by id DESC limit $limit offset $offset";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * count total sales record
         * -------------------------
         */
        
        public function count_sales () {
            $sql = "Select id from hmis_medicines_sold where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_sold) BETWEEN '$start_date' and '$end_date'";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                if ( $patient_id > 0 and is_numeric ( $patient_id ) )
                    $sql .= " and patient_id=$patient_id";
            }
            $sql   .= " group by sale_id";
            $sales = $this -> db -> query ( $sql );
            return $sales -> num_rows ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * count total adjustments record
         * -------------------------
         */
        
        public function count_adjustments () {
            $sql = "Select id from hmis_medicines_adjustments where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $sql   .= " group by adjustment_id";
            $sales = $this -> db -> query ( $sql );
            return $sales -> num_rows ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * count total medicines
         * -------------------------
         */
        
        public function count_all_medicines () {
            return $this -> db -> count_all_results ( 'medicines' );
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * delete sale
         * -------------------------
         */
        
        public function delete_sale ( $sale_id ) {
            $this -> db -> delete ( 'medicines_sold', array ( 'id' => $sale_id ) );
        }
        
        /**
         * -------------------------
         * @param $adjustment_id
         * delete adjustment
         * -------------------------
         */
        
        public function delete_adjustment ( $adjustment_id ) {
            $this -> db -> delete ( 'hmis_medicines_adjustments', array ( 'id' => $adjustment_id ) );
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * delete medicine
         * -------------------------
         */
        
        public function delete_medicine ( $medicine_id ) {
            $this -> db -> delete ( 'medicines', array ( 'id' => $medicine_id ) );
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * delete sale
         * -------------------------
         */
        
        public function delete_entire_sale ( $sale_id ) {
            $this -> db -> delete ( 'medicines_sold', array ( 'sale_id' => $sale_id ) );
        }
        
        /**
         * -------------------------
         * @param $adjustment_id
         * delete adjustment
         * -------------------------
         */
        
        public function delete_entire_adjustment ( $adjustment_id ) {
            $this -> db -> delete ( 'hmis_adjustments', array ( 'id' => $adjustment_id ) );
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * do log delete sale
         * -------------------------
         */
        
        public function add_sale_delete_log ( $data ) {
            $this -> db -> insert ( 'sales_delete_log', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * do log edit sale
         * -------------------------
         */
        
        public function add_sale_edit_log ( $data ) {
            $this -> db -> insert ( 'edit_sale_log', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add generic
         * -------------------------
         */
        
        public function add_generic ( $data ) {
            $this -> db -> insert ( 'generics', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $generic_id
         * @return mixed
         * get generic
         * -------------------------
         */
        
        public function get_generic ( $generic_id ) {
            $stock = $this -> db -> get_where ( 'generics', array ( 'id' => $generic_id ) );
            return $stock -> row ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get generics
         * -------------------------
         */
        
        public function get_generics () {
            $stock = $this -> db -> get ( 'generics' );
            return $stock -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $generic_id
         * @return mixed
         * edit generic
         * -------------------------
         */
        
        public function edit_generic ( $data, $generic_id ) {
            $this -> db -> update ( 'generics', $data, array ( 'id' => $generic_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $generic_id
         * @return mixed
         * delete generic
         * -------------------------
         */
        
        public function delete_generic ( $generic_id ) {
            $this -> db -> delete ( 'generics', array ( 'id' => $generic_id ) );
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add strength
         * -------------------------
         */
        
        public function add_strength ( $data ) {
            $this -> db -> insert ( 'strength', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add medicine strength
         * -------------------------
         */
        
        public function add_medicine_strengths ( $data ) {
            $this -> db -> insert ( 'medicine_strengths', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add medicine forms
         * -------------------------
         */
        
        public function add_medicine_forms ( $data ) {
            $this -> db -> insert ( 'medicine_forms', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add medicine generics
         * -------------------------
         */
        
        public function add_medicine_generics ( $data ) {
            $this -> db -> insert ( 'medicine_generics', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $strength_id
         * @return mixed
         * get strength
         * -------------------------
         */
        
        public function get_strength ( $strength_id ) {
            $stock = $this -> db -> get_where ( 'strength', array ( 'id' => $strength_id ) );
            return $stock -> row ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get strength
         * -------------------------
         */
        
        public function get_strengths () {
            $stock = $this -> db -> get ( 'strength' );
            return $stock -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $strength_id
         * @return mixed
         * edit strength
         * -------------------------
         */
        
        public function edit_strength ( $data, $strength_id ) {
            $this -> db -> update ( 'strength', $data, array ( 'id' => $strength_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $strength_id
         * @return mixed
         * delete strength
         * -------------------------
         */
        
        public function delete_strength ( $strength_id ) {
            $this -> db -> delete ( 'strength', array ( 'id' => $strength_id ) );
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add form
         * -------------------------
         */
        
        public function add_form ( $data ) {
            $this -> db -> insert ( 'forms', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add_stock_update_log
         * -------------------------
         */
        
        public function add_stock_update_log ( $data ) {
            $this -> db -> insert ( 'stock_update_log', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * add_grand_total_discount
         * -------------------------
         */
        
        public function add_grand_total_discount ( $data ) {
            $this -> db -> insert ( 'stock_invoice_discount', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $form_id
         * @return mixed
         * get form
         * -------------------------
         */
        
        public function get_form ( $form_id ) {
            $stock = $this -> db -> get_where ( 'forms', array ( 'id' => $form_id ) );
            return $stock -> row ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get form
         * -------------------------
         */
        
        public function get_forms () {
            $this -> db -> order_by ( 'title', 'ASC' );
            $stock = $this -> db -> get ( 'forms' );
            return $stock -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $form_id
         * @return mixed
         * edit form
         * -------------------------
         */
        
        public function edit_form ( $data, $form_id ) {
            $this -> db -> update ( 'forms', $data, array ( 'id' => $form_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $form_id
         * @return mixed
         * delete form
         * -------------------------
         */
        
        public function delete_form ( $form_id ) {
            $this -> db -> delete ( 'forms', array ( 'id' => $form_id ) );
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @param $generic_id
         * @return bool
         * check if medicine generic exists
         * -------------------------
         */
        
        public function check_medicine_generics ( $medicine_id, $generic_id ) {
            $check = $this -> db -> get_where ( 'medicine_generics', array (
                'medicine_id' => $medicine_id,
                'generic_id'  => $generic_id
            ) );
            if ( $check -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @param $form_id
         * @return bool
         * check if medicine form exists
         * -------------------------
         */
        
        public function check_medicine_forms ( $medicine_id, $form_id ) {
            $check = $this -> db -> get_where ( 'medicine_forms', array (
                'medicine_id' => $medicine_id,
                'form_id'     => $form_id
            ) );
            if ( $check -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @param $strength_id
         * @return bool
         * check if medicine strength exists
         * -------------------------
         */
        
        public function check_medicine_strength ( $medicine_id, $strength_id ) {
            $check = $this -> db -> get_where ( 'medicine_strengths', array (
                'medicine_id' => $medicine_id,
                'strength_id' => $strength_id
            ) );
            if ( $check -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * delete generics
         * -------------------------
         */
        
        public function delete_generics ( $medicine_id ) {
            $this -> db -> delete ( 'medicine_generics', array ( 'medicine_id' => $medicine_id ) );
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * delete forms
         * -------------------------
         */
        
        public function delete_forms ( $medicine_id ) {
            $this -> db -> delete ( 'medicine_forms', array ( 'medicine_id' => $medicine_id ) );
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * delete strengths
         * -------------------------
         */
        
        public function delete_strengths ( $medicine_id ) {
            $this -> db -> delete ( 'medicine_strengths', array ( 'medicine_id' => $medicine_id ) );
        }
        
        /**
         * -------------------------
         * @return mixed
         * get stock by filter
         * -------------------------
         */
        
        public function get_stock_by_filter () {
            if ( isset( $_REQUEST[ 'supplier_id' ] ) and $_REQUEST[ 'supplier_id' ] > 0 and is_numeric ( $_REQUEST[ 'supplier_id' ] ) and isset( $_REQUEST[ 'supplier_invoice' ] ) and !empty( trim ( $_REQUEST[ 'supplier_invoice' ] ) ) ) {
                $sql = "Select * from hmis_medicines_stock where 1";
                if ( isset( $_REQUEST[ 'supplier_id' ] ) and $_REQUEST[ 'supplier_id' ] > 0 and is_numeric ( $_REQUEST[ 'supplier_id' ] ) ) {
                    $supplier_id = $_REQUEST[ 'supplier_id' ];
                    $sql         .= " and supplier_id=$supplier_id";
                }
                if ( isset( $_REQUEST[ 'supplier_invoice' ] ) and !empty( trim ( $_REQUEST[ 'supplier_invoice' ] ) ) ) {
                    $supplier_invoice = $_REQUEST[ 'supplier_invoice' ];
                    $sql              .= " and supplier_invoice LIKE '$supplier_invoice'";
                }
                if ( isset( $_REQUEST[ 'date_added' ] ) and !empty( trim ( $_REQUEST[ 'date_added' ] ) ) ) {
                    $date_added = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'date_added' ] ) );
                    $sql        .= " and DATE(date_added)='$date_added'";
                }
                $stocks = $this -> db -> query ( $sql );
                return $stocks -> result ();
            }
            return array ();
        }
        
        /**
         * -------------------------
         * @param $invoice
         * @return mixed
         * get grand total by invoice number
         * -------------------------
         */
        
        public function get_grand_total ( $invoice ) {
            $total = $this -> db -> get_where ( 'general_ledger', array ( 'invoice_id' => $invoice ) );
            return $total -> row ();
        }
        
        /**
         * -------------------------
         * @param $invoice
         * @return mixed
         * get stock grand total by invoice number
         * -------------------------
         */
        
        public function get_stock_grand_total ( $invoice ) {
            $total = $this -> db -> get_where ( 'stock_invoice_discount', array ( 'invoice_number' => $invoice ) );
            return $total -> row ();
        }
        
        /**
         * -------------------------
         * @param $invoice
         * @return mixed
         * get grand total by invoice number
         * -------------------------
         */
        
        public function get_grand_discount ( $invoice ) {
            $total = $this -> db -> get_where ( 'stock_invoice_discount', array ( 'invoice_number' => $invoice ) );
            return $total -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $stock_id
         * @return mixed
         * update stock
         * -------------------------
         */
        
        public function update_medicine_stock ( $data, $stock_id ) {
            $this -> db -> update ( 'medicines_stock', $data, array ( 'id' => $stock_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $invoice
         * @return mixed
         * update_grand_total_discount
         * -------------------------
         */
        
        public function update_grand_total_discount ( $data, $invoice ) {
            $this -> db -> update ( 'stock_invoice_discount', $data, array ( 'invoice_number' => $invoice ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $invoice
         * @return mixed
         * update_ledger
         * -------------------------
         */
        
        public function update_ledger ( $data, $invoice ) {
            $this -> db -> update ( 'general_ledger', $data, array ( 'invoice_id' => $invoice ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $invoice
         * @return mixed
         * get_stock_by_invoice
         * -------------------------
         */
        
        public function get_stock_by_invoice ( $invoice ) {
            $stock = $this -> db -> get_where ( 'medicines_stock', array ( 'supplier_invoice' => $invoice ) );
            return $stock -> result ();
        }
        
        /**
         * -------------------------
         * @param $invoice
         * @param $supplier_id
         * @return mixed
         * get_stock_by_invoice
         * -------------------------
         */
        
        public function get_stock_by_invoice_and_supplier ( $invoice, $supplier_id ) {
            $stock = $this -> db -> query ( "Select * from hmis_medicines_stock where supplier_invoice LIKE '$invoice' and supplier_id=$supplier_id" );
            //		$stock = $this -> db -> get_where ( 'medicines_stock', array (
            //			'supplier_invoice' => $invoice,
            //			'supplier_id'      => $supplier_id
            //		) );
            return $stock -> result ();
        }
        
        /**
         * -------------------------
         * @param $invoice
         * @return mixed
         * get_stock_over_all_discount_by_invoice
         * -------------------------
         */
        
        public function get_stock_over_all_discount_by_invoice ( $invoice ) {
            $stock = $this -> db -> get_where ( 'stock_invoice_discount', array ( 'invoice_number' => $invoice ) );
            return $stock -> row ();
        }
        
        /**
         * -------------------------
         * @param $invoice
         * @return mixed
         * get_stock_ledger_by_invoice
         * -------------------------
         */
        
        public function get_stock_ledger_by_invoice ( $invoice ) {
            $stock = $this -> db -> get_where ( 'general_ledger', array ( 'invoice_id' => $invoice ) );
            return $stock -> row ();
        }
        
        /**
         * -------------------------
         * @return array
         * get sale by Invoice ID
         * -------------------------
         */
        
        public function get_sale_by_sale_id () {
            if ( isset( $_REQUEST[ 'sale_id' ] ) and !empty( trim ( $_REQUEST[ 'sale_id' ] ) ) and is_numeric ( $_REQUEST[ 'sale_id' ] ) > 0 ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sales   = $this -> db -> get_where ( 'medicines_sold', array ( 'sale_id' => $sale_id ) );
                return $sales -> result ();
            }
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @return array
         * get adjustment by adjustment id
         * -------------------------
         */
        
        public function get_adjustment_by_adjustment_id () {
            if ( isset( $_REQUEST[ 'adjustment_id' ] ) and !empty( trim ( $_REQUEST[ 'adjustment_id' ] ) ) and is_numeric ( $_REQUEST[ 'adjustment_id' ] ) > 0 ) {
                $adjustment_id = $_REQUEST[ 'adjustment_id' ];
                $sales         = $this -> db -> get_where ( 'hmis_medicines_adjustments', array ( 'adjustment_id' => $adjustment_id ) );
                return $sales -> result ();
            }
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @param $adjustment_id
         * get adjustment by adjustment id
         * -------------------------
         * @return array
         */
        
        public function get_adjustment_by_id ( $adjustment_id ) {
            $sales = $this -> db -> get_where ( 'hmis_adjustments', array ( 'id' => $adjustment_id ) );
            return $sales -> row ();
        }
        
        /**
         * -------------------------
         * @param $adjustment_id
         * get adjustment by adjustment id
         * -------------------------
         * @return array
         */
        
        public function get_med_adjustment_by_id ( $adjustment_id ) {
            $sales = $this -> db -> get_where ( 'hmis_medicines_adjustments', array ( 'id' => $adjustment_id ) );
            return $sales -> row ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return int
         * get total by Invoice ID
         * -------------------------
         */
        
        public function get_total_by_sale_id ( $sale_id ) {
            if ( !empty( trim ( $sale_id ) ) and is_numeric ( $sale_id ) > 0 ) {
                $total = $this -> db -> get_where ( 'sales', array ( 'id' => $sale_id ) );
                if ( $total -> num_rows () > 0 )
                    return $total -> row () -> total;
                else
                    return 0;
            }
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return int
         * check stock expiry date
         * -------------------------
         */
        
        public function check_stock_expiry_date_difference ( $stock_id ) {
            if ( !empty( trim ( $stock_id ) ) and is_numeric ( $stock_id ) > 0 ) {
                $total = $this -> db -> get_where ( 'medicines_stock', array ( 'id' => $stock_id ) );
                if ( $total -> num_rows () > 0 )
                    return $total -> row () -> expiry_date;
                else
                    return 0;
            }
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @param $net_price
         * @param $sale_id
         * update sale total
         * -------------------------
         */
        
        public function update_sale_total ( $net_price, $sale_id ) {
            $qry = "UPDATE hmis_sales SET total = (total - $net_price) WHERE id=$sale_id";
            $this -> db -> query ( $qry );
        }
        
        /**
         * -------------------------
         * @param $net_price
         * @param $adjustment_id
         * update adjustment total
         * -------------------------
         */
        
        public function update_adjustment_total ( $net_price, $adjustment_id ) {
            $qry = "UPDATE hmis_adjustments SET total = (total - $net_price) WHERE id=$adjustment_id";
            $this -> db -> query ( $qry );
        }
        
        /**
         * -------------------------
         * @param $supplier_invoice
         * @param $price
         * update sale total
         * -------------------------
         */
        
        public function update_stock_invoice_total ( $supplier_invoice, $price ) {
            $qry = "UPDATE hmis_stock_invoice_discount SET grand_total = (grand_total - $price) WHERE invoice_number='$supplier_invoice'";
            $this -> db -> query ( $qry );
        }
        
        /**
         * -------------------------
         * @param $net_price
         * @param $invoice_id
         * update supplier ledger
         * @return mixed
         * -------------------------
         */
        
        public function update_supplier_ledger ( $net_price, $invoice_id ) {
            $qry = "UPDATE hmis_general_ledger SET debit = (debit - $net_price) WHERE stock_id='$invoice_id' and  invoice_id='$invoice_id'";
            $this -> db -> query ( $qry );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $invoice_id
         * check if ledger exists
         * @return mixed
         * -------------------------
         */
        
        public function checkIfLedgerExists ( $invoice_id ) {
            $qry = $this -> db -> get_where ( 'general_ledger', array (
                'stock_id'   => $invoice_id,
                'invoice_id' => $invoice_id
            ) );
            if ( $qry -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $net_price
         * @param $local_purchase_id
         * update supplier ledger
         * @return mixed
         * -------------------------
         */
        
        public function update_local_purchase_supplier_ledger ( $net_price, $local_purchase_id ) {
            $qry = "UPDATE hmis_general_ledger SET debit = (debit - $net_price) WHERE local_purchase_id='$local_purchase_id'";
            $this -> db -> query ( $qry );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $net_price
         * @param $invoice_id
         * update customer ledger
         * @return mixed
         * -------------------------
         */
        
        public function update_customer_ledger ( $net_price, $invoice_id ) {
            $qry = "UPDATE hmis_general_ledger SET credit = (credit - $net_price) WHERE invoice_id=$invoice_id";
            $this -> db -> query ( $qry );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $net_price
         * @param $invoice_id
         * @param $account_id
         * update customer ledger
         * @return mixed
         * -------------------------
         */
        
        public function update_pharmacy_ledger ( $net_price, $invoice_id, $account_id ) {
            $qry = "UPDATE hmis_general_ledger SET credit = (credit - $net_price) WHERE invoice_id=$invoice_id and acc_head_id='$account_id'";
            $this -> db -> query ( $qry );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $net_price
         * @param $sale_id
         * update sale total
         * -------------------------
         */
        
        public function update_overall_sale_total ( $net_price, $sale_id ) {
            $qry = "UPDATE hmis_sales SET total = $net_price WHERE id=$sale_id";
            $this -> db -> query ( $qry );
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $sale_id
         * @return mixed
         * update sale total
         * -------------------------
         */
        
        public function update_medicines_sale_total ( $info, $sale_id ) {
            $this -> db -> update ( 'hmis_sales', $info, array ( 'id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $net_price
         * @param $adjustment_id
         * update adjustment total
         * -------------------------
         */
        
        public function update_overall_adjustment_total ( $net_price, $adjustment_id ) {
            $qry = "UPDATE hmis_adjustments SET total = $net_price WHERE id=$adjustment_id";
            $this -> db -> query ( $qry );
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get sale by id
         * -------------------------
         */
        
        public function get_sale_by_id ( $sale_id ) {
            $sale = $this -> db -> get_where ( 'sales', array ( 'id' => $sale_id ) );
            return $sale -> row ();
        }
        
        /**
         * -------------------------
         * @param $sale_ids
         * @return mixed
         * get sale by id
         * -------------------------
         */
        
        public function get_medicine_sales_total_by_batch_ids ( $sale_ids ) {
            $sale = $this -> db -> query ( "Select SUM(total) as total from hmis_sales where id IN($sale_ids)" );
            return $sale -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @param $type
         * @return mixed
         * get sale by id
         * -------------------------
         */
        
        public function get_sale_by_type ( $sale_id, $type ) {
            $sale = $this -> db -> get_where ( 'sales', array (
                'id'   => $sale_id,
                'type' => $type
            ) );
            return $sale -> row ();
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * get stock returned quantity
         * -------------------------
         */
        
        public function get_stock_returned_quantity ( $stock_id ) {
            $returned = $this -> db -> query ( "Select SUM(return_qty) as returned from hmis_return_stock where stock_id=$stock_id" );
            return $returned -> row () -> returned;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get medicine returned quantity
         * -------------------------
         */
        
        public function get_medicine_returned_quantity ( $medicine_id ) {
            $returned = return_customer;
            $returned = $this -> db -> query ( "Select SUM(quantity) as returned from hmis_medicines_stock where medicine_id=$medicine_id and supplier_id=$returned" );
            return $returned -> row () -> returned;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get medicine returned quantity
         * -------------------------
         */
        
        public function get_medicine_returned_quantity_by_date_filter ( $medicine_id ) {
            $returned = return_customer;
            $sql      = "Select SUM(quantity) as returned from hmis_medicines_stock where medicine_id=$medicine_id and supplier_id=$returned";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $returned = $this -> db -> query ( $sql );
            return $returned -> row () -> returned;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @param $stock_id
         * @return mixed
         * get stock returned quantity by supplier
         * -------------------------
         */
        
        public function get_stock_returned_quantity_by_customer ( $medicine_id, $stock_id ) {
            $returned = return_customer;
            $returned = $this -> db -> query ( "Select SUM(quantity) as returned from hmis_medicines_stock where medicine_id=$medicine_id and id=$stock_id and supplier_id=$returned" );
            return $returned -> row () -> returned;
        }
        
        /**
         * ---------------------
         * @param $medicine_id
         * @return mixed
         * get sum of all stocks
         * by medicine id
         * ---------------------
         */
        
        public function get_all_stock_price_by_medicine_id ( $medicine_id ) {
            $total  = 0;
            $stocks = $this -> db -> query ( "Select id, tp_unit, quantity, sales_tax, net_price, discount from hmis_medicines_stock where medicine_id=$medicine_id" ) -> result ();
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock ) {
                    $discount       = $stock -> discount;
                    $returned       = get_stock_returned_quantity ( $stock -> id );
                    $sold           = get_sold_quantity_by_stock ( $medicine_id, $stock -> id );
                    $expired        = get_expired_by_stock ( $stock -> id, $medicine_id );
                    $adjustment_qty = count_medicine_adjustment_by_medicine_id ( $medicine_id, $stock -> id );
                    $available      = $stock -> quantity - $returned - $sold - $expired - $adjustment_qty;
                    $net_price      = $discount - ( $discount * ( $available * ( $stock -> tp_unit + $stock -> sales_tax ) ) / 100 );
                    if ( $net_price >= $stock -> net_price )
                        $total += $net_price;
                    else
                        $total += $stock -> net_price;
                }
                return $total;
            }
            else {
                return $total;
            }
        }
        
        /**
         * ---------------------
         * @param $medicine_id
         * @return mixed
         * get sum of available stocks
         * by medicine id
         * ---------------------
         */
        
        public function get_available_stock_price_by_medicine_id ( $medicine_id ) {
            $total  = 0;
            $stocks = $this -> db -> query ( "Select id, tp_unit, quantity, sales_tax, net_price, discount from hmis_medicines_stock where medicine_id=$medicine_id" ) -> result ();
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock ) {
                    $discount       = $stock -> discount;
                    $sold           = get_sold_quantity_by_stock ( $medicine_id, $stock -> id );
                    $expired        = get_expired_by_stock ( $stock -> id, $medicine_id );
                    $int_issue      = get_medicines_internal_issuance ( $stock -> id );
                    $ipd_med        = get_ipd_medication_assigned_count_by_stock_and_medicine ( $medicine_id, $stock -> id );
                    $returned       = get_stock_returned_quantity ( $stock -> id );
                    $adjustment_qty = count_medicine_adjustment_by_medicine_id ( $medicine_id, $stock -> id );
                    $available      = $stock -> quantity - $sold - $expired - $int_issue - $ipd_med - $returned - $adjustment_qty;
                    $net_price      = $available * $stock -> tp_unit;
                    //				$total      		+= $net_price - ($net_price * ($discount / 100)) + $stock -> sales_tax;
                    $total += $net_price;
                }
                return $total;
            }
            else {
                return $total;
            }
        }
        
        public function get_expired_quantity_medicine_id ( $medicine_id ) {
            $total  = 0;
            $stocks = $this -> db -> query ( "Select id from hmis_medicines_stock where medicine_id=$medicine_id" ) -> result ();
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock ) {
                    $expired = get_expired_by_stock ( $stock -> id, $medicine_id );
                    //                    print_data ('Stock ID: ' . $stock -> id);
                    //                    print_data ('Expired Meds: ' . $expired);
                    $total = $total + $expired;
                }
                return ( $total < 0 ) ? 0 : $total;
            }
            else {
                return ( $total < 0 ) ? 0 : $total;
            }
        }
        
        
        /**
         * ---------------------
         * @param $medicine_id
         * @return mixed
         * get sum of available stocks
         * by medicine id
         * ---------------------
         */
        
        public function get_available_stock_price_by_medicine_id_by_date_filter ( $medicine_id ) {
            $total = 0;
            $sql   = "Select id, tp_unit, quantity, sales_tax, net_price, discount from hmis_medicines_stock where medicine_id=$medicine_id";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $stocks = $this -> db -> query ( $sql ) -> result ();
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock ) {
                    $discount = $stock -> discount;
                    $sold     = get_sold_quantity_by_stock ( $medicine_id, $stock -> id );
                    $expired  = get_expired_by_stock ( $stock -> id, $medicine_id );
                    //				if ( $medicine_id == 1251 ) {
                    //					print_data ($this -> db -> last_query());
                    //				}
                    $int_issue      = get_medicines_internal_issuance ( $stock -> id );
                    $ipd_med        = get_ipd_medication_assigned_count_by_stock_and_medicine ( $medicine_id, $stock -> id );
                    $returned       = get_stock_returned_quantity ( $stock -> id );
                    $adjustment_qty = count_medicine_adjustment_by_medicine_id ( $medicine_id, $stock -> id );
                    $available      = $stock -> quantity - $sold - $expired - $int_issue - $ipd_med - $returned - $adjustment_qty;
                    $net_price      = $available * $stock -> tp_unit;
                    
                    //				if ($medicine_id == 1251) {
                    //					print_data ('$sold: ' . $sold);
                    //					print_data ('$expired: ' . $expired);
                    //					print_data ('$int_issue: ' . $int_issue);
                    //					print_data ('$ipd_med: ' . $ipd_med);
                    //					print_data ('$returned: ' . $returned);
                    //					print_data ('$adjustment_qty: ' . $adjustment_qty);
                    //					print_data ('$available: ' . $available);
                    //				}
                    
                    //				$total      		+= $net_price - ($net_price * ($discount / 100)) + $stock -> sales_tax;
                    $total += $net_price;
                }
                return $total;
            }
            else {
                return $total;
            }
        }
        
        /**
         * ---------------------
         * @param $medicine_id
         * @param $total_qty
         * @return mixed
         * get sum of all stocks
         * by medicine id
         * ---------------------
         */
        
        public function get_stock_price_by_medicine_id_total_quantity ( $medicine_id, $total_qty ) {
            $total  = 0;
            $stocks = $this -> db -> query ( "Select id, sale_unit, quantity, sales_tax, net_price, discount from hmis_medicines_stock where medicine_id=$medicine_id and (tp_unit='0' or tp_unit=0 or tp_unit IS NULL)" ) -> result ();
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock ) {
                    $discount  = $stock -> discount;
                    $net_price = $total_qty * ( $stock -> sale_unit + $stock -> sales_tax );
                    $total     += $net_price - ( $net_price * ( $discount / 100 ) );
                }
                return $total;
            }
            else {
                return $total;
            }
        }
        
        /**
         * ---------------------
         * @param $medicine_id
         * @param $sold
         * @return mixed
         * get sum of all stocks
         * by medicine id
         * ---------------------
         */
        
        public function get_stock_price_by_medicine_id_sold_quantity ( $medicine_id, $sold ) {
            $total  = 0;
            $stocks = $this -> db -> query ( "Select id, sale_unit, quantity, sales_tax, net_price, discount from hmis_medicines_stock where medicine_id=$medicine_id and (tp_unit='0' or tp_unit=0 or tp_unit IS NULL)" ) -> result ();
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock ) {
                    $net_price = $sold * $stock -> sale_unit;
                    $total     += $net_price;
                }
                return $total;
            }
            else {
                return $total;
            }
        }
        
        /**
         * ---------------------
         * @param $medicine_id
         * @param $available
         * @return mixed
         * get sum of all stocks
         * by medicine id
         * ---------------------
         */
        
        public function get_stock_price_by_medicine_id_available_quantity ( $medicine_id, $available ) {
            $total  = 0;
            $stocks = $this -> db -> query ( "Select id, sale_unit, quantity, sales_tax, net_price, discount from hmis_medicines_stock where medicine_id=$medicine_id and (tp_unit='0' or tp_unit=0 or tp_unit IS NULL)" ) -> result ();
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock ) {
                    $net_price = $available * $stock -> sale_unit;
                    $total     += $net_price;
                }
                return $total;
            }
            else {
                return $total;
            }
        }
        
        /**
         * ---------------------
         * @param $medicine_id
         * @param $returned
         * @return mixed
         * get sum of all stocks
         * by medicine id
         * ---------------------
         */
        
        public function get_stock_price_by_medicine_id_returned_quantity ( $medicine_id, $returned ) {
            $total  = 0;
            $stocks = $this -> db -> query ( "Select id, sale_unit, quantity, sales_tax, net_price, discount from hmis_medicines_stock where medicine_id=$medicine_id and (tp_unit='0' or tp_unit=0 or tp_unit IS NULL)" ) -> result ();
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock ) {
                    $net_price = $returned * $stock -> sale_unit;
                    $total     += $net_price;
                }
                return $total;
            }
            else {
                return $total;
            }
        }
        
        /**
         * ---------------------
         * @param $medicine_id
         * @param $issued
         * @return mixed
         * get sum of all stocks
         * by medicine id
         * ---------------------
         */
        
        public function get_stock_price_by_medicine_id_issued_quantity ( $medicine_id, $issued ) {
            $total  = 0;
            $stocks = $this -> db -> query ( "Select id, sale_unit, quantity, sales_tax, net_price, discount from hmis_medicines_stock where medicine_id=$medicine_id and (tp_unit='0' or tp_unit=0 or tp_unit IS NULL)" ) -> result ();
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock ) {
                    $net_price = $issued * $stock -> sale_unit;
                    $total     += $net_price;
                }
                return $total;
            }
            else {
                return $total;
            }
        }
        
        /**
         * ---------------------
         * @param $medicine_id
         * @param $counter
         * @return mixed
         * get sum of all stocks
         * by medicine id
         * ---------------------
         */
        
        public function get_all_stock_sale_price_by_medicine_id ( $medicine_id, $counter ) {
            $total  = 0;
            $stocks = $this -> db -> query ( "Select id, sale_unit, quantity, sales_tax, net_price, discount from hmis_medicines_stock where medicine_id=$medicine_id" ) -> result ();
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock ) {
                    $discount       = $stock -> discount;
                    $returned       = get_stock_returned_quantity ( $stock -> id );
                    $sold           = get_sold_quantity_by_stock ( $medicine_id, $stock -> id );
                    $expired        = get_expired_by_stock ( $stock -> id, $medicine_id );
                    $int_issue      = get_medicines_internal_issuance ( $stock -> id );
                    $ipd_med        = get_ipd_medication_assigned_count_by_stock_and_medicine ( $medicine_id, $stock -> id );
                    $adjustment_qty = count_medicine_adjustment_by_medicine_id ( $medicine_id, $stock -> id );
                    $available      = $stock -> quantity - $sold - $expired - $int_issue - $ipd_med - $returned - $adjustment_qty;
                    $net_price      = $available * ( $stock -> sale_unit );
                    //				$total      += $net_price - ($net_price * ($discount / 100)) + $stock -> sales_tax;
                    $total += $net_price;
                    //				print_data('$counter: ' . $counter);
                    //				print_data('Discount: ' . $discount);
                    //				print_data('$returned: ' . $returned);
                    //				print_data('$sold: ' . $sold);
                    //				print_data('$expired: ' . $expired);
                    //				print_data('$available: ' . $available);
                    //				print_data('$stock -> sale_unit: ' . $stock -> sale_unit);
                    //				print_data('$stock -> sales_tax: ' . $stock -> sales_tax);
                    //				print_data('$net_price: ' . $net_price);
                    //				print_data('$total: ' . $total);
                }
                return $total;
            }
            else {
                return $total;
            }
        }
        
        /**
         * ---------------------
         * @param $invoice_id
         * @return mixed
         * get supplier id by invoice id
         * ---------------------
         */
        
        public function get_supplier_id_by_invoice_id ( $invoice_id ) {
            $supplier = $this -> db -> get_where ( 'medicines_stock', array ( 'supplier_invoice' => $invoice_id ) );
            if ( $supplier -> num_rows () > 0 )
                return $supplier -> row () -> supplier_id;
        }
        
        /**
         * ---------------------
         * @param $invoice_id
         * @param $supplier_id
         * @return mixed
         * get supplier id by invoice id and supplier id
         * ---------------------
         */
        
        public function get_supplier_id_by_invoice_id_and_supplier_id ( $invoice_id, $supplier_id ) {
            $supplier = $this -> db -> get_where ( 'medicines_stock', array (
                'supplier_invoice' => $invoice_id,
                'supplier_id'      => $supplier_id
            ) );
            if ( $supplier -> num_rows () > 0 )
                return $supplier -> row () -> supplier_id;
        }
        
        /**
         * ---------------------
         * @param $invoice
         * check if invoice record already exists
         * @return bool
         * ---------------------
         */
        
        public function check_if_invoice_already_exists ( $invoice ) {
            if ( !empty( trim ( $invoice ) ) ) {
                $invoice = $this -> db -> query ( "Select * from hmis_stock_invoice_discount where invoice_number='$invoice'" );
                if ( $invoice -> num_rows () > 0 ) {
                    return $invoice -> row ();
                }
            }
        }
        
        /**
         * -------------------------
         * @param $total
         * @param $supplier_invoice
         * update ledger total
         * -------------------------
         */
        
        public function update_stock_total ( $total, $supplier_invoice ) {
            $this -> db -> update ( 'hmis_stock_invoice_discount', array ( 'grand_total' => $total ), array ( 'invoice_number' => $supplier_invoice ) );
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save manufacturers into database
         * -------------------------
         */
        
        public function add_manufacturers ( $data ) {
            $this -> db -> insert ( 'manufacturers', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get manufacturers from database
         * -------------------------
         */
        
        public function get_manufacturers () {
            $manufacturers = $this -> db -> get ( 'manufacturers' );
            return $manufacturers -> result ();
        }
        
        /**
         * -------------------------
         * @param $manufacturer_id
         * get manufacturers from database
         * -------------------------
         * @return mixed
         */
        
        public function get_manufacturer_by_id ( $manufacturer_id ) {
            $manufacturer = $this -> db -> get_where ( 'manufacturers', array ( 'id' => $manufacturer_id ) );
            return $manufacturer -> row ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $manufacturer_id
         * update manufacturer
         * @return mixed
         * -------------------------
         */
        
        public function edit_manufacturers ( $info, $manufacturer_id ) {
            $this -> db -> update ( 'manufacturers', $info, array ( 'id' => $manufacturer_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $manufacturer_id
         * update manufacturer
         * @return mixed
         * -------------------------
         */
        
        public function delete_manufacturers ( $manufacturer_id ) {
            $this -> db -> delete ( 'manufacturers', array ( 'id' => $manufacturer_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $condition
         * check if medicine already added
         * @return bool
         * -------------------------
         */
        
        public function check_if_medicine_already_added ( $condition ) {
            $medicine = $this -> db -> get_where ( 'medicines', $condition );
            if ( $medicine -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @return array
         * get return customer stock
         * -------------------------
         */
        
        public function get_medicine_stock_of_return_customer () {
            
            $search = false;

//            if ( isset( $_REQUEST[ 'date_added' ] ) and !empty( trim ( $_REQUEST[ 'date_added' ] ) ) ) {
//                $date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'date_added' ] ) );
//                $this -> db -> where ( 'DATE(date_added)', $date );
//            }
            
            if ( isset( $_REQUEST[ 'invoice' ] ) and !empty( trim ( $_REQUEST[ 'invoice' ] ) ) ) {
                $this -> db -> where ( 'supplier_invoice', $_REQUEST[ 'invoice' ] );
                $search = true;
            }
            
            $this -> db -> where ( 'supplier_id', return_customer );
            
            $query = $this -> db -> get ( 'medicines_stock' );
            
            if ( $search ) {
                return $query -> result ();
            }
            else {
                return array ();
            }
        }
        
        /**
         * -------------------------
         * @return array
         * get local purchase
         * -------------------------
         */
        
        public function get_local_purchase () {
            if ( isset( $_REQUEST[ 'supplier_invoice' ] ) and !empty( trim ( $_REQUEST[ 'supplier_invoice' ] ) ) ) {
                $supplier_invoice = $_REQUEST[ 'supplier_invoice' ];
                $query            = $this -> db -> get_where ( 'medicines_stock', array (
                    'supplier_id'      => local_purchase,
                    'supplier_invoice' => $supplier_invoice
                ) );
                
                return $query -> result ();
            }
            else {
                return array ();
            }
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get last medicine return customer info
         * -------------------------
         */
        
        public function get_medicine_last_return_record ( $medicine_id ) {
            $return_customer = return_customer;
            $query           = $this -> db -> query ( "Select * from hmis_medicines_stock where medicine_id=$medicine_id order by id DESC limit 1" );
            return $query -> row ();
        }
        
        /**
         * -------------------------
         * @param $where
         * @return mixed
         * check if medicine already sold on same time
         * -------------------------
         */
        
        public function check_if_sale_already_made ( $where ) {
            $query = $this -> db -> get_where ( 'medicines_sold', $where );
            if ( $query -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $where
         * @return mixed
         * check if medicine already sold on same time
         * -------------------------
         */
        
        public function check_if_sale_already_added ( $where ) {
            $query = $this -> db -> get_where ( 'sales', $where );
            if ( $query -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $supplier_id
         * @param $invoice_number
         * @return bool
         * check if invoice number exists
         * -------------------------
         */
        
        public function check_if_invoice_number_already_exists ( $supplier_id, $invoice_number ) {
            $query = $this -> db -> get_where ( 'medicines_stock', array (
                //			'supplier_id'      => $supplier_id,
                'supplier_invoice' => $invoice_number
            ) );
            if ( $query -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get stock with local purchase
         * -------------------------
         */
        
        public function count_local_purchases () {
            $supplier_id = local_purchase;
            $sql         = "SELECT id FROM hmis_medicines_stock where supplier_id=$supplier_id";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' AND '$end_date'";
            }
            if ( isset( $_REQUEST[ 'medicine_id' ] ) and $_REQUEST[ 'medicine_id' ] > 0 ) {
                $medicine_id = $_REQUEST[ 'medicine_id' ];
                $sql         .= " and medicine_id=$medicine_id";
            }
            $sql       .= " GROUP BY supplier_invoice";
            $purchases = $this -> db -> query ( $sql );
            return $purchases -> num_rows ();
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get stock with local purchase
         * -------------------------
         */
        
        public function get_local_purchases ( $limit, $offset ) {
            $supplier_id = local_purchase;
            $sql         = "SELECT GROUP_CONCAT(id) as ids, user_id, supplier_id, supplier_invoice, GROUP_CONCAT(medicine_id) as medicines, GROUP_CONCAT(batch) as batches, GROUP_CONCAT(supplier_invoice) as invoices, expiry_date, GROUP_CONCAT(quantity) as quantities, price, GROUP_CONCAT(tp_unit) as tps, GROUP_CONCAT(sale_unit) as sales, GROUP_CONCAT(net_price) as prices, date_added FROM hmis_medicines_stock where supplier_id=$supplier_id";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' AND '$end_date'";
            }
            if ( isset( $_REQUEST[ 'medicine_id' ] ) and $_REQUEST[ 'medicine_id' ] > 0 ) {
                $medicine_id = $_REQUEST[ 'medicine_id' ];
                $sql         .= " and medicine_id=$medicine_id";
            }
            $sql       .= " GROUP BY supplier_invoice order by id DESC limit $limit offset $offset";
            $purchases = $this -> db -> query ( $sql );
            return $purchases -> result ();
        }
        
        /**
         * -------------------------
         * @param $supplier_invoice
         * get stock with local purchase
         * -------------------------
         * @return mixed
         */
        
        public function get_local_purchases_by_supplier_invoice ( $supplier_invoice ) {
            $supplier_id = local_purchase;
            $purchases   = $this -> db -> query ( "SELECT * FROM hmis_medicines_stock where supplier_id=$supplier_id and supplier_invoice='$supplier_invoice'" );
            return $purchases -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * count pharmacy issuance
         * -------------------------
         */
        
        public function count_issuance () {
            $sql = "Select id from hmis_medicines_internal_issuance where 1";
            if ( isset( $_REQUEST[ 'sale_id' ] ) and $_REQUEST[ 'sale_id' ] > 0 ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            if ( isset( $_REQUEST[ 'issue_to' ] ) and $_REQUEST[ 'issue_to' ] > 0 ) {
                $issue_to = $_REQUEST[ 'issue_to' ];
                $sql      .= " and issue_to=$issue_to";
            }
            if ( isset( $_REQUEST[ 'medicine_id' ] ) and $_REQUEST[ 'medicine_id' ] > 0 ) {
                $medicine_id = $_REQUEST[ 'medicine_id' ];
                $sql         .= " and medicine_id=$medicine_id";
            }
            $sql   .= " group by sale_id";
            $query = $this -> db -> query ( $sql );
            return $query -> num_rows ();
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get pharmacy issuance
         * -------------------------
         */
        
        public function get_issuance ( $limit, $offset ) {
            $sql = "Select GROUP_CONCAT(medicine_id) as medicines, GROUP_CONCAT(stock_id) as stocks, GROUP_CONCAT(quantity) as quantities, issue_to, sale_id, id, date_added from hmis_medicines_internal_issuance where 1";
            
            if ( isset( $_REQUEST[ 'sale_id' ] ) and $_REQUEST[ 'sale_id' ] > 0 ) {
                $sale_id = $_REQUEST[ 'sale_id' ];
                $sql     .= " and sale_id=$sale_id";
            }
            if ( isset( $_REQUEST[ 'issue_to' ] ) and $_REQUEST[ 'issue_to' ] > 0 ) {
                $issue_to = $_REQUEST[ 'issue_to' ];
                $sql      .= " and issue_to=$issue_to";
            }
            if ( isset( $_REQUEST[ 'medicine_id' ] ) and $_REQUEST[ 'medicine_id' ] > 0 ) {
                $medicine_id = $_REQUEST[ 'medicine_id' ];
                $sql         .= " and medicine_id=$medicine_id";
            }
            $sql   .= " group by sale_id order by id DESC limit $limit offset $offset";
            $query = $this -> db -> query ( $sql );
            return $query -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get pharmacy issuance
         * -------------------------
         */
        
        public function get_issuance_by_filter () {
            $search = false;
            $sql    = "Select id, user_id, sale_id, issue_to, department_id, GROUP_CONCAT(medicine_id) as medicines, GROUP_CONCAT(stock_id) as stocks, GROUP_CONCAT(quantity) as quantities, GROUP_CONCAT(returned) as returns, date_added from hmis_medicines_internal_issuance where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' AND '$end_date'";
                $search     = true;
            }
            if ( isset( $_REQUEST[ 'medicine_id' ] ) and $_REQUEST[ 'medicine_id' ] > 0 ) {
                $medicine_id = $_REQUEST[ 'medicine_id' ];
                $sql         .= " and medicine_id=$medicine_id";
                $search      = true;
            }
            if ( isset( $_REQUEST[ 'user_id' ] ) and $_REQUEST[ 'user_id' ] > 0 ) {
                $user_id = $_REQUEST[ 'user_id' ];
                $sql     .= " and user_id=$user_id";
                $search  = true;
            }
            if ( isset( $_REQUEST[ 'department_id' ] ) and $_REQUEST[ 'department_id' ] > 0 ) {
                $department_id = $_REQUEST[ 'department_id' ];
                $sql           .= " and department_id=$department_id";
                $search        = true;
            }
            $sql   .= " group by sale_id";
            $query = $this -> db -> query ( $sql );
            if ( $search )
                return $query -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @param $issuance_id
         * @return mixed
         * delete issuance
         * -------------------------
         */
        
        public function delete_issue_sale ( $issuance_id ) {
            $this -> db -> delete ( 'issuance', array ( 'id' => $issuance_id ) );
            $this -> db -> delete ( 'medicines_internal_issuance', array ( 'sale_id' => $issuance_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $issuance_id
         * @return mixed
         * delete issuance
         * -------------------------
         */
        
        public function delete_single_issuance ( $issuance_id ) {
            $this -> db -> delete ( 'medicines_internal_issuance', array ( 'id' => $issuance_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $issuance_id
         * @return mixed
         * get issuance by id
         * -------------------------
         */
        
        public function get_issuance_by_id ( $issuance_id ) {
            $issuance = $this -> db -> get_where ( 'medicines_internal_issuance', array ( 'sale_id' => $issuance_id ) );
            return $issuance -> result ();
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * get stock remaining quantity
         * -------------------------
         */
        
        public function get_stock_remaining_available_quantity ( $stock_id ) {
            $returned  = $this -> get_stock_returned_quantity ( $stock_id );
            $issued    = check_stock_issued_quantity ( $stock_id );
            $available = $this -> get_stock_available_quantity ( $stock_id );
            return $available -> quantity - $available -> sold - $issued - $returned;
        }
        
        /**
         * -------------------------
         * @return mixed
         * search issuance
         * -------------------------
         */
        
        public function search_issuance () {
            
            $issuance_id = $this -> input -> get ( 'issuance_id' );
            $user_id     = $this -> input -> get ( 'user_id' );
            $date        = $this -> input -> get ( 'date' );
            $search      = false;
            
            $sql = "Select * from hmis_medicines_internal_issuance where 1";
            if ( $issuance_id > 0 and !empty( trim ( $issuance_id ) ) ) {
                $sql    .= " and sale_id=$issuance_id";
                $search = true;
            }
            if ( $user_id > 0 and !empty( trim ( $user_id ) ) ) {
                $sql    .= " and issue_to=$user_id";
                $search = true;
            }
            if ( !empty( trim ( $date ) ) ) {
                $date   = date ( 'Y-m-d', strtotime ( $date ) );
                $sql    .= " and DATE(date_added)='$date'";
                $search = true;
            }
            
            $issuance = $this -> db -> query ( $sql );
            return $search ? $issuance -> result () : array ();
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get issued quantity
         * -------------------------
         */
        
        public function get_issued_quantity ( $medicine_id ) {
            $query = $this -> db -> query ( "Select SUM(quantity) as total from hmis_medicines_internal_issuance where medicine_id=$medicine_id" );
            return $query -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get issued quantity
         * -------------------------
         */
        
        public function get_issued_quantity_by_date_filter ( $medicine_id ) {
            $sql = "Select SUM(quantity) as total from hmis_medicines_internal_issuance where medicine_id=$medicine_id";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $query = $this -> db -> query ( $sql );
            return $query -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $medicine
         * @param $department_id
         * get internal issuance par level
         * value by medicine id and department
         * @return mixed
         * -------------------------
         */
        
        public function get_internal_issuance_par_level ( $medicine, $department_id ) {
            $query = $this -> db -> query ( "Select * from hmis_internal_issuance_par_levels where medicine_id=$medicine and department_id=$department_id" );
            if ( $query -> num_rows () > 0 )
                return $query -> row () -> allowed;
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @param $medicine
         * @param $department_id
         * get internal issuance quantity
         * @return mixed
         * -------------------------
         */
        
        public function get_internal_issued_medicines_quantity ( $medicine, $department_id ) {
            $query = $this -> db -> query ( "Select SUM(quantity) as quantity from hmis_medicines_internal_issuance where medicine_id=$medicine and department_id=$department_id" );
            return $query -> row () -> quantity;
        }
        
        /**
         * -------------------------
         * @param $info
         * @return mixed
         * do add pack sizes
         * -------------------------
         */
        
        public function do_add_pack_sizes ( $info ) {
            $this -> db -> insert ( 'pack_size', $info );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get pack sizes
         * -------------------------
         */
        
        public function get_pack_sizes () {
            $this -> db -> order_by ( 'title', 'ASC' );
            $packs = $this -> db -> get ( 'pack_size' );
            return $packs -> result ();
        }
        
        /**
         * -------------------------
         * @param $pack_id
         * @return mixed
         * delete pack size
         * -------------------------
         */
        
        public function delete_pack ( $pack_id ) {
            $this -> db -> delete ( 'pack_size', array ( 'id' => $pack_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $pack_id
         * @param $info
         * @return mixed
         * update pack size
         * -------------------------
         */
        
        public function do_edit_pack_size ( $info, $pack_id ) {
            $this -> db -> update ( 'pack_size', $info, array ( 'id' => $pack_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $pack_id
         * get pack size by id
         * -------------------------
         * @return mixed
         */
        
        public function get_pack_size_by_id ( $pack_id ) {
            $this -> db -> order_by ( 'title', 'ASC' );
            $pack = $this -> db -> get_where ( 'pack_size', array ( 'id' => $pack_id ) );
            return $pack -> row ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get ipd requisitions
         * -------------------------
         */
        
        public function get_ipd_medicine_requisitions () {
            $requisitions = $this -> db -> query ( "Select * from hmis_ipd_requisitions group by sale_id order by seen ASC" );
            return $requisitions -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * count new ipd requisitions
         * -------------------------
         */
        
        public function count_new_ipd_requisitions () {
            $requisitions = $this -> db -> query ( "Select COUNT(*) as total from hmis_ipd_requisitions where seen='0' group by sale_id" );
            if ( $requisitions -> num_rows () > 0 )
                return $requisitions -> row () -> total;
            else
                return '0';
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get latest medicine stock
         * -------------------------
         */
        
        public function get_latest_medicine_stock ( $medicine_id ) {
            $this -> db -> order_by ( 'id', 'DESC' );
            $stock = $this -> db -> get_where ( 'medicines_stock', array ( 'medicine_id' => $medicine_id ) );
            return $stock -> row ();
        }
        
        /**
         * -------------------------
         * @param $department_id
         * @return mixed
         * check if par level already added
         * -------------------------
         */
        
        public function checkIfParLevelAlreadyAddedByDeptId ( $department_id ) {
            $this -> db -> order_by ( 'id', 'DESC' );
            $row = $this -> db -> get_where ( 'hmis_internal_issuance_par_levels', array ( 'department_id' => $department_id ) );
            if ( $row -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * get medicine internal issuance
         * -------------------------
         */
        
        public function get_medicines_internal_issuance ( $stock_id ) {
            $query = $this -> db -> query ( "Select SUM(quantity) as quantity from hmis_medicines_internal_issuance where stock_id='$stock_id'" );
            return $query -> row () -> quantity;
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * get ipd medication count
         * -------------------------
         */
        
        public function get_ipd_medication_assigned_count_by_stock ( $stock_id ) {
            $query = $this -> db -> query ( "Select SUM(quantity) as total from hmis_ipd_medication where stock_id=$stock_id" );
            return $query -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * get ipd medication count
         * -------------------------
         */
        
        public function get_ipd_medication_assigned_count_by_stock_and_medicine ( $medicine_id, $stock_id ) {
            $query = $this -> db -> query ( "Select SUM(quantity) as total from hmis_ipd_medication where stock_id=$stock_id and medicine_id=$medicine_id" );
            return $query -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get ipd medication count
         * -------------------------
         */
        
        public function get_ipd_issued_medicine_quantity ( $medicine_id ) {
            //		$query = $this -> db -> query ( "Select SUM(quantity) as total from hmis_ipd_medication where medicine_id=$medicine_id AND stock_id IN (SELECT id FROM `hmis_medicines_stock` WHERE `medicine_id` = $medicine_id)" );
            //		return $query -> row () -> total;
            
            //            $sql = "Select SUM(quantity) as total from hmis_ipd_medication where medicine_id=$medicine_id AND stock_id IN (SELECT id FROM `hmis_medicines_stock` WHERE `medicine_id` = $medicine_id)";
            $sql = "Select SUM(quantity) as total from hmis_ipd_medication where medicine_id=$medicine_id and stock_id IN (Select id from hmis_medicines_stock where medicine_id=$medicine_id)";
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            
            $query = $this -> db -> query ( $sql );
            return $query -> row () -> total;
            
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get ipd medication count
         * -------------------------
         */
        
        public function get_medicine_issued_quantity ( $medicine_id ) {
            $sql = "Select SUM(quantity) as total from hmis_medicines_sold where medicine_id=$medicine_id AND stock_id IN (SELECT id FROM `hmis_medicines_stock` WHERE `medicine_id` = $medicine_id) and sale_id IN (Select id from hmis_sales where refunded='0')";
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_sold) BETWEEN '$start_date' and '$end_date'";
            }
            
            $query = $this -> db -> query ( $sql );
            return $query -> row () -> total;
            
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get ipd medication net price
         * -------------------------
         */
        
        public function get_ipd_issued_medicine_net_price ( $medicine_id ) {
            $sql = "Select SUM(net_price) as total from hmis_ipd_medication where medicine_id=$medicine_id AND stock_id IN (SELECT id FROM `hmis_medicines_stock` WHERE `medicine_id` = $medicine_id)";
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            
            $query = $this -> db -> query ( $sql );
            return $query -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get ipd medication net price
         * -------------------------
         */
        
        public function get_issued_medicine_net_price ( $medicine_id ) {
            $sql = "Select SUM(net_price) as total from hmis_medicines_sold where medicine_id=$medicine_id AND stock_id IN (SELECT id FROM `hmis_medicines_stock` WHERE `medicine_id` = $medicine_id)";
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_sold) BETWEEN '$start_date' and '$end_date'";
            }
            
            $query = $this -> db -> query ( $sql );
            
            return $query -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get ipd medication count
         * -------------------------
         */
        
        public function get_ipd_issued_medicine_quantity_by_date_filter ( $medicine_id ) {
            $sql = "Select SUM(quantity) as total from hmis_ipd_medication where medicine_id=$medicine_id and stock_id IN (Select id from hmis_medicines_stock where medicine_id=$medicine_id)";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $query = $this -> db -> query ( $sql );
            return $query -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get returned medicines quantity by supplier
         * -------------------------
         */
        
        public function get_returned_medicines_quantity_by_supplier ( $medicine_id ) {
            $query = $this -> db -> query ( "Select SUM(return_qty) as quantity from hmis_return_stock where medicine_id=$medicine_id" );
            return $query -> row () -> quantity;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get returned medicines quantity by supplier
         * -------------------------
         */
        
        public function get_returned_medicines_quantity_by_supplier_by_date_filter ( $medicine_id ) {
            $sql = "Select SUM(return_qty) as quantity from hmis_return_stock where medicine_id=$medicine_id";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $query = $this -> db -> query ( $sql );
            return $query -> row () -> quantity;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @param $stock_id
         * @return mixed
         * count
         * -------------------------
         */
        
        public function count_medicine_adjustment_by_medicine_id ( $medicine_id, $stock_id ) {
            $query = $this -> db -> query ( "Select SUM(quantity) as total from hmis_medicines_adjustments where medicine_id=$medicine_id and stock_id=$stock_id" );
            return $query -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * count
         * -------------------------
         */
        
        public function get_total_adjustments_by_medicine_id ( $medicine_id ) {
            $query = $this -> db -> query ( "Select SUM(quantity) as total from hmis_medicines_adjustments where medicine_id=$medicine_id" );
            return $query -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * count
         * -------------------------
         */
        
        public function get_total_adjustments_by_medicine_id_by_date_filter ( $medicine_id ) {
            $sql = "Select SUM(quantity) as total from hmis_medicines_adjustments where medicine_id=$medicine_id";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $query = $this -> db -> query ( $sql );
            return $query -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $adjustment_id
         * get adjustments
         * -------------------------
         * @return mixed
         */
        
        public function get_all_adjustments ( $adjustment_id ) {
            $sql   = "Select adjustment_id, GROUP_CONCAT(quantity) as quantity, GROUP_CONCAT(price) as price, GROUP_CONCAT(medicine_id) as medicine_id, GROUP_CONCAT(stock_id) as stock_id, SUM(net_price) as net_price, date_added from hmis_medicines_adjustments where adjustment_id=$adjustment_id group by adjustment_id order by id DESC";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return int
         * get medicine stock sale/unit price
         * -------------------------
         */
        
        public function get_medicine_stock_sale_unit_price ( $stock_id ) {
            $stock = $this -> db -> get_where ( 'medicines_stock', array ( 'id' => $stock_id ) );
            if ( !empty( $stock ) )
                return $stock -> row () -> sale_unit;
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get medicines total sale
         * by date range
         * -------------------------
         */
        
        public function get_total_sale_by_date_range () {
            $sql = "Select SUM(total) as net from hmis_sales where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(date_sale) Between '$start_date' and '$end_date'";
            }
            if ( isset( $_REQUEST[ 'start_time' ] ) and isset( $_REQUEST[ 'end_time' ] ) and !empty( $_REQUEST[ 'start_time' ] ) and !empty( $_REQUEST[ 'end_time' ] ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'start_time' ] ) );
                $end_time   = date ( 'H:i:s', strtotime ( $_REQUEST[ 'end_time' ] ) );
                $sql        .= " and TIME(date_sale) BETWEEN '$start_time' and '$end_time'";
            }
            if ( isset( $_REQUEST[ 'user_id' ] ) and $_REQUEST[ 'user_id' ] > 0 ) {
                $user_id = $_REQUEST[ 'user_id' ];
                $sql     .= " and user_id=$user_id";
            }
            $query = $this -> db -> query ( $sql );
            return $query -> row ();
        }
        
        /**
         * -------------------------
         * @return float|int
         * calculate actual cost of medicines sold
         * -------------------------
         */
        
        public function calculate_cost_of_medicines_sold () {
            $stocks     = $_POST[ 'stock_id' ];
            $quantities = $_POST[ 'quantity' ];
            $sum        = 0;
            
            if ( isset( $stocks ) and count ( $stocks ) > 0 ) {
                foreach ( $stocks as $key => $stock_id ) {
                    $quantity = $quantities[ $key ];
                    $stock    = get_stock ( $stock_id );
                    $tp_unit  = $stock -> tp_unit;
                    $sum      = $sum + ( $quantity * $tp_unit );
                }
            }
            return $sum;
        }
        
        public function calculate_cost_of_medicines_sold_by_sale_id ( $sale_id ) {
            $query  = $this -> db -> query ( "Select stock_id, quantity from hmis_medicines_sold where sale_id=$sale_id" );
            $result = $query -> result ();
            
            $net = 0;
            if ( count ( $result ) > 0 ) {
                foreach ( $result as $item ) {
                    $quantity = $item -> quantity;
                    $stock_id = $item -> stock_id;
                    $stock    = $this -> get_stock_by_id ( $stock_id );
                    if ( !empty( $stock ) ) {
                        $tp_unit = $stock -> tp_unit;
                        $net     = $net + ( $tp_unit * $quantity );
                    }
                }
            }
            return $net;
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return float|int
         * calculate actual cost of medicines sold
         * -------------------------
         */
        
        public function calculate_cost_of_ipd_medicines_sold ( $sale_id ) {
            $query  = $this -> db -> query ( "Select stock_id, quantity from hmis_ipd_medication where sale_id=$sale_id" );
            $result = $query -> result ();
            
            $net = 0;
            if ( count ( $result ) > 0 ) {
                foreach ( $result as $item ) {
                    $quantity = $item -> quantity;
                    $stock_id = $item -> stock_id;
                    $stock    = $this -> get_stock_by_id ( $stock_id );
                    if ( !empty( $stock ) ) {
                        $tp_unit = $stock -> tp_unit;
                        $net     = $net + ( $tp_unit * $quantity );
                    }
                }
            }
            return $net;
        }
        
        /**
         * -------------------------
         * @return mixed
         * calculate sum local purchase
         * -------------------------
         */
        
        public function calculate_sum_local_purchase () {
            $local_purchase = local_purchase;
            $start_date     = $_REQUEST[ 'start_date' ];
            $end_date       = $_REQUEST[ 'end_date' ];
            
            $sql = "Select SUM(net_price) as net_price from hmis_medicines_stock where supplier_id='$local_purchase'";
            
            if ( isset( $start_date ) and isset( $end_date ) and !empty( trim ( $start_date ) ) and !empty( trim ( $end_date ) ) ) {
                $start = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end   = date ( 'Y-m-d', strtotime ( $end_date ) );
                $sql   .= " and DATE(date_added) BETWEEN '$start' and '$end'";
            }
            
            $query = $this -> db -> query ( $sql );
            return $query -> row () -> net_price;
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get medicine suppliers
         * -------------------------
         */
        
        public function get_supplier_by_medicine_id ( $medicine_id ) {
            $query = $this -> db -> query ( "Select supplier_id from hmis_medicines_stock where medicine_id=$medicine_id group by supplier_id" );
            return $query -> result ();
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * get medicine stock by id
         * -------------------------
         */
        
        public function get_stock_by_id ( $stock_id ) {
            $query = $this -> db -> query ( "Select * from hmis_medicines_stock where id=$stock_id" );
            return $query -> row ();
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @param $stock_id
         * @param $batch
         * @return bool
         * check if medicine is discarded
         * -------------------------
         */
        
        public function check_if_medicine_discarded ( $medicine_id, $stock_id, $batch ) {
            $query = $this -> db -> get_where ( 'discarded_expired_medicines', array (
                'medicine_id' => $medicine_id,
                'stock_id'    => $stock_id,
                'batch_no'    => $batch
            ) );
            if ( $query -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get discarded expired medicines
         * -------------------------
         */
        
        public function get_discarded_expired_medicines () {
            $user_id     = $this -> input -> get ( 'user-id' );
            $supplier_id = $this -> input -> get ( 'supplier-id' );
            $start_date  = $this -> input -> get ( 'start-date' );
            $end_date    = $this -> input -> get ( 'end-date' );
            $sql         = "Select * from hmis_discarded_expired_medicines where 1";
            
            if ( isset( $user_id ) && is_numeric ( $user_id ) && $user_id > 0 )
                $sql .= " and user_id=$user_id";
            
            if ( isset( $supplier_id ) && is_numeric ( $supplier_id ) && $supplier_id > 0 )
                $sql .= " and stock_id IN (Select id from hmis_medicines_stock where supplier_id=$supplier_id)";
            
            if ( isset( $start_date ) && !empty( trim ( $start_date ) ) && isset( $end_date ) && !empty( trim ( $end_date ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                $sql        .= " and DATE(date_added) BETWEEN '$start_date' AND '$end_date'";
            }
            
            $query = $this -> db -> query ( $sql );
            return $query -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * count return medicines
         * -------------------------
         */
        
        public function count_return_medicines () {
            $return_customer = return_customer;
            $count           = 0;
            $sql             = "Select id, COUNT(*) as totalRows from hmis_medicines_stock where supplier_id=$return_customer";
            
            if ( isset( $_REQUEST[ 'invoice' ] ) and !empty( trim ( $_REQUEST[ 'invoice' ] ) ) ) {
                $invoice = $_REQUEST[ 'invoice' ];
                $sql     .= " and supplier_invoice='$invoice'";
            }
            
            if ( isset( $_REQUEST[ 'start-date' ] ) and !empty( trim ( $_REQUEST[ 'start-date' ] ) ) and isset( $_REQUEST[ 'end-date' ] ) and !empty( trim ( $_REQUEST[ 'end-date' ] ) ) ) {
                $start = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start-date' ] ) );
                $end   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end-date' ] ) );
                $sql   .= " and supplier_invoice BETWEEN '$start' AND '$end'";
            }
            
            $sql       .= " group by DATE(date_added)";
            $medicines = $this -> db -> query ( $sql );
            
            $results = $medicines -> result ();
            if ( count ( $results ) > 0 ) {
                foreach ( $results as $result ) {
                    $count++;
                }
            }
            return $count;
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get return medicines invoices
         * -------------------------
         */
        
        public function get_return_medicines ( $limit, $offset ) {
            $return_customer = return_customer;
            $sql             = "Select supplier_invoice, GROUP_CONCAT(medicine_id) as medicines, GROUP_CONCAT(quantity) as quantities, GROUP_CONCAT(paid_to_customer) as paid_to_customer, date_added from hmis_medicines_stock where supplier_id=$return_customer";
            
            if ( isset( $_REQUEST[ 'invoice' ] ) and !empty( trim ( $_REQUEST[ 'invoice' ] ) ) ) {
                $invoice = $_REQUEST[ 'invoice' ];
                $sql     .= " and supplier_invoice='$invoice'";
            }
            
            if ( isset( $_REQUEST[ 'start-date' ] ) and !empty( trim ( $_REQUEST[ 'start-date' ] ) ) and isset( $_REQUEST[ 'end-date' ] ) and !empty( trim ( $_REQUEST[ 'end-date' ] ) ) ) {
                $start = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start-date' ] ) );
                $end   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end-date' ] ) );
                $sql   .= " and DATE(date_added) BETWEEN '$start' AND '$end'";
            }
            
            $sql .= " group by supplier_invoice order by id DESC limit $limit offset $offset";
            
            $medicines = $this -> db -> query ( $sql );
            return $medicines -> result ();
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get medicine sale session
         * -------------------------
         */
        
        public function get_medicine_sale_session ( $medicine_id ) {
            $sale = $this -> db -> query ( "Select GROUP_CONCAT(stock_id) as stocks from hmis_medicine_sale_session where medicine_id=$medicine_id" );
            return $sale -> row ();
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @param $stock_id
         * @return mixed
         * get medicine stock
         * -------------------------
         */
        
        public function get_medicine_stock_not_in_current_session ( $medicine_id, $stock_id ) {
            $date = date ( 'Y-m-d' );
            $sql  = "Select * from hmis_medicines_stock where medicine_id=$medicine_id and expiry_date > '$date' and status='1'";
            if ( $stock_id > 0 )
                $sql .= " and id NOT IN ($stock_id)";
            $sql   .= " order by expiry_date ASC";
            $stock = $this -> db -> query ( $sql );
            return $stock -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save current sale user session
         * -------------------------
         */
        
        public function save_current_session ( $data ) {
            $this -> db -> insert ( 'medicine_sale_session', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $medicine_id
         * @return mixed
         * get expired stocks
         * -------------------------
         */
        
        public function get_expired_medicine_stocks ( $medicine_id ) {
            $date   = date ( 'Y-m-d' );
            $stocks = $this -> db -> query ( "Select id, user_id, supplier_id, supplier_invoice, medicine_id, batch, expiry_date, box_qty, units, quantity, box_price, price, discount, sales_tax, box_price_after_dis_tax, net_price, tp_unit, sale_box, sale_unit, description, paid_to_customer, status, returned, date_added, date_updated, (SUM(quantity) - IFNULL((Select SUM(quantity) from hmis_medicines_sold where medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(return_qty) from hmis_return_stock where medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(quantity) from hmis_medicines_internal_issuance where medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(quantity) from hmis_medicines_adjustments where medicine_id='$medicine_id'), 0) - IFNULL((Select SUM(quantity) from hmis_ipd_medication where medicine_id='$medicine_id'), 0)) as total from hmis_medicines_stock where medicine_id='$medicine_id' AND expiry_date <= '$date' having quantity > 0" );
            return $stocks -> result ();
        }
        
        public function get_patient_id_by_sale_id ( $sale_id ) {
            $query = $this -> db -> get_where ( 'medicines_sold', array ( 'sale_id' => $sale_id ) );
            if ( $query -> num_rows () > 0 )
                return $query -> row () -> patient_id;
            else
                return 0;
        }
        
        public function get_medicine_net_sale_value ( $sale_id ) {
            $query = $this -> db -> query ( "Select SUM(net_price) as net_price from hmis_medicines_sold where sale_id=$sale_id" );
            if ( $query -> num_rows () > 0 )
                return $query -> row () -> net_price;
            else
                return 0;
        }
        
        public function get_supplier_stock () {
            $supplier_id = $this -> input -> get ( 'supplier_id', true );
            $invoice     = $this -> input -> get ( 'invoice', true );
            
            if ( isset( $supplier_id ) && $supplier_id > 0 && isset( $invoice ) && !empty( trim ( $invoice ) ) ) {
                $stocks = $this -> db -> get_where ( 'medicines_stock', [ 'supplier_id' => $supplier_id, 'supplier_invoice' => $invoice ] );
                if ( $stocks -> num_rows () > 0 )
                    return $stocks -> result ();
                else
                    return [];
            }
            else
                return [];
            
        }
        
        public function count_stock_available_quantity ( $medicine_id, $stock ) {
            $sold              = get_sold_quantity_by_stock ( $medicine_id, $stock -> id );
            $supplier_returned = get_stock_returned_quantity ( $stock -> id );
            $issued            = check_stock_issued_quantity ( $stock -> id );
            $ipd_med           = get_ipd_medication_assigned_count_by_stock_and_medicine ( $medicine_id, $stock -> id );
            $adjustment_qty    = count_medicine_adjustment_by_medicine_id ( $medicine_id, $stock -> id );
            return ( $stock -> quantity - $sold - $ipd_med - $issued - $supplier_returned - $adjustment_qty );
        }
        
        public function get_stock_total_value_by_invoice ( $invoice ) {
            $query = $this -> db -> query ( "Select SUM(paid_to_customer) as paid_to_customer from hmis_medicines_stock where supplier_invoice='$invoice'" );
            return $query -> row () -> paid_to_customer;
        }
        
        public function calculate_cost_of_medicines_returned_by_invoice ( $invoice ) {
            $query  = $this -> db -> query ( "Select * from hmis_medicines_stock where supplier_invoice='$invoice'" );
            $stocks = $query -> result ();
            
            $cost = 0;
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock ) {
                    $cost = $cost + ( $stock -> tp_unit * $stock -> quantity );
                }
            }
            return $cost;
        }
        
        public function get_locked_medicines () {
            $this
                -> db
                -> select ( 'medicines.name, medicines.generic_id, medicines.form_id, medicines.strength_id, medicines_stock.batch, users.name as user' )
                -> from ( 'medicine_sale_session' )
                -> join ( 'medicines', 'medicine_sale_session.medicine_id=medicines.id' )
                -> join ( 'medicines_stock', 'medicine_sale_session.stock_id=medicines_stock.id' )
                -> join ( 'users', 'medicine_sale_session.user_id=users.id' );
            $query = $this -> db -> get ();
            return $query -> result ();
        }
        
        public function filter_medicines_stock_valuation () {
            $form_id     = $this -> input -> get ( 'form-id' );
            $generic_id  = $this -> input -> get ( 'generic-id' );
            $strength_id = $this -> input -> get ( 'strength-id' );
            $sql         = "Select * from hmis_medicines where status='1' and id IN (Select medicine_id from hmis_medicines_stock)";
            
            if ( isset( $form_id ) && $form_id > 0 ) {
                $sql .= " and form_id=$form_id";
            }
            
            if ( isset( $generic_id ) && $generic_id > 0 ) {
                $sql .= " and generic_id=$generic_id";
            }
            
            if ( isset( $strength_id ) && $strength_id > 0 ) {
                $sql .= " and strength_id=$strength_id";
            }
            
            $sql       .= " order by name ASC";
            $medicines = $this -> db -> query ( $sql );
            return $medicines -> result ();
        }
        
        public function get_pharmacy_total ( $refunded = false ) {
            
            $start_date = $this -> input -> get ( 'start_date' );
            $end_date   = $this -> input -> get ( 'end_date' );
            $start_time = $this -> input -> get ( 'start_time' );
            $end_time   = $this -> input -> get ( 'end_time' );
            $user_id    = $this -> input -> get ( 'user_id' );
            
            $this -> db -> select ( 'SUM(total) as net' ) -> from ( 'sales' );
            
            if ( isset( $start_date ) and !empty( trim ( $start_date ) ) and isset( $end_date ) and !empty( trim ( $end_date ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                $this -> db -> where ( "DATE(date_sale) Between '$start_date' and '$end_date'" );
            }
            
            if ( isset( $start_time ) and isset( $end_time ) and !empty( $start_time ) and !empty( $end_time ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $start_time ) );
                $end_time   = date ( 'H:i:s', strtotime ( $end_time ) );
                $this -> db -> where ( "TIME(date_sale) BETWEEN '$start_time' and '$end_time'" );
            }
            
            if ( isset( $user_id ) and $user_id > 0 ) {
                $this -> db -> where ( 'user_id', $user_id );
            }
            
            if ( $refunded ) {
                $this -> db -> where ( 'refunded', '1' );
            }
            
            $query = $this -> db -> get ();
            return $query -> row () -> net;
        }
        
    }
