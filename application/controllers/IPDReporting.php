<?php
    
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class IPDReporting extends CI_Controller {
        
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
            $this -> load -> model ( 'IPDModel' );
            $this -> load -> model ( 'PatientModel' );
            $this -> load -> model ( 'PanelModel' );
            $this -> load -> model ( 'DoctorModel' );
            $this -> load -> model ( 'RoomModel' );
            $this -> load -> model ( 'ReferenceModel' );
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
        
        public function general_report_cash () {
            $title = site_name . ' - IPD Reporting (Cash)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'discharged' ] = false;
            $data[ 'sales' ]      = $this -> IPDModel -> get_cash_sales_report ();
            $data[ 'patients' ]   = $this -> PatientModel -> get_patients ();
            $data[ 'references' ] = $this -> ReferenceModel -> get_references ();
            $data[ 'doctors' ]    = $this -> DoctorModel -> get_doctors ();
            $data[ 'services' ]   = $this -> IPDModel -> get_parent_services ();
            $this -> load -> view ( '/ipd-reports/general-report-cash.php', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * General summary report
         * display summary report of
         * lab, opd, ipd
         * -------------------------
         */
        
        public function general_report_panel () {
            $title = site_name . ' - IPD Reporting (Panel)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'discharged' ] = false;
            $data[ 'sales' ]      = $this -> IPDModel -> get_panel_sales_report ();
            $data[ 'patients' ]   = $this -> PatientModel -> get_patients ();
            $data[ 'panels' ]     = $this -> PanelModel -> get_panels ();
            $data[ 'references' ] = $this -> ReferenceModel -> get_references ();
            $data[ 'doctors' ]    = $this -> DoctorModel -> get_doctors ();
            $data[ 'services' ]   = $this -> IPDModel -> get_parent_services ();
            $this -> load -> view ( '/ipd-reports/general-report-panel.php', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Consultant commission report
         * -------------------------
         */
        
        public function consultant_commission () {
            $title = site_name . ' - Consultant Commission';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'discharged' ] = false;
            $data[ 'doctors' ]    = $this -> DoctorModel -> get_doctors ();
            $data[ 'panels' ]     = $this -> PanelModel -> get_panels ();
            $data[ 'services' ]   = $this -> IPDModel -> get_parent_services ();
            $data[ 'sales' ]      = $this -> IPDModel -> get_consultant_commission ();
            $this -> load -> view ( '/ipd-reports/consultant-commission', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * OT Timings report
         * -------------------------
         */
        
        public function ot_timings () {
            $title = site_name . ' - OT Timings';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'timings' ]  = $this -> IPDModel -> get_ot_timings_by_filter ();
            $data[ 'services' ] = $this -> IPDModel -> get_parent_services ();
            $data[ 'panels' ]   = $this -> PanelModel -> get_active_panels ();
            $this -> load -> view ( '/ipd-reports/ot-timings', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Bed status report
         * -------------------------
         */
        
        public function bed_reporting () {
            $title = site_name . ' - Bed Status Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'beds' ] = $this -> RoomModel -> get_beds ();
            $this -> load -> view ( '/ipd-reports/bed-reporting', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Bed status report
         * -------------------------
         */
        
        public function beds_status_report () {
            $title = site_name . ' - Beds Status Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'rooms' ]      = $this -> RoomModel -> get_beds_status_report ();
            $data[ 'rooms_list' ] = $this -> RoomModel -> get_rooms ();
            $this -> load -> view ( '/ipd-reports/beds-status-report', $data );
            $this -> footer ();
        }
        
        public function summary_report () {
            $title = site_name . ' - Summary Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'sales' ]   = $this -> IPDModel -> get_doctors_summary_report ();
            $data[ 'panels' ]  = $this -> PanelModel -> get_active_panels ( array ( 1 ) );
            $this -> load -> view ( '/ipd-reports/summary-report', $data );
            $this -> footer ();
        }
        
        public function receivable_report () {
            $title = site_name . ' - Receivable Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'sales' ] = $this -> IPDModel -> get_receivable_report ();
            $this -> load -> view ( '/ipd-reports/receivable-report', $data );
            $this -> footer ();
        }
        
        public function claim_status_report () {
            $title = site_name . ' - Claim Status Report (SSP)';
            $this -> header ( $title );
            $this -> sidebar ();
            $this -> load -> view ( '/ipd-reports/claim-status-report' );
            $this -> footer ();
        }
        
        public function claim_aging_report () {
            $title = site_name . ' - Claim Ageing Report (SSP)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'claims' ] = $this -> IPDModel -> claim_aging_report ();
            $this -> load -> view ( '/ipd-reports/claim-aging-report', $data );
            $this -> footer ();
        }
        
        public function cash_receiving_report () {
            $title = site_name . ' - Cash Receiving Report (Cash)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ]      = $title;
            $data[ 'discharged' ] = false;
            $data[ 'payments' ]   = $this -> IPDModel -> cash_receiving_report ();
            $this -> load -> view ( '/ipd-reports/cash-receiving-report', $data );
            $this -> footer ();
        }
        
        public function cash_receiving_panel () {
            $title = site_name . ' - Cash Receiving Report (Panel)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ]      = $title;
            $data[ 'discharged' ] = false;
            $data[ 'payments' ]   = $this -> IPDModel -> cash_receiving_report_panel ();
            $this -> load -> view ( '/ipd-reports/cash-receiving-report-panel', $data );
            $this -> footer ();
        }
        
    }
