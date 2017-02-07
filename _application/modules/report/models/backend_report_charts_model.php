<?php

/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of backend_report_charts_model
 *
 * @author Yusuf Rahmanto
 */
class backend_report_charts_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    /*
     * Charts Serial
     */
    function sum_penggunaan($date, $waktu){
        $this->db->select('COUNT(serial_id) AS total, SUM(serial_type_price_log_value) AS total_harga');
        $this->db->where('serial_is_used', '1');
        if($waktu=='bulanan') $this->db->where("DATE_FORMAT(serial_user_datetime,'%Y-%m')", $date);
        else if($waktu=='tahunan'){
            $this->db->where('YEAR(serial_user_datetime) >=', '2014');
            $this->db->where('YEAR(serial_user_datetime) <=', $date);
        }
        else $this->db->where('DATE(serial_user_datetime)', $date);
        $this->db->join('sys_serial_user', 'serial_user_serial_id=serial_id', 'left');
        $this->db->join('sys_serial_type_price_log', 'serial_type_price_log_serial_type_id=serial_serial_type_id', 'left');
        return $this->db->get('sys_serial');
    }
    
    function sum_aktivasi($date, $waktu){
        $this->db->select('COUNT(serial_id) AS total');
        $this->db->where('serial_is_active', '1');
        if($waktu=='bulanan') $this->db->where("DATE_FORMAT(serial_activation_datetime,'%Y-%m')", $date);
        else if($waktu=='tahunan'){
            $this->db->where('YEAR(serial_activation_datetime) >=', '2014');
            $this->db->where('YEAR(serial_activation_datetime) <=', $date);
        }
        else $this->db->where('DATE(serial_activation_datetime)', $date);
        $this->db->join('sys_serial_activation', 'serial_activation_serial_id=serial_id', 'left');
        return $this->db->get('sys_serial');
    }
    
    function sum_penjualan($date, $waktu){
        $this->db->select('serial_buyer_datetime, serial_activation_datetime');
        $this->db->where('serial_is_sold', '1');
        if($waktu=='bulanan') $this->db->where("DATE_FORMAT(serial_buyer_datetime,'%Y-%m')", $date);
        else if($waktu=='tahunan'){
            $this->db->where('YEAR(serial_buyer_datetime) >=', '2014');
            $this->db->where('YEAR(serial_buyer_datetime) <=', $date);
        }
        else $this->db->where('DATE(serial_buyer_datetime)', $date);
        $this->db->join('sys_serial_buyer', 'serial_buyer_serial_id=serial_id', 'left');
        $this->db->join('sys_serial_activation', 'serial_activation_serial_id=serial_id', 'left');
        return $this->db->get('sys_serial');
    }
    
    /*
     * Chart Member
     */
    function sum_payout($arr_bonus, $date, $waktu){
        foreach ($arr_bonus as $bonus){
            $this->db->select_sum('bonus_log_'.$bonus['name'], 'log_'.$bonus['name']);
        }
        if($waktu=='bulanan') $this->db->where("DATE_FORMAT(bonus_log_date,'%Y-%m')", $date);
        else if($waktu=='tahunan'){
            $this->db->where('YEAR(bonus_log_date) >=', '2014');
            $this->db->where('YEAR(bonus_log_date) <=', $date);
        }
        else $this->db->where('bonus_log_date', $date);
        return $this->db->get('sys_bonus_log');
    }
    
    function sum_transfer($arr_bonus, $date, $waktu){
        foreach ($arr_bonus as $bonus){
            $this->db->select_sum('bonus_transfer_detail_'.$bonus['name'], 'transfer_'.$bonus['name']);
        }
        if($waktu=='bulanan') $this->db->where("DATE_FORMAT(bonus_transfer_datetime,'%Y-%m')", $date);
        else if($waktu=='tahunan'){
            $this->db->where('YEAR(bonus_transfer_datetime) >=', '2014');
            $this->db->where('YEAR(bonus_transfer_datetime) <=', $date);
        }
        else $this->db->where('DATE(bonus_transfer_datetime)', $date);
        $this->db->join('sys_bonus_transfer_detail', 'bonus_transfer_detail_bonus_transfer_id=bonus_transfer_id', 'left');
        return $this->db->get('sys_bonus_transfer');
    }
}

?>
