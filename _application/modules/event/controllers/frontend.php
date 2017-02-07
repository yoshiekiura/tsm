<?php

/*
 * Frontend News Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frontend extends Frontend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('frontend_event_model');
    }

    public function index() {
        $data['arr_breadcrumbs'] = array(
            'Event' => '#',
            'Data Event' => '',
        );
        $this->load->library('pagination');

        //pagination
        $offset = (int) $this->uri->segment(3, 0);
        $limit = 6;
        $config['base_url'] = site_url('event/index');
        $config['total_rows'] = $this->frontend_event_model->get_event_list(0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['title'] = 'Agenda';
        $data['query'] = $this->frontend_event_model->get_event_list($offset, $limit);

        template('frontend', 'event/frontend_event_list_view', $data);
    }

    function detail() {
        $data['arr_breadcrumbs'] = array(
            'Event' => '#',
            'Detail Event' => '',
        );
        $data['title'] = 'Event Detail';
        $data['query'] = $this->frontend_event_model->get_event_detail($this->uri->segment(3));

        template('frontend', 'event/frontend_event_detail_view', $data);
    }

}
