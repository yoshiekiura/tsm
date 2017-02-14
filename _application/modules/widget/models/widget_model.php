<?php

/**
 * Description of widget_model
 *
 * @author el-fatih
 */
class widget_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_slider_active($limit = 5) {
        $this->db->where('slider_is_active', '1');
        $this->db->order_by('slider_id', 'asc');
        $this->db->limit($limit);
        return $this->db->get('site_slider');
    }

    function get_news_by_category($limit = 5) {
        $this->db->where('news_is_active', '1');
        $this->db->order_by('news_input_datetime', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('site_news');
    }

    public function get_news_list($offset = 0, $limit = 20, $category_id=false) {
        $this->db->select("*, DATE_FORMAT(news_input_datetime, '%M %D, %Y') AS news_input_date", false);
        $this->db->from('site_news');
        $this->db->join('site_news_category', 'news_category_id=news_news_category_id');
        if ($category_id !== false) {
            $this->db->where('news_is_active', $category_id);
        }
        $this->db->where(array('news_is_active' => '1'));
        $this->db->order_by('news_input_datetime', 'desc');
        $this->db->offset($offset);
        $this->db->limit($limit);

        return $this->db->get();
    }

    public function get_news_side() {
        $this->db->select("*, DATE_FORMAT(news_input_datetime, '%M %D, %Y') AS news_input_date", false);
        $this->db->from('site_news');
        $this->db->where(array('news_is_active' => '1'));
        $this->db->order_by('news_input_datetime', 'desc');
        $this->db->limit(6);

        return $this->db->get();
    }

    public function get_event_list_widget($limit=6) {
        $this->db->select("*, DATE_FORMAT(event_input_datetime, '%M %D, %Y') AS event_input_date", false);
        $this->db->from('site_event');
        $this->db->where(array('event_is_active' => '1'));
        $this->db->order_by('event_input_datetime', 'desc');
        $this->db->limit($limit);
        return $this->db->get();
    }

    public function get_event_list_cabang() {
        $this->db->select("*, DATE_FORMAT(event_input_datetime, '%M %D, %Y') AS event_input_date", false);
        $this->db->from('site_event');
        $this->db->where(array('event_is_active' => '1'));
        $this->db->order_by('event_input_datetime', 'desc');
        //$this->db->limit($limit);

        return $this->db->get();
    }

    public function get_testimony_active() {
        $this->db->select("*", false);
        $this->db->from('view_testimony');
        $this->db->where(array('testimony_is_active' => '1'));
        $this->db->order_by('testimony_datetime', 'desc');

        $this->db->limit(5);

        return $this->db->get();
    }

    public function get_new_member($limit = 10) {
        $this->db->select("*");
        $this->db->from('sys_member');
        $this->db->join('sys_network', 'member_network_id=network_id', 'left');
        $this->db->where(array('member_is_active' => '1'));
        $this->db->order_by('member_join_datetime', 'desc');
        $this->db->limit($limit);

        return $this->db->get();
    }

    function get_event_random($id) {
        $this->db->select("*, DATE_FORMAT(event_input_datetime, '%M %D, %Y') AS event_input_date", false);
        $this->db->from('site_event');
        $this->db->where('event_id !=', $id);
        $this->db->where('event_is_active', '1');
        $this->db->order_by('event_id', 'ASC');

        return $this->db->get();
    }

    function get_promo() {
        $this->db->where('promo_is_active', '1');
        $this->db->order_by('promo_input_datetime', 'DESC');
        //$this->db->limit($limit);
        return $this->db->get('site_promo');
    }

    function get_left_promo($limit = 5) {
        $this->db->where('promo_is_active', '1');
        $this->db->where('promo_price >', '0' );
        $this->db->order_by('promo_input_datetime', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('site_promo');
    }
    
    function get_partner() {
        $this->db->where('partner_is_active', '1');
        $this->db->order_by('partner_input_datetime', 'DESC');
        //$this->db->limit($limit);
        return $this->db->get('site_partner');
    }

    function get_top_sponsor($startDate = '', $endDate = '', $limit = 10) {
        $this->db->cache_on();

        if ($startDate != '' && $endDate != '') {
            $where = "AND DATE(member_sponsoring.member_join_datetime) BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
        } else {
            $where = '';
        }

        $sql = 'SELECT network_sponsor_network_id, member_sponsoring.member_join_datetime, count(network_id) as jumlah,max(member_sponsoring.member_join_datetime)  as last_update,
                member_sponsor.member_name
                FROM sys_network sponsor
                INNER JOIN sys_member member_sponsoring ON member_sponsoring.member_network_id = sponsor.network_id
                INNER JOIN sys_member member_sponsor ON member_sponsor.member_network_id = sponsor.network_sponsor_network_id
                WHERE member_sponsor.member_is_active = 1 '.$where.'
                GROUP BY network_sponsor_network_id
                ORDER BY jumlah DESC,
                last_update ASC
                
                LIMIT '. $limit ;

        return $this->db->query($sql);
        $this->db->cache_off();
    }

    function get_top_income($startDate = '', $endDate = '', $limit=100) {
        $this->db->cache_on();

        if ($startDate != '' && $endDate != '') {
            $whereBonusLog = "WHERE bonus_log_date BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
            $whereReward = "WHERE reward_qualified_date BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
        } else {
            $whereBonusLog = "";
            $whereReward = "";
        }
        $sql = "
            SELECT network_id, member_name, network_code, (bonus_sponsor_acc + bonus_match_acc + bonus_node_acc) as total_bonus
                FROM sys_bonus
                INNER JOIN sys_network ON network_id = bonus_network_id
                INNER JOIN sys_member ON member_network_id = network_id
                ORDER BY (bonus_sponsor_acc + bonus_match_acc + bonus_node_acc) DESC
                LIMIT {$limit}
            ";

        $query = $this->db->query($sql);
        return $query;
        $this->db->cache_off();
    }

    function get_member_reward($startDate = '', $endDate = '', $limit=100) {
        $this->db->cache_on();

        if ($startDate != '' && $endDate != '') {
            $additionalWhere = "AND reward_qualified_status_datetime BETWEEN '" . $startDate . "' AND '" . $endDate . "'";
        } else {
            $additionalWhere = "";
        }
        $sql = "
            SELECT network_id, member_name, network_code, reward_qualified_reward_bonus, reward_qualified_status_datetime
                FROM sys_reward_qualified_status
                INNER JOIN sys_reward_qualified ON reward_qualified_status_reward_qualified_id = reward_qualified_id
                INNER JOIN sys_network ON network_id = reward_qualified_network_id
                INNER JOIN sys_member ON member_network_id = network_id
                WHERE reward_qualified_status = 'approved'
                    AND reward_qualified_status_status = 'approved'
                    {$additionalWhere}
                ORDER BY reward_qualified_status_datetime DESC
                LIMIT {$limit}
            ";

        $query = $this->db->query($sql);
        return $query;
        $this->db->cache_off();
    }

    public function get_last_gallery($limit=6) {
        $this->db->from('site_gallery');
        $this->db->where(array('gallery_is_active' => '1'));
        $this->db->order_by('gallery_date', 'desc');
        $this->db->limit($limit);

        return $this->db->get();
    }

    public function get_data_contact($limit=6) {
        $this->db->from('site_contact_us');
        $this->db->where(array('contact_us_is_active' => '1'));
        $this->db->order_by('contact_us_id', 'asc');
        $this->db->limit($limit);

        return $this->db->get();
    }

    public function get_data_leader($limit=6) {
        $this->db->from('site_leader');
        $this->db->where(array('leader_is_active' => '1'));
        $this->db->order_by('leader_id', 'asc');
        $this->db->limit($limit);

        return $this->db->get();
    }

    public function get_data_product($limit=6) {
        $this->db->from('site_product');
        $this->db->where(array('product_is_active' => '1'));
        $this->db->order_by('product_id', 'asc');
        $this->db->limit($limit);

        return $this->db->get();
    }

}
