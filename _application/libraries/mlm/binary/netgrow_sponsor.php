<?php

/*
 * MLM Netgrow Sponsor Libraries
 *
 * @author  Yusuf Rahmanto
 * @copyright   Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Netgrow_sponsor {

    var $CI = null;
    protected $db;
    protected $network_id;
    protected $date;
    protected $add_sponsor_depend = array();
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->library(array('function_lib', 'mlm_function'));
    }
    
    /*
     * Method untuk meng-handle dependensi sponsor
     * @param Array $arr_class_name
     */
    public function add_sponsor_depend($arr_class_name) {
        foreach ($arr_class_name as $class_name => $config) {
            include_once($class_name . ".php");
            $this->add_sponsor_depend[$class_name] = $config;
            $this->$class_name = new $class_name;
        }
    }
    
    /*
     * Method untuk eksekusi sponsoring
     */
    public function execute() {
        if ($this->sponsor_network_id != 0) {
            $arr_sponsor_position = $this->get_sponsor_position();
            $sql_insert = "
                INSERT INTO sys_netgrow_sponsor SET 
                netgrow_sponsor_network_id = '" . $this->sponsor_network_id . "', 
                netgrow_sponsor_downline_network_id = '" . $this->network_id . "',
                netgrow_sponsor_position = '" . $arr_sponsor_position['position'] . "',
                netgrow_sponsor_level = '" . $arr_sponsor_position['level'] . "',
                netgrow_sponsor_date = '" . $this->date . "'
            ";
            $this->CI->db->query($sql_insert);
                
            //generate dependensi terhadap sponsor
            if (count($this->add_sponsor_depend) > 0) {
                foreach ($this->add_sponsor_depend as $class_name => $config) {
                    $this->$class_name->set_network_id($this->sponsor_network_id);
                    // tambahan
                    $this->$class_name->set_downline_network_id($this->network_id);
                    //akhir tambahan
                    $this->$class_name->set_date($this->date);
                    
                    //cek jika mengandung gen maka harus ada config level
                    preg_match("/gen/", strval($class_name), $matches);
                    if (!empty($matches)) {
                        $this->$class_name->set_max_level($config['level']);
                    }
                    $this->$class_name->execute();
                }
            }
        }
    }
    
    
    /* -------------------------------------------------------------------------
     * setter
     * -------------------------------------------------------------------------
     */
    public function set_network_id($network_id) {
        $this->network_id = $network_id;
        $this->sponsor_network_id = $this->CI->mlm_function->get_sponsor_network_id($network_id);
        return $this;
    }
    
    public function set_date($date) {
        $this->date = $date;
        return $this;
    }
    
    
    /* -------------------------------------------------------------------------
     * callback
     * -------------------------------------------------------------------------
     */
    private function get_sponsor_position(){
        $upline_network_id = $this->network_id;
        $level = 0;
        do {
            $sql = "SELECT network_position, network_upline_network_id FROM sys_network WHERE network_id = '" . $upline_network_id . "' LIMIT 1";
            $query = $this->CI->db->query($sql);
            if($query->num_rows() > 0) {
                $row = $query->row();
                $position = $row->network_position;
                $upline_network_id = $row->network_upline_network_id;
                $level++;
            } else {
                break;
            }
        } while($upline_network_id !== 0 && $upline_network_id !== $this->sponsor_network_id);
        
        return array(
            'position' => $position,
            'level' => $level,
        );
    }
    
}

?>