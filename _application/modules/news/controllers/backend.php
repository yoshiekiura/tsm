<?php

/*
 * Backend News Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('news/backend_news_model');
        $this->load->helper('form');

        $this->file_dir = _dir_news;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 520;
        $this->image_height = 520;
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Berita' => 'backend/news/show',
        );
        $data['category_options'] = $this->backend_news_model->get_news_category_options('string');
        template('backend', 'news/backend_news_list_view', $data);
    }

    function add() {
        $this->load->helper('tinymce');
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Berita' => 'backend/news/show',
            'Tambah Berita' => 'backend/news/add',
        );
        
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/news/act_add';
        $data['category_options'] = $this->backend_news_model->get_news_category_options('array');

        template('backend', 'news/backend_news_add_view', $data);
    }

    function edit() {
        $this->load->helper('tinymce');
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Berita' => 'backend/news/show',
            'Ubah Berita' => 'backend/news/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_news', 'news_id', $edit_id);
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/news/act_edit';
        $data['category_options'] = $this->backend_news_model->get_news_category_options('array');

        template('backend', 'news/backend_news_edit_view', $data);
    }

}
