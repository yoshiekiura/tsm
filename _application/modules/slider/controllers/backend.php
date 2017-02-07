<?php

/*
 * Backend Slider Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('slider/backend_slider_model');
        $this->load->helper('form');
        
        $this->file_dir = _dir_slider;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';

        //set width & height berdasarkan slider block
        $this->header_image_width = 1000;
        $this->header_image_height = 200;
    }

    function index() {
        $this->show();
    }
    
    function show($block = 'header') {
        switch($block) {
            default:
                $block_title = "Header";
                break;
        }
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Slider ' . $block_title => 'backend/slider/show/' . $block,
        );
        
        $data['block'] = $block;
        $data['block_title'] = $block_title;
        
        template('backend', 'slider/backend_slider_list_view', $data);
    }

    function add($block = 'header') {
        switch($block) {
            default:
                $block_title = "Header";
                break;
        }
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Slider ' . $block_title => 'backend/slider/show/' . $block,
            'Tambah Slider ' . $block_title => 'backend/slider/add/' . $block,
        );
        
        $data['block'] = $block;
        $data['block_title'] = $block_title;
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $slider_block_image_width = $block . '_image_width';
        $slider_block_image_height = $block . '_image_height';
        if(isset($this->$slider_block_image_width) && isset($this->$slider_block_image_height)) {
            $data['image_width'] = $this->$slider_block_image_width;
            $data['image_height'] = $this->$slider_block_image_height;
        }
        $data['form_action'] = 'backend_service/slider/act_add';
        
        template('backend', 'slider/backend_slider_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        $block = $this->function_lib->get_one('site_slider', 'slider_block', (array('slider_id' => $edit_id)));
        
        switch($block) {
            default:
                $block_title = "Header";
                break;
        }
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Slider ' . $block_title => 'backend/slider/show/' . $block,
            'Ubah Slider' => 'backend/slider/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_slider', 'slider_id', $edit_id);
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $slider_block_image_width = $block . '_image_width';
        $slider_block_image_height = $block . '_image_height';
        if(isset($this->$slider_block_image_width) && isset($this->$slider_block_image_height)) {
            $data['image_width'] = $this->$slider_block_image_width;
            $data['image_height'] = $this->$slider_block_image_height;
        }
        $data['form_action'] = 'backend_service/slider/act_edit';

        template('backend', 'slider/backend_slider_edit_view', $data);
    }

}
