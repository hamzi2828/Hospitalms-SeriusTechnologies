<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VaccinationSetting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('VaccinationModel'); 
        $this -> lang -> load ( 'general', 'english' );
        $this -> load -> model ( 'DoctorModel' );
        $this -> load -> model ( 'RadiologyModel' );
        $this -> load -> model ( 'TemplateModel' );

    }

    /** 
     * -------------------------
     * Header template
     * -------------------------
     */
    public function header($title) {
        $data['title'] = $title;
        $this->load->view('/includes/admin/header', $data);
    }

    /**
     * -------------------------
     * Sidebar template
     * -------------------------
     */
    public function sidebar() {
        $this->load->view('/includes/admin/general-sidebar');
    }

    /**
     * -------------------------
     * Footer template
     * -------------------------
     */
    public function footer() {
        $this->load->view('/includes/admin/footer');
    }

    /**
     * -------------------------
     * All Products page
     * -------------------------
     */
    public function add_vaccination() {
        if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_vaccinations' )
        $this -> do_add_vaccinations ( $_POST );
    
    $title = site_name . ' - All Vaccinations';
    $this -> header ( $title );
    $this -> sidebar ();
    $data[ 'doctors' ]   = $this -> DoctorModel -> get_doctors ();
    $data[ 'templates' ] = $this -> TemplateModel -> get_xray_templates ();
    $this -> load -> view ( '/Vaccinations/add_vaccinations', $data );
    $this -> footer ();
    }

    public function do_add_vaccinations() {
        $data = $_POST;
    
        // Prepare the data array
        $info = array(
            'user_id'    => get_logged_in_user_id(),
            'order_by'   => $data['order_by'],
            'patient_id' => $data['patient-id'],
            'sale_id'    => $data['sale-id'],
            'study'      => $data['study']
        );
    
        // Insert the data directly using the database library
        if ($this->db->insert('vaccinations_details', $info)) {
            $this->session->set_flashdata('response', 'Success! Vaccination added.');
        } else {
            $this->session->set_flashdata('error', 'Error! Please try again.');
        }
    
        // Redirect back to the referring page
        return redirect($_SERVER['HTTP_REFERER']);
    }
    



    public function all_vaccinations () {
        $title = site_name . ' - All Vaccinations';
        $this -> header ( $title );
        $this -> sidebar ();
        
        $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
        $data[ 'reports' ] = $this -> VaccinationModel -> get_all_vaccinations ( );
        $str_links         = $this -> pagination -> create_links ();
        $data[ "links" ]   = explode ( '&nbsp;', $str_links );
        $this -> load -> view ( 'Vaccinations/all_vaccinations', $data );
        $this -> footer ();
    }


    public function delete_vaccination( $id ) {
        if ( $this -> VaccinationModel -> delete_vaccination ( $id ) ) {
            $this -> session -> set_flashdata ( 'response', 'Success! Vaccination deleted.' );
        } else {
            $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
        }
        
        return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
    }

    public function edit_vaccination( $id ) {

        if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_update_vaccination' )
        $this -> do_update_vaccination ( $_POST );

        $title = site_name . ' - All Vaccinations';
        $this -> header ( $title );
        $this -> sidebar ();
        $data[ 'doctors' ]   = $this -> DoctorModel -> get_doctors ();
        $data[ 'templates' ] = $this -> TemplateModel -> get_xray_templates ();
        $data[ 'vaccination' ] = $this -> VaccinationModel -> get_vaccination_by_id ( $id );
        $this -> load -> view ( 'Vaccinations/edit_vaccination', $data );
        $this -> footer ();

    }

    public function do_update_vaccination() {
        // Check if form is submitted
        if ($this->input->post('action') === 'do_update_vaccination') {
            $id = $this->input->post('id'); // Get vaccination ID
            $data = $this->input->post();
    
            // Prepare the data array for update
            $info = array(
                'user_id'    => get_logged_in_user_id(),
                'order_by'   => $data['order_by'],
                'patient_id' => $data['patient-id'],
                'sale_id'    => $data['sale-id'],
                'study'      => $data['study']
            );
    
            // Update the vaccination record
            if ($this->VaccinationModel->update_vaccination($id, $info)) {
                $this->session->set_flashdata('response', 'Success! Vaccination updated.');
            } else {
                $this->session->set_flashdata('error', 'Error! Please try again.');
            }
    
            // Redirect back to the referring page
            return redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->set_flashdata('error', 'Invalid request.');
            return redirect($_SERVER['HTTP_REFERER']);
        }
    }
    

}
