<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/Auth.php';
require APPPATH . '/libraries/REST_Controller.php';

/**
 * Controller para teste
 * 
 * @category        Controller
 * @version         0.1
 * @author          Ismael Costa
 */
class Cliente extends REST_Controller {

    private $status_header;
    private $auth;

    function __construct(){

        // Construct the parent class
        parent::__construct();
        
        $this->load->library('my_encrypt'); 
        
        $this->auth = Auth::authentication();
    }

    /**
    * @return 201 OK
    */
    public function index_post(){

        if($this->auth['error'] == false){

            $id = $this->encrypt->decode($this->auth['sub']);

            $this->load->model('Cliente_model','',TRUE);

            $form_data = $this->post();

            $output['message'] = $form_data;

            return $this->set_response($output, REST_Controller::HTTP_BAD_REQUEST);

        }
            
        $output['error'] = true;
        $output['message'] = $this->auth['message'];

        return $this->set_response($output, REST_Controller::HTTP_UNAUTHORIZED);

    }
}
?>