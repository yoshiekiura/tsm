<?php

/*
 * Member Transfer Ewallet Controller
 *
 * @author	Yudha Wirawan S
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Transfer_ewallet extends Member_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('voffice/transfer_ewallet_model');
    }
    
    public function index() {
        $this->show();
    }
    
    function show() {
        $data['arr_breadcrumbs'] = array(
            'Transfer ewallet' => 'voffice/transfer_ewallet/add',
        );
        
        $data['form_action'] = 'voffice/transfer_ewallet/act_add';
        
        template('member', 'voffice/transfer_ewallet_view', $data);

    }

    function act_add(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ewallet_transfer_log_network_id_transfer', '<b>Kode Member</b>', 'required|callback_check_network');
        $this->form_validation->set_rules('ewallet_transfer_log_value', '<b>Nominal Transfer</b>', 'required|callback_check_nominal');
        $this->form_validation->set_rules('pin', '<b>Pin</b>', 'required|callback_check_pin');


        if ($this->form_validation->run($this) == FALSE) {
            $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
            $this->session->set_flashdata('input_kode_member', $this->input->post('ewallet_transfer_log_network_id_transfer'));
            $this->session->set_flashdata('input_nominal_transfer', $this->input->post('ewallet_transfer_log_value'));
            $this->session->set_flashdata('input_pin', $this->input->post('pin'));
            redirect($this->input->post('uri_string'));
        } else {
            $network_id = $this->session->userdata('network_id');
            $network_id_transfer = $this->mlm_function->get_network_id($this->input->post('ewallet_transfer_log_network_id_transfer'));
            $ewallet_transfer_log_value = $this->input->post('ewallet_transfer_log_value');
            $transfer_value = substr(str_replace('.', '', $ewallet_transfer_log_value), 0, strlen(str_replace('.', '', $ewallet_transfer_log_value)) - 3);

            $data = array();
            $data['ewallet_transfer_log_network_id'] = $network_id;
            $data['ewallet_transfer_log_network_id_transfer'] = $network_id_transfer;
            $data['ewallet_transfer_log_value'] = $ewallet_transfer_log_value;
            $data['ewallet_transfer_log_datetime'] = date("Y-m-d H:i:s");
            $this->function_lib->insert_data('sys_ewallet_transfer_log', $data);

            //update ewallet yang mentransfer
             $sql_update_ewallet_product_network_id = "
                             UPDATE sys_ewallet_product
                             SET ewallet_product_balance = ewallet_product_balance - " . $transfer_value . " 
                             WHERE ewallet_product_network_id = '" . $network_id . "'";
                        $this->CI->db->query($sql_update_ewallet_product_network_id);     

            //update ewallet yang di transfer
            $sql_update_ewallet_product_network_id_transfer = "
                             UPDATE sys_ewallet_product
                             SET ewallet_product_balance = ewallet_product_balance + " . $transfer_value . " 
                             WHERE ewallet_product_network_id = '" . $network_id_transfer . "'";
                        $this->CI->db->query($sql_update_ewallet_product_network_id_transfer);    
            

            $this->session->set_flashdata('confirmation', '<div class="confirmation alert alert-success">Transfer Ewallet Berhasil, ewallet ditransfer sebesar : '.$ewallet_transfer_log_value.'.</div>');
            redirect($this->input->post('uri_string'));
        }
    }
    
    function check_network($value){
            $cek_id = $this->mlm_function->get_network_id($value);
            if(empty($cek_id))
            {
                $this->form_validation->set_message('check_network','Member tidak terdaftar');
                return false;
            }
            else return true;
        }

        function check_pin($value){
            $network_code = $this->session->userdata('network_code');
            $serial_pin = $this->function_lib->get_one('sys_serial','serial_pin','serial_network_code = "'.$network_code.'" AND serial_pin =' . $value);
           
            if($value != $serial_pin)
            {
                $this->form_validation->set_message('check_pin','Pin Anda Salah');
                return false;
            }
            else return true;
        }

        function check_nominal($value){
            $transfer_value = substr(str_replace('.', '', $value), 0, strlen(str_replace('.', '', $value)) - 3);

            $network_id = $this->session->userdata('network_id');
            $ewallet_value = $this->function_lib->get_one('sys_ewallet_product','ewallet_product_balance','ewallet_product_network_id =' . $network_id);
           
            if($transfer_value > $ewallet_value)
            {
                $this->form_validation->set_message('check_nominal','Saldo Anda tidak mencukupi');
                return false;
            }elseif($transfer_value < 50000){
                $this->form_validation->set_message('check_nominal','Minimal Nominal Transfer sebesar 50.000');
                return false;
            }
            else return true;
        }


}
