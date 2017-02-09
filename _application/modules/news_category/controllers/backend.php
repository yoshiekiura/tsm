<?php

/*
 * Backend News Category Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('news_category/backend_news_category_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Data Berita Kategori' => 'backend/news_category/show',
        );
        
        template('backend', 'news_category/backend_news_category_list_view', $data);
    }

    function item_show($parent_id=FALSE) {
        if (!$parent_id) {
            redirect('backend/news_category');
        }
        $data_parent = $this->function_lib->get_detail_data('site_news_category', 'news_category_id', $parent_id);
        if ($data_parent->num_rows() == 0) {
            redirect('backend/news_category');
        }

        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Data Berita Kategori' => '#',
            'Kategori' => 'backend/news_category/show',
            $data_parent->row('news_category_name') => '',
        );
        $data['parent_id'] = $parent_id;
        template('backend', 'news_category/backend_news_category_list_item_view', $data);
    }

    function add($parent_id=0) {

        if ($parent_id == 0) {
            $data['arr_breadcrumbs'] = array(
                'Pengelolaan Web' => '#',
                'Data Berita Kategori' => 'backend/news_category/show',
                'Tambah Data Kategori' => 'backend/news_category/add',
            );
        } else {
            $data_parent = $this->function_lib->get_detail_data('site_news_category', 'news_category_id', $parent_id);
            if ($data_parent->num_rows() == 0) {
                redirect('backend/news_category');
            }
            $data['arr_breadcrumbs'] = array(
                'Pengelolaan Web' => '#',
                'Data Berita Kategori' => '#',
                'Kategori' => 'backend/news_category/show',
                $data_parent->row('news_category_name') => 'backend/news_category/item_show/'.$parent_id,
                'Tambah Data Kategori' => '',
            );
        }
        
        $data['parent_id'] = $parent_id;
        $data['form_action'] = 'backend_service/news_category/act_add';
        
        template('backend', 'news_category/backend_news_category_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        $data['query'] = $this->function_lib->get_detail_data('site_news_category', 'news_category_id', $edit_id);

        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Data Berita Kategori' => 'backend/news_category/show',
            'Ubah Data Berita Kategori' => 'backend/news_category/edit/' . $edit_id,
        );
        
        $data['form_action'] = 'backend_service/news_category/act_edit';

        template('backend', 'news_category/backend_news_category_edit_view', $data);
    }

}
