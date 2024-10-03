<?php

/**
 * ---------------------
 * @param $email
 * @param $password
 * @param $user_id
 * send account registration and activation email
 * ---------------------
 */

function user_account_detail_email($email, $password, $username, $user_id) {
    $config['protocol'] = 'sendmail';
    $config['mailpath'] = '/usr/sbin/sendmail';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = TRUE;
    $ci = &get_instance();
    $ci->email->initialize($config);
    $data = array(
        'email'     =>  $email,
        'password'  =>  $password,
        'user_id'   =>  $user_id,
        'username'  =>  $username,
    );
    $message = $ci -> load -> view('emails/account-details', $data, true);
    $ci->email->from(site_email, site_name);
    $ci->email->to($email);
    $ci->email->subject('Account details');
    $ci->email->message($message);
    $ci->email->set_mailtype("html");
    $ci->email->send();
}

/**
 * ---------------------
 * @param $email
 * @param $password
 * send password update email
 * ---------------------
 */

function send_password_update_email($email, $password) {
    $config['protocol'] = 'sendmail';
    $config['mailpath'] = '/usr/sbin/sendmail';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = TRUE;

    $ci = &get_instance();
    $ci->email->initialize($config);
    $data = array(
        'email'     =>  $email,
        'password'  =>  $password,
    );
    $message = $ci -> load -> view('emails/password-update-details', $data, true);
    $ci->email->from(site_email, site_name);
    $ci->email->to($email);
    $ci->email->subject('Password reset');
    $ci->email->message($message);
    $ci->email->set_mailtype("html");
    $ci->email->send();
}