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
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
           die();
        }

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
            'nome'      => $post_data->name,
            'cd_genero' => $post_data->genre,
            'cd_status' => $post_data->status,
            'imagem' => $post_data->imagem
        );

        $response = $this->db->insert('serie', $data);
        $id_serie = $this->db->insert_id();

        $data_comment = array(

            'cd_serie' => $id_serie ,
            'comentario' => $post_data->comments
        );

        $response = $this->db->insert('comentario', $data_comment);
        
        $this->response($response,REST_Controller::HTTP_OK);


    } 

    
}