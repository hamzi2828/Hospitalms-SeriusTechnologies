<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );

    /*
    |--------------------------------------------------------------------------
    | Display Debug backtrace
    |--------------------------------------------------------------------------
    |
    | If set to TRUE, a backtrace will be displayed along with php errors. If
    | error_reporting is disabled, the backtrace will not display, regardless
    | of this setting
    |
    */
    defined ( 'SHOW_DEBUG_BACKTRACE' ) or define ( 'SHOW_DEBUG_BACKTRACE', TRUE );

    /*
    |--------------------------------------------------------------------------
    | File and Directory Modes
    |--------------------------------------------------------------------------
    |
    | These prefs are used when checking and setting modes when working
    | with the file system.  The defaults are fine on servers with proper
    | security, but you may wish (or even need) to change the values in
    | certain environments (Apache running a separate process for each
    | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
    | always be used to set the mode correctly.
    |
    */
    defined ( 'FILE_READ_MODE' ) or define ( 'FILE_READ_MODE', 0644 );
    defined ( 'FILE_WRITE_MODE' ) or define ( 'FILE_WRITE_MODE', 0666 );
    defined ( 'DIR_READ_MODE' ) or define ( 'DIR_READ_MODE', 0755 );
    defined ( 'DIR_WRITE_MODE' ) or define ( 'DIR_WRITE_MODE', 0755 );

    /*
    |--------------------------------------------------------------------------
    | File Stream Modes
    |--------------------------------------------------------------------------
    |
    | These modes are used when working with fopen()/popen()
    |
    */
    defined ( 'FOPEN_READ' ) or define ( 'FOPEN_READ', 'rb' );
    defined ( 'FOPEN_READ_WRITE' ) or define ( 'FOPEN_READ_WRITE', 'r+b' );
    defined ( 'FOPEN_WRITE_CREATE_DESTRUCTIVE' ) or define ( 'FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb' );            // truncates existing file data, use with care
    defined ( 'FOPEN_READ_WRITE_CREATE_DESTRUCTIVE' ) or define ( 'FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b' ); // truncates existing file data, use with care
    defined ( 'FOPEN_WRITE_CREATE' ) or define ( 'FOPEN_WRITE_CREATE', 'ab' );
    defined ( 'FOPEN_READ_WRITE_CREATE' ) or define ( 'FOPEN_READ_WRITE_CREATE', 'a+b' );
    defined ( 'FOPEN_WRITE_CREATE_STRICT' ) or define ( 'FOPEN_WRITE_CREATE_STRICT', 'xb' );
    defined ( 'FOPEN_READ_WRITE_CREATE_STRICT' ) or define ( 'FOPEN_READ_WRITE_CREATE_STRICT', 'x+b' );

    /*
    |--------------------------------------------------------------------------
    | Exit Status Codes
    |--------------------------------------------------------------------------
    |
    | Used to indicate the conditions under which the script is exit()ing.
    | While there is no universal standard for error codes, there are some
    | broad conventions.  Three such conventions are mentioned below, for
    | those who wish to make use of them.  The CodeIgniter defaults were
    | chosen for the least overlap with these conventions, while still
    | leaving room for others to be defined in future versions and user
    | applications.
    |
    | The three main conventions used for determining exit status codes
    | are as follows:
    |
    |    Standard C/C++ Library (stdlibc):
    |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
    |       (This link also contains other GNU-specific conventions)
    |    BSD sysexits.h:
    |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
    |    Bash scripting:
    |       http://tldp.org/LDP/abs/html/exitcodes.html
    |
    */
    defined ( 'EXIT_SUCCESS' ) or define ( 'EXIT_SUCCESS', 0 );               // no errors
    defined ( 'EXIT_ERROR' ) or define ( 'EXIT_ERROR', 1 );                   // generic error
    defined ( 'EXIT_CONFIG' ) or define ( 'EXIT_CONFIG', 3 );                 // configuration error
    defined ( 'EXIT_UNKNOWN_FILE' ) or define ( 'EXIT_UNKNOWN_FILE', 4 );     // file not found
    defined ( 'EXIT_UNKNOWN_CLASS' ) or define ( 'EXIT_UNKNOWN_CLASS', 5 );   // unknown class
    defined ( 'EXIT_UNKNOWN_METHOD' ) or define ( 'EXIT_UNKNOWN_METHOD', 6 ); // unknown class member
    defined ( 'EXIT_USER_INPUT' ) or define ( 'EXIT_USER_INPUT', 7 );         // invalid user input
    defined ( 'EXIT_DATABASE' ) or define ( 'EXIT_DATABASE', 8 );             // database error
    defined ( 'EXIT__AUTO_MIN' ) or define ( 'EXIT__AUTO_MIN', 9 );           // lowest automatically-assigned error code
    defined ( 'EXIT__AUTO_MAX' ) or define ( 'EXIT__AUTO_MAX', 125 );         // highest automatically-assigned error code
    define ( 'site_title', 'Kuwait Medical Complex' );
    define ( 'licenced', 'Sirius Technologies <br> Rapid Reporting Hospital Management System <br> Version 8.1' );

    define ( 'site_email', 'info@hospital.com' );
    define ( 'site_name', 'General Dummy Hospital' );
    define ( 'site_slug', 'GDH' );
    define ( 'hospital_address', '<strong>Head Office:</strong> XYZ, ISB, RWP, PAK' );
    define ( 'hospital_phone', '05815-123654' );

    define ( 'emr_prefix', '' );
    define ( 'db_prefix', 'hmis_' );

    define ( 'supplier_id', 1 );
    define ( 'customer_id', 2 );
    define ( 'sales_id', 3 );
    define ( 'bank_id', 4 );
    define ( 'expense_id', 5 );
    define ( 'asset_id', 6 );
    define ( 'liability_id', 7 );
    define ( 'capital_id', 8 );
    define ( 'cash_patient', 14 );
    define ( 'panel_patient', 15 );
    define ( 'cash_in_hand', 21 );
    define ( 'cash_from_pharmacy', 22 );
    define ( 'cash_from_opd', 23 );
    define ( 'cash_from_lab', 24 );
    define ( 'return_customer', 45 );
    define ( 'cash_from_opd_consultancy', 23 );
    define ( 'cash_from_opd_services', 64 );
    define ( 'local_purchase', 71 );
    define ( 'store_supplier', 791 );
    define ( 'lab_suppliers', 724 );
    define ( 'Cafe_Suppliers', 9 ); // new created 
    define ( 'pharmacy_dept', 3 );
    define ( 'anesthetist_charges', '20% - 33% of surgeon fee' );
    define ( 'ipd_service_types', "'xray','ultrasound','ecg','echo'" );
    define ( 'short_medicine_cost', 197 );
    define ( 'administrative_expenses', 39 );
    define ( 'fixed_assets', 905 );
    define ( 'mm_store', 251 );
    define ( 'sales_consultancy_service', 312 );
    define ( 'discount_consultancy_service', 320 );
    define ( 'sales_opd_services', 308 );
    define ( 'discount_opd_services', 323 );
    define ( 'cash_from_lab_services', 24 );
    define ( 'sales_lab_services', 313 );
    define ( 'discount_lab_services', 322 );
    define ( 'medical_supply_inventory', 306 );
    define ( 'sales_pharmacy', 310 );
    define ( 'discount_pharmacy', 340 );
    define ( 'cost_of_medicine_sold', 299 );
    define ( 'returns_and_allowances', 297 );
    define ( 'cash_from_ipd', 108 );
    define ( 'Sales_IPD_Services', 309 );
    define ( 'Discount_on_IPD_Services', 321 );
    define ( 'COS_Procedures', 175 );
    define ( 'COS_Other_Direct_Cost_Procedures', 345 );
    define ( 'housekeeping_dept', 12 );
    define ( 'assets', 1 );
    define ( 'liabilities', 2 );
    define ( 'capitals', 3 );
    define ( 'income', 4 );
    define ( 'expenditure', 5 );
    define ( 'COS_Consultancy_Charges', 328 );
    define ( 'Returns_and_Allowances', 297 );
    define ( 'Fee_Discounts', 285 );
    define ( 'Direct_Costs', 287 );
    define ( 'Finance_Cost', 365 );
    define ( 'Tax', 366 );
    define ( 'chart_days', 30 );
    define ( 'sales_ipd_services_panel', 414 );
    define ( 'discount_ipd_services_panel', 415 );
    define ( 'sales_lab_services_panel', 419 );
    define ( 'discount_lab_services_panel', 420 );
    define ( 'sales_from_opd_services_panel', 425 );
    define ( 'discount_from_opd_services_panel', 426 );
    define ( 'sales_consultancy_service_panel', 428 );
    define ( 'discount_consultancy_service_panel', 429 );
    define ( 'secret_key', 'CxPluNs8jHK3sb7KVX6gJgT3yY5t9A1x' );

// current assets
    define ( 'cash_balances', 21 );
    define ( 'banks', 4 );
    define ( 'receivable_accounts', 92 );
    define ( 'inventory', 99 );

// non current assets
    define ( 'furniture_fixture', 58 );
    define ( 'intangible_assets', 422 );
    define ( 'bio_medical_surgical_items', 60 );
    define ( 'machinery_equipment', 73 );
    define ( 'electrical_equipment', 75 );
    define ( 'it_equipment', 76 );
    define ( 'office_equipment', 189 );
    define ( 'land_building', 421 );
    define ( 'accumulated_depreciation', 435 );

// liabilities
    define ( 'payable_accounts', 156 );
    define ( 'accrued_expenses', 126 );
    define ( 'unearned_revenue', 437 );
    define ( 'WHT_payable', 102 );
    define ( 'long_term_debt', 438 );
    define ( 'other_long_term_liabilities', 439 );

//covid tests
    define ( 'COVID_RAPID_PCR', 883 );
    define ( 'COVID_19_RT_PCR_General', 1297 );
    define ( 'COVID_19_RT_PCR_Panel', 776 );
    define ( 'ADMINISTRATION_DEPT', 1 );

    define ( 'TURKISH_AIRLINE', 7 );
    define ( 'PEGASUS_AIRLINE', 12 );

    define ( 'GENERAL_ADMINISTRATIVE_EXPENSES', 5 );
    define ( 'CP_Peripheral_Film', 860 );
    define ( 'SEMEN_ANALYSIS', 571 );
    define ( 'STOOL_EXAMINATION', 7 );
    define ( 'URINE_RE', 6 );
    define ( 'CSF_ANALYSIS', 1346 );
    define ( 'Ascitic_Fluid_Analysis', 348 );
    define ( 'Pericardial_Fluid', 1361 );

    define ( 'cp_peripheral_film_general', array (
        '861',
        '862',
        '863',
        '865',
        '866',
        '867',
        '868',
        '864',
        '869',
    ) );
    define ( 'cp_peripheral_film_dlc', array (
        '870',
        '871',
        '872',
        '873',
    ) );
    define ( 'cp_peripheral_film_rcm', array (
        '874',
        '1321',
        '1322',
        '1323',
        '1324',
        '1325',
    ) );

    define ( 'semen_analysis_general', array (
        '1394',
        '1395',
        '1396',
        '1397',
        '1399',
        '1400',
    ) );
    define ( 'semen_analysis_motility', array (
        '1401',
        '1402',
        '1403',
    ) );
    define ( 'semen_analysis_count', array (
        '1404',
    ) );
    define ( 'semen_analysis_cells', array (
        '1405',
    ) );

    define ( 'stool_examination_physical_analysis', array (
        '793',
        '798',
        '794',
        '799',
        '1550',
        '795',
        '1551',
        '1552',
    ) );
    define ( 'stool_microscopic_examination', array (
        '1382',
        '1383',
        '1553',
        '1377',
        '1554',
        '1379',
        '1555',
        '1381',
        '796',
        '1556',
        '1557',
    ) );

    define ( 'urine_r_e_physical_examination', array (
        '122',
        '1371',
    ) );
    define ( 'urine_r_e_chemical_examination', array (
        '25',
        '124',
        '126',
        '127',
        '125',
        '1548',
        '130',
        '128',
        '1536',
        '878',
    ) );
    define ( 'urine_r_e_microscopic_examination', array (
        '1376',
        '129',
        '133',
        '1537',
        '768',
        '1539',
        '1540',
        '1541',
        '134',
    ) );

    define ( 'csf_bio_chemistry', array (
        '1558',
        '1559',
        '1560',
    ) );
    define ( 'csf_microscopy', array (
        '1561',
        '1562',
        '1563',
        '1564',
    ) );
    define ( 'csf_others', array (
        '1565',
        '1566',
    ) );

    define ( 'afa_physical_examination', array (
        '1927',
        '1928',
        '1929',
        '1930',
        '1931',
        '1932',
        '1933',
    ) );

    define ( 'afa_chemical_examination', array (
        '1934',
        '1935',
        '1936',
    ) );

    define ( 'afa_microscopic_examination', array (
        '1937',
        '1938',
    ) );

    define ( 'afa_dlc', array (
        '1939',
        '1940',
        '1941',
        '1942',
    ) );

    define ( 'pf_physical_examination', array (
        '1944',
        '1945',
        '1946',
        '1947',
        '1948',
        '1949',
        '1950',
    ) );

    define ( 'pf_chemical_examination', array (
        '1951',
        '1952',
    ) );

    define ( 'pf_microscopic_examination', array (
        '1953',
        '1954',
    ) );

    define ( 'pf_dlc', array (
        '1955',
        '1956',
        '1957',
        '1958',
    ) );

    define ( 'months', array (
        1  => 'January',
        2  => 'February',
        3  => 'March',
        4  => 'April',
        5  => 'May',
        6  => 'June',
        7  => 'July',
        8  => 'August',
        9  => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December'
    ) );

    define ( 'capital', 8 );
    define ( 'STORE_SUPPLIER', 791 );
    define ( 'CONSULTANCY_SHARES_DOCTOR', 67 );
    define ( 'RECEIVABLE_FROM_PANELS', 138 );
    define ( 'LOSS_ON_DISPOSAL', 814 );
    define ( 'GAIN_ON_DISPOSAL', 815 );
    define ( 'ACCUMULATED_DEPRECIATION', 435 );
    define ( 'OTHER_INCOME', 206 );
    define ( 'store_inventory', 470 );
    define ( 'lab_inventory', 486 );
    define ( 'Cafe_Inventory', 10 );
    
    define ( 'COS_Procedures_IPD', 861 );
    define ( 'COS_Anesthesia_Fee', 181 );
    define ( 'Anesthetist_Charges', 30 );
    define ( 'SSP_ADVANCE_TAX', 862 );
    define ( 'COS_DEDUCTION_SSP', 864 );
    define ( 'COS_EXCLUDE_SSP', 863 );
    define ( 'CARD', 869 );
    define ( 'Lab_Patient_Balances', 870 );
    define ( 'COS_Online_Referral_Portal', 871 );
    define ( 'COST_OF_SERVICES', 169 );
    define ( 'COS_Laboratory', 878 );

    // define ( 'online_report_url', 'http://159.223.61.59/reports/' );
    // define ( 'SMS_API_KEY', '923245318328-a1dd0a79-c98d-4727-a1cb-28f38b23ed69' );
    define ( 'BIRTH_CERT_REG', 'KMC-Bcert-' );
    define ( 'STORE_CODE', 'KMC-' . date ( 'y' ) . '-0010' );
