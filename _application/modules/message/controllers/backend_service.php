<?php

/*
 * Backend Service Message Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_service extends Backend_Service_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('backend_message_model');
        $this->load->helper('form');
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
        $params['select'] = "
            site_message.*, 
            sender_network.network_code AS sender_network_code, 
            sender_member.member_name AS sender_member_name, 
            receiver_network.network_code AS receiver_network_code, 
            receiver_member.member_name AS receiver_member_name 
        ";
        $params['join'] = "
            INNER JOIN sys_network sender_network ON sender_network.network_id = message_sender_network_id 
            INNER JOIN sys_member sender_member ON sender_member.member_network_id = message_sender_network_id 
            INNER JOIN sys_network receiver_network ON receiver_network.network_id = message_receiver_network_id 
            INNER JOIN sys_member receiver_member ON receiver_member.member_network_id = message_receiver_network_id 
        ";
        $params['where_detail'] = "
            message_sender_network_id != '0' 
            AND message_receiver_network_id != '0'
            AND message_par_id = '0'
        ";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);
        
        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //is_read
            $last_message = $this->backend_message_model->get_last_message($row->message_id)->row();
            if ($last_message->message_is_read == '0' && $last_message->message_par_id != '0') {
                $stat = 'Pesan Baru';
                $image_stat = 'new-text.png';
            } else {
                $stat = 'Telah Dibaca';
                $image_stat = 'tick.png';
            }
            $is_read = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            //detail item
            $detail_item = '<a href="' . base_url() . 'backend/message/detail/' . $row->message_id . '"><img src="' . base_url() . _dir_icon . 'window_image_small.png" border="0" alt="Data Detail" title="Lihat Data Detail" /></a>';

            $entry = array('id' => $row->message_id,
                'cell' => array(
                    'message_id' => $row->message_id,
                    'sender_network_code' => ($last_message->message_is_read == '0' && $last_message->message_par_id != '0') ? '<strong>' . $row->sender_network_code . '</strong>' : $row->sender_network_code,
                    'sender_member_name' => ($last_message->message_is_read == '0' && $last_message->message_par_id != '0') ? '<strong>' . $row->sender_member_name . '</strong>' : $row->sender_member_name,
                    'receiver_network_code' => ($last_message->message_is_read == '0' && $last_message->message_par_id != '0') ? '<strong>' . $row->receiver_network_code . '</strong>' : $row->receiver_network_code,
                    'receiver_member_name' => ($last_message->message_is_read == '0' && $last_message->message_par_id != '0') ? '<strong>' . $row->receiver_member_name . '</strong>' : $row->receiver_member_name,
                    'message_subject' => ($last_message->message_is_read == '0' && $last_message->message_par_id != '0') ? '<strong>' . $row->message_title . '</strong>' : $row->message_title,
                    'message_input_datetime' => ($last_message->message_is_read == '0' && $last_message->message_par_id != '0') ? '<strong>' . convert_datetime($row->message_input_datetime, 'id') . '</strong>' : convert_datetime($row->message_input_datetime, 'id'),
                    'message_is_read' => $is_read,
                    'detail_item' => $detail_item
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function get_message_admin_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "site_message";
        $params['select'] = "
            site_message.*, 
            IFNULL(sender_network.network_code, 'Admin') AS sender_network_code, 
            IFNULL(sender_member.member_name, 'Administrator') AS sender_member_name, 
            IFNULL(receiver_network.network_code, 'Admin') AS receiver_network_code, 
            IFNULL(receiver_member.member_name, 'Administrator') AS receiver_member_name 
        ";
        $params['join'] = "
            LEFT JOIN sys_network sender_network ON sender_network.network_id = message_sender_network_id 
            LEFT JOIN sys_member sender_member ON sender_member.member_network_id = message_sender_network_id 
            LEFT JOIN sys_network receiver_network ON receiver_network.network_id = message_receiver_network_id 
            LEFT JOIN sys_member receiver_member ON receiver_member.member_network_id = message_receiver_network_id 
        ";
        $params['where_detail'] = "
            (
                message_sender_network_id = '0' 
                OR message_receiver_network_id = '0'
            ) 
            AND message_par_id = '0'
        ";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);
        
        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {

            //is_read
            $last_message = $this->backend_message_model->get_last_receive($row->message_id, 0)->row();
            if ($last_message->message_is_read == '0' && $last_message->message_sender_network_id != '0') {
                $stat = 'Pesan Baru';
                $image_stat = 'new-text.png';
            } else {
                $stat = 'Telah Dibaca';
                $image_stat = 'tick.png';
            }
            $is_read = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            //detail item
            $detail_item = '<a href="' . base_url() . 'backend/message/detail_admin/' . $row->message_id . '"><img src="' . base_url() . _dir_icon . 'window_image_small.png" border="0" alt="Data Detail" title="Lihat Data Detail" /></a>';

            $entry = array('id' => $row->message_id,
                'cell' => array(
                    'message_id' => $row->message_id,
                    'sender_network_code' => ($last_message->message_is_read == '0' && $last_message->message_sender_network_id != '0') ? '<strong>' . $row->sender_network_code . '</strong>' : $row->sender_network_code,
                    'sender_member_name' => ($last_message->message_is_read == '0' && $last_message->message_sender_network_id != '0') ? '<strong>' . $row->sender_member_name . '</strong>' : $row->sender_member_name,
                    'receiver_network_code' => ($last_message->message_is_read == '0' && $last_message->message_sender_network_id != '0') ? '<strong>' . $row->receiver_network_code . '</strong>' : $row->receiver_network_code,
                    'receiver_member_name' => ($last_message->message_is_read == '0' && $last_message->message_sender_network_id != '0') ? '<strong>' . $row->receiver_member_name . '</strong>' : $row->receiver_member_name,
                    'message_subject' => ($last_message->message_is_read == '0' && $last_message->message_sender_network_id != '0') ? '<strong>' . $row->message_title . '</strong>' : $row->message_title,
                    'message_input_datetime' => ($last_message->message_is_read == '0' && $last_message->message_sender_network_id != '0') ? '<strong>' . convert_datetime($row->message_input_datetime, 'id') . '</strong>' : convert_datetime($row->message_input_datetime, 'id'),
                    'message_is_read' => $is_read,
                    'detail_item' => $detail_item
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    
    function act_add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('network_code', '<b>Kode Member</b>', 'required|callback_check_network');
        $this->form_validation->set_rules('content', '<b>Isi Pesan</b>', 'required');

        if ($this->form_validation->run($this) == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_net_code', $this->input->post('network_code'));
            $this->session->set_flashdata('input_title', $this->input->post('message_title'));
            $this->session->set_flashdata('input_content', $this->input->post('content'));
            redirect($this->input->post('uri_string'));
        } else {
            $message_title = $this->input->post('message_title');
            $message_receive = $this->mlm_function->get_network_id($this->input->post('network_code'));
            $message_content = $this->input->post('content');

            $data = array();
            $data['message_par_id'] = $this->input->post('message_par_id');
            $data['message_sender_network_id'] = 0;
            $data['message_receiver_network_id'] = $message_receive;
            $data['message_title'] = $message_title;
            $data['message_content'] = $message_content;
            $data['message_is_read'] = '0';
            $data['message_input_datetime'] = date("Y-m-d H:i:s");
            $this->function_lib->insert_data('site_message', $data);
            
            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Pesan berhasil dikirim.</div>');
            redirect($this->input->post('uri_string'));
        }
    }
    
    function check_network($value){
        $cek_id = $this->mlm_function->get_network_id($value);
        if(empty($cek_id))
        {
            $this->form_validation->set_message('check_network', 'Member tidak terdaftar');
            return false;
        }
        else return true;
    }
}

?>
