<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of backend
 *
 * @author hanan
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('reward/backend_reward_model');
        $this->load->helper('form');

        $this->file_dir = _dir_reward;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 600;
        $this->image_height = 1000;
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Reward' => 'backend/reward/show',
        );
        template('backend', 'reward/backend_reward_list_view', $data);
    }

    function add() {

        $data['arr_breadcrumbs'] = array(
            'Reward' => 'backend/reward/show',
            'Tambah Reward' => 'backend/reward/add',
        );

        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/reward/act_add';

        template('backend', 'reward/backend_reward_add_view', $data);
    }

    function edit($edit_id=FALSE) {
        $data['query'] = $this->function_lib->get_detail_data('sys_reward', 'reward_id', $edit_id);

        $data['arr_breadcrumbs'] = array(
            'Reward' => 'backend/reward/show',
            'Ubah Reward' => 'backend/reward/edit/' . $edit_id,
        );

        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/reward/act_edit';

        template('backend', 'reward/backend_reward_edit_view', $data);
    }

    function approval(){
        $data['arr_breadcrumbs'] = array(
            'Reward' => 'backend/reward/show',
            'Approval Reward' => 'backend/reward/approval',
        );

        template('backend', 'reward/backend_reward_member_list_view', $data);
    }

    function log() {
        $data['arr_breadcrumbs'] = array(
            'Reward' => '#',
            'Reward History' => 'backend/reward/log',
        );

        template('backend', 'reward/backend_reward_log_view', $data);
    }   

}

