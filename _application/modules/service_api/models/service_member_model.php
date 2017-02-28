<?php
/**
 * Service API Member Model
 *
 * @author      Fahrur Rifai <developer11@esoftdream.net>
 * @copyright   Copyright (c) 2017, Esoftdream.net
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Service_member_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get_total_member($active=-1, $register_year=0, $register_month=0) {
	    $this->db->select('COUNT(network_id) as total');
	    if ($active >= 0) {
	        $this->db->where('member_is_active', $active);
	    }
	    if ($register_year > 0) {
	        $this->db->where('YEAR(member_join_datetime)', $register_year);
	    }
	    if ($register_month > 0) {
	        $this->db->where('MONTH(member_join_datetime)', $register_month);
	    }
	    $this->db->join('sys_network', 'member_network_id=network_id');
	    $q = $this->db->get('sys_member');        
	    return intval($q->row('total'));
	}

	function get_total_last_created_serial() {
	    // check in serial activation
	    $this->db->select('COUNT(serial_id) as total_created, DATE(serial_create_datetime) as date_only');
	    $this->db->order_by('serial_create_datetime DESC');
	    $this->db->group_by('date_only');
	    $this->db->limit(1);
	    $q = $this->db->get('sys_serial');
	    if ($q->num_rows() > 0) {
	        return $q->row();
	    } else {
	        $arr['total_created'] = $result['act']->total_created+$result['up']->total_created;
	        $arr['date_only'] = $act_last_date;
	        return (object) $arr;
	    }
	}

	function get_member_info($year, $month) {
		$month_idn = convert_month($month, 'id');
		$day = date('d');
		$range = 2;

		$result['summary']['total_member'] = $this->function_lib->set_number_format($this->get_total_member(1, $year, $month));

		$last_join = $this->function_lib->set_number_format($this->get_total_member(1, $year, $month));
		$result['summary']['last_join'] = $last_join." Member ({$month_idn} {$year})";       

		$arr_last_serial_create = $this->get_total_last_created_serial();
		$last_serial_create_date = convert_date($arr_last_serial_create->date_only, 'id');
		$result['summary']['last_serial_create'] = $arr_last_serial_create->total_created." Serial ({$last_serial_create_date})";

		 // REGISTRASI 
		for ($i=$range; $i >= 0; $i--) { 
			$timestamp = mktime(0,0,0,$month-$i,1,$year);
			$temp_month = date('m', $timestamp);
			$temp_year = date('Y', $timestamp);
			$result['registrasi'][$range-$i]['year'] = $temp_year;
			$result['registrasi'][$range-$i]['month'] = $temp_month;
			$result['registrasi'][$range-$i]['total'] = $this->function_lib->set_number_format($this->get_total_member(1, $temp_year, $temp_month));
		}


		return $result;
	}
}