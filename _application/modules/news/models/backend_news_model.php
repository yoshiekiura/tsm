<?php

/*
 * Backend News Model
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

class Backend_news_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function list_news() {
        $sql = "SELECT * FROM site_news WHERE news_is_active = '1' ORDER BY news_title ASC";
        return $this->db->query($sql);
    }

    function get_news_category_options($return_type='string') {
    	$this->db->where('news_category_is_active', 1);
    	$query = $this->db->get('site_news_category');
		$str_options = '';
		$arr_options = array();
    	if ($query->num_rows() > 0) {
    		foreach ($query->result() as $row) {
    			$str_options .= $row->news_category_id . ':' . $row->news_category_title . '|';
	    		$arr_options[$row->news_category_id] = $row->news_category_title;
    		}
    		$str_options = rtrim($str_options, '|');
    	} 
    	if ($return_type == 'array') {
    		return $arr_options;
    	} elseif ($return_type == 'string') {
    		return $str_options;
    	} else {
    		return FALSE;
    	}
    }

}
