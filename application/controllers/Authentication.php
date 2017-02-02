<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Autenticação para acesso a API
 * 
 * @subpackage      Rest API
 * @category        Controller
 * @author          Ismael Costa
 */
class Authentication extends REST_Controller {


    function __construct(){

        // Construct the parent class
        parent::__construct();
        
        $this->load->library('my_encrypt'); 
        
    }

    /**
    * Gera o token para acessar a API
    * @param String $email
    * @param String $secret
    * @return 200 OK
    * @return authorization_token
    */
    public function index_post(){

        $this->load->model('Cliente_model','',TRUE);

        $output = [];

        $result = $this->Cliente_model->getId($this->post('email'),$this->post('secret'));

        if($result){
            
            $params = ['authorization_header' => null, 'id' => $this->encrypt->encode($result['id'])];
            $this->load->library('Auth_JWT',$params);
    
            $output = $this->auth_jwt->generate_token();

            return $this->set_response($output, REST_Controller::HTTP_OK);            

        }

        $output['error'] = true;
        $output['message'] = 'Não foi possível autenticar este usuário.';
            
        return $this->set_response($output, REST_Controller::HTTP_BAD_REQUEST);
        

    }

}
