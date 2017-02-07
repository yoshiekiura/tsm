<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of frontend
 *
 * @author Yusuf Rahmanto
 */
class frontend extends Frontend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('frontend_catalog_item_model');
    }

    public function index() {
        $data['arr_breadcrumbs'] = array(
            'Katalog' => '#',
            'Data Katalog' => '',
        );

        $this->load->library('pagination');

        //pagination
        $offset = (int) $this->uri->segment(3, 0);
        $limit = 9;
        $config['base_url'] = site_url('catalog_item/index');
        $config['total_rows'] = $this->frontend_catalog_item_model->get_catalog_list(0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['title'] = 'Katalog Item';
        $data['query'] = $this->frontend_catalog_item_model->get_catalog($offset, $limit)->result();
        //$data['category'] = $this->frontend_catalog_model->get_catalog_category()->result();

        template('frontend', 'catalog_item/frontend_catalog_item_list_view', $data);
    }

    public function detail_catalog_item() {
        $data['arr_breadcrumbs'] = array(
            'Katalog' => '#',
            'Katalog Detail' => '',
        );
        $this->load->library('pagination');

        //pagination
        $offset = (int) $this->uri->segment(4, 0);
        $limit = 50;
        $config['base_url'] = site_url('catalog_item/detail_catalog_item/' . $this->uri->segment(3));
        $config['total_rows'] = $this->frontend_catalog_item_model->get_catalog_detail_list($this->uri->segment(3), 0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['title'] = 'Detail Katalog';
        $data['catalog_item_detail'] = $this->frontend_catalog_item_model->get_catalog_item_date($this->uri->segment(3));
        $data['query'] = $this->frontend_catalog_item_model->get_catalog_detail_list($this->uri->segment(3), $offset, $limit)->result();

        template('frontend', 'catalog_item/frontend_catalog_item_detail_list_view', $data);
    }

    public function download() {
        $this->load->helper('download');
        $date = date('Ymd_his');
        $name = 'GreenUmrah_' . $date . '.pdf'; 
        $data = file_get_contents("http://www.greentravellink.com/assets/images/downloads/GreenUmrah.pdf");

        force_download($name, $data);
    }

}

?>
