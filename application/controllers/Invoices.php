<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Invoices extends CI_Controller {
        
        /**
         * -------------------------
         * Accounts constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'AccountModel' );
            $this -> load -> model ( 'MedicineModel' );
            $this -> load -> model ( 'StockReturnModel' );
            $this -> load -> model ( 'ReportingModel' );
            $this -> load -> model ( 'PurchaseOrderModel' );
            $this -> load -> model ( 'ConsultancyModel' );
            $this -> load -> model ( 'LabModel' );
            $this -> load -> model ( 'OPDModel' );
            $this -> load -> model ( 'IPDModel' );
            $this -> load -> model ( 'RadiologyModel' );
            $this -> load -> model ( 'StoreModel' );
            $this -> load -> model ( 'DoctorModel' );
            $this -> load -> model ( 'HrModel' );
            $this -> load -> model ( 'LoanModel' );
            $this -> load -> model ( 'CompanyModel' );
            $this -> load -> model ( 'MemberModel' );
            $this -> load -> model ( 'PanelModel' );
            $this -> load -> model ( 'BirthCertificateModel' );
            $this -> load -> model ( 'RoomModel' );
            $this -> load -> model ( 'CultureModel' );
            $this -> load -> model ( 'HistopathologyModel' );
            $this -> load -> model ( 'RequisitionModel' );
            $this -> load -> model ( 'OnlineReferenceModel' );
            $this -> load -> model ( 'DeathCertificateModel' );
            $this -> load -> model ( 'UserModel' );
            $this -> load -> library ( 'pdf' );
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
         * ---------------------
         * print transaction invoice
         * by transaction id
         * ---------------------
         */
        
        public function transaction () {
            $transaction_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $transaction_id ) ) or !is_numeric ( $transaction_id ) or $transaction_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $where = array (
                'id' => $transaction_id
            );
            
            $data[ 'transaction_id' ] = $transaction_id;
            $data[ 'transactions' ]   = $this -> AccountModel -> get_transactions_by_id ( $where );
            $html_content             = $this -> load -> view ( '/invoices/transactions', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'fullpage' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $transaction_id . '.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * print transaction invoice
         * by voucher number
         * ---------------------
         */
        
        public function voucher_transaction () {
            $voucher_number = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $voucher_number ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $where = array (
                'voucher_number' => $voucher_number
            );
            
            $data[ 'transaction_id' ] = $voucher_number;
            $data[ 'transactions' ]   = $this -> AccountModel -> get_transactions_order_by_debit ( $where );
            $html_content             = $this -> load -> view ( '/invoices/transactions', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 40,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'fullpage' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $voucher_number . '.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets sales id and prints all record related to sale
         * ---------------------
         */
        
        public function sale_invoice () {
            $invoice_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $invoice_id ) ) or !is_numeric ( $invoice_id ) or $invoice_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $where = array (
                'sale_id' => $invoice_id
            );
            
            $data[ 'sale_id' ]   = $invoice_id;
            $data[ 'sales' ]     = $this -> MedicineModel -> get_sales_by_sale_id ( $where );
            $data[ 'sale' ]      = $this -> MedicineModel -> get_sale_by_id ( $invoice_id );
            $data[ 'user' ]      = get_user ( $data[ 'sale' ] -> user_id );
            $data[ 'sale_info' ] = get_sale ( $invoice_id );
            $html_content        = $this -> load -> view ( '/invoices/sale-invoice', $data );
            
            /*require_once FCPATH . '/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf([
            'margin_left'   => 5,
            'margin_right'  => 5,
            'margin_top'    => 48,
            'margin_bottom' => 25,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);

        $mpdf->SetTitle(site_name);
        $mpdf->SetAuthor(site_name);
        $mpdf->SetWatermarkText(site_name);
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html_content);
        $mpdf->Output($invoice_id.'.pdf','I');*/
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets invoice id and prints single record related to sale
         * ---------------------
         */
        
        public function print_invoice () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $where = array (
                'id' => $sale_id
            );
            
            $data[ 'sale_id' ] = $sale_id;
            $data[ 'sales' ]   = $this -> MedicineModel -> get_sales_by_sale_id ( $where );
            $html_content      = $this -> load -> view ( '/invoices/sale-invoice', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'fullpage' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $sale_id . '.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets return id and prints all record related to return
         * ---------------------
         */
        
        public function stock_return_invoice () {
            $return_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $return_id ) ) or !is_numeric ( $return_id ) or $return_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'return_id' ]   = $return_id;
            $data[ 'returns' ]     = $this -> StockReturnModel -> get_returns ( $return_id );
            $data[ 'return_info' ] = $this -> StockReturnModel -> get_return ( $return_id );
            $data[ 'supplier' ]    = get_account_head ( $data[ 'return_info' ] -> supplier_id );
            $html_content          = $this -> load -> view ( '/invoices/return-invoice', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $return_id . '.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets general invoice
         * of sales
         * ---------------------
         */
        
        public function general_report () {
            $data[ 'reports' ] = $this -> ReportingModel -> get_sale_reports ();
            $html_content      = $this -> load -> view ( '/invoices/general-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'General report ' . time () . '.pdf';
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText    = false;
            $mpdf -> watermark_font       = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha   = 0.1;
            $mpdf -> shrink_tables_to_fit = 1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets general invoice
         * of sales
         * ---------------------
         */
        
        public function sale_report_against_supplier () {
            if ( isset( $_REQUEST[ 'start_date' ] ) or isset( $_REQUEST[ 'end_date' ] ) or isset( $_REQUEST[ 'acc_head_id' ] ) ) {
                $stocks = $this -> ReportingModel -> get_supplier_stocks ();
                if ( empty( trim ( $stocks ) ) )
                    $stocks = 0;
                $data[ 'reports' ] = $this -> ReportingModel -> get_sale_report_by_supplier_stock ( $stocks );
            }
            else {
                $data[ 'reports' ] = array ();
            }
            $html_content = $this -> load -> view ( '/invoices/sale_report_against_supplier', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Sale Report Against Suppliers ' . time () . '.pdf';
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText    = false;
            $mpdf -> watermark_font       = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha   = 0.1;
            $mpdf -> shrink_tables_to_fit = 1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets general invoice
         * of sales
         * ---------------------
         */
        
        public function general_report_ipd_medication () {
            $data[ 'reports' ] = $this -> ReportingModel -> get_sale_reports_ipd_medication ();
            $html_content      = $this -> load -> view ( '/invoices/general-report-ipd-medication', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'General report IPD Medication' . time () . '.pdf';
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> shrink_tables_to_fit = 0;
            $mpdf -> showWatermarkText    = false;
            $mpdf -> watermark_font       = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha   = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets lab general invoice
         * of sales
         * ---------------------
         */
        
        public function lab_general_invoice () {
            $data[ 'reports' ]    = $this -> LabModel -> get_general_report ();
            $data[ 'receivings' ] = $this -> LabModel -> get_lab_receiving_general_report ();
            $html_content         = $this -> load -> view ( '/invoices/lab-general-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Lab General report ' . time () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets lab general invoice covid
         * of sales
         * ---------------------
         */
        
        public function lab_covid_report () {
            $data[ 'reports' ] = $this -> LabModel -> get_general_report_covid ();
            $html_content      = $this -> load -> view ( '/invoices/lab-covid-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Lab General report covid ' . time () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets lab general invoice covid
         * of sales
         * ---------------------
         */
        
        public function lab_covid_invoice () {
            $data[ 'reports' ] = $this -> LabModel -> get_general_report_covid ();
            $html_content      = $this -> load -> view ( '/invoices/lab-covid-invoice', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Lab General invoice covid ' . time () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets lab general invoice
         * of sales
         * ---------------------
         */
        
        public function lab_cash_balance_report () {
            $data[ 'sales' ] = $this -> LabModel -> get_lab_cash_balance_report ();
            $html_content    = $this -> load -> view ( '/invoices/lab-cash-balance-report.php', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 15,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Lab Cash Balance Report ' . time () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets lab regents consumption invoice
         * ---------------------
         */
        
        public function regents_consumption_invoice () {
            $data[ 'regent_consumption' ] = $this -> LabModel -> get_regents_consumption_report ();
            $html_content                 = $this -> load -> view ( '/invoices/regents-consumption-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Regents consumption ' . time () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets lab regents consumption invoice
         * ---------------------
         */
        
        public function regents_consumption_invoice_ipd () {
            $data[ 'regent_consumption' ] = $this -> LabModel -> get_regents_ipd_consumption_report ();
            $html_content                 = $this -> load -> view ( '/invoices/regents-consumption-report-ipd', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Regents consumption IPD' . time () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets lab general invoice
         * of sales
         * ---------------------
         */
        
        public function lab_general_invoice_ipd () {
            $data[ 'reports' ] = $this -> IPDModel -> get_lab_general_report ();
            $html_content      = $this -> load -> view ( '/invoices/lab-general-report-ipd', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Lab General report IPD ' . time () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets profit invoice
         * of sales
         * ---------------------
         */
        
        public function profit_report () {
            $data[ 'reports' ] = $this -> ReportingModel -> get_profit_reports ();
            $data[ 'returns' ] = $this -> ReportingModel -> get_customer_return_profit_reports ();
            $html_content      = $this -> load -> view ( '/invoices/profit-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Profit report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets profit invoice
         * of sales
         * ---------------------
         */
        
        public function profit_report_ipd_medication () {
            $data[ 'reports' ] = $this -> ReportingModel -> get_sale_reports_ipd_medication ();
            $html_content      = $this -> load -> view ( '/invoices/profit-report-ipd-medication', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Profit Report IPD Medication.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets stock evaluation invoice
         * ---------------------
         */
        
        public function stock_evaluation_report () {
            $data[ 'medicines' ] = $this -> MedicineModel -> filter_medicines_stock_valuation ();
            $html_content        = $this -> load -> view ( '/invoices/stock-evaluation-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Stock evaluation report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets stock evaluation invoice
         * ---------------------
         */
        
        public function store_stock_evaluation_report () {
            $data[ 'stores' ] = $this -> StoreModel -> get_store_having_stock ();
            $html_content     = $this -> load -> view ( '/invoices/store-stock-evaluation-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Store Stock evaluation report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets store purchase report
         * ---------------------
         */
        
        public function purchase_report () {
            $data[ 'stocks' ] = $this -> StoreModel -> get_purchase_report ();
            $html_content     = $this -> load -> view ( '/invoices/purchase-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Purchase report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets stock evaluation invoice of available qty
         * ---------------------
         */
        
        public function stock_evaluation_report_available_qty_report () {
            $data[ 'medicines' ] = $this -> MedicineModel -> get_all_medicines ( 100000000, 0 );
            $html_content        = $this -> load -> view ( '/invoices/stock_evaluation_report_available_qty_report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Stock evaluation report available quantity.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets stock evaluation invoice
         * ---------------------
         */
        
        public function stock_evaluation_report_sale_price () {
            $data[ 'medicines' ] = $this -> MedicineModel -> filter_medicines_stock_valuation ();
            $html_content        = $this -> load -> view ( '/invoices/stock_evaluation_report_sale_price', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Stock evaluation report sale price.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets stock threshold invoice
         * ---------------------
         */
        
        public function threshold_report () {
            $data[ 'medicines' ] = $this -> MedicineModel -> get_all_medicines ( 100000000, 0 );
            $html_content        = $this -> load -> view ( '/invoices/threshold-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Threshold report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets expired medicine invoice
         * ---------------------
         */
        
        public function expired_medicine_report () {
            $data[ 'medicines' ] = $this -> MedicineModel -> get_all_medicines ( 100000000, 0 );
            $html_content        = $this -> load -> view ( '/invoices/expired-medicine-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Expired medicine report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print purchase order invoice
         * ---------------------
         */
        
        public function purchase_order_invoice () {
            $order_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $order_id ) ) or !is_numeric ( $order_id ) or $order_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'order_id' ] = $order_id;
            $data[ 'orders' ]   = $this -> PurchaseOrderModel -> get_orders_by_id ( $order_id );
            $html_content       = $this -> load -> view ( '/invoices/purchase-order-invoice', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Purchase order.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print store purchase order invoice
         * ---------------------
         */
        
        public function store_purchase_order_invoice () {
            $order_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $order_id ) ) or !is_numeric ( $order_id ) or $order_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'order_id' ] = $order_id;
            $data[ 'orders' ]   = $this -> PurchaseOrderModel -> get_store_orders_by_id ( $order_id );
            $html_content       = $this -> load -> view ( '/invoices/store-purchase-order-invoice', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Store Purchase order.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print lab sale invoice
         * ---------------------
         */
        
        public function lab_sale_invoice () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]            = $sale_id;
            $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
            $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
            $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
            $data[ 'sales' ]              = $this -> LabModel -> get_lab_sales_by_sale_id ( $sale_id );
            $data[ 'parents' ]            = $this -> LabModel -> get_parents_by_sale_id ( $sale_id );
            $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
            $data[ 'specimens' ]          = $this -> LabModel -> get_lab_sale_specimens ( $sale_id );
            $sale_info                    = get_lab_sale ( $sale_id );
            $data[ 'sold_by' ]            = get_user ( $sale_info -> user_id ) -> name;
            $test_sale_info               = get_test_sale ( $sale_id );
            
            $html_content = $this -> load -> view ( '/invoices/lab-sale-invoice', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 45,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Lab sale' . rand ( 0, 15244 ) . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            
            if ( $test_sale_info -> refunded == '1' ) {
                $mpdf -> SetWatermarkText ( 'Refunded' );
                $mpdf -> showWatermarkText = true;
            }
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            
            //            $mpdf -> SetWatermarkImage ( base_url ( '/assets/img/watermark.jpeg' ), 0.8 );
            //            $mpdf -> showWatermarkImage = true;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> autoScriptToLang = true;
            $mpdf -> autoLangToFont   = true;
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print test result invoice
         * ---------------------
         */
        
        public function test_result_invoice () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]    = $sale_id;
            $data[ 'patient_id' ] = get_patient_id_by_sale_id ( $sale_id );
            $data[ 'patient' ]    = get_patient ( $data[ 'patient_id' ] );
            $data[ 'user' ]       = get_user ( get_logged_in_user_id () );
            $data[ 'tests' ]      = $this -> LabModel -> get_lab_results_by_sale_id ( $sale_id );
            
            $html_content = $this -> load -> view ( '/invoices/lab-result-invoice', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Lab-test-result.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print stock invoice
         * ---------------------
         */
        
        public function stock_invoice () {
            $invoice_id  = $this -> uri -> segment ( 3 );
            $supplier_id = $_REQUEST[ 'supplier_id' ];
            if ( empty( trim ( $invoice_id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'invoice' ] = $invoice_id;
            //        $supplier_id            = get_supplier_id_by_invoice_id_and_supplier_id($invoice_id);
            $data[ 'supplier' ] = get_supplier ( $supplier_id );
            $data[ 'user' ]     = get_user ( get_logged_in_user_id () );
            $data[ 'stock' ]    = $this -> MedicineModel -> get_stock_by_invoice_and_supplier ( $invoice_id, $supplier_id );
            
            $html_content = $this -> load -> view ( '/invoices/stock-invoice', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 40,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Stock invoice.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print consultancy invoice
         * ---------------------
         */
        
        public function consultancy_invoice () {
            $consultancy_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $consultancy_id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'consultancy_id' ] = $consultancy_id;
            $data[ 'user' ]           = get_user ( get_logged_in_user_id () );
            $data[ 'consultancy' ]    = $this -> ConsultancyModel -> get_consultancy_by_id ( $consultancy_id );
            $data[ 'sold_by' ]        = get_user ( $data[ 'consultancy' ] -> user_id ) -> name;
            $html_content             = $this -> load -> view ( '/invoices/consultancy-invoice', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            
            if ( $data[ 'consultancy' ] -> refunded == '1' ) {
                $mpdf -> SetWatermarkText ( 'Refunded' );
                $mpdf -> showWatermarkText = true;
            }
            
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Consultancy invoice.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print prescription invoice
         * ---------------------
         */
        
        public function prescription_invoice () {
            $prescription_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $prescription_id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'user' ]         = get_user ( get_logged_in_user_id () );
            $data[ 'prescription' ] = $this -> ConsultancyModel -> get_doctor_prescriptions ( $prescription_id );
            $data[ 'medicines' ]    = $this -> ConsultancyModel -> get_doctor_prescribed_medicines ( $prescription_id );
            $data[ 'tests' ]        = $this -> ConsultancyModel -> get_doctor_prescribed_tests ( $prescription_id );
            $html_content           = $this -> load -> view ( '/invoices/prescription-invoice', $data, true );
            
            $name = 'Prescription-invoice-' . rand ( 0, 500 ) . '.pdf';
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 25,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print prescription invoice
         * ---------------------
         */
        
        public function detailed_stock_report () {
            $data[ 'user' ]   = get_user ( get_logged_in_user_id () );
            $data[ 'stocks' ] = $this -> MedicineModel -> get_all_stocks ();
            $html_content     = $this -> load -> view ( '/invoices/detailed-stock-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Detailed stock report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print opd sale service invoice
         * ---------------------
         */
        
        public function opd_sale_invoice () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $sale_id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]   = $sale_id;
            $data[ 'user' ]      = get_user ( get_logged_in_user_id () );
            $data[ 'main_sale' ] = $this -> OPDModel -> get_sale_by_id ( $sale_id );
            $data[ 'sales' ]     = $this -> OPDModel -> get_sales ( $sale_id );
            $sale                = $data[ 'sale' ] = get_opd_sale ( $sale_id );
            $data[ 'sold_by' ]   = get_user ( $sale -> user_id ) -> name;
            $html_content        = $this -> load -> view ( '/invoices/opd-sale-invoice', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            
            if ( $sale -> refund == '1' ) {
                $mpdf -> SetWatermarkText ( 'Refunded' );
                $mpdf -> showWatermarkText = true;
            }
            
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Sale service invoice.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print opd sale service invoice
         * ---------------------
         */
        
        public function consultancy_general_report () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( isset( $_REQUEST[ 'action' ] ) and $_REQUEST[ 'action' ] == 'print-consultancy-report' ) {
                $data[ 'user' ]             = get_user ( get_logged_in_user_id () );
                $data[ 'consultancies' ]    = $this -> ReportingModel -> get_consultancies_cash ();
                $data[ 'online_reference' ] = $this -> OnlineReferenceModel -> get_reference_by_id ( $this -> input -> get ( 'online-reference-id' ) );
                $html_content               = $this -> load -> view ( '/invoices/consultancy-general-report', $data, true );
                
                require_once FCPATH . '/vendor/autoload.php';
                $mpdf = new \Mpdf\Mpdf( [
                                            'margin_left'   => 5,
                                            'margin_right'  => 5,
                                            'margin_top'    => 35,
                                            'margin_bottom' => 17,
                                            'margin_header' => 5,
                                            'margin_footer' => 5
                                        ] );
                $mpdf -> SetTitle ( strip_tags ( site_name ) );
                $mpdf -> SetAuthor ( site_name );
                $mpdf -> SetWatermarkText ( site_name );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( 'Consultancy general report cash.pdf', 'I' );
            }
        }
        
        /**
         * ---------------------
         * do print invoice
         * print opd sale service invoice
         * ---------------------
         */
        
        public function consultancy_general_report_panel () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( isset( $_REQUEST[ 'action' ] ) and $_REQUEST[ 'action' ] == 'print-consultancy-report' ) {
                $data[ 'user' ]          = get_user ( get_logged_in_user_id () );
                $data[ 'consultancies' ] = $this -> ReportingModel -> get_consultancies_panel ();
                $html_content            = $this -> load -> view ( '/invoices/consultancy_general_report_panel', $data, true );
                
                require_once FCPATH . '/vendor/autoload.php';
                $mpdf = new \Mpdf\Mpdf( [
                                            'margin_left'   => 5,
                                            'margin_right'  => 5,
                                            'margin_top'    => 35,
                                            'margin_bottom' => 5,
                                            'margin_header' => 5,
                                            'margin_footer' => 5
                                        ] );
                $mpdf -> SetTitle ( strip_tags ( site_name ) );
                $mpdf -> SetAuthor ( site_name );
                $mpdf -> SetWatermarkText ( site_name );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( 'Consultancy general report panel.pdf', 'I' );
            }
        }
        
        /**
         * ---------------------
         * do print invoice
         * print opd sale service invoice
         * ---------------------
         */
        
        public function opd_general_report () {
            $data[ 'user' ]  = get_user ( get_logged_in_user_id () );
            $data[ 'sales' ] = $this -> ReportingModel -> get_sales_by_sale_grouped ();
            $html_content    = $this -> load -> view ( '/invoices/opd-general-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'OPD general report cash.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print opd sale service invoice
         * ---------------------
         */
        
        public function opd_general_report_panel () {
            $data[ 'user' ]  = get_user ( get_logged_in_user_id () );
            $data[ 'sales' ] = $this -> ReportingModel -> get_panel_sales_by_sale_grouped ();
            $html_content    = $this -> load -> view ( '/invoices/opd-general-report-panel', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'OPD general report panel.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets general invoice customer return
         * ---------------------
         */
        
        public function general_report_customer_return () {
            $data[ 'reports' ] = $this -> ReportingModel -> get_customer_sale_return_reports ();
            $html_content      = $this -> load -> view ( '/invoices/general-report-customer-return', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'General report returns.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * summary report
         * ---------------------
         */
        
        public function summary_report () {
            $data[ 'consultancy_sales' ]    = $this -> ReportingModel -> get_consultancy_sales_summary ();
            $data[ 'opd_sales' ]            = $this -> ReportingModel -> get_opd_sales_summary ();
            $data[ 'return_sales' ]         = $this -> ReportingModel -> get_return_sales_summary ();
            $data[ 'lab_sales' ]            = $this -> ReportingModel -> get_lab_sales_summary ();
            $data[ 'pharmacy_sales' ]       = $this -> ReportingModel -> get_pharmacy_sales_summary ();
            $data[ 'pharmacy_discount' ]    = $this -> ReportingModel -> get_pharmacy_discount ();
            $data[ 'total_local_purchase' ] = calculate_sum_local_purchase ();
            $html_content                   = $this -> load -> view ( '/invoices/summary-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Summary Report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * general ledger
         * ---------------------
         */
        
        public function general_ledger () {
            $data[ 'ledgers' ] = $this -> AccountModel -> get_ledgers ();
            $html_content      = $this -> load -> view ( '/invoices/general-ledger', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'General Ledger ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * xray report
         * ---------------------
         */
        
        public function xray_report () {
            
            if ( !isset( $_REQUEST[ 'report-id' ] ) or !is_numeric ( $_REQUEST[ 'report-id' ] ) or $_REQUEST[ 'report-id' ] < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $report_id        = $_REQUEST[ 'report-id' ];
            $data[ 'report' ] = $this -> RadiologyModel -> get_xray_report_by_id ( $report_id );
            $data[ 'lab' ]    = get_lab_sale ( $data[ 'report' ] -> sale_id );
            $data[ 'user' ]   = get_logged_in_user ();
            $html_content     = $this -> load -> view ( '/invoices/xray-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 41,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Xray Report ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            
            $status = get_report_verify_status ( $report_id, 'hmis_xray' );
            if ( empty( $status ) ) {
                $mpdf -> SetWatermarkText ( 'Unverified' );
                $mpdf -> showWatermarkText  = true;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
            }
            else {
                $mpdf -> SetWatermarkText ( site_name );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
            }
            
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * xray report
         * ---------------------
         */
        
        public function ultrasound_report () {
            
            if ( !isset( $_REQUEST[ 'report-id' ] ) or !is_numeric ( $_REQUEST[ 'report-id' ] ) or $_REQUEST[ 'report-id' ] < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $report_id        = $_REQUEST[ 'report-id' ];
            $data[ 'report' ] = $this -> RadiologyModel -> get_ultrasound_report_by_id ( $report_id );
            $data[ 'lab' ]    = get_lab_sale ( $data[ 'report' ] -> sale_id );
            $data[ 'user' ]   = get_logged_in_user ();
            $html_content     = $this -> load -> view ( '/invoices/ultrasound-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 41,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Ultrasound Report ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            
            $status = get_report_verify_status ( $report_id, 'hmis_ultrasound' );
            if ( empty( $status ) ) {
                $mpdf -> SetWatermarkText ( 'Unverified' );
                $mpdf -> showWatermarkText  = true;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
            }
            else {
                $mpdf -> SetWatermarkText ( site_name );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
            }
            
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * abdomen pelvis female report
         * ---------------------
         */
        
        public function abdomen_pelvis_female_report () {
            
            if ( !isset( $_REQUEST[ 'report_id' ] ) or !is_numeric ( $_REQUEST[ 'report_id' ] ) or $_REQUEST[ 'report_id' ] < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $report_id        = $_REQUEST[ 'report_id' ];
            $data[ 'report' ] = $this -> RadiologyModel -> get_abdomen_female_report ( $report_id );
            $data[ 'kidney' ] = $this -> RadiologyModel -> get_abdomen_female_kidney_report ( $report_id );
            $html_content     = $this -> load -> view ( '/invoices/abdomen-pelvis-female-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            $name = 'Abdomen Pelvis Female Report ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * bonus stock report
         * ---------------------
         */
        
        public function bonus_stock_report () {
            $data[ 'stocks' ] = $this -> ReportingModel -> bonus_stock_report ();
            $html_content     = $this -> load -> view ( '/invoices/bonus-stock-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Bonus Report ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * bonus stock report
         * ---------------------
         */
        
        public function form_wise_report () {
            $data[ 'forms' ] = $this -> ReportingModel -> get_forms ();
            $html_content    = $this -> load -> view ( '/invoices/form_wise_report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Form Wise Report ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * form wise report combined of tablets/capsules
         * ---------------------
         */
        
        public function form_wise_report_c () {
            $data[ 'forms' ]          = $this -> ReportingModel -> get_forms_except_tablets_capsules ();
            $data[ 'combined_forms' ] = $this -> ReportingModel -> get_forms_combined_tablets_capsules ();
            $html_content             = $this -> load -> view ( '/invoices/form_wise_report_c', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Form Wise Report Tablet/Capsule Combined ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * ipd invoice
         * ---------------------
         */
        
        public function ipd_invoice () {
            $sale_id = @$_REQUEST[ 'sale_id' ];
            if ( !isset( $sale_id ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale' ]                    = $this -> IPDModel -> get_sale_info ( $sale_id );
            $data[ 'patient' ]                 = get_patient ( $data[ 'sale' ] -> patient_id );
            $data[ 'patient_id' ]              = $data[ 'sale' ] -> patient_id;
            $data[ 'sale_id' ]                 = $sale_id;
            $data[ 'user' ]                    = get_user ( $data[ 'sale' ] -> discharged_by );
            $data[ 'ipd_associated_services' ] = $this -> IPDModel -> get_patient_ipd_associated_services_not_in_type ( $sale_id );
            $data[ 'opd_associated_services' ] = $this -> IPDModel -> get_patient_opd_associated_services_not_in_type ( $sale_id );
            $data[ 'xray' ]                    = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'xray' );
            $data[ 'ultrasound' ]              = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'ultrasound' );
            $data[ 'ecg' ]                     = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'ecg' );
            $data[ 'echo' ]                    = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'echo' );
            $data[ 'ipd_lab_tests' ]           = $this -> IPDModel -> get_ipd_patient_tests ( $sale_id );
            $data[ 'medication' ]              = $this -> IPDModel -> get_ipd_patient_medication ( $sale_id );
            $data[ 'sale_billing' ]            = $this -> IPDModel -> get_sale_billing_info ( $sale_id );
            $data[ 'count_payment' ]           = $this -> IPDModel -> count_payment ( $sale_id );
            $data[ 'consultants' ]             = $this -> IPDModel -> get_consultants ( $sale_id );
            
            $html_content = $this -> load -> view ( '/invoices/ipd_invoice', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'IPD Invoice ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * ipd consolidated invoice
         * ---------------------
         */
        
        public function ipd_invoice_consolidated () {
            $sale_id = @$_REQUEST[ 'sale_id' ];
            if ( !isset( $sale_id ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale' ]                             = $this -> IPDModel -> get_sale_info ( $sale_id );
            $data[ 'patient' ]                          = get_patient ( $data[ 'sale' ] -> patient_id );
            $data[ 'patient_id' ]                       = $data[ 'sale' ] -> patient_id;
            $data[ 'sale_id' ]                          = $sale_id;
            $data[ 'user' ]                             = get_user ( $data[ 'sale' ] -> discharged_by );
            $data[ 'ipd_associated_services' ]          = $this -> IPDModel -> get_patient_ipd_associated_services_consolidated_not_in_type ( $sale_id );
            $data[ 'ipd_associated_services_excluded' ] = $this -> IPDModel -> get_patient_ipd_associated_services_consolidated_not_in_type ( $sale_id, '0' );
            $data[ 'opd_associated_services' ]          = $this -> IPDModel -> get_patient_opd_associated_services_not_in_type ( $sale_id );
            $data[ 'xray' ]                             = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'xray' );
            $data[ 'ultrasound' ]                       = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'ultrasound' );
            $data[ 'ecg' ]                              = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'ecg' );
            $data[ 'echo' ]                             = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'echo' );
            $data[ 'ipd_lab_tests' ]                    = $this -> IPDModel -> get_ipd_patient_tests_consolidated ( $sale_id );
            $data[ 'medication' ]                       = $this -> IPDModel -> get_ipd_patient_medication_consolidated ( $sale_id );
            $data[ 'sale_billing' ]                     = $this -> IPDModel -> get_sale_billing_info ( $sale_id );
            $data[ 'count_payment' ]                    = $this -> IPDModel -> count_payment ( $sale_id );
            $data[ 'consultants' ]                      = $this -> IPDModel -> get_consultants ( $sale_id );
            $data[ 'cash_paid' ]                        = $this -> IPDModel -> sum_ipd_payments ( $sale_id );
            $data[ 'anesthesia_charges' ]               = $this -> IPDModel -> get_anesthesia_charges ( $sale_id );
            
            $html_content = $this -> load -> view ( '/invoices/ipd_invoice_consolidated', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 25,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'IPD Invoice Consolidated ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function ipd_invoice_consolidated_cash () {
            $sale_id = @$_REQUEST[ 'sale_id' ];
            if ( !isset( $sale_id ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale' ]                             = $this -> IPDModel -> get_sale_info ( $sale_id );
            $data[ 'patient' ]                          = get_patient ( $data[ 'sale' ] -> patient_id );
            $data[ 'patient_id' ]                       = $data[ 'sale' ] -> patient_id;
            $data[ 'sale_id' ]                          = $sale_id;
            $data[ 'user' ]                             = get_user ( $data[ 'sale' ] -> discharged_by );
            $data[ 'ipd_associated_services' ]          = $this -> IPDModel -> get_patient_ipd_associated_services_consolidated_not_in_type ( $sale_id );
            $data[ 'ipd_associated_services_excluded' ] = $this -> IPDModel -> get_patient_ipd_associated_services_consolidated_not_in_type ( $sale_id, '0' );
            $data[ 'opd_associated_services' ]          = $this -> IPDModel -> get_patient_opd_associated_services_not_in_type ( $sale_id );
            $data[ 'xray' ]                             = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'xray' );
            $data[ 'ultrasound' ]                       = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'ultrasound' );
            $data[ 'ecg' ]                              = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'ecg' );
            $data[ 'echo' ]                             = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'echo' );
            $data[ 'ipd_lab_tests' ]                    = $this -> IPDModel -> get_ipd_patient_tests_consolidated ( $sale_id );
            $data[ 'medication' ]                       = $this -> IPDModel -> get_ipd_patient_medication_consolidated ( $sale_id );
            $data[ 'sale_billing' ]                     = $this -> IPDModel -> get_sale_billing_info ( $sale_id );
            $data[ 'count_payment' ]                    = $this -> IPDModel -> count_payment ( $sale_id );
            $data[ 'consultants' ]                      = $this -> IPDModel -> get_consultants ( $sale_id );
            $data[ 'cash_paid' ]                        = $this -> IPDModel -> sum_ipd_payments ( $sale_id );
            $data[ 'anesthesia_charges' ]               = $this -> IPDModel -> get_anesthesia_charges ( $sale_id );
            
            $html_content = $this -> load -> view ( '/invoices/ipd_invoice_consolidated_cash', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 25,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'IPD Invoice Consolidated ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * ipd invoice
         * ---------------------
         */
        
        public function ipd_invoice_combined () {
            $sale_id = @$_REQUEST[ 'sale_id' ];
            if ( !isset( $sale_id ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale' ]                    = $this -> IPDModel -> get_sale_info ( $sale_id );
            $data[ 'patient' ]                 = get_patient ( $data[ 'sale' ] -> patient_id );
            $data[ 'patient_id' ]              = $data[ 'sale' ] -> patient_id;
            $data[ 'sale_id' ]                 = $sale_id;
            $data[ 'user' ]                    = get_user ( $data[ 'sale' ] -> discharged_by );
            $data[ 'ipd_associated_services' ] = $this -> IPDModel -> get_patient_ipd_associated_services_not_in_type ( $sale_id );
            $data[ 'opd_associated_services' ] = $this -> IPDModel -> get_patient_opd_associated_services_not_in_type ( $sale_id );
            $data[ 'xray' ]                    = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'xray' );
            $data[ 'ultrasound' ]              = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'ultrasound' );
            $data[ 'ecg' ]                     = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'ecg' );
            $data[ 'echo' ]                    = $this -> IPDModel -> get_patient_associated_services_by_type ( $sale_id, 'echo' );
            $data[ 'ipd_lab_tests' ]           = $this -> IPDModel -> get_ipd_patient_tests_sum ( $sale_id );
            $data[ 'medication' ]              = $this -> IPDModel -> get_ipd_patient_medication_sum ( $sale_id );
            $data[ 'sale_billing' ]            = $this -> IPDModel -> get_sale_billing_info ( $sale_id );
            $data[ 'count_payment' ]           = $this -> IPDModel -> count_payment ( $sale_id );
            $data[ 'consultants' ]             = $this -> IPDModel -> get_consultants ( $sale_id );
            
            $html_content = $this -> load -> view ( '/invoices/ipd_invoice_combined', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'IPD Invoice ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * supplier wise invoice
         * ---------------------
         */
        
        public function supplier_wise_report () {
            $data[ 'stocks' ] = $this -> ReportingModel -> get_supplier_stock ();
            $html_content     = $this -> load -> view ( '/invoices/supplier_wise_report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Supplier Invoice ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * Analysis report
         * display invoice wise report
         * ---------------------
         */
        
        public function analysis_report () {
            $data[ 'analysis' ] = $this -> ReportingModel -> get_stock_analysis ();
            $html_content       = $this -> load -> view ( '/invoices/analysis_report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Analysis Invoice ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * Analysis report
         * display invoice wise report
         * ---------------------
         */
        
        public function analysis_report_sale () {
            $data[ 'analysis' ] = $this -> ReportingModel -> get_stock_analysis_by_sale ();
            $html_content       = $this -> load -> view ( '/invoices/analysis_report_sale', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Analysis Invoice Sale' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * Analysis report
         * display invoice wise report
         * ---------------------
         */
        
        public function analysis_report_ipd_sale () {
            $data[ 'analysis' ] = $this -> ReportingModel -> get_stock_analysis_by_ipd_sale ();
            $html_content       = $this -> load -> view ( '/invoices/analysis_report_ipd_sale', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Analysis Invoice IPD Sale' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * Issuance report
         * display internal issuance report
         * ---------------------
         */
        
        public function internal_medicine_issuance () {
            $sale_id = @$_REQUEST[ 'sale_id' ];
            if ( !isset( $sale_id ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'issuance' ] = $this -> MedicineModel -> get_issuance_by_id ( $sale_id );
            $html_content       = $this -> load -> view ( '/invoices/internal_medicine_issuance', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Internal medicine issuance ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * par levels report
         * display par levels report
         * ---------------------
         */
        
        public function internal_issuance_par_levels_report () {
            $department_id = @$_REQUEST[ 'department_id' ];
            if ( !isset( $department_id ) or !is_numeric ( $department_id ) or $department_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'levels' ] = $this -> StoreModel -> internal_issuance_par_levels_report_by_department ( $department_id );
            $html_content     = $this -> load -> view ( '/invoices/internal_issuance_par_levels_report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            $name = 'Internal issuance par levels ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * general report
         * display internal issuance general report
         * ---------------------
         */
        
        public function internal_issuance_medicines_general_report () {
            $data[ 'issuance' ] = $this -> MedicineModel -> get_issuance_by_filter ();
            $html_content       = $this -> load -> view ( '/invoices/internal_issuance_medicines_general_report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Internal issuance general report ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * general report
         * doctor consultancy report
         * ---------------------
         */
        
        public function doctor_consultancy_report () {
            $data[ 'doctors' ]        = $this -> DoctorModel -> get_doctors ();
            $data[ 'filter_doctors' ] = $this -> DoctorModel -> get_doctors_by_filter ();
            $data[ 'user' ]           = get_logged_in_user ();
            $html_content             = $this -> load -> view ( '/invoices/doctor_consultancy_report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Doctor consultancy report ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * ipd payment
         * payment slip invoice
         * ---------------------
         */
        
        public function payment_invoice () {
            $payment_id = $this -> uri -> segment ( 3 );
            $sale_id    = $this -> uri -> segment ( 4 );
            if ( !$payment_id or $payment_id < 1 or !$sale_id or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'payment' ] = $this -> IPDModel -> get_payment_by_id ( $payment_id );
            $data[ 'slip' ]    = $this -> IPDModel -> get_admission_slip ( $sale_id );
            $html_content      = $this -> load -> view ( '/invoices/payment_invoice', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 40,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            $name = 'Payment Slip ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * ipd payment
         * payments slip invoice
         * ---------------------
         */
        
        public function payments_invoice () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( !$sale_id or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'payments' ]           = $this -> IPDModel -> gets_payment_by_id ( $sale_id );
            $data[ 'slip' ]               = $this -> IPDModel -> get_admission_slip ( $sale_id );
            $data[ 'sale_billing' ]       = $this -> IPDModel -> get_sale_billing_info ( $sale_id );
            $data[ 'total_ipd_services' ] = $this -> IPDModel -> total_ipd_services ( $sale_id );
            $data[ 'total_opd_services' ] = $this -> IPDModel -> total_opd_services ( $sale_id );
            $data[ 'total_lab_services' ] = $this -> IPDModel -> total_lab_services ( $sale_id );
            $data[ 'total_medication' ]   = $this -> IPDModel -> total_medication ( $sale_id );
            $data[ 'sale_id' ]            = $sale_id;
            $html_content                 = $this -> load -> view ( '/invoices/payments_invoice', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 42,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            $name = 'Payments Slip ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * ipd payment
         * initial deposit invoice
         * ---------------------
         */
        
        public function initial_deposit_invoice () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( !$sale_id or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'slip' ]         = $this -> IPDModel -> get_admission_slip ( $sale_id );
            $data[ 'sale_billing' ] = $this -> IPDModel -> get_sale_billing_info ( $sale_id );
            $html_content           = $this -> load -> view ( '/invoices/initial_deposit_invoice', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Payment Slip ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * ipd payment
         * admission slip
         * ---------------------
         */
        
        public function ipd_admission_slip () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( !$sale_id or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'slip' ] = $this -> IPDModel -> get_admission_slip ( $sale_id );
            $html_content   = $this -> load -> view ( '/invoices/ipd_admission_slip', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Admission Slip ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * General summary report
         * display summary report of
         * lab, opd, ipd
         * -------------------------
         */
        
        public function general_summary_report () {
            $data[ 'consultancy_total' ] = $this -> ConsultancyModel -> get_total_sale_by_date_range ();
            $data[ 'opd_total' ]         = $this -> OPDModel -> get_total_sale_by_date_range ();
            $data[ 'lab_total' ]         = $this -> LabModel -> get_total_sale_by_date_range ();
            $data[ 'med_total' ]         = $this -> MedicineModel -> get_total_sale_by_date_range ();
            $data[ 'ipd_total' ]         = $this -> IPDModel -> get_total_sale_by_date_range ();
            $html_content                = $this -> load -> view ( '/invoices/general-summary-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'General summary report ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function daily_closing_report () {
            $data[ 'consultancies' ] = $this -> ConsultancyModel -> get_consultancy_daily_closing_report ();
            $data[ 'opd_sales' ]     = $this -> OPDModel -> get_opd_sales_daily_closing_report ();
            $data[ 'lab_sales' ]     = $this -> LabModel -> get_lab_sales_daily_closing_report ();
            $html_content            = $this -> load -> view ( '/invoices/daily-closing-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Daily closing report ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * General summary report
         * display summary report of
         * lab, opd, ipd
         * -------------------------
         */
        
        public function local_purchase () {
            
            if ( !isset( $_REQUEST[ 'supplier_invoice' ] ) or empty( trim ( $_REQUEST[ 'supplier_invoice' ] ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $supplier_invoice = $_REQUEST[ 'supplier_invoice' ];
            $data[ 'stocks' ] = $this -> MedicineModel -> get_local_purchases_by_supplier_invoice ( $supplier_invoice );
            $html_content     = $this -> load -> view ( '/invoices/local_purchase', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Local purchase ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * display ipd lab test
         * -------------------------
         */
        
        public function ipd_lab_test () {
            
            $test_id = $this -> uri -> segment ( 3 );
            if ( !$test_id or empty( trim ( $test_id ) ) or !is_numeric ( $test_id ) or $test_id < 0 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'test_id' ] = $test_id;
            $data[ 'test' ]    = $this -> IPDModel -> get_ipd_lab_test ( $test_id );
            $html_content      = $this -> load -> view ( '/invoices/ipd_lab_test', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'IPD Lab Test ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * display ipd lab tests
         * -------------------------
         */
        
        public function ipd_lab_tests () {
            
            $sale_id = $_REQUEST[ 'sale_id' ];
            if ( !isset( $sale_id ) or empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 0 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'tests' ] = $this -> IPDModel -> get_ipd_lab_tests ( $sale_id );
            $html_content    = $this -> load -> view ( '/invoices/ipd_lab_tests', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'IPD Lab Test ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * display ipd medication
         * -------------------------
         */
        
        public function ipd_medication_invoice () {
            
            $sale_id = $_REQUEST[ 'sale_id' ];
            if ( !isset( $sale_id ) or empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 0 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]   = $sale_id;
            $data[ 'medicines' ] = $this -> IPDModel -> get_ipd_medication ( $sale_id );
            $html_content        = $this -> load -> view ( '/invoices/ipd_medication_invoice', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'IPD Medication ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * ipd adjustments
         * -------------------------
         */
        
        public function adjustment_invoice () {
            
            $adjustment_id = $this -> uri -> segment ( 3 );
            if ( !isset( $adjustment_id ) or empty( trim ( $adjustment_id ) ) or !is_numeric ( $adjustment_id ) or $adjustment_id < 0 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sales' ] = $this -> MedicineModel -> get_all_adjustments ( $adjustment_id );
            $html_content    = $this -> load -> view ( '/invoices/adjustment_invoice', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Adjustments ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * ipd adjustments
         * -------------------------
         */
        
        public function ipd_general_report_cash () {
            
            $data[ 'sales' ] = $this -> IPDModel -> get_cash_sales_report ();
            $html_content    = $this -> load -> view ( '/invoices/ipd_general_report_cash', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5,
                                        'format'        => 'A4-L',
                                        'orientation'   => 'L'
                                    ] );
            $name = 'IPD General Report Cash ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * ipd adjustments
         * -------------------------
         */
        
        public function ipd_general_report_panel () {
            
            $data[ 'sales' ] = $this -> IPDModel -> get_panel_sales_report ();
            $html_content    = $this -> load -> view ( '/invoices/ipd_general_report_panel', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5,
                                        'format'        => 'A4-L',
                                        'orientation'   => 'L'
                                    ] );
            $name = 'IPD General Report Panel ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * print par level
         * -------------------------
         */
        
        public function print_par_level () {
            
            $department_id = $this -> uri -> segment ( 3 );
            if ( !isset( $department_id ) or empty( trim ( $department_id ) ) or !is_numeric ( $department_id ) or $department_id < 0 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'levels' ] = $this -> StoreModel -> get_par_levels_by_department ( $department_id );
            $html_content     = $this -> load -> view ( '/invoices/print_par_level', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            $name = 'Par Level ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * store items
         * -------------------------
         */
        
        public function store_items () {
            
            $data[ 'stores' ] = $this -> StoreModel -> get_store ();
            $html_content     = $this -> load -> view ( '/invoices/store_items', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Store Items ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * store items
         * -------------------------
         */
        
        public function medicines () {
            
            $data[ 'medicines' ] = $this -> MedicineModel -> get_all_medicines ();
            $html_content        = $this -> load -> view ( '/invoices/medicines', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Medicines ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * store items
         * -------------------------
         */
        
        public function discharge_summary_invoice () {
            
            $summary_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $summary_id ) ) or !is_numeric ( $summary_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'emergency' ]       = $this -> IPDModel -> get_discharge_summary_by_id ( $summary_id );
            $data[ 'medication' ]      = $this -> IPDModel -> get_discharge_summary_medication ( $summary_id );
            $data[ 'medication_hosp' ] = $this -> IPDModel -> get_discharge_summary_medication_during_hosp ( $summary_id );
            $data[ 'services' ]        = $this -> IPDModel -> get_discharge_summary_services ( $summary_id );
            $html_content              = $this -> load -> view ( '/invoices/discharge_summary_invoice', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Discharge summary invoice ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * store items
         * -------------------------
         */
        
        public function admission_order_invoice () {
            
            $admission_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $admission_id ) ) or !is_numeric ( $admission_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'order' ]  = $this -> IPDModel -> get_mo_admission_order ( $admission_id );
            $data[ 'record' ] = $this -> IPDModel -> get_mo_order_record_by_id ( $admission_id );
            $html_content     = $this -> load -> view ( '/invoices/admission_order_invoice', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Admission order invoice ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * store items
         * -------------------------
         */
        
        public function store_stock_invoice () {
            
            $invoice_number = $_REQUEST[ 'invoice' ];
            if ( !isset( $invoice_number ) or empty( trim ( $invoice_number ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'stock_info' ] = $this -> StoreModel -> get_stock_info ( $invoice_number );
            $data[ 'stocks' ]     = $this -> StoreModel -> get_stock_by_invoice ( $invoice_number );
            $html_content         = $this -> load -> view ( '/invoices/store_stock_invoice', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Store stock invoice ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * store items
         * -------------------------
         */
        
        public function store_issuance_invoice () {
            
            $sale_id = $_REQUEST[ 'sale_id' ];
            if ( !isset( $sale_id ) or empty( trim ( $sale_id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sales' ] = $this -> StoreModel -> get_stock_sales_by_sale_id ( $sale_id );
            $html_content    = $this -> load -> view ( '/invoices/store_issuance_invoice', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 25,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Store issuance invoice ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * store items
         * -------------------------
         */
        
        public function patient_invoice () {
            
            $patient_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $patient_id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'patient' ] = get_patient ( $patient_id );
            $data[ 'user' ]    = get_user ( $data[ 'patient' ] -> user_id );
            $html_content      = $this -> load -> view ( '/invoices/patient_invoice', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Patient invoice ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * general report xray
         * -------------------------
         */
        
        public function general_report_xray () {
            
            $data[ 'sales' ] = $this -> ReportingModel -> get_xray_reporting ();
            $data[ 'user' ]  = get_logged_in_user ();
            $html_content    = $this -> load -> view ( '/invoices/general_report_xray', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'General Report XRay ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * general report ultrasound
         * -------------------------
         */
        
        public function general_report_ultrasound () {
            
            $data[ 'sales' ] = $this -> ReportingModel -> get_ultrasound_reporting ();
            $data[ 'user' ]  = get_logged_in_user ();
            $html_content    = $this -> load -> view ( '/invoices/general_report_ultrasound', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'General Report Ultrasound ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * employee report
         * -------------------------
         */
        
        public function employee () {
            
            $employee_id              = $this -> uri -> segment ( 3 );
            $data[ 'employee' ]       = $this -> HrModel -> get_employee_by_id ( $employee_id );
            $data[ 'bank' ]           = $this -> HrModel -> get_bank_by_id ( $employee_id );
            $data[ 'history' ]        = $this -> HrModel -> get_history_by_id ( $employee_id );
            $data[ 'family_details' ] = $this -> HrModel -> get_family_details_by_id ( $employee_id );
            $data[ 'children' ]       = $this -> HrModel -> get_employee_children ( $employee_id );
            $html_content             = $this -> load -> view ( '/invoices/employee', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 30,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Employee ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets general invoice
         * of sales
         * ---------------------
         */
        
        public function print_salary_sheet () {
            $salary_id        = $this -> uri -> segment ( 3 );
            $data[ 'sheets' ] = $this -> HrModel -> get_sheet_by_salary_id ( $salary_id );
            $html_content     = $this -> load -> view ( '/invoices/print_salary_sheet', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            $name = 'Salary Sheet ' . time () . '.pdf';
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText    = false;
            $mpdf -> watermark_font       = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha   = 0.1;
            $mpdf -> shrink_tables_to_fit = 1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets general invoice
         * of sales
         * ---------------------
         */
        
        public function loan () {
            $loan_id        = $this -> uri -> segment ( 3 );
            $data[ 'loan' ] = $this -> LoanModel -> get_loan_by_id ( $loan_id );
            $html_content   = $this -> load -> view ( '/invoices/loan', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Loan ' . time () . '.pdf';
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText    = false;
            $mpdf -> watermark_font       = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha   = 0.1;
            $mpdf -> shrink_tables_to_fit = 1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets general invoice
         * of sales
         * ---------------------
         */
        
        public function loans () {
            $data[ 'loans' ] = $this -> LoanModel -> get_loans_employee_wise ();
            $html_content    = $this -> load -> view ( '/invoices/loans', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            $name = 'Loans ' . time () . '.pdf';
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText    = false;
            $mpdf -> watermark_font       = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha   = 0.1;
            $mpdf -> shrink_tables_to_fit = 1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets general invoice
         * of sales
         * ---------------------
         */
        
        public function salary_slips () {
            
            if ( !isset( $_REQUEST[ 'salary_slip' ] ) or empty( trim ( $_REQUEST[ 'salary_slip' ] ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $salary_slip = $_REQUEST[ 'salary_slip' ];
            
            $data[ 'slips' ] = $this -> HrModel -> get_sheet_by_salary_id ( $salary_slip );
            $html_content    = $this -> load -> view ( '/invoices/salary-slips', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Salary Slips ' . time () . '.pdf';
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText    = false;
            $mpdf -> watermark_font       = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha   = 0.1;
            $mpdf -> shrink_tables_to_fit = 1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * gets general invoice
         * of sales
         * ---------------------
         */
        
        public function employee_loans () {
            
            if ( !isset( $_REQUEST[ 'employee_id' ] ) or empty( trim ( $_REQUEST[ 'employee_id' ] ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $employee_id = $_REQUEST[ 'employee_id' ];
            
            $data[ 'loans' ] = $this -> LoanModel -> get_loans_by_employee ( $employee_id );
            $html_content    = $this -> load -> view ( '/invoices/employee-loan-details', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            $name = 'Employee loan details ' . time () . '.pdf';
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText    = false;
            $mpdf -> watermark_font       = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha   = 0.1;
            $mpdf -> shrink_tables_to_fit = 1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * Analysis report
         * display invoice wise report
         * ---------------------
         */
        
        public function ipd_customer_invoice () {
            
            $sale_id = $_REQUEST[ 'sale_id' ];
            if ( !isset( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'total_ipd_services' ] = $this -> IPDModel -> total_ipd_services ( $sale_id );
            $data[ 'total_opd_services' ] = $this -> IPDModel -> total_opd_services ( $sale_id );
            $data[ 'total_lab_services' ] = $this -> IPDModel -> total_lab_services ( $sale_id );
            $data[ 'total_medication' ]   = $this -> IPDModel -> total_medication ( $sale_id );
            
            $data[ 'sale' ]          = $this -> IPDModel -> get_sale_info ( $sale_id );
            $data[ 'patient' ]       = get_patient ( $data[ 'sale' ] -> patient_id );
            $data[ 'patient_id' ]    = $data[ 'sale' ] -> patient_id;
            $data[ 'sale_id' ]       = $sale_id;
            $data[ 'user' ]          = get_user ( $data[ 'sale' ] -> discharged_by );
            $data[ 'sale_billing' ]  = $this -> IPDModel -> get_sale_billing_info ( $sale_id );
            $data[ 'count_payment' ] = $this -> IPDModel -> count_payment ( $sale_id );
            $data[ 'consultants' ]   = $this -> IPDModel -> get_consultants ( $sale_id );
            
            
            $html_content = $this -> load -> view ( '/invoices/ipd_customer_invoice', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'IPD Customer Invoice' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * return customer invoice
         * ---------------------
         */
        
        public function return_customer_invoice () {
            
            $invoice = $this -> uri -> segment ( 3 );
            if ( !isset( $invoice ) or empty( trim ( $invoice ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'invoice' ] = $invoice;
            $data[ 'stocks' ]  = $this -> MedicineModel -> get_stock_by_invoice ( $invoice );
            
            $html_content = $this -> load -> view ( '/invoices/return_customer_invoice', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Return Customer Invoice' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * return customer invoice
         * ---------------------
         */
        
        public function trial_balance_sheet () {
            
            $account_heads                 = $this -> AccountModel -> get_trial_balance_sheet ( local_purchase );
            $tree                          = buildTree ( $account_heads );
            $data[ 'balance_sheet' ]       = $this -> AccountModel -> build_table ( $tree );
            $data[ 'balance_sheet_total' ] = $this -> AccountModel -> trial_balance_total ();
            $html_content                  = $this -> load -> view ( '/invoices/trial_balance_sheet', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Trial Balance Sheet' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * return customer invoice
         * ---------------------
         */
        
        public function balance_sheet () {
            
            $data[ 'user' ]                            = get_logged_in_user_id ();
            $data[ 'cash_balances' ]                   = $this -> AccountModel -> filter_balance_sheet ( cash_balances );
            $data[ 'banks' ]                           = $this -> AccountModel -> filter_balance_sheet ( banks );
            $data[ 'receivable_accounts' ]             = $this -> AccountModel -> filter_balance_sheet ( receivable_accounts );
            $data[ 'inventory' ]                       = $this -> AccountModel -> filter_balance_sheet ( inventory );
            $data[ 'furniture_fixture' ]               = $this -> AccountModel -> filter_balance_sheet ( furniture_fixture );
            $data[ 'intangible_assets' ]               = $this -> AccountModel -> filter_balance_sheet ( intangible_assets );
            $data[ 'bio_medical_surgical_items' ]      = $this -> AccountModel -> filter_balance_sheet ( bio_medical_surgical_items );
            $data[ 'machinery_equipment' ]             = $this -> AccountModel -> filter_balance_sheet ( machinery_equipment );
            $data[ 'electrical_equipment' ]            = $this -> AccountModel -> filter_balance_sheet ( electrical_equipment );
            $data[ 'it_equipment' ]                    = $this -> AccountModel -> filter_balance_sheet ( it_equipment );
            $data[ 'office_equipment' ]                = $this -> AccountModel -> filter_balance_sheet ( office_equipment );
            $data[ 'land_building' ]                   = $this -> AccountModel -> filter_balance_sheet ( land_building );
            $data[ 'accumulated_depreciation' ]        = $this -> AccountModel -> filter_balance_sheet ( accumulated_depreciation );
            $data[ 'payable_accounts' ]                = $this -> AccountModel -> filter_balance_sheet ( payable_accounts );
            $data[ 'accrued_expenses' ]                = $this -> AccountModel -> filter_balance_sheet ( accrued_expenses );
            $data[ 'unearned_revenue' ]                = $this -> AccountModel -> filter_balance_sheet ( unearned_revenue );
            $data[ 'WHT_payable' ]                     = $this -> AccountModel -> filter_balance_sheet ( WHT_payable );
            $data[ 'long_term_debt' ]                  = $this -> AccountModel -> filter_balance_sheet ( long_term_debt );
            $data[ 'other_long_term_liabilities' ]     = $this -> AccountModel -> filter_balance_sheet ( other_long_term_liabilities );
            $data[ 'capital' ]                         = $this -> AccountModel -> filter_balance_sheet ( capital );
            $data[ 'total_accumulative_depreciation' ] = $this -> StoreModel -> calculate_total_accumulative_depreciation ( $this -> input -> get ( 'trans_date' ) );
            
            // to calculate net profit
            if ( isset( $_REQUEST[ 'trans_date' ] ) and !empty( trim ( $_REQUEST[ 'trans_date' ] ) ) )
                $data[ 'calculate_net_profit' ] = $this -> AccountModel -> balance_sheet_net_profit ();
            else
                $data[ 'calculate_net_profit' ] = 0;
            
            $html_content = $this -> load -> view ( '/invoices/balance_sheet', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 15,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Balance Sheet' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function balance_sheets () {
            
            $data[ 'user' ]                            = get_logged_in_user_id ();
            $data[ 'currentAssets' ]                   = $this -> AccountModel -> get_balance_sheet_account_heads ( 'current-assets' );
            $data[ 'nonCurrentAssets' ]                = $this -> AccountModel -> get_balance_sheet_account_heads ( 'non-current-assets' );
            $data[ 'currentLiabilities' ]              = $this -> AccountModel -> get_balance_sheet_account_heads ( 'current-liabilities' );
            $data[ 'accumulated_depreciation' ]        = $this -> AccountModel -> filter_balance_sheet ( accumulated_depreciation );
            $data[ 'payable_accounts' ]                = $this -> AccountModel -> filter_balance_sheet ( payable_accounts );
            $data[ 'accrued_expenses' ]                = $this -> AccountModel -> filter_balance_sheet ( accrued_expenses );
            $data[ 'unearned_revenue' ]                = $this -> AccountModel -> filter_balance_sheet ( unearned_revenue );
            $data[ 'WHT_payable' ]                     = $this -> AccountModel -> filter_balance_sheet ( WHT_payable );
            $data[ 'long_term_debt' ]                  = $this -> AccountModel -> filter_balance_sheet ( long_term_debt );
            $data[ 'other_long_term_liabilities' ]     = $this -> AccountModel -> filter_balance_sheet ( other_long_term_liabilities );
            $data[ 'capital' ]                         = $this -> AccountModel -> filter_balance_sheet ( capital );
            $data[ 'total_accumulative_depreciation' ] = $this -> StoreModel -> calculate_total_accumulative_depreciation ( $this -> input -> get ( 'trans_date' ) );
            $data[ 'other_incomes' ]                   = $this -> AccountModel -> get_specific_account_heads ( OTHER_INCOME );
            
            // to calculate net profit
            if ( isset( $_REQUEST[ 'trans_date' ] ) and !empty( trim ( $_REQUEST[ 'trans_date' ] ) ) )
                $data[ 'calculate_net_profit' ] = $this -> AccountModel -> balance_sheet_net_profit ();
            else
                $data[ 'calculate_net_profit' ] = 0;
            
            $html_content = $this -> load -> view ( '/invoices/balance_sheets', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 15,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Balance Sheet' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * profit loss statement
         * ---------------------
         */
        
        public function profit_loss_statement () {
            
            $data[ 'sales_account_head' ]              = $this -> AccountModel -> get_specific_account_heads ( sales_id );
            $data[ 'returns_allowances_account_head' ] = get_account_head ( Returns_and_Allowances );
            $data[ 'fee_discounts_account_head' ]      = $this -> AccountModel -> get_specific_account_heads ( Fee_Discounts );
            $data[ 'Direct_Costs_account_head' ]       = $this -> AccountModel -> get_specific_account_heads ( Direct_Costs );
            $data[ 'expenses_account_head' ]           = $this -> AccountModel -> get_specific_account_heads ( expense_id );
            $data[ 'other_incomes' ]                   = $this -> AccountModel -> get_specific_account_heads ( OTHER_INCOME );
            $data[ 'total_accumulative_depreciation' ] = $this -> StoreModel -> calculate_total_accumulative_depreciation ( $this -> input -> get ( 'end_date' ) );
            $data[ 'Finance_Cost_account_head' ]       = get_account_head ( Finance_Cost );
            $data[ 'Tax_account_head' ]                = get_account_head ( Tax );
            $this -> load -> view ( '/accounts/profit-loss-statement', $data );
            
            $html_content = $this -> load -> view ( '/invoices/profit_loss_statement', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Profit Loss Statement' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print test result invoice
         * ---------------------
         */
        
        public function ipd_test_result_invoice () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]    = $sale_id;
            $data[ 'patient_id' ] = get_ipd_patient_id_by_sale_id ( $sale_id );
            $data[ 'patient' ]    = get_patient ( $data[ 'patient_id' ] );
            $data[ 'user' ]       = get_user ( get_logged_in_user_id () );
            $data[ 'tests' ]      = $this -> IPDModel -> get_lab_results_by_sale_id ( $sale_id );
            $html_content         = $this -> load -> view ( '/invoices/lab-result-invoice', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'IPD-Lab-test-result.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print test result invoice
         * ---------------------
         */
        
        public function print_lab_single_invoice () {
            $id      = $this -> input -> get ( 'id', true );
            $sale_id = $this -> input -> get ( 'sale-id', true );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]               = $sale_id;
            $data[ 'patient_id' ]            = get_ipd_patient_id_by_sale_id ( $sale_id );
            $data[ 'patient' ]               = get_patient ( $data[ 'patient_id' ] );
            $data[ 'user' ]                  = get_user ( get_logged_in_user_id () );
            $data[ 'tests' ]                 = $this -> IPDModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
            $data[ 'previous_test_results' ] = get_ipd_previous_test_results ( $sale_id, @$_REQUEST[ 'parent-id' ] );
            
            $html_content = $this -> load -> view ( '/invoices/lab-result-invoice', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 38,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'IPD-Lab-test-result.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print test result invoice
         * ---------------------
         */
        
        public function print_lab_single_invoice_lab () {
            
            if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
                $link = "https";
            else $link = "http";
            
            // Here append the common URL characters.
            $link .= "://";
            
            // Append the host(domain name, ip) to the URL.
            $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];
            
            if ( strpos ( $link, ',qrcode=true' ) !== false ) {
                return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
            }
            
            $id      = $this -> input -> get ( 'id', true );
            $sale_id = $this -> input -> get ( 'sale-id', true );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]               = $sale_id;
            $data[ 'patient_id' ]            = get_patient_id_by_sale_id ( $sale_id );
            $data[ 'patient' ]               = get_patient ( $data[ 'patient_id' ] );
            $data[ 'user' ]                  = get_user ( get_logged_in_user_id () );
            $data[ 'sale' ]                  = $this -> LabModel -> get_lab_sale ( $sale_id );
            $data[ 'tests' ]                 = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
            $data[ 'previous_test_results' ] = get_previous_test_results ( $sale_id, @$_REQUEST[ 'parent-id' ] );
            $data[ 'remarks' ]               = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
            $data[ 'airline' ]               = $this -> LabModel -> get_airline_details ( $sale_id );
            $data[ 'online_report_info' ]    = $this -> LabModel -> online_test_invoice ( $sale_id );
            $data[ 'test_result_image' ]     = $this -> LabModel -> get_test_result_image ( $sale_id, $_REQUEST[ 'parent-id' ] );
            $html_content                    = $this -> load -> view ( '/invoices/lab-result-invoice-lab', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 41,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'IPD-Lab-test-result.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print test result invoice
         * ---------------------
         */
        
        public function cp_peripheral_film_report () {
            
            if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
                $link = "https";
            else $link = "http";
            
            // Here append the common URL characters.
            $link .= "://";
            
            // Append the host(domain name, ip) to the URL.
            $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];
            
            if ( strpos ( $link, ',qrcode=true' ) !== false ) {
                return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
            }
            
            $id      = $this -> input -> get ( 'id', true );
            $sale_id = $this -> input -> get ( 'sale-id', true );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]            = $sale_id;
            $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
            $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
            $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
            $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
            $data[ 'tests' ]              = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
            $data[ 'remarks' ]            = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
            $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
            $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
            $html_content                 = $this -> load -> view ( '/invoices/cp-peripheral-film-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 25,
                                        'margin_header' => 0,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'CP-Peripheral-Film-Report.pdf', 'I' );
        }
        
        public function ipd_single_service_invoice () {
            $id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ] = $id;
            $data[ 'user' ]    = get_user ( get_logged_in_user_id () );
            $data[ 'sale' ]    = $this -> IPDModel -> get_ipd_patient_ipd_service_by_id ( $id );
            $html_content      = $this -> load -> view ( '/invoices/ipd-single-service-invoice', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'IPD sale service invoice.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print adjustments invoice
         * ---------------------
         */
        
        public function adjustments () {
            
            if ( isset( $_REQUEST[ 'per_page' ] ) and $_REQUEST[ 'per_page' ] > 0 ) {
                $offset = $_REQUEST[ 'per_page' ];
            }
            else {
                $offset = 0;
            }
            $data[ 'user' ]  = get_user ( get_logged_in_user_id () );
            $data[ 'sales' ] = $this -> MedicineModel -> get_adjustments ( 50, $offset );
            
            $html_content = $this -> load -> view ( '/invoices/adjustments-invoice', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Adjustments invoice.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print store threshold invoice
         * ---------------------
         */
        
        public function store_threshold_report () {
            $data[ 'user' ]   = get_user ( get_logged_in_user_id () );
            $data[ 'stores' ] = $this -> StoreModel -> get_store ();
            $html_content     = $this -> load -> view ( '/invoices/store-threshold-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Store threshold report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print panel details
         * ---------------------
         */
        
        public function print_panel () {
            
            if ( isset( $_GET[ 'id' ] ) and is_numeric ( $_GET[ 'id' ] ) and $_GET[ 'id' ] > 0 )
                $panel_id = $_GET[ 'id' ];
            else
                return redirect ( base_url ( '/' ) );
            
            $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
            $data[ 'members' ]            = $this -> MemberModel -> get_members ();
            $data[ 'panel' ]              = $this -> PanelModel -> get_panel_by_id ( $panel_id );
            $data[ 'services' ]           = $this -> IPDModel -> get_all_services ();
            $data[ 'ipd_services' ]       = $this -> PanelModel -> get_panel_ipd_services ( $panel_id );
            $data[ 'doctors' ]            = $this -> DoctorModel -> get_doctors ();
            $data[ 'panel_doctors' ]      = $this -> PanelModel -> get_panel_doctors ( $panel_id );
            $data[ 'opd_services' ]       = $this -> OPDModel -> get_all_services ();
            $data[ 'added_opd_services' ] = $this -> PanelModel -> get_panel_opd_services ( $panel_id );
            $data[ 'companies' ]          = $this -> PanelModel -> get_panel_companies ( $panel_id );
            $data[ 'panel_tests' ]        = $this -> PanelModel -> get_panel_lab_tests ( $panel_id );
            $html_content                 = $this -> load -> view ( '/invoices/print-panel-details', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Panel details.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do discharge slip
         * ---------------------
         */
        
        public function print_discharge_slip () {
            
            if ( !isset( $_GET[ 'id' ] ) or !is_numeric ( $_GET[ 'id' ] ) or !$_GET[ 'id' ] < 0 )
                return redirect ( base_url ( '/' ) );
            
            $id                = $_GET[ 'id' ];
            $data[ 'user' ]    = get_user ( get_logged_in_user_id () );
            $data[ 'slip' ]    = $this -> IPDModel -> get_discharge_slip_by_id ( $id );
            $data[ 'patient' ] = get_patient_by_id ( $data[ 'slip' ] -> patient_id );
            $html_content      = $this -> load -> view ( '/invoices/print-discharge-slip', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Discharge Slip.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do consultant commission slip
         * ---------------------
         */
        
        public function consultant_commission () {
            
            $data[ 'user' ]  = get_user ( get_logged_in_user_id () );
            $data[ 'sales' ] = $this -> IPDModel -> get_consultant_commission ();
            $html_content    = $this -> load -> view ( '/invoices/consultant-commission', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Consultant Commission.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * ot timings receipt
         * ---------------------
         */
        
        public function ot_timings () {
            $data[ 'user' ]    = get_user ( get_logged_in_user_id () );
            $data[ 'timings' ] = $this -> IPDModel -> get_ot_timings_by_filter ();
            $data[ 'patient' ] = get_patient ( $data[ 'timings' ] -> patient_id );
            $html_content      = $this -> load -> view ( '/invoices/ot-timings', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'OT Timings.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * ot timings receipt
         * ---------------------
         */
        
        public function birth_certificate () {
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !is_numeric ( decode ( $id ) ) or decode ( $id ) < 1 )
                return redirect ( base_url ( '/birth-certificates/index' ) );
            
            $data[ 'user' ]        = get_user ( get_logged_in_user_id () );
            $data[ 'certificate' ] = $this -> BirthCertificateModel -> get_certificate_by_id ( decode ( $id ) );
            $html_content          = $this -> load -> view ( '/invoices/birth-certificate', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Birth Certificate.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * bed status receipt
         * ---------------------
         */
        
        public function bed_reporting () {
            $data[ 'user' ] = get_user ( get_logged_in_user_id () );
            $data[ 'beds' ] = $this -> RoomModel -> get_beds ();
            $html_content   = $this -> load -> view ( '/invoices/bed-status-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Bed Status Report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * test prices report
         * ---------------------
         */
        
        public function test_prices_report () {
            $data[ 'user' ]    = get_user ( get_logged_in_user_id () );
            $data[ 'reports' ] = $this -> ReportingModel -> get_test_prices_report ();
            $html_content      = $this -> load -> view ( '/invoices/test-prices-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Test Prices Report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * doctors list
         * ---------------------
         */
        
        public function doctors () {
            $data[ 'user' ]            = get_user ( get_logged_in_user_id () );
            $data[ 'specializations' ] = $this -> DoctorModel -> get_doctor_specializations ();
            $html_content              = $this -> load -> view ( '/invoices/doctors', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 25,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Doctors List.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * opd services list
         * ---------------------
         */
        
        public function opd_services () {
            $data[ 'user' ]     = get_user ( get_logged_in_user_id () );
            $data[ 'services' ] = $this -> OPDModel -> get_parent_services ();
            $html_content       = $this -> load -> view ( '/invoices/opd-services', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 45,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'OPD Services List.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * referred by report
         * ---------------------
         */
        
        public function referred_by_report () {
            $data[ 'user' ]    = get_user ( get_logged_in_user_id () );
            $data[ 'reports' ] = $this -> ReportingModel -> get_referred_by_report ();
            $html_content      = $this -> load -> view ( '/invoices/referred-by-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Referred By Report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * expanses report
         * ---------------------
         */
        
        public function expanse_report () {
            $data[ 'user' ]     = get_user ( get_logged_in_user_id () );
            $accounts1          = $this -> AccountModel -> get_account_heads_by_id ( GENERAL_ADMINISTRATIVE_EXPENSES );
            $accounts2          = get_general_and_administrative_expenses_data ( GENERAL_ADMINISTRATIVE_EXPENSES );
            $data[ 'accounts' ] = array_merge ( $accounts1, $accounts2 );
            $html_content       = $this -> load -> view ( '/invoices/expanse-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 38,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Expanse Report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * print all test results report
         * ---------------------
         */
        
        public function test_results_report () {
            $sale_id = $this -> input -> get ( 'sale-id', true );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]            = $sale_id;
            $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
            $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
            $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
            $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
            $data[ 'tests' ]              = $this -> LabModel -> get_lab_results_by_sale_id ( $sale_id );
            $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
            $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
            $html_content                 = $this -> load -> view ( '/invoices/test-results-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 25,
                                        'margin_header' => 0,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Test-results-report' . rand () . '.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * culture report
         * ---------------------
         */
        
        public function culture_report () {
            
            if ( !isset( $_REQUEST[ 'report-id' ] ) or !is_numeric ( $_REQUEST[ 'report-id' ] ) or $_REQUEST[ 'report-id' ] < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $report_id             = $_REQUEST[ 'report-id' ];
            $data[ 'report' ]      = $this -> CultureModel -> get_report_by_id ( $report_id );
            $data[ 'antibiotics' ] = $this -> CultureModel -> get_added_antibiotics ( $report_id );
            $data[ 'lab' ]         = get_lab_sale ( $data[ 'report' ] -> sale_id );
            $html_content          = $this -> load -> view ( '/invoices/culture-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 41,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Culture-Report-' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            
            $status = get_report_verify_status ( $report_id, 'hmis_culture' );
            if ( empty( $status ) ) {
                $mpdf -> SetWatermarkText ( 'Unverified' );
                $mpdf -> showWatermarkText  = true;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
            }
            else {
                $mpdf -> SetWatermarkText ( site_name );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
            }
            
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * histopathology report
         * ---------------------
         */
        
        public function histopathology_report () {
            
            if ( !isset( $_REQUEST[ 'report-id' ] ) or !is_numeric ( $_REQUEST[ 'report-id' ] ) or $_REQUEST[ 'report-id' ] < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $report_id        = $_REQUEST[ 'report-id' ];
            $data[ 'report' ] = $this -> HistopathologyModel -> get_report_by_id ( $report_id );
            $data[ 'lab' ]    = get_lab_sale ( $data[ 'report' ] -> sale_id );
            $html_content     = $this -> load -> view ( '/invoices/histopathology-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 41,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Histopathology-Report-' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            
            $status = get_report_verify_status ( $report_id, 'hmis_histopathology' );
            if ( empty( $status ) ) {
                $mpdf -> SetWatermarkText ( 'Unverified' );
                $mpdf -> showWatermarkText  = true;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
            }
            else {
                $mpdf -> SetWatermarkText ( site_name );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
            }
            
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * general report culture
         * -------------------------
         */
        
        public function general_report_culture () {
            
            $data[ 'sales' ] = $this -> ReportingModel -> get_culture_reporting ();
            $html_content    = $this -> load -> view ( '/invoices/general_report_culture', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'General Report Culture ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * general report culture
         * -------------------------
         */
        
        public function general_report_histopathology () {
            
            $data[ 'sales' ] = $this -> ReportingModel -> get_histopathology_reporting ();
            $html_content    = $this -> load -> view ( '/invoices/general_report_histopathology', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'General Report Histopathology ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * ct scan report
         * ---------------------
         */
        
        public function ct_scan_report () {
            
            if ( !isset( $_REQUEST[ 'report-id' ] ) or !is_numeric ( $_REQUEST[ 'report-id' ] ) or $_REQUEST[ 'report-id' ] < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $report_id        = $_REQUEST[ 'report-id' ];
            $data[ 'report' ] = $this -> RadiologyModel -> get_ct_scan_report_by_id ( $report_id );
            $data[ 'user' ]   = get_logged_in_user ();
            $html_content     = $this -> load -> view ( '/invoices/ct-scan-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 41,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'CT-Scan Report ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            
            $status = get_report_verify_status ( $report_id, 'hmis_ct_scan' );
            if ( empty( $status ) ) {
                $mpdf -> SetWatermarkText ( 'Unverified' );
                $mpdf -> showWatermarkText  = true;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
            }
            else {
                $mpdf -> SetWatermarkText ( site_name );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
            }
            
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * mri report
         * ---------------------
         */
        
        public function mri_report () {
            
            if ( !isset( $_REQUEST[ 'report-id' ] ) or !is_numeric ( $_REQUEST[ 'report-id' ] ) or $_REQUEST[ 'report-id' ] < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $report_id        = $_REQUEST[ 'report-id' ];
            $data[ 'report' ] = $this -> RadiologyModel -> get_mri_report_by_id ( $report_id );
            $data[ 'user' ]   = get_logged_in_user ();
            $html_content     = $this -> load -> view ( '/invoices/mri-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 41,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'MRI Report ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            
            $status = get_report_verify_status ( $report_id, 'hmis_mri' );
            if ( empty( $status ) ) {
                $mpdf -> SetWatermarkText ( 'Unverified' );
                $mpdf -> showWatermarkText  = true;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
            }
            else {
                $mpdf -> SetWatermarkText ( site_name );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
            }
            
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * ipd services list
         * ---------------------
         */
        
        public function ipd_services () {
            $data[ 'user' ]     = get_user ( get_logged_in_user_id () );
            $data[ 'services' ] = $this -> IPDModel -> get_parent_services ();
            $html_content       = $this -> load -> view ( '/invoices/ipd-services', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'IPD Services List.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * @throws \Mpdf\MpdfException
         * custom semen analysis report
         * ---------------------
         */
        
        public function semen_analysis_report () {
            
            if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
                $link = "https";
            else $link = "http";
            
            // Here append the common URL characters.
            $link .= "://";
            
            // Append the host(domain name, ip) to the URL.
            $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];
            
            if ( strpos ( $link, ',qrcode=true' ) !== false ) {
                return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
            }
            
            $id      = $this -> input -> get ( 'id', true );
            $sale_id = $this -> input -> get ( 'sale-id', true );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]            = $sale_id;
            $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
            $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
            $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
            $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
            $data[ 'tests' ]              = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
            $data[ 'remarks' ]            = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
            $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
            $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
            $html_content                 = $this -> load -> view ( '/invoices/semen-analysis-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 25,
                                        'margin_header' => 0,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Semen-Analysis-Report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * @throws \Mpdf\MpdfException
         * custom stool examination report
         * ---------------------
         */
        
        public function stool_examination_report () {
            
            if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
                $link = "https";
            else $link = "http";
            
            // Here append the common URL characters.
            $link .= "://";
            
            // Append the host(domain name, ip) to the URL.
            $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];
            
            if ( strpos ( $link, ',qrcode=true' ) !== false ) {
                return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
            }
            
            $id      = $this -> input -> get ( 'id', true );
            $sale_id = $this -> input -> get ( 'sale-id', true );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]            = $sale_id;
            $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
            $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
            $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
            $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
            $data[ 'tests' ]              = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
            $data[ 'remarks' ]            = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
            $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
            $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
            $html_content                 = $this -> load -> view ( '/invoices/stool-examination-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 25,
                                        'margin_header' => 0,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Stool-Examination-Report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * @throws \Mpdf\MpdfException
         * custom urine re analysis report
         * ---------------------
         */
        
        public function urine_re_analysis_report () {
            
            if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
                $link = "https";
            else $link = "http";
            
            // Here append the common URL characters.
            $link .= "://";
            
            // Append the host(domain name, ip) to the URL.
            $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];
            
            if ( strpos ( $link, ',qrcode=true' ) !== false ) {
                return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
            }
            
            $id      = $this -> input -> get ( 'id', true );
            $sale_id = $this -> input -> get ( 'sale-id', true );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]            = $sale_id;
            $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
            $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
            $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
            $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
            $data[ 'tests' ]              = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
            $data[ 'remarks' ]            = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
            $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
            $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
            $html_content                 = $this -> load -> view ( '/invoices/urine-re-analysis-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 25,
                                        'margin_header' => 0,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Urine-RE-Analysis-Report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * @throws \Mpdf\MpdfException
         * custom csf analysis report
         * ---------------------
         */
        
        public function csf_analysis_report () {
            
            if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
                $link = "https";
            else $link = "http";
            
            // Here append the common URL characters.
            $link .= "://";
            
            // Append the host(domain name, ip) to the URL.
            $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];
            
            if ( strpos ( $link, ',qrcode=true' ) !== false ) {
                return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
            }
            
            $id      = $this -> input -> get ( 'id', true );
            $sale_id = $this -> input -> get ( 'sale-id', true );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]            = $sale_id;
            $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
            $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
            $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
            $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
            $data[ 'tests' ]              = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
            $data[ 'remarks' ]            = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
            $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
            $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
            $html_content                 = $this -> load -> view ( '/invoices/csf-analysis-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 25,
                                        'margin_header' => 0,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'CSF-Analysis-Report.pdf', 'I' );
        }
        
        /**
         * ---------------------
         * @throws \Mpdf\MpdfException
         * custom ascitic fluid analysis report
         * ---------------------
         */
        
        public function ascitic_fluid_analysis () {
            
            if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
                $link = "https";
            else $link = "http";
            
            // Here append the common URL characters.
            $link .= "://";
            
            // Append the host(domain name, ip) to the URL.
            $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];
            
            if ( strpos ( $link, ',qrcode=true' ) !== false ) {
                return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
            }
            
            $id      = $this -> input -> get ( 'id', true );
            $sale_id = $this -> input -> get ( 'sale-id', true );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]            = $sale_id;
            $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
            $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
            $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
            $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
            $data[ 'tests' ]              = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
            $data[ 'remarks' ]            = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
            $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
            $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
            $html_content                 = $this -> load -> view ( '/invoices/ascitic-fluid-analysis-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 25,
                                        'margin_header' => 0,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Ascitic-Fluid-Analysis.pdf', 'I' );
        }
        
        public function pericardial_fluid_report () {
            
            if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
                $link = "https";
            else $link = "http";
            
            // Here append the common URL characters.
            $link .= "://";
            
            // Append the host(domain name, ip) to the URL.
            $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];
            
            if ( strpos ( $link, ',qrcode=true' ) !== false ) {
                return redirect ( str_replace ( ',', '&', str_replace ( ',qrcode=true', '', $link ) ) );
            }
            
            $id      = $this -> input -> get ( 'id', true );
            $sale_id = $this -> input -> get ( 'sale-id', true );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 or empty( trim ( $id ) ) or !is_numeric ( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]            = $sale_id;
            $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
            $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
            $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
            $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
            $data[ 'tests' ]              = $this -> LabModel -> get_lab_results_by_sale_id_result_id ( $sale_id, $id );
            $data[ 'remarks' ]            = $this -> LabModel -> get_test_remarks ( $sale_id, @$_REQUEST[ 'parent-id' ] );
            $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
            $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
            $html_content                 = $this -> load -> view ( '/invoices/pericardial-fluid-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 25,
                                        'margin_header' => 0,
                                        'margin_footer' => 10
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Pericardial-Fluid-Report.pdf', 'I' );
        }
        
        public function complete_results_report () {
            $sale_id = $this -> input -> get ( 'sale-id', true );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]            = $sale_id;
            $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
            $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
            $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
            $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
            $data[ 'tests' ]              = $this -> LabModel -> get_lab_sale_parent_tests_by_sale_id ( $sale_id );
            $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
            $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
            $html_content                 = $this -> load -> view ( '/invoices/complete-results-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 41,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Test-results-report' . rand () . '.pdf', 'I' );
        }
        
        public function complete_tests_results_report () {
            $sale_id = $this -> input -> get ( 'sale-id', true );
            if ( empty( trim ( $sale_id ) ) or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sale_id' ]            = $sale_id;
            $data[ 'patient_id' ]         = get_patient_id_by_sale_id ( $sale_id );
            $data[ 'patient' ]            = get_patient ( $data[ 'patient_id' ] );
            $data[ 'user' ]               = get_user ( get_logged_in_user_id () );
            $data[ 'sale' ]               = $this -> LabModel -> get_lab_sale ( $sale_id );
            $data[ 'tests' ]              = $this -> LabModel -> get_lab_sale_parent_tests_by_sale_id ( $sale_id );
            $data[ 'airline' ]            = $this -> LabModel -> get_airline_details ( $sale_id );
            $data[ 'online_report_info' ] = $this -> LabModel -> online_test_invoice ( $sale_id );
            $html_content                 = $this -> load -> view ( '/invoices/complete-tests-results-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 41,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Test-results-report' . rand () . '.pdf', 'I' );
        }
        
        public function package ( $id ) {
            $data[ 'user' ]     = get_user ( get_logged_in_user_id () );
            $data[ 'package' ]  = $this -> IPDModel -> get_package_by_id ( $id );
            $data[ 'services' ] = $this -> IPDModel -> get_package_all_services ( $id );
            $html_content       = $this -> load -> view ( '/invoices/package', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 38,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Package-' . $data[ 'package' ] -> title . '.pdf', 'I' );
        }
        
        public function discarded_medicines_report () {
            $data[ 'user' ]      = get_user ( get_logged_in_user_id () );
            $data[ 'medicines' ] = $this -> MedicineModel -> get_discarded_expired_medicines ();
            $html_content        = $this -> load -> view ( '/invoices/discarded-medicines-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Discarded-Medicines-List.pdf', 'I' );
        }
        
        public function store_general_report () {
            $data[ 'sales' ] = $this -> ReportingModel -> get_store_sales ();
            $html_content    = $this -> load -> view ( '/invoices/store-general-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Store general report.pdf', 'I' );
        }
        
        public function doctor_consultancy_report_summary () {
            $data[ 'doctors' ]        = $this -> DoctorModel -> get_consultancy_doctors ();
            $data[ 'filter_doctors' ] = $this -> DoctorModel -> get_doctors_consultancy_summary_report ();
            $data[ 'user' ]           = get_logged_in_user ();
            $html_content             = $this -> load -> view ( '/invoices/doctor_consultancy_report_summary', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Doctor consultancy report summary' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * bed status receipt
         * ---------------------
         */
        
        public function beds_status_report () {
            $data[ 'user' ]  = get_user ( get_logged_in_user_id () );
            $data[ 'rooms' ] = $this -> RoomModel -> get_beds_status_report ();
            $html_content    = $this -> load -> view ( '/invoices/beds-status-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = true;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Bed Status Report.pdf', 'I' );
        }
        
        public function store_fix_assets_report () {
            $data[ 'user' ]    = get_user ( get_logged_in_user_id () );
            $data[ 'reports' ] = $this -> StoreModel -> get_fix_assets_report ();
            $data[ 'filters' ] = $this -> StoreModel -> get_years_range_by_search ();
            $html_content      = $this -> load -> view ( '/invoices/store-fix-assets-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5,
                                        'format'        => 'A4-L',
                                        'orientation'   => 'L'
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = true;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Store Fix Assets Report.pdf', 'I' );
        }
        
        public function chart_of_accounts () {
            $data[ 'user' ]          = get_user ( get_logged_in_user_id () );
            $account_heads           = $this -> AccountModel -> get_chart_of_accounts ();
            $tree                    = buildTree ( $account_heads );
            $data[ 'account_heads' ] = $this -> AccountModel -> build_chart_of_accounts_table ( $tree, 0, true );
            $html_content            = $this -> load -> view ( '/invoices/chart-of-accounts-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 38,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = true;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Chart of Accounts Report.pdf', 'I' );
        }
        
        public function park_plaza () {
            $html_content = $this -> load -> view ( '/invoices/park-plaza', null, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 0,
                                        'margin_right'  => 0,
                                        'margin_top'    => 60,
                                        'margin_bottom' => 0,
                                        'margin_header' => 0,
                                        'margin_footer' => 0
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkImage ( base_url ( '/assets/MKW-Associates-1.png' ), 0.1, array ( 50, 20 ) );
            $mpdf -> showWatermarkImage = true;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Park Plaza Letter Head.pdf', 'I' );
        }
        
        public function park_plaza_terms_conditions () {
            $html_content = $this -> load -> view ( '/invoices/park-plaza-terms-conditions', null, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 2,
                                        'margin_right'  => 2,
                                        'margin_top'    => 2,
                                        'margin_bottom' => 2,
                                        'margin_header' => 0,
                                        'margin_footer' => 0
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkImage ( base_url ( '/assets/MKW-Associates-1.png' ), 0.1, array ( 50, 20 ) );
            $mpdf -> showWatermarkImage = true;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Terms & Conditions - Park Plaza 1.pdf', 'I' );
        }
        
        public function park_plaza_installments_unit_wise () {
            $html_content = $this -> load -> view ( '/invoices/park-plaza-installments-unit-wise', null, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 0,
                                        'margin_right'  => 0,
                                        'margin_top'    => 40,
                                        'margin_bottom' => 10,
                                        'margin_header' => 0,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkImage ( base_url ( '/assets/Park-view-black.jpg' ), 0.1, array ( 80, 80 ) );
            $mpdf -> showWatermarkImage = true;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Park Plaza - Installments Unit Wise.pdf', 'I' );
        }
        
        public function park_plaza_installments_space_wise () {
            $html_content = $this -> load -> view ( '/invoices/park-plaza-installments-space-wise', null, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 0,
                                        'margin_right'  => 0,
                                        'margin_top'    => 60,
                                        'margin_bottom' => 25,
                                        'margin_header' => 0,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkImage ( base_url ( '/assets/Park-view-black.jpg' ), 0.1, array ( 80, 80 ) );
            $mpdf -> showWatermarkImage = true;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Park Plaza - Installments Space Wise.pdf', 'I' );
        }
        
        public function park_plaza_letter_head () {
            $html_content = $this -> load -> view ( '/invoices/park-plaza-letter-head', null, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 0,
                                        'margin_right'  => 0,
                                        'margin_top'    => 50,
                                        'margin_bottom' => 10,
                                        'margin_header' => 0,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Park Plaza - Letter Head.pdf', 'I' );
        }
        
        public function patient_card ( $patient_id ) {
            $data[ 'patient' ] = $patient = get_patient_by_id ( $patient_id );
            $html_content      = $this -> load -> view ( '/invoices/patient-card', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 2,
                                        'margin_right'  => 2,
                                        'margin_top'    => 2,
                                        'margin_bottom' => 0,
                                        'margin_header' => 2,
                                        'margin_footer' => 0,
                                        'format'        => [ 86, 54 ]
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkImage ( base_url ( '/assets/img/logo-new.jpeg' ), 0.1, array ( 50, 40 ) );
            $mpdf -> showWatermarkImage = true;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( get_patient_name ( 0, $patient ) . ' - Card.pdf', 'I' );
        }
        
        public function ipd_summary_report () {
            $data[ 'user' ]   = get_user ( get_logged_in_user_id () );
            $data[ 'sales' ]  = $this -> IPDModel -> get_doctors_summary_report ();
            $data[ 'panels' ] = $this -> PanelModel -> get_active_panels ();
            $html_content     = $this -> load -> view ( '/invoices/ipd-summary-report', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 40,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5,
                                        'mode'          => 'utf-8',
                                        'format'        => 'A4-L'
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = true;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'IPD-Summary-Report.pdf', 'I' );
        }
        
        public function general_summary_report_cash () {
            $data[ 'consultancies' ]          = $this -> ConsultancyModel -> get_consultancies_total ();
            $data[ 'consultancies_refunded' ] = $this -> ConsultancyModel -> get_consultancies_total ( true );
            $data[ 'opd' ]                    = $this -> OPDModel -> get_opd_total ();
            $data[ 'opd_refunded' ]           = $this -> OPDModel -> get_opd_total ( true );
            $data[ 'lab' ]                    = $this -> LabModel -> get_lab_total ();
            $data[ 'lab_refunded' ]           = $this -> LabModel -> get_lab_total ( true );
            $data[ 'pharmacy' ]               = $this -> MedicineModel -> get_pharmacy_total ();
            $data[ 'pharmacy_refunded' ]      = $this -> MedicineModel -> get_pharmacy_total ( true );
            $data[ 'ipd_total' ]              = $this -> IPDModel -> get_ipd_total_report ();
            $data[ 'panels' ]                 = $this -> PanelModel -> get_panels ();
            $html_content                     = $this -> load -> view ( '/invoices/general-summary-report-cash', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 38,
                                        'margin_bottom' => 20,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'General summary report cash' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = true;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function accounts_receivable () {
            $account_heads         = $this -> AccountModel -> getRecursiveAccountHeads ( receivable_accounts );
            $data[ 'receivables' ] = displayRecursiveAccountHeads ( $account_heads );
            $html_content          = $this -> load -> view ( '/invoices/accounts-receivable', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 38,
                                        'margin_bottom' => 15,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Accounts receivable report' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = true;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function accounts_payable () {
            $account_heads     = $this -> AccountModel -> getRecursiveAccountHeads ( payable_accounts );
            $data[ 'payable' ] = displayRecursiveAccountHeads ( $account_heads, 0, 0, 1, true );
            $html_content      = $this -> load -> view ( '/invoices/accounts-payable', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 38,
                                        'margin_bottom' => 15,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Accounts payable report' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = true;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function general_ledgers () {
            $account_heads                 = $this -> AccountModel -> getRecursiveAccountHeads ( $this -> input -> get ( 'account-head' ) );
            $data[ 'parent_account_head' ] = $this -> AccountModel -> get_account_head_by_id ( $this -> input -> get ( 'account-head' ) );
            $account_head[]                = $this -> AccountModel -> get_account_head_by_id ( $this -> input -> get ( 'account-head' ) );
            $account_heads_list            = ( array_merge ( $account_head, $account_heads ) );
            $data[ 'ledgers' ]             = build_ledgers_table ( $account_heads_list );
            $html_content                  = $this -> load -> view ( '/invoices/general-ledgers', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'General Ledger ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function store_code_ticket ( $item_id ) {
            $data[ 'asset' ] = $this -> StoreModel -> get_fix_asset_by_id ( $item_id );
            $html_content    = $this -> load -> view ( '/invoices/store-code-ticket', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 2,
                                        'margin_right'  => 2,
                                        'margin_top'    => 2,
                                        'margin_bottom' => 0,
                                        'margin_header' => 2,
                                        'margin_footer' => 0,
                                        'format'        => [ 86, 15 ]
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $data[ 'asset' ] -> code . '.pdf', 'I' );
        }
        
        public function store_fix_assets_list () {
            $data[ 'assets' ] = $this -> StoreModel -> get_store_fix_assets ();
            $html_content     = $this -> load -> view ( '/invoices/store-fix-assets-list', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Store-Fix-Assets-List' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function disposed_store_fix_assets_list () {
            $data[ 'assets' ] = $this -> StoreModel -> get_disposed_store_fix_assets ();
            $html_content     = $this -> load -> view ( '/invoices/disposed-store-fix-assets-list', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Disposed-Store-Fix-Assets-List' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function employee_card ( $employee_id ) {
            $data[ 'employee' ] = $this -> HrModel -> get_employee_by_id ( $employee_id );
            $html_content       = $this -> load -> view ( '/invoices/employee-card', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 2,
                                        'margin_right'  => 2,
                                        'margin_top'    => 2,
                                        'margin_bottom' => 0,
                                        'margin_header' => 2,
                                        'margin_footer' => 0,
                                        'format'        => [ 86, 54 ]
                                    ] );
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkImage ( base_url ( '/assets/img/logo-new.jpeg' ), 0.1, array ( 50, 40 ) );
            $mpdf -> showWatermarkImage = true;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $data[ 'employee' ] -> name . ' - Card.pdf', 'I' );
        }
        
        public function general_report_ct_scan () {
            
            $data[ 'sales' ] = $this -> ReportingModel -> get_ct_scan_reporting ();
            $data[ 'user' ]  = get_logged_in_user ();
            $html_content    = $this -> load -> view ( '/invoices/general_report_ct_scan', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'General Report CT-Scan ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function general_report_mri () {
            
            $data[ 'sales' ] = $this -> ReportingModel -> get_ct_scan_reporting ();
            $data[ 'user' ]  = get_logged_in_user ();
            $html_content    = $this -> load -> view ( '/invoices/general_report_mri', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'General Report MRI ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function demand_requisition ( $requisition_id ) {
            
            $data[ 'requisitions' ] = $this -> RequisitionModel -> get_demand_requisitions_by_requisition_id ( $requisition_id );
            $data[ 'user' ]         = get_logged_in_user ();
            $html_content           = $this -> load -> view ( '/invoices/demand-requisitions', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Requisitions-' . $requisition_id . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function requisitions ( $requisition_id ) {
            
            $data[ 'requisitions' ] = $this -> RequisitionModel -> get_requisitions_by_requisition_id ( $requisition_id );
            $data[ 'user' ]         = get_logged_in_user ();
            $html_content           = $this -> load -> view ( '/invoices/requisitions', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Requisitions-' . $requisition_id . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function ipd_receivable_report () {
            $data[ 'sales' ] = $this -> IPDModel -> get_receivable_report ();
            $html_content    = $this -> load -> view ( '/invoices/ipd-receivable-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'IPD-Receivable-Report' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = true;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function claim_status_report () {
            $html_content = $this -> load -> view ( '/invoices/claim-status-report', null, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Claim-Status-Report-' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = true;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function claim_aging_report () {
            $data[ 'claims' ] = $this -> IPDModel -> claim_aging_report ();
            $html_content     = $this -> load -> view ( '/invoices/claim-aging-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            $name = 'Claim-Aging-Report-' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = true;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function death_certificate () {
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !is_numeric ( $id ) )
                return redirect ( base_url ( '/death-certificates/index' ) );
            
            $data[ 'user' ]        = get_user ( get_logged_in_user_id () );
            $data[ 'certificate' ] = $this -> DeathCertificateModel -> get_certificate_by_id ( $id );
            $data[ 'patient' ]     = get_patient ( $data[ 'certificate' ] -> patient_id );
            $html_content          = $this -> load -> view ( '/invoices/death-certificate', $data, true );
            
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5
                                    ] );
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( 'Death Certificate.pdf', 'I' );
        }
        
        public function cash_receiving_report () {
            $data[ 'payments' ] = $this -> IPDModel -> cash_receiving_report ();
            $html_content       = $this -> load -> view ( '/invoices/cash-receiving-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5,
                                    ] );
            $name = 'Cash Receiving Report-' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function cash_receiving_panel () {
            $data[ 'payments' ] = $this -> IPDModel -> cash_receiving_report_panel ();
            $html_content       = $this -> load -> view ( '/invoices/cash-receiving-report-panel', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5,
                                    ] );
            $name = 'Cash Receiving Report Panel-' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        public function general_summary_report_cash_ii () {
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
            $html_content             = $this -> load -> view ( '/invoices/general-summary-report-cash-ii', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 35,
                                        'margin_bottom' => 5,
                                        'margin_header' => 5,
                                        'margin_footer' => 5,
                                    ] );
            $name = 'General summary report cash ii-' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( strip_tags ( site_name ) );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = false;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * general report ultrasound
         * -------------------------
         */
        
        public function general_report_ecg () {
            
            $data[ 'sales' ] = $this -> ReportingModel -> get_ecg_reporting ();
            $html_content    = $this -> load -> view ( '/invoices/general_report_ultrasound', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            $name = 'General Report Ultrasound ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = true;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * xray report
         * ---------------------
         */
        
        public function ecg_report () {
            
            if ( !isset( $_REQUEST[ 'report-id' ] ) or !is_numeric ( $_REQUEST[ 'report-id' ] ) or $_REQUEST[ 'report-id' ] < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $report_id        = $_REQUEST[ 'report-id' ];
            $data[ 'report' ] = $this -> RadiologyModel -> get_ecg_report_by_id ( $report_id );
            $html_content     = $this -> load -> view ( '/invoices/ecg-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            $name = 'ECG Report ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = true;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * -------------------------
         * general report ultrasound
         * -------------------------
         */
        
        public function general_report_echo () {
            
            $data[ 'sales' ] = $this -> ReportingModel -> get_echo_reporting ();
            $html_content    = $this -> load -> view ( '/invoices/general_report_ultrasound', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            $name = 'General Report Ultrasound ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = true;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
        
        /**
         * ---------------------
         * do print invoice
         * xray report
         * ---------------------
         */
        
        public function echo_report () {
            
            if ( !isset( $_REQUEST[ 'report-id' ] ) or !is_numeric ( $_REQUEST[ 'report-id' ] ) or $_REQUEST[ 'report-id' ] < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $report_id        = $_REQUEST[ 'report-id' ];
            $data[ 'report' ] = $this -> RadiologyModel -> get_echo_report_by_id ( $report_id );
            $html_content     = $this -> load -> view ( '/invoices/echo-report', $data, true );
            require_once FCPATH . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf( [
                                        'margin_left'   => 5,
                                        'margin_right'  => 5,
                                        'margin_top'    => 48,
                                        'margin_bottom' => 25,
                                        'margin_header' => 10,
                                        'margin_footer' => 10
                                    ] );
            $name = 'ECHO Report ' . rand () . '.pdf';
            
            $mpdf -> SetTitle ( site_name );
            $mpdf -> SetAuthor ( site_name );
            $mpdf -> SetWatermarkText ( site_name );
            $mpdf -> showWatermarkText  = true;
            $mpdf -> watermark_font     = 'DejaVuSansCondensed';
            $mpdf -> watermarkTextAlpha = 0.1;
            $mpdf -> SetDisplayMode ( 'real' );
            $mpdf -> WriteHTML ( $html_content );
            $mpdf -> Output ( $name, 'I' );
        }
    }
