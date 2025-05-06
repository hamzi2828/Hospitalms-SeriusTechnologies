<?php
// Check if the function already exists to avoid redefinition
if (!function_exists('check_panel_type_cash_panel')) {
    /**
     * Check if a panel is a Cash Panel
     * 
     * @param int $panel_id Panel ID to check
     * @return string Returns 'Cash Panel' if the panel is a cash panel, otherwise returns panel type
     */
    function check_panel_type_cash_panel($panel_id) {
        $CI = &get_instance();
        if ($panel_id > 0) {
            $CI->db->where('id', $panel_id);
            $panel = $CI->db->get('hmis_panels')->row();
            if ($panel) {
                return $panel->type;
            }
        }
        return '';
    }
}

// Add this new function to modify the get_sales_by_sale_id method
if (!function_exists('get_cash_panel_patients_sql')) {
    /**
     * Get SQL condition for cash panel patients
     * 
     * @return string SQL condition for cash panel patients
     */
    function get_cash_panel_patients_sql() {
        return " and (patient_id IN (Select id from hmis_patients where panel_id < 1 or panel_id = 0 or panel_id IS NULL) 
                OR patient_id IN (Select p.id from hmis_patients p 
                                 JOIN hmis_panels pnl ON p.panel_id = pnl.id 
                                 WHERE pnl.type = 'Cash Panel'))";
    }
}
