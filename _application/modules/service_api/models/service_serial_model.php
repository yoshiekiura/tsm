<?php
/**
 * Service API Serial Model
 *
 * @author      Fahrur Rifai <developer11@esoftdream.net>
 * @copyright   Copyright (c) 2017, Esoftdream.net
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Service_serial_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get_serial_info($year, $month) {
		$results = array('year'=>$year, 'month'=>convert_month($month, 'id'));
		$q_type = $this->db->query("SELECT serial_type_id, serial_type_name FROM sys_serial_type WHERE serial_type_is_active = 1");
		if ($q_type->num_rows() > 0) {
			foreach ($q_type->result() as $row) {
				$temp = array();
				$temp['serial_type'] = $row->serial_type_name;
				$temp['serial_create'] = $this->function_lib->set_number_format($this->function_lib->get_one("sys_serial", "COUNT(serial_id)", "MONTH(serial_create_datetime)='" . $month . "' AND YEAR(serial_create_datetime) = '" . $year . "'"));
				$temp['serial_active'] = $this->function_lib->set_number_format($this->function_lib->get_one("sys_serial_activation", "COUNT(serial_activation_serial_id)", "MONTH(serial_activation_datetime)='" . $month . "' AND YEAR(serial_activation_datetime) = '" . $year . "'"));
				$temp['serial_sold'] = $this->function_lib->set_number_format($this->function_lib->get_one("sys_serial_buyer", "COUNT(serial_buyer_serial_id)", "MONTH(serial_buyer_datetime)='" . $month . "' AND YEAR(serial_buyer_datetime) = '" . $year . "'"));
				$temp['serial_used'] = $this->function_lib->set_number_format($this->function_lib->get_one("sys_serial_user", "COUNT(serial_user_serial_id)", "MONTH(serial_user_datetime)='" . $month . "' AND YEAR(serial_user_datetime) = '" . $year . "'"));
				$results['selling'][] = $temp;

				//summary
				$temp_summary = array();
				$temp_summary['serial_type'] = $row->serial_type_name;
				$temp_summary['serial_create'] = $this->function_lib->set_number_format($this->function_lib->get_one("sys_serial", "COUNT(serial_id)"));
				$temp_summary['serial_active'] = $this->function_lib->set_number_format($this->function_lib->get_one("sys_serial_activation", "COUNT(serial_activation_serial_id)"));
				$temp_summary['serial_sold'] = $this->function_lib->set_number_format($this->function_lib->get_one("sys_serial_buyer", "COUNT(serial_buyer_serial_id)"));
				$temp_summary['serial_used'] = $this->function_lib->set_number_format($this->function_lib->get_one("sys_serial_user", "COUNT(serial_user_serial_id)"));
				$results['summary'][] = $temp_summary;
			}
		}

		return $results;
	}
}