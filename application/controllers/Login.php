<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    /**
     * -------------------------
     * Login constructor.
     * loads helpers, modal or libraries
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
        $this -> is_logged_in();
        $this -> lang -> load ( 'general', 'english' );
        $this -> load -> model('LoginModel');
        $this -> load -> model('SettingModel');
    }

    /**
     * -------------------------
     * @param $title
     * login header template
     * -------------------------
     */

    public function header($title) {
		check_if_authorized();
        $data['title'] = $title;
		$data[ 'background' ] = $this -> SettingModel -> getBackground ();
		$data[ 'logo' ] = $this -> SettingModel -> getLogo ();
        $this -> load -> view('/includes/login/header', $data);
    }

    /**
     * -------------------------
     * login footer template
     * -------------------------
     */

    public function footer() {
        $this -> load -> view('/includes/login/footer');
    }

    /**
     * -------------------------
     * login main page
     * -------------------------
     */

    public function index() {

        if(isset($_POST['action']) and $_POST['action'] == 'do_login')
            $this -> do_login_user();

        $title = site_name . ' - Login';
        $this -> header($title);
        $this -> load -> view('/login/index');
        $this -> footer();
	}

    /**
     * -------------------------
     * register main page
     * -------------------------
     */

    public function register() {

//        if(isset($_POST['action']) and $_POST['action'] == 'register_member')
//            //$this -> do_register_member($_POST);

        $title = site_name . ' - Register';
        $this -> header($title);
        $this -> load -> view('/login/register');
        $this -> footer();
	}

    /**
     * -------------------------
     * forget password main page
     * -------------------------
     */

    public function forget_password() {

        if (isset($_POST['action']) and $_POST['action'] == 'forget_password')
            $this -> process_forget_password($_POST);

        $title = site_name . ' - Forget Password';
        $this -> header($title);
        $this -> load -> view('/login/forgot-password');
        $this -> footer();
	}

    /**
     * -------------------------
     * @param $post
     * register user
     * -------------------------
     */

	public function do_register_member($post) {
        $data = filter_var_array($post, FILTER_SANITIZE_STRING);
        $this -> form_validation -> set_rules('name', 'name', 'required|trim|min_length[1]|xss_clean');
        $this -> form_validation -> set_rules('email', 'email', 'required|trim|min_length[1]|xss_clean|valid_email|is_unique[users.email]');
        $this -> form_validation -> set_rules('phone', 'phone', 'required|trim|min_length[1]|xss_clean');
        $this -> form_validation -> set_rules('address', 'address', 'required|trim|min_length[1]|xss_clean');
        $this -> form_validation -> set_rules('address', 'address', 'required|trim|min_length[1]|xss_clean');
        $this -> form_validation -> set_rules('cnic', 'cnic', 'required|trim|min_length[1]|xss_clean|is_unique[users.cnic]');
        $this -> form_validation -> set_rules('password', 'password', 'required|trim|min_length[1]|xss_clean');
        $this -> form_validation -> set_rules('role', 'role', 'required|trim|min_length[1]|xss_clean');
        if($this -> form_validation -> run() == true) {
            $username = get_username($data['name']);
            $array = array(
                'name'          =>  $data['name'],
                'username'      =>  $username,
                'email'         =>  $data['email'],
                'address'       =>  $data['address'],
                'phone'         =>  $data['phone'],
                'cnic'          =>  $data['cnic'],
                'password'      =>  password_hash($data['password'], PASSWORD_BCRYPT),
                'role'          =>  $data['role'],
                'date_added'    =>  date('Y-m-d')
            );
            $user_id = $this -> LoginModel -> add($array);
            if($user_id > 0) {
                $this -> session -> set_flashdata('response', 'An email has been sent to your email address. Please activate your account.');
                user_account_detail_email($data['email'], $data['password'], $username, $user_id);
                return redirect(base_url('/register'));
            }
            else {
                $this -> session -> set_flashdata('error', 'Oops! An unknown error occurred. Please try again.');
                return redirect(base_url('/register'));
            }
        }
    }

    /**
     * -------------------------
     * activate account
     * checks if email exists
     * -------------------------
     */

    public function activate_account() {
        $user_email = $this -> input -> get('email');
        if(!empty(trim($user_email)) and filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $email_exists = $this -> LoginModel -> check_email_exists($user_email);
            if($email_exists) {
                $is_activated = $this -> LoginModel -> activate_account($user_email);
                if($is_activated) {
                    $this -> session -> set_flashdata('response', 'Success! Account has been activated.');
                    return redirect(base_url('/login'));
                }
                else {
                    $this -> session -> set_flashdata('response', 'Account has already been updated.');
                    return redirect(base_url('/login'));
                }
            }
            else {
                $this -> session -> set_flashdata('error', 'No email found. Please register.');
                return redirect(base_url('/register'));
            }
        }
        else {
            return redirect(base_url());
        }
    }

    /**
     * -------------------------
     * @param $POST
     * process forget password
     * -------------------------
     */

    public function process_forget_password($POST) {
        $data = filter_var_array($POST, FILTER_SANITIZE_STRING);
        $this -> form_validation -> set_rules('email', 'email', 'required|trim|valid_email|xss_clean');
        if($this -> form_validation -> run() != false) {
            $email = $data['email'];
            $email_exists = $this -> LoginModel -> check_email_exists($email);
            if($email_exists) {
                $password = $this -> randomPassword();
                $this -> LoginModel -> update_password($email, password_hash($password, PASSWORD_BCRYPT));
                send_password_update_email($email, $password);
                $this -> session -> set_flashdata('response', 'An email has been sent to your email address.');
                return redirect(base_url('/forget-password'));
            }
            else {
                $this -> session -> set_flashdata('error', 'No email found. Please register.');
                return redirect(base_url('/register'));
            }
        }
    }

    /**
     * -------------------------
     * @return string
     * generate random password
     * -------------------------
     */

    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyz@!ABC*DE/FGHI#JKL2M8NOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    /**
     * ---------------------
     * checks if user is logged in
     * ---------------------
     */

    public function is_logged_in() {
        if (!empty($this -> session -> userdata('user_data'))) {
            return redirect(base_url('/dashboard'));
        }
    }

    /**
     * ---------------------
     * login user
     * ---------------------
     */

    public function do_login_user() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[1]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[1]|xss_clean');

        if ($this -> form_validation -> run() == true) {
            $username        = $this -> input -> post('username');
            $password        = $this -> input -> post('password');
            $user = $this -> LoginModel -> login_user($username, $password);
            if($user) {
                $this -> session -> set_userdata('user_data', $user);

                $log = array(
                	'user_id'		=>	get_logged_in_user_id(),
					'action'		=>	'logged_in',
					'log'			=>	json_encode($user),
					'date_added'	=>	current_date_time()
				);
                $this -> load -> model('LogModel');
                $this -> LogModel -> create_log('user_logs', $log);

                return redirect(base_url('/dashboard'));
            }
            else
                echo $this -> session -> set_flashdata('error', 'Invalid username or password.');
        }
    }

}
