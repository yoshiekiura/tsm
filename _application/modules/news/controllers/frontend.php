<?php

/*
 * Frontend News Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frontend extends Frontend_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->model('frontend_news_model');
        $this->file_dir = _dir_news;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 520;
        $this->image_height = 520;
    }

    public function index() {
        $this->load->library('pagination');
        
        $data['arr_breadcrumbs'] = array(
            'Berita' => '#',
            'Data Berita' => '',
        );
        //pagination
        $offset = (int) $this->uri->segment(3, 0);
        $limit = 6;
        $config['base_url'] = site_url('news/index');
        $config['total_rows'] = $this->frontend_news_model->get_news_list(0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['title'] = 'Berita';
        $data['query'] = $this->frontend_news_model->get_news_list($offset, $limit);

        template('frontend', 'news/frontend_news_list_view', $data);
    }

//    public function show() {
//        $this->load->library('pagination');
//
//        //pagination
//        $offset = (int) $this->uri->segment(3, 0);
//        $limit = 10;
//        $config['base_url'] = site_url('news/show');
//        $config['total_rows'] = $this->frontend_news_model->get_news_list(0, 10000)->num_rows();
//        $config['per_page'] = $limit;
//        $config['uri_segment'] = 3;
//        $this->pagination->initialize($config);
//        $data['pagination'] = $this->pagination->create_links();
//
//        $data['title'] = 'Berita';
//        $data['query'] = $this->frontend_news_model->get_news_list($offset, $limit);
//
//        template('frontend', 'news/frontend_news_list_view', $data);
//    }

    function detail() {
         $data['arr_breadcrumbs'] = array(
            'Berita' => '#',
            'Detail Berita' => '',
        );
        $data['title'] = 'Detail Berita';
        $data['query'] = $this->frontend_news_model->get_news_detail($this->uri->segment(3));
        
        $news_title = $this->function_lib->get_one('site_news','news_title',"news_id = '".$this->uri->segment(3)."'");
        $news_image = $this->function_lib->get_one('site_news','news_image',"news_id = '".$this->uri->segment(3)."'");
        $news_short_content = $this->function_lib->get_one('site_news','news_short_content',"news_id = '".$this->uri->segment(3)."'");
            
        $data['meta_data'] = '
                <meta property="og:title" content="'.$news_title. '" /> 
                <meta property="og:description" content="'.$news_short_content.'" /> 
                <meta property="og:image" content="'.base_url() . _dir_news . $news_image.'" /> 
                <meta property="og:url" content="'. base_url(). 'news/detail/' . $this->uri->segment(3) . '/' . url_title($news_title).'"/>
                <meta name="keywords" content="greentravellink.com" />
                <meta name="copyright" content="greentravellink.com">
                <meta name="author" content="greentravellink.com"/>
            ';
        

        template('frontend', 'news/frontend_news_detail_view', $data);
    }

}