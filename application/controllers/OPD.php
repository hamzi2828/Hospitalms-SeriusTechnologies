<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class OPD extends CI_Controller {
        
        /**
         * -------------------------
         * OPD constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'OPDModel' );
            $this -> load -> model ( 'AccountModel' );
            $this -> load -> model ( 'PanelModel' );
            $this -> load -> model ( 'DoctorModel' );
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
         * sale service main page
         * -------------------------
         */
        
        public function sale () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_sale_service' )
                $this -> do_sale_service ();
            
            $title = site_name . ' - Sale Service';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $this -> load -> view ( '/opd/sale', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add more sale service main page
         * -------------------------
         */
        
        public function add_more_sale_services () {
            $data[ 'row' ]        = $this -> input -> post ( 'added', true );
            $data[ 'patient_id' ] = $patient_id = $this -> input -> post ( 'patient_id', true );
            if ( $patient_id > 0 )
                $panel_id = get_patient ( $patient_id ) -> panel_id;
            else
                $panel_id = 0;
            $data[ 'services' ] = $this -> OPDModel -> get_all_services ( $panel_id );
            $data[ 'doctors' ]  = $this -> DoctorModel -> get_doctors ();
            $this -> load -> view ( '/opd/add-more', $data );
        }
        
        /**
         * -------------------------
         * get service price
         * by service id
         * -------------------------
         */
        
        public function get_service_price_by_id () {
            $service_id = $this -> input -> post ( 'service_id', true );
            $patient_id = $this -> input -> post ( 'patient_id', true );
            $dis        = 0;
            $dis_type   = 'flat';
            $patient    = '';
            if ( !empty( $service_id ) and $service_id > 0 ) {
                $price   = $this -> OPDModel -> get_service_price_by_id ( $service_id );
                $service = $this -> OPDModel -> get_service_by_id ( $service_id );
                if ( isset( $patient_id ) and $patient_id > 0 ) {
                    $patient = get_patient ( $patient_id );
                    if ( $patient -> panel_id > 0 ) {
                        $discount = $this -> PanelModel -> get_opd_panel_service_discount ( $service_id, $patient -> panel_id );
                        if ( !empty( $discount ) ) {
                            $price    = $discount -> price;
                            $dis_type = $discount -> type;
                        }
                    }
                }
                $info = array (
                    'discount'     => $dis,
                    'act_charges'  => $this -> OPDModel -> get_service_price_by_id ( $service_id ),
                    'charges'      => $price,
                    'dis_type'     => $dis_type,
                    'patient_type' => $patient -> type,
                    'service_type' => $service -> service_type
                );
                echo json_encode ( $info );
            }
        }
        
        /**
         * -------------------------
         * @param $POST
         * sale service
         * -------------------------
         */

//        public function do_sale_service ( $POST ) {
//            $data         = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
//            $service_id   = $data[ 'service_id' ];
//            $doctor_id    = $data[ 'doctor_id' ];
//            $service_info = array ();
//
//            $patient = get_patient ( $data[ 'patient_id' ] );
//            if ( $patient -> panel_id > 0 ) {
//                $accHeadID = get_account_head_id_by_panel_id ( $patient -> panel_id );
//                if ( empty( $accHeadID ) ) {
//                    $this -> session -> set_flashdata ( 'error', 'No account head is linked against patient Panel ID.' );
//                    return redirect ( base_url ( '/OPD/sale' ) );
//                }
//            }
//
//            if ( isset( $service_id ) and count ( $service_id ) > 0 ) {
//                $sale    = array (
//                    'user_id'         => get_logged_in_user_id (),
//                    'account_head_id' => $this -> input -> post ( 'bank-id' ),
//                    'total'           => $data[ 'total_sum_opd_services' ],
//                    'discount'        => $data[ 'sale_discount' ],
//                    'flat_discount'   => $data[ 'flat_discount' ],
//                    'net'             => $data[ 'total' ],
//                    'payment_method'  => $this -> input -> post ( 'payment-method' ),
//                    'transaction_no'  => $this -> input -> post ( 'transaction-no' ),
//                    'date_added'      => current_date_time (),
//                );
//                $sale_id = $this -> OPDModel -> add_opd_sale ( $sale );
//
//                $log = array (
//                    'user_id'      => get_logged_in_user_id (),
//                    'patient_id'   => $data[ 'patient_id' ],
//                    'sale_id'      => $sale_id,
//                    'action'       => 'opd_total_sale_added',
//                    'log'          => json_encode ( $sale ),
//                    'after_update' => '',
//                    'date_added'   => current_date_time ()
//                );
//                $this -> load -> model ( 'LogModel' );
//                $this -> LogModel -> create_log ( 'opd_sales_logs', $log );
//
//                foreach ( $service_id as $key => $value ) {
//                    $title = get_service_by_id ( $value ) -> title;
//                    array_push ( $service_info, $title );
//                }
//
//                opd_cash_from_opd_ledger ( $data, $sale_id, $service_info, $patient -> panel_id );
//                opd_sales_opd_services_ledger ( $data, $sale_id, $service_info, $patient -> panel_id );
//
//                if ( ( isset( $data[ 'sale_discount' ] ) and $data[ 'sale_discount' ] > 0 ) || ( isset( $data[ 'flat_discount' ] ) and $data[ 'flat_discount' ] > 0 ) )
//                    opd_discount_opd_services_ledger ( $data, $sale_id, $service_info, $patient -> panel_id );
//
//                foreach ( $service_id as $key => $value ) {
//                    if ( $value > 0 and !empty( $value ) ) {
//                        $info = array (
//                            'user_id'      => get_logged_in_user_id (),
//                            'patient_id'   => $data[ 'patient_id' ],
//                            'sale_id'      => $sale_id,
//                            'service_id'   => $value,
//                            'doctor_id'    => $doctor_id[ $key ],
//                            'price'        => $data[ 'price' ][ $key ],
//                            'discount'     => 0,
//                            'net_price'    => $data[ 'price' ][ $key ],
//                            'doctor_share' => $data[ 'doctor_share' ][ $key ],
//                            'date_added'   => current_date_time (),
//                        );
//                        $this -> OPDModel -> add_opd_sale_service ( $info );
//
//                        if ( isset( $doctor_id[ $key ] ) and $doctor_id[ $key ] > 0 and $data[ 'doctor_share' ][ $key ] > 0 ) {
//                            $doc_share   = ( ( $data[ 'total' ] * $data[ 'doctor_share' ][ $key ] ) / 100 );
//                            $doc_head_id = get_doctor_linked_account_head_id ( $doctor_id[ $key ] );
//                            if ( $doc_head_id > 0 ) {
//                                opd_sales_DOCTOR_ledger ( $data, $sale_id, $service_info, $doc_head_id, $doc_share );
//                                opd_sales_COS_PROCEDURE_ledger ( $data, $sale_id, $service_info, $doc_head_id, $doc_share );
//                            }
//                            else {
//                                $this -> session -> set_flashdata ( 'error', 'Doctor (' . get_doctor ( $doctor_id[ $key ] ) -> name . ') account head is not linked' );
//                            }
//                        }
//
//                        $log = array (
//                            'user_id'      => get_logged_in_user_id (),
//                            'patient_id'   => $data[ 'patient_id' ],
//                            'sale_id'      => $sale_id,
//                            'action'       => 'opd_sale_services_added',
//                            'log'          => json_encode ( $info ),
//                            'after_update' => '',
//                            'date_added'   => current_date_time ()
//                        );
//                        $this -> load -> model ( 'LogModel' );
//                        $this -> LogModel -> create_log ( 'opd_sales_logs', $log );
//
//                    }
//                }
//                $this -> session -> set_flashdata ( 'response', 'Success! Service sold. <a href="' . base_url ( '/invoices/opd-service-invoice/' . $sale_id ) . '" target="_blank" style="font-weight: 800; font-size: 16px">Print</a>' );
//                return redirect ( base_url ( '/OPD/sale' ) );
//            }
//        }
        
        /**
         * -------------------------
         * refund service
         * -------------------------
         */
        
        public function refund () {
            
            $sale_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_opd_refund' )
                $this -> do_opd_refund ();
            
            $title = site_name . ' - Refund';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'service' ]          = $this -> OPDModel -> get_opd_sale ( $sale_id );
            $data[ 'actual_net_value' ] = $this -> OPDModel -> get_opd_total_sale_value ( $sale_id );
            $this -> load -> view ( '/opd/refund', $data );
            $this -> footer ();
            
        }
        
        public function do_opd_refund () {
            
            $sale_id                 = $this -> input -> post ( 'sale_id' );
            $amount_paid_to_customer = $this -> input -> post ( 'amount_paid_to_customer' );
            $description             = $this -> input -> post ( 'description' );
            $actual_net_value        = $this -> input -> post ( 'actual_net_value' );
            $service_info            = array ();
            
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $services = $this -> OPDModel -> get_sold_services ( $sale_id );
            $patient  = get_patient ( $services[ 0 ][ 'patient_id' ] );
            
            if ( $patient -> panel_id > 0 ) {
                $accHeadID = get_account_head_id_by_panel_id ( $patient -> panel_id );
                if ( empty( $accHeadID ) ) {
                    $this -> session -> set_flashdata ( 'error', 'No account head is linked against patient Panel ID.' );
                    return redirect ( base_url ( '/OPD/sale' ) );
                }
            }
            
            $this -> db -> trans_begin ();
            try {
                $date_added = date ( 'Y-m-d', strtotime ( $_POST[ 'date_added' ] ) ) . ' ' . date ( 'H:i:s' );
                $sale       = $maiSale = (array)$this -> OPDModel -> get_opd_sale ( $sale_id );
                $this -> OPDModel -> update_opd_sales ( array ( 'refund' => '1' ), $sale_id );
                array_shift ( $sale );
                
                $sale[ 'user_id' ]       = get_logged_in_user_id ();
                $sale[ 'net' ]           = -$amount_paid_to_customer;
                $sale[ 'refund' ]        = '1';
                $sale[ 'refund_reason' ] = $description;
                $sale[ 'date_added' ]    = $date_added;
                $new_sale_id             = $this -> OPDModel -> add_opd_sale ( $sale );
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $services[ 0 ][ 'patient_id' ],
                    'sale_id'      => $sale_id,
                    'action'       => 'opd_sale_refunded_total',
                    'log'          => json_encode ( $sale ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'opd_sales_logs', $log );
                
                $cashAccountHead = cash_from_opd_services;
                $opdSaleInfo     = $this -> OPDModel -> get_opd_sale ( $sale_id );
                if ( $opdSaleInfo -> payment_method == 'card' )
                    $cashAccountHead = CARD;
                else if ( $opdSaleInfo -> payment_method == 'bank' )
                    $cashAccountHead = $opdSaleInfo -> account_head_id;
                
                $ledger[ 'user_id' ]        = get_logged_in_user_id ();
                $ledger[ 'acc_head_id' ]    = $cashAccountHead;
                $ledger[ 'opd_service_id' ] = $sale_id;
                $ledger[ 'debit' ]          = $amount_paid_to_customer;
                $ledger[ 'credit' ]         = 0;
                $ledger[ 'description' ]    = $description;
                $ledger[ 'trans_date' ]     = date ( 'Y-m-d', strtotime ( $_POST[ 'date_added' ] ) );
                $ledger[ 'date_added' ]     = current_date_time ();
                if ( $patient -> panel_id > 0 ) {
                    $accHeadID = get_account_head_id_by_panel_id ( $patient -> panel_id );
                    if ( !empty( $accHeadID ) ) {
                        $accHeadID               = $accHeadID -> id;
                        $ledger[ 'acc_head_id' ] = $accHeadID;
                    }
                }
                $this -> AccountModel -> add_ledger ( $ledger );
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $services[ 0 ][ 'patient_id' ],
                    'sale_id'      => $sale_id,
                    'action'       => 'opd_sale_refunded_ledger',
                    'log'          => json_encode ( $ledger ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'opd_sales_logs', $log );
                
                $ledger[ 'acc_head_id' ] = sales_opd_services;
                if ( $patient -> panel_id > 0 ) {
                    $ledger[ 'acc_head_id' ] = sales_from_opd_services_panel;
                }
                
                $ledger[ 'debit' ]  = 0;
                $ledger[ 'credit' ] = $actual_net_value;
                $this -> AccountModel -> add_ledger ( $ledger );
                
                $data = array (
                    'discount'   => $actual_net_value - $amount_paid_to_customer,
                    'patient_id' => $patient -> id
                );
                if ( abs ( $sale[ 'discount' ] ) > 0 || abs ( $sale[ 'flat_discount' ] ) > 0 )
                    update_opd_discount_opd_services_ledger ( $data, $sale_id, $service_info, $patient -> panel_id );
                
                $sales = $this -> OPDModel -> get_sales ( $sale_id );
                if ( count ( $sales ) > 0 ) {
                    foreach ( $sales as $sale ) {
                        $title = get_service_by_id ( $sale -> service_id ) -> title;
                        array_push ( $service_info, $title );
                        $doctor_id = $sale -> doctor_id;
                        if ( $doctor_id > 0 ) {
                            $doc_head_id         = get_doctor_linked_account_head_id ( $doctor_id );
                            $doc_share           = $sale -> doctor_share;
                            $patient_id          = $sale -> patient_id;
                            $actual_doc_share    = ( ( $sale -> net_price * $doc_share ) / 100 );
                            $cos_procedure_value = $actual_net_value - $actual_doc_share;
                            
                            if ( $doc_head_id > 0 ) {
                                update_opd_sales_DOCTOR_ledger ( $patient_id, $sale_id, $doc_head_id, $actual_doc_share );
                                update_opd_sales_COS_PROCEDURE_ledger ( $patient_id, $sale_id, $doc_head_id, $actual_doc_share );
                            }
                        }
                    }
                }
                
                if ( count ( $services ) > 0 ) {
                    foreach ( $services as $service ) {
                        array_shift ( $service );
                        $service[ 'user_id' ]    = get_logged_in_user_id ();
                        $service[ 'sale_id' ]    = $new_sale_id;
                        $service[ 'price' ]      = -$service[ 'price' ];
                        $service[ 'net_price' ]  = -$service[ 'net_price' ];
                        $service[ 'date_added' ] = $date_added;
                        $this -> OPDModel -> add_opd_sale_service ( $service );
                        
                        $log = array (
                            'user_id'      => get_logged_in_user_id (),
                            'patient_id'   => $services[ 0 ][ 'patient_id' ],
                            'sale_id'      => $sale_id,
                            'action'       => 'opd_sale_refunded_services',
                            'log'          => json_encode ( $service ),
                            'after_update' => '',
                            'date_added'   => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'opd_sales_logs', $log );
                        
                    }
                }
                
                $this -> db -> trans_commit ();
                
                $this -> session -> set_flashdata ( 'response', 'Success! Service refunded. <a href="' . base_url ( '/invoices/opd-service-invoice/' . $sale_id ) . '" target="_blank" style="font-weight: 800; font-size: 16px">Print</a>' );
                return redirect ( base_url ( '/OPD/sales' ) );
            }
            catch ( Exception $e ) {
                $this -> db -> trans_rollback ();
                $this -> session -> set_flashdata ( 'error', $e -> getMessage () );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * refund service
         * -------------------------
         */

//        public function do_opd_refund () {
//
//            $sale_id                 = $this -> input -> post ( 'sale_id' );
//            $amount_paid_to_customer = $this -> input -> post ( 'amount_paid_to_customer' );
//            $description             = $this -> input -> post ( 'description' );
//            $actual_net_value        = $this -> input -> post ( 'actual_net_value' );
//            $service_info            = array ();
//
//            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
//                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
//
//            $services = $this -> OPDModel -> get_sold_services ( $sale_id );
//            $patient  = get_patient ( $services[ 0 ][ 'patient_id' ] );
//
//            if ( $patient -> panel_id > 0 ) {
//                $accHeadID = get_account_head_id_by_panel_id ( $patient -> panel_id );
//                if ( empty( $accHeadID ) ) {
//                    $this -> session -> set_flashdata ( 'error', 'No account head is linked against patient Panel ID.' );
//                    return redirect ( base_url ( '/OPD/sale' ) );
//                }
//            }
//
//            $date_added = date ( 'Y-m-d', strtotime ( $_POST[ 'date_added' ] ) ) . ' ' . date ( 'H:i:s' );
//            $sale       = $maiSale = (array)$this -> OPDModel -> get_opd_sale ( $sale_id );
//
//            $this -> OPDModel -> update_opd_sales ( array ( 'refund' => '1' ), $sale_id );
//            array_shift ( $sale );
//            $sale[ 'user_id' ]       = get_logged_in_user_id ();
//            $sale[ 'net' ]           = -$amount_paid_to_customer;
//            $sale[ 'refund' ]        = '1';
//            $sale[ 'refund_reason' ] = $description;
//            $sale[ 'date_added' ]    = $date_added;
//            $new_sale_id             = $this -> OPDModel -> add_opd_sale ( $sale );
//
//            $log = array (
//                'user_id'      => get_logged_in_user_id (),
//                'patient_id'   => $services[ 0 ][ 'patient_id' ],
//                'sale_id'      => $sale_id,
//                'action'       => 'opd_sale_refunded_total',
//                'log'          => json_encode ( $sale ),
//                'after_update' => '',
//                'date_added'   => current_date_time ()
//            );
//
//            $this -> load -> model ( 'LogModel' );
//            $this -> LogModel -> create_log ( 'opd_sales_logs', $log );
//
//            //		$where = array (
//            //			'acc_head_id'    => cash_from_opd_services,
//            //			'opd_service_id' => $sale_id,
//            //		);
//            //		$ledger = (array)$this -> AccountModel -> get_ledger ( $where );
//
//            $cashAccountHead = cash_from_opd_services;
//            $opdSaleInfo     = $this -> OPDModel -> get_opd_sale ( $sale_id );
//            if ( $opdSaleInfo -> payment_method == 'card' )
//                $cashAccountHead = CARD;
//            else if ( $opdSaleInfo -> payment_method == 'bank' )
//                $cashAccountHead = $opdSaleInfo -> account_head_id;
//
//            $ledger[ 'user_id' ]        = get_logged_in_user_id ();
//            $ledger[ 'acc_head_id' ]    = $cashAccountHead;
//            $ledger[ 'opd_service_id' ] = $new_sale_id;
//            $ledger[ 'debit' ]          = $amount_paid_to_customer;
//            $ledger[ 'credit' ]         = 0;
//            $ledger[ 'description' ]    = $description;
//            $ledger[ 'trans_date' ]     = date ( 'Y-m-d', strtotime ( $_POST[ 'date_added' ] ) );
//            $ledger[ 'date_added' ]     = $date_added;
//            if ( $patient -> panel_id > 0 ) {
//                $accHeadID = get_account_head_id_by_panel_id ( $patient -> panel_id );
//                if ( !empty( $accHeadID ) ) {
//                    $accHeadID               = $accHeadID -> id;
//                    $ledger[ 'acc_head_id' ] = $accHeadID;
//                }
//            }
//            $this -> AccountModel -> add_ledger ( $ledger );
//
//            $log = array (
//                'user_id'      => get_logged_in_user_id (),
//                'patient_id'   => $services[ 0 ][ 'patient_id' ],
//                'sale_id'      => $sale_id,
//                'action'       => 'opd_sale_refunded_ledger',
//                'log'          => json_encode ( $ledger ),
//                'after_update' => '',
//                'date_added'   => current_date_time ()
//            );
//            $this -> load -> model ( 'LogModel' );
//            $this -> LogModel -> create_log ( 'opd_sales_logs', $log );
//
//            $ledger[ 'acc_head_id' ] = sales_opd_services;
//            if ( $patient -> panel_id > 0 ) {
//                $ledger[ 'acc_head_id' ] = sales_from_opd_services_panel;
//            }
//
//            $ledger[ 'debit' ]  = 0;
//            $ledger[ 'credit' ] = $actual_net_value;
//            $this -> AccountModel -> add_ledger ( $ledger );
//
//            $sales = $this -> OPDModel -> get_sales ( $sale_id );
//            if ( count ( $sales ) > 0 ) {
//                foreach ( $sales as $sale ) {
//                    $title = get_service_by_id ( $sale -> service_id ) -> title;
//                    array_push ( $service_info, $title );
//                    $doctor_id = $sale -> doctor_id;
//                    if ( $doctor_id > 0 ) {
//                        $doc_head_id         = get_doctor_linked_account_head_id ( $doctor_id );
//                        $doc_share           = $sale -> doctor_share;
//                        $patient_id          = $sale -> patient_id;
//                        $actual_doc_share    = ( ( $sale -> net_price * $doc_share ) / 100 );
//                        $cos_procedure_value = $actual_net_value - $actual_doc_share;
//
//                        if ( $doc_head_id > 0 ) {
//                            update_opd_sales_DOCTOR_ledger ( $patient_id, $sale_id, $doc_head_id, $actual_doc_share );
//                            update_opd_sales_COS_PROCEDURE_ledger ( $patient_id, $sale_id, $doc_head_id, $actual_doc_share );
//                        }
//                    }
//                }
//            }
//
//
//            if ( count ( $services ) > 0 ) {
//                foreach ( $services as $service ) {
//                    array_shift ( $service );
//                    $service[ 'user_id' ]    = get_logged_in_user_id ();
//                    $service[ 'sale_id' ]    = $new_sale_id;
//                    $service[ 'price' ]      = -$service[ 'price' ];
//                    $service[ 'net_price' ]  = -$service[ 'net_price' ];
//                    $service[ 'date_added' ] = $date_added;
//                    $this -> OPDModel -> add_opd_sale_service ( $service );
//
//                    $log = array (
//                        'user_id'      => get_logged_in_user_id (),
//                        'patient_id'   => $services[ 0 ][ 'patient_id' ],
//                        'sale_id'      => $sale_id,
//                        'action'       => 'opd_sale_refunded_services',
//                        'log'          => json_encode ( $service ),
//                        'after_update' => '',
//                        'date_added'   => current_date_time ()
//                    );
//                    $this -> load -> model ( 'LogModel' );
//                    $this -> LogModel -> create_log ( 'opd_sales_logs', $log );
//
//                }
//            }
//
//            $data = array (
//                'discount'   => $actual_net_value - $amount_paid_to_customer,
//                'patient_id' => $patient -> id
//            );
//            if ( $maiSale[ 'discount' ] > 0 || $maiSale[ 'flat_discount' ] > 0 )
//                update_opd_discount_opd_services_ledger ( $data, $sale_id, $service_info, $patient -> panel_id );
//
//            $this -> session -> set_flashdata ( 'response', 'Success! Service refunded. <a href="' . base_url ( '/invoices/opd-service-invoice/' . $new_sale_id ) . '" target="_blank" style="font-weight: 800; font-size: 16px">Print</a>' );
//            return redirect ( base_url ( '/OPD/sales' ) );
//        }
        
        /**
         * -------------------------
         * sales service main page
         * -------------------------
         */
        
        public function sales () {
            $title = site_name . ' - Sales Invoices (Cash)';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'OPD/sales' );
            $total_row                      = $this -> OPDModel -> count_sales_by_sale_grouped ();
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
            
            $data[ 'services' ] = $this -> OPDModel -> get_all_services ();
            $data[ 'doctors' ]  = $this -> DoctorModel -> get_doctors ();
            $data[ 'sales' ]    = $this -> OPDModel -> get_sales_by_sale_grouped ( $config[ "per_page" ], $offset );
            $str_links          = $this -> pagination -> create_links ();
            $data[ "links" ]    = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/opd/sales', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * sales service main page
         * -------------------------
         */
        
        public function panel_sales () {
            $title = site_name . ' - Sales Invoices (Panel)';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'OPD/panel_sales' );
            $total_row                      = $this -> OPDModel -> count_panel_sales_by_sale_grouped ();
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
            
            $data[ 'services' ] = $this -> OPDModel -> get_all_services ();
            $data[ 'doctors' ]  = $this -> DoctorModel -> get_doctors ();
            $data[ 'sales' ]    = $this -> OPDModel -> get_panel_sales_by_sale_grouped ( $config[ "per_page" ], $offset );
            $str_links          = $this -> pagination -> create_links ();
            $data[ "links" ]    = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/opd/panel_sales', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * delete services sold
         * by service id
         * -------------------------
         */
        
        public function delete () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( !empty( $sale_id ) and $sale_id > 0 ) {
                
                $sale = $this -> OPDModel -> get_opd_sale ( $sale_id );
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => 0,
                    'sale_id'      => $sale_id,
                    'action'       => 'opd_sale_deleted',
                    'log'          => json_encode ( $sale ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'opd_sales_logs', $log );
                
                $this -> OPDModel -> delete_sale ( $sale_id );
                $this -> AccountModel -> delete_opd_consultancy_services ( $sale_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Service deleted.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * validate if doctor is linked
         * -------------------------
         */
        
        public function is_doctor_linked_with_account_head () {
            $doctor_id   = $this -> input -> post ( 'doctor_id', true );
            $doc_head_id = get_doctor_linked_account_head_id ( $doctor_id );
            if ( $doc_head_id < 1 or empty( $doc_head_id ) )
                echo 'false';
            else
                echo 'true';
        }
        
        public function add_opd_service_for_sale () {
            $patient_id = $this -> input -> get ( 'patient_id', true );
            $service_id = $this -> input -> get ( 'service_id', true );
            $row        = $this -> input -> get ( 'row', true );
            
            if ( is_numeric ( $patient_id ) && $patient_id > 0 && !empty( $service_id ) and $service_id > 0 ) {
                $price   = $this -> OPDModel -> get_service_price_by_id ( $service_id );
                $service = $this -> OPDModel -> get_service_by_id ( $service_id );
                
                $patient = get_patient ( $patient_id );
                if ( $patient -> panel_id > 0 ) {
                    $discount = $this -> PanelModel -> get_opd_panel_service_discount ( $service_id, $patient -> panel_id );
                    if ( !empty( $discount ) ) {
                        $price = $discount -> price;
                    }
                }
                
                $info = array (
                    'charges'      => $price,
                    'service_type' => $service -> service_type,
                    'service'      => $service,
                    'row'          => $row,
                    'doctors'      => $this -> DoctorModel -> get_doctors ()
                );
                
                $this -> load -> view ( '/opd/add-opd-service', $info );
            }
        }
        
        public function load_sale_services_dropdown () {
            $patient_id = $this -> input -> get ( 'patient_id', true );
            $panel_id   = 0;
            
            if ( is_numeric ( $patient_id ) && $patient_id > 0 ) {
                
                $patient = get_patient ( $patient_id );
                if ( $patient -> panel_id > 0 ) {
                    $panel_id = $patient -> panel_id;
                }
                
                $services = $this -> OPDModel -> get_active_services ( $panel_id, true );
                $tree     = buildTree ( $services );
                $options  = '';
                $list     = '<option></option>';
                $list     .= buildList ( $tree, $options, 0, true );
                echo $list;
            }
        }
        
        public function do_sale_service () {
            $data         = $_POST;
            $service_id   = $this -> input -> post ( 'service_id' );
            $doctor_id    = $this -> input -> post ( 'doctor-id' );
            $patient_id   = $this -> input -> post ( 'patient_id' );
            $doctor_share = $this -> input -> post ( 'doctor-share' );
            $patient      = get_patient ( $patient_id );
            $service_info = array ();
            
            if ( $patient -> panel_id > 0 ) {
                $accHeadID = get_account_head_id_by_panel_id ( $patient -> panel_id );
                if ( empty( $accHeadID ) ) {
                    $this -> session -> set_flashdata ( 'error', 'No account head is linked against patient Panel ID.' );
                    return redirect ( base_url ( '/OPD/sale' ) );
                }
            }
            
            if ( isset( $doctor_id ) and $doctor_id > 0 ) {
                $doc_head_id = get_doctor_linked_account_head_id ( $doctor_id );
                if ( empty( $doc_head_id ) || $doc_head_id < 1 ) {
                    $this -> session -> set_flashdata ( 'error', 'Doctor (' . get_doctor ( $doctor_id ) -> name . ') account head is not linked' );
                }
            }
            
            if ( isset( $service_id ) and count ( $service_id ) > 0 ) {
                $sale    = array (
                    'user_id'         => get_logged_in_user_id (),
                    'doctor_id'       => $doctor_id,
                    'account_head_id' => $this -> input -> post ( 'bank-id' ),
                    'total'           => $this -> input -> post ( 'total_sum_opd_services' ),
                    'discount'        => $this -> input -> post ( 'sale_discount' ),
                    'flat_discount'   => $this -> input -> post ( 'flat_discount' ),
                    'net'             => $this -> input -> post ( 'total' ),
                    'payment_method'  => $this -> input -> post ( 'payment-method' ),
                    'transaction_no'  => $this -> input -> post ( 'transaction-no' ),
                    'doctor_share'    => $doctor_share,
                    'date_added'      => current_date_time (),
                );
                $sale_id = $this -> OPDModel -> add_opd_sale ( $sale );
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'patient_id'   => $patient_id,
                    'sale_id'      => $sale_id,
                    'action'       => 'opd_total_sale_added',
                    'log'          => json_encode ( $sale ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'opd_sales_logs', $log );
                
                foreach ( $service_id as $key => $value ) {
                    $title          = get_service_by_id ( $value ) -> title;
                    $service_info[] = $title;
                }
                
                opd_cash_from_opd_ledger ( $data, $sale_id, $service_info, $patient -> panel_id );
                opd_sales_opd_services_ledger ( $data, $sale_id, $service_info, $patient -> panel_id );
                
                if ( ( isset( $data[ 'sale_discount' ] ) and $data[ 'sale_discount' ] > 0 ) || ( isset( $data[ 'flat_discount' ] ) and $data[ 'flat_discount' ] > 0 ) )
                    opd_discount_opd_services_ledger ( $data, $sale_id, $service_info, $patient -> panel_id );
                
                foreach ( $service_id as $key => $value ) {
                    if ( $value > 0 and !empty( $value ) ) {
                        $info = array (
                            'user_id'      => get_logged_in_user_id (),
                            'patient_id'   => $patient_id,
                            'sale_id'      => $sale_id,
                            'service_id'   => $value,
                            'doctor_id'    => $doctor_id,
                            'price'        => $data[ 'price' ][ $key ],
                            'discount'     => 0,
                            'net_price'    => $data[ 'price' ][ $key ],
                            'doctor_share' => $doctor_share,
                            'date_added'   => current_date_time (),
                        );
                        $this -> OPDModel -> add_opd_sale_service ( $info );
                        
                        $log = array (
                            'user_id'      => get_logged_in_user_id (),
                            'patient_id'   => $data[ 'patient_id' ],
                            'sale_id'      => $sale_id,
                            'action'       => 'opd_sale_services_added',
                            'log'          => json_encode ( $info ),
                            'after_update' => '',
                            'date_added'   => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'opd_sales_logs', $log );
                    }
                }
                
                if ( isset( $doctor_id ) and $doctor_id > 0 ) {
                    $doc_share   = ( ( $this -> input -> post ( 'total_sum_opd_services' ) * $doctor_share ) / 100 );
                    $doc_head_id = get_doctor_linked_account_head_id ( $doctor_id );
                    if ( $doc_head_id > 0 ) {
                        opd_sales_DOCTOR_ledger ( $data, $sale_id, $service_info, $doc_head_id, $doc_share );
                        opd_sales_COS_PROCEDURE_ledger ( $data, $sale_id, $service_info, $doc_head_id, $doc_share );
                    }
                    else {
                        $this -> session -> set_flashdata ( 'error', 'Doctor (' . get_doctor ( $doctor_id ) -> name . ') account head is not linked' );
                    }
                }
                
                $this -> session -> set_flashdata ( 'response', 'Success! Service sold. <a href="' . base_url ( '/invoices/opd-service-invoice/' . $sale_id ) . '" target="_blank" style="font-weight: 800; font-size: 16px">Print</a>' );
                return redirect ( base_url ( '/OPD/sale' ) );
            }
        }
    }
