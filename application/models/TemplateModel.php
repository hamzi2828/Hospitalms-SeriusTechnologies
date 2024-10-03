<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class TemplateModel extends CI_Model {
        
        /**
         * ----------
         * Template constructor.
         * ----------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * ----------
         * @return mixed
         * get templates
         * ----------
         */
        
        public function get_templates () {
            $templates = $this -> db -> get ( 'templates' );
            return $templates -> result ();
        }
        
        /**
         * ----------
         * @return mixed
         * get templates
         * ----------
         */
        
        public function get_xray_templates () {
            $templates = $this -> db -> get ( 'xray_templates' );
            return $templates -> result ();
        }
        
        /**
         * ----------
         * @param $id
         * @return mixed
         * get template by id
         * ----------
         */
        
        public function get_template_by_id ( $id ) {
            $template = $this -> db -> get_where ( 'templates', array ( 'id' => $id ) );
            return $template -> row ();
        }
        
        /**
         * ----------
         * @param $id
         * @return mixed
         * get template by id
         * ----------
         */
        
        public function get_xray_template_by_id ( $id ) {
            $template = $this -> db -> get_where ( 'xray_templates', array ( 'id' => $id ) );
            return $template -> row ();
        }
        
        /**
         * ----------
         * @param $info
         * @return mixed
         * add templates
         * ----------
         */
        
        public function add ( $info ) {
            $this -> db -> insert ( 'templates', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------
         * @param $info
         * @return mixed
         * add xray templates
         * ----------
         */
        
        public function add_xray_templates ( $info ) {
            $this -> db -> insert ( 'xray_templates', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------
         * @param $info
         * @param $where
         * @return mixed
         * update templates
         * ----------
         */
        
        public function edit ( $info, $where ) {
            $this -> db -> update ( 'templates', $info, $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------
         * @param $info
         * @param $where
         * @return mixed
         * update xray templates
         * ----------
         */
        
        public function edit_xray_template ( $info, $where ) {
            $this -> db -> update ( 'xray_templates', $info, $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------
         * @param $id
         * @return mixed
         * get delete by id
         * ----------
         */
        
        public function delete ( $id ) {
            $template = $this -> db -> delete ( 'templates', array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------
         * @param $id
         * @return mixed
         * get delete by id
         * ----------
         */
        
        public function delete_xray_templates ( $id ) {
            $template = $this -> db -> delete ( 'xray_templates', array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------
         * @return mixed
         * get culture templates
         * ----------
         */
        
        public function get_culture_templates () {
            $templates = $this -> db -> get ( 'culture_templates' );
            return $templates -> result ();
        }
        
        /**
         * ----------
         * @param $info
         * @return mixed
         * add culture templates
         * ----------
         */
        
        public function add_culture_templates ( $info ) {
            $this -> db -> insert ( 'culture_templates', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------
         * @param $id
         * @return mixed
         * get culture template by id
         * ----------
         */
        
        public function get_culture_template_by_id ( $id ) {
            $template = $this -> db -> get_where ( 'culture_templates', array ( 'id' => $id ) );
            return $template -> row ();
        }
        
        /**
         * ----------
         * @param $info
         * @param $where
         * @return mixed
         * update culture templates
         * ----------
         */
        
        public function edit_culture_template ( $info, $where ) {
            $this -> db -> update ( 'culture_templates', $info, $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------
         * @param $id
         * @return mixed
         * delete culture template by id
         * ----------
         */
        
        public function delete_culture_templates ( $id ) {
            $template = $this -> db -> delete ( 'culture_templates', array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
    
        /**
         * ----------
         * @return mixed
         * get histopathology templates
         * ----------
         */
    
        public function get_histopathology_templates () {
            $templates = $this -> db -> get ( 'histopathology_templates' );
            return $templates -> result ();
        }
        
        /**
         * ----------
         * @param $info
         * @return mixed
         * add histopathology templates
         * ----------
         */
        
        public function add_histopathology_templates ( $info ) {
            $this -> db -> insert ( 'histopathology_templates', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------
         * @param $id
         * @return mixed
         * get histopathology template by id
         * ----------
         */
        
        public function get_histopathology_template_by_id ( $id ) {
            $template = $this -> db -> get_where ( 'histopathology_templates', array ( 'id' => $id ) );
            return $template -> row ();
        }
    
        /**
         * ----------
         * @param $info
         * @param $where
         * @return mixed
         * update histopathology templates
         * ----------
         */
    
        public function edit_histopathology_template ( $info, $where ) {
            $this -> db -> update ( 'histopathology_templates', $info, $where );
            return $this -> db -> affected_rows ();
        }
    
        /**
         * ----------
         * @param $id
         * @return mixed
         * delete histopathology template by id
         * ----------
         */
    
        public function delete_histopathology_templates ( $id ) {
            $template = $this -> db -> delete ( 'histopathology_templates', array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
    
        /**
         * ----------
         * @return mixed
         * get antibiotics
         * ----------
         */
    
        public function get_antibiotics () {
            $templates = $this -> db -> get ( 'antibiotics' );
            return $templates -> result ();
        }
    
        /**
         * ----------
         * @param $info
         * @return mixed
         * add antibiotics
         * ----------
         */
    
        public function add_antibiotics ( $info ) {
            $this -> db -> insert ( 'antibiotics', $info );
            return $this -> db -> insert_id ();
        }
    
        /**
         * ----------
         * @param $id
         * @return mixed
         * get antibiotics template by id
         * ----------
         */
    
        public function get_antibiotic_by_id ( $id ) {
            $template = $this -> db -> get_where ( 'antibiotics', array ( 'id' => $id ) );
            return $template -> row ();
        }
    
        /**
         * ----------
         * @param $info
         * @param $where
         * @return mixed
         * update antibiotics templates
         * ----------
         */
    
        public function edit_antibiotics ( $info, $where ) {
            $this -> db -> update ( 'antibiotics', $info, $where );
            return $this -> db -> affected_rows ();
        }
    
        /**
         * ----------
         * @param $id
         * @return mixed
         * delete antibiotics
         * ----------
         */
    
        public function delete_antibiotics ( $id ) {
            $template = $this -> db -> delete ( 'antibiotics', array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
    
        /**
         * ----------
         * @return mixed
         * get ct scan templates
         * ----------
         */
    
        public function get_ct_scan_templates () {
            $templates = $this -> db -> get ( 'ct_scan_templates' );
            return $templates -> result ();
        }
    
        /**
         * ----------
         * @param $info
         * @return mixed
         * add ct scan templates
         * ----------
         */
    
        public function add_ct_scan_templates ( $info ) {
            $this -> db -> insert ( 'ct_scan_templates', $info );
            return $this -> db -> insert_id ();
        }
    
        /**
         * ----------
         * @param $id
         * @return mixed
         * get ct scan template by id
         * ----------
         */
    
        public function get_ct_scan_template_by_id ( $id ) {
            $template = $this -> db -> get_where ( 'ct_scan_templates', array ( 'id' => $id ) );
            return $template -> row ();
        }
    
        /**
         * ----------
         * @param $info
         * @param $where
         * @return mixed
         * update ct scan templates
         * ----------
         */
    
        public function edit_ct_scan_template ( $info, $where ) {
            $this -> db -> update ( 'ct_scan_templates', $info, $where );
            return $this -> db -> affected_rows ();
        }
    
        /**
         * ----------
         * @param $id
         * @return mixed
         * delete ct scan template by id
         * ----------
         */
    
        public function delete_ct_scan_templates ( $id ) {
            $template = $this -> db -> delete ( 'ct_scan_templates', array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
    
        /**
         * ----------
         * @return mixed
         * get mri templates
         * ----------
         */
    
        public function get_mri_templates () {
            $templates = $this -> db -> get ( 'mri_templates' );
            return $templates -> result ();
        }
    
        /**
         * ----------
         * @param $info
         * @return mixed
         * add mri templates
         * ----------
         */
    
        public function add_mri_templates ( $info ) {
            $this -> db -> insert ( 'mri_templates', $info );
            return $this -> db -> insert_id ();
        }
    
        /**
         * ----------
         * @param $id
         * @return mixed
         * get mri template by id
         * ----------
         */
    
        public function get_mri_template_by_id ( $id ) {
            $template = $this -> db -> get_where ( 'mri_templates', array ( 'id' => $id ) );
            return $template -> row ();
        }
    
        /**
         * ----------
         * @param $info
         * @param $where
         * @return mixed
         * update mri templates
         * ----------
         */
    
        public function edit_mri_template ( $info, $where ) {
            $this -> db -> update ( 'mri_templates', $info, $where );
            return $this -> db -> affected_rows ();
        }
    
        /**
         * ----------
         * @param $id
         * @return mixed
         * delete mri template by id
         * ----------
         */
    
        public function delete_mri_templates ( $id ) {
            $template = $this -> db -> delete ( 'mri_templates', array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------
         * @return mixed
         * get templates
         * ----------
         */
        
        public function get_echo_templates () {
            $templates = $this -> db -> get ( 'echo_templates' );
            return $templates -> result ();
        }
        
        /**
         * ----------
         * @param $info
         * @return mixed
         * add templates
         * ----------
         */
        
        public function add_echo_template ( $info ) {
            $this -> db -> insert ( 'echo_templates', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------
         * @param $id
         * @return mixed
         * get template by id
         * ----------
         */
        
        public function get_echo_template_by_id ( $id ) {
            $template = $this -> db -> get_where ( 'echo_templates', array ( 'id' => $id ) );
            return $template -> row ();
        }
        
        /**
         * ----------
         * @param $info
         * @param $where
         * @return mixed
         * update templates
         * ----------
         */
        
        public function edit_echo ( $info, $where ) {
            $this -> db -> update ( 'echo_templates', $info, $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------
         * @param $id
         * @return mixed
         * get delete by id
         * ----------
         */
        
        public function delete_echo ( $id ) {
            $template = $this -> db -> delete ( 'echo_templates', array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------
         * @return mixed
         * get templates
         * ----------
         */
        
        public function get_ecg_templates () {
            $templates = $this -> db -> get ( 'ecg_templates' );
            return $templates -> result ();
        }
        
        /**
         * ----------
         * @param $info
         * @return mixed
         * add templates
         * ----------
         */
        
        public function add_ecg_template ( $info ) {
            $this -> db -> insert ( 'ecg_templates', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------
         * @param $id
         * @return mixed
         * get template by id
         * ----------
         */
        
        public function get_ecg_template_by_id ( $id ) {
            $template = $this -> db -> get_where ( 'ecg_templates', array ( 'id' => $id ) );
            return $template -> row ();
        }
        
        /**
         * ----------
         * @param $info
         * @param $where
         * @return mixed
         * update templates
         * ----------
         */
        
        public function edit_ecg ( $info, $where ) {
            $this -> db -> update ( 'ecg_templates', $info, $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------
         * @param $id
         * @return mixed
         * get delete by id
         * ----------
         */
        
        public function delete_ecg ( $id ) {
            $template = $this -> db -> delete ( 'ecg_templates', array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
        
    }