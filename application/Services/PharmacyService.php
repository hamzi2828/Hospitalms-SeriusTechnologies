<?php
    
    class PharmacyService {
        
        private $ci;
        
        public function __construct ( $ci ) {
            $this -> ci = $ci;
        }
        
        public function refund ( $sale ) {
            
            $this -> ci -> load -> model ( 'MedicineModel' );
            $this -> ci -> load -> model ( 'AccountModel' );
            
            $patient_id = get_pharmacy_patient_id_by_sale_id ( $sale -> id );
            if ( empty( trim ( $patient_id ) ) || $patient_id < 1 )
                $patient_id = cash_from_pharmacy;
            
            $cashAccountHead = cash_from_pharmacy;
            if ( $sale -> payment_method == 'card' )
                $cashAccountHead = CARD;
            else if ( $sale -> payment_method == 'bank' )
                $cashAccountHead = $sale -> account_head_id;
            
            $patient_id = ( empty( trim ( $patient_id ) ) || $patient_id < 1 ) ? cash_from_pharmacy : $cashAccountHead;
            
            $description = 'Invoice Refunded. Invoice# ' . $sale -> id;
            $ledger = array (
                'user_id'          => get_logged_in_user_id (),
                'acc_head_id'      => $patient_id,
                'invoice_id'       => $sale -> id,
                'trans_date'       => date ( 'Y-m-d' ),
                'payment_mode'     => 'cash',
                'paid_via'         => 'cash',
                'transaction_type' => 'debit',
                'credit'           => 0,
                'debit'            => $sale -> total,
                'description'      => $description,
                'date_added'       => current_date_time (),
            );
            $this -> ci -> AccountModel -> add_ledger ( $ledger );
            
            if ( is_numeric ( $sale -> discount ) && $sale -> discount > 0 ) {
                
                $net_total_before_discount = $this -> add_discount_back_to_total ( $sale -> total, $sale -> discount );
                
                $ledger[ 'acc_head_id' ] = sales_pharmacy;
                $ledger[ 'transaction_type' ] = 'credit';
                $ledger[ 'credit' ] = $net_total_before_discount;
                $ledger[ 'debit' ] = 0;
                $this -> ci -> AccountModel -> add_ledger ( $ledger );
                
                $ledger[ 'acc_head_id' ] = discount_pharmacy;
                $ledger[ 'transaction_type' ] = 'debit';
                $ledger[ 'credit' ] = 0;
                $ledger[ 'debit' ] = $net_total_before_discount - $sale -> total;
                $this -> ci -> AccountModel -> add_ledger ( $ledger );
                
            }
            
            else if ( is_numeric ( $sale -> flat_discount ) && $sale -> flat_discount > 0 ) {
                
                $ledger[ 'acc_head_id' ] = sales_pharmacy;
                $ledger[ 'transaction_type' ] = 'credit';
                $ledger[ 'credit' ] = $sale -> total + $sale -> flat_discount;
                $ledger[ 'debit' ] = 0;
                $this -> ci -> AccountModel -> add_ledger ( $ledger );
                
                $ledger[ 'acc_head_id' ] = discount_pharmacy;
                $ledger[ 'transaction_type' ] = 'debit';
                $ledger[ 'credit' ] = 0;
                $ledger[ 'debit' ] = $sale -> flat_discount;
                $this -> ci -> AccountModel -> add_ledger ( $ledger );
                
            }
            
            else {
                $ledger[ 'acc_head_id' ] = sales_pharmacy;
                $ledger[ 'transaction_type' ] = 'credit';
                $ledger[ 'credit' ] = $sale -> total;
                $ledger[ 'debit' ] = 0;
                $this -> ci -> AccountModel -> add_ledger ( $ledger );
            }
            
            $total_cost_tp_wise = calculate_cost_of_medicines_sold_by_sale_id ( $sale -> id );
            $ledger[ 'acc_head_id' ] = cost_of_medicine_sold;
            $ledger[ 'transaction_type' ] = 'debit';
            $ledger[ 'credit' ] = 0;
            $ledger[ 'debit' ] = $total_cost_tp_wise;
            $this -> ci -> AccountModel -> add_ledger ( $ledger );
            
            $ledger[ 'acc_head_id' ] = medical_supply_inventory;
            $ledger[ 'transaction_type' ] = 'credit';
            $ledger[ 'credit' ] = $total_cost_tp_wise;
            $ledger[ 'debit' ] = 0;
            $this -> ci -> AccountModel -> add_ledger ( $ledger );
            
            $info = array (
                'refunded' => '1',
                'total'    => ( $sale -> total * -1 )
            );
            $this -> ci -> MedicineModel -> edit_sale ( $info, $sale -> id );
            
        }
        
        public function add_discount_back_to_total ( $total_invoice_value, $discount_percent ) {
            $discount = $discount_percent / 100;
            return $total_invoice_value / ( 1 - $discount );
        }
        
    }