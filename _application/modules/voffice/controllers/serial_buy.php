<?php

/*
 * Member Serial Buy Controller
 *
 * @author	@yonkz28
 * @copyright	Copyright (c) 2016, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Serial_buy extends Member_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('voffice/serial_buy_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['page_title'] = 'Data Serial Terbeli';
        $data['arr_breadcrumbs'] = array(
            'Serial Terbeli' => 'voffice/serial_buy/show',
        );

        template('member', 'voffice/serial_buy_list_view', $data);
    }


    function get_data() {
        $params = isset($_POST) ? $_POST : array();
        $params['select'] = "
            sys_serial_buyer.*, sys_serial.*";
        $params['table'] = "sys_serial_buyer";
        $params['join'] = "INNER JOIN sys_serial ON serial_id = serial_buyer_serial_id";
        $params['where_detail'] = "serial_buyer_network_id = '" . $this->session->userdata('network_id') . "'";
        $query = $this->function_lib->get_query_data($params);
        $total = $this->function_lib->get_query_data($params, true);

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {
  //is_active
            if ($row->serial_is_active == '1') {
                $stat = 'Aktif';
                $image_stat = 'tick.png';
            } else {
                $stat = 'Tidak Aktif';
                $image_stat = 'minus-small.png';
            }
            $is_active = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            //is_sold
            if ($row->serial_is_sold == '1') {
                $stat = 'Terjual';
                $image_stat = 'tick.png';
            } else {
                $stat = 'Belum Terjual';
                $image_stat = 'minus-small.png';
            }
            $is_sold = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            //is_used
            if ($row->serial_is_used == '1') {
                $stat = 'Terpakai';
                $image_stat = 'tick.png';
            } else {
                $stat = 'Belum Terpakai';
                $image_stat = 'minus-small.png';
            }
            $is_used = '<img src="' . base_url() . _dir_icon . $image_stat . '" alt="' . $stat . '" title="' . $stat . '" border="0" />';
            
            $entry = array('id' => $row->serial_buyer_serial_id,
                'cell' => array(
                    'serial_buyer_serial_id' => $row->serial_buyer_serial_id,
                    'serial_pin' => $row->serial_pin,
                    'serial_is_sold' => $is_sold,
                    'serial_is_active' => $is_active,
                    'serial_is_used' => $is_used,
                    'serial_buyer_datetime' => convert_datetime($row->serial_buyer_datetime, 'id'),
                ),
            );
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
}
