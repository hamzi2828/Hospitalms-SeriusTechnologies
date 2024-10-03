<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class UserModel extends CI_Model {
        
        /**
         * -------------------------
         * UnitModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get users
         * -------------------------
         */
        
        public function get_users () {
            $users = $this -> db -> get ( 'users' );
            return $users -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get active users
         * -------------------------
         */
        
        public function get_active_users () {
            $users = $this -> db -> get_where ( 'users', array ( 'status' => '1' ) );
            return $users -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get active users
         * -------------------------
         */
        
        public function get_active_users_except_logged_in () {
            $user_id = get_logged_in_user_id ();
            $users = $this -> db -> get_where ( 'users', array (
                'status' => '1',
                'id !='  => $user_id
            ) );
            return $users -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get users
         * -------------------------
         */
        
        public function get_all_users () {
            $users = $this -> db -> get ( 'users' );
            return $users -> result ();
        }
        
        /**
         * -------------------------
         * @param $user_id
         * @return mixed
         * get user by id
         * -------------------------
         */
        
        public function get_user_by_id ( $user_id ) {
            $user = $this -> db -> get_where ( 'users', array ( 'id' => $user_id ) );
            return $user -> row ();
        }
        
        /**
         * -------------------------
         * @param $department
         * @return mixed
         * get user by department
         * -------------------------
         */
        
        public function get_users_by_department ( $department ) {
            $user = $this -> db -> get_where ( 'users', array ( 'department_id' => $department ) );
            return $user -> result ();
        }
        
        /**
         * -------------------------
         * @param $department
         * @return mixed
         * get user by department
         * -------------------------
         */
        
        public function get_active_users_by_department ( $department ) {
            $user = $this -> db -> get_where ( 'users', array (
                'department_id' => $department,
                'status'        => '1'
            ) );
            return $user -> result ();
        }
        
        /**
         * -------------------------
         * @param $user_id
         * @return mixed
         * get user by id
         * -------------------------
         */
        
        public function get_user_access ( $user_id ) {
            $user = $this -> db -> get_where ( 'user_access', array ( 'user_id' => $user_id ) );
            return $user -> row ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * register user
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'users', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add user access
         * -------------------------
         */
        
        public function add_access ( $data ) {
            $this -> db -> insert ( 'user_access', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $user_id
         * @return mixed
         * update user status
         * -------------------------
         */
        
        public function delete ( $info, $user_id ) {
            $this -> db -> update ( 'users', $info, array ( 'id' => $user_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $user_id
         * @return mixed
         * delete user access
         * -------------------------
         */
        
        public function delete_access ( $user_id ) {
            $this -> db -> delete ( 'user_access', array ( 'user_id' => $user_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $user_id
         * @return mixed
         * update user
         * -------------------------
         */
        
        public function edit ( $info, $user_id ) {
            $this -> db -> update ( 'users', $info, array ( 'id' => $user_id ) );
            return $this -> db -> affected_rows ();
        }
        
    }