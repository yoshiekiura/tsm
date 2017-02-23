<?php

/*
 * Member Network Controller
 *
 * @author	Ardi Pras
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Network extends Member_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('voffice/network_model');
        $this->load->helper('form');
        $this->load->helper('is_serialized');
    }
    
    function index(){
        $this->node();
    }
    
    function show(){
        $data['page_title'] = 'Status Jaringan';
        $data['arr_breadcrumbs'] = array(
            'Jaringan' => '#',
            'Status Jaringan' => 'voffice/network/show',
        );
        
        $data['city_grid_options'] = $this->function_lib->get_city_grid_options();
        $data['province_grid_options'] = $this->function_lib->get_province_grid_options();
        $data['region_grid_options'] = $this->function_lib->get_region_grid_options();
        $data['country_grid_options'] = $this->function_lib->get_country_grid_options();
        
        template('member', 'voffice/network_node_view', $data);
    }
    
    function geneology(){
        $root_network_id = $this->session->userdata('network_id');
        $top_network_code = $this->uri->segment(4);
        
        $data['page_title'] = 'Geneologi';
        $data['arr_breadcrumbs'] = array(
            'Jaringan' => '#',
            'Geneologi' => 'voffice/network/geneology',
        );
        
        if($top_network_code) {
            $top_network_id = $this->mlm_function->get_network_id($top_network_code);
            if($top_network_id == '') {
                $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger"><p>Member yang anda cari tidak ditemukan.</p><p>Silakan <a href="' . base_url() . 'voffice/network/geneology' . '">klik disini</a> untuk kembali ke Jaringan Member anda.</p></div>');
                $this->session->set_flashdata('notfound', true);
                redirect('voffice/network/geneology');
            } else {
                //cek apakah member yang dicari sejalur dengan member login
                $check_uplink = $this->mlm_function->check_uplink($top_network_code, $this->session->userdata('network_code'));
                if(!$check_uplink) {
                    $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger"><p>Member yang anda cari tidak berada pada jaringan anda.</p><p>Silakan <a href="' . base_url() . 'voffice/network/geneology' . '">klik disini</a> untuk kembali ke Jaringan Member anda.</p></div>');
                    $this->session->set_flashdata('notfound', true);
                    redirect('voffice/network/geneology');
                }
            }
        } else {
            $top_network_id = $this->session->userdata('network_id');
        }
        $data['root_network_id'] = $root_network_id;
        $data['top_network_id'] = $top_network_id;
        $data['arr_data'] = $this->mlm_function->generate_geneology_binary($root_network_id, $top_network_id, 3);
        $data['extra_head_content'] = '<link rel="stylesheet" href="' . base_url() . '/addons/jorgchart/css/jorgchart.css"/>';
        $data['extra_head_content'] .= '<script type="text/javascript" src="' . base_url() . '/addons/jorgchart/js/jorgchart.js"></script>';
        $data['extra_head_content'] .= '<link rel="stylesheet" href="' . base_url() . '/addons/jquery-qtip/css/jquery.qtip.min.css"/>';
        $data['extra_head_content'] .= '<script type="text/javascript" src="' . base_url() . '/addons/jquery-qtip/js/jquery.qtip.min.js"></script>';
        $data['form_action'] = 'voffice/network/act_geneology';
        
        template('member', 'voffice/network_geneology_view', $data);
    }
    
    function act_geneology(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('search_network_code', '<b>Kode Member</b>', 'required');
        $this->session->set_flashdata('input_search_network_code', $this->input->post('search_network_code'));

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            redirect($this->input->post('uri_string'));
        } else {
            $network_code = $this->input->post('search_network_code');
            $check = $this->function_lib->get_one('sys_network', 'network_id', array('network_code' => $network_code));
            if($check != '') {
                redirect('voffice/network/geneology/' . $network_code);
            } else {
                $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger"><p>Data tidak ditemukan.</p><p>Silakan <a href="' . base_url() . $this->input->post('uri_string') . '">klik disini</a> untuk kembali ke Jaringan Member sebelumnya.</p></div>');
                $this->session->set_flashdata('notfound', true);
                redirect($this->input->post('uri_string'));
            }
        }
    }
    
    function get_member_info($network_code = '') {
        $network_id = $this->mlm_function->get_network_id($network_code);
        $data['arr_data'] = $this->mlm_function->get_arr_member_detail($network_id);
        $data['arr_data']['max_level_left'] = $this->mlm_function->get_member_max_level($network_id, 'L');
        $data['arr_data']['max_level_right'] = $this->mlm_function->get_member_max_level($network_id, 'R');
        $data['arr_data']['sponsoring_count_left'] = $this->mlm_function->get_member_sponsoring_count($network_id, 'L');
        $data['arr_data']['sponsoring_count_right'] = $this->mlm_function->get_member_sponsoring_count($network_id, 'R');
        template('blank', 'voffice/network_member_info_view', $data);
    }
    
    function node($position=FALSE){
        $data['page_title'] = 'Data Downline';
        $data['arr_breadcrumbs'] = array(
            'Jaringan' => '#',
            'Data Downline' => 'voffice/network/node',
        );
        
        $data['city_grid_options'] = $this->function_lib->get_city_grid_options();
        $data['province_grid_options'] = $this->function_lib->get_province_grid_options();
        $data['region_grid_options'] = $this->function_lib->get_region_grid_options();
        $data['country_grid_options'] = $this->function_lib->get_country_grid_options();

        $data['arr_node'] = $this->network_model->get_arr_node($this->session->userdata('network_id'));
        $data['position'] = $position;
        if ($position == 'left') {
            $data['title_data'] = 'JUMLAH JARINGAN KIRI ANDA : ' . $data['arr_node']['left'];
        } elseif ($position == 'right') {
            $data['title_data'] = 'JUMLAH JARINGAN KANAN ANDA : ' . $data['arr_node']['right'];
        } else {
            $data['position'] = FALSE;
            $data['title_data'] = 'JUMLAH JARINGAN ANDA : ' . $data['arr_node']['left'] . ' KIRI &middot;&middot;&middot; ' . $data['arr_node']['right'] . ' KANAN';
        }

        $data['service_url'] = base_url('voffice/network/get_node_data/'.$data['position']);
        
        template('member', 'voffice/network_node_view', $data);
    }
    
    function get_node_data($position=FALSE) {
        $params = isset($_POST) ? $_POST : array();
        if ($position == 'left') {
            $params['where'] = "netgrow_node_position = 'L'";
        } elseif ($position == 'right') {
            $params['where'] = "netgrow_node_position = 'R'";
        }
        $query = $this->network_model->get_query_netgrow_node_data($this->session->userdata('network_id'), $params);
        $total = $this->network_model->get_query_netgrow_node_data($this->session->userdata('network_id'), $params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //downline_is_active
            if ($row->downline_member_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $downline_is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            $entry = array('id' => $row->netgrow_node_id,
                'cell' => array(
                    'netgrow_node_level' => $row->netgrow_node_level,
                    'netgrow_node_position' => $row->netgrow_node_position,
                    'netgrow_node_position_text' => $row->netgrow_node_position_text,
                    'netgrow_node_date' => convert_date($row->netgrow_node_date, 'id'),
                    'downline_network_code' => $row->downline_network_code,
                    'downline_frontline_left_network_code' => $row->downline_frontline_left_network_code,
                    'downline_frontline_right_network_code' => $row->downline_frontline_right_network_code,
                    'downline_member_name' => stripslashes($row->downline_member_name),
                    'downline_member_nickname' => $row->downline_member_nickname,
                    'downline_member_phone' => $row->downline_member_phone,
                    'downline_member_mobilephone' => $row->downline_member_mobilephone,
                    'downline_member_join_datetime' => convert_datetime($row->downline_member_join_datetime, 'id'),
                    'downline_member_is_active' => $downline_is_active,
                    'downline_member_city_name' => $row->downline_member_city_name,
                    'downline_member_province_name' => $row->downline_member_province_name,
                    'downline_member_region_name' => $row->downline_member_region_name,
                    'downline_member_country_name' => $row->downline_member_country_name,
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function export_data() {
        $params = isset($_POST['params']) ? $_POST['params'] : array();
        
        if($params['total_data'] <= 1000) {
            unset($params['rp']);
            unset($params['page']);
        }
        
        $data = array();
        $data['title'] = 'Data Downline';
        $data['query'] = $this->network_model->get_query_netgrow_node_data($this->session->userdata('network_id'), $params);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }
    
    function sponsoring(){
        $data['page_title'] = 'Data Sponsorisasi';
        $data['arr_breadcrumbs'] = array(
            'Jaringan' => '#',
            'Data Sponsorisasi' => 'voffice/network/sponsoring',
        );
        
        $data['city_grid_options'] = $this->function_lib->get_city_grid_options();
        $data['province_grid_options'] = $this->function_lib->get_province_grid_options();
        $data['region_grid_options'] = $this->function_lib->get_region_grid_options();
        $data['country_grid_options'] = $this->function_lib->get_country_grid_options();
        
        template('member', 'voffice/network_sponsoring_view', $data);
    }
    
    function get_sponsoring_data() {
        $params = isset($_POST) ? $_POST : array();
        $query = $this->network_model->get_query_netgrow_sponsor_data($this->session->userdata('network_id'), $params);
        $total = $this->network_model->get_query_netgrow_sponsor_data($this->session->userdata('network_id'), $params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //downline_is_active
            if ($row->downline_member_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $downline_is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            $entry = array('id' => $row->netgrow_sponsor_id,
                'cell' => array(
                    'netgrow_sponsor_level' => $row->netgrow_sponsor_level,
                    'netgrow_sponsor_position' => $row->netgrow_sponsor_position,
                    'netgrow_sponsor_position_text' => $row->netgrow_sponsor_position_text,
                    'netgrow_sponsor_date' => convert_date($row->netgrow_sponsor_date, 'id'),
                    'downline_network_code' => $row->downline_network_code,
                    'downline_frontline_left_network_code' => $row->downline_frontline_left_network_code,
                    'downline_frontline_right_network_code' => $row->downline_frontline_right_network_code,
                    'downline_member_name' => stripslashes($row->downline_member_name),
                    'downline_member_nickname' => $row->downline_member_nickname,
                    'downline_member_phone' => $row->downline_member_phone,
                    'downline_member_mobilephone' => $row->downline_member_mobilephone,
                    'downline_member_join_datetime' => convert_datetime($row->downline_member_join_datetime, 'id'),
                    'downline_member_is_active' => $downline_is_active,
                    'downline_member_city_name' => $row->downline_member_city_name,
                    'downline_member_province_name' => $row->downline_member_province_name,
                    'downline_member_region_name' => $row->downline_member_region_name,
                    'downline_member_country_name' => $row->downline_member_country_name,
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function export_sponsoring_data() {
        $params = isset($_POST['params']) ? $_POST['params'] : array();
        
        if($params['total_data'] <= 1000) {
            unset($params['rp']);
            unset($params['page']);
        }
        
        $data = array();
        $data['title'] = 'Data Sponsorisasi';
        $data['query'] = $this->network_model->get_query_netgrow_sponsor_data($this->session->userdata('network_id'), $params);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }
    
    function match() {
        $data['arr_breadcrumbs'] = array(
            'Jaringan' => '#',
            'History Pasangan' => 'voffice/network/match',
        );
        
        template('member', 'voffice/network_match_view', $data);
    }
    
    function get_match_data() {
        $params = isset($_POST) ? $_POST : array();
        $query = $this->network_model->get_query_netgrow_match_data($this->session->userdata('network_id'), $params);
        $total = $this->network_model->get_query_netgrow_match_data($this->session->userdata('network_id'), $params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            $entry = array('id' => $row->netgrow_match_id,
                'cell' => array(
                    'netgrow_match_value' => $row->netgrow_match_value,
                    'netgrow_match_date' => convert_date($row->netgrow_match_date, 'id'),
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function export_match_data() {
        $params = isset($_POST['params']) ? $_POST['params'] : array();
        
        if($params['total_data'] <= 1000) {
            unset($params['rp']);
            unset($params['page']);
        }
        
        $data = array();
        $data['title'] = 'Data History Pasangan';
        $data['query'] = $this->network_model->get_query_netgrow_match_data($this->session->userdata('network_id'), $params);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }
    
    function gen_node() {
        $data['arr_breadcrumbs'] = array(
            'Jaringan' => '#',
            'History Generasi Titik' => 'voffice/network/gen_node',
        );
        
        $data['city_grid_options'] = $this->function_lib->get_city_grid_options();
        $data['province_grid_options'] = $this->function_lib->get_province_grid_options();
        $data['region_grid_options'] = $this->function_lib->get_region_grid_options();
        $data['country_grid_options'] = $this->function_lib->get_country_grid_options();
        
        template('member', 'voffice/network_gen_node_view', $data);
    }
    
    function get_gen_node_data() {
        $params = isset($_POST) ? $_POST : array();
        $query = $this->network_model->get_query_netgrow_gen_node_data($this->session->userdata('network_id'), $params);
        $total = $this->network_model->get_query_netgrow_gen_node_data($this->session->userdata('network_id'), $params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //downline_is_active
            if ($row->downline_member_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $downline_is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            $entry = array('id' => $row->netgrow_gen_node_id,
                'cell' => array(
                    'netgrow_gen_node_level' => $row->netgrow_gen_node_level,
                    'netgrow_gen_node_position' => $row->netgrow_gen_node_position,
                    'netgrow_gen_node_position_text' => $row->netgrow_gen_node_position_text,
                    'netgrow_gen_node_date' => convert_date($row->netgrow_gen_node_date, 'id'),
                    'downline_network_code' => $row->downline_network_code,
                    'downline_frontline_left_network_code' => $row->downline_frontline_left_network_code,
                    'downline_frontline_right_network_code' => $row->downline_frontline_right_network_code,
                    'downline_member_name' => $row->downline_member_name,
                    'downline_member_nickname' => $row->downline_member_nickname,
                    'downline_member_phone' => $row->downline_member_phone,
                    'downline_member_mobilephone' => $row->downline_member_mobilephone,
                    'downline_member_join_datetime' => convert_datetime($row->downline_member_join_datetime, 'id'),
                    'downline_member_is_active' => $downline_is_active,
                    'downline_member_city_name' => $row->downline_member_city_name,
                    'downline_member_province_name' => $row->downline_member_province_name,
                    'downline_member_region_name' => $row->downline_member_region_name,
                    'downline_member_country_name' => $row->downline_member_country_name,
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function export_gen_node_data() {
        $params = isset($_POST['params']) ? $_POST['params'] : array();
        
        if($params['total_data'] <= 1000) {
            unset($params['rp']);
            unset($params['page']);
        }
        
        $data = array();
        $data['title'] = 'Data History Generasi Titik';
        $data['query'] = $this->network_model->get_query_netgrow_gen_node_data($this->session->userdata('network_id'), $params);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }
    
    function gen_sponsor() {
        $data['page_title'] = 'History Generasi Sponsor';
        
        $data['arr_breadcrumbs'] = array(
            'Jaringan' => '#',
            'History Generasi Sponsor' => 'voffice/network/gen_sponsor',
        );
        
        $data['city_grid_options'] = $this->function_lib->get_city_grid_options();
        $data['province_grid_options'] = $this->function_lib->get_province_grid_options();
        $data['region_grid_options'] = $this->function_lib->get_region_grid_options();
        $data['country_grid_options'] = $this->function_lib->get_country_grid_options();
        
        template('member', 'voffice/network_gen_sponsor_view', $data);
    }
    
    function get_gen_sponsor_data() {
        $params = isset($_POST) ? $_POST : array();
        $query = $this->network_model->get_query_netgrow_gen_sponsor_data($this->session->userdata('network_id'), $params);
        $total = $this->network_model->get_query_netgrow_gen_sponsor_data($this->session->userdata('network_id'), $params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //downline_is_active
            if ($row->downline_member_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $downline_is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            $entry = array('id' => $row->netgrow_gen_sponsor_id,
                'cell' => array(
                    'netgrow_gen_sponsor_level' => $row->netgrow_gen_sponsor_level,
                    //'netgrow_gen_sponsor_position' => $row->netgrow_gen_sponsor_position,
                    //'netgrow_gen_sponsor_position_text' => $row->netgrow_gen_sponsor_position_text,
                    'netgrow_gen_sponsor_date' => convert_date($row->netgrow_gen_sponsor_date, 'id'),
                    'downline_network_code' => $row->downline_network_code,
                    'downline_frontline_left_network_code' => $row->downline_frontline_left_network_code,
                    'downline_frontline_right_network_code' => $row->downline_frontline_right_network_code,
                    'downline_member_name' => $row->downline_member_name,
                    'downline_member_nickname' => $row->downline_member_nickname,
                    'downline_member_phone' => $row->downline_member_phone,
                    'downline_member_mobilephone' => $row->downline_member_mobilephone,
                    'downline_member_join_datetime' => convert_datetime($row->downline_member_join_datetime, 'id'),
                    'downline_member_is_active' => $downline_is_active,
                    'downline_member_city_name' => $row->downline_member_city_name,
                    'downline_member_province_name' => $row->downline_member_province_name,
                    'downline_member_region_name' => $row->downline_member_region_name,
                    'downline_member_country_name' => $row->downline_member_country_name,
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function export_gen_sponsor_data() {
        $params = isset($_POST['params']) ? $_POST['params'] : array();
        
        if($params['total_data'] <= 1000) {
            unset($params['rp']);
            unset($params['page']);
        }
        
        $data = array();
        $data['title'] = 'Data History Generasi Sponsor';
        $data['query'] = $this->network_model->get_query_netgrow_gen_sponsor_data($this->session->userdata('network_id'), $params);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }
    
    function gen_match() {
        $data['arr_breadcrumbs'] = array(
            'Jaringan' => '#',
            'History Generasi Pasangan' => 'voffice/network/gen_match',
        );
        
        $data['city_grid_options'] = $this->function_lib->get_city_grid_options();
        $data['province_grid_options'] = $this->function_lib->get_province_grid_options();
        $data['region_grid_options'] = $this->function_lib->get_region_grid_options();
        $data['country_grid_options'] = $this->function_lib->get_country_grid_options();
        
        template('member', 'voffice/network_gen_match_view', $data);
    }
    
    function get_gen_match_data() {
        $params = isset($_POST) ? $_POST : array();
        $query = $this->network_model->get_query_netgrow_gen_match_data($this->session->userdata('network_id'), $params);
        $total = $this->network_model->get_query_netgrow_gen_match_data($this->session->userdata('network_id'), $params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //downline_is_active
            if ($row->downline_member_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $downline_is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            $entry = array('id' => $row->netgrow_gen_match_id,
                'cell' => array(
                    'netgrow_gen_match_level' => $row->netgrow_gen_match_level,
                    'netgrow_gen_match_position' => $row->netgrow_gen_match_position,
                    'netgrow_gen_match_position_text' => $row->netgrow_gen_match_position_text,
                    'netgrow_gen_match_date' => convert_date($row->netgrow_gen_match_date, 'id'),
                    'downline_network_code' => $row->downline_network_code,
                    'downline_frontline_left_network_code' => $row->downline_frontline_left_network_code,
                    'downline_frontline_right_network_code' => $row->downline_frontline_right_network_code,
                    'downline_member_name' => $row->downline_member_name,
                    'downline_member_nickname' => $row->downline_member_nickname,
                    'downline_member_phone' => $row->downline_member_phone,
                    'downline_member_mobilephone' => $row->downline_member_mobilephone,
                    'downline_member_join_datetime' => convert_datetime($row->downline_member_join_datetime, 'id'),
                    'downline_member_is_active' => $downline_is_active,
                    'downline_member_city_name' => $row->downline_member_city_name,
                    'downline_member_province_name' => $row->downline_member_province_name,
                    'downline_member_region_name' => $row->downline_member_region_name,
                    'downline_member_country_name' => $row->downline_member_country_name,
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function export_gen_match_data() {
        $params = isset($_POST['params']) ? $_POST['params'] : array();
        
        if($params['total_data'] <= 1000) {
            unset($params['rp']);
            unset($params['page']);
        }
        
        $data = array();
        $data['title'] = 'Data History Generasi Pasangan';
        $data['query'] = $this->network_model->get_query_netgrow_gen_match_data($this->session->userdata('network_id'), $params);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }
    
    function upline_sponsor() {
        $data['arr_breadcrumbs'] = array(
            'Jaringan' => '#',
            'History Upline Sponsor' => 'voffice/network/upline_sponsor',
        );
        
        $data['city_grid_options'] = $this->function_lib->get_city_grid_options();
        $data['province_grid_options'] = $this->function_lib->get_province_grid_options();
        $data['region_grid_options'] = $this->function_lib->get_region_grid_options();
        $data['country_grid_options'] = $this->function_lib->get_country_grid_options();
        
        template('member', 'voffice/network_upline_sponsor_view', $data);
    }
    
    function get_upline_sponsor_data() {
        $params = isset($_POST) ? $_POST : array();
        $query = $this->network_model->get_query_netgrow_upline_sponsor_data($this->session->userdata('network_id'), $params);
        $total = $this->network_model->get_query_netgrow_upline_sponsor_data($this->session->userdata('network_id'), $params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //downline_is_active
            if ($row->downline_member_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $downline_is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            $entry = array('id' => $row->netgrow_upline_sponsor_id,
                'cell' => array(
                    'netgrow_upline_sponsor_date' => convert_date($row->netgrow_upline_sponsor_date, 'id'),
                    'downline_network_code' => $row->downline_network_code,
                    'downline_frontline_left_network_code' => $row->downline_frontline_left_network_code,
                    'downline_frontline_right_network_code' => $row->downline_frontline_right_network_code,
                    'downline_member_name' => $row->downline_member_name,
                    'downline_member_nickname' => $row->downline_member_nickname,
                    'downline_member_phone' => $row->downline_member_phone,
                    'downline_member_mobilephone' => $row->downline_member_mobilephone,
                    'downline_member_join_datetime' => convert_datetime($row->downline_member_join_datetime, 'id'),
                    'downline_member_is_active' => $downline_is_active,
                    'downline_member_city_name' => $row->downline_member_city_name,
                    'downline_member_province_name' => $row->downline_member_province_name,
                    'downline_member_region_name' => $row->downline_member_region_name,
                    'downline_member_country_name' => $row->downline_member_country_name,
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function export_upline_sponsor_data() {
        $params = isset($_POST['params']) ? $_POST['params'] : array();
        
        if($params['total_data'] <= 1000) {
            unset($params['rp']);
            unset($params['page']);
        }
        
        $data = array();
        $data['title'] = 'Data History Upline Sponsor';
        $data['query'] = $this->network_model->get_query_netgrow_upline_sponsor_data($this->session->userdata('network_id'), $params);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }
    
    function upline_match() {
        $data['arr_breadcrumbs'] = array(
            'Jaringan' => '#',
            'History Upline Pasangan' => 'voffice/network/upline_match',
        );
        
        $data['city_grid_options'] = $this->function_lib->get_city_grid_options();
        $data['province_grid_options'] = $this->function_lib->get_province_grid_options();
        $data['region_grid_options'] = $this->function_lib->get_region_grid_options();
        $data['country_grid_options'] = $this->function_lib->get_country_grid_options();
        
        template('member', 'voffice/network_upline_match_view', $data);
    }
    
    function get_upline_match_data() {
        $params = isset($_POST) ? $_POST : array();
        $query = $this->network_model->get_query_netgrow_upline_match_data($this->session->userdata('network_id'), $params);
        $total = $this->network_model->get_query_netgrow_upline_match_data($this->session->userdata('network_id'), $params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //downline_is_active
            if ($row->downline_member_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'bulb_on.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'bulb_off.png';
            }
            $downline_is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            $entry = array('id' => $row->netgrow_upline_match_id,
                'cell' => array(
                    'netgrow_upline_match_date' => convert_date($row->netgrow_upline_match_date, 'id'),
                    'downline_network_code' => $row->downline_network_code,
                    'downline_frontline_left_network_code' => $row->downline_frontline_left_network_code,
                    'downline_frontline_right_network_code' => $row->downline_frontline_right_network_code,
                    'downline_member_name' => $row->downline_member_name,
                    'downline_member_nickname' => $row->downline_member_nickname,
                    'downline_member_phone' => $row->downline_member_phone,
                    'downline_member_mobilephone' => $row->downline_member_mobilephone,
                    'downline_member_join_datetime' => convert_datetime($row->downline_member_join_datetime, 'id'),
                    'downline_member_is_active' => $downline_is_active,
                    'downline_member_city_name' => $row->downline_member_city_name,
                    'downline_member_province_name' => $row->downline_member_province_name,
                    'downline_member_region_name' => $row->downline_member_region_name,
                    'downline_member_country_name' => $row->downline_member_country_name,
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function export_upline_match_data() {
        $params = isset($_POST['params']) ? $_POST['params'] : array();
        
        if($params['total_data'] <= 1000) {
            unset($params['rp']);
            unset($params['page']);
        }
        
        $data = array();
        $data['title'] = 'Data History Upline Pasangan';
        $data['query'] = $this->network_model->get_query_netgrow_upline_match_data($this->session->userdata('network_id'), $params);
        $data['column'] = isset($_POST['column']) ? $_POST['column'] : array();
        $this->function_lib->export_excel_standard($data);
    }

    function geneology_tree(){
        $root_network_id = $this->session->userdata('network_id');
        $omzet_year = $this->uri->segment(4, date("Y"));
        $omzet_month = $this->uri->segment(5, date("m"));
        $top_network_code = $this->uri->segment(6);
        $level_depth = 5;
        
        $data['arr_breadcrumbs'] = array(
            'Jaringan' => '#',
            'Geneologi (Tree)' => 'voffice/network/geneology_tree',
        );
        
        $data['month_options'] = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'Nopember',
            '12' => 'Desember'
        );
        
        $data['year_options'] = array();
        $min_year = 2014;
        $max_year = date("Y");
        for($year = $min_year; $year <= $max_year; $year++) {
            $data['year_options'][$year] = $year;
        }
        
        if($top_network_code) {
            $top_network_id = $this->mlm_function->get_network_id($top_network_code);
            $search_top_network_code = $top_network_code;
            if($top_network_id == '') {
                $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger"><p>Member yang anda cari tidak ditemukan.</p><p>Silakan <a href="' . base_url() . 'voffice/network/geneology_tree' . '">klik disini</a> untuk kembali ke Jaringan Member anda.</p></div>');
                $this->session->set_flashdata('notfound', true);
                redirect('voffice/network/geneology_tree_new');
            } else {
                //cek apakah member yang dicari sejalur dengan member login
                $check_uplink = $this->mlm_function->check_uplink($top_network_code, $this->session->userdata('network_code'));
                if(!$check_uplink) {
                    $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger"><p>Member yang anda cari tidak berada pada jaringan anda.</p><p>Silakan <a href="' . base_url() . 'voffice/network/geneology_tree' . '">klik disini</a> untuk kembali ke Jaringan Member anda.</p></div>');
                    $this->session->set_flashdata('notfound', true);
                    redirect('voffice/network/geneology_tree');
                }
            }
        } else {
            $top_network_id = $this->session->userdata('network_id');
            $top_network_code = $this->mlm_function->get_network_code($top_network_id);
            $search_top_network_code = '';
        }
        
        $data['page_title'] = 'Jaringan Geneologi (Tree)';
        $data['root_network_id'] = $root_network_id;
        $data['top_network_id'] = $top_network_id;
        $data['top_network_code'] = $top_network_code;
        $data['top_member_name'] = stripslashes($this->mlm_function->get_member_name($top_network_id));
        $data['search_top_network_code'] = $search_top_network_code;
        $data['omzet_year'] = $omzet_year;
        $data['omzet_month'] = $omzet_month;
        $data['str_data'] = $this->mlm_function->generate_geneology_tree($root_network_id, $top_network_id, $level_depth, $omzet_year, $omzet_month);
        $data['addons_tree_dir'] = base_url() . 'addons/jquery-treeview';
        $data['extra_head_content'] = '<link rel="stylesheet" href="' . base_url() . 'addons/jquery-treeview/css/jquery.treeview.css"/>';
        $data['extra_head_content'] .= '<script type="text/javascript" src="' . base_url() . 'addons/js/jquery.cookie.js"></script>';
        $data['extra_head_content'] .= '<script type="text/javascript" src="' . base_url() . 'addons/jquery-treeview/js/jquery.treeview.js"></script>';
        $data['extra_head_content'] .= '<script type="text/javascript" src="' . base_url() . 'addons/js/jquery.cookie.js"></script>';
        $data['form_action'] = 'voffice/network/act_geneology_tree';
        
        template('member', 'voffice/network_geneology_tree_view', $data);
    }

    /**
    dapatkan data downline
    */
    public function get_downline($root_network_id = 0, $upline_id = 0, $year = 0, $month = 0) {
        $separator_1 = ' <font color="#888888">&middot;</font> ';
        $separator_2 = ' <font color="#888888">&middot;&middot;</font> ';
        $separator_3 = ' <font color="#888888">&middot;&middot;&middot;</font> ';

        if($year == '' || $month == '') {
            $year = date("Y");
            $month = date("m");
        }

        if(!isset($tree)) {
            $tree = '';
        }

        $response = array();
        $response['status'] = 500;
        $response['message'] = 'Data tidak ditemukan.';
        $response['ul_child'] = '';

        $sql = "
            SELECT * FROM sys_network INNER JOIN sys_member ON member_network_id = network_id WHERE network_upline_network_id = " . $upline_id . " AND network_position = 'L' 
            UNION ALL 
            SELECT * FROM sys_network INNER JOIN sys_member ON member_network_id = network_id WHERE network_upline_network_id = " . $upline_id . " AND network_position = 'R' 
        ";
        $query = $this->CI->db->query($sql);
        if($query->num_rows() > 0) {
            $response = array();

            $tree .= '<ul style="display:block;">';
            foreach($query->result() as $row) {

                $network_level = $this->mlm_function->get_network_level_value($row->network_id, $root_network_id);
                if($network_level == '') {
                    $network_level = 0;
                }
                $downline_check = $this->function_lib->get_one('sys_network', 'network_id', array('network_upline_network_id' => $row->network_id));

                $row_data = '&nbsp;Lv ' . $network_level . $separator_1 . $row->network_position . $separator_1 . $row->network_code . $separator_1 . stripslashes($row->member_name) . '';
                $has_downline = $this->mlm_function->check_has_downline($row->network_id);
                $has_downline_label = ($has_downline > 0) ? '<a href="javascript:void(0)" onclick="get_downline($(this), ' . $root_network_id . ', ' . $row->network_id . ', ' . $year . ', ' . $month . '); return false;" title="Expand">[+]</a> ' : '';

                $tree .= '<li id="parentli_' . $row->network_id . '"> '. $has_downline_label;
                $tree .= '<span>' . $row_data . '</span>';
                $tree .= '</li>';

            }
            $tree .= '</ul>';
            $response['status'] = 200;
            $response['message'] = 'OK';
            $response['ul_child'] = $tree;
        }

        echo json_encode($response);
    }

    function act_geneology_tree(){
        if($this->input->post('search') != FALSE) {
            $this->session->set_flashdata('input_search_network_code', $this->input->post('search_network_code'));
            $year = (!empty($this->input->post('year'))) ? $this->input->post('year') : date("Y");
            $month = (!empty($this->input->post('month'))) ? $this->input->post('month') : date("m");
            if($this->input->post('search_network_code') != FALSE) {
                $network_code = $this->input->post('search_network_code');
                $check = $this->function_lib->get_one('sys_network', 'network_id', array('network_code' => $network_code));
                if($check != '') {
                    redirect('voffice/network/geneology_tree/' . $year . '/' . $month . '/' . $network_code);
                } else {
                    $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger"><p>Data tidak ditemukan.</p><p>Silakan <a href="' . base_url() . $this->input->post('uri_string') . '">klik disini</a> untuk kembali ke Jaringan Member sebelumnya.</p></div>');
                    $this->session->set_flashdata('notfound', true);
                    redirect('voffice/network/geneology_tree');
                }
            } else {
                redirect('voffice/network/geneology_tree/' . $year . '/' . $month);
            }
        }
    }
    
    function geneology_tree_print() {
        $root_network_id = $this->session->userdata('network_id');
        $omzet_year = base64_decode($this->uri->segment(4));
        $omzet_month = base64_decode($this->uri->segment(5));
        $top_network_code = base64_decode($this->uri->segment(6));
        $level_depth = 5;
        
        $data['arr_breadcrumbs'] = array(
            'Jaringan' => '#',
            'Geneologi (Tree)' => 'voffice/network/geneology_tree',
        );
        
        $data['arr_month'] = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'Nopember',
            '12' => 'Desember'
        );
        
        if($top_network_code) {
            $top_network_id = $this->mlm_function->get_network_id($top_network_code);
            if($top_network_id == '') {
                die('Member yang anda cari tidak ditemukan.');
            } else {
                //cek apakah member yang dicari sejalur dengan member login
                $check_uplink = $this->mlm_function->check_uplink($top_network_code, $this->session->userdata('network_code'));
                if(!$check_uplink) {
                    die('Member yang anda cari tidak berada pada jaringan anda.');
                }
            }
        } else {
            $top_network_id = $this->session->userdata('network_id');
            $top_network_code = $this->mlm_function->get_network_code($top_network_id);
        }
        
        $data['root_network_id'] = $root_network_id;
        $data['top_network_id'] = $top_network_id;
        $data['top_network_code'] = $top_network_code;
        $data['top_member_name'] = $this->mlm_function->get_member_name($top_network_id);
        $data['omzet_year'] = $omzet_year;
        $data['omzet_month'] = $omzet_month;
        $data['str_data'] = $this->mlm_function->generate_geneology_tree($root_network_id, $top_network_id, $level_depth, $omzet_year, $omzet_month);
        $data['addons_tree_dir'] = base_url() . 'addons/jquery-treeview';
        $data['extra_head_content'] = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>';
        $data['extra_head_content'] .= '<link rel="stylesheet" href="' . base_url() . 'addons/jquery-treeview/css/jquery.treeview.css"/>';
        $data['extra_head_content'] .= '<script type="text/javascript" src="' . base_url() . 'addons/js/jquery.cookie.js"></script>';
        $data['extra_head_content'] .= '<script type="text/javascript" src="' . base_url() . 'addons/jquery-treeview/js/jquery.treeview.js"></script>';
        $data['form_action'] = 'voffice/network/act_geneology_tree';
        
        template('blank', 'voffice/network_geneology_tree_print_view', $data);
    }
    
}

?>
