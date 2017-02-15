<?php

/*
 * Backend Message Controller
 *
 * @author	Yusuf Rahmanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('backend_message_model');
        $this->load->helper('form');
    }
    
    function index(){
        $this->show();
    }
    
    function show(){
        $data['arr_breadcrumbs'] = array(
            'Pesan' => '#',
            'Data Pesan Member' => 'backend/message/show',
        );
        
        template('backend', 'message/backend_message_list_view', $data);
    }
    
    function detail($message_id = ''){
        $data['arr_breadcrumbs'] = array(
            'Pesan' => '#',
            'Data Pesan Member' => 'backend/message/show',
            'Detail Pesan Member' => 'backend/message/detail',
        );
        
        //cari data pengirim & penerima
        $parent_message = $this->backend_message_model->get_parent_message($message_id)->row();
        $data['parent_sender_network_id'] = $parent_message->message_sender_network_id;
        $data['parent_sender_network_code'] = $this->mlm_function->get_network_code($parent_message->message_sender_network_id);
        $data['parent_sender_member_name'] = $this->mlm_function->get_member_name($parent_message->message_sender_network_id);
        $data['parent_receiver_network_id'] = $parent_message->message_receiver_network_id;
        $data['parent_receiver_network_code'] = $this->mlm_function->get_network_code($parent_message->message_receiver_network_id);
        $data['parent_receiver_member_name'] = $this->mlm_function->get_member_name($parent_message->message_receiver_network_id);
        
        //pagination
        $this->load->library('pagination');
        $offset = (int) $this->uri->segment(5, 0);
        $limit = 10;
        $config['base_url'] = site_url('backend/message/detail/' . $message_id);
        $config['total_rows'] = $this->backend_message_model->get_detail_message($message_id, 0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 5;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['offset'] = $offset;
        $data['message_detail'] = $this->backend_message_model->get_detail_message($message_id, $offset, $limit)->result();
        
        template('backend', 'message/backend_message_detail_view', $data);
    }
    
    function show_admin(){
        $data['arr_breadcrumbs'] = array(
            'Pesan' => '#',
            'Data Pesan Admin' => 'backend/message/show_admin',
        );
        
        template('backend', 'message/backend_message_to_admin_list_view', $data);
    }
    
    function detail_admin($message_id = ''){
        $data['arr_breadcrumbs'] = array(
            'Pesan' => '#',
            'Data Pesan Admin' => 'backend/message/show_admin',
            'Detail Pesan Admin' => 'backend/message/detail_admin',
        );
        
        $data['form_action'] = 'backend_service/message/act_add';
        $data['message_id'] = $message_id;
        
        $parent_message = $this->backend_message_model->get_parent_message($message_id)->row();
        $data['parent_message_title'] = $parent_message->message_title;
        
        //cari data pengirim
        $data['parent_sender_network_id'] = $parent_message->message_sender_network_id;
        if($parent_message->message_sender_network_id == 0) {
            $data['parent_sender_network_code'] = 'Admin';
            $data['parent_sender_member_name'] = 'Administrator';
        } else {
            $data['parent_sender_network_code'] = $this->mlm_function->get_network_code($parent_message->message_sender_network_id);
            $data['parent_sender_member_name'] = $this->mlm_function->get_member_name($parent_message->message_sender_network_id);
            $data['responder_code'] = $data['parent_sender_network_code'];
            $data['responder_name'] = $data['parent_sender_member_name'];
        }
        
        //cari data penerima
        $data['parent_receiver_network_id'] = $parent_message->message_receiver_network_id;
        if($parent_message->message_receiver_network_id == 0) {
            $data['parent_receiver_network_code'] = 'Admin';
            $data['parent_receiver_member_name'] = 'Administrator';
        } else {
            $data['parent_receiver_network_code'] = $this->mlm_function->get_network_code($parent_message->message_receiver_network_id);
            $data['parent_receiver_member_name'] = $this->mlm_function->get_member_name($parent_message->message_receiver_network_id);
            $data['responder_code'] = $data['parent_receiver_network_code'];
            $data['responder_name'] = $data['parent_receiver_member_name'];
        }
        
        $cek_last = $this->backend_message_model->get_last_message($message_id)->row();
        if($cek_last->message_receiver_network_id == 0){
            $data_update = array('message_is_read' => '1');
            $this->function_lib->update_data('site_message', 'message_id', $message_id, $data_update);
            $this->function_lib->update_data('site_message', 'message_par_id', $message_id, $data_update);
        }
                
        //pagination
        $this->load->library('pagination');
        $offset = (int) $this->uri->segment(5, 0);
        $limit = 10;
        $config['base_url'] = site_url('backend/message/detail_admin/' . $message_id);
        $config['total_rows'] = $this->backend_message_model->get_detail_message($message_id, 0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 5;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['offset'] = $offset;
        $data['message_detail'] = $this->backend_message_model->get_detail_message($message_id, $offset, $limit)->result();
        
        template('backend', 'message/backend_message_to_admin_detail_view', $data);
    }
    
    function add(){
        $data['arr_breadcrumbs'] = array(
            'Data Pesan Admin' => 'backend/message/show_admin',
            'Buat Pesan Baru' => 'backend/message/add',
        );
        
        $data['form_action'] = 'backend_service/message/act_add';
        
        template('backend', 'message/backend_message_add_view', $data);
    }
    
}

?>
