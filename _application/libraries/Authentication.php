<?php

/*
 * Authentication Libraries
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Authentication {

    var $CI = null;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library(array('session'));
    }
    
    function auth_user() {
        if(!$this->CI->session->userdata('administrator_logged_in')) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function privilege_user() {
        
        $uri_string = rtrim(uri_string(), "/");
        $arr_uri = explode('/', $uri_string);
        $actor = $arr_uri[0];
        $controller = $arr_uri[1];
        $action = str_replace($actor . '/' . $controller . '/', '', $uri_string);
        
        $arr_uri_string_true = array(
            'backend/systems/profile',
            'backend/systems/password',
            'backend/member/get_member_info/(.*)',
        );
        
        $is_true = FALSE;
        if($this->CI->session->userdata('administrator_group_type') == 'superuser') {
            $is_true = TRUE;
        } else {
            foreach($arr_uri_string_true as $uri_string_true) {
                if(preg_match('/' . str_replace('/', '\/', rtrim($uri_string_true, "/")) . '$/', $uri_string)) {
                    $is_true = TRUE;
                }
            }
            
            if(!$is_true) {
                $sql_administrator_privilege = "
                    SELECT * 
                    FROM site_administrator_privilege 
                    LEFT JOIN site_administrator_menu ON administrator_menu_id = administrator_privilege_administrator_menu_id 
                    WHERE administrator_privilege_administrator_group_id = '" . $this->CI->session->userdata('administrator_group_id') . "'
                ";
                $query_administrator_privilege = $this->CI->db->query($sql_administrator_privilege);
                if($query_administrator_privilege->num_rows() > 0) {
                    $arr_menu[0] = 'backend/dashboard/show';
                    foreach($query_administrator_privilege->result() as $row_administrator_privilege) {
                        $arr_menu[$row_administrator_privilege->administrator_menu_id] = $row_administrator_privilege->administrator_menu_link;
                    }
                }

                foreach ($arr_menu as $menu_id => $menu_link) {
                    if (preg_match('/' . $actor . '\/' . $controller . '\//i', $menu_link)) {
                        $is_true = TRUE;
                        break;
                    }
                }
            }
        }
        
        return $is_true;
    }
    
    function auth_member() {
        if(!$this->CI->session->userdata('member_logged_in')) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>
