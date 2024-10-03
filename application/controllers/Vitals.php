<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Vitals extends CI_Controller {
        
        /**
         * -------------------------
         * Vitals constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'VitalModel' );
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
         * Patients main page
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - Patient Vitals';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit = 10;
            $config = array ();
            $config[ "base_url" ] = base_url ( 'vitals/index' );
            $total_row = $this -> VitalModel -> count_vitals_grouped ();
            
            $config[ "total_rows" ] = $total_row;
            $config[ "per_page" ] = $limit;
            $config[ 'use_page_numbers' ] = false;
            $config[ 'page_query_string' ] = TRUE;
            $config[ 'reuse_query_string' ] = TRUE;
            $config[ 'num_links' ] = 10;
            $config[ 'cur_tag_open' ] = '&nbsp;<a class="current">';
            $config[ 'cur_tag_close' ] = '</a>';
            $config[ 'next_link' ] = 'Next';
            $config[ 'prev_link' ] = 'Previous';
            
            $this -> pagination -> initialize ( $config );
            
            /**********END PAGINATION***********/
            
            if ( isset( $_REQUEST[ 'per_page' ] ) and $_REQUEST[ 'per_page' ] > 0 ) {
                $offset = $_REQUEST[ 'per_page' ];
            }
            else {
                $offset = 0;
            }
            
            $data[ 'vitals' ] = $this -> VitalModel -> get_patient_vitals_grouped ( $config[ "per_page" ], $offset );
            $str_links = $this -> pagination -> create_links ();
            $data[ "links" ] = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/vitals/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * patients add main page
         * -------------------------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_patient_vitals' )
                $this -> do_add_patient_vitals ( $_POST );
            
            $title = site_name . ' - Add Patient Vitals';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/vitals/add' );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add patient vitals
         * -------------------------
         */
        
        public function do_add_patient_vitals ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $patient_id = $data[ 'patient_id' ];
            $vital_key = $data[ 'vital_key' ];
            $vital_value = $data[ 'vital_value' ];
            $vital_id = uniqid ( db_prefix, true );
            if ( !empty( trim ( $patient_id ) ) and is_numeric ( $patient_id ) and count ( $vital_key ) > 0 ) {
                foreach ( $vital_key as $key => $value ) {
                    if ( !empty( trim ( $value ) ) ) {
                        $info = array (
                            'user_id'     => get_logged_in_user_id (),
                            'patient_id'  => $patient_id,
                            'vital_id'    => $vital_id,
                            'vital_key'   => $value,
                            'vital_value' => $vital_value[ $key ],
                            'date_added'  => current_date_time (),
                        );
                        $this -> VitalModel -> add ( $info );
                        
                        $log = array (
                            'user_id'      => get_logged_in_user_id (),
                            'patient_id'   => $patient_id,
                            'vital_id'     => $vital_id,
                            'action'       => 'vitals_added',
                            'log'          => json_encode ( $info ),
                            'after_update' => '',
                            'date_added'   => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'vital_logs', $log );
                        
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Patient vitals added.' );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please enter patient EMR number and add values.' );
            }
            return redirect ( base_url ( '/vitals/add' ) );
        }
        
        /**
         * -------------------------
         * patient edit main page
         * -------------------------
         */
        
        public function edit () {
            
            $vital_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $vital_id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_patient_vitals' )
                $this -> do_edit_patient_vitals ( $_POST );
            
            $title = site_name . ' - Edit Patient Vitals';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'vitals' ] = $this -> VitalModel -> get_patient_vitals_by_vital_id ( $vital_id );
            $this -> load -> view ( '/vitals/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit patient vitals
         * -------------------------
         */
        
        public function do_edit_patient_vitals ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $vital_id = $data[ 'vital_id' ];
            $patient_id = $data[ 'patient_id' ];
            $vital_key = $data[ 'vital_key' ];
            $vital_value = $data[ 'vital_value' ];
            if ( !empty( trim ( $patient_id ) ) and is_numeric ( $patient_id ) and count ( $vital_key ) > 0 ) {
                $this -> VitalModel -> delete ( $vital_id );
                foreach ( $vital_key as $key => $value ) {
                    if ( !empty( trim ( $value ) ) ) {
                        $info = array (
                            'user_id'     => get_logged_in_user_id (),
                            'patient_id'  => $patient_id,
                            'vital_id'    => $vital_id,
                            'vital_key'   => $value,
                            'vital_value' => $vital_value[ $key ],
                            'date_added'  => current_date_time (),
                        );
                        $this -> VitalModel -> add ( $info );
                        $log = array (
                            'user_id'      => get_logged_in_user_id (),
                            'patient_id'   => $patient_id,
                            'vital_id'     => $vital_id,
                            'action'       => 'vitals_updated',
                            'log'          => json_encode ( $info ),
                            'after_update' => '',
                            'date_added'   => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'vital_logs', $log );
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Patient vitals updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please enter patient EMR number and add values.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * update status of supplier to inactive
         * records are not being deleted permanently
         * -------------------------
         */
        
        public function delete () {
            $vital_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $vital_id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'patient_id'   => $this -> VitalModel -> get_patient_vitals_by_vital_id ( $vital_id )[ 0 ] -> patient_id,
                'vital_id'     => $vital_id,
                'action'       => 'vitals_deleted',
                'log'          => json_encode ( $this -> VitalModel -> get_patient_vitals_by_vital_id ( $vital_id ) ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'vital_logs', $log );
            
            $this -> VitalModel -> delete ( $vital_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Vitals deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * fetch vitals
         * -------------------------
         */
        
        public function fetch_vitals () {
            $patient_id = $this -> input -> post ( 'patient_id' );
            if ( $patient_id > 0 ) {
                $date = date ( 'Y-m-d' );
                $vitals = $this -> VitalModel -> fetch_vitals ( $patient_id, $date );
                if ( $vitals )
                    echo 'Vitals added on ' . $date;
                else
                    echo 'No vitals added';
            }
        }
        
    }
