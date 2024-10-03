<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {

    /**
     * -------------------------
     * Login model constructor.
     * loads helpers, modal or libraries
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
    }

    /**
     * -------------------------
     * @param $data
     * @return mixed
     * register user
     * -------------------------
     */

    public function add($data) {
        $this -> db -> insert('users', $data);
        return $this -> db -> insert_id();
    }

    /**
     * -------------------------
     * @param $email
     * @return bool
     * check if email exists
     * -------------------------
     */

    public function check_email_exists($email) {
        $found = $this -> db -> get_where('users', array('email'    =>  $email));
        if($found -> num_rows() == 1)
            return true;
        else
            return false;
    }

    /**
     * -------------------------
     * @param $user_id
     * @return bool
     * get user
     * -------------------------
     */

    public function get_user($user_id) {
        $user = $this -> db -> get_where('users', array('id'    =>  $user_id));
        return $user -> row();
    }

    /**
     * -------------------------
     * @param $email
     * @return mixed
     * update status of account
     * -------------------------
     */

    public function activate_account($email) {
        $this -> db -> update('users', array('status'   =>  1), array('email'   =>  $email));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @param $email
     * @param $password
     * @return mixed
     * update password of account
     * -------------------------
     */

    public function update_password($email, $password) {
        $this -> db -> update('users', array('password'   =>  $password), array('email'   =>  $email));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------
     * @param $username
     * @param $password
     * @return bool
     * login user
     * -------------
     */

    public function login_user($username, $password) {
        $result = $this -> db -> get_where('users', array('username'  =>  $username, 'status' =>  '1'));
        if($result -> num_rows() == 1) {
            $user = $result -> row();
            if(password_verify($password, $user -> password)) {
                unset($user -> password);
                return $user;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    /**
     * -------------
     * @param $username
     * @return string
     * validate username
     * -------------
     */

    public function get_username($username) {
        $username = url_title($username, 'dash', true);
        $check_username = $this -> db -> get_where('users', array('username'   =>  $username));
        if($check_username -> num_rows() > 0) {
            $total_rows = $check_username -> num_rows() + 1;
            return $username . '-' . $total_rows;
        }
        else {
            return $username;
        }
    }

}