<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class AccountModel extends CI_Model {
        
        public $net_debit          = 0;
        public $net_credit         = 0;
        public $parent_net_credit  = 0;
        public $parent_net_debit   = 0;
        public $parent_net_rb      = 0;
        public $parent_net_opening = 0;
        public $net_net_opening    = 0;
        
        /**
         * -------------------------
         * AccountModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all main active account heads
         * -------------------------
         */
        
        public function get_main_account_heads () {
            $account_heads = $this -> db -> get_where ( 'account_heads', array (
                'status'    => '1',
                'parent_id' => '0'
            ) );
            return $account_heads -> result ();
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * @return mixed
         * get account head id by panel id
         * -------------------------
         */
        
        public function get_account_head_id_by_panel_id ( $panel_id = 0 ) {
            if ( $panel_id > 0 ) {
                $account_heads = $this -> db -> get_where ( 'account_heads', array (
                    'panel_id' => $panel_id,
                ) );
                return $account_heads -> row ();
            }
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * @return mixed
         * check if doctor is already linked with acc head
         * -------------------------
         */
        
        public function is_doctor_already_linked_with_account_head ( $doctor_id = 0 ) {
            if ( $doctor_id > 0 ) {
                $account_heads = $this -> db -> get_where ( 'account_heads', array (
                    'doctor_id' => $doctor_id,
                ) );
                if ( $account_heads -> num_rows () > 0 )
                    return true;
                else
                    return false;
            }
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $panel_id
         * @return mixed
         * check if panel is already linked with acc head
         * -------------------------
         */
        
        public function is_panel_already_linked_with_account_head ( $panel_id = 0 ) {
            if ( $panel_id > 0 ) {
                $account_heads = $this -> db -> get_where ( 'account_heads', array (
                    'panel_id' => $panel_id,
                ) );
                if ( $account_heads -> num_rows () > 0 )
                    return true;
                else
                    return false;
            }
            else
                return false;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all main active account heads
         * -------------------------
         */
        
        public function get_all_account_heads () {
            $account_heads = $this -> db -> get_where ( 'account_heads', array ( 'parent_id' => '0' ) );
            return $account_heads -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add account heads
         * -------------------------
         */
        
        public function insert ( $data ) {
            $this -> db -> insert ( 'account_heads', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * @return mixed
         * get child account heads
         * -------------------------
         */
        
        public function get_child_account_heads ( $acc_head_id ) {
            $account_heads = $this -> db -> get_where ( 'account_heads', array ( 'parent_id' => $acc_head_id ) );
            return $account_heads -> result ();
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * @return mixed
         * get child account heads
         * -------------------------
         */
        
        public function get_active_child_account_heads ( $acc_head_id ) {
            $account_heads = $this -> db -> get_where ( 'account_heads', array (
                'parent_id' => $acc_head_id,
                'status'    => '1'
            ) );
            return $account_heads -> result ();
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * @return mixed
         * get sub child account head ids
         * -------------------------
         */
        
        public function get_sub_child_account_head_ids ( $acc_head_id ) {
            $account_head_ids = $this -> db -> query ( "Select GROUP_CONCAT(id) as ids from hmis_account_heads where parent_id=$acc_head_id" );
            return $account_head_ids -> row ();
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * @return mixed
         * get child account heads
         * -------------------------
         */
        
        public function if_has_child ( $acc_head_id ) {
            $account_heads = $this -> db -> get_where ( 'account_heads', array ( 'parent_id' => $acc_head_id ) );
            return $account_heads -> num_rows ();
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * @return mixed
         * get sub child account heads
         * -------------------------
         */
        
        public function get_sub_account_heads ( $acc_head_id ) {
            $account_heads = $this -> db -> get_where ( 'account_heads', array ( 'parent_id' => $acc_head_id ) );
            return $account_heads -> result ();
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * @return mixed
         * get account head by id
         * -------------------------
         */
        
        public function get_account_head_by_id ( $acc_head_id ) {
            $account_heads = $this -> db -> get_where ( 'account_heads', array ( 'id' => $acc_head_id ) );
            return $account_heads -> row ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get account heads
         * -------------------------
         */
        
        public function get_account_heads () {
            $account_heads = $this -> db -> get ( 'account_heads' );
            return $account_heads -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get account heads
         * -------------------------
         */
        
        public function get_account_heads_by_id ( $id ) {
            $account_heads = $this -> db -> get_where ( 'account_heads', array ( 'id' => $id ) );
            return $account_heads -> result_array ();
        }
        
        /**
         * -------------------------
         * @param $account_head_id
         * get account heads
         * @return mixed
         * -------------------------
         */
        
        public function get_account_heads_not_in ( $account_head_id ) {
            $this -> db -> select ( "*" );
            $this -> db -> from ( 'account_heads' );
            $this -> db -> where_not_in ( 'id', $account_head_id );
            $account_heads = $this -> db -> get ();
            return $account_heads -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $acc_head_id
         * @return mixed
         * update account heads
         * -------------------------
         */
        
        public function edit ( $data, $acc_head_id ) {
            $this -> db -> update ( 'account_heads', $data, array ( 'id' => $acc_head_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * @param $data
         * @return mixed
         * update status account head
         * -------------------------
         */
        
        public function delete ( $data, $acc_head_id ) {
            $this -> db -> update ( 'account_heads', $data, array ( 'id' => $acc_head_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add ledger
         * -------------------------
         */
        
        public function add_ledger ( $data ) {
            $this -> db -> insert ( 'general_ledger', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add roles
         * -------------------------
         */
        
        public function add_roles ( $data ) {
            $this -> db -> insert ( 'account_roles', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $bank_id
         * @return mixed
         * get banks
         * -------------------------
         */
        
        public function get_banks ( $bank_id ) {
            $banks = $this -> db -> get_where ( 'account_heads', array ( 'parent_id' => $bank_id ) );
            return $banks -> result ();
        }
        
        /**
         * -------------------------
         * @param $main_head_id
         * @return mixed
         * get banks
         * -------------------------
         */
        
        public function get_customers ( $main_head_id ) {
            $customers = $this -> db -> get_where ( 'account_heads', array ( 'parent_id' => $main_head_id ) );
            return $customers -> result ();
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * @return mixed
         * get account head
         * -------------------------
         */
        
        public function get_account_head ( $acc_head_id ) {
            $banks = $this -> db -> get_where ( 'account_heads', array ( 'id' => $acc_head_id ) );
            return $banks -> row ();
        }
        
        public function get_account_head_by ( $column, $value ) {
            $banks = $this -> db -> get_where ( 'account_heads', array ( $column => $value ) );
            return $banks -> row ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get opening balances
         * -------------------------
         */
        
        public function get_opening_balances () {
            $balances = $this -> db -> get ( 'opening_balance' );
            return $balances -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add opening balance
         * -------------------------
         */
        
        public function add_opening_balance ( $data ) {
            $this -> db -> insert ( 'general_ledger', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $column
         * @param $acc_head_id
         * @return int
         * get remaining balance
         * -------------------------
         */
        
        public function get_remaining_balance ( $acc_head_id ) {
            $remaining_balance = $this -> db -> query ( "Select * from hmis_general_ledger where acc_head_id=$acc_head_id order by id DESC limit 1" );
            if ( $remaining_balance -> num_rows () > 0 ) {
                $balance = $remaining_balance -> row ();
                return $balance -> remaining_balance + $balance -> debit - $balance -> credit;
            }
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @param $column
         * @param $acc_head_id
         * @return int
         * get remaining balance
         * -------------------------
         */
        
        public function get_running_balance ( $acc_head_id ) {
            $remaining_balance = $this -> db -> query ( "Select remaining_balance from hmis_general_ledger where acc_head_id=$acc_head_id order by id DESC limit 1" );
            if ( $remaining_balance -> num_rows () > 0 ) {
                $balance = $remaining_balance -> row ();
                return $balance -> remaining_balance;
            }
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @param $column
         * @param $transaction_id
         * @return int
         * get remaining balance
         * -------------------------
         */
        
        public function get_bank_running_balance ( $transaction_id ) {
            $remaining_balance = $this -> db -> query ( "Select remaining_balance from hmis_general_ledger where id=$transaction_id order by id DESC limit 1" );
            if ( $remaining_balance -> num_rows () > 0 ) {
                $balance = $remaining_balance -> row ();
                return $balance -> remaining_balance;
            }
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @param $transaction_id
         * @param $acc_head_id
         * @return int
         * get remaining balance
         * -------------------------
         */
        
        public function get_running_balance_by_trans_id ( $acc_head_id, $transaction_id ) {
            $remaining_balance = $this -> db -> query ( "Select remaining_balance from hmis_general_ledger where id<$transaction_id and acc_head_id=$acc_head_id order by id DESC limit 1" );
            if ( $remaining_balance -> num_rows () > 0 ) {
                $balance = $remaining_balance -> row ();
                return $balance -> remaining_balance;
            }
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @param $column
         * @param $acc_head_id
         * @return int
         * get remaining ledger balance
         * -------------------------
         */
        
        public function get_remaining_ledger_balance_by_column ( $column, $acc_head_id ) {
            $remaining_balance = $this -> db -> query ( "Select remaining_balance as balance from hmis_general_ledger where acc_head_id=$acc_head_id order by id DESC limit 1" );
            if ( $remaining_balance -> num_rows () > 0 )
                return $remaining_balance -> row () -> balance;
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @param $balance_id
         * delete opening balance
         * -------------------------
         */
        
        public function delete_opening_balance ( $balance_id ) {
            $this -> db -> delete ( 'opening_balance', array ( 'id' => $balance_id ) );
        }
        
        /**
         * -------------------------
         * @param $data
         * create an entry of remaining balance
         * -------------------------
         */
        
        public function create_entry_of_remaining_balance ( $data ) {
            $this -> db -> insert ( 'opening_balance', $data );
        }
        
        /**
         * -------------------------
         * @return mixed
         * search ledger
         * -------------------------
         */
        
        public function get_ledgers () {
            if ( isset( $_REQUEST[ 'acc_head_id' ] ) or isset( $_REQUEST[ 'start_date' ] ) or isset( $_REQUEST[ 'end_date' ] ) ) {
                $acc_head_id = explode ( '-', $_REQUEST[ 'acc_head_id' ] );
                $start_date  = $_REQUEST[ 'start_date' ];
                $end_date    = $_REQUEST[ 'end_date' ];
                
                if ( $acc_head_id[ 0 ] == 'm' ) {
                    return $this -> get_all_children_of_account_head ( $acc_head_id[ 1 ] );
                }
                if ( $acc_head_id[ 0 ] == 'c' ) {
                    return $this -> get_all_children_of_account_head ( $acc_head_id[ 1 ] );
                }
                if ( $acc_head_id[ 0 ] == 'sc' ) {
                    return $this -> get_parent_of_account_head ( $acc_head_id[ 1 ] );
                }
                
            }
        }
        
        /**
         * -------------------------
         * @param $id
         * @return mixed
         * get all children linked to their parent
         * -------------------------
         */
        
        public function get_all_children_of_account_head ( $id ) {
            $children = $this -> db -> query ( "Select id, title from hmis_account_heads where id=$id or parent_id=$id" );
            return $children -> result ();
        }
        
        /**
         * -------------------------
         * @param $id
         * @return mixed
         * get parent of account head
         * -------------------------
         */
        
        public function get_parent_of_account_head ( $id ) {
            $children = $this -> db -> query ( "Select id, title from hmis_account_heads where id=$id" );
            return $children -> result ();
        }
        
        
        /**
         * -------------------------
         * @param $transaction_id
         * @return mixed
         * get transaction record by id
         * -------------------------
         */
        
        public function get_transaction_by_id ( $transaction_id ) {
            $transaction = $this -> db -> get_where ( 'general_ledger', array ( 'id' => $transaction_id ) );
            return $transaction -> row ();
        }
        
        /**
         * -------------------------
         * @param $where
         * @return mixed
         * get transactions record by id
         * -------------------------
         */
        
        public function get_transactions_by_id ( $where ) {
            $transaction = $this -> db -> get_where ( 'general_ledger', $where );
            return $transaction -> result ();
        }
        
        /**
         * -------------------------
         * @param $bank_trans_id
         * @return int
         * get account head id by bank transaction id
         * -------------------------
         */
        
        public function get_bank_acc_id_by_bank_trans_id ( $bank_trans_id ) {
            if ( !empty( trim ( $bank_trans_id ) ) and $bank_trans_id > 0 and is_numeric ( $bank_trans_id ) ) {
                $acc_head_id = $this -> db -> query ( "Select acc_head_id from hmis_general_ledger where id=$bank_trans_id" );
                if ( $acc_head_id -> num_rows () > 0 )
                    return $acc_head_id -> row () -> acc_head_id;
                else
                    return 0;
            }
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $where
         * update transaction
         * -------------------------
         */
        
        public function update_general_ledger ( $data, $where ) {
            $this -> db -> update ( 'general_ledger', $data, $where );
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $where
         * update transaction
         * -------------------------
         */
        
        public function update_role ( $data, $where ) {
            $this -> db -> update ( 'account_roles', $data, $where );
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $where
         * update transaction
         * -------------------------
         */
        
        public function update_general_stock_discount ( $data, $where ) {
            $this -> db -> update ( 'hmis_stock_invoice_discount', $data, $where );
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $transaction_id
         * update transaction
         * -------------------------
         */
        
        public function update_ledger ( $data, $transaction_id ) {
            $this -> db -> update ( 'general_ledger', $data, array ( 'id' => $transaction_id ) );
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $purchase_id
         * update transaction
         * -------------------------
         */
        
        public function update_local_ledger ( $data, $purchase_id ) {
            $this -> db -> update ( 'general_ledger', $data, array ( 'local_purchase_id' => $purchase_id ) );
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $invoice_id
         * update transaction
         * -------------------------
         */
        
        public function update_sale_ledger ( $data, $invoice_id ) {
            $this -> db -> update ( 'general_ledger', $data, array ( 'invoice_id' => $invoice_id ) );
        }
        
        /**
         * -------------------------
         * @param $where
         * @return bool
         * check if ledger exists
         * -------------------------
         */
        
        public function check_if_ledger_exists ( $where ) {
            $query = $this -> db -> get_where ( 'general_ledger', $where );
            if ( $query -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $opd_consultancy_id
         * update OPD consultancy ledger
         * -------------------------
         */
        
        public function update_opd_consultancy_ledger ( $data, $opd_consultancy_id ) {
            $this -> db -> update ( 'general_ledger', $data, array ( 'opd_consultancy_id' => $opd_consultancy_id ) );
        }
        
        /**
         * -------------------------
         * @param $opd_consultancy_id
         * delete OPD consultancy ledger
         * -------------------------
         */
        
        public function delete_opd_consultancy_ledger ( $opd_consultancy_id ) {
            $this -> db -> delete ( 'general_ledger', array ( 'opd_consultancy_id' => $opd_consultancy_id ) );
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * delete OPD service ledger
         * -------------------------
         */
        
        public function delete_opd_consultancy_services ( $sale_id ) {
            $this -> db -> delete ( 'general_ledger', array ( 'opd_service_id' => $sale_id ) );
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * @return mixed
         * get account head parent id
         * -------------------------
         */
        
        public function get_account_head_parent ( $acc_head_id ) {
            $parent = $this -> db -> query ( "Select parent_id from hmis_account_heads where id=$acc_head_id" );
            return $parent -> row () -> parent_id;
        }
        
        /**
         * -------------------------
         * @param $transaction_id
         * @return mixed
         * chec_if_bank_trans_exists
         * -------------------------
         */
        
        public function check_if_bank_trans_exists ( $transaction_id ) {
            $parent = $this -> db -> query ( "Select bank_trans_id from hmis_general_ledger where id=$transaction_id" );
            return $parent -> row () -> bank_trans_id;
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * @param $transaction_id
         * @return mixed
         * get ledgers after updating transaction to update remaining values
         * -------------------------
         */
        
        public function get_ledgers_after_transaction_updated ( $acc_head_id, $transaction_id ) {
            $ledgers = $this -> db -> query ( "Select id, credit, debit, remaining_balance, bank_trans_id from hmis_general_ledger where id >= $transaction_id and acc_head_id=$acc_head_id" );
            return $ledgers -> result ();
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * @param $transaction_id
         * @return mixed
         * get ledgers after updating transaction to update remaining values
         * -------------------------
         */
        
        public function get_previous_RB ( $transaction_id, $acc_head_id ) {
            $ledgers = $this -> db -> query ( "Select remaining_balance from hmis_general_ledger where id < $transaction_id and acc_head_id=$acc_head_id order by id DESC LIMIT 1" );
            return $ledgers -> row () -> remaining_balance;
        }
        
        /**
         * -------------------------
         * @param $transaction_id
         * @return mixed
         * get ledgers after updating transaction to update remaining values
         * -------------------------
         */
        
        public function get_current_running_balance_by_trans_id ( $transaction_id, $acc_head_id ) {
            $ledgers = $this -> db -> query ( "Select remaining_balance from hmis_general_ledger where id < $transaction_id and acc_head_id=$acc_head_id order by id DESC LIMIT 1" );
            return $ledgers -> row () -> remaining_balance;
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $transaction_id
         * @param $acc_head_id
         * update running balance
         * -------------------------
         */
        
        public function update_new_running_balances ( $data, $transaction_id, $acc_head_id ) {
            $this -> db -> update ( 'general_ledger', $data, array (
                'id'          => $transaction_id,
                'acc_head_id' => $acc_head_id
            ) );
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * @param $transaction_id
         * @return mixed
         * get ledgers after updating transaction to update remaining values for bank only
         * -------------------------
         */
        
        public function get_ledgers_after_transaction_updated_bank ( $acc_head_id, $transaction_id ) {
            $ledgers = $this -> db -> query ( "Select id, credit, debit, remaining_balance, bank_trans_id from hmis_general_ledger where id >= $transaction_id and acc_head_id=$acc_head_id" );
            return $ledgers -> result ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $transaction_id
         * @param $before_update
         * do create log
         * if before array is empty get it by transaction id
         * -------------------------
         */
        
        public function do_create_log ( $info, $transaction_id, $before_update ) {
            $info = array (
                'transaction_id' => $transaction_id,
                'after_update'   => json_encode ( $info ),
                'date_updated'   => date ( 'Y-m-d' )
            );
            if ( empty( $before_update ) )
                $info[ 'before_update' ] = json_encode ( (array)$this -> get_transaction_by_id ( $transaction_id ) );
            else
                $info[ 'before_update' ] = json_encode ( $before_update );
            $this -> db -> insert ( 'transactions_log', $info );
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * @return mixed
         * get transactions by account head id
         * -------------------------
         */
        
        public function get_transactions ( $acc_head_id ) {
            $sql = "Select * from hmis_general_ledger where acc_head_id=$acc_head_id";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and trans_date BETWEEN '$start_date' and '$end_date'";
            }
            $sql          .= " order by trans_date, id ASC";
            $transactions = $this -> db -> query ( $sql );
            return $transactions -> result ();
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * delete account head
         * -------------------------
         */
        
        public function delete_acc_head ( $acc_head_id ) {
            $this -> db -> delete ( 'account_heads', array ( 'id' => $acc_head_id ) );
        }
        
        /**
         * -------------------------
         * @param $condition
         * delete general ledger
         * -------------------------
         */
        
        public function delete_ledger ( $condition ) {
            $this -> db -> delete ( 'general_ledger', $condition );
        }
        
        /**
         * -------------------------
         * @param $voucher_number
         * check if voucher is double entry system
         * -------------------------
         * @return mixed
         */
        
        public function check_if_voucher_is_double_entry ( $voucher_number ) {
            if ( !empty( trim ( $voucher_number ) ) ) {
                $query = $this -> db -> query ( "Select COUNT(*) as total from hmis_general_ledger where voucher_number='$voucher_number'" );
                
                return $query -> row () -> total;
            }
            return 0;
        }
        
        /**
         * -------------------------
         * @param $supplier_invoice
         * @param $supplier_id
         * check if supplier has already ledger
         * against invoice no
         * @return bool
         * -------------------------
         */
        
        public function check_if_supplier_invoice_exists ( $supplier_invoice, $supplier_id ) {
            if ( !empty( trim ( $supplier_invoice ) ) and !empty( trim ( $supplier_id ) ) ) {
                $ledger = $this -> db -> query ( "Select * from hmis_general_ledger where acc_head_id=$supplier_id and invoice_id='$supplier_invoice'" );
                if ( $ledger -> num_rows () > 0 ) {
                    return $ledger -> row ();
                }
            }
        }
        
        /**
         * -------------------------
         * @param $supplier_id
         * @param $supplier_invoice
         * @param $ledger_total
         * update ledger total
         * -------------------------
         */
        
        public function update_ledger_total ( $supplier_id, $supplier_invoice, $ledger_total ) {
            $this -> db -> update ( 'general_ledger', array ( 'debit' => $ledger_total ), array (
                'acc_head_id' => $supplier_id,
                'invoice_id'  => $supplier_invoice
            ) );
        }
        
        /**
         * -------------------------
         * @param $ledger
         * @param $where
         * update ledger
         * -------------------------
         */
        
        public function update_adjustments_ledger ( $ledger, $where ) {
            $this -> db -> update ( 'general_ledger', $ledger, $where );
        }
        
        /**
         * -------------------------
         * @return mixed
         * get supplier invoices
         * search by supplier id,
         * start and end trans date
         * -------------------------
         */
        
        public function get_supplier_invoices () {
            $supplier = supplier_id;
            $sql      = "Select * from hmis_general_ledger where invoice_id != '' and acc_head_id IN(Select id from hmis_account_heads where parent_id=$supplier) ";
            if ( isset( $_REQUEST[ 'supplier' ] ) and $_REQUEST[ 'supplier' ] > 0 and !empty( $_REQUEST[ 'supplier' ] ) ) {
                $supplier_id = $_REQUEST[ 'supplier' ];
                $sql         .= " and acc_head_id=$supplier_id";
            }
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and DATE(trans_date) BETWEEN '$start_date' and '$end_date'";
            }
            $query = $this -> db -> query ( $sql );
            return $query -> result ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * delete lab general ledger
         * @return mixed
         * -------------------------
         */
        
        public function delete_lab_sale ( $sale_id ) {
            $this -> db -> delete ( 'hmis_general_ledger', array ( 'lab_sale_id' => $sale_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * delete local purchase ledger
         * -------------------------
         */
        
        public function delete_local_purchase ( $stock_id ) {
            $this -> db -> delete ( 'general_ledger', array ( 'local_purchase_id' => $stock_id ) );
        }
        
        /**
         * -------------------------
         * @param $voucher_number
         * @param $id
         * check if voucher is double entry system
         * -------------------------
         * @return mixed
         */
        
        public function check_id_double_entry ( $voucher_number, $id ) {
            if ( !empty( trim ( $voucher_number ) ) ) {
                $query = $this -> db -> query ( "Select * from hmis_general_ledger where voucher_number='$voucher_number' and id!=$id" );
                return $query -> result ();
            }
            return array ();
        }
        
        /**
         * -------------------------
         * @param $voucher_number
         * revert transaction by voucher number
         * @return mixed
         * -------------------------
         */
        
        public function revert_transaction ( $voucher_number ) {
            $this -> db -> delete ( 'general_ledger', array ( 'voucher_number' => $voucher_number ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $date
         * @param $acc_head_id
         * @return int
         * get running balance previous than searched date
         * -------------------------
         */
        
        public function get_opening_balance_previous_than_searched_start_date ( $date, $acc_head_id ) {
            
            if ( !empty( trim ( $date ) ) ) {
                
                $financial_year = $this -> db -> get ( 'financial_year' );
                if ( $financial_year -> num_rows () > 0 ) {
                    $start_date = $financial_year -> row () -> start_date;

//                    print_data ( 'Financial year' );
//                    print_data ( $start_date );
//                    exit;
                }
                else {
                    $month = date ( 'm' );
                    if ( $month < 7 )
                        $year = date ( 'Y' ) - 1;
                    else
                        $year = date ( 'Y' );
                    $start_date = '2020-07-01';
                }

//                print_data ( $start_date );
//                exit;
                
                $sql = "Select * from hmis_general_ledger where acc_head_id=$acc_head_id";
                
                if ( !empty( trim ( $date ) ) ) {
                    $trans_date = date ( 'Y-m-d', strtotime ( $date . ' -1 day' ) );
                    $sql        .= " and DATE(trans_date) BETWEEN '$start_date' AND '$trans_date'";
                }
                
                
                $query = $this -> db -> query ( $sql );
                
                $balances             = $query -> result ();
                $last_running_balance = 0;
                $RB                   = 0;
//                if ( count ( $balances ) > 0 ) {
//                    foreach ( $balances as $balance ) {
//                        $RB                   = ( $last_running_balance - $balance -> debit ) + $balance -> credit;
//                        $last_running_balance = $RB;
//                    }
//                }
                if ( count ( $balances ) > 0 ) {
                    foreach ( $balances as $balance ) {
                        $account_head = $this -> get_account_head_by_id ( $balance -> acc_head_id );
                        if ( in_array ( $account_head -> role_id, array ( assets, expenditure ) ) )
                            $last_running_balance = $last_running_balance + $balance -> credit - $balance -> debit;
                        
                        else if ( in_array ( $account_head -> role_id, array ( liabilities, capitals, income ) ) )
                            $last_running_balance = $last_running_balance - $balance -> credit + $balance -> debit;
                    }
                }
                return $last_running_balance;
            }
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @param $voucher_number
         * @return bool
         * check if voucher number exists
         * -------------------------
         */
        
        public function validate_voucher_number ( $voucher_number ) {
            $query = $this -> db -> get_where ( 'general_ledger', array ( 'voucher_number' => $voucher_number ) );
            if ( $query -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $where
         * @return mixed
         * get ledger
         * -------------------------
         */
        
        public function get_ledger ( $where ) {
            $info = $this -> db -> get_where ( 'general_ledger', $where );
            return $info -> row ();
        }
        
        /**
         * -------------------------
         * @param $id
         * delete store fix assets
         * -------------------------
         * @return mixed
         */
        
        public function delete_store_fix_asset ( $id ) {
            $this -> db -> delete ( 'general_ledger', array ( 'store_fix_asset_id' => $id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get test sale ledger by Invoice ID
         * -------------------------
         */
        
        public function get_lab_sales_ledger_by_sale_id ( $sale_id ) {
            $info = $this -> db -> get_where ( 'general_ledger', array ( 'lab_sale_id' => $sale_id ) );
            return $info -> row ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get roles
         * -------------------------
         */
        
        public function get_roles () {
            $roles = $this -> db -> get ( 'account_roles' );
            return $roles -> result ();
        }
        
        /**
         * -------------------------
         * @param $role_id
         * get role by id
         * -------------------------
         * @return mixed
         */
        
        public function get_account_role ( $role_id ) {
            $roles = $this -> db -> get_where ( 'account_roles', array ( 'id' => $role_id ) );
            return $roles -> row ();
        }
        
        /**
         * -------------------------
         * @param $role_id
         * delete role
         * -------------------------
         */
        
        public function delete_role ( $role_id ) {
            $this -> db -> delete ( 'account_roles', array ( 'id' => $role_id ) );
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * @return bool
         * is doctor linked with ACC
         * -------------------------
         */
        
        public function check_if_doctor_is_linked_with_account_head ( $doctor_id ) {
            $query = $this -> db -> get_where ( 'account_heads', array ( 'doctor_id' => $doctor_id ) );
            if ( $query -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * @return bool
         * get doctor linked with ACC
         * -------------------------
         */
        
        public function get_doctor_linked_account_head_id ( $doctor_id ) {
            $query = $this -> db -> get_where ( 'account_heads', array ( 'doctor_id' => $doctor_id ) );
            if ( $query -> num_rows () > 0 )
                return $query -> row () -> id;
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @param $voucher_number
         * @return bool
         * generate voucher number
         * -------------------------
         */
        
        public function generate_voucher_number ( $voucher_number ) {
            $query = $this -> db -> query ( " Select *  from hmis_general_ledger where voucher_number LIKE '$voucher_number%' order by id DESC" );
            if ( $query -> num_rows () > 0 ) {
                $v_no = explode ( '-', $query -> row () -> voucher_number );
                $rows = $v_no[ 1 ] + 1;
                return $voucher_number . '-' . $rows;
            }
            else
                return $voucher_number . '-1';
        }
        
        /**
         * -------------------------
         * @param $voucher_number
         * @param $transaction_id
         * @return bool
         * get second transaction by voucher number
         * -------------------------
         */
        
        public function get_second_transaction_by_voucher_number ( $voucher_number, $transaction_id ) {
            $query = $this -> db -> get_where ( 'general_ledger', array (
                'id !='          => $transaction_id,
                'voucher_number' => $voucher_number
            ) );
            if ( $query -> num_rows () > 0 )
                return $query -> row ();
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * @param $financial_year
         * @return mixed
         * calculate acc heads transactions
         * -------------------------
         */
        
        public function calculate_acc_head_transaction ( $acc_head_id, $financial_year = false ) {
            
            $start_date = @$_REQUEST[ 'start_date' ];
            $end_date   = @$_REQUEST[ 'end_date' ];
            $search     = false;
            
            $sql = "Select SUM(credit) as credit, SUM(debit) as debit from hmis_general_ledger where acc_head_id=$acc_head_id";
            if ( isset( $start_date ) and !empty( trim ( $start_date ) ) and isset( $end_date ) and !empty( trim ( $end_date ) ) and !$financial_year ) {
                $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                $sql        .= " and DATE(trans_date) BETWEEN '$start_date' AND '$end_date'";
                $search     = true;
            }
            else if ( $financial_year ) {
                $trans_date = $_REQUEST[ 'trans_date' ];
                $month      = date ( 'm' );
                if ( $month <= 7 )
                    $year = date ( 'Y' ) - 1;
                else
                    $year = date ( 'Y' );
                $start_date = '2010-07-01';
                $end_date   = date ( 'Y-m-d', strtotime ( $trans_date ) );
                $sql        .= " and DATE(trans_date) BETWEEN '$start_date' AND '$end_date'";
                $search     = true;
            }
            $query = $this -> db -> query ( $sql );
            return $search ? $query -> row () : null;
        }
        
        /**
         * -------------------------
         * @param $acc_head_ids
         * @param $financial_year
         * @return mixed
         * calculate acc heads transactions
         * -------------------------
         */
        
        public function calculate_sub_acc_head_transaction ( $acc_head_ids, $financial_year = false ) {
            
            $start_date = @$_REQUEST[ 'start_date' ];
            $end_date   = @$_REQUEST[ 'end_date' ];
            
            if ( !empty( trim ( $acc_head_ids ) ) ) {
                $sql = "Select SUM(credit) as credit, SUM(debit) as debit, SUM(credit) as credit from hmis_general_ledger where acc_head_id IN ($acc_head_ids)";
                if ( isset( $start_date ) and !empty( trim ( $start_date ) ) and isset( $end_date ) and !empty( trim ( $end_date ) ) and !$financial_year ) {
                    $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                    $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                    $sql        .= " and DATE(trans_date) BETWEEN '$start_date' AND '$end_date'";
                }
                else if ( $financial_year ) {
                    $trans_date = $_REQUEST[ 'trans_date' ];
                    $month      = date ( 'm' );
                    if ( $month <= 7 )
                        $year = date ( 'Y' ) - 1;
                    else
                        $year = date ( 'Y' );
                    $start_date = '2020-07-01';
                    $end_date   = date ( 'Y-m-d', strtotime ( $trans_date ) );
                    $sql        .= " and DATE(trans_date) BETWEEN '$start_date' AND '$end_date'";
                }
                $query = $this -> db -> query ( $sql );
                return $query -> row ();
            }
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * @return mixed
         * get account heads by id
         * -------------------------
         */
        
        public function get_specific_account_heads ( $acc_head_id ) {
            $query = $this -> db -> get_where ( 'account_heads', array ( 'id' => $acc_head_id ) );
            return $query -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get financial year
         * -------------------------
         */
        
        public function get_financial_year () {
            $query = $this -> db -> get ( 'financial_year' );
            return $query -> row ();
        }
        
        /**
         * -------------------------
         * @param $acc_head_id
         * get balance sheet
         * -------------------------
         * @return int
         */
        
        public function get_balance_sheet ( $acc_head_id ) {
            $net_closing_balance = 0;
            if ( isset( $_REQUEST[ 'trans_date' ] ) and !empty( trim ( $_REQUEST[ 'trans_date' ] ) ) ) {
                $sql          = $this -> db -> query ( "Select * from hmis_account_heads where id=$acc_head_id or parent_id=$acc_head_id" );
                $accountHeads = $sql -> result ();
                if ( count ( $accountHeads ) > 0 ) {
                    foreach ( $accountHeads as $accountHead ) {
                        $accountHeadID = $accountHead -> id;
                        $transactions  = $this -> get_transactions_by_date ( $accountHeadID, $_REQUEST[ 'trans_date' ] );
                        
                        if ( $transactions and count ( $transactions ) > 0 ) {
                            end ( $transactions );
                            $last_key = key ( $transactions );
                            
                            $counter                 = 1;
                            $total_credit            = 0;
                            $total_debit             = 0;
                            $running_balance         = 0;
                            $current_opening_balance = get_opening_balance_previous_than_searched_start_date ( $_REQUEST[ 'trans_date' ], $accountHeadID );
                            
                            if ( $current_opening_balance >= 0 or $current_opening_balance < 0 )
                                $running_balance = $current_opening_balance;
                            else
                                $running_balance = 0;
                            foreach ( $transactions as $key => $transaction ) {
                                $parent = get_account_head_parent ( $transaction -> acc_head_id );
                                if ( $transaction -> transaction_type == 'opening_balance' and $counter == 1 )
                                    $running_balance = $transaction -> debit + $transaction -> credit;
                                else if ( !empty( $parent ) and ( $parent == bank_id or $parent == cash_from_pharmacy or $parent == cash_from_lab or $parent == cash_from_opd ) )
                                    $running_balance = ( $running_balance + $transaction -> credit ) - $transaction -> debit;
                                else if ( $transaction -> acc_head_id == cash_from_pharmacy or $transaction -> acc_head_id == cash_from_lab or $transaction -> acc_head_id == cash_from_opd )
                                    $running_balance = ( $running_balance + $transaction -> credit ) - $transaction -> debit;
                                else
                                    $running_balance = ( $running_balance - $transaction -> debit ) + $transaction -> credit;
                                
                                if ( $transaction -> transaction_type != 'opening_balance' ) {
                                    $total_credit += $transaction -> credit;
                                    $total_debit  += $transaction -> debit;
                                }
                            }
                            $net_closing_balance += ( $total_credit - $total_debit );
                        }
                    }
                }
            }
            return array (
                'account_head_id' => $acc_head_id,
                'net_closing'     => $net_closing_balance
            );
        }
        
        /**
         * -------------------------
         * @param $date
         * @param $acc_head_id
         * @return mixed
         * get transactions by account head id and date
         * -------------------------
         */
        
        public function get_transactions_by_date ( $acc_head_id, $date ) {
            $financial_year = $this -> db -> get ( 'financial_year' );
            if ( $financial_year -> num_rows () > 0 ) {
                $start_date = $financial_year -> row () -> start_date;
            }
            else {
                $month = date ( 'm' );
                if ( $month < 7 )
                    $year = date ( 'Y' ) - 1;
                else
                    $year = date ( 'Y' );
                $start_date = '2020-07-01';
            }
            
            $sql = "Select * from hmis_general_ledger where acc_head_id=$acc_head_id";
            if ( !empty( trim ( $date ) ) ) {
                $trans_date = date ( 'Y-m-d', strtotime ( $date ) );
                $sql        .= " and trans_date BETWEEN '$start_date' AND '$trans_date'";
            }
            $sql          .= " order by trans_date ASC";
            $transactions = $this -> db -> query ( $sql );
            
            return $transactions -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * upsert financial year
         * -------------------------
         */
        
        public function upsert_financial_year ( $data ) {
            $year = $this -> db -> get ( 'financial_year' );
            if ( $year -> num_rows () > 0 ) {
                $this -> db -> update ( 'financial_year', $data );
            }
            else
                $this -> db -> insert ( 'financial_year', $data );
        }
        
        /**
         * -------------------------
         * @return int
         * calculate net profit for balance sheet
         * -------------------------
         */
        
        public function balance_sheet_net_profit () {
            $sales_account_head              = $this -> get_specific_account_heads ( sales_id );
            $returns_allowances_account_head = get_account_head ( Returns_and_Allowances );
            $fee_discounts_account_head      = $this -> get_specific_account_heads ( Fee_Discounts );
            $Direct_Costs_account_head       = $this -> get_specific_account_heads ( Direct_Costs );
            $expenses_account_head           = $this -> get_specific_account_heads ( expense_id );
            $Finance_Cost_account_head       = get_account_head ( Finance_Cost );
            $Tax_account_head                = get_account_head ( Tax );
            $sales_debit                     = calculate_sales_debit ( $sales_account_head );
            $allowances_credit               = calculate_allowances_credit ( $returns_allowances_account_head );
            $fee_discounts_credit            = calculate_fee_discounts_credit ( $fee_discounts_account_head );
            $sales_net                       = $sales_debit - $allowances_credit - $fee_discounts_credit;
            $direct_cost_credit              = calculate_direct_cost_credit ( $Direct_Costs_account_head );
            $direct_cost_net                 = $sales_net - $direct_cost_credit;
            $expense_account_credit          = calculate_expense_account_credit ( $expenses_account_head );
            $finance_cost_debit              = 0;
            $acc_head_id                     = $Finance_Cost_account_head -> id;
            $transaction                     = calculate_acc_head_transaction ( $acc_head_id, true );
            $finance_cost_debit              = $finance_cost_debit + $transaction -> credit;
            $net_revenue_before_tax          = $direct_cost_net - $expense_account_credit - $finance_cost_debit;
            $tax_debit                       = 0;
            $acc_head_id                     = $Tax_account_head -> id;
            $transaction                     = calculate_acc_head_transaction ( $acc_head_id, true );
            $tax_debit                       = $tax_debit + $transaction -> debit;
            return $net_revenue_before_tax - $tax_debit;
        }
        
        function get_general_and_administrative_expenses_data ( $parent_id ) {
            $accounts = $this -> db -> query ( "SELECT * FROM hmis_account_heads WHERE parent_id=$parent_id" );
            return $accounts -> result_array ();
        }
        
        function get_ledger_by_account_head ( $account_head_id ) {
            $sql = "SELECT * FROM hmis_general_ledger WHERE acc_head_id=$account_head_id";
            
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql        .= " and trans_date BETWEEN '$start_date' and '$end_date'";
            }
            
            $ledger = $this -> db -> query ( $sql );
            return $ledger -> result ();
        }

//        function get_trial_balance_sheet ( $account_id ) {
//            $query = $this -> db -> query ( "Select parent_id, GROUP_CONCAT(id ORDER BY id ASC) as ids, GROUP_CONCAT(title ORDER BY title ASC) as titles from hmis_account_heads where id NOT IN ($account_id) GROUP BY parent_id" );
//            return $query -> result_array ();
//        }
//
//        function build_table ( $account_heads ) {
//
//            $html       = '<tbody>';
//            $net_debit  = 0;
//            $net_credit = 0;
//            $counter    = 1;
//            $start_date = ( isset( $_GET[ 'start_date' ] ) && !empty( trim ( $_GET[ 'start_date' ] ) ) ) ? date ( 'Y-m-d', strtotime ( $_GET[ 'start_date' ] ) ) : null;
//
//            foreach ( $account_heads as $account_head ) {
//
//                $ids                 = explode ( ',', $account_head[ 'ids' ] );
//                $parent_id           = $account_head[ 'parent_id' ];
//                $titles              = explode ( ',', $account_head[ 'titles' ] );
//                $childRunningBalance = 0;
//
//                if ( count ( $ids ) > 0 ) {
//                    foreach ( $ids as $acc_head_id ) {
//                        $transaction = calculate_acc_head_transaction ( $acc_head_id );
//
//                        if ( !empty( $transaction ) )
//                            $childRunningBalance += $transaction -> debit - $transaction -> credit;
//                        else
//                            $childRunningBalance += 0;
//                    }
//                }
//
//                if ( $parent_id > 0 && abs ( $childRunningBalance ) > 0 ) {
//                    $parent = $this -> get_account_head_by_id ( $parent_id );
//                    if ( !empty( $parent ) ) {
//                        $html .= '<tr>';
//                        $html .= '<td>' . $counter++ . '</td>';
//                        $html .= '<td colspan="5"><strong>' . $parent -> title . '</strong></td>';
//                        $html .= '</tr>';
//                    }
//                }
//
//                if ( count ( $ids ) > 0 ) {
//                    foreach ( $ids as $key => $acc_head_id ) {
//
//                        if ( !empty( trim ( $start_date ) ) )
//                            $opening_balance = get_opening_balance_previous_than_searched_start_date ( $start_date, $acc_head_id );
//                        else
//                            $opening_balance = 0;
//
//                        $transaction    = calculate_acc_head_transaction ( $acc_head_id );
//                        $runningBalance = 0;
//
//                        if ( !empty( $transaction ) ) {
//                            $net_credit     = $net_credit + $transaction -> credit;
//                            $net_debit      = $net_debit + $transaction -> debit;
//                            $runningBalance = $transaction -> debit - $transaction -> credit;
//                        }
//
//                        $title = $titles[ $key ];
//
//                        if ( abs ( $runningBalance ) > 0 ) {
//
//                            $html .= '<tr>';
//                            $html .= '<td></td>';
//                            $html .= '<td style="padding-left: 25px">' . $title . '</td>';
//                            $html .= '<td>' . number_format ( $opening_balance, 2 ) . '</td>';
//                            $html .= '<td>' . number_format ( $transaction -> credit, 2 ) . '</td>';
//                            $html .= '<td>' . number_format ( $transaction -> debit, 2 ) . '</td>';
//                            $html .= '<td>' . number_format ( $runningBalance, 2 ) . '</td>';
//                            $html .= '</tr>';
//                        }
//                    }
//                }
//
//            }
//
//            $html .= '</tbody>';
//            $html .= '<tfoot>';
//            $html .= '<tr>';
//            $html .= '<td colspan="3" align="right"></td>';
//            $html .= '<td><strong> ' . number_format ( $net_credit, 2 ) . '</strong></td>';
//            $html .= '<td><strong> ' . number_format ( $net_debit, 2 ) . ' </strong></td>';
//            $html .= '<td><strong>' . number_format ( $net_credit - $net_debit, 2 ) . '</strong></td>';
//            $html .= '</tr>';
//            $html .= '</tfoot>';
//
//            return $html;
//        }
        
        function get_trial_balance_sheet ( $account_id ) {
            $this -> db -> order_by ( 'parent_id', 'ASC' );
            $this -> db -> order_by ( 'title', 'ASC' );
            $this -> db -> where_not_in ( 'id', $account_id );
            $query = $this -> db -> get ( "account_heads" );
            return $query -> result_array ();
        }
        
        function build_table ( $data, $level = 0 ) {
            
            $html       = '<tbody>';
            $start_date = ( isset( $_GET[ 'start_date' ] ) && !empty( trim ( $_GET[ 'start_date' ] ) ) ) ? date ( 'Y-m-d', strtotime ( $_GET[ 'start_date' ] ) ) : null;
            
            foreach ( $data as $row ) {
                $acc_head_id = $row[ 'id' ];
                
                $padding = str_repeat ( '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $level );
                
                if ( isset( $row[ 'children' ] ) && count ( $row[ 'children' ] ) > 0 )
                    $title = '<strong>' . $row[ 'title' ] . '</strong>';
                else
                    $title = $row[ 'title' ];
                
                if ( !empty( $start_date ) )
                    $opening_balance = get_opening_balance_previous_than_searched_start_date ( $start_date, $acc_head_id );
                else
                    $opening_balance = 0;
                
                $transaction    = calculate_acc_head_transaction ( $acc_head_id );
                $runningBalance = 0;
                
                if ( !empty( $transaction ) ) {
                    $this -> net_credit = $this -> net_credit + $transaction -> credit;
                    $this -> net_debit  = $this -> net_debit + $transaction -> debit;
                    
                    if ( in_array ( $row[ 'role_id' ], array ( assets, expenditure ) ) )
                        $runningBalance = $runningBalance + $transaction -> credit - $transaction -> debit;
                    
                    else if ( in_array ( $row[ 'role_id' ], array ( liabilities, capitals, income ) ) )
                        $runningBalance = $runningBalance - $transaction -> credit + $transaction -> debit;

//                    $runningBalance     = $transaction -> debit - $transaction -> credit;
                }
                
                if ( isset( $row[ 'children' ] ) && count ( $row[ 'children' ] ) > 0 ) {
                    
                    $this -> parent_net_credit  = 0;
                    $this -> parent_net_debit   = 0;
                    $this -> parent_net_opening = 0;
                    $this -> parent_net_rb      = 0;
                    
                    $parentRunningBalance    = $this -> trial_balance_parent_wise_total ( $row[ 'children' ], $start_date );
                    $this -> net_net_opening += $parentRunningBalance[ 'net_opening' ];
                    
                    $html .= "<tr>";
                    $html .= "<td>{$padding}{$title}</td>";
                    $html .= "<td style='color: #FF0000'><strong>" . number_format ( $parentRunningBalance[ 'net_opening' ], 2 ) . "</strong></td>";
                    $html .= "<td style='color: #FF0000'><strong>" . number_format ( $parentRunningBalance[ 'net_credit' ], 2 ) . "</strong></td>";
                    $html .= "<td style='color: #FF0000'><strong>" . number_format ( $parentRunningBalance[ 'net_debit' ], 2 ) . "</strong></td>";
                    $html .= "<td style='color: #FF0000'><strong>" . number_format ( ( $parentRunningBalance[ 'net_rb' ] + $parentRunningBalance[ 'net_opening' ] ), 2 ) . "</strong></td>";
                    $html .= "</tr>";
                }
                else {
                    if ( !empty( $transaction ) && ( abs ( $transaction -> credit ) > 0 || abs ( $transaction -> debit ) > 0 ) ) {
                        $this -> net_net_opening += $opening_balance;
                        $html                    .= "<tr>";
                        $html                    .= "<td>{$padding}{$title}</td>";
                        $html                    .= "<td>" . number_format ( $opening_balance, 2 ) . "</td>";
                        $html                    .= "<td>" . number_format ( $transaction -> credit, 2 ) . "</td>";
                        $html                    .= "<td>" . number_format ( $transaction -> debit, 2 ) . "</td>";
                        $html                    .= "<td>" . number_format ( ( $runningBalance + $opening_balance ), 2 ) . "</td>";
                        $html                    .= "</tr>";
                    }
                }
                
                if ( isset( $row[ 'children' ] ) && is_array ( $row[ 'children' ] ) ) {
                    $html .= $this -> build_table ( $row[ 'children' ], $level + 1 );
                }
            }
            
            $html .= '</tbody>';
            return $html;
        }
        
        public function trial_balance_total () {
            $html = '<tfoot>';
            $html .= '<tr>';
            $html .= '<td align="right"></td>';
            $html .= '<td><strong> ' . number_format ( $this -> net_net_opening, 2 ) . '</strong></td>';
            $html .= '<td><strong> ' . number_format ( $this -> net_credit, 2 ) . '</strong></td>';
            $html .= '<td><strong> ' . number_format ( $this -> net_debit, 2 ) . ' </strong></td>';
            $html .= '<td><strong>' . number_format ( $this -> net_credit - $this -> net_debit, 2 ) . '</strong></td>';
            $html .= '</tr>';
            return $html;
        }
        
        public function trial_balance_parent_wise_total ( $account_heads, $start_date = null ) {
            
            foreach ( $account_heads as $row ) {
                $acc_head_id = $row[ 'id' ];
                if ( !empty( $start_date ) )
                    $opening_balance = get_opening_balance_previous_than_searched_start_date ( $start_date, $acc_head_id );
                else
                    $opening_balance = 0;
                
                $this -> parent_net_opening += $opening_balance;
                
                $transaction    = calculate_acc_head_transaction ( $acc_head_id );
                $runningBalance = 0;
                
                if ( !empty( $transaction ) ) {
                    $this -> parent_net_credit += $transaction -> credit;
                    $this -> parent_net_debit  += $transaction -> debit;
                    
                    if ( in_array ( $row[ 'role_id' ], array ( assets, expenditure ) ) )
                        $this -> parent_net_rb = $this -> parent_net_rb + $transaction -> credit - $transaction -> debit;
                    
                    else if ( in_array ( $row[ 'role_id' ], array ( liabilities, capitals, income ) ) )
                        $this -> parent_net_rb = $this -> parent_net_rb - $transaction -> credit + $transaction -> debit;

//                    $this -> parent_net_rb += ( $transaction -> debit - $transaction -> credit );
                }
                
                if ( isset( $row[ 'children' ] ) && is_array ( $row[ 'children' ] ) )
                    $this -> trial_balance_parent_wise_total ( $row[ 'children' ] );
            }
            
            return array (
                'net_credit'  => $this -> parent_net_credit,
                'net_debit'   => $this -> parent_net_debit,
                'net_rb'      => $this -> parent_net_rb,
                'net_opening' => $this -> parent_net_opening
            );
            
        }
        
        public function filter_general_ledger () {
            
            $search             = false;
            $result             = null;
            $voucher_number     = $this -> input -> get ( 'voucher' );
            $transaction_number = $this -> input -> get ( 'transaction_number' );
            
            if ( isset( $transaction_number ) && !empty( trim ( $transaction_number ) ) ) {
                $search = true;
                $this -> db -> where ( array ( 'id' => $transaction_number ) );
            }
            
            if ( isset( $voucher_number ) && !empty( trim ( $voucher_number ) ) ) {
                $search = true;
                $this -> db -> where ( array ( 'voucher_number' => $voucher_number ) );
            }
            
            if ( $search ) {
                $query  = $this -> db -> get ( 'general_ledger' );
                $result = $query -> row ();
            }
            
            return $search ? $result : null;
            
        }
        
        function get_chart_of_accounts ( $parent_id = 0 ) {
            $this -> db -> select ( '*' );
            $this -> db -> from ( 'account_heads' );
            
            if ( $parent_id > 0 )
                $this -> db -> where ( array ( 'parent_id' => $parent_id ) );
            
            $this -> db -> order_by ( 'sort_order', 'ASC' );
            $query = $this -> db -> get ();
            return $query -> result_array ();
        }
        
        function build_chart_of_accounts_table ( $data, $level = 0, $hide_actions = false ) {
            
            $html = '<tbody>';
            foreach ( $data as $row ) {
                $acc_head_id = $row[ 'id' ];
                $ledger      = $this -> get_ledger_by_account_head ( $acc_head_id );
                $parent      = $this -> check_if_account_is_parent ( $acc_head_id );
                
                $padding = str_repeat ( '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $level );
                
                if ( isset( $row[ 'children' ] ) && count ( $row[ 'children' ] ) > 0 )
                    $title = '<strong>' . $row[ 'title' ] . '</strong>';
                else
                    $title = $row[ 'title' ];
                
                $html .= "<tr>";
                $html .= "<td>{$padding}{$title}</td>";
                
                $html .= "<td>";
                if ( $row[ 'status' ] == '0' )
                    $html .= "<span class='badge badge-warning'>Inactive</span>";
                else
                    $html .= "<span class='badge badge-success'>Active</span>";
                $html .= "</td>";
                
                if ( !$hide_actions ) {
                    $html .= "<td>";
                    if ( $row[ 'editable' ] == '1' ) {
                        if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_chart_of_accounts', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) {
                            $html .= '<a href="' . base_url ( '/accounts/edit/' . $acc_head_id ) . '" class="btn btn-warning btn-xs"> <i class="fa fa-pencil"></i> Edit </a>';
                        }
                    }
                    
                    if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_chart_of_accounts', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) && ( $row[ 'parent_id' ] < 1 || empty( trim ( $row[ 'parent_id' ] ) ) || count ( $ledger ) < 1 ) && !$parent && $row[ 'deleteable' ] == '1' )
                        $html .= '<a href="' . base_url ( '/accounts/delete/' . $acc_head_id ) . '" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure to delete?\')"> <i class="fa fa-trash-o"></i> Delete </a>';
                    $html .= "</td>";
                }
                $html .= "</tr>";
                
                if ( isset( $row[ 'children' ] ) && is_array ( $row[ 'children' ] ) ) {
                    $html .= $this -> build_chart_of_accounts_table ( $row[ 'children' ], $level + 1, $hide_actions );
                }
            }
            
            $html .= '</tbody>';
            return $html;
        }
        
        public function filter_transactions () {
            $voucher      = $this -> input -> get ( 'voucher', true );
            $transactions = array ();
            
            if ( !empty( trim ( $voucher ) ) ) {
                $transactions = $this -> db -> get_where ( 'general_ledger', array ( 'voucher_number' => $voucher ) );
                return $transactions -> result ();
            }
            
            return $transactions;
            
        }
        
        public function filter_balance_sheet ( $id ) {
            $net_closing = 0;
            $trans_date  = $this -> input -> get ( 'trans_date' );
            if ( !empty( trim ( $trans_date ) ) ) {
                
                $account_heads = $this -> db
                    -> select ( 'id, parent_id, role_id, title' )
                    -> from ( 'account_heads' )
                    -> where ( 'id', $id )
                    -> get ();
                $results       = $account_heads -> result_array ();
                
                if ( count ( $results ) > 0 ) {
                    foreach ( $results as $result ) {
                        $total_credit = 0;
                        $total_debit  = 0;
                        
                        $transaction = $this -> sum_transactions_by_date ( $result[ 'id' ], $_REQUEST[ 'trans_date' ] );
                        if ( !empty( $transaction ) && ( !empty( trim ( $transaction -> credit ) ) || !empty( trim ( $transaction -> debit ) ) ) ) {
                            $total_credit += $transaction -> credit;
                            $total_debit  += $transaction -> debit;
                        }
                        
                        $net_closing += ( $total_credit - $total_debit );
                        $net_closing += $this -> get_child_account_heads_by_parent ( $result[ 'id' ] );
                    }
                }
            }
            
            return array (
                'account_head_id' => $id,
                'net_closing'     => abs ( $net_closing )
            );
        }
        
        public function get_child_account_heads_by_parent ( $id ) {
            $net_closing = 0;
            
            $account_heads = $this -> db
                -> select ( 'id, parent_id, role_id, title' )
                -> from ( 'account_heads' )
                -> where ( 'parent_id', $id )
                -> get ();
            $results       = $account_heads -> result_array ();
            
            if ( count ( $results ) > 0 ) {
                foreach ( $results as $result ) {
                    $total_credit = 0;
                    $total_debit  = 0;
                    
                    $transaction = $this -> sum_transactions_by_date ( $result[ 'id' ], $_REQUEST[ 'trans_date' ] );
                    if ( !empty( $transaction ) && ( !empty( trim ( $transaction -> credit ) ) || !empty( trim ( $transaction -> debit ) ) ) ) {
                        $total_credit += $transaction -> credit;
                        $total_debit  += $transaction -> debit;
                    }
                    
                    $net_closing += ( $total_credit - $total_debit );
                    $net_closing += $this -> get_child_account_heads_by_parent ( $result[ 'id' ] );
                }
            }
            
            return abs ( $net_closing );
        }
        
        public function sum_transactions_by_date ( $acc_head_id, $date ) {
            $financial_year = $this -> db -> get ( 'financial_year' );
            if ( $financial_year -> num_rows () > 0 ) {
                $start_date = $financial_year -> row () -> start_date;
            }
            else {
                $month = date ( 'm' );
                if ( $month < 7 )
                    $year = date ( 'Y' ) - 1;
                else
                    $year = date ( 'Y' );
                $start_date = '2020-07-01';
            }
            
            $sql = "Select SUM(credit) as credit, SUM(debit) as debit from hmis_general_ledger where acc_head_id=$acc_head_id AND transaction_type!='opening_balance'";
            if ( !empty( trim ( $date ) ) ) {
                $trans_date = date ( 'Y-m-d', strtotime ( $date ) );
                $sql        .= " and trans_date BETWEEN '$start_date' AND '$trans_date'";
            }
            $sql          .= " order by trans_date ASC";
            $transactions = $this -> db -> query ( $sql );
            
            return $transactions -> row ();
        }
        
        public function getRecursiveAccountHeads ( $parentID = 0, $array = false ) {
            if ( $parentID > 0 ) {
                $this -> db -> select ( '*' );
                $this -> db -> from ( 'account_heads' );
                $this -> db -> where ( 'parent_id', $parentID );
                $query  = $this -> db -> get ();
                $result = $array ? $query -> result_array () : $query -> result ();
                
                $records = array ();
                foreach ( $result as $row ) {
                    $id = $array ? $row[ 'id' ] : $row -> id;
                    
                    if ( $array )
                        $row[ 'children' ] = $this -> getRecursiveAccountHeads ( $id, $array );
                    else
                        $row -> children = $this -> getRecursiveAccountHeads ( $id, $array );
                    
                    $records[] = $row;
                }
                
                return $records;
            }
            return array ();
        }
        
        public function get_account_head_credit_sum ( $account_head_id ) {
            $start_date = $this -> input -> get ( 'start-date' );
            $end_date   = $this -> input -> get ( 'end-date' );
            
            $data = $this
                -> db
                -> select ( 'SUM(credit) as credit' )
                -> from ( 'general_ledger' )
                -> where ( 'acc_head_id', $account_head_id );
            
            if ( isset( $start_date ) && !empty( trim ( $start_date ) ) && isset( $end_date ) && !empty( trim ( $end_date ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                $data -> where ( "DATE(trans_date) BETWEEN '$start_date' AND '$end_date'" );
            }
            
            $data = $data -> get ();
            return $data -> num_rows () > 0 ? $data -> row () -> credit : 0;
        }
        
        public function get_account_head_debit_sum ( $account_head_id ) {
            $start_date = $this -> input -> get ( 'start-date' );
            $end_date   = $this -> input -> get ( 'end-date' );
            
            $data = $this
                -> db
                -> select ( 'SUM(debit) as debit' )
                -> from ( 'general_ledger' )
                -> where ( 'acc_head_id', $account_head_id );
            
            if ( isset( $start_date ) && !empty( trim ( $start_date ) ) && isset( $end_date ) && !empty( trim ( $end_date ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                $data -> where ( "DATE(trans_date) BETWEEN '$start_date' AND '$end_date'" );
            }
            
            $data = $data -> get ();
            return $data -> num_rows () > 0 ? $data -> row () -> debit : 0;
        }
        
        public function check_if_account_is_parent ( $account_head_id ) {
            $data   = $this
                -> db
                -> select ( 'parent_id, SUM(id) as totalRows' )
                -> from ( 'account_heads' )
                -> where ( 'parent_id', $account_head_id )
                -> get ();
            $result = $data -> row ();
            
            if ( $result -> totalRows > 0 )
                return true;
            else
                return false;
        }
        
        public function search_transactions ( $acc_head_id ) {
            $start_date = $this -> input -> get ( 'start-date' );
            $end_date   = $this -> input -> get ( 'end-date' );
            
            $transactions = $this -> db -> select ( '*' ) -> from ( 'general_ledger' ) -> where ( 'acc_head_id', $acc_head_id );
            if ( isset( $start_date ) and !empty( $start_date ) and isset( $end_date ) and !empty( $end_date ) ) {
                $start_date   = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date     = date ( 'Y-m-d', strtotime ( $end_date ) );
                $transactions = $transactions -> where ( "DATE(trans_date) BETWEEN '$start_date' and '$end_date'" );
            }
            $transactions -> order_by ( 'trans_date, id', 'ASC' );
            $transactions = $transactions -> get ();
            return $transactions -> result ();
        }
        
        public function get_transactions_order_by_debit ( $where ) {
            $this -> db -> order_by ( 'transaction_type', 'ASC' );
            $transaction = $this -> db -> get_where ( 'general_ledger', $where );
            return $transaction -> result ();
        }
        
        public function get_accounts_by_role ( $role_id ) {
            $account_heads = $this
                -> db
                -> select ( '*' )
                -> from ( 'account_heads' )
                -> where ( "role_id=$role_id AND (parent_id IS NULL OR parent_id < 1)" )
                -> get ();
            return $account_heads -> result ();
        }
        
        function build_charts_of_accounts_table ( $data, $level = 0 ) {
            
            $html = '<tbody>';
            foreach ( $data as $row ) {
                
                $padding = str_repeat ( '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $level );
                
                if ( isset( $row[ 'children' ] ) && count ( $row[ 'children' ] ) > 0 )
                    $title = '<strong>' . $row[ 'title' ] . '</strong>';
                else
                    $title = $row[ 'title' ];
                
                $html .= "<tr>";
                $html .= "<td>{$padding}{$title}</td>";
                
                $html .= "</tr>";
                
                if ( isset( $row[ 'children' ] ) && is_array ( $row[ 'children' ] ) ) {
                    $html .= $this -> build_charts_of_accounts_table ( $row[ 'children' ], $level + 1 );
                }
            }
            
            $html .= '</tbody>';
            return $html;
        }
        
        public function delete_ipd_consultant ( $sale_id, $doctor_id ) {
            $this -> db -> delete ( 'general_ledger', array ( 'ipd_sale_id' => $sale_id, 'acc_head_id' => $doctor_id ) );
        }
        
        public function delete_ipd_anesthesia_doctor ( $sale_id, $doctor_id ) {
            $this -> db -> delete ( 'general_ledger', array ( 'ipd_sale_id' => $sale_id, 'acc_head_id' => $doctor_id ) );
        }
        
        public function delete_payment ( $payment_id ) {
            $this -> db -> delete ( 'general_ledger', array ( 'payment_id' => $payment_id ) );
        }
        
        public function search_transactions_by_voucher () {
            $search         = false;
            $voucher_number = $this -> input -> get ( 'voucher' );
            
            $this -> db -> select ( '*' ) -> from ( 'general_ledger' );
            
            if ( !empty( trim ( $voucher_number ) ) ) {
                $search = true;
                $this -> db -> where ( array ( 'voucher_number' => $voucher_number ) );
            }
            
            $transactions = $this -> db -> get ();
            return $search ? $transactions -> result () : array ();
        }
        
        public function get_transactions_by_voucher ( $voucher_number ) {
            $transactions = $this -> db -> get_where ( 'general_ledger', array ( 'voucher_number' => $voucher_number ) );
            return $transactions -> result ();
        }
        
        public function get_consultants ( $account_head_id ) {
            $heads = $this -> db -> get_where ( 'account_heads', array ( 'parent_id' => $account_head_id ) );
            return $heads -> result ();
        }
        
        public function pay_consultant_consultancy ( $doctor_id, $paid_amount, $payment_mode, $description, $voucher_no, $payable ) {
            $ledger = array (
                'user_id'          => get_logged_in_user_id (),
                'acc_head_id'      => cash_from_opd_consultancy,
                'trans_date'       => date ( 'Y-m-d' ),
                'payment_mode'     => $payment_mode,
                'paid_via'         => $payment_mode,
                'voucher_number'   => $voucher_no,
                'credit'           => 0,
                'debit'            => $paid_amount,
                'transaction_type' => 'debit',
                'description'      => 'Consultancy amount paid via Pay Consultant. Against Sale ID# ' . $payable -> consultancies . $description,
                'transaction_no'   => $this -> input -> post ( 'transaction-no' ),
                'date_added'       => current_date_time (),
            );
            $this -> AccountModel -> add_ledger ( $ledger );
            
            $doc_account_head             = $this -> get_doctor_linked_account_head_id ( $doctor_id );
            $ledger[ 'acc_head_id' ]      = $doc_account_head;
            $ledger[ 'credit' ]           = $paid_amount;
            $ledger[ 'debit' ]            = 0;
            $ledger[ 'transaction_type' ] = 'credit';
            $this -> AccountModel -> add_ledger ( $ledger );
        }
        
        public function pay_consultant_opd ( $doctor_id, $paid_amount, $payment_mode, $description, $voucher_no, $payable ) {
            $ledger = array (
                'user_id'          => get_logged_in_user_id (),
                'acc_head_id'      => cash_from_opd_services,
                'trans_date'       => date ( 'Y-m-d' ),
                'payment_mode'     => $payment_mode,
                'paid_via'         => $payment_mode,
                'voucher_number'   => $voucher_no,
                'credit'           => 0,
                'debit'            => $paid_amount,
                'transaction_type' => 'debit',
                'description'      => 'OPD amount paid via Pay Consultant. Against Sale ID# ' . implode ( ',', $payable[ 'sales' ] ) . $description,
                'transaction_no'   => $this -> input -> post ( 'transaction-no' ),
                'date_added'       => current_date_time (),
            );
            $this -> AccountModel -> add_ledger ( $ledger );
            
            $doc_account_head             = $this -> get_doctor_linked_account_head_id ( $doctor_id );
            $ledger[ 'acc_head_id' ]      = $doc_account_head;
            $ledger[ 'credit' ]           = $paid_amount;
            $ledger[ 'debit' ]            = 0;
            $ledger[ 'transaction_type' ] = 'credit';
            $this -> AccountModel -> add_ledger ( $ledger );
        }
        
        public function pay_consultant_lab ( $doctor_id, $paid_amount, $payment_mode, $description, $voucher_no, $payable ) {
            $ledger = array (
                'user_id'          => get_logged_in_user_id (),
                'acc_head_id'      => cash_from_lab,
                'trans_date'       => date ( 'Y-m-d' ),
                'payment_mode'     => $payment_mode,
                'paid_via'         => $payment_mode,
                'voucher_number'   => $voucher_no,
                'credit'           => 0,
                'debit'            => $paid_amount,
                'transaction_type' => 'debit',
                'description'      => 'Lab amount paid via Pay Consultant. Against Sale ID# ' . implode ( ',', $payable[ 'sales' ] ) . $description,
                'transaction_no'   => $this -> input -> post ( 'transaction-no' ),
                'date_added'       => current_date_time (),
            );
            $this -> AccountModel -> add_ledger ( $ledger );
            
            $doc_account_head             = $this -> get_doctor_linked_account_head_id ( $doctor_id );
            $ledger[ 'acc_head_id' ]      = $doc_account_head;
            $ledger[ 'credit' ]           = $paid_amount;
            $ledger[ 'debit' ]            = 0;
            $ledger[ 'transaction_type' ] = 'credit';
            $this -> AccountModel -> add_ledger ( $ledger );
        }
        
        public function get_balance_sheet_account_heads ( $balance_sheet ) {
            $account_heads = $this -> db -> get_where ( 'account_heads', array (
                'balance_sheet' => $balance_sheet
            ) );
            return $account_heads -> result ();
        }
        
    }
