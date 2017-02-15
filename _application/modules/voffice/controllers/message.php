<?php

/*
 * Member Message Controller
 *
 * @author	Yusuf Rahmanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Message extends Member_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('voffice/message_model');
        $this->load->helper('form');
    }
    
    function index(){
        $this->show();
    }
    
    function show(){
        $data['page_title'] = 'Data Pesan';
        $data['arr_breadcrumbs'] = array(
            'Data Pesan' => 'voffice/message/show',
        );
        
        template('member', 'voffice/message_list_view', $data);
    }
    
    function act_show() {
        $arr_output = array();
        $arr_output['message'] = '';
        $arr_output['message_class'] = '';

        //delete
        if ($this->input->post('delete') != FALSE) {
            $arr_item = json_decode($_POST['item']);
            if (is_array($arr_item)) {
                $item_deleted = $item_undeleted = 0;
                foreach ($arr_item as $id) {
                    $this->function_lib->delete_data('site_message', 'message_id', $id);
                    $this->function_lib->delete_data('site_message', 'message_par_id', $id);
                    $item_deleted++;
                }
                $arr_output['message'] = $item_deleted . ' data berhasil dihapus. ' . $item_undeleted . ' data gagal dihapus.';
                $arr_output['message_class'] = ($item_undeleted > 0) ? 'response_error alert alert-danger' : 'response_confirmation alert alert-success';
            } else {
                $arr_output['message'] = 'Anda belum memilih data.';
                $arr_output['message_class'] = 'response_error alert alert-danger';
            }
        }

        echo json_encode($arr_output);
    }
    
    function get_message_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "site_message";
        $params['where_detail'] = "
            (
                message_sender_network_id = '" . $this->session->userdata('network_id') . "' 
                OR message_receiver_network_id = '" . $this->session->userdata('network_id') . "'
            ) 
            AND message_par_id = '0'
        ";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);
        
        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            $last_message = $this->message_model->get_last_receive($row->message_id, $this->session->userdata('network_id'))->row();
            //is_read
            if ($last_message->message_is_read == '0' && $last_message->message_sender_network_id != $this->session->userdata('network_id')) {
                $stat = 'Pesan Baru';
                $image_stat = 'new-text.png';
            } else {
                $stat = 'Telah Dibaca';
                $image_stat = 'tick.png';
            }
            $is_read = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            //detail item
            $detail_item = '<a href="' . base_url() . 'voffice/message/detail/' . $row->message_id . '"><img src="' . base_url() . _dir_icon . 'window_image_small.png" border="0" alt="Data Detail" title="Lihat Data Detail" /></a>';

            if($row->message_sender_network_id == $this->session->userdata('network_id')) {
                $network_code = $this->mlm_function->get_network_code($row->message_receiver_network_id);
                $member_name = $this->mlm_function->get_member_name($row->message_receiver_network_id);
                
                if($row->message_receiver_network_id == '0'){
                    $network_code = 'Admin';
                    $member_name = 'Administrator';
                }
            }
            else {
                $network_code = $this->mlm_function->get_network_code($row->message_sender_network_id);
                $member_name = $this->mlm_function->get_member_name($row->message_sender_network_id);
                
                if($row->message_sender_network_id == '0'){
                    $network_code = 'Admin';
                    $member_name = 'Administrator';
                }
            }
            
            $entry = array('id' => $row->message_id,
                'cell' => array(
                    'message_id' => $row->message_id,
                    'network_code' => ($last_message->message_is_read == '0' && $last_message->message_sender_network_id != $this->session->userdata('network_id')) ? '<strong>' . $network_code . '</strong>' : $network_code,
                    'member_name' => ($last_message->message_is_read == '0' && $last_message->message_sender_network_id != $this->session->userdata('network_id')) ? '<strong>' . $member_name . '</strong>' : $member_name,
                    'message_subject' => ($last_message->message_is_read == '0' && $last_message->message_sender_network_id != $this->session->userdata('network_id')) ? '<strong>' . $row->message_title . '</strong>' : $row->message_title,
                    'message_input_datetime' => ($last_message->message_is_read == '0' && $last_message->message_sender_network_id != $this->session->userdata('network_id')) ? '<strong>' . convert_datetime($row->message_input_datetime, 'id') . '</strong>' : convert_datetime($row->message_input_datetime, 'id'),
                    'message_is_read' => $is_read,
                    'detail_item' => $detail_item
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function detail($message_id = ''){
        $data['page_title'] = 'Data Detail Pesan';
        $data['arr_breadcrumbs'] = array(
            'Data Pesan' => 'voffice/message/show',
            'Detail Pesan' => 'voffice/message/detail',
        );
        
        $data['form_action'] = 'voffice/message/act_add';
        $data['message_id'] = $message_id;
        
        $parent_message = $this->message_model->get_parent_message($message_id)->row();
        $data['parent_message_title'] = $parent_message->message_title;
        
        //cek apakah member sebagai pengirim atau penerimanya
        if($parent_message->message_sender_network_id == $this->session->userdata('network_id')){
            $responder = $parent_message->message_receiver_network_id;
            $member_id = $parent_message->message_sender_network_id;
        }
        else{
            $responder = $parent_message->message_sender_network_id;
            $member_id = $parent_message->message_receiver_network_id;
        }
        
        if($responder != 0) {
            $data['responder_code'] = $this->mlm_function->get_network_code($responder);
            $data['responder_name'] =  $this->mlm_function->get_member_name($responder);
        }
        else {
            $data['responder_code'] = 'Admin';
            $data['responder_name'] = 'Administrator';
        }
        
        //validasi pengintip pesan orang
        if($member_id != $this->session->userdata('network_id')) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Maaf, anda tidak diijinkan melihat isi pesan.</div>');
            redirect('voffice/message/show');
        }
        
        $cek_last = $this->message_model->get_last_message($message_id)->row();
        if($cek_last->message_receiver_network_id == $this->session->userdata('network_id')){
            $data_update = array('message_is_read' => '1');
            $this->function_lib->update_data('site_message', 'message_id', $message_id, $data_update);
            $this->function_lib->update_data('site_message', 'message_par_id', $message_id, $data_update);
        }
                
        //pagination
        $this->load->library('pagination');
        $offset = (int) $this->uri->segment(5, 0);
        $limit = 10;
        $config['base_url'] = site_url('voffice/message/detail/' . $message_id);
        $config['total_rows'] = $this->message_model->get_detail_message($message_id, 0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 5;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['offset'] = $offset;
        $data['message_detail'] = $this->message_model->get_detail_message($message_id, $offset, $limit)->result();
        
        template('member', 'voffice/message_detail_view', $data);
    }
    
    function add(){
        $data['page_title'] = 'Kirim Pesan Baru';
        $data['arr_breadcrumbs'] = array(
            'Data Pesan' => 'voffice/message/show',
            'Kirim Pesan Baru' => 'voffice/message/add',
        );
        
        $data['form_action'] = 'voffice/message/act_add';
        
        template('member', 'voffice/message_add_view', $data);
    }
    
    function act_add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('network_code', '<b>Kode Member</b>', 'required|callback_check_network');
        $this->form_validation->set_rules('content', '<b>Isi Pesan</b>', 'required');
        // VALIDASI PIN SERIAL
        $this->form_validation->set_rules('validate_pin', '<b>PIN Serial</b>', 'required|callback_validate_pin');

        if ($this->form_validation->run($this) == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_type', $this->input->post('type'));
            $this->session->set_flashdata('input_network_code', $this->input->post('network_code'));
            $this->session->set_flashdata('input_title', $this->input->post('message_title'));
            $this->session->set_flashdata('input_content', $this->input->post('content'));
            redirect($this->input->post('uri_string'));
        } else {
            $message_title = $this->input->post('message_title');
            $message_receiver = ($this->input->post('type') == 'member') ? $this->mlm_function->get_network_id($this->input->post('network_code')) : 0;
            $message_content = $this->input->post('content');

            $data = array();
            $data['message_par_id'] = $this->input->post('message_par_id');
            $data['message_sender_network_id'] = $this->session->userdata('network_id');
            $data['message_receiver_network_id'] = $message_receiver;
            $data['message_title'] = $message_title;
            $data['message_content'] = $message_content;
            $data['message_is_read'] = '0';
            $data['message_input_datetime'] = date("Y-m-d H:i:s");
            $this->function_lib->insert_data('site_message', $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Data berhasil disimpan.</div>');
            redirect($this->input->post('uri_string'));
        }
    }
    
    function check_network($value){
        if($value == 'Admin'){
            return true;
        }
        else{
            $cek_id = $this->mlm_function->get_network_id($value);
            if(empty($cek_id)) {
                $this->form_validation->set_message('check_network','Member tidak terdaftar');
                return false;
            } else {
                if ($cek_id == $this->session->userdata('network_id')) {
                    $this->form_validation->set_message('check_network','Tidak bisa mengirim pesan ke anda sendiri');
                    return false;
                } else {
                    return true;
                }
            }
        }
    }
    
    public function get_message_unread_count() {
        $arr_output = array();
        $network_id = $this->session->userdata('network_id');
        $this->load->model('voffice/message_model');
        $arr_output['count'] = $this->message_model->get_message_unread_count($network_id);
        echo json_encode($arr_output);
    }

    public function validate_pin($pin) {
        $this->load->model('voffice/systems_model');
        $is_valid = $this->systems_model->check_pin($this->session->userdata('network_id'), $pin);
        if ($is_valid) {
            return true;
        } else {
            $this->form_validation->set_message('validate_pin', '<b>PIN Serial</b> salah.');
            return false;
        }
    }
}
