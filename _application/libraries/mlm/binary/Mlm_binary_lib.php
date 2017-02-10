<?php

/*
 * MLM Binary Libraries
 *
 * @author	Yusuf Rahmanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

include_once realpath('_application/libraries/mlm/Mlm_lib.php');

class Mlm_binary_lib extends Mlm_lib {

    var $CI = null;
    protected $db = null;
    protected $network_id = 0;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
    }

    /* -------------------------------------------------------------------------
     * getter
     * -------------------------------------------------------------------------
     */

    public function get_network_id() {
        return $this->network_id;
    }

    public function get_message() {
        return $this->message;
    }
    
     /* -------------------------------------------------------------------------
     * callback
     * -------------------------------------------------------------------------
     */

    public function insert_network($x = 1) {
        //cek posisi upline
        if ($this->network_position == 'R') {
            $check_node_id = $this->CI->function_lib->get_one('sys_network', 'network_right_node_network_id', array('network_id' => $this->network_upline_network_id));
        } else {
            $check_node_id = $this->CI->function_lib->get_one('sys_network', 'network_left_node_network_id', array('network_id' => $this->network_upline_network_id));
        }

        //jika bukan nol, berarti sudah terisi
        if ($check_node_id !== '0') {
            $prev_network_upline_network_code = $this->network_upline_network_code;
            $prev_position_text = $this->arr_network['position_text'];

            //bandingkan hasilnya
            $left_node = explode(' ', $this->CI->mlm_function->get_last_node($this->network_upline_network_id, 'left'));
            $right_node = explode(' ', $this->CI->mlm_function->get_last_node($this->network_upline_network_id, 'right'));
            if ($left_node[1] > $right_node[1]) {
                $this->network_upline_network_id = $right_node[0];
                $this->network_position = 'R';
            } else {
                $this->network_upline_network_id = $left_node[0];
                $this->network_position = 'L';
            }
            $new_position_text = ($this->network_position == 'R') ? 'kanan' : 'kiri';
            $new_network_upline_network_code = $this->network_upline_network_code = $this->CI->mlm_function->get_network_code($this->network_upline_network_id);

            $this->message .= '<div class="success alert alert-warning">';
            $this->message .= '<div class="alert-title"><b>PERHATIAN</b></div>';
            $this->message .= '<ul>';
            $this->message .= '<li>Kaki ' . $prev_position_text . ' dari ' . $prev_network_upline_network_code . ' sudah terisi oleh member ' . $this->CI->mlm_function->get_network_code($check_node_id) . ' pada saat anda mengisi data.</li>';
            $this->message .= '<li>Otomatis kami gantikan upline anda dengan ' . $new_network_upline_network_code . '(' . $this->CI->mlm_function->get_member_name($this->network_upline_network_id) . ') pada posisi ' . $new_position_text . '.</li>';
            $this->message .= '</ul>';
            $this->message .= '</div>';
        }

        //cek apakah sudah ada yang ber-upline sama pada posisi tsb
        $check_node_position = $this->CI->function_lib->get_one('sys_network', 'network_id', array('network_upline_network_id' => $this->network_upline_network_id, 'network_position' => $this->network_position));
        if ($check_node_position != '') {
            $left_node = explode(' ', $this->CI->mlm_function->get_last_node($this->network_upline_network_id, 'left'));
            $right_node = explode(' ', $this->CI->mlm_function->get_last_node($this->network_upline_network_id, 'right'));
            if ($left_node[1] > $right_node[1]) {
                $this->network_upline_network_id = $right_node[0];
                $this->network_position = 'R';
            } else {
                $this->network_upline_network_id = $left_node[0];
                $this->network_position = 'L';
            }
            $this->network_upline_network_code = $this->CI->mlm_function->get_network_code($this->network_upline_network_id);
        }

//        if ($x == 1) {
        $this->network_code = $this->generate_code($this->arr_serial);
        $member_code = $this->network_code;
//        } else {
//            $member_code = $this->network_code . '-' . $x;
//        }
        //insert ke sys_network
        $sql_insert = "
            INSERT INTO sys_network 
            SET network_code = '" . $member_code . "',
            network_position = '" . $this->network_position . "',
            network_sponsor_network_id = '" . $this->network_sponsor_network_id . "',
            network_initial_sponsor_network_id = '" . $this->network_initial_sponsor_network_id . "',
            network_upline_network_id = '" . $this->network_upline_network_id . "'
        ";
        $feedback = $this->CI->db->query($sql_insert);

        //jika gagal, maka hentikan proses
        if (!$feedback) {
            die('Terjadi kesalahan pada saat proses registrasi. Silahkan ulangi registrasi anda.');
        }

        //ambil network_id
        $this->network_id = $this->CI->function_lib->last_id();
        $_SESSION['network_id'][$x] = $this->network_id;
        $_SESSION['network_code'][$x] = $member_code;

        if ( ! empty($this->parent_network_group) OR $this->parent_network_group != '') {
            $parent_network_id = $this->parent_network_group;
        } else {
            $parent_network_id = $_SESSION['network_id'][1];
        }
        //jika turunan dari titik utama, maka insert ke grup jaringan
        //if ($x > 0) {
        $sql_insert = "
               INSERT INTO sys_network_group 
               SET network_group_parent_network_id = '" . $parent_network_id . "', 
               network_group_member_network_id = '" . $this->network_id . "', 
               network_group_is_approve = '1', 
               network_group_input_datetime = '" . $this->datetime . "'
           ";
        $this->CI->db->query($sql_insert);
        //}
        

        //update data upline
        if ($this->network_position == 'R') {
            $string_update = "network_right_node_network_id = '" . $this->network_id . "'";
        } else {
            $string_update = "network_left_node_network_id = '" . $this->network_id . "'";
        }
        $sql_update = "UPDATE sys_network SET " . $string_update . " WHERE network_id = '" . $this->network_upline_network_id . "'";
        $this->CI->db->query($sql_update);

        $this->insert_member();
    }

}

?>
