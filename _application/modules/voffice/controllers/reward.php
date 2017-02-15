<?php

/*
 * Member Reward Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reward extends Member_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('voffice/reward_model');
    }
    
    public function index() {
        $this->show();
    }
    
    function show() {        
        $data['page_title'] = 'Info Titik Reward ';
        $data['arr_breadcrumbs'] = array(
            'Reward' => '#',
            'Info Titik Reward' => 'voffice/reward/show',
        );
        
        $data['arr_node']['left'] = $this->function_lib->get_one('sys_network', 'network_total_reward_node_left', array('network_id'=>$this->session->userdata('network_id')));
        $data['arr_node']['right'] = $this->function_lib->get_one('sys_network', 'network_total_reward_node_right', array('network_id'=>$this->session->userdata('network_id')));
        $data['service_url'] = base_url('voffice/reward/get_data');;
        
        template('member', 'voffice/reward_info_view', $data);
    }
    
    function get_data() {
        $params = isset($_POST) ? $_POST : array();
        $query = $this->reward_model->get_query_data($this->session->userdata('network_id'), $params);
        $total = $this->reward_model->get_query_data($this->session->userdata('network_id'), $params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());

        // get total node member
        $total_node_member['left'] = $this->function_lib->get_one('sys_network', 'network_total_reward_node_left', array('network_id'=>$this->session->userdata('network_id')));
        $total_node_member['right'] = $this->function_lib->get_one('sys_network', 'network_total_reward_node_right', array('network_id'=>$this->session->userdata('network_id')));
        foreach ($query->result() as $row) {
            
            // is_qualified
            if (($total_node_member['left'] >= $row->reward_cond_node_left) && ($total_node_member['right'] >= $row->reward_cond_node_right)) {
                $is_qualified = '<a href="'.base_url('voffice/reward/act_claim/'.$row->reward_id).'" class="btn btn-success btn-xs btn-claim"><span class="fa fa-check"></span> Claim Reward</a>';
            } else {
                $is_qualified = '-';
            }

            $entry = array('id' => $row->reward_id,
                'cell' => array(
                    'reward_cond_node_left' => $this->function_lib->set_number_format($row->reward_cond_node_left),
                    'reward_cond_node_right' => $this->function_lib->set_number_format($row->reward_cond_node_right),
                    'reward_bonus' => $row->reward_bonus,
                    'action' => $is_qualified,
                    'no' => $page++,
                ),
            );
            
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function act_claim($reward_id=FALSE) {
        $reward_url = 'voffice/reward/show';
        $date = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        
        // check pin serial
        $this->load->model('voffice/systems_model');
        $is_valid = $this->systems_model->check_pin($this->session->userdata('network_id'), $this->input->post('validate_pin'));
        if ($is_valid == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger"><strong>Claim Gagal : </strong>PIN Serial salah</div>');
            redirect($reward_url);
        }

        // check reward is exist
        $query = $this->function_lib->get_detail_data('sys_reward', array('reward_id'=>$reward_id, 'reward_is_active'=>'1'), NULL);
        if ($query->num_rows() == 0) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger"><strong>Claim Gagal : </strong>Reward tidak ditemukan</div>');
            redirect($reward_url);
        }

        // check member is qualified
        $reward_data = $query->row();
        // get total node member
        $total_node_member['left'] = $this->function_lib->get_one('sys_network', 'network_total_reward_node_left', array('network_id'=>$this->session->userdata('network_id')));
        $total_node_member['right'] = $this->function_lib->get_one('sys_network', 'network_total_reward_node_right', array('network_id'=>$this->session->userdata('network_id')));
        if (($total_node_member['left'] >= $reward_data->reward_cond_node_left) && ($total_node_member['right'] >= $reward_data->reward_cond_node_right)) {
            // insert into reward_qualified
            $ins['reward_qualified_network_id'] = $this->session->userdata('network_id');
            $ins['reward_qualified_reward_id'] = $reward_data->reward_id;
            $ins['reward_qualified_condition_node_left'] = $total_node_member['left'];
            $ins['reward_qualified_condition_node_right'] = $total_node_member['right'];
            $ins['reward_qualified_reward_value'] = $reward_data->reward_bonus_value;
            $ins['reward_qualified_reward_bonus'] = $reward_data->reward_bonus;
            $ins['reward_qualified_date'] = $date;
            $ins['reward_qualified_status'] = 'pending';
            $this->db->insert('sys_reward_qualified', $ins);

            $reward_qualified_id = $this->db->insert_id();
            
            // insert into reward_qualified_status
            $ins2['reward_qualified_status_reward_qualified_id'] = $reward_qualified_id;
            $ins2['reward_qualified_status_datetime'] = $datetime;
            $ins2['reward_qualified_status_status'] = 'pending';
            $this->db->insert('sys_reward_qualified_status', $ins2);

            // update total_network_node_[left/right]
            $upd['network_total_reward_node_left'] = $total_node_member['left'] - $reward_data->reward_cond_node_left;
            $upd['network_total_reward_node_right'] = $total_node_member['right'] - $reward_data->reward_cond_node_right;
            $this->db->update('sys_network', $upd, array('network_id'=>$this->session->userdata('network_id')));
            
            // message
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-success"><strong>Claim Berhasil : </strong>Menunggu approval dari admin.</div>');
            redirect($reward_url);
        } else {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger"><strong>Claim Gagal : </strong>Anda Belum Qualified Reward Tersebut.</div>');
            redirect($reward_url);
        }
    }
    
    function log() {
        $data['page_title'] = 'History Reward';

        $data['arr_breadcrumbs'] = array(
            'Reward' => '#',
            'History Reward' => 'voffice/reward/log',
        );
        
        $data['year'] = $year = date('Y');
        $data['month'] = $month = date('m');
        
        template('member', 'voffice/reward_log_view', $data);
    }
    
    function get_log_data() {
        $params = isset($_POST) ? $_POST : array();
        $query = $this->reward_model->get_member_reward_data($this->session->userdata('network_id'), $params);
        $total = $this->reward_model->get_member_reward_data($this->session->userdata('network_id'), $params, true);

        header("Content-type: application/json");
        // print_r(json_encode($query->result()));die();
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        $administrator = array('-'=>'-');
        foreach ($query->result() as $row) {
            
            //status
            if ($row->reward_qualified_status == 'approved') {
                $status = '<span class="btn btn-success" style="width:80px; padding:2px 5px !important; font-size:7pt; cursor:default;">' . strtoupper($row->reward_qualified_status) . '</span>';
            } else if($row->reward_qualified_status == 'rejected') {
                $status = '<span class="btn btn-danger" style="width:80px; padding:2px 5px !important; font-size:7pt; cursor:default;">' . strtoupper($row->reward_qualified_status) . '</span>';
            } else {
                $status = '<span class="btn btn-warning" style="width:80px; padding:2px 5px !important; font-size:7pt; cursor:default;">' . strtoupper($row->reward_qualified_status) . '</span>';
            }

            if ( ! isset($administrator[$row->administrator_id])) {
                $administrator[$row->administrator_id] = $row->administrator_name;
            }
            
            $entry = array('id' => $row->reward_qualified_id,
                'cell' => array(
                    'no' => $page++,
                    'reward_cond_node_left' => $this->function_lib->set_number_format($row->reward_cond_node_left),
                    'reward_cond_node_right' => $this->function_lib->set_number_format($row->reward_cond_node_right),
                    'reward_qualified_condition_node_left' => $this->function_lib->set_number_format($row->reward_qualified_condition_node_left),
                    'reward_qualified_condition_node_right' => $this->function_lib->set_number_format($row->reward_qualified_condition_node_right),
                    'reward_qualified_reward_bonus' => $row->reward_qualified_reward_bonus,
                    'reward_qualified_status' => $status,
                    'reward_qualified_date' => convert_date($row->reward_qualified_date, 'id'),
                    'process_date' => $row->process_date,
                    'administrator_name' => $administrator[$row->administrator_id],
                ),
            );
            
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function export_log_data() {
        $params = array();
        if(isset($_POST)) {
            foreach($_POST as $id => $value) {
                $params[$id] = $value;
            }
        }
        $params['params']['table'] = "sys_reward_qualified";
        $params['params']['where_detail'] = "reward_qualified_network_id = " . $this->session->userdata('network_id') . "";
        
        if($params['params']['total_data'] <= 1000) {
            unset($params['params']['rp']);
            unset($params['params']['page']);
        }
        
        $data = array();
        $data['title'] = 'Pencapaian Reward';
        $data['params'] = $params;
        $data['query'] = $this->function_lib->get_query_data($params['params']);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }

}
