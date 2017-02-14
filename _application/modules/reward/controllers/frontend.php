<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of frontend
 *
 * @author Almira
 */
class frontend extends Frontend_Controller{
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('frontend_reward_model');
    }
    
    public function index(){
        $this->show();
    }
    
    public function show() {
        $data['title'] = 'Data Reward';
        $data['arr_breadcrumbs'] = array(
            'Data Reward' => '#',
            'Reward' => '',
        );
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        $data['data_reward'] = $this->frontend_reward_model->get_reward_active();
        template('frontend', 'reward/frontend_reward_list_view', $data);
    }
    
    public function member($reward_id){        
        $data['title'] = 'Data Penerima Reward';
        $data['arr_breadcrumbs'] = array(
            'Data Reward' => 'reward',
            'Member Qualified' => '',
        );
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        $this->load->library('pagination');
        // pagination
        $offset = (int) $this->uri->segment(4, 0);
        $limit = 10;
        $config['base_url'] = site_url('reward/member/'.$reward_id);
        $config['total_rows'] = $this->frontend_reward_model->get_member_qualified_reward($reward_id, FALSE, FALSE, TRUE);
        
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        $data['query_reward'] = $this->frontend_reward_model->get_reward_info($reward_id);
        $data['data_member_qualified'] = $this->frontend_reward_model->get_member_qualified_reward($reward_id, $offset, $limit);

        template('frontend', 'reward/frontend_reward_member', $data);
    }
}

?>
