<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Series extends REST_Controller {


    function __construct()
    {

        parent::__construct();

        $this->methods['users_get']['limit'] = 500; 
        $this->methods['users_post']['limit'] = 100; 
        $this->methods['users_delete']['limit'] = 50;
    }

    public function index_get(){
        //Dados Recebidos via POST
        $post_data = json_decode(file_get_contents('php://input'));

        $this->load->model('Serie_Model', 'serie');
        $query = $this->db->get('serie');
        //debug($query->result(),1);
        $this->response($query->result(),REST_Controller::HTTP_OK);

    }

    public function index_post(){

        $post_data = json_decode(file_get_contents('php://input'));
        
        $data = array(
            'nome'      => $post_data->nome_serie,
            'cd_genero' => $post_data->genero,
            'cd_status' => $post_data->status,
        );

        $response = $this->db->insert('serie', $data);
        $this->response($response,REST_Controller::HTTP_OK);


    } 

    
}