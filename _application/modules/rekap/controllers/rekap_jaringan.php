<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of rekap_jaringan
 *
 * @author mang_haku
 * @copyright (c) year, ESD
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rekap_jaringan extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function registrasi() {

        $sql = 'SELECT network_id, network_code, member_join_datetime, 
                date(member_join_datetime) as registration_date
                FROM sys_network
                INNER JOIN sys_member ON member_network_id = network_id
                ';


        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $this->rekap_platinum($row->network_id, $row->member_join_datetime, $row->registration_date);
            }
        }
    }

    function rekap_platinum($network_id, $datetime, $date) {
        $this->load->library('mlm/binary/netgrow_node', null, 'netgrow_node');
        $this->load->library('mlm/binary/netgrow_sponsor', null, 'netgrow_sponsor');
        $this->load->library('mlm/binary/netgrow_match', null, 'netgrow_match');
        $this->load->library('mlm/binary/netgrow_level_match', null, 'netgrow_level_match');


        $arr_netgrow = $this->mlm_function->get_arr_active_netgrow();

        $this->netgrow_node->set_network_id($network_id);
        $this->netgrow_node->set_date($date);

        //untuk set config masing-masing netgrow yang dependensi dengan titik
        $arr_node_depend_class = array();

        //generasi titik
        if (in_array('gen_node', $arr_netgrow)) {
            $arr_node_depend_class['netgrow_gen_node'] = $this->mlm_function->get_arr_netgrow_config('gen_node');
        }

        if (!empty($arr_node_depend_class)) {
            $this->netgrow_node->add_node_depend($arr_node_depend_class);
        }
        $this->netgrow_node->execute();

        // akhir netgrow node
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        // netgrow sponsor

        $this->netgrow_sponsor->set_network_id($network_id);
        $this->netgrow_sponsor->set_date($date);

        //untuk set config masing-masing netgrow yang dependensi dengan sponsor
        $arr_sponsor_depend_class = array();

        //generasi sponsor
        if (in_array('gen_sponsor', $arr_netgrow)) {
            $arr_sponsor_depend_class['netgrow_gen_sponsor'] = $this->mlm_function->get_arr_netgrow_config('gen_sponsor');
        }

        if (!empty($arr_sponsor_depend_class)) {
            $this->netgrow_sponsor->add_sponsor_depend($arr_sponsor_depend_class);
        }
        $this->netgrow_sponsor->execute();

        // akhir netgrow sponsor
        $match_config = $this->mlm_function->get_arr_netgrow_config('match');
        $this->netgrow_match->set_match_bool(true);
        $this->netgrow_match->set_flushout($match_config['flushout']);
        $this->netgrow_match->set_max_wait($match_config['max_wait']);
        $this->netgrow_match->set_date($date);

        //untuk set config masing-masing netgrow yang dependensi dengan pasangan
        $arr_match_depend_class = array();

        //generasi pasangan
        if (in_array('gen_match', $arr_netgrow)) {
            $arr_match_depend_class['netgrow_gen_match'] = $this->mlm_function->get_arr_netgrow_config('gen_match');
        }

        if (!empty($arr_match_depend_class)) {
            $this->netgrow_match->add_match_depend($arr_match_depend_class);
        }
        $this->netgrow_match->execute();

        // akhir netgrow match
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        // netgrow level match
       $this->netgrow_level_match->set_date($date);

       //untuk set config masing-masing netgrow yang dependensi dengan pasangan level
       $arr_level_match_depend_class = array();

       //generasi pasangan
       if (in_array('gen_level_match', $arr_netgrow)) {
           $arr_level_match_depend_class['netgrow_gen_level_match'] = $this->mlm_function->get_arr_netgrow_config('gen_level_match');
       }

       if (!empty($arr_level_match_depend_class)) {
           $this->netgrow_level_match->add_level_match_depend($arr_level_match_depend_class);
       }
       $this->netgrow_level_match->execute();
    }

}
