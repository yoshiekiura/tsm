<?php

/*
 * MLM Netgrow Gen Sponsor Libraries
 *
 * @author  Yusuf Rahmanto
 * @copyright Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Netgrow_gen_sponsor {

    var $CI = null;
    protected $db;
    protected $network_id;
    protected $date;
    protected $max_level;

    //tambahan +> network id yang melakukan registrasi
    protected $downline_network_id;
    //akhir tambahan

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->library(array('function_lib', 'mlm_function'));
    }
    
    /*
     * Method untuk eksekusi generasi sponsor
     */
    public function execute() {
       $level = 1;

       // ==== script asli ====
       // $sponsor_id = $this->CI->function_lib->get_one('sys_network', 'network_sponsor_network_id', array('network_id' => $this->network_id));
       // while ($level <= $this->max_level && $sponsor_id != 0) {
       //     $sql_insert = "INSERT INTO sys_netgrow_gen_sponsor SET netgrow_gen_sponsor_network_id = '" . $sponsor_id . "', netgrow_gen_sponsor_downline_network_id = '" . $this->network_id . "',
       //                    netgrow_gen_sponsor_level = '" . $level . "', netgrow_gen_sponsor_date = '" . $this->date . "'";
       //     $this->CI->db->query($sql_insert);
       //     //cari generasi diatasnya
       //     $sponsor_id = $this->CI->function_lib->get_one('sys_network', 'network_sponsor_network_id', array('network_id' => $sponsor_id));

       //     $level++;
       // }
       // === akhir script asli ====



       // === script baru ===
       $sponsor_id = $this->network_id;
       $sponsor_id_level_1 = $this->downline_network_id;
       
       $member_parent_network_id = $this->CI->function_lib->get_one('sys_network_group','network_group_parent_network_id', array('network_group_member_network_id' => $this->downline_network_id));
       $sponsor_parent_network_id = $this->CI->function_lib->get_one('sys_network_group','network_group_parent_network_id', array('network_group_member_network_id' => $sponsor_id));

        while ($level <= $this->max_level && $sponsor_id != 0) {

            if($sponsor_parent_network_id != $member_parent_network_id) {
                $data = array();
                $data['netgrow_gen_sponsor_network_id'] = $sponsor_id;
                $data['netgrow_gen_sponsor_downline_network_id'] = $sponsor_id_level_1;
                $data['netgrow_gen_sponsor_downline_downline_network_id'] = $this->downline_network_id;
                $data['netgrow_gen_sponsor_level'] = $level;
                $data['netgrow_gen_sponsor_date'] = $this->date;
                $this->CI->function_lib->insert_data('sys_netgrow_gen_sponsor', $data);
            }

            $sponsor_id_level_1 = $sponsor_id;
            $sponsor_id = $this->CI->function_lib->get_one('sys_network', 'network_sponsor_network_id', array('network_id' => $sponsor_id));
            $sponsor_parent_network_id = $this->CI->function_lib->get_one('sys_network_group','network_group_parent_network_id', array('network_group_member_network_id' => $sponsor_id));
            $level++;
        }
          

        // ==== akhir script baru ====
    }
    
    
    /* -------------------------------------------------------------------------
     * setter
     * -------------------------------------------------------------------------
     */
    public function set_network_id($network_id) {
        $this->network_id = $network_id;
    }

    public function set_date($date) {
        $this->date = $date;
        return $this;
    }

    public function set_max_level($max_level) {
        $this->max_level = $max_level;
        return $this;
    }

    // tambahan
    public function set_downline_network_id($network_id) {
        $this->downline_network_id = $network_id;
    }
    // akhir tambahan

}

?>