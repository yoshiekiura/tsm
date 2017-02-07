<?php

/*
 * MLM Netgrow Node Libraries
 *
 * @author	Yusuf Rahmanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Netgrow_node {
    
    var $CI = null;
    protected static $_instance;
    protected $db;
    protected $network_id;
    protected $date;
    protected $class_name;
    protected $add_node_depend = array();
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->library(array('function_lib', 'mlm_function'));
    }
    
    /*
     * Method untuk meng-handle dependensi titik
     * @param Array $arr_class_name
     */
    public function add_node_depend($arr_class_name) {
       foreach ($arr_class_name as $class_name => $config) {
           include_once($class_name . ".php");
           $this->add_node_depend[$class_name] = $config;
           $this->$class_name = new $class_name;
       }
    }
    
    /*
     * Method untuk eksekusi update jaringan ke atas
     */
    public function execute() {
        $this->upline_network_id = $this->CI->mlm_function->get_upline_network_id($this->network_id);
        $this->update_node($this->network_id, $this->upline_network_id, $this->date, 1);

        //generate dependensi terhadap node
        if (count($this->add_node_depend) > 0) {
            foreach ($this->add_node_depend as $class_name => $config) {
                $this->$class_name->set_network_id($this->upline_network_id);
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
    
    
    /* -------------------------------------------------------------------------
     * setter
     * -------------------------------------------------------------------------
     */
    public function set_network_id($network_id) {
        $this->network_id = $network_id;
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
    private function update_node($network_id, $upline_network_id, $date, $level) {
        $sql_network = "SELECT * FROM sys_network WHERE network_id = '" . $upline_network_id . "' LIMIT 1";
        $row_network = $this->CI->db->query($sql_network)->row_array();
        if ($row_network) {
            $next_upline_network_id = $row_network['network_upline_network_id'];
            $position = ($row_network['network_right_node_network_id'] == $network_id) ? 'R' : 'L';
            $position_text = ($position == 'L') ? 'left' : 'right';
            
            //cek netgrow hari ini
            //jika ada, maka update
            //jika tidak ada, maka insert
            $sql_netgrow = "
                SELECT * 
                FROM sys_netgrow_master 
                WHERE netgrow_master_network_id = '" . $upline_network_id . "' 
                AND netgrow_master_date = '" . $date . "'
            ";
            $row_netgrow = $this->CI->db->query($sql_netgrow)->row_array();
            if ($row_netgrow) {
                //update
                $sql_update_netgrow = "
                    UPDATE sys_netgrow_master 
                    SET netgrow_master_node_" . $position_text . " = netgrow_master_node_" . $position_text . " + 1 
                    WHERE netgrow_master_network_id = '" . $upline_network_id . "' 
                    AND netgrow_master_date = '" . $date . "'
                ";
            } else {
                //insert
                $sql_update_netgrow = "
                    INSERT INTO sys_netgrow_master 
                    SET netgrow_master_node_" . $position_text . " = 1, 
                    netgrow_master_date = '" . $date . "', 
                    netgrow_master_network_id = '" . $upline_network_id . "'
                ";
            }
            $this->CI->db->query($sql_update_netgrow);
            
            //update total titik upline-nya
            $sql_update_network = "
                UPDATE sys_network 
                SET 
                    network_total_downline_" . $position_text . " = network_total_downline_" . $position_text . " + 1 ,
                    network_total_reward_node_" . $position_text . " = network_total_reward_node_" . $position_text . " + 1 
                WHERE network_id = '" . $upline_network_id . "'
            ";
            $this->CI->db->query($sql_update_network);
            
            //insert ke netgrow node
            $sql_insert_netgrow_node = "
                INSERT INTO sys_netgrow_node 
                SET netgrow_node_network_id = '" . $upline_network_id . "', 
                netgrow_node_downline_network_id = '" . $this->network_id . "', 
                netgrow_node_position = '" . $position . "', 
                netgrow_node_level = '" . $level . "', 
                netgrow_node_date = '" . $date . "'
            ";
            $this->CI->db->query($sql_insert_netgrow_node);
            
            $level++;
            $this->update_node($upline_network_id, $next_upline_network_id, $date, $level);
        }
    }
    
    /*
     * Method static singelton buat
     */
    public static function get_instance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new netgrow_node;
        }
        return self::$_instance;  
    }
}

?>