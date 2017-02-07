<?php

/*
 * MLM Netgrow Level Match Libraries
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Netgrow_level_match {

    var $CI = null;
    protected $date;
    protected $add_level_match_depend = array();

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->library(array('function_lib', 'mlm_function'));
    }
    
    /*
     * Method untuk meng-handle dependensi pasangan level
     * @param Array $arr_class_name
     */
    public function add_level_match_depend($arr_class_name) {
        foreach ($arr_class_name as $class_name => $config) {
            include_once($class_name . ".php");
            $this->add_level_match_depend[$class_name] = $config;
            $this->$class_name = new $class_name;
        }
    }
    
    /*
     * Method untuk eksekusi penghitungan pasangan level
     */
    public function execute() {
        //cari data netgrow node hari ini
        $sql = "SELECT * FROM sys_netgrow_node WHERE netgrow_node_date = '" . $this->date . "'";
        $query = $this->CI->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $network_id = $row->netgrow_node_network_id;
                $position = $row->netgrow_node_position;
                $level = $row->netgrow_node_level;
                if ($position == 'L') {
                    $cross_position = 'R';
                } else {
                    $cross_position = 'L';
                }

                //cari data di level yang sama, tapi posisi yang beda
                $sql_cross = "
                    SELECT 1 
                    FROM sys_netgrow_node 
                    WHERE netgrow_node_network_id = '" . $network_id . "' 
                    AND netgrow_node_position = '" . $cross_position . "' 
                    AND netgrow_node_level = '" . $level . "'
                ";
                $query_cross = $this->CI->db->query($sql_cross);
                if ($query_cross->num_rows() > 0) {
                    //cek apakah sudah mendapat bonus pasangan level pada level tsb
                    $sql_check = "
                        SELECT 1 
                        FROM sys_netgrow_level_match 
                        WHERE netgrow_level_match_network_id = '" . $network_id . "' 
                        AND netgrow_level_match_level = '" . $level . "'
                    ";
                    $query_check = $this->CI->db->query($sql_check);

                    //jika tidak ada, maka mendapat bonus pasangan level
                    if ($query_check->num_rows() == 0) {
                        $sql_insert = "
                            INSERT INTO sys_netgrow_level_match 
                            SET netgrow_level_match_network_id = '" . $network_id . "', 
                            netgrow_level_match_level = '" . $level . "', 
                            netgrow_level_match_date = '" . $this->date . "'
                        ";
                        $this->CI->db->query($sql_insert);
                        
                        //generate dependensi terhadap pasangan level
                        if (count($this->add_level_match_depend) > 0) {
                            foreach ($this->add_level_match_depend as $class_name => $config) {
                                $this->$class_name->set_network_id($network_id);
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
            }
        }
    }
    
    
    /* -------------------------------------------------------------------------
     * setter
     * -------------------------------------------------------------------------
     */
    public function set_date($date) {
        $this->date = $date;
        return $this;
    }

}

?>