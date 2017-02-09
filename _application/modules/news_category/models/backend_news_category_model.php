<?php
/**
 * Backend Downloads Category Model
 * 
 * @author Fahrur Rifai <mfahrurrifai@gmail.com>
 * @copyright Copyright (c) 2014, Esoftdream.net
 * 
*/

class Backend_news_category_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function check_delete($id) {
        $this->db->where('news_news_category_id', $id);
        $query = $this->db->get('site_news');
        
        if($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

}
