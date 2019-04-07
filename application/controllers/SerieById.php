<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class SerieById extends REST_Controller {


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

    

    public function index_post(){

        $post_data = json_decode(file_get_contents('php://input'));
        //debug($post_data,1);

        $this->load->model('Serie_Model', 'series');

        $data = array(
            'id' => $post_data->cd_serie,
        );



        //debug($data,1);
        $response = $this->series->get($data);
        $this->response($response,REST_Controller::HTTP_OK);


    } 

    
}