<?php

/*
 * Member Downloads Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Downloads extends Member_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('voffice/downloads_model');
    }
    
    public function index() {
        $this->show();
    }
    
    function show() {
        $data['page_title'] = 'File Download';
        $data['arr_breadcrumbs'] = array(
            'Download File' => 'voffice/downloads/show',
        );
        
        template('member', 'voffice/downloads_list_view', $data);
    }
    
    function get_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = "site_downloads";
        $params['where'] = "downloads_location = 'member'";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {
            
            //file icon
            if ($row->downloads_file != '') {
                $this->load->library('image_lib');
                $arr_filename = $this->image_lib->explode_name($row->downloads_file);
                $file_ext = $arr_filename['ext'];
                $filetype = str_replace('.', '', $file_ext);
                $filetype_icon = 'icon-' . $filetype . '.png';
                if(!file_exists(_dir_filetypes . $filetype_icon)) {
                    $filetype_icon = '_default.png';
                    $icon = $file_ext;
                } else {
                    $icon = '<img src="' . base_url() . _dir_filetypes . $filetype_icon . '" title="' . $file_ext . '" alt="' . $file_ext . '" />';
                    //$icon = $file_ext;
                }
            } else {
                $file_ext = '-';
                $filetype = '-';
                $filetype_icon = '_default.png';
                $icon = '-';
            }
            
            //downloads link & file size
            if ($row->downloads_file != '' && file_exists(_dir_downloads . $row->downloads_file)) {
                $downloads_link = '<a href="' . base_url() . 'voffice/downloads/getfile/' . $row->downloads_id . '/' . $row->downloads_file . '"><img src="' . base_url() . _dir_icon . 'downloads.png" border="0" alt="Download" title="Download" /></a>';
                $downloads_filesize = get_filesize(_dir_downloads . $row->downloads_file);
            } else {
                $downloads_link = '<img src="' . base_url() . _dir_icon . 'downloads_disabled.png" border="0" alt="File tidak tersedia" title="File tidak tersedia" />';
                $downloads_filesize = '-';
            }
            
            $entry = array('id' => $row->downloads_id,
                'cell' => array(
                    'downloads_id' => $row->downloads_id,
                    'downloads_title' => $row->downloads_title,
                    'downloads_description' => nl2br($row->downloads_description),
                    'downloads_input_datetime' => convert_datetime($row->downloads_input_datetime, 'id'),
                    'downloads_input_date' => convert_date($row->downloads_input_datetime, 'id'),
                    'downloads_filesize' => $downloads_filesize,
                    'downloads_link' => $downloads_link,
                    'downloads_file_ext' => $file_ext,
                    'downloads_filetype' => strtoupper($filetype),
                    'downloads_icon' => $icon,
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }

    function getfile() {
        $downloads_id = $this->uri->segment(4);
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
            
            $this->downloads_model->update_downloads_count($row->downloads_id);
        }
    }

}
