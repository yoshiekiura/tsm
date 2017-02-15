<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions {

    public function show_404($page = '', $log_error = TRUE) {
        include APPPATH . 'config/routes.php';
        
        $CI = & get_instance();

        // By default we log this, but allow a dev to skip it
        if ($log_error) {
            log_message('error', '404 Page Not Found --> ' . $page);
        }

        if (!empty($route['404_override'])) {
            //$CI->load->view('my_view');
            //echo $CI->output->get_output();
            echo modules::run($route['404_override']);
            // redirect($route['404_override']);
            // exit;
        } else {
            $heading = "404 Page Not Found";
            $message = "The page you requested was not found.";

            echo $this->show_error($heading, $message, 'error_404', 404);
            exit;
        }
    }

}

