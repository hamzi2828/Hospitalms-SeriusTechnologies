<div class="form-group col-lg-12">
    <div class="select-all">
        <input type="checkbox" class="checkbox" id="select_all"> Select All
    </div>
    <table class="table table-hover table-bordered" width="100%">
        <thead>
        <tr>
            <th> Module</th>
            <th> Sub Module</th>
            <th> Accessibility</th>
        </tr>
        </thead>
        <tbody>
        <tr style="background: #dff0d8;">
            <td> Dashboard</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" class="checkbox" class="checkbox"
                       name="access[]"
                       value="dashboard" <?php if ( !empty( $access ) and in_array ( 'dashboard', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Stats Dashboard</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" class="checkbox" class="checkbox"
                       name="access[]"
                       value="stats-dashboard" <?php if ( !empty( $access ) and in_array ( 'stats-dashboard', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Patients</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" class="checkbox" name="access[]"
                       value="patients" <?php if ( !empty( $access ) and in_array ( 'patients', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> All Patients</td>
            <td>
                <input type="checkbox" class="checkbox" class="checkbox" name="access[]"
                       value="all_patients" <?php if ( !empty( $access ) and in_array ( 'all_patients', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" class="checkbox" name="access[]"
                       value="patient_medical_history" <?php if ( !empty( $access ) and in_array ( 'patient_medical_history', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Medical History
                <input type="checkbox" class="checkbox" class="checkbox" name="access[]"
                       value="edit_patient" <?php if ( !empty( $access ) and in_array ( 'edit_patient', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" class="checkbox" name="access[]"
                       value="delete_patient" <?php if ( !empty( $access ) and in_array ( 'delete_patient', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" class="checkbox" name="access[]"
                       value="delete_patient_history_file" <?php if ( !empty( $access ) and in_array ( 'delete_patient_history_file', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete Patient History Files
                <input type="checkbox" class="checkbox" class="checkbox" name="access[]"
                       value="print_patient" <?php if ( !empty( $access ) and in_array ( 'print_patient', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Add Patients (Cash)</td>
            <td>
                <input type="checkbox" class="checkbox" class="checkbox" name="access[]"
                       value="add_patient" <?php if ( !empty( $access ) and in_array ( 'add_patient', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Add Patients (Panel)</td>
            <td>
                <input type="checkbox" class="checkbox" class="checkbox" name="access[]"
                       value="add_patient_panel" <?php if ( !empty( $access ) and in_array ( 'add_patient_panel', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Nursing Station</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="nursing_station" <?php if ( !empty( $access ) and in_array ( 'nursing_station', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Vitals</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="vitals" <?php if ( !empty( $access ) and in_array ( 'vitals', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_vitals" <?php if ( !empty( $access ) and in_array ( 'edit_vitals', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_vitals" <?php if ( !empty( $access ) and in_array ( 'delete_vitals', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Patient Vitals</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_vitals" <?php if ( !empty( $access ) and in_array ( 'add_vitals', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Consultancy</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="consultancy" <?php if ( !empty( $access ) and in_array ( 'consultancy', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Consultancy Invoices (Cash)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="cash_consultancies" <?php if ( !empty( $access ) and in_array ( 'cash_consultancies', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Consultancy Invoices (Panel)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="panel_consultancies" <?php if ( !empty( $access ) and in_array ( 'panel_consultancies', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_consultancy" <?php if ( !empty( $access ) and in_array ( 'edit_consultancy', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_consultancy" <?php if ( !empty( $access ) and in_array ( 'delete_consultancy', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_consultancy" <?php if ( !empty( $access ) and in_array ( 'print_consultancy', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="refund_consultancy" <?php if ( !empty( $access ) and in_array ( 'refund_consultancy', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Refund
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Consultancies</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_consultancies" <?php if ( !empty( $access ) and in_array ( 'add_consultancies', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Consultancy Discount</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_consultancy_discount" <?php if ( !empty( $access ) and in_array ( 'add_consultancy_discount', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Pay Consultant</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="pay-consultant" <?php if ( !empty( $access ) and in_array ( 'pay-consultant', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> doctor settings</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="doctor_settings" <?php if ( !empty( $access ) and in_array ( 'doctor_settings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Doctors</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_doctors" <?php if ( !empty( $access ) and in_array ( 'all_doctors', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="view_doctors" <?php if ( !empty( $access ) and in_array ( 'view_doctors', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> View
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_doctors" <?php if ( !empty( $access ) and in_array ( 'edit_doctors', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_doctors" <?php if ( !empty( $access ) and in_array ( 'delete_doctors', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="active_inactive_doctors" <?php if ( !empty( $access ) and in_array ( 'active_inactive_doctors', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Active/Inactive
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Doctors</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_doctors" <?php if ( !empty( $access ) and in_array ( 'add_doctors', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Specializations</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_specializations" <?php if ( !empty( $access ) and in_array ( 'all_specializations', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_specialization" <?php if ( !empty( $access ) and in_array ( 'edit_specialization', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_specialization" <?php if ( !empty( $access ) and in_array ( 'delete_specialization', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Specializations</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_specializations" <?php if ( !empty( $access ) and in_array ( 'add_specializations', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Follow Ups</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_follow_ups" <?php if ( !empty( $access ) and in_array ( 'all_follow_ups', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_follow_up" <?php if ( !empty( $access ) and in_array ( 'edit_follow_up', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_follow_up" <?php if ( !empty( $access ) and in_array ( 'delete_follow_up', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Follow Ups</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_follow_up" <?php if ( !empty( $access ) and in_array ( 'add_follow_up', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Medicine R<sub>x</sub></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="medicine_rx" <?php if ( !empty( $access ) and in_array ( 'medicine_rx', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_medicine_rx" <?php if ( !empty( $access ) and in_array ( 'edit_medicine_rx', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_medicine_rx" <?php if ( !empty( $access ) and in_array ( 'delete_medicine_rx', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add R<sub>x</sub></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_medicine_rx" <?php if ( !empty( $access ) and in_array ( 'add_medicine_rx', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> pharmacy</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="pharmacy" <?php if ( !empty( $access ) and in_array ( 'pharmacy', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Sale Medicine</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="sale_medicine" <?php if ( !empty( $access ) and in_array ( 'sale_medicine', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_medicine_sale_invoice" <?php if ( !empty( $access ) and in_array ( 'edit_medicine_sale_invoice', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_medicine_sale_invoice" <?php if ( !empty( $access ) and in_array ( 'delete_medicine_sale_invoice', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="refund_medicine_sale_invoice" <?php if ( !empty( $access ) and in_array ( 'refund_medicine_sale_invoice', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Refund
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_medicine_sale_invoice" <?php if ( !empty( $access ) and in_array ( 'print_medicine_sale_invoice', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Sale Invoices</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="pharmacy_sale_invoices" <?php if ( !empty( $access ) and in_array ( 'pharmacy_sale_invoices', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Edit Sale</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_medicine_sale" <?php if ( !empty( $access ) and in_array ( 'edit_medicine_sale', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Return Customer Invoices</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="return_customer_invoices" <?php if ( !empty( $access ) and in_array ( 'return_customer_invoices', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Return Customer</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="return_customer" <?php if ( !empty( $access ) and in_array ( 'return_customer', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Edit Return Customer</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_return_customer" <?php if ( !empty( $access ) and in_array ( 'edit_return_customer', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Local Purchase</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="local_purchases" <?php if ( !empty( $access ) and in_array ( 'local_purchases', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_local_purchases" <?php if ( !empty( $access ) and in_array ( 'edit_local_purchases', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_local_purchases" <?php if ( !empty( $access ) and in_array ( 'delete_local_purchases', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Local Purchase</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_local_purchases" <?php if ( !empty( $access ) and in_array ( 'add_local_purchases', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Edit Local Purchase</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_local_purchases" <?php if ( !empty( $access ) and in_array ( 'edit_local_purchases', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Medicines</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="medicines" <?php if ( !empty( $access ) and in_array ( 'medicines', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Medicines (Export)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="medicines-export" <?php if ( !empty( $access ) and in_array ( 'medicines-export', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_medicine" <?php if ( !empty( $access ) and in_array ( 'edit_medicine', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_medicine" <?php if ( !empty( $access ) and in_array ( 'delete_medicine', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="inactive_medicine" <?php if ( !empty( $access ) and in_array ( 'inactive_medicine', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Inactive
                <input type="checkbox" class="checkbox" name="access[]"
                       value="medicine_stock" <?php if ( !empty( $access ) and in_array ( 'medicine_stock', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Stock
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Medicines Stock</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_medicines_stock" <?php if ( !empty( $access ) and in_array ( 'add_medicines_stock', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Edit Medicines Stock</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_medicines_stock" <?php if ( !empty( $access ) and in_array ( 'edit_medicines_stock', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Search Supplier Invoice</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="search-medicine-supplier-invoice" <?php if ( !empty( $access ) and in_array ( 'search-medicine-supplier-invoice', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_medicine_stock" <?php if ( !empty( $access ) and in_array ( 'delete_medicine_stock', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete Stock
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Returns</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_medicine_stock_returns" <?php if ( !empty( $access ) and in_array ( 'all_medicine_stock_returns', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_medicine_return_button" <?php if ( !empty( $access ) and in_array ( 'print_medicine_return_button', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_medicine_return_button" <?php if ( !empty( $access ) and in_array ( 'delete_medicine_return_button', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Stock Returns</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_medicine_stock_returns" <?php if ( !empty( $access ) and in_array ( 'add_medicine_stock_returns', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Requisitions</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_requisitions" <?php if ( !empty( $access ) and in_array ( 'ipd_requisitions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Adjustments</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_adjustments" <?php if ( !empty( $access ) and in_array ( 'add_adjustments', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Adjustments</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="adjustments" <?php if ( !empty( $access ) and in_array ( 'adjustments', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Discarded Expired Medicines</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="discarded_expired_medicines" <?php if ( !empty( $access ) and in_array ( 'discarded_expired_medicines', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_adjustments" <?php if ( !empty( $access ) and in_array ( 'edit_adjustments', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_adjustments" <?php if ( !empty( $access ) and in_array ( 'delete_adjustments', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Pharmacy Discount</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_pharmacy_discount" <?php if ( !empty( $access ) and in_array ( 'add_pharmacy_discount', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> pharmacy reporting</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="pharmacy_reporting" <?php if ( !empty( $access ) and in_array ( 'pharmacy_reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>General report (IPD Med)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="general_report_ipd_medication" <?php if ( !empty( $access ) and in_array ( 'general_report_ipd_medication', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>General report (sales)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="sales_general_report" <?php if ( !empty( $access ) and in_array ( 'sales_general_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>General report (return)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="returns_general_report" <?php if ( !empty( $access ) and in_array ( 'returns_general_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Sale Report Against Supplier</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="sale_report_against_supplier" <?php if ( !empty( $access ) and in_array ( 'sale_report_against_supplier', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Stock valuation report (tp wise)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="stock_valuation_report_tp_wise" <?php if ( !empty( $access ) and in_array ( 'stock_valuation_report_tp_wise', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Stock valuation report (sale wise)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="stock_valuation_report_sale_wise" <?php if ( !empty( $access ) and in_array ( 'stock_valuation_report_sale_wise', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>threshold report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="threshold_report" <?php if ( !empty( $access ) and in_array ( 'threshold_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>expired medicine report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="expired_medicine_report" <?php if ( !empty( $access ) and in_array ( 'expired_medicine_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>profit report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="profit_report" <?php if ( !empty( $access ) and in_array ( 'profit_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>profit report (ipd medication)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="profit_report_ipd_medication" <?php if ( !empty( $access ) and in_array ( 'profit_report_ipd_medication', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>detailed stock report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="detailed_stock_report" <?php if ( !empty( $access ) and in_array ( 'detailed_stock_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>bonus stock report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="bonus_stock_report" <?php if ( !empty( $access ) and in_array ( 'bonus_stock_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>form wise report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="form_wise_report" <?php if ( !empty( $access ) and in_array ( 'form_wise_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>supplier wise report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="supplier_wise_report" <?php if ( !empty( $access ) and in_array ( 'supplier_wise_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>analysis report (Purchase)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="analysis_report" <?php if ( !empty( $access ) and in_array ( 'analysis_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>analysis report (Sale)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="analysis_report_sale" <?php if ( !empty( $access ) and in_array ( 'analysis_report_sale', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>analysis report (IPD Sale)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="analysis_report_ipd_sale" <?php if ( !empty( $access ) and in_array ( 'analysis_report_ipd_sale', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>summary report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="summary_report" <?php if ( !empty( $access ) and in_array ( 'summary_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> pharmacy settings</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="pharmacy_settings" <?php if ( !empty( $access ) and in_array ( 'pharmacy_settings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>add medicines</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_medicines" <?php if ( !empty( $access ) and in_array ( 'add_medicines', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>generics</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="generics" <?php if ( !empty( $access ) and in_array ( 'generics', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_generics" <?php if ( !empty( $access ) and in_array ( 'edit_generics', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_generics" <?php if ( !empty( $access ) and in_array ( 'delete_generics', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>add generics</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_generics" <?php if ( !empty( $access ) and in_array ( 'add_generics', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>strength</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="strength" <?php if ( !empty( $access ) and in_array ( 'strength', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_strength" <?php if ( !empty( $access ) and in_array ( 'edit_strength', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_strength" <?php if ( !empty( $access ) and in_array ( 'delete_strength', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>add strength</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_strength" <?php if ( !empty( $access ) and in_array ( 'add_strength', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>forms</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="forms" <?php if ( !empty( $access ) and in_array ( 'forms', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_forms" <?php if ( !empty( $access ) and in_array ( 'edit_forms', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_forms" <?php if ( !empty( $access ) and in_array ( 'delete_forms', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>add forms</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_forms" <?php if ( !empty( $access ) and in_array ( 'add_forms', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>manufacturers</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="manufacturers" <?php if ( !empty( $access ) and in_array ( 'manufacturers', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_manufacturers" <?php if ( !empty( $access ) and in_array ( 'edit_manufacturers', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_manufacturers" <?php if ( !empty( $access ) and in_array ( 'delete_manufacturers', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>add manufacturers</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_manufacturers" <?php if ( !empty( $access ) and in_array ( 'add_manufacturers', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>pack size</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="pack_size" <?php if ( !empty( $access ) and in_array ( 'pack_size', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_pack_size" <?php if ( !empty( $access ) and in_array ( 'edit_pack_size', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_pack_size" <?php if ( !empty( $access ) and in_array ( 'delete_pack_size', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>add pack size</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_pack_size" <?php if ( !empty( $access ) and in_array ( 'add_pack_size', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Lab</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab" <?php if ( !empty( $access ) and in_array ( 'lab', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Sale Test (General)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="sale_test" <?php if ( !empty( $access ) and in_array ( 'sale_test', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Sale Test (Package)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="sale_test_package" <?php if ( !empty( $access ) and in_array ( 'sale_test_package', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Sale Test (Covid-19 Panel)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="sale_test_covid" <?php if ( !empty( $access ) and in_array ( 'sale_test_covid', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td>Sale Invoices (Cash)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="sale_invoices_cash" <?php if ( !empty( $access ) and in_array ( 'sale_invoices_cash', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="view_lab_sale_invoices" <?php if ( !empty( $access ) and in_array ( 'view_lab_sale_invoices', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> View
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_lab_sale_invoices" <?php if ( !empty( $access ) and in_array ( 'delete_lab_sale_invoices', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_lab_sale_invoices" <?php if ( !empty( $access ) and in_array ( 'print_lab_sale_invoices', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="refund_lab_sales" <?php if ( !empty( $access ) and in_array ( 'refund_lab_sales', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Refund
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Sale Invoices (Panel)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="sale_invoices_panel" <?php if ( !empty( $access ) and in_array ( 'sale_invoices_panel', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Pending Results</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab_sale_pending_results" <?php if ( !empty( $access ) and in_array ( 'lab_sale_pending_results', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab_add_pending_results_button" <?php if ( !empty( $access ) and in_array ( 'lab_add_pending_results_button', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Add Pending Results Button
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Added Test Results</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab_all_added_test_results" <?php if ( !empty( $access ) and in_array ( 'lab_all_added_test_results', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab-add-added-results-edit-patient-btn" <?php if ( !empty( $access ) and in_array ( 'lab-add-added-results-edit-patient-btn', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit Patient Button
                
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab-add-added-results-add-airline-details-btn" <?php if ( !empty( $access ) and in_array ( 'lab-add-added-results-add-airline-details-btn', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Add Airline Details Button
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Pending Results (IPD)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab_sale_pending_results_ipd" <?php if ( !empty( $access ) and in_array ( 'lab_sale_pending_results_ipd', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Added Test Results (IPD)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab_all_added_test_results_ipd" <?php if ( !empty( $access ) and in_array ( 'lab_all_added_test_results_ipd', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Test Status</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="test-status-report" <?php if ( !empty( $access ) and in_array ( 'test-status-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Edit Sale</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_lab_sale" <?php if ( !empty( $access ) and in_array ( 'edit_lab_sale', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Tests</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_lab_tests" <?php if ( !empty( $access ) and in_array ( 'all_lab_tests', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_lab_test" <?php if ( !empty( $access ) and in_array ( 'edit_lab_test', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="status_lab_test" <?php if ( !empty( $access ) and in_array ( 'status_lab_test', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Activate/Deactivate
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_lab_sale_invoices" <?php if ( !empty( $access ) and in_array ( 'delete_lab_sale_invoices', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_lab_regents" <?php if ( !empty( $access ) and in_array ( 'delete_lab_regents', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete Regents
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Lab Tests</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_lab_tests" <?php if ( !empty( $access ) and in_array ( 'add_lab_tests', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Test Protocols</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab_test_protocols" <?php if ( !empty( $access ) and in_array ( 'lab_test_protocols', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add results</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_test_results" <?php if ( !empty( $access ) and in_array ( 'add_test_results', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add results (IPD)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_ipd_test_results" <?php if ( !empty( $access ) and in_array ( 'add_ipd_test_results', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add airline details</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_airline_details" <?php if ( !empty( $access ) and in_array ( 'add_airline_details', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Calibrations</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="calibrations" <?php if ( !empty( $access ) and in_array ( 'calibrations', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Calibrations</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_calibrations" <?php if ( !empty( $access ) and in_array ( 'add_calibrations', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Prices Update (Bulk)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="update_prices_bulk" <?php if ( !empty( $access ) and in_array ( 'update_prices_bulk', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> lab result verify button</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab_result_verify_button" <?php if ( !empty( $access ) and in_array ( 'lab_result_verify_button', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> lab result verify + add results button</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab_result_verify_and_add_result_button" <?php if ( !empty( $access ) and in_array ( 'lab_result_verify_and_add_result_button', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Lab Discount</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_lab_discount" <?php if ( !empty( $access ) and in_array ( 'add_lab_discount', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> lab reporting</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab_reporting" <?php if ( !empty( $access ) and in_array ( 'lab_reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> general reporting</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab_general_reporting" <?php if ( !empty( $access ) and in_array ( 'lab_general_reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> General Report (COVID-19)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab_covid_reporting" <?php if ( !empty( $access ) and in_array ( 'lab_covid_reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Sale Invoices (Cash-Balance)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab-cash-balance-report" <?php if ( !empty( $access ) and in_array ( 'lab-cash-balance-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Load Data Sheet</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="load-data-sheet" <?php if ( !empty( $access ) and in_array ( 'load-data-sheet', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> general reporting IPD</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab_general_reporting_ipd" <?php if ( !empty( $access ) and in_array ( 'lab_general_reporting_ipd', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Regents Consumption Report (Cash)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="regents_consumption_report" <?php if ( !empty( $access ) and in_array ( 'regents_consumption_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Regents Consumption Report (IPD)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="regents_consumption_report_ipd" <?php if ( !empty( $access ) and in_array ( 'regents_consumption_report_ipd', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Test Prices Report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="test_prices_report" <?php if ( !empty( $access ) and in_array ( 'test_prices_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Referred By Report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="referred-by-report" <?php if ( !empty( $access ) and in_array ( 'referred-by-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> lab settings</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="lab_settings" <?php if ( !empty( $access ) and in_array ( 'lab_settings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all locations</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="locations" <?php if ( !empty( $access ) and in_array ( 'locations', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_locations" <?php if ( !empty( $access ) and in_array ( 'edit_locations', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_locations" <?php if ( !empty( $access ) and in_array ( 'delete_locations', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add locations</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_locations" <?php if ( !empty( $access ) and in_array ( 'add_locations', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all units</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="units" <?php if ( !empty( $access ) and in_array ( 'units', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_units" <?php if ( !empty( $access ) and in_array ( 'edit_units', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_units" <?php if ( !empty( $access ) and in_array ( 'delete_units', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add units</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_units" <?php if ( !empty( $access ) and in_array ( 'add_units', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all sections</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="sections" <?php if ( !empty( $access ) and in_array ( 'sections', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_sections" <?php if ( !empty( $access ) and in_array ( 'edit_sections', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_sections" <?php if ( !empty( $access ) and in_array ( 'delete_sections', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add sections</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_sections" <?php if ( !empty( $access ) and in_array ( 'add_sections', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all test tube colors</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="test_tube_colors" <?php if ( !empty( $access ) and in_array ( 'test_tube_colors', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_test_tube_colors" <?php if ( !empty( $access ) and in_array ( 'edit_test_tube_colors', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_test_tube_colors" <?php if ( !empty( $access ) and in_array ( 'delete_test_tube_colors', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add test tube colors</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_test_tube_colors" <?php if ( !empty( $access ) and in_array ( 'add_test_tube_colors', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> samples</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="samples" <?php if ( !empty( $access ) and in_array ( 'samples', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_samples" <?php if ( !empty( $access ) and in_array ( 'edit_samples', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_samples" <?php if ( !empty( $access ) and in_array ( 'delete_samples', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add samples</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_samples" <?php if ( !empty( $access ) and in_array ( 'add_samples', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Destinations</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="destinations" <?php if ( !empty( $access ) and in_array ( 'destinations', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit-destinations" <?php if ( !empty( $access ) and in_array ( 'edit-destinations', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete-destinations" <?php if ( !empty( $access ) and in_array ( 'delete-destinations', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add destinations</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-destinations" <?php if ( !empty( $access ) and in_array ( 'add-destinations', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Airlines</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="airlines" <?php if ( !empty( $access ) and in_array ( 'airlines', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit-airlines" <?php if ( !empty( $access ) and in_array ( 'edit-airlines', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete-airlines" <?php if ( !empty( $access ) and in_array ( 'delete-airlines', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add airlines</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-airlines" <?php if ( !empty( $access ) and in_array ( 'add-airlines', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Specimen</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="specimen" <?php if ( !empty( $access ) and in_array ( 'specimen', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_specimen" <?php if ( !empty( $access ) and in_array ( 'edit_specimen', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_specimen" <?php if ( !empty( $access ) and in_array ( 'delete_specimen', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Specimen</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_specimen" <?php if ( !empty( $access ) and in_array ( 'add_specimen', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Remarks</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="remarks" <?php if ( !empty( $access ) and in_array ( 'remarks', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_remarks" <?php if ( !empty( $access ) and in_array ( 'edit_remarks', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_remarks" <?php if ( !empty( $access ) and in_array ( 'delete_remarks', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Remarks</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_remarks" <?php if ( !empty( $access ) and in_array ( 'add_remarks', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Packages</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="packages" <?php if ( !empty( $access ) and in_array ( 'packages', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit-packages" <?php if ( !empty( $access ) and in_array ( 'edit-packages', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete-packages" <?php if ( !empty( $access ) and in_array ( 'delete-packages', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add packages</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-packages" <?php if ( !empty( $access ) and in_array ( 'add-packages', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td> Culture / Histopathology</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="culture-histopathology" <?php if ( !empty( $access ) and in_array ( 'culture-histopathology', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td> Culture</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="culture" <?php if ( !empty( $access ) and in_array ( 'culture', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-culture-report" <?php if ( !empty( $access ) and in_array ( 'add-culture-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Add Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="search-culture-report" <?php if ( !empty( $access ) and in_array ( 'search-culture-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Search Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="culture-reports" <?php if ( !empty( $access ) and in_array ( 'culture-reports', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>All Reports
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td style="padding-left: 35px">
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print-culture-report" <?php if ( !empty( $access ) and in_array ( 'print-culture-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit-culture-report" <?php if ( !empty( $access ) and in_array ( 'edit-culture-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="verify_culture_report_button" <?php if ( !empty( $access ) and in_array ( 'verify_culture_report_button', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Verify
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete-culture-report" <?php if ( !empty( $access ) and in_array ( 'delete-culture-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td> Histopathology</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="histopathology" <?php if ( !empty( $access ) and in_array ( 'histopathology', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-histopathology-report" <?php if ( !empty( $access ) and in_array ( 'add-histopathology-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Add Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="search-histopathology-report" <?php if ( !empty( $access ) and in_array ( 'search-histopathology-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Search Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="histopathology-reports" <?php if ( !empty( $access ) and in_array ( 'histopathology-reports', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> All Reports
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td style="padding-left: 35px">
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print-histopathology-report" <?php if ( !empty( $access ) and in_array ( 'print-histopathology-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit-histopathology-report" <?php if ( !empty( $access ) and in_array ( 'edit-histopathology-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="verify_histo_report_button" <?php if ( !empty( $access ) and in_array ( 'verify_histo_report_button', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Verify
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete-histopathology-report" <?php if ( !empty( $access ) and in_array ( 'delete-histopathology-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td>Culture / Histopathology Reporting</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="culture-histopathology-reporting" <?php if ( !empty( $access ) and in_array ( 'culture-histopathology-reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
            <td></td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>General Report (Culture)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="culture-general-reporting" <?php if ( !empty( $access ) and in_array ( 'culture-general-reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>General Report (Histopathology)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="histopathology-general-reporting" <?php if ( !empty( $access ) and in_array ( 'histopathology-general-reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td>Culture / Histopathology Settings</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="culture-histopathology-settings" <?php if ( !empty( $access ) and in_array ( 'culture-histopathology-settings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
            <td></td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>All Templates (Culture)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="culture-templates" <?php if ( !empty( $access ) and in_array ( 'culture-templates', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Add Templates (Culture)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-culture-templates" <?php if ( !empty( $access ) and in_array ( 'add-culture-templates', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>All Templates (Histopathology)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="templates-histopathology" <?php if ( !empty( $access ) and in_array ( 'templates-histopathology', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Add Templates (Histopathology)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-templates-histopathology" <?php if ( !empty( $access ) and in_array ( 'add-templates-histopathology', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td></td>
            <td>All Antibiotic (Susceptibility)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="antibiotic-susceptibility" <?php if ( !empty( $access ) and in_array ( 'antibiotic-susceptibility', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Add Antibiotic (Susceptibility)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-antibiotic-susceptibility" <?php if ( !empty( $access ) and in_array ( 'add-antibiotic-susceptibility', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td> general reporting</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="general_reporting" <?php if ( !empty( $access ) and in_array ( 'general_reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Summary report (sales)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="general_summary_report" <?php if ( !empty( $access ) and in_array ( 'general_summary_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Summary report (Cash)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="general_summary_report_cash" <?php if ( !empty( $access ) and in_array ( 'general_summary_report_cash', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Summary report (Cash II)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="general_summary_report_cash_ii" <?php if ( !empty( $access ) and in_array ( 'general_summary_report_cash_ii', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Daily Closing (User Wise)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="daily-closing-report" <?php if ( !empty( $access ) and in_array ( 'daily-closing-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> general settings</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="general_settings" <?php if ( !empty( $access ) and in_array ( 'general_settings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> companies</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="companies" <?php if ( !empty( $access ) and in_array ( 'companies', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_companies" <?php if ( !empty( $access ) and in_array ( 'edit_companies', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_companies" <?php if ( !empty( $access ) and in_array ( 'delete_companies', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="company_members" <?php if ( !empty( $access ) and in_array ( 'company_members', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Members
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add companies</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_companies" <?php if ( !empty( $access ) and in_array ( 'add_companies', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> panels</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="panels" <?php if ( !empty( $access ) and in_array ( 'panels', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_panels" <?php if ( !empty( $access ) and in_array ( 'edit_panels', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_panels" <?php if ( !empty( $access ) and in_array ( 'delete_panels', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_panels" <?php if ( !empty( $access ) and in_array ( 'print_panels', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add panels</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_panels" <?php if ( !empty( $access ) and in_array ( 'add_panels', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> member types</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="member_types" <?php if ( !empty( $access ) and in_array ( 'member_types', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_member_types" <?php if ( !empty( $access ) and in_array ( 'edit_member_types', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_member_types" <?php if ( !empty( $access ) and in_array ( 'delete_member_types', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add member types</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_member_types" <?php if ( !empty( $access ) and in_array ( 'add_member_types', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Cities</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="cities" <?php if ( !empty( $access ) and in_array ( 'cities', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Add Cities</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_city" <?php if ( !empty( $access ) and in_array ( 'add_city', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> References</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="references" <?php if ( !empty( $access ) and in_array ( 'references', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Add References</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-references" <?php if ( !empty( $access ) and in_array ( 'add-references', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit-references" <?php if ( !empty( $access ) and in_array ( 'edit-references', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete-references" <?php if ( !empty( $access ) and in_array ( 'delete-references', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Online Referral Portals</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="online-references" <?php if ( !empty( $access ) and in_array ( 'online-references', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Add Online Referral Portals</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-online-references" <?php if ( !empty( $access ) and in_array ( 'add-online-references', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit-online-references" <?php if ( !empty( $access ) and in_array ( 'edit-online-references', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete-online-references" <?php if ( !empty( $access ) and in_array ( 'delete-online-references', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Site Settings</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="site_settings" <?php if ( !empty( $access ) and in_array ( 'site_settings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> accounts</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="accounts" <?php if ( !empty( $access ) and in_array ( 'accounts', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> chart of accounts</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="chart_of_accounts" <?php if ( !empty( $access ) and in_array ( 'chart_of_accounts', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_chart_of_accounts" <?php if ( !empty( $access ) and in_array ( 'edit_chart_of_accounts', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_chart_of_accounts" <?php if ( !empty( $access ) and in_array ( 'delete_chart_of_accounts', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add account head</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_account_head" <?php if ( !empty( $access ) and in_array ( 'add_account_head', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add transactions</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_transactions" <?php if ( !empty( $access ) and in_array ( 'add_transactions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add transactions (panel)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_transactions_panel" <?php if ( !empty( $access ) and in_array ( 'add_transactions_panel', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add transactions (multiple)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_transactions_multiple" <?php if ( !empty( $access ) and in_array ( 'add_transactions_multiple', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add opening balance</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_opening_balance" <?php if ( !empty( $access ) and in_array ( 'add_opening_balance', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> general ledger</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="general_ledger" <?php if ( !empty( $access ) and in_array ( 'general_ledger', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> expanse report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="expanse-report" <?php if ( !empty( $access ) and in_array ( 'expanse-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> search transactions</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="search_transactions" <?php if ( !empty( $access ) and in_array ( 'search_transactions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> search transactions (Advance)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="search-transactions-advance" <?php if ( !empty( $access ) and in_array ( 'search-transactions-advance', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> delete transactions</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete-transactions" <?php if ( !empty( $access ) and in_array ( 'delete-transactions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> revert transactions</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="revert-transactions" <?php if ( !empty( $access ) and in_array ( 'revert-transactions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Edit Transactions</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit-transactions-bulk" <?php if ( !empty( $access ) and in_array ( 'edit-transactions-bulk', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> supplier invoices</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="supplier_invoices" <?php if ( !empty( $access ) and in_array ( 'supplier_invoices', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Trial Balance Sheet (Details)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="trial_balance_sheet_detail" <?php if ( !empty( $access ) and in_array ( 'trial_balance_sheet_detail', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Balance Sheet</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="balance_sheet" <?php if ( !empty( $access ) and in_array ( 'balance_sheet', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Balance Sheet (II)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="balance_sheet_ii" <?php if ( !empty( $access ) and in_array ( 'balance_sheet_ii', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Profit and Loss Statement</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="profit_loss_statement" <?php if ( !empty( $access ) and in_array ( 'profit_loss_statement', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Accounts Receivable Report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="accounts-receivable-report" <?php if ( !empty( $access ) and in_array ( 'accounts-receivable-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Accounts Payable Report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="accounts-payable-report" <?php if ( !empty( $access ) and in_array ( 'accounts-payable-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Allow Back Date Entries</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="allow-back-date-entries" <?php if ( !empty( $access ) and in_array ( 'allow-back-date-entries', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> account settings</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="account_settings" <?php if ( !empty( $access ) and in_array ( 'account_settings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all roles</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_roles" <?php if ( !empty( $access ) and in_array ( 'all_roles', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_account_role" <?php if ( !empty( $access ) and in_array ( 'edit_account_role', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_account_role" <?php if ( !empty( $access ) and in_array ( 'delete_account_role', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add roles</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_roles" <?php if ( !empty( $access ) and in_array ( 'add_roles', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Financial Year</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="financial_year" <?php if ( !empty( $access ) and in_array ( 'financial_year', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> purchase orders</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="purchase_orders" <?php if ( !empty( $access ) and in_array ( 'purchase_orders', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all purchase orders</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_purchase_orders" <?php if ( !empty( $access ) and in_array ( 'purchase_orders', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_purchase_orders" <?php if ( !empty( $access ) and in_array ( 'print_purchase_orders', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_purchase_orders" <?php if ( !empty( $access ) and in_array ( 'delete_purchase_orders', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="received_purchase_orders" <?php if ( !empty( $access ) and in_array ( 'received_purchase_orders', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Received
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add purchase orders</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_purchase_orders" <?php if ( !empty( $access ) and in_array ( 'add_purchase_orders', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all purchase orders (store)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_store_purchase_orders" <?php if ( !empty( $access ) and in_array ( 'all_store_purchase_orders', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add purchase orders (store)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_store_purchase_orders" <?php if ( !empty( $access ) and in_array ( 'add_store_purchase_orders', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> HR</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="hr" <?php if ( !empty( $access ) and in_array ( 'hr', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all employees</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="hr_members" <?php if ( !empty( $access ) and in_array ( 'hr_members', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_hr_members" <?php if ( !empty( $access ) and in_array ( 'edit_hr_members', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_hr_members" <?php if ( !empty( $access ) and in_array ( 'delete_hr_members', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="active_deactive_hr_members" <?php if ( !empty( $access ) and in_array ( 'active_deactive_hr_members', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Active/Deactive
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add employees</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_hr_members" <?php if ( !empty( $access ) and in_array ( 'add_hr_members', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add salary sheet</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="salary_sheet" <?php if ( !empty( $access ) and in_array ( 'salary_sheet', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all salary sheets</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_salary_sheets" <?php if ( !empty( $access ) and in_array ( 'all_salary_sheets', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_sheet" <?php if ( !empty( $access ) and in_array ( 'edit_sheet', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_sheet" <?php if ( !empty( $access ) and in_array ( 'delete_sheet', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> search salary sheet</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="search_salary_sheet" <?php if ( !empty( $access ) and in_array ( 'search_salary_sheet', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td> HR Settings</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="hr-settings" <?php if ( !empty( $access ) and in_array ( 'hr-settings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all posts</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="hr-posts" <?php if ( !empty( $access ) and in_array ( 'hr-posts', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit-hr-post" <?php if ( !empty( $access ) and in_array ( 'edit-hr-post', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete-hr-post" <?php if ( !empty( $access ) and in_array ( 'delete-hr-post', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add post</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-hr-posts" <?php if ( !empty( $access ) and in_array ( 'add-hr-posts', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td> members</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="members" <?php if ( !empty( $access ) and in_array ( 'members', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all members</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_members" <?php if ( !empty( $access ) and in_array ( 'all_members', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_members" <?php if ( !empty( $access ) and in_array ( 'edit_members', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_members" <?php if ( !empty( $access ) and in_array ( 'delete_members', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add members (System Users)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_members" <?php if ( !empty( $access ) and in_array ( 'add_members', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add members (Panel)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_members_panel" <?php if ( !empty( $access ) and in_array ( 'add_members_panel', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td> complaints</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="complains" <?php if ( !empty( $access ) and in_array ( 'complains', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all complaints</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_complains" <?php if ( !empty( $access ) and in_array ( 'all_complains', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_complains" <?php if ( !empty( $access ) and in_array ( 'edit_complains', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_complains" <?php if ( !empty( $access ) and in_array ( 'delete_complains', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add complaints</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_complains" <?php if ( !empty( $access ) and in_array ( 'add_complains', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td> loans</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="loan" <?php if ( !empty( $access ) and in_array ( 'loan', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all loans</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_loans" <?php if ( !empty( $access ) and in_array ( 'all_loans', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_loan" <?php if ( !empty( $access ) and in_array ( 'edit_loan', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_loan" <?php if ( !empty( $access ) and in_array ( 'delete_loan', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add loan</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_loan" <?php if ( !empty( $access ) and in_array ( 'add_loan', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> pay loan</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="pay_loan" <?php if ( !empty( $access ) and in_array ( 'pay_loan', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all paid loans</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="paid_loans" <?php if ( !empty( $access ) and in_array ( 'paid_loans', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_paid_loan" <?php if ( !empty( $access ) and in_array ( 'edit_paid_loan', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_paid_loan" <?php if ( !empty( $access ) and in_array ( 'delete_paid_loan', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td> store</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="store" <?php if ( !empty( $access ) and in_array ( 'store', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> issue item</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="issue_items" <?php if ( !empty( $access ) and in_array ( 'issue_items', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all issued items</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="sold_items" <?php if ( !empty( $access ) and in_array ( 'sold_items', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> edit issue item</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_issue_items" <?php if ( !empty( $access ) and in_array ( 'edit_issue_items', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_issue_items" <?php if ( !empty( $access ) and in_array ( 'delete_issue_items', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all items</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_issued_items" <?php if ( !empty( $access ) and in_array ( 'all_issued_items', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="stock_issued_items" <?php if ( !empty( $access ) and in_array ( 'stock_issued_items', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Stock
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_issued_items" <?php if ( !empty( $access ) and in_array ( 'edit_issued_items', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_issued_items" <?php if ( !empty( $access ) and in_array ( 'delete_issued_items', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all issued items</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="sold_items" <?php if ( !empty( $access ) and in_array ( 'sold_items', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_issued_item" <?php if ( !empty( $access ) and in_array ( 'edit_issued_item', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_issued_item" <?php if ( !empty( $access ) and in_array ( 'delete_issued_item', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add item</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_store_items" <?php if ( !empty( $access ) and in_array ( 'add_store_items', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add stock</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_store_stock" <?php if ( !empty( $access ) and in_array ( 'add_store_stock', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> all stock</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_store_stock" <?php if ( !empty( $access ) and in_array ( 'all_store_stock', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> add edit</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_store_stock" <?php if ( !empty( $access ) and in_array ( 'edit_store_stock', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Requisition (Store)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="requisition_store" <?php if ( !empty( $access ) and in_array ( 'requisition_store', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Requisition (Others)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="requisition_others" <?php if ( !empty( $access ) and in_array ( 'requisition_others', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> All Store (Fix Assets)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="store_fix_assets" <?php if ( !empty( $access ) and in_array ( 'store_fix_assets', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_store_fix_assets" <?php if ( !empty( $access ) and in_array ( 'edit_store_fix_assets', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="dispose_store_fix_assets_btn" <?php if ( !empty( $access ) and in_array ( 'dispose_store_fix_assets_btn', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Dispose
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_store_fix_assets" <?php if ( !empty( $access ) and in_array ( 'delete_store_fix_assets', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Add Store (Fix Assets)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_store_fix_assets" <?php if ( !empty( $access ) and in_array ( 'add_store_fix_assets', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Dispose Fixed Asset</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="dispose_store_fix_assets" <?php if ( !empty( $access ) and in_array ( 'dispose_store_fix_assets', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> Disposed Fixed Assets</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="disposed_store_fix_assets" <?php if ( !empty( $access ) and in_array ( 'disposed_store_fix_assets', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> OPD</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="opd" <?php if ( !empty( $access ) and in_array ( 'opd', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>all services</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_opd_services" <?php if ( !empty( $access ) and in_array ( 'all_opd_services', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_opd_services" <?php if ( !empty( $access ) and in_array ( 'edit_opd_services', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_opd_services" <?php if ( !empty( $access ) and in_array ( 'delete_opd_services', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="active_inactive_opd_services" <?php if ( !empty( $access ) and in_array ( 'active_inactive_opd_services', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Active/Inactive
            </td>
        </tr>
        <tr>
            <td></td>
            <td>sale services</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="sale_opd_services" <?php if ( !empty( $access ) and in_array ( 'sale_opd_services', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>sale invoices</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="sale_opd_invoices" <?php if ( !empty( $access ) and in_array ( 'sale_opd_invoices', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_opd_invoices" <?php if ( !empty( $access ) and in_array ( 'print_opd_invoices', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="refund_opd_invoices" <?php if ( !empty( $access ) and in_array ( 'refund_opd_invoices', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Refund
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_opd_invoices" <?php if ( !empty( $access ) and in_array ( 'delete_opd_invoices', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td>sale invoices (panel)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="panel_sale_opd_invoices" <?php if ( !empty( $access ) and in_array ( 'panel_sale_opd_invoices', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="panel_print_opd_invoices" <?php if ( !empty( $access ) and in_array ( 'print_opd_invoices', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="panel_refund_opd_invoices" <?php if ( !empty( $access ) and in_array ( 'refund_opd_invoices', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Refund
                <input type="checkbox" class="checkbox" name="access[]"
                       value="panel_delete_opd_invoices" <?php if ( !empty( $access ) and in_array ( 'delete_opd_invoices', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add OPD Discount</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_opd_discount" <?php if ( !empty( $access ) and in_array ( 'add_opd_discount', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> OPD Reporting</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="opd-reporting" <?php if ( !empty( $access ) and in_array ( 'opd-reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>General Report (Cash)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="opd_general_reporting" <?php if ( !empty( $access ) and in_array ( 'opd_general_reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>General Report (Panel)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="opd_general_reporting_panel" <?php if ( !empty( $access ) and in_array ( 'opd_general_reporting_panel', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> OPD Settings</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="opd_settings" <?php if ( !empty( $access ) and in_array ( 'opd_settings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add services</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_opd_services" <?php if ( !empty( $access ) and in_array ( 'add_opd_services', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Doctor Prescriptions</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="doctor-prescriptions" <?php if ( !empty( $access ) and in_array ( 'doctor-prescriptions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Follow Ups</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="prescriptions-follow-ups" <?php if ( !empty( $access ) and in_array ( 'prescriptions-follow-ups', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Consultancy Reporting</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="consultancy-reporting" <?php if ( !empty( $access ) and in_array ( 'consultancy-reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>General Reporting (Cash)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="consultancy_general_reporting" <?php if ( !empty( $access ) and in_array ( 'consultancy_general_reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>General Reporting (Panel)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="consultancy_general_reporting_panel" <?php if ( !empty( $access ) and in_array ( 'consultancy_general_reporting_panel', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Doctor Wise Reporting</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="doctor_consultancy_reporting" <?php if ( !empty( $access ) and in_array ( 'doctor_consultancy_reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Doctor Wise Report (Summary)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="doctor_consultancy_reporting_summary" <?php if ( !empty( $access ) and in_array ( 'doctor_consultancy_reporting_summary', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Department Settings</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="member-settings" <?php if ( !empty( $access ) and in_array ( 'member-settings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>all departments</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_departments" <?php if ( !empty( $access ) and in_array ( 'all_departments', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>add departments</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_departments" <?php if ( !empty( $access ) and in_array ( 'add_departments', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_departments" <?php if ( !empty( $access ) and in_array ( 'edit_departments', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_departments" <?php if ( !empty( $access ) and in_array ( 'delete_departments', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Store Reporting</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="store-reporting" <?php if ( !empty( $access ) and in_array ( 'store-reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td>general report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="store_general_report" <?php if ( !empty( $access ) and in_array ( 'store_general_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td></td>
            <td> Stock Valuation Report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="store-stock-valuation-report" <?php if ( !empty( $access ) and in_array ( 'store-stock-valuation-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td></td>
            <td> Store Threshold Report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="store-threshold-report" <?php if ( !empty( $access ) and in_array ( 'store-threshold-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td></td>
            <td> Store Purchase Report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="store-purchase-report" <?php if ( !empty( $access ) and in_array ( 'store-purchase-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td></td>
            <td> Fix Assets Report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="store-fix-assets-report" <?php if ( !empty( $access ) and in_array ( 'store-fix-assets-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Store Settings</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="store-settings" <?php if ( !empty( $access ) and in_array ( 'store-settings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>all par levels</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="store_par_levels" <?php if ( !empty( $access ) and in_array ( 'store_par_levels', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_par_levels" <?php if ( !empty( $access ) and in_array ( 'edit_par_levels', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_par_levels" <?php if ( !empty( $access ) and in_array ( 'delete_par_levels', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_par_levels" <?php if ( !empty( $access ) and in_array ( 'print_par_levels', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
            </td>
        </tr>
        <tr>
            <td></td>
            <td>add par levels</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_store_par_levels" <?php if ( !empty( $access ) and in_array ( 'add_store_par_levels', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Requisitions</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="requisition" <?php if ( !empty( $access ) and in_array ( 'requisition', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>all Requisitions (store)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_requisitions" <?php if ( !empty( $access ) and in_array ( 'all_requisitions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_all_requisitions" <?php if ( !empty( $access ) and in_array ( 'edit_all_requisitions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_all_requisitions" <?php if ( !empty( $access ) and in_array ( 'delete_all_requisitions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_requisitions" <?php if ( !empty( $access ) and in_array ( 'print_requisitions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
            </td>
        </tr>
        <tr>
            <td></td>
            <td>add Requisitions (Store)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_store_requisitions" <?php if ( !empty( $access ) and in_array ( 'add_store_requisitions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>all Requisitions (Others)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="demand_requisitions" <?php if ( !empty( $access ) and in_array ( 'demand_requisitions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_demand_requisitions" <?php if ( !empty( $access ) and in_array ( 'edit_demand_requisitions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_demand_requisitions" <?php if ( !empty( $access ) and in_array ( 'delete_demand_requisitions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_demand_requisitions" <?php if ( !empty( $access ) and in_array ( 'print_demand_requisitions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
            </td>
        </tr>
        <tr>
            <td></td>
            <td>add Requisitions (Other)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_other_requisitions" <?php if ( !empty( $access ) and in_array ( 'add_other_requisitions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Facility Manager</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="facility-manager" <?php if ( !empty( $access ) and in_array ( 'facility-manager', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Requisitions (Store)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="facility_manager_store_requisition" <?php if ( !empty( $access ) and in_array ( 'facility_manager_store_requisition', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="approve_fm_request" <?php if ( !empty( $access ) and in_array ( 'approve_fm_request', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Approve
                <input type="checkbox" class="checkbox" name="access[]"
                       value="reject_fm_request" <?php if ( !empty( $access ) and in_array ( 'reject_fm_request', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Reject
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_fm_request" <?php if ( !empty( $access ) and in_array ( 'delete_fm_request', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Requisitions (Others)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="facility_manager_other_requisition" <?php if ( !empty( $access ) and in_array ( 'facility_manager_other_requisition', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="approve_fm_demand" <?php if ( !empty( $access ) and in_array ( 'approve_fm_demand', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Approve
                <input type="checkbox" class="checkbox" name="access[]"
                       value="reject_fm_demand" <?php if ( !empty( $access ) and in_array ( 'reject_fm_demand', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Reject
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_fm_demand" <?php if ( !empty( $access ) and in_array ( 'delete_fm_demand', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Instructions</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="instructions" <?php if ( !empty( $access ) and in_array ( 'instructions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> IPD</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd" <?php if ( !empty( $access ) and in_array ( 'ipd', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>register patient</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_register_patient" <?php if ( !empty( $access ) and in_array ( 'ipd_register_patient', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>ipd invoices (Cash)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_invoice" <?php if ( !empty( $access ) and in_array ( 'ipd_invoice', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>ipd invoices (Panel)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_invoice_panel" <?php if ( !empty( $access ) and in_array ( 'ipd_invoice_panel', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_ipd_invoice" <?php if ( !empty( $access ) and in_array ( 'print_ipd_invoice', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="c_print_ipd_invoice" <?php if ( !empty( $access ) and in_array ( 'c_print_ipd_invoice', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> C Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="discharge_ipd_invoice" <?php if ( !empty( $access ) and in_array ( 'discharge_ipd_invoice', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Discharge
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_ipd_invoice" <?php if ( !empty( $access ) and in_array ( 'edit_ipd_invoice', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="send_claim" <?php if ( !empty( $access ) and in_array ( 'send_claim', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Send Claim
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_ipd_invoice" <?php if ( !empty( $access ) and in_array ( 'delete_ipd_invoice', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>discharged patients</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_discharged_patient" <?php if ( !empty( $access ) and in_array ( 'ipd_discharged_patient', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_discharged_ipd_invoice" <?php if ( !empty( $access ) and in_array ( 'print_discharged_ipd_invoice', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_discharged_ipd_invoice" <?php if ( !empty( $access ) and in_array ( 'edit_discharged_ipd_invoice', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_discharged_ipd_invoice" <?php if ( !empty( $access ) and in_array ( 'delete_discharged_ipd_invoice', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>IPD Tabs</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_admission_slip" <?php if ( !empty( $access ) and in_array ( 'ipd_admission_slip', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Admission Slip
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_tab_services" <?php if ( !empty( $access ) and in_array ( 'ipd_tab_services', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> IPD Services
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_lab_tests" <?php if ( !empty( $access ) and in_array ( 'ipd_lab_tests', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Lab Tests
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_generate_requisitions" <?php if ( !empty( $access ) and in_array ( 'ipd_generate_requisitions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Generate Requisitions
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_medications" <?php if ( !empty( $access ) and in_array ( 'ipd_medications', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Medications
                <input type="checkbox" class="checkbox" name="access[]"
                       value="consultants" <?php if ( !empty( $access ) and in_array ( 'consultants', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Consultants
                <input type="checkbox" class="checkbox" name="access[]"
                       value="anesthesia-charges" <?php if ( !empty( $access ) and in_array ( 'anesthesia-charges', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Anesthesia Charges
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_billing" <?php if ( !empty( $access ) and in_array ( 'ipd_billing', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Billing
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_add_payment" <?php if ( !empty( $access ) and in_array ( 'ipd_add_payment', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Add Payment
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_discharge_date" <?php if ( !empty( $access ) and in_array ( 'ipd_discharge_date', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Discharge Date
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_ot_timings" <?php if ( !empty( $access ) and in_array ( 'ipd_ot_timings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> OT Timings
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td>IPD Edit Control</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Delete IPD Services</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_added_ipd_services" <?php if ( !empty( $access ) and in_array ( 'delete_added_ipd_services', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Delete IPD Lab Tests</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_added_ipd_lab_tests" <?php if ( !empty( $access ) and in_array ( 'delete_added_ipd_lab_tests', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Delete IPD Medication</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_added_ipd_medication" <?php if ( !empty( $access ) and in_array ( 'delete_added_ipd_medication', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Discharge IPD Patient</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="discharge_ipd_patient" <?php if ( !empty( $access ) and in_array ( 'discharge_ipd_patient', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Delete Payments Billing</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete-payments-billings" <?php if ( !empty( $access ) and in_array ( 'delete-payments-billings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Discount In Billing</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="discount-in-billings" <?php if ( !empty( $access ) and in_array ( 'discount-in-billings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Initial Deposit In Billing</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="initial-deposit-in-billings" <?php if ( !empty( $access ) and in_array ( 'initial-deposit-in-billings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Medical Officer (MO)</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_mo" <?php if ( !empty( $access ) and in_array ( 'ipd_mo', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Admission Orders</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_mo_add_admissions" <?php if ( !empty( $access ) and in_array ( 'ipd_mo_add_admissions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Admission Orders</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_mo_admissions" <?php if ( !empty( $access ) and in_array ( 'ipd_mo_admissions', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_mo_adm_order" <?php if ( !empty( $access ) and in_array ( 'print_mo_adm_order', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_mo_adm_order" <?php if ( !empty( $access ) and in_array ( 'edit_mo_adm_order', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_mo_adm_order" <?php if ( !empty( $access ) and in_array ( 'delete_mo_adm_order', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> History - Physical Examination</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="physical_examination" <?php if ( !empty( $access ) and in_array ( 'physical_examination', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> All History - Physical Examination</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_physical_examination" <?php if ( !empty( $access ) and in_array ( 'all_physical_examination', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_physical_examination" <?php if ( !empty( $access ) and in_array ( 'edit_physical_examination', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_physical_examination" <?php if ( !empty( $access ) and in_array ( 'delete_physical_examination', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Add Progress Notes</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_progress_notes" <?php if ( !empty( $access ) and in_array ( 'add_progress_notes', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> All Progress Notes</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_progress_notes" <?php if ( !empty( $access ) and in_array ( 'all_progress_notes', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_progress_notes" <?php if ( !empty( $access ) and in_array ( 'edit_progress_notes', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_progress_notes" <?php if ( !empty( $access ) and in_array ( 'delete_progress_notes', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Add Diagnostic Flow Sheet</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_diagnostic_flow_sheet" <?php if ( !empty( $access ) and in_array ( 'add_diagnostic_flow_sheet', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> All Diagnostic Flow Sheet</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_diagnostic_flow_sheet" <?php if ( !empty( $access ) and in_array ( 'all_diagnostic_flow_sheet', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_diagnostic_flow_sheet" <?php if ( !empty( $access ) and in_array ( 'edit_diagnostic_flow_sheet', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_diagnostic_flow_sheet" <?php if ( !empty( $access ) and in_array ( 'delete_diagnostic_flow_sheet', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Add Discharge Summary</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_discharge_summary" <?php if ( !empty( $access ) and in_array ( 'add_discharge_summary', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> All Discharge Summary</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_discharge_summary"" <?php if ( !empty( $access ) and in_array ( 'all_discharge_summary', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_discharge_summary"" <?php if ( !empty( $access ) and in_array ( 'print_discharge_summary', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_discharge_summary"" <?php if ( !empty( $access ) and in_array ( 'edit_discharge_summary', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_discharge_summary"" <?php if ( !empty( $access ) and in_array ( 'delete_diagnostic_flow_sheet', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Add Blood Transfusion</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_blood_transfusion" <?php if ( !empty( $access ) and in_array ( 'add_blood_transfusion', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> All Blood Transfusions</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_blood_transfusion" <?php if ( !empty( $access ) and in_array ( 'all_blood_transfusion', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_blood_transfusion" <?php if ( !empty( $access ) and in_array ( 'edit_blood_transfusion', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_blood_transfusion" <?php if ( !empty( $access ) and in_array ( 'delete_blood_transfusion', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_discharge_slip" <?php if ( !empty( $access ) and in_array ( 'print_discharge_slip', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Add Discharge Slip</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_discharge_slip" <?php if ( !empty( $access ) and in_array ( 'add_discharge_slip', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> All Discharge Slips</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_discharge_slips" <?php if ( !empty( $access ) and in_array ( 'all_discharge_slips', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_discharge_slip" <?php if ( !empty( $access ) and in_array ( 'edit_discharge_slip', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_discharge_slip" <?php if ( !empty( $access ) and in_array ( 'delete_discharge_slip', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> IPD Reporting</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd-reporting" <?php if ( !empty( $access ) and in_array ( 'ipd-reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>general report (cash)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_general_report" <?php if ( !empty( $access ) and in_array ( 'ipd_general_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>general report (panel)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_general_report_panel" <?php if ( !empty( $access ) and in_array ( 'ipd_general_report_panel', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Consultant Commission</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="consultant_commission" <?php if ( !empty( $access ) and in_array ( 'consultant_commission', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>OT Timings Report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ot_timings_report" <?php if ( !empty( $access ) and in_array ( 'ot_timings_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Bed Status Report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="bed_status_report" <?php if ( !empty( $access ) and in_array ( 'bed_status_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>IPD Summary Report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd-summary-report" <?php if ( !empty( $access ) and in_array ( 'ipd-summary-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Receivable Report (SSP)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd-receivable-report" <?php if ( !empty( $access ) and in_array ( 'ipd-receivable-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Claim Status Report (SSP)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd-claim-status-report" <?php if ( !empty( $access ) and in_array ( 'ipd-claim-status-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Claim Aging Report (SSP)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd-claim-aging-report" <?php if ( !empty( $access ) and in_array ( 'ipd-claim-aging-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Cash Receiving Report (Cash)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd-cash-receiving-report-cash" <?php if ( !empty( $access ) and in_array ( 'ipd-cash-receiving-report-cash', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Cash Receiving Report (Panel)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd-cash-receiving-report-panel" <?php if ( !empty( $access ) and in_array ( 'ipd-cash-receiving-report-panel', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> IPD Settings</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd-settings" <?php if ( !empty( $access ) and in_array ( 'ipd-settings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>services</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_services" <?php if ( !empty( $access ) and in_array ( 'ipd_services', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_ipd_services" <?php if ( !empty( $access ) and in_array ( 'edit_ipd_services', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_ipd_services" <?php if ( !empty( $access ) and in_array ( 'delete_ipd_services', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>add services</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_ipd_services" <?php if ( !empty( $access ) and in_array ( 'add_ipd_services', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>packages</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ipd_packages" <?php if ( !empty( $access ) and in_array ( 'ipd_packages', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_ipd_packages" <?php if ( !empty( $access ) and in_array ( 'edit_ipd_packages', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_ipd_package" <?php if ( !empty( $access ) and in_array ( 'print_ipd_package', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_ipd_packages" <?php if ( !empty( $access ) and in_array ( 'delete_ipd_packages', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>add packages</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_ipd_packages" <?php if ( !empty( $access ) and in_array ( 'add_ipd_packages', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td>rooms/Beds</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="rooms" <?php if ( !empty( $access ) and in_array ( 'rooms', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit-room" <?php if ( !empty( $access ) and in_array ( 'edit-room', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete-room" <?php if ( !empty( $access ) and in_array ( 'delete-room', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>add rooms/Beds</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-room" <?php if ( !empty( $access ) and in_array ( 'add-room', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td> Internal Issuance</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="internal-issuance" <?php if ( !empty( $access ) and in_array ( 'internal-issuance', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Issue Medicine</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="issue_internal_medicine" <?php if ( !empty( $access ) and in_array ( 'issue_internal_medicine', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Search Issuance</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="search_internal_issuance" <?php if ( !empty( $access ) and in_array ( 'search_internal_issuance', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Issuance</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_internal_issuance" <?php if ( !empty( $access ) and in_array ( 'all_internal_issuance', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_internal_issuance" <?php if ( !empty( $access ) and in_array ( 'edit_internal_issuance', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_internal_issuance" <?php if ( !empty( $access ) and in_array ( 'delete_internal_issuance', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Internal Issuance Reporting</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="internal-issuance-medicines-reporting" <?php if ( !empty( $access ) and in_array ( 'internal-issuance-medicines-reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>General Report</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="internal-issuance-medicines-general-report" <?php if ( !empty( $access ) and in_array ( 'internal-issuance-medicines-general-report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Internal Issuance Medicines Settings</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="internal-issuance-medicines-settings" <?php if ( !empty( $access ) and in_array ( 'internal-issuance-medicines-settings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>All Par levels</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="internal_issuance_par_levels" <?php if ( !empty( $access ) and in_array ( 'internal_issuance_par_levels', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_internal_issuance_par_levels" <?php if ( !empty( $access ) and in_array ( 'edit_internal_issuance_par_levels', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_internal_issuance_par_levels" <?php if ( !empty( $access ) and in_array ( 'delete_internal_issuance_par_levels', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Add Par levels</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_internal_issuance_par_levels" <?php if ( !empty( $access ) and in_array ( 'add_internal_issuance_par_levels', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td> Radiology</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="radiology" <?php if ( !empty( $access ) and in_array ( 'radiology', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td> XRay</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="xray" <?php if ( !empty( $access ) and in_array ( 'xray', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_xray_report" <?php if ( !empty( $access ) and in_array ( 'add_xray_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Add Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="search_xray_report" <?php if ( !empty( $access ) and in_array ( 'search_xray_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Search Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_xray_reports" <?php if ( !empty( $access ) and in_array ( 'all_xray_reports', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>All Reports
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td style="padding-left: 35px">
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_xray_report" <?php if ( !empty( $access ) and in_array ( 'print_xray_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="verify_xray_report_button" <?php if ( !empty( $access ) and in_array ( 'verify_xray_report_button', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Verify
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_xray_report" <?php if ( !empty( $access ) and in_array ( 'edit_xray_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_xray_report" <?php if ( !empty( $access ) and in_array ( 'delete_xray_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td></td>
            <td> CT-Scan</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ct-scan" <?php if ( !empty( $access ) and in_array ( 'ct-scan', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_ct_scan_report" <?php if ( !empty( $access ) and in_array ( 'add_ct_scan_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Add Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="search_ct_scan_report" <?php if ( !empty( $access ) and in_array ( 'search_ct_scan_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Search Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_ct_scan_reports" <?php if ( !empty( $access ) and in_array ( 'all_ct_scan_reports', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>All Reports
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td style="padding-left: 35px">
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_ct_scan_report" <?php if ( !empty( $access ) and in_array ( 'print_ct_scan_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_ct_scan_report" <?php if ( !empty( $access ) and in_array ( 'edit_ct_scan_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="verify_ct_scan_report_button" <?php if ( !empty( $access ) and in_array ( 'verify_ct_scan_report_button', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Verify
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_ct_scan_report" <?php if ( !empty( $access ) and in_array ( 'delete_ct_scan_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td></td>
            <td> MRI</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="mri" <?php if ( !empty( $access ) and in_array ( 'mri', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_mri_report" <?php if ( !empty( $access ) and in_array ( 'add_mri_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Add Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="search_mri_report" <?php if ( !empty( $access ) and in_array ( 'search_mri_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Search Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_mri_reports" <?php if ( !empty( $access ) and in_array ( 'all_mri_reports', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>All Reports
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td style="padding-left: 35px">
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_mri_report" <?php if ( !empty( $access ) and in_array ( 'print_mri_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_mri_report" <?php if ( !empty( $access ) and in_array ( 'edit_mri_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="verify_mri_report_button" <?php if ( !empty( $access ) and in_array ( 'verify_mri_report_button', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Verify
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_mri_report" <?php if ( !empty( $access ) and in_array ( 'delete_mri_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td></td>
            <td> Ultrasound</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ultrasound" <?php if ( !empty( $access ) and in_array ( 'ultrasound', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_ultrasound_report" <?php if ( !empty( $access ) and in_array ( 'add_ultrasound_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Add Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="search_ultrasound_report" <?php if ( !empty( $access ) and in_array ( 'search_ultrasound_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Search Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_ultrasound_reports" <?php if ( !empty( $access ) and in_array ( 'all_ultrasound_reports', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> All Reports
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td style="padding-left: 35px">
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_ultrasound_report" <?php if ( !empty( $access ) and in_array ( 'print_ultrasound_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_ultrasound_report" <?php if ( !empty( $access ) and in_array ( 'edit_ultrasound_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="verify_ultrasound_report_button" <?php if ( !empty( $access ) and in_array ( 'verify_ultrasound_report_button', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Verify
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_ultrasound_report" <?php if ( !empty( $access ) and in_array ( 'delete_ultrasound_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td></td>
            <td> ECHO</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="echo" <?php if ( !empty( $access ) and in_array ( 'echo', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_echo_report" <?php if ( !empty( $access ) and in_array ( 'add_echo_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Add Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="search_echo_report" <?php if ( !empty( $access ) and in_array ( 'search_echo_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>Search Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_echo_reports" <?php if ( !empty( $access ) and in_array ( 'all_echo_reports', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> All Reports
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td style="padding-left: 35px">
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_echo_report" <?php if ( !empty( $access ) and in_array ( 'print_echo_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_echo_report" <?php if ( !empty( $access ) and in_array ( 'edit_echo_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_echo_report" <?php if ( !empty( $access ) and in_array ( 'delete_echo_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td></td>
            <td> ECG</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ecg" <?php if ( !empty( $access ) and in_array ( 'ecg', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add_ecg_report" <?php if ( !empty( $access ) and in_array ( 'add_ecg_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Add Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="search_ecg_report" <?php if ( !empty( $access ) and in_array ( 'search_ecg_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>Search Report
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all_ecg_reports" <?php if ( !empty( $access ) and in_array ( 'all_ecg_reports', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> All Reports
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td style="padding-left: 35px">
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print_ecg_report" <?php if ( !empty( $access ) and in_array ( 'print_ecg_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit_ecg_report" <?php if ( !empty( $access ) and in_array ( 'edit_ecg_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete_ecg_report" <?php if ( !empty( $access ) and in_array ( 'delete_ecg_report', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td>Radiology Reporting</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="radiology-reporting" <?php if ( !empty( $access ) and in_array ( 'radiology-reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
            <td></td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>General Report (X-Ray)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="xray_general_reporting" <?php if ( !empty( $access ) and in_array ( 'xray_general_reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>General Report (Ultrasound)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ultrasound_general_reporting" <?php if ( !empty( $access ) and in_array ( 'ultrasound_general_reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>General Report (CT-Scan)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ct_scan_general_reporting" <?php if ( !empty( $access ) and in_array ( 'ct_scan_general_reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>General Report (MRI)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="mri_general_reporting" <?php if ( !empty( $access ) and in_array ( 'mri_general_reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>General Report (ECHO)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="echo_general_reporting" <?php if ( !empty( $access ) and in_array ( 'echo_general_reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>General Report (ECG)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ecg_general_reporting" <?php if ( !empty( $access ) and in_array ( 'ecg_general_reporting', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td>Radiology Settings</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="radiology-settings" <?php if ( !empty( $access ) and in_array ( 'radiology-settings', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
            <td></td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>All Templates (Ultrasound)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="templates" <?php if ( !empty( $access ) and in_array ( 'templates', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Add Templates (Ultrasound)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-templates" <?php if ( !empty( $access ) and in_array ( 'add-templates', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>All Templates (X-Ray)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="templates-xray" <?php if ( !empty( $access ) and in_array ( 'templates-xray', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Add Templates (X-Ray)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-templates-xray" <?php if ( !empty( $access ) and in_array ( 'add-templates-xray', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>All Templates (CT-Scan)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="templates-ct-scan" <?php if ( !empty( $access ) and in_array ( 'templates-ct-scan', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Add Templates (CT-Scan)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-templates-ct-scan" <?php if ( !empty( $access ) and in_array ( 'add-templates-ct-scan', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>All Templates (MRI)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="templates-mri" <?php if ( !empty( $access ) and in_array ( 'templates-mri', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Add Templates (MRI)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-templates-mri" <?php if ( !empty( $access ) and in_array ( 'add-templates-mri', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td></td>
            <td>All Templates (ECHO)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="echo-templates" <?php if ( !empty( $access ) and in_array ( 'echo-templates', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Add Templates (ECHO)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-echo-templates" <?php if ( !empty( $access ) and in_array ( 'add-echo-templates', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td></td>
            <td>All Templates (ECG)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="ecg-templates" <?php if ( !empty( $access ) and in_array ( 'ecg-templates', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Add Templates (ECG)</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-ecg-templates" <?php if ( !empty( $access ) and in_array ( 'add-ecg-templates', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td>Metrics Analysis</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="metrics-analysis" <?php if ( !empty( $access ) and in_array ( 'metrics-analysis', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
            <td></td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Patients Analysis</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="patients_analysis" <?php if ( !empty( $access ) and in_array ( 'patients_analysis', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td>Birth Certifictes</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="birth-certificates" <?php if ( !empty( $access ) and in_array ( 'birth-certificates', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
            <td></td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>All Certificates</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all-birth-certificates" <?php if ( !empty( $access ) and in_array ( 'all-birth-certificates', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit-birth-certificate" <?php if ( !empty( $access ) and in_array ( 'edit-birth-certificate', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete-birth-certificate" <?php if ( !empty( $access ) and in_array ( 'delete-birth-certificate', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print-birth-certificate" <?php if ( !empty( $access ) and in_array ( 'print-birth-certificate', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Add Certificates</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-birth-certificates" <?php if ( !empty( $access ) and in_array ( 'add-birth-certificates', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        
        <tr style="background: #dff0d8;">
            <td>Death Certificates</td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="death-certificates" <?php if ( !empty( $access ) and in_array ( 'death-certificates', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
            <td></td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>All Certificates</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="all-death-certificates" <?php if ( !empty( $access ) and in_array ( 'all-death-certificates', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td></td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="edit-death-certificate" <?php if ( !empty( $access ) and in_array ( 'edit-death-certificate', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Edit
                <input type="checkbox" class="checkbox" name="access[]"
                       value="delete-death-certificate" <?php if ( !empty( $access ) and in_array ( 'delete-death-certificate', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Delete
                <input type="checkbox" class="checkbox" name="access[]"
                       value="print-death-certificate" <?php if ( !empty( $access ) and in_array ( 'print-death-certificate', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>> Print
            </td>
        </tr>
        <tr style="background: #dff0d8;">
            <td></td>
            <td>Add Certificates</td>
            <td>
                <input type="checkbox" class="checkbox" name="access[]"
                       value="add-death-certificates" <?php if ( !empty( $access ) and in_array ( 'add-death-certificates', explode ( ',', $access -> access ) ) )
                    echo 'checked="checked"' ?>>
            </td>
        </tr>
        </tbody>
    </table>
</div>
