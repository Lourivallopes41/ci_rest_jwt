<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Model Cliente
 * 
 * Autor: Ismael Costa
 * */

Class Cliente_model extends CI_Model{

    private $cliente_id = '';

    function getId($email, $secret){

        $retorno = false;

        $where_array = array('cliente.email' => $email, 'cliente.secret' => $secret);

        $this->db->select('id');
        $this->db->from('cliente');
        $this->db->where($where_array);
        $this->db->limit(1);

        $result = $this->db->get();

        if($result -> num_rows() > 0){

            $retorno = $result->result_array();
            return $retorno[0];
        } 

        return $retorno;

    }

}