<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Controller
 *
 * @author rogerio
 */
class MY_Controller extends CI_Controller {
    protected static $sessionStarted = false;

    function __construct() {
        parent::__construct();
        if (!self::$sessionStarted) {
            session_start();
            self::$sessionStarted = true;
        }
        $this->load->library('Slug');
        $this->load->library('Mobile_Detect');
    }



    public function _remap($method, $params = array()) {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }

        $this->show404();
    }

    function show404() {
        $data['error_code'] = "404 Page Not Found";
        $data['message'] = "Sorry, we couldn't find the page you requested.";
        $this->load->library('layout');
        $this->output->set_status_header(404);

        if (ob_get_level() > 1) {
            ob_end_flush();
        }
        ob_start();

        //$this->load->view('/erro/erro404';
        $this->layout->view('/erro/erro404', $data);

        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
        exit;
    }

}
