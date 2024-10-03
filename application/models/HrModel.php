<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class HrModel extends CI_Model {
        
        /**
         * -------------------------
         * HrModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get employees
         * -------------------------
         */
        
        public function get_employees () {
            $employees = $this -> db -> get ( 'employees' );
            return $employees -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get active employees
         * -------------------------
         */
        
        public function get_active_employees () {
            $employees = $this -> db -> get_where ( 'employees', array ( 'active' => '1' ) );
            return $employees -> result ();
        }
        
        /**
         * -------------------------
         * @param $info
         * add employees
         * -------------------------
         * @return mixed
         */
        
        public function add ( $info ) {
            $this -> db -> insert ( 'employees', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $info
         * add employees
         * -------------------------
         * @return mixed
         */
        
        public function add_bank_info ( $info ) {
            $this -> db -> insert ( 'employee_bank_info', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $info
         * add employees
         * -------------------------
         * @return mixed
         */
        
        public function add_documents ( $info ) {
            $this -> db -> insert ( 'employee_documents', $info );
            return $this -> db -> insert_id ();
        }
        
        public function add_family_details ( $info ) {
            $this -> db -> insert ( 'employee_family_details', $info );
            return $this -> db -> insert_id ();
        }
        
        public function add_children ( $info ) {
            $this -> db -> insert ( 'employee_children', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $info
         * add employees
         * -------------------------
         * @return mixed
         */
        
        public function add_job_history ( $info ) {
            $this -> db -> insert ( 'employee_job_history', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $info
         * add employees salaries
         * -------------------------
         * @return mixed
         */
        
        public function add_salary_sheets ( $info ) {
            $this -> db -> insert ( 'employee_salaries', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $employee_id
         * get employee by id
         * -------------------------
         * @return mixed
         */
        
        public function get_bank_by_id ( $employee_id ) {
            $employee = $this -> db -> get_where ( 'employee_bank_info', array ( 'employee_id' => $employee_id ) );
            return $employee -> row ();
        }
        
        /**
         * -------------------------
         * @param $employee_id
         * get bank by id
         * -------------------------
         * @return mixed
         */
        
        public function get_employee_by_id ( $employee_id ) {
            $employee = $this -> db -> get_where ( 'employees', array ( 'id' => $employee_id ) );
            return $employee -> row ();
        }
        
        /**
         * -------------------------
         * @param $employee_id
         * get history by id
         * -------------------------
         * @return mixed
         */
        
        public function get_history_by_id ( $employee_id ) {
            $employee = $this -> db -> get_where ( 'employee_job_history', array ( 'employee_id' => $employee_id ) );
            return $employee -> row ();
        }
        
        /**
         * -------------------------
         * @param $employee_id
         * get document by id
         * -------------------------
         * @return mixed
         */
        
        public function get_documents_by_id ( $employee_id ) {
            $employee = $this -> db -> get_where ( 'employee_documents', array ( 'employee_id' => $employee_id ) );
            return $employee -> result ();
        }
        
        public function get_family_details_by_id ( $employee_id ) {
            $employee = $this -> db -> get_where ( 'employee_family_details', array ( 'employee_id' => $employee_id ) );
            return $employee -> row ();
        }
        
        /**
         * -------------------------
         * @param $employee_id
         * @param $info
         * update employee by id
         * -------------------------
         * @return mixed
         */
        
        public function update ( $info, $employee_id ) {
            $this -> db -> update ( 'employees', $info, array ( 'id' => $employee_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $salary_id
         * @param $employee_id
         * @param $info
         * update employee salary sheet
         * -------------------------
         * @return mixed
         */
        
        public function update_salary_sheets ( $info, $salary_id, $employee_id ) {
            $this -> db -> update ( 'employee_salaries', $info, array ( 'salary_id'   => $salary_id,
                                                                        'employee_id' => $employee_id
            ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $employee_id
         * delete employee by id
         * -------------------------
         * @return mixed
         */
        
        public function delete ( $employee_id ) {
            $this -> db -> delete ( 'employees', array ( 'id' => $employee_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $employee_id
         * delete bank info by id
         * -------------------------
         * @return mixed
         */
        
        public function delete_bank_info ( $employee_id ) {
            $this -> db -> delete ( 'employee_bank_info', array ( 'id' => $employee_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $employee_id
         * delete job history by id
         * -------------------------
         * @return mixed
         */
        
        public function delete_job_history ( $employee_id ) {
            $this -> db -> delete ( 'employee_job_history', array ( 'employee_id' => $employee_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $employee_id
         * delete documents by id
         * -------------------------
         * @return mixed
         */
        
        public function delete_documents ( $employee_id ) {
            $this -> db -> delete ( 'employee_documents', array ( 'id' => $employee_id ) );
            return $this -> db -> affected_rows ();
        }
        
        public function delete_family_details ( $employee_id ) {
            $this -> db -> delete ( 'employee_family_details', array ( 'employee_id' => $employee_id ) );
            return $this -> db -> affected_rows ();
        }
        
        public function delete_children ( $employee_id ) {
            $this -> db -> delete ( 'employee_children', array ( 'employee_id' => $employee_id ) );
            return $this -> db -> affected_rows ();
        }
        
        public function get_employee_children ( $employee_id ) {
            $children = $this -> db -> get_where ( 'employee_children', array ( 'employee_id' => $employee_id ) );
            return $children -> result ();
        }
        
        /**
         * -------------------------
         * @param $salary_id
         * delete employee salary sheet by id
         * -------------------------
         * @return mixed
         */
        
        public function delete_sheet ( $salary_id ) {
            $this -> db -> delete ( 'employee_salaries', array ( 'salary_id' => $salary_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get salary sheet
         * -------------------------
         */
        
        public function get_sheets () {
            $query = $this -> db -> query ( "Select COUNT(employee_id) as employees, salary_id, days, SUM(net_salary) as net_salary, salary_month, date_added from hmis_employee_salaries group by salary_id order by date_added DESC" );
            return $query -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get salary sheet
         * -------------------------
         */
        
        public function search_sheets () {
            $month = $_REQUEST[ 'month' ];
            $year  = $_REQUEST[ 'year' ];
            
            $sql = "Select COUNT(employee_id) as employees, salary_id, days, SUM(net_salary) as net_salary, date_added from hmis_employee_salaries where 1";
            
            if ( isset( $month ) and !empty( trim ( $month ) ) and $month > 0 )
                $sql .= " and MONTH(date_added)=$month";
            
            if ( isset( $year ) and !empty( trim ( $year ) ) and $year > 0 )
                $sql .= " and YEAR(date_added)=$year";
            
            $sql .= " group by salary_id order by date_added DESC";
            
            $query = $this -> db -> query ( $sql );
            return $query -> result ();
        }
        
        /**
         * -------------------------
         * @param $salary_id
         * get employee salaries sheet by id
         * -------------------------
         * @return mixed
         */
        
        public function get_sheet_by_salary_id ( $salary_id ) {
            $sheet = $this -> db -> get_where ( 'employee_salaries', array ( 'salary_id' => $salary_id ) );
            return $sheet -> result ();
        }
        
        public function generate_code ( $department_id ) {
            $department = get_department ( $department_id );
            $code       = $department -> code;
            $this -> db -> select ( 'COUNT(*) as totalRows' ) -> from ( 'employees' ) -> where ( "code LIKE 'KMC-$code-%'" );
            $result = $this -> db -> get ();
            $data   = $result -> row ();
            return $data -> totalRows > 0 ? 'KMC-' . $code . '-' . ( $data -> totalRows + 1 ) : 'KMC-' . $code . '-1';
        }
        
    }
