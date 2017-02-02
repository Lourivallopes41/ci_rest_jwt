<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH . 'vendor/autoload.php';
use \Firebase\JWT\JWT;

class Auth_JWT{

	private $authorization_header;
    private $id;
    private $token;

	function __construct($params){
		
   		$this->authorization_header = $params['authorization_header'];
        $this->id = $params['id'];
    
    }

    public function generate_token(){

        $this->token = array();
        $this->token['iss'] = 'http://localhost';
        $this->token['aud'] = 'http://localhost';
        $this->token['sub'] = $this->id;
        $output['id_token'] = JWT::encode($this->token, JWT_TOKEN);

        return $output;

    }

    public function validate_token(){

        $token = $this->authorization_header;

        try {
            $decode = JWT::decode($token,JWT_TOKEN,array('HS256'));

            $array = (array) $decode;

            return array('error' => false, 'sub' => $array['sub']);
            
        } catch (Exception $e) {
            
            return array('error' => true, 'message' => 'Invalid token');
            
        }

    }

}
?>
