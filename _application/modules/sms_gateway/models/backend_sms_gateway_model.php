<?php

/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of sms_gateway_model
 *
 * @author Yusuf Rahmanto
 */
class backend_sms_gateway_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function get_member_all() {
        $this->db->where('member_mobilephone !=', '');
        $result = $this->db->get('sys_member');
        if($result->num_rows() > 0) return $result->result();
        else return FALSE;
    }
    
    public function get_member_id_by_phone($phone) {
        $this->db->select('member_network_id');
        $this->db->where('member_mobilephone', $phone);
        $result = $this->db->get('sys_member');
        if($result->num_rows() > 0) {
            $data = $result->row();
            return $data->member_network_id;
        }
        else return 0;
    }
    public function get_phone_by_member_id($id) {
        $this->db->select('member_mobilephone');
        $this->db->where('member_network_id', $id);
        $result = $this->db->get('sys_member');
        if($result->num_rows() > 0) {
            $data = $result->row();
            return $data->member_mobilephone;
        }
        else return 0;
    }
    
    public function get_member_id_by_code($code) {
        $this->db->select('network_id');
        $this->db->where('network_code', $code);
        $result = $this->db->get('sys_network');
        if($result->num_rows() > 0) {
            $data = $result->row();
            return $data->network_id;
        }
        else return 0;
    }
    
    public function get_sms($where, $limit, $offset) {
        if(!empty($where)) $this->db->where($where, NULL, FALSE);
        $this->db->join('sys_network', 'sms_gateway_network_id=network_id', 'left');
        $this->db->join('sys_member', 'sms_gateway_network_id=member_network_id', 'left');
        $this->db->limit($limit, $offset);
        $result = $this->db->get('site_sms_gateway');
        if($result->num_rows() > 0) return $result->result_array();
        else return FALSE;
    }
    
    public function count_sms($where) {
        if(!empty($where)) $this->db->where($where, NULL, FALSE);
        $this->db->join('sys_network', 'sms_gateway_network_id=network_id', 'left');
        $this->db->join('sys_member', 'sms_gateway_network_id=member_network_id', 'left');
        return $this->db->count_all_results('site_sms_gateway');
    }
    
    public function delete_sms($sms_id) {
        $this->db->where('sms_gateway_id',$sms_id);
        $result = $this->db->delete('site_sms_gateway');
        return $result;
    }
    
    /*
     * =============================API ZenSiva=================================
     */
    public function send_sms($message, $telepon, $network_id='', $type='single') {

        $telepon = preg_replace("/^0/", "62", trim($telepon));
        $userkey = "cx7g4f"; // userkey lihat di zenziva

        $passkey = "esoftdream"; // set passkey di zenziva


        $url = "http://alpha.zenziva.com/apps/smsapi.php";

        $curlHandle = curl_init();

        curl_setopt($curlHandle, CURLOPT_URL, $url);

        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey=' . $userkey . '&passkey=' . $passkey . '&nohp=' . $telepon . '&pesan=' . urlencode($message));

        curl_setopt($curlHandle, CURLOPT_HEADER, 0);

        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);

        curl_setopt($curlHandle, CURLOPT_POST, 1);

        $response = curl_exec($curlHandle);
$xml_string = <<<XML
$response
XML;

        curl_close($curlHandle);
        
        $sXML = simplexml_load_string($xml_string);
        if(!empty($sXML)){
            if($sXML->message[0]->text == 'Success'){
                $this->insert_sms($message, $telepon, $network_id, $type);
                return TRUE;
            }
            else return FALSE;
        }
        else return FALSE;
    }
    //==========================================================================
    
    function insert_sms($message, $telepon, $network_id, $type){
        if(empty($network_id)){
            $result = $this->db->query("SELECT member_network_id FROM sys_member WHERE member_mobilephone = '{$telepon}' limit 1");
            if($result->num_rows() > 0) {
                $row = $result->row();
                $network_id = $row->member_network_id;
            }
            else $network_id = 0;
        }
        
        $data_insert = array('sms_gateway_network_id' => $network_id,
                             'sms_gateway_mobilephone' => $telepon,
                             'sms_gateway_content' => $message,
                             'sms_gateway_type' => $type,
                             'sms_gateway_datetime' => date("Y-m-d H:i:s"));
        $this->db->insert('site_sms_gateway', $data_insert);
    }
}

?>
