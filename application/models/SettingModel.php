<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SettingModel extends CI_Model {

    /**
     * -------------------------
     * SettingModel constructor.
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
    }

    /**
     * -------------------------
     * @param $data
     * @return mixed
     * add settings
     * -------------------------
     */

    public function add($data) {
        $this -> db -> insert('site_settings', $data);
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @return mixed
     * get background
     * -------------------------
     */

    public function getBackground() {
        $query = $this -> db -> query("Select * from hmis_site_settings where login_background!='' and login_background!='0' order by id DESC limit 1");
        return $query -> row();
    }

    /**
     * -------------------------
     * @return mixed
     * get logo
     * -------------------------
     */

    public function getLogo() {
        $query = $this -> db -> query("Select * from hmis_site_settings where logo!='' and logo!='0' order by id DESC limit 1");
        return $query -> row();
    }

}