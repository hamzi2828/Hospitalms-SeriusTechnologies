<?php
    error_reporting ( E_ERROR );
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Reporting extends CI_Controller {
        
        /**
         * -------------------------
         * Reporting constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'MedicineModel' );
            $this -> load -> model ( 'AccountModel' );
            $this -> load -> model ( 'SupplierModel' );
            $this -> load -> model ( 'AccountModel' );
            $this -> load -> model ( 'StockReturnModel' );
            $this -> load -> model ( 'ReportingModel' );
            $this -> load -> model ( 'LabModel' );
            $this -> load -> model ( 'MemberModel' );
            $this -> load -> model ( 'PanelModel' );
            $this -> load -> model ( 'IPDModel' );
            $this -> load -> model ( 'AirlineModel' );
            $this -> load -> model ( 'LocationModel' );
            $this -> load -> model ( 'ReferenceModel' );
            $this -> load -> model ( 'SectionModel' );
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
         * General report
         * display sale report
         * -------------------------
         */
        
        public function general_report () {
            $title = site_name . ' - General Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ]     = $this -> MedicineModel -> get_medicines ();
            $data[ 'generics' ]      = $this -> MedicineModel -> get_generics ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            if ( isset( $_REQUEST[ 'start_date' ] ) or isset( $_REQUEST[ 'end_date' ] ) or isset( $_REQUEST[ 'acc_head_id' ] ) or isset( $_REQUEST[ 'sale_from' ] ) or isset( $_REQUEST[ 'sale_to' ] ) or isset( $_REQUEST[ 'medicine_id' ] ) or isset( $_REQUEST[ 'user_id' ] ) ) {
                $data[ 'reports' ] = $this -> ReportingModel -> get_sale_reports ();
            }
            else {
                $data[ 'reports' ] = array ();
            }
            
            $user = get_user ( get_logged_in_user_id () );
            if ( $user -> department_id == ADMINISTRATION_DEPT )
                $data[ 'users' ] = $this -> UserModel -> get_users_by_department ( pharmacy_dept );
            else
                $data[ 'users' ] = array ();
            
            $data[ 'user' ] = get_logged_in_user ();
            
            $this -> load -> view ( '/reporting/general-report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * General report
         * display sale report
         * -------------------------
         */
        
        public function sale_report_against_supplier () {
            $title = site_name . ' - Sale Report Against Supplier';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'suppliers' ] = $this -> AccountModel -> get_child_account_heads ( supplier_id );
            if ( isset( $_REQUEST[ 'start_date' ] ) or isset( $_REQUEST[ 'end_date' ] ) or isset( $_REQUEST[ 'acc_head_id' ] ) ) {
                $stocks = $this -> ReportingModel -> get_supplier_stocks ();
                if ( empty( trim ( $stocks ) ) )
                    $stocks = 0;
                $data[ 'reports' ] = $this -> ReportingModel -> get_sale_report_by_supplier_stock ( $stocks );
            }
            else {
                $data[ 'reports' ] = array ();
            }
            
            $this -> load -> view ( '/reporting/sale_report_against_supplier', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * General report ipd medication
         * display sale report
         * -------------------------
         */
        
        public function general_report_ipd_medication () {
            $title = site_name . ' - General Report IPD Medication';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ]     = $this -> MedicineModel -> get_medicines ();
            $data[ 'generics' ]      = $this -> MedicineModel -> get_generics ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'users' ]         = $this -> UserModel -> get_users_by_department ( pharmacy_dept );
            if ( isset( $_REQUEST[ 'start_date' ] ) or isset( $_REQUEST[ 'end_date' ] ) or isset( $_REQUEST[ 'acc_head_id' ] ) or isset( $_REQUEST[ 'sale_from' ] ) or isset( $_REQUEST[ 'sale_to' ] ) or isset( $_REQUEST[ 'medicine_id' ] ) or isset( $_REQUEST[ 'user_id' ] ) ) {
                $data[ 'reports' ] = $this -> ReportingModel -> get_sale_reports_ipd_medication ();
            }
            else {
                $data[ 'reports' ] = array ();
            }
            
            $data[ 'panels' ] = $this -> PanelModel -> get_panels ();
            $this -> load -> view ( '/reporting/general-report-ipd-medication', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Profit report
         * display Profit report
         * -------------------------
         */
        
        public function profit_report () {
            $title = site_name . ' - Profit Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ]     = $this -> MedicineModel -> get_medicines ();
            $data[ 'generics' ]      = $this -> MedicineModel -> get_generics ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            if ( isset( $_REQUEST[ 'start_date' ] ) or isset( $_REQUEST[ 'end_date' ] ) or isset( $_REQUEST[ 'acc_head_id' ] ) or isset( $_REQUEST[ 'sale_from' ] ) or isset( $_REQUEST[ 'sale_to' ] ) or isset( $_REQUEST[ 'medicine_id' ] ) ) {
                $data[ 'reports' ] = $this -> ReportingModel -> get_profit_reports ();
                $data[ 'returns' ] = $this -> ReportingModel -> get_customer_return_profit_reports ();
            }
            else {
                $data[ 'reports' ] = array ();
                $data[ 'returns' ] = array ();
            }
            $this -> load -> view ( '/reporting/profit-report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Stock valuation report
         * display stock valuation report
         * -------------------------
         */
        
        public function stock_valuation_report () {
            $title = site_name . ' - Stock valuation Report (TP Wise)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ] = $this -> MedicineModel -> filter_medicines_stock_valuation ();
            $data[ 'forms' ]     = $this -> MedicineModel -> get_forms ();
            $data[ 'generics' ]  = $this -> MedicineModel -> get_generics ();
            $data[ 'strengths' ] = $this -> MedicineModel -> get_strengths ();
            $this -> load -> view ( '/reporting/stock-valuation-report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Stock valuation report
         * display stock valuation report
         * -------------------------
         */
        
        public function stock_valuation_report_sale_price () {
            $title = site_name . ' - Stock valuation Report (Sale Price Wie)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ] = $this -> MedicineModel -> filter_medicines_stock_valuation ();
            $data[ 'forms' ]     = $this -> MedicineModel -> get_forms ();
            $data[ 'generics' ]  = $this -> MedicineModel -> get_generics ();
            $data[ 'strengths' ] = $this -> MedicineModel -> get_strengths ();
            $this -> load -> view ( '/reporting/stock-valuation-report-sale-price', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Threshold report
         * display Threshold report
         * -------------------------
         */
        
        public function threshold_report () {
            $title = site_name . ' - Threshold Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_all_medicines ( 100000000, 0 );
            $this -> load -> view ( '/reporting/threshold-report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Expired medicine report
         * display Expired medicine report
         * -------------------------
         */
        
        public function expired_medicine_report () {
            $title = site_name . ' - Threshold Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_all_medicines ( 100000000, 0 );
            $this -> load -> view ( '/reporting/expired-medicine-report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * lab general report
         * -------------------------
         */
        
        public function lab_general_reporting () {
            $title = site_name . ' - General Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'tests' ]      = $this -> LabModel -> get_tests ();
            $data[ 'panels' ]     = $this -> PanelModel -> get_active_panels ();
            $data[ 'doctors' ]    = $this -> DoctorModel -> get_doctors ();
            $data[ 'reports' ]    = $this -> LabModel -> get_general_report ();
            $data[ 'receivings' ] = $this -> LabModel -> get_lab_receiving_general_report ();
//            print_data ($this -> db -> last_query());
            $data[ 'references' ] = $this -> ReferenceModel -> get_references ();
            
            $user = get_user ( get_logged_in_user_id () );
            if ( $user -> department_id == ADMINISTRATION_DEPT )
                $data[ 'users' ] = $this -> UserModel -> get_active_users ();
            else
                $data[ 'users' ] = array ();
            
            $data[ 'user' ] = get_logged_in_user ();
            $this -> load -> view ( '/reporting/lab-general-report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * lab general report
         * -------------------------
         */
        
        public function lab_covid_report () {
            $title = site_name . ' - General Report (COVID)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'tests' ]    = $this -> LabModel -> get_tests ();
            $data[ 'panels' ]   = $this -> PanelModel -> get_active_panels_by_user ();
            $data[ 'airlines' ] = $this -> AirlineModel -> get_airlines ();
            $data[ 'reports' ]  = $this -> LabModel -> get_general_report_covid ();
            $this -> load -> view ( '/reporting/lab-covid-report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * lab cash balance report
         * -------------------------
         */
        
        public function lab_cash_balance_report () {
            $title = site_name . ' - Cash Balance Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'sales' ] = $this -> LabModel -> get_lab_cash_balance_report ();
            $this -> load -> view ( '/reporting/lab-cash-balance-report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * regents consumption report
         * -------------------------
         */
        
        public function regents_consumption_report () {
            $title = site_name . ' - Regents Consumption Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'tests' ]              = $this -> LabModel -> get_tests ();
            $data[ 'regents' ]            = $this -> LabModel -> get_regents ();
            $data[ 'regent_consumption' ] = $this -> LabModel -> get_regents_consumption_report ();
            $this -> load -> view ( '/reporting/regents-consumption-report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * regents consumption report
         * -------------------------
         */
        
        public function regents_consumption_report_ipd () {
            $title = site_name . ' - Regents Consumption Report (IPD)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'tests' ]              = $this -> LabModel -> get_tests ();
            $data[ 'regents' ]            = $this -> LabModel -> get_regents ();
            $data[ 'regent_consumption' ] = $this -> LabModel -> get_regents_ipd_consumption_report ();
            $this -> load -> view ( '/reporting/regents-consumption-report-ipd', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * lab general report
         * -------------------------
         */
        
        public function lab_general_reporting_ipd () {
            $title = site_name . ' - General Report IPD';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'tests' ]  = $this -> LabModel -> get_tests ();
            $data[ 'panels' ] = $this -> PanelModel -> get_active_panels ();
            if ( ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) ) or ( isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) or ( isset( $_REQUEST[ 'test_id' ] ) and !empty( trim ( $_REQUEST[ 'test_id' ] ) ) ) or ( isset( $_REQUEST[ 'sale_id' ] ) and !empty( trim ( $_REQUEST[ 'sale_id' ] ) ) ) )
                $data[ 'reports' ] = $this -> IPDModel -> get_lab_general_report ();
            else
                $data[ 'reports' ] = array ();
            $this -> load -> view ( '/reporting/lab-general-report-ipd', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * get detailed stock report
         * -------------------------
         */
        
        public function detailed_stock_report () {
            $title = site_name . ' - Detailed Stock Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'stocks' ] = $this -> MedicineModel -> get_all_stocks ();
            $this -> load -> view ( '/reporting/detailed-stock-report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * get bonus stock report
         * -------------------------
         */
        
        public function bonus_stock_report () {
            $title = site_name . ' - Bonus Stock Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'stocks' ] = $this -> ReportingModel -> bonus_stock_report ();
            $this -> load -> view ( '/reporting/bonus-stock-report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * General report customer return
         * display sale report
         * -------------------------
         */
        
        public function general_report_customer_return () {
            $title = site_name . ' - General Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ]     = $this -> MedicineModel -> get_medicines ();
            $data[ 'generics' ]      = $this -> MedicineModel -> get_generics ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            if ( isset( $_REQUEST[ 'start_date' ] ) or isset( $_REQUEST[ 'end_date' ] ) or isset( $_REQUEST[ 'medicine_id' ] ) ) {
                $data[ 'reports' ] = $this -> ReportingModel -> get_customer_sale_return_reports ();
            }
            else {
                $data[ 'reports' ] = array ();
            }
            $this -> load -> view ( '/reporting/general-report-customer-return', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Summary report
         * display summary report
         * -------------------------
         */
        
        public function summary_report () {
            $title = site_name . ' - Summary Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'consultancy_sales' ] = array ();
            $data[ 'opd_sales' ]         = array ();
            $data[ 'pharmacy_sales' ]    = array ();
            $data[ 'return_sales' ]      = array ();
            $data[ 'lab_sales' ]         = array ();
            if ( isset( $_REQUEST[ 'start_date' ] ) or isset( $_REQUEST[ 'end_date' ] ) ) {
                $data[ 'consultancy_sales' ] = $this -> ReportingModel -> get_consultancy_sales_summary ();
                $data[ 'opd_sales' ]         = $this -> ReportingModel -> get_opd_sales_summary ();
                $data[ 'return_sales' ]      = $this -> ReportingModel -> get_return_sales_summary ();
                $data[ 'lab_sales' ]         = $this -> ReportingModel -> get_lab_sales_summary ();
                $data[ 'pharmacy_sales' ]    = $this -> ReportingModel -> get_pharmacy_sales_summary ();
                $data[ 'pharmacy_discount' ] = $this -> ReportingModel -> get_pharmacy_discount ();
            }
            $this -> load -> view ( '/reporting/summary-report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Summary report
         * display form wise report
         * -------------------------
         */
        
        public function form_wise_report () {
            $title = site_name . ' - Form Wise Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'all_forms' ] = $this -> MedicineModel -> get_forms ();
            $data[ 'forms' ]     = $this -> ReportingModel -> get_forms ();
            $this -> load -> view ( '/reporting/form_wise_report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Summary report
         * display form wise report
         * -------------------------
         */
        
        public function supplier_wise_report () {
            $title = site_name . ' - Supplier Wise Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $data[ 'stocks' ]    = $this -> ReportingModel -> get_supplier_stock ();
            $this -> load -> view ( '/reporting/supplier_wise_report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Analysis report
         * display invoice wise report
         * -------------------------
         */
        
        public function analysis_report () {
            $title = site_name . ' - Analysis Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_all_medicines ();
            $data[ 'analysis' ]  = $this -> ReportingModel -> get_stock_analysis ();
            $this -> load -> view ( '/reporting/analysis_report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Analysis report sale
         * display invoice wise report
         * -------------------------
         */
        
        public function analysis_report_sale () {
            $title = site_name . ' - Analysis Report - Sale';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_all_medicines ();
            $data[ 'analysis' ]  = $this -> ReportingModel -> get_stock_analysis_by_sale ();
            
            $this -> load -> view ( '/reporting/analysis_report_sale', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Analysis report ipd sale
         * display invoice wise report
         * -------------------------
         */
        
        public function analysis_report_ipd_sale () {
            $title = site_name . ' - Analysis Report - IPD Sale';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_all_medicines ();
            $data[ 'analysis' ]  = $this -> ReportingModel -> get_stock_analysis_by_ipd_sale ();
            
            $this -> load -> view ( '/reporting/analysis_report_ipd_sale', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * General report
         * display internal issuance general report
         * -------------------------
         */
        
        public function internal_issuance_medicines_general_report () {
            $title = site_name . ' - Internal Issuance General Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ]   = $this -> MedicineModel -> get_all_medicines ();
            $data[ 'users' ]       = $this -> UserModel -> get_users ();
            $data[ 'issuance' ]    = $this -> MedicineModel -> get_issuance_by_filter ();
            $data[ 'departments' ] = $this -> MemberModel -> get_departments ();
            $this -> load -> view ( '/reporting/internal_issuance_medicines_general_report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * General report ipd medication
         * display sale report
         * -------------------------
         */
        
        public function profit_report_ipd_medication () {
            $title = site_name . ' - Profit Report IPD Medication';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'medicines' ]     = $this -> MedicineModel -> get_medicines ();
            $data[ 'generics' ]      = $this -> MedicineModel -> get_generics ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'users' ]         = $this -> UserModel -> get_users_by_department ( pharmacy_dept );
            if ( isset( $_REQUEST[ 'start_date' ] ) or isset( $_REQUEST[ 'end_date' ] ) or isset( $_REQUEST[ 'acc_head_id' ] ) or isset( $_REQUEST[ 'sale_from' ] ) or isset( $_REQUEST[ 'sale_to' ] ) or isset( $_REQUEST[ 'medicine_id' ] ) or isset( $_REQUEST[ 'user_id' ] ) ) {
                $data[ 'reports' ] = $this -> ReportingModel -> get_sale_reports_ipd_medication ();
            }
            else {
                $data[ 'reports' ] = array ();
            }
            
            $this -> load -> view ( '/reporting/profit-report-ipd-medication', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * lab test prices report
         * -------------------------
         */
        
        public function test_prices_report () {
            $title = site_name . ' - Test Prices Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'tests' ]    = $this -> LabModel -> get_parent_tests ();
            $data[ 'panels' ]   = $this -> PanelModel -> get_active_panels ();
            $data[ 'sections' ] = $this -> SectionModel -> get_sections ();
            $data[ 'reports' ]  = $this -> ReportingModel -> get_test_prices_report ();
            $this -> load -> view ( '/reporting/test-prices-report', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * lab referred by report
         * -------------------------
         */
        
        public function referred_by_report () {
            $title = site_name . ' - Referred By Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'airlines' ]  = $this -> AirlineModel -> get_airlines ();
            $data[ 'locations' ] = $this -> LocationModel -> get_locations ();
            $data[ 'panels' ]    = $this -> PanelModel -> get_active_panels ();
            $data[ 'reports' ]   = $this -> ReportingModel -> get_referred_by_report ();
            $this -> load -> view ( '/reporting/referred-by-report', $data );
            $this -> footer ();
        }
        
    }
