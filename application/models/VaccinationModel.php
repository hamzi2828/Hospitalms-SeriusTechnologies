<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class VaccinationModel extends CI_Model {
        
        /**
         * -------------------------
         * Class constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save tests into database
         * -------------------------
         */


         public function get_all_vaccinations() {
            // Start building the query with filters
            $this->db->order_by('id', 'DESC');
            
            if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
                $this->db->where('id', $_REQUEST['id']);
            }
        
            if (isset($_REQUEST['patient_id']) && $_REQUEST['patient_id'] > 0) {
                $this->db->where('patient_id', $_REQUEST['patient_id']);
            }
        
            if (isset($_REQUEST['name']) && !empty(trim($_REQUEST['name']))) {
                $name = trim($_REQUEST['name']);
                $this->db->where("patient_id IN (SELECT id FROM hmis_patients WHERE name LIKE '%$name%')");
            }
        
            // Execute the query
            $query = $this->db->get('vaccinations_details');
        
            return $query->result();
        }
        
     

        public function delete_vaccination ( $id ) {
            $this->db->where('id', $id)->delete('vaccinations_details');
            return $this->db->affected_rows();
            
        }

        public function get_vaccination_by_id ( $id ) {
            
            $query = $this->db->get_where('vaccinations_details', array('id' => $id));
            
            return $query->row();
        }
    
        public function update_vaccination($id, $info) {
            $this->db->where('id', $id);
            return $this->db->update('vaccinations_details', $info);
        }
        
        
        
    }
