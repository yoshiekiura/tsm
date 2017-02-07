<?php

/*
 * MLM Libraries
 *
 * @author	Yusuf Rahmanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Mlm_lib {

    var $CI = null;
    protected $db = null; //untuk class database
    protected $plan_type = '';
    protected $auto_network_code;
    protected $serial_type_node; //jumlah hu
    protected $date = '';
    protected $datetime = '';
    protected $arr_serial = array();
    protected $arr_network = array();
    protected $data_member = array();
    protected $data_member_detail = array();
    protected $data_member_account = array();
    protected $data_member_bank = array();
    protected $data_member_devisor = array();
    protected $network_code = '';
    protected $message = '';
    protected $parent_network_group = '';
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->library('function_lib');
        
        $this->auto_network_code = TRUE;
        $this->serial_type_node = 1;
    }
    
    /* -------------------------------------------------------------------------
     * setter
     * -------------------------------------------------------------------------
     */
    public function set_data_serial($arr_serial) {
        $this->arr_serial = $arr_serial;
        return $this;
    }
    
    public function set_serial_type_node($serial_type_node = 1) {
        $this->serial_type_node = $serial_type_node;
        return $this;
    }
    
    public function set_auto_network_code($boolean = TRUE) {
        $this->auto_network_code = $boolean;
        return $this;
    }

    public function set_date($date) {
        $this->date = $date;
        return $this;
    }

    public function set_datetime($datetime) {
        $this->datetime = $datetime;
        return $this;
    }
    
    public function set_data_member($arr_member) {
        $this->data_member = $arr_member;
        return $this;
    }
    
    public function set_data_member_detail($arr_member_detail) {
        $this->data_member_detail = $arr_member_detail;
        return $this;
    }
    
    public function set_data_member_account($arr_member_account) {
        $this->data_member_account = $arr_member_account;
        return $this;
    }
    
    public function set_data_member_bank($arr_member_bank) {
        $this->data_member_bank = $arr_member_bank;
        return $this;
    }
    
    public function set_data_member_devisor($arr_member_devisor) {
        $this->data_member_devisor = $arr_member_devisor;
        return $this;
    }
    
    public function set_data_network($arr_network) {
        foreach($arr_network as $field => $value) {
            $this->$field = $value;
        }
        return $this;
    }

    public function set_parent_network_group($parent_network_group)
    {
        $this->parent_network_group = $parent_network_group;
        return $this;
    }
    
    
    /* -------------------------------------------------------------------------
     * getter
     * -------------------------------------------------------------------------
     */
    public function get_sponsor_network_id() {
        return $this->network_sponsor_network_id;
    }
    
    public function get_upline_network_id() {
        return $this->network_upline_network_id;
    }
    
    public function get_message() {
        return $this->message;
    }
    
    
    /* -------------------------------------------------------------------------
     * callback
     * -------------------------------------------------------------------------
     */
    public function generate_code($arr_serial) {
        if ($this->auto_network_code) {
            $this->CI->db->trans_begin();
            $sql_select = "SELECT stock_network_code_value FROM sys_stock_network_code ORDER BY stock_network_code_id LIMIT 1 FOR UPDATE";
            $row = $this->CI->db->query($sql_select)->row_array();
            $network_code = $row['stock_network_code_value'];

            //delete stock network mid
            $sql_delete = "DELETE FROM sys_stock_network_code WHERE stock_network_code_value = '" . $network_code . "'";
            $this->CI->db->query($sql_delete);
            $this->CI->db->trans_commit();
        } else {
            $network_code = $this->CI->function_lib->get_one('sys_serial', 'serial_network_code', array('serial_id' => $arr_serial['serial_id'], 'serial_pin' => $arr_serial['serial_pin']));
        }
        
        return $network_code;
    }
    
    public function insert_member() {
        //update data member
        if(!empty($this->data_member)) {
            $this->CI->db->update('sys_member', $this->data_member, array('member_network_id' => $this->network_id));
        }
        
        //update data member detail
        if(!empty($this->data_member_detail)) {
            $this->CI->db->update('sys_member_detail', $this->data_member_detail, array('member_detail_network_id' => $this->network_id));
        }
        
        //update data password
        if(!empty($this->data_member_account)) {
            $this->CI->db->update('sys_member_account', $this->data_member_account, array('member_account_network_id' => $this->network_id));
        }
        
        //update data member bank
        if(!empty($this->data_member_bank)) {
            $this->CI->db->update('sys_member_bank', $this->data_member_bank, array('member_bank_network_id' => $this->network_id));
        }
        
        //update data member devisor
        if(!empty($this->data_member_devisor)) {
            $this->CI->db->update('sys_member_devisor', $this->data_member_devisor, array('member_devisor_network_id' => $this->network_id));
        }
        
        //update data status serial
        $this->CI->db->query("UPDATE sys_serial SET serial_is_used = '1',serial_is_sold = '1' WHERE serial_id = '" . $this->arr_serial['serial_id'] . "'");
        
        //insert data pengguna serial
        $this->CI->db->query("INSERT INTO sys_serial_user SET serial_user_serial_id = '" . $this->arr_serial['serial_id'] . "', serial_user_network_id = '" . $this->network_id . "', serial_user_datetime = '" . $this->datetime . "'");
        
        //insert data pembeli serial (jika belum ada)
        $buyer_network_id = $this->CI->function_lib->get_one('sys_serial_buyer', 'serial_buyer_network_id', array('serial_buyer_serial_id' => $this->arr_serial['serial_id']));
        if($buyer_network_id == '') {
            $serial_type_id = $this->CI->function_lib->get_one('sys_serial', 'serial_serial_type_id', array('serial_id' => $this->arr_serial['serial_id']));
            $serial_price = $this->CI->function_lib->get_one('sys_serial_type_price_log', 'serial_type_price_log_value', array('serial_type_price_log_serial_type_id' => $serial_type_id), 'serial_type_price_log_datetime', 'desc');
            $this->CI->db->query("INSERT INTO sys_serial_buyer SET serial_buyer_serial_id = '" . $this->arr_serial['serial_id'] . "', serial_buyer_network_id = '" . $this->network_id . "', serial_buyer_price_value = '" . $serial_price . "', serial_buyer_administrator_id = '1', serial_buyer_datetime = '" . $this->datetime . "'");
        }
        
        return $this;
    }
    
}
?>
