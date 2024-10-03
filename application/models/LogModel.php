<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LogModel extends CI_Model {

	/**
	 * ----------
	 * @param $table
	 * @param $log
	 * @return mixed
	 * create logs
	 * ----------
	 */

	public function create_log($table, $log) {
		$this -> db -> insert($table, $log);
		return $this -> db -> affected_rows();
	}

}