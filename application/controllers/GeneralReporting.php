<?php
    
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class GeneralReporting extends CI_Controller {
        
        /**
         * -------------------------
         * GeneralReporting constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'LabModel' );
            $this -> load -> model ( 'OPDModel' );
            $this -> load -> model ( 'IPDModel' );
            $this -> load -> model ( 'ConsultancyModel' );
            $this -> load -> model ( 'MedicineModel' );
            $this -> load -> model ( 'PanelModel' );
            $this -> load -> model ( 'AccountModel' );
            $this -> load -> model ( 'ReportingModel' );
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
         * General summary report
         * display summary report of
         * lab, opd, ipd
         * -------------------------
         */
        
        public function general_summary_report () {
            $title = site_name . ' - Summary Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'consultancy_total' ] = $this -> ConsultancyModel -> get_total_sale_by_date_range ();
            $data[ 'opd_total' ]         = $this -> OPDModel -> get_total_sale_by_date_range ();
            $data[ 'lab_total' ]         = $this -> LabModel -> get_total_sale_by_date_range ();
            $data[ 'med_total' ]         = $this -> MedicineModel -> get_total_sale_by_date_range ();
            $data[ 'ipd_total' ]         = $this -> IPDModel -> get_total_sale_by_date_range ();
            $data[ 'users' ]             = $this -> UserModel -> get_users ();
            $this -> load -> view ( '/general-report/summary-report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * General summary report
         * display closing report of
         * lab, opd, consultancy
         * -------------------------
         */
        
        public function daily_closing_report () {
            $title = site_name . ' - Daily Closing Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'consultancies' ] = $this -> ConsultancyModel -> get_consultancy_daily_closing_report ();
            $data[ 'opd_sales' ]     = $this -> OPDModel -> get_opd_sales_daily_closing_report ();
            $data[ 'lab_sales' ]     = $this -> LabModel -> get_lab_sales_daily_closing_report ();
            $data[ 'users' ]         = $this -> UserModel -> get_users ();
            $this -> load -> view ( '/general-report/daily-closing-report', $data );
            $this -> footer ();
        }
        
        public function general_summary_report_cash () {
            $title = site_name . ' - Summary Report (Cash)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'consultancies' ]          = $this -> ConsultancyModel -> get_consultancies_total ();
            $data[ 'consultancies_refunded' ] = $this -> ConsultancyModel -> get_consultancies_total ( true );
            $data[ 'opd' ]                    = $this -> OPDModel -> get_opd_total ();
            $data[ 'opd_refunded' ]           = $this -> OPDModel -> get_opd_total ( true );
            $data[ 'lab' ]                    = $this -> LabModel -> get_lab_total ();
            $data[ 'lab_refunded' ]           = $this -> LabModel -> get_lab_total ( true );
            $data[ 'pharmacy' ]               = $this -> MedicineModel -> get_pharmacy_total ();
            $data[ 'pharmacy_refunded' ]      = $this -> MedicineModel -> get_pharmacy_total ( true );
            $data[ 'ipd_total' ]              = $this -> IPDModel -> get_ipd_total_report ();
            $data[ 'users' ]                  = $this -> UserModel -> get_users ();
            $data[ 'panels' ]                 = $this -> PanelModel -> get_panels ();
            $this -> load -> view ( '/general-report/summary-report-cash', $data );
            $this -> footer ();
        }
        
        public function general_summary_report_cash_ii () {
            $title = site_name . ' - Summary Report (Cash II)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'cash_consultancies' ]     = $this -> ConsultancyModel -> get_consultancies_total_by_payment_method ( 'cash' );
            $data[ 'card_consultancies' ]     = $this -> ConsultancyModel -> get_consultancies_total_by_payment_method ( 'card' );
            $data[ 'bank_consultancies' ]     = $this -> ConsultancyModel -> get_consultancies_total_by_payment_method ( 'bank' );
            $data[ 'consultancies_refunded' ] = $this -> ConsultancyModel -> get_consultancies_refunded_total ();
            
            $data[ 'cash_opd' ]     = $this -> OPDModel -> get_opd_total_by_payment_method ( 'cash' );
            $data[ 'card_opd' ]     = $this -> OPDModel -> get_opd_total_by_payment_method ( 'card' );
            $data[ 'bank_opd' ]     = $this -> OPDModel -> get_opd_total_by_payment_method ( 'bank' );
            $data[ 'opd_refunded' ] = $this -> OPDModel -> get_opd_refunded_total ();
            
            $data[ 'cash_lab' ]     = $this -> LabModel -> get_lab_total_by_payment_method ( 'cash' );
            $data[ 'card_lab' ]     = $this -> LabModel -> get_lab_total_by_payment_method ( 'card' );
            $data[ 'bank_lab' ]     = $this -> LabModel -> get_lab_total_by_payment_method ( 'bank' );
            $data[ 'lab_refunded' ] = $this -> LabModel -> get_lab_refunded_total ();
            
            $data[ 'ipd_total' ]   = $this -> IPDModel -> get_ipd_total_report ();
            $data[ 'users' ]       = $this -> UserModel -> get_users ();
            $data[ 'panels' ]      = $this -> PanelModel -> get_panels ();
            $data[ 'consultants' ] = $this -> AccountModel -> get_consultants ( CONSULTANCY_SHARES_DOCTOR );
            $accounts1             = $this -> AccountModel -> get_account_heads_by_id ( GENERAL_ADMINISTRATIVE_EXPENSES );
            $accounts2             = get_general_and_administrative_expenses_data ( GENERAL_ADMINISTRATIVE_EXPENSES );
            $data[ 'accounts' ]    = array_merge ( $accounts1, $accounts2 );
            
            $data[ 'filter_doctors' ] = $this -> DoctorModel -> get_doctors_consultancy_summary_report ();
            $data[ 'sales' ]          = $this -> ReportingModel -> get_doctors_sales_by_sale_grouped ();
            $data[ 'reports' ]        = $this -> LabModel -> get_doctor_share_general_report ();
            $data[ 'ipd_sales' ]      = $this -> IPDModel -> get_consultant_commission ( true );
            $this -> load -> view ( '/general-report/summary-report-cash-ii', $data );
            $this -> footer ();
        }
        
    }
