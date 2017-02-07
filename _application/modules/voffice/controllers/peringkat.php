<?php

/*
 * Report Peringkat Controller
 *
 * @author	Yudha Wirawan S
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class peringkat extends Member_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('voffice/peringkat_model');
        $this->load->library(array('encrypt'));
        $this->config->load('key');
    }

    public function index() {
        $this->show();
    }

    public function decode() {
        $sql = "SELECT network_code, member_account_username, member_name, member_mobilephone,member_account_password, IFNULL(member_detail_email, '-' ) as email  
            FROM sys_member_account
            INNER JOIN sys_member ON member_network_id = member_account_network_id
            INNER JOIN sys_member_detail on member_detail_network_id = member_network_id
            INNER JOIN sys_network ON network_id = member_network_id
            ";
        $query = $this->CI->db->query($sql);

        $pass = 'NAazV+96jPPG4QycIHH6qoaGUm+8sxP+ylBLOcLeTQlzAiSvTaWX9pJavoxVPyC9ZQcrAQMvo+fEsOB304QvhA==';
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
//                echo $row->network_code .' | '. $row->member_account_username .' | ' .$row->member_name . ' | '
//                        .$row->member_mobilephone . ' | ' . $row->email . ' | '
//                        . $this->encrypt->decode($row->member_account_password,$this->config->item('key_member'));
//                echo "<br>";
                echo $this->encrypt->decode($pass,$this->config->item('key_member'));
                die();  
                echo "<br>";
            }
        }
    }

    function show() {
        $data['page_title'] = 'Peringkat Downline';
        $data['arr_breadcrumbs'] = array(
            'Peringkat' => '#',
            'Data Peringkat Downline' => 'voffice/peringkat/show',
        );
        $data['peringkat'] = $this->peringkat_model->get_data($this->session->userdata('network_id'));


        template('member', 'voffice/peringkat_main_view', $data);
    }
    
    function get_ip_addres(){
        $url = 'http://greentravellink.apiswitcher.com/api/ipaddress';        
        $params['request_ip_address'] = TRUE;

        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_POST, 1);

        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($params));

        curl_setopt($curlHandle, CURLOPT_HEADER, 0);

        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        

        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);

        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($curlHandle);
        
        curl_close($curlHandle);

        $sXML = simplexml_load_string($response);

        $ipaddress =  $sXML->res_data->ip_address;

        return 'IP ADDRESS ANDA : '.$ipaddress;        
    }
    

}
