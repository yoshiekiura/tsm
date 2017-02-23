<?php

/*
 * MLM Function Libraries
 *
 * @author	Yusuf Rahmanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class mlm_function {
    
    var $CI = null;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
    }
    
    /**
     * function untuk mendapatkan network_id
     * @param String $network_code network_code member yang ingin di cari
     * @return String
     */
    function get_network_id($network_code = '') {
        return $this->CI->function_lib->get_one('sys_network', 'network_id', array('network_code' => $network_code));
    }
    
    /**
     * function untuk mendapatkan kode member
     * @param Int $network_id network_id member yang ingin di cari
     * @return String
     */
    function get_network_code($network_id = 0) {
        return $this->CI->function_lib->get_one('sys_network', 'network_code', array('network_id' => $network_id));
    }
    
    /**
     * function untuk mendapatkan network_id sponsor
     * @param String $network_id network_id member yang ingin di cari sponsor-nya
     * @return Int
     */
    function get_sponsor_network_id($network_id = '') {
        return $this->CI->function_lib->get_one('sys_network', 'network_sponsor_network_id', array('network_id' => $network_id));
    }
    
    /**
     * function untuk mendapatkan network_id upline
     * @param String $network_id network_id member yang ingin di cari upline-nya
     * @return Int
     */
    function get_upline_network_id($network_id = '') {
        return $this->CI->function_lib->get_one('sys_network', 'network_upline_network_id', array('network_id' => $network_id));
    }
    
    /**
     * function untuk mendapatkan level
     * @param Int $network_id network_id member yang ingin di cari
     * @param Int $from_network_id network_id upline
     * @return String
     */
    function get_network_level_value($network_id, $from_network_id) {
        return $this->CI->function_lib->get_one('sys_netgrow_node', 'netgrow_node_level', array('netgrow_node_network_id' => $from_network_id, 'netgrow_node_downline_network_id' => $network_id));
    }
    
    /**
     * function untuk mendapatkan nama member
     * @param Int $network_id network_id member yang ingin di cari
     * @return String
     */
    function get_member_name($network_id = 0) {
        return $this->CI->function_lib->get_one('sys_member', 'member_name', array('member_network_id' => $network_id));
    }
    
    function get_arr_member_detail($network_id = 0) {
        $sql = "SELECT * FROM view_member WHERE network_id = '" . $network_id . "' LIMIT 1";
        $query = $this->CI->db->query($sql);
        if($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    
    /**
     * function untuk mendapatkan nama member berdasarkan kode member
     * @param String $network_code network_code member yang ingin di cari
     * @return String
     */
    function get_member_name_by_network_code($network_code = '') {
        $member_name = '';
        $query = $this->CI->db->query("SELECT member_name FROM sys_member INNER JOIN sys_network ON network_id = member_network_id WHERE network_code = '" . $network_code . "'");
        if($query->num_rows() > 0) {
            $row = $query->row();
            $member_name = $row->member_name;
        }
        return $member_name;
    }
    
    function get_member_max_level($network_id, $position = '') {
        $where = "WHERE netgrow_node_network_id = '" . $network_id . "'";
        if($position != '') {
            $where .= " AND netgrow_node_position = '" . $position . "'";
        }
        $sql = "SELECT MAX(netgrow_node_level) AS max_level FROM sys_netgrow_node " . $where;
        $query = $this->CI->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            return $row->max_level;
        } else {
            return 0;
        }
    }
    
    function get_member_sponsoring_count($network_id, $position = '') {
        $where = "WHERE netgrow_sponsor_network_id = '" . $network_id . "'";
        if($position != '') {
            $where .= " AND netgrow_sponsor_position = '" . $position . "'";
        }
        $sql = "SELECT COUNT(netgrow_sponsor_id) AS sponsoring_count FROM sys_netgrow_sponsor " . $where;
        $query = $this->CI->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            return $row->sponsoring_count;
        } else {
            return 0;
        }
    }
    
    /**
     * function untuk cek apakah upline & sponsor sejalur
     * @param String $upline_network_code network_code member yang ingin di cek
     * @param String $sponsor_network_code network_code sponsor yang ingin di cek
     * @return Boolean
     */
    public function check_uplink($upline_network_code, $sponsor_network_code) {
        $upline_network_id = $this->get_network_id($upline_network_code);
        $sponsor_network_id = $this->get_network_id($sponsor_network_code);
        $result = false;
        do {
            if ($upline_network_id == $sponsor_network_id) {
                $result = true;
                break;
            }
            
            $upline_network_id = $this->CI->function_lib->get_one('sys_network', 'network_upline_network_id', array('network_id' => $upline_network_id));
            if ($upline_network_id == '') {
                break;
            }
        } while (!$result);
        
        return $result;
    }

    /**
     * function untuk mencari member yang paling bawah sebelah kiri
     * @param String $network_id network_id member yang ingin di cek
     * @param String $position posisi yang ingin di cek
     * @return String 
     */
    public static function get_last_node($network_id, $position = 'left') {
        $level = 0;
        while ($network_id != 0) {
            $level++;
            $last_network_id = $network_id;
            $downline_network_id = $this->CI->function_lib->get_one('sys_network', 'network_downline_' . $position . '_network_id', array('network_id' => $network_id));
            $network_id = $downline_network_id;
        }
        return $last_network_id . " " . $level;
    }

    /**
     * Method untuk mengekstrak kata, apakah ada gennya
     * @param String $words kata yang ingin dicari
     * @return String
     */
    public static function search_gen($words) {
        preg_match("/gen/", strval($words), $matches);
        if (!empty($matches)) {
            return 'gen';
        }
        else {
            return $words;
        }
    }

    /**
     * Method untuk update network node
     * @param Int $network_id network_id
     * @param Int $network_upline_network_id upline dari network_id-nya yang pengen diganti
     * @param String $from_network_level_status dari status level apa
     * @param String $to_network_level_status menuju level status apa
     */
    public static function update_network_level_status($network_id, $network_upline_network_id, $from_network_level_status, $to_network_level_status) {
        $sql_update = "";
        $position = "";
        $network = $this->CI->db->query("SELECT * FROM sys_network WHERE network_id = '" . $network_upline_network_id . "'")->row_array();
        if ($network) {
            if($network['network_downline_left_network_id'] == $network_id) {
                //posisi di kiri
                $position = "left";
            } else {
                $position = "right";
            }
            $sql_update = "SET network_node_".$to_network_level_status."_".$position." = network_node_".$to_network_level_status."_".$position." + 1, 
                           network_node_".$from_network_level_status."_".$position." = network_node_".$from_network_level_status."_".$position." - 1";
            //tambahkan dan hapus level statusnya
            if($from_network_level_status == 'passive') {
                $sql_update .= ",network_node_active_".$position." = network_node_active_".$position." + 1";
            }
            $this->CI->db->query("UPDATE sys_network_node ".$sql_update." WHERE network_node_network_id = '".$network_upline_network_id."'");
            //rekursif
            $network_upline_network_id_next = $network['network_upline_network_id'];
            self::update_network_level_status($network_upline_network_id, $network_upline_network_id_next, $from_network_level_status, $to_network_level_status);
        }
    }

    /**
     * function untuk mendapatkan jumlah hu serial
     * @return Query
     */
    function get_serial_type_node($serial_id = '') {
        $sql = "
            SELECT serial_type_node 
            FROM sys_serial_type 
            INNER JOIN sys_serial ON serial_serial_type_id = serial_type_id 
            WHERE serial_id = '" . $serial_id . "'
        ";
        $query = $this->CI->db->query($sql);
        $serial_type_node = 1;
        if($query->num_rows() > 0) {
            $row = $query->row();
            $serial_type_node = $row->serial_type_node;
        }
        return $serial_type_node;
    }

    /**
     * function untuk list tipe serial
     * @return Query
     */
    function get_list_serial_type() {
        $sql = "SELECT * FROM sys_serial_type WHERE serial_type_is_active = '1' ORDER BY serial_type_node ASC, serial_type_label ASC";
        return $this->CI->db->query($sql);
    }

    /**
     * function untuk mendapatkan jumlah tipe serial
     * @return Integer
     */
    function get_count_serial_type() {
        $sql = "SELECT COUNT(*) AS row_count FROM sys_serial_type WHERE serial_type_is_active = '1'";
        $query = $this->CI->db->query($sql);
        $row = $query->row();
        
        return $row->row_count;
    }

    /**
     * function untuk generate array option pada form input
     * @return Array
     */
    function get_serial_type_options() {
        $options = array();
        $query = $this->get_list_serial_type();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $options[$row->serial_type_id] = $row->serial_type_label;
            }
        }
        return $options;
    }

    /**
     * function untuk generate string option pada filter grid
     * @return String
     */
    function get_serial_type_grid_options() {
        $grid_options = '';
        $query = $this->get_list_serial_type();
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $grid_options .= $row->serial_type_id . ':' . $row->serial_type_label . '|';
            }
            $grid_options = rtrim($grid_options, '|');
        }
        return $grid_options;
    }

    /**
     * function untuk generate kode transfer
     * @param string $date tanggal untuk mencari kode transfer terakhir
     * @return String
     */
    function generate_bonus_transfer_code($date = '') {
        if($date == '') {
            $date = date("Y-m-d");
        }
        $sql = "
            SELECT IFNULL(LPAD(MAX(CAST(RIGHT(bonus_transfer_code, 5) AS SIGNED) + 1), 5, '0'), '00001') AS new_sort 
            FROM sys_bonus_transfer 
            WHERE DATE(bonus_transfer_datetime) = '" . $date . "'
        ";
        $query = $this->CI->db->query($sql);
        $new_sort = '';
        if($query->num_rows() > 0) {
            $row = $query->row();
            $new_sort = $row->new_sort;
        }
        $new_code = 'TRF.' . str_replace('-', '', $date) . '.' . $new_sort;
        
        return $new_code;
    }

    /**
     * function untuk generate kode transfer
     * @param int $root_network_id network_id batas member yang diperbolehkan
     * @param int $top_network_id network_id member paling atas dari geneologi yang ditampilkan
     * @param int $level_depth kedalaman level
     * @return Array
     */
    function generate_geneology_binary($root_network_id, $top_network_id, $level_depth) {
        $today = date("Y-m-d");
        $data_max = 0;
        $arr_level_node_start = array();
        for ($i = 0; $i <= $level_depth; $i++) {
            $pow = pow(2, $i);
            $data_max = $data_max + $pow;
            array_push($arr_level_node_start, $pow);
        }

        $arr_data = array();
        $upline = 0;
        
        $level = $this->get_network_level_value($top_network_id, $root_network_id);
        if($level == '') {
            $level = 0;
        }
        
        $level_current = 0;
        
        for ($x = 1; $x <= $data_max; $x++) {
            if ($x % 2 == 0) {
                $position = 'L';
                $position_text = 'kiri';
                $downline_node_id = 'network_left_node_network_id';
                $upline++;
            } else {
                $position = 'R';
                $position_text = 'kanan';
                $downline_node_id = 'network_right_node_network_id';
            }

            if ($x == 1) {
                $network_id = $top_network_id;
            } else {
                if(isset($arr_data[$upline][$downline_node_id])) {
                    $network_id = $arr_data[$upline][$downline_node_id];
                } else {
                    $network_id = '';
                }
                
                if(in_array($x, $arr_level_node_start)) {
                    $level++;
                    $level_current++;
                }
            }
            
            if ($network_id == '') {
                $arr_data[$x] = '';
                $arr_data[$x]['geneology_status'] = 'blank';
                $arr_data[$x]['sort'] = $x;
                $arr_data[$x]['geneology_parent'] = $upline;
                $arr_data[$x]['geneology_level'] = $level;
            } else {
                $query = $this->CI->function_lib->get_detail_data('view_member', 'network_id', $network_id);
                if ($query->num_rows() > 0) {
                    $row = $query->row_array();
                    
                    $total_downline_left_today = $this->CI->function_lib->get_one('sys_netgrow_master', 'netgrow_master_node_left', array('netgrow_master_network_id' => $network_id, 'netgrow_master_date' => $today));
                    if($total_downline_left_today == '') {
                        $total_downline_left_today = 0;
                    }
                    
                    $total_downline_right_today = $this->CI->function_lib->get_one('sys_netgrow_master', 'netgrow_master_node_right', array('netgrow_master_network_id' => $network_id, 'netgrow_master_date' => $today));
                    if($total_downline_right_today == '') {
                        $total_downline_right_today = 0;
                    }
                    
                    $total_node_right = $this->CI->function_lib->get_one('sys_network', 'network_total_downline_right', array('network_id' => $network_id));
                    if($total_node_right == '') {
                        $total_node_right = 0;
                    }
                    $total_node_left = $this->CI->function_lib->get_one('sys_network', 'network_total_downline_left', array('network_id' => $network_id));
                    if($total_node_left == '') {
                        $total_node_left = 0;
                    }
                    
                    if($row['member_image'] != '' && file_exists(_dir_member . $row['member_image'])) {
                        $images_src = base_url() . 'media/' . _dir_member . '48/48/' . $row['member_image'];
                    } else {
                        $images_src = base_url() . 'media/' . _dir_member . '48/48/_default.jpg';
                    }
                    
                    
                    $arr_data[$x] = $row;
                    $arr_data[$x]['geneology_status'] = 'filled';
                    $arr_data[$x]['sort'] = $x;
                    $arr_data[$x]['geneology_parent'] = $upline;
                    $arr_data[$x]['total_node_right'] = $total_node_right;
                    $arr_data[$x]['total_node_left'] = $total_node_left;
                    $arr_data[$x]['geneology_node_today_left'] = $total_downline_left_today;
                    $arr_data[$x]['geneology_node_today_right'] = $total_downline_right_today;
                    $arr_data[$x]['geneology_level'] = $level;
                    $arr_data[$x]['geneology_image_src'] = $images_src;
                } else {
                    $arr_data[$x] = '';
                    $arr_data[$x]['geneology_status'] = 'empty';
                    $arr_data[$x]['sort'] = $x;
                    $arr_data[$x]['geneology_parent'] = $upline;
                    $arr_data[$x]['geneology_level'] = $level;
                    $arr_data[$x]['geneology_upline_network_code'] = $arr_data[$upline]['network_code'];
                    $arr_data[$x]['geneology_node_position'] = $position_text;
                }
            }
        }
        return $arr_data;
    }


    /**
     * function untuk generate geneology tree
     * @param int $root_network_id network_id batas member yang diperbolehkan
     * @param int $top_network_id network_id member paling atas dari geneologi yang ditampilkan
     * @param int $level_depth maksimal kedalaman level
     * @return Array
     */
     function generate_geneology_tree($root_network_id, $top_network_id, $level_depth, $year = '', $month = '', $level = 0) {
        

        $separator_1 = ' <font color="#888888">&middot;</font> ';
        $separator_2 = ' <font color="#888888">&middot;&middot;</font> ';
        $separator_3 = ' <font color="#888888">&middot;&middot;&middot;</font> ';
        
        if($year == '' || $month == '') {
            $year = date("Y");
            $month = date("m");
        }
        
        if(!isset($tree)) {
            $tree = '';
        }
        
        if($level == 0) {
            $sql_top_network = "SELECT * FROM sys_network INNER JOIN sys_member ON member_network_id = network_id WHERE network_id = " . $top_network_id . " LIMIT 1";
            $query_top_network = $this->CI->db->query($sql_top_network);
            if($query_top_network->num_rows() > 0) {
                $row_top_network = $query_top_network->row();
                
                $network_level = $this->get_network_level_value($top_network_id, $root_network_id);
                if($network_level == '') {
                    $network_level = 0;
                }
                $tree .= '<li>';
                $tree .= '<span>&nbsp;Lv ' . $network_level . $separator_1 . $row_top_network->network_code . $separator_1 . stripslashes($row_top_network->member_name) . '</span>';
                $tree .= $this->generate_geneology_tree($root_network_id, $row_top_network->network_id, $level_depth, $year, $month, 1);
                $tree .= '</li>';
            }
            
        } elseif($level <= $level_depth) {
            $sql = "
                SELECT * FROM sys_network INNER JOIN sys_member ON member_network_id = network_id WHERE network_upline_network_id = " . $top_network_id . " AND network_position = 'L' 
                UNION ALL 
                SELECT * FROM sys_network INNER JOIN sys_member ON member_network_id = network_id WHERE network_upline_network_id = " . $top_network_id . " AND network_position = 'R' 
            ";
            $query = $this->CI->db->query($sql);
            if($query->num_rows() > 0) {
                $tree .= '<ul>';
                foreach($query->result() as $row) {
                    
                    $network_level = $this->get_network_level_value($row->network_id, $root_network_id);
                    if($network_level == '') {
                        $network_level = 0;
                    }
                    $downline_check = $this->CI->function_lib->get_one('sys_network', 'network_id', array('network_upline_network_id' => $row->network_id));
                    
                    $row_data = '&nbsp;Lv ' . $network_level . $separator_1 . $row->network_position . $separator_1 . $row->network_code . $separator_1 . stripslashes($row->member_name) . '';
                    
                    $has_downline = 0;
                    if($network_level == $level_depth) {
                        $has_downline = $this->check_has_downline($row->network_id);
                    }

                    $has_downline_label = ($has_downline > 0) ? '<a href="javascript:void(0)" onclick="get_downline($(this), ' . $root_network_id . ', ' . $row->network_id . ', ' . $year . ', ' . $month . '); return false;" title="Expand">[+]</a>' : '';

                    if($downline_check != '') {
                        $tree .= '<li id="parentli_' . $row->network_id . '">' . $has_downline_label;
                        $tree .= '<span>' . $row_data . '</span>';
                        $level++;
                        $tree .= $this->generate_geneology_tree($root_network_id, $row->network_id, $level_depth, $year, $month, $level);
                        $level--;
                        $tree .= '</li>';
                    } else {
                        $tree .= '<li><span>' . $row_data . '</span></li>';
                    }
                }
                $tree .= '</ul>';
            }
        }
        
        return $tree;
    }

    /**
     * function untuk mendapatkan konfigurasi netgrow yang digunakan
     * @return Array
     */
    function get_arr_active_netgrow() {
        $this->CI->config->load('netgrow');
        $arr_all_netgrow_config = $this->CI->config->item('netgrow');
        $arr_active_netgrow = array();
        if(is_array($arr_all_netgrow_config)) {
            foreach($arr_all_netgrow_config as $netgrow_name => $arr_item) {
                if($arr_item['active']) {
                    $arr_active_netgrow[] = $netgrow_name;
                }
            }
        }
        return $arr_active_netgrow;
    }
    
    /**
     * function untuk mendapatkan konfigurasi netgrow yang digunakan
     * @return Array
     */
    function get_arr_netgrow_config($netgrow_name) {
        $this->CI->config->load('netgrow');
        $arr_all_netgrow_config = $this->CI->config->item('netgrow');
        
        return $arr_all_netgrow_config[$netgrow_name];
    }

    /**
     * function untuk mendapatkan konfigurasi bonus yang digunakan
     * @return Array
     */
    function get_arr_active_bonus($periode = '') {
        $this->CI->config->load('bonus');
        $arr_all_bonus_config = $this->CI->config->item('bonus');
        $arr_active_bonus = array();
        if(is_array($arr_all_bonus_config)) {
            foreach($arr_all_bonus_config as $bonus_name => $arr_item) {
                if($arr_item['active']) {
                    if($periode != '') {
                        if($arr_item['periode'] == $periode) {
                            $arr_active_bonus[] = array(
                                'name' => $bonus_name,
                                'label' => $arr_item['label'],
                                'periode' => $arr_item['periode'],
                                'value' => $arr_item['value'],
                            );
                        }
                    } else {
                        $arr_active_bonus[] = array(
                            'name' => $bonus_name,
                            'label' => $arr_item['label'],
                            'periode' => $arr_item['periode'],
                            'value' => $arr_item['value'],
                        );
                    }
                }
            }
        }
        return $arr_active_bonus;
    }
    
    /**
     * function untuk mendapatkan konfigurasi bonus yang digunakan
     * @return Array
     */
    function get_arr_bonus_config($bonus_name) {
        $this->CI->config->load('bonus');
        $arr_all_bonus_config = $this->CI->config->item('bonus');
        
        return $arr_all_bonus_config[$bonus_name];
    }
    
    /**
     * function untuk mendapatkan label bonus
     * @return Array
     */
    function get_bonus_label($bonus_name) {
        $arr_bonus_config = $this->get_arr_bonus_config($bonus_name);
        $bonus_label = (array_key_exists('label', $arr_bonus_config)) ? $arr_bonus_config['label'] : '';
        
        return $bonus_label;
    }

    /**
     * function untuk mendapatkan string select query bonus log untuk bonus aktif
     * @return String
     */
    function get_string_bonus_log_select() {
        $arr_active_bonus = $this->get_arr_active_bonus();
        
        $str_select = "";
        $str_total_bonus_select = "";
        if(is_array($arr_active_bonus)) {
            $str_total_bonus_select .= "(";
            foreach($arr_active_bonus as $bonus_item) {
                $str_select .= "bonus_log_" . $bonus_item['name'] . ", ";
                $str_total_bonus_select .= "bonus_log_" . $bonus_item['name'] . " + ";
            }
            $str_total_bonus_select = rtrim($str_total_bonus_select, ' + ');
            $str_total_bonus_select .= ") AS bonus_log_total";
            $str_select .= $str_total_bonus_select;
        }
        $str_select = rtrim($str_select, ", ");
        
        return $str_select;
    }

    /**
     * function untuk mendapatkan string select query bonus log untuk bonus aktif
     * @return String
     */
    function get_string_bonus_log_subtotal_select() {
        $arr_active_bonus = $this->get_arr_active_bonus();
        
        $str_select = "";
        $str_total_bonus_select = "";
        if(is_array($arr_active_bonus)) {
            $str_total_bonus_select .= "(";
            foreach($arr_active_bonus as $bonus_item) {
                $str_select .= "SUM(bonus_log_" . $bonus_item['name'] . ") AS bonus_log_" . $bonus_item['name'] . ", ";
                $str_total_bonus_select .= "SUM(bonus_log_" . $bonus_item['name'] . ") + ";
            }
            $str_total_bonus_select = rtrim($str_total_bonus_select, ' + ');
            $str_total_bonus_select .= ") AS bonus_log_total";
            $str_select .= $str_total_bonus_select;
        }
        $str_select = rtrim($str_select, ", ");
        
        return $str_select;
    }

    /**
     * function untuk mendapatkan string select query bonus untuk bonus aktif
     * @return String
     */
    function get_string_bonus_select() {
        $arr_active_bonus = $this->get_arr_active_bonus();
        
        $str_select = "";
        $str_total_in_bonus_select = "";
        $str_total_out_bonus_select = "";
        $str_total_saldo_bonus_select = "";
        if(is_array($arr_active_bonus)) {
            $str_total_in_bonus_select .= "(";
            $str_total_out_bonus_select .= "(";
            $str_total_saldo_bonus_select .= "(";
            foreach($arr_active_bonus as $bonus_item) {
                $str_select .= "IFNULL(SUM(bonus_log_" . $bonus_item['name'] . "), 0) AS bonus_" . $bonus_item['name'] . "_in, ";
                $str_select .= "IFNULL(SUM(bonus_transfer_detail_" . $bonus_item['name'] . "), 0) AS bonus_" . $bonus_item['name'] . "_out, ";
                $str_select .= "(IFNULL(SUM(bonus_log_" . $bonus_item['name'] . "), 0) - IFNULL(SUM(bonus_transfer_detail_" . $bonus_item['name'] . "), 0)) AS bonus_" . $bonus_item['name'] . "_saldo, ";
                
                $str_total_in_bonus_select .= "IFNULL(SUM(bonus_log_" . $bonus_item['name'] . "), 0) + ";
                $str_total_out_bonus_select .= "IFNULL(SUM(bonus_transfer_detail_" . $bonus_item['name'] . "), 0) + ";
                $str_total_saldo_bonus_select .= "(IFNULL(SUM(bonus_log_" . $bonus_item['name'] . "), 0) - IFNULL(SUM(bonus_transfer_detail_" . $bonus_item['name'] . "), 0)) + ";
            }
            $str_total_in_bonus_select = rtrim($str_total_in_bonus_select, ' + ');
            $str_total_in_bonus_select .= ") AS bonus_total_in, ";
            
            $str_total_out_bonus_select = rtrim($str_total_out_bonus_select, ' + ');
            $str_total_out_bonus_select .= ") AS bonus_total_out, ";
            
            $str_total_saldo_bonus_select = rtrim($str_total_saldo_bonus_select, ' + ');
            $str_total_saldo_bonus_select .= ") AS bonus_total_saldo";
            
            $str_select .= $str_total_in_bonus_select;
            $str_select .= $str_total_out_bonus_select;
            $str_select .= $str_total_saldo_bonus_select;
        }
        $str_select = rtrim($str_select, ", ");
        
        return $str_select;
    }

    /**
     * function untuk mendapatkan nilai bonus member
     * @param String $bonus_name nama bonus yang akan dicari
     * @param int $network_id network_id member yang akan dicari
     * @return Array
     */
    function get_selected_bonus($bonus_name, $network_id) {
        $arr_bonus_value = array(
            'bonus_in' => 0,
            'bonus_out' => 0,
            'bonus_saldo' => 0,
        );
        $sql = "
            SELECT network_id AS bonus_network_id, 
            IFNULL(SUM(bonus_log_" . $bonus_name . "), 0) AS bonus_in, 
            IFNULL(SUM(bonus_transfer_detail_" . $bonus_name . "), 0) AS bonus_out, 
            (IFNULL(SUM(bonus_log_" . $bonus_name . "), 0) - IFNULL(SUM(bonus_transfer_detail_" . $bonus_name . "), 0)) AS bonus_saldo 
            FROM sys_network 
            LEFT JOIN sys_bonus_log ON bonus_log_network_id = network_id 
            LEFT JOIN sys_bonus_transfer_detail ON bonus_log_id = bonus_transfer_detail_bonus_log_id 
            LEFT JOIN sys_bonus_transfer ON bonus_transfer_id = bonus_transfer_detail_bonus_transfer_id AND bonus_transfer_status NOT IN ('failed') 
            WHERE network_id = '" . $network_id . "'
        ";
        $query = $this->CI->db->query($sql);
        if($query->num_rows() > 0) {
            $row = $query->row();
            $arr_bonus_value = array(
                'bonus_in' => $row->bonus_in,
                'bonus_out' => $row->bonus_out,
                'bonus_saldo' => $row->bonus_saldo,
            );
        }
        return $arr_bonus_value;
    }
    
    /**
     * function untuk mendapatkan bonus yang digunakan pada transfer tertenu
     * @return Array
     */
    function get_arr_transfer_bonus_active($datetime = '') {
        $arr_transfer_bonus_active = array();
        $sql = "
            SELECT bonus_transfer_active_str_bonus 
            FROM sys_bonus_transfer_active 
            WHERE bonus_transfer_active_datetime = '" . $datetime . "'
        ";
        $query = $this->CI->db->query($sql);
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $str_bonus = $row->bonus_transfer_active_str_bonus;
                $arr_temp = explode("#", $str_bonus);
                foreach($arr_temp as $bonus_item) {
                    if(!array_key_exists($bonus_item, $arr_transfer_bonus_active)) {
                        array_push($arr_transfer_bonus_active, $bonus_item);
                    }
                }
            }
        }
        
        return $arr_transfer_bonus_active;
    }
    
    function get_arr_transfer_category() {
        $arr_transfer_category = array(
            'daily' => 'Harian',
            'weekly' => 'Mingguan',
            'monthly' => 'Bulanan',
            'annualy' => 'Tahunan'
        );
        return $arr_transfer_category;
    }
    
    function get_transfer_category_grid_options() {
        $grid_options = '';
        $arr_transfer_category = $this->get_arr_transfer_category();
        foreach($arr_transfer_category as $name => $label) {
            $grid_options .= $name . ':' . $label . '|';
        }
        $grid_options = rtrim($grid_options, '|');
        
        return $grid_options;
    }
    
    /**
    cek apakah ada downlinenya untuk lebih dari maksimal kedalaman
    @param int $upline_id
    */
    public function check_has_downline($upline_id) {
        $has_downline = $this->CI->function_lib->get_one("sys_network", "COUNT(network_id)", array('network_upline_network_id' => $upline_id));

        return ($has_downline > 0) ? true : false;
    }

}
?>
