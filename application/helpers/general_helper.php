<?php
    
    /**
     * ------------
     * @param $date
     * @return false|string
     * format the date and return
     * ------------
     */
    
    function date_setter ( $date, $addHours = 0 ) {
        if ( $addHours > 0 )
            return date ( 'd-m-Y g:i A', strtotime ( $date . " +$addHours hours" ) );
        else
            return date ( 'd-m-Y g:i A', strtotime ( $date ) );
    }
    
    function date_setter_without_time ( $date ) {
        return date ( 'd-m-Y', strtotime ( $date ) );
    }
    
    /**
     * ------------
     * @param $string
     * @return mixed
     * encrypt string
     * ------------
     * ------------
     */
    
    function encrypt ( $string ) {
        return $this -> encrypt -> encode ( $string );
    }
    
    /**
     * ------------
     * @param $string
     * @return mixed
     * decrypt string
     * ------------
     */
    
    function decrypt ( $string ) {
        return $this -> encrypt -> decode ( $string );
    }
    
    /**
     * ---------------------
     * @param $username
     * @return mixed
     * get username
     * ---------------------
     */
    
    function get_username ( $username ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LoginModel' );
        return $ci -> LoginModel -> get_username ( $username );
    }
    
    /**
     * ---------------------
     * @return mixed
     * get logged in user id
     * ---------------------
     */
    
    function get_logged_in_user_id () {
        $ci        = &get_instance ();
        $user_data = $ci -> session -> userdata ( 'user_data' );
        return $user_data -> id;
    }
    
    /**
     * ---------------------
     * @return mixed
     * get logged in user department id
     * ---------------------
     */
    
    function get_logged_in_user_department_id () {
        $ci        = &get_instance ();
        $user_data = $ci -> session -> userdata ( 'user_data' );
        return $user_data -> department_id;
    }
    
    /**
     * ---------------------
     * @return mixed
     * get logged in user
     * ---------------------
     */
    
    function get_logged_in_user () {
        $ci        = &get_instance ();
        $user_data = $ci -> session -> userdata ( 'user_data' );
        return $user_data;
    }
    
    /**
     * ---------------------
     * @param $string
     * convert normal array into formalized
     * ---------------------
     */
    
    function print_data ( $string ) {
        echo '<pre>';
        print_r ( $string );
        echo '</pre>';
    }
    
    /**
     * ---------------------
     * @return mixed
     * count active medicines
     * ---------------------
     */
    
    function count_active_medicines () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> count_active_medicines ();
    }
    
    /**
     * ---------------------
     * @return mixed
     * count all medicines
     * ---------------------
     */
    
    function count_medicines () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> count_medicines ();
    }
    
    /**
     * ---------------------
     * @return mixed
     * count inactive medicines
     * ---------------------
     */
    
    function count_inactive_medicines () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> count_inactive_medicines ();
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * count inactive medicines
     * ---------------------
     * @return mixed
     */
    
    function get_medicine ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_medicine ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $supplier_id
     * count inactive medicines
     * ---------------------
     * @return mixed
     */
    
    function get_supplier ( $supplier_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'SupplierModel' );
        return $ci -> SupplierModel -> get_supplier_by_id ( $supplier_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * count sold quantity of medicine
     * ---------------------
     */
    
    function get_sold_quantity ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_sold_quantity ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * count sold quantity of medicine
     * ---------------------
     */
    
    function get_sold_quantity_by_date_filter ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_sold_quantity_by_date_filter ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @param $stock_id
     * @return mixed
     * count sold quantity of medicine
     * ---------------------
     */
    
    function get_sold_quantity_by_stock ( $medicine_id, $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_sold_quantity_by_stock ( $medicine_id, $stock_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * count stock of medicine
     * ---------------------
     */
    
    function get_stock_quantity ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock_quantity ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * count stock of medicine
     * ---------------------
     */
    
    function get_stock_quantity_by_date_filter ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock_quantity_by_date_filter ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $manufacturer_id
     * @return mixed
     * get manufacturer
     * ---------------------
     */
    
    function get_manufacturer ( $manufacturer_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_manufacturer_by_id ( $manufacturer_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * count expired stock of medicine
     * ---------------------
     */
    
    function get_stock_expired_quantity ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock_expired_quantity ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $stock_id
     * @return mixed
     * get stock by id
     * ---------------------
     */
    
    function get_stock_by_id ( $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock_by_id ( $stock_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * count expired stock of medicine
     * ---------------------
     */
    
    function get_stock_expired_quantity_by_date_filter ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock_expired_quantity_by_date_filter ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $stock_id
     * @return mixed
     * count expired stock
     * ---------------------
     */
    
    function get_expired_by_stock ( $stock_id, $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_expired_by_stock ( $stock_id, $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $stock_id
     * @return mixed
     * get_stock
     * ---------------------
     */
    
    function get_stock ( $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock ( $stock_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @param $stock_id
     * @return mixed
     * check quantity sold
     * ---------------------
     */
    
    function check_quantity_sold ( $medicine_id, $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> check_quantity_sold ( $medicine_id, $stock_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @param $stock_id
     * @return mixed
     * check quantity issued
     * ---------------------
     */
    
    function check_issued_quantity ( $medicine_id, $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> check_issued_quantity ( $medicine_id, $stock_id );
    }
    
    /**
     * ---------------------
     * @param $stock_id
     * @return mixed
     * check stock quantity issued
     * ---------------------
     */
    
    function check_stock_issued_quantity ( $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> check_stock_issued_quantity ( $stock_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * check medicine quantity issued
     * ---------------------
     */
    
    function get_issued_quantity ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_issued_quantity ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * check medicine quantity issued
     * ---------------------
     */
    
    function get_issued_quantity_by_date_filter ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_issued_quantity_by_date_filter ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $stock_id
     * @return mixed
     * check stock quantity issued
     * ---------------------
     */
    
    function get_stock_remaining_available_quantity ( $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock_remaining_available_quantity ( $stock_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * get total by sale id
     * ---------------------
     */
    
    function get_total_by_sale_id ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_total_by_sale_id ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $company_id
     * @return mixed
     * get company by id
     * ---------------------
     */
    
    function get_company_by_id ( $company_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'CompanyModel' );
        return $ci -> CompanyModel -> get_company_by_id ( $company_id );
    }
    
    /**
     * ---------------------
     * @param $panel_id
     * @return mixed
     * get company id by panel id
     * ---------------------
     */
    
    function get_company_id_by_panel_id ( $panel_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'CompanyModel' );
        return $ci -> CompanyModel -> get_company_id_by_panel_id ( $panel_id );
    }
    
    /**
     * ---------------------
     * @param $member_id
     * @return mixed
     * get member by id
     * ---------------------
     */
    
    function get_member_by_id ( $member_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MemberModel' );
        return $ci -> MemberModel -> get_member_by_id ( $member_id );
    }
    
    /**
     * ---------------------
     * @param $account_head_id
     * @param $single_account_head
     * @return mixed
     * get child account heads
     * ---------------------
     */
    
    function get_child_account_heads ( $account_head_id, $single_account_head = 0 ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        $data[ 'single_account_head' ] = $single_account_head;
        $data[ 'account_heads' ]       = $ci -> AccountModel -> get_child_account_heads ( $account_head_id );
        $ci -> load -> view ( '/accounts/child-account-heads', $data );
    }
    
    /**
     * ---------------------
     * @param $account_head_id
     * @param $single_account_head
     * @return mixed
     * get child account heads
     * ---------------------
     */
    
    function get_active_child_account_heads ( $account_head_id, $single_account_head = 0 ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        $data[ 'single_account_head' ] = $single_account_head;
        $data[ 'account_heads' ]       = $ci -> AccountModel -> get_active_child_account_heads ( $account_head_id );
        $ci -> load -> view ( '/accounts/child-account-heads', $data );
    }
    
    /**
     * ---------------------
     * @param $account_head_id
     * @return mixed
     * get child account heads data
     * ---------------------
     */
    
    function get_child_account_heads_data ( $account_head_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_child_account_heads ( $account_head_id );
    }
    
    /**
     * ---------------------
     * @param $account_head_id
     * @return mixed
     * get sub child account head ids
     * ---------------------
     */
    
    function get_sub_child_account_head_ids ( $account_head_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_sub_child_account_head_ids ( $account_head_id );
    }
    
    /**
     * ---------------------
     * @param $account_head_id
     * @param $parent_id
     * @return mixed
     * get child account heads
     * ---------------------
     */
    
    function get_child_account_heads_for_parent_select_only ( $account_head_id, $parent_id = 0 ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        $data[ 'parent_id' ]     = $parent_id;
        $data[ 'account_heads' ] = $ci -> AccountModel -> get_child_account_heads ( $account_head_id );
        $ci -> load -> view ( '/accounts/get_child_account_heads_for_parent_select_only', $data );
    }
    
    /**
     * ---------------------
     * @param $role_id
     * @return mixed
     * get account head role
     * ---------------------
     */
    
    function get_account_head_role ( $role_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        $data[ 'role_id' ] = $role_id;
        return $ci -> AccountModel -> get_account_role ( $role_id );
    }
    
    /**
     * ---------------------
     * @param $account_head_id
     * @param $single_account_head
     * @return mixed
     * get child account heads
     * ---------------------
     */
    
    function get_child_account_heads_hierarchy ( $account_head_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        $data[ 'account_heads' ] = $ci -> AccountModel -> get_child_account_heads ( $account_head_id );
        $ci -> load -> view ( '/accounts/child-account-heads-hierarchy', $data );
    }
    
    /**
     * ---------------------
     * @param $doctor_id
     * @return mixed
     * check if doctor is linked with ACC
     * ---------------------
     */
    
    function check_if_doctor_is_linked_with_account_head ( $doctor_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> check_if_doctor_is_linked_with_account_head ( $doctor_id );
    }
    
    /**
     * ---------------------
     * @param $account_head_id
     * @return mixed
     * check if parent has children
     * ---------------------
     */
    
    function if_has_child ( $account_head_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> if_has_child ( $account_head_id );
    }
    
    /**
     * ---------------------
     * @param $account_head_id
     * @param int $single_account_head
     * get sub child account heads
     * ---------------------
     */
    
    function get_sub_child_account_heads ( $account_head_id, $single_account_head = 0 ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        $data[ 'single_account_head' ] = $single_account_head;
        $data[ 'account_heads' ]       = $ci -> AccountModel -> get_child_account_heads ( $account_head_id );
        $ci -> load -> view ( '/accounts/sub-child-account-heads', $data );
    }
    
    /**
     * ---------------------
     * @param $account_head_id
     * @param int $single_account_head
     * get sub child account heads
     * ---------------------
     */
    
    function get_active_sub_child_account_heads ( $account_head_id, $single_account_head = 0 ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        $data[ 'single_account_head' ] = $single_account_head;
        $data[ 'account_heads' ]       = $ci -> AccountModel -> get_active_child_account_heads ( $account_head_id );
        $ci -> load -> view ( '/accounts/sub-child-account-heads', $data );
    }
    
    /**
     * ---------------------
     * @param int $service_id
     * @param bool $third_level
     * @param int $single_service_id
     * @param int $panel_id
     * get sub child
     * ---------------------
     */
    
    function get_sub_child ( $service_id, $third_level = false, $single_service_id = 0, $panel_id = 0 ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        $data[ 'sub_services' ]      = $ci -> IPDModel -> get_sub_child ( $service_id, $panel_id );
        $data[ 'third_level' ]       = $third_level;
        $data[ 'single_service_id' ] = $single_service_id;
        $data[ 'panel_id' ]          = $panel_id;
        $ci -> load -> view ( '/settings/ipd/sub-child', $data );
    }
    
    /**
     * ---------------------
     * @param int $test_id
     * @param int $single_test_id
     * get sub child
     * ---------------------
     */
    
    function get_child_tests ( $test_id, $single_test_id = 0 ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        $data[ 'child_tests' ]    = $ci -> LabModel -> get_child_tests ( $test_id );
        $data[ 'single_test_id' ] = $single_test_id;
        $ci -> load -> view ( '/ipd/child-tests', $data );
    }
    
    /**
     * ---------------------
     * @param int $test_id
     * get sub child
     * ---------------------
     */
    
    function get_test_children ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_child_tests ( $test_id );
    }
    
    /**
     * ---------------------
     * @param int $test_id
     * get sub child
     * @return mixed
     * ---------------------
     */
    
    function get_child_tests_ids ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_child_tests_ids ( $test_id );
    }
    
    /**
     * ---------------------
     * @param int $sale_id
     * @param int $testIDS
     * @param int $result_id
     * get sub child
     * @return mixed
     * ---------------------
     */
    
    function get_test_results_by_ids ( $sale_id, $testIDS, $result_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_sub_lab_results_by_sale_id_result_id ( $sale_id, $testIDS, $result_id );
    }
    
    /**
     * ---------------------
     * @param int $sale_id
     * @param int $testIDS
     * @param int $result_id
     * get sub child
     * @return mixed
     * ---------------------
     */
    
    function get_lab_test_results_by_ids ( $sale_id, $testIDS, $result_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_sub_lab_results_by_sale_id_result_id ( $sale_id, $testIDS, $result_id );
    }
    
    /**
     * ---------------------
     * @param int $sale_id
     * @param int $testIDS
     * @param int $result_id
     * get sub child
     * @return mixed
     * ---------------------
     */
    
    function get_ipd_lab_test_results_by_ids ( $sale_id, $testIDS, $result_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_ipd_lab_test_results_by_ids ( $sale_id, $testIDS, $result_id );
    }
    
    /**
     * ---------------------
     * @param int $test_id
     * @param int $single_test_id
     * @param int $panel_id
     * get sub child
     * ---------------------
     */
    
    function get_active_child_tests ( $test_id, $single_test_id = 0, $panel_id = 0 ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        $data[ 'child_tests' ] = $ci -> LabModel -> get_active_child_tests ( $test_id, $panel_id );
        
        $data[ 'single_test_id' ] = $single_test_id;
        $data[ 'panel_id' ]       = $panel_id;
        $ci -> load -> view ( '/ipd/child-tests', $data );
    }
    
    /**
     * ---------------------
     * @param $account_head_id
     * @param int $single_account_head
     * get sub child account heads
     * ---------------------
     */
    
    function get_sub_child_account_heads_hierarchy ( $account_head_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        $data[ 'account_heads' ] = $ci -> AccountModel -> get_child_account_heads ( $account_head_id );
        $ci -> load -> view ( '/accounts/sub-child-account-heads-hierarchy', $data );
    }
    
    /**
     * ---------------------
     * @param $account_head_id
     * @return mixed
     * get account head
     * ---------------------
     */
    
    function get_account_head ( $account_head_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_account_head ( $account_head_id );
    }
    
    /**
     * ---------------------
     * @param $bank_trans_id
     * @return mixed
     * get bank transaction id
     * ---------------------
     */
    
    function get_bank_acc_id_by_bank_trans_id ( $bank_trans_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_bank_acc_id_by_bank_trans_id ( $bank_trans_id );
    }
    
    /**
     * ---------------------
     * @param $info
     * @param $transaction_id
     * @param string $before_update
     * @return mixed
     * do create log of transactions
     * ---------------------
     */
    
    function do_create_log ( $info, $transaction_id, $before_update = '' ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> do_create_log ( $info, $transaction_id, $before_update );
    }
    
    /**
     * ---------------------
     * @param string $acc_head_id
     * @return mixed
     * do create log of transactions
     * ---------------------
     */
    
    function get_account_head_parent ( $acc_head_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_account_head_parent ( $acc_head_id );
    }
    
    /**
     * ---------------------
     * @param string $stock_id
     * @return mixed
     * get_transaction_id_by_stock_id
     * ---------------------
     */
    
    function get_transaction_id_by_stock_id ( $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_transaction_id_by_stock_id ( $stock_id );
    }
    
    /**
     * ---------------------
     * @param string $acc_head_id
     * @return mixed
     * get_transactions
     * ---------------------
     */
    
    function get_transactions ( $acc_head_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_transactions ( $acc_head_id );
    }
    
    /**
     * ---------------------
     * @param string $generic_id
     * @return mixed
     * get_generic
     * ---------------------
     */
    
    function get_generic ( $generic_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_generic ( $generic_id );
    }
    
    /**
     * ---------------------
     * @param string $form_id
     * @return mixed
     * get_form
     * ---------------------
     */
    
    function get_form ( $form_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_form ( $form_id );
    }
    
    /**
     * ---------------------
     * @param string $strength_id
     * @return mixed
     * get_strength
     * ---------------------
     */
    
    function get_strength ( $strength_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_strength ( $strength_id );
    }
    
    /**
     * ---------------------
     * @param string $generic_id
     * @param string $medicine_id
     * @return mixed
     * check_medicine_generics
     * ---------------------
     */
    
    function check_medicine_generics ( $medicine_id, $generic_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> check_medicine_generics ( $medicine_id, $generic_id );
    }
    
    /**
     * ---------------------
     * @param string $form_id
     * @param string $medicine_id
     * @return mixed
     * check_medicine_forms
     * ---------------------
     */
    
    function check_medicine_forms ( $medicine_id, $form_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> check_medicine_forms ( $medicine_id, $form_id );
    }
    
    /**
     * ---------------------
     * @param string $strength_id
     * @param string $medicine_id
     * @return mixed
     * check_medicine_strength
     * ---------------------
     */
    
    function check_medicine_strength ( $medicine_id, $strength_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> check_medicine_strength ( $medicine_id, $strength_id );
    }
    
    /**
     * ---------------------
     * @param $invoice_number
     * @return mixed
     * get grand total
     * ---------------------
     */
    
    function get_grand_total ( $invoice_number ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_grand_total ( $invoice_number );
    }
    
    /**
     * ---------------------
     * @param $invoice_number
     * @return mixed
     * get stock grand total
     * ---------------------
     */
    
    function get_stock_grand_total ( $invoice_number ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock_grand_total ( $invoice_number );
    }
    
    /**
     * ---------------------
     * @param $invoice_number
     * @return mixed
     * get grand discount
     * ---------------------
     */
    
    function get_grand_discount ( $invoice_number ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_grand_discount ( $invoice_number );
    }
    
    /**
     * ---------------------
     * @param $user_id
     * @return mixed
     * get user
     * ---------------------
     */
    
    function get_user ( $user_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LoginModel' );
        return $ci -> LoginModel -> get_user ( $user_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * get sale
     * ---------------------
     */
    
    function get_sale ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_sale_by_id ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_ids
     * @return mixed
     * get sale
     * ---------------------
     */
    
    function get_medicine_sales_total_by_batch_ids ( $sale_ids ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_medicine_sales_total_by_batch_ids ( $sale_ids );
    }
    
    /**
     * ---------------------
     * @param $adjustment_id
     * @return mixed
     * get sale
     * ---------------------
     */
    
    function get_adjustment_by_id ( $adjustment_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_adjustment_by_id ( $adjustment_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @param $stock_id
     * @return mixed
     * count
     * ---------------------
     */
    
    function count_medicine_adjustment_by_medicine_id ( $medicine_id, $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> count_medicine_adjustment_by_medicine_id ( $medicine_id, $stock_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * get sale
     * ---------------------
     */
    
    function get_lab_sale ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_lab_sale ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * get sale previous receiving total
     * ---------------------
     */
    
    function get_lab_sale_previous_receiving_total ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_lab_sale_previous_receiving_total ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * get sale
     * ---------------------
     */
    
    function get_test_sale ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_test_sale ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @param $result_id
     * @return mixed
     * get sale
     * ---------------------
     */
    
    function get_result_verification_data ( $sale_id, $result_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_result_verification_data ( $sale_id, $result_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @param $type
     * @return mixed
     * get sale
     * ---------------------
     */
    
    function get_sale_by_type ( $sale_id, $type = 'pharmacy' ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_sale_by_type ( $sale_id, $type );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * get medicine returned quantity
     * ---------------------
     */
    
    function get_medicine_returned_quantity ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_medicine_returned_quantity ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * get medicine returned quantity
     * ---------------------
     */
    
    function get_medicine_returned_quantity_by_date_filter ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_medicine_returned_quantity_by_date_filter ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $stock_id
     * @return mixed
     * get stock returned quantity by  supplier
     * ---------------------
     */
    
    function get_stock_returned_quantity ( $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock_returned_quantity ( $stock_id );
    }
    
    /**
     * ---------------------
     * @param $stock_id
     * @param $medicine_id
     * @return mixed
     * get stock returned quantity by customer
     * ---------------------
     */
    
    function get_stock_returned_quantity_by_customer ( $medicine_id, $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock_returned_quantity_by_customer ( $medicine_id, $stock_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * get stocks
     * ---------------------
     */
    
    function get_stocks ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stocks ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * get expired stocks
     * ---------------------
     */
    
    function get_expired_stocks ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_expired_stocks ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $return_id
     * @return mixed
     * get return
     * ---------------------
     */
    
    function get_return ( $return_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StockReturnModel' );
        return $ci -> StockReturnModel -> get_return ( $return_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * get sum of all stocks
     * by medicine id
     * ---------------------
     */
    
    function get_all_stock_price_by_medicine_id ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_all_stock_price_by_medicine_id ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * get sum of available stocks
     * by medicine id
     * ---------------------
     */
    
    function get_available_stock_price_by_medicine_id ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_available_stock_price_by_medicine_id ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * get sum of available stocks
     * by medicine id
     * ---------------------
     */
    
    function get_available_stock_price_by_medicine_id_by_date_filter ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_available_stock_price_by_medicine_id_by_date_filter ( $medicine_id );
    }
    
    function get_expired_quantity_medicine_id ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_expired_quantity_medicine_id ( $medicine_id );
    }
    
    function get_available_stock_price ( $store_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StoreModel' );
        return $ci -> StoreModel -> get_available_stock_price ( $store_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @param $available
     * @return mixed
     * get sum of all stocks
     * by medicine id
     * ---------------------
     */
    
    function get_stock_price_by_medicine_id_total_quantity ( $medicine_id, $available ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock_price_by_medicine_id_total_quantity ( $medicine_id, $available );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @param $sold
     * @return mixed
     * get sum of all stocks
     * by medicine id
     * ---------------------
     */
    
    function get_stock_price_by_medicine_id_sold_quantity ( $medicine_id, $sold ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock_price_by_medicine_id_sold_quantity ( $medicine_id, $sold );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @param $returned
     * @return mixed
     * get sum of all stocks
     * by medicine id
     * ---------------------
     */
    
    function get_stock_price_by_medicine_id_returned_quantity ( $medicine_id, $returned ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock_price_by_medicine_id_returned_quantity ( $medicine_id, $returned );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @param $issued
     * @return mixed
     * get sum of all stocks
     * by medicine id
     * ---------------------
     */
    
    function get_stock_price_by_medicine_id_issued_quantity ( $medicine_id, $issued ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock_price_by_medicine_id_issued_quantity ( $medicine_id, $issued );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @param $available
     * @return mixed
     * get sum of all stocks
     * by medicine id
     * ---------------------
     */
    
    function get_stock_price_by_medicine_id_available_quantity ( $medicine_id, $available ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock_price_by_medicine_id_available_quantity ( $medicine_id, $available );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @param $counter
     * @return mixed
     * get sum of all stocks
     * by medicine id
     * ---------------------
     */
    
    function get_all_stock_sale_price_by_medicine_id ( $medicine_id, $counter ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_all_stock_sale_price_by_medicine_id ( $medicine_id, $counter );
    }
    
    /**
     * ---------------------
     * @param $stock_id
     * @return mixed
     * get sum of all stocks
     * by medicine id
     * ---------------------
     */
    
    function get_medicines_internal_issuance ( $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_medicines_internal_issuance ( $stock_id );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * @return mixed
     * get test by id
     * ---------------------
     */
    
    function get_test_by_id ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_test_by_id ( $test_id );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * @param $panel_id
     * @return mixed
     * get test price by id
     * ---------------------
     */
    
    function get_test_price ( $test_id, $panel_id = 0 ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_test_price ( $test_id, $panel_id );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * @param $panel_id
     * @param $airline_id
     * @return mixed
     * get test price by airline id
     * ---------------------
     */
    
    function get_test_price_by_airline ( $test_id, $panel_id = 0, $airline_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_test_price_by_airline ( $test_id, $panel_id, $airline_id );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * @return mixed
     * get regular test price by id
     * ---------------------
     */
    
    function get_regular_test_price ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_regular_test_price ( $test_id );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * @param $patient_id
     * @return mixed
     * get test price by patient type
     * ---------------------
     */
    
    function get_test_price_by_patient_type ( $test_id, $patient_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_test_price_by_patient_type ( $test_id, $patient_id );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * @param $panel_id
     * @return mixed
     * get test price by panel id
     * ---------------------
     */
    
    function get_test_price_panel_id ( $test_id, $panel_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_test_price_panel_id ( $test_id, $panel_id );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * @return mixed
     * check if test has sub tests
     * ---------------------
     */
    
    function check_if_test_has_sub_tests ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> check_if_test_has_sub_tests ( $test_id );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * @return mixed
     * check if test is child
     * ---------------------
     */
    
    function check_if_test_is_child ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> check_if_test_is_child ( $test_id );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * @param $location_id
     * @return mixed
     * get selected test location
     * ---------------------
     */
    
    function get_selected_location ( $location_id, $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_selected_location ( $location_id, $test_id );
    }
    
    /**
     * ---------------------
     * @return mixed
     * get next sale id
     * ---------------------
     */
    
    function get_next_sale_id () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_next_sale_id ();
    }
    
    /**
     * ---------------------
     * @param $patient_id
     * get_patient_monthly_gained_allowance
     * ---------------------
     * @return mixed
     */
    
    function get_patient_monthly_gained_allowance ( $patient_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_patient_monthly_gained_allowance ( $patient_id );
    }
    
    /**
     * ---------------------
     * @param $panel_id
     * @param $company_id
     * @return mixed
     * get panel companies by id
     * ---------------------
     */
    
    function get_panel_company ( $panel_id, $company_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'PanelModel' );
        return $ci -> PanelModel -> get_panel_company ( $panel_id, $company_id );
    }
    
    /**
     * ---------------------
     * @param $patient_id
     * @return mixed
     * get patient
     * ---------------------
     */
    
    function get_patient ( $patient_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'PatientModel' );
        return $ci -> PatientModel -> get_patient_by_id ( $patient_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @param $total
     * update_total
     * ---------------------
     * @return mixed
     */
    
    function update_total ( $sale_id, $total ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> update_total ( $sale_id, $total );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * get patient id by sale
     * ---------------------
     * @return mixed
     */
    
    function get_patient_id_by_sale_id ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_patient_id_by_sale_id ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * get patient id by sale
     * ---------------------
     * @return mixed
     */
    
    function get_pharmacy_patient_id_by_sale_id ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_patient_id_by_sale_id ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * get patient id by sale
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_patient_id_by_sale_id ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_patient_id_by_sale_id ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * get patient id by sale
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_procedures ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_consultants ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $id
     * @return mixed
     * get patient id by sale
     * ---------------------
     */
    
    function get_services_by_parent_id ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'OPDModel' );
        return $ci -> OPDModel -> get_services_by_parent_id ( $id );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * get_test_unit_by_id
     * ---------------------
     * @return mixed
     */
    
    function get_test_unit_id_by_id ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_test_unit_id_by_id ( $test_id );
    }
    
    /**
     * ---------------------
     * @param $unit_id
     * get_unit_by_id
     * ---------------------
     * @return mixed
     */
    
    function get_unit_by_id ( $unit_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_unit_by_id ( $unit_id );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * get_reference_ranges_by_test_id
     * ---------------------
     * @return mixed
     */
    
    function get_reference_ranges_by_test_id ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_reference_ranges_by_test_id ( $test_id );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * get test sample info
     * ---------------------
     * @return mixed
     */
    
    function get_test_sample_info ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_test_sample_info ( $test_id );
    }
    
    /**
     * ---------------------
     * @param $section_id
     * @return mixed
     * get test sample info
     * ---------------------
     */
    
    function get_section_by_id ( $section_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'SectionModel' );
        return $ci -> SectionModel -> get_section_by_id ( $section_id );
    }
    
    /**
     * ---------------------
     * @param $id
     * @param $sale_id
     * get_test_results
     * ---------------------
     * @return mixed
     */
    
    function get_test_results ( $sale_id, $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_test_results ( $sale_id, $id );
    }
    
    /**
     * ---------------------
     * @param $id
     * @param $sale_id
     * get_test_results
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_test_result ( $sale_id, $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> IPDModel -> get_ipd_test_result ( $sale_id, $id );
    }
    
    /**
     * ---------------------
     * @param $id
     * @param $sale_id
     * @param $sale_table_id
     * get_test_results
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_test_result_associated_to_sale_table_id ( $sale_id, $id, $sale_table_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> IPDModel -> get_ipd_test_result_associated_to_sale_table_id ( $sale_id, $id, $sale_table_id );
    }
    
    /**
     * ---------------------
     * @param $id
     * get_regent_test_results
     * ---------------------
     * @return mixed
     */
    
    function get_regent_test_results ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_regent_test_results ( $id );
    }
    
    /**
     * ---------------------
     * @param $id
     * get_regent_test_results
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_regent_test_results ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_ipd_regent_test_results ( $id );
    }
    
    /**
     * ---------------------
     * @param $id
     * get_regents_used_by_test
     * ---------------------
     * @return mixed
     */
    
    function get_regents_used_by_test ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_regents_used_by_test ( $id );
    }
    
    /**
     * ---------------------
     * @param $id
     * @return mixed
     * get_regents_used_by_test
     * ---------------------
     */
    
    function get_regent_calibrations ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_regent_calibrations ( $id );
    }
    
    /**
     * ---------------------
     * @param $id
     * @param $test_id
     * get_saved_regent_value
     * ---------------------
     * @return mixed
     */
    
    function get_saved_regent_value ( $test_id, $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_saved_regent_value ( $test_id, $id );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * get_test_regents
     * ---------------------
     * @return mixed
     */
    
    function get_test_regents ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_test_regents ( $test_id );
    }
    
    /**
     * ---------------------
     * @param $id
     * @param $sale_id
     * @param $sale_table_id
     * get_test_results
     * @return mixed
     * ---------------------
     */
    
    function get_ipd_test_results ( $sale_id, $id, $sale_table_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_test_results ( $sale_id, $id, $sale_table_id );
    }
    
    /**
     * ---------------------
     * @param $specialization_id
     * get_specialization
     * ---------------------
     * @return mixed
     */
    
    function get_specialization_by_id ( $specialization_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'DoctorModel' );
        return $ci -> DoctorModel -> get_specialization_by_id ( $specialization_id );
    }
    
    /**
     * ---------------------
     * @param $doctor_id
     * get_doctor
     * ---------------------
     * @return mixed
     */
    
    function get_doctor ( $doctor_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'DoctorModel' );
        return $ci -> DoctorModel -> get_doctor_id ( $doctor_id );
    }
    
    /**
     * ---------------------
     * @param $invoice_id
     * get_supplier_id_by_invoice_id
     * ---------------------
     * @return mixed
     */
    
    function get_supplier_id_by_invoice_id ( $invoice_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_supplier_id_by_invoice_id ( $invoice_id );
    }
    
    /**
     * ---------------------
     * @param $invoice_id
     * @param $supplier_id
     * get_supplier_id_by_invoice_id_and_supplier_id
     * ---------------------
     * @return mixed
     */
    
    function get_supplier_id_by_invoice_id_and_supplier_id ( $invoice_id, $supplier_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_supplier_id_by_invoice_id_and_supplier_id ( $invoice_id, $supplier_id );
    }
    
    /**
     * ---------------------
     * @param $user_id
     * get_user_access
     * ---------------------
     * @return mixed
     */
    
    function get_user_access ( $user_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'UserModel' );
        return $ci -> UserModel -> get_user_access ( $user_id );
    }
    
    /**
     * ---------------------
     * @param $store_id
     * get store stock total quantity
     * ---------------------
     * @return mixed
     */
    
    function get_store_stock_total_quantity ( $store_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StoreModel' );
        return $ci -> StoreModel -> get_store_stock_total_quantity ( $store_id );
    }
    
    /**
     * ---------------------
     * @param $store_id
     * get store stock sold quantity
     * ---------------------
     * @return mixed
     */
    
    function get_store_stock_sold_quantity ( $store_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StoreModel' );
        return $ci -> StoreModel -> get_store_stock_sold_quantity ( $store_id );
    }
    
    /**
     * ---------------------
     * @param $store_id
     * get store by id
     * ---------------------
     * @return mixed
     */
    
    function get_store ( $store_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StoreModel' );
        return $ci -> StoreModel -> get_store_by_id ( $store_id );
    }
    
    /**
     * ---------------------
     * @param $stock_id
     * get stock quantity
     * ---------------------
     * @return mixed
     */
    
    function get_stock_total_quantity ( $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StoreModel' );
        return $ci -> StoreModel -> get_stock_total_quantity ( $stock_id );
    }
    
    /**
     * ---------------------
     * @param $stock_id
     * get stock sold quantity
     * ---------------------
     * @return mixed
     */
    
    function get_stock_sold_quantity ( $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StoreModel' );
        return $ci -> StoreModel -> get_stock_sold_quantity ( $stock_id );
    }
    
    /**
     * ---------------------
     * @param $stock_id
     * get store stock
     * ---------------------
     * @return mixed
     */
    
    function get_store_stock ( $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StoreModel' );
        return $ci -> StoreModel -> get_store_stock ( $stock_id );
    }
    
    /**
     * ---------------------
     * @param $voucher_number
     * Check if transaction is double entry
     * ---------------------
     * @return mixed
     */
    
    function check_if_voucher_is_double_entry ( $voucher_number ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> check_if_voucher_is_double_entry ( $voucher_number );
    }
    
    /**
     * ---------------------
     * @param $patient_id
     * get patient vitals
     * ---------------------
     * @return mixed
     */
    
    function get_vitals ( $patient_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'ConsultancyModel' );
        return $ci -> ConsultancyModel -> get_vitals ( $patient_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @param $consultancy_id
     * check if medicine added with prescription
     * ---------------------
     * @return mixed
     */
    
    function check_if_medicine_added_with_consultancy ( $consultancy_id, $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'ConsultancyModel' );
        return $ci -> ConsultancyModel -> check_if_medicine_added_with_consultancy ( $consultancy_id, $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * @param $consultancy_id
     * check if test added with prescription
     * ---------------------
     * @return mixed
     */
    
    function check_if_test_added_with_consultancy ( $consultancy_id, $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'ConsultancyModel' );
        return $ci -> ConsultancyModel -> check_if_test_added_with_consultancy ( $consultancy_id, $test_id );
    }
    
    /**
     * ---------------------
     * @param $service_id
     * check if service has children
     * ---------------------
     * @return mixed
     */
    
    function opd_services_has_children ( $service_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'OPDModel' );
        return $ci -> OPDModel -> opd_services_has_children ( $service_id );
    }
    
    /**
     * ---------------------
     * @param $service_id
     * get service by id
     * ---------------------
     * @return mixed
     */
    
    function get_service_by_id ( $service_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'OPDModel' );
        return $ci -> OPDModel -> get_service_by_id ( $service_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * get sale by id
     * ---------------------
     * @return mixed
     */
    
    function get_opd_sale ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'OPDModel' );
        return $ci -> OPDModel -> get_opd_sale ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * get sale by id
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_sale ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_sale ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * get discharged date
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_discharged_date ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_discharged_date ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @param $patient_id
     * get patient associated services
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_patient_associated_services ( $patient_id, $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_patient_associated_services ( $patient_id, $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * get follow up by id
     * ---------------------
     * @return mixed
     */
    
    function get_follow_up_by_id ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'DoctorModel' );
        return $ci -> DoctorModel -> get_follow_up_by_id ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $department_id
     * get department up by id
     * ---------------------
     * @return mixed
     */
    
    function get_department ( $department_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MemberModel' );
        return $ci -> MemberModel -> get_department_by_id ( $department_id );
    }
    
    /**
     * ---------------------
     * @param $user_id
     * get user department
     * ---------------------
     * @return mixed
     */
    
    function get_user_department ( $user_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MemberModel' );
        return $ci -> MemberModel -> get_department_by_id ( $user_id );
    }
    
    /**
     * ---------------------
     * @param int $length
     * generate 4 digits unique id
     * @return bool|string
     * ---------------------
     */
    
    function unique_id ( $length = 4 ) {
        return substr ( md5 ( uniqid ( mt_rand (), true ) ), 0, $length );
    }
    
    /**
     * ---------------------
     * @param $department_id
     * @param $store_id
     * get department par level
     * ---------------------
     * @return mixed
     */
    
    function get_par_level_by_dept_item ( $department_id, $store_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StoreModel' );
        $par_level = $ci -> StoreModel -> get_par_level_by_dept_item ( $department_id, $store_id );
        if ( $par_level and !empty( $par_level ) ) {
            $allowed = $par_level -> allowed;
            $sold    = $ci -> StoreModel -> get_issued_items_by_dept_item_id_date ( $department_id, $store_id );
            return $allowed - $sold;
        }
        else {
            return '0';
        }
    }
    
    /**
     * ---------------------
     * @param $voucher_number
     * @param $id
     * Check if transaction is double entry
     * ---------------------
     * @return mixed
     */
    
    function check_id_double_entry ( $voucher_number, $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> check_id_double_entry ( $voucher_number, $id );
    }
    
    /**
     * ---------------------
     * @param $id
     * get instruction by id
     * ---------------------
     * @return mixed
     */
    
    function get_instruction_by_id ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'InstructionModel' );
        return $ci -> InstructionModel -> get_instruction_by_id ( $id );
    }
    
    /**
     * ---------------------
     * @param $date
     * @param $acc_head_id
     * get_opening_balance_previous_than_searched_start_date
     * @return mixed
     * ---------------------
     */
    
    function get_opening_balance_previous_than_searched_start_date ( $date, $acc_head_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_opening_balance_previous_than_searched_start_date ( $date, $acc_head_id );
    }
    
    /**
     * ---------------------
     * @param $financial_year
     * @param $acc_head_id
     * @return mixed
     * calculate acc heads transactions
     * ---------------------
     */
    
    function calculate_acc_head_transaction ( $acc_head_id, $financial_year = false ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> calculate_acc_head_transaction ( $acc_head_id, $financial_year );
    }
    
    /**
     * ---------------------
     * @param $financial_year
     * @param $acc_head_ids
     * @return mixed
     * calculate acc heads transactions
     * ---------------------
     */
    
    function calculate_sub_acc_head_transaction ( $acc_head_ids, $financial_year = false ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> calculate_sub_acc_head_transaction ( $acc_head_ids, $financial_year );
    }
    
    /**
     * ---------------------
     * @param $id
     * check_if_service_has_child
     * ---------------------
     * @return mixed
     */
    
    function check_if_service_has_child ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> check_if_service_has_child ( $id );
    }
    
    /**
     * ---------------------
     * @return string
     * current date time
     * ---------------------
     */
    
    function current_date_time () {
        return ( new DateTime() ) -> format ( "Y-m-d H:i:s" );
    }
    
    /**
     * ---------------------
     * @param $id
     * get package services
     * ---------------------
     * @return mixed
     */
    
    function get_package_services ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_package_services ( $id );
    }
    
    /**
     * ---------------------
     * @param $id
     * get service by id
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_service_by_id ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_service_by_id ( $id );
    }
    
    /**
     * ---------------------
     * @param $start
     * @param $end
     * @param string $interval
     * @param string $format
     * @return array
     * create time ranges
     * ---------------------
     */
    
    function create_time_range ( $start, $end, $interval = '60 mins', $format = '24' ) {
        $startTime        = strtotime ( $start );
        $endTime          = strtotime ( $end );
        $returnTimeFormat = ( $format == '12' ) ? 'g:i:s A' : 'G:i:s';
        
        $current = time ();
        $addTime = strtotime ( '+' . $interval, $current );
        $diff    = $addTime - $current;
        
        $times = array ();
        while ( $startTime < $endTime ) {
            $times[]   = date ( $returnTimeFormat, $startTime );
            $startTime += $diff;
        }
        $times[] = date ( $returnTimeFormat, $startTime );
        return $times;
    }
    
    /**
     * ---------------------
     * @param $id
     * get service parent id
     * ---------------------
     * @return mixed
     */
    
    function get_service_parent_id ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_service_parent_id ( $id );
    }
    
    /**
     * ---------------------
     * @return mixed
     * get anesthetist service
     * ---------------------
     */
    
    function get_anesthetist_service () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_anesthetist_service ();
    }
    
    /**
     * ---------------------
     * @param $form_id
     * get medicines by form
     * ---------------------
     * @return mixed
     */
    
    function get_medicines_by_form ( $form_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'ReportingModel' );
        return $ci -> ReportingModel -> get_medicines_by_form ( $form_id );
    }
    
    /**
     * ---------------------
     * @return mixed
     * count new ipd requisitions
     * ---------------------
     */
    
    function count_new_ipd_requisitions () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> count_new_ipd_requisitions ();
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * count new ipd requisitions
     * ---------------------
     * @return mixed
     */
    
    function get_latest_medicine_stock ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_latest_medicine_stock ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * get medicine stock
     * ---------------------
     * @return mixed
     */
    
    function get_medicine_stock ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stocks ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $department_id
     * check if par level already added
     * ---------------------
     * @return mixed
     */
    
    function checkIfParLevelAlreadyAddedByDeptId ( $department_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> checkIfParLevelAlreadyAddedByDeptId ( $department_id );
    }
    
    /**
     * ---------------------
     * @param $doctor_id
     * get consultancies by doctor id
     * ---------------------
     * @return mixed
     */
    
    function get_doctor_consultancies ( $doctor_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'ConsultancyModel' );
        return $ci -> ConsultancyModel -> get_doctor_consultancies ( $doctor_id );
    }
    
    /**
     * ---------------------
     * @param $order_id
     * get mo order record
     * ---------------------
     * @return mixed
     */
    
    function get_mo_order_record ( $order_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_mo_order_record ( $order_id );
    }
    
    /**
     * ---------------------
     * @param $patient_id
     * get ipd admission no
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_admission_no ( $patient_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_admission_no ( $patient_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * get ipd admission date
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_admission_date ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_admission_slip ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $stock_id
     * get ipd assigned medication
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_medication_assigned_count_by_stock ( $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_ipd_medication_assigned_count_by_stock ( $stock_id );
    }
    
    /**
     * ---------------------
     * @param $stock_id
     * get ipd assigned medication
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_medication_assigned_count_by_stock_and_medicine ( $medicine_id, $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_ipd_medication_assigned_count_by_stock_and_medicine ( $medicine_id, $stock_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * get ipd assigned medication
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_issued_medicine_quantity ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_ipd_issued_medicine_quantity ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * get ipd assigned medication
     * ---------------------
     * @return mixed
     */
    
    function get_medicine_issued_quantity ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_medicine_issued_quantity ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * get ipd assigned medication net price
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_issued_medicine_net_price ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_ipd_issued_medicine_net_price ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * get ipd assigned medication net price
     * ---------------------
     * @return mixed
     */
    
    function get_issued_medicine_net_price ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_issued_medicine_net_price ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * get ipd assigned medication
     * ---------------------
     * @return mixed
     */
    
    function get_ipd_issued_medicine_quantity_by_date_filter ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_ipd_issued_medicine_quantity_by_date_filter ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * get returned medicines quantity by supplier
     * ---------------------
     * @return mixed
     */
    
    function get_returned_medicines_quantity_by_supplier ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_returned_medicines_quantity_by_supplier ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * get returned medicines quantity by supplier
     * ---------------------
     * @return mixed
     */
    
    function get_returned_medicines_quantity_by_supplier_by_date_filter ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_returned_medicines_quantity_by_supplier_by_date_filter ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * get medicines adjustments quantity by medicine
     * ---------------------
     * @return mixed
     */
    
    function get_total_adjustments_by_medicine_id ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_total_adjustments_by_medicine_id ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * get medicines adjustments quantity by medicine
     * ---------------------
     * @return mixed
     */
    
    function get_total_adjustments_by_medicine_id_by_date_filter ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_total_adjustments_by_medicine_id_by_date_filter ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $patient_id
     * check patient
     * ---------------------
     * @return mixed
     */
    
    function get_patient_by_id ( $patient_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'PatientModel' );
        return $ci -> PatientModel -> get_patient_by_id ( $patient_id );
    }
    
    /**
     * ---------------------
     * @param $panel_id
     * get panel
     * ---------------------
     * @return mixed
     */
    
    function get_panel_by_id ( $panel_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'PatientModel' );
        return $ci -> PatientModel -> get_panel_by_id ( $panel_id );
    }
    
    /**
     * ---------------------
     * @param $panel_id
     * @param $doctor_id
     * get panel doctor discount
     * ---------------------
     * @return mixed
     */
    
    function get_panel_doctor_discount ( $doctor_id, $panel_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'PanelModel' );
        return $ci -> PanelModel -> get_panel_doctor_discount ( $doctor_id, $panel_id );
    }
    
    /**
     * ---------------------
     * @param $panel_id
     * @param $service_id
     * get panel opd discount
     * ---------------------
     * @return mixed
     */
    
    function get_panel_opd_discount ( $service_id, $panel_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'PanelModel' );
        return $ci -> PanelModel -> get_panel_opd_discount ( $service_id, $panel_id );
    }
    
    /**
     * ---------------------
     * @param $store_id
     * get store item
     * ---------------------
     * @return mixed
     */
    
    function get_store_by_id ( $store_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StoreModel' );
        return $ci -> StoreModel -> get_store_by_id ( $store_id );
    }
    
    /**
     * ---------------------
     * @return mixed
     * get store item
     * ---------------------
     */
    
    function count_store_requisition_requests () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StoreModel' );
        return $ci -> StoreModel -> count_store_requisition_requests ();
    }
    
    /**
     * ---------------------
     * @return mixed
     * get store item
     * ---------------------
     */
    
    function count_requests_facility_manager () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StoreModel' );
        return $ci -> StoreModel -> count_requests_facility_manager ();
    }
    
    /**
     * ---------------------
     * @return mixed
     * get store item
     * ---------------------
     */
    
    function count_requisition_demands () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'RequisitionModel' );
        return $ci -> RequisitionModel -> count_requisition_demands ();
    }
    
    /**
     * ---------------------
     * @return mixed
     * get store item
     * ---------------------
     */
    
    function count_requisition_demands_store () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'RequisitionModel' );
        return $ci -> RequisitionModel -> count_requisition_demands_store ();
    }
    
    /**
     * ---------------------
     * @param $number
     * @return string
     * ordinal number
     * ---------------------
     */
    
    function ordinal ( $number ) {
        $ends = array (
            'th',
            'st',
            'nd',
            'rd',
            'th',
            'th',
            'th',
            'th',
            'th',
            'th'
        );
        if ( ( ( $number % 100 ) >= 11 ) && ( ( $number % 100 ) <= 13 ) )
            return $number . 'th';
        else
            return $number . $ends[ $number % 10 ];
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * get ipd model
     * ---------------------
     */
    
    function get_ipd_total ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_total ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * get ipd model
     * ---------------------
     */
    
    function get_ipd_services_total ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_services_total ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $city_id
     * @return mixed
     * get city
     * ---------------------
     */
    
    function get_city_by_id ( $city_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'PatientModel' );
        return $ci -> PatientModel -> get_city_by_id ( $city_id );
    }
    
    /**
     * ---------------------
     * @param $patients
     * patient search form
     * ---------------------
     * @return mixed
     */
    
    function patient_search_form ( $patients ) {
        $ci = &get_instance ();
        return $ci -> load -> view ( '/patients/search', $patients );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * get sub lab tests
     * ---------------------
     * @return mixed
     */
    
    function get_sub_lab_tests ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        $data[ 'tests' ] = $ci -> LabModel -> get_active_child_tests ( $test_id );
        return $ci -> load -> view ( '/lab/sub-lab-tests', $data );
    }
    
    /**
     * ---------------------
     * @param $file_name
     * @return mixed
     * upload files
     * ---------------------
     */
    
    function upload_files ( $file_name ) {
        $ci = &get_instance ();
        if ( is_uploaded_file ( $_FILES[ $file_name ][ 'tmp_name' ] ) ) {
            
            if ( !is_dir ( 'uploads/' ) ) {
                mkdir ( './uploads/', 0777, TRUE );
            }
            
            $upload_path               = 'uploads/';
            $config[ 'upload_path' ]   = $upload_path;
            $config[ 'allowed_types' ] = 'jpg|png|gif|pdf|zip|jpeg|PNG';
            $config[ 'max_size' ]      = '0';
            $config[ 'max_filename' ]  = '255';
            $config[ 'encrypt_name' ]  = true;
            $ci -> load -> library ( 'upload', $config );
            $ci -> upload -> initialize ( $config );
            if ( !$ci -> upload -> do_upload ( $file_name ) ) {
                $ci -> session -> set_flashdata ( 'error', $ci -> upload -> display_errors () );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $image_data = $ci -> upload -> data ();
                $image_path = base_url ( '/uploads/' . $image_data[ 'file_name' ] );
                return $image_path;
            }
        }
        else
            return false;
    }
    
    /**
     * ---------------------
     * @param $employee_id
     * @return int
     * get employee current loan
     * ---------------------
     */
    
    function get_employee_standing_loan ( $employee_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LoanModel' );
        return $ci -> LoanModel -> get_employee_standing_loan ( $employee_id );
    }
    
    /**
     * ---------------------
     * @param $employee_id
     * @return mixed
     * get employee by id
     * ---------------------
     */
    
    function get_employee_by_id ( $employee_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'HrModel' );
        return $ci -> HrModel -> get_employee_by_id ( $employee_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * check if already refunded
     * ---------------------
     */
    
    function is_lab_invoice_already_refunded ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> is_lab_invoice_already_refunded ( $sale_id );
    }
    
    /**
     * ---------------------
     * check if any added stock
     * total is not equal to actual stock
     * net price than update it
     * ---------------------
     */
    
    function update_stock_gl_totals () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        $query     = $ci -> db -> query ( "Select supplier_id, supplier_invoice, SUM(net_price) as net_price_stock, date_added from hmis_medicines_stock where returned='0' group by supplier_invoice order by supplier_invoice ASC" );
        $stock_sum = $query -> result ();
        
        
        $query_2     = $ci -> db -> query ( "Select invoice_number, grand_total from hmis_stock_invoice_discount order by invoice_number ASC" );
        $stock_total = $query_2 -> result_array ();
        
        
        foreach ( $stock_sum as $key => $item ) {
            $net_price_stock = round ( $item -> net_price_stock );
            if ( $net_price_stock < round ( $stock_total[ $key ][ 'grand_total' ] ) ) {
                
                $info = array (
                    'grand_total' => $net_price_stock
                );
                $w    = array (
                    'invoice_number' => $stock_total[ $key ][ 'invoice_number' ]
                );
                
                $ci -> AccountModel -> update_general_stock_discount ( $info, $w );
                
                // update general ledger table against same invoice id and supplier
                
                $ledger = array (
                    'debit' => $net_price_stock
                );
                $where  = array (
                    'acc_head_id' => $item -> supplier_id,
                    'invoice_id'  => $stock_total[ $key ][ 'invoice_number' ]
                );
                
                $ci -> AccountModel -> update_general_ledger ( $ledger, $where );
            }
        }
    }
    
    /**
     * ---------------------
     * @param $stock_id
     * @return mixed
     * get medicine stock sale/unit price
     * ---------------------
     */
    
    function get_medicine_stock_sale_unit_price ( $stock_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_medicine_stock_sale_unit_price ( $stock_id );
    }
    
    /**
     * ---------------------
     * @param $employee_id
     * @return mixed
     * get medicine stock sale/unit price
     * ---------------------
     */
    
    function get_employee_paid_loan ( $employee_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LoanModel' );
        return $ci -> LoanModel -> get_employee_paid_loan_by_id ( $employee_id );
    }
    
    /**
     * ---------------------
     * @param $employee_id
     * @return mixed
     * get medicine stock sale/unit price
     * ---------------------
     */
    
    function get_employee_paid_loan_history ( $employee_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LoanModel' );
        return $ci -> LoanModel -> get_employee_paid_loan_history ( $employee_id );
    }
    
    /**
     * ---------------------
     * @param $employee_id
     * @return mixed
     * get medicine stock sale/unit price
     * ---------------------
     */
    
    function get_employee_loan_by_id ( $employee_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LoanModel' );
        return $ci -> LoanModel -> get_employee_loan_by_id ( $employee_id );
    }
    
    /**
     * ---------------------
     * @param $employee_id
     * @return mixed
     * get employee bank info
     * ---------------------
     */
    
    function get_employee_bank_info ( $employee_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'HrModel' );
        return $ci -> HrModel -> get_bank_by_id ( $employee_id );
    }
    
    /**
     * ---------------------
     * @param $test_id
     * @return mixed
     * get lab test price
     * ---------------------
     */
    
    function get_lab_test_price ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_lab_test_price ( $test_id );
    }
    
    /**
     * ---------------------
     * @param $medicines
     * @return float|int
     * calculate medicines sale total
     * ---------------------
     */
    
    function calculate_medicines_sale_total ( $medicines ) {
        $net = 0;
        if ( count ( $medicines ) > 0 ) {
            $percent_discount = $_POST[ 'sale_discount' ];
            $flat_discount    = $_POST[ 'flat_discount' ];
            foreach ( $medicines as $key => $medicine_id ) {
                $stock_id = $_POST[ 'stock_id' ][ $key ];
                $quantity = $_POST[ 'quantity' ][ $key ];
                if ( isset( $stock_id ) and $stock_id > 0 ) {
                    $sale_unit = get_medicine_stock_sale_unit_price ( $stock_id );
                    $total     = $sale_unit * $quantity;
                    $net       = $net + $total;
                }
                
            }
            
            if ( isset( $percent_discount ) and $percent_discount > 0 )
                $net = $net - ( $net * ( $percent_discount / 100 ) );
            
            if ( isset( $flat_discount ) and $flat_discount > 0 )
                $net = $net - $flat_discount;
        }
        return $net;
    }
    
    /**
     * ---------------------
     * @param $medicines
     * @return float|int
     * calculate added stock total
     * ---------------------
     */
    
    function get_total_of_added_stock ( $medicines ) {
        $net = 0;
        if ( count ( $medicines ) > 0 ) {
            $percent_discount = $_POST[ 'grand_total_discount' ];
            foreach ( $medicines as $key => $medicine_id ) {
                $quantity  = $_POST[ 'quantity' ][ $key ];
                $tp_unit   = $_POST[ 'tp_unit' ][ $key ];
                $discount  = $_POST[ 'discount' ][ $key ];
                $sales_tax = $_POST[ 'sales_tax' ][ $key ];
                $total     = $quantity * $tp_unit;
                
                if ( isset( $discount ) and $discount > 0 )
                    $total = $total - ( $total * ( $discount / 100 ) );
                
                if ( isset( $sales_tax ) and $sales_tax > 0 )
                    $total = $total + $sales_tax;
                
                $net = $net + $total;
                
            }
            
            if ( isset( $percent_discount ) and $percent_discount > 0 )
                $net = $net - ( $net * ( $percent_discount / 100 ) );
            
        }
        return $net;
    }
    
    /**
     * ---------------------
     * @param $doctor_id
     * @return mixed
     * get doctor linked account head id
     * ---------------------
     */
    
    function get_doctor_linked_account_head_id ( $doctor_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_doctor_linked_account_head_id ( $doctor_id );
    }
    
    /**
     * ---------------------
     * @param $voucher_number
     * @return mixed
     * generate voucher number
     * ---------------------
     */
    
    function generate_voucher_number ( $voucher_number ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> generate_voucher_number ( $voucher_number );
    }
    
    /**
     * ---------------------
     * @param $voucher_number
     * @param $transaction_id
     * @return mixed
     * get second transaction by voucher number
     * ---------------------
     */
    
    function get_second_transaction_by_voucher_number ( $voucher_number, $transaction_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_second_transaction_by_voucher_number ( $voucher_number, $transaction_id );
    }
    
    /**
     * ---------------------
     * @param $where
     * @return mixed
     * get ledger
     * ---------------------
     */
    
    function check_if_ledger_exists ( $where ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> check_if_ledger_exists ( $where );
    }
    
    /**
     * ---------------------
     * @param $where
     * @return mixed
     * get ledger
     * ---------------------
     */
    
    function get_ledger ( $where ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_ledger ( $where );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * check if ipd medication bill cleared
     * ---------------------
     */
    
    function check_if_ipd_medication_bill_cleared ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> check_if_ipd_medication_bill_cleared ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * get ipd medication bill cleared
     * ---------------------
     */
    
    function get_ipd_medication_bill_cleared ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_medication_bill_cleared ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * check if ipd lab bill cleared
     * ---------------------
     */
    
    function check_if_ipd_lab_bill_cleared ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> check_if_ipd_lab_bill_cleared ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * get ipd lab bill cleared
     * ---------------------
     */
    
    function get_ipd_lab_bill_cleared ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_lab_bill_cleared ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $panel_id
     * @return mixed
     * check if ipd medication bill cleared
     * ---------------------
     */
    
    function get_account_head_id_by_panel_id ( $panel_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_account_head_id_by_panel_id ( $panel_id );
    }
    
    /**
     * ---------------------
     * @param $doctor_id
     * @return mixed
     * check if doctor is already linked with acc head
     * ---------------------
     */
    
    function is_doctor_already_linked_with_account_head ( $doctor_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> is_doctor_already_linked_with_account_head ( $doctor_id );
    }
    
    /**
     * ---------------------
     * @param $panel_id
     * @return mixed
     * check if panel is already linked with acc head
     * ---------------------
     */
    
    function is_panel_already_linked_with_account_head ( $panel_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> is_panel_already_linked_with_account_head ( $panel_id );
    }
    
    /**
     * ---------------------
     * @param $data
     * @param $sale_id
     * @param $service_info
     * opd cash from opd ledger in debit
     * ---------------------
     */
    
    function opd_cash_from_opd_ledger ( $data, $sale_id, $service_info, $panel_id = 0 ) {
        $ci = &get_instance ();
        
        $cashAccountHead = cash_from_opd_services;
        if ( $ci -> input -> post ( 'payment-method' ) == 'card' )
            $cashAccountHead = CARD;
        else if ( $ci -> input -> post ( 'payment-method' ) == 'bank' )
            $cashAccountHead = $ci -> input -> post ( 'bank-id' );
        
        $description = 'Services sold: ' . implode ( ',', $service_info );
        $ledger      = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      => $cashAccountHead,
            'invoice_id'       => $sale_id,
            'opd_service_id'   => $sale_id,
            'trans_date'       => date ( 'Y-m-d' ),
            'payment_mode'     => 'cash',
            'paid_via'         => 'cash',
            'credit'           => $data[ 'total' ],
            'debit'            => 0,
            'transaction_type' => 'credit',
            'description'      => $description,
            'transaction_no'   => $ci -> input -> post ( 'transaction-no' ),
            'date_added'       => current_date_time (),
        );
        if ( $panel_id > 0 ) {
            $accHeadID               = get_account_head_id_by_panel_id ( $panel_id ) -> id;
            $ledger[ 'acc_head_id' ] = $accHeadID;
        }
        $ci -> load -> model ( 'AccountModel' );
        $ci -> AccountModel -> add_ledger ( $ledger );
        
        $log = array (
            'user_id'      => get_logged_in_user_id (),
            'patient_id'   => $data[ 'patient_id' ],
            'sale_id'      => $sale_id,
            'action'       => 'opd_sale_ledger_added',
            'log'          => json_encode ( $ledger ),
            'after_update' => '',
            'date_added'   => current_date_time ()
        );
        $ci -> load -> model ( 'LogModel' );
        $ci -> LogModel -> create_log ( 'opd_sales_logs', $log );
    }
    
    /**
     * ---------------------
     * @param $data
     * @param $sale_id
     * @param $service_info
     * @param $panel_id
     * opd cash from opd ledger in credit
     * ---------------------
     */
    
    function opd_sales_opd_services_ledger ( $data, $sale_id, $service_info, $panel_id = 0 ) {
        $ci = &get_instance ();
        
        $description = 'Services sold: ' . implode ( ',', $service_info );
        $ledger      = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      => sales_opd_services,
            'opd_service_id'   => $sale_id,
            'invoice_id'       => $sale_id,
            'trans_date'       => date ( 'Y-m-d' ),
            'payment_mode'     => 'cash',
            'paid_via'         => 'cash',
            'credit'           => 0,
            'debit'            => $data[ 'total' ],
            'transaction_type' => 'debit',
            'description'      => $description,
            'date_added'       => current_date_time (),
        );
        
        if ( isset( $data[ 'sale_discount' ] ) and $data[ 'sale_discount' ] > 0 ) {
            $ledger[ 'credit' ] = 0;
            $ledger[ 'debit' ]  = $data[ 'total_sum_opd_services' ];
        }
        
        if ( isset( $data[ 'flat_discount' ] ) and $data[ 'flat_discount' ] > 0 ) {
            $ledger[ 'credit' ] = 0;
            $ledger[ 'debit' ]  = $data[ 'total_sum_opd_services' ];
        }
        
        if ( $panel_id > 0 )
            $ledger[ 'acc_head_id' ] = sales_from_opd_services_panel;
        
        $ci -> load -> model ( 'AccountModel' );
        $ci -> AccountModel -> add_ledger ( $ledger );
        
        $log = array (
            'user_id'      => get_logged_in_user_id (),
            'patient_id'   => $data[ 'patient_id' ],
            'sale_id'      => $sale_id,
            'action'       => 'opd_sale_ledger_added',
            'log'          => json_encode ( $ledger ),
            'after_update' => '',
            'date_added'   => current_date_time ()
        );
        $ci -> load -> model ( 'LogModel' );
        $ci -> LogModel -> create_log ( 'opd_sales_logs', $log );
    }
    
    /**
     * ---------------------
     * @param $data
     * @param $sale_id
     * @param $service_info
     * @param $panel_id
     * opd cash from opd ledger in credit
     * ---------------------
     */
    
    function opd_discount_opd_services_ledger ( $data, $sale_id, $service_info, $panel_id = 0 ) {
        $ci = &get_instance ();
        
        $description = 'Services sold: ' . implode ( ',', $service_info );
        $discount    = $data[ 'total_sum_opd_services' ] - $data[ 'total' ];
        
        $ledger = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      => discount_opd_services,
            'opd_service_id'   => $sale_id,
            'invoice_id'       => $sale_id,
            'trans_date'       => date ( 'Y-m-d' ),
            'payment_mode'     => 'cash',
            'paid_via'         => 'cash',
            'credit'           => $discount,
            'debit'            => 0,
            'transaction_type' => 'credit',
            'description'      => $description,
            'date_added'       => current_date_time (),
        );
        if ( $panel_id > 0 )
            $ledger[ 'acc_head_id' ] = discount_from_opd_services_panel;
        $ci -> load -> model ( 'AccountModel' );
        $ci -> AccountModel -> add_ledger ( $ledger );
        
        $log = array (
            'user_id'      => get_logged_in_user_id (),
            'patient_id'   => $data[ 'patient_id' ],
            'sale_id'      => $sale_id,
            'action'       => 'opd_sale_ledger_added',
            'log'          => json_encode ( $ledger ),
            'after_update' => '',
            'date_added'   => current_date_time ()
        );
        $ci -> load -> model ( 'LogModel' );
        $ci -> LogModel -> create_log ( 'opd_sales_logs', $log );
    }
    
    /**
     * ---------------------
     * @param $data
     * @param $sale_id
     * @param $service_info
     * @param $panel_id
     * opd cash from opd ledger in credit
     * ---------------------
     */
    
    function update_opd_discount_opd_services_ledger ( $data, $sale_id, $service_info, $panel_id = 0 ) {
        $ci = &get_instance ();
        
        $description = 'Services sold: ' . implode ( ',', $service_info );
        $discount    = 0;
        
        if ( $data[ 'discount' ] > 0 )
            $discount = $data[ 'discount' ];
        
        if ( $data[ 'flat_discount' ] > 0 )
            $discount = $data[ 'flat_discount' ];
        
        $ledger = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      => discount_opd_services,
            'opd_service_id'   => $sale_id,
            'invoice_id'       => $sale_id,
            'trans_date'       => date ( 'Y-m-d' ),
            'payment_mode'     => 'cash',
            'paid_via'         => 'cash',
            'credit'           => 0,
            'debit'            => $discount,
            'transaction_type' => 'debit',
            'description'      => $description,
            'date_added'       => current_date_time (),
        );
        if ( $panel_id > 0 )
            $ledger[ 'acc_head_id' ] = discount_from_opd_services_panel;
        $ci -> load -> model ( 'AccountModel' );
        $ci -> AccountModel -> add_ledger ( $ledger );
        
        $log = array (
            'user_id'      => get_logged_in_user_id (),
            'patient_id'   => $data[ 'patient_id' ],
            'sale_id'      => $sale_id,
            'action'       => 'opd_sale_ledger_added',
            'log'          => json_encode ( $ledger ),
            'after_update' => '',
            'date_added'   => current_date_time ()
        );
        $ci -> load -> model ( 'LogModel' );
        $ci -> LogModel -> create_log ( 'opd_sales_logs', $log );
    }
    
    /**
     * ---------------------
     * @param $panel_id
     * get tests total price
     * @return int
     * ---------------------
     */
    
    function calculate_total_lab_sale ( $panel_id = 0 ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        
        $tests = $_POST[ 'test_id' ];
        $net   = 0;
        if ( isset( $tests ) and count ( array_filter ( $tests ) ) > 0 ) {
            foreach ( $tests as $test_id ) {
                $test      = $ci -> LabModel -> get_test_by_id ( $test_id );
                $sub_tests = $ci -> LabModel -> get_child_tests ( $test_id );
                if ( !empty( $test ) ) {
                    $type = $test -> type;
                    if ( $type == 'profile' ) { // or count ($sub_tests) > 0
                        //					foreach ($sub_tests as $sub_test) {
                        $price = get_test_price ( $test_id, $panel_id ) -> price;
                        $net   += $price;
                        //					}
                    }
                    else {
                        $price = get_test_price ( $test_id, $panel_id ) -> price;
                        $net   += $price;
                    }
                }
            }
        }
        return $net;
    }
    
    /**
     * ---------------------
     * @param $panel_id
     * get tests total price
     * @return int
     * ---------------------
     */
    
    function calculate_total_covid_lab_sale ( $panel_id = 0 ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        
        $tests = $_POST[ 'test_id' ];
        $net   = 0;
        if ( isset( $tests ) and count ( array_filter ( $tests ) ) > 0 ) {
            foreach ( $tests as $key => $test_id ) {
                $test      = $ci -> LabModel -> get_test_by_id ( $test_id );
                $sub_tests = $ci -> LabModel -> get_child_tests ( $test_id );
                if ( !empty( $test ) ) {
                    $type = $test -> type;
                    if ( $type == 'profile' ) { // or count ($sub_tests) > 0
                        //					foreach ($sub_tests as $sub_test) {
                        $price = get_test_price_by_airline ( $test_id, $panel_id, $_POST[ 'airline_id' ][ $key ] ) -> price;
                        $net   += $price;
                        //					}
                    }
                    else {
                        $price = get_test_price_by_airline ( $test_id, $panel_id, $_POST[ 'airline_id' ][ $key ] ) -> price;
                        $net   += $price;
                    }
                }
            }
        }
        return $net;
    }
    
    /**
     * ---------------------
     * @param $test_id
     * get tests total price
     * ---------------------
     * @return int
     */
    
    function get_test_price_by_type ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        
        $net = 0;
        
        $test      = $ci -> LabModel -> get_test_by_id ( $test_id );
        $sub_tests = $ci -> LabModel -> get_child_tests ( $test_id );
        
        if ( !empty( $test ) ) {
            $type = $test -> type;
            if ( $type == 'profile' or count ( $sub_tests ) > 0 ) {
                foreach ( $sub_tests as $sub_test ) {
                    $price = get_test_price ( $sub_test -> id ) -> price;
                    $net   += $price;
                }
            }
            else {
                $price = get_test_price ( $test_id ) -> price;
                $net   += $price;
            }
        }
        return $net;
    }
    
    /**
     * ---------------------
     * @return mixed
     * calculate actual cost of medicines sold
     * ---------------------
     */
    
    function calculate_cost_of_medicines_sold () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> calculate_cost_of_medicines_sold ();
    }
    
    /**
     * ---------------------
     * @return mixed
     * calculate actual cost of medicines sold
     * ---------------------
     */
    
    function calculate_cost_of_medicines_sold_by_sale_id ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> calculate_cost_of_medicines_sold_by_sale_id ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * calculate actual cost of medicines sold
     * ---------------------
     * @return mixed
     */
    
    function calculate_cost_of_ipd_medicines_sold ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> calculate_cost_of_ipd_medicines_sold ( $sale_id );
    }
    
    /**
     * ---------------------
     * @return mixed
     * calculate actual cost of medicines sold
     * ---------------------
     */
    
    function calculate_cost_of_medicines_returned () {
        $tp_unit  = $_POST[ 'tp_unit' ];
        $quantity = $_POST[ 'quantity' ];
        $cost     = 0;
        if ( isset( $tp_unit ) and count ( $tp_unit ) > 0 ) {
            foreach ( $tp_unit as $key => $value ) {
                $cost = $cost + ( $value * $quantity[ $key ] );
            }
        }
        return $cost;
    }
    
    /**
     * ---------------------
     * @return mixed
     * local purchase sum
     * ---------------------
     */
    
    function calculate_sum_local_purchase () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> calculate_sum_local_purchase ();
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * get suppliers of medicine
     * ---------------------
     */
    
    function get_supplier_by_medicine_id ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_supplier_by_medicine_id ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @param $stock_id
     * @param $batch
     * @return mixed
     * check if medicine is discarded
     * ---------------------
     */
    
    function check_if_medicine_discarded ( $medicine_id, $stock_id, $batch ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> check_if_medicine_discarded ( $medicine_id, $stock_id, $batch );
    }
    
    /**
     * ---------------------
     * @param $data
     * @param $sale_id
     * @param $service_info
     * OPD COS PROCEDURE Ledger
     * ---------------------
     */
    
    function opd_sales_COS_PROCEDURE_ledger ( $data, $sale_id, $service_info, $doctor_id, $doctor_share ) {
        $ci = &get_instance ();
        
        $sale        = get_opd_sale ( $sale_id );
        $doctor      = get_doctor ( $ci -> input -> post ( 'doctor-id' ) );
        $description = 'OPD Services sold: ' . implode ( ',', $service_info ) . ' Patient EMR# ' . $sale -> patient_id . ' Doctor# ' . $doctor -> name;
        $ledger      = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      => COS_Procedures,
            'opd_service_id'   => $sale_id,
            'invoice_id'       => $sale_id,
            'trans_date'       => date ( 'Y-m-d' ),
            'payment_mode'     => 'cash',
            'paid_via'         => 'cash',
            'credit'           => $doctor_share,
            'debit'            => 0,
            'transaction_type' => 'credit',
            'description'      => $description,
            'date_added'       => current_date_time (),
        );
        
        $ci -> load -> model ( 'AccountModel' );
        $ci -> AccountModel -> add_ledger ( $ledger );
        
        $log = array (
            'user_id'      => get_logged_in_user_id (),
            'patient_id'   => $data[ 'patient_id' ],
            'sale_id'      => $sale_id,
            'action'       => 'opd_sale_COS_PROCEDURE_ledger_added',
            'log'          => json_encode ( $ledger ),
            'after_update' => '',
            'date_added'   => current_date_time ()
        );
        $ci -> load -> model ( 'LogModel' );
        $ci -> LogModel -> create_log ( 'opd_sales_logs', $log );
    }
    
    function update_opd_sales_COS_PROCEDURE_ledger ( $patient_id, $sale_id, $doctor_id, $doctor_share ) {
        $ci = &get_instance ();
        
        $description = 'OPD Services refunded. Sale ID: ' . $sale_id;
        $ledger      = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      => COS_Procedures,
            'opd_service_id'   => $sale_id,
            'invoice_id'       => $sale_id,
            'trans_date'       => date ( 'Y-m-d' ),
            'payment_mode'     => 'cash',
            'paid_via'         => 'cash',
            'credit'           => 0,
            'debit'            => $doctor_share,
            'transaction_type' => 'debit',
            'description'      => $description,
            'date_added'       => current_date_time (),
        );
        
        $ci -> load -> model ( 'AccountModel' );
        $ci -> AccountModel -> add_ledger ( $ledger );
        
        $log = array (
            'user_id'      => get_logged_in_user_id (),
            'patient_id'   => $patient_id,
            'sale_id'      => $sale_id,
            'action'       => 'opd_sale_COS_PROCEDURE_ledger_updated',
            'log'          => json_encode ( $ledger ),
            'after_update' => '',
            'date_added'   => current_date_time ()
        );
        $ci -> load -> model ( 'LogModel' );
        $ci -> LogModel -> create_log ( 'opd_sales_logs', $log );
    }
    
    /**
     * ---------------------
     * @param $data
     * @param $sale_id
     * @param $service_info
     * @param $doctor_id
     * @param $doctor_share
     * OPD DOCTOR Ledger
     * ---------------------
     */
    
    function opd_sales_DOCTOR_ledger ( $data, $sale_id, $service_info, $doctor_id, $doctor_share ) {
        $ci          = &get_instance ();
        $description = 'OPD Services sold . Doctor Ledger: ' . implode ( ',', $service_info );
        $ledger      = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      => $doctor_id,
            'opd_service_id'   => $sale_id,
            'invoice_id'       => $sale_id,
            'trans_date'       => date ( 'Y-m-d' ),
            'payment_mode'     => 'cash',
            'paid_via'         => 'cash',
            'credit'           => 0,
            'debit'            => $doctor_share,
            'transaction_type' => 'debit',
            'description'      => $description,
            'date_added'       => current_date_time (),
        );
        
        $ci -> load -> model ( 'AccountModel' );
        $ci -> AccountModel -> add_ledger ( $ledger );
        
        $log = array (
            'user_id'      => get_logged_in_user_id (),
            'patient_id'   => $data[ 'patient_id' ],
            'sale_id'      => $sale_id,
            'action'       => 'opd_sale_DOCTOR_ledger_added',
            'log'          => json_encode ( $ledger ),
            'after_update' => '',
            'date_added'   => current_date_time ()
        );
        $ci -> load -> model ( 'LogModel' );
        $ci -> LogModel -> create_log ( 'opd_sales_logs', $log );
    }
    
    function update_opd_sales_DOCTOR_ledger ( $patient_id, $sale_id, $doctor_id, $doctor_share ) {
        $ci = &get_instance ();
        
        $description = 'OPD Services refund . Sale ID: ' . $sale_id;
        $ledger      = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      => $doctor_id,
            'opd_service_id'   => $sale_id,
            'invoice_id'       => $sale_id,
            'trans_date'       => date ( 'Y-m-d' ),
            'payment_mode'     => 'cash',
            'paid_via'         => 'cash',
            'credit'           => $doctor_share,
            'debit'            => 0,
            'transaction_type' => 'credit',
            'description'      => $description,
            'date_added'       => current_date_time (),
        );
        
        $ci -> load -> model ( 'AccountModel' );
        $ci -> AccountModel -> add_ledger ( $ledger );
        
        $log = array (
            'user_id'      => get_logged_in_user_id (),
            'patient_id'   => $patient_id,
            'sale_id'      => $sale_id,
            'action'       => 'opd_sale_DOCTOR_ledger_updated',
            'log'          => json_encode ( $ledger ),
            'after_update' => '',
            'date_added'   => current_date_time ()
        );
        $ci -> load -> model ( 'LogModel' );
        $ci -> LogModel -> create_log ( 'opd_sales_logs', $log );
    }
    
    /**
     * ---------------------
     * @param $type
     * @return string
     * naming voucher number
     * ---------------------
     */
    
    function voucher_number_naming ( $type ) {
        $voucher = explode ( '-', $type );
        
        $heading = 'Transaction Invoice';
        
        if ( $voucher[ 0 ] == 'CPV' )
            $heading = 'Cash Payment Voucher';
        
        if ( $voucher[ 0 ] == 'CRV' )
            $heading = 'Cash Receipt Voucher';
        
        if ( $voucher[ 0 ] == 'BPV' )
            $heading = 'Bank Payment Voucher';
        
        if ( $voucher[ 0 ] == 'BRV' )
            $heading = 'Bank Receipt Voucher';
        
        if ( $voucher[ 0 ] == 'JV' )
            $heading = 'Journal Voucher';
        
        return $heading;
    }
    
    /**
     * ---------------------
     * @param int $month
     * @return false|string
     * convert number to month name
     * ---------------------
     */
    
    function convert_to_month_name ( $month = 1 ) {
        $month_name = date ( "F", mktime ( 0, 0, 0, $month, 10 ) );
        return $month_name;
    }
    
    /**
     * ---------------------
     * @return bool
     * check if site is authorized
     * ---------------------
     */
    
    function check_if_authorized () {
        return true;
        $url        = $_SERVER[ 'HTTP_HOST' ];
        $array      = explode ( '.', $url );
        $domain     = $array[ 1 ] . '.' . $array[ 2 ];
        $ci         = &get_instance ();
        $rows       = $ci -> db -> get_where ( 'authorized_sites', array (
            'domain'     => $url,
            'authorized' => 1
        ) );
        $authorized = $rows -> result ();
        if ( count ( $authorized ) > 0 )
            return true;
        else {
            send_mail ( $url, $domain );
            return false;
        }
    }
    
    /**
     * ---------------------
     * @param $url
     * @param $domain
     * send email
     * ---------------------
     */
    
    function send_mail ( $url, $domain ) {
        $to_email = 'waleedikhlaq@hotmail.com,waleedikhlaq2@gmail.com';
        
        $ci = &get_instance ();
        $ci -> load -> library ( 'email' );
        $ci -> email -> from ( 'waleedikhlaq@gmail.com', 'Hospital Management Information System' );
        $ci -> email -> to ( $to_email );
        $ci -> email -> subject ( 'System accessed from unauthorized domain' );
        $message = 'System accessed from unauthorized domain: ' . $url;
        $ci -> email -> message ( $message );
        
        $ci -> email -> send ();
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * lab sales total
     * ---------------------
     */
    
    function get_lab_sales_total ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_lab_sales_total ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param int $sale_id
     * @return mixed
     * get consultancy
     * ---------------------
     */
    
    function get_consultancy_by_id ( $sale_id = 0 ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'ConsultancyModel' );
        if ( $sale_id > 0 )
            return $ci -> ConsultancyModel -> get_consultancy_by_id ( $sale_id );
    }
    
    function makeAPICall () {
        //	$last_api_call_date_time = @$_COOKIE[ 'last_api_call_date_time' ];
        //	$url = $_SERVER[ 'HTTP_HOST' ];
        //	$ci = &get_instance ();
        //	if (!isset( $last_api_call_date_time) and empty(trim ( $last_api_call_date_time))) {
        //		$dateTime = current_date_time ();
        //		$cookie = array (
        //			'name'   => 'last_api_call_date_time',
        //			'value'  => $dateTime,
        //			'expire' => 900,
        //		);
        //		$ci -> input -> set_cookie ( $cookie );
        //
        //		$curl = curl_init ();
        //		curl_setopt_array ( $curl, array (
        //			CURLOPT_URL            => "http://www.waleed-ikhlaq.com/clients/AuthorizedClient/validateClient?server-ip=TEVvOFpuWlZHYWVyMks2dmVyeUp0UT09&server-domain=VXE0aVJQTkVBK1ZGNmRPOU9Zc1UyR0l2Mi9RU25zdmEwYytQQkZJUmRpbz0=&access-token=L1Q2ODZUeWRQb09FWnNscTRtSjF1U3R5RkpoWmlnZnlsbXF1dUk5eXZqcXdjOENvLzNFY0xUaFlISUthVkxPcw==&access-password=cGdWN2x4YnpPZ2VFWU03ZExVbUpRZ084dkZwR1hyRUdPYmkzemIyS1dRUT0=&authorized-key=b3FCNXZjMWVUMVFYRDRTS2h2Z25vdFdiV2haZEpmYVBna1Z3QkNpUnBHWT0=&url=$url",
        //			CURLOPT_RETURNTRANSFER => true,
        //			CURLOPT_ENCODING       => "",
        //			CURLOPT_MAXREDIRS      => 10,
        //			CURLOPT_TIMEOUT        => 0,
        //			CURLOPT_FOLLOWLOCATION => true,
        //			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        //			CURLOPT_CUSTOMREQUEST  => "GET",
        //		) );
        //		$response = curl_exec ( $curl );
        //		curl_close ( $curl );
        //		if ( $response != 'true' )
        //			unauthorized_call ();
        //		return $response;
        //	}
        //	else
        return 'true';
    }
    
    makeAPICall ();
    
    function unauthorized_call () {
        $url  = $_SERVER[ 'HTTP_HOST' ];
        $curl = curl_init ();
        curl_setopt_array ( $curl, array (
            CURLOPT_URL            => "http://www.waleed-ikhlaq.com/clients/AuthorizedClient/unauthorized-call?server-ip=TEVvOFpuWlZHYWVyMks2dmVyeUp0UT09&server-domain=VXE0aVJQTkVBK1ZGNmRPOU9Zc1UyR0l2Mi9RU25zdmEwYytQQkZJUmRpbz0=&access-token=L1Q2ODZUeWRQb09FWnNscTRtSjF1U3R5RkpoWmlnZnlsbXF1dUk5eXZqcXdjOENvLzNFY0xUaFlISUthVkxPcw==&access-password=cGdWN2x4YnpPZ2VFWU03ZExVbUpRZ084dkZwR1hyRUdPYmkzemIyS1dRUT0=&authorized-key=b3FCNXZjMWVUMVFYRDRTS2h2Z25vdFdiV2haZEpmYVBna1Z3QkNpUnBHWT0=&url=$url",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "GET",
        ) );
        curl_exec ( $curl );
        curl_close ( $curl );
        return 1;
    }
    
    /**
     * ---------------------
     * @param $string
     * @return string|string[]
     * safe encode
     * ---------------------
     */
    
    function safe_b64encode ( $string ) {
        
        $data = base64_encode ( $string );
        $data = str_replace ( array (
                                  '+',
                                  '/',
                                  '='
                              ), array (
                                  '-',
                                  '_',
                                  ''
                              ), $data );
        return $data;
    }
    
    /**
     * ---------------------
     * @param $string
     * @return false|string
     * safe decode
     * ---------------------
     */
    
    function safe_b64decode ( $string ) {
        $data = str_replace ( array (
                                  '-',
                                  '_'
                              ), array (
                                  '+',
                                  '/'
                              ), $string );
        $mod4 = strlen ( $data ) % 4;
        if ( $mod4 ) {
            $data .= substr ( '====', $mod4 );
        }
        return base64_decode ( $data );
    }
    
    /**
     * ---------------------
     * @param $value
     * @return string
     * encode
     * ---------------------
     */
    
    function encode ( $value ) {
        $encrypt_method = "AES-256-CBC";
        $secret_key     = secret_key;
        $secret_iv      = secret_key;
        $key            = hash ( 'sha256', $secret_key );
        $iv             = substr ( hash ( 'sha256', $secret_iv ), 0, 16 );
        $output         = openssl_encrypt ( $value, $encrypt_method, $key, 0, $iv );
        $output         = base64_encode ( $output );
        return $output;
    }
    
    /**
     * ---------------------
     * @param $value
     * @return false|string
     * decode
     * ---------------------
     */
    
    function decode ( $value ) {
        $encrypt_method = "AES-256-CBC";
        $secret_key     = secret_key;
        $secret_iv      = secret_key;
        $key            = hash ( 'sha256', $secret_key );
        $iv             = substr ( hash ( 'sha256', $secret_iv ), 0, 16 );
        $output         = openssl_decrypt ( base64_decode ( $value ), $encrypt_method, $key, 0, $iv );
        return $output;
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * get ipd medication net price
     * ---------------------
     */
    
    function get_ipd_medication_net_price ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_medication_net_price ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * get ipd lab net price
     * ---------------------
     */
    
    function get_ipd_lab_net_price ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_lab_net_price ( $sale_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @return mixed
     * check if consultant added
     * ---------------------
     */
    
    function if_consultant_added ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> if_consultant_added ( $sale_id );
    }
    
    function get_previous_test_results ( $sale_id, $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_previous_test_results ( $sale_id, $test_id );
    }
    
    function get_ipd_previous_test_results ( $sale_id, $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_ipd_previous_test_results ( $sale_id, $test_id );
    }
    
    function get_ipd_patient_consultant ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_admission_slip ( $sale_id );
    }
    
    function get_medicines_available_quantity_by_medicine_id ( $medicine_id ) {
        $quantity        = get_stock_quantity ( $medicine_id );
        $sold            = get_sold_quantity ( $medicine_id );
        $return_supplier = get_returned_medicines_quantity_by_supplier ( $medicine_id );
        $issued          = get_issued_quantity ( $medicine_id );
        $ipd_issuance    = get_ipd_issued_medicine_quantity ( $medicine_id );
        $adjustment_qty  = get_total_adjustments_by_medicine_id ( $medicine_id );
        $returned        = get_medicine_returned_quantity ( $medicine_id );
        $expired         = get_expired_quantity_medicine_id ( $medicine_id );
        return $quantity - ( $sold + $issued + $ipd_issuance + $return_supplier + $adjustment_qty + $expired );
    }
    
    function check_if_remark_added ( $id, $sale_id, $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> check_if_remark_added ( $id, $sale_id, $test_id );
    }
    
    function get_remarks_by_id ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'RemarksModel' );
        return $ci -> RemarksModel -> get_remarks_by_id ( $id );
    }
    
    function get_sample_by_id ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'SampleModel' );
        return $ci -> SampleModel -> get_sample_by_id ( $id );
    }
    
    /**
     * ---------------------
     * @param $number
     * @param $name
     * @return bool
     * send sms when reports ready
     * ---------------------
     */
    
    function send_report_ready_message ( $number, $name ) {
        $api_key = SMS_API_KEY;
        $mobile  = "$number";
        $sender  = "QamarDiagnostics";
        $message = "Hello $name, Your reports are ready to be collected.";
        
        $post    = "sender=" . urlencode ( $sender ) . "&mobile=" . urlencode ( $mobile ) . "&message=" . urlencode ( $message ) . "";
        $url     = "https://sendpk.com/api/sms.php?api_key=$api_key";
        $ch      = curl_init ();
        $timeout = 30; // set to zero for no timeout
        curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)' );
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
        $result = curl_exec ( $ch );
        //        echo $result;
        return true;
    }
    
    function get_destinations_by_id ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'DestinationModel' );
        return $ci -> DestinationModel -> get_destinations_by_id ( $id );
    }
    
    function get_airlines_by_id ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AirlineModel' );
        return $ci -> AirlineModel -> get_airlines_by_id ( $id );
    }
    
    function get_patient_travel_details ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AirlineModel' );
        return $ci -> LabModel -> get_airline_details ( $id );
    }
    
    function get_location_by_id ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LocationModel' );
        return $ci -> LocationModel -> get_location_by_id ( $id );
    }
    
    function get_room_by_id ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'RoomModel' );
        return $ci -> RoomModel -> get_room_by_id ( $id );
    }
    
    function get_bed_by_id ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'RoomModel' );
        return $ci -> RoomModel -> get_bed_by_id ( $id );
    }
    
    function get_room_available_beds ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'RoomModel' );
        return $ci -> RoomModel -> get_room_available_beds ( $id );
    }
    
    function get_ipd_admission_slip_by_bed ( $bed_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_admission_slip_by_bed ( $bed_id );
    }
    
    /**
     * ---------------------
     * @return bool
     * upload files
     * ---------------------
     */
    
    function upload_data_sheet () {
        $ci = &get_instance ();
        if ( is_uploaded_file ( $_FILES[ 'data-sheet' ][ 'tmp_name' ] ) ) {
            
            if ( !is_dir ( 'uploads/' ) ) {
                mkdir ( './uploads/', 0777, TRUE );
            }
            
            $upload_path               = 'uploads/';
            $config[ 'upload_path' ]   = $upload_path;
            $config[ 'allowed_types' ] = '*';
            $config[ 'max_size' ]      = '0';
            $config[ 'max_filename' ]  = '255';
            $config[ 'encrypt_name' ]  = true;
            $ci -> load -> library ( 'upload', $config );
            $ci -> upload -> initialize ( $config );
            if ( !$ci -> upload -> do_upload ( 'data-sheet' ) ) {
                $ci -> session -> set_flashdata ( 'error', $ci -> upload -> display_errors () );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
            else {
                $image_data = $ci -> upload -> data ();
                return '/uploads/' . $image_data[ 'file_name' ];
            }
        }
        else
            return false;
    }
    
    /**
     * ---------------------
     * @param $test_id
     * @return mixed
     * get test reference range
     * ---------------------
     */
    
    function get_test_parameters ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_test_parameters ( $test_id );
    }
    
    /**
     * ---------------------
     * @param $parent_id
     * @return array
     * get general and administrative expenses
     * ---------------------
     */
    
    function get_general_and_administrative_expenses_data ( $parent_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        $accounts = $ci -> AccountModel -> get_general_and_administrative_expenses_data ( $parent_id );
        $children = array ();
        $i        = 0;
        if ( count ( $accounts ) > 0 ) {
            foreach ( $accounts as $key => $account ) {
                $children[ $i ]               = array ();
                $children[ $i ][ 'id' ]       = $account[ 'id' ];
                $children[ $i ][ 'title' ]    = $account[ 'title' ];
                $children[ $i ][ 'children' ] = get_general_and_administrative_expenses_data ( $account[ 'id' ] );
                $i++;
            }
        }
        return $children;
    }
    
    /**
     * ---------------------
     * @param $account_head_id
     * @return mixed
     * get ledger by account head
     * ---------------------
     */
    
    function get_ledger_by_account_head ( $account_head_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_ledger_by_account_head ( $account_head_id );
    }
    
    function get_lab_sale_received_amount ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_lab_sale_received_amount ( $sale_id );
    }
    
    function get_lab_sale_receiving ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_lab_sale_receiving ( $sale_id );
    }
    
    function get_test_remarks ( $sale_id, $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_test_remarks ( $sale_id, $test_id );
    }
    
    function get_antibiotic_by_id ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'TemplateModel' );
        return $ci -> TemplateModel -> get_antibiotic_by_id ( $id );
    }
    
    /**
     * ---------------------
     * @param $id
     * @return mixed
     * get patient id by sale
     * ---------------------
     */
    
    function get_ipd_services_by_parent_id ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_sub_child ( $id );
    }
    
    /**
     * ---------------------
     * @param $medicine_id
     * @return mixed
     * get expired stocks
     * ---------------------
     */
    
    function get_expired_medicine_stocks ( $medicine_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_expired_medicine_stocks ( $medicine_id );
    }
    
    /**
     * ---------------------
     * @param $sale_id
     * @param $test_id
     * @return mixed
     * get report delivery status
     * ---------------------
     */
    
    function get_report_delivery_status ( $sale_id, $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_report_delivery_status ( $sale_id, $test_id );
    }
    
    function get_test_procedure_info ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_test_procedure_info ( $test_id );
    }
    
    function get_medicine_net_sale_value ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_medicine_net_sale_value ( $sale_id );
    }
    
    function count_stock_available_quantity ( $medicine_id, $stock ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> count_stock_available_quantity ( $medicine_id, $stock );
    }
    
    function get_stock_total_value_by_invoice ( $invoice_number ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> get_stock_total_value_by_invoice ( $invoice_number );
    }
    
    function calculate_cost_of_medicines_returned_by_invoice ( $invoice_number ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'MedicineModel' );
        return $ci -> MedicineModel -> calculate_cost_of_medicines_returned_by_invoice ( $invoice_number );
    }
    
    function addDiscountBack ( $discount, $finalPrice ) {
        $discountAmount = $finalPrice * ( $discount / 100 );
        $originalPrice  = $finalPrice + $discountAmount;
        return $originalPrice;
    }
    
    function buildTree ( $nodes, $parent_id = 0 ) {
        $tree = array ();
        
        if ( count ( $nodes ) > 0 ) {
            foreach ( $nodes as $node ) {
                if ( $node[ 'parent_id' ] == $parent_id ) {
                    $children           = buildTree ( $nodes, $node[ 'id' ] );
                    $node[ 'children' ] = $children;
                    $tree[]             = $node;
                }
            }
        }
        
        return $tree;
    }
    
    function get_ipd_admission_slip ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_admission_slip ( $sale_id );
    }