<?php

/**
 * Description of ewallet
 *
 * @author el-fatih
 */
class ewallet extends Member_Controller{
    function __construct() {
        parent::__construct();
        
        $this->load->model('voffice/ewallet_model');
        $this->datetime = date("Y-m-d H:i:s");
        $this->date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 0, date("Y")));

        $this->load->library('payment_lib');
    }
    
    function index(){
        $this->show();
    }
    
    function show() {
        $data['page_title'] = 'Status E-Wallet';
        $data['arr_breadcrumbs'] = array(
            'Ewallet' => '#',
            'Status E-Wallet' => 'voffice/ewallet/show',
        );

        $data['saldo_ewallet'] = $this->ewallet_model->get_saldo_ewallet_product($this->session->userdata('network_id'));
        
        template('member', 'voffice/ewallet_main_view', $data);
    }

    // function transfer(){
    //     $this->load->helper('form');
    //     $data['page_title'] = 'Status E-Wallet';
    //     $data['arr_breadcrumbs'] = array(
    //         'Ewallet' => '#',
    //         'Status E-Wallet' => 'voffice/ewallet/show',
    //     );

    //     $data['form_action'] = 'voffice/ewallet/act_transfer';

    //     template('member', 'voffice/ewallet_withdraw_view', $data);
    // }

    function transfer($type = 'member'){
        $this->load->helper('form');
        
        $page_title = ($type == 'member') ? 'Transfer E-Wallet' : 'TopUp Deposit PPOB';
        $data['page_title'] = $page_title;
        $data['arr_breadcrumbs'] = array(
            'E-Wallet' => '#',
            $page_title => 'voffice/ewallet/transfer/' . $type,
        );

        $data['form_action'] = '../act_transfer';
        $data['transfer_type'] = $type;

        template('member', 'voffice/ewallet_withdraw_view',$data);
    }


    function get_data(){
        $params = isset($_POST) ? $_POST : array();
        $params['where_detail'] = "ewallet_product_log_network_id = " . $this->session->userdata('network_id') . "";
        $query = $this->ewallet_model->get_query_data($this->session->userdata('network_id'), $params);
        $total = $this->ewallet_model->get_query_data($this->session->userdata('network_id'), $params, true);


        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        foreach ($query->result() as $row) {
        
            $entry = array('id' => $row->ewallet_product_log_id,
                'cell' => array(
                    'ewallet_product_log_datetime' => convert_datetime($row->ewallet_product_log_datetime,'id'),
                    'ewallet_product_log_type' => $row->ewallet_product_log_type,
                    'ewallet_product_log_value' => $this->function_lib->set_number_format($row->ewallet_product_log_value),
                    'ewallet_product_log_note' => $row->ewallet_product_log_note,
                ),
            );
            
            $json_data['rows'][] = $entry;
        }

        echo json_encode($json_data);
    }
    

    public function get_member_name() {
        $member_name = '';
        if ($this->input->post('code')) {
            $member_name = $this->mlm_function->get_member_name_by_network_code($this->input->post('code'));
        }

        echo json_encode($member_name);
    }

    function act_transfer(){

        if($this->input->post('submit')){
            $this->load->library('form_validation');
            $type = $this->input->post('type');
            $this->form_validation->set_error_delimiters('<li>', '</li>');

            if( $type =='member') {
                $this->form_validation->set_rules('receive_network_code', '<b>Kode Member</b>', 'required|callback_check_receiver');
            }
            
            $this->form_validation->set_rules('ewallet_transfer_value', '<b>Nominal Transfer</b>', 'required|callback_check_ewallet_saldo');
            $this->form_validation->set_rules('pin', '<b>Pin</b>', 'required|callback_check_pin');

            if ($this->form_validation->run($this) == FALSE) {
                $this->session->set_flashdata('message', '<div class="error alert alert-danger">' . validation_errors() . '</div>');
                $this->session->set_flashdata('input_receive_network_code', $this->input->post('receive_network_code'));
                $this->session->set_flashdata('input_ewallet_transfer_value', $this->input->post('ewallet_transfer_value'));
                $this->session->set_flashdata('input_pin', $this->input->post('pin'));
                if($type=='member'){
                    $this->session->set_flashdata('input_pin', $this->input->post('pin'));
                }
                
            }else{
                $transfer_value = addslashes($this->input->post('ewallet_transfer_value'));
                $rx_network_id = $this->mlm_function->get_network_id(addslashes($this->input->post('receive_network_code')));
                $rx_name = $this->mlm_function->get_member_name($rx_network_id);
                // $tx_value = str_replace('.','',rtrim($transfer_value,',')) ;
                
                $tx_value = substr(str_replace('.', '', $transfer_value), 0, strlen(str_replace('.', '', $transfer_value)) - 3);


                if($type =='member'){
                    //Insert ewallet_log
                    $tx_data = array();
                    $tx_data['ewallet_product_log_network_id'] = $this->session->userdata('network_id');
                    $tx_data['ewallet_product_log_type'] = 'out';
                    $tx_data['ewallet_product_log_value'] = $tx_value;
                    $tx_data['ewallet_product_log_note'] = "TRANSFER EWALLET KE MEMBER ".$this->input->post('receive_network_code'). " (".$rx_name.")";
                    $tx_data['ewallet_product_log_datetime'] = $this->datetime;
                    $this->function_lib->insert_data('sys_ewallet_product_log',$tx_data);

                    $rx_data = array();
                    $rx_data['ewallet_product_log_network_id'] = $rx_network_id;
                    $rx_data['ewallet_product_log_type'] = 'in';
                    $rx_data['ewallet_product_log_value'] = $tx_value;
                    $rx_data['ewallet_product_log_note'] = "Penambahan saldo ewallet , transfer dari ".$this->session->userdata('network_code'). " (".$this->session->userdata('member_name').")";
                    $rx_data['ewallet_product_log_datetime'] = $this->datetime;
                    $this->function_lib->insert_data('sys_ewallet_product_log',$rx_data);

                    //Updata saldo ewallet balance

                    $sql_tx_update = "UPDATE sys_ewallet_product SET ewallet_product_balance = ewallet_product_balance - ".$tx_value." WHERE ewallet_product_network_id = '".$this->session->userdata('network_id')."'";

                    $sql_rx_update = "UPDATE sys_ewallet_product SET ewallet_product_balance = ewallet_product_balance + ".$tx_value." WHERE ewallet_product_network_id = '".$rx_network_id."'";

                    $this->db->query($sql_rx_update);
                    $this->db->query($sql_tx_update);

                    $this->session->set_flashdata('message', '<div class="error alert alert-success">Transfer Ewallet ke Member '.$this->input->post('receive_network_code'). ' ('.$rx_name.')..Berhasil Dilakukan. </div>');

                }else {
                    $params['member_code'] = $this->session->userdata('network_code');
                    $params['nominal'] = $tx_value;
                    $transaction = $this->payment_lib->deposit_payment($params);

                    if($transaction->res_status == "S"){
                        $tx_data = array();
                        $tx_data['ewallet_product_log_network_id'] = $this->session->userdata('network_id');
                        $tx_data['ewallet_product_log_type'] = 'out';
                        $tx_data['ewallet_product_log_value'] = $tx_value;
                        $tx_data['ewallet_product_log_note'] = "TRANSFER EWALLET KE PAYMENT";
                        $tx_data['ewallet_product_log_datetime'] = $this->datetime;
                        $this->function_lib->insert_data('sys_ewallet_product_log',$tx_data);
                        $sql_tx_update = "UPDATE sys_ewallet_product SET ewallet_product_balance = ewallet_product_balance - ".$tx_value." WHERE ewallet_product_network_id = '".$this->session->userdata('network_id')."'";

                        $this->session->set_flashdata('message', '<div class="error alert alert-success">Transfer Ewallet Sebesar '.$tx_value.' ke System Payment Berhasil Dilakukan</div>');
                    }else{
                        $this->session->set_flashdata('message', '<div class="error alert alert-danger">Transfer Ewallet ke System Payment Gagal Dilakukan. Silahkan melakukan Transaksi beberapa saat lagi</div>');
                    }

                }
            }

            redirect($this->input->post('uri_string'));
        }        

    }

    function check_pin(){
        $serial_pin = $this->function_lib->get_one('view_member','member_serial_pin',array('network_id' => $this->session->userdata('network_id')));

        if($this->input->post('pin') !== $serial_pin){
            $this->form_validation->set_message('check_pin','Pin Anda Salah');
                return false;
            }else {
                return true;
            }
    }

    function check_ewallet_saldo(){
        $value = $this->input->post('ewallet_transfer_value');
        // $transfer_value = strreplace('.','',rtrim($transfer_value,',')) ;

        $transfer_value = substr(str_replace('.', '', $value), 0, strlen(str_replace('.', '', $value)) - 3);
        
        $saldo_ewallet = $this->function_lib->get_one('sys_ewallet_product','ewallet_product_balance',array('ewallet_product_network_id' => $this->session->userdata('network_id')));

        if($transfer_value > $saldo_ewallet)
            {
                $this->form_validation->set_message('check_ewallet_saldo','Saldo Anda tidak mencukupi');
                return false;
            }elseif($transfer_value < 50000){
                $this->form_validation->set_message('check_ewallet_saldo','Minimal Nominal Transfer sebesar 50.000');
                return false;
            }
            else {
                return true;
            }
    }
}
