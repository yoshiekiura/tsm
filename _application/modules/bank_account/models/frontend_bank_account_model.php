<?php

/**
 * Description of frontend_bank_account_model
 *
 * @author Yusuf Rahmanto
 */
class frontend_bank_account_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_bank_account_active() {
        $this->db->join('ref_bank', 'bank_id=bank_account_bank_id', 'left');
        $this->db->where('bank_account_is_active', '1');
        return $this->db->get('site_bank_account');
    }
}

?>
