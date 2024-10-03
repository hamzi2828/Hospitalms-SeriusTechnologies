<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GraphModel extends CI_Model {

    /**
     * -------------------------
     * GraphModel constructor.
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
    }
 
	/**
	 * --------------
	 * get opd sales grouped by date
	 * @return mixed
	 * --------------
	 */
	
	public function get_opd_sales_chart () {
		$days = chart_days;
		$sql = "Select COUNT(patient_id) as patients, SUM(net_price) as net_price, MONTH(date_added) as month, DAY(date_added) as day, YEAR(date_added) as year from hmis_opd_services_sales where date_added >= DATE(NOW()) - INTERVAL $days DAY and patient_id IN (Select id from hmis_patients where type='cash') GROUP BY DATE(date_added) order by date_added ASC";
		$sales = $this -> db -> query ( $sql );
		return $sales -> result ();
	}
	
	/**
	 * --------------
	 * get opd sales grouped by date
	 * @param $type
	 * @return mixed
	 * --------------
	 */
	
	public function get_opd_sales_chart_by_type ($type) {
		$days = chart_days;
		$sql = "Select COUNT(patient_id) as patients, SUM(net_price) as net_price, MONTH(date_added) as month, DAY(date_added) as day, YEAR(date_added) as year from hmis_opd_services_sales where date_added >= DATE(NOW()) - INTERVAL $days DAY and patient_id IN (Select id from hmis_patients where type='cash') and service_id IN (Select id from hmis_opd_services where service_type='$type') GROUP BY DATE(date_added) order by date_added ASC";
		$sales = $this -> db -> query ( $sql );
		return $sales -> result ();
	}
	
	/**
	 * --------------
	 * @return mixed
	 * get ipd sales grouped by date
	 * --------------
	 */
	
	public function get_ipd_sales_chart () {
		$days = chart_days;
		$sql = "Select SUM(net_total) as net_total, MONTH(date_added) as month, DAY(date_added) as day, YEAR(date_added) as year from hmis_ipd_sales where date_added >= DATE(NOW()) - INTERVAL $days DAY GROUP BY DATE(date_added) order by date_added ASC";
		$sales = $this -> db -> query ( $sql );
		return $sales -> result ();
	}
	
	/**
	 * -------------------------
	 * @return mixed
	 * get pharmacy sales grouped by date
	 * -------------------------
	 */
	
	public function get_sale_reports () {
		$days = chart_days;
		$sql = "Select COUNT(patient_id) as patients, SUM(net_price) as net_price, MONTH(date_sold) as month, DAY(date_sold) as day, YEAR(date_sold) as year from hmis_medicines_sold where date_sold >= DATE(NOW()) - INTERVAL $days DAY GROUP BY DATE(date_sold) order by date_sold ASC";
		$sales = $this -> db -> query ( $sql );
		return $sales -> result ();
	}
	
	/**
	 * -------------------------
	 * @return mixed
	 * get consultancies sales grouped by date
	 * -------------------------
	 */
	
	public function get_consultancies_sales_chart () {
		$days = chart_days;
		$sql = "Select COUNT(patient_id) as patients, SUM(net_bill) as net_bill, MONTH(date_added) as month, DAY(date_added) as day, YEAR(date_added) as year from hmis_consultancies where patient_id IN (Select id from hmis_patients where type='cash') and date_added >= DATE(NOW()) - INTERVAL $days DAY GROUP BY DATE(date_added) order by date_added ASC";
		$consultancies = $this -> db -> query ( $sql );
		return $consultancies -> result ();
	}
	
	/**
	 * -------------------------
	 * @return mixed
	 * get lab sales grouped by date
	 * -------------------------
	 */
	
	public function get_lab_sales_chart () {
		$days = chart_days;
		$sql = "Select COUNT(patient_id) as patients, SUM(price) as price, MONTH(date_added) as month, DAY(date_added) as day, YEAR(date_added) as year from hmis_test_sales where date_added >= DATE(NOW()) - INTERVAL $days DAY GROUP BY DATE(date_added) order by date_added ASC";
		$sales = $this -> db -> query ( $sql );
		return $sales -> result ();
	}
	
	public function get_opd_sales_by_month ( $date ) {
		$date = explode ( '-', $date );
		$month = $date[ 0 ];
		$year = $date[ 1 ];
		
		$sql = "Select SUM(net_price) as total from hmis_opd_services_sales where MONTH(date_added)='$month' and YEAR(date_added)='$year' and patient_id IN (Select id from hmis_patients where type='cash')";
		$sales = $this -> db -> query ( $sql );
		return $sales -> row ();
	}
	
	public function get_ipd_sales_by_month ( $date ) {
		$date = explode ( '-', $date );
		$month = $date[ 0 ];
		$year = $date[ 1 ];
		
		$sql = "Select SUM(net_total) as total from hmis_ipd_sales where MONTH(date_added)='$month' and YEAR(date_added)='$year'";
		$sales = $this -> db -> query ( $sql );
		return $sales -> row ();
	}
	
	public function get_consultancy_sales_by_month ( $date) {
		$date = explode ( '-', $date );
		$month = $date[ 0 ];
		$year = $date[ 1 ];
		
		$sql = "Select SUM(net_bill) as total from hmis_consultancies where patient_id IN (Select id from hmis_patients where type='cash') and MONTH(date_added)='$month' and YEAR(date_added)='$year'";
		$consultancies = $this -> db -> query ( $sql );
		return $consultancies -> row ();
	}
	
	public function get_pharmacy_sales_by_month ( $date) {
		$date = explode ( '-', $date );
		$month = $date[ 0 ];
		$year = $date[ 1 ];
		
		$sql = "Select SUM(net_price) as total from hmis_medicines_sold where MONTH(date_sold)='$month' and YEAR(date_sold)='$year'";
		$sales = $this -> db -> query ( $sql );
		return $sales -> row ();
	}
	
	public function get_dialysis_sales_by_month ( $date ) {
		$date = explode ( '-', $date );
		$month = $date[ 0 ];
		$year = $date[ 1 ];
		
		$sql = "Select SUM(net_price) as total from hmis_opd_services_sales where MONTH(date_added)='$month' and YEAR(date_added)='$year' and patient_id IN (Select id from hmis_patients where type='cash') and service_id IN (Select id from hmis_opd_services where service_type='dialysis')";
		$sales = $this -> db -> query ( $sql );
		return $sales -> row ();
	}
	
	public function get_xray_sales_by_month ( $date ) {
		$date = explode ( '-', $date );
		$month = $date[ 0 ];
		$year = $date[ 1 ];
		
		$sql = "Select SUM(net_price) as total from hmis_opd_services_sales where MONTH(date_added)='$month' and YEAR(date_added)='$year' and patient_id IN (Select id from hmis_patients where type='cash') and service_id IN (Select id from hmis_opd_services where service_type='xray')";
		$sales = $this -> db -> query ( $sql );
		return $sales -> row ();
	}
	
	public function get_ultrasound_sales_by_month ( $date ) {
		$date = explode ( '-', $date );
		$month = $date[ 0 ];
		$year = $date[ 1 ];
		
		$sql = "Select SUM(net_price) as total from hmis_opd_services_sales where MONTH(date_added)='$month' and YEAR(date_added)='$year' and patient_id IN (Select id from hmis_patients where type='cash') and service_id IN (Select id from hmis_opd_services where service_type='ultrasound')";
		$sales = $this -> db -> query ( $sql );
		return $sales -> row ();
	}
	
	public function get_lab_sales_by_month ( $date) {
		$date = explode ( '-', $date );
		$month = $date[ 0 ];
		$year = $date[ 1 ];
		
		$sql = "Select SUM(price) as total from hmis_test_sales where MONTH(date_added)='$month' and YEAR(date_added)='$year'";
		$sales = $this -> db -> query ( $sql );
		return $sales -> row ();
	}

}