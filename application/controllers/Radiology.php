<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Radiology extends CI_Controller {
        
        /**
         * -------------------------
         * Radiology constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'DoctorModel' );
            $this -> load -> model ( 'RadiologyModel' );
            $this -> load -> model ( 'TemplateModel' );
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
         * add xray report main page
         * -------------------------
         */
        
        public function add_xray_report () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_xray_report' )
                $this -> do_add_xray_report ( $_POST );
            
            $title = site_name . ' - Add X-Ray Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ]   = $this -> DoctorModel -> get_doctors ();
            $data[ 'templates' ] = $this -> TemplateModel -> get_xray_templates ();
            $this -> load -> view ( '/radiology/xray/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add xray report
         * -------------------------
         */
        
        public function do_add_xray_report ( $POST ) {
            $template   = $this -> TemplateModel -> get_xray_template_by_id ( $POST[ 'template-id' ] );
            $data       = $POST;
            $patient_id = $this -> input -> post ( 'patient-id', true );
            $sale_id    = $this -> input -> post ( 'sale-id', true );
            
            if ( !empty( trim ( $sale_id ) ) && $sale_id > 0 )
                $patient_id = get_patient_id_by_sale_id ( $sale_id );
            
            $info       = array (
                'user_id'      => get_logged_in_user_id (),
                'doctor_id'    => $data[ 'doctor_id' ],
                'doctor_stamp' => $data[ 'doctor_stamp' ],
                'patient_id'   => $patient_id,
                'sale_id'      => $sale_id,
                'order_by'     => $data[ 'order_by' ],
                'study'        => $data[ 'study' ],
                'report_title' => $template -> title,
                'conclusion'   => $data[ 'conclusion' ],
                'film'         => upload_files ( 'film' ),
                'date_added'   => current_date_time ()
            );
            $id         = $this -> RadiologyModel -> add_xray_report ( $info );
            
            $print = '<a href="' . base_url ( '/invoices/xray-report?report-id=' . $id ) . '" target="_blank">Print</a>';
            if ( $id > 0 ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Xray report added.' . $print );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
        }
        
        /**
         * -------------------------
         * xray reports main page
         * -------------------------
         */
        
        public function xray_reports () {
            $title = site_name . ' - X-Ray Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'radiology/x-ray/xray-reports' );
            $total_row                      = $this -> RadiologyModel -> count_xray_reports ();
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
            
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'reports' ] = $this -> RadiologyModel -> get_xray_reports ( $config[ "per_page" ], $offset );
            $str_links         = $this -> pagination -> create_links ();
            $data[ "links" ]   = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/radiology/xray/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * ultrasound reports main page
         * -------------------------
         */
        
        public function ultrasound_reports () {
            $title = site_name . ' - Ultrasound Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'radiology/ultrasound/ultrasound-reports' );
            $total_row                      = $this -> RadiologyModel -> count_ultrasound_reports ();
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
            
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'reports' ] = $this -> RadiologyModel -> get_ultrasound_reports ( $config[ "per_page" ], $offset );
            $str_links         = $this -> pagination -> create_links ();
            $data[ "links" ]   = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/radiology/ultrasound/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * delete xray report
         * by report id
         * -------------------------
         */
        
        public function delete_xray_report () {
            $report_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $report_id ) ) or !is_numeric ( $report_id ) or $report_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            $this -> RadiologyModel -> delete_xray_report ( $report_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Xray report deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * xray reports main page
         * -------------------------
         */
        
        public function search_xray_report () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_xray_report' )
                $this -> do_update_xray_report ( $_POST );
            
            $title = site_name . ' - Search X-Ray Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'report' ]  = $this -> RadiologyModel -> search_xray_report ();
            $this -> load -> view ( '/radiology/xray/search', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * xray reports main page
         * -------------------------
         */
        
        public function search_ultrasound_report () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_ultrasound_report' )
                $this -> do_edit_ultrasound_report ( $_POST );
            
            $title = site_name . ' - Search Ultrasound Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            if ( isset( $_REQUEST[ 'start_date' ] ) )
                $data[ 'report' ] = $this -> RadiologyModel -> search_ultrasound_report ();
            else
                $data[ 'report' ] = array ();
            $this -> load -> view ( '/radiology/ultrasound/search', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * update xray report
         * -------------------------
         */
        
        public function do_update_xray_report ( $POST ) {
            $data       = $POST;
            $report_id  = $data[ 'report_id' ];
            $patient_id = get_patient_id_by_sale_id ( $data[ 'sale-id' ] );
            $info       = array (
                'doctor_id'    => $data[ 'doctor_id' ],
                'doctor_stamp' => $data[ 'doctor_stamp' ],
                'order_by'     => $data[ 'order_by' ],
                'report_title' => $data[ 'report_title' ],
                'study'        => $data[ 'study' ],
            );
            
            if ( isset( $_FILES[ 'film' ] ) && !empty( trim ( $_FILES[ 'film' ][ 'tmp_name' ] ) ) )
                $info[ 'film' ] = upload_files ( 'film' );
            
            $updated = $this -> RadiologyModel -> update_xray_report ( $info, $report_id );
            delete_report_verify_status ( $report_id, 'hmis_xray' );
            if ( $updated ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Xray report updated.' );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * add ultrasound reports main page
         * -------------------------
         */
        
        public function add_ultrasound_report () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_ultrasound_report' )
                $this -> do_add_ultrasound_report ( $_POST );
            
            $title = site_name . ' - Add Ultrasound Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ]   = $this -> DoctorModel -> get_doctors ();
            $data[ 'templates' ] = $this -> TemplateModel -> get_templates ();
            $this -> load -> view ( '/radiology/ultrasound/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add ultra sound report
         * -------------------------
         */
        
        public function do_add_ultrasound_report ( $POST ) {
            $template   = $this -> TemplateModel -> get_template_by_id ( $POST[ 'template-id' ] );
            $patient_id = $this -> input -> post ( 'patient-id', true );
            $sale_id    = $this -> input -> post ( 'sale-id', true );
            
            if ( !empty( trim ( $sale_id ) ) && $sale_id > 0 )
                $patient_id = get_patient_id_by_sale_id ( $sale_id );
            
            $info       = array (
                'user_id'      => get_logged_in_user_id (),
                'doctor_id'    => $POST[ 'doctor_id' ],
                'sale_id'      => $POST[ 'sale-id' ],
                'patient_id'   => $patient_id,
                'order_by'     => $POST[ 'order_by' ],
                'study'        => $POST[ 'study' ],
                'report_title' => $template -> title,
                'conclusion'   => $POST[ 'conclusion' ],
                'film'         => upload_files ( 'film' ),
                'date_added'   => current_date_time ()
            );
            $id         = $this -> RadiologyModel -> add_ultrasound_report ( $info );
            
            $print = '<a href="' . base_url ( '/invoices/ultrasound-report?report-id=' . $id ) . '" target="_blank">Print</a>';
            if ( $id > 0 ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Ultrasound report added.' . $print );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
        }
        
        /**
         * -------------------------
         * add ultrasound reports main page
         * -------------------------
         */
        
        public function edit_ultrasound_report () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_ultrasound_report' )
                $this -> do_edit_ultrasound_report ( $_POST );
            
            $title = site_name . ' - Search Ultrasound Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'report' ]  = $this -> RadiologyModel -> search_ultrasound_report ();
            $this -> load -> view ( '/radiology/ultrasound/search', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit report of abdomen for female
         * -------------------------
         */
        
        public function do_edit_ultrasound_report ( $POST ) {
            $data       = $POST;
            $report_id  = $data[ 'report_id' ];
            $patient_id = get_patient_id_by_sale_id ( $data[ 'sale-id' ] );
            $info       = array (
                'doctor_id'    => $data[ 'doctor_id' ],
                'order_by'     => $data[ 'order_by' ],
                'report_title' => $data[ 'report_title' ],
                'study'        => $data[ 'study' ],
                'conclusion'   => $data[ 'conclusion' ]
            );
            
            if ( isset( $_FILES[ 'film' ] ) && !empty( trim ( $_FILES[ 'film' ][ 'tmp_name' ] ) ) )
                $info[ 'film' ] = upload_files ( 'film' );
            
            $updated = $this -> RadiologyModel -> update_ultrasound_report ( $info, $report_id );
            delete_report_verify_status ( $report_id, 'hmis_ultrasound' );
            if ( $updated ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Ultrasound report updated.' );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * delete ultrasound report
         * by report id
         * -------------------------
         */
        
        public function delete_ultrasound_report () {
            $report_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $report_id ) ) or !is_numeric ( $report_id ) or $report_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            $this -> RadiologyModel -> delete_ultrasound_report ( $report_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Ultrasound report deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * ct scan reports main page
         * -------------------------
         */
        
        public function ct_scan_reports () {
            $title = site_name . ' - CT-Scan Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'radiology/ct-scan/ct-scan-reports' );
            $total_row                      = $this -> RadiologyModel -> count_ct_scan_reports ();
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
            
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'reports' ] = $this -> RadiologyModel -> get_ct_scan_reports ( $config[ "per_page" ], $offset );
            $str_links         = $this -> pagination -> create_links ();
            $data[ "links" ]   = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/radiology/ct-scan/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add ct scan report main page
         * -------------------------
         */
        
        public function add_ct_scan_report () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_ct_scan_report' )
                $this -> do_add_ct_scan_report ( $_POST );
            
            $title = site_name . ' - Add CT-Scan Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ]   = $this -> DoctorModel -> get_doctors ();
            $data[ 'templates' ] = $this -> TemplateModel -> get_ct_scan_templates ();
            $this -> load -> view ( '/radiology/ct-scan/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add ct scan report
         * -------------------------
         */
        
        public function do_add_ct_scan_report ( $POST ) {
            $template   = $this -> TemplateModel -> get_ct_scan_template_by_id ( $POST[ 'template-id' ] );
            $data       = $POST;
            $patient_id = get_patient_id_by_sale_id ( $data[ 'sale-id' ] );
            $info       = array (
                'user_id'      => get_logged_in_user_id (),
                'doctor_id'    => $data[ 'doctor_id' ],
                'doctor_stamp' => $data[ 'doctor_stamp' ],
                'patient_id'   => $patient_id,
                'sale_id'      => $data[ 'sale-id' ],
                'order_by'     => $data[ 'order_by' ],
                'study'        => $data[ 'study' ],
                'report_title' => $template -> title,
                'film'         => upload_files ( 'film' ),
                'date_added'   => current_date_time ()
            );
            $id         = $this -> RadiologyModel -> add_ct_scan_report ( $info );
            
            $print = '<a href="' . base_url ( '/invoices/ct-scan-report?report-id=' . $id ) . '" target="_blank">Print</a>';
            if ( $id > 0 ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Report added.' . $print );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
        }
        
        /**
         * -------------------------
         * xray reports main page
         * -------------------------
         */
        
        public function search_ct_scan_report () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_ct_scan_report' )
                $this -> do_update_ct_scan_report ( $_POST );
            
            $title = site_name . ' - Search CT-Scan Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'report' ]  = $this -> RadiologyModel -> search_ct_scan_report ();
            $this -> load -> view ( '/radiology/ct-scan/search', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * update ct scan report
         * -------------------------
         */
        
        public function do_update_ct_scan_report ( $POST ) {
            $data       = $POST;
            $report_id  = $data[ 'report_id' ];
            $patient_id = get_patient_id_by_sale_id ( $data[ 'sale-id' ] );
            $info       = array (
                'doctor_id'    => $data[ 'doctor_id' ],
                'doctor_stamp' => $data[ 'doctor_stamp' ],
                'sale_id'      => $data[ 'sale-id' ],
                'patient_id'   => $patient_id,
                'order_by'     => $data[ 'order_by' ],
                'report_title' => $data[ 'report_title' ],
                'study'        => $data[ 'study' ],
            );
            
            if ( isset( $_FILES[ 'film' ] ) && !empty( trim ( $_FILES[ 'film' ][ 'tmp_name' ] ) ) )
                $info[ 'film' ] = upload_files ( 'film' );
            
            $updated = $this -> RadiologyModel -> update_ct_scan_report ( $info, $report_id );
            delete_report_verify_status ( $report_id, 'hmis_ct_scan' );
            if ( $updated ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Report updated.' );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * delete ct scan report
         * by report id
         * -------------------------
         */
        
        public function delete_ct_scan_report () {
            $report_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $report_id ) ) or !is_numeric ( $report_id ) or $report_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> RadiologyModel -> delete_ct_scan_report ( $report_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Report deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * mri reports main page
         * -------------------------
         */
        
        public function mri_reports () {
            $title = site_name . ' - MRI Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'radiology/mri/ct-scan-reports' );
            $total_row                      = $this -> RadiologyModel -> count_mri_reports ();
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
            
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'reports' ] = $this -> RadiologyModel -> get_mri_reports ( $config[ "per_page" ], $offset );
            $str_links         = $this -> pagination -> create_links ();
            $data[ "links" ]   = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/radiology/mri/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add mri report main page
         * -------------------------
         */
        
        public function add_mri_report () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_mri_report' )
                $this -> do_add_mri_report ( $_POST );
            
            $title = site_name . ' - Add MRI Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ]   = $this -> DoctorModel -> get_doctors ();
            $data[ 'templates' ] = $this -> TemplateModel -> get_mri_templates ();
            $this -> load -> view ( '/radiology/mri/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add mri report
         * -------------------------
         */
        
        public function do_add_mri_report ( $POST ) {
            $template   = $this -> TemplateModel -> get_mri_template_by_id ( $POST[ 'template-id' ] );
            $data       = $POST;
            $patient_id = get_patient_id_by_sale_id ( $data[ 'sale-id' ] );
            $info       = array (
                'user_id'      => get_logged_in_user_id (),
                'doctor_id'    => $data[ 'doctor_id' ],
                'doctor_stamp' => $data[ 'doctor_stamp' ],
                'sale_id'      => $data[ 'sale-id' ],
                'patient_id'   => $patient_id,
                'order_by'     => $data[ 'order_by' ],
                'study'        => $data[ 'study' ],
                'report_title' => $template -> title,
                'film'         => upload_files ( 'film' ),
                'date_added'   => current_date_time ()
            );
            $id         = $this -> RadiologyModel -> add_mri_report ( $info );
            
            $print = '<a href="' . base_url ( '/invoices/mri-report?report-id=' . $id ) . '" target="_blank">Print</a>';
            if ( $id > 0 ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Report added.' . $print );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
        }
        
        /**
         * -------------------------
         * xray reports main page
         * -------------------------
         */
        
        public function search_mri_report () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_mri_report' )
                $this -> do_update_mri_report ( $_POST );
            
            $title = site_name . ' - Search MRI Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'report' ]  = $this -> RadiologyModel -> search_mri_report ();
            $this -> load -> view ( '/radiology/mri/search', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * update mri report
         * -------------------------
         */
        
        public function do_update_mri_report ( $POST ) {
            $data       = $POST;
            $report_id  = $data[ 'report_id' ];
            $patient_id = get_patient_id_by_sale_id ( $data[ 'sale-id' ] );
            $info       = array (
                'doctor_id'    => $data[ 'doctor_id' ],
                'doctor_stamp' => $data[ 'doctor_stamp' ],
                'sale_id'      => $data[ 'sale-id' ],
                'patient_id'   => $patient_id,
                'order_by'     => $data[ 'order_by' ],
                'report_title' => $data[ 'report_title' ],
                'study'        => $data[ 'study' ],
            );
            
            if ( isset( $_FILES[ 'film' ] ) && !empty( trim ( $_FILES[ 'film' ][ 'tmp_name' ] ) ) )
                $info[ 'film' ] = upload_files ( 'film' );
            
            $updated = $this -> RadiologyModel -> update_mri_report ( $info, $report_id );
            delete_report_verify_status ( $report_id, 'hmis_mri' );
            if ( $updated ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Report updated.' );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * delete mri report
         * by report id
         * -------------------------
         */
        
        public function delete_mri_report () {
            $report_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $report_id ) ) or !is_numeric ( $report_id ) or $report_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> RadiologyModel -> delete_mri_report ( $report_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Report deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        public function verify_xray_report () {
            $report_id = $this -> input -> get ( 'report-id' );
            if ( empty( trim ( $report_id ) ) or !is_numeric ( $report_id ) or $report_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> RadiologyModel -> verify_report ( $report_id, 'hmis_xray' );
            $this -> session -> set_flashdata ( 'response', 'Success! Report verified.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        public function verify_ultrasound_report () {
            $report_id = $this -> input -> get ( 'report-id' );
            if ( empty( trim ( $report_id ) ) or !is_numeric ( $report_id ) or $report_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> RadiologyModel -> verify_report ( $report_id, 'hmis_ultrasound' );
            $this -> session -> set_flashdata ( 'response', 'Success! Report verified.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        public function verify_ct_scan_report () {
            $report_id = $this -> input -> get ( 'report-id' );
            if ( empty( trim ( $report_id ) ) or !is_numeric ( $report_id ) or $report_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> RadiologyModel -> verify_report ( $report_id, 'hmis_ct_scan' );
            $this -> session -> set_flashdata ( 'response', 'Success! Report verified.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        public function verify_mri_report () {
            $report_id = $this -> input -> get ( 'report-id' );
            if ( empty( trim ( $report_id ) ) or !is_numeric ( $report_id ) or $report_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> RadiologyModel -> verify_report ( $report_id, 'hmis_mri' );
            $this -> session -> set_flashdata ( 'response', 'Success! Report verified.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * echo reports main page
         * -------------------------
         */
        
        public function echo_reports () {
            $title = site_name . ' - ECHO Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit = 10;
            $config = array ();
            $config[ "base_url" ] = base_url ( 'radiology/echo/echo-reports' );
            $total_row = $this -> RadiologyModel -> count_echo_reports ();
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
            
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'reports' ] = $this -> RadiologyModel -> get_echo_reports ( $config[ "per_page" ], $offset );
            $str_links = $this -> pagination -> create_links ();
            $data[ "links" ] = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/radiology/echo/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add echo reports main page
         * -------------------------
         */
        
        public function add_echo_report () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_echo_report' )
                $this -> do_add_echo_report ( $_POST );
            
            $title = site_name . ' - Add ECHO Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'templates' ] = $this -> TemplateModel -> get_echo_templates ();
            $this -> load -> view ( '/radiology/echo/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add echo report
         * -------------------------
         */
        
        public function do_add_echo_report ( $POST ) {
            $template = $this -> TemplateModel -> get_echo_template_by_id ( $POST[ 'template-id' ] );
            $info = array (
                'user_id'      => get_logged_in_user_id (),
                'doctor_id'    => $POST[ 'doctor_id' ],
                'patient_id'   => $POST[ 'patient_id' ],
                'order_by'     => $POST[ 'order_by' ],
                'study'        => $POST[ 'study' ],
                'report_title' => $template -> title,
                'conclusion'   => $POST[ 'conclusion' ],
                'date_added'   => current_date_time ()
            );
            $id = $this -> RadiologyModel -> add_echo_report ( $info );
            if ( $id > 0 ) {
                $this -> session -> set_flashdata ( 'response', 'Success! ECHO report added.' );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
            return redirect ( '/invoices/echo-report?report-id=' . $id );
        }
        
        /**
         * -------------------------
         * echo reports main page
         * -------------------------
         */
        
        public function search_echo_report () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_echo_report' )
                $this -> do_edit_echo_report ( $_POST );
            
            $title = site_name . ' - Search ECHO Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'report' ] = $this -> RadiologyModel -> search_echo_report ();
            
            $this -> load -> view ( '/radiology/echo/search', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add echo reports main page
         * -------------------------
         */
        
        public function edit_echo_report () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_echo_report' )
                $this -> do_edit_echo_report ( $_POST );
            
            $title = site_name . ' - Search ECHO Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'report' ] = $this -> RadiologyModel -> search_echo_report ();
            $this -> load -> view ( '/radiology/echo/search', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit echo
         * -------------------------
         */
        
        public function do_edit_echo_report ( $POST ) {
            $data = $POST;
            $report_id = $data[ 'report_id' ];
            $info = array (
                'doctor_id'    => $data[ 'doctor_id' ],
                'patient_id'   => $data[ 'patient_id' ],
                'order_by'     => $data[ 'order_by' ],
                'report_title' => $data[ 'report_title' ],
                'study'        => $data[ 'study' ],
                'conclusion'   => $data[ 'conclusion' ]
            );
            $updated = $this -> RadiologyModel -> update_echo_report ( $info, $report_id );
            if ( $updated ) {
                $this -> session -> set_flashdata ( 'response', 'Success! ECHO report updated.' );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * delete echo report
         * by report id
         * -------------------------
         */
        
        public function delete_echo_report () {
            $report_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $report_id ) ) or !is_numeric ( $report_id ) or $report_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            $this -> RadiologyModel -> delete_echo_report ( $report_id );
            $this -> session -> set_flashdata ( 'response', 'Success! ECHO report deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * ecg reports main page
         * -------------------------
         */
        
        public function ecg_reports () {
            $title = site_name . ' - ECG Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit = 10;
            $config = array ();
            $config[ "base_url" ] = base_url ( 'radiology/ecg/ecg-reports' );
            $total_row = $this -> RadiologyModel -> count_ecg_reports ();
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
            
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'reports' ] = $this -> RadiologyModel -> get_ecg_reports ( $config[ "per_page" ], $offset );
            $str_links = $this -> pagination -> create_links ();
            $data[ "links" ] = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/radiology/ecg/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add ecg reports main page
         * -------------------------
         */
        
        public function add_ecg_report () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_ecg_report' )
                $this -> do_add_ecg_report ( $_POST );
            
            $title = site_name . ' - Add ECG Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'templates' ] = $this -> TemplateModel -> get_ecg_templates ();
            $this -> load -> view ( '/radiology/ecg/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add ecg report
         * -------------------------
         */
        
        public function do_add_ecg_report ( $POST ) {
            $template = $this -> TemplateModel -> get_ecg_template_by_id ( $POST[ 'template-id' ] );
            $info = array (
                'user_id'      => get_logged_in_user_id (),
                'doctor_id'    => $POST[ 'doctor_id' ],
                'patient_id'   => $POST[ 'patient_id' ],
                'order_by'     => $POST[ 'order_by' ],
                'study'        => $POST[ 'study' ],
                'report_title' => $template -> title,
                'conclusion'   => $POST[ 'conclusion' ],
                'date_added'   => current_date_time ()
            );
            $id = $this -> RadiologyModel -> add_ecg_report ( $info );
            if ( $id > 0 ) {
                $this -> session -> set_flashdata ( 'response', 'Success! ECG report added.' );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
            return redirect ( '/invoices/ecg-report?report-id=' . $id );
        }
        
        /**
         * -------------------------
         * ecg reports main page
         * -------------------------
         */
        
        public function search_ecg_report () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_ecg_report' )
                $this -> do_edit_ecg_report ( $_POST );
            
            $title = site_name . ' - Search ECG Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'report' ] = $this -> RadiologyModel -> search_ecg_report ();
            
            $this -> load -> view ( '/radiology/ecg/search', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add ecg reports main page
         * -------------------------
         */
        
        public function edit_ecg_report () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_ecg_report' )
                $this -> do_edit_ecg_report ( $_POST );
            
            $title = site_name . ' - Search ECG Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'report' ] = $this -> RadiologyModel -> search_ecg_report ();
            $this -> load -> view ( '/radiology/ecg/search', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit ecg
         * -------------------------
         */
        
        public function do_edit_ecg_report ( $POST ) {
            $data = $POST;
            $report_id = $data[ 'report_id' ];
            $info = array (
                'doctor_id'    => $data[ 'doctor_id' ],
                'patient_id'   => $data[ 'patient_id' ],
                'order_by'     => $data[ 'order_by' ],
                'report_title' => $data[ 'report_title' ],
                'study'        => $data[ 'study' ],
                'conclusion'   => $data[ 'conclusion' ]
            );
            $updated = $this -> RadiologyModel -> update_ecg_report ( $info, $report_id );
            if ( $updated ) {
                $this -> session -> set_flashdata ( 'response', 'Success! ECG report updated.' );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * delete ecg report
         * by report id
         * -------------------------
         */
        
        public function delete_ecg_report () {
            $report_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $report_id ) ) or !is_numeric ( $report_id ) or $report_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            $this -> RadiologyModel -> delete_ecg_report ( $report_id );
            $this -> session -> set_flashdata ( 'response', 'Success! ECG report deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
    }
