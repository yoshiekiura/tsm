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
    
    public function show($reward_type_id, $reward_title) {
       $data['title'] = 'Data Reward '.$reward_title;
       $data['reward_type'] = $reward_title;
       $data['data_reward'] = $this->frontend_reward_model->get_reward_active_by_id($reward_type_id);
       template('frontend', 'reward/frontend_reward_list_view', $data);
    }
    
    public function member($reward_type,$reward_id){        
        $data['title'] = 'Data Penerima Reward';
        $this->load->library('pagination');
        // pagination
        $offset = (int) $this->uri->segment(5, 0);
        $limit = 10;
        $config['base_url'] = site_url('reward/member/'.$reward_type.'/'.$reward_id);
        $config['total_rows'] = $this->frontend_reward_model->get_member_qualified_reward($reward_type, $reward_id)->num_rows();
        
        $config['per_page'] = $limit;
        $config['uri_segment'] = 5;

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();        
        
        $data['query_reward'] = $this->frontend_reward_model->get_reward_info($reward_id);
        $data['query_member'] = $this->frontend_reward_model->get_member_qualified_reward($reward_type,$reward_id,$offset,$limit)->result();

        template('frontend', 'reward/frontend_reward_member', $data);
    }
}

?>
