<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of check_crosline
 *
 * @author mang_haku
 * @copyright (c) year, ESD
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class check_crosline extends MY_Controller{
    function __construct() {
        parent::__construct();
        
        error_reporting(E_ALL);
        
    }
    
    function index() {
        $sql = 'SELECT network_id, network_sponsor_network_id, network_upline_network_id
            FROM sys_network
            ';
        
        $arr_member = $this->db->query($sql);
        
        if($arr_member->num_rows() >0){
            foreach ($arr_member->result() as $row) {
                $upline_network_code = $this->mlm_function->get_network_code($row->network_upline_network_id);
                $sponsor_network_code = $this->mlm_function->get_network_code($row->network_sponsor_network_id);
                $is_crossline = $this->mlm_function->check_uplink($upline_network_code, $sponsor_network_code);
                
                if(!$is_crossline) {
                    echo $row->network_id . ' Crossline <br>';
                }
            }
        }
    }
}
