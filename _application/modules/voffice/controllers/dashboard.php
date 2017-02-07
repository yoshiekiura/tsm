<?php

/*
 * Member Dashboard Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Member_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('voffice/dashboard_model');
    }
    
    public function index() {
        $this->show();
    }
    
    function show() {
        $data['page_title'] = 'Dashboard';
        $data['year'] = $year = date('Y');
        $data['month'] = $month = date('m');

        // status jaringan
        $network_id = $this->session->userdata('network_id');
        $data['network_code'] = $this->session->userdata('network_code');
        $data['member_name'] = $this->session->userdata('member_name');
        $data['member_nickname'] = $this->session->userdata('member_nickname');
        $data['member_last_login'] = $this->session->userdata('member_last_login');
        $sponsor_id = $this->mlm_function->get_sponsor_network_id($network_id);
        $data['sponsor_code'] = $this->mlm_function->get_network_code($sponsor_id);
        $data['sponsor_name'] = $this->mlm_function->get_member_name($sponsor_id);
        $upline_id = $this->mlm_function->get_upline_network_id($network_id);
        $data['upline_code'] = $this->mlm_function->get_network_code($upline_id);
        $data['upline_name'] = $this->mlm_function->get_member_name($upline_id);
        $member_position = $this->function_lib->get_one('sys_network', 'network_position', array('network_id'=>$network_id));
        $data['member_position'] = $member_position == 'L' ? 'Kiri' : 'Kanan';
        $data['member_join_datetime'] = $this->function_lib->get_one('sys_member', 'member_join_datetime', array('member_network_id'=>$network_id));
        $data['sponsoring_count'] = $this->dashboard_model->get_total_sponsoring($network_id);
        $data['arr_node'] = $this->dashboard_model->get_total_arr_node($network_id);

        // status komisi
        $data['query_bonus_log'] = $this->dashboard_model->get_total_bonus_log_subtotal($network_id);
        
        // info jaringan hari ini
        $data['sponsoring_count_today'] = $this->dashboard_model->get_total_sponsoring($network_id, date('Y-m-d'));
        $data['arr_node_today'] = $this->dashboard_model->get_total_arr_node($network_id, FALSE, date('Y-m-d'));
        

        $data['query_downline'] = $this->dashboard_model->get_downline_current_month($this->session->userdata('network_id'), $year, $month);
        $data['query_network_group'] = $this->dashboard_model->get_unapproved_network_group($this->session->userdata('network_id'));
        $data['arr_active_bonus'] = $this->mlm_function->get_arr_active_bonus();
        
        // $data['arr_node'] = $this->dashboard_model->get_arr_node_current_month($this->session->userdata('network_id'), $year, $month);
        // $data['reward_bonus'] = $this->dashboard_model->get_str_reward_bonus_qualified($this->session->userdata('network_id'), $year, $month);
        // $data['arr_bonus_acc'] = $this->dashboard_model->get_arr_bonus_acc($this->session->userdata('network_id'));

        $daily_bonus = $this->mlm_function->get_arr_active_bonus('daily');
        
        $bonys = array();
        foreach ($daily_bonus as $daily_bonus_item) {
            $max_level = 0;
            $bonus_name = $daily_bonus_item['name'];
            $config_bonus_value = $daily_bonus_item['value'];

            if (is_array($daily_bonus_item['value'])) {
                $max_level = max(array_keys($daily_bonus_item['value']));
            }
            $bonus_function = 'calculate_bonus_'.$bonus_name.'_daily';
            $daily_bonus_calculation[$bonus_name]['label'] = $daily_bonus_item['label'];
            $daily_bonus_calculation[$bonus_name]['value'] = $this->$bonus_function($config_bonus_value, $max_level);
        }

        $data['arr_daily_bonus'] = $daily_bonus_calculation;
        template('member', 'voffice/dashboard_main_view', $data);
    }
    
    function information() {
        $data['page_title'] = 'Informasi';
        $data['arr_breadcrumbs'] = array(
            'Informasi' => 'voffice/dashboard/information',
        );
        
        $data['query'] = $this->dashboard_model->get_homepage();
        template('member', 'voffice/dashboard_information_view', $data);
    }


    function calculate_bonus_sponsor_daily($bonus_value, $max_level) {
        $total_bonus = 0;
        $total_sponsoring = $this->dashboard_model->get_total_sponsoring($this->session->userdata('network_id'), date('Y-m-d'));
        $total_bonus = $total_sponsoring * $bonus_value;
        return ($total_bonus);
    }

    function calculate_bonus_node_daily($bonus_value, $max_level) {
        $total_bonus = 0;
        foreach ($bonus_value as $level => $value) {
            $total_node_bonus = $this->dashboard_model->get_total_arr_node($this->session->userdata('network_id'), $level, date('Y-m-d'));
            $total_node = $total_node_bonus['left'] + $total_node_bonus['right'];
            $total_bonus_pre = ($total_node * $value);
            $total_bonus += $total_bonus_pre;
        }   
        return ($total_bonus);
    }

    function calculate_bonus_match_daily($bonus_value, $max_level) {
        $total_bonus = 0;
        $total_matching = $this->dashboard_model->get_total_match($this->session->userdata('network_id'), date('Y-m-d'));
        $total_bonus = $total_matching * $bonus_value;
        return ($total_bonus);
    }

}
