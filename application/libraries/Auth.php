<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Classe abstrata para tratar a autenticação
* @subpackage      Library
* @version         0.1
* @author          Ismael Costa
*/

abstract class Auth{
	
	private $ci;

	static public function authentication(){

		$output = [];
		$ci =& get_instance();

		$token = $ci->input->get_request_header('authorization', TRUE);

        if(!$token){

            $output['error'] = true;
            $output['message'] = 'Missing authorization header';

        }else{

        	$params = ['authorization_header' => $token, 'id' => null];
        
        	$ci->load->library('Auth_JWT',$params);

        	$output = $ci->auth_jwt->validate_token();
	
        }

        return $output;

	}
    
}