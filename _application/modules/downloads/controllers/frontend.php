<?php

/*
 * Frontend Download Controller
 *
 * @author	@yonkz28
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frontend extends Frontend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('frontend_downloads_model');
    }

    public function index() {
        $data['arr_breadcrumbs'] = array(
            'Download' => '#',
            'Data Download' => '',
        );
        $this->load->library('pagination');

        //pagination
        $offset = (int) $this->uri->segment(3, 0);
        $limit = 30;
        $config['base_url'] = site_url('downloads/index');
        $config['total_rows'] = $this->frontend_downloads_model->get_downloads_list(0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['title'] = 'File Downloads';
        $data['query'] = $this->frontend_downloads_model->get_downloads_list($offset, $limit);

        template('frontend', 'downloads/frontend_downloads_list_view', $data);
    }
    
    function getfile() {
        $downloads_id = $this->uri->segment(3);
        $this->load->library('filedownload');

        $query = $this->function_lib->get_detail_data('site_downloads', 'downloads_id', $downloads_id);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $config = array(
                'file' => _dir_downloads . $row->downloads_file,
                'resume' => true,
                'filename' => $row->downloads_file,
                'speed' => 200, // file download speed limit, in kbytes  
            );
            $this->filedownload->send_download($config);
            
            $this->frontend_downloads_model->update_downloads_count($row->downloads_id);
        }
    }

}
