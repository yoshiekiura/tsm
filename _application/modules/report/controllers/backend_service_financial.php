<?php

/*
 * Backend Service Financial Controller
 *
 * @author	Fahrur Rifai
 * @copyright	Copyright (c) 2017, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service_financial extends Backend_Controller {

	function __construct() {
        parent::__construct();

        $this->load->model('report/backend_report_model');
        $this->load->helper('form');
        $this->today = date('Y-m-d');
        $this->day = date('d');
        $this->month = date('m');
        $this->year = date('Y');
    }

	function financial_report($period='global') {
		$data['arr_breadcrumbs'] = array(
		    'Laporan' => '#',
		    'Laporan Keuangan' => 'backend/report/financial/global',
		);

		if ($period == 'monthly') {
			if ($this->input->post('month') && $this->input->post('year')) {
				$this->session->set_flashdata('month', $this->input->post('month'));
				$this->session->set_flashdata('year', $this->input->post('year'));
				redirect(uri_string());
			}
		    $search_month = $this->session->flashdata('month') === FALSE ? $this->month : $this->session->flashdata('month');
		    $search_year = $this->session->flashdata('year') === FALSE ? $this->year : $this->session->flashdata('year');
		    $search_date = date_converter($search_year . '-' . $search_month . '-' . $this->day, 'F Y');
		    $title = 'Bulanan';
		    $data['arr_breadcrumbs'][$title] = 'backend/report/financial/' . $period;
		    $data['arr_breadcrumbs'][$search_date] = 'backend/report/financial/' . $period;
		    $data['title'] = 'Laporan Keuangan Bulan ' . $search_date;
		    $data['search_date'] = $search_year . '-' . $search_month . '-' . $this->day;
		} else {
			$search_month = FALSE;
			$search_year = FALSE;
		    $title = 'Global';
		    $data['arr_breadcrumbs'][$title] = 'backend/report/financial/' . $period;
		    $data['title'] = 'Laporan Keuangan Global';
		}


		$data['period'] = $period;
		$data['serial_type'] = $this->get_serial_type($search_month, $search_year);
		$data['arr_bonus'] = $this->get_total_bonus($search_month, $search_year);
		$data['month_options'] = $this->getAllMonths();
		$data['year_options'] = $this->getYearList();
		$data['service_url'] = base_url('backend/report/get_finance_data');
		template('backend', 'report/backend_report_finance_view', $data);
	}

	function get_total_bonus($month=FALSE, $year=FALSE) {
		$arr_bonus = $this->mlm_function->get_arr_active_bonus();
		$arr_total_bonus = array();
		foreach ($arr_bonus as $bonus_item) {
			$str_select = 'SUM(bonus_log_' . $bonus_item['name'] . ') as total';
			if ($month) {
				$this->db->where('MONTH(bonus_log_date)', $month);
			}
			if ($year) {
				$this->db->where('YEAR(bonus_log_date)', $year);
			}
			$this->db->select($str_select);
			$query = $this->db->get('sys_bonus_log');
			if ($query->num_rows() > 0) {
				$sum = $query->row('total');
			} else {
				$sum = 0;
			}
			$bonus_item['total_bonus'] = $sum;
			$arr_total_bonus[] = $bonus_item;
		}
		return $arr_total_bonus;
	}

	private function get_serial_type($month=FALSE, $year=FALSE) {
		$serial_type = $this->mlm_function->get_list_serial_type()->result();
		$data_serial_type = array();
		foreach ($serial_type as $row) {
			if ($row->serial_type_is_active == '1') {
				$row->last_price = $this->function_lib->get_one('sys_serial_type_price_log', 'serial_type_price_log_value', array('serial_type_price_log_serial_type_id'=>$row->serial_type_id), 'serial_type_price_log_datetime', 'DESC');
				$row->count_member_joined = $this->get_user_registered($month, $year, $row->serial_type_id);
				$row->subtotal = $row->last_price * $row->count_member_joined;
				$data_serial_type[] = $row;
			}
		}
		return $data_serial_type;
	}

	function get_user_registered($month=FALSE, $year=FALSE, $serial_type_id=FALSE) {
		if ($month) {
			$this->db->where('MONTH(member_join_datetime)', $month);
		}
		if ($year) {
			$this->db->where('YEAR(member_join_datetime)', $year);
		}
		$this->db->join('sys_serial_user', 'member_network_id=serial_user_network_id');
		$this->db->join('sys_serial', 'serial_id=serial_user_serial_id');
		$this->db->select('COUNT(member_network_id) as row_count');
		
		if ($serial_type_id) {
			$this->db->where('serial_serial_type_id', $serial_type_id);
		}

		$query = $this->db->get('sys_member');
		if ($query->num_rows() > 0) {
			return $query->row('row_count');
		} else {
			return 0;
		}
	}

	private function get_serial_used($serial_type_id) {
		$sql = "SELECT COUNT(serial_id) as row_count
				FROM sys_serial
				WHERE serial_serial_type_id = {$serial_type_id}";
		$query = $this->db->query($sql);
		return $query->row('row_count');
	}

	private function getAllMonths() {
		$options = '';
		$opt_result = array() ;
		for ($i = 1; $i <= 12; $i++) {
			$value = ($i < 10) ? '0' . $i : $i;
			$opt_result[$value] = convert_month(date("m", mktime(0, 0, 0, $i+1, 0, 0)),'id');
		}

		return $opt_result;
	}

	private function getYearList() {
		$options = '';
		$optresult = array();
		for ($i = 2016; $i <= date('Y'); $i++) {
			$optresult[$i] = $i;
		}

		return $optresult;
	}

}