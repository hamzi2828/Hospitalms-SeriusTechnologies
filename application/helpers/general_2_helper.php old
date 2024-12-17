<?php
    
    function get_report_verify_status ( $report_id, $table ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'RadiologyModel' );
        return $ci -> RadiologyModel -> get_report_verify_status ( $report_id, $table );
    }
    
    function delete_report_verify_status ( $report_id, $table ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'RadiologyModel' );
        return $ci -> RadiologyModel -> delete_report_verify_status ( $report_id, $table );
    }
    
    function get_package_by_id ( $package_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_package_by_id ( $package_id );
    }
    
    function get_sold_items_count ( $department_id, $item_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StoreModel' );
        return $ci -> StoreModel -> get_issued_items_by_dept_item_id_date ( $department_id, $item_id );
    }
    
    function get_medicine_name ( $medicine ) {
        $name = $medicine -> name;
        if ( $medicine -> form_id > 1 ) :
            $name .= get_form ( $medicine -> form_id ) -> title;
        endif;
        if ( $medicine -> strength_id > 1 ) :
            $name .= get_strength ( $medicine -> strength_id ) -> title;
        endif;
        return $name;
    }
    
    function calculate_depreciation_value ( $purchase_date, $value, $depreciation, $depreciation_charge, $year, $depSum, $disposed = null ) {
        $ci         = &get_instance ();
        $start_date = $ci -> input -> get ( 'start-date' );
        $end_date   = $ci -> input -> get ( 'end-date' );
        $counter    = 0;
        $initial    = $value * ( ( $depreciation ) / 100 );
        
        if ( !empty( trim ( $start_date ) ) && !empty( trim ( $end_date ) ) ) {
            
            if ( !empty( $disposed ) && $year > date ( 'Y', strtotime ( $disposed -> dispose_date ) ) ) {
                return 0;
            }
            
            $as_of_date  = date ( 'm-d', strtotime ( $end_date ) );
            $first_date  = new DateTime( $year . '-' . $as_of_date );
            $second_date = new DateTime( $purchase_date );
            $interval    = $second_date -> diff ( $first_date );
            $years       = (int)$interval -> format ( "%r%y" );
            
            if ( $depreciation_charge == 'annual' ) {
                if ( $years > 0 )
                    $depreciated_value = $value * ( ( $depreciation ) / 100 );
                else if ( $first_date >= $second_date ) {
                    $date1             = $purchase_date;
                    $date2             = $year . '-' . $as_of_date;
                    $diff              = abs ( strtotime ( $date2 ) - strtotime ( $date1 ) );
                    $years             = floor ( $diff / ( 365 * 60 * 60 * 24 ) );
                    $months            = floor ( ( $diff - $years * 365 * 60 * 60 * 24 ) / ( 30 * 60 * 60 * 24 ) );
                    $depreciated_value = $months > 0 ? ( $value * ( $depreciation / 100 ) ) : 0;
                    $depreciated_value = ( $depreciated_value / 12 ) * $months;
                }
                else
                    $depreciated_value = 0;
            }
            else {
                $purchase_date_year = date ( 'Y', strtotime ( $purchase_date ) );
                
                if ( $year >= $purchase_date_year ) {
                    $counter++;
                    $years             = $counter;
                    $depreciated_value = $value * ( ( $depreciation * $years ) / 100 );
                }
                else
                    $depreciated_value = 0;
            }
            return $depreciated_value;
        }
        
        return 0;
        
    }
    
    function calculate_total_accumulative_depreciation ( $report ) {
        $ci                 = &get_instance ();
        $netAccumulativeDep = 0;
        $netPrice           = 0;
        $wdv                = 0;
        $netWDV             = 0;
        $month              = date ( 'm' );
        $year               = date ( 'Y' );
        $financial_year     = date ( $year . '-07' );
        
        $itemDepreciation = array ();
        $depreciation     = 0;
        $disposed         = get_store_disposed_asset ( $report -> id );
        $acc_head         = get_account_head ( $report -> account_head_id );
        $netPrice         += $report -> value;
        $totalValue       = $report -> value;
        $depreciationRate = ( $report -> depreciation / 100 ); // 10%
        $netAccumulative  = 0;
        $filter_date      = strtotime ( date ( $year . '-' . $month ) );
        $searchDateTime   = strtotime ( date ( $year . '-' . $month . '-01' ) );
        $purchaseDateTime = strtotime ( $report -> purchase_date );
        $numberOfMonths   = ( date ( 'Y', $searchDateTime ) - date ( 'Y', $purchaseDateTime ) ) * 12 + ( date ( 'm', $searchDateTime ) - date ( 'm', $purchaseDateTime ) );
        
        for ( $i = 0; $i < $numberOfMonths; $i++ ) {
            $monthlyDepreciationExpense          = ( $totalValue * $depreciationRate ) / 12;
            $totalValue                          -= $monthlyDepreciationExpense;
            $netAccumulative                     += $monthlyDepreciationExpense;
            $itemDepreciation[ $report -> id ][] = $monthlyDepreciationExpense;
        }
        
        $depreciation = round ( $netAccumulative, 2 );
        $wdv          = ( $report -> value - $depreciation );
        
        if ( !empty( $disposed ) ) {
            $dispose_date = strtotime ( date ( 'Y-m', strtotime ( $disposed -> dispose_date ) ) );
            if ( $filter_date > $dispose_date )
                $wdv = 0;
            
            if ( $filter_date >= $dispose_date && count ( $itemDepreciation ) > 0 ) {
                $lastDepreciation = end ( $itemDepreciation[ $report -> id ] );
                $depreciation     -= round ( $lastDepreciation, 2 );
            }
            
            if ( $filter_date > strtotime ( $financial_year ) ) {
                $depreciation    = 0;
                $netAccumulative = 0;
            }
        }
        
        $netWDV             += $wdv;
        $netAccumulativeDep += $depreciation;
        return $netAccumulativeDep;
    }

//    function calculate_total_accumulative_depreciation ( $purchase_date, $value, $depreciation, $depreciation_charge ) {
//        $ci                = &get_instance ();
//        $depreciated_value = 0;
//        $end_date          = $ci -> input -> get ( 'end-date' );
//
//        if ( empty( trim ( $end_date ) ) )
//            $end_date = date ( 'Y-m-d' );
//
//        if ( !empty( trim ( $end_date ) ) ) {
//
//            $first_date  = new DateTime( $end_date );
//            $second_date = new DateTime( $purchase_date );
//            $interval    = $second_date -> diff ( $first_date );
//            $years       = (int)$interval -> format ( "%r%y" );
//
//            if ( $years >= 0 ) {
//                if ( $depreciation_charge == 'annual' )
//                    $depreciated_value = ( $value * ( $depreciation / 100 ) ) * $years;
//                else {
//                    if ( date ( 'Y', strtotime ( $purchase_date ) ) <= date ( 'Y', strtotime ( $end_date ) ) )
//                        $years = ( date ( 'Y', strtotime ( $end_date ) ) - date ( 'Y', strtotime ( $purchase_date ) ) ) + 1;
//
//                    $depreciated_value = ( $value * ( $depreciation / 100 ) ) * $years;
//                }
//            }
//        }
//        return min ( $depreciated_value, $value );
//    }
    
    function string_to_title ( $string ) {
        return ucwords ( str_replace ( '-', ' ', $string ) );
    }
    
    function is_item_disposed ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StoreModel' );
        return $ci -> StoreModel -> is_item_disposed ( $id );
    }
    
    function get_store_disposed_quantity ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StoreModel' );
        return $ci -> StoreModel -> get_store_disposed_quantity ( $id );
    }
    
    function get_store_disposed_asset ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'StoreModel' );
        return $ci -> StoreModel -> get_store_disposed_asset ( $id );
    }
    
    function get_patient_name ( $id = 0, $patient = null ) {
        if ( $id > 0 )
            $patient = get_patient_by_id ( $id );
        
        return $patient -> prefix . ' ' . $patient -> name;
    }
    
    function get_patient_age ( $id = 0, $patient = null ) {
        if ( $id > 0 )
            $patient = get_patient_by_id ( $id );
        
        return $patient -> age . ' ' . $patient -> age_year_month;
    }
    
    function get_patient_gender ( $id = 0, $patient = null ) {
        if ( $id > 0 )
            $patient = get_patient_by_id ( $id );
        
        if ( $patient -> gender == '0' )
            return 'Female';
        
        if ( $patient -> gender == '1' )
            return 'Male';
        
        if ( $patient -> gender == '2' )
            return 'MC';
        
        if ( $patient -> gender == '3' )
            return 'FC';
    }
    
    function get_patient_guardian ( $id = 0, $patient = null ) {
        if ( $id > 0 )
            $patient = get_patient_by_id ( $id );
        
        return array (
            $patient -> relationship,
            $patient -> father_name
        );
    }
    
    function upload_patient_files ( $patient_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'PatientModel' );
        
        if ( !is_dir ( 'uploads/' ) ) {
            mkdir ( './uploads/', 0777, TRUE );
        }
        
        $upload_path               = 'uploads/';
        $config[ 'upload_path' ]   = $upload_path;
        $config[ 'allowed_types' ] = 'jpg|png|jpeg|PNG|txt|pdf|docx|doc';
        $config[ 'encrypt_name' ]  = true;
        $ci -> load -> library ( 'upload', $config );
        $ci -> upload -> initialize ( $config );
        
        if ( !empty( $_FILES[ 'files' ][ 'name' ] ) ) {
            $filesCount = count ( $_FILES[ 'files' ][ 'name' ] );
            for ( $i = 0; $i < $filesCount; $i++ ) {
                $_FILES[ 'file' ][ 'name' ]     = $_FILES[ 'files' ][ 'name' ][ $i ];
                $_FILES[ 'file' ][ 'type' ]     = $_FILES[ 'files' ][ 'type' ][ $i ];
                $_FILES[ 'file' ][ 'tmp_name' ] = $_FILES[ 'files' ][ 'tmp_name' ][ $i ];
                $_FILES[ 'file' ][ 'error' ]    = $_FILES[ 'files' ][ 'error' ][ $i ];
                $_FILES[ 'file' ][ 'size' ]     = $_FILES[ 'files' ][ 'size' ][ $i ];
                
                if ( $ci -> upload -> do_upload ( 'file' ) ) {
                    $fileData              = $ci -> upload -> data ();
                    $path                  = $fileData[ 'file_name' ];
                    $files[ 'user_id' ]    = get_logged_in_user_id ();
                    $files[ 'patient_id' ] = $patient_id;
                    $files[ 'file_name' ]  = $_FILES[ 'files' ][ 'name' ][ $i ];
                    $files[ 'url' ]        = $path;
                    $ci -> PatientModel -> add_files ( $files );
                }
            }
        }
    }
    
    function count_patients_doctor ( $patients ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'PatientModel' );
        return $ci -> PatientModel -> count_patients_doctor ( $patients );
    }
    
    function count_panel_patients_doctor ( $patients, $panel_id = 0 ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'PatientModel' );
        return $ci -> PatientModel -> count_panel_patients_doctor ( $patients, $panel_id );
    }
    
    function get_consultants ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_consultants ( $sale_id );
    }
    
    function get_doctor_by_specialization ( $specialization_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'DoctorModel' );
        return $ci -> DoctorModel -> get_doctor_by_specialization ( $specialization_id );
    }
    
    function count_ipd_payment_received ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> count_payment ( $sale_id );
    }
    
    function calculate_sales_debit ( $sales_account_head ) {
        $sales_debit = 0;
        if ( count ( $sales_account_head ) > 0 ) {
            foreach ( $sales_account_head as $sale_account_head ) {
                $childAccHeads = get_child_account_heads_data ( $sale_account_head -> id );
                $acc_head_id   = $sale_account_head -> id;
                $transaction   = calculate_acc_head_transaction ( $acc_head_id, true );
                
                if ( !empty( $transaction ) ) {
                    $sales_debit += abs ( ( $transaction -> debit - $transaction -> credit ) );
                    if ( count ( $childAccHeads ) > 0 ) {
                        foreach ( $childAccHeads as $childAccHead ) {
                            $acc_head_id        = $childAccHead -> id;
                            $transaction        = calculate_acc_head_transaction ( $acc_head_id, true );
                            $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                            $sub_transaction    = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids, true );
                            $sales_debit        += abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) );
                        }
                    }
                }
            }
        }
        return abs ( $sales_debit );
    }
    
    function calculate_allowances_credit ( $returns_allowances_account_head ) {
        $acc_head_id = $returns_allowances_account_head -> id;
        $transaction = calculate_acc_head_transaction ( $acc_head_id, true );
        return abs ( ( $transaction -> debit - $transaction -> credit ) );
    }
    
    function calculate_fee_discounts_credit ( $fee_discounts_account_head ) {
        $fee_discounts_credit = 0;
        if ( count ( $fee_discounts_account_head ) > 0 ) {
            foreach ( $fee_discounts_account_head as $fee_discount_account_head ) {
                $childAccHeads        = get_child_account_heads_data ( $fee_discount_account_head -> id );
                $acc_head_id          = $fee_discount_account_head -> id;
                $transaction          = calculate_acc_head_transaction ( $acc_head_id, true );
                $fee_discounts_credit = abs ( $fee_discounts_credit + $transaction -> credit );
                
                if ( count ( $childAccHeads ) > 0 ) {
                    foreach ( $childAccHeads as $childAccHead ) {
                        $acc_head_id          = $childAccHead -> id;
                        $transaction          = calculate_acc_head_transaction ( $acc_head_id, true );
                        $subChildAccHeadIds   = get_sub_child_account_head_ids ( $acc_head_id );
                        $sub_transaction      = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids, true );
                        $fee_discounts_credit += abs ( ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) ) );
                    }
                }
            }
        }
        return abs ( $fee_discounts_credit );
    }
    
    function calculate_direct_cost_credit ( $Direct_Costs_account_head ) {
        $direct_cost_credit = 0;
        if ( count ( $Direct_Costs_account_head ) > 0 ) {
            foreach ( $Direct_Costs_account_head as $Direct_Cost_account_head ) {
                $childAccHeads      = get_child_account_heads_data ( $Direct_Cost_account_head -> id );
                $acc_head_id        = $Direct_Cost_account_head -> id;
                $transaction        = calculate_acc_head_transaction ( $acc_head_id, true );
                $direct_cost_credit += abs ( -$transaction -> credit + $transaction -> debit );
                
                if ( count ( $childAccHeads ) > 0 ) {
                    foreach ( $childAccHeads as $childAccHead ) {
                        $subChildAccHeads   = get_child_account_heads_data ( $childAccHead -> id );
                        $acc_head_id        = $childAccHead -> id;
                        $transaction        = calculate_acc_head_transaction ( $acc_head_id, true );
                        $direct_cost_credit += abs ( -$transaction -> credit + $transaction -> debit );
                        
                        if ( count ( $subChildAccHeads ) > 0 ) {
                            foreach ( $subChildAccHeads as $subChildAccHead ) {
                                $acc_head_id        = $subChildAccHead -> id;
                                $transaction        = calculate_acc_head_transaction ( $acc_head_id, true );
                                $subChildAccHeadIds = get_sub_child_account_head_ids ( $acc_head_id );
                                $sub_transaction    = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids, true );
                                $direct_cost_credit += abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) );
                            }
                        }
                    }
                }
            }
        }
        return abs ( $direct_cost_credit );
    }
    
    function calculate_expense_account_credit ( $expenses_account_head ) {
        $expense_account_credit = 0;
        if ( count ( $expenses_account_head ) > 0 ) {
            foreach ( $expenses_account_head as $expense_account_head ) {
                $childAccHeads          = get_child_account_heads_data ( $expense_account_head -> id );
                $acc_head_id            = $expense_account_head -> id;
                $transaction            = calculate_acc_head_transaction ( $acc_head_id, true );
                $expense_account_credit = abs ( -$transaction -> credit + $transaction -> debit );
                
                if ( count ( $childAccHeads ) > 0 ) {
                    foreach ( $childAccHeads as $childAccHead ) {
                        $subChildAccHeads       = get_child_account_heads_data ( $childAccHead -> id );
                        $childAccHeads          = get_child_account_heads_data ( $expense_account_head -> id );
                        $acc_head_id            = $childAccHead -> id;
                        $transaction            = calculate_acc_head_transaction ( $acc_head_id, true );
                        $subChildAccHeadIds     = get_sub_child_account_head_ids ( $acc_head_id );
                        $sub_transaction        = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids, true );
                        $subChildAccHeads       = get_child_account_heads_data ( $childAccHead -> id );
                        $sub_transaction        = ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) );
                        $expense_account_credit += abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) );
                        
                        if ( count ( $subChildAccHeads ) > 0 ) {
                            foreach ( $subChildAccHeads as $subChildAccHead ) {
                                $acc_head_id            = $subChildAccHead -> id;
                                $transaction            = calculate_acc_head_transaction ( $acc_head_id, true );
                                $subChildAccHeadIds     = get_sub_child_account_head_ids ( $acc_head_id );
                                $sub_transaction        = calculate_sub_acc_head_transaction ( $subChildAccHeadIds -> ids, true );
                                $expense_account_credit += abs ( ( -$transaction -> credit + $transaction -> debit ) + ( -@$sub_transaction -> credit + @$sub_transaction -> debit ) );
                            }
                        }
                    }
                }
            }
        }
        
        return abs ( $expense_account_credit );
    }
    
    function displayRecursiveAccountHeads ( $records, $netCredit = 0, $netDebit = 0, $level = 1, $reverseFormula = false ) {
        $results = '';
        $ci      = &get_instance ();
        foreach ( $records as $record ) {
            
            $credit          = get_account_head_credit_sum ( $record -> id );
            $debit           = get_account_head_debit_sum ( $record -> id );
            $opening_balance = get_opening_balance_previous_than_searched_start_date ( $ci -> input -> get ( 'start-date' ), $record -> id );
            
            $netCredit += $credit;
            $netDebit  += $debit;
            
            if ( $reverseFormula )
                $running_balance = ( $opening_balance + $debit ) - $credit;
            else
                $running_balance = ( $opening_balance + $credit ) - $debit;
            
            if ( isset( $record -> children ) && count ( $record -> children ) > 0 || ( abs ( $credit ) > 0 || abs ( $debit ) > 0 ) ) {
                $results .= '<tr>';
                $results .= '<td style="padding-left: ' . ( 20 * $level ) . 'px">';
                
                if ( isset( $record -> children ) && count ( $record -> children ) > 0 )
                    $results .= '<strong>' . $record -> title . '</strong>';
                else
                    $results .= $record -> title;
                
                $results .= '</td>';
                $results .= '<td>' . number_format ( $opening_balance, 2 ) . '</td>';
                $results .= '<td>' . number_format ( $credit, 2 ) . '</td>';
                $results .= '<td>' . number_format ( $debit, 2 ) . '</td>';
                $results .= '<td>' . number_format ( $running_balance, 2 ) . '</td>';
                $results .= '</tr>';
                
                if ( !empty( $record -> children ) ) {
                    $childResult = displayRecursiveAccountHeads ( $record -> children, $netCredit, $netDebit, $level + 1 );
                    $results     .= $childResult[ 'table' ];
                    $netCredit   += $childResult[ 'netCredit' ];
                    $netDebit    += $childResult[ 'netDebit' ];
                }
            }
        }
        return array (
            'table'     => $results,
            'netCredit' => $netCredit,
            'netDebit'  => $netDebit
        );
    }
    
    function get_account_head_credit_sum ( $account_head_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_account_head_credit_sum ( $account_head_id );
    }
    
    function get_account_head_debit_sum ( $account_head_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_account_head_debit_sum ( $account_head_id );
    }
    
    function buildList ( $nodes, &$options, $depth = 0, $disable_parent = false, $account_head_obj = null, $singleAccountHeadId = 0 ) {
        $ci = &get_instance ();
        $id = $ci -> input -> get ( 'account-head' );
        if ( !empty( $account_head_obj ) && $account_head_obj -> parent_id > 0 )
            $id = $account_head_obj -> parent_id;
        
        if ( !empty( $singleAccountHeadId ) && $singleAccountHeadId > 0 )
            $id = $singleAccountHeadId;
        
        foreach ( $nodes as $item ) {
            $indentation = str_repeat ( '&nbsp;', $depth * 5 );
            $selected    = $id == $item[ 'id' ] ? 'selected="selected"' : '';
            $disabled    = $disable_parent ? 'disabled="disabled"' : '';
            if ( !empty( $item[ 'children' ] ) ) {
                $options .= '<option value="' . $item[ 'id' ] . '" class="bold" ' . $selected . $disabled . '>' . $indentation . $item[ 'title' ] . '</option>';
                buildList ( $item[ 'children' ], $options, $depth + 1, $disable_parent, $account_head_obj, $singleAccountHeadId );
            }
            else {
                $options .= '<option value="' . $item[ 'id' ] . '" ' . $selected . '>' . $indentation . $item[ 'title' ] . '</option>';
            }
        }
        return $options;
    }
    
    function build_ledgers_table ( $ledgers, $level = 0, &$net_closing_balance = 0 ) {
        $ci         = &get_instance ();
        $html       = '';
        $start_date = $ci -> input -> get ( 'start-date' );
        
        if ( $ledgers and count ( array_filter ( $ledgers ) ) > 0 ) {
            foreach ( $ledgers as $ledger ) {
                
                $acc_head_id     = $ledger -> id;
                $counter         = 1;
                $total_credit    = 0;
                $total_debit     = 0;
                $running_balance = 0;
                $transactions    = search_transactions ( $acc_head_id );
                $acc_head        = get_account_head ( $acc_head_id );
                
                $html .= '<tr>';
                $html .= '<td></td>';
                $html .= '<td colspan="9" style="font-size: 11pt; color: #FF0000;">';
                $html .= '<strong>' . $ledger -> title . '</strong>';
                $html .= '</td>';
                $html .= '</tr>';
                
                if ( count ( $transactions ) > 0 ) {
                    
                    $current_opening_balance = get_opening_balance_previous_than_searched_start_date ( $start_date, $acc_head_id );
                    
                    if ( abs ( $current_opening_balance ) > 0 ) :
                        $running_balance = $current_opening_balance;
                        $html            .= '<tr>';
                        $html            .= '<td colspan="5"></td>';
                        $html            .= '<td colspan="4"> Opening balance of ' . date_setter_without_time ( $start_date ) . '</td>';
                        $html            .= '<td> ' . number_format ( $current_opening_balance, 2 ) . '</td>';
                        $html            .= '</tr>';
                    endif;
                    
                    foreach ( $transactions as $transaction ) {

//                        if ( $transaction -> transaction_type == 'opening_balance' )
//                            $running_balance = $transaction -> debit + $transaction -> credit;
//
//                        else
//
                        $running_balance = calculate_running_balance ( $running_balance, $transaction -> credit, $transaction -> debit, $acc_head );
                        
                        $second          = check_id_double_entry ( $transaction -> voucher_number, $transaction -> id );
                        $opening_balance = $transaction -> transaction_type == 'opening_balance' ? 'opening' : '';
                        
                        $html .= '<tr class="odd gradeX ' . $opening_balance . '">';
                        $html .= '<td align="center">' . $counter++ . '</td>';
                        $html .= '<td>';
                        $html .= $transaction -> id;
                        if ( count ( $second ) > 0 ) {
                            foreach ( $second as $item ) {
                                $html .= ' - ' . $item -> id . '<br/>';
                            }
                        }
                        $html .= '</td>';
                        $html .= '<td>';
                        if ( !empty( trim ( $transaction -> invoice_id ) ) )
                            $html .= $transaction -> invoice_id;
                        
                        else if ( !empty( trim ( $transaction -> internal_issuance_id ) ) )
                            $html .= $transaction -> internal_issuance_id;
                        
                        else if ( !empty( trim ( $transaction -> bank_trans_id ) ) )
                            $html .= $transaction -> bank_trans_id;
                        
                        else if ( !empty( trim ( $transaction -> stock_id ) ) )
                            $html .= $transaction -> stock_id;
                        
                        else if ( !empty( trim ( $transaction -> lab_sale_id ) ) )
                            $html .= $transaction -> lab_sale_id;
                        
                        else if ( !empty( trim ( $transaction -> opd_consultancy_id ) ) )
                            $html .= $transaction -> opd_consultancy_id;
                        
                        else if ( !empty( trim ( $transaction -> opd_service_id ) ) )
                            $html .= $transaction -> opd_service_id;
                        
                        else if ( !empty( trim ( $transaction -> ipd_sale_id ) ) )
                            $html .= $transaction -> ipd_sale_id;
                        
                        else if ( !empty( trim ( $transaction -> local_purchase_id ) ) )
                            $html .= $transaction -> local_purchase_id;
                        
                        else if ( !empty( trim ( $transaction -> adjustment_id ) ) )
                            $html .= $transaction -> adjustment_id;
                        
                        else if ( !empty( trim ( $transaction -> store_fix_asset_id ) ) )
                            $html .= $transaction -> store_fix_asset_id;
                        
                        else if ( !empty( trim ( $transaction -> department_id ) ) )
                            $html .= $transaction -> department_id;
                        
                        else
                            $html .= $transaction -> stock_id;
                        $html .= '</td>';
                        
                        $html         .= '<td>' . $transaction -> transaction_no . '</td>';
                        $html         .= '<td>';
                        $url          = base_url ( '/invoices/voucher_transaction/' . $transaction -> voucher_number );
                        $html         .= '<a href="' . $url . '" target="_blank"> ' . $transaction -> voucher_number . '</a></td>';
                        $html         .= '<td>' . date_setter_without_time ( $transaction -> trans_date ) . '</td>';
                        $html         .= '<td>' . $transaction -> description . '</td>';
                        $html         .= '<td>' . number_format ( $transaction -> credit, 2 ) . '</td>';
                        $html         .= '<td>' . number_format ( $transaction -> debit, 2 ) . '</td>';
                        $html         .= '<td>' . number_format ( $running_balance, 2 ) . '</td>';
                        $html         .= '</tr>';
                        $total_credit += $transaction -> credit;
                        $total_debit  += $transaction -> debit;
                    }
                    
                    $html .= '<tr>';
                    $html .= '<td colspan="7"></td>';
                    $html .= '<td><strong>' . number_format ( $total_credit, 2 ) . '</strong></td>';
                    $html .= '<td><strong>' . number_format ( $total_debit, 2 ) . '</strong></td>';
                    $html .= '<td><strong>' . number_format ( $running_balance, 2 ) . '</strong></td>';
                    $html .= '</tr>';
                    
                }
                else {
                    $html .= '<tr>';
                    $html .= '<td></td>';
                    $html .= '<td></td>';
                    $html .= '<td>-</td>';
                    $html .= '<td>-</td>';
                    $html .= '<td>-</td>';
                    $html .= '<td>-</td>';
                    $html .= '<td>-</td>';
                    $html .= '<td>-</td>';
                    $html .= '<td>-</td>';
                    $html .= '<td>-</td>';
                    $html .= '</tr>';
                }
                
                $net_closing_balance = ( $net_closing_balance + $running_balance );
                
                if ( isset( $ledger -> children ) && is_array ( $ledger -> children ) ) {
                    $childResult = build_ledgers_table ( $ledger -> children, $level + 1, $net_closing_balance );
                    $html        .= $childResult[ 'html' ];
                }
            }
        }
        return array (
            'html'        => $html,
            'net_closing' => $net_closing_balance
        );
    }
    
    function calculate_running_balance ( $running_balance, $credit, $debit, $account_head ) {
        if ( in_array ( $account_head -> role_id, array ( assets, expenditure ) ) )
            return $running_balance + $credit - $debit;
        
        else if ( in_array ( $account_head -> role_id, array ( liabilities, capitals, income ) ) )
            return $running_balance - $credit + $debit;
    }
    
    function search_transactions ( $account_head_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> search_transactions ( $account_head_id );
    }
    
    function get_financial_year () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_financial_year ();
    }
    
    function get_account_head_by ( $column = null, $value = null ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_account_head_by ( $column, $value );
    }
    
    function get_post ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'PostModel' );
        return $ci -> PostModel -> get_post ( $id );
    }
    
    function get_accounts_by_role ( $role_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> get_accounts_by_role ( $role_id );
    }
    
    function getRecursiveAccountHeads ( $id, $array = false ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> getRecursiveAccountHeads ( $id, $array );
    }
    
    function build_chart_of_accounts_table ( $accounts ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> build_charts_of_accounts_table ( $accounts );
    }
    
    function get_active_child_tests_by_parent ( $test_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_active_child_tests ( $test_id );
    }
    
    function get_ipd_cash_by_panel ( $panel_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_cash_by_panel ( $panel_id );
    }
    
    function get_sum_patient_ipd_associated_services_consolidated_not_in_type ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_sum_patient_ipd_associated_services_consolidated_not_in_type ( $sale_id );
    }
    
    function get_ipd_net_price_excluding ( $sale ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        $services     = $ci -> IPDModel -> get_patient_ipd_associated_services_consolidated_not_in_type ( $sale -> sale_id, '0' );
        $tests        = $ci -> IPDModel -> get_ipd_patient_tests_consolidated ( $sale -> sale_id );
        $medications  = $ci -> IPDModel -> get_ipd_patient_medication_consolidated ( $sale -> sale_id );
        $sale_billing = $ci -> IPDModel -> get_sale_billing_info ( $sale -> sale_id );
        $patient      = get_patient ( $sale -> patient_id );
        
        if ( $patient -> panel_id < 1 || empty( trim ( $patient -> panel_id ) ) )
            return $sale_billing -> net_total;
        
        $panel = '';
        if ( $patient -> panel_id > 0 )
            $panel = get_panel_by_id ( $patient -> panel_id );
        
        $services_net_excluded = 0;
        if ( count ( $services ) > 0 ) {
            foreach ( $services as $ipd_associated_service ) {
                $services_net_excluded = $services_net_excluded + $ipd_associated_service -> net_price;
            }
        }
        
        $lab_net = 0;
        if ( count ( $tests ) > 0 ) {
            foreach ( $tests as $ipd_lab_test ) {
                $lab_net = $lab_net + $ipd_lab_test -> net_price;
            }
        }
        
        $medicine_net = 0;
        if ( count ( $medications ) > 0 ) {
            foreach ( $medications as $med ) {
                $medicine_net = $medicine_net + $med -> net_price;
            }
        }
        
        $netBill = $sale_billing -> net_total - $services_net_excluded;
        
        if ( !empty( $panel ) && $panel -> exclude_pharmacy == '1' ) {
            $netBill -= $medicine_net;
        }
        
        if ( !empty( $panel ) && $panel -> exclude_lab == '1' ) {
            $netBill -= $lab_net;
        }
        
        return $netBill;
    }
    
    function get_ipd_net_amount_excluding ( $sale ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        $services              = $ci -> IPDModel -> get_patient_ipd_associated_services_consolidated_not_in_type ( $sale -> sale_id, '0' );
        $included_services_sum = get_ipd_included_services_sum ( $sale -> sale_id );
        $tests                 = $ci -> IPDModel -> get_ipd_patient_tests_consolidated ( $sale -> sale_id );
        $medications           = $ci -> IPDModel -> get_ipd_patient_medication_consolidated ( $sale -> sale_id );
        $sale_billing          = $ci -> IPDModel -> get_sale_billing_info ( $sale -> sale_id );
        $patient               = get_patient ( $sale -> patient_id );
        $payments              = $ci -> IPDModel -> sum_ipd_payments ( $sale -> sale_id );
        
        if ( $patient -> panel_id < 1 || empty( trim ( $patient -> panel_id ) ) )
            return $sale_billing -> net_total;
        
        $panel = '';
        if ( $patient -> panel_id > 0 )
            $panel = get_panel_by_id ( $patient -> panel_id );
        
        $services_net_excluded = 0;
        if ( count ( $services ) > 0 ) {
            foreach ( $services as $ipd_associated_service ) {
                $services_net_excluded = $services_net_excluded + $ipd_associated_service -> net_price;
            }
        }
        
        $lab_net = 0;
        if ( count ( $tests ) > 0 ) {
            foreach ( $tests as $ipd_lab_test ) {
                $lab_net = $lab_net + $ipd_lab_test -> net_price;
            }
        }
        
        $medicine_net = 0;
        if ( count ( $medications ) > 0 ) {
            foreach ( $medications as $med ) {
                $medicine_net = $medicine_net + $med -> net_price;
            }
        }
        
        $netBill   = $included_services_sum - $services_net_excluded;
        $deduction = $sale_billing -> deduction;
        $tax       = $sale_billing -> tax;
        $tax_value = ( $included_services_sum * ( $tax / 100 ) );
        $netBill   = $netBill - $deduction - $tax_value;
        
        if ( !empty( $panel ) && $panel -> exclude_pharmacy == '1' ) {
            $netBill -= $medicine_net;
        }
        
        if ( !empty( $panel ) && $panel -> exclude_lab == '1' ) {
            $netBill -= $lab_net;
        }
        
        $netBill += ( $sale_billing -> initial_deposit + $payments );
        
        return $netBill;
    }
    
    function get_ipd_included_services_sum ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_included_services_sum ( $sale_id );
    }
    
    function get_ipd_receivable_by_sale_id ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_receivable_by_sale_id ( $sale_id );
    }
    
    function count_ipd_payments_received_by_patient ( $sale_id, $patient_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> count_ipd_payments_received_by_patient ( $sale_id, $patient_id );
    }
    
    function getMonthName ( $monthNumber ) {
        $monthNames = array (
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
            12 => 'December',
        );
        
        // Check if the provided month number is valid
        if ( isset( $monthNames[ $monthNumber ] ) ) {
            return $monthNames[ $monthNumber ];
        }
        else {
            return 'Invalid month number';
        }
    }
    
    function count_ipd_admitted_patients_by_month ( $month ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> count_ipd_admitted_patients_by_month ( $month );
    }
    
    function count_ipd_discharged_patients_by_month ( $month ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> count_ipd_discharged_patients_by_month ( $month );
    }
    
    function count_ipd_claims_sent_by_month ( $month ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> count_ipd_claims_sent_by_month ( $month );
    }
    
    function sum_ipd_claims_sent_by_month ( $month ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> sum_ipd_claims_sent_by_month ( $month );
    }
    
    function count_ipd_pending_claims_by_month ( $month ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> count_ipd_pending_claims_by_month ( $month );
    }
    
    function sum_of_ipd_services_of_admitted_patients_by_month ( $month ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> sum_of_ipd_services_of_admitted_patients_by_month ( $month );
    }
    
    function sum_of_ipd_services_of_discharged_patients_by_month ( $month ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> sum_of_ipd_services_of_discharged_patients_by_month ( $month );
    }
    
    function sum_of_ipd_received_claimed_amount_by_month ( $month ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> sum_of_ipd_received_claimed_amount_by_month ( $month );
    }
    
    function sum_of_ipd_deduction_by_month ( $month, $discharged = '0' ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> sum_of_ipd_deduction_by_month ( $month, $discharged );
    }
    
    function get_average_tax_by_month ( $month ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_average_tax_by_month ( $month );
    }
    
    function sum_ipd_claims_by_sale_id ( $sale ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> sum_ipd_claims_by_sale_id ( $sale );
    }
    
    function get_ipd_receivables ( $general_ledger_ids ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_receivables ( $general_ledger_ids );
    }
    
    function get_ipd_excluded_services_sum ( $sale_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'IPDModel' );
        return $ci -> IPDModel -> get_ipd_excluded_services_sum ( $sale_id );
    }
    
    function is_patient_panel ( $id = 0, $patient = null ) {
        if ( $id > 0 )
            $patient = get_patient_by_id ( $id );
        
        return $patient -> panel_id > 0;
    }
    
    function calculate_total_package_lab_sale () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'PackageModel' );
        
        $packages = $_POST[ 'package_id' ];
        $net      = 0;
        if ( isset( $packages ) and count ( $packages ) > 0 ) {
            foreach ( $packages as $package_id ) {
                $package = $ci -> PackageModel -> get_lab_packages_by_id ( $package_id );
                $net     = $net + $package -> price;
            }
        }
        return $net;
    }
    
    function get_online_referral_portal_by_id ( $online_reference_id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'OnlineReferenceModel' );
        return $ci -> OnlineReferenceModel -> get_reference_by_id ( $online_reference_id );
    }
    
    function set_lab_sort_order () {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> set_lab_sort_order ();
    }
    
    function get_reference_by_id ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'ReferenceModel' );
        return $ci -> ReferenceModel -> get_reference_by_id ( $id );
    }
    
    function lab_sales_DOCTOR_ledger ( $data, $sale_id, $service_info, $doctor_id, $doctor_share ) {
        $ci          = &get_instance ();
        $description = 'Lab tests sold . Doctor Ledger: ' . implode ( ',', $service_info );
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
            'sale_id'      => $sale_id,
            'action'       => 'lab_sale_doctor_ledger_added',
            'log'          => json_encode ( $ledger ),
            'after_update' => '',
            'date_added'   => current_date_time ()
        );
        $ci -> load -> model ( 'LogModel' );
        $ci -> LogModel -> create_log ( 'lab_sale_logs', $log );
    }
    
    function lab_sales_COS_Laboratory_ledger ( $data, $sale_id, $service_info, $doctor_id, $doctor_share ) {
        $ci          = &get_instance ();
        $description = 'Lab tests sold . Doctor Ledger: ' . implode ( ',', $service_info );
        $ledger      = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      => COS_Laboratory,
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
            'sale_id'      => $sale_id,
            'action'       => 'lab_sale_doctor_ledger_added',
            'log'          => json_encode ( $ledger ),
            'after_update' => '',
            'date_added'   => current_date_time ()
        );
        $ci -> load -> model ( 'LogModel' );
        $ci -> LogModel -> create_log ( 'lab_sale_logs', $log );
    }
    
    function refund_lab_sales_DOCTOR_ledger ( $data, $sale_id, $service_info, $doctor_id, $doctor_share ) {
        $ci          = &get_instance ();
        $description = 'Lab tests refunded . Doctor Ledger: ' . implode ( ',', $service_info );
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
            'sale_id'      => $sale_id,
            'action'       => 'lab_sale_doctor_ledger_added',
            'log'          => json_encode ( $ledger ),
            'after_update' => '',
            'date_added'   => current_date_time ()
        );
        $ci -> load -> model ( 'LogModel' );
        $ci -> LogModel -> create_log ( 'lab_sale_logs', $log );
    }
    
    function refund_lab_sales_COS_Laboratory_ledger ( $data, $sale_id, $service_info, $doctor_id, $doctor_share ) {
        $ci          = &get_instance ();
        $description = 'Lab tests sold . Doctor Ledger: ' . implode ( ',', $service_info );
        $ledger      = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      => COS_Laboratory,
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
            'sale_id'      => $sale_id,
            'action'       => 'lab_sale_doctor_ledger_added',
            'log'          => json_encode ( $ledger ),
            'after_update' => '',
            'date_added'   => current_date_time ()
        );
        $ci -> load -> model ( 'LogModel' );
        $ci -> LogModel -> create_log ( 'lab_sale_logs', $log );
    }
    
    function calculateBirthdate ( $age, $unit ) {
        $currentDate = new DateTime();
        
        switch ( $unit ) {
            case 'years':
            case 'year':
                $interval = new DateInterval( 'P' . $age . 'Y' );
                break;
            case 'months':
            case 'month':
                $interval = new DateInterval( 'P' . $age . 'M' );
                break;
            case 'days':
            case 'day':
                $interval = new DateInterval( 'P' . $age . 'D' );
                break;
            default:
                throw new Exception( "Invalid unit" );
        }
        $currentDate -> sub ( $interval );
        return $currentDate -> format ( 'Y-m-d' );
    }
    
    function get_patient_dob ( $patient = null ) {
        $dob = null;
        if ( $patient && !empty( trim ( $patient -> dob ) ) && $patient -> dob !== '1970-01-01' ) {
            $dob = calculatePatientAge ( $patient -> dob );
        }
        else
            $dob = $patient -> age . ' ' . $patient -> age_year_month;
        
        return $dob;
    }
    
    function calculatePatientAge ( $dob ) {
        $dobDate     = new DateTime( $dob );
        $currentDate = new DateTime();
        $ageInterval = $currentDate -> diff ( $dobDate );
        
        // Determine the age to return based on the interval
        if ( $ageInterval -> y > 0 ) {
            return $ageInterval -> y . ' years';
        }
        elseif ( $ageInterval -> m > 0 ) {
            return $ageInterval -> m . ' months';
        }
        else {
            return $ageInterval -> d . ' days';
        }
    }
    
    function filter_balance_sheet ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'AccountModel' );
        return $ci -> AccountModel -> filter_balance_sheet ( $id );
    }
    
    function get_test_panels ( $id ) {
        $ci = &get_instance ();
        $ci -> load -> model ( 'LabModel' );
        return $ci -> LabModel -> get_test_panels ( $id );
    }
